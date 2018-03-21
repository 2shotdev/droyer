<?php
/**
 * The template for displaying Neocate Parent & Patient Resources Page.
 *
 * @package WordPress
 * @subpackage Neocate
 * @since NEO 1.0
 */
$resources = get_post_meta(get_the_ID(), 'page_parent_resources', true);
$resource_ctr = 1;
get_header(); ?>
<?php get_theme_part( 'global', 'landing-header' ); ?>
<div class="full f0">
	<div class="inline resource-listing-left w50 f16 right">
		<?php foreach($resources as $key => $resource ) : 
			if($resource['parent_column']=='left') { ?>
			<div class="<?php echo $resource["parent_color"]; ?> relative">
				<div class="pbmedium pmedium resource-item left <?php echo $resource["parent_font_color"]; ?>">
					<div class="alignmiddle">
						<div class="f24 uppercase mbxxsmall lato-bold"><?php echo $resource["title"]; ?></div>
						<div class="f16"><?php echo $resource["parent_content"]; ?></div>
						<div class="psmall"><a class="button uppercase" href="<?php echo get_the_permalink($resource['parent_button_url']); ?>" title="<?php echo $resource['parent_button_text']; ?>"><?php echo $resource['parent_button_text']; ?></a></div>
					</div>
				</div>
			</div>
		<?php	} endforeach; ?>
	</div>
	<div class="inline resource-listing-right w50 f16 left">
		<?php foreach($resources as $key => $resource ) : 
			if($resource['parent_column']=='right') { ?>
			<div class="<?php echo $resource["parent_color"]; ?> relative">
				<div class="pbmedium pmedium resource-item left <?php echo $resource["parent_font_color"]; ?>">
					<div class="alignmiddle">
						<div class="f24 uppercase mbxxsmall lato-bold"><?php echo $resource["title"]; ?></div>
						<div class="f16"><?php echo $resource["parent_content"]; ?></div>
						<div class="psmall"><a class="button uppercase" href="<?php echo get_the_permalink($resource['parent_button_url']); ?>" title="<?php echo $resource['parent_button_text']; ?>"><?php echo $resource['parent_button_text']; ?></a></div>
					</div>
				</div>
			</div>
		<?php	} endforeach; ?>
	</div>		
</div>
<?php get_footer(); ?>