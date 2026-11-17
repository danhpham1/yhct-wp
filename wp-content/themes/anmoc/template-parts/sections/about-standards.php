<?php
/**
 * Section: Về An Mộc – cam kết chuyên môn
 *
 * @package anmoc
 */

?>
<section class="section standards">
	<div class="container section-head">
		<div><?php anmoc_eyebrow( 'standards_eyebrow' ); ?><h2><?php anmoc_e( 'standards_title' ); ?></h2></div>
		<ul class="standard-list"<?php anmoc_field_attr( 'standards' ); ?>><?php anmoc_render_repeater( 'standards' ); ?></ul>
	</div>
</section>
