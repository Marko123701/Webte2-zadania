<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit04483c2099d018930e160a33f1808c28
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Workerman\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Workerman\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/workerman',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit04483c2099d018930e160a33f1808c28::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit04483c2099d018930e160a33f1808c28::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit04483c2099d018930e160a33f1808c28::$classMap;

        }, null, ClassLoader::class);
    }
}
