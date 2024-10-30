<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://mapfit.com
 * @since      1.0.0
 *
 * @package    Mapfit
 * @subpackage Mapfit/admin/partials
 */

?>

<?php
	$current_user = wp_get_current_user();
	$current_site = get_site_url();
?>

<div class='notification'><h1>Activate Your Map</h1><p>
<p>Please connect to activate your Mapfit map.</p>
<form name="mapfit-connect" method="POST" > 
	<?php wp_nonce_field( 'mapfit_connect_action', 'mapfit_nonce' ); ?>
	<label>Email</label>
	<input type="text" name="email" width="100%" value="<?php echo esc_attr( $current_user->user_email ); ?>" >
	<br>
	<label>Domain</label>
	<input type="text" name="domain" value="<?php echo esc_attr( $current_site ); ?>" >
</form>
<button  id="mapfit-connect" class="button" href="#" target="_blank"> Connect Mapfit</button>
<p></p>

<?php
echo '</div>';
