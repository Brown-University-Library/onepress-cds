<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OnePress
 */
?>

    <div id="colophon" class="site-footer" role="contentinfo">
<!--
            <div class="footer-connect">
                <div class="container">
                    <div class="row">
-->
						<?php require("/var/www/html_worfdev/includes/universal_footer_include_bootstrap.html") ; ?>
<!--
                    </div>
                </div>
            </div>
-->

        <!-- .site-info -->

    </div><!-- #colophon -->

</div><!-- #page -->


<?php wp_footer(); ?>

</body>
</html>
