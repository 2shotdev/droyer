<?php
/**
 * The template for displaying Castle Windows posts/pages.
 *
 * @package WordPress
 * @subpackage Castle Windows
 * @since CW 1.0
  * Template Name: Base Template w/Rail
  * Template Post Type: post, page
 */
get_header(); ?>
<div class="full menu-adjustment">
	<div class="base">
		<div class="inline w60 top"><?php the_content(); ?></div>
		<div class="inline w40 top">
			<div class="relative search icon mbxsmall"><input type="text" name="search" class="search-rail" /></div>
			<?php if ( is_active_sidebar( 'custom-side-bar' ) ) : ?>
			    <?php dynamic_sidebar( 'custom-side-bar' ); ?>
			<?php endif; ?>	
		</div>
	</div>
</div>
<?php get_footer(); ?>