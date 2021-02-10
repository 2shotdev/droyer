<?php 
  $color="bg-purple";
  if(get_post_meta(get_the_ID(),"header_background",true) != "" ) {$color=get_post_meta(get_the_ID(),"header_background",true);}
?>
<div class="full base-banner <?php echo $color; ?>">
	<div class="base left base-banner">
		<h1 class="lunchbox f64 white alignmiddle-bottom-left uppercase w85"><?php the_title();?></h1>
		<?php if(get_post_type() == "blog" || get_post_type() == "news" || get_post_type() == "story") { ?>
			<?php get_theme_part( 'global', 'share');?>
		<?php } ?>
	</div>
</div>
<?php if(wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())) != "")  { ?>
<div class="full home-banner relative" style="background-image:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>);">
	<div class="base home-banner">
		<div class="home-banner-content w50 f0 alignmiddle-bottom-left">&nbsp;<!-- IE Fix --></div>
	</div>
</div>
<?php } ?>