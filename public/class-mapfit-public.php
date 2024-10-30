<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://mapfit.com
 * @since      1.0.0
 *
 * @package    Mapfit
 * @subpackage Mapfit/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mapfit
 * @subpackage Mapfit/public
 * @author     Bogdan Bodnarescu <bogdan@mapfit.com>
 */
class Mapfit_Public {


	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $mapfit    The ID of this plugin.
	 */
	private $mapfit;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	/**
	 * Template rendering
	 *
	 * @var string $tmpl
	 */
	private $tmpl;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $mapfit       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $mapfit, $version ) {

		$this->mapfit  = $mapfit;
		$this->version = $version;

		// load template render.
		$tpl       = new Mapfit_Template( dirname( __FILE__ ) . '/partials' );
		$this->tpl = $tpl;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mapfit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mapfit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'mapfit', '//cdn.mapfit.com/v2-3/assets/css/mapfit.css', array(), false, 'all' );
		wp_enqueue_style( 'mapfit-public', plugin_dir_url( __FILE__ ) . 'css/mapfit-public.css', array(), false, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mapfit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mapfit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'mapfit-map-tetragon', '//cdn.mapfit.com/v2-3/assets/js/tetragon.js', array(), $this->version, false );
		wp_enqueue_script( 'mapfit-map-script', '//cdn.mapfit.com/v2-3/assets/js/mapfit.js', array(), $this->version, false );

		wp_enqueue_script( $this->mapfit, plugin_dir_url( __FILE__ ) . 'js/mapfit-public.js', array( 'jquery' ), $this->version, true );

	}

}
