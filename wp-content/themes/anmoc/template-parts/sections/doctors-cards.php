<?php
/**
 * Section: Đội ngũ – danh sách bác sĩ
 *
 * @package anmoc
 */

$doctors = get_posts(
	array(
		'post_type'      => 'anmoc_doctor',
		'posts_per_page' => -1,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	)
);
?>
<section class="container doctor-grid">
	<?php foreach ( $doctors as $i => $doctor ) : ?>
		<article class="doctor-card">
			<div class="doctor-photo">
				<?php anmoc_post_image( $doctor, 'anmoc-portrait', 'doctor-an.jpg' ); ?>
				<span aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
			</div>
			<div class="doctor-info">
				<small><?php anmoc_post_text_e( $doctor, 'role' ); ?></small>
				<h2><?php anmoc_post_text_e( $doctor, 'title' ); ?></h2>
				<p><?php anmoc_post_text_e( $doctor, 'focus' ); ?></p>
				<strong><?php anmoc_post_text_e( $doctor, 'exp' ); ?></strong>
				<a class="link-arrow" href="<?php echo esc_url( anmoc_page_url( 'contact', array( 'doctor' => $doctor->ID ) ) ); ?>" aria-label="<?php echo esc_attr( 'Đặt lịch với ' . get_the_title( $doctor ) ); ?>"><?php anmoc_e( 'doctors_cta' ); ?> <?php echo anmoc_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
		</article>
	<?php endforeach; ?>
</section>
