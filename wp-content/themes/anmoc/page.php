<?php
/**
 * Default page (e.g. Chính sách bảo mật).
 *
 * @package anmoc
 */

get_header();
while ( have_posts() ) :
	the_post();
	?>
	<header class="page-intro" data-watermark="<?php echo esc_attr( anmoc_get( 'intro_watermark' ) ); ?>">
		<div class="container"><h1><?php the_title(); ?></h1></div>
	</header>
	<div class="container entry-content article-body"><?php the_content(); ?></div>
	<?php
endwhile;
get_footer();
