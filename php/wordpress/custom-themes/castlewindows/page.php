<?php
/**
 * The template for displaying ACT Basic Pages
 *
 * @package WordPress
 * @subpackage ACT
 * @since ACT 1.0
 */
get_header(); ?>
<div class="full menu-adjustment"><?php the_content(); ?></div>
<?php if(get_post_meta(get_the_ID(), 'show_newsletter', true) == "on") { ?>
	<div class="full bg-ltgrey">
		<div class="base">
			<div class="msmall mbsmall"><?php echo do_shortcode(get_act_option('footer_form'), false); ?></div>
		</div>
	</div>
<?php } ?>
<?php get_footer(); ?>