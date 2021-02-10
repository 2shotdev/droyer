<?php
/**
 * The template for displaying Castle Windows Blog Pages
 */
?>

<?php get_header(); ?>
<main class="blog-post-page">
	<article class="post post-<?php the_ID(); ?>">
		
		<?php if( has_post_thumbnail() ) : ?>
		 	
		 	<header class="has-bg" style="background-image: url('<?php the_post_thumbnail_url(); ?>')">
		<?php else: ?>
		
			 <header>
				 
		<?php endif; ?>
				<div class="header-content">
					<h1 class="post-title"><?php the_title(); ?></h1>
					<ul class="post-meta">
						<li class="author">
							by <?php the_author_posts_link(); ?>
						</li>
						<li class="cat">in <?php the_category( ', ' ); ?></li>
						<li class="date">on <?php the_time('F j, Y'); ?></li>
					</ul>
				</div>
			</header>
			
			<section id="post-content">
				<?php the_content(); ?>	
			</section>
	</article>
</main>

<?php get_footer(); ?>