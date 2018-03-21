var neocate = {
	filteritem:"",
	learn: "",
	video: "<iframe src='https://www.youtube.com/embed/~~video~~?autoplay=1&rel=0&showinfo=0&volume=0&modestbranding=0'' frameborder='0' allowfullscreen></iframe><div class='video-close f24 uppercase white'>X</div>",
	sticky:"",
	comments:3,
	init:function(){
		neocate.initforms();
		neocate.initbuttons();
		neocate.initicons();
		jQuery("table").addClass("rtable").attr("width","100%");
		if(jQuery("table").attr("border") == "1"){
			jQuery("table").addClass("table-border");
		}
		jQuery("table").mousedown(function() {
			jQuery(this).addClass("hide-scroll");
		}).scroll(function() {
			jQuery(this).addClass("hide-scroll");
		});
		if(jQuery(".ismobile").is(":visible")) {
			jQuery(".rtable").each(function() {
				if(jQuery(window).width() > jQuery(".rtable").width()) {
					jQuery(".rtable").addClass("hide-scroll");
				}
			});
		}
		//Search
		jQuery(".utility-search > a, .search > a, .mobile-icons>.search").bind("click", function(e){
			e.preventDefault();
			jQuery(".search-wrapper").fadeIn(650);
		});
		jQuery(".search-close").bind("click", function() {
			jQuery(".search-wrapper").fadeOut(350);
		});
		jQuery(".search-full").bind("click", function(e) {
			e.preventDefault();
			if(jQuery(this).parent().find("input").val().trim() != "") {
				window.location = "/search/"+jQuery(this).parent().find("input").val().trim();
			} else {
				jQuery(this).val("");
			}
		});
		// HCP
		jQuery(".hcp-link").bind("click", function(e){
			e.preventDefault();
			jQuery(".hcp-popup").fadeIn(650);
		});
		jQuery(".hcp-no").bind("click", function(e){
			e.preventDefault();
			jQuery(".hcp-popup").fadeOut(650);
		});
		// Cart
		if(parseInt(neocate.getCookie("Cart")) > 0){
			jQuery(".utility-cart > a, .nav-primary > .cart > a, .mobile-menu .cart").addClass("has-items").attr("data-content",neocate.getCookie("Cart"));
		} else {
			jQuery(".utility-cart > a, .nav-primary > .cart > a, .mobile-menu .cart").removeClass("has-items").attr("data-content","");
		}
		jQuery(document).on('keyup',function(ev) {
			if(ev.keyCode === 27 && jQuery(".search-wrapper").is(":visible")) {
				jQuery(".search-wrapper").fadeOut(350);
			}
		});
		jQuery(".search-box").keypress(function(ev) {
			if(ev.which === 13) {
				if(jQuery(this).val().trim() != "") {
					window.location = "/search/"+jQuery(this).val().trim();
				} else {
					jQuery(this).val("");
				}
			}
		});
		// Home Slide
		jQuery(".home-carousel").each(function() {
			jQuery(this).owlCarousel({
				items:1,
				loop:true,
				dots:true,
				navText:["",""],
				nav: true
			});
		});
		//HCP Product Select
		jQuery(".product-specifics").on("change",function() {
			if(jQuery(this).val() != ""){
				jQuery(".hcp-reset").slideUp(250);
				jQuery("."+jQuery(this).val()).slideDown(700);
			}
		});
		// Expand Collapse
		jQuery(".expand").bind("click", function() {
			jQuery(this).toggleClass('collapse');
			jQuery(jQuery(this).attr("ref")).slideToggle(600);
		});
		// Expand Add Background
		jQuery(".condition").bind("click", function() {
			jQuery(this).parent().toggleClass('bg-lt-grey');
		});
		// Video Drop-down
		jQuery(".video-drop").bind("click", function() {
			if(jQuery(this).attr("ref") != ""){
				if(jQuery(".video-wrapper").is(":visible")) {
					jQuery(".video-wrapper").slideUp(350, function() {jQuery(".video-wrapper").html("")})
				} else {
					jQuery(".video-wrapper").html("").html(neocate.video.replace(/~~video~~/g, jQuery(this).attr("ref"))).slideDown(650);
					jQuery('html,body').animate({scrollTop: jQuery('.video-wrapper').offset().top-150},'slow');
					jQuery(".video-close").unbind().bind("click", function() {
						jQuery(".video-wrapper").slideUp(350, function() {jQuery(".video-wrapper").html("")})
					});
				}
			}
		});
		// Sharing
		jQuery(".show-share").bind("click", function(e) {
			e.preventDefault();
			jQuery(".neo-add-this").fadeToggle(500);
		});
		//Print
		jQuery(".print-button").bind("click", function(e){
			e.preventDefault();
			window.print();
		});
		// Learn More
		jQuery(".learn-more").bind("click", function(e) {
			e.preventDefault();
			var tmp=jQuery(this).attr("ref");
			jQuery(".learn-more").each(function() {jQuery(this).removeClass("active");});
			jQuery(this).addClass("active");
			if(jQuery(".ismobile").is(":visible")) {
				jQuery(".learn-more-content").each(function() {
					jQuery(this).slideUp(100);
				});
				if(tmp == neocate.learn) {
					jQuery(".learn-more-content-mobile").each(function() {
						if(jQuery(this).attr("ref") == tmp) {
							jQuery(this).slideUp(650);
							jQuery(this).removeClass("active");
						}
					});
				} else {
					jQuery(".learn-more-content-mobile").each(function() {
						if(jQuery(this).attr("ref") == tmp) {
							jQuery(this).slideDown(650);
						}
					});
					neocate.learn = tmp;
				}
			} else {
				jQuery(".learn-more-content-mobile").each(function() {
					jQuery(this).slideUp(100);
				});
				if(tmp == neocate.learn) {
					jQuery(".learn-more-content").each(function() {
						jQuery(this).slideUp(650);
					});
					jQuery(".learn-more").each(function() { jQuery(this).removeClass("active"); });
					neocate.learn = "";
				} else {
					jQuery(".learn-more-content").each(function() {
						if(jQuery(this).attr("ref") == tmp) {
							jQuery(this).slideDown(650);
						} else {
							jQuery(this).slideUp(650);
						}
					});
					neocate.learn = tmp;
				}
			}
		});
		// Contact Form
		jQuery(".contact-options").on("change",function() {
			if(jQuery(this).val() != "") {
				var tmp = jQuery(this).val();
				jQuery(".contact-answer").each(function() {
					if(jQuery(this).attr("ref")==tmp) {
						jQuery(this).slideDown();
					} else {
						jQuery(this).slideUp();
					}
				});
				if(jQuery(".form-thankyou").is(":visible")){
					jQuery(".form-thankyou").slideUp(500);
				}
				jQuery(".contact-form").slideDown(500);
				jQuery(".toaddress").val(jQuery("option:selected",this).attr("ref"));
			} else {
				jQuery(".contact-answer").slideUp(500);
				jQuery(".contact-form").slideUp(500);
				jQuery(".form-thankyou").slideUp(500);
			}
		});
		// Recipes
		jQuery(".recipe-link").mousedown(function() {
			neocate.savefilter(jQuery(this).attr("ref"), "single-recipe");
		});
		jQuery(".recipe-reset").mousedown(function() {
			if(jQuery(this).attr("ref")!="") {neocate.savefilter("reset","single-recipe");}
		});
		// Personalized Blog
		jQuery(".personalized-link-blog").mousedown(function() {
			if(jQuery(this).attr("ref")!="") { neocate.savefilter(jQuery(this).attr("ref"), "blog-filter"); }
		});
		// Store locator
		jQuery("#asl-storelocator div .search_filter p:first-child").text("Enter your City or Zip Code");
		// Select fix
		jQuery(".select-wrapper").bind("click", function() {
			jQuery("select", this).focus().trigger("open");
		});
	},
	getCookie: function(cname) {
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
	resetcookie: function(name,days){
		var expires = "";
		if (days) {
		    var date = new Date();
		    date.setTime(date.getTime() + (days*24*60*60*1000));
		    expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" +  ""  + expires + "; path=/";
	},
	savefilter: function(val, typ) {
		jQuery.ajax({
			type: "GET",
			url: "../../data/filter.php",
			dataType: "json",
			data: {
				   type:typ,
			                value:val
			},
			async: false
		});
	},
	initicons:function() {
		var exts = new Array("pdf","xls","doc","ppt","html");
		try {
		  jQuery(".button").each(function() {
		  	var ext = jQuery(this).attr("href").substring(jQuery(this).attr("href").lastIndexOf('.')+1, jQuery(this).attr("href").length).toLowerCase() || jQuery(this).attr("href");
		  	switch(ext){
		  		case "pdf":
					jQuery(this).addClass("files pdf");
					break;
		  		case "doc":
		  		case "docx":
					jQuery(this).addClass("files doc");
					break;
		  		case "xls":
		  		case "xlsx":
					jQuery(this).addClass("files xls");
					break;
		  		case "ppt":
		  		case "pptx":
					jQuery(this).addClass("files ppt");
					break;
		  		case "html":
		  		case "htm":
		  		case "php":
					jQuery(this).addClass("files html");
					break;
		  		case "jpg":
		  		case "jpeg":
		  		case "gif":
		  		case "png":
					jQuery(this).addClass("files image");
					break;
		  	}
		  });
		} catch(ex) {}
	},
	initbuttons:function() {
		jQuery(".button").bind("click", function(e) {
			if(jQuery(this).hasClass("disabled")) {
				e.preventDefault();
			} else {

			}
		});
	},
	initforms: function() {
		// Labels
		jQuery("input, textarea").focus(function() {
			jQuery(this).parent().find("label").fadeOut(500);
		}).blur(function() {
			if(jQuery(this).val() == "") {
				jQuery(this).parent().find("label").fadeIn(500);
			} 
		});
		jQuery("label").bind("click", function() {
			jQuery(this).fadeOut(500);
			jQuery(this).parent().find("input, textarea").focus();
		});
		// Reimbursement
		jQuery(".reimbursement-select").on("change",function() {
			if(jQuery(this).val() != ""){
				jQuery(".reimbursement-download").attr("href",jQuery(this).val()).removeClass("disabled");
			} else {
				jQuery(".reimbursement-download").attr("href","").addClass("disabled");
			}
		});
		jQuery(".reimbursement-states").on("change",function() {
			var st = jQuery(this).val().toLowerCase();
			var ctr=0;
			if(jQuery(this).val() != ""){
				jQuery(".reimbursement-product").each(function() {
					if(jQuery(this).attr("ref").indexOf(st) > 0){
						jQuery(this).fadeIn(500);
						ctr++;
					} else {
						jQuery(this).fadeOut(500);
					}
				});
				if(ctr < 1) {
					jQuery(".no-coverage").fadeIn(500);
				} else {
					jQuery(".no-coverage").fadeOut(500);
				}
				if(!jQuery(".reimbursement-results").is(":visible")) {
					jQuery(".reimbursement-results").slideDown(750)
				}
			} else {
				jQuery(".reimbursement-results").slideUp(750);
				jQuery(".reimbursement-product").each(function(){ jQuery(this).hide();})
			}
		});
		// Comments
		jQuery(".comment-load-more").bind("click", function(e) {
			e.preventDefault();
			var ctr=0;
			jQuery(".comment.fade-in").each(function() {
				if(!jQuery(this).is(":visible") && ctr < neocate.comments) {
					jQuery(this).removeClass("fade-in").css("display","block").animate({opacity:1}, 650);ctr++;
				}
			});
			if(!jQuery(".comment.fade-in").length) {
				jQuery(".comment-load-more").slideUp();
			}
		})
		try {
			jQuery(".comment-form").validate({
				errorLabelContainer: ".errorsummary ul",
				errorElement: 'span',
				wrapper: "er",
				rules: {
					author: "required",
					email: "required",
					comment: "required"
				},
				messages: {
					author:"Enter your name (Enter your name as you would like it to appear on our website).",
					email: {
						required: "Enter a valid email address. (Don't worry, your email address will not be published on the website; it’s simply to ensure our team can follow up with you directly, should we have a question about information you entered.)",
						email: "Please enter a valid email format, such as john@gmail.com."
					},
					comment:"Oops! Looks like you forgot to add your comment."
				},
				errorPlacement: function(error, element) {
					real_label = error.clone();
					real_label.insertAfter(element);
					element.blur(function(){
						if(jQuery(this).hasClass("errorfield")) { 
							jQuery(this).parent().find("er").fadeOut(350);
						}
					});                                                          
					element.focus(function(){                                    
						if(jQuery(this).hasClass("errorfield")) { 
							jQuery(this).parent().find("er").css("opacity","1").fadeIn(350);
						}
					});
					jQuery("er").hide(10);
				},
				highlight: function (element, errorClass, validClass) {
					jQuery(element).addClass("errorfield");
					jQuery(element).parent().addClass("errorparent");
				},
				unhighlight: function (element, errorClass, validClass) {
					jQuery(element).removeClass("errorfield");
					jQuery(element).parent().removeClass("errorparent");
				},
				focueCleanup:true,
				onfocusout: false,
				focusInvalid: true
			});
		} catch(e) {}
		jQuery("input, textarea").blur(function() {
			jQuery(this).valid();
		}).focus(function() {
			jQuery(this).parent().find("er").hide(350);
		})
		jQuery(".comment-form").submit(function(e){
			e.preventDefault();
			if(jQuery(".comment-form").valid() && neocate.checkcaptcha()) {
				jQuery(".comment-form .submit").hide();
				jQuery(".comment-save").show();
				jQuery.ajax({
					type: 'post',
					url: jQuery(".comment-form").attr('action'),
					data: jQuery(".comment-form").serialize(),
					error: function(XMLHttpRequest, textStatus, errorThrown){
						jQuery(".comment-save, .comment-write, .comment-form").slideUp(500);
						jQuery(".comment-errors").slideDown(500);
					},
					success: function(data, textStatus){
						jQuery(".comment-save, .comment-write, .comment-form").slideUp(500);
						jQuery(".comment-thanks").slideDown(500,function() {
							jQuery('html,body').animate({scrollTop: jQuery('.comment-thanks').offset().top-400},'slow');
						});
					}
				});
			}
			return false;
		});
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
		if(jQuery(".ismobile").is(":visible")) {
			jQuery(".recipe-item").unbind().bind("click", function() {
				if(!jQuery(".recipe-cover", this).is(":visible")) {
					jQuery(".recipe-cover, .alignmiddle", this).fadeIn(500);
				} else {
					jQuery(".recipe-cover, .alignmiddle", this).fadeOut(500);
				}
			});
			jQuery(".rtable").each(function() {
				if(jQuery(window).width() > jQuery(".rtable").width()) {
					jQuery(".rtable").addClass("hide-scroll");
				}
			});	
		} else {
			jQuery(".recipe-item").mouseenter(function() {
				jQuery(".recipe-cover, .alignmiddle", this).fadeIn(500);
			}).mouseleave(function() {
				jQuery(".recipe-cover, .alignmiddle", this).fadeOut(500);
			});
		}
	},
	loadstates: function(targetelement) {
    	var items = [];
	    jQuery.ajax({
	        type: "GET",
	        url: "/data/states.json",
	        dataType: "json",
	        success: function (data) {
	            items.push("<option value=\"\">Select State</option>");
	            jQuery.each(data, function (key, val) {
	                items.push("<option value=\"" + key + "\">" + val + "</option>");
	            });
	            jQuery(targetelement).html(items.join(""));
	        },
	        async: false
	    })
	},
	trackevent:function FpEvent(cat, act, lbl) {
		ga('send', 'event', cat, act, lbl);
	}
}
jQuery(document).ready(function(){
	neocate.init();	
})
jQuery(window).resize(function(){
	neocate.checkmobile();
});