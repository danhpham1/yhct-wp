<?php
/**
 * Single article.
 *
 * @package anmoc
 */

get_header();
while ( have_posts() ) :
	the_post();
	$tag = anmoc_post_tag();
	?>
	<article <?php post_class( 'single-article' ); ?>>
		<header class="page-intro article-intro" data-watermark="<?php echo esc_attr( anmoc_get( 'intro_watermark' ) ); ?>">
			<div class="container">
				<?php anmoc_eyebrow( $tag ? $tag : anmoc_get( 'journal_intro_eyebrow' ), true ); ?>
				<h1><?php the_title(); ?></h1>
				<p class="article-byline"><?php echo esc_html( anmoc_byline() . ' · ' . get_the_date( 'd.m.Y' ) . ' · ' . anmoc_reading_time() . ' ' . anmoc_get( 'journal_read_time' ) ); ?></p>
			</div>
		</header>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="container article-cover"><?php the_post_thumbnail( 'full', anmoc_thumb_attrs() ); ?></div>
		<?php endif; ?>
		<div class="container entry-content article-body">
			<?php the_content(); ?>
		</div>
	</article>
	<?php
	$related = new WP_Query(
		array(
			'posts_per_page'      => 3,
			'post__not_in'        => array( get_the_ID() ),
			'category__in'        => wp_get_post_categories( get_the_ID() ),
			'ignore_sticky_posts' => true,
		)
	);
	if ( $related->have_posts() ) :
		?>
		<section class="section journal-preview">
			<div class="container">
				<div class="section-head">
					<div><?php anmoc_eyebrow( 'hj_eyebrow' ); ?><h2><?php anmoc_e( 'hj_title' ); ?></h2></div>
					<div><a class="button button-outline" href="<?php echo esc_url( anmoc_page_url( 'journal' ) ); ?>"><?php anmoc_e( 'hj_button' ); ?></a></div>
				</div>
				<div class="article-grid">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						get_template_part( 'template-parts/article-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
		<?php
	endif;
endwhile;
get_template_part( 'template-parts/booking-banner' );
get_footer();
