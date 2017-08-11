<?php

add_shortcode('product_by_taxonomy','cnmd_get_products_by_taxonomy');

/**
 * Shortcode to list all (or limited) products by taxonomy
 *
 * Based on [product_categories] in class-wc-shortcodes.php
 */

function cnmd_get_products_by_taxonomy( $atts ) {
	global $woocommerce_loop;

	/**
	 * number       How many to show
	 * orderby      What to orderby
	 * order        ASC or DESC
	 * columns      The columns of the grid to display
	 * hide_empty   Hide terms with no assigned products
	 * parent       Set the parent parameter to 0 to only display top level categories.
	 * ids          Set IDs to a comma separated list of category IDs to only show those.
	 * taxonomy     the taxonomy to show
	 */

	$atts = shortcode_atts( array(
		'number'     => null,
		'orderby'    => 'name',
		'order'      => 'ASC',
		'columns'    => '4',
		'hide_empty' => 1,
		'parent'     => '',
		'ids'        => '',
		'taxonomy'   => 'product_cat',
	), $atts, 'product_by_taxonomy' );

	$ids        = array_filter( array_map( 'trim', explode( ',', $atts['ids'] ) ) );
	$hide_empty = ( true === $atts['hide_empty'] || 'true' === $atts['hide_empty'] || 1 === $atts['hide_empty'] || '1' === $atts['hide_empty'] ) ? 1 : 0;


	// Ensure we're after a valid taxonomy
	$public_builtin_taxonomies = get_taxonomies( array(
		'public'   => true,
		'_builtin' => true,
	));
	$public_custom_taxonomies = get_taxonomies( array(
		'public'   => true,
		'_builtin' => false,
	));

	$all_taxonomies = array_merge( $public_builtin_taxonomies, $public_custom_taxonomies);

	if (! in_array($atts['taxonomy'], $all_taxonomies)) {
		return;
	}

	// get terms and workaround WP bug with parents/pad counts
	$args = array(
		'orderby'    => $atts['orderby'],
		'order'      => $atts['order'],
		'hide_empty' => $hide_empty,
		'include'    => $ids,
		'pad_counts' => true,
		'child_of'   => $atts['parent'],
		'taxonomy'   => $atts['taxonomy'],
	);

	$terms = get_terms( $args );

	if ( '' !== $atts['parent'] ) {
		$terms = wp_list_filter( $terms, array( 'parent' => $atts['parent'] ) );
	}

	if ( $hide_empty ) {
		foreach ( $terms as $key => $term ) {
			if ( 0 == $term->count ) {
				unset( $terms[ $key ] );
			}
		}
	}

	if ( $atts['number'] ) {
		$terms = array_slice( $terms, 0, $atts['number'] );
	}

	$columns                     = absint( $atts['columns'] );
	$woocommerce_loop['columns'] = $columns;

	ob_start();

	if ( $terms ) {
		woocommerce_product_loop_start();

		foreach ( $terms as $term ) {
			wc_get_template( 'content-product_cat.php', array(
				'category' => $term,
			) );
		}

		woocommerce_product_loop_end();
	}

	woocommerce_reset_loop();

	return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
}
