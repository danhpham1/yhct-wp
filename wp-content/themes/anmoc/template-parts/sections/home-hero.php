<?php
/**
 * Section: Trang chủ – banner đầu trang
 *
 * @package anmoc
 */

$contact = anmoc_page_url( 'contact' );
$arrow   = anmoc_icon( 'arrow' );
?>
<section class="hero">
	<div class="container hero-grid">
		<div class="hero-copy">
			<?php anmoc_eyebrow( 'hero_eyebrow' ); ?>
			<h1><?php anmoc_e( 'hero_title' ); ?><br /><em><?php anmoc_e( 'hero_title_em' ); ?></em></h1>
			<p><?php anmoc_e( 'hero_desc' ); ?></p>
			<div class="button-row">
				<a class="button button-solid" href="<?php echo esc_url( $contact ); ?>"><?php anmoc_e( 'hero_btn' ); ?> <?php echo $arrow; // phpcs:ignore ?></a>
				<a class="button button-outline" href="<?php echo esc_url( anmoc_page_url( 'about' ) ); ?>"><?php anmoc_e( 'hero_link' ); ?></a>
			</div>
			<div class="hero-trust"<?php anmoc_field_attr( 'hero_stats' ); ?>><?php anmoc_render_repeater( 'hero_stats' ); ?></div>
			<?php if ( anmoc_get( 'hero_trust_source' ) || is_customize_preview() ) : ?>
				<p class="trust-source"><?php anmoc_e( 'hero_trust_source' ); ?></p>
			<?php endif; ?>
		</div>
		<div class="hero-visual">
			<?php anmoc_image( 'hero_image', '1536x1536', 'hero_image_alt' ); ?>
			<div class="hero-stamp">
				<svg viewBox="0 0 100 100" aria-hidden="true"><path d="M50 16c2 22-7 43-27 62M50 33c13-5 23-1 29 10-13 4-23 1-29-10ZM42 49c-12-5-22-1-27 10 12 4 21 1 27-10ZM36 65c10-1 18 3 21 12-10 1-17-3-21-12Z" /></svg>
				<span><?php anmoc_e( 'hero_stamp' ); ?></span>
			</div>
			<div class="hours-card">
				<span><?php echo anmoc_icon( 'clock' ); // phpcs:ignore ?> <?php anmoc_e( 'hero_hours_label' ); ?></span>
				<p><?php anmoc_e( 'hero_hours_text' ); ?> <strong><?php echo esc_html( anmoc_close_today() ); ?></strong></p>
				<a class="hours-link" href="<?php echo esc_url( $contact ); ?>"><?php anmoc_e( 'hero_hours_link' ); ?> <?php echo $arrow; // phpcs:ignore ?></a>
			</div>
		</div>
	</div>
</section>
