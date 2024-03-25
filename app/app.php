<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class WTDPVC_APP {
    public function __construct() {  

        // Enqueue admin scripts
        add_action( 'wp_enqueue_scripts', array( $this, 'wtdpvc_enqueue_scripts' ) );

        // Count post view
        add_action( 'wp_head', array( $this, 'wtdpvc_count_post_view' ) );

        // ShortCode for Post View Count passed the post id 
        add_shortcode( 'wtdpvc_post_view_count', array( $this, 'wtdpvc_post_view_count_shortcode' ) );
         
    }
 
    /**
     * Enqueue admin scripts
     *
     * @since 1.0.0
     * @author Sydur Rahman <sydurrahmant1@gmail.com>
     * @return void
     */
    public function wtdpvc_enqueue_scripts(){
 
        // Enqueue style
        wp_enqueue_style( 'wtdpvc-admin-style', WTDPVC_FILE . 'assets/app/css/wtdpvc-style.css', array(), WTDPVC_VERSION, 'all' ); 
    }

    /**
     * Count post view count
     *
     * @since 1.0.0
     * @param int $post_id 
     */

    public function wtdpvc_count_post_view( $post_id ){ 

        // Check if it's a single post page
        if( is_single() ){ 

            // Get current post ID
            $post_id = get_the_ID();
             
            // Post Meta Key
            $count_key = 'wtdpvc_post_view_count';

            // Get post meta value
            $count = get_post_meta( $post_id, $count_key, true );

            // If the count does not exist, set it to zero.
            if( $count =='' ){

                $count = 0;
                delete_post_meta( $post_id, $count_key );
                add_post_meta( $post_id, $count_key, 1 );

            }else{ // Otherwise, increment it by 1

                $count++;
                update_post_meta( $post_id, $count_key, $count );
            } 
        } 

    }

    /**
     * ShortCode for Post View Count
     *
     * @since 1.0.0
     * @param int $post_id 
     */ 
    public function wtdpvc_post_view_count_shortcode( $atts ){ 

        // Shortcode attribute
        $atts = shortcode_atts( array(
            'id' => get_the_ID(),
        ), $atts, 'wtdpvc_post_view_count' );

        // Get post id
        $post_id = $atts['id'];

        // get post view count
        $count_key = 'wtdpvc_post_view_count';

        $count = get_post_meta( $post_id, $count_key, true ); 

        if( $count =='' ){
            return esc_html( __('No Views', 'post-view-count') );
        }

        ob_start();
        ?>
        <div class="wtdpvc-post-view-count">
            <h2>
                <?php echo esc_html( __('Page View',  'post-view-count'  ) ) ?>
                <span><?php echo esc_html( __('Total Views',  'post-view-count'  ) ) ?></span>
                <?php echo esc_html($count); ?>
            </h2> 
           
            
        </div>

        <?php
        return ob_get_clean();
    }
}