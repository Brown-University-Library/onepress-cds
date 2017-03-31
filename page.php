<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress
 */

get_header(); ?>

	<div id="content" class="site-content">

		<div class="page-header">
			<div class="container">
				<img alt="Brown University Library -- link to Brown Home Page" src="https://library.brown.edu/common/images/wordmark_for_dark_background.png" style="width : 125px ; float : left ; ">
				
				<form accept-charset="UTF-8" action="https://search.library.brown.edu/" method="get"><div style="display:none"><input name="utf8" type="hidden" value="&#x2713;" />
				</div>
				<div style="width : 50% ; float : right ; margin-top : 6px ;  " >
				  <div style="float : right ; ">
				        <label for="q" value="search box" />
                      <input style="border-radius : 4px 0px 0px 4px ; width : 270px ; height : 25px ; font-size : .8em ; margin : 0px ; " id="q" name="q" placeholder="Enter keywords to search library resources" type="text" value=""  />
                    <button type="submit" class="btn" style="width : 50px ; height : 25px ; background-color : #FFC72C ; font-size : .7em ; color : #4E3629 ; padding : 0px ; border-radius : 0px 4px 4px 0px ; margin : 0px 0px 0px -6px ; " id="search">
                        <span class="submit-search-text">Search</span>
                    </button>
				  </div>
				</div>
				</form>
				

			</div>
		</div>

        <?php echo onepress_breadcrumb(); ?>
        
        <!-- hero goes here -->
        <?php dynamic_sidebar( 'hero_image' ); ?>

		<div id="content-inside" class="container no-sidebar">
		
		
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

						<?php get_template_part( 'template-parts/content', 'page' ); ?>

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
