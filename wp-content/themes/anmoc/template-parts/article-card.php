<?php
/**
 * Journal card for the current post in the loop.
 *
 * @package anmoc
 */

$tag = anmoc_post_tag();
?>
<article class="article-card">
	<a class="article-image" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php anmoc_post_image( null, 'anmoc-card' ); ?>
		<?php if ( $tag ) : ?><span><?php echo esc_html( $tag ); ?></span><?php endif; ?>
	</a>
	<div class="article-meta"><?php echo esc_html( get_the_date( 'd.m.Y' ) . ' · ' . anmoc_reading_time() . ' ' . anmoc_get( 'journal_read_time' ) ); ?></div>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p><?php echo esc_html( get_the_excerpt() ); ?></p>
	<a class="link-arrow" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( anmoc_get( 'journal_read_more' ) . ': ' . get_the_title() ); ?>"><?php anmoc_e( 'journal_read_more' ); ?> <?php echo anmoc_icon( 'arrow' ); // phpcs:ignore ?></a>
</article>
