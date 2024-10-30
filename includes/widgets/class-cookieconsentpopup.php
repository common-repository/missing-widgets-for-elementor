<?php declare( strict_types = 1 );

namespace MissingWidgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use MissingWidgets\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Cookie Consent Widget
 *
 * Popup to set your control the cookie usersetting
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class Cookie_Consent_Popup extends \Elementor\Widget_Base {


	public function get_name(): string {
		return 'missingwidget-cookieconsentpopup';
	}

	public function get_title(): string {
		return _x( 'Cookie Consent Popup', 'Cookie Consent Widget', 'missingwidgets' );
	}

	public function get_icon(): string {
		return 'eicon eicon-click';
	}

	public function get_categories(): array {
		return array( 'general' );
	}

	public function get_keywords(): array {
		return array( 'cookie', 'consent', 'google', 'tagmanager', 'popup', 'missing', 'widgets', 'missingwidgets' );
	}

	public function get_script_depends(): array {
		return array( 'jQuery' );
	}

	public function get_custom_help_url(): string {
		return 'https://missingwidgets.com/missing-widgets-features/elementor-cookie-consent-popup-widget/';
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'cookie_consent_popup_type',
			array(
				'label' => __( 'Type', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$cookie_banner_type_args = array(
			'label'       => __( 'Popup up type', 'missingwidgets' ),
			'label_block' => true,
			'type'        => Controls_Manager::SELECT,
			'default'     => 'banner-below',
		);

		$cookie_banner_type_extra_args = array();
		if ( \missingwidgets_fs()->can_use_premium_code__premium_only() ) {
			$cookie_banner_type_extra_args = array(
				'options' => array(
					'banner-below'    => __( 'Banner below', 'missingwidgets' ),
					'banner-centered' => __( 'Banner centered', 'missingwidgets' ),
					'banner-top'      => __( 'Banner top', 'missingwidgets' ),
				),
			);
		}
		if ( \missingwidgets_fs()->is_not_paying() ) {
			$cookie_banner_type_extra_args = array(
				'description' => Core::freeplan_upgrade_description( 'cookie_banner_type', self::get_custom_help_url() ),
				'options'     => array(
					'banner-below' => __( 'Banner below', 'missingwidgets' ),
				),
			);
		}

		$this->add_control(
			'cookie_bannner_type',
			array_merge( $cookie_banner_type_args, $cookie_banner_type_extra_args )
		);

		$cookie_checkbox_layout_args       = array(
			'label'       => __( 'Layout options', 'missingwidgets' ),
			'label_block' => true,
			'type'        => Controls_Manager::SELECT,
			'default'     => 'horizontal',
		);
		$cookie_checkbox_layout_extra_args = array();
		if ( \missingwidgets_fs()->can_use_premium_code__premium_only() ) {
			$cookie_checkbox_layout_extra_args = array(
				'options' => array(
					'vertical'   => __( 'Vertical', 'missingwidgets' ),
					'horizontal' => __( 'Horizontal', 'missingwidgets' ),
				),
			);
		}
		if ( \missingwidgets_fs()->is_not_paying() ) {
			$cookie_checkbox_layout_extra_args = array(
				'description' => Core::freeplan_upgrade_description( 'cookie_checkbox_layout', self::get_custom_help_url() ),
				'options'     => array(
					'horizontal' => __( 'Horizontal', 'missingwidgets' ),
				),
			);
		}
		$this->add_control(
			'cookie_checkbox_layout',
			array_merge( $cookie_checkbox_layout_args, $cookie_checkbox_layout_extra_args )
		);

		if ( \missingwidgets_fs()->can_use_premium_code__premium_only() ) {
			$use_backgroundlayer_args       = array(
				'label'   => __( 'Use backgroundlayer', 'missingwidgets' ),
				'default' => 'no',
			);
			$use_backgroundlayer_extra_args = array(
				'type' => Controls_Manager::SWITCHER,
			);
			$this->add_control(
				'use_backgroundlayer',
				array_merge( $use_backgroundlayer_args, $use_backgroundlayer_extra_args )
			);
		}

		$this->end_controls_section();

		$this->start_controls_section(
			'cookie_consent_popup_content',
			array(
				'label' => __( 'Content', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'cookietext',
			array(
				'label'       => __( 'Text field', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::WYSIWYG,
				'placeholder' => __( 'Enter text for inside the popup', 'missingwidgets' ),
				'default'     => '',
			)
		);
		$this->add_control(
			'accepttext',
			array(
				'label'       => __( 'Text accept button', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Save settings', 'missingwidgets' ),
			)
		);
		$this->add_control(
			'functional_cookie_text',
			array(
				'label'       => __( 'Text functional cookie', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter text for functional cookies', 'missingwidgets' ),
				'default'     => __( 'Accept functional cookies', 'missingwidgets' ),
			)
		);
		$this->add_control(
			'analytical_cookie_text',
			array(
				'label'       => __( 'Text analytical cookie', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter text for analytical cookies', 'missingwidgets' ),
				'default'     => __( 'Accept analytical cookies', 'missingwidgets' ),
			)
		);
		$this->add_control(
			'advertisement_cookie_text',
			array(
				'label'       => __( 'Text advertisment/third-party cookie', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter text for advertisement cookies', 'missingwidgets' ),
				'default'     => __( 'Accept advertisment/third party cookies', 'missingwidgets' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'cookie_consent_popup_checkboxes',
			array(
				'label' => __( 'Default cookie settings', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'functionalCookies',
			array(
				'label'       => __( 'Default functional cookie settings ', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'options'     => array(
					'1'  => __( 'Always allowed', 'missingwidgets' ),
					'0'  => __( 'Allowed', 'missingwidgets' ),
					'-1' => __( 'Not allowed', 'missingwidgets' ),
				),
			)
		);
		$this->add_control(
			'functionalCookies_show',
			array(
				'label'       => __( 'Show checkbox option for functional cookies', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',

			)
		);
		$this->add_control(
			'form_divider',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);
		$this->add_control(
			'analyticalCookies',
			array(
				'label'       => __( 'Default analytical cookie settings ', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => array(
					'1'  => __( 'Always allowed', 'missingwidgets' ),
					'0'  => __( 'Allowed', 'missingwidgets' ),
					'-1' => __( 'Not allowed', 'missingwidgets' ),
				),
			)
		);
		$this->add_control(
			'analyticalCookies_show',
			array(
				'label'       => __( 'Show checkbox option for analytical cookies', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',

			)
		);
		$this->add_control(
			'form_divider',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);
		$this->add_control(
			'advertisementCookies',
			array(
				'label'       => __( 'Default advertisement/third-party cookie settings ', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default'     => '-1',
				'options'     => array(
					'1'  => __( 'Always allowed', 'missingwidgets' ),
					'0'  => __( 'Allowed', 'missingwidgets' ),
					'-1' => __( 'Not allowed', 'missingwidgets' ),
				),
			)
		);

		$this->add_control(
			'advertisementCookies_show',
			array(
				'label'       => __( 'Show checkbox option for advertisement/third-party cookies', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',

			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'cookie_consent_hide_pages',
			array(
				'label' => __( 'Hide popup on pages', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'hide_popup_pages',
			array(
				'label'       => __( 'Hide popup on pages', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( 'Enter pageid\'s here (separated by ,).', 'missingwidgets' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_popup',
			array(
				'label' => __( 'Popup', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'popup_background_color',
			array(
				'label'     => __( 'Color background popup', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_ACCENT,
				),
				'selectors' => array(
					'{{WRAPPER}} #cookieconsentpopup' => 'background-color: {{VALUE}};',
				),
			)
		);

		if ( \missingwidgets_fs()->can_use_premium_code__premium_only() ) {
			$this->add_control(
				'layer_background_color',
				array(
					'label'     => __( 'Color background layer', 'missingwidgets' ),
					'type'      => Controls_Manager::COLOR,
					'global'    => array(
						'default' => Global_Colors::COLOR_ACCENT,
					),
					'condition' => array(
						'use_backgroundlayer' => 'yes',
					),
					'selectors' => array(
						'{{WRAPPER}} .cookieconsentpopup-layer' => 'background-color: {{VALUE}};',
					),
				)
			);
		}

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'popup_border',
				'label'    => __( 'Border', 'elementor' ),
				'selector' => '{{WRAPPER}} #cookieconsentpopup',
			)
		);

		$this->add_control(
			'popup_border_radius',
			array(
				'label'      => __( 'Border Radius', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} #cookieconsentpopup' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'popup_bordershadow',
				'label'    => __( 'Border shadow', 'elementor' ),
				'selector' => '{{WRAPPER}} #cookieconsentpopup',
			)
		);

		$this->add_responsive_control(
			'popup_padding',
			array(
				'label'      => __( 'Padding', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} #cookieconsentpopup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);
		$this->add_responsive_control(
			'popup_margin',
			array(
				'label'      => __( 'Margin', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} #cookieconsentpopup' => 'width:calc(100% - {{RIGHT}}{{UNIT}} - {{LEFT}}{{UNIT}});margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			array(
				'label' => __( 'Text', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'       => __( 'Text typography', 'missingwidgets' ),
				'label_block' => true,
				'name'        => 'typography',
				'global'      => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
				'selector'    => '{{WRAPPER}} .cookieconsent_text',
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .cookieconsent_text' => 'fill: {{VALUE}}; color: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'align_text',
			array(
				'label'     => __( 'Alignment', 'elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => __( 'Left', 'elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => __( 'Justified', 'elementor' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .cookieconsent_text' => 'text-align: {{VALUE}};',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_checkbox',
			array(
				'label' => __( 'Checkboxes', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'    => __( 'Checkbox typography', 'missingwidgets' ),
				'name'     => 'checkbox_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
				'selector' => '{{WRAPPER}} .cookieconsent-accept',
			)
		);

		$this->add_control(
			'checkbox_text_color',
			array(
				'label'     => __( 'Checkbox text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .cookieconsent-accept' => 'fill: {{VALUE}}; color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'checkbox_checked_color',
			array(
				'label'     => __( 'Backgroundcolor allowed ', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#00CC00',
				'selectors' => array(
					'{{WRAPPER}} .cookieconsent-accept input:checked + .slider' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'checkbox_unchecked_color',
			array(
				'label'     => __( 'Backgroundcolor not allowed ', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FF0000',
				'selectors' => array(
					'{{WRAPPER}} .cookieconsent-accept .slider' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'checkbox_disabled_color',
			array(
				'label'     => __( 'Backgroundcolor disabled ', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#CCCCCC',
				'selectors' => array(
					'{{WRAPPER}} .cookieconsent-accept input:disabled + .slider' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'checkbox_checked_color',
			array(
				'label'     => __( 'Checkbox text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .cookieconsent-accept' => 'fill: {{VALUE}}; color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'cookieconsent_accept_align',
			array(
				'label'     => __( 'Alignment', 'elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => __( 'Left', 'elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => __( 'Center', 'elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'end'        => array(
						'title' => __( 'Right', 'elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .cookieconsent-accept ul' => 'align-items: {{VALUE}};',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			array(
				'label' => __( 'Button', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
				'selector' => '{{WRAPPER}} #cookieconsentbutton',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'button_text_shadow',
				'selector' => '{{WRAPPER}} #cookieconsentbutton',
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => __( 'Normal', 'elementor' ),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} #cookieconsentbutton' => 'fill: {{VALUE}}; color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label'     => __( 'Background Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_ACCENT,
				),
				'selectors' => array(
					'{{WRAPPER}} #cookieconsentbutton' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => __( 'Hover', 'elementor' ),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} #cookieconsentbutton:hover, {{WRAPPER}} #cookieconsentbutton:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} #cookieconsentbutton:hover svg, {{WRAPPER}} #cookieconsentbutton:focus svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_background_color',
			array(
				'label'     => __( 'Background Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} #cookieconsentbutton:hover, {{WRAPPER}} #cookieconsentbutton:focus' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'hover_animation',
			array(
				'label' => __( 'Hover Animation', 'elementor' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'      => 'button_border',
				'label'     => __( 'Border', 'elementor' ),
				'selector'  => '{{WRAPPER}} #cookieconsentbutton',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} #cookieconsentbutton' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} #cookieconsentbutton',
			)
		);

		$this->add_responsive_control(
			'button_text_padding',
			array(
				'label'      => __( 'Padding', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} #cookieconsentbutton' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->end_controls_section();
	}


	private function set_cookie_button(): string {
		$text_button = strval( $this->get_settings_for_display( 'accepttext' ) );

		return '<li><button id="cookieconsentbutton" type="button">' . esc_html( $text_button ) . '</button></li>';
	}

	private function set_cookie_checkbox( string $setting_name, string $label ): string {

		$cookie_setting         = intval( $this->get_settings_for_display( $setting_name ) );
		$cookie_setting_display = strval( $this->get_settings_for_display( $setting_name . '_show' ) );
		$checkbox_value         = '';
		if ( Core::has_cookie() ) {
			if ( Core::get_cookie_value( $setting_name ) ) {
				$checkbox_value = $cookie_setting === 1 ? 'checked disabled="true"' : 'checked';
				$cookie_setting = true;
			}
		} elseif ( $cookie_setting === 0 ) {
				$checkbox_value = 'checked';
				$cookie_setting = true;
		}
		if ( $cookie_setting === 1 ) {
			$checkbox_value = 'checked disabled="true"';
			$cookie_setting = true;
		}
		if ( $cookie_setting_display ) {
			return '<li><label class="switch">
<input type="checkbox" name="' . esc_attr( $setting_name ) . '" id="' . esc_attr( $setting_name ) . '" ' . $checkbox_value . ' value="" /><span class="slider"></span></label><span>' . wp_kses( $label, wp_kses_allowed_html( 'data' ) ) . '<span></span></li>';
		} else {
			return '<input type="hidden" name="' . esc_attr( $setting_name ) . '" id="' . esc_attr( $setting_name ) . '" value="' . $cookie_setting . '" />';
		}
	}

	protected function render(): void {
		$settings = (array) $this->get_settings_for_display();

		$cookie_class = strval( $settings['cookie_bannner_type'] ?? 'banner-below' );
		$cookie_hide  = ' ';
		// Check if the page is excluded from cookie popup.
		$hide_pages = explode( ',', strval( $settings['hide_popup_pages'] ?? '' ) );
		if ( in_array( strval( get_the_ID() ), $hide_pages, true ) ) {
			$cookie_hide = ' ' . Core::HIDECOOKIECLASS;
		}

		$output  = '<div id="cookieconsentpopup" class="' . esc_attr( $cookie_class . $cookie_hide ) . '">';
		$output .= '<div class="cookieconsent_text">' . $this->parse_text_editor( strval( $settings['cookietext'] ) ) . '</div>'; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$output .= '<div class="cookieconsent-accept"><form id="cookieconsentform"><ul class="' . esc_attr( strval( $settings['cookie_checkbox_layout'] ) ) . '">'; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		/** @phpstan-ignore-next-line */
		$output .= wp_nonce_field( 'cookie_settings', 'cookie_nonce_field' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$output .= $this->set_cookie_checkbox( 'functionalCookies', strval( $settings['functional_cookie_text'] ) ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$output .= $this->set_cookie_checkbox( 'analyticalCookies', strval( $settings['analytical_cookie_text'] ) ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$output .= $this->set_cookie_checkbox( 'advertisementCookies', strval( $settings['advertisement_cookie_text'] ) ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$output .= $this->set_cookie_button(); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$output .= '</ul></form></div></div>';
		if ( \missingwidgets_fs()->can_use_premium_code__premium_only() && $settings['use_backgroundlayer'] ) {
			$output .= '<div class="cookieconsentpopup-layer' . esc_attr( $cookie_hide ) . '"></div>';
		}

		echo $output; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
