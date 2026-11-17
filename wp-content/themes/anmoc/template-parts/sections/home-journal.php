<?php
/**
 * Section: Trang chủ – góc kiến thức
 *
 * @package anmoc
 */

$latest = new WP_Query(
	array(
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
	)
);
if ( ! $latest->have_posts() ) {
	return;
}
?>
<section class="section journal-preview">
	<div class="container">
		<div class="section-head">
			<div><?php anmoc_eyebrow( 'hj_eyebrow' ); ?><h2><?php anmoc_e( 'hj_title' ); ?></h2></div>
			<div><a class="button button-outline" href="<?php echo esc_url( anmoc_page_url( 'journal' ) ); ?>"><?php anmoc_e( 'hj_button' ); ?></a></div>
		</div>
		<div class="article-grid">
			<?php
			while ( $latest->have_posts() ) :
				$latest->the_post();
				get_template_part( 'template-parts/article-card' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
