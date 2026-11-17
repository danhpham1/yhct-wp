<?php
/**
 * Fallback template.
 *
 * @package anmoc
 */

get_header();
?>
<header class="page-intro" data-watermark="<?php echo esc_attr( anmoc_get( 'intro_watermark' ) ); ?>">
	<div class="container"><h1><?php echo is_search() ? esc_html( 'Kết quả tìm kiếm: ' . get_search_query() ) : esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?></h1></div>
</header>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="article-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/article-card' );
				endwhile;
				?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p class="empty-note"><?php anmoc_e( 'journal_empty' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
