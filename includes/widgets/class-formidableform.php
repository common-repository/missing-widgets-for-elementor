<?php declare( strict_types = 1 );

namespace MissingWidgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use FrmForm;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Formidable Form widget for displaying forms
 *
 * @see     https://formidableforms.com/knowledgebase/publish-a-form/#kb-parameters
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class Formidable_Form extends Widget_Base {

	public function get_name(): string {
		return 'missingwidgets-formidableforms';
	}

	public function get_title(): string {
		return __( 'Formidable Forms', 'missingwidgets' );
	}

	public function get_icon(): string {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return array( 'general' );
	}

	public function get_keywords() {
		return array( 'form', 'formidable', 'forms', 'missing', 'widgets', 'missingwidgets' );
	}

	public function get_custom_help_url(): string {
		return 'https://missingwidgets.com/missing-widgets-features/elementor-formidable-forms-widgets/';
	}

	public function get_style_depends() {
		return array( 'formidable' );
	}

	public static function get_form_options(): array {
		if ( ! class_exists( 'FrmForm' ) ) {
			return array();
		}
		$forms   = FrmForm::getAll();
		$options = array();
		foreach ( $forms as $form ) {
			$options[ $form->id ] = $form->name;
		}

		return $options;
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'content_basic',
			array(
				'label' => __( 'Form settings', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'form_id',
			array(
				'label'       => __( 'Formidable form', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'options'     => self::get_form_options(),
			)
		);

		$this->add_control(
			'form_edit_button',
			array(
				'label'       => __( 'Edit form', 'missingwidgets' ),
				'show_label'  => false,
				'label_block' => true,
				'type'        => Controls_Manager::BUTTON,
				'text'        => 'Edit formidable form',
				'event'       => 'ms_formidable_form_edit',
			)
		);

		$this->add_control(
			'form_divider',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'form_show_title',
			array(
				'label'   => __( 'Show form title', 'missingwidgets' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'form_show_description',
			array(
				'label'   => __( 'Show form description', 'missingwidgets' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			)
		);

		$this->add_control(
			'form_minimize_html',
			array(
				'label'       => __( 'Minimize form HTML', 'missingwidgets' ),
				'description' => __( 'This will remove extra white space in your form HTML that is added if your form is double-filtered by another plugin or your theme.', 'missingwidgets' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
			)
		);

		$this->add_control(
			'form_include_fields',
			array(
				'label'       => __( 'Include fields', 'missingwidgets' ),
				'label_block' => true,
				'description' => __( 'Specify which fields to include in your form. Use a comma-separated list of field keys or ids.', 'missingwidgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			)
		);

		$this->add_control(
			'form_exclude_fields',
			array(
				'label'       => __( 'Exclude fields', 'missingwidgets' ),
				'label_block' => true,
				'description' => __( 'Exclude specific fields from your form. Use a comma-separated list of field keys or ids.', 'missingwidgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
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
				'label' => __( 'Form Container', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'ms_formidable_form_background',
			array(
				'label'     => esc_html__( 'Form Background Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_form_fields > fieldset' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_alignment',
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
					'{{WRAPPER}} .mw-formidable-form'      => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .mw-formidable-form form' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_width',
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
					'{{WRAPPER}} .mw-formidable-form .frm_forms' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_max_width',
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
					'{{WRAPPER}} .mw-formidable-form .frm_forms' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_margin',
			array(
				'label'      => esc_html__( 'Form Margin', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_form_fields > fieldset' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_padding',
			array(
				'label'      => esc_html__( 'Form Padding', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_form_fields > fieldset' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_form_fields > fieldset' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'ms_formidable_form_border',
				'selector' => '{{WRAPPER}} .mw-formidable-form .frm_form_fields > fieldset',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'ms_formidable_form_box_shadow',
				'selector' => '{{WRAPPER}} .mw-formidable-form .frm_form_fields > fieldset',
			)
		);

		$this->end_controls_section();
		/**
		 * Style Tab: Title and Description
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'ms_formidable_form_section_title_description_style',
			array(
				'label' => __( 'Title & Description', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_heading_alignment',
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
					'{{WRAPPER}} .mw-formidable-form legend + h3 , {{WRAPPER}} .mw-formidable-form h3.frm_form_title, {{WRAPPER}} .mw-formidable-form legend + h3' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .mw-formidable-form fieldset > div.frm_description, {{WRAPPER}} .mw-formidable-form fieldset > div.frm_description p' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_title_heading',
			array(
				'label'     => __( 'Title', 'missingwidgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'ms_formidable_form_title_text_color',
			array(
				'label'     => __( 'Text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form legend + h3 , {{WRAPPER}} .mw-formidable-form h3.frm_form_title, {{WRAPPER}} .mw-formidable-form legend + h3' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'ms_formidable_form_title_typography',
				'label'    => __( 'Typography', 'missingwidgets' ),
				'scheme'   => Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .mw-formidable-form legend + h3 , {{WRAPPER}} .mw-formidable-form h3.frm_form_title, {{WRAPPER}} .mw-formidable-form legend + h3',
			)
		);

		$this->add_control(
			'ms_formidable_form_description_heading',
			array(
				'label'     => __( 'Description', 'missingwidgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'ms_formidable_form_description_text_color',
			array(
				'label'     => __( 'Text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form fieldset > div.frm_description p' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'ms_formidable_form_description_typography',
				'label'    => __( 'Typography', 'missingwidgets' ),
				'scheme'   => Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .mw-formidable-form fieldset > div.frm_description p',
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Labels
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'ms_formidable_form_section_label_style',
			array(
				'label' => __( 'Labels', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'ms_formidable_form_text_color_label',
			array(
				'label'     => __( 'Text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_form_field .frm_primary_label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'ms_formidable_form_typography_label',
				'label'    => __( 'Typography', 'missingwidgets' ),
				'selector' => '{{WRAPPER}} .mw-formidable-form .frm_form_field .frm_primary_label',
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Input & Textarea & Select
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'ms_formidable_form_section_fields_style',
			array(
				'label' => __( 'Input & Textarea & Select', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_input_alignment',
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
					'{{WRAPPER}} .mw-formidable-form input[type="text"],{{WRAPPER}} .mw-formidable-form input[type="password"], {{WRAPPER}} .mw-formidable-form input[type="email"], {{WRAPPER}} .mw-formidable-form input[type="number"], {{WRAPPER}} .mw-formidable-form input[type="url"], {{WRAPPER}} .mw-formidable-form input[type="tel"], {{WRAPPER}} .mw-formidable-form input[type="file"], {{WRAPPER}} .mw-formidable-form input[type="search"], {{WRAPPER}} .mw-formidable-form textarea, {{WRAPPER}} .mw-formidable-form select' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_fields_style' );

		$this->start_controls_tab(
			'ms_formidable_form_tab_fields_normal',
			array(
				'label' => __( 'Normal', 'missingwidgets' ),
			)
		);

		$this->add_control(
			'ms_formidable_form_field_bg_color',
			array(
				'label'     => __( 'Background Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form input[type="text"],{{WRAPPER}} .mw-formidable-form input[type="password"], {{WRAPPER}} .mw-formidable-form input[type="email"], {{WRAPPER}} .mw-formidable-form input[type="number"], {{WRAPPER}} .mw-formidable-form input[type="url"], {{WRAPPER}} .mw-formidable-form input[type="tel"], {{WRAPPER}} .mw-formidable-form input[type="file"], {{WRAPPER}} .mw-formidable-form input[type="search"], {{WRAPPER}} .mw-formidable-form textarea, {{WRAPPER}} .mw-formidable-form select' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_field_text_color',
			array(
				'label'     => __( 'Text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form input[type="text"],{{WRAPPER}} .mw-formidable-form input[type="password"], {{WRAPPER}} .mw-formidable-form input[type="email"], {{WRAPPER}} .mw-formidable-form input[type="number"], {{WRAPPER}} .mw-formidable-form input[type="url"], {{WRAPPER}} .mw-formidable-form input[type="tel"], {{WRAPPER}} .mw-formidable-form input[type="file"], {{WRAPPER}} .mw-formidable-form input[type="search"], {{WRAPPER}} .mw-formidable-form textarea, {{WRAPPER}} .mw-formidable-form select' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_field_spacing',
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
					'{{WRAPPER}} .mw-formidable-form .form-field' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_field_spacing_right',
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
					'{{WRAPPER}} .mw-formidable-form .form-field' => 'padding-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_field_padding',
			array(
				'label'      => __( 'Padding', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form input:not([type="radio"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]):not([type="image"]):not([type="file"]), {{WRAPPER}} .mw-formidable-form textarea, {{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_text_indent',
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
					'{{WRAPPER}} .mw-formidable-form input[type="text"],{{WRAPPER}} .mw-formidable-form input[type="password"], {{WRAPPER}} .mw-formidable-form input[type="email"], {{WRAPPER}} .mw-formidable-form input[type="number"], {{WRAPPER}} .mw-formidable-form input[type="url"], {{WRAPPER}} .mw-formidable-form input[type="tel"], {{WRAPPER}} .mw-formidable-form input[type="file"], {{WRAPPER}} .mw-formidable-form input[type="search"], {{WRAPPER}} .mw-formidable-form textarea, {{WRAPPER}} .mw-formidable-form select' => 'text-indent: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_input_height',
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
					'{{WRAPPER}} .mw-formidable-form input[type="text"],{{WRAPPER}} .mw-formidable-form input[type="password"], {{WRAPPER}} .mw-formidable-form input[type="email"], {{WRAPPER}} .mw-formidable-form input[type="number"], {{WRAPPER}} .mw-formidable-form input[type="url"], {{WRAPPER}} .mw-formidable-form input[type="tel"], {{WRAPPER}} .mw-formidable-form input[type="file"], {{WRAPPER}} .mw-formidable-form input[type="search"]' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_select_height',
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
					'{{WRAPPER}} .mw-formidable-form select' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'ms_formidable_form_field_border',
				'label'       => __( 'Border', 'missingwidgets' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .mw-formidable-form input[type="text"],{{WRAPPER}} .mw-formidable-form input[type="password"], {{WRAPPER}} .mw-formidable-form input[type="email"], {{WRAPPER}} .mw-formidable-form input[type="number"], {{WRAPPER}} .mw-formidable-form input[type="url"], {{WRAPPER}} .mw-formidable-form input[type="tel"], {{WRAPPER}} .mw-formidable-form input[type="file"], {{WRAPPER}} .mw-formidable-form input[type="search"], {{WRAPPER}} .mw-formidable-form textarea, {{WRAPPER}} .mw-formidable-form select',
				'separator'   => 'before',
			)
		);

		$this->add_control(
			'ms_formidable_form_field_radius',
			array(
				'label'      => __( 'Border Radius', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form input[type="text"],{{WRAPPER}} .mw-formidable-form input[type="password"], {{WRAPPER}} .mw-formidable-form input[type="email"], {{WRAPPER}} .mw-formidable-form input[type="number"], {{WRAPPER}} .mw-formidable-form input[type="url"], {{WRAPPER}} .mw-formidable-form input[type="tel"], {{WRAPPER}} .mw-formidable-form input[type="file"], {{WRAPPER}} .mw-formidable-form input[type="search"], {{WRAPPER}} .mw-formidable-form textarea, {{WRAPPER}} .mw-formidable-form select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'ms_formidable_form_field_typography',
				'label'     => __( 'Typography', 'missingwidgets' ),
				'selector'  => '{{WRAPPER}} .mw-formidable-form input[type="text"],{{WRAPPER}} .mw-formidable-form input[type="password"], {{WRAPPER}} .mw-formidable-form input[type="email"], {{WRAPPER}} .mw-formidable-form input[type="number"], {{WRAPPER}} .mw-formidable-form input[type="url"], {{WRAPPER}} .mw-formidable-form input[type="tel"], {{WRAPPER}} .mw-formidable-form input[type="file"], {{WRAPPER}} .mw-formidable-form input[type="search"], {{WRAPPER}} .mw-formidable-form textarea, {{WRAPPER}} .mw-formidable-form select',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'ms_formidable_form_field_box_shadow',
				'selector'  => '{{WRAPPER}} .mw-formidable-form input[type="text"],{{WRAPPER}} .mw-formidable-form input[type="password"], {{WRAPPER}} .mw-formidable-form input[type="email"], {{WRAPPER}} .mw-formidable-form input[type="number"], {{WRAPPER}} .mw-formidable-form input[type="url"], {{WRAPPER}} .mw-formidable-form input[type="tel"], {{WRAPPER}} .mw-formidable-form input[type="file"], {{WRAPPER}} .mw-formidable-form input[type="search"], {{WRAPPER}} .mw-formidable-form textarea, {{WRAPPER}} .mw-formidable-form select',
				'separator' => 'before',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ms_formidable_form_tab_fields_focus',
			array(
				'label' => __( 'Focus', 'missingwidgets' ),
			)
		);

		$this->add_control(
			'ms_formidable_form_field_bg_color_focus',
			array(
				'label'     => __( 'Background Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form input:focus, {{WRAPPER}} .mw-formidable-form textarea:focus' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'ms_formidable_form_focus_input_border',
				'label'       => __( 'Border', 'missingwidgets' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .mw-formidable-form input:focus, {{WRAPPER}} .mw-formidable-form textarea:focus',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'ms_formidable_form_focus_box_shadow',
				'selector'  => '{{WRAPPER}} .mw-formidable-form input:focus, {{WRAPPER}} .mw-formidable-form textarea:focus',
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
			'ms_formidable_form_section_field_description_style',
			array(
				'label' => __( 'Field Description', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'ms_formidable_form_field_description_text_color',
			array(
				'label'     => __( 'Text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_form_field .frm_description' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'ms_formidable_form_field_description_typography',
				'label'    => __( 'Typography', 'missingwidgets' ),
				'selector' => '{{WRAPPER}} .mw-formidable-form .frm_form_field .frm_description',
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_field_description_spacing',
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
					'{{WRAPPER}} .mw-formidable-form .frm_form_field .frm_description' => 'padding-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Section Field
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'ms_formidable_form_section_field_style',
			array(
				'label' => __( 'Section Field', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'ms_formidable_form_section_field_text_color',
			array(
				'label'     => __( 'Text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_section_heading h3' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'ms_formidable_form_section_field_typography',
				'label'     => __( 'Typography', 'missingwidgets' ),
				'scheme'    => Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .mw-formidable-form .frm_section_heading h3',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'ms_formidable_form_section_field_border_type',
			array(
				'label'     => __( 'Border Type', 'missingwidgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => __( 'None', 'missingwidgets' ),
					'solid'  => __( 'Solid', 'missingwidgets' ),
					'double' => __( 'Double', 'missingwidgets' ),
					'dotted' => __( 'Dotted', 'missingwidgets' ),
					'dashed' => __( 'Dashed', 'missingwidgets' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_section_heading' => 'border-bottom-style: {{VALUE}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_section_field_border_height',
			array(
				'label'      => __( 'Border Height', 'missingwidgets' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 1,
				),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_section_heading' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'section_field_border_type!' => 'none',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_section_field_border_color',
			array(
				'label'     => __( 'Border Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_section_heading' => 'border-bottom-color: {{VALUE}}',
				),
				'condition' => array(
					'section_field_border_type!' => 'none',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_section_field_margin',
			array(
				'label'      => __( 'Margin', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_section_heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Placeholder
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'ms_formidable_form_section_placeholder_style',
			array(
				'label' => __( 'Placeholder', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'ms_formidable_form_text_color_placeholder',
			array(
				'label'     => __( 'Text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form input::-webkit-input-placeholder, {{WRAPPER}} .mw-formidable-form textarea::-webkit-input-placeholder' => 'color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form input::-moz-placeholder, {{WRAPPER}} .mw-formidable-form textarea::-moz-placeholder' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Checkbox
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'ms_formidable_form_section_checkbox_style',
			array(
				'label' => __( 'Checkbox', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_checkbox_style',
			array(
				'label'     => __( 'Style', 'missingwidgets' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'inline' => array(
						'title' => __( 'Single line', 'missingwidgets' ),
						'icon'  => 'eicon-navigation-horizontal',
					),
					'block'  => array(
						'title' => __( 'Multiple lines', 'missingwidgets' ),
						'icon'  => 'eicon-navigation-vertical',
					),
				),
				'default'   => 'block',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_checkbox, {{WRAPPER}} .mw-formidable-form .frm_checkbox label' => 'display: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_checkbox_size',
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
					'{{WRAPPER}} .mw-formidable-form .frm_checkbox input[type="checkbox"]' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_checkbox_font_size',
			array(
				'label'      => __( 'Check Size', 'missingwidgets' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '12',
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
					'{{WRAPPER}} .mw-formidable-form .frm_checkbox input[type="checkbox"]:before' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_checkbox_margin_item',
			array(
				'label'      => esc_html__( 'Margin', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_checkbox' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'ms_formidable_form_checkbox_typography',
				'label'     => __( 'Typography', 'missingwidgets' ),
				'scheme'    => Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .mw-formidable-form .frm_checkbox label',
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_checkbox_style' );

		$this->start_controls_tab(
			'ms_formidable_form_checkbox_normal',
			array(
				'label' => __( 'Normal', 'missingwidgets' ),
			)
		);

		$this->add_control(
			'ms_formidable_form_checkbox_color',
			array(
				'label'     => __( 'Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_checkbox input[type="checkbox"]' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_checkbox_border_width',
			array(
				'label'      => __( 'Border Width', 'missingwidgets' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 15,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_checkbox input[type="checkbox"]' => 'border-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_checkbox_border_color',
			array(
				'label'     => __( 'Border Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_checkbox input[type="checkbox"]' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_checkbox_heading',
			array(
				'label' => __( 'Checkbox', 'missingwidgets' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'ms_formidable_form_checkbox_border_radius',
			array(
				'label'      => __( 'Border Radius', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_checkbox input[type="checkbox"], {{WRAPPER}} .mw-formidable-form .frm_checkbox input[type="checkbox"]:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_checkbox_margin',
			array(
				'label'      => esc_html__( 'Margin', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_checkbox input[type="checkbox"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ms_formidable_form_checkbox_checked',
			array(
				'label' => __( 'Checked', 'missingwidgets' ),
			)
		);

		$this->add_control(
			'ms_formidable_form_checkbox_color_checked',
			array(
				'label'     => __( 'Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_checkbox input[type="checkbox"]:checked:before' => 'box-shadow: none; background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Style Tab: Radio
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_radio_style',
			array(
				'label' => __( 'Radio', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_radio_style',
			array(
				'label'     => __( 'Style', 'missingwidgets' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'inline' => array(
						'title' => __( 'Single line', 'missingwidgets' ),
						'icon'  => 'eicon-navigation-horizontal',
					),
					'block'  => array(
						'title' => __( 'Multiple lines', 'missingwidgets' ),
						'icon'  => 'eicon-navigation-vertical',
					),
				),
				'default'   => 'block',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_radio, {{WRAPPER}} .mw-formidable-form .frm_radio label' => 'display: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_radio_size',
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
					'{{WRAPPER}} .mw-formidable-form .frm_radio input[type="radio"]' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_radio_font_size',
			array(
				'label'      => __( 'Check Size', 'missingwidgets' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '12',
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
					'{{WRAPPER}} .mw-formidable-form .frm_radio input[type="radio"]:checked:before' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_radio_margin_item',
			array(
				'label'      => esc_html__( 'Margin', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_radio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'ms_formidable_form_radio_typography',
				'label'     => __( 'Typography', 'missingwidgets' ),
				'scheme'    => Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .mw-formidable-form .frm_radio label',
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_radio_style' );

		$this->start_controls_tab(
			'ms_formidable_form_radio_normal',
			array(
				'label' => __( 'Normal', 'missingwidgets' ),
			)
		);

		$this->add_control(
			'ms_formidable_form_radio_color',
			array(
				'label'     => __( 'Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_radio input[type="radio"]' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_radio_border_width',
			array(
				'label'      => __( 'Border Width', 'missingwidgets' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 15,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_radio input[type="radio"]' => 'border-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_radio_border_color',
			array(
				'label'     => __( 'Border Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_radio input[type="radio"]' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_radio_heading',
			array(
				'label' => __( 'Radio Buttons', 'missingwidgets' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'ms_formidable_form_radio_border_radius',
			array(
				'label'      => __( 'Border Radius', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_radio input[type="radio"], {{WRAPPER}} .mw-formidable-form .frm_radio input[type="radio"]:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_radio_margin',
			array(
				'label'      => esc_html__( 'Radio button margin', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_radio input[type="radio"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ms_formidable_form_radio_checked',
			array(
				'label' => __( 'Checked', 'missingwidgets' ),
			)
		);

		$this->add_control(
			'ms_formidable_form_radio_color_checked',
			array(
				'label'     => __( 'Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_radio input[type="radio"]:checked:before' => 'box-shadow: none; background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Style Tab: Submit Button
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'ms_formidable_form_section_submit_button_style',
			array(
				'label' => __( 'Submit Button', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_button_align',
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
					'{{WRAPPER}} .mw-formidable-form .frm_submit' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_button_width',
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
					'{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'ms_formidable_form_tab_button_normal',
			array(
				'label' => __( 'Normal', 'missingwidgets' ),
			)
		);

		$this->add_control(
			'ms_formidable_form_button_bg_color_normal',
			array(
				'label'     => __( 'Background Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_button_text_color_normal',
			array(
				'label'     => __( 'Text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'ms_formidable_form_button_border_normal',
				'label'       => __( 'Border', 'missingwidgets' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit',
			)
		);

		$this->add_control(
			'ms_formidable_form_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_button_padding',
			array(
				'label'      => __( 'Padding', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ms_formidable_form_button_margin',
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
					'{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ms_formidable_form_tab_button_hover',
			array(
				'label' => __( 'Hover', 'missingwidgets' ),
			)
		);

		$this->add_control(
			'ms_formidable_form_button_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_button_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_button_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'ms_formidable_form_button_typography',
				'label'     => __( 'Typography', 'missingwidgets' ),
				'scheme'    => Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'ms_formidable_form_button_box_shadow',
				'selector'  => '{{WRAPPER}} .mw-formidable-form .frm_submit .frm_button_submit',
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Errors
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'ms_formidable_form_section_error_style',
			array(
				'label' => __( 'Errors', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'ms_formidable_form_error_messages_heading',
			array(
				'label' => __( 'Error alert box', 'missingwidgets' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'ms_formidable_form_error_message_text_color',
			array(
				'label'     => __( 'Text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_error_style' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_error_message_bg_color',
			array(
				'label'     => __( 'Background Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_error_style' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_error_message_border_color',
			array(
				'label'     => __( 'Border Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_error_style' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'ms_formidable_form_error_message_typography',
				'label'     => __( 'Typography', 'missingwidgets' ),
				'selector'  => '{{WRAPPER}} .mw-formidable-form .frm_error_style',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'ms_formidable_form_validation_errors_heading',
			array(
				'label'     => __( 'Fields validation errors', 'missingwidgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'ms_formidable_form_validation_error_field_label_color',
			array(
				'label'     => __( 'Field Label Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_form_field.frm_blank_field label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_validation_error_field_input_border_color',
			array(
				'label'     => __( 'Field Input Border Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="text"]' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="password"]' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="url"]' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="tel"]' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="number"]' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="email"]' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field textarea' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .mce-edit-area iframe' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field select:not(.ui-datepicker-month):not(.ui-datepicker-year)' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .frm_form_fields_error_style' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .frm-g-recaptcha iframe' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .g-recaptcha iframe' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .frm-card-element.StripeElement' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .chosen-container-multi .chosen-choices' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .chosen-container-single .chosen-single' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .mw-formidable-form .frm_form_field :invalid' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_validation_error_field_input_border_width',
			array(
				'label'     => __( 'Field Input Border Width', 'missingwidgets' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="text"]' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="password"]' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="url"]' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="tel"]' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="number"]' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field input[type="email"]' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field textarea' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .mce-edit-area iframe' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field select:not(.ui-datepicker-month):not(.ui-datepicker-year)' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .frm_form_fields_error_style' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .frm-g-recaptcha iframe' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .g-recaptcha iframe' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .frm-card-element.StripeElement' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .chosen-container-multi .chosen-choices' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_blank_field .chosen-container-single .chosen-single' => 'border-width: {{VALUE}}px',
					'{{WRAPPER}} .mw-formidable-form .frm_form_field :invalid' => 'border-width: {{VALUE}}px',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_validation_error_description_color',
			array(
				'label'     => __( 'Description Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_error' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Thank You Message
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'ms_formidable_form_thank_you_style',
			array(
				'label' => __( 'Thank You Message', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'ms_formidable_form_thank_you_message_text_color',
			array(
				'label'     => __( 'Text Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_message, {{WRAPPER}} .mw-formidable-form .frm_message p' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_thank_you_message_bg_color',
			array(
				'label'     => __( 'Background Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_message' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'ms_formidable_form_thank_you_message_border_color',
			array(
				'label'     => __( 'Border Color', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mw-formidable-form .frm_message' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'ms_formidable_thank_you_message_typography',
				'label'     => __( 'Typography', 'missingwidgets' ),
				'selector'  => '{{WRAPPER}} .mw-formidable-form .frm_message',
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = (array) $this->get_settings_for_display();
		$form_id  = intval( $settings['form_id'] ?? 0 );
		$this->add_render_attribute(
			'formidable-form',
			'class',
			array(
				'mw-form',
				'mw-formidable-form',
			)
		);
		if ( $form_id > 0 ) {
			// Check the settings for loading the styling.
			$frm_settings = \FrmAppHelper::get_settings(); // @phpstan-ignore-line
			if ( $frm_settings->load_style === 'dynamic' ) {
				\FrmStylesController::enqueue_style(); // @phpstan-ignore-line
			} ?>
			<div <?php echo $this->get_render_attribute_string( 'formidable-form' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $this->run_shortcode(
					'formidable',
					array_filter( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						array(
							'id'             => $form_id,
							'title'          => strval( $settings['form_show_title'] ) === 'yes' ? '1' : null,
							'description'    => strval( $settings['form_show_description'] ) === 'yes' ? '1' : null,
							'minimize'       => strval( $settings['form_minimize_html'] ) === 'yes' ? '1' : null,
							'fields'         => esc_attr( strval( $settings['form_include_fields'] ?? '' ) ),
							'exclude_fields' => esc_attr( strval( $settings['form_exclude_fields'] ?? '' ) ),
						)
					)
				);
				?>
			</div>
			<?php
		}
	}

	public function run_shortcode( string $tag, array $attr = array(), string $content = '' ): string {
		global $shortcode_tags;
		if ( array_key_exists( $tag, $shortcode_tags ) ) {
			return strval( call_user_func( $shortcode_tags[ $tag ], $attr, $content, $tag ) );
		}

		return '';
	}
}
