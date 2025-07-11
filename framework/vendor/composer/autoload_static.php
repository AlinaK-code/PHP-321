<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5e4b84bb44ea628ba08b30d03b974724
{
    public static $prefixLengthsPsr4 = array (
        'm' => 
        array (
            'main\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'main\\' => 
        array (
            0 => __DIR__ . '/../..' . '/main',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'main\\Controllers\\ArticleController' => __DIR__ . '/../..' . '/main/Controllers/ArticleController.php',
        'main\\Controllers\\HomeController' => __DIR__ . '/../..' . '/main/Controllers/HomeController.php',
        'main\\Controllers\\MainController' => __DIR__ . '/../..' . '/main/Controllers/MainController.php',
        'main\\Core\\Controller' => __DIR__ . '/../..' . '/main/Core/Controller.php',
        'main\\Models\\ActiveRecordEntity' => __DIR__ . '/../..' . '/main/Models/ActiveRecordEntity.php',
        'main\\Models\\Article' => __DIR__ . '/../..' . '/main/Models/Article.php',
        'main\\Models\\Articles\\Article' => __DIR__ . '/../..' . '/main/Models/Articles/Article.php',
        'main\\Models\\User' => __DIR__ . '/../..' . '/main/Models/User.php',
        'main\\Models\\Users\\User' => __DIR__ . '/../..' . '/main/Models/Users/User.php',
        'main\\Router\\IncludePages' => __DIR__ . '/../..' . '/main/Router/IncludePages.php',
        'main\\Router\\Router' => __DIR__ . '/../..' . '/main/Router/Router.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5e4b84bb44ea628ba08b30d03b974724::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5e4b84bb44ea628ba08b30d03b974724::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5e4b84bb44ea628ba08b30d03b974724::$classMap;

        }, null, ClassLoader::class);
    }
}
