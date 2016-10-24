<?php
/**
 * Plugin Name:     EDD Admin Tabs
 * Plugin URI:      https://wordpress.org/plugins/edd-admin-tabs/
 * Description:     Better organization of download's edit page with tabs
 * Version:         1.0.0
 * Author:          rubengc
 * Author URI:      http://rubengc.com
 * Text Domain:     edd-admin-tabs
 *
 * @package         EDD\Admin_Tabs
 * @author          rubengc
 * @copyright       Copyright (c) rubengc
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'EDD_Admin_Tabs' ) ) {

    /**
     * Main EDD_Admin_Tabs class
     *
     * @since       1.0.0
     */
    class EDD_Admin_Tabs {

        /**
         * @var         EDD_Admin_Tabs $instance The one true EDD_Admin_Tabs
         * @since       1.0.0
         */
        private static $instance;


        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true EDD_Admin_Tabs
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new EDD_Admin_Tabs();
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->load_textdomain();
                self::$instance->hooks();
            }

            return self::$instance;
        }


        /**
         * Setup plugin constants
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function setup_constants() {
            // Plugin version
            define( 'EDD_ADMIN_TABS_VER', '1.0.0' );

            // Plugin path
            define( 'EDD_ADMIN_TABS_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'EDD_ADMIN_TABS_URL', plugin_dir_url( __FILE__ ) );
        }


        /**
         * Include necessary files
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function includes() {
            // Include scripts
            require_once EDD_ADMIN_TABS_DIR . 'includes/scripts.php';
        }


        /**
         * Run action and filter hooks
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function hooks() {
            // Adds tabs at top of edit download view
            add_action( 'edit_form_top', array( $this, 'edd_admin_tabs_html' ) );
        }


        /**
         * Internationalization
         *
         * @access      public
         * @since       1.0.0
         * @return      void
         */
        public function load_textdomain() {
            // Set filter for language directory
            $lang_dir = EDD_ADMIN_TABS_DIR . '/languages/';
            $lang_dir = apply_filters( 'edd_admin_tabs_languages_directory', $lang_dir );

            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), 'edd-admin-tabs' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'edd-admin-tabs', $locale );

            // Setup paths to current locale file
            $mofile_local   = $lang_dir . $mofile;
            $mofile_global  = WP_LANG_DIR . '/edd-admin-tabs/' . $mofile;

            if( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/edd-admin-tabs/ folder
                load_textdomain( 'edd-admin-tabs', $mofile_global );
            } elseif( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/edd-admin-tabs/languages/ folder
                load_textdomain( 'edd-admin-tabs', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'edd-admin-tabs', false, $lang_dir );
            }
        }

        public function edd_admin_tabs_html( $post ) {
            if($post->post_type == 'download') {
                $tabs =  array();

                $tabs['general'] =  array(
                    'label' => 'General Information',
                    'selectors' => array(
                        '#titlediv',
                        '#postdivrich',
                        '#edd_product_notes',
                        '#postexcerpt',
                        '#download_categorydiv',
                        '#tagsdiv-download_tag',
                        '#edd_product_settings',
                        '#postimagediv',
                        // Support for EDD Googl
                        '#edd-googl-shortlink-box',
                    )
                );

                $tabs['price-files'] = array(
                    'label' => 'Prices and files',
                    'selectors' => array(
                        '#edd_product_prices',
                        '#edd_product_files',
                    )
                );

                if( class_exists('EDD_Front_End_Submissions') ) {
                    // Support for EDD FES
                    $tabs['fes'] = array(
                        'label' => 'Vendor',
                        'selectors' => array(
                            '#fes-custom-fields',
                            '#authordiv',
                            // Support for EDD Commissions
                            '#edd_download_commissions',
                        )
                    );
                }

                if( class_exists('WPSEO_Meta') ) {
                    // Support for Yoast SEO
                    $tabs['seo'] = array(
                        'label' => 'SEO',
                        'selectors' => array(
                            '#wpseo_meta',
                        )
                    );
                }

                $tabs['feedback'] = array(
                    'label' => 'Feedback',
                    'selectors' => array(
                        '#commentstatusdiv',
                        '#commentsdiv',
                        // Support for EDD Reviews
                        '#edd-reviews-status',
                        '#edd-reviews',
                    )
                );

                $tabs = apply_filters( 'edd_admin_tabs_download_tabs', $tabs );

                $current_tab = 'tab-' . array_keys( $tabs )[0];

                ?>
                <div id="edd-admin-tabs-container">
                    <h1 id="edd-admin-tabs-nav" class="edd-admin-tabs-nav nav-tab-wrapper">
                    <?php
                        foreach($tabs as $tab_id => $tab_args) {
                            ?>
                                <a id="tab-<?php echo $tab_id; ?>"
                                   href="#"
                                   class="edd-admin-tabs-nav-tab nav-tab <?php echo ($current_tab == 'tab-' . $tab_id) ? 'nav-tab-active' : ''; ?>"
                                   data-selector="<?php echo implode( ', ', $tab_args['selectors'] ); ?>">
                                    <span><?php echo $tab_args['label']; ?></span>
                                </a>
                            <?php
                        }
                    ?>
                    </h1>
                </div>
                <?php
            }
        }
    }
} // End if class_exists check


/**
 * The main function responsible for returning the one true EDD_Admin_Tabs
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \EDD_Admin_Tabs The one true EDD_Admin_Tabs
 */
function edd_admin_tabs() {
    return EDD_Admin_Tabs::instance();
}
add_action( 'plugins_loaded', 'edd_admin_tabs' );
