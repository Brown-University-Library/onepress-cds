<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Data Template-Part File
 *
 * @file           post-data.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/post-data.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
?>

<?php if ( !is_page() && !is_search() ) { ?>

	<div class="post-data">
		<?php printf( __( '&laquo; All items from %s', 'responsive' ), get_the_category_list( ', ' ) ); ?>
		<?php the_tags( __( 'Tagged with:', 'responsive' ) . ' ', ', ', '<br />' ); ?>
	</div><!-- end of .post-data -->

<?php } ?>

