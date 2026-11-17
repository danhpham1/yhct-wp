<?php
/**
 * Section: Trang chủ – triết lý
 *
 * @package anmoc
 */

?>
<section class="philosophy">
	<div class="container">
		<div class="philosophy-grid">
			<div>
				<?php anmoc_eyebrow( 'philo_eyebrow' ); ?>
				<p class="big-index" aria-hidden="true"><?php anmoc_e( 'philo_index' ); ?></p>
			</div>
			<div>
				<h2><?php anmoc_e( 'philo_title' ); ?></h2>
				<p><?php anmoc_e( 'philo_desc' ); ?></p>
			</div>
		</div>
		<div class="values"<?php anmoc_field_attr( 'values' ); ?>><?php anmoc_render_repeater( 'values' ); ?></div>
	</div>
</section>
