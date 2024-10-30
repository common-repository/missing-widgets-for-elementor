<?php

declare( strict_types = 1 );

namespace MissingWidgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use MissingWidgets\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * To top widget
 *
 * Widget for scrolling back to the top of the page.
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class To_Top extends Widget_Base {


	public function get_name(): string {
		return 'missingwidgets-scrolltotop';
	}

	public function get_title(): string {
		return _x( 'Scroll to top button', 'To top Widget', 'missingwidgets' );
	}

	public function get_icon(): string {
		return 'eicon-v-align-top';
	}

	public function get_categories(): array {
		return array( 'general' );
	}

	public function get_custom_help_url(): string {
		return 'https://missingwidgets.com/missing-widgets-features/elementor-scroll-to-top-button-widget/';
	}

	public function get_keywords(): array {
		return array( 'to', 'top', 'totop', 'scroll', 'button', 'up', 'missing', 'widgets', 'missingwidgets' );
	}

	protected function register_controls(): void {
		$this->start_controls_section(
				'to_top_settings',
				array(
						'label' => _x( 'Scroll to top button', 'To top Widget', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_CONTENT,
				)
		);

		$this->add_control(
				'totop_icon',
				array(
						'label'   => _x( 'Icon', 'To top Widget', 'missingwidgets' ),
						'type'    => Controls_Manager::ICONS,
						'default' => array(
								'value'   => 'fas fa-arrow-up',
								'library' => 'fa-solid',
						),
				)
		);
		$totop_position_args = array(
				'label'     => __( 'Position', 'missingwidgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'selectors' => array(
						'{{WRAPPER}} #totop'   => 'z-index:99; position: fixed;',
						'{{WRAPPER}} #totop a' => ' text-align:center; display:block; width:100%; margin:0 auto',

				),
		);

		$totop_position_extra_args = array();

		if ( \missingwidgets_fs()->can_use_premium_code__premium_only() ) {
			$totop_position_extra_args = array(
					'options' => array(
							'totopleft'   => __( 'Left', 'missingwidgets' ),
							'totopmiddle' => __( 'Middle', 'missingwidgets' ),
							'totopright'  => __( 'Right', 'missingwidgets' ),
					),
			);
		}

		if ( \missingwidgets_fs()->is_not_paying() ) {
			$totop_position_extra_args = array(
					'description' => Core::freeplan_upgrade_description( 'premium_options',
							self::get_custom_help_url() ),
					'options'     => array(
							'totopleft'  => __( 'Left', 'missingwidgets' ),
							'totopright' => __( 'Right', 'missingwidgets' ),
					),
			);
		}

		$this->add_control(
				'totop_alignment',
				array_merge( $totop_position_args, $totop_position_extra_args )
		);

		$this->add_responsive_control(
				'totop_horizontal_distance',
				array(
						'label'           => _x( 'Horizontal padding', 'To top Widget', 'missingwidgets' ),
						'description'     => _x(
								'Distance to the left/right side of the screen',
								'To top Widget',
								'missingwidgets'
						),
						'type'            => Controls_Manager::SLIDER,
						'size_units'      => array( 'px', '%' ),
						'range'           => array(
								'px' => array(
										'min'  => 0,
										'max'  => 100,
										'step' => 1,
								),
								'%'  => array(
										'min'  => 0,
										'max'  => 100,
										'step' => 1,
								),
						),
						'desktop_default' => array(
								'unit' => 'px',
								'size' => 30,
						),
						'selectors'       => array(
								'{{WRAPPER}} #totop.totopleft'   => 'left: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} #totop.totopmiddle' => 'left: calc(50% + {{SIZE}}{{UNIT}});',
								'{{WRAPPER}} #totop.totopright'  => 'right: {{SIZE}}{{UNIT}};',
						),
				)
		);

		$this->add_responsive_control(
				'totop_vertical_distance',
				array(
						'label'           => _x( 'Vertical padding', 'To top Widget', 'missingwidgets' ),
						'description'     => _x(
								'Distance to the bottom of the screen',
								'To top Widget',
								'missingwidgets'
						),
						'type'            => Controls_Manager::SLIDER,
						'size_units'      => array( 'px', '%' ),
						'range'           => array(
								'px' => array(
										'min'  => 0,
										'max'  => 100,
										'step' => 1,
								),
								'%'  => array(
										'min'  => 0,
										'max'  => 100,
										'step' => 1,
								),
						),
						'desktop_default' => array(
								'unit' => 'px',
								'size' => 30,
						),
						'selectors'       => array(
								'{{WRAPPER}} #totop' => 'bottom: {{SIZE}}{{UNIT}};',
						),
				)
		);

		$this->end_controls_section();

		$this->start_controls_section(
				'icon',
				array(
						'label' => _x( 'Icon', 'To top Widget', 'missingwidgets' ),
						'tab'   => Controls_Manager::TAB_STYLE,
				)
		);

		$this->add_responsive_control(
				'totop_size',
				array(
						'label'           => _x( 'Size', 'To top Widget', 'missingwidgets' ),
						'type'            => Controls_Manager::SLIDER,
						'size_units'      => array( 'px', 'em' ),
						'range'           => array(
								'px' => array(
										'min' => 0,
										'max' => 100,
								),
								'%'  => array(
										'min'  => 0,
										'max'  => 100,
										'step' => 1,
								),
						),
						'desktop_default' => array(
								'unit' => 'px',
								'size' => 50,
						),
						'selectors'       => array(
								'{{WRAPPER}} #totop'     => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} #totop a i' => 'line-height:  {{SIZE}}{{UNIT}};',
						),
				)
		);

		$this->add_control(
				'totop_backgroundcolor',
				array(
						'label'     => _x( 'Background Color', 'To top Widget', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000',
						'selectors' => array(
								'{{WRAPPER}} #totop' => 'background-color: {{VALUE}};',
						),
				)
		);

		$this->add_responsive_control(
				'totop_borderradius',
				array(
						'label'           => _x( 'Border Radius', 'To top Widget', 'missingwidgets' ),
						'type'            => Controls_Manager::SLIDER,
						'size_units'      => array( 'px', '%' ),
						'range'           => array(
								'%'  => array(
										'min'  => 0,
										'max'  => 100,
										'step' => 1,
								),
								'px' => array(
										'min'  => 0,
										'max'  => 100,
										'step' => 1,
								),
						),
						'desktop_default' => array(
								'unit' => '%',
								'size' => 50,
						),
						'selectors'       => array(
								'{{WRAPPER}} #totop' => 'border-radius: {{SIZE}}{{UNIT}};',
						),
				)
		);

		$this->add_control(
				'totop_icon_color',
				array(
						'label'     => _x( 'Color', 'To top Widget', 'missingwidgets' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#fff',
						'selectors' => array(
								'{{WRAPPER}} #totop i' => 'color: {{VALUE}};',
						),
				)
		);

		$this->add_responsive_control(
				'totop_icon_size',
				array(
						'label'           => _x( 'Size', 'To top Widget', 'missingwidgets' ),
						'type'            => Controls_Manager::SLIDER,
						'size_units'      => array( 'px', 'em' ),
						'range'           => array(
								'px' => array(
										'min' => 0,
										'max' => 100,
								),
								'em' => array(
										'min'  => 0,
										'max'  => 10,
										'step' => 0.1,
								),
						),
						'desktop_default' => array(
								'unit' => 'px',
								'size' => 25,
						),
						'selectors'       => array(
								'{{WRAPPER}} #totop i' => 'font-size: {{SIZE}}{{UNIT}};',
						),
				)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$icon     = (array) $this->get_settings_for_display( 'totop_icon' );
		$position = strval( $this->get_settings_for_display( 'totop_alignment' ) );
		$title    = _x( 'Scroll to top', 'To top Widget', 'missingwidgets' );

		if ( empty( $icon['library'] ) || empty( $icon['value'] ) || ! is_string( $icon['value'] ) ) {
			return;
		}

		$this->add_render_attribute( 'totop-class', 'class', $position );
		$this->add_render_attribute( 'icon-class', 'class', strval( $icon['library'] ) );
		$this->add_render_attribute( 'icon-class', 'class', $icon['value'] );
		$this->add_render_attribute( 'link-title', 'title', $title );
		?>
		<div id="totop"
				<?php
				echo $this->get_render_attribute_string( 'totop-class' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
		>
			<a href="#scroll-top" id="hreftotop"
					<?php
					echo $this->get_render_attribute_string( 'link-title' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
			>
				<i
						<?php
						echo $this->get_render_attribute_string( 'icon-class' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
				></i>
			</a>
		</div>
		<?php
	}
}
