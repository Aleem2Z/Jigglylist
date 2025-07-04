<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb91e73e4f3e060ddce7b1a1842336253
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'Http\\' => 5,
        ),
        'C' => 
        array (
            'Core\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Http\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Http',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb91e73e4f3e060ddce7b1a1842336253::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb91e73e4f3e060ddce7b1a1842336253::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb91e73e4f3e060ddce7b1a1842336253::$classMap;

        }, null, ClassLoader::class);
    }
}
