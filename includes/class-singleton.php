<?php declare( strict_types = 1 );

namespace MissingWidgets;

/**
 * Trait Singleton
 *
 * Implements singleton method
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
trait Singleton {

	/**
	 * Returns the reference to the class
	 *
	 * All $args will be passed to the class constructor.
	 * Notice that this will only work if the instance function is not called before.
	 *
	 * Will throw an Exception if the function is called while the previous $instance is still being evaluated.
	 * e.g. Calling Class::instance in the constructor of Class
	 *
	 * @param array ...$args array of arguments.
	 *
	 * @return self
	 * @throws \Exception Exception error.
	 */
	public static function &instance( ...$args ) {
		static $initializing = false;
		static $instance = null;
		if ( $instance === null && $initializing ) {
			throw new \Exception( sprintf( 'Tried to get instance of "%s" in the evaluation of previous instance', __CLASS__ ) );
		} elseif ( $instance === null ) {
			$initializing = true;
			$instance = new self( ...$args );
		}

		return $instance;
	}
}
