var vote ={
	email:"",
	selected: "",
	pincode:"",
	items: "",
	base:"<div class='vote-item inline msmall mbsmall' ref='~id~'><div class='one-third-vote one-third-left-lg inline top right'><img src='images/states/~state-image~@2x.png' alt='~state~' /></div><div class='two-thirds-sm inline top left'><div class='f26'>~name~</div><div class='f24'>~state~</div><div class='f16'>~school~</div></div></div>",
	desktop: 9,
	mobile: 8,
	owl: "",
	resizing:"",
	ismobile: false,
	init: function() {
		vote.checkmobile(true);
		vote.loadfinalists();
		vote.email = vote.getparameter("email");
		vote.pincode = vote.getparameter("pincode");
		if(vote.email != "" && vote.pincode != "") {
			jQuery.ajax({
				type: "GET",
				url: "../data/vote.php",
			            data: {
			                action:"confirm",
			                email:vote.email,
			                pincode:vote.pincode
			            },
				dataType: "json",
				success: function (data) {
					switch(data.d.ReturnCode) {
						case 2:
							// Vote Confirmed
							jQuery(".confirm-info").text(vote.selected.name+" from "+vote.selected.state);
							agsn.trackevent("Voting", "Confirm", "Confirmed");
							jQuery(".confirm-vote").slideDown(750, function() {
								jQuery("html, body").animate({ scrollTop: jQuery(".confirm-vote").offset().top-150}, 1000);
							});
							break;
						case 3:
							// Already Confirmed
							jQuery(".confirm-info").text(vote.selected.name+" from "+vote.selected.state);
							agsn.trackevent("Voting", "Confirm", "Already");
							jQuery(".confirm-vote").slideDown(750, function() {
								jQuery("html, body").animate({ scrollTop: jQuery(".confirm-vote").offset().top-150}, 1000);
							});
							break;
					}
				},
				async: false
			});
		} else {
			jQuery(".voting").slideDown(750);
		}
		jQuery(".sort").change(function() {
			switch (jQuery(this).val()) {
				case "f1":
					vote.sortitems(vote.items, "name", true);
					break;
				case "f2":
					vote.sortitems(vote.items, "name", false);
					break;
				case "s1":
					vote.sortitems(vote.items, "school", true);
					break;
				case "s2":
					vote.sortitems(vote.items, "school", false);
					break;
				case "t1":
					vote.sortitems(vote.items, "state", true);
					break;
				case "t2":
					vote.sortitems(vote.items, "state", false);
					break;
			}
		});
		jQuery(".v-email").blur(function() {
			if(vote.validatevote()) {
				jQuery(".v-email").removeClass("errorfield");
			}  else {
				jQuery(".v-email").addClass("errorfield");
			}
		});
		jQuery(".v-submit").bind("click", function(e) {
			e.preventDefault();
			if(vote.validatevote()) {
				if(grecaptcha.getResponse() != "") {
					jQuery(".v-email").removeClass("errorfield");
					vote.email = jQuery(".v-email").val();
					jQuery.ajax({
						type: "GET",
						url: "../data/vote.php",
					            data: {
					                action:"insert",
					                email:vote.email,
					                voteid:vote.selected.id,
					                votename:vote.selected.name,
					                votestate:vote.selected.state
					            },
						dataType: "json",
						success: function (data) {
							switch(data.d.ReturnCode) {
								case 0:
									// New Vote
									vote.pincode = data.d.ErrorMessage;
									vote.sendemail();
									jQuery(".voting").slideUp(750, function() {
										//agsn.trackevent("Voting", "Vote", "Submitted");
										jQuery(".confirm-info").text(vote.selected.name+" from "+vote.selected.state);
										jQuery(".thankyou").slideDown(750, function() {
											jQuery("html, body").animate({ scrollTop: jQuery(".thankyou").offset().top-150}, 1000);
										});
									});
									break;
								case 1:
									// Already Voted Today
									jQuery(".voting").slideUp(750, function() {
										//agsn.trackevent("Voting", "Vote", "Already Today");
										jQuery(".already-voted").slideDown(750, function() {
											jQuery("html, body").animate({ scrollTop: jQuery(".already-voted").offset().top-150}, 1000);
										});
									});
									break;
							}
						},
						async: false
					});
				} else {
					jQuery(".g-recaptcha > div").addClass("errorfield");
				}
			}  else {
				agsn.trackevent("Voting", "Invalid", "Email");
				jQuery(".v-email").addClass("errorfield");
			}
		})
	},
	sendemail: function() {
		jQuery.ajax({
			type: "POST",
            			contentType: "application/json;charset=utf-8",
			url: "http://revolutionsocial.com/pfizer/sendgrid.aspx/SendEmail",
			data: '{email:"'+vote.email+'",pincode:"'+vote.pincode+'"}',
			dataType: "json",
			success: function (data) {
				switch(data.d.ReturnCode) {
					case "0":
						// Email Sent
						agsn.trackevent("Voting", "Vote", "Email Sent");
						break;
					case "1":
						// Error
						agsn.trackevent("Voting", "Vote", "Email Error");
						break;
					case "2":
						// Error
						agsn.trackevent("Voting", "Vote", "Email Error");
						break;
				}
			}
		});
	},
	validatevote: function() {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  		return re.test(jQuery(".v-email").val());
	},
	loadfinalists: function() {
		var items = [];
		jQuery.ajax({
			type: "GET",
			url: "../data/finalists.json",
			dataType: "json",
			success: function (data) {
				vote.items = data;
				vote.items = vote.random(vote.items);
				vote.showfinalists(true);
			},
			async: false
		});
	},
	sortitems: function(arrToSort, strObjParamToSortBy, sortAscending){
  		if(sortAscending == undefined) sortAscending = true;  // default to true
		agsn.trackevent("Voting", "Sorting", strObjParamToSortBy+" "+sortAscending);
    		if(sortAscending) {
			arrToSort.sort(function (a, b) {
				return a[strObjParamToSortBy].localeCompare(b[strObjParamToSortBy]);
			});
		}
		else {
			arrToSort.sort(function (a, b) {
				return b[strObjParamToSortBy].localeCompare(a[strObjParamToSortBy]);
			});
		}
		vote.showfinalists(false);
	},
	random: function (sourceArray) {
	    for (var i = 0; i < sourceArray.length - 1; i++) {
	        var j = i + Math.floor(Math.random() * (sourceArray.length - i));

	        var temp = sourceArray[j];
	        sourceArray[j] = sourceArray[i];
	        sourceArray[i] = temp;
	    }
	    return sourceArray;
	},
	showfinalists: function(initial) {
		var ctr = 1;
		var items = 1;
		var max;
		if(vote.ismobile){max = vote.mobile;} else {max=vote.desktop;}
		jQuery.each(vote.items, function(key, value){
			var tmp = vote.base;
			jQuery.each(value, function(key, value){
				switch(key){
					case "id":
						tmp = tmp.replace(/~id~/g, value);
						break;
					case "state":
						var st = value;
						var st = st.replace(/\s/g,"-");
						tmp = tmp.replace(/~state-image~/g, st);
						tmp = tmp.replace(/~state~/g, value);
						break;
					case "name":
						tmp = tmp.replace(/~name~/g, value);
						break;
					case "school":
						tmp = tmp.replace(/~school~/g, value);
						break;
				}
			});
			if(ctr == 1){
				if(initial) {jQuery(".voting-finalists").append("<div class='items items-"+items+"'>");} else {jQuery(".items-"+items).html("");}
				jQuery(".items-"+items).append(tmp);
				ctr++;
			} else if(ctr == max) {
				jQuery(".items-"+items).append(tmp);
				if(initial) {jQuery(".voting-finalists").append("</div>");}
				ctr = 1;
				items++;
			} else {
				jQuery(".items-"+items).append(tmp);
				ctr++;
			}
		});
		vote.owl = $(".owl-carousel").owlCarousel({
			items: 1,
			nav: true,
			navText: ["",""],
			center:true,
			navSpeed: 750
		});
		jQuery(".vote-item").unbind().bind("mouseenter", function() {
			var current = jQuery(this).attr("ref");
			jQuery(".vote-item").each(function() {
				if(jQuery(this).attr("ref")!=current){
					jQuery(this).addClass("inactive");
				} else {
					jQuery(this).removeClass("inactive");
				}
			});
		}).bind("click", function() {
			var sel = parseInt(jQuery(this).attr("ref"));
			for(i=0;i<vote.items.length;i++){
				if(vote.items[i].id == sel) {
					vote.selected = vote.items[i];
					break;
				}
			}
			var st =vote.selected.state;
			st =  st.replace(/\s/g,"-");
			jQuery(".v-state-image").attr("src","images/states/"+st+"@2x.png");
			jQuery(".v-state").text(vote.selected.state);
			jQuery(".v-name").text(vote.selected.name);
			jQuery(".v-school").text(vote.selected.school);
			jQuery(".v-essay").text(vote.selected.essay);
			jQuery(".full-cover").slideDown(750);
			jQuery("html, body").animate({ scrollTop: jQuery(".full-cover").offset().top-100}, 750);
		});
		jQuery(".voting-finalists").unbind().bind("mouseleave", function() {
			jQuery(".vote-item").each(function() {
				jQuery(this).removeClass("inactive");
			});
		});
		jQuery(".close-button").unbind().bind("click", function() {
			jQuery(".full-cover").slideUp(750);
		});
		vote.owl.on('changed.owl.carousel', function(event) {
			jQuery(".owl-next, .owl-prev").removeClass("disabled");
		 	if(event.item.index ==  event.item.count-1) {
		 		jQuery(".owl-next").addClass("disabled");
		 	} else if(event.item.index == 0) {
		 		jQuery(".owl-prev").addClass("disabled");
		 	} 
		});
	},
	getparameter: function (name) {
		var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if (results==null){
			return "";
		} else {
			return results[1] || 0;
		}
	},
	checkmobile: function(initial) {
		clearTimeout(vote.resizing);
		if(jQuery(".ismobile").is(":visible")) {
			vote.ismobile = true;
		} else {
			vote.ismobile = false;
		}
		if(!initial) {
			vote.showfinalists(false);
		}  
	}
}
jQuery(document).ready(function() {
	vote.init();
});
jQuery(window).resize(function() {
	clearTimeout(vote.resizing);
	vote.resizing = setTimeout("vote.checkmobile(false)",500);
});