<?php
/**
 * The Original template for displaying Castle Windows Blog Pages
 *
 * @package WordPress
 * @subpackage Castle Windows
 * @since CW 1.0
 */
get_header(); ?>
<div class="full blog-menu-adjustment">
	<div class="base left">
		<div class="inline w60 top ">
			<h1 class="uppercase f40 nunito mxsmall lrmobile"><?php the_title(); ?></h1>
			<div class="mbxsmall nunito f16 light darkgrey lrmobile">by <?php echo get_the_author(); ?> | <?php echo get_the_date("F j, Y"); ?></div>
			<div class="mbsmall lrmobile"><?php the_content(); ?></div>
		</div>
		<div class="inline w40 top mxsmall grey-left">
			<div class="mxsmall lrmobile">
			<?php if ( is_active_sidebar( 'custom-side-bar' ) ) : ?>
			    <?php dynamic_sidebar( 'custom-side-bar' ); ?>
			<?php endif; ?>	
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>