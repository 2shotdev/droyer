<?php
/**
 * Template for Home Page
 *
 * @package WordPress
 * @subpackage Rev-D
 * @since RD 1.0
 */

?>
<?php get_header(); ?>
<?php get_theme_part( 'home', 'video_header' ); ?>
<div class="full">
	<div class="base plarge"><div class="w65 aligncenter"><?php the_content(); ?></div></div>
</div>
<?php get_theme_part( 'home', 'featured_work' ); ?>
<?php get_theme_part( 'home', 'front_modules' ); ?>
<?php get_theme_part( 'home', 'clients' ); ?>
<?php get_theme_part( 'home', 'featured-blog' ); ?>
<?php get_footer(); ?>