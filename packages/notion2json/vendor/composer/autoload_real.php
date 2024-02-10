<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit318d23af8f1c5897fdeab6f02fc58f87
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit318d23af8f1c5897fdeab6f02fc58f87', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit318d23af8f1c5897fdeab6f02fc58f87', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit318d23af8f1c5897fdeab6f02fc58f87::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
