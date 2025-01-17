<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite802d370ad51b3b1c1f32c2720f0b126
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MissingWidgets\\Dependencies\\' => 28,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MissingWidgets\\Dependencies\\' => 
        array (
            0 => __DIR__ . '/../..' . '/dependencies',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'MissingWidgets\\Core' => __DIR__ . '/../..' . '/includes/class-core.php',
        'MissingWidgets\\Extras\\Module_Sticky_Scroll_Effects' => __DIR__ . '/../..' . '/includes/extras/class-modulestickyscrolleffects.php',
        'MissingWidgets\\Extras\\Theme_Extra_Settings' => __DIR__ . '/../..' . '/includes/extras/class-themeextrasettings.php',
        'MissingWidgets\\Extras\\Theme_Style_Extra_Button' => __DIR__ . '/../..' . '/includes/extras/class-themestyleextrabutton.php',
        'MissingWidgets\\Manifest' => __DIR__ . '/../..' . '/includes/class-manifest.php',
        'MissingWidgets\\Singleton' => __DIR__ . '/../..' . '/includes/class-singleton.php',
        'MissingWidgets\\Widgets\\Cookie_Consent_Popup' => __DIR__ . '/../..' . '/includes/widgets/class-cookieconsentpopup.php',
        'MissingWidgets\\Widgets\\Dynamic_Field_List' => __DIR__ . '/../..' . '/includes/widgets/class-dynamicfieldlist.php',
        'MissingWidgets\\Widgets\\Footer_Menu' => __DIR__ . '/../..' . '/includes/widgets/class-footermenu.php',
        'MissingWidgets\\Widgets\\Form_Assembly' => __DIR__ . '/../..' . '/includes/widgets/class-formassembly.php',
        'MissingWidgets\\Widgets\\Formidable_Form' => __DIR__ . '/../..' . '/includes/widgets/class-formidableform.php',
        'MissingWidgets\\Widgets\\Label_List' => __DIR__ . '/../..' . '/includes/widgets/class-labellist.php',
        'MissingWidgets\\Widgets\\Maximum_Content_Length' => __DIR__ . '/../..' . '/includes/widgets/class-maximumcontentlength.php',
        'MissingWidgets\\Widgets\\Menu_Anchor_With_Offset' => __DIR__ . '/../..' . '/includes/widgets/class-menuanchorwithoffset.php',
        'MissingWidgets\\Widgets\\Numbered_List' => __DIR__ . '/../..' . '/includes/widgets/class-numberedlist.php',
        'MissingWidgets\\Widgets\\SideBoxInfo' => __DIR__ . '/../..' . '/includes/widgets/class-sideboxinfo.php',
        'MissingWidgets\\Widgets\\To_Top' => __DIR__ . '/../..' . '/includes/widgets/class-totop.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite802d370ad51b3b1c1f32c2720f0b126::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite802d370ad51b3b1c1f32c2720f0b126::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite802d370ad51b3b1c1f32c2720f0b126::$classMap;

        }, null, ClassLoader::class);
    }
}
