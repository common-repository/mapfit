<script>
//use global class

mapfit.apikey = "<?php echo esc_js( $apikey ); ?>";

var theme ="<?php echo esc_attr( get_option( 'mapfit_theme' ) ); ?>";
var pin = "<?php echo esc_attr( get_option( 'mapfit_pin' ) ); ?>";
if(pin == 'default') pin = 'pin';
var address = "<?php echo esc_attr( get_option( 'mapfit_address' ) ); ?>";
var title = "<?php echo esc_attr( get_option( 'mapfit_title' ) ); ?>";
var subTitle1 = "<?php echo esc_attr( get_option( 'mapfit_subtitle1' ) ); ?>";
var subTitle2 = "<?php echo esc_attr( get_option( 'mapfit_subtitle2' ) ); ?>";


var mv = mapfit.MapView('webEmbed', { theme: theme})

var myIcon = mapfit.Icon();
myIcon.setIconUrl(pin)

var defaultMarker = mapfit.Marker()
defaultMarker.address = address || "119 w 24th st, New York, NY";
defaultMarker.setIcon(myIcon)

var placeInfo = mapfit.PlaceInfo();
if( title || subTitle1 || subTitle2 ){
	placeInfo.setTitle(title);
	placeInfo.setDescription(subTitle1+"<br>"+subTitle2);
}
defaultMarker.setPlaceInfo(placeInfo)

//add marker & recenter
mv.addMarker(defaultMarker)
	.then(function () {
		mv.panTo(defaultMarker.getPosition())
		defaultMarker.setPlaceInfoVisibility();
	})

</script>
