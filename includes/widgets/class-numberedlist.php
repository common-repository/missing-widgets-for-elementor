<?php

declare( strict_types = 1 );

namespace MissingWidgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Create a listing with numbers and text
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class Numbered_List extends Widget_Base {

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
		return 'missingwidget-numberedlist';
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
		return __( 'Numbered List', 'missingwidgets' );
	}

	/**
	 * Get widget label.
	 *
	 * Retrieve label list widget icon.
	 *
	 * @return string Widget icon.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_icon(): string {
		return 'eicon-editor-list-ol';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 * @since  2.1.0
	 * @access public
	 */
	public function get_keywords(): array {
		return array(
			'numbered list',
			'icon list',
			'definition list',
			'label',
			'list',
			'numbers',
			'missing',
			'widgets',
			'missingwidgets',
		);
	}

	/**
	 * Set this to theme-elements so the widget can be found inside the site tab of the widget elementor
	 * see for more info https://developers.elementor.com/widget-categories/.
	 *
	 * @return array
	 */
	public function get_categories(): array {
		return array( 'general' );
	}

	public function get_custom_help_url(): string {
		return 'https://missingwidgets.com/missing-widgets-features/elementor-numbered-list-widget/';
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
			'section_numbered_list',
			array(
				'label' => __( 'Numbered List', 'missingwidgets' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'       => __( 'Text', 'elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Numbered Item', 'elementor' ),
				'default'     => __( 'Numbered Item', 'elementor' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => __( 'Link', 'elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => __( 'https://your-link.com', 'elementor' ),
			)
		);

		$repeater->add_control(
			'hide_when_empty',
			array(
				'label'     => __( 'Hide list item when text is empty', 'missingwidgets' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Show', 'missingwidgets' ),
				'label_on'  => __( 'Hide', 'missingwidgets' ),
			)
		);

		$this->add_control(
			'numbered_list',
			array(
				'label'       => __( 'Items', 'elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'text' => __( 'List Item #1', 'elementor' ),
					),
					array(
						'text' => __( 'List Item #2', 'elementor' ),
					),
					array(
						'text' => __( 'List Item #3', 'elementor' ),
					),
				),
				'title_field' => '{{{ text }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_numbered_type',
			array(
				'label' => __( 'Type of ordering', 'elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'order_type',
			array(
				'label'       => __( 'Select the type of ordering', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default'     => 'decimal',
				'options'     => array(
					'decimal'              => __( 'With numbers', 'missingwidgets' ),
					'decimal-leading-zero' => __( 'With numbers with leading zeros', 'missingwidgets' ),
					'upper-latin'          => __( 'Uppercase letters', 'missingwidgets' ),
					'lower-latin'          => __( 'Lowercase letters', 'missingwidgets' ),
					'upper-roman'          => __( 'Uppercase roman numbers', 'missingwidgets' ),
					'lower-roman'          => __( 'Lowercase roman numbers', 'missingwidgets' ),
				),
				'selectors'   => array(
					'{{WRAPPER}} ol li:before' => 'content: counter(numbered-list, {{VALUE}});counter-increment: numbered-list 1;',
				),
			)
		);

		$this->add_control(
			'start_from',
			array(
				'label'       => __( 'Start count from', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'step'        => 1,
				'default'     => 1,
				'selectors'   => array(
					'{{WRAPPER}} ol' => 'list-style-type:none;counter-reset:numbered-list calc({{VALUE}} - 1);',
				),

			)
		);

		$this->add_responsive_control(
			'space_between',
			array(
				'label'     => __( 'Space Between', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-numbered-list-items:not(.elementor-inline-items) .elementor-numbered-list-item:not(:last-child)'  => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-numbered-list-items:not(.elementor-inline-items) .elementor-numbered-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-numbered-list-items.elementor-inline-items .elementor-numbered-list-item'                         => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-numbered-list-items.elementor-inline-items'                                                       => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body.rtl {{WRAPPER}} .elementor-numbered-list-items.elementor-inline-items .elementor-numbered-list-item:after'          => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body:not(.rtl) {{WRAPPER}} .elementor-numbered-list-items.elementor-inline-items .elementor-numbered-list-item:after'    => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
				),
			)
		);

		$this->add_responsive_control(
			'label_align',
			array(
				'label'        => __( 'Alignment', 'elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'left'   => array(
						'title' => __( 'Left', 'elementor' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'elementor' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'elementor' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'prefix_class' => 'elementor%s-align-',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_numbered_style',
			array(
				'label' => __( 'Number', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'number_background_color',
			array(
				'label'     => __( 'Color background', 'missingwidgets' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_ACCENT,
				),
				'selectors' => array(
					'{{WRAPPER}} ol li.elementor-numbered-list-item:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'number_color',
			array(
				'label'     => __( 'Number color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ol li.elementor-numbered-list-item:before' => 'color: {{VALUE}};',
				),
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} ol li.elementor-numbered-list-item:before',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'number_shadow',
				'selector' => '{{WRAPPER}} ol li.elementor-numbered-list-item:before',
			)
		);

		$this->add_responsive_control(
			'number_width',
			array(
				'label'      => __( 'Width', 'elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'unit' => 'em',
					'size' => '1',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ol li.elementor-numbered-list-item:before' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'number_height',
			array(
				'label'      => __( 'Height', 'elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'unit' => 'em',
					'size' => '1',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ol li.elementor-numbered-list-item:before' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'number_divider',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'number_border',
				'label'    => __( 'Border', 'elementor' ),
				'selector' => '{{WRAPPER}} ol li.elementor-numbered-list-item:before',
			)
		);

		$this->add_control(
			'number_border_radius',
			array(
				'label'      => __( 'Border Radius', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ol li.elementor-numbered-list-item:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			array(
				'label' => __( 'Text', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-label-list-text'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-label-list-text > a' => 'color: {{VALUE}};',
				),
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
			)
		);

		$this->add_control(
			'text_color_hover',
			array(
				'label'     => __( 'Hover', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-numbered-list-item:hover .elementor-label-list-text'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-numbered-list-item:hover .elementor-label-list-text > a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
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
					'{{WRAPPER}} .elementor-label-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'text_width',
			array(
				'label'      => __( 'Text width', 'missingwidgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 250,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'em' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => .1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-label-list-text' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .elementor-label-list-text',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-label-list-text',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render(): void {
		$settings = (array) $this->get_settings_for_display( 'numbered_list' );

		$this->add_render_attribute( 'numbered_list', 'class', 'elementor-numbered-list-items' );
		$this->add_render_attribute( 'list_item', 'class', 'elementor-numbered-list-item' );

		?>
		<ol <?php
		echo $this->get_render_attribute_string( 'numbered_list' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
			foreach ( $settings as $index => $item ) {
				$linkitem = (array) $item;

				$text_key = $this->get_repeater_setting_key( 'text', 'numbered_list', $index );
				$this->add_render_attribute( $text_key, 'class', 'elementor-label-list-text' );
				$this->add_inline_editing_attributes( $text_key );
				$text            = strval( $linkitem['text'] );
				$hide_when_empty = $linkitem['hide_when_empty'] === 'yes' && empty( $text );
				$link            = (array) $linkitem['link'];
				$url             = strval( $link ? $link['url'] : '' );
				if ( ! $hide_when_empty ) {
					?>
					<li <?php
					echo $this->get_render_attribute_string( 'list_item' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>>
					<span <?php
					echo $this->get_render_attribute_string( $text_key ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>>
					<?php
					if ( ! empty( $url ) ) {
						$link_key = 'link_' . $index;

						$this->add_link_attributes( $link_key, $link );

						echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>'; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					echo esc_html( $text );
					if ( ! empty( $url ) ) {
						?>
						</a>
						<?php
					} ?>
					</span>
					</li>
					<?php
				}
			}
			?>
		</ol>
		<?php
	}

	/**
	 * Render icon list widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since  2.9.0
	 * @access protected
	 */
	protected function content_template(): void {
		?>
		<#
		view.addRenderAttribute( 'numbered_list', 'class', 'elementor-numbered-list-items' );
		view.addRenderAttribute( 'list_item', 'class', 'elementor-numbered-list-item' );

		#>
		<# if ( settings.numbered_list ) { #>
		<ol {{{ view.getRenderAttributeString( 'numbered_list' ) }}}>
		<# _.each( settings.numbered_list, function( item, index ) {
		var hideItem = item.hide_when_empty == 'yes' && item.text.length == 0;
		var itemTextKey = view.getRepeaterSettingKey( 'text', 'numbered_list', index );
		view.addRenderAttribute( itemTextKey, 'class', 'elementor-label-list-text' );
		view.addInlineEditingAttributes( itemTextKey );
		if(!hideItem){
		#>

		<li {{{ view.getRenderAttributeString( 'list_item' ) }}}>
		<span {{{ view.getRenderAttributeString( itemTextKey ) }}}>
		<# if ( item.link && item.link.url ) { #>
		<a href="{{ item.link.url }}">

			<# } #>
			{{{ item.text }}}
			<# if ( item.link && item.link.url ) { #>
		</a>
		<# } #>
		</span>
		</li>
		<#
		}
		} ); #>
		</ol>
		<#    } #>

		<?php
	}
}
