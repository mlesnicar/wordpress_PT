<?php
/*
	Template Name: Template Eventi
*/

get_header(); ?>

<div id="content" class="site-content">
	<div class="site-content-inner">

		<div id="primary" class="content-area">
			<main id="main" class="site-main">

			<?php 
		$args = array('post_type' => 'eventi', 'post_per_page' => 3);
		$loop = new WP_Query( $args);


		if ( $loop -> have_posts() ) : 			
			 while ($loop -> have_posts() ): $loop -> the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

			<?php endwhile; 		

		 endif; 

		?>
			</main><!-- #main -->
		</div><!-- #primary -->

<?php 
get_sidebar();
get_footer();