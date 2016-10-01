<?php
/**
 * Scripts
 *
 * @package     EDD\Admin_Tabs\Scripts
 * @since       1.0.0
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;


/**
 * Load admin scripts
 *
 * @since       1.0.0
 * @global      array $edd_settings_page The slug for the EDD settings page
 * @global      string $post_type The type of post that we are editing
 * @return      void
 */
function edd_admin_tabs_admin_scripts( $hook ) {
    global $post_type;

    if($post_type == 'download') {
        wp_enqueue_script('edd_admin_tabs_admin_js', EDD_ADMIN_TABS_URL . '/assets/js/edd-admin-tabs.js', array('jquery'));
    }
}
add_action( 'admin_enqueue_scripts', 'edd_admin_tabs_admin_scripts', 100 );