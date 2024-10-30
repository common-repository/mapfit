<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://mapfit.com
 * @since      1.0.0
 *
 * @package    Mapfit
 * @subpackage Mapfit/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Mapfit
 * @subpackage Mapfit/includes
 * @author     Bogdan Bodnarescu <bogdan@mapfit.com>
 */
class Mapfit_Deactivator {


	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		$option_group = 'mapfit-option-group';
		unregister_setting( $option_group, 'mapfit_marker' );
		unregister_setting( $option_group, 'mapfit_placeinfo' );
		unregister_setting( $option_group, 'mapfit_map' );

		unregister_setting( $option_group, 'mapfit_address' );
		unregister_setting( $option_group, 'mapfit_title' );
		unregister_setting( $option_group, 'mapfit_subtitle1' );
		unregister_setting( $option_group, 'mapfit_subtitle2' );
		unregister_setting( $option_group, 'mapfit_theme' );
		unregister_setting( $option_group, 'mapfit_pin' );

		unregister_setting( 'mapfit_tid', 'mapfit_tid' );

		delete_option( 'mapfit_marker' );
		delete_option( 'mapfit_placeinfo' );
		delete_option( 'mapfit_map' );

		delete_option( 'mapfit_address' );
		delete_option( 'mapfit_title' );
		delete_option( 'mapfit_subtitile1' );
		delete_option( 'mapfit_subtitile2' );
		delete_option( 'mapfit_theme' );
		delete_option( 'mapfit_pin' );

		delete_option( 'mapfit_tid' );
	}


}
