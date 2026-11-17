<?php
/**
 * "Bắt đầu từ một cuộc hẹn" call to action.
 *
 * @package anmoc
 */

?>
<section class="booking-banner">
	<div class="container">
		<div>
			<?php anmoc_eyebrow( 'banner_eyebrow', true ); ?>
			<h2><?php anmoc_e( 'banner_title' ); ?></h2>
		</div>
		<div>
			<p><?php anmoc_e( 'banner_desc' ); ?></p>
			<a class="button button-light" href="<?php echo esc_url( anmoc_page_url( 'contact' ) ); ?>"><?php anmoc_e( 'banner_button' ); ?> <?php echo anmoc_icon( 'calendar' ); // phpcs:ignore ?></a>
		</div>
	</div>
</section>
