<?php declare( strict_types = 1 );

namespace MissingWidgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Core\Schemes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Text Widget with the ability to set a maximum content length
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class Maximum_Content_Length extends Widget_Base {

	/**
	 * Set the unique widget name
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'missingwidgets-maxcontentlength';
	}

	/**
	 * Set the title of the widget
	 *
	 * @return string
	 */
	public function get_title(): string {

		return __( 'Maximum Content Length Widget', 'missingwidgets' );
	}

	/**
	 * See for icons https://elementor.github.io/elementor-icons/.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-wrap';
	}

	/**
	 * Set this to theme-elements so the widget can be found inside the site tab of the widget elementor.
	 * See for more info https://developers.elementor.com/widget-categories/
	 *
	 * @return array
	 */
	public function get_categories(): array {
		return array( 'general' );
	}

	/**
	 * Links to an online helpdocument inside the widget itself.
	 *
	 * @return string
	 */
	public function get_custom_help_url(): string {
		return 'https://missingwidgets.com/missing-widgets-features/elementor-maximum-content-length-widget/';
	}

	/**
	 * Set extra keywords for the widget search off elementor.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return array(
			'excerpt',
			'text',
			'length',
			'maximum',
			'content',
			'info',
			'missing',
			'widgets',
			'missingwidgets',
		);
	}

	/**
	 * Enqueuing extra styling.
	 * See example https://developers.elementor.com/creating-a-new-widget/adding-javascript-to-elementor-widgets/
	 *
	 * @return array
	 */
	public function get_style_depends(): array {
		return array( 'style-handle' );
	}

	/**
	 * Enqueuing extra scripting.
	 * See example https://developers.elementor.com/creating-a-new-widget/adding-javascript-to-elementor-widgets/
	 *
	 * @return array
	 */
	public function get_script_depends(): array {
		return array( 'script-handle' );
	}


	/**
	 * Limit sentence length to a character count.
	 *
	 * @param string $sentence
	 * @param int    $limit
	 * @param string $more
	 *
	 * @return string
	 */
	public static function limit_sentence_strlen( string $sentence, int $limit, string $more = '&hellip;' ): string {

		// Make sure the sentence is longer than the limit.
		if ( strlen( $sentence ) <= $limit ) {
			return $sentence;
		}

		$count = 0;
		$index = 0;
		$words = explode( ' ', $sentence );
		foreach ( $words as $i => $word ) {
			$count += strlen( $word ) + 1;
			if ( $count > $limit ) {
				$index = $i;
				break;
			}
		}

		return implode( ' ', array_slice( $words, 0, $index, false ) ) . ' ' . $more;
	}


	/**
	 *  Function to set which controls for the widget you'll need in the elementor editor
	 *  see https://developers.elementor.com/elementor-controls/
	 */
	protected function register_controls(): void {
		// start with a start_controls_section
		// add various controls to tab
		// end with an end_controls_section
		// repeat if you'll need more sections
		// see https://developers.elementor.com/add-control-section-to-widgets/.
		$this->start_controls_section(
			'text_basic',
			array(
				'label' => __( 'Text settings', 'missingwidgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		// see https://developers.elementor.com/add-controls-to-widgets/.
		$this->add_control(
			'text_field',
			array(
				'label'       => __( 'Text field', 'missingwidgets' ),
				'label_block' => true,
				'description' => __( 'Set the field of the text', 'missingwidgets' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '',
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'excerptlength',
			array(
				'label'       => __( 'Number of maximal characters', 'missingwidgets' ),
				'label_block' => true,
				'type'        => Controls_Manager::NUMBER,
				'default'     => 150,
			)
		);

		$this->add_control(
			'more',
			array(
				'label'   => __( 'End tag of content', 'missingwidgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '&hellip;',
				'options' => array(
					''         => '',
					'&hellip;' => '&hellip;',
					'..'       => '..',
					'.'        => '.',
				),
			)
		);

		$this->add_control(
			'striphtml',
			array(
				'label'   => __( 'Strip all HTML tags?', 'missingwidgets' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => __( 'Text Editor', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'     => __( 'Alignment', 'elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => __( 'Left', 'elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => __( 'Justified', 'elementor' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-maxcontent-editor' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}' => 'color: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_3,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'   => 'typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_3,
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Function which displays the widget HTML inside the webpage.
	 * see https://developers.elementor.com/render-widget-template/.
	 */
	protected function render(): void {

		// Get the values you set in the elementor controls.
		// See https://developers.elementor.com/get-widget-settings/.
		$text_value           = strval( $this->get_settings_for_display( 'text_field' ) );
		$more_value           = strval( $this->get_settings_for_display( 'more' ) );
		$excerpt_length_value = intval( $this->get_settings_for_display( 'excerptlength' ) );
		$stripped_html        = strval( $this->get_settings_for_display( 'striphtml' ) );
		if ( $text_value !== '' ) {
			if ( $stripped_html === 'yes' ) {
				$text_value = strip_shortcodes( wp_strip_all_tags( $text_value ) );
			} else {
				$text_value = strip_shortcodes( $text_value );
			}

			$this->add_render_attribute(
				'editor',
				'class',
				array(
					'elementor-maxcontent-editor',
					'elementor-clearfix',
				)
			);

			?>
			<div <?php echo $this->get_render_attribute_string( 'editor' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php echo esc_html( self::limit_sentence_strlen( $text_value, $excerpt_length_value, $more_value ) ); ?>
			</div>
			<?php
		}
	}
}
