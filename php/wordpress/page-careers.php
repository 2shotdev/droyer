<?php
/**
 * Template for Careers
 *
 * @package WordPress
 * @subpackage Rev-D
 * @since RD 1.0
 */
$careers = new WP_Query(array(
	'post_type' => 'careers',
	'posts_per_page' => -1,
));
?>
<?php get_header(); ?>

<div class="full">
	<div class="base"><div class="ptitlelarge"><h1 class="ablebold red f60 uppercase"><?php the_title(); ?></h1></div></div>
</div>
<div class="full small-header mlarge" style="background-image: url(<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>);">
	<div class="base"><div class="psmall w65 centerblock"><h2 class="able f24 white"><?php the_content(); ?></h2></div></div>
</div>
<div class="full">
	<div class="base"><div class="psmall w65 centerblock"><h3 class="f16"><?php echo get_post_meta(get_the_ID(), 'page_sub_lead_in', true) ?></h3></div></div>
</div>
<div class="full psmall careers-information">
	<div class="base pbxlarge">
<?php while ($careers -> have_posts()) : $careers->the_post(); ?>
	<div class="relative career-opening half inline left mbsmall ">
		<h2 class="ablebold red f22 uppercase the-q mobile-left"><a href="# " title="<?php echo 'Careers: '.get_the_title(); ?>" class="red-link"><?php the_title(); ?></a></h2>
		<div class="f16  psmall left the-a">
			<?php the_content(); ?>
			<div class="center psmall"><a href="#" title="<?php echo get_the_title(); ?>" ref="<?php echo get_post_meta(get_the_ID(), 'careers_email_group', true); ?>" class="inline black-button apply-button">Apply Now</a></div>
		</div>
	</div>
	<div class="clearing">&nbsp;<!-- IE Fix --></div>
<?php endwhile; wp_reset_postdata(); ?>	
	</div>
</div>

<div class="full lightgrey-bg">
<div class="base pxlarge">
		<div class="half inline left center"><?php echo do_shortcode(get_post_meta(get_the_ID(), 'page_job_form_short_code', true)); ?></div>
	</div>
</div>

<script language="javascript" src="<?php echo get_stylesheet_directory_uri().'/inc/assets/js/careers.js'; ?>"></script>
 <?php get_footer(); ?>