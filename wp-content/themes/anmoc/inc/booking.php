<?php
/**
 * Booking form: saves a "Lịch hẹn" entry and emails the clinic.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_post_nopriv_anmoc_booking', 'anmoc_handle_booking' );
add_action( 'admin_post_anmoc_booking', 'anmoc_handle_booking' );

function anmoc_handle_booking() {
	$back = anmoc_page_url( 'contact' );

	// phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash -- unslashed via wp_unslash in $in().
	$in = function ( $key ) {
		return isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : ''; // phpcs:ignore WordPress.Security
	};
	// phpcs:enable

	if ( ! wp_verify_nonce( sanitize_key( $in( '_anmoc_nonce' ) ), 'anmoc_booking' ) ) {
		wp_safe_redirect( add_query_arg( 'booking', 'error', $back ) . '#booking' );
		exit;
	}

	// Honeypot: real visitors never fill this.
	if ( '' !== $in( 'website' ) ) {
		wp_safe_redirect( add_query_arg( 'booking', 'success', $back ) . '#booking' );
		exit;
	}

	$name    = sanitize_text_field( $in( 'fullName' ) );
	$phone   = sanitize_text_field( $in( 'phone' ) );
	$service = absint( $in( 'service' ) );
	$doctor  = absint( $in( 'doctor' ) );
	$date    = sanitize_text_field( $in( 'preferredDate' ) );
	$note    = sanitize_textarea_field( $in( 'note' ) );

	$digits     = preg_replace( '/\D/', '', $phone );
	$valid_date = preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) && $date >= wp_date( 'Y-m-d' );
	if ( '' === $name || strlen( $digits ) < 9 || strlen( $digits ) > 12 || ! $valid_date ) {
		wp_safe_redirect( add_query_arg( 'booking', 'error', $back ) . '#booking' );
		exit;
	}

	// Simple flood guard: 5 requests per IP per 10 minutes.
	$ip_key = 'anmoc_bk_' . md5( isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '' );
	$count  = (int) get_transient( $ip_key );
	if ( $count >= 5 ) {
		wp_safe_redirect( add_query_arg( 'booking', 'error', $back ) . '#booking' );
		exit;
	}
	set_transient( $ip_key, $count + 1, 10 * MINUTE_IN_SECONDS );

	$service_name = $service && 'anmoc_service' === get_post_type( $service ) ? get_post_field( 'post_title', $service ) : '';
	$doctor_name  = $doctor && 'anmoc_doctor' === get_post_type( $doctor ) ? get_post_field( 'post_title', $doctor ) : '';
	$date_label   = wp_date( 'd/m/Y', strtotime( $date ) );

	$booking_id = wp_insert_post(
		array(
			'post_type'   => 'anmoc_booking',
			'post_status' => 'publish',
			'post_title'  => $name,
			'meta_input'  => array(
				'_anmoc_phone'   => $phone,
				'_anmoc_service' => $service_name,
				'_anmoc_doctor'  => $doctor_name,
				'_anmoc_date'    => $date_label,
				'_anmoc_note'    => $note,
				'_anmoc_status'  => 'new',
			),
		)
	);

	$to = anmoc_get( 'booking_email' );
	$to = is_email( $to ) ? $to : get_option( 'admin_email' );

	$lines = array(
		'Họ tên: ' . $name,
		'Điện thoại: ' . $phone,
		'Dịch vụ: ' . ( $service_name ? $service_name : '—' ),
		'Bác sĩ: ' . ( $doctor_name ? $doctor_name : '—' ),
		'Ngày mong muốn: ' . $date_label,
		'Ghi chú: ' . ( $note ? $note : '—' ),
		'',
		'Xem trong quản trị: ' . admin_url( 'post.php?post=' . (int) $booking_id . '&action=edit' ),
	);
	wp_mail( $to, sprintf( '[%s] Lịch hẹn mới: %s – %s', anmoc_get( 'brand_name' ), $name, $date_label ), implode( "\n", $lines ) );

	wp_safe_redirect( add_query_arg( 'booking', 'success', $back ) . '#booking' );
	exit;
}

/**
 * Badge with the number of new bookings in the admin menu.
 */
add_action(
	'admin_menu',
	function () {
		global $menu;
		$new = new WP_Query(
			array(
				'post_type'      => 'anmoc_booking',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_key'       => '_anmoc_status', // phpcs:ignore WordPress.DB.SlowDBQuery
				'meta_value'     => 'new', // phpcs:ignore WordPress.DB.SlowDBQuery
			)
		);
		if ( ! $new->found_posts ) {
			return;
		}
		foreach ( $menu as $i => $item ) {
			if ( 'edit.php?post_type=anmoc_booking' === $item[2] ) {
				$menu[ $i ][0] .= ' <span class="awaiting-mod">' . (int) $new->found_posts . '</span>'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
			}
		}
	}
);
