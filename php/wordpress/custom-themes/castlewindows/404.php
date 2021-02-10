<?php
/**
 * Template for 404 Page
 *
 * @package WordPress
 * @subpackage Castle Windows
 * @since CW 1.0
 */
get_header(); ?>
<div class="full mb404">
	<div class="base left">
		<div class="f16 w75 mbxsmall">
			<h1 class="nunito uppercase f56 msmall mbxsmall"><?php echo get_cw_option('404_lead_text'); ?></h1>
			<div class=""><?php echo get_cw_option('404_content'); ?></div>
		</div>
	</div>
</div>
<?php get_footer(); ?>