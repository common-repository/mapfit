<?php
/**
 * Class Template - a very simple PHP class for rendering PHP templates
 *
 * @link       https://mapfit.com
 * @since      1.0.0
 *
 * @package    Mapfit
 * @subpackage Mapfit/includes
 */

/**
 * Class Template - a very simple PHP class for rendering PHP templates
 *
 * @since      1.0.0
 * @package    Mapfit
 * @subpackage Mapfit/includes
 * @author     Bogdan Bodnarescu <bogdan@mapfit.com>
 */
class Mapfit_Template {

	/**
	 * Location of expected template
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $folder
	 */
	public $folder;

	/**
	 * Template constructor.
	 *
	 * @param string $folder Location of template.
	 */
	public function __construct( $folder = null ) {
		if ( $folder ) {
			$this->set_folder( $folder );
		}
	}

	/**
	 * Simple method for updating the base folder where templates are located.
	 *
	 * @param string $folder Location of template.
	 */
	public function set_folder( $folder ) {
		// normalize the internal folder value by removing any final slashes.
		$this->folder = rtrim( $folder, '/' );
	}

	/**
	 * Find and attempt to render a template with variables
	 *
	 * @param string $suggestions Suggestion path.
	 * @param array  $variables Template vars.
	 *
	 * @return string
	 */
	public function render( $suggestions, $variables = array() ) {
		$template = $this->find_template( $suggestions );
		$output   = '';
		if ( $template ) {
			$output = $this->render_template( $template, $variables );
		}
		return $output;
	}

	/**
	 * Look for the first template suggestion
	 *
	 * @param string $suggestions Suggestion path.
	 *
	 * @return bool|string
	 */
	public function find_template( $suggestions ) {
		if ( ! is_array( $suggestions ) ) {
			$suggestions = array( $suggestions );
		}
		$suggestions = array_reverse( $suggestions );
		$found       = false;
		foreach ( $suggestions as $suggestion ) {
			$file = "{$this->folder}/{$suggestion}.php";
			if ( file_exists( $file ) ) {
				$found = $file;
				break;
			}
		}
		return $found;
	}

	/**
	 * Execute the template by extracting the variables into scope, and including
	 * the template file.
	 *
	 * @internal param $template
	 * @internal param $variables
	 *
	 * @return string
	 */
	public function render_template() {
		ob_start();
		foreach ( func_get_args()[1] as $key => $value ) {
			${$key} = $value;
		}
		include func_get_args()[0];
		return ob_get_clean();
	}
}
