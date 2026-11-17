<?php
/**
 * Site header.
 *
 * @package anmoc
 */

$phone = anmoc_get( 'phone' );
?>
<!doctype html>
<html <?php language_attributes(); ?><?php anmoc_html_font_attr(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="color-scheme" content="light" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Bỏ qua điều hướng</a>
<header class="header">
	<div class="clinic-bar">
		<div class="container">
			<span><?php anmoc_e( 'topbar_text' ); ?></span>
			<span><?php anmoc_e( 'city' ); ?> <i></i> <a href="<?php echo esc_url( anmoc_tel( $phone ) ); ?>"><?php anmoc_e( 'phone' ); ?></a></span>
			<?php get_template_part( 'template-parts/font-switch' ); ?>
		</div>
	</div>
	<div class="container nav-wrap">
		<a class="brand-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( anmoc_get( 'brand_name' ) . ' – về trang chủ' ); ?>"><?php anmoc_brand(); ?></a>
		<nav id="main-nav" class="nav" aria-label="Điều hướng chính">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'depth'          => 1,
					'fallback_cb'    => 'anmoc_menu_fallback',
				)
			);
			?>
			<a class="button button-solid" href="<?php echo esc_url( anmoc_page_url( 'contact' ) ); ?>"><?php anmoc_e( 'header_cta' ); ?></a>
		</nav>
		<button type="button" class="menu-button" aria-controls="main-nav" aria-expanded="false" aria-label="Mở menu" data-open="Mở menu" data-close="Đóng menu">
			<span></span><span></span>
		</button>
	</div>
</header>
<main id="main" tabindex="-1">
