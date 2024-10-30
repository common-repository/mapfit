<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://mapfit.com
 * @since      1.0.0
 *
 * @package    Mapfit
 * @subpackage Mapfit/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mapfit
 * @subpackage Mapfit/admin
 * @author     Bogdan Bodnarescu <bogdan@mapfit.com>
 */
class Mapfit_Admin {


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
	 * The access level
	 *
	 * @var string
	 */
	private $access_level = 'manage_options';

	/**
	 * Token ID
	 *
	 * @var string
	 */
	private $tid;

	/**
	 * API KEY
	 *
	 * @var string
	 */
	private $apikey = '591dccc4e499ca0001a4c6a4fbcd46efacf8456c9dbf583bc6f5eb6e';

	/**
	 * Default option group
	 *
	 * @var string
	 */
	private $option = 'mapfit-plugin-settings-group';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $mapfit       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $mapfit, $version ) {

		$this->mapfit  = $mapfit;
		$this->version = $version;

		$this->register_mapfitsettings();
		$this->tid = esc_attr( get_option( 'mapfit_tid' ) );
		$this->load_dependencies();

	}

	/**
	 * The class responsible for template rendering
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mapfit-template.php';

		$tpl       = new Mapfit_Template( dirname( __FILE__ ) . '/partials' );
		$this->tpl = $tpl;

		if ( $this->tid ) {
			add_shortcode( 'mapfitmap', array( $this, 'wpmapfit_shortcode' ) );
		}

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( 'mapfit-styles', '//cdn.mapfit.com/v2-3/assets/css/mapfit.css', array(), false, 'all' );
		wp_enqueue_style( 'mapfit-admin', plugin_dir_url( __FILE__ ) . 'css/mapfit-admin.css', array(), false, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( 'ddslick', plugin_dir_url( __FILE__ ) . 'js/jquery.ddSlick.min.js', array(), $this->version, false );
		wp_enqueue_script( $this->mapfit, plugin_dir_url( __FILE__ ) . 'js/mapfit-admin.js', array(), $this->version, true );
	}

	/**
	 * MAIN MENU
	 * build main menu
	 */
	public function wpmapfit_admin_menu() {

		if ( isset( $_GET['page'] ) == 'wpmapfit-menu' ) {

			$this->enqueue_styles();
			$this->enqueue_scripts();

		}
		$menu = add_menu_page( 'WPMapfit', __( 'Mapfit', 'wpmapfit' ), $this->access_level, 'wpmapfit-menu', array( $this, 'wpmapfit_map_page' ), $this->get_plugin_url() . 'images/mapfit-icon.svg' );

	}

	/**
	 * Save token ajax
	 *
	 * @return void
	 */
	public function wpmapfit_save_token() {
		if ( ! isset( $_POST['mapfit_nonce'] ) || ! wp_verify_nonce( $_POST['mapfit_nonce'], 'mapfit_connect_action' ) ) {
			wp_die( 'Sorry, your nonce did not verify. Please try again later.' );
		}
		if ( isset( $_POST['tid'] ) ) {
			$tid = wp_unslash( $_POST['tid'] );
			$tid = sanitize_text_field( $tid );
		}

		if ( get_option( 'mapfit_tid' ) !== false ) {
			update_option( 'mapfit_tid', $tid );
		} else {
			add_option( 'mapfit_tid', $tid );
		}

		echo json_encode(
			[
				'tid'    => $tid,
				'status' => 'success',
				'nonce'  => 'verified',
			]
		);

		wp_die(); // this is required to terminate immediately and return a proper response.
	}


	/**
	 * WP Mapfti Admin page
	 *
	 * @return void
	 */
	public function wpmapfit_map_page() {

		$url = plugin_dir_url( __FILE__ );

		echo '<div id="mapfitbuilder">';
		echo '<div class="mapfitsidebar">';

		// header image.
		print wp_kses_post( $this->tpl->render(
			'mapfit-admin-page-header',
			[
				// 'tid' => $this->tid, // pass tid to remove activation message.
				'img' => $url . 'images/',
			]
		));

		// api_key notification.
		if ( ! $this->tid ) {
			print $this->tpl->render( 'mapfit-admin-notification' );
		}

		// sidebar.
		print $this->tpl->render(
			'mapfit-admin-page-sidebar',
			[
				'tid'    => esc_url( $this->tid ), // pass tid to remove activation message.
				'img'    => esc_url( $url ) . 'images/',
				'pinurl' => esc_url( $url ) . 'images/pins/',
			]
		);

		echo '</div>';

		print $this->tpl->render( 'mapfit-admin-page', [ 'apikey' => $this->merge_token() ] );

		echo '</div>';

	}

	/**
	 * Shortcode
	 *
	 * @param string $atts width & height of the shortcode wrapper.
	 * @return string returns the mapfit wrapper with the specied width & height
	 */
	public function wpmapfit_shortcode( $atts ) {
		$a = shortcode_atts(
			array(
				'width'  => '100%',
				'height' => '400px',
			), $atts
		);

		$script = $this->tpl->render( 'mapfit-map-script', [ 'apikey' => $this->merge_token() ] );
		return "<div id='webEmbed' style=\" width:{$a['width']}; height:{$a['height']} \" ></div>" . $script;

	}


	/**
	 * Get Plugin Url
	 *
	 * @return string
	 */
	public function get_plugin_url() {
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * Register Options
	 *
	 * @return void
	 */
	public function register_mapfitsettings() {
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



	/**
	 * Settings Page
	 *
	 * @return void
	 */
	public function wpmapfit_menu_settings_layout() {
		?>
	<div class="wrap">
	<h1>Mapfit Settings</h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'mapfit-plugin-settings-group' ); ?>
		<?php do_settings_sections( 'mapfit-plugin-settings-group' ); ?>
		<table class="form-table">
			<tr valign="top">
			<th scope="row">Theme</th>
			<td><input type="text" name="mapfit_theme" value="<?php echo esc_attr( get_option( 'mapfit_theme' ) ); ?>" /></td>
			</tr>
			<th scope="row">Address</th>
			<td><input type="text" name="mapfit_address" value="<?php echo esc_attr( get_option( 'mapfit_address' ) ); ?>" /></td>
			</tr>
			<th scope="row">Title</th>
			<td><input type="text" name="mapfit_title" value="<?php echo esc_attr( get_option( 'mapfit_title' ) ); ?>" /></td>
			</tr>
			<th scope="row">Marker</th>
			<td><input type="text" name="mapfit_marker" value="<?php echo esc_attr( get_option( 'mapfit_marker' ) ); ?>" /></td>
			</tr>

			<tr valign="top">
			<th scope="row">Place Info</th>
			<td><input type="text" name="mapfit_placeinfo" value="<?php echo esc_attr( get_option( 'mapfit_placeinfo' ) ); ?>" /></td>
			</tr>

			<tr valign="top">
			<th scope="row">Map</th>
			<td><input type="text" name="mapfit_map" value="<?php echo esc_attr( get_option( 'mapfit_map' ) ); ?>" /></td>
			</tr>
		</table>

		<?php submit_button(); ?>

	</form>
	</div>
	<?php
	}

	/**
	 * Merge Token with API key
	 *
	 * @return string
	 */
	private function merge_token() {
		// $tid = esc_attr(get_option('mapfit_tid') );
		if ( $this->tid ) {
			$apikey = $this->apikey . "&tid=$this->tid";
		} else {
			$apikey = $this->apikey;
		}

		return $apikey;

	}

}
