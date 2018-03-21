var agsn = {
	dte: new Date(),
	count: 600,
	init: function() {
		$(".phone, .nphone").mask("(999) 999-9999");
		$(".zip").mask("99999");
		jQuery("a").bind("click", function() {
			agsn.trackevent(jQuery(this).attr("ref"), "Click", jQuery(this).attr("title"));
		});
		jQuery("label").bind("click", function() {
			jQuery(this).parent().find("input, select").click();
		});
		jQuery("input, select, textarea").focus(function() {
			jQuery(this).parent().find("label, .optional").fadeOut(375);
		}).blur(function() {
			if(jQuery(this).val() == "" || jQuery(this).val() == null){
				jQuery(this).parent().find("label, .optional").fadeIn(375);
			}
		});
		jQuery(".checkbox").bind("click", function() {
			jQuery(".check",this).toggleClass('active');
		});
		jQuery(".nominate-now, .fill-out-form").bind("click", function(e) {
			e.preventDefault();
			jQuery("html, body").animate({ scrollTop: jQuery(".nominate").offset().top-150}, 1000);
		});
		jQuery(".vote-now").bind("click", function(e) {
			e.preventDefault();
			jQuery("html, body").animate({ scrollTop: jQuery(".voting").offset().top-150}, 1000);
		});
		jQuery(".nominate").validate({
		    errorLabelContainer: ".errorsummary ul",
		    wrapper: "li",
		    highlight: function (element, errorClass, validClass) {
		        jQuery(element).addClass("errorfield");
		        jQuery(element).parent().find("label").addClass("counterror");
		        //jQuery(element).focus();
		    },
		    unhighlight: function (element, errorClass, validClass) {
		        jQuery(element).removeClass("errorfield");
		        jQuery(element).parent().find("label").removeClass("counterror");
		    },
		    onfocusout: false,
		    focusInvalid: true
		});
		jQuery("textarea").bind("keyup blur focus", function() {
			var count = jQuery(this).val().length;
			if(parseInt(count) > agsn.count) {
				jQuery(this).val(jQuery(this).val().substring(0,agsn.count));
				jQuery(this).addClass("errorfield");
				jQuery(".count").addClass("counterror");
			} else {
				jQuery(this).removeClass("errorfield");
				jQuery(".count").removeClass("counterror");
			}
			jQuery(".count").text(count+"/"+agsn.count);
		});
		jQuery(".submit").bind("click", function(e) {
			jQuery("input, select").each(function() {
				var tmp = $.trim(jQuery(this).val());
				jQuery(this).val(tmp);
			});
			e.preventDefault();
			if(agsn.fullvalidate()) {
				if(grecaptcha.getResponse() != "") {
					jQuery(".submit").hide();
					jQuery(".loading").show();
					jQuery(".g-recaptcha").removeClass("errorfield");
					agsn.savenomination().then(function(data){
						var result = data.d;
						switch (result.ReturnCode) {
							case 0:
								jQuery(".thankyou").show();
								jQuery(".nomination").slideUp(750, function() {
									jQuery("html, body").animate({ scrollTop: jQuery(".thankyou").offset().top}, 600);
									jQuery(".nominate-now").css({"opacity":0,"cursor":"default"}).unbind("click");
								});
								break;
							default:

								break;
						}
					});
				} else {
					jQuery(".g-recaptcha").addClass("errorfield");
				}
			}
		});
		try {
			agsn.loadstates();
		} catch(ex) {}
	},
	fullvalidate: function() {
		var isok = false;
		if(jQuery(".checkbox > .check").hasClass("active")) {
			jQuery(".checkbox").removeClass("errorfield");
			isok = true;
		} else {
			jQuery(".checkbox").addClass("errorfield");
		}
		if(!agsn.validateEmail(jQuery(".email").val())) {
			jQuery(".email").addClass("errorfield2").focus();
			isok = false;
		} else {
			jQuery('.email').removeClass(".errorfield2");
		}
		if(jQuery(".nominate").valid()) {
			return isok;
		} else {
			return false;
		}
	},
	validateEmail: function(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	},
	savenomination: function() {
	    var str = $(".comments").val();
	    str = str.replace(/'/g, "''");
	    //str = str.replace(/"/g, '""');
                return $.ajax({
                    type: "GET",
                    contentType: "application/json;charset=utf-8",
                    url: "/data/insert.php",
                    data: {
                        nfirstname:$(".nfirstname").val(),
                        nlastname:$(".nlastname").val(),
                        nemail:$(".nemail").val(),
                        nphone:$(".nphone").val(),
                        nknow:$(".nknow").val(),
                        firstname:$(".firstname").val(),
                        lastname:$(".lastname").val(),
                        school:$(".school").val(),
                        phone:$(".phone").val(),
                        address:$(".address").val(),
                        city:$(".city").val(),
                        state:$(".state").val(),
                        zip:$(".zip").val(),
                        comments:str,
                        rules:"true"
                    },
                    dataType: "json"
                }).promise();

	},
	trackevent:function FpEvent(cat, act, lbl) {
		//ga('send', 'event', cat, act, lbl);
	},
	loadstates: function() {
		var items = [];
		jQuery.ajax({
			type: "GET",
			url: "../data/states.json",
			dataType: "json",
			success: function (data) {
				items.push("<option value=\"\">            </option>");
				jQuery.each(data, function (key, val) {
					items.push("<option value=\"" + key + "\">" + val + "</option>");
				});
				jQuery(".state").html(items.join(""));
			},
			async: false
		});
	}
}
jQuery(document).ready(function() {
	agsn.init();
});