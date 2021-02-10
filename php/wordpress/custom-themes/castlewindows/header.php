<?php
/**
 * The Header for our theme.
 *
 * @package WordPress
 * @subpackage Castle Windows
 * @since CW 1.0
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NFC8N8B');</script>
<!-- End Google Tag Manager -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" id="viewport" content="width=device-width,maximum-scale=1,user-scalable=1,initial-scale=1.0" />
	<meta name = "format-detection" content = "telephone=no">
	<link rel="icon" type="image/png" href="/favicon.png">
	<link rel="icon" type="image/ico" href="/favicon.ico"/>
	<link rel="apple-touch-icon" href="/icons/apple-touch-icon.png" sizes="57x57">
	<link rel="apple-touch-icon" href="/icons/apple-touch-icon-72x72.png" sizes="72x72">
	<link rel="apple-touch-icon" href="/icons/apple-touch-icon-76x76.png" sizes="76x76">
	<link rel="apple-touch-icon" href="/icons/apple-touch-icon-114x114.png" sizes="114x114">
	<link rel="apple-touch-icon" href="/icons/apple-touch-icon-120x120.png" sizes="120x120">
	<link rel="apple-touch-icon" href="/icons/apple-touch-icon-144x144.png" sizes="144x144">
	<link rel="apple-touch-icon" href="/icons/apple-touch-icon-152x152.png" sizes="152x152">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="msapplication-TileImage" content="/icons/apple-touch-icon-144x144.png">
	<meta name="msapplication-TileColor" content="#25b2bb"/>
	<meta name="application-name" content="Advanced Cell Training" />
	<meta name="author" content="Advanced Cell Training">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
	<style>
		.icons,.icon:after, .testimonial:after{background-image:url(<?php echo get_cw_option('site_icons');?>);}
		.social-icons>a{background-image:url(<?php echo get_cw_option('social_icons');?>);}
	</style>
</head>
<body>
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NFC8N8B"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<div class="full mobile-hide bg-yellow utility-sticky">
		<div class="base utility right">
			<?php wp_nav_menu( array( 'theme_location' => 'utility', 'menu_class' => 'nav-utility f14 relative black', 'container' => false) ); ?>
		</div>
	</div>