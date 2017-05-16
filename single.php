<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package OnePress
 */

get_header();
/* $layout = get_theme_mod( 'onepress_layout', 'right-sidebar' ); */
$layout = get_theme_mod( 'onepress_layout' );
?>

	<div id="content" class="site-content">

		<?php echo onepress_breadcrumb(); ?>
             
		<div id="content-inside" class="container <?php echo esc_attr( $layout ); ?>">
			<div id="single-post-hero-header-default">
			<?php if ( false || $layout != 'no-sidebar' ) { ?>
			    <?php get_sidebar(); ?>
			<?php } ?>
			
			<div id="primary" class="content-area">
              
                <div id="site_content_menu"> 
                    <ul>
                        <?php
                            wp_nav_menu(array('theme_location' => 'primary', 'container' => '', 'items_wrap' => '%3$s'));  
                        ?>
                    </ul>
                </div>
                            
				<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // End of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->

		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
