<?php header('Content-Type: application/json'); ?>
<?php
// Include WordPress
if($_GET["token"] === "ualremkwol290675kso91mcmf"){
	define('WP_USE_THEMES', false);
	require('../wp-load.php');
	$blogs = new WP_Query(array(
		'post_type' => 'blog',
		'posts_per_page' => -1,
		'orderby' => 'date',
		'order'=>'desc'
	));
	echo "[";
	$ctr = 0;
	$buttontext = "Read More";
	while ($blogs -> have_posts()) : $blogs->the_post();?>
	<?php 
		$cond="all ";$ag="all ";$cats="all ";
		$conditions = wp_get_post_terms(get_the_ID(), 'blog_condition', array('fields'=>'all'));
		$ages = wp_get_post_terms(get_the_ID(), 'blog_age', array('fields'=>'all'));
		$categories = wp_get_post_terms(get_the_ID(), 'blog_category', array('fields'=>'all'));
		foreach ($conditions as $condition) :
			$cond .= $condition->slug." ";
		endforeach;
		foreach ($ages as $age) :
			$ag .= $age->slug." ";
		endforeach;
		foreach ($categories as $category) :
			$cats .= $category->slug." ";
		endforeach;
	?>
	<?php if($ctr == 0) {++$ctr;} else {echo ",";} ?>
	{
	"id":"<?php echo get_the_ID(); ?>",
	"title":"<?php echo get_the_title(); ?>",
	"hovercolor":"<?php echo get_post_meta(get_the_ID(), 'page_color', true); ?>",
	"hoveropacity":"<?php echo get_post_meta(get_the_ID(), 'page_opacity', true); ?>",
	"image":"<?php echo get_post_meta(get_the_ID(), 'page_image', true); ?>",
	"link":"<?php echo get_the_permalink(); ?>",
	"dte":"<?php echo the_date("m/d/Y"); ?>",
	"buttontext":"<?php echo $buttontext; ?>",
	"condition":"<?php echo $cond; ?>",
	"categories":"<?php echo $cats; ?>",
	"ages":"<?php echo $ag; ?>"
	}
	<?php endwhile; echo "]";?>
<?php } ?>