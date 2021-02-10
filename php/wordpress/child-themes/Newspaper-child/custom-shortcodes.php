<?php
$GLOBALS['btnstyle'] =1;
function shortcode_cta_btn($atts = [], $content = null, $tag = '') {
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $s_atts = '';
    switch($GLOBALS['btnstyle']) {
        case 1:
            $s_atts = shortcode_atts([
                'btncolorstart' => '#fe1a00',
                'btncolorend' => '#ce0100',
                'btncolor' => '',
                'textcolor' => 'white',
                'textshadowcolor' => '#b23e35',
                'label' => 'Buy Now',
                'font_size' => '18px',
                'font_family' => 'Arial',
                'border_radius' => '6px',
                'border_color' => '#d83526',
                'border_width' => '1px',
                'link' => '#',
                'class' => '',
                'mobile_float' => 'no',
                'mobile_float_only' => 'no',
                'full_width' => 'no',
                'arrow' => 'yes',
                'arrowcolor' => '#fff',
                'target' => '_blank',
                'mediaid' => '0',
                'imagesrc' => ''
             ], $atts, $tag);
            break;
        case 2:
            $s_atts = shortcode_atts([
                'btncolorstart' => '#fff',
                'btncolorend' => '#fff',
                'btncolor' => '',
                'textcolor' => '#000',
                'textshadowcolor' => '#fff',
                'label' => 'Buy Now',
                'font_size' => '18px',
                'font_family' => 'Arial',
                'border_radius' => '6px',
                'border_color' => '#999',
                'border_width' => '1px',
                'link' => '#',
                'class' => '',
                'mobile_float' => 'no',
                'mobile_float_only' => 'no',
                'full_width' => 'no',
                'arrow' => 'yes',
                'arrowcolor' => '#000',
                'target' => '_blank',
                'mediaid' => '0',
                'imagesrc' => ''
             ], $atts, $tag);
            break;
        case 3:
            $s_atts = shortcode_atts([
                'btncolorstart' => '#fe1a00',
                'btncolorend' => '#ce0100',
                'btncolor' => '',
                'textcolor' => 'white',
                'textshadowcolor' => '#b23e35',
                'label' => 'Buy Now',
                'font_size' => '18px',
                'font_family' => 'Arial',
                'border_radius' => '6px',
                'border_color' => '#d83526',
                'border_width' => '1px',
                'link' => '#',
                'class' => '',
                'mobile_float' => 'no',
                'mobile_float_only' => 'no',
                'full_width' => 'no',
                'arrow' => 'yes',
                'arrowcolor' => '#000',
                'target' => '_blank',
                'mediaid' => '0',
                'imagesrc' => ''
             ], $atts, $tag);

            break;
        case 4:
            $s_atts = shortcode_atts([
                'btncolorstart' => '#fff',
                'btncolorend' => '#fff',
                'btncolor' => 'fff',
                'textcolor' => 'black',
                'textshadowcolor' => '#fff',
                'label' => 'Buy Now',
                'font_size' => '18px',
                'font_family' => 'Arial',
                'border_radius' => '6px',
                'border_color' => '#fff',
                'border_width' => '0px',
                'link' => '#',
                'class' => '',
                'mobile_float' => 'no',
                'mobile_float_only' => 'no',
                'full_width' => 'no',
                'arrow' => 'no',
                'arrowcolor' => '#000',
                'target' => '_blank',
                'mediaid' => '0',
                'imagesrc' => ''
             ], $atts, $tag);
            break;
    }
    $o = '';
    $o_s = '';
    switch($GLOBALS['btnstyle']) {
        case 1:
            $o_s = '<a class="cta-btn{$class}{$mobile_float}{$mobile_float_only} flex equalheight" referrerpolicy="no-referrer-when-downgrade" style="            
            display:inline-flex;
            width:{$full_width};
            flex-flow: row nowrap;
            justify-content: left;
            align-items: center;     
            text-align:left;
            box-shadow: 0px 1px 0px 0px #f29c93;
            background: {$background};
            border-radius: {$border_radius};
            -moz-border-radius: {$border_radius};
            -webkit-border-radius: {$border_radius};
            border: {$border_width} solid {$border_color};
            font-family: {$font_family};
            font-size: {$font_size};
            color: {$textcolor};            
            margin: 3px 3px;
            padding:12px 4px 12px 10px;
            font-weight: bold;
            position:relative;
            text-decoration: none;
            text-shadow: 1px 1px 0px {$textshadowcolor}"
            href="{$link}" info-data="{$label}" target="{$target}"><div style="flex: 1;margin-right:18px;line-height:21px;">{$label}</div>{$arrow}</a>';
            break;
        case 2:
            $imgurl = '';
            if($s_atts['mediaid'] != '0') {
                $tmp = wp_get_attachment_image_src($s_atts['mediaid'], 'medium');
                $imgurl = $tmp[0];
            } else {
                $imgurl = $s_atts['imagesrc'];
            }
            $o_s = '<a class="cta-btn{$class}{$mobile_float}{$mobile_float_only} flex equalheight" referrerpolicy="no-referrer-when-downgrade" style="            
            display:inline-flex;
            width:{$full_width};
            flex-flow: row nowrap;
            justify-content: left;
            align-items: center;     
            text-align:left;
            -webkit-box-shadow: 6px 6px 20px 0px rgba(0,0,0,0.29);
            -moz-box-shadow: 6px 6px 20px 0px rgba(0,0,0,0.29);
            box-shadow: 6px 6px 20px 0px rgba(0,0,0,0.29);
            background: {$background};
            border-radius: {$border_radius};
            -moz-border-radius: {$border_radius};
            -webkit-border-radius: {$border_radius};
            border: {$border_width} solid {$border_color};
            font-family: {$font_family};
            font-size: {$font_size};
            color: {$textcolor};            
            margin: 3px 3px;
            padding:4px 4px 4px 10px;
            font-weight: bold;
            position:relative;
            text-decoration: none;
            text-shadow: 1px 1px 0px {$textshadowcolor}"
            href="{$link}" info-data="{$label}" target="{$target}"><div class="cta-image"><img src="'.$imgurl.'" /></div><div class="cta-text">{$label}</div>{$arrow}</a>';
            break;
        case 3:
            $imgurl = '';
            if($s_atts['mediaid'] != '0') {
                $tmp = wp_get_attachment_image_src($s_atts['mediaid'], 'medium');
                $imgurl = $tmp[0];
            } else {
                $imgurl = $s_atts['imagesrc'];
            }
            $o_s = '<a class="cta-btn{$class}{$mobile_float}{$mobile_float_only} flex equalheight" referrerpolicy="no-referrer-when-downgrade" style="            
            display:inline-flex;
            width:{$full_width};
            flex-flow: row nowrap;
            justify-content: left;
            align-items: center;     
            text-align:left;
            background: {$background};
            font-family: {$font_family};
            font-size: {$font_size};
            color: {$textcolor};            
            margin: 3px 3px;
            padding:4px 4px 4px 10px;
            font-weight: bold;
            position:relative;
            text-decoration: none;
            text-shadow: 1px 1px 0px {$textshadowcolor}"
            href="{$link}" info-data="{$label}" target="{$target}"><div class="cta-image"><img src="'.$imgurl.'" /></div><div class="cta-text">{$label}</div>{$arrow}</a>';
            break;
        case 4:
            $imgurl = '';
            if($s_atts['mediaid'] != '0') {
                $tmp = wp_get_attachment_image_src($s_atts['mediaid'], 'medium');
                $imgurl = $tmp[0];
            } else {
                $imgurl = $s_atts['imagesrc'];
            }
            $o_s = '<a class="cta-btn{$class}{$mobile_float}{$mobile_float_only} flex ctafull" referrerpolicy="no-referrer-when-downgrade" style="            
            display:inline-block;
            width:{$full_width};
            flex-flow: row nowrap;
            justify-content: left;
            align-items: center;     
            text-align:left;
            background: {$background};
            font-family: {$font_family};
            font-size: {$font_size};
            color: {$textcolor};            
            margin: 3px 3px;
            padding:12px 4px 12px 10px;
            font-weight: bold;
            position:relative;
            text-decoration: none;
            text-shadow: 1px 1px 0px {$textshadowcolor}"
            href="{$link}" info-data="{$label}" target="{$target}"><div class="cta-imagefull"><img src="'.$imgurl.'" /></div><div class="cta-textfull">{$label}</div>{$arrow}</a>';
            break;
    }
    $vars = array(
        '{$mobile_float}' => ($s_atts['mobile_float'] == 'yes')?(' ' . 'mobile-float'):(''),
        '{$mobile_float_only}' => ($s_atts['mobile_float_only'] == 'yes')?(' ' . 'mobile-float-only'):(''),
        '{$background}'=> ($s_atts['btncolor'])?($s_atts['btncolor']):('-webkit-gradient(linear, left top, left bottom, color-stop(0.05, ' . $s_atts['btncolorstart'] . '), color-stop(1, ' . $s_atts['btncolorend'] . '))'),
        '{$border_radius}' => $s_atts['border_radius'],
        '{$border_width}' => $s_atts['border_width'],
        '{$border_color}' => $s_atts['border_color'],
        '{$font_family}' => $s_atts['font_family'],
        '{$font_size}' => $s_atts['font_size'],
        '{$textcolor}' => $s_atts['textcolor'],
        '{$textshadowcolor}' => $s_atts['textshadowcolor'],
        '{$class}' => ($s_atts['class'])?(' ' . $s_atts['class']):(''),
        '{$link}' => $s_atts['link'],
        '{$label}' => $s_atts['label'],
        '{$full_width}' => ($s_atts['full_width'] == 'yes')?('100%'):('48.5%'),
        '{$arrow}' => ($s_atts['arrow'] == 'yes')?('<i class="arrow right flex" style="border-color:'.$s_atts['arrowcolor'].'"></i>'):(''),
        '{$target}' => $s_atts['target'],
        '{mediaid}' => $s_atts['mediaid'],
        '{imagesrc}' => $s_atts['imagesrc']
    );
    $o_s_p = strtr($o_s, $vars);
    $o .= $o_s_p;
    return $o;
}
function shortcode_cta_wrap($atts = [], $content = null, $tag = '') {
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $s_atts = shortcode_atts(['sponsoredads' => 'no','sponsoredadstext' => 'Related Topics (Ads)','mobilesponsoredads' => 'no','btnstyle' => '1'], $atts, $tag);
    $o = '';
    if ($s_atts['sponsoredads'] == 'yes') {
        $o .= '<div class="f14"><label>'.$s_atts['sponsoredadstext'].'</label></div>';
    }
    if($s_atts['btnstyle']) {
        $GLOBALS['btnstyle'] = number_format($s_atts['btnstyle']);
    }
    $o_v = '<div class="cta-btn-wrap" data-mobile-sponsoredads="{$mobilesponsoredads}">';
    $vars = array(
        '{$mobilesponsoredads}' => $s_atts['mobilesponsoredads']
    );
    $o_s_p = strtr($o_v, $vars);
    $o .= $o_s_p;

    if (!is_null($content)) {
        $o .= do_shortcode($content);
    }
    $o .= '</div>';
    // return output
    return $o;
}
function shortcode_mobile_cta_wrap($atts = [], $content = null, $tag = '') {
    $o = '';
    $o .= '<div class="mobile-cta-wrap">';
    if (!is_null($content)) {
        $o .= do_shortcode($content);
    }
    $o .= '</div>';
    // return output
    return $o;
}
add_shortcode('ctabtn', 'shortcode_cta_btn');
add_shortcode('ctabtnwrap', 'shortcode_cta_wrap');
add_shortcode('mobilectawrap', 'shortcode_mobile_cta_wrap');
?>