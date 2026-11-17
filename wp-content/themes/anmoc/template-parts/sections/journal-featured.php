<?php
/**
 * Section: Kiến thức – bài viết nổi bật
 *
 * @package anmoc
 */

$featured = ( ! is_category() && ! is_paged() ) ? anmoc_featured_post_id() : 0;
if ( $featured ) :
	?>
	<section class="container featured-article">
		<a href="<?php echo esc_url( get_permalink( $featured ) ); ?>" tabindex="-1" aria-hidden="true"><?php anmoc_post_image( $featured, 'large' ); ?></a>
		<div>
			<?php anmoc_eyebrow( 'journal_featured_label' ); ?>
			<h2><a href="<?php echo esc_url( get_permalink( $featured ) ); ?>"><?php echo esc_html( get_the_title( $featured ) ); ?></a></h2>
			<p><?php echo esc_html( get_the_excerpt( $featured ) ); ?></p>
			<span><?php echo esc_html( anmoc_byline( $featured ) . ' · ' . anmoc_reading_time( $featured ) . ' ' . anmoc_get( 'journal_read_time' ) ); ?></span>
			<a class="link-arrow" href="<?php echo esc_url( get_permalink( $featured ) ); ?>"><?php anmoc_e( 'journal_read_more' ); ?> <?php echo anmoc_icon( 'arrow' ); // phpcs:ignore ?></a>
		</div>
	</section>
<?php endif; ?>
