<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit318d23af8f1c5897fdeab6f02fc58f87
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'Notion2json\\lib\\' => 16,
            'Notion2json\\errors\\' => 19,
            'Notion2json\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Notion2json\\lib\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/lib',
        ),
        'Notion2json\\errors\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/errors',
        ),
        'Notion2json\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit318d23af8f1c5897fdeab6f02fc58f87::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit318d23af8f1c5897fdeab6f02fc58f87::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit318d23af8f1c5897fdeab6f02fc58f87::$classMap;

        }, null, ClassLoader::class);
    }
}
