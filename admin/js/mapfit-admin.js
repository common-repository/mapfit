(function ($) {
	'use strict';

	// swap marker with new address
	$("#mapfitbuilder input[name=mapfit_address] ").on('blur', function () {

		var address = $("input[name=mapfit_address]").val();

		// remove all markers & polygons!
		mv.removeLayer(defaultMarker)
		mv.eachLayer(
			function (l) {
				if (l.feature && l.feature.geometry.type === "Polygon") {
					l.remove()
				}
			}
		)

		// defaultMarker = mapfit.Marker()
		defaultMarker.address = address;

		placeInfo = mapfit.PlaceInfo();
		placeInfo.setTitle(address);

		defaultMarker.setIcon(myIcon)
		defaultMarker.setPlaceInfo(placeInfo)
		mv.addMarker(defaultMarker)
			.then(
				function () {
					defaultMarker.setPlaceInfoVisibility();
					mv.panTo(defaultMarker.getPosition())
				}
			)

	}
	)

	// swap theme
	$("#mapfitbuilder input[name=mapfit_theme]").on('click', function () {

		var theme = $("input[name=mapfit_theme]:checked").val();
		mv.remove();
		mv = mapfit.MapView('webEmbed', { 'theme': theme });

		$("#mapfitbuilder input[name=mapfit_address] ").blur();
		setTimeout(function(){ 
			$("#mapfitbuilder input[name=mapfit_title] ").change();
		},100)


	})

	// swap icon
	// $("#mapfitbuilder select[name=mapfit_pin] ").on('change', function () {
	// var pin = $("#mapfitbuilder select[name=mapfit_pin] ").val();
	// var pin = jQuery("#mapfitbuilder .dd-selected-value").val();
	// myIcon.setIconUrl(pin)
	// defaultMarker.remove()
	// defaultMarker.setIcon(myIcon)
	// mv.addMarker(defaultMarker)
	// })
	// swap icon with dd
	$('#mapfit_pin').ddslick(
		{
			width: "100%",
			defaultSelectedIndex: 1,
			imagePosition: "left",
			onSelected: function (data) {
				$('.dd-selected-value').attr('name', 'mapfit_pin');
				// console.log("pin = ", data);
				var pin = data.selectedData.value;
				if (myIcon && defaultMarker && mv) {
					if (pin == 'default')
						pin = 'pin'
					myIcon.setIconUrl(pin)
					defaultMarker.remove()
					defaultMarker.setIcon(myIcon)
					mv.addMarker(defaultMarker)
				}
			}
		}
	);

	// swap card title
	$("#mapfitbuilder input[name=mapfit_title], input[name^=mapfit_subtitle] ").on(
		'change', function () {
			var title = $("#mapfitbuilder input[name=mapfit_title] ").val();
			var subtitle1 = $("#mapfitbuilder input[name=mapfit_subtitle1] ").val();
			var subtitle2 = $("#mapfitbuilder input[name=mapfit_subtitle2] ").val();

			var address = $("input[name=mapfit_address]").val();
			placeInfo = mapfit.PlaceInfo();

			if (title != "" || subtitle1 != "" || subtitle2 != "") {
				placeInfo.setTitle(title);
				if (subtitle1 != "" || subtitle2 != "") {
					placeInfo.setDescription("<p>" + subtitle1 + "<br>" + subtitle2 + "</p>")

				}
			} else if (title == "") {
				placeInfo = mapfit.PlaceInfo();
				placeInfo.setTitle(address);
			}

			// fix icon
			defaultMarker.remove()
			// var pin = $("#mapfitbuilder select[name=mapfit_pin] ").val();
			var pin = jQuery("#mapfitbuilder .dd-selected-value").val();
			myIcon.setIconUrl(pin)

			// enable directions
			// placeInfo.enableDirectionsButton(false)
			defaultMarker.setPlaceInfo(placeInfo)
			mv.addMarker(defaultMarker)
				.then(
					function () {
						defaultMarker.setIcon(myIcon)
						defaultMarker.setPlaceInfoVisibility();
					}
				)
		}
	)

	$("#copyIcon").click(
		function () {
			var copyText = document.getElementById("mapfit_shortcode");

			copyText.disabled = false;
			copyText.select();
			copyText.disabled = true;

			document.execCommand("Copy");
			$('.copied-text').show();
			setTimeout(function(){
				$('.copied-text').fadeOut(); 
			},2000)
		}
	)

	$('#mapfit-connect').click(
		function () {
			var email = $('form[name=mapfit-connect] [name=email] ').val();
			var domain = $('form[name=mapfit-connect] [name=domain] ').val();
			var nonce = $('form[name=mapfit-connect] [name=mapfit_nonce] ').val();
			var data = { email: email, domain: domain, mapfit_nonce: nonce };

			$.post("https://dash.mapfit.com/api/gettoken/", data)
				.done(
					function (tid) {

						var data = {
							'action': 'wpmapfit_save_token',
							'tid': tid.tid,
							'mapfit_nonce': nonce
						}
						$.post(
							ajaxurl, data, function (response) {
								// reload map with tid
								window.location.reload();
							}
						)

					}
				);

		}
	)

})(jQuery);


var theme = jQuery("input[name=mapfit_theme]:checked").val();
var mv = mapfit.MapView('webEmbed', { theme: theme || "day" })
// var mapEvents = mv.drawMap();

function formatInfoCardDescription(subtitle1, subtitle2) {
	return "<p>" + subtitle1 + "<br>" + subtitle2 + "</p>"
}

function rebuildMap() {
	mv.options.mapObject.remove();
	mv.drawMap();
}


var myIcon = mapfit.Icon();
// // var pin = jQuery("#mapfitbuilder select[name=mapfit_pin] ").val();
var pin = jQuery("#mapfitbuilder .dd-selected-value").val();
if (pin == 'default')
	pin = 'pin'
// console.log(" pin on load = ", pin)
myIcon.setIconUrl(pin)
var defaultMarker = mapfit.Marker()
defaultMarker.setIcon(myIcon)
// //default address
var newAddress = jQuery("input[name=mapfit_address]").val();

// //default placeinfo
var newTitle = jQuery("input[name=mapfit_title]").val();
var newSubtitle1 = jQuery("input[name=mapfit_subtitle1]").val();
var newSubtitle2 = jQuery("input[name=mapfit_subtitle2]").val();

if (newAddress != "") {
	defaultMarker.address = newAddress;

	var placeInfo = mapfit.PlaceInfo();
	if (newTitle != "" || newSubtitle1 != "" || newSubtitle2 != "") {
		placeInfo.setTitle(newTitle)
		placeInfo.setDescription(newSubtitle1 + "<br>" + newSubtitle2)
		// placeInfo.enableDirectionsButton(true)
	}


	defaultMarker.setPlaceInfo(placeInfo)
	// add marker & recenter
	mv.addMarker(defaultMarker)
		.then(
			function () {

				// mv.options.mapObject.panTo( defaultMarker.getPosition() )
				mv.panTo(defaultMarker.getPosition())
				defaultMarker.setPlaceInfoVisibility();

			}
		)
}
