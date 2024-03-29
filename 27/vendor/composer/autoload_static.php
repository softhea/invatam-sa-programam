<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4d2f3384b7988831b6f50ab8877f1507
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4d2f3384b7988831b6f50ab8877f1507::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4d2f3384b7988831b6f50ab8877f1507::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4d2f3384b7988831b6f50ab8877f1507::$classMap;

        }, null, ClassLoader::class);
    }
}
