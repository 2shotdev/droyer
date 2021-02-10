<?php
/**
 * Template for Castle Windows Search Page
 *
 * @package WordPress
 * @subpackage Castle Windows
 * @since CW 1.0
 */
$paged = 1;
$url = strtok($_SERVER["REQUEST_URI"],'?');
$tokens = explode('/', $url);
if((int) $tokens[sizeof($tokens)-1] > 0 ) {$paged = (int) $tokens[sizeof($tokens)-1];} else { $paged = 1;};
$max=$wp_query->found_posts;
$maxpages = ceil($max/get_act_option('search_count'));
$showmax = 4;
$loopstart=1;
if($paged > 2) {
	$loopstart = $paged-2;
}
$searchurl =  "/search/".get_search_query()."/page/";
get_header(); ?>
<div class="full menu-adjustment">
	<div class="base left">
		<? if(have_posts()) { ?>
			<div class="f16 w75 mbxsmall">
				<h1 class="nunito uppercase f36 mxsmall mbxsmall lrmobile"><?php echo get_act_option('search_title'); ?></h1><span class="f20 normal"><?php if($max>1) {echo $max." Results Found.";} else { echo $max." Result Found.";} ?></span>
			</div>
			<div class="blog-listing mbsmall center">
		<?php while ( have_posts() ) : the_post(); ?>
				<div class="one-third inline border-grey msmall top left">
					<?php if(wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())) != "") { ?>
						<div class="listing-image mbsmall"><img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></div>
					<?php } ?>
						<h2 class="msmall uppercase f30 nunito mbxxsmall plrmedium"><a href="<?php echo get_the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<?php if(get_post_type(get_the_ID()) == "post") { ?>
						<div class="mbxxsmall nunito f16 light plrmedium darkgrey">by <?php echo get_the_author(); ?> | <?php echo get_the_date("F j, Y"); ?></div>
					<?php } ?>
					<div class="plrmedium"><?php the_excerpt(); ?></div>
					<div class="read-more plrmedium mbsmall"><a href="<?php echo get_the_permalink(); ?>" title="<?php the_title(); ?>" class="ltblue">read more</a></div>
				</div>
		<?php endwhile; wp_reset_postdata();?>
			</div>
			<?php  if($maxpages > 1) { ?>
				<div class="pagination center mbsmall">
					<?php if($paged != 1) {?>
					<a href="<?php $prev = $paged-1; echo $searchurl.$prev;?>" title="Previous Page" class="button blue-button mlrmedium f16">Previous</a>
					<?php } ?>
					<div class="pages inline f16 bold">
						<?php for($x = $loopstart; $x <= $showmax+$loopstart; $x++) {
							if($x <= $maxpages) {
							if($x != $paged) { ?>
								<a href="<?php echo $searchurl.$x; ?>" title="Page: <?php echo $x; ?>" class="nav-circle inline box"><?php echo $x; ?></a>
							<?php } else { ?>
								<a href="<?php echo $searchurl.$x; ?>" title="Page: <?php echo $x; ?>" class="nav-circle active inline box"><?php echo $x; ?></a>
						<?php } } } ?>
					</div>
					<?php if($paged+1 <= $maxpages) {?>
					<a href="<?php $nxt = $paged+1; echo $searchurl.$nxt;?>" title="Next Page"  class="button blue-button mlrmedium f16">Next</a>
					<?php } ?>
				</div>
			<?php  } ?>
			<?php  } else { ?>
					<h1 class="nunito uppercase f36 msmall mbxsmall"><?php echo get_act_option('search_none'); ?></h1>
					<div class="f16 w75 mb404"><?php echo get_act_option('search_none_content'); ?></div>
			<?php } ?>
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