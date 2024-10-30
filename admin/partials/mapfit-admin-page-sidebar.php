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

$pinarr = [
	'default',
	'active',
	'airport',
	'arts',
	'auto',
	'bar',
	'cafe',
	'commercial',
	'community',
	'conference',
	'cooking',
	'education',
	'finance',
	'gas',
	'homegarden',
	'hospital',
	'hotel',
	'law',
	'market',
	'medical',
	'park',
	'pharmacy',
	'religion',
	'restaurant',
	'shopping',
	'sports',
];
?>

<form method="post" action="options.php">
	<?php settings_fields( 'mapfit-option-group' ); ?>
	<?php do_settings_sections( 'mapfit-option-group' ); ?>
<div class="mapfitform">
	<div class="col-sm-12">
	<div class="addressHdr">
		<h4 class="iframeHdr">ADDRESS</h4>
	</div>
		<input class="validate-required ng-pristine ng-valid ng-touched" type="text" maxlength="100" name="mapfit_address" value="<?php echo esc_attr( get_option( 'mapfit_address' ) ); ?>" placeholder="Enter your address (Required)"  >
	</div>
	<div>
	<div class="col-sm-12">
		<div class="col-sm-3">
		<div class="radioBtns">
			<div class="topRadio">
			<h4 class="iframeHdr">MAP STYLE</h4>
			</div>
			<div class="btmRadio">
				<label for="dayMap">
					<input id="dayMap" name="mapfit_theme"
						<?php
						if ( esc_attr( get_option( 'mapfit_theme' ) ) !== 'night' ) {
							echo 'checked';
						}
						?>
						type="radio" value="day">
					<img alt="Day map style" src="<?php echo esc_url( $img ); ?>light-style.png">
				</label>

				<label for="nightMap">
					<input id="nightMap" name="mapfit_theme" value="night"
						<?php
						if ( esc_attr( get_option( 'mapfit_theme' ) ) === 'night' ) {
							echo 'checked';
						}
						?>
						type="radio"  >
					<img alt="Night map style" src="<?php echo esc_url( $img ); ?>dark-style.png">
				</label> 
			</div>
			</div>
		</div>
		<div class="col-sm-9">
			<div class="input-select">
				<h4 class="iframeHdr">MARKER ICON</h4>

				<div id="selectOptsContainer"> 

				<select name="mapfit_pin" id="mapfit_pin">

				<?php $pinselected = get_option( 'mapfit_pin' ); ?> 
				<?php foreach ( $pinarr as $pin ) : ?>
				<?php $pin = ( 'pin' === $pinselected ) ? 'default' : $pin; ?>

					<option value="<?php echo esc_html( $pin ); ?>"
						<?php echo ( empty( $pinselected ) || $pin === $pinselected ) ? 'selected' : ''; ?> 
						data-imagesrc="<?php echo esc_html( $img . "pins/$pin.svg" ); ?>" >

							<?php echo ( esc_html( $pin ) === 'homegarden' ) ? 'Home Gardern' : ucwords( esc_html( $pin ) ); ?>

					</option>
				<?php endforeach; ?>

				</select>

			</div>
		</div>
		</div>
	</div>
	</div>
	<div class="col-sm-12">
		<h4 class="formHdr">CUSTOMIZE THE CARD</h4>
		<input class="validate-required ng-untouched ng-pristine ng-valid" maxlength="100" name="mapfit_title" value="<?php echo esc_attr( get_option( 'mapfit_title' ) ); ?>"placeholder="Enter a Title (Optional)" type="text" >
	</div>
	<div class="col-sm-12">
		<input class="validate-required ng-untouched ng-pristine ng-valid" maxlength="100" name="mapfit_subtitle1" value="<?php echo esc_attr( get_option( 'mapfit_subtitle1' ) ); ?>" placeholder="Enter a Subtitle (Optional)" type="text" >
	</div>
	<div class="col-sm-12">
		<input class="validate-required ng-untouched ng-pristine ng-valid" maxlength="100" name="mapfit_subtitle2" value="<?php echo esc_attr( get_option( 'mapfit_subtitle2' ) ); ?>" placeholder="Enter an Additional Subtitle (Optional)" type="text" >
	</div>

	<hr>

	<div class="col-sm-12">
		<button class="validate-required button gray" > Save your map </button>
		<?php //submit_button(); ?>
	</div>

	<hr>

	<div class="iframeContainer col-sm-12">
	  <div class="iframeTopRow">
		<h4 class="iframeHdr shortcode">SHORTCODE <span class="activation"> <?php echo ( ! $tid ) ? 'ACTIVATION REQUIRED' : ''; ?></span></h4>
		<div class="copyGroup" id="copyIcon">
				<img class="active" src = "<?php echo esc_html( $img . 'copy_default.svg' ); ?>" >
				<img src = "<?php echo esc_html( $img . 'copy_hover.svg' ); ?>" > 
		</div>
				<span class="copied-text">Copied</span>
	  </div>
	  <div class="shortcode">
		<input class="validate-required ng-untouched ng-pristine ng-valid" maxlength="100" id="mapfit_shortcode" name="mapfit_shortcode" disabled value="[mapfitmap width=&quot;100%&quot; height=&quot;500px&quot;]" type="text" >
	  </div>
	</div>

	<div>
	  <p id="termsLink">By using this code, you agree to our <a target="_blank" href="https://mapfit.com/terms">Terms of Service</a> </p>
	</div>

  </div>

</form>
