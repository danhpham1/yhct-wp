<?php
/**
 * Section: Trang chủ – cảm nhận khách hàng
 *
 * @package anmoc
 */

get_template_part(
	'template-parts/testimonials',
	null,
	array(
		'placement' => 'home',
		'class'     => 'testimonials',
		'eyebrow'   => 'ht_eyebrow',
		'title'     => 'ht_title',
		'desc'      => 'ht_desc',
	)
);
