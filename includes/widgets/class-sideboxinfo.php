<?php

declare( strict_types = 1 );

namespace MissingWidgets\Widgets;

use Elementor\Core\Base\Document;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use MissingWidgets\Core;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SideBoxInfo extends Widget_Base {
	public function get_name(): string {
		return 'information_sidebox';
	}

	public function get_title(): string {
		return _x( 'Information sidebox', 'missingwidgets' );
	}

	public function get_icon(): string {
		return 'eicon-info-box';
	}

	public function get_categories(): array {
		return array( 'general' );
	}

	public function get_custom_help_url(): string {
		return 'https://missingwidgets.com/missing-widgets-features/elementor-sidebox-information-widget/';
	}

	public function get_keywords(): array {
		return array(
				'info',
				'side',
				'fixed',
				'information',
				'box',
		);
	}

	protected function register_controls(): void {
		$this->start_controls_section( 'title_settings', array(
				'label' => _x( 'Title', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
		) );
		$this->add_control( 'title_text', array(
				'label'       => __( 'Text title', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Information', 'missingwidgets' ),
		) );
		$this->end_controls_section();

		$this->start_controls_section(
				'section_template_content',
				array(
						'label' => __( 'Template', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_CONTENT,
				)
		);

		$document_types = Plugin::instance()->documents->get_document_types( array(
				'show_in_library' => true,
		) );

		$this->add_control(
				'template_id',
				array(
						'label'        => esc_html__( 'Choose Template', 'missingwidgets' ),
						'type'         => \ElementorPro\Modules\QueryControl\Module::QUERY_CONTROL_ID,
						'label_block'  => true,
						'autocomplete' => array(
								'object' => \ElementorPro\Modules\QueryControl\Module::QUERY_OBJECT_LIBRARY_TEMPLATE,
								'query'  => array(
										'meta_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
												array(
														'key'     => Document::TYPE_META_KEY,
														'value'   => array_keys( $document_types ),
														'compare' => 'IN',
												),
										), // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
								),
						),
				)
		);

		$this->end_controls_section();

		$this->start_controls_section(
				'section_box_style',
				array(
						'label' => __( 'Box', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_CONTENT,
				)
		);

		$infobox_position_args = array(
				'label'   => __( 'Position', 'missingwidgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'infoboxleft',
		);

		$infobox_position_extra_args = array();

		if ( \missingwidgets_fs()->can_use_premium_code__premium_only() ) {
			$infobox_position_extra_args = array(
					'options' => array(
							'infoboxleft'  => __( 'Left', 'missingwidgets' ),
							'infoboxright' => __( 'Right', 'missingwidgets' ),
					),
			);
		}

		if ( \missingwidgets_fs()->is_not_paying() ) {
			$infobox_position_extra_args = array(
					'description' => Core::freeplan_upgrade_description( 'premium_options',
							self::get_custom_help_url() ),
					'options'     => array(
							'infoboxleft' => __( 'Left', 'missingwidgets' ),
					),
			);
		}

		$this->add_control(
				'infobox_position',
				array_merge( $infobox_position_args, $infobox_position_extra_args )
		);

		$this->add_responsive_control(
				'box_top',
				array(
						'label'           => __( 'Top', 'missingwidgets' ),
						'type'            => Controls_Manager::SLIDER,
						'desktop_default' => array(
								'size' => 0,
								'unit' => 'px',
						),
						'range'           => array(
								'px' => array(
										'min'  => 0,
										'max'  => 200,
										'step' => 1,
								),
						),
						'size_units'      => array( 'px', 'em', '%' ),
						'selectors'       => array(
								'{{WRAPPER}} .sideinfo-wrap' => 'top:{{SIZE}}{{UNIT}};',
						),
				)
		);

		$this->add_control(
				'showclose-button',
				array(
						'label'   => __( 'Show close icon', 'missingwidgets' ),
						'default' => 'yes',
						'type'    => Controls_Manager::SWITCHER,
				)
		);
		$this->end_controls_section();

		$this->start_controls_section(
				'section_title_style',
				array(
						'label' => __( 'Title', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_STYLE,
				)
		);

		$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
						'name'     => 'title_typography',
						'selector' => '{{WRAPPER}} .sideinfo-title',
						'global'   => array(
								'default' => Global_Typography::TYPOGRAPHY_TEXT,
						),
				)
		);
		$this->add_control(
				'title_color',
				array(
						'label'     => __( 'Color', 'elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#fff',
						'selectors' => array(
								'{{WRAPPER}} .sideinfo-title' => 'color: {{VALUE}}',
						),
				)
		);
		$this->add_control( 'title_backgroundcolor',
				array(
						'label'     => _x( 'Backgroundcolor', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000',
						'selectors' => array(
								'{{WRAPPER}} .sideinfo-title' => 'background-color: {{VALUE}};',
						),
				) );

		$this->add_responsive_control(
				'title_padding',
				array(
						'label'           => __( 'Padding', 'missingwidgets' ),
						'type'            => Controls_Manager::SLIDER,
						'desktop_default' => array(
								'unit' => 'px',
								'size' => 10,
						),
						'range'           => array(
								'px' => array(
										'min'  => 0,
										'max'  => 80,
										'step' => 1,
								),
						),
						'size_units'      => array( 'px', 'em', '%' ),
						'selectors'       => array(
								'{{WRAPPER}} .sideinfo-title' => 'padding: 0 {{SIZE}}{{UNIT}};',
						),
				)
		);
		$this->add_responsive_control(
				'title_height',
				array(
						'label'           => __( 'Height', 'missingwidgets' ),
						'type'            => Controls_Manager::SLIDER,
						'desktop_default' => array(
								'unit' => 'px',
								'size' => 40,
						),
						'range'           => array(
								'px' => array(
										'min'  => 0,
										'max'  => 80,
										'step' => 1,
								),
						),
						'size_units'      => array( 'px', 'em', '%' ),
						'selectors'       => array(
								'{{WRAPPER}} .infoboxright .sideinfo-title' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};transform: rotate(-90deg) translateY(-{{SIZE}}{{UNIT}});',
								'{{WRAPPER}} .infoboxleft .sideinfo-title'  => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};transform: rotate(-90deg);',
						),
				)
		);
		$this->add_control(
				'title_border_radius',
				array(
						'label'      => esc_html__( 'Border-radius', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'separator'  => 'before',
						'size_units' => array( 'px' ),
						'selectors'  => array(
								'{{WRAPPER}} .sideinfo-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
						'name'     => 'infobox_title_border',
						'selector' => '{{WRAPPER}} .sideinfo-title',
				)
		);
		$this->end_controls_section();

		$this->start_controls_section(
				'section_content_style',
				array(
						'label' => __( 'Content', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_STYLE,
				)
		);

		$this->add_responsive_control(
				'content_width',
				array(
						'label'           => __( 'Width', 'missingwidgets' ),
						'type'            => Controls_Manager::SLIDER,
						'desktop_default' => array(
								'unit' => 'px',
								'size' => 300,
						),
						'range'           => array(
								'px' => array(
										'min'  => 0,
										'max'  => 600,
										'step' => 10,
								),
						),
						'size_units'      => array( 'px', '%' ),
						'selectors'       => array(
								'{{WRAPPER}} .sideinfo-box'              => 'width: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .sideinfo-wrap.infoboxleft' => 'left: -{{SIZE}}{{UNIT}};',

						),
				)
		);

		$this->add_responsive_control(
				'infobox_content_padding',
				array(
						'label'           => __( 'Padding', 'elementor' ),
						'type'            => Controls_Manager::DIMENSIONS,
						'desktop_default' => array(
								'unit' => 'px',
								'size' => 10,
						),
						'size_units'      => array( 'px', 'em', '%' ),
						'selectors'       => array(
								'{{WRAPPER}} .sideinfo-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->add_control( 'content_backgroundcolor',
				array(
						'label'     => _x( 'Backgroundcolor', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#fff',
						'selectors' => array(
								'{{WRAPPER}} .sideinfo-box' => 'background-color: {{VALUE}};',
						),
				) );

		$this->add_control(
				'content_border_radius',
				array(
						'label'      => esc_html__( 'Border-radius', 'missingwidgets' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'separator'  => 'before',
						'size_units' => array( 'px' ),
						'selectors'  => array(
								'{{WRAPPER}} .sideinfo-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
				)
		);

		$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
						'name'     => 'infobox_content_border',
						'selector' => '{{WRAPPER}} .sideinfo-box',
				)
		);
		$this->end_controls_section();

		$this->start_controls_section(
				'section_close_button_style',
				array(
						'label'     => __( 'Close button', 'mensdebilt' ),
						'tab'       => Controls_Manager::TAB_STYLE,
						'condition' => array(
								'showclose-button' => 'yes',
						),
				)
		);

		$this->add_control(
				'close_button_color',
				array(
						'label'     => __( 'Color', 'elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#fff',
						'selectors' => array(
								'{{WRAPPER}} .sideinfo-close' => 'color: {{VALUE}}',
						),
				)
		);

		$this->add_responsive_control(
				'close_button_height',
				array(
						'label'           => __( 'Size icon', 'elementor' ),
						'type'            => Controls_Manager::SLIDER,
						'size_units'      => array( 'px', 'em' ),
						'desktop_default' => array(
								'unit' => 'em',
								'size' => '1',
						),
						'range'           => array(
								'px' => array(
										'min' => 10,
										'max' => 40,
								),
								'em' => array(
										'min' => 1,
										'max' => 5,
								),
						),
						'selectors'       => array(
								'{{WRAPPER}} .sideinfo-close' => 'font-size: {{SIZE}}{{UNIT}}',
						),
				)
		);

		$this->add_responsive_control(
				'close_button_top',
				array(
						'label'           => __( 'Top', 'missingwidgets' ),
						'type'            => Controls_Manager::SLIDER,
						'desktop_default' => array(
								'size' => 10,
								'unit' => 'px',
						),
						'range'           => array(
								'px' => array(
										'min'  => 0,
										'max'  => 200,
										'step' => 1,
								),
						),
						'size_units'      => array( 'px', 'em', '%' ),
						'selectors'       => array(
								'{{WRAPPER}} .sideinfo-close' => 'top:{{SIZE}}{{UNIT}};',
						),
				)
		);

		$this->add_responsive_control(
				'close_button_right',
				array(
						'label'           => __( 'Right', 'missingwidgets' ),
						'type'            => Controls_Manager::SLIDER,
						'desktop_default' => array(
								'size' => 10,
								'unit' => 'px',
						),
						'range'           => array(
								'px' => array(
										'min'  => 0,
										'max'  => 200,
										'step' => 1,
								),
						),
						'size_units'      => array( 'px', 'em', '%' ),
						'selectors'       => array(
								'{{WRAPPER}} .sideinfo-close' => 'right:{{SIZE}}{{UNIT}};',
						),
				)
		);
		$this->end_controls_section();
	}

	protected function render(): void {
		$settings      = (array) $this->get_settings_for_display();
		$title         = '<div class="sideinfo-title">' . esc_html( $this->get_settings( 'title_text' ) ) . '</div>';
		$template_id   = $this->get_settings( 'template_id' );
		$infobox_class = strval( $settings['infobox_position'] ?? 'infoboxright' );

		?>
		<div class="sideinfo-wrap <?php
		echo esc_attr( $infobox_class ) ?>">
			<?php
			if ( $infobox_class === 'infoboxright' ) {
				echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
			<div class="sideinfo-box">
				<?php
				if ( $settings['showclose-button'] ) {
					?><span class="sideinfo-close"><i class="fas fa-times"></i></span><?php
				}
				// PHPCS - should not be escaped.
				echo Plugin::instance()->frontend->get_builder_content_for_display( $template_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</div>
			<?php
			if ( $infobox_class === 'infoboxleft' ) {
				echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</div>
		<?php
	}
}
