<?php
/**
 * Section: Kiến thức – bộ lọc & danh sách bài viết
 *
 * @package anmoc
 */

$is_cat = is_category();
?>
<section class="section">
	<div class="container">
		<?php
		$cats = get_categories( array( 'hide_empty' => true, 'orderby' => 'term_id' ) );
		if ( count( $cats ) > 1 ) :
			?>
			<nav class="filter-row" aria-label="Lọc bài viết">
				<a class="<?php echo $is_cat ? '' : 'selected'; ?>" href="<?php echo esc_url( anmoc_page_url( 'journal' ) ); ?>"<?php echo $is_cat ? '' : ' aria-current="page"'; ?>><?php anmoc_e( 'journal_all_label' ); ?></a>
				<?php foreach ( $cats as $cat ) : ?>
					<?php $on = $is_cat && get_queried_object_id() === $cat->term_id; ?>
					<a class="<?php echo $on ? 'selected' : ''; ?>" href="<?php echo esc_url( get_category_link( $cat ) ); ?>"<?php echo $on ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $cat->name ); ?></a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="article-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/article-card' );
				endwhile;
				?>
			</div>
			<?php
			the_posts_pagination(
				array(
					'prev_text' => '←',
					'next_text' => '→',
				)
			);
			?>
		<?php else : ?>
			<p class="empty-note"><?php anmoc_e( 'journal_empty' ); ?></p>
		<?php endif; ?>
	</div>
</section>
