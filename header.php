<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OnePress
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'onepress_before_site_star' ); ?>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'onepress' ); ?></a>
    <?php
    /**
     * Hooked: onepress_site_header
     *
     * @see onepress_site_header
     */
//     do_action( 'onepress_site_start' ); //  Comment this line out, because we want custom header links
?>
<header id="masthead" class="site-header" role="banner">
     <div class="container">

         <!-- BUL-branding -->

         <div class="header-right-wrapper">
             <a href="#0" id="nav-toggle"><?php _e('Menu', 'onepress'); ?><span></span></a>
             <nav id="site-navigation" class="main-navigation" role="navigation">
 
                 <ul class="onepress-menu">
                     <?php 
                     // Grab the main nav from BUL web and display it here
                     $universal_bul_nav_menu = file_get_contents("/var/www/html/includes/universal_header_include.html") ;

                    $count = 0 ;
                    
                    $patterns = array('/<a/', '/<\/a>/', '/<div style="width: 100%;" id="libnav">/', '/<\/div>/') ;
                    $replacements = array('<li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-2 current_page_item menu-item-8"><a', '</a></li>', '', '') ;
                                        
                    foreach($patterns as $pattern) {
                        $universal_bul_nav_menu = preg_replace($pattern, $replacements[$count], $universal_bul_nav_menu ) ;
                        ++$count ;
                    }
                  
                     echo $universal_bul_nav_menu ;
                     
//                      wp_nav_menu(array('theme_location' => 'primary', 'container' => '', 'items_wrap' => '%3$s'));  
//This is the main menu, but it's commented out here. If we want a site menu, we can add it to a template file.
                     
                     ?>
                 </ul>
 
             </nav>
             <!-- #site-navigation -->
         </div>
     </div>
 </header><!-- #masthead -->


<!-- end of header.php --> 