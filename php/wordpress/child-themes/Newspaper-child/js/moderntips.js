//
// JS that gets loaded on every page
//
var ads = {
    state: "",
    stateabrv: "",
    citystate: "",
    city: "",
    country: "",
    countryname: "",
    zip: "",
    url: "",
    affid: "1010",
    affsub: "organic",
    init: function() {
        jQuery("html").append("<div id='mobile-float'></div><div class='soft-popup-wrapper'><div class='soft-popup'><a href='' title=''><img class='soft-pop-image' src='' alt='PopUp Image' /></a><div class='exit'>X</div></div></div>");
        jQuery(".td-scroll-up").css({"display":"none"});
        ads.url = window.location.href; 
        ads.geo();
        setTimeout('ads.processurl()',1000);
        setTimeout('ads.processaff()',1000);
        setTimeout('ads.equalheight()', 750);
        setTimeout('ads.popup()',1000);
        setTimeout('ads.processdisclaimer()',1000);
    },
    postGEO: function() {
        // Sets info-data to geo-aware text instead of using geo macros
        jQuery('.cta-btn').each(function(index){
            jQuery(this).attr('info-data', jQuery(this).text());
        });
        jQuery('.cta-btn-wrap').hide().fadeIn(300);
        // Handles mobile float city text
        if(jQuery('a.mobile-float')){
            jQuery('a.mobile-float').each(function(index){
                jQuery(this).attr('info-data', jQuery(this).text());
            });
        }
    },
    urlParam: function(name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        } else {
            return results[1] || 0;
        }
    },
    linkSwap: function() {
        var holderVar = document.getElementsByClassName('holder')[0].value;
        new_window = window.open(holderVar,'_blank');
        if (new_window.focus) {new_window.focus();}
        // if (jQuery(".acfinfo").attr("leaveBehindLink")) {
        //     var lbh = jQuery(".acfinfo").attr("leaveBehindLink");
        //     lbh = lbh.replace(/{utm_medium}/g, ads.urlParam('utm_medium')).replace(/{utm_source}/g, ads.urlParam('utm_source')).replace(/{utm_term}/g, ads.urlParam('utm_term')).replace(/{utm_campaign}/g, ads.urlParam('utm_campaign'));
        //     window.location.href = lbh;
        // }
    },
    camel: function(val) {
        return val.charAt(0).toUpperCase() + val.toLowerCase().slice(1);
    },
    abbrState: function(a,n){
        var e=[["Arizona","AZ"],["Alabama","AL"],["Alaska","AK"],["Arizona","AZ"],["Arkansas","AR"],["California","CA"],["Colorado","CO"],["Connecticut","CT"],["Delaware","DE"],["Florida","FL"],["Georgia","GA"],["Hawaii","HI"],["Idaho","ID"],["Illinois","IL"],["Indiana","IN"],["Iowa","IA"],["Kansas","KS"],["Kentucky","KY"],["Kentucky","KY"],["Louisiana","LA"],["Maine","ME"],["Maryland","MD"],["Massachusetts","MA"],["Michigan","MI"],["Minnesota","MN"],["Mississippi","MS"],["Missouri","MO"],["Montana","MT"],["Nebraska","NE"],["Nevada","NV"],["New Hampshire","NH"],["New Jersey","NJ"],["New Mexico","NM"],["New York","NY"],["North Carolina","NC"],["North Dakota","ND"],["Ohio","OH"],["Oklahoma","OK"],["Oregon","OR"],["Pennsylvania","PA"],["Rhode Island","RI"],["South Carolina","SC"],["South Dakota","SD"],["Tennessee","TN"],["Texas","TX"],["Utah","UT"],["Vermont","VT"],["Virginia","VA"],["Washington","WA"],["West Virginia","WV"],["Wisconsin","WI"],["Wyoming","WY"]];if("abbr"==n){for(a=a.replace(/\w\S*/g,function(a){return a.charAt(0).toUpperCase()+a.substr(1).toLowerCase()}),i=0;i<e.length;i++)if(e[i][0]==a)return e[i][1]}else if("name"==n)for(a=a.toUpperCase(),i=0;i<e.length;i++)if(e[i][1]==a)return e[i][0]
    },
    popup: function() {
        var tmp = "";
        try{
            tmp = ads.get_cookie();
        } catch(poperror) {}
        if(jQuery(".acfinfo").attr("softPop") == "on" && tmp == "") {
            jQuery(".soft-pop-image").attr("src", jQuery(".acfinfo").attr("softpopimage"));
            if(jQuery(".acfinfo").attr("soft_exit_pop_link")) {
                var lnk = jQuery(".soft-pop-image").attr("href", jQuery(".acfinfo").attr("softPopLink"));
                lnk = lnk.replace(/{utm_medium}/g, ads.urlParam('utm_medium')).replace(/{utm_source}/g, ads.urlParam('utm_source')).replace(/{utm_term}/g, ads.urlParam('utm_term')).replace(/{utm_campaign}/g, ads.urlParam('utm_campaign'));
                jQuery(".soft-popup > a").attr("href", lnk);
            } else {
                jQuery(".soft-popup > a").attr("href", jQuery(".acfinfo").attr("softPopFallbackLink"));
            }
            jQuery(".soft-popup > a").attr("title",jQuery(document).find("title").text());
            jQuery(".soft-popup .exit").bind("click", function() {
                ads.set_cookie("show_light_box_popup", "true", 30, document.domain);
                jQuery(".soft-popup-wrapper").fadeOut(750);
            });
            function addEvent(obj, evt, fn) {
              if (obj.addEventListener) {
                obj.addEventListener(evt, fn, false);
              } else if (obj.attachEvent) {
                obj.attachEvent("on" + evt, fn);
              }
            }
            addEvent(document, 'mouseout', function(evt) {
              if (evt.toElement === null && evt.relatedTarget === null && ads.get_cookie() != "true") {
                jQuery(".soft-popup-wrapper").fadeIn(450);
              }
            });
        }
    },
    geo: function() {
        jQuery.ajax({
            /* url: "https://geolocation-db.com/json/ccac0ae0-1c71-11e9-a0ce-dbd4f7d6e208", */
            url: "https://api.ipdata.co/?api-key=6aba6dc7cf852ebc95e89fb83eb88350f03b58b05e726e64c21de888",
            dataType:'json',
            success: function( loc ) {
                try {
                    /* ads.city = loc.city;
                    ads.state = loc.state;
                    ads.stateabrv = ads.abbrState(loc.state,"abbr");
                    ads.country = loc.country_code;
                    ads.countryname = loc.country_name;
                    ads.zip = loc.zip; */
                    ads.city = loc.city;
                    ads.state = loc.region;
                    try {
                        ads.stateabrv = ads.abbrState(loc.region,"abbr");
                    } catch(geoerror) {}
                    ads.country = loc.country_code;
                    ads.countryname = loc.country_name;
                    ads.zip = loc.postal;
                    ads.process();
                } catch(geoerror) {}
            },
            complete: function(){
            },
            error: function(){
                ads.postGEO();
            }
        });
    },
    processdisclaimer: function() {
        if(jQuery(".acfinfo").attr("disclaimerswitch") == "on") {
            jQuery(".disclaimer > div > div").append("<div class='disclaimertext'></div>");
            jQuery(".disclaimertext").html(jQuery(".acfinfo").attr("disclaimertext"));
        }
    },
    processaff: function() {
        jQuery(".dynamic-aff").each(function() {
            var outlink = jQuery(this).attr("href");
            if(ads.urlParam('aff_id')) {
                outlink = outlink.replace(/{aff_id}/g, ads.urlParam('aff_id'));
            } else {
                outlink = outlink.replace(/{aff_id}/g, ads.affid);
            }
            if(ads.urlParam('aff_sub')) {
                outlink = outlink.replace(/{aff_sub}/g, ads.urlParam('aff_sub'));
            } else {
                outlink = outlink.replace(/{aff_sub}/g, ads.affsub);
            }
            jQuery(this).attr("href",outlink);
        });
    },
    equalheight: function() {
        jQuery(".cta-btn-wrap").each(function() {
            if(!jQuery(this).parent().hasClass("mobile-cta-wrap")) {
                var tallest=0;
                jQuery(".equalheight", this).each(function() {
                    if(jQuery(this).height() > tallest) {
                        tallest=jQuery(this).height();
                    }
                });
                jQuery(".equalheight", this).height(tallest);
            }
        });
    },
    process: function() {
        if ( jQuery('state') || jQuery('stateabv') || jQuery('ex-city-state') || jQuery('city') ) {
            if(ads.city != "") {
                jQuery("city").each(function( index ) {
                    try {
                        var elem = jQuery(this);
                        var first = elem.attr('first');
                        var upper =  elem.attr('upper');
                        var lower = elem.attr('lower');
                        if (first != undefined) {
                            elem.html(ads.city);
                        } else if(upper != undefined) {
                            elem.html(ads.city.toUpperCase());
                        } else if (lower != undefined) {
                            elem.html(ads.city.toLowerCase());
                        } else {
                            elem.html(ads.city);
                        }
                    } catch(cityErr) {}
                });
            }
            if(jQuery('ex-city-state')) {
                jQuery( "ex-city-state" ).each(function(index) {
                    try {
                        var elem = jQuery(this);
                        elem.html( '(for example: '+ ads.city + ', ' + ads.abbrState(ads.state, 'abbr') + ')' );
                    }catch(excitystateErr) {}
                });
            }
            if (jQuery('stateabv')) {
                jQuery('stateabv').each(function( index ) {
                    try{
                        var elem = jQuery(this);
                        var first = elem.attr('first');
                        var upper =  elem.attr('upper');
                        var lower = elem.attr('lower');
                        var state = ads.stateabrv;
                        if (first != undefined) {
                            elem.html(ads.camel(state));
                        } else if(upper != undefined) {
                            elem.html(state.toUpperCase());
                        } else if (lower != undefined) {
                            elem.html(state.toLowerCase());
                        } else {
                            elem.html(state);
                        }
                    } catch(stateabvErr){}
                });
            }
            if (jQuery('state')) {
                jQuery( "state" ).each(function( index ) {
                    try{
                        var elem = jQuery(this);
                        var first = elem.attr('first');
                        var upper =  elem.attr('upper');
                        var lower = elem.attr('lower');

                        if (first != undefined) {
                            elem.html(ads.state);
                        } else if(upper != undefined) {
                            elem.html(ads.state.toUpperCase());
                        } else if (lower != undefined) {
                            elem.html(ads.state.toLowerCase());
                        } else {
                            elem.html(ads.state);
                        }
                    } catch(stateErr){};
                });
            }
            ads.postGEO();
        } else {
            ads.postGEO();
        }
    },
    processurl: function() {
        jQuery(".dynamic-link").attr("rel", "nofollow").css("cursor", "pointer").attr('onClick', "runIt(this);");
        jQuery('a[href*="{aff_id}"]').attr('onClick', 'runIt(this);');
        var outlink="";
        if(jQuery(".acfinfo").attr(ads.country.toLowerCase()) != undefined) {
            outlink = ads.urlParam('utm_medium') || ads.urlParam('utm_source') || ads.urlParam('utm_term') || ads.urlParam('utm_campaign') ? jQuery(".acfinfo").attr(ads.country.toLowerCase()) : jQuery(".acfinfo").attr(ads.country.toLowerCase()+"fallback");
            outlink = outlink.replace(/{utm_medium}/g, ads.urlParam('utm_medium')).replace(/{utm_source}/g, ads.urlParam('utm_source')).replace(/{utm_term}/g, ads.urlParam('utm_term')).replace(/{utm_campaign}/g, ads.urlParam('utm_campaign'));
        } else {
            outlink = ads.urlParam('utm_medium') || ads.urlParam('utm_source') || ads.urlParam('utm_term') || ads.urlParam('utm_campaign') ? jQuery(".acfinfo").attr("outboundLink") : jQuery(".acfinfo").attr("fallbackoutboundLink");
            outlink = outlink.replace(/{utm_medium}/g, ads.urlParam('utm_medium')).replace(/{utm_source}/g, ads.urlParam('utm_source')).replace(/{utm_term}/g, ads.urlParam('utm_term')).replace(/{utm_campaign}/g, ads.urlParam('utm_campaign'));
        }
        var theURL = window.location.href;
        var cleanURL = theURL.split("?")[0];
        var extraCleanURL = cleanURL.slice(7);
        outlink = outlink.replace("{encodedrefurl}", encodeURIComponent(extraCleanURL));
        jQuery(".holder").val(outlink);
        var blurExists = false;
        jQuery(document).on('DOMNodeInserted', function(e) {
            if(e.target.localName=="iframe" && e.target.ownerDocument.defaultView.frameElement == null){
                if (!blurExists) {
                    var listener = window.addEventListener('blur', function() {
                        focus();
                        if ( document.activeElement.tagName === 'IFRAME' ){
                            if (!blurExists){
                                try {
                                    runIt();
                                } catch (runIterror) {}
                                blurExists = true;
                            }
                        }
                        window.removeEventListener('blur', listener);
                    });
                };
            };
        });
        // Blur handler for clicking inside iframe
        var listener = window.addEventListener('blur', function() {
            if (jQuery(document.activeElement) === jQuery('iframe').first()){
                try {
                    runIt();
                } catch (runIterror) {}
            }
            window.removeEventListener('blur', listener);
        });
        jQuery('.dynamic-link').click(function(e) {
            e.preventDefault();        
            if (jQuery(this).attr('info-data')) {
                var outlink = encodeURIComponent(jQuery(this).attr('info-data').replace(/[ ,]+/g, "+"))
                var dynamic_ctatext = jQuery(this).attr('info-data');
                var dynamic_ectatext = dynamic_ctatext.replace(/[ ,]+/g, "+");
                dynamic_encodedctatext = encodeURIComponent(dynamic_ctatext);
                var sponsoredLinkOne = jQuery(".holder").val();
                var ectasponsoredlink = sponsoredLinkOne.replace(/{encodedctatext}/g, dynamic_encodedctatext); //replace {encodedctatext} with dynamic_encodedctatext
                var finishedSponsoredLink = ectasponsoredlink.replace(/{ctatext}/g, dynamic_ctatext); //replace {ctatext} with dynamic_ctatext
                jQuery(".holder").val("" + finishedSponsoredLink + "");
            }
            ads.linkSwap();
        });
        var isMobile = window.matchMedia("only screen and (max-width: 760px)");
        if (isMobile.matches && jQuery('a.mobile-float')) {
            jQuery.when(
                jQuery.getScript("//cdn.jsdelivr.net/npm/withinviewport@2.0.0/withinviewport.min.js"),
                jQuery.getScript("//cdn.jsdelivr.net/npm/withinviewport@2.0.0/jquery.withinviewport.js"),
                jQuery.getScript("//cdnjs.cloudflare.com/ajax/libs/jquery-visible/1.2.0/jquery.visible.min.js"),
                jQuery.Deferred(function( deferred ){
                    jQuery( deferred.resolve );
                })
            ).done(function(){
                var $$ = {
                    mobilectas: jQuery('div.mobile-cta-wrap'),
                    mobilefloat: jQuery('#mobile-float')
                };
                $$.mobilectas.each(function(index){
                    jQuery(this).attr('data-cta-index', index);
                });

                var scrollHandling = {
                    allow: true,
                    reallow: function() {
                        scrollHandling.allow = true;
                    },
                    delay: 10 //(milliseconds) adjust to the highest acceptable value
                };
                jQuery(window).scroll(function() {
                    if(scrollHandling.allow) {
                        var mobilectas = jQuery('div.mobile-cta-wrap').withinviewport();
                        var mobilecta = null;
                        jQuery.each($$.mobilectas, function(index, obj) {
                            if(ads.isOnScreen(jQuery(this),0.7, 0.7)){
                                mobilecta = jQuery(this);
                            }
                        });
                        if (mobilecta) {
                            var index = mobilecta.data('cta-index');
                            if( $$.mobilefloat.data('cta-index') !== mobilecta.data('cta-index') ) {
                                try {
                                    var ctaBtn = mobilecta.find('a.cta-btn.mobile-float')[0];
                                    $$.mobilefloat.html(jQuery(ctaBtn).clone(true));
                                    $$.mobilefloat.attr('data-cta-index', index);
                                    if (jQuery(ctaBtn).parent().data('mobile-sponsoredads') == 'yes') {
                                        $$.mobilefloat.prepend('<label class="sponsored">Sponsored Ads</label>');
                                        $$.mobilefloat.addClass('sponsored');
                                    }
                                    jQuery(ctaBtn).parent().css('display','flex');
                                } catch(err) {
                                    /* console.log('ctaBtn find Err', err); */
                                }
                            }
                        } else {
                            $$.mobilefloat.html('').attr('data-cta-index', '');
                        }
                        scrollHandling.allow = false;
                        setTimeout(scrollHandling.reallow, scrollHandling.delay);
                    }
                });
                ads.process();
            });
        }
    },
    get_cookie: function() {
        return document.cookie.replace(/(?:(?:^|.*;\s*)show_light_box_popup\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    },
    set_cookie: function(cookie_name, cookie_value, lifespan_in_minutes, valid_domain) {
        var domain_string = valid_domain ? ("; domain=" + valid_domain) : '';
        document.cookie = cookie_name + "=" + encodeURIComponent(cookie_value) + "; max-age=" + 60 * lifespan_in_minutes + "; path=/" + domain_string;
    },
    isOnScreen: function(element,x, y){
        if(x == null || typeof x == 'undefined') x = 1;
        if(y == null || typeof y == 'undefined') y = 1;
        var win = jQuery(window);
        var viewport = {
            top : win.scrollTop(),
            left : win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();
        viewport.height = viewport.bottom - viewport.top;
        var height = element.outerHeight();
        var width = element.outerWidth();
        if(!width || !height){
            return false;
        }
        var bounds = element.offset();
        bounds.right = bounds.left + width;
        bounds.bottom = bounds.top + height;
        var visible = (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
        if(!visible){
            return false;
        }
        var deltas = {
            top : Math.min( 1, ( bounds.bottom - viewport.top ) / height),
            bottom : Math.min(1, ( viewport.bottom - bounds.top ) / height),
            left : Math.min(1, ( bounds.right - viewport.left ) / width),
            right : Math.min(1, ( viewport.right - bounds.left ) / width)
        };
        if (bounds.top <= viewport.top && bounds.bottom > viewport.bottom){
            return true;
        } else if (bounds.top >= viewport.top && bounds.bottom >= viewport.bottom) {
            var percCoverage = (viewport.height - (bounds.top - viewport.top)) / viewport.height;
            return (percCoverage >= y) ? true : false;
        } else if(bounds.top <= viewport.top && bounds.bottom <= viewport.bottom) {
            var percCoverage = (viewport.height - (viewport.bottom - bounds.bottom)) / viewport.height;
            return (percCoverage >= y) ? true : false;
        } else {
            return (deltas.left * deltas.right) >= x && (deltas.top * deltas.bottom) >= y;
        }

    }
}
// Parse url params
jQuery(document).ready(function() {
    ads.init();
});
