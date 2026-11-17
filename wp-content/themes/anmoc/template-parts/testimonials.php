<?php
/**
 * Testimonial grid ("Lời kể từ khách hàng").
 *
 * @package anmoc
 *
 * @var array $args { placement, class, eyebrow, title, desc (field ids) }
 */

$items = anmoc_testimonials( $args['placement'] );
if ( ! $items ) {
	return;
}
?>
<section class="section <?php echo esc_attr( $args['class'] ); ?>">
	<div class="container">
		<div class="section-head">
			<div>
				<?php anmoc_eyebrow( $args['eyebrow'] ); ?>
				<h2><?php anmoc_e( $args['title'] ); ?></h2>
			</div>
			<?php if ( ! empty( $args['desc'] ) ) : ?>
				<p><?php anmoc_e( $args['desc'] ); ?></p>
			<?php endif; ?>
		</div>
		<div class="testimonial-grid">
			<?php foreach ( $items as $item ) : ?>
				<?php $service = anmoc_post_text( $item, 'service' ); ?>
				<blockquote>
					<span aria-hidden="true">“</span>
					<p><?php anmoc_post_text_e( $item, 'content' ); ?></p>
					<footer><?php anmoc_post_text_e( $item, 'title' ); ?><?php if ( $service ) : ?> <em>· <?php anmoc_post_text_e( $item, 'service' ); ?></em><?php endif; ?></footer>
				</blockquote>
			<?php endforeach; ?>
		</div>
	</div>
</section>
