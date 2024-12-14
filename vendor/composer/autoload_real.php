<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit44bac5a3825e3066e85d538f3a9585df
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

        spl_autoload_register(array('ComposerAutoloaderInit44bac5a3825e3066e85d538f3a9585df', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit44bac5a3825e3066e85d538f3a9585df', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit44bac5a3825e3066e85d538f3a9585df::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}