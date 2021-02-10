<?php
/**
 * The template for displaying site social icons
 * This template is used in footer.php
 *
 * @package WordPress
 * @subpackage Daily's
 * @since DL 1.0
 */
?>
<div class="social inline psmall">
 	<?php foreach ( get_neo_option( 'site_social', array() ) as $social ): ?>
 	<?php if($social['class'] == "") { ?>
		<a ref="<?php echo esc_attr( $social['url'] ); ?>" title="<?php echo esc_attr( $social['title'] ); ?>" class="inline <?php echo esc_attr( $social['class'] ); ?>"></a>
	<?php } else { ?>
		<a href="<?php echo esc_url( $social['url'] ); ?>" title="<?php echo esc_attr( $social['title'] ); ?>" target="_blank" class="inline <?php echo esc_attr( $social['class'] ); ?>"></a>
	<?php } ?>
	<?php endforeach ?>
</div>