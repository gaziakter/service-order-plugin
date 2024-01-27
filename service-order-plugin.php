<?php 
/**
 * Plugin Name:       Service Order Plugin
 * Plugin URI:        https://gaziakter.com/plugin/service-order-plugin
 * Description:       Service order plugin for quick client order form handle. 
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Gazi Akter
 * Author URI:        https://gaziakter.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       service-order
 * Domain Path:       /languages
 */


add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( 'toplevel_page_service_order' == $hook ) {
        wp_enqueue_style( 'pure-grid-css', '//unpkg.com/purecss@1.0.1/build/grids-min.css' );
        wp_enqueue_style( 'service-order-css', plugin_dir_url( __FILE__ ) . "assets/css/style.css", null, time() );
        wp_enqueue_script( 'service-order-js', plugin_dir_url( __FILE__ ) . "assets/js/main.js", array( 'jquery' ), time(), true );

        $action = 'ajd_protected';
        $ajd_nonce = wp_create_nonce( $action );
        wp_localize_script(
            'service-order-js',
            'plugindata',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ))
        );
    }
} );

add_action( 'admin_menu', function () {
    add_menu_page( 'Service Order', 'Service Order', 'manage_options', 'service_order', 'service_order_admin_page' );
} );

function service_order_admin_page() {
    ?>
        <div class="container" style="padding-top:20px;">
            <h1>Service Order</h1>
            <div class="pure-g">
                <div class="pure-u-1-4" style='height:100vh;'>
                    <div class="plugin-side-options">
                        <button class="action-button" data-task='simple_ajax_call'>Simple Ajax Call</button>
                        <button class="action-button" data-task='unp_ajax_call'>Unprivileged Ajax Call</button>
                        <button class="action-button" data-task='ajd_localize_script'>Why wp_localize_script</button>
                        <button class="action-button" data-task='ajd_secure_ajax_call'>Security with Nonce</button>
                    </div>
                </div>
                <div class="pure-u-3-4">
                    <div class="plugin-demo-content">
                        <h3 class="plugin-result-title">Result</h3>
                        <div id="plugin-demo-result" class="plugin-result"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

add_action( 'wp_ajax_ajd_simple', function () {
    $data = $_POST['data'];
    echo "Hello " . strtoupper( $data );
    die();
} );