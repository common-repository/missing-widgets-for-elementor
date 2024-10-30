<?php

namespace MissingWidgets\Extras;

use Elementor\Controls_Manager;
use Elementor\Core\Base\Module;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Element_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Module_Sticky_Scroll_Effects extends Module {

	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}

	public function get_name() {
		return 'stickyscrolleffects';
	}

	public function register_controls( Element_Base $element ): void {
		$element->add_control(
			'sticky_scrolleffect_header',
			array(
				'label'     => esc_html__( 'Sticky Scrolling Effects', 'missingwidgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'sticky!' => '',
				),
			)
		);

		$element->add_control(
			'sticky_scrolleffect_enable',
			array(
				'label'              => esc_html__( 'Enable Sticky Scrolling Effects', 'missingwidgets' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => esc_html__( 'No', 'elementor-pro' ),
				'label_on'           => esc_html__( 'Yes', 'elementor-pro' ),
				'return_value'       => 'yes',
				'default'            => '',
				'render_type'        => 'ui',
				'frontend_available' => true,
				'condition'          => array(
					'sticky!' => '',
				),
				'selectors'          => array(
					'{{WRAPPER}}.elementor-sticky--active:not(.elementor-sticky--effects) .elementor-widget-image img' => 'transition: transform .45s cubic-bezier(.4, 0, .2, 1);transform: scale(1);',
				),
			)
		);

		$element->add_control(
			'sticky_scrolleffect_downsize_enable',
			array(
				'label'              => esc_html__( 'Downsize images when scrolling', 'missingwidgets' ),
				'description'        => esc_html__( 'Add the classname "sticky-scrolling-effect-noresize" to an image to prevent it from resizing during scrolling.',
					'missingwidgets' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => esc_html__( 'No', 'elementor-pro' ),
				'label_on'           => esc_html__( 'Yes', 'elementor-pro' ),
				'return_value'       => 'yes',
				'default'            => '',
				'render_type'        => 'ui',
				'frontend_available' => true,
				'condition'          => array(
					'sticky!'                    => '',
					'sticky_scrolleffect_enable' => 'yes',
				),
			)
		);

		$element->add_responsive_control(
			'sticky_scrolleffect_minheight_image',
			array(
				'label'              => esc_html__( 'Downsize images (%)', 'missingwidgets' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => array( '%' ),
				'default'            => array(
					'size' => 50,
				),
				'range'              => array(
					'%' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'condition'          => array(
					'sticky!'                             => '',
					'sticky_scrolleffect_enable'          => 'yes',
					'sticky_scrolleffect_downsize_enable' => 'yes',
				),
				'render_type'        => 'none',
				'frontend_available' => true,
				'selectors'          => array(
					'{{WRAPPER}}.elementor-sticky--active.elementor-sticky--effects .elementor-widget-image:not(.sticky-scrolling-effect-noresize) img' => 'transition: transform .45s cubic-bezier(.4, 0, .2, 1);transform: scale(calc({{SIZE}} / 100));',
				),
			)
		);

		$element->add_responsive_control(
			'sticky_scrolleffect_minheight',
			array(
				'label'              => esc_html__( 'Set minimum height section (px)', 'missingwidgets' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => array( 'px' ),
				'default'            => array(
					'size' => 100,
				),
				'range'              => array(
					'px' => array(
						'min' => 1,
						'max' => 300,
					),
				),
				'required'           => true,
				'condition'          => array(
					'sticky!'                    => '',
					'sticky_scrolleffect_enable' => 'yes',
				),
				'render_type'        => 'none',
				'frontend_available' => true,
				'selectors'          => array(
					'{{WRAPPER}}.elementor-sticky--active.elementor-sticky--effects > .elementor-container' => 'transition: min-height .45s cubic-bezier(.4, 0, .2, 1);min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$element->add_responsive_control(
			'sticky_scrolleffect_background',
			array(
				'label'              => esc_html__( 'Change background color', 'missingwidgets' ),
				'type'               => Controls_Manager::COLOR,
				'default'            => '',
				'condition'          => array(
					'sticky!'                    => '',
					'sticky_scrolleffect_enable' => 'yes',
				),
				'render_type'        => 'none',
				'frontend_available' => true,
				'selectors'          => array(
					'{{WRAPPER}}.elementor-sticky--active.elementor-sticky--effects' => 'background-color: {{VALUE}}',
				),
			)
		);

		$element->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'sticky_scrolleffect_border',
				'label'     => __( 'Border', 'missingwidgets' ),
				'default'   => '',
				'selector'  => '{{WRAPPER}}.elementor-sticky--active.elementor-sticky--effects',
				'separator' => 'before',
				'condition' => array(
					'sticky!'                    => '',
					'sticky_scrolleffect_enable' => 'yes',
				),
			)
		);

		$element->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'sticky_scrolleffect_boxshadow',
				'selector'  => '{{WRAPPER}}.elementor-sticky--active.elementor-sticky--effects',
				'condition' => array(
					'sticky!'                    => '',
					'sticky_scrolleffect_enable' => 'yes',
				),
			)
		);
	}

	private function add_actions(): void {
		add_action( 'elementor/element/section/section_effects/before_section_end', array( $this, 'register_controls' ) );
		add_action( 'elementor/element/container/section_effects/before_section_end', array( $this, 'register_controls' ) );
		add_action( 'elementor/element/common/section_effects/before_section_end', array( $this, 'register_controls' ) );
	}
}
