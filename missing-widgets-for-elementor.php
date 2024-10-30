<?php

/**
 * Plugin Name: Missing Widgets for Elementor (Premium)
 * Plugin URI:  https://missingwidgets.com/
 * Description: Usefull widgets for Elementor that other widgetbuilders may have missed.
 * Author:      Sivard Donkers
 * Author URI:  https://missingwidgets.com/
 * Version:     1.4.7
 * Update URI: https://api.freemius.com
 * Text Domain: missingwidgets
 * Domain Path: /languages
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly.
}
define( 'MISSING_WIDGETS_DIR', __DIR__ );
define( 'MISSING_WIDGETS_FILE', __FILE__ );
if ( function_exists( 'missingwidgets_fs' ) ) {
    \missingwidgets_fs()->set_basename( true, __FILE__ );
} else {
    // DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE `function_exists` CALL ABOVE TO PROPERLY WORK.
    if ( !function_exists( 'missingwidgets_fs' ) ) {
        /**
         * Create a helper function for easy SDK access.
         *
         * @return Freemius
         * @throws Freemius_Exception Throws Freemius error.
         */
        function missingwidgets_fs() : \Freemius {
            global $missingwidgets_fs;
            if ( !isset( $missingwidgets_fs ) ) {
                // Include Freemius SDK.
                require_once __DIR__ . '/assets/freemius/start.php';
                $missingwidgets_fs = fs_dynamic_init( array(
                    'id'             => '8437',
                    'slug'           => 'missing-widgets-for-elementor',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_1e72238218f3106e63aed19ce0de9',
                    'is_premium'     => true,
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => array(
                        'first-path' => 'plugins.php',
                    ),
                    'is_live'        => true,
                ) );
            }
            return $missingwidgets_fs;
        }

        // Init Freemius.
        missingwidgets_fs();
        // Signal that SDK was initiated.
        do_action( 'missingwidgets_fs_loaded' );
    }
    if ( !defined( 'WP_FS__ENABLE_GARBAGE_COLLECTOR' ) ) {
        define( 'WP_FS__ENABLE_GARBAGE_COLLECTOR', true );
    }
    // ... Your plugin's main file logic ...
    require_once __DIR__ . '/includes/class-singleton.php';
    require_once __DIR__ . '/includes/class-core.php';
    require_once __DIR__ . '/includes/class-manifest.php';
    require __DIR__ . '/vendor/autoload.php';
    \MissingWidgets\Core::instance();
}