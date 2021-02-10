<?php
/**
 * The template for displaying Castle Windows theme footer.
 *
 * @package WordPress
 * @subpackage Castle Windows
 * @since CW 1.0
 */
?>
	<footer>
		<section id="main-footer-section">
			<?php if(get_cw_option('footer_section1') != "") { ?>
				<div class="footer-section inline">
					<?php echo str_replace('%s', date('Y'), get_cw_option('footer_section1')); ?>
				</div>
			<?php } ?>
			<?php if(get_cw_option('footer_section2') != "") { ?>
				<div class="footer-section inline">
					<?php echo str_replace('%s', date('Y'), get_cw_option('footer_section2')); ?>
				</div>
			<?php } ?>
			<?php if(get_cw_option('footer_section3') != "") { ?>
				<div class="footer-section inline">
					<?php echo str_replace('%s', date('Y'), get_cw_option('footer_section3')); ?>
				</div>
			<?php } ?>
		</section>
		<section id="copyright-section">
			<p>Copyright &copy;<?php echo date('Y') ?> Castle Windows. All Rights Reserved.</p>
		</section>
	</footer>
	
	<div id="main-menu-nav" class="full nav-bar mobile-hide bg-black transparent">
		<div class="base navigation right"><div class="float-left logo"><a href="/" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo get_cw_option('site_logo');?>" title="<?php bloginfo( 'name' ); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a><div class="shine"><img src="/wp-content/themes/castlewindows/inc/assets/images/shine-effect.png" alt="Castle Shine" title="Castle Shine" /></div></div><?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-primary inline f16 relative yellow uppercase', 'container' => false) ); ?></div>
	</div>
	<div id="mobile-menu-nav" class="mobile-full-menu bg-black"><?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-mobile-open f18 white relative uppercase', 'container' => false) ); ?><?php wp_nav_menu( array( 'theme_location' => 'utility', 'menu_class' => 'f16 white relative uppercase', 'container' => false) ); ?></div>
	<div class="full bg-black nav-mobile mobile-show left">
		<div class="base navigation">
			<div class="inline logo-mobile-sticky box">
				<a href="/" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo get_cw_option('site_logo');?>" title="<?php bloginfo( 'name' ); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
				<div class="mobile-expand inline fa fa-bars">&nbsp;</div>
			</div>
		</div>
	</div>
<?php echo get_cw_option('footer_scripts'); ?>
<?php wp_footer(); ?>
<?php
  /**
   * set a fake logged-in user cookie to break out of
   * wpe's caching as needed. Is only set if no other
   * CMS logged-in-user cookie has been set already.
   *
   * @return boolean true if new cookie set. false otherwise
   */
  function maybe_set_user_cookie() {

    $cookie_was_set = false;

    if ( false === ($cook = has_logged_in_user_cookie()) ) {
      $expire = time()+3600;  # modify expiration time to suit your needs
      set_fake_user_logged_in_cookie($expire);
      $cookie_was_set = true;
    }

    return $cookie_was_set;

  }

  # unset fake CMS user cookie
  function remove_user_cookie() {
    $expired = time()-3600;
    set_fake_user_logged_in_cookie($expired);
  }

  function set_fake_user_logged_in_cookie($expire=0) {
    $fake_user = '_fake_user_';
    $cookie = 'wordpress_logged_in_' . md5($fake_user);
    $value = md5($fake_user);
    setcookie($cookie, $value, $expire, '/');
  }

  # determine if logged-in cookie is already set
  function has_logged_in_user_cookie() {
    $patt = 'wordpress_logged_in_';
    foreach($_COOKIE as $cook => $val) {
      if( 0 === strpos($cook, $patt) ) {
        return $cook;
      }
    }
    return FALSE;
  } ?>
  
  
</body>
</html>