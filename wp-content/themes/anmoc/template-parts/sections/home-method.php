<?php
/**
 * Section: Trang chủ – quy trình thăm khám
 *
 * @package anmoc
 */

?>
<section class="section method">
	<div class="container method-grid">
		<div class="method-image">
			<?php anmoc_image( 'method_image', 'large', 'method_image_alt' ); ?>
			<span class="image-note"><?php anmoc_e( 'method_note' ); ?></span>
		</div>
		<div class="method-copy">
			<?php anmoc_eyebrow( 'method_eyebrow' ); ?>
			<h2><?php anmoc_e( 'method_title' ); ?></h2>
			<p><?php anmoc_e( 'method_desc' ); ?></p>
			<ol class="steps"<?php anmoc_field_attr( 'steps' ); ?>><?php anmoc_render_repeater( 'steps' ); ?></ol>
		</div>
	</div>
</section>
