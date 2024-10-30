<?php

namespace MissingWidgets\Extras;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

class Theme_Extra_Settings extends Tab_Base {

	public function get_id(): string {
		return 'themeextrastylingsettings';
	}

	public function get_title(): string {
		return __( 'Extra Theme Styling settings', 'missingwidgets' );
	}

	public function get_group(): string {
		return 'theme-style';
	}

	public function get_icon(): string {
		return 'eicon-settings';
	}

	public function get_help_url(): string {
		return 'https://missingwidgets.com/missing-widgets-features/';
	}

	protected function register_tab_controls(): void {

		$anchor_selector = 'body:not(.elementor-editor-active) .elementor-menu-anchor:before';

		$this->start_controls_section(
			'section_themeextrastylingsettings',
			array(
				'label' => __( 'Extra theme settings styling', 'missingwidgets' ),
				'tab'   => $this->get_id(),
			)
		);

		$this->add_responsive_control(
			'anchor_fixed_header_offset',
			array(
				'label' => __( 'Offset for anchors with fixed headers', 'missingwidgets' ),
				'type'  => Controls_Manager::NUMBER,
			)
		);

		$this->end_controls_section();
	}
}
