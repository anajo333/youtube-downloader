<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc6ee3b81189023b1cd9e77e6eda12046
{
    public static $prefixLengthsPsr4 = array (
        'Y' => 
        array (
            'YouTube\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'YouTube\\' => 
        array (
            0 => __DIR__ . '/..' . '/athlon1600/youtube-downloader/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc6ee3b81189023b1cd9e77e6eda12046::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc6ee3b81189023b1cd9e77e6eda12046::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
