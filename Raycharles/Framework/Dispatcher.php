<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/27 0027
 * Time: 14:22
 */
namespace Raychars\Framework;

class Dispatcher {

    /**
     * URL映射到控制器
     * @access public
     * @return void
     */
    static public function dispatch() {
//        p($_SERVER['QUERY_STRING']);

    }

    /**
     * 获得控制器的命名空间路径 便于插件机制访问
     */
    static private function getSpace($var,$urlCase) {
        $space  =   !empty($_GET[$var])?strip_tags($_GET[$var]):'';
        unset($_GET[$var]);
        return $space;
    }

    /**
     * 获得实际的控制器名称
     */
    static private function getController($var,$urlCase) {
        $controller = (!empty($_GET[$var])? $_GET[$var]:C('DEFAULT_CONTROLLER'));
        unset($_GET[$var]);
        if($maps = C('URL_CONTROLLER_MAP')) {
            if(isset($maps[strtolower($controller)])) {
                // 记录当前别名
                define('CONTROLLER_ALIAS',strtolower($controller));
                // 获取实际的控制器名
                return   ucfirst($maps[CONTROLLER_ALIAS]);
            }elseif(array_search(strtolower($controller),$maps)){
                // 禁止访问原始控制器
                return   '';
            }
        }
        if($urlCase) {
            // URL地址不区分大小写
            // 智能识别方式 user_type 识别到 UserTypeController 控制器
            $controller = parse_name($controller,1);
        }
        return strip_tags(ucfirst($controller));
    }

    /**
     * 获得实际的操作名称
     */
    static private function getAction($var,$urlCase) {
        $action   = !empty($_POST[$var]) ?
            $_POST[$var] :
            (!empty($_GET[$var])?$_GET[$var]:C('DEFAULT_ACTION'));
        unset($_POST[$var],$_GET[$var]);
        if($maps = C('URL_ACTION_MAP')) {
            if(isset($maps[strtolower(CONTROLLER_NAME)])) {
                $maps =   $maps[strtolower(CONTROLLER_NAME)];
                if(isset($maps[strtolower($action)])) {
                    // 记录当前别名
                    define('ACTION_ALIAS',strtolower($action));
                    // 获取实际的操作名
                    if(is_array($maps[ACTION_ALIAS])){
                        parse_str($maps[ACTION_ALIAS][1],$vars);
                        $_GET   =   array_merge($_GET,$vars);
                        return $maps[ACTION_ALIAS][0];
                    }else{
                        return $maps[ACTION_ALIAS];
                    }

                }elseif(array_search(strtolower($action),$maps)){
                    // 禁止访问原始操作
                    return   '';
                }
            }
        }
        return strip_tags( $urlCase? strtolower($action) : $action );
    }

    /**
     * 获得实际的模块名称
     */
    static private function getModule($var) {
        $module   = (!empty($_GET[$var])?$_GET[$var]:C('DEFAULT_MODULE'));
        unset($_GET[$var]);
        if($maps = C('URL_MODULE_MAP')) {
            if(isset($maps[strtolower($module)])) {
                // 记录当前别名
                define('MODULE_ALIAS',strtolower($module));
                // 获取实际的模块名
                return   ucfirst($maps[MODULE_ALIAS]);
            }elseif(array_search(strtolower($module),$maps)){
                // 禁止访问原始模块
                return   '';
            }
        }
        return strip_tags(ucfirst($module));
    }

}