<?php

declare( strict_types = 1 );

namespace MissingWidgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use MissingWidgets\Core;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Create a listing with dynamic fields
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class Dynamic_Field_List extends Widget_Base {

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
		return 'missingwidget-dynamicfieldlist';
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
		return __( 'Dynamic field list', 'missingwidgets' );
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
		return 'eicon-bullet-list';
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
			'dynamic fields list',
			'text list',
			'icon list',
			'definition list',
			'dynamic fields',
			'list',
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
		return 'https://missingwidgets.com/missing-widgets-features/elementor-dynamic-field-list-widget/';
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
			'section_dynamicfield_list',
			array(
				'label' => __( 'Dynamic Field List', 'missingwidgets' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'       => __( 'Text', 'elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'List Item', 'elementor' ),
				'default'     => __( 'List Item', 'elementor' ),
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
			'dynamicfield_list',
			array(
				'label'       => __( 'Items', 'elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'text' => __( 'List Item #1', 'elementor' ) ),
					array( 'text' => __( 'List Item #2', 'elementor' ) ),
					array( 'text' => __( 'List Item #3', 'elementor' ) ),
				),
				'title_field' => '{{{ text }}}',
			)
		);

		$separator_args = array(
			'label'   => __( 'Type of separator', 'missingwidgets' ),
			'type'    => Controls_Manager::SELECT,
			'default' => ',',
		);

		$separator_extra_args = array();

		if ( \missingwidgets_fs()->can_use_premium_code__premium_only() ) {
			$separator_extra_args = array(
				'options' => array(
					'&nbsp;' => __( 'Single space', 'missingwidgets' ),
					','      => ',',
					';'      => ';',
					'|'      => '|',
					'none'   => __( 'No separator', 'missingwidgets' ),
					'custom' => __( 'Custom separator', 'missingwidgets' ),
				),
			);
		}

		if ( \missingwidgets_fs()->is_not_paying() ) {
			$separator_extra_args = array(
				'description' => Core::freeplan_upgrade_description( 'premium_options',
					self::get_custom_help_url() ),
				'options'     => array(
					'&nbsp;' => __( 'Single space', 'missingwidgets' ),
					','      => ',',
					';'      => ';',
					'|'      => '|',
					'none'   => __( 'No separator', 'missingwidgets' ),
				),
			);
		}

		$this->add_control(
			'separator',
			array_merge( $separator_args, $separator_extra_args )
		);

		if ( \missingwidgets_fs()->can_use_premium_code__premium_only() ) {
			$this->add_control(
				'custom_separator',
				array(
					'label'       => __( 'Custom separator', 'missingwidgets' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => array(
						'active' => true,
					),
					'condition'   => array(
						'separator' => 'custom',
					),
				)
			);
		}
		if ( \missingwidgets_fs()->is_not_paying() ) {
			$this->add_control(
				'custom_panel_notice2',
				array(
					'type'        => Controls_Manager::NOTICE,
					'notice_type' => 'info',
					'dismissible' => false,
					'heading'     => __( 'Custom separator', 'missingwidgets' ),
					'content'     => __( 'Pro users have the ability to add a custom separator.',
						'missingwidgets' ),
				)
			);
		}

		$this->add_responsive_control(
			'view',
			array(
				'label'          => esc_html__( 'Layout', 'elementor' ),
				'type'           => Controls_Manager::CHOOSE,
				'default'        => 'inline',
				'options'        => array(
					'inline'      => array(
						'title' => esc_html__( 'Inline', 'elementor' ),
						'icon'  => 'eicon-ellipsis-h',
					),
					'traditional' => array(
						'title' => esc_html__( 'Default', 'elementor' ),
						'icon'  => 'eicon-editor-list-ul',
					),
				),
				'style_transfer' => true,
				'selectors' => array(
					'{{WRAPPER}} .elementor-dynamicfield-list-items' => '{{VALUE}};',
				),
				'selectors_dictionary' => array(
					'inline' => 'display:flex;',
					'traditional' => 'display:block;',
				),
			)
		);

		$this->add_responsive_control(
			'item_alignment_horizontal',
			array(
				'label' => esc_html__( 'Item Alignment', 'missingwidgets' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => array(
					'start' => array(
						'title' => esc_html__( 'Start', 'missingwidgets' ),
						'icon' => 'eicon-align-start-h',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'missingwidgets' ),
						'icon' => 'eicon-align-center-h',
					),
					'end' => array(
						'title' => esc_html__( 'End', 'missingwidgets' ),
						'icon' => 'eicon-align-end-h',
					),
					'stretch' => array(
						'title' => esc_html__( 'Stretch', 'missingwidgets' ),
						'icon' => 'eicon-align-stretch-h',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-dynamicfield-list-items' => '{{VALUE}};',
				),
				'selectors_dictionary' => array(
					'start' => 'flex-direction: row;align-items: flex-start; justify-content: left; flex-grow: 0;flex-wrap:wrap;',
					'center' => 'flex-direction: row;align-items: center; justify-content: center;flex-grow: 0;flex-wrap:wrap;',
					'end' => 'flex-direction: row;align-items: flex-end; justify-content: end; flex-grow: 0;flex-wrap:wrap;',
					'stretch' => 'flex-direction: row;align-items: stretch; justify-content: space-between;flex-grow: 1;flex-wrap:wrap;',
				),
				'condition' => array(
					'view' => 'inline',
				),
				'frontend_available' => true,
			)
		);

		$this->add_responsive_control(
			'item_alignment_vertical',
			array(
				'label'     => __( 'Alignment', 'elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
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
				'selectors' => array(
					'{{WRAPPER}} .elementor-dynamicfield-list-items .elementor-dynamicfield-list-item' => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					'view' => 'traditional',
				),
				'frontend_available' => true,
			)
		);

		$this->add_responsive_control(
			'item_padding_vertical',
			array(
				'label'     => __( 'Vertical Padding', 'elementor-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'condition' => array(
					'view' => 'traditional',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-dynamicfield-list-items .elementor-dynamicfield-list-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .elementor-dynamicfield-list-item'     => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .elementor-dynamicfield-list-item:hover'     => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .elementor-dynamicfield-list-item' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .elementor-dynamicfield-list-item',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-dynamicfield-list-item',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_link_style',
			array(
				'label' => __( 'Link', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'text_link_color',
			array(
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-dynamicfield-list-item > a'     => 'color: {{VALUE}};',
				),
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
			)
		);

		$this->add_control(
			'text_link_color_hover',
			array(
				'label'     => __( 'Hover', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-dynamicfield-list-item > a:hover'     => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .elementor-dynamicfield-list-item > a',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_separator_style',
			array(
				'label' => __( 'Separator', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'separator_color',
			array(
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-dynamicfield-list-item .elementor-dynamicfield-separator'     => 'color: {{VALUE}};',
				),
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
			)
		);
		$this->add_responsive_control(
			'separator_padding',
			array(
				'label'      => __( 'Padding', 'missingwidgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-dynamicfield-list-item .elementor-dynamicfield-separator' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'separator_typography',
				'selector' => '{{WRAPPER}} .elementor-dynamicfield-list-item .elementor-dynamicfield-separator',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-dynamicfield-list-item .elementor-dynamicfield-separator',
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
		$settings     = $this->get_settings_for_display();
		$itemsettings = (array) $this->get_settings_for_display( 'dynamicfield_list' );
		$separator    = strval( $settings['separator'] );
		if ( $separator === 'custom' ) {
			$separator = strval( $settings['custom_separator'] );
		}
		$this->add_render_attribute( 'list_items', 'class', 'elementor-dynamicfield-list-items' );
		$this->add_render_attribute( 'list_item', 'class', 'elementor-dynamicfield-list-item' );
		$this->add_render_attribute( 'list_item_separator', 'class', 'elementor-dynamicfield-separator' );

		if ( 'inline' === $settings['view'] ) {
			$this->add_render_attribute( 'list_items', 'class', 'elementor-inline-dynamicfield-list' );
		}
		?>
		<div <?php
		echo $this->get_render_attribute_string( 'list_items' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
			foreach ( $itemsettings as $index => $item ) {
				$linkitem = (array) $item;
				$text_key = $this->get_repeater_setting_key( 'text', 'dynamicfield_list', $index );
				$this->add_render_attribute( $text_key, 'class', 'elementor-dynamicfield-list-text' );

				$this->add_inline_editing_attributes( $text_key );
				$text            = strval( $linkitem['text'] );
				$hide_when_empty = $linkitem['hide_when_empty'] === 'yes' && empty( $text );
				$link            = (array) $linkitem['link'];
				$url             = strval( $link ? $link['url'] : '' );
				if ( ! $hide_when_empty ) {
					?>
					<div <?php
					echo $this->get_render_attribute_string( 'list_item' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
						}
						if ( $separator !== 'none' && $index !== ( count( $itemsettings ) - 1 ) ) { ?>
							<span <?php
							echo $this->get_render_attribute_string( 'list_item_separator' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>><?php
							echo esc_html( $separator );
?></span><?php
						}
						?>
					</div>
					<?php
				}
			}
			?>
		</div>
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
		view.addRenderAttribute( 'list_item', 'class', 'elementor-dynamicfield-list-item' );
		view.addRenderAttribute( 'list_item_separator', 'class', 'elementor-dynamicfield-separator' );
		view.addRenderAttribute( 'list_items', 'class', 'elementor-dynamicfield-list-items' );
		if ( settings.view == 'inline' ) {
		view.addRenderAttribute( 'list_items', 'class', 'elementor-inline-dynamicfield-list' );
		}
		if ( settings.dynamicfield_list ) {
		#>
		<div {{{ view.getRenderAttributeString( 'list_items' ) }}}>
		<# _.each( settings.dynamicfield_list, function( item, index ) {
		var hideItem = item.hide_when_empty == 'yes' && item.text.length == 0;
		var itemTextKey = view.getRepeaterSettingKey( 'text', 'dynamicfield_list', index );
		view.addRenderAttribute( itemTextKey, 'class', 'elementor-dynamicfield-list-text' );
		view.addInlineEditingAttributes( itemTextKey );
		if(!hideItem){
		#>

		<div {{{ view.getRenderAttributeString( 'list_item' ) }}}>
		<# if ( item.link && item.link.url ) { #>
		<a href="{{ item.link.url }}">
			<# } #>
			{{{ item.text }}}
			<# if ( item.link && item.link.url ) { #>
		</a>
		<# } #>
		<# if ( settings.separator != 'none' && (settings.dynamicfield_list.length -1) > index) { #>
		<span {{{ view.getRenderAttributeString( 'list_item_separator' ) }}}>
		<# if ( settings.separator == 'custom' ) { #>
		{{{ settings.custom_separator }}}
		<# } else { #>
		{{{ settings.separator }}}
		<# } #>
		</span>
		<# } #>
		</div>
		<#
		}
		} ); #>
		</div>
		<#    } #>

		<?php
	}
}
