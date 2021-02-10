<div class="full home-banner relative" style="background-image:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>);">
	<div class="mobile-gradient-cover">&nbsp;<!-- IE Fix --></div>
	<div class="base home-banner landing-content">
		<div class="home-banner-content w47 f0 alignmiddle-bottom-left">
			<?php if(get_post_type() == "recipe") { ?>
				<h1 class="purple f64 lunchbox left mbxxsmall uppercase"><?php the_title();?></h1>
			<?php } else { ?> 
				<h1 class="purple f64 lunchbox left mbxxsmall  uppercase"><?php echo get_post_meta(get_the_ID(), 'page_h1', true);?></h1>
				<div class="clearing">&nbsp;<!-- IE Fix --></div>
				<?php if (get_post_meta(get_the_ID(), 'page_h2', true) != "") {?><h2 class="grey f24 lato left mbxxsmall"><?php echo get_post_meta(get_the_ID(), 'page_h2', true);?></h2><?php } ?>
				<div class="clearing">&nbsp;<!-- IE Fix --></div>
				<h3 class="f16 left"><?php the_content();?></h3>
			<?php } ?>
			<?php if(strtolower(the_slug(get_the_ID())) == "neocate-guides-faqs") { ?>
				<div class="chat-wrapper mxsmall"><p class="center pbxxsmall f16"><a class="pink-button button white f16 uppercase files chat full-block mbxxxsmall" href="/">Live Customer Support</a><span class="chattext pink bold uppercase">or call</span> <a class="pink bold tel files phone" href="tel:+18003657354">1-800-365-7354</a><br /> Available Mon-Fri, 8:30 am-7:00 pm ET</p></div>
			<?php } ?>
		</div>
		<?php if(get_post_type() == "recipe") { ?>
		<div class="recipe-buttons f14">
			<a href="/recipes/" title="View All Recipes" class="button pink-button uppercase">View All Recipes</a>
		</div>
		<?php get_theme_part( 'global', 'share');?>
		<?php } ?>
	</div>
	<?php if(get_post_meta(get_the_ID(), 'page_image_credit', true) != "") { ?>
	<div class="image-credit f16 lunchbox purple"><?php echo get_post_meta(get_the_ID(), 'page_image_credit', true); ?></div>
	<?php } ?>
</div>