<?php
/**
 * Section: Về An Mộc – ảnh & trích dẫn
 *
 * @package anmoc
 */

?>
<section class="about-hero container">
	<div><?php anmoc_image( 'about_image', 'large', 'about_image_alt' ); ?></div>
	<div>
		<span class="quote-mark" aria-hidden="true">“</span>
		<blockquote><?php anmoc_e( 'about_quote' ); ?></blockquote>
		<p><?php anmoc_e( 'about_quote_author' ); ?></p>
	</div>
</section>
