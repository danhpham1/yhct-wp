<?php
/**
 * Admin shortcuts so editors always find where content lives.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

/**
 * Customizer deep link for a page key.
 */
function anmoc_customize_link( $key ) {
	$focus = array(
		'home'      => array( 'panel', 'anmoc_home' ),
		'about'     => array( 'section', 'anmoc_about' ),
		'services'  => array( 'section', 'anmoc_services' ),
		'doctors'   => array( 'section', 'anmoc_doctors' ),
		'journal'   => array( 'section', 'anmoc_journal' ),
		'community' => array( 'section', 'anmoc_community' ),
		'contact'   => array( 'section', 'anmoc_contact' ),
	);
	$args = array( 'url' => rawurlencode( anmoc_page_url( $key ) ) );
	if ( isset( $focus[ $key ] ) ) {
		$args[ 'autofocus[' . $focus[ $key ][0] . ']' ] = $focus[ $key ][1];
	}
	return add_query_arg( $args, admin_url( 'customize.php' ) );
}

/**
 * Which theme page key a page ID belongs to.
 */
function anmoc_page_key( $post_id ) {
	foreach ( array_merge( array( 'home', 'journal' ), array_keys( anmoc_page_templates() ) ) as $key ) {
		if ( $post_id && anmoc_page_id( $key ) === (int) $post_id ) {
			return $key;
		}
	}
	return '';
}

add_action(
	'admin_menu',
	function () {
		add_menu_page( 'Nội dung website', 'Nội dung website', 'edit_theme_options', 'customize.php', '', 'dashicons-admin-customizer', 3 );
	}
);

/* Notice inside the page editor of theme pages. */
add_action(
	'add_meta_boxes_page',
	function ( $post ) {
		$key = anmoc_page_key( $post->ID );
		if ( ! $key ) {
			return;
		}
		add_meta_box(
			'anmoc_where',
			'Nội dung trang này',
			function () use ( $key ) {
				echo '<p>Chữ, hình ảnh và màu sắc của trang này được chỉnh trực quan trong Tùy biến (xem trước trực tiếp).</p>';
				printf( '<p><a class="button button-primary" href="%s">Mở trình chỉnh nội dung</a></p>', esc_url( anmoc_customize_link( $key ) ) );
			},
			'page',
			'side',
			'high'
		);
	}
);

/* "Sửa nội dung trang" in the admin bar on the front end. */
add_action(
	'admin_bar_menu',
	function ( WP_Admin_Bar $bar ) {
		if ( is_admin() || ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}
		$key = '';
		if ( is_front_page() ) {
			$key = 'home';
		} elseif ( is_home() || is_category() ) {
			$key = 'journal';
		} elseif ( is_page() ) {
			$key = anmoc_page_key( get_queried_object_id() );
		}
		if ( ! $key ) {
			return;
		}
		$bar->add_node(
			array(
				'id'    => 'anmoc-edit-content',
				'title' => '<span class="ab-icon dashicons dashicons-admin-customizer" style="top:2px"></span>Sửa nội dung trang',
				'href'  => anmoc_customize_link( $key ),
			)
		);
	},
	81
);
