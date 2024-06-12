<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1abc2bd51dd7ce74b121f26f8190d544
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1abc2bd51dd7ce74b121f26f8190d544::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1abc2bd51dd7ce74b121f26f8190d544::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1abc2bd51dd7ce74b121f26f8190d544::$classMap;

        }, null, ClassLoader::class);
    }
}