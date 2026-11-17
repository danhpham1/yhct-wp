<?php
/**
 * Section: Về An Mộc – những con số
 *
 * @package anmoc
 */

?>
<section class="section numbers">
	<div class="container">
		<?php anmoc_eyebrow( 'numbers_eyebrow' ); ?>
		<div class="number-grid"<?php anmoc_field_attr( 'numbers' ); ?>><?php anmoc_render_repeater( 'numbers' ); ?></div>
		<?php if ( anmoc_get( 'numbers_source' ) || is_customize_preview() ) : ?>
			<p class="trust-source"><?php anmoc_e( 'numbers_source' ); ?></p>
		<?php endif; ?>
	</div>
</section>
