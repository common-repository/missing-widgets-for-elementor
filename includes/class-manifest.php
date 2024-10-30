<?php

declare( strict_types = 1 );

namespace MissingWidgets;

/**
 * Represents a webpack manifest file
 *
 * @author  Sivard Donkers
 * @package missing_widgets_for_elementor
 */
class Manifest {


	/**
	 * @var string Manifest file
	 */
	protected $file = '';

	/**
	 * @var string Manifest base url
	 */
	protected $base_uri = '';


	/**
	 * @var array|null Manifest content
	 */
	protected $assets;

	/**
	 * Manifest constructor.
	 *
	 * @param string $file Manifest file.
	 */
	public function __construct( string $file ) {
		$this->file = $file;
	}


	/**
	 * Get manifest assets
	 *
	 * Will prepend the base_uri to all asset files when it is set.
	 *
	 * @return array Returns an empty array if the manifest does not exist
	 * or when the manifest is not formatted properly.
	 */
	public function get_assets(): array {
		if ( $this->assets !== null ) {
			return $this->assets;
		}

		if ( ! file_exists( $this->file ) ) {
			return array();
		}

		//phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$assets = (array) json_decode( (string) file_get_contents( $this->file ), true );

		if ( empty( $assets ) ) {
			return array();
		}

		if ( $this->base_uri !== null ) {
			foreach ( $assets as $key => &$asset ) {
				$asset = $this->base_uri . $asset;
			}
		}

		return $assets;
	}

	/**
	 * Get all assets and filter by file extension
	 *
	 * @param string $ext
	 *
	 * @return array
	 */
	public function get_assets_by_extension( string $ext ): array {
		$assets = $this->get_assets();

		return array_filter(
			$assets,
			function ( $name ) use ( $ext ) {
				return self::has_suffix( $name, $ext );
			},
			ARRAY_FILTER_USE_KEY
		);
	}

	/**
	 * Checks whether file has the suffix or not
	 *
	 * @param string $filename
	 * @param string $suffix
	 *
	 * @return bool Returns true if string has suffix
	 */
	public static function has_suffix( string $filename, string $suffix ): bool {
		$length = strlen( $suffix );
		if ( $length === 0 ) {
			return true;
		}

		return ( substr( $filename, - $length ) === $suffix );
	}

	/**
	 * Get asset by name
	 *
	 * @param string $name
	 *
	 * @return string|null Returns null when the asset could not be found.
	 */
	public function get_asset( string $name ) {
		$content = $this->get_assets();

		return $content[ $name ] ?? null;
	}

	/**
	 * @param string $name
	 *
	 * @return bool Returns true if the manifest contains the asset
	 */
	public function has_asset( string $name ): bool {
		return isset( $this->get_assets()[ $name ] );
	}

	/**
	 * Get scripts
	 *
	 * @return array Returns all assets with .js extension
	 */
	public function get_scripts(): array {
		return $this->get_assets_by_extension( '.js' );
	}

	/**
	 * Get styles
	 *
	 * @return array Returns all assets with .css extension
	 */
	public function get_styles(): array {
		return $this->get_assets_by_extension( '.css' );
	}
}
