<?php
/**
 * The template for displaying Neocate Conditions & Symptoms Page.
 *
 * @package WordPress
 * @subpackage Neocate
 * @since NEO 1.0
 */
$conditions = get_post_meta(get_the_ID(), 'page_parent_conditions', true);
get_header(); ?>
<?php get_theme_part( 'global', 'landing-header' ); ?>
<div class="full f0">
<?php foreach($conditions as $key => $condition ) : ?>
<div class="pbmedium pmedium condition-item relative inline w50 left" style="background-image:url(<?php echo $condition['conditions_image']; ?>);">
	<div class="condition-cover <?php echo $condition['conditions_color']; ?>" style="opacity:.<?php echo $condition['conditions_opacity']; ?>;">&nbsp;<!-- IE Fix --></div>
	<div class="alignmiddle left">
		<div class="uppercase f24 lato-bold white mbxxsmall"><?php echo $condition['title']; ?></div>
		<div class="f18 white mbsmall"><?php echo $condition['conditions_lead_text']; ?></div>
		<?php if($condition['conditions_button_url'] != "") { ?>
			<a href="<?php echo get_the_permalink($condition['conditions_button_url']); ?>" title="<?php echo $conditions['tile']; ?>" class="white-button button uppercase f16 purple"><?php echo $condition['conditions_button_text']; ?></a>
			<?php if($condition['conditions_button2_text'] != "") {?><a href="<?php echo $condition['conditions_button2_url']; ?>" title="<?php echo $conditions['conditions_button2_text']; ?>" class="purple-button button uppercase f16 white mlsmall"><?php echo $condition['conditions_button2_text']; ?></a><?php } ?>
		<?php } else {?>
			<a href="<?php echo $condition['conditions_button2_url']; ?>" title="<?php echo $conditions['conditions_button2_text']; ?>" class="white-button button uppercase f16 purple"><?php echo $condition['conditions_button2_text']; ?></a>
		<?php } ?>
	</div>
</div>
<?php endforeach; ?>
</div>
<?php get_footer(); ?>