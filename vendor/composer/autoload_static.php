<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd50b8184920b2f1bdc4b3e7e7b406ee7
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Boris\\Fizzbuzz\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Boris\\Fizzbuzz\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd50b8184920b2f1bdc4b3e7e7b406ee7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd50b8184920b2f1bdc4b3e7e7b406ee7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd50b8184920b2f1bdc4b3e7e7b406ee7::$classMap;

        }, null, ClassLoader::class);
    }
}
