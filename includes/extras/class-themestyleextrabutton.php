<?php

namespace MissingWidgets\Extras;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

class Theme_Style_Extra_Button extends Tab_Base {

	public function get_id(): string {
		return 'themestyleextrabuttons';
	}

	public function get_title(): string {
		return __( 'Styling button types', 'missingwidgets' );
	}

	public function get_group(): string {
		return 'theme-style';
	}

	public function get_icon(): string {
		return 'eicon-button';
	}

	public function get_help_url(): string {
		return 'https://missingwidgets.com/missing-elementor-widgets-features/extra-styling-elementor-button-widget/';
	}

	protected function register_tab_controls(): void {
		$button_items = array( 'info', 'success', 'warning', 'danger' );
		foreach ( $button_items as $button_item ) {
			$button_selectors = array(
				'{{WRAPPER}} .elementor-button-' . $button_item . ' .elementor-button',
			);

			$button_hover_selectors = array(
				'{{WRAPPER}} .elementor-button-' . $button_item . ' .elementor-button:hover',
				'{{WRAPPER}} .elementor-button-' . $button_item . ' .elementor-button:focus',
			);
			$button_selector        = implode( ',', $button_selectors );
			$button_hover_selector  = implode( ',', $button_hover_selectors );
			$button_label           = ucfirst( $button_item ) . ' type button';
			$this->start_controls_section(
				'section_buttons' . $button_item,
				array(
					'label' => __( $button_label, 'elementor' ), //phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
					'tab'   => $this->get_id(),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'label'    => __( 'Typography', 'elementor' ),
					'name'     => 'button_' . $button_item . '_typography',
					'selector' => $button_selector,
				)
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				array(
					'name'     => 'button_' . $button_item . '_text_shadow',
					'selector' => $button_selector,
				)
			);

			$this->start_controls_tabs( 'tabs_button_' . $button_item . '_style' );
			$this->start_controls_tab(
				'tab_button_' . $button_item,
				array(
					'label' => __( 'Normal', 'elementor' ),
				)
			);

			$this->add_control(
				'button_' . $button_item . '_text_color',
				array(
					'label'     => __( 'Text Color', 'elementor' ),
					'type'      => Controls_Manager::COLOR,
					'dynamic'   => array(),
					'selectors' => array(
						$button_selector => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'button_' . $button_item . '_background_color',
				array(
					'label'     => __( 'Background Color', 'elementor' ),
					'type'      => Controls_Manager::COLOR,
					'dynamic'   => array(),
					'selectors' => array(
						$button_selector => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'button_' . $button_item . '_box_shadow',
					'selector' => $button_selector,
				)
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'           => 'button_' . $button_item . '_border',
					'selector'       => $button_selector,
					'fields_options' => array(
						'color' => array(
							'dynamic' => array(),
						),
					),
				)
			);

			$this->add_control(
				'button_' . $button_item . '_border_radius',
				array(
					'label'      => __( 'Border Radius', 'elementor' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						$button_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'tab_button_' . $button_item . '_hover',
				array(
					'label' => __( 'Hover', 'elementor' ),
				)
			);

			$this->add_control(
				'button_' . $button_item . '_hover_text_color',
				array(
					'label'     => __( 'Text Color', 'elementor' ),
					'type'      => Controls_Manager::COLOR,
					'dynamic'   => array(),
					'selectors' => array(
						$button_hover_selector => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'button_' . $button_item . '_hover_background_color',
				array(
					'label'     => __( 'Background Color', 'elementor' ),
					'type'      => Controls_Manager::COLOR,
					'dynamic'   => array(),
					'selectors' => array(
						$button_hover_selector => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'button_' . $button_item . '_hover_box_shadow',
					'selector' => $button_hover_selector,
				)
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'           => 'button_' . $button_item . '_hover_border',
					'selector'       => $button_hover_selector,
					'fields_options' => array(
						'color' => array(
							'dynamic' => array(),
						),
					),
				)
			);

			$this->add_control(
				'button_' . $button_item . '_hover_border_radius',
				array(
					'label'      => __( 'Border Radius', 'elementor' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						$button_hover_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'button_' . $button_item . '_padding',
				array(
					'label'      => __( 'Padding', 'elementor' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						$button_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'separator'  => 'before',
				)
			);

			$this->end_controls_section();

		}
	}
}
