<?php
/**
 * Plugin Name: Post View Count
 * Plugin URI: https://github.com/mdrejon/post-view-count
 * Description: This plugins counts the number of views for each post.
 * Version: 1.0.0
 * Author: Sydur Rahman
 * Author URI: https://sydurrahman.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: post-view-count
 * Domain Path: /languages
 */


class  WTDPVC_VIEW_COUNT {
    public function __construct() {

        // // Define constant
        $this->wtdrp_constant();
 
        // Load plugin textdomain
        add_action( 'plugins_loaded', array( $this, 'wtdpvc_load_textdomain' ) );

        // Run the plugin
        add_action( 'plugins_loaded', array( $this, 'wtdpvc_run' ) );  
    }
 
    /**
     * Load plugin textdomain.  
     *
     * @since 1.0.0
     * @author Sydur Rahman <sydurrahmant1@gmail.com>
     * @return void
     */
    public function wtdpvc_load_textdomain() {

        load_plugin_textdomain( 'post-view-count', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

    }
    
    /**
     * Run the plugin
     *
     * @since 1.0.0
     * @author Sydur Rahman <sydurrahmant1@gmail.com>
     * @return void
     */
    public function wtdpvc_run() {
        
        // Check if it's admin
        if( is_admin() ){

            // Load admin class
            require_once WTDPVC_PATH . 'admin/admin.php';

            // Run admin class
            new WTDPVC_ADMIN();

            
        } else { 

            // Load app class
            require_once WTDPVC_PATH . 'app/app.php';

            // Run app class
            new WTDPVC_APP();

        }

    }

    /**
     * Define constant
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function wtdrp_constant(){

        // Define constant
        define( 'WTDPVC_VERSION', '1.0.0' ); 
        define( 'WTDPVC_FILE', plugin_dir_url( __FILE__ ));
        define( 'WTDPVC_PATH', plugin_dir_path( __FILE__ )); 

    }

}

// Run the plugin
new WTDPVC_VIEW_COUNT(); 
