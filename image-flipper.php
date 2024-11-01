<?php
/*
Plugin Name: WooCommerce Image Flipper
Version: 1.0
Description: Displays a secondary image for product archives on hover.
Author: Debabrat Sharma
Author URI: https://www.facebook.com/debabrat.sharma.31
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	/**
	 * Image Flipper class
	 **/
	if ( ! class_exists( 'WC_wif' ) ) {

		class WC_wif {

			public function __construct() {
				add_action( 'wp_enqueue_scripts', array( $this, 'wif_scripts' ) );														// Enqueue the styles
				add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'wif_second_product_thumbnail' ), 11 );
				add_filter( 'post_class', array( $this, 'wif_gallery' ) );
			}


	        /*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/

			// Setup styles
			function wif_scripts() {
				if ( apply_filters( 'woocommerce_product_image_flipper_styles', true ) ) {
					wp_enqueue_style( 'pif-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );
				}
				wp_enqueue_script( 'pif-script', plugins_url( '/assets/js/script.js', __FILE__ ), array( 'jquery' ) );
			}

			// Add pif-has-gallery class to products that have a gallery
			function wif_gallery( $classes ) {
				global $product;

				$post_type = get_post_type( get_the_ID() );

				if ( ! is_admin() ) {

					if ( $post_type == 'product' ) {

						$attachment_ids = $this->wif_gallery_image_ids( $product );

						if ( $attachment_ids ) {
							$classes[] = 'wif-if-gallery';
						}
					}

				}

				return $classes;
			}


			/*-----------------------------------------------------------------------------------*/
			/* Frontend Functions */
			/*-----------------------------------------------------------------------------------*/

			// Display the second thumbnails
			function wif_second_product_thumbnail() {
				global $product, $woocommerce;

				$attachment_ids = $this->wif_gallery_image_ids( $product );

				if ( $attachment_ids ) {
					$attachment_ids     = array_values( $attachment_ids );
					$secondary_image_id = $attachment_ids['1'];
					echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'secondary-image attachment-shop-catalog wp-post-image' ) );
				}
			}


			/*-----------------------------------------------------------------------------------*/
			/* WooCommerce Compatibility Functions */
			/*-----------------------------------------------------------------------------------*/

			// Get product gallery image IDs
			function wif_gallery_image_ids( $product ) {
				if ( ! is_a( $product, 'WC_Product' ) ) {
					return;
				}

				if ( is_callable( 'WC_Product::wif_gallery_image_ids' ) ) {
					return $product->wif_gallery_image_ids();
				} else {
					return $product->wif_gallery_attachment_ids();
				}
			}

		}


		$WC_wif = new WC_wif();
	}
}
