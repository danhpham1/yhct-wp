<?php
/**
 * Site footer.
 *
 * @package anmoc
 */

$phone   = anmoc_get( 'phone' );
$email   = anmoc_get( 'email' );
$privacy = anmoc_privacy_url();
?>
</main>
<footer class="footer">
	<div class="container">
		<div class="footer-top">
			<div class="footer-brand">
				<?php anmoc_brand( true ); ?>
				<p><?php anmoc_e( 'footer_desc' ); ?></p>
			</div>
			<nav class="footer-col" aria-label="Liên kết chân trang">
				<h2><?php anmoc_e( 'footer_menu_title' ); ?></h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'items_wrap'     => '%3$s',
						'depth'          => 1,
						'fallback_cb'    => 'anmoc_menu_fallback',
					)
				);
				?>
			</nav>
			<div class="footer-col">
				<h2><?php anmoc_e( 'footer_contact_title' ); ?></h2>
				<a href="<?php echo esc_url( anmoc_tel( $phone ) ); ?>"><?php anmoc_e( 'phone' ); ?></a>
				<?php if ( $email ) : ?>
					<a href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php anmoc_e( 'email' ); ?></a>
				<?php endif; ?>
				<p><?php anmoc_e( 'address' ); ?></p>
			</div>
			<div class="footer-cta">
				<p><?php anmoc_e( 'footer_cta_text' ); ?></p>
				<a class="button button-light" href="<?php echo esc_url( anmoc_page_url( 'contact' ) ); ?>"><?php anmoc_e( 'footer_cta_label' ); ?> <?php echo anmoc_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
		</div>
		<div class="footer-bottom">
			<span><?php anmoc_e( 'copyright' ); ?></span>
			<span><?php anmoc_e( 'license' ); ?></span>
			<?php if ( $privacy ) : ?>
				<a href="<?php echo esc_url( $privacy ); ?>"><?php anmoc_e( 'privacy_label' ); ?></a>
			<?php else : ?>
				<span><?php anmoc_e( 'privacy_label' ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
