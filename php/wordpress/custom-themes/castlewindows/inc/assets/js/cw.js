var cw = {
	formcheck: "",
	init:function(){
		jQuery(".mobile-expand").bind("click", function() {
			jQuery(".mobile-full-menu").slideToggle(650);
		});
		jQuery(".mobile-full-menu>ul>li").removeClass("dropdown");
		jQuery(".dropdown").mouseenter(function() {
			jQuery(".sub-menu", this).stop().slideDown();
		}).mouseleave(function() {
			jQuery(".sub-menu", this).stop().slideUp();
			jQuery(".sub-menu").css({height:"auto"});
		});
		jQuery(".no-link>a").bind("click",function(e) {
			e.preventDefault();
			return false;
		});
		jQuery(".nav-bar").mouseenter(function() {
			jQuery(".shine").addClass("shineeffect");
			setTimeout('jQuery(".shine").removeClass("shineeffect")', 3500);
		});
		cw.formcheck = setInterval("cw.bindbuttons();", 750);
		cw.setutm();
	},
	bindbuttons: function() {
		jQuery(".elementor-field-type-submit > button").unbind("mousedown").bind("mousedown", function() {
			jQuery(".elementor-field-group-utm_source > input").val(cw.getcookie("utm_source"));
			jQuery(".elementor-field-group-utm_campaign > input").val(cw.getcookie("utm_campaign"));
			jQuery(".elementor-field-group-orig_referrer > input").val(cw.getcookie("orig_referrer"));
			jQuery(".elementor-field-group-last_referrer > input").val(cw.getcookie("last_referrer"));
		});
	},
	setutm: function() {
		var tmp = cw.getcookie("utm_source");
		var src="";
		if(tmp == "") {
			src = cw.getParam("utm_source");
			cw.setcookie("utm_source", src, 1);
		}
		tmp = cw.getcookie("utm_campaign");
		if(tmp == "") {
			src = cw.getParam("utm_campaign");
			cw.setcookie("utm_campaign", src, 1);
		}
		tmp = cw.getcookie("orig_referrer");
		if(tmp == "") {
			src = document.referrer == "" ? "Direct" : document.referrer;
			cw.setcookie("orig_referrer", src, 1);
		}
		cw.setcookie("last_referrer",cw.getcookie("last_referrer_tmp"), 1);
		cw.setcookie("last_referrer_tmp", window.location.href, 1);
	},
	setcookie: function(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	},
	getcookie: function(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
			  c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
			  return c.substring(name.length, c.length);
			}
		}
		return "";
	},
	checkcaptcha: function() {
		var response = jQuery('#g-recaptcha-response').val();
		if(response.length == 0) {
			jQuery(".g-recaptcha").addClass("errorfield");
			return false;
		} else {
			jQuery(".g-recaptcha").removeClass("errorfield");
			return true;
		}
	},
	checkmobile: function() {

	},
	getParam: function(name) {
        if(window.location.href.indexOf(name) > 0) {
        	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            return decodeURIComponent(results[1]);
        } else {
        	var ref = document.referrer;
        	if(ref == "" || ref == undefined) {
        		ref="Direct";
        	}
            return ref;
        }
    },
	trackevent:function FpEvent(cat, act, lbl) {
		ga('send', 'event', cat, act, lbl);
	}
}
jQuery(document).ready(function(){
	cw.init();	
})
jQuery(window).resize(function(){
	cw.checkmobile();
});
jQuery(window).scroll(function() {
	if(jQuery(this).scrollTop() > 80) {
		jQuery(".nav-bar").removeClass("transparent");
		jQuery(".nav-bar").removeClass("transparent");
	} else {
		jQuery(".nav-bar").addClass("transparent");
	}
});