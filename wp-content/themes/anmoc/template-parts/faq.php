<?php
/**
 * FAQ accordion (first item open, like the design).
 *
 * @package anmoc
 */

$faqs = get_posts(
	array(
		'post_type'      => 'anmoc_faq',
		'posts_per_page' => -1,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	)
);
if ( ! $faqs ) {
	return;
}
?>
<section class="section faq">
	<div class="container faq-grid">
		<div>
			<?php anmoc_eyebrow( 'faq_eyebrow' ); ?>
			<h2><?php anmoc_e( 'faq_title' ); ?></h2>
		</div>
		<div class="faq-list">
			<?php foreach ( $faqs as $i => $faq ) : ?>
				<?php $open = 0 === $i; ?>
				<div class="faq-item<?php echo $open ? ' open' : ''; ?>">
					<h3><button type="button" id="faq-q-<?php echo (int) $faq->ID; ?>" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>" aria-controls="faq-a-<?php echo (int) $faq->ID; ?>"><span><?php anmoc_post_text_e( $faq, 'title' ); ?></span><i aria-hidden="true"><?php echo $open ? '−' : '+'; ?></i></button></h3>
					<p class="faq-answer" id="faq-a-<?php echo (int) $faq->ID; ?>" role="region" aria-labelledby="faq-q-<?php echo (int) $faq->ID; ?>"<?php echo $open ? '' : ' hidden'; ?>><?php anmoc_post_text_e( $faq, 'content' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
