<?php
/**
 * Block Name: ctabtn
 *
 * This is the template that displays the ctabtn block.
 */

// the_field('', false, false)
// disables wpautop and autobr from affecting the content of the field
do_shortcode(the_field('ctabtn', false, false));
?>