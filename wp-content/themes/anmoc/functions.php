<?php
/**
 * An Mộc theme bootstrap.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

define( 'ANMOC_VERSION', '1.5.0' );
define( 'ANMOC_DIR', get_template_directory() );
define( 'ANMOC_URI', get_template_directory_uri() );

require ANMOC_DIR . '/inc/fields.php';
require ANMOC_DIR . '/inc/helpers.php';
require ANMOC_DIR . '/inc/setup.php';
require ANMOC_DIR . '/inc/customizer.php';
require ANMOC_DIR . '/inc/customizer-images.php';
require ANMOC_DIR . '/inc/customizer-posts.php';
require ANMOC_DIR . '/inc/post-types.php';
require ANMOC_DIR . '/inc/booking.php';
require ANMOC_DIR . '/inc/admin.php';
require ANMOC_DIR . '/inc/seed.php';
