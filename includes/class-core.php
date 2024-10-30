<?php

namespace MissingWidgets;

use Elementor\Core\Kits\Documents\Kit;
use Elementor\Widgets_Manager;

/**
 * Base Class for Missing Widgets plugin.
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class Core {


	use Singleton;

	const PLUGINNAME = 'missingwidgets';
	const COOKIE = 'cookieconsent_missingwidgets';
	const HIDECOOKIECLASS = 'hide-cookieconsentpopup';
	const ICON_OPTION_NAME = 'missing_widgets_icon_sets_config';
	const ELEMENTOR_EDITOR_ID = 'elementorwpeditor';
	const EXPIRE = 31536000;

	/**
	 * Constructor for this plugin.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_plugin_features' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ), 10, 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ), 10, 0 );
		add_action( 'wp_loaded', array( $this, 'register' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ), 10, 1 );
		add_action( 'elementor/kit/register_tabs', array( $this, 'register_tabs' ), 10, 1 );
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'register_icon_libraries_control' ) );
		add_action( 'wp_ajax_setconsentcookie', array( $this, 'set_consent_cookie' ) );
		add_action( 'wp_ajax_nopriv_setconsentcookie', array( $this, 'set_consent_cookie' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( MISSING_WIDGETS_FILE ), array( $this, 'mw_links' ) );
		add_action( 'init', array( $this, 'add_buttons_to_elementor_editor' ) );
		// Installation and uninstallation hooks.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
	}


	/**
	 * Add extra buttons to the elementor text editor
	 *
	 * @return void
	 */
	public function add_buttons_to_elementor_editor() {
		/* Add the button/option in second row */
		add_filter( 'mce_buttons_2', array( $this, 'elementor_editor_background_color_button' ), 99, 2 ); // 2nd row
	}

	/**
	 * Add the highlight button to the editor.
	 *
	 * @param array  $buttons current button array.
	 * @param string $id      id of the elementor editor.
	 *
	 * @return array
	 */
	public function elementor_editor_background_color_button( array $buttons, string $id ) {
		// only for the elementor editor.
		if ( $id !== self::ELEMENTOR_EDITOR_ID ) {
			return $buttons;
		}
		// Add the button/option after 4th item after the foreground color.
		array_splice( $buttons, 3, 0, 'backcolor' );

		return $buttons;
	}

	/**
	 *  Method to display extra info of premium features.
	 *
	 * @param string $id
	 * @param string $widget_url
	 *
	 * @return string
	 * @throws \Freemius_Exception Freemius error.
	 */
	public static function freeplan_upgrade_description( string $id, string $widget_url ): string {
		$premium_feature_url = $widget_url . '#' . $id;
		$description         = sprintf( __( 'Premium users have more options here!  <a href="%s" target="_new">View the premium options for this widget.</a>',
			'missing-widgets-for-elementor' ),
			$premium_feature_url );
		$description         .= sprintf( __( '<br/><a href="%s" target="_new">Upgrade Now!</a>',
			'missing-widgets-for-elementor' ),
			\missingwidgets_fs()->get_upgrade_url() );

		return $description;
	}

	/**
	 * Add extra links to the plugin action.
	 *
	 * @param array $links Current action links.
	 *
	 * @return array
	 */
	public function mw_links( array $links ): array {
		if ( \missingwidgets_fs()->is_not_paying() ) {
			$upgrade_link = '<a style="color:#39b54a;font-weight:bold" href="' . esc_url( \missingwidgets_fs()->get_upgrade_url() ) . '">' . __( 'Upgrade to Pro for more features',
					'missing-widgets-for-elementor' ) . '</a>';
			array_push(
				$links,
				$upgrade_link
			);
		}

		return $links;
	}

	/**
	 *  Loads the standard plugins of this plugin.
	 */
	public function load_plugin_features(): void {
		\load_plugin_textdomain( self::PLUGINNAME,
			false,
			dirname( plugin_basename( MISSING_WIDGETS_FILE ) ) . '/languages/' );
		if ( self::is_elementor_loaded() ) {
			new Extras\Module_Sticky_Scroll_Effects();
		}
	}

	/**
	 * Prints admin notices.
	 */
	public function admin_notices(): void {
		if ( ! self::is_elementor_loaded() ) {
			//phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralDomain
			self::print_notice( __( 'Elementor is not active or not installed', self::PLUGINNAME ),
				'notice notice-error' );
		}
	}

	/**
	 * Show a message for a class.
	 *
	 * @param string $message    add message.
	 * @param string $class_name add class.
	 */
	public static function print_notice( string $message, string $class_name ): void {
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class_name ), esc_html( $message ) );
	}

	/**
	 * Returns the version number of the widget.
	 *
	 * @return string
	 */
	public static function get_version(): string {
		$plugin_data = get_plugin_data( MISSING_WIDGETS_FILE );

		return $plugin_data['Version'];
	}

	/**
	 * Enqueue theme styles and scripts.
	 */
	public function add_scripts(): void {
		if ( self::is_elementor_loaded() ) {
			$manifest = self::get_manifest();
			if ( $manifest->has_asset( 'plugin.js' ) ) {
				wp_enqueue_script( 'missingwidgets',
					plugin_dir_url( MISSING_WIDGETS_FILE ) . $manifest->get_asset( 'plugin.js' ),
					array( 'jquery' ),
					self::get_version(),
					false );
				wp_localize_script(
					'missingwidgets',
					'cookieconsentpopup',
					array(
						'ajax_url'          => admin_url( 'admin-ajax.php' ),
						'cookie_name'       => self::COOKIE,
						'cookie_hide_class' => self::HIDECOOKIECLASS,
					)
				);
				$this->add_cookie_consent_datalayer();
			}
			if ( $manifest->has_asset( 'plugin.css' ) ) {
				wp_enqueue_style( 'missingwidgets',
					plugin_dir_url( MISSING_WIDGETS_FILE ) . $manifest->get_asset( 'plugin.css' ),
					array(),
					self::get_version() );
			}
		}
	}

	/**
	 * Gets the manifest file.
	 *
	 * @returns Manifest Returns parent theme manifest.
	 */
	public static function get_manifest(): Manifest {
		return new Manifest( MISSING_WIDGETS_DIR . '/dist/manifest.json' );
	}


	/**
	 * Activate the plugin.
	 */
	public static function activate(): void {
		// Do nothing.
	}

	/**
	 * De-activate the plugin.
	 */
	public static function deactivate(): void {
		// Do nothing.
	}

	/**
	 * Register plugin.
	 */
	public function register(): void {
	}

	/**
	 * Register new Elementor widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager
	 *
	 * @return void
	 */
	public function register_widgets( Widgets_Manager $widgets_manager ): void {
		// Elementor is loaded.
		if ( self::is_elementor_loaded() ) {
			$widgets_manager->register( new Widgets\Maximum_Content_Length() );
			$widgets_manager->register( new Widgets\Footer_Menu() );
			$widgets_manager->register( new Widgets\Label_List() );
			$widgets_manager->register( new Widgets\Dynamic_Field_List() );
			$widgets_manager->register( new Widgets\To_Top() );
			$widgets_manager->register( new Widgets\Cookie_Consent_Popup() );
			$widgets_manager->register( new Widgets\Form_Assembly() );
			$widgets_manager->register( new Widgets\Menu_Anchor_With_Offset() );
			$widgets_manager->register( new Widgets\Numbered_List() );
			// Formidable is loaded.
			if ( class_exists( 'FrmHooksController' ) ) {
				$widgets_manager->register( new Widgets\Formidable_Form() );
			}
			if ( self::is_elementor_pro_loaded() ) {
				$widgets_manager->register( new Widgets\SideBoxInfo() );
			}
		}
	}

	/**
	 * Register extra settings to the elementor settings.
	 *
	 * @param Kit $kit
	 *
	 * @return void
	 */
	public function register_tabs( Kit $kit ) {
		$kit->register_tab( 'themestyleextrabuttons', new Extras\Theme_Style_Extra_Button( $kit ) );
	}

	/**
	 * Merges the missing widget icon array.
	 *
	 * @param array $additional_sets
	 *
	 * @return array
	 */
	public function register_icon_libraries_control( array $additional_sets ) {
		return array_merge( $additional_sets, self::get_custom_icons_config() );
	}

	/**
	 * Set the missing widget icon array settings.
	 *
	 * @return array
	 */
	public static function get_custom_icons_config() {
		$set_config                    = array(
			'name'             => 'Missing-Widgets-Icons',
			'label'            => 'Missing Widgets Icons',
			'url'              => plugin_dir_url( MISSING_WIDGETS_FILE ) . '/assets/fonts/style.css',
			'prefix'           => 'mwi-',
			'displayPrefix'    => '',
			'labelIcon'        => 'eicon eicon-folder',
			'ver'              => '1.0.0',
			'custom_icon_type' => 'Icomoon',
			'enqueue'          => '',
			'count'            => '1',
			'icons'            => array( 'Transparent-Icon' ),
		);
		$config[ $set_config['name'] ] = $set_config;

		return $config;
	}

	/**
	 * Whether or not the elementor plugin is active and has been loaded.
	 *
	 * @return bool
	 */
	public static function is_elementor_loaded(): bool {
		return class_exists( '\Elementor\Plugin' );
	}

	/**
	 * Whether or not the elementor pro plugin is active and has been loaded.
	 *
	 * @return bool
	 */
	public static function is_elementor_pro_loaded(): bool {
		return class_exists( '\ElementorPro\Plugin' );
	}

	/**
	 * Set the consent cookie.
	 */
	public function set_consent_cookie(): void {
		try {
			if ( isset( $_POST['cookie_nonce_field'] ) && \wp_verify_nonce( \sanitize_key( $_POST['cookie_nonce_field'] ),
					'cookie_settings' ) ) {
				$functional_cookie            = isset( $_POST['functionalCookies'] ) ? \sanitize_text_field( wp_unslash( $_POST['functionalCookies'] ) ) : '';
				$analytical_cookie            = isset( $_POST['analyticalCookies'] ) ? \sanitize_text_field( wp_unslash( $_POST['analyticalCookies'] ) ) : '';
				$advertisement_cookie         = isset( $_POST['advertisementCookies'] ) ? \sanitize_text_field( wp_unslash( $_POST['advertisementCookies'] ) ) : '';
				$data                         = array();
				$data['functionalCookies']    = $functional_cookie === '1' ? '1' : '0';
				$data['analyticalCookies']    = $analytical_cookie === '1' ? '1' : '0';
				$data['advertisementCookies'] = $advertisement_cookie === '1' ? '1' : '0';
				setcookie( self::COOKIE,
					(string) wp_json_encode( $data ),
					time() + self::EXPIRE,
					'/',
					'',
					true,
					false );
				echo wp_json_encode(
					array(
						'success' => true,
						'cookie'  => self::COOKIE,
						'expire'  => self::EXPIRE,
						'data'    => $data,
					)
				);
			}
			wp_die();
		} catch ( \Exception $error ) {
			echo wp_json_encode(
				array(
					'success' => false,
					'message' => $error->getMessage(),
				)
			);
			wp_die();
		}
	}


	/**
	 * Check if cookie is set.
	 *
	 * @return bool
	 */
	public static function has_cookie(): bool {
		if ( isset( $_COOKIE[ self::COOKIE ] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get the value of a setting inside the cookie.
	 *
	 * @param string $setting_name . Name of the setting.
	 *
	 * @return bool
	 */
	public static function get_cookie_value( string $setting_name ): bool {
		if ( isset( $_COOKIE[ self::COOKIE ] ) ) {
			// Cookie input is sanitized by filter array.
			//phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$cookie = filter_var_array( (array) json_decode( wp_unslash( $_COOKIE[ self::COOKIE ] ), true ),
				self::filter_cookie_arguments() );
			if ( $cookie ) {
				return $cookie[ $setting_name ] === 1;
			}
		}

		return false;
	}

	/**
	 * Filter for cookies settings.
	 *
	 * @return array
	 */
	public static function filter_cookie_arguments(): array {
		return array(
			'functionalCookies'    => FILTER_VALIDATE_INT,
			'analyticalCookies'    => FILTER_VALIDATE_INT,
			'advertisementCookies' => FILTER_VALIDATE_INT,
		);
	}

	/**
	 *  Add cookie consent script to the page
	 */
	public function add_cookie_consent_datalayer(): void {
		// Check if cookie is set.
		if ( isset( $_COOKIE[ self::COOKIE ] ) ) {
			$cookie_script = '<!-- Missing Widget code for GTM -->';
			$cookie_script .= '<script type="text/javascript">//<![CDATA[             
            window.dataLayer = window.dataLayer ? window.dataLayer : [];
            let layer = {};';
			// Get settings from cookie.
			// Cookie input is sanitized by filter array.
			//phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$cookie = filter_var_array( (array) json_decode( wp_unslash( $_COOKIE[ self::COOKIE ] ), true ),
				self::filter_cookie_arguments() );
			if ( $cookie ) {
				foreach ( $cookie as $name => $setting ) {
					// Add values to datalayer.
					$cookie_value  = $setting === 1 ? '1' : '0';
					$cookie_script .= 'layer["' . (string) $name . '"] = ' . $cookie_value . ';';
				}
			}
			$cookie_script .= 'window.dataLayer.push(layer);';
			$cookie_script .= '//]]></script>';
			$cookie_script .= '<!-- Missing Widget code for GTM -->';
			wp_add_inline_script( 'missingwidgets', $cookie_script, 'before' );
		}
	}
}
