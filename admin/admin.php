<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post View Count Admin Class
 */
class WTDPVC_ADMIN {

	/**
	 *  __construct
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {

		// enqueue admin scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'wtdpvc_admin_enqueue_scripts' ) );

		// Add new columns to post list.
		add_filter( 'manage_posts_columns', array( $this, 'wtdpvc_add_new_columns' ) );

		// Add data to new columns.
		add_action( 'manage_posts_custom_column', array( $this, 'wtdpvc_add_data_to_new_columns' ), 10, 2 );

		// Sortable columns.
		add_filter( 'manage_edit-post_sortable_columns', array( $this, 'wtdpvc_sortable_columns' ) );

		// Sort posts by post view count.
		add_action( 'pre_get_posts', array( $this, 'wtdpvc_sort_posts_by_post_view_count' ) );
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function wtdpvc_admin_enqueue_scripts() {

		// // Enqueue custom stylesheet for plugin admin dashboard.
		wp_enqueue_style( 'wtdpvc-admin-style', WTDPVC_FILE . 'assets/admin/css/wtdpvc-admin-style.css', array(), WTDPVC_VERSION, 'all' );

		// Enqueue custom script for plugin admin dashboard.
		wp_enqueue_script( 'wtdpvc-admin-script', WTDPVC_FILE . 'assets/admin/js/wtdpvc-admin-script.js', array( 'jquery' ), WTDPVC_VERSION, true );
	}

	/**
	 * Add new columns to post list
	 *
	 * @since 1.0.0
	 * @param array $columns
	 * @return array
	 */
	public function wtdpvc_add_new_columns( $columns ) {

		// Add new column.
		$columns['wtdpvc_post_view_count'] = __( 'View Count', 'post-view-count' );

		return $columns;
	}

	/**
	 * Add data to new columns.
	 *
	 * @since 1.0.0
	 * @param string $column
	 * @param int    $post_id
	 * @return void
	 */
	public function wtdpvc_add_data_to_new_columns( $column, $post_id ) {

		// Display post view count.
		if ( 'wtdpvc_post_view_count' === $column ) {
			// get post view count.
			$count = get_post_meta( $post_id, 'wtdpvc_post_view_count', true );

			// Display post view count.
			echo "<div class='wtdpvc_view_count_wrap'>";

			if ( '' === $count ) {
				echo "<p  class='wtdpvc_view_count empty'> " . esc_html( __( 'No Views', 'post-view-count' ) ) . '</p>';
			} else {
				echo "<p class='wtdpvc_view_count '> " . esc_html( $count ) . ' ' . esc_html( __( 'Views', 'post-view-count' ) ) . '</p>';
			}
			echo "<button class='wtdpvc_shortcode_btn' data-code ='[wtdpvc_post_view_count id=" . esc_attr( $post_id ) . "]'> " . esc_html( __( 'Copy Shortcode', 'post-view-count' ) ) . ' </button>';

			echo '</div>';

		}
	}

	/**
	 * Sortable columns
	 *
	 * @since 1.0.0
	 * @param array $columns
	 * @return array
	 */
	public function wtdpvc_sortable_columns( $columns ) {

		// Add new column.
		$columns['wtdpvc_post_view_count'] = 'wtdpvc_post_view_count';
		return $columns;
	}

	/**
	 * Sort posts by post view count
	 *
	 * @since 1.0.0
	 * @param WP_Query $query
	 * @return void
	 */
	public function wtdpvc_sort_posts_by_post_view_count( $query ) {

		// Check if it's admin.
		if ( ! is_admin() ) {
			return;
		}

		// Check if it's main query.
		$orderby = $query->get( 'orderby' );

		// Sort posts by post view count.
		if ( 'wtdpvc_post_view_count' === $orderby ) {
			$query->set( 'meta_key', 'wtdpvc_post_view_count' );
			$query->set( 'orderby', 'meta_value_num' );
		}
	}
}
