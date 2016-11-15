<?php
/**
 * The Template for displaying all single posts.
 *
 * @package beam
 */

get_header(); ?> 

	<div id="content" class="site-content">
		<div class="site-content-inner">

			<div id="primary" class="content-area">
				<main id="main" class="site-main">

				<?php 
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'single' );

					
					beam_content_nav( 'nav-below' );

				endwhile; // end of the loop. 
				?>

				</main><!-- #main -->
			</div><!-- #primary -->

<?php 
get_sidebar(); 
get_footer();
