<?php
/**
 * Section: Hoạt động – chương trình nổi bật
 *
 * @package anmoc
 */

$url = anmoc_get( 'cf_url' );
if ( ! $url ) {
	$url = anmoc_page_url( 'journal' ); // until a story URL is set in Customizer
}
?>
<section class="container community-feature">
	<div class="community-image">
		<?php anmoc_image( 'cf_image', 'large', 'cf_image_alt' ); ?>
		<?php if ( anmoc_get( 'cf_date' ) ) : ?><span><?php anmoc_e( 'cf_date' ); ?></span><?php endif; ?>
	</div>
	<div>
		<?php anmoc_eyebrow( 'cf_eyebrow' ); ?>
		<h2><?php anmoc_e( 'cf_title' ); ?></h2>
		<p><?php anmoc_e( 'cf_desc' ); ?></p>
		<?php if ( anmoc_get( 'cf_link' ) ) : ?>
			<a class="link-arrow" href="<?php echo esc_url( $url ); ?>"><?php anmoc_e( 'cf_link' ); ?> <?php echo anmoc_icon( 'arrow' ); // phpcs:ignore ?></a>
		<?php endif; ?>
	</div>
</section>
