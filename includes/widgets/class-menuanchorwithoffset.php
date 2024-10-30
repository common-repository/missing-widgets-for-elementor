<?php declare( strict_types = 1 );

namespace MissingWidgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Menu Anchor With Offset Widget
 *
 * Anchor Widget which scroll to a specific position on the page and doesn't hide under a fixed menu.
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class Menu_Anchor_With_Offset extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve menu anchor widget name.
	 *
	 * @return string Widget name.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_name(): string {
		return 'menu-anchor-with-offset';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve menu anchor widget title.
	 *
	 * @return string Widget title.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_title(): string {
		return esc_html__( 'Menu Anchor With Offset', 'missingwidgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve menu anchor widget icon.
	 *
	 * @return string Widget icon.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_icon(): string {
		return 'eicon-anchor';
	}

	/**
	 * Set the categories.
	 *
	 * @return string[]
	 */
	public function get_categories(): array {
		return array( 'general' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords(): array {
		return array( 'menu', 'anchor', 'link', 'offset', 'scroll' );
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {

		$this->start_controls_section(
				'section_anchor_with_offset',
				array(
						'label' => esc_html__( 'Anchor', 'missingwidgets' ),
						'tab' => Controls_Manager::TAB_CONTENT,
				)
		);

		$this->add_control(
				'anchor_with_offset',
				array(
						'label' => esc_html__( 'The ID of Menu Anchor.', 'missingwidgets' ),
						'type' => Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'For Example: About', 'missingwidgets' ),
						'description' => esc_html__( 'This ID will be the CSS ID you will have to use in your own page, Without #.', 'elementor' ),
						'label_block' => true,
				)
		);

		$this->add_control(
				'anchor_note_with_offset',
				array(
						'type' => Controls_Manager::RAW_HTML,
						'raw' => sprintf( esc_html__( 'Note: The ID link ONLY accepts these chars: %s', 'missingwidgets' ), 'A-Z, a-z, 0-9, _ , -' ),
						'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				)
		);

		$this->add_responsive_control(
				'anchor_offset',
				array(
						'label' => esc_html__( 'Anchor offset in pixels', 'missingwidgets' ),
						'type' => Controls_Manager::NUMBER,
						'min' => 0,
						'max' => 300,
						'step' => 1,
						'default' => 0,
				)
		);

		$this->add_responsive_control(
				'anchor_scrolling_speed',
				array(
						'label' => esc_html__( 'Anchor Scrolling Speed in ms.', 'missingwidgets' ),
						'type' => Controls_Manager::NUMBER,
						'min' => 0,
						'max' => 2000,
						'step' => 100,
						'default' => 1000,
				)
		);

		$this->end_controls_section();
	}

	/**
	 * Render output on the frontend.
	 */
	protected function render(): void {
		$anchor = strval( $this->get_settings_for_display( 'anchor_with_offset' ) );
		$offset_value = strval( $this->get_settings_for_display( 'anchor_offset' ) );
		$animation_type = 'smooth';
		if ( ! empty( $anchor ) ) {
			$this->add_render_attribute( 'inner', 'id', sanitize_html_class( $anchor ) );
			$this->add_render_attribute( 'inner', 'data-animation', esc_attr( $animation_type ) );
			$this->add_render_attribute( 'inner', 'data-offset', esc_attr( $offset_value ) );
		}

		$this->add_render_attribute( 'inner', 'class', 'missingwidget-menu-anchor' );
		?>
		<div <?php $this->print_render_attribute_string( 'inner' ); ?>></div>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template(): void {
		?>
		<div class="missingwidget-menu-anchor" {{{ settings.anchor_with_offset ? ' id="' + settings.anchor_with_offset + '"' : '' }}} {{{ settings.anchor_offset ? ' data-offset="' + settings.anchor_offset + '"' : '' }}} data-animation="smooth"></div>
		<?php
	}
}
