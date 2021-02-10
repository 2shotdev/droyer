<!--Section One-->
<?php
locate_template('includes/wp_booster/td_single_template_vars.php', true);
get_header();
global $loop_sidebar_position, $td_sidebar_position, $post, $meta, $nosidebar;
$postid = $post -> ID;

$td_mod_single = new td_module_single($post);

$nosidebar = false;
$noadby = false;
$all_the_tags = get_the_tags();
foreach($all_the_tags as $this_tag) {
    $name = $this_tag->name;
    if ($name == 'nosidebar'){
        $nosidebar = true;
    } else if ($name == 'noadby') {
        $noadby = true;
    } else if ($name == 'Yahoo') {
        $yahoo = true;
    } else if ($name == 'yahoo600') {
        $yahoo600 = true;
        $yahoo = true;
    } else if ($name == 'yahoo1click') {
        $yahoo = true;
        $yahoo1click = true;
    }
}

global $metav;
$meta = get_post_meta($postid);
$metav = array();

$metav['compkey'] = '';
if (array_key_exists('compkey', $meta)) {
    $metav['compkey'] = $meta['compkey'][0];

}

$metav['cta'] = '';
if (array_key_exists('cta', $meta)) {
    $metav['cta'] =  $meta['cta'][0];
}

$metav['lamjs'] = false;
if (array_key_exists('lamjs_switch', $meta)) {
    if ($meta['lamjs_switch'][0] === 'on') {
        $metav['lamjs'] = true;
    }
}

$metav['lamjs_v'] = '';
if (array_key_exists('lamjs_switch', $meta)) {
    $metav['lamjs_v'] = $meta['lamjs_switch'][0] ;
}

$metav['lamjs_partner_id'] = 1234;
if (array_key_exists('lamjs_partner_id', $meta)){
    $metav['lamjs_partner_id'] = $meta['lamjs_partner_id'][0];
}

$metav['sponsor'] = '';

if (array_key_exists('sponsor_name', $meta)) {
    $metav['sponsor'] = $meta['sponsor_name'][0];
}

$metav['mask_switch'] = false;
if (array_key_exists('mask_switch', $meta)) {
    if ($meta['mask_switch'][0] === 'on') {
        $metav['mask_switch'] = true;
    }
}

$metav['learnmore'] = '';
if (array_key_exists('learnmore', $meta)) {
    $metav['learnmore'] = $meta['learnmore'][0];
}

$metav['utm_link'] = '';
if (array_key_exists('utm_link', $meta)) {
    $metav['utm_link'] = $meta['utm_link'][0];
}

$metav['sponsor_link_real'] = '';
if (array_key_exists('sponsor_link_real', $meta)) {
    $metav['sponsor_link_real'] = $meta['sponsor_link_real'][0];
}

$metav['disclaimer_switch'] = false;
if (array_key_exists('disclaimer_switch', $meta)) {
    if ($meta['disclaimer_switch'][0] === 'on') {
        $metav['disclaimer_switch'] = true;
    }
}

$metav['disclaimer_text'] = '';
if (array_key_exists('disclaimer_text', $meta)) {
    $metav['disclaimer_text'] = $meta['disclaimer_text'][0];
}

$metav['soft_exit_pop_link'] = '';
if (array_key_exists('soft_exit_pop_link', $meta)) {
    $metav['soft_exit_pop_link'] = $meta['soft_exit_pop_link'][0];
}

$metav['soft_exit_pop_link_utm'] = '';
if (array_key_exists('soft_exit_pop_link_utm', $meta)) {
    $metav['soft_exit_pop_link_utm'] = $meta['soft_exit_pop_link_utm'][0];
}

$metav['sp_switch'] = false;
if (array_key_exists('sp_switch', $meta)) {
    if ($meta['sp_switch'][0] === 'on') {
        $metav['sp_switch'] = true;
    }
}

$metav['sp_switch_v'] = '';
if (array_key_exists('sp_switch', $meta)) {
    $metav['sp_switch_v'] = $meta['sp_switch'][0];
}

$metav['img_url'] = '';
if (array_key_exists('h_image', $meta)) {
    $metav['img_url'] = $meta['h_image'][0];
}

$metav['leave_behind_link'] = '';
if (array_key_exists('leave_behind_link', $meta)) {
    $metav['leave_behind_link'] = $meta['leave_behind_link'][0];
}

$metav['lamjs_subid'] = '';
if (array_key_exists('lamjs_subid', $meta)) {
    $metav['lamjs_subid'] = $meta['lamjs_subid'][0];
}

$metav['lamjs_subid_two'] = '';
if (array_key_exists('lamjs_subid_two', $meta)) {
    $metav['lamjs_subid_two'] = $meta['lamjs_subid_two'][0];
}

$metav['lamjs_campaign'] = '';
if (array_key_exists('lamjs_campaign', $meta)) {
    $metav['lamjs_campaign'] = $meta['lamjs_campaign'][0];
}

$metav['lamjs_iturl'] = '';
if (array_key_exists('lamjs_iturl', $meta)) {
    $metav['lamjs_iturl'] = $meta['lamjs_iturl'][0];
}

$metav['lamjs_click_track'] = '';
if (array_key_exists('lamjs_click_track', $meta)) {
    $metav['lamjs_click_track'] = $meta['lamjs_click_track'][0];
}

$metav['lamjs_search_track'] = '';
if (array_key_exists('lamjs_search_track', $meta)) {
    $metav['lamjs_search_track'] = $meta['lamjs_search_track'][0];
}

$metav['button_switch'] = false;
if (array_key_exists('button_switch', $meta)) {
    if ($meta['button_switch'][0] === 'on') {
        $metav['button_switch'] = true;
    }
}


// echo '<pre>';
// print_r($metav);
// echo '</pre>';

?>

<style>
    body {z-index:-1!important;}

    .learn-more {float: left;-moz-box-shadow: inset 0px 1px 0px 0px #f29c93;-webkit-box-shadow: inset 0px 1px 0px 0px #f29c93;box-shadow: inset 0px 1px 0px 0px #f29c93;background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #fe1a00), color-stop(1, #ce0100) );background: -moz-linear-gradient( center top, #fe1a00 5%, #ce0100 100% );filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fe1a00', endColorstr='#ce0100');background-color: #fe1a00;-moz-border-radius: 6px;-webkit-border-radius: 6px;border-radius: 6px;border: 1px solid #d83526;display: inline-block;color: #ffffff !important;font-family: arial;font-size: 15px;font-weight: bold;padding: 6px 24px;text-decoration: none;text-shadow: 1px 1px 0px #b23e35;}

    #dt-section a {color:white;}

    .sidebar-posts-style {font-family: 'Roboto', sans-serif;font-size:17px;line-height: 20px;margin:0px!important;height: 115px;}

    div#side-posts {padding-bottom: 20px; margin-top:-25px;}

    img.side-sponsored-image {float: left; padding-right: 10px;width: 100px;}

    #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }

    #mc_embed_signup div.mce_inline_error {background-color: #3399FF;}

    .facebook-container{min-height:290px;}

    .entry-title {font-weight:bold;}

    a.dynamic-link {color: red;}

    a.dynamic-link:hover {text-decoration: underline;}

    @media screen and (max-width:1140px) {
        .left-size {max-width: 698px!important;margin: auto;}
    }

    @media screen and (max-width:1018px) {
        .left-size {max-width: 480px!important;margin: auto;}
        .right-size {max-width: 230px!important;}
        img.alignright {max-width: 800px!important;width: 100%!important;}
        img.alignnone {max-width: 800px!important;width: 100%!important;}
        img.alignleft {max-width: 800px!important;width: 100%!important;}
        div#dt-section {padding: 0px 50px;}
    }

    @media screen and (max-width:767px) {
        .sponsored-left {max-width:1074px!important;width:100%!important;padding:0px 50px;}
        .sidebar-right {max-width:1074px!important;width:100%!important;padding:0px 50px;}
        .pos-box {margin-right:10px;}
        .left-size {max-width: 767px!important;margin: auto;}
        .right-size {max-width: 767px!important;}
    }

    @media screen and (max-width:640px) {
        .sponsored-left {max-width:1074px!important;width:100%!important;padding:0px 10px;}
        .sidebar-right {max-width:1074px!important;width:100%!important;padding:0px 10px;}
        .pos-box {margin-right:10px;}
        .disclaimer-ul {padding:0px 10px;}
        .span-edit-one {font-size:13px!important;}
        .span-edit-two {font-size:9px!important;}
    }

    @media screen and (max-width:450px) {
        span.span-edit-one {
            font-size: 13px!important;
        }
    }

    .w-btn-group {
        text-align: left;
        margin-top: -20px;
    }

    .w-btn-group label {
        font-size: 14px;
        text-align: left;
        margin-left: 10px;
    }

    @media (max-width: 767px) {
        .w-btn-group label {
            margin-left: 5px;
        }
    }

    .w-btn-group .split {
        text-align: center;
        flex-flow: row wrap;
        display: flex;
    }

    .w-btn-group .split .btn-red {
        box-shadow: inset 0px 1px 0px 0px #f29c93;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #fe1a00), color-stop(1, #ce0100));
        background: -moz-linear-gradient(center top, #fe1a00 5%, #ce0100 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fe1a00', endColorstr='#ce0100');
        background-color: #fe1a00;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        border-radius: 6px;
        border: 1px solid #d83526;
        display: inline-block;
        color: #ffffff !important;
        font-family: arial;
        font-size: 15px;
        font-weight: bold;
        padding: 12px 24px;
        text-decoration: none;
        text-shadow: 1px 1px 0px #b23e35;
        margin-bottom: 10px;
        padding-right: 0px;
        width: 345px;
    }

    .w-btn-group .split .btn-red.flex {
        display:inline-flex;
        flex-flow: row nowrap;
        justify-content: center;
        align-items: center;
        margin-left: auto;
        margin-right: auto;
        flex: 0 1 auto;
    }

    .btn-red.flex div {
        flex: 1;
    }

    /* Handles button look at different screen sizes */
    @media (max-width: 767px) and (min-width: 623px) {
        .w-btn-group .split .btn-red {
            max-width: 290px;
        }
    }

    @media (max-width: 622px) {
        .w-btn-group .split .btn-red {
            width: 100%;
            max-width: 100%;
        }
    }

    .w-btn-group .split .btn-red span {
        margin: 0px 20px;
        display: inline;
    }

    /* Right Arrow on btn links */
    i.arrow {
        border: solid white;
        border-width: 0 2px 2px 0;
        display: inline-block;
        padding: 7px;
        float: right;
        margin-right: 12px;
        margin-top: 2px;
    }

    i.arrow.right {
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
    }

    i.arrow.right-flex {
        flex: 0 1;
    }

    .sponsored-page {
        width:100%;
        max-width:1074px;
        overflow: hidden;
        margin: auto;
    }

    .sidebar-right {
        padding-top: 20px;
        max-width: 325px;
        float:right;
        display: block;
        overflow:hidden;
        width:30%;
    }

    .sidebar-right.nosidebar {
        display:none !important;
    }
    .sponsored-left {
        max-width:699px;
        float:left;
        overflow:hidden;
        width:70%;

    }
    .sponsored-left.nosidebar {
        margin:auto;
        float:none;
    }

    #lm-button.nobuttonswitch {
        display:none;
    }

    body[class^="postid-"] p {
        font-size: 18px;
        line-height: 24px;
    }

</style>


<script>
jQuery.urlParam = function(name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) {
        return null;
    } else {
        return results[1] || 0;
    }
}

// jQuery(function () {
    // $('body').on('load', 'iframe[id^="_mN_dy"]', function(e){

    // $('iframe[id^="_mN_dy"]').load(function (e) {

        // frames["myframe"].document.body.innerHTML = htmlValue;
    // });
// });

// var ranIt = false;
// window.onbeforeunload = function(e) {
    // console.log('window.onbeforeunload');
    // if (!ranIt) {
        // runIt();
        // ranIt = true;
        // console.log('ran it');
        // console.log('inside', window.location);
    // }
    // return undefined;
// };

// window.onblur = function() { console.log('blur'); }



// jQuery('a').on('click', document.removeEventListener("visibilitychange"));


</script>
<div style="background-color: rgba(0, 0, 0, 0.67);width: 100%;height: 100%;z-index: 3000;top: 0;left: 0;position: fixed;display:none;" class="pop-up-box">
    <div class="pop-up-container" style="overflow: hidden; width: 100%;max-width: 650px;margin: 200px auto;">
        <a class="soft-pop-url" href="#"><img src="#" class="pop-up-image"></img></a>
        <div class="pop-exit" style="position:fixed;margin-left:625px;margin-top:-290px;">
            <img src="https://moderntips.com/wp-content/uploads/2019/04/Button-Delete-icon.png" style="width: 30px;">
        </div>
    </div>
</div>
<div class="mouse-pop" style="width:100%;height:10px;"></div>
<div class="mouse-catch" style="width:100%;height:10px;"></div>
<div class="sponsored-page">
    <div class="sponsored-left <?php if ($nosidebar){echo('nosidebar');}?>">
        <div class="left-size">
            <div id="content-section-one">
                <h1 style='margin-top:10px!important;' itemprop='name' class='entry-title'><?php echo($post->post_title); ?></h1>
            </div>

            <div style="margin-top:-20px;display:none;" id="the_categories"></div>

            <?php if ($yahoo): ?>
                <div id="yahoo-container" style="">
                    <!--
                    ~ Copyright (C) 2014-2015 Media.net Advertising FZ-LLC All Rights Reserved
                    -->
                    <script type="text/javascript">
                        window._mNHandle = window._mNHandle || {};
                        window._mNHandle.queue = window._mNHandle.queue || [];
                        medianet_versionId = "3121199";
                        medianet_chnm = jQuery.urlParam('utm_term') ? jQuery.urlParam('utm_term') : 'organic';

                        <!-- Checks the border top color based on media queries to see document size -->
                        var isMobile = jQuery('#yahoo-container').css('border-top-color') == 'rgb(255, 0, 0)' ? true : false;
                        console.log('isMobile', isMobile, jQuery('#yahoo-container').css('border-top-color'));
                    </script>

                    <?php
                        $yahooDesktopID = "447502576";
                        $yahooDesktopSize = "700x135";
                        $yahooMobileID = "884954137";
                        $yahooMobileSize = "355x250";


                        if ($yahoo1click):

                            $yahooDesktopID = "315531585";
                            $yahooDesktopSize = "600x280";
                            $yahooMobileID = "315531585";
                            $yahooMobileSize = "600x280";

                        endif;

                    ?>


                    <!--
                    ~ Copyright (C) 2014 Media.net Advertising FZ-LLC All Rights Reserved
                    -->
                    <div id="<?php echo $yahooDesktopID;?>">
                        <script type="text/javascript">
                            if (!isMobile){
                                try {
                                    window._mNHandle.queue.push(function () {
                                        window._mNDetails.loadTag( <?php echo '"'.$yahooDesktopID.'"'; ?>,<?php echo '"'.$yahooDesktopSize.'"'; ?>,<?php echo '"'.$yahooDesktopID.'"'; ?> );
                                    });
                                } catch (error) {}
                            }
                        </script>
                    </div>

                    <!--
                    ~ Copyright (C) 2014 Media.net Advertising FZ-LLC All Rights Reserved
                    -->
                    <div id="<?php echo $yahooMobileID;?>">
                        <script type="text/javascript">
                          if (isMobile) {
                              try {
                                   window._mNHandle.queue.push(function () {
                                    window._mNDetails.loadTag( <?php echo '"'.$yahooMobileID.'"'; ?>,<?php echo '"'.$yahooMobileSize.'"'; ?>,<?php echo '"'.$yahooMobileID.'"'; ?> );
                                    });
                                  }
                              catch (error) {}
                          }
                        </script>
                    </div>


                </div>
            <?php endif; ?>

            <?php if( get_field('enable_4_button_ad') == 'yes' ): ?>
                <div id="content-section-w">
                <?php if( get_field('enable_caption') == 'yes' ): ?>
                    <p class="caption"><?php the_field('caption'); ?></p>
                <?php endif; ?>
                    <div class="w-btn-group text-right">
                        <label>Sponsored Ads</label>
                        <div class="split" id="4-btn-ad-wrap" style="display:none;">

                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Main content section -->
            <div id="content-section-two">
                <div class="td-post-text-content"><?php echo the_content(); ?></div>
            </div>

            <div style="display:none;" id="the_categories_two"></div>
            <!-- Only render lamjs if lamjs switch is active -->
            <?php if ($metav['lamjs']): ?>
                <script src="https://<?php echo $metav['lamjs_partner_id'];?>.lamtrigger.com/lam.js"></script>
            <?php endif; ?>
            <?php if ($metav['button_switch']): ?>
                <div id="lm-button" class="<?php if (!$metav['button_switch']){echo 'nobuttonswitch';} ?>">
                    <a class="dynamic-link" info-data="<?php echo $metav['compkey']; ?>" href="#">
                        <div class="learn-more"><?php echo $metav['cta']; ?></div>
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($yahoo): ?>

                <div id="yahoo-container2"></div>

            <?php endif; ?>

            <!-- Render below content -->
            <?php echo $meta['below_content_area'][0]; ?>            

            <?php if ($yahoo): ?>

                <?php
                    $yahooDesktopID = ($yahoo600 ? "218358271" : "572462557");
                    $yahooDesktopSize = ($yahoo600 ? "950x900" : "600x250");

                    $yahooMobileID = ($yahoo600 ? "218358271" : "231400328");
                    $yahooMobileSize = ($yahoo600 ? "950x900" : "355x250");

                    if ($yahoo1click):

                        $yahooDesktopID = "555691212";
                        $yahooDesktopSize = "600x600";
                        $yahooMobileID = "555691212";
                        $yahooMobileSize = "600x600";

                    endif;

                ?>


                <!--
                ~ Copyright (C) 2014 Media.net Advertising FZ-LLC All Rights Reserved
                -->

                <div id="<?php echo $yahooDesktopID;?>">
                    <script type="text/javascript">
                        if (!isMobile){
                          console.log('rendering desktop');
                          try {
                            window._mNHandle.queue.push(function () {
                                window._mNDetails.loadTag( <?php echo '"'.$yahooDesktopID.'"'; ?>,<?php echo '"'.$yahooDesktopSize.'"'; ?>,<?php echo '"'.$yahooDesktopID.'"'; ?>);
                            });
                          }
                          catch (error) {}
                        }
                    </script>
                </div>


                <div id="<?php echo $yahooMobileID;?>">
                    <script type="text/javascript">
                      if (isMobile) {
                          console.log('rendering mobile');
                          try {
                            window._mNHandle.queue.push(function () {
                                window._mNDetails.loadTag( <?php echo '"'.$yahooMobileID.'"'; ?>,<?php echo '"'.$yahooMobileSize.'"'; ?>,<?php echo '"'.$yahooMobileID.'"'; ?> );
                            });
                          }
                      catch (error) {}
                      }
                    </script>
                </div>

                <script src="//contextual.media.net/dmedianet.js?cid=8CUA8EU6E" async="async"></script>
            <?php endif; ?>
        </div>
    </div>

    <div class="sidebar-right <?php if ($nosidebar){echo('nosidebar');}?>">
        <div class="right-size">

            <aside class="widget widget_text"><div class="textwidget"><div class="block-title"><span style="font-size: 18px;margin-bottom: 1px;">SPONSORED</span></div></div></aside>
            <div id="side-posts">

                    <?php
                        // Only render sidebar if no tags limiting sidebar
                        if (!$nosidebar){
                            $query = $query = new WP_Query( array( 'post_type' => 'sponsored', 'post__not_in' => array($postid), 'orderby' => 'date', 'posts_per_page' => 5 ) );


                            while ( $query->have_posts() ) : $query->the_post();
                                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );
                                $url = $thumb['0'];
                                echo '<a class="linkZero" target="_blank" href="';
                                the_permalink();
                                echo '"><h3 class="sidebar-posts-style titleZero"><img class="side-sponsored-image" src="';
                                echo $url;
                                echo '"></img>';
                                the_title();
                                echo '</h3></a>';
                            endwhile;
                        }
                    ?>

            </div>
        </div>
    </div> <!-- Sidebar Right end -->

</div>
<?php

    // echo '<pre>';
    // print_r( get_fields() );
    // print_r($meta);
    // echo '</pre>';

?>

<input class="holder" type="hidden" name="holder-one" value="null">
<input class="holder-comp-key" type="hidden" name="holder-comp-key" value="<?php echo $metav['compkey'];?>">


<div style="overflow: hidden;width: 100%;background-color: #3399FF;padding-top:20px;margin-top: 60px;">
    <div id="dt-section" style="font-size: 13px;color:#FFFFFF;overflow: hidden; width:100%; max-width:1074px;margin:auto;"></div>
</div>

<!--            -->
<!-- PIXEL AREA -->
<!--            -->
<div style="display:none"><?php echo $meta['pixel_area'][0];?></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/postscribe/2.0.8/postscribe.min.js"></script>



<style>
@media screen and (min-width: 767px) and (max-width: 1018px) {

    .sidebar-posts-style {font-size: 12px!important;height:90px!important;}
    img.side-sponsored-image {width: 80px!important;}

}
</style>
<script>
jQuery(document).ready(function() {

    // Checks for state variables and replaces if they exist

    function render4BtnAd(){
        var btnsHtml = '';

        <?php if( get_field('enable_4_button_ad') == 'yes' ):
            if( have_rows('button_group') ):
                while ( have_rows('button_group') ) : the_row(); ?>
                  btnsHtml += '<a type="button" target="_blank" isCheck="1" class="btn-red dynamic-link flex"><div><?php echo the_sub_field('button_title');?></div><i class="arrow right flex"></i></a>';
                  btnsHtml += '\n';
                <?php endwhile;
            endif;
        endif; ?>

        jQuery('#4-btn-ad-wrap').html(btnsHtml);
    }

    render4BtnAd();

    function show4BtnAd(){
        if (!jQuery('#4-btn-ad-wrap').is(':empty')){
            jQuery('#4-btn-ad-wrap a').each(function(index){
                jQuery(this).attr('info-data', jQuery(this).text());
            });
            jQuery('#4-btn-ad-wrap').hide().fadeIn(300);
        }
        jQuery('.cta-btn-wrap').hide().fadeIn(300);
        // Handles mobile float city text
        if (jQuery('a.mobile-float')){
            jQuery('a.mobile-float').each(function(index){
                jQuery(this).attr('info-data', jQuery(this).text());
            });

        }
    }

    var geoSuccess = false;

    if ( jQuery('state') || jQuery('stateabv') || jQuery('ex-city-state') || jQuery('city') ) {
        try {
            jQuery.when(geo()).done(function(loc){
                if ( Object.keys(loc).length > 0 ) {

                    if (jQuery('state')) {
                        jQuery( "state" ).each(function( index ) {
                            try{
                                var elem = jQuery(this);
                                var first = elem.attr('first');
                                var upper =  elem.attr('upper');
                                var lower = elem.attr('lower');

                                if (first != undefined) {
                                    elem.html(loc.state);
                                } else if(upper != undefined) {
                                    elem.html(loc.state.toUpperCase());
                                } else if (lower != undefined) {
                                    elem.html(loc.state.toLowerCase());
                                } else {
                                    elem.html(loc.state);
                                }
                            } catch(stateErr){};
                        });
                    }

                    if (jQuery('stateabv')) {
                        jQuery( "stateabv" ).each(function( index ) {
                            try{
                                var elem = jQuery(this);
                                var first = elem.attr('first');
                                var upper =  elem.attr('upper');
                                var lower = elem.attr('lower');
                                var state = abbrState(loc.state,'abbr');
                                console.log('stateabv', state, first, upper, lower);
                                if (first != undefined) {
                                    elem.html( camel(state) );
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

                    // for example: Los Angeles, CA
                    if (jQuery('ex-city-state')) {
                        jQuery( "ex-city-state" ).each(function( index ) {
                            try {
                                var elem = jQuery(this);
                                elem.html( '(for example: '+ loc.city + ', ' + abbrState(loc.state, 'abbr') + ')' );
                            }catch(excitystateErr) {}
                        });
                    }

                    if (jQuery('city')) {
                        jQuery( "city" ).each(function( index ) {
                            try {
                                var elem = jQuery(this);
                                var first = elem.attr('first');
                                var upper =  elem.attr('upper');
                                var lower = elem.attr('lower');

                                if (first != undefined) {
                                    elem.html( loc.city );
                                } else if(upper != undefined) {
                                    elem.html(loc.city.toUpperCase());
                                } else if (lower != undefined) {
                                    elem.html(loc.city.toLowerCase());
                                } else {
                                    elem.html(loc.city);
                                }

                            }catch(cityErr) {console.log(cityErr);}
                        });
                    }

                }

                // Show 4btn ad regardless
                show4BtnAd();

            });

            function geo(){
                return jQuery.ajax({
                    url: "https://geolocation-db.com/json/ccac0ae0-1c71-11e9-a0ce-dbd4f7d6e208",
                    dataType:'json',
                    success: function( loc ) {
                        return loc;

                        //"country_code": "US",
                        //"country_name": "United States",
                        //"city": "Denver",
                        //"postal": "80260",
                        //"latitude": 39.8672,
                        //"longitude": -105.0041,
                        //"IPv4": "192.168.1.101",
                        //"state": "Colorado"
                    },
                    complete: function(){
                        return {};
                    },
                    error: function(){
                        return {};
                    }
                });
            }

            function abbrState(a,n){var e=[["Arizona","AZ"],["Alabama","AL"],["Alaska","AK"],["Arizona","AZ"],["Arkansas","AR"],["California","CA"],["Colorado","CO"],["Connecticut","CT"],["Delaware","DE"],["Florida","FL"],["Georgia","GA"],["Hawaii","HI"],["Idaho","ID"],["Illinois","IL"],["Indiana","IN"],["Iowa","IA"],["Kansas","KS"],["Kentucky","KY"],["Kentucky","KY"],["Louisiana","LA"],["Maine","ME"],["Maryland","MD"],["Massachusetts","MA"],["Michigan","MI"],["Minnesota","MN"],["Mississippi","MS"],["Missouri","MO"],["Montana","MT"],["Nebraska","NE"],["Nevada","NV"],["New Hampshire","NH"],["New Jersey","NJ"],["New Mexico","NM"],["New York","NY"],["North Carolina","NC"],["North Dakota","ND"],["Ohio","OH"],["Oklahoma","OK"],["Oregon","OR"],["Pennsylvania","PA"],["Rhode Island","RI"],["South Carolina","SC"],["South Dakota","SD"],["Tennessee","TN"],["Texas","TX"],["Utah","UT"],["Vermont","VT"],["Virginia","VA"],["Washington","WA"],["West Virginia","WV"],["Wisconsin","WI"],["Wyoming","WY"]];if("abbr"==n){for(a=a.replace(/\w\S*/g,function(a){return a.charAt(0).toUpperCase()+a.substr(1).toLowerCase()}),i=0;i<e.length;i++)if(e[i][0]==a)return e[i][1]}else if("name"==n)for(a=a.toUpperCase(),i=0;i<e.length;i++)if(e[i][1]==a)return e[i][0]}
            function camel(val){return val.charAt(0).toUpperCase() + val.toLowerCase().slice(1);}

        } catch(e) {
            console.log("State Macro / GEO parsing - Unhandled Exception -", e);

        } finally {
            show4BtnAd();
            // setTimeout(show4BtnAd(), 2000);
           // initCtaTextEventHandlers();
        }

    } else {
        show4BtnAd();
    }


    // Parses URL Parameters
    jQuery.urlParam = function(name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        } else {
            return results[1] || 0;
        }
    }

    // Set working vars
    var theURL = window.location.href;
    var cleanURL = theURL.split("?")[0];
    var extraCleanURL = cleanURL.slice(8);
    var utmSource = jQuery.urlParam('utm_source');
    var utmMedium = jQuery.urlParam('utm_medium');
    var utmTerm = jQuery.urlParam('utm_term') ? jQuery.urlParam('utm_term') : 'organic';
    var utmCampaign = jQuery.urlParam('utm_campaign');
    var sponsorLink;
    var sponsorLinkFinal;
    var spSwitch;
    var i;
    var imageUrl;
    var title;
    var leaveBehindUrl;

    // Modify search wrapper based on link switch
    <?php if($metav['mask_switch']): ?>
        jQuery(".header-search-wrap").empty();
        jQuery(".header-search-wrap").append("<a class='dynamic-link' href='#'><div class='pos-box' style='position:absolute;right:0;top:0;bottom:0;margin-top:10px;text-align:right;'><span class='span-edit-one' style='color:white;font-size:17px;'>ADVERTISEMENT</span><br><span class='span-edit-two' style='color:white;font-size:12px;margin-top:-5px;display:block;text-align:right;'>by <?php echo $metav['sponsor']; ?></span></div></a>");
    <?php else: ?>
        jQuery(".header-search-wrap").empty();
        jQuery(".header-search-wrap").append("<div class='pos-box' style='position:absolute;right:0;top:0;bottom:0;'><span class='span-edit-one' style='color:white;font-size:17px;'>ADVERTISEMENT</span><br><span class='span-edit-two' style='color:white;font-size:12px;margin-top:-5px;display:block;text-align:right;'>by <?php echo $metav['sponsor']; ?></span></div>");
    <?php endif; ?>

    <?php if($noadby): ?>
        jQuery(".header-search-wrap").hide();
    <?php endif; ?>


    // Dynamic link base logic
    jQuery(".dynamic-link").attr("href", "<?php echo $metav['learnmore'];?>");
    jQuery(".dynamic-link").attr('onClick', "runIt(this);");
    jQuery(".dynamic-link").attr("target", "_top");

    jQuery('a[href*="{aff_id}"]').attr('onClick', 'runIt(this);');

    jQuery(".dynamic-link").css("cursor", "pointer");
    jQuery(".dynamic-link").attr("rel", "nofollow");


    // Generate sponsor link
    if (jQuery.urlParam('utm_source') == null) {
        var utmLink = "<?php echo $metav['utm_link']; ?>";
        sponsorLink = utmLink.replace(/{encodedrefurl}/g, encodeURIComponent(extraCleanURL));
        jQuery(".holder").val("" + sponsorLink + "");
    } else {
        var strLink = "<?php echo $metav['sponsor_link_real']; ?>";
        var resLink = strLink.replace(/{utm_medium}/g, jQuery.urlParam('utm_medium'));
        var uevLink = resLink.replace(/{utm_source}/g, jQuery.urlParam('utm_source'));
        var bmbLink = uevLink.replace(/{utm_term}/g, jQuery.urlParam('utm_term'));
        var theRef = bmbLink.replace(/{refurl}/g, extraCleanURL);
        var theERef = theRef.replace(/{encodedrefurl}/g, encodeURIComponent(extraCleanURL));
        var theLink = theERef.replace(/{utm_campaign}/g, jQuery.urlParam('utm_campaign'));
        sponsorLink = theLink;
        jQuery(".holder").val("" + sponsorLink + "");
    }


    // Set disclaimer message if it exists
    <?php if ($metav['disclaimer_switch']): ?>
        var discText = <?php echo json_encode($metav["disclaimer_text"]);?>;
        jQuery("#dt-section").html('<div class="td-post-text-content">' + discText + '</div>');
    <?php endif;?>
    var spLinkStart = "<?php echo $metav['soft_exit_pop_link'];?>";
    var spLinkUtm = "<?php echo $metav['soft_exit_pop_link_utm'];?>";
    window.imageUrl = "<?php echo $metav['img_url']; ?>";
    window.spSwitch = "<?php echo $metav['sp_switch_v']; ?>";


    // Generate Leave Behind Link
    if (jQuery.urlParam('utm_source') == null) {
        window.leaveBehindUrl = "<?php echo $metav['leave_behind_link']; ?>";
    } else {
        var strLinkBehind = "<?php echo $metav['leave_behind_link']; ?>";
        var resLinkBehind = strLinkBehind.replace(/{utm_medium}/g, jQuery.urlParam('utm_medium'));
        var uevLinkBehind = resLinkBehind.replace(/{utm_source}/g, jQuery.urlParam('utm_source'));
        var bmbLinkBehind = uevLinkBehind.replace(/{utm_term}/g, jQuery.urlParam('utm_term'));
        var theLinkBehind = bmbLinkBehind.replace(/{utm_campaign}/g, jQuery.urlParam('utm_campaign'));
        window.leaveBehindUrl = theLinkBehind;
    }

    if (window.spSwitch == "on") {
        if (jQuery.urlParam('utm_source') == null) {
            spLink = spLinkStart;
        } else {
            var staLink = "<?php echo $metav['soft_exit_pop_link_utm'];?>";
            var reaLink = staLink.replace(/{utm_medium}/g, jQuery.urlParam('utm_medium'));
            var ueaLink = reaLink.replace(/{utm_source}/g, jQuery.urlParam('utm_source'));
            var bmaLink = ueaLink.replace(/{utm_term}/g, jQuery.urlParam('utm_term'));
            var thaLink = bmaLink.replace(/{utm_campaign}/g, jQuery.urlParam('utm_campaign'));
            spLink = thaLink;
        }
        jQuery(".soft-pop-url").attr("href", spLink);
        jQuery(".soft-pop-url").on("click", function(e) {
            e.preventDefault();
            linkPopup();
        });
        jQuery(".pop-up-image").attr("src", window.imageUrl);
    }

    var lamjs_switch = "<?php echo $metav['lamjs_v']; ?>";
    if (lamjs_switch == "on") {
        jQuery("#the_categories").css('display', 'block');
        var utmMediumVar = "<?php echo $metav['lamjs_subid_two']; ?>";
        var mediumVar = utmMediumVar.replace(/{utm_medium}/g, jQuery.urlParam('utm_medium'));
        var utmSourceVar = "<?php echo $metav['lamjs_subid']; ?>";
        var sourceVar = utmSourceVar.replace(/{utm_source}/g, jQuery.urlParam('utm_source'));
        var pageOptions = {
            'campaign': "<?php echo $metav['lamjs_campaign']; ?>",
            'subid': sourceVar, //{utm_source}
            'subid2': mediumVar, //{utm_medium}
            'impression_track_url': "<?php echo $metav['lamjs_iturl']; ?>",
            'click_track_url': "<?php echo $metav['lamjs_click_track']; ?>",
            'search_track_url': "<?php echo $metav['lamjs_search_track']; ?>"
        };

        var categories = {
            type: 'category_page',
            container: 'the_categories',
        };

        lam.partner.render(pageOptions, categories);
        jQuery("#the_categories_two").css('display', 'block');
        var pageOptions = {
            'campaign': "<?php echo $metav['lamjs_campaign']; ?>",
            'subid': sourceVar, //{utm_source}
            'subid2': mediumVar, //{utm_medium}
            'impression_track_url': "<?php echo $metav['lamjs_iturl']; ?>",
            'click_track_url': "<?php echo $metav['lamjs_click_track']; ?>",
            'search_track_url': "<?php echo $metav['lamjs_search_track']; ?>"
        };
        var categories = {
            type: 'category_page',
            container: 'the_categories_two',
        };
        lam.partner.render(pageOptions, categories);
    }


    var blurExists = false;
    jQuery(document).on('DOMNodeInserted', function(e) {
        if(e.target.localName=="iframe" && e.target.ownerDocument.defaultView.frameElement == null){
            //console.log(e.target.ownerDocument.defaultView.frameElement);
            if (!blurExists) {
                var listener = window.addEventListener('blur', function() {
                    focus();
                    if ( document.activeElement.tagName === 'IFRAME' ){
                        //console.log('ranit');
                        if (!blurExists){
                            runIt();
                            blurExists = true;
                        }
                    }

                    window.removeEventListener('blur', listener);
                });
            };
        };
    });


    // $(window).on('load', function() {
        // console.log("window loaded");
        // $('iframe').on('load', function(){
            // console.log("Iframe loaded");
            // var listener = window.addEventListener('blur', function() {
                // console.log($(document.activeElement), $('iframe').first());
                // if ( $(document.activeElement) === $('iframe').first() ){
                    // console.log('ran it');
                    // runIt();
                // }
                // window.removeEventListener('blur', listener);
            // });
        // });
    // });






    var listener = window.addEventListener('blur', function() {
        if (jQuery(document.activeElement) === jQuery('iframe').first()){
            console.log('ran it');
            runIt();
        }
        // if (document.activeElement === document.getElementById('omtemplate-0')) {
            // runIt(); // clicked
        // }
        window.removeEventListener('blur', listener);
    });

    // four buttons at top functionality. Capture and update outgoing url parameters. {ctatext} and {encodedctatext}
    jQuery('.dynamic-link').click(function(e) {
        e.preventDefault();
        var attribute = jQuery(this).attr('info-data');
        if (jQuery(this).attr('info-data')) {
            var dynamic_ctatext = jQuery(this).attr('info-data');
            var dynamic_ectatext = dynamic_ctatext.replace(/[ ,]+/g, "+");
            dynamic_encodedctatext = encodeURIComponent(dynamic_ctatext);
            var sponsoredLinkOne = jQuery(".holder").val();
            var ectasponsoredlink = sponsoredLinkOne.replace(/{encodedctatext}/g, dynamic_encodedctatext); //replace {encodedctatext} with dynamic_encodedctatext
            var finishedSponsoredLink = ectasponsoredlink.replace(/{ctatext}/g, dynamic_ctatext); //replace {ctatext} with dynamic_ctatext
            jQuery(".holder").val("" + finishedSponsoredLink + "");
        }
        linkSwap();
    });

    // Mouseenter & Mouseleave
    jQuery("#lm-button").hover(function() {
        var sponsoredLinkOne = jQuery(".holder").val();
        var compKey = jQuery(".holder-comp-key").val();
        var ectasponsoredlink = sponsoredLinkOne.replace(/{encodedctatext}/g, compKey); //replace {encodedctatext} with dynamic_encodedctatext
        var finishedSponsoredLink = ectasponsoredlink.replace(/{ctatext}/g, compKey); //replace {ctatext} with dynamic_ctatext
        jQuery(".holder").val("" + finishedSponsoredLink + "");
    }, function() {
        var sponsoredLinkOne = jQuery(".holder").val();
        var compKey = jQuery(".holder-comp-key").val();
        var ectasponsoredlink = sponsoredLinkOne.replace(new RegExp(compKey, "g"), "{encodedctatext}"); //replace {encodedctatext} with dynamic_encodedctatext
        var finishedSponsoredLink = ectasponsoredlink.replace(new RegExp(compKey, "g"), "{ctatext}"); //replace {ctatext} with dynamic_ctatext
        jQuery(".holder").val("" + finishedSponsoredLink + "");
    });



    // Logic for loading facebook content into container if it's present
    if (jQuery(".facebook-container")) {
        jQuery(".facebook-container").html("<img style='display:block;margin:auto;' src='/wp-content/uploads/2017/11/facebook-img.jpg'></img>");
        var realFacebook;
        realFacebook = 1;
        jQuery(".facebook-container").mouseover(function() {
            if (realFacebook == 1) {
                realFacebook = 2;
                jQuery(".facebook-container").html("<iframe src='//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fmymoderntips&amp;width&amp;data-width=340&amp;data-height=225&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=579417315535309' scrolling='no' frameborder='0' style='border:none; overflow:hidden; height:290px; display:block; margin: 0 auto; width: 300px' allowTransparency='true'></iframe>");
            };
        });
    }


    // Extra event handlers
    jQuery('.mouse-pop').mouseenter(function() {
        if (window.spSwitch == "on") {
            if (window.i >= 1 && get_cookie() === '') {
                jQuery('.pop-up-box').show();
            }
        }
    });

    jQuery('.mouse-catch').mouseenter(function() {
        window.i = 2;
    });

    jQuery(".pop-exit").click(function() {
        set_cookie("show_light_box_popup", "true", 30, document.domain);
        jQuery(".pop-up-box").hide();
    });

    var str = window.location.href;
    if (str.search("/s/") != -1) {
        jQuery('.td-header-rec-wrap').hide();
    } else {};


    // Change aff_id and aff_sub to be based on url params if they exist, else replace with organic
    if ( jQuery('div.sponsored-page a').length > 0 ) {
        var aff_id = jQuery.urlParam('aff_id');
        var aff_sub = jQuery.urlParam('aff_sub');

        jQuery('div.sponsored-page a').each( function(index, element){
            var href = jQuery(this).attr('href');
            if (~href.indexOf("{aff_id}") && ~href.indexOf("{aff_sub}")) {
                if (aff_id && aff_sub && /^\d+$/.test(aff_id) && aff_id.length == 4) {
                    var newUrl = href.replace(/{aff_id}/g, aff_id).replace(/{aff_sub}/g, aff_sub);
                } else {
                    var newUrl = href.replace(/{aff_id}/g, '1010').replace(/{aff_sub}/g, 'organic');
                }

                jQuery(this).attr('href', newUrl);
                jQuery(this).attr('target', '_blank');
            }

        });
    }


    <?php if ($yahoo): ?>

    // setTimeout(function(){

    var ranIt = false;

    window.addEventListener('blur', function(){
        // console.log('blur');
        setTimeout(function(){
            // console.log('visState', document.visibilityState);
            if (!ranIt && document.visibilityState == 'hidden') {
                runIt();
                ranIt = true;
                // console.log('ranIt');
            } else if(ranIt) {
                // console.log('runIt previously fired');
            }
        }, 250);
    });


    <?php endif; ?>


    // General functions
    function linkSwap() {
        var holderVar = jQuery('.holder').val();
        new_window = window.open(holderVar, '_top');
        if (new_window.focus) {new_window.focus()}
        if (window.leaveBehindUrl) {
            window.location.href = window.leaveBehindUrl;
        }
    };

    function linkPopup() {
        var linkClicked = document.getElementByClassName('soft-pop-url').href;
        new_window = window.open(linkClicked,'_blank');
        if (new_window.focus) {new_window.focus()}
        if (window.leaveBehindUrl) {
            window.location.href = window.leaveBehindUrl;
        }
    }

    function set_cookie(cookie_name, cookie_value, lifespan_in_minutes, valid_domain) {
        var domain_string = valid_domain ? ("; domain=" + valid_domain) : '';
        document.cookie = cookie_name + "=" + encodeURIComponent(cookie_value) + "; max-age=" + 60 * lifespan_in_minutes + "; path=/" + domain_string;
    }

    function get_cookie() {
        return document.cookie.replace(/(?:(?:^|.*;\s*)show_light_box_popup\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    }

});
</script>


<?php get_footer(); ?>
