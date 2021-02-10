var ds_chatfuel = {
	init: function() {
		jQuery(".ds-specials").text(directory+'/json/specials/');
		jQuery(".ds-pricing").each(function() {
			jQuery(this).text(directory+'/json/floorplans/?type='+jQuery(this).attr("ref"));
		});
		jQuery(".ds-gallery").text(directory+'/json/gallery/');
		jQuery(".ds-id").text(directory+'/json/apprent/getid');
		jQuery(".ds-tour").text(directory+'/json/apprent/checkdate');
	}
}
jQuery(document).ready(function() {
	ds_chatfuel.init();
})