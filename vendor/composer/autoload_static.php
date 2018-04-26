<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit62223002059beb277d3892ecf9a0075f
{
    public static $files = array (
        'aeb5adf536b83c67130837db1b77ec23' => __DIR__ . '/../..' . '/Raycharles/Helper/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Raychars\\Upload\\' => 16,
            'Raychars\\Framework\\' => 19,
            'Raychars\\Console\\' => 17,
            'Raychars\\Cli\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Raychars\\Upload\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Raycharles/Upload/src',
        ),
        'Raychars\\Framework\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Raycharles/Framework',
        ),
        'Raychars\\Console\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Raycharles/Console/src',
        ),
        'Raychars\\Cli\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Raycharles/Cli',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit62223002059beb277d3892ecf9a0075f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit62223002059beb277d3892ecf9a0075f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}