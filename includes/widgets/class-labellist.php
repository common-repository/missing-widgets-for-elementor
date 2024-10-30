<?php
declare( strict_types = 1 );

namespace MissingWidgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Create a listing with labels and text
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class Label_List extends Widget_Base {

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
		return 'missingwidget-labellist';
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
		return __( 'Label List', 'missingwidgets' );
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
		return 'eicon-tags';
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
			'label list',
			'info list',
			'icon list',
			'definition list',
			'two column list',
			'label',
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
		return 'https://missingwidgets.com/missing-widgets-features/elementor-label-list-widget/';
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
			'section_label_list',
			array(
				'label' => __( 'Label List', 'missingwidgets' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'label',
			array(
				'label'       => __( 'Label', 'missingwidgets' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Label', 'missingwidgets' ),
				'default'     => __( 'Label', 'missingwidgets' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

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
			'label_list',
			array(
				'label'       => __( 'Items', 'elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'label' => __( 'Label #1', 'missingwidgets' ),
						'text'  => __( 'List Item', 'elementor' ),
					),
					array(
						'label' => __( 'Label #2', 'missingwidgets' ),
						'text'  => __( 'List Item', 'elementor' ),
					),
					array(
						'label' => __( 'Label #3', 'missingwidgets' ),
						'text'  => __( 'List Item', 'elementor' ),
					),
				),
				'title_field' => '{{{ label }}} {{{ text }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label_list',
			array(
				'label' => __( 'List', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .elementor-label-list-items:not(.elementor-inline-items) .elementor-label-list-item:not(:last-child)'  => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-label-list-items:not(.elementor-inline-items) .elementor-label-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-label-list-items.elementor-inline-items .elementor-label-list-item'                         => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-label-list-items.elementor-inline-items'                                                    => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body.rtl {{WRAPPER}} .elementor-label-list-items.elementor-inline-items .elementor-label-list-item:after'          => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body:not(.rtl) {{WRAPPER}} .elementor-label-list-items.elementor-inline-items .elementor-label-list-item:after'    => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
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

		$this->add_control(
			'divider',
			array(
				'label'     => __( 'Divider', 'elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'elementor' ),
				'label_on'  => __( 'On', 'elementor' ),
				'selectors' => array(
					'{{WRAPPER}} .elementor-label-list-item:not(:last-child):after' => 'content: ""',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'divider_style',
			array(
				'label'     => __( 'Style', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => __( 'Solid', 'elementor' ),
					'double' => __( 'Double', 'elementor' ),
					'dotted' => __( 'Dotted', 'elementor' ),
					'dashed' => __( 'Dashed', 'elementor' ),
				),
				'default'   => 'solid',
				'condition' => array(
					'divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-label-list-items .elementor-label-list-item:not(:last-child):after' => 'border-top-style: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'divider_weight',
			array(
				'label'     => __( 'Weight', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 1,
				),
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 20,
					),
				),
				'condition' => array(
					'divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-label-list-items .elementor-label-list-item:not(:last-child):after' => 'border-top-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'divider_width',
			array(
				'label'     => __( 'Width', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'unit' => '%',
					'size' => '100',
				),
				'condition' => array(
					'divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-label-list-item:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'divider_height',
			array(
				'label'      => __( 'Height', 'elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'default'    => array(
					'unit' => 'px',
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
				'condition'  => array(
					'divider' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-label-list-item:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'divider_color',
			array(
				'label'     => __( 'Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ddd',
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'condition' => array(
					'divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-label-list-item:not(:last-child):after' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label_style',
			array(
				'label' => __( 'Label', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-label-list-label' => 'color: {{VALUE}};',
				),
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
			)
		);

		$this->add_responsive_control(
			'label_width',
			array(
				'label'      => __( 'Label width', 'missingwidgets' ),
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
					'{{WRAPPER}} .elementor-label-list-label' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .elementor-label-list-label',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'label_shadow',
				'selector' => '{{WRAPPER}} .elementor-label-list-label',
			)
		);

		$this->add_responsive_control(
			'label_left_align',
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
					'{{WRAPPER}} .elementor-label-list-item .elementor-label-list-label' => 'text-align: {{VALUE}};',
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
					'{{WRAPPER}} .elementor-label-list-item:hover .elementor-label-list-text'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-label-list-item:hover .elementor-label-list-text > a' => 'color: {{VALUE}};',
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

		$this->add_responsive_control(
			'text_align',
			array(
				'label'     => __( 'Alignment', 'elementor' ),
				'selectors' => array(
					'{{WRAPPER}} .elementor-label-list-item .elementor-label-list-text' => 'text-align: {{VALUE}};',
				),
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
		$settings = (array) $this->get_settings_for_display( 'label_list' );

		$this->add_render_attribute( 'label_list', 'class', 'elementor-label-list-items' );
		$this->add_render_attribute( 'list_item', 'class', 'elementor-label-list-item' );

		?>
		<ul <?php
		echo $this->get_render_attribute_string( 'label_list' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
			foreach ( $settings as $index => $item ) {
				$linkitem  = (array) $item;
				$label_key = $this->get_repeater_setting_key( 'label', 'label_list', $index );
				$this->add_render_attribute( $label_key, 'class', 'elementor-label-list-label' );
				$this->add_inline_editing_attributes( $label_key );

				$text_key = $this->get_repeater_setting_key( 'text', 'label_list', $index );
				$this->add_render_attribute( $text_key, 'class', 'elementor-label-list-text' );
				$this->add_inline_editing_attributes( $text_key );
				$label           = strval( $linkitem['label'] );
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
						echo $this->get_render_attribute_string( $label_key ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>><?php
							echo esc_html( $label ); ?></span>
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
		</ul>
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
		view.addRenderAttribute( 'label_list', 'class', 'elementor-label-list-items' );
		view.addRenderAttribute( 'list_item', 'class', 'elementor-label-list-item' );

		#>
		<# if ( settings.label_list ) { #>
		<ul {{{ view.getRenderAttributeString( 'label_list' ) }}}>
		<# _.each( settings.label_list, function( item, index ) {
		var hideItem = item.hide_when_empty == 'yes' && item.text.length == 0;
		var itemTextKey = view.getRepeaterSettingKey( 'text', 'label_list', index );
		view.addRenderAttribute( itemTextKey, 'class', 'elementor-label-list-text' );
		view.addInlineEditingAttributes( itemTextKey );
		var itemLabelKey = view.getRepeaterSettingKey( 'label', 'label_list', index );
		view.addRenderAttribute( itemLabelKey, 'class', 'elementor-label-list-label' );
		view.addInlineEditingAttributes( itemLabelKey );
		if(!hideItem){
		#>

		<li {{{ view.getRenderAttributeString( 'list_item' ) }}}>
		<span {{{ view.getRenderAttributeString( itemLabelKey ) }}}>{{{ item.label }}}</span>
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
		</ul>
		<#    } #>

		<?php
	}
}
