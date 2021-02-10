<?php
/**
 * The template for displaying Castle Windows Category listing pages
 *
 * @package WordPress
 * @subpackage Castle Windows
 * @since CW 1.0
 */
get_header(); ?>
<div class="full menu-adjustment">
		<div class="base">
			<div class="blog-listing msmall mbsmall left">
			<?php if ( have_posts() ) { 
					while(have_posts()) : the_post(); ?>
						<div class="one-third inline border-grey msmall top left">
							<div class="listing-image mbsmall"><a href="<?php echo get_the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></a></div>
							<h2 class="msmall uppercase f30 nunito mbxxsmall plrmedium"><a href="<?php echo get_the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
							<div class="mbxxsmall nunito f16 light plrmedium darkgrey">by <?php echo get_the_author(); ?> | <?php echo get_the_date("F j, Y"); ?></div>
							<div class="plrmedium"><?php the_excerpt(); ?></div>
							<div class="read-more plrmedium mbsmall"><a href="<?php echo get_the_permalink(); ?>" title="<?php the_title(); ?>" class="ltblue">read more</a></div>
						</div>
					<?php endwhile; ?>
			<?php } ?>
			</div>
		</div>
</div>
<?php if(get_post_meta(get_the_ID(), 'show_newsletter', true) == "on") { ?>
	<div class="full bg-ltgrey">
		<div class="base">
			<div class="msmall mbsmall"><?php echo do_shortcode(get_act_option('footer_form'), false); ?></div>
		</div>
	</div>
<?php } ?>
<?php get_footer(); ?>