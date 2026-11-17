<?php
/**
 * Not found.
 *
 * @package anmoc
 */

get_header();
?>
<section class="page-intro" data-watermark="404">
	<div class="container">
		<div class="intro-grid">
			<h1>Không tìm thấy trang.</h1>
			<p>Trang bạn tìm có thể đã được đổi địa chỉ. Hãy quay lại trang chủ hoặc đặt lịch để được tư vấn trực tiếp.</p>
		</div>
	</div>
</section>
<section class="section">
	<div class="container button-row">
		<a class="button button-solid" href="<?php echo esc_url( home_url( '/' ) ); ?>">Về trang chủ</a>
		<a class="button button-outline" href="<?php echo esc_url( anmoc_page_url( 'contact' ) ); ?>"><?php anmoc_e( 'header_cta' ); ?></a>
	</div>
</section>
<?php
get_footer();
