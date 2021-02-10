jQuery(document).ready(function( $ ) {
    if (!$('div.mobile-cta-wrap')){
        return false;
    }

    $.ajaxSetup({
        cache: false
    });

    $.fn.isOnScreen = function(x, y){

        if(x == null || typeof x == 'undefined') x = 1;
        if(y == null || typeof y == 'undefined') y = 1;

        var win = $(window);

        var viewport = {
            top : win.scrollTop(),
            left : win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();
        viewport.height = viewport.bottom - viewport.top;

        var height = this.outerHeight();
        var width = this.outerWidth();

        if(!width || !height){
            return false;
        }

        var bounds = this.offset();
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

    };

    var isMobile = window.matchMedia("only screen and (max-width: 760px)");

    if ( isMobile.matches && $('a.mobile-float') ) {
        $.when(
            // https://github.com/ssorallen/jquery-scrollstop
            // $.getScript("//cdn.jsdelivr.net/npm/jquery-scrollstop@1.2.0/jquery.scrollstop.min.js"),

            // https://github.com/patik/within-viewport
            $.getScript("//cdn.jsdelivr.net/npm/withinviewport@2.0.0/withinviewport.min.js"),
            $.getScript("//cdn.jsdelivr.net/npm/withinviewport@2.0.0/jquery.withinviewport.js"),

            // https://github.com/customd/jquery-visible
            $.getScript("//cdnjs.cloudflare.com/ajax/libs/jquery-visible/1.2.0/jquery.visible.min.js"),

            $.Deferred(function( deferred ){
                $( deferred.resolve );
            })
        ).done(function(){

            //cache of jQuery objects
            var $$ = {
                mobilectas: $('div.mobile-cta-wrap'),
                mobilefloat: $('#mobile-float')
            };

            $$.mobilectas.each(function(index){
                $(this).attr('data-cta-index', index);
            });

            var scrollHandling = {
                allow: true,
                reallow: function() {
                    scrollHandling.allow = true;
                },
                delay: 10 //(milliseconds) adjust to the highest acceptable value
            };

            $(window).scroll(function() {
                if(scrollHandling.allow) {
                    var mobilectas = $('div.mobile-cta-wrap').withinviewport();
                    var mobilecta = null;
                    $.each($$.mobilectas, function(index, obj) {
                        if( $(this).isOnScreen(0.7, 0.7) ){
                            mobilecta = $(this);
                            return false;
                        }
                    });

                    if (mobilecta) {
                        var index = mobilecta.data('cta-index');
                        if( $$.mobilefloat.data('cta-index') !== mobilecta.data('cta-index') ) {
                            try {
                                var ctaBtn = mobilecta.find('a.cta-btn.mobile-float')[0];
                                $$.mobilefloat.html($(ctaBtn).clone(true));
                                $$.mobilefloat.attr('data-cta-index', index);
                                console.log(ctaBtn, $(ctaBtn), $(ctaBtn).parent());

                                if ($(ctaBtn).parent().data('mobile-sponsoredads') == 'yes') {
                                    $$.mobilefloat.prepend('<label class="sponsored">Sponsored Ads</label>');
                                    $$.mobilefloat.addClass('sponsored');
                                }
                                
                                $(ctaBtn).parent().css('display','flex');
                                
                                //$$.mobilefloat.fadeTo(100, 1);

                            } catch(err) {
                                console.log('ctaBtn find Err', err);
                            }
                        }
                    } else {
                        $$.mobilefloat.html('').attr('data-cta-index', '');
                        //$$.mobilefloat.fadeTo(100, 0.01, function() {
                        //})
                    }

                    scrollHandling.allow = false;
                    setTimeout(scrollHandling.reallow, scrollHandling.delay);
                }
            });

        });
    }
 });