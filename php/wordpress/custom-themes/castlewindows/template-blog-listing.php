<?php
/**
 * The template for displaying Castle Windows posts/pages.
 *
 * @package WordPress
 * @subpackage Castle Windows
 * @since CW 1.0
  * Template Name: Blog Listing
  * Template Post Type: page
 */
$posts = new WP_Query(array(
   'post_type' => 'post',
   'posts_per_page' => -1,
   'order_by' => 'date',
   'order' => 'DESC'
)
);
get_header(); ?>
<div class="full menu-adjustment">
			<?php if (!empty( get_the_content() ) ) {  ?>
			<div class="mbsmall"><?php the_content(); ?></div>
		<?php } ?>
			<div class="blog-listing msmall mbsmall">
						<?php while ($posts -> have_posts()) : $posts->the_post();?>
						<div class="one-third inline border-grey msmall top left">
							<div class="listing-image mbsmall"><a href="<?php echo get_the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></a></div>
							<h2 class="msmall uppercase f30 nunito mbxxsmall plrmedium"><a href="<?php echo get_the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
							<div class="mbxxsmall nunito f16 light plrmedium darkgrey">by <?php echo get_the_author(); ?> | <?php echo get_the_date("F j, Y"); ?></div>
							<div class="plrmedium"><?php the_excerpt(); ?></div>
							<div class="read-more plrmedium mbsmall"><a href="<?php echo get_the_permalink(); ?>" title="<?php the_title(); ?>" class="ltblue">read more</a></div>
						</div>
					<?php endwhile; ?>
			</div>
		</div>
</div>
<?php get_footer(); ?>