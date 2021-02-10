<?php
/**
 * The template for displaying Castle Windows Blog Pages
 */
?>

<?php get_header(); ?>
<main class="archive-page blog-post-page">
	<header>
		<div class="header-content">
			<h1>From our Blog</h1>
		</div>
	</header>
	
	<section class="main-content archive-content">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article class="post post-<?php the_ID(); ?>">
		
		 	<div class="img-container" style="background-image: url('<?php the_post_thumbnail_url(); ?>')">
				<a href="<?php the_permalink(); ?>"></a>
			</div>
				
			<div class="post-content">
				<h2 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<ul class="post-meta">
					<li class="author">
						by <?php the_author_posts_link(); ?>
					</li>
					<li class="cat">in <?php the_category( ', ' ); ?></li>
					<li class="date">on <?php the_time('F j, Y'); ?></li>
				</ul>
				
				<?php the_excerpt(); ?>
				
				<a href="<?php echo get_the_permalink(); ?>" title="<?php the_title(); ?>" class="btn btn-blog-read-more">Read more</a></div>
			</div>
			
		</article>
	
	<?php endwhile; else : ?>
	
	  <p><?php _e( 'Sorry, no posts found.' ); ?></p>
	
	<?php endif; ?>
	</section>
</main>

<?php if(get_post_meta(get_the_ID(), 'show_newsletter', true) == "on") { ?>
	<div class="full bg-ltgrey">
		<div class="base">
			<div class="msmall mbsmall"><?php echo do_shortcode(get_act_option('footer_form'), false); ?></div>
		</div>
	</div>
<?php } ?>

<?php get_footer(); ?>