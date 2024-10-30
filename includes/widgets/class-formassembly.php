<?php

declare( strict_types = 1 );

namespace MissingWidgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * FormAssembly Widget
 *
 * Create a FormAssembly form
 * For styling see https://help.formassembly.com/help/theme-customization-controls
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class Form_Assembly extends Widget_Base {


	/**
	 * Get widget name.
	 *
	 * Retrieve label list widget name.
	 *
	 * @return string Widget name.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_name(): string {
		return 'missingwidget-formassembly';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve label list widget title.
	 *
	 * @return string Widget title.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_title(): string {
		return __( 'FormAssembly forms', 'missingwidgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve icon.
	 *
	 * @return string icon.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_icon(): string {
		return 'eicon-form-horizontal';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array<int, string> Widget keywords.
	 * @since  2.1.0
	 * @access public
	 */
	public function get_keywords(): array {
		return array( 'form', 'formassembly', 'forms', 'salesforce', 'missing', 'widgets', 'missingwidgets' );
	}

	/**
	 * Set this to theme-elements so the widget can be found inside the site tab of the widget elementor.
	 * see for more info https://developers.elementor.com/widget-categories/
	 *
	 * @return array<int, string>
	 */
	public function get_categories(): array {
		return array( 'general' );
	}

	public function get_custom_help_url(): string {
		return 'https://missingwidgets.com/missing-widgets-features/formassembly-elementor-widget/';
	}

	/**
	 * Register label list widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  3.1.0
	 * @access protected
	 */
	protected function register_controls(): void {
		$this->start_controls_section(
				'section_form_details',
				array(
						'label' => __( 'Form settings', 'missingwidgets' ),
				)
		);

		$this->add_control(
				'fa_url',
				array(
						'label'       => __( 'Form assembly url', 'missingwidgets' ),
						'label_block' => true,
						'type'        => Controls_Manager::TEXT,
						'default'     => 'https://app.formassembly.com',
				)
		);
		$this->add_control(
				'fa_type',
				array(
						'label'   => __( 'Form type', 'elementor' ),
						'type'    => Controls_Manager::SELECT,
						'options' => array(
								'form'     => __( 'Form', 'elementor' ),
								'workflow' => __( 'Workflow', 'missingwidgets' ),
						),
						'default' => 'form',
				)
		);
		$this->add_control(
				'fa_id',
				array(
						'label' => __( 'Form id', 'missingwidgets' ),
						'type'  => Controls_Manager::TEXT,
				)
		);
		$this->add_control(
				'fa_fields',
				array(
						'label'       => __( 'Prefill field parameters', 'missingwidgets' ),
						'label_block' => true,
						'type'        => Controls_Manager::TEXT,
						'default'     => '',
						'description' => __( 'Prefill the form based on url request parameters. Add a comma between the different fields. See <a href="https://help.formassembly.com/help/prefill-through-the-url" target="_blank">https://help.formassembly.com/help/prefill-through-the-url</a> for more information',
								'missingwidgets' ),
				)
		);
		$this->add_control(
				'fa_iframe',
				array(
						'label'       => __( 'Use iFrame', 'missingwidgets' ),
						'type'        => Controls_Manager::SWITCHER,
						'label_off'   => __( 'No', 'elementor' ),
						'label_on'    => __( 'Yes', 'elementor' ),
						'description' => __( 'Styling can only be used if iFrame is set to no.', 'missingwidgets' ),
				)
		);
		$this->add_control(
				'fa_iframe_style',
				array(
						'label'       => __( 'Iframe Style', 'missingwidgets' ),
						'type'        => Controls_Manager::TEXT,
						'label_block' => true,
						'condition'   => array(
								'fa_iframe' => 'yes',
						),
						'default'     => 'width: 100%; min-height: 650px;',
				)
		);
		$this->end_controls_section();

		/**
		 * Style Tab: Iframe Info Container
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
				'mw_formassembly_section_general_style',
				array(
						'label'     => __( 'Iframe', 'missingwidgets' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'fa_iframe' => 'yes',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_info_iframe',
				array(
						'label'     => esc_html__( 'Form is set to iFrame', 'missingwidgets' ),
						'type'      => Controls_Manager::RAW_HTML,
						'separator' => 'before',
						'raw'       => '<div><p>' . __(
										'Styling is disabled if Iframe is used.',
										'missingwidgets'
								) . '</p></div>',
				)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Form Container
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
				'section_container_style',
				array(
						'label'     => __( 'Form Container', 'missingwidgets' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'fa_iframe' => '',
						),

				)
		);

		$this->add_control(
				'mw_formassembly_background',
				array(
						'label'     => esc_html__( 'Form Background Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .wFormContainer,
								{{WRAPPER}} .mw-formassembly-form .reviewHeader,
								{{WRAPPER}} .mw-formassembly-form .reviewResponse,
								{{WRAPPER}} .mw-formassembly-form .reviewFooter,
								{{WRAPPER}} .mw-formassembly-form .wForm .field-hint-inactive .hint,
								{{WRAPPER}} .mw-formassembly-form .wForm .hintsBelow .field-hint,
								{{WRAPPER}} .mw-formassembly-form .wForm .hintsSide .field-hint,
								{{WRAPPER}} .mw-formassembly-form .wFormContainer .wForm, 
								{{WRAPPER}} .mw-formassembly-form .wForm .wFormTitle' => 'background-color: {{VALUE}};',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_alignment',
				array(
						'label'       => esc_html__( 'Form Alignment', 'missingwidgets' ),
						'type'        => Controls_Manager::CHOOSE,
						'label_block' => true,
						'options'     => array(
								'default' => array(
										'title' => __( 'Default', 'missingwidgets' ),
										'icon'  => 'fa fa-ban',
								),
								'left'    => array(
										'title' => esc_html__( 'Left', 'missingwidgets' ),
										'icon'  => 'eicon-h-align-left',
								),
								'center'  => array(
										'title' => esc_html__( 'Center', 'missingwidgets' ),
										'icon'  => 'eicon-h-align-center',
								),
								'right'   => array(
										'title' => esc_html__( 'Right', 'missingwidgets' ),
										'icon'  => 'eicon-h-align-right',
								),
						),
						'default'     => 'default',
						'selectors'   => array(
								'{{WRAPPER}} .mw-formassembly-form'      => 'text-align: {{VALUE}};',
								'{{WRAPPER}} .mw-formassembly-form form' => 'text-align: {{VALUE}};',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_width',
				array(
						'label'      => esc_html__( 'Form Width', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'em', '%' ),
						'range'      => array(
								'px' => array(
										'min' => 10,
										'max' => 1500,
								),
								'em' => array(
										'min' => 1,
										'max' => 80,
								),
						),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .wFormContainer' => 'width: {{SIZE}}{{UNIT}};',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_max_width',
				array(
						'label'      => esc_html__( 'Form Max Width', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'em', '%' ),
						'range'      => array(
								'px' => array(
										'min' => 10,
										'max' => 1500,
								),
								'em' => array(
										'min' => 1,
										'max' => 80,
								),
						),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .wFormContainer' => 'max-width: {{SIZE}}{{UNIT}};',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_margin',
				array(
						'label'      => esc_html__( 'Form Margin', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .wFormContainer, {{WRAPPER}} .mw-formassembly-form .reviewHeader, {{WRAPPER}} .mw-formassembly-form .reviewResponse' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_padding',
				array(
						'label'      => esc_html__( 'Form Padding', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .wFormContainer, {{WRAPPER}} .mw-formassembly-form .reviewHeader, {{WRAPPER}} .mw-formassembly-form .reviewResponse' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_border_radius',
				array(
						'label'      => esc_html__( 'Border Radius', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'separator'  => 'before',
						'size_units' => array( 'px' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .wFormContainer, {{WRAPPER}} .mw-formassembly-form .reviewHeader, {{WRAPPER}} .mw-formassembly-form .reviewResponse' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
						'name'     => 'mw_formassembly_border',
						'selector' => '{{WRAPPER}} .mw-formassembly-form .wFormContainer, {{WRAPPER}} .mw-formassembly-form .reviewHeader, {{WRAPPER}} .mw-formassembly-form .reviewResponse',
				)
		);

		$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
						'name'     => 'mw_formassembly_box_shadow',
						'selector' => '{{WRAPPER}} .mw-formassembly-form .wFormContainer, {{WRAPPER}} .mw-formassembly-form .reviewHeader, {{WRAPPER}} .mw-formassembly-form .reviewResponse',
				)
		);

		$this->end_controls_section();
		/**
		 * Style Tab: Title and Border
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
				'mw_formassembly_section_title_description_style',
				array(
						'label'     => __( 'Section Title & Border', 'missingwidgets' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'fa_iframe' => '',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_title_heading',
				array(
						'label'     => __( 'Title', 'missingwidgets' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
				)
		);

		$this->add_control(
				'mw_formassembly_title_text_color',
				array(
						'label'     => __( 'Text Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form fieldset > legend, {{WRAPPER}} .mw-formassembly-form .wFormContainer .wForm .wFormTitle' => 'color: {{VALUE}};',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
						'name'     => 'mw_formassembly_title_typography',
						'label'    => __( 'Typography', 'missingwidgets' ),
						'scheme'   => Typography::TYPOGRAPHY_4,
						'selector' => '{{WRAPPER}} .mw-formassembly-form fieldset > legend, {{WRAPPER}} .mw-formassembly-form .wFormContainer .wForm .wFormTitle',
				)
		);

		$this->add_control(
				'mw_formassembly_description_heading',
				array(
						'label'     => __( 'Border', 'missingwidgets' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
				)
		);

		$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
						'name'        => 'mw_formassembly_section_border',
						'label'       => __( 'Section border', 'missingwidgets' ),
						'placeholder' => '1px',
						'default'     => '1px',
						'selector'    => '{{WRAPPER}} .mw-formassembly-form fieldset, {{WRAPPER}} .mw-formassembly-form .wFormContainer .wForm',
				)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Labels
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
				'mw_formassembly_section_label_style',
				array(
						'label'     => __( 'Labels', 'missingwidgets' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'fa_iframe' => '',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_text_color_label',
				array(
						'label'     => __( 'Text Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
								'{{WRAPPER}}.mw-formassembly-form label.preField, 
								{{WRAPPER}} .mw-formassembly-form .label, 
								{{WRAPPER}} .mw-formassembly-form .oneChoice .label.postField, 
								{{WRAPPER}} .mw-formassembly-form .oneField .label span, 
								{{WRAPPER}} .mw-formassembly-form .wForm .inputWrapper input[type="file"]' => 'color: {{VALUE}}',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_text_required_color_label',
				array(
						'label'     => __( 'Required Sign Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form label.preField::after, 
								{{WRAPPER}} .mw-formassembly-form .label::after' => 'color: {{VALUE}}',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
						'name'     => 'mw_formassembly_typography_label',
						'label'    => __( 'Typography', 'missingwidgets' ),
						'selector' => '{{WRAPPER}}.mw-formassembly-form label.preField, 
								{{WRAPPER}} .mw-formassembly-form .label, 
								{{WRAPPER}} .mw-formassembly-form .oneChoice .label.postField, 
								{{WRAPPER}} .mw-formassembly-form .oneField .label span, 
								{{WRAPPER}} .mw-formassembly-form .wForm .inputWrapper input[type="file"]',
				)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Input & Textarea & Select
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
				'mw_formassembly_section_fields_style',
				array(
						'label'     => __( 'Input & Textarea & Select', 'missingwidgets' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'fa_iframe' => '',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_input_alignment',
				array(
						'label'     => __( 'Alignment', 'missingwidgets' ),
						'type'      => Controls_Manager::CHOOSE,
						'options'   => array(
								'left'   => array(
										'title' => esc_html__( 'Left', 'missingwidgets' ),
										'icon'  => 'eicon-h-align-left',
								),
								'center' => array(
										'title' => esc_html__( 'Center', 'missingwidgets' ),
										'icon'  => 'eicon-h-align-center',
								),
								'right'  => array(
										'title' => esc_html__( 'Right', 'missingwidgets' ),
										'icon'  => 'eicon-h-align-right',
								),
						),
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form input[type="text"],{{WRAPPER}} .mw-formassembly-form input[type="password"], {{WRAPPER}} .mw-formassembly-form input[type="email"], {{WRAPPER}} .mw-formassembly-form input[type="number"], {{WRAPPER}} .mw-formassembly-form input[type="url"], {{WRAPPER}} .mw-formassembly-form input[type="tel"], {{WRAPPER}} .mw-formassembly-form input[type="file"], {{WRAPPER}} .mw-formassembly-form input[type="search"], {{WRAPPER}} .mw-formassembly-form textarea, {{WRAPPER}} .mw-formassembly-form select' => 'text-align: {{VALUE}};',
						),
				)
		);

		$this->start_controls_tabs( 'tabs_fields_style' );

		$this->start_controls_tab(
				'mw_formassembly_tab_fields_normal',
				array(
						'label' => __( 'Normal', 'missingwidgets' ),
				)
		);

		$this->add_control(
				'mw_formassembly_field_bg_color',
				array(
						'label'     => __( 'Background Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form input[type="text"],{{WRAPPER}} .mw-formassembly-form input[type="password"], {{WRAPPER}} .mw-formassembly-form input[type="email"], {{WRAPPER}} .mw-formassembly-form input[type="number"], {{WRAPPER}} .mw-formassembly-form input[type="url"], {{WRAPPER}} .mw-formassembly-form input[type="tel"], {{WRAPPER}} .mw-formassembly-form input[type="file"], {{WRAPPER}} .mw-formassembly-form input[type="search"], {{WRAPPER}} .mw-formassembly-form textarea, {{WRAPPER}} .mw-formassembly-form select' => 'background-color: {{VALUE}}',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_field_text_color',
				array(
						'label'     => __( 'Text Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form input[type="text"],{{WRAPPER}} .mw-formassembly-form input[type="password"], {{WRAPPER}} .mw-formassembly-form input[type="email"], {{WRAPPER}} .mw-formassembly-form input[type="number"], {{WRAPPER}} .mw-formassembly-form input[type="url"], {{WRAPPER}} .mw-formassembly-form input[type="tel"], {{WRAPPER}} .mw-formassembly-form input[type="file"], {{WRAPPER}} .mw-formassembly-form input[type="search"], {{WRAPPER}} .mw-formassembly-form textarea, {{WRAPPER}} .mw-formassembly-form select' => 'color: {{VALUE}}',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_field_spacing',
				array(
						'label'      => __( 'Spacing', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'range'      => array(
								'px' => array(
										'min'  => 0,
										'max'  => 100,
										'step' => 1,
								),
						),
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .inputWrapper' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_field_spacing_right',
				array(
						'label'      => __( 'Spacing Right', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'range'      => array(
								'px' => array(
										'min'  => 0,
										'max'  => 100,
										'step' => 1,
								),
						),
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .inputWrapper' => 'padding-right: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_field_padding',
				array(
						'label'      => __( 'Padding', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), {{WRAPPER}} .mw-formassembly-form textarea, {{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_text_indent',
				array(
						'label'      => __( 'Text Indent', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'range'      => array(
								'px' => array(
										'min'  => 0,
										'max'  => 60,
										'step' => 1,
								),
								'%'  => array(
										'min'  => 0,
										'max'  => 30,
										'step' => 1,
								),
						),
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form input[type="text"],{{WRAPPER}} .mw-formassembly-form input[type="password"], {{WRAPPER}} .mw-formassembly-form input[type="email"], {{WRAPPER}} .mw-formassembly-form input[type="number"], {{WRAPPER}} .mw-formassembly-form input[type="url"], {{WRAPPER}} .mw-formassembly-form input[type="tel"], {{WRAPPER}} .mw-formassembly-form input[type="file"], {{WRAPPER}} .mw-formassembly-form input[type="search"], {{WRAPPER}} .mw-formassembly-form textarea, {{WRAPPER}} .mw-formassembly-form select' => 'text-indent: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_input_height',
				array(
						'label'      => __( 'Input Height', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'range'      => array(
								'px' => array(
										'min'  => 0,
										'max'  => 80,
										'step' => 1,
								),
						),
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form input[type="text"],{{WRAPPER}} .mw-formassembly-form input[type="password"], {{WRAPPER}} .mw-formassembly-form input[type="email"], {{WRAPPER}} .mw-formassembly-form input[type="number"], {{WRAPPER}} .mw-formassembly-form input[type="url"], {{WRAPPER}} .mw-formassembly-form input[type="tel"], {{WRAPPER}} .mw-formassembly-form input[type="file"], {{WRAPPER}} .mw-formassembly-form input[type="search"]' => 'height: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_select_height',
				array(
						'label'      => __( 'Select Height', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'range'      => array(
								'px' => array(
										'min'  => 0,
										'max'  => 80,
										'step' => 1,
								),
						),
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form select' => 'height: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
						'name'        => 'mw_formassembly_field_border',
						'label'       => __( 'Border', 'missingwidgets' ),
						'placeholder' => '1px',
						'default'     => '1px',
						'selector'    => '{{WRAPPER}} .mw-formassembly-form input[type="text"],{{WRAPPER}} .mw-formassembly-form input[type="password"], {{WRAPPER}} .mw-formassembly-form input[type="email"], {{WRAPPER}} .mw-formassembly-form input[type="number"], {{WRAPPER}} .mw-formassembly-form input[type="url"], {{WRAPPER}} .mw-formassembly-form input[type="tel"], {{WRAPPER}} .mw-formassembly-form input[type="file"], {{WRAPPER}} .mw-formassembly-form input[type="search"], {{WRAPPER}} .mw-formassembly-form textarea, {{WRAPPER}} .mw-formassembly-form select',
						'separator'   => 'before',
				)
		);

		$this->add_control(
				'mw_formassembly_field_radius',
				array(
						'label'      => __( 'Border Radius', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form input[type="text"],{{WRAPPER}} .mw-formassembly-form input[type="password"], {{WRAPPER}} .mw-formassembly-form input[type="email"], {{WRAPPER}} .mw-formassembly-form input[type="number"], {{WRAPPER}} .mw-formassembly-form input[type="url"], {{WRAPPER}} .mw-formassembly-form input[type="tel"], {{WRAPPER}} .mw-formassembly-form input[type="file"], {{WRAPPER}} .mw-formassembly-form input[type="search"], {{WRAPPER}} .mw-formassembly-form textarea, {{WRAPPER}} .mw-formassembly-form select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
						'name'      => 'mw_formassembly_field_typography',
						'label'     => __( 'Typography', 'missingwidgets' ),
						'selector'  => '{{WRAPPER}} .mw-formassembly-form input[type="text"],{{WRAPPER}} .mw-formassembly-form input[type="password"], {{WRAPPER}} .mw-formassembly-form input[type="email"], {{WRAPPER}} .mw-formassembly-form input[type="number"], {{WRAPPER}} .mw-formassembly-form input[type="url"], {{WRAPPER}} .mw-formassembly-form input[type="tel"], {{WRAPPER}} .mw-formassembly-form input[type="file"], {{WRAPPER}} .mw-formassembly-form input[type="search"], {{WRAPPER}} .mw-formassembly-form textarea, {{WRAPPER}} .mw-formassembly-form select',
						'separator' => 'before',
				)
		);

		$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
						'name'      => 'mw_formassembly_field_box_shadow',
						'selector'  => '{{WRAPPER}} .mw-formassembly-form input[type="text"],{{WRAPPER}} .mw-formassembly-form input[type="password"], {{WRAPPER}} .mw-formassembly-form input[type="email"], {{WRAPPER}} .mw-formassembly-form input[type="number"], {{WRAPPER}} .mw-formassembly-form input[type="url"], {{WRAPPER}} .mw-formassembly-form input[type="tel"], {{WRAPPER}} .mw-formassembly-form input[type="file"], {{WRAPPER}} .mw-formassembly-form input[type="search"], {{WRAPPER}} .mw-formassembly-form textarea, {{WRAPPER}} .mw-formassembly-form select',
						'separator' => 'before',
				)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
				'mw_formassembly_tab_fields_focus',
				array(
						'label' => __( 'Focus', 'missingwidgets' ),
				)
		);

		$this->add_control(
				'mw_formassembly_field_bg_color_focus',
				array(
						'label'     => __( 'Background Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form input:focus, {{WRAPPER}} .mw-formassembly-form textarea:focus' => 'background-color: {{VALUE}}',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
						'name'        => 'mw_formassembly_focus_input_border',
						'label'       => __( 'Border', 'missingwidgets' ),
						'placeholder' => '1px',
						'default'     => '1px',
						'selector'    => '{{WRAPPER}} .mw-formassembly-form input:focus, {{WRAPPER}} .mw-formassembly-form textarea:focus',
				)
		);

		$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
						'name'      => 'mw_formassembly_focus_box_shadow',
						'selector'  => '{{WRAPPER}} .mw-formassembly-form input:focus, {{WRAPPER}} .mw-formassembly-form textarea:focus',
						'separator' => 'before',
				)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Style Tab: Field Description
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
				'mw_formassembly_section_field_description_style',
				array(
						'label'     => __( 'Field Description', 'missingwidgets' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'fa_iframe' => '',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_field_description_text_color',
				array(
						'label'     => __( 'Text Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
								'{{WRAPPER}}  .mw-formassembly-form .wForm,
		{{WRAPPER}}  .mw-formassembly-form .reviewHeader,
     {{WRAPPER}}  .mw-formassembly-form .reviewResponse,
     {{WRAPPER}}  .mw-formassembly-form .reviewFooter,
     {{WRAPPER}}  .mw-formassembly-form .htmlSection .htmlContent span,
     {{WRAPPER}}  .mw-formassembly-form .htmlSection .htmlContent,
     {{WRAPPER}}  .mw-formassembly-form fieldset > fieldset:last-child,
     {{WRAPPER}}  .mw-formassembly-form table.matrixLayout thead tr.headerRow th,
     {{WRAPPER}}  .mw-formassembly-form table.gridLayout thead tr.headerRow th,
     {{WRAPPER}}  .mw-formassembly-form table.matrixLayout thead tr th.headerCol,
     {{WRAPPER}}  .mw-formassembly-form table.gridLayout thead tr th.headerCol' => 'color: {{VALUE}}',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
						'name'     => 'mw_formassembly_field_description_typography',
						'label'    => __( 'Typography', 'missingwidgets' ),
						'selector' => '{{WRAPPER}}  .mw-formassembly-form .wForm,
		{{WRAPPER}}  .mw-formassembly-form .reviewHeader,
     {{WRAPPER}}  .mw-formassembly-form .reviewResponse,
     {{WRAPPER}}  .mw-formassembly-form .reviewFooter,
     {{WRAPPER}}  .mw-formassembly-form .htmlSection .htmlContent span,
     {{WRAPPER}}  .mw-formassembly-form .htmlSection .htmlContent,
     {{WRAPPER}}  .mw-formassembly-form fieldset > fieldset:last-child,
     {{WRAPPER}}  .mw-formassembly-form table.matrixLayout thead tr.headerRow th,
     {{WRAPPER}}  .mw-formassembly-form table.gridLayout thead tr.headerRow th,
     {{WRAPPER}}  .mw-formassembly-form table.matrixLayout thead tr th.headerCol,
     {{WRAPPER}}  .mw-formassembly-form table.gridLayout thead tr th.headerCol',
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_field_description_spacing',
				array(
						'label'      => __( 'Spacing', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'range'      => array(
								'px' => array(
										'min'  => 0,
										'max'  => 100,
										'step' => 1,
								),
						),
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}}  .mw-formassembly-form .wForm,
		{{WRAPPER}}  .mw-formassembly-form .reviewHeader,
     {{WRAPPER}}  .mw-formassembly-form .reviewResponse,
     {{WRAPPER}}  .mw-formassembly-form .reviewFooter,
     {{WRAPPER}}  .mw-formassembly-form .htmlSection .htmlContent span,
     {{WRAPPER}}  .mw-formassembly-form .htmlSection .htmlContent,
     {{WRAPPER}}  .mw-formassembly-form fieldset > fieldset:last-child,
     {{WRAPPER}}  .mw-formassembly-form table.matrixLayout thead tr.headerRow th,
     {{WRAPPER}}  .mw-formassembly-form table.gridLayout thead tr.headerRow th,
     {{WRAPPER}}  .mw-formassembly-form table.matrixLayout thead tr th.headerCol,
     {{WRAPPER}}  .mw-formassembly-form table.gridLayout thead tr th.headerCol' => 'padding-top: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Placeholder
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
				'mw_formassembly_section_placeholder_style',
				array(
						'label'     => __( 'Placeholder', 'missingwidgets' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'fa_iframe' => '',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_text_color_placeholder',
				array(
						'label'     => __( 'Text Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form input::-webkit-input-placeholder, {{WRAPPER}} .mw-formassembly-form textarea::-webkit-input-placeholder' => 'color: {{VALUE}}',
								'{{WRAPPER}} .mw-formassembly-form input::-moz-placeholder, {{WRAPPER}} .mw-formassembly-form textarea::-moz-placeholder'                   => 'color: {{VALUE}}',
						),
				)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Checkbox
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
				'mw_formassembly_section_checkbox_style',
				array(
						'label'     => __( 'Checkbox', 'missingwidgets' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'fa_iframe' => '',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_checkbox_size',
				array(
						'label'      => __( 'Size', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'default'    => array(
								'size' => '18',
								'unit' => 'px',
						),
						'range'      => array(
								'px' => array(
										'min'  => 0,
										'max'  => 80,
										'step' => 1,
								),
						),
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .oneChoice input[type="checkbox"]' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_checkbox_margin',
				array(
						'label'      => esc_html__( 'Margin', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .oneChoice input[type="checkbox"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Radio
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
				'section_radio_style',
				array(
						'label'     => __( 'Radio', 'missingwidgets' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'fa_iframe' => '',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_radio_size',
				array(
						'label'      => __( 'Size', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'default'    => array(
								'size' => '18',
								'unit' => 'px',
						),
						'range'      => array(
								'px' => array(
										'min'  => 0,
										'max'  => 80,
										'step' => 1,
								),
						),
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .wFormContainer .oneChoice input[type="radio"]' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_radio_margin',
				array(
						'label'      => esc_html__( 'Radio button margin', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .oneChoice input[type="radio"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Submit Button
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
				'mw_formassembly_section_submit_button_style',
				array(
						'label'     => __( 'Submit Button', 'missingwidgets' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'fa_iframe' => '',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_button_align',
				array(
						'label'     => __( 'Alignment', 'missingwidgets' ),
						'type'      => Controls_Manager::CHOOSE,
						'options'   => array(
								'left'   => array(
										'title' => __( 'Left', 'missingwidgets' ),
										'icon'  => 'eicon-h-align-left',
								),
								'center' => array(
										'title' => __( 'Center', 'missingwidgets' ),
										'icon'  => 'eicon-h-align-center',
								),
								'right'  => array(
										'title' => __( 'Right', 'missingwidgets' ),
										'icon'  => 'eicon-h-align-right',
								),
						),
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .actions .primaryAction,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton' => 'text-align: {{VALUE}};',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_button_width',
				array(
						'label'      => __( 'Width', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'default'    => array(
								'size' => '100',
								'unit' => '%',
						),
						'range'      => array(
								'px' => array(
										'min'  => 0,
										'max'  => 1200,
										'step' => 1,
								),
						),
						'size_units' => array( 'px', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .actions .primaryAction,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton' => 'width: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
						'name'      => 'mw_formassembly_button_typography',
						'label'     => __( 'Typography', 'missingwidgets' ),
						'scheme'    => Typography::TYPOGRAPHY_4,
						'selector'  => '{{WRAPPER}} .mw-formassembly-form .actions .primaryAction,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton',
						'separator' => 'before',
				)
		);

		$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
						'name'      => 'mw_formassembly_button_box_shadow',
						'selector'  => '{{WRAPPER}} .mw-formassembly-form .actions .primaryAction,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton',
						'separator' => 'before',
				)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
				'mw_formassembly_tab_button_normal',
				array(
						'label' => __( 'Normal', 'missingwidgets' ),
				)
		);

		$this->add_control(
				'mw_formassembly_button_bg_color_normal',
				array(
						'label'     => __( 'Background Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .actions .primaryAction,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton' => 'background-color: {{VALUE}}',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_button_text_color_normal',
				array(
						'label'     => __( 'Text Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .actions .primaryAction,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton' => 'color: {{VALUE}}',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
						'name'        => 'mw_formassembly_button_border_normal',
						'label'       => __( 'Border', 'missingwidgets' ),
						'placeholder' => '1px',
						'default'     => '1px',
						'selector'    => '{{WRAPPER}} .mw-formassembly-form .actions .primaryAction,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton',
				)
		);

		$this->add_control(
				'mw_formassembly_button_border_radius',
				array(
						'label'      => __( 'Border Radius', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .actions .primaryAction,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_button_padding',
				array(
						'label'      => __( 'Padding', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .actions .primaryAction,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->add_responsive_control(
				'mw_formassembly_button_margin',
				array(
						'label'      => __( 'Margin Top', 'missingwidgets' ),
						'type'       => Controls_Manager::SLIDER,
						'range'      => array(
								'px' => array(
										'min'  => 0,
										'max'  => 100,
										'step' => 1,
								),
						),
						'size_units' => array( 'px', 'em', '%' ),
						'selectors'  => array(
								'{{WRAPPER}} .mw-formassembly-form .actions .primaryAction,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton' => 'margin-top: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
				'mw_formassembly_tab_button_hover',
				array(
						'label' => __( 'Hover', 'missingwidgets' ),
				)
		);

		$this->add_control(
				'mw_formassembly_button_bg_color_hover',
				array(
						'label'     => __( 'Background Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .actions .primaryAction:hover,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton:hover,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton:hover' => 'background-color: {{VALUE}}',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_button_text_color_hover',
				array(
						'label'     => __( 'Text Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .actions .primaryAction:hover,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton:hover,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton:hover' => 'color: {{VALUE}}',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_button_border_color_hover',
				array(
						'label'     => __( 'Border Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .actions .primaryAction:hover,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPageNextButton:hover,
								{{WRAPPER}} .mw-formassembly-form .wfPagingButtons .wfPagePreviousButton:hover' => 'border-color: {{VALUE}}',
						),
				)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Style Tab: Errors
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
				'mw_formassembly_section_error_style',
				array(
						'label'     => __( 'Errors', 'missingwidgets' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'fa_iframe' => '',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_error_messages_heading',
				array(
						'label' => __( 'Error alert box', 'missingwidgets' ),
						'type'  => Controls_Manager::HEADING,
				)
		);

		$this->add_control(
				'mw_formassembly_error_message_text_color',
				array(
						'label'     => __( 'Text Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .errorMessage, {{WRAPPER}} .mw-formassembly-form a.errMsg' => 'color: {{VALUE}} !important',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_error_message_bg_color',
				array(
						'label'     => __( 'Background Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .errorMessage, {{WRAPPER}} .mw-formassembly-form a.errMsg' => 'background-color: {{VALUE}} !important',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_error_message_border_color',
				array(
						'label'     => __( 'Border Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .errorMessage, {{WRAPPER}} .mw-formassembly-form a.errMsg' => 'border-color: {{VALUE}} !important;',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
						'name'      => 'mw_formassembly_error_message_typography',
						'label'     => __( 'Typography', 'missingwidgets' ),
						'selector'  => '{{WRAPPER}} .mw-formassembly-form .errorMessage, {{WRAPPER}} .mw-formassembly-form a.errMsg',
						'separator' => 'before',
				)
		);

		$this->add_control(
				'mw_formassembly_validation_errors_heading',
				array(
						'label'     => __( 'Fields validation errors', 'missingwidgets' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
				)
		);

		$this->add_control(
				'ms_formidable_form_validation_error_text_color',
				array(
						'label'     => __( 'Field Errortext Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formidable-form .oneField.errFld .errMsg' => 'color: {{VALUE}} !important',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_validation_error_field_input_border_color',
				array(
						'label'     => __( 'Field Input Border Color', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .oneField.errFld .inputWrapper input[type="text"],
     {{WRAPPER}} .mw-formassembly-form .oneField.errFld .inputWrapper input[type="password"],
     {{WRAPPER}} .mw-formassembly-form .oneField.errFld .inputWrapper textarea,
     {{WRAPPER}} .mw-formassembly-form .oneField.errFld .inputWrapper select,
     {{WRAPPER}} .mw-formassembly-form .oneField.errFld .inputWrapper input[type="text"].required' => 'border-color: {{VALUE}} !important',
						),
				)
		);

		$this->add_control(
				'mw_formassembly_validation_error_field_input_border_width',
				array(
						'label'     => __( 'Field Input Border Width', 'missingwidgets' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 1,
						'min'       => 1,
						'max'       => 10,
						'step'      => 1,
						'selectors' => array(
								'{{WRAPPER}} .mw-formassembly-form .oneField.errFld .inputWrapper input[type="text"],
     {{WRAPPER}} .mw-formassembly-form .oneField.errFld .inputWrapper input[type="password"],
     {{WRAPPER}} .mw-formassembly-form .oneField.errFld .inputWrapper textarea,
     {{WRAPPER}} .mw-formassembly-form .oneField.errFld .inputWrapper select,
     {{WRAPPER}} .mw-formassembly-form .oneField.errFld .inputWrapper input[type="text"].required' => 'border-width: {{VALUE}}px !important',
						),
				)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render(): void {
		$settings   = (array) $this->get_settings_for_display();
		$host_url   = strval( $settings['fa_url'] ?? 'https://app.formassembly.com' );
		$fa_id      = strval( $settings['fa_id'] ?? '' );
		$action_url = strval( $settings['fa_type'] ?? '' ) === 'workflow' ? 'workflows/start' : 'forms/view';
		$iframe     = strval( $settings['fa_iframe'] ?? 'no' ) === 'yes';
		$fa_fields  = strval( $settings['fa_fields'] ) !== '' ? explode( ',', strval( $settings['fa_fields'] ) ) : array();
		$fa_params  = '';
		if ( ! empty( $fa_fields ) && isset( $_SERVER['REQUEST_URI'] ) ) {
			$url_components = \wp_parse_url( $_SERVER['REQUEST_URI'] ); //phpcs:ignore
			if ( array_key_exists( 'query', $url_components ) ) {
				$params = array();
				\parse_str( \wp_unslash( $url_components['query'] ), $params );
				$params_result = array();
				if ( count( $params ) > 0 ) {
					foreach ( $fa_fields as $field ) {
						if ( array_key_exists( $field, $params ) ) {
							$params_result[] = wp_strip_all_tags( $field ) . '=' . rawurlencode( wp_strip_all_tags( $params[ $field ] ) );
						}
					}
					if ( ! empty( $params_result ) ) {
						$fa_params = '/?' . implode( '&', $params_result );
					}
				}
			}
		}
		if ( ! empty( $fa_id ) && ! empty( $host_url ) ) {
			if ( $iframe ) {
				$this->add_render_attribute( 'iframe-style', 'style', strval( $settings['fa_iframe_style'] ?? '' ) );
				$this->add_render_attribute(
						'iframe-src',
						'src',
						esc_url( $host_url . '/' . $action_url . '/' . $fa_id . $fa_params )
				);
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '<iframe ' . $this->get_render_attribute_string( 'iframe-style' ) . $this->get_render_attribute_string( 'iframe-src' ) . '"></iframe>';
			} else {
				$form_url = esc_url( $host_url . '/rest/' . $action_url . '/' . $fa_id . $fa_params );
				$response = wp_remote_get( $form_url );
				/* If WP_Error, throw exception */
				if ( is_wp_error( $response ) ) {
					echo esc_html( 'Form request failed. :' . $response->get_error_message() );
				}
				$this->add_render_attribute(
						'formassembly-form',
						'class',
						array(
								'mw-form',
								'mw-formassembly-form',
						)
				); ?>
				<div
						<?php
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo $this->get_render_attribute_string( 'formassembly-form' );
						?>
				>
					<?php
					//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo wp_remote_retrieve_body( $response );
					?>
				</div>
				<?php
			}
		}
	}

	/**
	 * Render widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since  2.9.0
	 * @access protected
	 */
	protected function content_template(): void {
	}
}
