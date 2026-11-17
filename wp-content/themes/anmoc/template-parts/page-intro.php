<?php
/**
 * Dark page header used by inner pages.
 *
 * @package anmoc
 *
 * @var array $args { prefix: field prefix, e.g. "about" }
 */

$prefix = $args['prefix'];
?>
<section class="page-intro" data-watermark="<?php echo esc_attr( anmoc_get( 'intro_watermark' ) ); ?>">
	<div class="container">
		<?php anmoc_eyebrow( $prefix . '_intro_eyebrow', true ); ?>
		<div class="intro-grid">
			<?php if ( 'journal' === $prefix && is_category() ) : ?>
				<h1><?php single_cat_title(); ?></h1>
				<p><?php echo category_description() ? esc_html( wp_strip_all_tags( category_description() ) ) : anmoc_field_html( 'journal_intro_desc' ); // phpcs:ignore ?></p>
			<?php else : ?>
				<h1><?php anmoc_e( $prefix . '_intro_title' ); ?></h1>
				<p><?php anmoc_e( $prefix . '_intro_desc' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
