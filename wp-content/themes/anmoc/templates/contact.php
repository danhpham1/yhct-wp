<?php
/**
 * Template Name: An Mộc – Đặt lịch
 *
 * @package anmoc
 */

get_header();

// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only UI state.
$status     = isset( $_GET['booking'] ) ? sanitize_key( $_GET['booking'] ) : '';
$pre_svc    = isset( $_GET['service'] ) ? absint( $_GET['service'] ) : 0;
$pre_doctor = isset( $_GET['doctor'] ) ? absint( $_GET['doctor'] ) : 0;
// phpcs:enable
if ( $pre_doctor && 'anmoc_doctor' !== get_post_type( $pre_doctor ) ) {
	$pre_doctor = 0;
}
$phone     = anmoc_get( 'phone' );
$tel       = anmoc_tel( $phone );
$req       = '<abbr title="bắt buộc">*</abbr>';
?>
<section class="contact-page">
	<div class="container contact-grid">
		<div class="contact-copy">
			<?php anmoc_eyebrow( 'contact_eyebrow' ); ?>
			<h1><?php anmoc_e( 'contact_title' ); ?><br /><em><?php anmoc_e( 'contact_title_em' ); ?></em></h1>
			<p><?php anmoc_e( 'contact_desc' ); ?></p>
			<div class="contact-detail"><?php echo anmoc_icon( 'phone' ); // phpcs:ignore ?><div><small><?php anmoc_e( 'label_hotline' ); ?></small><a href="<?php echo esc_url( $tel ); ?>"><strong><?php anmoc_e( 'phone' ); ?></strong></a></div></div>
			<div class="contact-detail"><?php echo anmoc_icon( 'pin' ); // phpcs:ignore ?><div><small><?php anmoc_e( 'label_address' ); ?></small><strong><?php anmoc_e( 'address' ); ?></strong></div></div>
			<div class="contact-detail"><?php echo anmoc_icon( 'clock' ); // phpcs:ignore ?><div><small><?php anmoc_e( 'label_hours' ); ?></small><strong><?php anmoc_e( 'hours_weekday' ); ?><br /><?php anmoc_e( 'hours_weekend' ); ?></strong></div></div>
			<a class="button button-outline call-now" href="<?php echo esc_url( $tel ); ?>"><?php echo anmoc_icon( 'phone' ); // phpcs:ignore ?> <?php anmoc_e( 'contact_call' ); ?></a>
		</div>

		<div class="booking-panel" id="booking" aria-live="polite">
			<?php if ( 'success' === $status ) : ?>
				<div class="success-message">
					<span><?php echo anmoc_icon( 'check' ); // phpcs:ignore ?></span>
					<h2><?php anmoc_e( 'success_title' ); ?></h2>
					<p><?php anmoc_e( 'success_desc' ); ?></p>
					<a class="button button-solid" href="<?php echo esc_url( anmoc_page_url( 'contact' ) ); ?>#booking"><?php anmoc_e( 'success_button' ); ?></a>
				</div>
			<?php else : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<h2><?php anmoc_e( 'form_title' ); ?></h2>
					<p class="required-note"><?php echo $req; // phpcs:ignore ?> <?php anmoc_e( 'form_required' ); ?></p>
					<?php if ( 'error' === $status ) : ?>
						<p class="form-error" role="alert"><?php anmoc_e( 'form_error' ); ?></p>
					<?php endif; ?>
					<input type="hidden" name="action" value="anmoc_booking" />
					<?php wp_nonce_field( 'anmoc_booking', '_anmoc_nonce', false ); ?>
					<div class="hp-field" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off" /></label></div>
					<?php if ( $pre_doctor ) : ?>
						<input type="hidden" name="doctor" value="<?php echo (int) $pre_doctor; ?>" />
						<p class="chosen-doctor"><?php anmoc_e( 'form_doctor' ); ?>: <strong><?php echo esc_html( get_the_title( $pre_doctor ) ); ?></strong></p>
					<?php endif; ?>
					<div class="form-grid">
						<label><span><?php anmoc_e( 'form_name' ); ?> <?php echo $req; // phpcs:ignore ?></span><input name="fullName" autocomplete="name" required maxlength="120" placeholder="<?php echo esc_attr( anmoc_get( 'form_name_ph' ) ); ?>" /></label>
						<label><span><?php anmoc_e( 'form_phone' ); ?> <?php echo $req; // phpcs:ignore ?></span><input name="phone" required type="tel" inputmode="tel" autocomplete="tel" pattern="[0-9 +().\-]{9,20}" placeholder="<?php echo esc_attr( anmoc_get( 'form_phone_ph' ) ); ?>" /></label>
						<label><?php anmoc_e( 'form_service' ); ?><select name="service">
							<option value=""><?php echo esc_html( anmoc_get( 'form_service_ph' ) ); ?></option>
							<?php foreach ( anmoc_services() as $service ) : ?>
								<option value="<?php echo (int) $service->ID; ?>" <?php selected( $pre_svc, $service->ID ); ?>><?php echo esc_html( get_the_title( $service ) ); ?></option>
							<?php endforeach; ?>
						</select></label>
						<label><span><?php anmoc_e( 'form_date' ); ?> <?php echo $req; // phpcs:ignore ?></span><input name="preferredDate" required type="date" min="<?php echo esc_attr( wp_date( 'Y-m-d' ) ); ?>" /></label>
					</div>
					<label><?php anmoc_e( 'form_note' ); ?><textarea name="note" rows="5" maxlength="2000" placeholder="<?php echo esc_attr( anmoc_get( 'form_note_ph' ) ); ?>"></textarea></label>
					<p class="privacy"><?php echo anmoc_icon( 'check' ); // phpcs:ignore ?><span><?php anmoc_e( 'form_privacy' ); ?></span></p>
					<button type="submit" class="button button-solid"><?php anmoc_e( 'form_submit' ); ?> <?php echo anmoc_icon( 'arrow' ); // phpcs:ignore ?></button>
				</form>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php
get_footer();
