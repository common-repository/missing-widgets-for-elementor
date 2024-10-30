<?php

declare( strict_types = 1 );

namespace MissingWidgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Footer Menu Widget
 *
 * Create a footer menu layout for WordPress menu's
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class Footer_Menu extends Widget_Base {

	protected $nav_menu_index = 1; // @phpstan-ignore-line

	public function get_name(): string {
		return 'missingwidgets-footermenu';
	}

	public function get_title(): string {
		return __( 'Footermenu', 'missingwidgets' );
	}

	public function get_icon(): string {
		return 'eicon-nav-menu';
	}

	public function get_categories(): array {
		return array( 'general' );
	}

	public function get_keywords(): array {
		return array( 'menu', 'nav', 'footer', 'navigation', 'navigation', 'missing', 'widgets', 'missingwidgets' );
	}

	public function get_custom_help_url(): string {
		return 'https://missingwidgets.com/missing-widgets-features/elementor-footer-menu-widget/';
	}

	protected function get_nav_menu_index(): int {
		return $this->nav_menu_index++;
	}

	private function get_available_menus(): array {
		$menus = wp_get_nav_menus();

		$options = array();

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	protected function register_controls(): void {
		// Start layout tab-content.
		$this->start_controls_section(
				'content_basic',
				array(
						'label' => __( 'Layout', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_CONTENT,
				)
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
					'footermenu',
					array(
							'label'        => __( 'Menu', 'elementor-pro' ),
							'type'         => Controls_Manager::SELECT,
							'options'      => $menus,
							'default'      => array_keys( $menus )[0],
							'save_default' => true,
							'separator'    => 'after',
							'description'  => sprintf(
									__(
											'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.',
											'elementor-pro'
									),
									admin_url( 'nav-menus.php' )
							),
					)
			);
		} else {
			$this->add_control(
					'emptyfootermenu',
					array(
							'type'            => Controls_Manager::RAW_HTML,
							'raw'             => '<strong>' . __(
											'There are no menus in your site.',
											'elementor-pro'
									) . '</strong><br>'
												. sprintf(
														__( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.',
																'elementor-pro' ),
														admin_url( 'nav-menus.php?action=edit&menu=0' )
												),
							'separator'       => 'after',
							'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					)
			);
		}

		$this->add_responsive_control(
				'columns_footermenu',
				array(
						'label'              => __( 'Columns', 'elementor-pro' ),
						'type'               => Controls_Manager::SELECT,
						'default'            => '3',
						'tablet_default'     => '2',
						'mobile_default'     => '1',
						'options'            => array(
								'1' => '1',
								'2' => '2',
								'3' => '3',
								'4' => '4',
								'5' => '5',
								'6' => '6',
						),
						'prefix_class'       => 'elementor-grid%s-',
						'frontend_available' => true,
						'selectors'          => array(
								'{{WRAPPER}} .elementor-nav-footermenu > li' => 'width: calc( 100% / {{SIZE}} )',
						),
				)
		);

		$this->add_control(
				'align_items',
				array(
						'label'                => __( 'Align menuitems', 'missingwidgets' ),
						'type'                 => Controls_Manager::CHOOSE,
						'options'              => array(
								'left'   => array(
										'title' => __( 'Left', 'elementor-pro' ),
										'icon'  => 'eicon-h-align-left',
								),
								'center' => array(
										'title' => __( 'Center', 'elementor-pro' ),
										'icon'  => 'eicon-h-align-center',
								),
								'right'  => array(
										'title' => __( 'Right', 'elementor-pro' ),
										'icon'  => 'eicon-h-align-right',
								),

						),
						'selectors_dictionary' => array(
								'left'   => 'text-align: left',
								'center' => 'text-align: center',
								'right'  => 'text-align : right',
						),
						'selectors'            => array(
								'{{WRAPPER}} .elementor-nav-footermenu' => '{{VALUE}}',
						),
				)
		);

		$this->end_controls_section(); // end layout tab-content
		// Start icoon tab-content.
		$this->start_controls_section(
				'content_icon',
				array(
						'label' => __( 'Icon', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_CONTENT,
				)
		);

		$this->add_control(
				'submenuitem_icon',
				array(
						'type' => Controls_Manager::ICONS,
				)
		);

		$this->end_controls_section();
		// End icoon tab-content.

		// Start control section columns.
		$this->start_controls_section(
				'section_style_columns-menu',
				array(
						'label' => __( 'Columns', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_STYLE,
				)
		);

		$this->add_responsive_control(
				'padding_columns_menu',
				array(
						'label'      => __( 'Padding', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', '%', 'em' ),
						'selectors'  => array(
								'{{WRAPPER}} .elementor-nav-footermenu > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->end_controls_section();
		// End control section columns.

		// Start control section mainmenu.
		$this->start_controls_section(
				'section_style_mainheaderitems-menu',
				array(
						'label' => __( 'Header item', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_STYLE,
				)
		);
		// Start typography.
		$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
						'name'     => 'footermainmenu_typography',
						'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
						'selector' => '{{WRAPPER}} .elementor-nav-footermenu > li > a',
				)
		);

		// Start mainmenu tabs.
		$this->start_controls_tabs( 'tabs_mainmenu_item_style' );

		// Start mainmenu tab normal.
		$this->start_controls_tab(
				'tab_mainmenu_item_normal',
				array(
						'label' => __( 'Normal', 'elementor-pro' ),
				)
		);

		$this->add_control(
				'color_footer_mainmenu_item',
				array(
						'label'     => __( 'Text Color', 'elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .elementor-nav-footermenu > li > a' => 'color: {{VALUE}}',
						),
				)
		);

		$this->end_controls_tab();
		// End mainmenu tab normal.
		// Start mainmenu tab hover.
		$this->start_controls_tab(
				'tab_mainmenu_item_hover',
				array(
						'label' => __( 'Hover', 'elementor-pro' ),
				)
		);

		$this->add_control(
				'color_footer_mainmenu_item_hover',
				array(
						'label'     => __( 'Text Color', 'elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
								'{{WRAPPER}} .elementor-nav-footermenu > li > a:hover,
					{{WRAPPER}} .elementor-nav-footermenu > li > a:focus' => 'color: {{VALUE}}',
						),
				)
		);

		$this->end_controls_tab();
		// End mainmenu tab hover.

		$this->end_controls_tabs();
		// End mainmenu tabs.

		// This control is required to handle with complicated conditions.
		$this->add_control(
				'hr_mainmenu',
				array(
						'type' => Controls_Manager::DIVIDER,
				)
		);

		$this->add_responsive_control(
				'padding_vertical_footer_mainmenu_item',
				array(
						'label'     => __( 'Vertical Padding', 'elementor-pro' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => array(
								'px' => array(
										'max' => 50,
								),
						),
						'selectors' => array(
								'{{WRAPPER}} .elementor-nav-footermenu > li > a' => 'display:inline-block; padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->end_controls_section();
		// End control section mainmenu.
		// Start control section submenu.
		$this->start_controls_section(
				'section_style_subitems-menu',
				array(
						'label' => __( 'Submenu item', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_STYLE,
				)
		);

		$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
						'name'     => 'footersubmenu_typography',
						'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
						'selector' => '{{WRAPPER}} a.elementor-sub-footeritem',
				)
		);
		// Start submenu tabs.
		$this->start_controls_tabs( 'tabs_submenu_item_style' );

		// Start submenu tab normal.
		$this->start_controls_tab(
				'tab_submenu_item_normal',
				array(
						'label' => __( 'Normal', 'elementor-pro' ),
				)
		);

		$this->add_control(
				'color_footer_submenu_item',
				array(
						'label'     => __( 'Text Color', 'elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} a.elementor-sub-footeritem' => 'color: {{VALUE}}',
						),
				)
		);

		$this->end_controls_tab();
		// End submenu tab normal.
		// Start submenu tab hover.
		$this->start_controls_tab(
				'tab_submenu_item_hover',
				array(
						'label' => __( 'Hover', 'elementor-pro' ),
				)
		);

		$this->add_control(
				'color_footer_submenu_item_hover',
				array(
						'label'     => __( 'Text Color', 'elementor-pro' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
								'{{WRAPPER}} a.elementor-sub-footeritem:hover,
					{{WRAPPER}} a.elementor-sub-footeritem:focus' => 'color: {{VALUE}}',
						),
				)
		);

		$this->end_controls_tab();
		// End submenu tab hover.

		$this->end_controls_tabs();
		// End submenu tabs.

		$this->add_control(
				'hr_submenu',
				array(
						'type' => Controls_Manager::DIVIDER,
				)
		);

		$this->add_control(
				'text_indent',
				array(
						'label'     => __( 'Text Indent', 'elementor' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => array(
								'px' => array(
										'max' => 50,
								),
						),
						'selectors' => array(
								'{{WRAPPER}} .elementor-nav-submenu > li > a' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
						),
				)
		);

		$this->add_responsive_control(
				'padding_vertical_footer_submenu_item',
				array(
						'label'     => __( 'Vertical Padding', 'elementor-pro' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => array(
								'px' => array(
										'max' => 50,
								),
						),
						'selectors' => array(
								'{{WRAPPER}} .elementor-nav-submenu > li' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->add_control(
				'hr_icon_submenu',
				array(
						'type' => Controls_Manager::DIVIDER,
				)
		);

		$this->end_controls_section();
		// End control section submenu.

		// Start icoon tab-content.
		$this->start_controls_section(
				'style_icon',
				array(
						'label' => __( 'Icon', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_STYLE,
				)
		);

		$this->add_control(
				'icon_size',
				array(
						'label'      => __( 'Size', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'em', 'rem', 'vw' ),
						'range'      => array(
								'px'  => array(
										'min'  => 0,
										'max'  => 50,
										'step' => 1,
								),
								'em'  => array(
										'min'  => 0,
										'max'  => 5,
										'step' => .1,
								),
								'rem' => array(
										'min'  => 0,
										'max'  => 5,
										'step' => .1,
								),
								'vw'  => array(
										'min'  => 0,
										'max'  => 5,
										'step' => .1,
								),
						),
						'selectors'  => array(
								'{{WRAPPER}} .elementor-nav-submenu > li i' => 'font-size: {{SIZE}}{{UNIT}};',
						),
				)
		);

		// Start icon tabs.
		$this->start_controls_tabs( 'tabs_icon_item_style' );

		// Start icon tab normal.
		$this->start_controls_tab(
				'tab_icon_item_normal',
				array(
						'label' => __( 'Normal', 'elementor-pro' ),
				)
		);

		$this->add_control(
				'color_footer_icon_item',
				array(
						'label'     => __( 'Icon Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .elementor-nav-submenu > li i' => 'color: {{VALUE}}',
						),
				)
		);

		$this->end_controls_tab();
		// End icon tab normal.

		// Start icon tab hover.
		$this->start_controls_tab(
				'tab_icon_item_hover',
				array(
						'label' => __( 'Hover', 'elementor-pro' ),
				)
		);

		$this->add_control(
				'color_footer_icon_item_hover',
				array(
						'label'     => __( 'Icon Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
								'{{WRAPPER}} .elementor-nav-submenu > li:hover i,
					{{WRAPPER}} .elementor-nav-submenu > li:focus i' => 'color: {{VALUE}}',
						),
				)
		);

		$this->end_controls_tab();
		// End icon tab hover.

		$this->end_controls_tabs();
		// End icon tabs.

		$this->end_controls_section();
		// End icoon tab-content.
	}

	protected function render(): void {
		$available_menus = $this->get_available_menus();

		if ( ! $available_menus ) {
			return;
		}
		$settings = $this->get_active_settings();
		$icon     = $settings['submenuitem_icon']['value'] !== '' ? '<i class="' . esc_attr( $settings['submenuitem_icon']['value'] ) . '"></i>' : '';
		$args     = array(
				'echo'        => false,
				'menu'        => $settings['footermenu'],
				'before'      => $icon,
				'menu_class'  => 'elementor-nav-footermenu',
				'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
				'fallback_cb' => '__return_empty_string',
				'container'   => '',
		);
		// Add custom filter to handle Nav Menu HTML output.
		add_filter( 'nav_menu_link_attributes', array( $this, 'handle_link_classes' ), 10, 4 );
		add_filter( 'nav_menu_submenu_css_class', array( $this, 'handle_sub_menu_classes' ) );
		add_filter( 'nav_menu_item_id', '__return_empty_string' );

		// General Menu.
		$menu_html = strval( wp_nav_menu( $args ) );

		// Remove all our custom filters.
		remove_filter( 'nav_menu_link_attributes', array( $this, 'handle_link_classes' ) );
		remove_filter( 'nav_menu_submenu_css_class', array( $this, 'handle_sub_menu_classes' ) );
		remove_filter( 'nav_menu_item_id', '__return_empty_string' );

		if ( empty( $menu_html ) ) {
			return;
		}
		// $menu_html is sanitized by wp_nav_menu.
		?>
		<div class="elementor-footermenu-container">
			<?php
			echo $menu_html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
			?>
		</div>
		<?php
	}


	public function handle_link_classes( array $atts, \WP_Post $item, \stdClass $args, int $depth ): array {
		$classes   = $depth ? 'elementor-sub-footeritem' : 'elementor-footeritem';
		$is_anchor = false !== strpos( $atts['href'], '#' );

		// @phpstan-ignore-next-line
		if ( $item->classes && ! $is_anchor && in_array( 'current-menu-footeritem', $item->classes, true ) ) {
			$classes .= ' elementor-footeritem-active';
		}

		if ( $is_anchor ) {
			$classes .= ' elementor-footeritem-anchor';
		}

		if ( empty( $atts['class'] ) ) {
			$atts['class'] = $classes;
		} else {
			$atts['class'] .= ' ' . $classes;
		}

		return $atts;
	}

	public function handle_sub_menu_classes( array $classes ): array {
		$classes[] = 'elementor-nav-submenu';

		return $classes;
	}

	public function render_plain_content(): void {
	}
}
