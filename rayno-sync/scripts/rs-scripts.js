var rayno = {
	filename:"",
	days:"",
	tme:"",
	api:"",
	pge: 1,
	geo: 1,
	messages: ["Uploading the CSV file.", "Saving the settings.", "Saving Zoho information.", "Importing the Dealers", "Getting the Geolocation Data"],
	success: ["File uploaded successfully.","Settings saved correctly.","Zoho information saved successfully.","Dealers Imported Correctly", "Geolocation Synced Corrctly"],
	errors: ["There was a problem uploading the file.","There was a problem saving the settings.","There was a problem saving the Zhoh information.","There was an error importing the information.", "There was an error syncing the information."],
	init: function() {
		jQuery(".fUpload").bind("click", function(e) {
			e.preventDefault();
			var file = jQuery('#salesFile')[0].files[0];
			if (!file) {
				return;
			} else {
				jQuery(".overlay-content").text(rayno.messages[0]);
				jQuery(".overlay").fadeIn(750);
				rayno.fileupload();
			}
		});
		jQuery(".sSchedule").bind("click", function(e) {
			e.preventDefault();
			jQuery(".overlay-content").text(rayno.messages[1]);
			jQuery(".overlay").fadeIn(750);
			rayno.savesettings();
		});
		var days = jQuery("#formschedule").attr("ref");
		jQuery(".rscheck").each(function() {
			if(days.indexOf(jQuery(this).find("input").attr("value")) >= 0){
				jQuery(this).find("input").prop('checked', true).addClass("active");
			}
		});
		jQuery("#rsTime").val(jQuery("#formschedule").attr("ref2"));
		jQuery(".rscheck").bind("click", function() {
			jQuery(this).find("input").toggleClass("active");
		});
		jQuery(".zohoinfo").bind("click", function(e) {
			e.preventDefault();
			jQuery(".overlay-content").text(rayno.messages[0]);
			jQuery(".overlay").fadeIn(750);
			rayno.savezoho();
		});
		jQuery(".doimport").bind("click", function(e) {
			e.preventDefault();
			jQuery(".overlay-content").text(rayno.messages[3]);
			jQuery(".overlay").fadeIn(750);
			rayno.startimport();
		});
		jQuery(".geolocation").bind("click", function(e) {
			e.preventDefault();
			jQuery(".overlay-content").text(rayno.messages[4]);
			jQuery(".overlay").fadeIn(750);
			rayno.rungeo();
		});
	},
	fileupload: function() {
		var file = jQuery('#salesFile')[0].files[0];
		var formData = new FormData();
		formData.append('file', file);
		jQuery.ajax({
			url: '/wp-content/plugins/rayno-sync/admin/upload.php',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function (response) {
				switch (response.d.ReturnCode) {
					case 0:
						jQuery(".overlay-content").text(rayno.success[0]);
						jQuery(".currentfile").text(response.d.FileName);
						jQuery(".currentdate").text(response.d.nDate);
						jQuery(".currentuser").text(response.d.User);
						setTimeout("jQuery('.overlay').fadeOut();", 1650);
						break;
					case 1:
						jQuery(".overlay-content").text(rayno.errors[0]);
						setTimeout("jQuery('.overlay').fadeOut();", 1650);
						break;
					case 2:
						jQuery(".overlay-content").text(rayno.errors[0]);
						setTimeout("jQuery('.overlay').fadeOut();", 1650);
						break;
				}
			},
			error: function () {
				jQuery(".overlay-content").text(rayno.errors[0]);
				setTimeout("jQuery('.overlay').fadeOut();", 850);
			}
		});
	},
	savesettings: function() {
		var tmp="";
		jQuery(".rscheck").each(function() {
			if(jQuery(this).find("input").hasClass("active")) {
				tmp = tmp+jQuery(this).find("input").val()+",";
			}
		});
		jQuery.ajax({
			url: '/wp-content/plugins/rayno-sync/admin/save-settings.php',
			dataType: "json",
			contentType: "application/json;charset=utf-8",
			type: 'GET',
			cache: false,
			data: {
				days: tmp,
				tme: jQuery("#rsTime").val()
			},
			success: function (response) {
				jQuery(".overlay-content").text(rayno.success[1]);
				setTimeout("jQuery('.overlay').fadeOut();", 1650);
			},
			error: function () {
				jQuery(".overlay-content").text(rayno.errors[1]);
				setTimeout("jQuery('.overlay').fadeOut();", 1650);
			}
		});
	},
	savezoho: function() {
		jQuery.ajax({
			url: '/wp-content/plugins/rayno-sync/admin/save-zoho.php',
			dataType: "json",
			contentType: "application/json;charset=utf-8",
			type: 'GET',
			cache: false,
			data: {
				clientid: jQuery("#clientid").val(),
				clientsecret: jQuery("#clientsecret").val(),
				clientgranttype: jQuery("#granttype").val(),
				clientscope: jQuery("#scope").val(),
				clientsoid: jQuery("#soid").val()
			},
			success: function (response) {
				jQuery(".overlay-content").text(rayno.success[2]);
				setTimeout("jQuery('.overlay').fadeOut();", 1650);
			},
			error: function () {
				jQuery(".overlay-content").text(rayno.errors[2]);
				setTimeout("jQuery('.overlay').fadeOut();", 1650);
			}
		});
	},
	startimport: function() {
		rayno.pge = 1;
		rayno.doimport();
	},
	doimport: function() {
		jQuery.ajax({
			url: '/wp-content/plugins/rayno-sync/admin/page-import.php',
			dataType: "json",
			contentType: "application/json;charset=utf-8",
			type: 'GET',
			cache: false,
			data: {
				page: rayno.pge
			},
			success: function (response) {
				jQuery(".overlay-content").html(rayno.success[3]+"<br />Page "+rayno.pge);
				if(response.d.MoreRecords == 1) {
					rayno.pge++;
					rayno.doimport();
				} else {
					jQuery(".overlay-content").html("All Dealer Data Imported");
					setTimeout("jQuery('.overlay').fadeOut();", 1650);
				}
			},
			error: function () {
				jQuery(".overlay-content").text(rayno.errors[3]);
				setTimeout("jQuery('.overlay').fadeOut();", 1650);
			}
		});
	},
	startgoe: function() {
		rayno.geo = 1;
		rayno.rungeo();
	},
	rungeo: function() {
		jQuery.ajax({
			url: '/wp-content/plugins/rayno-sync/admin/geolocation.php',
			dataType: "json",
			contentType: "application/json;charset=utf-8",
			type: 'GET',
			cache: false,
			data: {
				page: rayno.pge
			},
			success: function (response) {
				jQuery(".overlay-content").html(rayno.success[4]+"<br />Page "+rayno.pge);
				console.log(response);
				if(response.d.MoreRecords == 1) {
					rayno.pge++;
					rayno.rungeo();
				} else {
					jQuery(".overlay-content").html("All Geolocation Data Imported");
					setTimeout("jQuery('.overlay').fadeOut();", 1650);
				}
			},
			error: function () {
				jQuery(".overlay-content").text(rayno.errors[4]);
				setTimeout("jQuery('.overlay').fadeOut();", 1650);
			}
		});
	}
}
jQuery(document).ready(function() {
	rayno.init();
});