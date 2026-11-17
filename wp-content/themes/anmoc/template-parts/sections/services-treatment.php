<?php
/**
 * Section: Trị liệu – nguyên tắc điều trị
 *
 * @package anmoc
 */

?>
<section class="section treatment-note">
	<div class="container treatment-grid">
		<?php anmoc_image( 'treat_image', 'large', 'treat_image_alt' ); ?>
		<div>
			<?php anmoc_eyebrow( 'treat_eyebrow', true ); ?>
			<h2><?php anmoc_e( 'treat_title' ); ?></h2>
			<p><?php anmoc_e( 'treat_desc' ); ?></p>
			<a class="button button-light" href="<?php echo esc_url( anmoc_page_url( 'contact' ) ); ?>"><?php anmoc_e( 'treat_button' ); ?></a>
		</div>
	</div>
</section>
