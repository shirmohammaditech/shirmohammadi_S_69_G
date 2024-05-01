<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6a3e96dfcd47a924711cb12d368846e7
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '781f373bf21663a385000f4e613d2e18' => __DIR__ . '/../..' . '/src/Helpers/Helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Ctype\\' => 23,
        ),
        'R' => 
        array (
            'Requtize\\QueryBuilder\\' => 22,
        ),
        'P' => 
        array (
            'PhpOption\\' => 10,
        ),
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Requtize\\QueryBuilder\\' => 
        array (
            0 => __DIR__ . '/..' . '/requtize/query-builder/src/QueryBuilder',
        ),
        'PhpOption\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoption/phpoption/src/PhpOption',
        ),
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
        'App\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit6a3e96dfcd47a924711cb12d368846e7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6a3e96dfcd47a924711cb12d368846e7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6a3e96dfcd47a924711cb12d368846e7::$classMap;

        }, null, ClassLoader::class);
    }
}
