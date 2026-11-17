<?php
/**
 * Section: Trị liệu – danh sách dịch vụ
 *
 * @package anmoc
 */

$arrow = anmoc_icon( 'arrow' );
?>
<section class="container service-page-grid">
	<?php foreach ( anmoc_services() as $i => $service ) : ?>
		<article class="service-card" id="<?php echo esc_attr( $service->post_name ); ?>">
			<span><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
			<h2><?php anmoc_post_text_e( $service, 'title' ); ?></h2>
			<p><?php anmoc_post_text_e( $service, 'desc' ); ?></p>
			<small><?php anmoc_post_text_e( $service, 'meta' ); ?></small>
			<?php $short = anmoc_post_text( $service, 'short' ); ?>
			<a class="link-arrow" href="<?php echo esc_url( anmoc_page_url( 'contact', array( 'service' => $service->ID ) ) ); ?>"><?php anmoc_e( 'services_cta_prefix' ); ?> <?php if ( '' !== $short ) : ?><?php anmoc_post_text_e( $service, 'short' ); ?><?php else : ?><?php echo esc_html( mb_strtolower( anmoc_post_text( $service, 'title' ), 'UTF-8' ) ); ?><?php endif; ?> <?php echo $arrow; // phpcs:ignore ?></a>
		</article>
	<?php endforeach; ?>
</section>
