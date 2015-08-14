<?php

/*
  Plugin Name: Vebtraffic
  Plugin URI: http://vebtraffic.com/
  Description: Vebtraffic.com
  Author: Vebtraffic
  Version: 2.2.6
  Author URI: http://vebtraffic.com/
  Text Domain: wp-vebtraffic
 */
$vt_PluginName = 'Vebtraffic';
$upload_dir = wp_upload_dir();
define('VT_PATH', plugin_dir_path(__FILE__));
define('VT_URL', plugin_dir_url(__FILE__));
define('VT_APP_URL', 'http://vebtraffic.com/');
//define('VT_APP_URL', 'http://localhost/vt/');

function vt_Activation_register() {
    
}

register_activation_hook(__FILE__, 'vt_Activation_register');

function vt_wp_admin_style() {
    wp_register_style('custom_wp_admin_css', plugins_url('css/styles.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('custom_wp_admin_css');
}

add_action('admin_enqueue_scripts', 'vt_wp_admin_style');

include VT_PATH . 'functions.php';

function vt_AdminMenu() {
    global $vt_PluginName;
    $vt_home_page = add_menu_page($vt_PluginName, $vt_PluginName, 'edit_themes', $vt_PluginName . "Home", 'vt_HomeView', VT_URL . 'images/icon.png');
    $vt_campaigns_page = add_submenu_page($vt_PluginName . "Home", 'Campaigns', 'Campaigns', 'edit_themes', $vt_PluginName . "Campaigns", 'vt_CampaignsView');
    $vt_add_campaigns_page = add_submenu_page($vt_PluginName . "Home", 'Add Campaigns', 'Add Campaigns', 'edit_themes', $vt_PluginName . "AddCampaigns", 'vt_addCampaignsView');
    $vt_settings_page = add_submenu_page($vt_PluginName . "Home", 'Settings', 'Settings', 'edit_themes', $vt_PluginName . "Settings", 'vt_SettingsView');
}

add_action('admin_menu', 'vt_AdminMenu');

function vt_HomeView() {
    global $vt_PluginName, $wpdb;
    if (get_option('vt_api_key')) {
        include 'vt_home.php';
    } else {
        include 'vt_settings.php';
    }
}

function vt_CampaignsView() {
    global $vt_PluginName, $wpdb;
    if (get_option('vt_api_key')) {
        include 'vt_campaigns.php';
    } else {
        include 'vt_settings.php';
    }
}

function vt_addCampaignsView() {
    global $vt_PluginName, $wpdb;
    if (get_option('vt_api_key')) {
        include 'vt_add_campaigns.php';
    } else {
        include 'vt_settings.php';
    }
}

function vt_SettingsView() {
    global $vt_PluginName, $wpdb;
    include 'vt_settings.php';
}

function vt_UpgradeView() {
    global $vt_PluginName, $wpdb;
    echo "<script>document.location.href='" . VT_APP_URL . "/app/upgrade.php'</script>";
    @header("Location:" . VT_APP_URL . "app/upgrade.php");
}

function vt_load_scripts($hook) {
    global $vt_PluginName;

    wp_enqueue_script('vt_ajax', plugin_dir_url(__FILE__) . 'js/vt_ajax.js', array('jquery'));
    wp_localize_script('vt_ajax', 'vt_vars', array(
        'vt_nonce' => wp_create_nonce('vt_nonce')
    ));
}

add_action('admin_enqueue_scripts', 'vt_load_scripts');

function vt_ajax_process() {

    if (!isset($_POST['vt_nonce']) || !wp_verify_nonce(($_POST['vt_nonce']), 'vt_nonce'))
        die('Permission denied...');

    $do = $_POST['do'];

    $result = array(
        'error' => '',
        'pass' => ''
    );

    if ($do == 'update_api_key') {
        $api_key = $_POST['api_key'];
        $surfer_link = $_POST['surfer_link'];
        update_option('vt_api_key', $api_key);
        update_option('vt_surfer_link', $surfer_link);

        $result = array('status' => "Success", "msg" => "Api key updated.");
        echo json_encode($result);
        exit();
    }

    die();
}

add_action('wp_ajax_update_vt_options', 'vt_ajax_process');
