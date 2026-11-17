<?php
/**
 * Template Name: An Mộc – Chính sách bảo mật
 *
 * @package anmoc
 */

get_header();
get_template_part( 'template-parts/page-intro', null, array( 'prefix' => 'privacy' ) );
while ( have_posts() ) :
	the_post();
	?>
	<section class="section"><div class="container prose"><?php the_content(); ?></div></section>
	<?php
endwhile;
get_footer();
