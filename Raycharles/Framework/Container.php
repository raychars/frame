<?php

namespace Raychars\Framework;

use Barryvdh\Reflection\DocBlock\Tag\ExampleTagTest;


class Container
{
    public $app;
    public $instance;
    public $abstract;
    public $instances;
    public $alias;//类别名
    public $dependences;//依赖的类

    public function __construct()
    {
        if (empty($this->instance)) {
            $this->instance = $this;
        }
        $this->app = $this->instance;
    }

    //绑定到容器中
    public function bind($abstract, $instance = '')
    {
        if (empty($instance)) {
            $this->abstract[$abstract] = $abstract;
        } else {
            $this->abstract[$abstract] = $instance;
        }
    }

    //从容器中获取实例
    public function make($abstract)
    {
        if (isset($this->abstract[$abstract])) {
            return $this->abstract[$abstract];
        }
        $instance = $this->parseAbstract($abstract);
        $this->bind($abstract, $instance);
        return $instance;
    }

    //解析类为实例
    private function parseAbstract($abstract)
    {
        $reflect = new \ReflectionClass($abstract);
        $constructor = $reflect->getConstructor();
        if ($constructor != null) {

            foreach ($constructor->getParameters() as $param) {
                //获取构造方法的参数
                if ($param->isDefaultValueAvailable()) {//如果是默认 直接取默认值
                    $this->dependences[$abstract]['__construct'][] = $param->getDefaultValue();
                } else {
                    //将构造函数中的参数实例化
                    $temp = $param->getClass();
                    if ($temp === null) {
                        //说明只是一个变量
                        $this->dependences[$abstract]['__construct'][] = null;
                    } else {
                        $class = $temp->getName();
                        $this->dependences[$abstract]['__construct'][] = $class;
                        $this->make($class);
                    }
                }
            }
        }
    }

    public function getInstance($abstract)
    {
        foreach ($this->abstract as $item) {
            if (isset($this->instances[$abstract])) {
                return $this->instances[$abstract];
            } else {
                $reflect = new \ReflectionClass($abstract);
                $constructor = $reflect->getConstructor();
                if ($constructor != null) {
                    foreach ($constructor->getParameters() as $param) {
                        //获取构造方法的参数
                        if ($param->isDefaultValueAvailable()) {//如果是默认 直接取默认值
                            $this->dependences[$abstract]['__construct'][] = $param->getDefaultValue();
                        } else {
                            //将构造函数中的参数实例化
                            $temp = $param->getClass();
                            if ($temp === null) {
                                //说明只是一个变量
                                $this->dependences[$abstract]['__construct'][] = null;
                            } else {
                                $class = $temp->getName();
                                $this->dependences[$abstract]['__construct'][] = $this->make($class);
                            }
                        }
                    }
                    return $reflect->newInstanceArgs($this->dependences[$abstract]['__construct']);
                } else {
                    return $reflect->newInstance();
                }
            }
        }
    }

    //解析实例中方法的类型
    public function parseMethod($abstract, $method)
    {
        $instance = $this->parseAbstract($abstract);
        $reflect = new \ReflectionClass($abstract);
        if ($reflect->hasMethod($method)) {
            $methodReflect = $reflect->getmethod($method);
            $dependencies = array();
            if (!empty($methodReflect->getParameters())) {
                foreach ($methodReflect->getParameters() as $key => $item) {
                    if ($item->isDefaultValueAvailable()) {//如果是默认 直接取默认值
                        $dependencies[] = $item->getDefaultValue();
                    } else {
                        //将构造函数中的参数实例化
                        $temp = $item->getClass();
                        if ($temp === null) {
                            //说明只是一个变量
                            $dependencies[] = null;
                        } else {
                            $class = $temp->getName();
                            $dependencies[] = $class;
                            $this->make($class);
                        }
                    }
                }
            }
            $this->dependences[$abstract][$method] = $dependencies;
        } else {
            throw new \Exception('方法不存在');
        }
    }

    public function alias()
    {
        $alias_path = ROOT_PATH . '/config/alias.php';
        if (file_exists($alias_path)) {
            $list = require_once $alias_path;
            return isset($list['alias']) ? $list['alias'] : '';
        }
        return array();
    }

    public function parseAlias()
    {
        if (is_array($this->alias)) {
            foreach ($this->alias as $key => $abstact) {
                class_alias($abstact, $key);
                $this->make($abstact);
            }
        }
    }


}
