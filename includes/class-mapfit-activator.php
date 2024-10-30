<?php
/**
 * Fired during plugin activation
 *
 * @link       https://mapfit.com
 * @since      1.0.0
 *
 * @package    Mapfit
 * @subpackage Mapfit/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mapfit
 * @subpackage Mapfit/includes
 * @author     Bogdan Bodnarescu <bogdan@mapfit.com>
 */
class Mapfit_Activator {


	/**
	 * Register Mapfit Settings
	 *
	 * @return void
	 */
	public static function activate() {

		$option_group = 'mapfit-option-group';
		register_setting( $option_group, 'mapfit_marker' );
		register_setting( $option_group, 'mapfit_placeinfo' );
		register_setting( $option_group, 'mapfit_map' );

		register_setting( $option_group, 'mapfit_address' );
		register_setting( $option_group, 'mapfit_title' );
		register_setting( $option_group, 'mapfit_subtitle1' );
		register_setting( $option_group, 'mapfit_subtitle2' );
		register_setting( $option_group, 'mapfit_theme' );
		register_setting( $option_group, 'mapfit_pin' );

		register_setting( 'mapfit_tid', 'mapfit_tid' );

	}

}
