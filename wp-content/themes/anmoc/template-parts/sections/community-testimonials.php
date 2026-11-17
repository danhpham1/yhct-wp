<?php
/**
 * Section: Hoạt động – cảm nhận khách hàng
 *
 * @package anmoc
 */

get_template_part(
	'template-parts/testimonials',
	null,
	array(
		'placement' => 'community',
		'class'     => 'testimonials',
		'eyebrow'   => 'ct_eyebrow',
		'title'     => 'ct_title',
		'desc'      => 'ct_desc',
	)
);
