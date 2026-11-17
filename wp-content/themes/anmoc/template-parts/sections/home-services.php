<?php
/**
 * Section: Trang chủ – bản đồ trị liệu (dịch vụ đánh dấu "Hiện ở trang chủ")
 *
 * @package anmoc
 */

$services = anmoc_services( true );
if ( ! $services ) {
	return;
}
?>
<section class="section services-preview">
	<div class="container">
		<div class="section-head">
			<div><?php anmoc_eyebrow( 'hs_eyebrow' ); ?><h2><?php anmoc_e( 'hs_title' ); ?></h2></div>
			<p><?php anmoc_e( 'hs_desc' ); ?></p>
		</div>
		<div class="service-list">
			<?php foreach ( $services as $i => $service ) : ?>
				<?php $desc = anmoc_meta( $service, 'desc' ); ?>
				<a class="service-row service-tone-<?php echo (int) ( $i % 6 ) + 1; ?>" href="<?php echo esc_url( anmoc_page_url( 'services' ) . '#' . $service->post_name ); ?>" aria-label="<?php echo esc_attr( get_the_title( $service ) . ': ' . $desc ); ?>">
					<div class="service-row-top"><span class="service-no"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><small><?php anmoc_post_text_e( $service, 'tagline' ); ?></small><span class="service-arrow"><?php echo anmoc_icon( 'arrow' ); // phpcs:ignore ?></span></div>
					<div class="service-row-body"><h3><?php anmoc_post_text_e( $service, 'title' ); ?></h3><p><?php anmoc_post_text_e( $service, 'desc' ); ?></p></div>
				</a>
			<?php endforeach; ?>
		</div>
		<div class="service-action">
			<p><?php anmoc_e( 'hs_action' ); ?></p>
			<a class="button button-outline" href="<?php echo esc_url( anmoc_page_url( 'contact' ) ); ?>"><?php anmoc_e( 'hs_button' ); ?></a>
		</div>
	</div>
</section>
