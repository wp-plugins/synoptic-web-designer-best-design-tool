<?php

/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool Light
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool-light/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: wdh.svwe.main.php
 * File Description: Main PHP Class
 * File Version: 1.0
 * Last Update File : 24.01.2015
 * ------------------------------------------------------------------- 
 */

if (!class_exists("wdhSVWE")) {
    
    class wdhSVWE
    {
        
        function wdhSVWE(){ // Constructor
            global $wdhSVWE, $wdhDB, $wdhFIELD, $WDH_EDFP;
            
            // Define constants
            $this->defConstants();
            
            // EDFP JS & CSS
            $WDH_EDFP->wdhHeadAutoInit();
            
            if (is_admin()){// admin.
                include_once ABSPATH.'wp-includes/pluggable.php';
                
                // Admin Start
                $this->startAdmin();
            }
            
            if ($wdhSVWE["ENABLED"] == true && $_SERVER['REQUEST_METHOD'] != 'POST') {
                
                if(is_admin()) {
                    // Rewrite Role Admin
                    add_action('init', array(&$this, 'rewriteRole'));
                }
                
                // Adding Translation & JS Variables in Backend
                if (!has_action('admin_head', array (&$this, 'wdhHead') )) {
                    add_action('admin_head', array(&$this, 'wdhHead'),10);
                }
                
                // Adding Translation & JS Variables in Frontend
                if (!has_action('wp_head', array (&$this, 'wdhHead') )) {
                    add_action('wp_head', array(&$this, 'wdhHead'),10);
                }
                 
                // Add Admin CSS
                add_action('admin_enqueue_scripts', array(&$this, 'addCSS'));

                // Add Frontend CSS
                add_action('wp_enqueue_scripts', array(&$this, 'addCSS'));

                // Add Admin JS
                add_action('admin_enqueue_scripts', array(&$this, 'addJS'));

                // Add Frontend JS
                add_action('wp_enqueue_scripts', array(&$this, 'addJS'));
            }
            
        }
        
        function rewriteRole(){
            global $current_user, $wdhSVWE;
            
            if ($this->userIsAdmin()){// admin.
                $wdhSVWE['role']    = get_option('WDH_SVWE_role');
                
                if(!isset($wdhSVWE['role'])) {
                    $wdhSVWE['role']  = 'all';
                    add_option('WDH_SVWE_role', $wdhSVWE['role']);
                } else {
                    
                    if ($wdhSVWE['role'] == '') {
                        $wdhSVWE['role']  = 'all';
                        update_option('WDH_SVWE_role', $wdhSVWE['role']);
                    }
                }
                
                $wdhLanguage = get_option('WDH_SVWE_language');
                
                if(!isset($wdhLanguage)) {
                    add_option('WDH_SVWE_language', $wdhSVWE["LANGUAGE"]);
                } else {
                    
                    if ($wdhLanguage == '') {
                        update_option('WDH_SVWE_language', $wdhSVWE["LANGUAGE"]);
                    }
                }
            } else {
                $wdhSVWE['role']    = $this->getCurrentRole();
            }
            
            // Set Real Role
            $wdhSVWE['real_role'] = $this->getCurrentRole();
            
            switch($wdhSVWE['role']){
                case 'all':
                    // Do not change role
                    break;
                case 'administrator':
                    // Do not change role
                    break;
                case 'editor':
                    if(isset($current_user->caps['administrator'])) {
                        $current_user->caps = array();
                        $current_user->caps['editor'] = 1;
                        
                        $current_user->allcaps = array('moderate_comments' => 1,
                                                        'manage_categories' => 1,
                                                        'manage_links' => 1,
                                                        'upload_files' => 1,
                                                        'unfiltered_html' => 1,
                                                        'edit_posts' => 1,
                                                        'edit_others_posts' => 1,
                                                        'edit_published_posts' => 1,
                                                        'publish_posts' => 1,
                                                        'edit_pages' => 1,
                                                        'read' => 1,
                                                        'level_7' => 1,
                                                        'level_6' => 1,
                                                        'level_5' => 1,
                                                        'level_4' => 1,
                                                        'level_3' => 1,
                                                        'level_2' => 1,
                                                        'level_1' => 1,
                                                        'level_0' => 1,
                                                        'edit_others_pages' => 1,
                                                        'edit_published_pages' => 1,
                                                        'publish_pages' => 1,
                                                        'delete_pages' => 1,
                                                        'delete_others_pages' => 1,
                                                        'delete_published_pages' => 1,
                                                        'delete_posts' => 1,
                                                        'delete_others_posts' => 1,
                                                        'delete_published_posts' => 1,
                                                        'delete_private_posts' => 1,
                                                        'edit_private_posts' => 1,
                                                        'read_private_posts' => 1,
                                                        'delete_private_pages' => 1,
                                                        'edit_private_pages' => 1,
                                                        'read_private_pages' => 1,
                                                        'editor' => 1);
                    }
                    $current_user->roles{0} = 'editor';
                    break;
                case 'author':
                    if(isset($current_user->caps['administrator'])) {
                        $current_user->caps = array();
                        $current_user->caps['author'] = 1;
                        
                        $current_user->allcaps = array('upload_files' => 1,
                                                        'edit_posts' => 1,
                                                        'edit_published_posts' => 1,
                                                        'publish_posts' => 1,
                                                        'read' => 1,
                                                        'level_2' => 1,
                                                        'level_1' => 1,
                                                        'level_0' => 1,
                                                        'delete_posts' => 1,
                                                        'delete_published_posts' => 1,
                                                        'author' => 1);
                    }
                    $current_user->roles{0} = 'author';
                    break;
                case 'contributor':
                    if(isset($current_user->caps['administrator'])) {
                        $current_user->caps = array();
                        $current_user->caps['contributor'] = 1;
                        
                        $current_user->allcaps = array('edit_posts' => 1,
                                                        'read' => 1,
                                                        'level_1' => 1,
                                                        'level_0' => 1,
                                                        'delete_posts' => 1,
                                                        'contributor' => 1);
                    }
                    $current_user->roles{0} = 'contributor';
                    break;
                case 'subscriber':
                    if(isset($current_user->caps['administrator'])) {
                        $current_user->caps = array();
                        $current_user->caps['subscriber'] = 1;
                        
                        $current_user->allcaps = array('read' => 1,
                                                        'level_0' => 1,
                                                        'subscriber' => 1);
                    }
                    $current_user->roles{0} = 'subscriber';
                    break;
                default:
                    if(isset($current_user->caps['administrator'])) {
                        $current_user->caps = array();
                        $current_user->caps['subscriber'] = 1;
                        
                        $current_user->allcaps = array('read' => 1,
                                                        'level_0' => 1,
                                                        'subscriber' => 1);
                    }
                    $current_user->roles{0} = 'subscriber';
                    break;
            }
        }
        
        /*
         * Admin Start
         */
        
        function startAdmin(){
            $this->generateTables();
        }
        
        function addCSS(){
            
            if ($this->userIsAdmin()){// admin.  
                // Register Styles.
                wp_register_style('SVWE_Popup_CSS', plugins_url('css/wdh.svwe.popup.css', __FILE__));
                wp_register_style('SVWE_Panel_CSS', plugins_url('css/wdh.svwe.panel.css', __FILE__));
                wp_register_style('SVWE_Synoptic_CSS', plugins_url('css/wdh.svwe.css', __FILE__));

                // Enqueue Styles.
                wp_enqueue_style('SVWE_Popup_CSS');
                wp_enqueue_style('SVWE_Panel_CSS');
                wp_enqueue_style('SVWE_Synoptic_CSS');
            }
        }
        
        function addJS(){
            
            if ($this->userIsAdmin()){// admin.  
                // Register JavaScript.
                wp_register_script('SVWE_Cookie_JS', plugins_url('js/wdh.svwe.cookie.js', __FILE__), array('jquery'));
                wp_register_script('SVWE_Dom_Path_JS', plugins_url('js/jquery.dom.path.js', __FILE__), array('jquery'));
                wp_register_script('SVWE_Popup_JS', plugins_url('js/wdh.svwe.popup.js', __FILE__), array('jquery'));
                wp_register_script('SVWE_Panel_JS', plugins_url('js/wdh.svwe.panel.js', __FILE__), array('jquery'));
                wp_register_script('SVWE_Synoptic_JS', plugins_url('js/wdh.svwe.js', __FILE__), array('jquery'));

                // Enqueue JavaScript.
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }

                if (!wp_script_is('jquery-ui-core', 'jquery')){
                    wp_enqueue_script('jquery-ui-core');
                }

                if (!wp_script_is('jquery-ui-datepicker', 'queue')){
                    wp_enqueue_script('jquery-ui-datepicker');
                }

                if (!wp_script_is('jquery-ui-tooltip', 'queue')){
                    wp_enqueue_script('jquery-ui-tooltip');
                }

                if (!wp_script_is('jquery-ui-resizable', 'queue')){
                    wp_enqueue_script('jquery-ui-resizable');
                }

                wp_enqueue_script('SVWE_Cookie_JS');
                wp_enqueue_script('SVWE_Dom_Path_JS');
                wp_enqueue_script('SVWE_Popup_JS');
                wp_enqueue_script('SVWE_Panel_JS');
                wp_enqueue_script('SVWE_Synoptic_JS');
            }
        }
        
        function wdhHead(){;
            global $wdhSVWE_CSS, $wdhSVWE, $wdhLibs;
            $headHTML = array();
            $wdhPageUrl = $this->clearPageUrl((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            
            if ($this->userIsAdmin()){// admin.
                $wdhSVWE['role']    = get_option('WDH_SVWE_role');
                
                if(!isset($wdhSVWE['role'])) {
                    $wdhSVWE['role']  = 'all';
                    add_option('WDH_SVWE_role', $wdhSVWE['role']);
                } else {
                    
                    if ($wdhSVWE['role'] == '') {
                        $wdhSVWE['role']  = 'all';
                        update_option('WDH_SVWE_role', $wdhSVWE['role']);
                    }
                }
                
                $wdhLanguage = get_option('WDH_SVWE_language');
                
                if(!isset($wdhLanguage)) {
                    add_option('WDH_SVWE_language', $wdhSVWE["LANGUAGE"]);
                } else {
                    
                    if ($wdhLanguage == '') {
                        update_option('WDH_SVWE_language', $wdhSVWE["LANGUAGE"]);
                    }
                }
            } else {
                $wdhSVWE['role']    = $this->getCurrentRole();
            }
            
            if (is_admin()){// admin.
                $wdhSVWE['page_on'] = 'wpadmin';
                
                if ($wdhSVWE['role'] === 'all') {
                    $wdhSVWE['role'] = 'administrator';
                }
            } else {
                $wdhSVWE['page_on'] = 'wpsite';
            }
            
            include_once WDHSVWE_Path.'wdh.svwe.css.php';
            
            if (!isset($wdhSVWE_CSS)) {
                $wdhSVWE_CSS = new wdhSVWE_CSS();
            }
            
            array_push($headHTML, '<!-- WDH TAGS -->');
            array_push($headHTML, '<!--[if lt IE 9]>');
            array_push($headHTML, '<script type="text/javascript"> document.createElement("wdhdiv"); document.createElement("wdhspan"); </script>');
            array_push($headHTML, '<![endif]-->');
            array_push($headHTML, '<!-- SWE: Generate CSS -->');
            
            // Add CSS Files for all people
            array_push($headHTML, $wdhSVWE_CSS->generateCSSFiles('all'));
            
            if ($wdhSVWE['role'] != 'all') {
                // Add CSS Files for x Role
                array_push($headHTML, $wdhSVWE_CSS->generateCSSFiles($wdhSVWE['role']));
            }
            
            if ($this->userIsAdmin()){// admin.  
                array_push($headHTML, '<style>');
                array_push($headHTML, $wdhSVWE_CSS->generateCSSTemp());
                array_push($headHTML, '</style>');
                array_push($headHTML, '<!-- SWE: Translation JS -->');
                array_push($headHTML, '<script type="text/javascript">');
                array_push($headHTML,   $this->addLanguageInJS());
                array_push($headHTML,   $this->addRollBackJS('website', $wdhPageUrl));
                array_push($headHTML,   $this->addRollBackJS('current_page', $wdhPageUrl));
                array_push($headHTML,   'window.wdhSVWESettingsResizeWidth  = window.WDH_DEFAULT_WIDTH;');
                array_push($headHTML,   'window.wdhSVWESettingsResizeHeight = window.WDH_DEFAULT_HEIGHT;');
                
                if (is_admin()){// admin.
                    array_push($headHTML,   'window.wdhSVWEPageIsOn             = "wpadmin";');
                    array_push($headHTML,   'window.wdhSVWEPageWPadminURL       = "'.admin_url().'";');
                } else {
                    array_push($headHTML,   'window.wdhSVWEPageIsOn             = "wpsite";');
                }
                
                include_once WDHSVWE_Path.'wdh.libs.php';
                
                if (!isset($wdhLibs)) {
                    $wdhLibs = new wdhLibs();
                }
                
                    array_push($headHTML,   'window.wdhSVWERole                 = "'.$wdhSVWE['role'].'";');
                    array_push($headHTML,   'window.wdhSVWERoles                = "'.$wdhSVWE["WDH_DEFAULT_DESIGN_CREATE_FOR_ROLES"].'";');
                    array_push($headHTML,   'window.wdhSVWELanguage             = "'.$wdhLanguage.'";');
                    array_push($headHTML,   "window.wdhSVWELanguages            = '".$wdhLibs->getLanguagesOptions($wdhLanguage)."';");
                    
                array_push($headHTML,   'window.ajaxurl = "'.admin_url('admin-ajax.php').'";');
                array_push($headHTML,   'var ajaxurl = "'.admin_url('admin-ajax.php').'";');
                array_push($headHTML,   'var $jWDH = jQuery.noConflict();');
                array_push($headHTML,   '$jWDH(document).ready(function(){');
                array_push($headHTML,   '   $jWDH(window.WDH_DEFAULT_CONTAINER).wdhSWE();');
                array_push($headHTML,   '});');
                array_push($headHTML, '</script>');
            }
            
            echo implode('',$headHTML);
        }
        
        function defConstants(){// Constants define.
            global $wpdb;
            
            // Paths
            if (!defined('WDHSVWE_Path')) {
                define('WDHSVWE_Path', ABSPATH.'wp-content/plugins/wdhsvwe/');
            }

            if (!defined('WDHSVWE_URL')) {
                define('WDHSVWE_URL', WP_PLUGIN_URL.'/wdhsvwe/');
            }

            // Tables
            if (!defined('WDHSVWE_General_Settings_table')) { // General Settings
                define('WDHSVWE_General_Settings_table', $wpdb->prefix.'wdh_svwe_general_settings');
            }
            
            if (!defined('WDHSVWE_Settings_table')) { // Settings
                define('WDHSVWE_Settings_table', $wpdb->prefix.'wdh_svwe_settings');
            }
            
            if (!defined('WDHSVWE_History_table')) { // History
                define('WDHSVWE_History_table', $wpdb->prefix.'wdh_svwe_history');
            }
            
            if (!defined('WDHSVWE_CSS_table')) { // CSS
                define('WDHSVWE_CSS_table', $wpdb->prefix.'wdh_svwe_css');
            }
            
            if (!defined('WDHSVWE_Temporary_CSS_table')) { // Temporary CSS
                define('WDHSVWE_Temporary_CSS_table', $wpdb->prefix.'wdh_svwe_temporary_css');
            }

        }
        
        function userIsAdmin(){
            global $wdhSVWE;
            $current_user = wp_get_current_user();
            
            if(isset($wdhSVWE['real_role'])) {
                
                if($wdhSVWE['real_role'] == 'administrator'){
                    return true;
                }
            } else {
            
                if (user_can( $current_user, 'administrator' )) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        
        function getCurrentRole(){
            global $current_user;
            
            if (isset($current_user)) {
                $user_roles = $current_user->roles;
                $user_role = array_shift($user_roles);
            } else {
                $user_role = 'all';
            }
            
            return trim($user_role);
        }
        
        function getRoles() {
            global $wp_roles;
            $rolesList = array();

            $roles = $wp_roles->roles;
            
            foreach($roles as $role){
                array_push($rolesList, $role['name']);
            }
            
            return $rolesList;
        }
        
        /*
         * Editor
         */
        
        function start(){
            global $wdhSVWE;
            
            if ($_COOKIE['wdh_svwe_login'] && $wdhSVWE["ENABLED"] == true && $_SERVER['REQUEST_METHOD'] != 'POST') { 
                $this->headStart();
            } else {
                $this->headStartViewOnly();
            }
        }
        
        /*
         * Translation
         */
        function addLanguageInJS(){
            global $wdhSVWE;
            $languageHTML = array();
            
            foreach ($wdhSVWE as $key => $value) {
                
                // ajaxurl
                if ($key == 'WEBSITE'){
                    array_push ($languageHTML, 'window.ajaxurl = "'.$value.'sne/request.php";');
                }
                
                // Languages && JS Settings
                if (strpos($key,'TXT_') !== false || strpos($key,'BOX_') !== false || strpos($key,'WDH_DEFAULT_') !== false) {
                    array_push ($languageHTML, 'window.'.$key.' = "'.$value.'";');
                }
            }
            
            return implode('', $languageHTML);
        }
        
        function generateTables(){
            global $wdhSVWE;
            
            $db_version = get_option('WDH_SVWE_db_version');
                
            if ($wdhSVWE["version"] != $db_version){
                require_once(ABSPATH.'wp-admin/includes/upgrade.php');

                // General Settings Table
                // -----------------------------------------------------------------

                $generalSettings = "CREATE TABLE ".WDHSVWE_General_Settings_table." (
                    id bigint NOT NULL AUTO_INCREMENT,
                    version VARCHAR(6) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    last_update_time datetime NOT NULL,
                    unix_last_update_time VARCHAR(30) NOT NULL,
                    UNIQUE KEY id (id)
                );";


                // Settings Table
                // -----------------------------------------------------------------

                $settings = "CREATE TABLE ".WDHSVWE_Settings_table." (
                    id bigint NOT NULL AUTO_INCREMENT,
                    uid bigint NOT NULL,
                    wid bigint NOT NULL,
                    used_for VARCHAR(20) DEFAULT 'current_page' COLLATE utf8_unicode_ci NOT NULL,
                    page_url VARCHAR(256) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    page_on VARCHAR(12) DEFAULT 'wpsite' COLLATE utf8_unicode_ci NOT NULL,
                    role VARCHAR(32) DEFAULT 'all' COLLATE utf8_unicode_ci NOT NULL,
                    roll_back VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    created_date datetime NOT NULL,
                    unix_created_date VARCHAR(30) NOT NULL,
                    UNIQUE KEY id (id)
                );";


                // History Table
                // -----------------------------------------------------------------

                $history = "CREATE TABLE ".WDHSVWE_History_table." (
                    id bigint NOT NULL AUTO_INCREMENT,
                    uid bigint NOT NULL,
                    wid bigint NOT NULL,
                    used_for VARCHAR(20) DEFAULT 'current_page' COLLATE utf8_unicode_ci NOT NULL,
                    page_url VARCHAR(256) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    page_on VARCHAR(12) DEFAULT 'wpsite' COLLATE utf8_unicode_ci NOT NULL,
                    role VARCHAR(32) DEFAULT 'all' COLLATE utf8_unicode_ci NOT NULL,
                    created_date date NOT NULL,
                    created_date_full datetime NOT NULL,
                    unix_created_date VARCHAR(30) NOT NULL,
                    UNIQUE KEY id (id)
                );";

                // CSS Table
                // -----------------------------------------------------------------

                $css = "CREATE TABLE ".WDHSVWE_CSS_table." (
                    id bigint NOT NULL AUTO_INCREMENT,
                    uid bigint NOT NULL,
                    wid bigint NOT NULL,
                    container_full_path TEXT COLLATE utf8_unicode_ci NOT NULL,
                    container_wdh_path TEXT COLLATE utf8_unicode_ci NOT NULL,
                    container_classes TEXT COLLATE utf8_unicode_ci NOT NULL,
                    container_id VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    element_tag VARCHAR(25) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    element_position int NOT NULL,
                    element_position_changed int NOT NULL,
                    resolution VARCHAR(5) DEFAULT 'all' COLLATE utf8_unicode_ci NOT NULL,
                    position_before_element TEXT COLLATE utf8_unicode_ci NOT NULL,
                    position_inside_of_element TEXT COLLATE utf8_unicode_ci NOT NULL,
                    used_for VARCHAR(20) DEFAULT 'current_page' COLLATE utf8_unicode_ci NOT NULL,
                    html_tag VARCHAR(20) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    page_url VARCHAR(256) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    page_on VARCHAR(12) DEFAULT 'wpsite' COLLATE utf8_unicode_ci NOT NULL,
                    role VARCHAR(32) DEFAULT 'all' COLLATE utf8_unicode_ci NOT NULL,
                    status VARCHAR(7) DEFAULT 'active' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_family VARCHAR(131) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_size VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_weight VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_style VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_variant VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_line_height VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_letter_spacing VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_word_spacing VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_align VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_decoration VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_indent VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_transform VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_vertical_align VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_white_space VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_color VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background VARCHAR(43) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_size VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_image VARCHAR(43) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_repeat VARCHAR(14) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_position_x VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_position_y VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_attachment VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_padding_top VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_padding_bottom VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_padding_right VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_padding_left VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_margin_top VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_margin_bottom VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_margin_right VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_margin_left VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_top VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_bottom VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_right VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_left VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_style VARCHAR(35) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_top_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_bottom_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_right_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_left_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_top_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_bottom_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_right_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_left_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_top_left_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_top_right_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_bottom_left_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_bottom_right_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_outline VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_outline_color VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_outline_width VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_outline_style VARCHAR(20) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_min_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_max_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_min_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_max_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_position VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_top VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_bottom VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_right VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_left VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_clip VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_overflow VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_z_index VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_float VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_clear VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_display VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_visibility VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_list_style VARCHAR(256) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_list_style_type VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_list_style_position VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_list_style_image VARCHAR(33) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_table_layout VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_collapse VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_spacing VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_caption_side VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_content VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_counter_increment VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_page_break_before VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_page_break_after VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_page_break_inside VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_orfans VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_windows VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_cursor VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_direction VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_unicode_bidi VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_family VARCHAR(131) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_size VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_weight VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_style VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_variant VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_line_height VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_letter_spacing VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_word_spacing VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_align VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_decoration VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_indent VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_transform VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_vertical_align VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_white_space VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_color VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background VARCHAR(43) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_size VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_image VARCHAR(43) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_repeat VARCHAR(14) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_position_x VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_position_y VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_attachment VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_padding_top VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_padding_bottom VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_padding_right VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_padding_left VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_margin_top VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_margin_bottom VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_margin_right VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_margin_left VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_top VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_bottom VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_right VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_left VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_style VARCHAR(35) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_top_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_bottom_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_right_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_left_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_top_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_bottom_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_right_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_left_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_top_left_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_top_right_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_bottom_left_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_bottom_right_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_outline VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_outline_color VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_outline_width VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_outline_style VARCHAR(20) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_min_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_max_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_min_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_max_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_position VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_top VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_bottom VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_right VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_left VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_clip VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_overflow VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_z_index VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_float VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_clear VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_display VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_visibility VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_list_style VARCHAR(256) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_list_style_type VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_list_style_position VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_list_style_image VARCHAR(33) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_table_layout VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_collapse VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_spacing VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_caption_side VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_content VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_counter_increment VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_page_break_before VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_page_break_after VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_page_break_inside VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_orfans VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_windows VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_cursor VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_direction VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_unicode_bidi VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    created_date datetime NOT NULL,
                    unix_created_date VARCHAR(30) NOT NULL,
                    UNIQUE KEY id (id)
                );";

                // container_wdh_path - new full path after is moved
                // resolution : 240,  320, 480, 568, 768, 1024, 1280, all
                // position_before_element - set position before x element - for sortable
                // position_inside_of_element - set position inside of x element - for draggable
                // used_for : current_page , website
                // html_tag : div , p , span ... 
                // CSS properties : text_ , color_ , background_ , box , box_margin_ , box_padding_ ,
                //                  box_border_ , position_ , display_, list_ , table_, content_,
                //                  paged_, misc_ 
                // Hover CSS properties : h_text_ , h_color_ , h_background_ , h_box , h_box_margin_ , h_box_padding_ ,
                //                  h_box_border_ , h_position_ , h_display_, h_list_ , h_table_, h_content_,
                //                  h_paged_, h_misc_
                // http://www.htmldog.com/reference/cssproperties/

                // Temporary CSS Table
                // -----------------------------------------------------------------
                $css_temp = "CREATE TABLE ".WDHSVWE_Temporary_CSS_table." (
                    id bigint NOT NULL AUTO_INCREMENT,
                    uid bigint NOT NULL,
                    wid bigint NOT NULL,
                    container_full_path TEXT COLLATE utf8_unicode_ci NOT NULL,
                    container_wdh_path TEXT COLLATE utf8_unicode_ci NOT NULL,
                    container_classes TEXT COLLATE utf8_unicode_ci NOT NULL,
                    container_id VARCHAR(128) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    element_tag VARCHAR(25) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    element_position int NOT NULL,
                    element_position_changed int NOT NULL,
                    resolution VARCHAR(5) DEFAULT 'all' COLLATE utf8_unicode_ci NOT NULL,
                    position_before_element TEXT COLLATE utf8_unicode_ci NOT NULL,
                    position_inside_of_element TEXT COLLATE utf8_unicode_ci NOT NULL,
                    session VARCHAR(256) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    used_for VARCHAR(20) DEFAULT 'current_page' COLLATE utf8_unicode_ci NOT NULL,
                    html_tag VARCHAR(20) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    page_url VARCHAR(256) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    page_on VARCHAR(12) DEFAULT 'wpsite' COLLATE utf8_unicode_ci NOT NULL,
                    role VARCHAR(32) DEFAULT 'all' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_family VARCHAR(131) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_size VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_weight VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_style VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_variant VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_line_height VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_letter_spacing VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_word_spacing VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_align VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_decoration VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_indent VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_transform VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_vertical_align VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_font_white_space VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    text_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_color VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background VARCHAR(43) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_size VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_image VARCHAR(43) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_repeat VARCHAR(14) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_position_x VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_position_y VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_background_attachment VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_padding_top VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_padding_bottom VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_padding_right VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_padding_left VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_margin_top VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_margin_bottom VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_margin_right VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_margin_left VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_top VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_bottom VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_right VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_left VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_style VARCHAR(35) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_top_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_bottom_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_right_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_left_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_top_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_bottom_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_right_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_left_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_top_left_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_top_right_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_bottom_left_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_bottom_right_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_outline VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_outline_color VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_outline_width VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_outline_style VARCHAR(20) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_min_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_max_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_min_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_max_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_position VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_top VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_bottom VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_right VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_left VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_clip VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_overflow VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_z_index VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_float VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_clear VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_display VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_visibility VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_list_style VARCHAR(256) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_list_style_type VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_list_style_position VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_list_style_image VARCHAR(33) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_table_layout VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_collapse VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_border_spacing VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_caption_side VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_content VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_counter_increment VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_page_break_before VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_page_break_after VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_page_break_inside VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_orfans VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_windows VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_cursor VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_direction VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    box_unicode_bidi VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_family VARCHAR(131) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_size VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_weight VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_style VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_variant VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_line_height VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_letter_spacing VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_word_spacing VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_align VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_decoration VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_indent VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_transform VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_vertical_align VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_font_white_space VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_text_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_color VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background VARCHAR(43) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_size VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_image VARCHAR(43) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_repeat VARCHAR(14) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_position_x VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_position_y VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_background_attachment VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_padding_top VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_padding_bottom VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_padding_right VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_padding_left VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_margin_top VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_margin_bottom VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_margin_right VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_margin_left VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_top VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_bottom VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_right VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_left VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_style VARCHAR(35) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_top_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_bottom_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_right_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_left_style VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_top_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_bottom_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_right_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_left_color VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_top_left_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_top_right_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_bottom_left_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_bottom_right_radius VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_outline VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_outline_color VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_outline_width VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_outline_style VARCHAR(20) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_min_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_max_width VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_min_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_max_height VARCHAR(11) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_position VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_top VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_bottom VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_right VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_left VARCHAR(12) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_clip VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_overflow VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_z_index VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_float VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_clear VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_display VARCHAR(23) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_visibility VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_list_style VARCHAR(256) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_list_style_type VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_list_style_position VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_list_style_image VARCHAR(33) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_table_layout VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_collapse VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_border_spacing VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_caption_side VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_content VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_counter_increment VARCHAR(18) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_page_break_before VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_page_break_after VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_page_break_inside VARCHAR(10) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_orfans VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_windows VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_cursor VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_direction VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    h_box_unicode_bidi VARCHAR(13) DEFAULT '' COLLATE utf8_unicode_ci NOT NULL,
                    UNIQUE KEY id (id)
                );";

                dbDelta($generalSettings);
                dbDelta($settings);
                dbDelta($history);
                dbDelta($css);
                dbDelta($css_temp);
                
                // Creating files directory
                mkdir(WP_CONTENT_DIR.'/wdhsvwe/',0775);
                // Creating CSS directory
                mkdir(WP_CONTENT_DIR.'/wdhsvwe/css/',0775);

                // Move Uploads Directory
                $this->moveFiles(WDHSVWE_Path.'wdhedfp/uploads/', WP_CONTENT_DIR.'/wdhsvwe/uploads/');

                if ($db_version != $wdhSVWE["version"]){

                   if ($db_version == "") {
                        add_option('WDH_SVWE_db_version', $wdhSVWE["version"]);
                    }
                    else{
                        update_option('WDH_SVWE_db_version', $wdhSVWE["version"]);
                    }
                    
                    $this->settingsAdd();
                }
            }
        }
        
        function moveFiles($from, $to){
            mkdir($to,0775);
            rename($from, $to);
        }
        
        function clearPageUrl($page){
            $page = str_replace('?wdhResolution=320','',$page);
            $page = str_replace('?wdhResolution=480','',$page);
            $page = str_replace('?wdhResolution=568','',$page);
            $page = str_replace('?wdhResolution=768','',$page);
            $page = str_replace('?wdhResolution=1024','',$page);
            $page = str_replace('?wdhResolution=1280','',$page);
            $page = str_replace('&wdhResolution=320','',$page);
            $page = str_replace('&wdhResolution=480','',$page);
            $page = str_replace('&wdhResolution=568','',$page);
            $page = str_replace('&wdhResolution=768','',$page);
            $page = str_replace('&wdhResolution=1024','',$page);
            $page = str_replace('&wdhResolution=1280','',$page);
            
            return $page;
        }
        
        function settingsAdd(){
            global $wdhSVWE, $wpdb;
            $wid        = $wdhSVWE['WEBSITE_ID'];
            
            // Adding General Settings
            $dateCreated = date('Y-m-d');
            $timeCreated = date('H:i:s');
            $dateTimeCreated = $dateCreated.' '.$timeCreated;
            list($hours, $minutes, $seconds) = explode(':', $timeCreated);
            $dateTime = \DateTime::createFromFormat('Y-m-d', $dateCreated)->setTime($hours, $minutes, $seconds); // \DateTime::createFromFormat('Y-m-d', $dateCreated)->setTime($hours, $minutes, $seconds);
            $unixDateCreated = $dateTime->getTimestamp();

            $settingsGeneralCSS   = "SELECT * FROM ".WDHSVWE_General_Settings_table;
            $row                  = $wpdb->get_row($settingsGeneralCSS, ARRAY_A);
            
            if ($wpdb->num_rows < 1) {
                // INSERT General Setiings
                $insertGeneralSettings = "INSERT INTO `".WDHSVWE_General_Settings_table."` (version,last_update_time,unix_last_update_time) VALUES('".$wdhSVWE['version']."','".$dateTimeCreated."','".$unixDateCreated."')";
                $wpdb->query($insertGeneralSettings);
            }

            // Adding wpsite & all Settings
            $settingsCSS   = "SELECT * FROM ".WDHSVWE_Settings_table." where wid='".$wid."' AND page_on='wpsite' AND role='all'";
            $row           = $wpdb->get_row($settingsCSS, ARRAY_A);

            if ($wpdb->num_rows < 1) {
                $insertSettings = "INSERT INTO `".WDHSVWE_Settings_table."` (wid,roll_back,used_for,page_on,role) VALUES('".$wid."','latest','website','wpsite','all')";
                $wpdb->query($insertSettings);
            }

            // Adding wpsite & all Settings
            $settingsCSS   = "SELECT * FROM ".WDHSVWE_Settings_table." where wid='".$wid."' AND page_on='wpadmin' AND role='all'";
            $row           = $wpdb->get_row($settingsCSS, ARRAY_A);

            if ($wpdb->num_rows < 1) {
                $insertSettings = "INSERT INTO `".WDHSVWE_Settings_table."` (wid,roll_back,used_for,page_on,role) VALUES('".$wid."','latest','website','wpadmin','all')";
                $wpdb->query($insertSettings);
            }

            $roles = explode(',',$wdhSVWE["WDH_DEFAULT_DESIGN_CREATE_FOR_ROLES"]);
            
            foreach($roles as $role){
                // Adding wpsite & all Settings
                $settingsCSS   = "SELECT * FROM ".WDHSVWE_Settings_table." where wid='".$wid."' AND page_on='wpsite' AND role='".$role."'";
                $row           = $wpdb->get_row($settingsCSS, ARRAY_A);

                if ($wpdb->num_rows < 1) {
                    $insertSettings = "INSERT INTO `".WDHSVWE_Settings_table."` (wid,roll_back,used_for,page_on,role) VALUES('".$wid."','latest','website','wpsite','".$role."')";
                    $wpdb->query($insertSettings);
                }

                // Adding wpsite & all Settings
                $settingsCSS   = "SELECT * FROM ".WDHSVWE_Settings_table." where wid='".$wid."' AND page_on='wpadmin' AND role='".$role."'";
                $row           = $wpdb->get_row($settingsCSS, ARRAY_A);

                if ($wpdb->num_rows < 1) {
                    $insertSettings = "INSERT INTO `".WDHSVWE_Settings_table."` (wid,roll_back,used_for,page_on,role) VALUES('".$wid."','latest','website','wpadmin','".$role."')";
                    $wpdb->query($insertSettings);
                }
            }
        }
        
        
        /*
         * Paste Design
         */
        function pasteDesign(){
            global $wdhSVWE, $wpdb;
            
            $wid                = $wdhSVWE['WEBSITE_ID'];
            $domPath            = sanitize_text_field($_POST['domPath']);
            $wdhPath            = sanitize_text_field($_POST['wdhPath']);
            $wdhClass           = sanitize_text_field($_POST['wdhClass']);
            $wdhID              = sanitize_text_field($_POST['wdhID']);
            $elementTag         = sanitize_text_field($_POST['elementTag']);
            $elementPosition    = sanitize_text_field($_POST['elementPosition']);
            $resolution         = sanitize_text_field($_POST['resolution']);
            $wdhPageUrl         = sanitize_text_field($this->clearPageUrl($_POST['wdhPageUrl']));
            $wdhSVWE['page_on'] = sanitize_text_field($_POST['wdhPageOn']);
            $wdhPageOn          = $wdhSVWE['page_on'];
            $wdhSVWE['role']    = sanitize_text_field($_POST['wdhRole']);
            $wdhRole            = $wdhSVWE['role'];
            
            if(isset($_POST['wdhAllCSS'])) {
                $wdhAllCSS          = sanitize_text_field(json_encode($_POST['wdhAllCSS']));
                $wdhAllCSS          = (object)json_decode($wdhAllCSS);
                $fieldsAll          = '';
                $color              = '';
                $bgcolor            = '';
                $border             = '';
                $borderColor        = '';
                $outline            = '';
                $outlineColor       = '';
                $borderTop          = '';
                $borderBottom       = '';
                $borderLeft         = '';
                $borderRight        = '';
                $borderTopColor     = '';
                $borderBottomColor  = '';
                $borderLeftColor    = '';
                $borderRightColor   = '';

                $checkCondition = "WHERE wid='".$wid."' AND container_full_path ='".$domPath."' AND container_wdh_path ='".$wdhPath."' AND container_classes ='".$wdhClass."' AND container_id ='".$wdhID."' AND element_tag ='".$elementTag."' AND element_position ='".$elementPosition."' AND resolution ='".$resolution."' AND page_url ='".$wdhPageUrl."' AND page_on ='".$wdhPageOn."' AND role ='".$wdhRole."'";
                $checkElement = "SELECT * FROM `".WDHSVWE_Temporary_CSS_table."` ".$checkCondition;

                if(isset($wdhAllCSS->color)) {
                    $color = str_replace('rgb(', '',$wdhAllCSS->color);
                    $color = str_replace(')', '',$color);
                    $color = str_replace(' ', '',$color);
                    $color = explode(',', $color);
                    $color = $this->rgbToHex($color);
                }

                if(isset($wdhAllCSS->BackgroundColor)) {
                    $bgcolor = str_replace('rgb(', '',$wdhAllCSS->BackgroundColor);
                    $bgcolor = str_replace(')', '',$bgcolor);
                    $bgcolor = str_replace(' ', '',$bgcolor);
                    $bgcolor = explode(',', $bgcolor);

                    if (isset($bgcolor[3])) {
                        $bgcolor = '';
                    } else {
                        $bgcolor = $this->rgbToHex($bgcolor);
                    }
                }

                if(isset($wdhAllCSS->Border)) {
                    $border = explode(' rgb', $wdhAllCSS->Border);
                }

                if(isset($wdhAllCSS->BorderColor)) {
                    $borderColor = str_replace('rgb(', '',$wdhAllCSS->BorderColor);
                    $borderColor = str_replace(')', '',$borderColor);
                    $borderColor = str_replace(' ', '',$borderColor);
                    $borderColor = explode(',', $borderColor);
                    $borderColor = $this->rgbToHex($borderColor);
                }

                if(isset($wdhAllCSS->Outline)) {
                    $outline = explode(') ', $wdhAllCSS->Outline);
                }

                if(isset($wdhAllCSS->OutlineColor)) {
                    $outlineColor = str_replace('rgb(', '',$wdhAllCSS->OutlineColor);
                    $outlineColor = str_replace(')', '',$outlineColor);
                    $outlineColor = str_replace(' ', '',$outlineColor);
                    $outlineColor = explode(',', $outlineColor);
                    $outlineColor = $this->rgbToHex($outlineColor);
                }

                if(isset($wdhAllCSS->OutlineColor)) {
                    $borderTop = explode(' rgb', $wdhAllCSS->BorderTop);
                }

                if(isset($wdhAllCSS->BorderBottom)) {
                    $borderBottom = explode(' rgb', $wdhAllCSS->BorderBottom);
                }

                if(isset($wdhAllCSS->BorderLeft)) {
                    $borderLeft = explode(' rgb', $wdhAllCSS->BorderLeft);
                }

                if(isset($wdhAllCSS->BorderRight)) {
                    $borderRight = explode(' rgb', $wdhAllCSS->BorderRight);
                }

                if(isset($wdhAllCSS->BorderTopColor)) {
                    $borderTopColor = str_replace('rgb(', '',$wdhAllCSS->BorderTopColor);
                    $borderTopColor = str_replace(')', '',$borderTopColor);
                    $borderTopColor = str_replace(' ', '',$borderTopColor);
                    $borderTopColor = explode(',', $borderTopColor);
                    $borderTopColor = $this->rgbToHex($borderTopColor);
                }

                if(isset($wdhAllCSS->BorderBottomColor)) {
                    $borderBottomColor = str_replace('rgb(', '',$wdhAllCSS->BorderBottomColor);
                    $borderBottomColor = str_replace(')', '',$borderBottomColor);
                    $borderBottomColor = str_replace(' ', '',$borderBottomColor);
                    $borderBottomColor = explode(',', $borderBottomColor);
                    $borderBottomColor = $this->rgbToHex($borderBottomColor);
                }

                if(isset($wdhAllCSS->BorderLeftColor)) {
                    $borderLeftColor = str_replace('rgb(', '',$wdhAllCSS->BorderLeftColor);
                    $borderLeftColor = str_replace(')', '',$borderLeftColor);
                    $borderLeftColor = str_replace(' ', '',$borderLeftColor);
                    $borderLeftColor = explode(',', $borderLeftColor);
                    $borderLeftColor = $this->rgbToHex($borderLeftColor);
                }

                if(isset($wdhAllCSS->BorderRightColor)) {
                    $borderRightColor = str_replace('rgb(', '',$wdhAllCSS->BorderRightColor);
                    $borderRightColor = str_replace(')', '',$borderRightColor);
                    $borderRightColor = str_replace(' ', '',$borderRightColor);
                    $borderRightColor = explode(',', $borderRightColor);
                    $borderRightColor = $this->rgbToHex($borderRightColor);
                }

                if(isset($wdhAllCSS->LineHeight) && isset($wdhAllCSS->fontSize)) {

                    if($wdhAllCSS->LineHeight == 'normal') {
                        $modLH = (intval($wdhAllCSS->fontSize)+2);
                        $modLH = $modLH.'px';
                    }
                }

                $ElementCheck = $wpdb->get_row($checkElement);

                if ($wpdb->num_rows > 0){
                    $fieldsAll .= "text_color='m@@".$color."',";
                    $fieldsAll .= "text_font_size='m@@".$wdhAllCSS->fontSize."',";
                    $fieldsAll .= "text_font_family='m@@".$wdhAllCSS->fontFamily."',";
                    $fieldsAll .= "text_font_weight='m@@".$wdhAllCSS->fontWeight."',";
                    $fieldsAll .= "text_font_style='m@@".$wdhAllCSS->fontStyle."',";
                    $fieldsAll .= "text_font_variant='m@@".$wdhAllCSS->fontVariant."',";
                    $fieldsAll .= "text_font_line_height='m@@".$wdhAllCSS->LineHeight."',";
                    $fieldsAll .= "text_font_align='m@@".$wdhAllCSS->FontAlign."',";
                    $fieldsAll .= "text_font_decoration='m@@".$wdhAllCSS->TextDecoration."',";
                    $fieldsAll .= "text_font_transform='m@@".$wdhAllCSS->TextTransform."',";
                    $fieldsAll .= "text_font_letter_spacing='m@@".$wdhAllCSS->LetterSpacing."',";
                    $fieldsAll .= "text_font_word_spacing='m@@".$wdhAllCSS->WordSpacing."',";
                    $fieldsAll .= "text_font_vertical_align='m@@".$wdhAllCSS->VerticalAlign."',";
                    $fieldsAll .= "text_font_white_space='m@@".$wdhAllCSS->WhiteSpace."',";
                    $fieldsAll .= "box_background_color='m@@".$bgcolor."',";
                    $fieldsAll .= "box_width='m@@".$wdhAllCSS->Width."',";
                    $fieldsAll .= "box_height='m@@".$wdhAllCSS->Height."',";
                    $fieldsAll .= "box_background_image='m@@".$wdhAllCSS->BackgroundImage."',";
                    $fieldsAll .= "box_background_size='m@@".$wdhAllCSS->BackgroundSize."',";
                    $fieldsAll .= "box_background_position_x='m@@".$wdhAllCSS->BackgroundPositionX."',";
                    $fieldsAll .= "box_background_position_y='m@@".$wdhAllCSS->BackgroundPositionY."',";
                    $fieldsAll .= "box_background_repeat='m@@".$wdhAllCSS->BackgroundRepeat."',";
                    $fieldsAll .= "box_padding_top='m@@".$wdhAllCSS->PaddingTop."',";
                    $fieldsAll .= "box_padding_bottom='m@@".$wdhAllCSS->PaddingBottom."',";
                    $fieldsAll .= "box_padding_left='m@@".$wdhAllCSS->PaddingLeft."',";
                    $fieldsAll .= "box_padding_right='m@@".$wdhAllCSS->PaddingRight."',";
                    $fieldsAll .= "box_margin_top='m@@".$wdhAllCSS->MarginTop."',";
                    $fieldsAll .= "box_margin_bottom='m@@".$wdhAllCSS->MarginBottom."',";
                    $fieldsAll .= "box_margin_left='m@@".$wdhAllCSS->MarginLeft."',";
                    $fieldsAll .= "box_margin_right='m@@".$wdhAllCSS->MarginRight."',";
                    $fieldsAll .= "box_border='m@@".$border[0]."',";
                    $fieldsAll .= "box_border_color='m@@".$borderColor."',";
                    $fieldsAll .= "box_border_radius='m@@".$wdhAllCSS->BorderRadius."',";
                    $fieldsAll .= "box_outline='m@@".$outline[1]."',";
                    $fieldsAll .= "box_outline_color='m@@".$outlineColor."',";
                    $fieldsAll .= "box_position='m@@".$outlineColor."',";
                    $fieldsAll .= "box_top='m@@".$wdhAllCSS->Top."',";
                    $fieldsAll .= "box_bottom='m@@".$wdhAllCSS->Bottom."',";
                    $fieldsAll .= "box_left='m@@".$wdhAllCSS->Left."',";
                    $fieldsAll .= "box_right='m@@".$wdhAllCSS->Right."',";
                    $fieldsAll .= "box_overflow='m@@".$wdhAllCSS->Overflow."',";
                    $fieldsAll .= "box_z_index='m@@".$wdhAllCSS->ZIndex."',";
                    $fieldsAll .= "box_float='m@@".$wdhAllCSS->Float."',";
                    $fieldsAll .= "box_clear='m@@".$wdhAllCSS->Clear."',";
                    $fieldsAll .= "box_display='m@@".$wdhAllCSS->Display."',";
                    $fieldsAll .= "box_visibility='m@@".$wdhAllCSS->Visibility."',";
                    $fieldsAll .= "box_border_collapse='m@@".$wdhAllCSS->BorderCollapse."',";
                    $fieldsAll .= "box_caption_side='m@@".$wdhAllCSS->CaptionSide."',";
                    $fieldsAll .= "box_content='m@@".$wdhAllCSS->Content."',";
                    $fieldsAll .= "box_page_break_before='m@@".$wdhAllCSS->PageBreakBefore."',";
                    $fieldsAll .= "box_page_break_after='m@@".$wdhAllCSS->PageBreakAfter."',";
                    $fieldsAll .= "box_page_break_inside='m@@".$wdhAllCSS->PageBreakInside."',";
                    $fieldsAll .= "box_orfans='m@@".$wdhAllCSS->Orfans."',";
                    $fieldsAll .= "box_windows='m@@".$wdhAllCSS->Windows."',";
                    $fieldsAll .= "box_cursor='m@@".$wdhAllCSS->Cursor."',";
                    $fieldsAll .= "box_direction='m@@".$wdhAllCSS->Direction."',";
                    $fieldsAll .= "box_border_top='m@@".$borderTop[0]."',";
                    $fieldsAll .= "box_border_bottom='m@@".$borderBottom[0]."',";
                    $fieldsAll .= "box_border_left='m@@".$borderLeft[0]."',";
                    $fieldsAll .= "box_border_right='m@@".$borderRight[0]."',";
                    $fieldsAll .= "box_border_top_color='m@@".$borderTopColor."',";
                    $fieldsAll .= "box_border_bottom_color='m@@".$borderBottomColor."',";
                    $fieldsAll .= "box_border_left_color='m@@".$borderLeftColor."',";
                    $fieldsAll .= "box_border_right_color='m@@".$borderRightColor."',";
                    $fieldsAll .= "box_border_top_left_radius='m@@".$wdhAllCSS->BorderTopLeftRadius."',";
                    $fieldsAll .= "box_border_bottom_left_radius='m@@".$wdhAllCSS->BorderBottomLeftRadius."',";
                    $fieldsAll .= "box_border_top_right_radius='m@@".$wdhAllCSS->BorderTopRightRadius."',";
                    $fieldsAll .= "box_border_bottom_right_radius='m@@".$wdhAllCSS->BorderBottomRightRadius."',";
                    $fieldsAll .= "box_min_width='m@@".$wdhAllCSS->MinWidth."',";
                    $fieldsAll .= "box_max_width='m@@".$wdhAllCSS->MaxWidth."',";
                    $fieldsAll .= "box_min_height='m@@".$wdhAllCSS->MinHeight."',";
                    $fieldsAll .= "box_max_height='m@@".$wdhAllCSS->MaxHeight."',";
                    $fieldsAll .= "box_list_style_type='m@@".$wdhAllCSS->ListStyleType."',";
                    $fieldsAll .= "box_list_style_position='m@@".$wdhAllCSS->ListStylePosition."'";

                    // UPDATE
                    $updateElement = "UPDATE `".WDHSVWE_Temporary_CSS_table."` SET ".$fieldsAll." ".$checkCondition;
                    $wpdb->query($updateElement);
                } else {
                    $fieldsAll .= "(wid,container_full_path,container_wdh_path,container_classes,container_id,element_tag,element_position,resolution,page_url,page_on,role,text_color,text_font_size,text_font_family,text_font_weight,text_font_style,text_font_variant,text_font_line_height,text_font_align,text_font_decoration,text_font_transform,text_font_letter_spacing,text_font_word_spacing,text_font_vertical_align,text_font_white_space,box_background_color,box_width,box_height,box_background_image,box_background_size,box_background_position_x,box_background_position_y,box_background_repeat,box_padding_top,box_padding_bottom,box_padding_left,box_padding_right,box_margin_top,box_margin_bottom,box_margin_left,box_margin_right,box_border,box_border_color,box_border_radius,box_outline,box_outline_color,box_position,box_top,box_bottom,box_left,box_right,box_overflow,box_z_index,box_float,box_clear,box_display,box_visibility,box_border_collapse,box_caption_side,box_content,box_page_break_before,box_page_break_after,box_page_break_inside,box_orfans,box_windows,box_cursor,box_direction,box_border_top,box_border_bottom,box_border_left,box_border_right,box_border_top_color,box_border_bottom_color,box_border_left_color,box_border_right_color,box_border_top_left_radius,box_border_bottom_left_radius,box_border_top_right_radius,box_border_bottom_right_radius,box_min_width,box_max_width,box_min_height,box_max_height,box_list_style_type,box_list_style_position) VALUES(";
                    $fieldsAll .= "'".$wid."','".$domPath."','".$wdhPath."','".$wdhClass."','".$wdhID."','".$elementTag."','".$elementPosition."','".$resolution."','".$wdhPageUrl."','".$wdhPageOn."','".$wdhRole."',";
                    $fieldsAll .= "'m@@".$color."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->fontSize."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->fontFamily."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->fontWeight."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->fontStyle."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->fontVariant."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->LineHeight."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->FontAlign."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->TextDecoration."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->TextTransform."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->LetterSpacing."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->WordSpacing."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->VerticalAlign."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->WhiteSpace."',";
                    $fieldsAll .= "'m@@".$bgcolor."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Width."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Height."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->BackgroundImage."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->BackgroundSize."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->BackgroundPositionX."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->BackgroundPositionY."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->BackgroundRepeat."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->PaddingTop."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->PaddingBottom."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->PaddingLeft."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->PaddingRight."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->MarginTop."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->MarginBottom."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->MarginLeft."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->MarginRight."',";
                    $fieldsAll .= "'m@@".$border[0]."',";
                    $fieldsAll .= "'m@@".$borderColor."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->BorderRadius."',";
                    $fieldsAll .= "'m@@".$outline[1]."',";
                    $fieldsAll .= "'m@@".$outlineColor."',";
                    $fieldsAll .= "'m@@".$outlineColor."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Top."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Bottom."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Left."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Right."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Overflow."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->ZIndex."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Float."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Clear."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Display."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Visibility."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->BorderCollapse."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->CaptionSide."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Content."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->PageBreakBefore."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->PageBreakAfter."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->PageBreakInside."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Orfans."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Windows."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Cursor."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->Direction."',";
                    $fieldsAll .= "'m@@".$borderTop[0]."',";
                    $fieldsAll .= "'m@@".$borderBottom[0]."',";
                    $fieldsAll .= "'m@@".$borderLeft[0]."',";
                    $fieldsAll .= "'m@@".$borderRight[0]."',";
                    $fieldsAll .= "'m@@".$borderTopColor."',";
                    $fieldsAll .= "'m@@".$borderBottomColor."',";
                    $fieldsAll .= "'m@@".$borderLeftColor."',";
                    $fieldsAll .= "'m@@".$borderRightColor."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->BorderTopLeftRadius."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->BorderBottomLeftRadius."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->BorderTopRightRadius."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->BorderBottomRightRadius."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->MinWidth."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->MaxWidth."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->MinHeight."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->MaxHeight."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->ListStyleType."',";
                    $fieldsAll .= "'m@@".$wdhAllCSS->ListStylePosition."')";

                    // INSERT
                    $insertElement = "INSERT INTO `".WDHSVWE_Temporary_CSS_table."` ".$fieldsAll;
                    $wpdb->query($insertElement);
                }
            }
            echo 'success'; die();
        }
        
        /*
         * Publish Design
         */
        function publish(){
            // Update Database
            global $wdhSVWE, $wdhSVWE_CSS, $wpdb;
            $wid                = $wdhSVWE['WEBSITE_ID'];
            $wdhPageUrl         = sanitize_text_field($this->clearPageUrl($_POST['wdhPageUrl']));
            $wdhSVWE['page_on'] = sanitize_text_field($_POST['wdhPageOn']);
            $wdhPageOn          = $wdhSVWE['page_on'];
            $wdhSVWE['role']    = sanitize_text_field($_POST['wdhRole']);
            $wdhRole            = $wdhSVWE['role'];
            $wdhPublishFor      = sanitize_text_field($_POST['wdhPublishFor']);
            $allCSSTemp         = "SELECT * FROM `".WDHSVWE_Temporary_CSS_table."`";
            $result_all         = $wpdb->get_results($allCSSTemp);
            $added              = 0;
            $dateCreated        = date('Y-m-d');
            $timeCreated        = date('H:i:s');
            $fieldsAll          = '';
            $dateTimeCreated = $dateCreated.' '.$timeCreated;
            list($hours, $minutes, $seconds) = explode(':', $timeCreated);
            $dateTime = \DateTime::createFromFormat('Y-m-d', $dateCreated)->setTime($hours, $minutes, $seconds); // \DateTime::createFromFormat('Y-m-d', $dateCreated)->setTime($hours, $minutes, $seconds);
            $unixDateCreated = $dateTime->getTimestamp();

            // UPDATE/INSERT All CSS PROPERTIES
            // ---------------------------------------------------------
            foreach ($result_all as $rowAll) {
                $rowAll = (array)$rowAll;
                $domPath = $rowAll['container_full_path'];
                $wdhPath = $rowAll['container_wdh_path'];
                $wdhClass = $rowAll['container_classes'];
                $wdhID = $rowAll['container_id'];
                $elementTag = $rowAll['element_tag'];
                $elementPosition = $rowAll['element_position'];
                $resolution = $rowAll['resolution'];
                $wdhPageUrl = sanitize_text_field($this->clearPageUrl($_POST['wdhPageUrl']));
                $checkCondition = "WHERE wid='".$wid."' AND used_for='".$wdhPublishFor."' AND container_full_path ='".$domPath."' AND container_wdh_path ='".$wdhPath."' AND container_classes ='".$wdhClass."' AND container_id ='".$wdhID."' AND element_tag ='".$elementTag."' AND element_position ='".$elementPosition."' AND resolution ='".$resolution."' AND page_url ='".$wdhPageUrl."' AND page_on ='".$wdhPageOn."' AND role ='".$wdhRole."'";
                $checkElement = "SELECT * FROM `".WDHSVWE_CSS_table."` ".$checkCondition;
                $checkElement = $wpdb->get_row($checkElement);
                
                if ($wpdb->num_rows > 0){
                    $fieldsAll .= "used_for='".$wdhPublishFor."',";
                    
                    $checkElement = (array)$checkElement;
                    
                    if(strpos($rowAll['text_color'],'m@@') === false){
                        $rowAll['text_color'] = $checkElement['text_color'];
                    }
                    $fieldsAll .= "text_color='".$rowAll['text_color']."',";
                    
                    if(strpos($rowAll['text_font_size'],'m@@') === false){
                        $rowAll['text_font_size'] = $checkElement['text_font_size'];
                    }
                    $fieldsAll .= "text_font_size='".$rowAll['text_font_size']."',";
                    
                    if(strpos($rowAll['text_font_family'],'m@@') === false){
                        $rowAll['text_font_family'] = $checkElement['text_font_family'];
                    }
                    $fieldsAll .= "text_font_family='".$rowAll['text_font_family']."',";
                    
                    if(strpos($rowAll['text_font_weight'],'m@@') === false){
                        $rowAll['text_font_weight'] = $checkElement['text_font_weight'];
                    }
                    $fieldsAll .= "text_font_weight='".$rowAll['text_font_weight']."',";
                    
                    if(strpos($rowAll['text_font_style'],'m@@') === false){
                        $rowAll['text_font_style'] = $checkElement['text_font_style'];
                    }
                    $fieldsAll .= "text_font_style='".$rowAll['text_font_style']."',";
                    
                    if(strpos($rowAll['text_font_variant'],'m@@') === false){
                        $rowAll['text_font_variant'] = $checkElement['text_font_variant'];
                    }
                    $fieldsAll .= "text_font_variant='".$rowAll['text_font_variant']."',";
                    
                    if(strpos($rowAll['text_font_line_height'],'m@@') === false){
                        $rowAll['text_font_line_height'] = $checkElement['text_font_line_height'];
                    }
                    $fieldsAll .= "text_font_line_height='".$rowAll['text_font_line_height']."',";
                    
                    if(strpos($rowAll['text_font_align'],'m@@') === false){
                        $rowAll['text_font_align'] = $checkElement['text_font_align'];
                    }
                    $fieldsAll .= "text_font_align='".$rowAll['text_font_align']."',";
                    
                    if(strpos($rowAll['text_font_decoration'],'m@@') === false){
                        $rowAll['text_font_decoration'] = $checkElement['text_font_decoration'];
                    }
                    $fieldsAll .= "text_font_decoration='".$rowAll['text_font_decoration']."',";
                    
                    if(strpos($rowAll['text_font_transform'],'m@@') === false){
                        $rowAll['text_font_transform'] = $checkElement['text_font_transform'];
                    }
                    $fieldsAll .= "text_font_transform='".$rowAll['text_font_transform']."',";
                    
                    if(strpos($rowAll['text_font_letter_spacing'],'m@@') === false){
                        $rowAll['text_font_letter_spacing'] = $checkElement['text_font_letter_spacing'];
                    }
                    $fieldsAll .= "text_font_letter_spacing='".$rowAll['text_font_letter_spacing']."',";
                    
                    if(strpos($rowAll['text_font_word_spacing'],'m@@') === false){
                        $rowAll['text_font_word_spacing'] = $checkElement['text_font_word_spacing'];
                    }
                    $fieldsAll .= "text_font_word_spacing='".$rowAll['text_font_word_spacing']."',";
                    
                    if(strpos($rowAll['text_font_vertical_align'],'m@@') === false){
                        $rowAll['text_font_vertical_align'] = $checkElement['text_font_vertical_align'];
                    }
                    $fieldsAll .= "text_font_vertical_align='".$rowAll['text_font_vertical_align']."',";
                    
                    if(strpos($rowAll['text_font_white_space'],'m@@') === false){
                        $rowAll['text_font_white_space'] = $checkElement['text_font_white_space'];
                    }
                    $fieldsAll .= "text_font_white_space='".$rowAll['text_font_white_space']."',";
                    
                    if(strpos($rowAll['box_background_color'],'m@@') === false){
                        $rowAll['box_background_color'] = $checkElement['box_background_color'];
                    }
                    $fieldsAll .= "box_background_color='".$rowAll['box_background_color']."',";
                    
                    if(strpos($rowAll['box_width'],'m@@') === false){
                        $rowAll['box_width'] = $checkElement['box_width'];
                    }
                    $fieldsAll .= "box_width='".$rowAll['box_width']."',";
                    
                    if(strpos($rowAll['box_height'],'m@@') === false){
                        $rowAll['box_height'] = $checkElement['box_height'];
                    }
                    $fieldsAll .= "box_height='".$rowAll['box_height']."',";
                    
                    if(strpos($rowAll['box_background_image'],'m@@') === false){
                        $rowAll['box_background_image'] = $checkElement['box_background_image'];
                    }
                    $fieldsAll .= "box_background_image='".$rowAll['box_background_image']."',";
                    
                    if(strpos($rowAll['box_background_size'],'m@@') === false){
                        $rowAll['box_background_size'] = $checkElement['box_background_size'];
                    }
                    $fieldsAll .= "box_background_size='".$rowAll['box_background_size']."',";
                    
                    if(strpos($rowAll['box_background_position_x'],'m@@') === false){
                        $rowAll['box_background_position_x'] = $checkElement['box_background_position_x'];
                    }
                    $fieldsAll .= "box_background_position_x='".$rowAll['box_background_position_x']."',";
                    
                    if(strpos($rowAll['box_background_position_y'],'m@@') === false){
                        $rowAll['box_background_position_y'] = $checkElement['box_background_position_y'];
                    }
                    $fieldsAll .= "box_background_position_y='".$rowAll['box_background_position_y']."',";
                    
                    if(strpos($rowAll['box_background_repeat'],'m@@') === false){
                        $rowAll['box_background_repeat'] = $checkElement['box_background_repeat'];
                    }
                    $fieldsAll .= "box_background_repeat='".$rowAll['box_background_repeat']."',";
                    
                    if(strpos($rowAll['box_padding_top'],'m@@') === false){
                        $rowAll['box_padding_top'] = $checkElement['box_padding_top'];
                    }
                    $fieldsAll .= "box_padding_top='".$rowAll['box_padding_top']."',";
                    
                    if(strpos($rowAll['box_padding_bottom'],'m@@') === false){
                        $rowAll['box_padding_bottom'] = $checkElement['box_padding_bottom'];
                    }
                    $fieldsAll .= "box_padding_bottom='".$rowAll['box_padding_bottom']."',";
                    
                    if(strpos($rowAll['box_padding_left'],'m@@') === false){
                        $rowAll['box_padding_left'] = $checkElement['box_padding_left'];
                    }
                    $fieldsAll .= "box_padding_left='".$rowAll['box_padding_left']."',";
                    
                    if(strpos($rowAll['box_padding_right'],'m@@') === false){
                        $rowAll['box_padding_right'] = $checkElement['box_padding_right'];
                    }
                    $fieldsAll .= "box_padding_right='".$rowAll['box_padding_right']."',";
                    
                    if(strpos($rowAll['box_margin_top'],'m@@') === false){
                        $rowAll['box_margin_top'] = $checkElement['box_margin_top'];
                    }
                    $fieldsAll .= "box_margin_top='".$rowAll['box_margin_top']."',";
                    
                    if(strpos($rowAll['box_margin_bottom'],'m@@') === false){
                        $rowAll['box_margin_bottom'] = $checkElement['box_margin_bottom'];
                    }
                    $fieldsAll .= "box_margin_bottom='".$rowAll['box_margin_bottom']."',";
                    
                    if(strpos($rowAll['box_margin_left'],'m@@') === false){
                        $rowAll['box_margin_left'] = $checkElement['box_margin_left'];
                    }
                    $fieldsAll .= "box_margin_left='".$rowAll['box_margin_left']."',";
                    
                    if(strpos($rowAll['box_margin_right'],'m@@') === false){
                        $rowAll['box_margin_right'] = $checkElement['box_margin_right'];
                    }
                    $fieldsAll .= "box_margin_right='".$rowAll['box_margin_right']."',";
                    
                    if(strpos($rowAll['box_border'],'m@@') === false){
                        $rowAll['box_border'] = $checkElement['box_border'];
                    }
                    $fieldsAll .= "box_border='".$rowAll['box_border']."',";
                    
                    if(strpos($rowAll['box_border_color'],'m@@') === false){
                        $rowAll['box_border_color'] = $checkElement['box_border_color'];
                    }
                    $fieldsAll .= "box_border_color='".$rowAll['box_border_color']."',";
                    
                    if(strpos($rowAll['box_border_radius'],'m@@') === false){
                        $rowAll['box_border_radius'] = $checkElement['box_border_radius'];
                    }
                    $fieldsAll .= "box_border_radius='".$rowAll['box_border_radius']."',";
                    
                    if(strpos($rowAll['box_outline'],'m@@') === false){
                        $rowAll['box_outline'] = $checkElement['box_outline'];
                    }
                    $fieldsAll .= "box_outline='".$rowAll['box_outline']."',";
                    
                    if(strpos($rowAll['box_outline_color'],'m@@') === false){
                        $rowAll['box_outline_color'] = $checkElement['box_outline_color'];
                    }
                    $fieldsAll .= "box_outline_color='".$rowAll['box_outline_color']."',";
                    
                    if(strpos($rowAll['box_position'],'m@@') === false){
                        $rowAll['box_position'] = $checkElement['box_position'];
                    }
                    $fieldsAll .= "box_position='".$rowAll['box_position']."',";
                    
                    if(strpos($rowAll['box_top'],'m@@') === false){
                        $rowAll['box_top'] = $checkElement['box_top'];
                    }
                    $fieldsAll .= "box_top='".$rowAll['box_top']."',";
                    
                    if(strpos($rowAll['box_bottom'],'m@@') === false){
                        $rowAll['box_bottom'] = $checkElement['box_bottom'];
                    }
                    $fieldsAll .= "box_bottom='".$rowAll['box_bottom']."',";
                    
                    if(strpos($rowAll['box_left'],'m@@') === false){
                        $rowAll['box_left'] = $checkElement['box_left'];
                    }
                    $fieldsAll .= "box_left='".$rowAll['box_left']."',";
                    
                    if(strpos($rowAll['box_right'],'m@@') === false){
                        $rowAll['box_right'] = $checkElement['box_right'];
                    }
                    $fieldsAll .= "box_right='".$rowAll['box_right']."',";
                    
                    if(strpos($rowAll['box_overflow'],'m@@') === false){
                        $rowAll['box_overflow'] = $checkElement['box_overflow'];
                    }
                    $fieldsAll .= "box_overflow='".$rowAll['box_overflow']."',";
                    
                    if(strpos($rowAll['box_z_index'],'m@@') === false){
                        $rowAll['box_z_index'] = $checkElement['box_z_index'];
                    }
                    $fieldsAll .= "box_z_index='".$rowAll['box_z_index']."',";
                    
                    if(strpos($rowAll['box_float'],'m@@') === false){
                        $rowAll['box_float'] = $checkElement['box_float'];
                    }
                    $fieldsAll .= "box_float='".$rowAll['box_float']."',";
                    
                    if(strpos($rowAll['box_clear'],'m@@') === false){
                        $rowAll['box_clear'] = $checkElement['box_clear'];
                    }
                    $fieldsAll .= "box_clear='".$rowAll['box_clear']."',";
                    
                    if(strpos($rowAll['box_display'],'m@@') === false){
                        $rowAll['box_display'] = $checkElement['box_display'];
                    }
                    $fieldsAll .= "box_display='".$rowAll['box_display']."',";
                    
                    if(strpos($rowAll['box_visibility'],'m@@') === false){
                        $rowAll['box_visibility'] = $checkElement['box_visibility'];
                    }
                    $fieldsAll .= "box_visibility='".$rowAll['box_visibility']."',";
                    
                    if(strpos($rowAll['box_border_collapse'],'m@@') === false){
                        $rowAll['box_border_collapse'] = $checkElement['box_border_collapse'];
                    }
                    $fieldsAll .= "box_border_collapse='".$rowAll['box_border_collapse']."',";
                    
                    if(strpos($rowAll['box_caption_side'],'m@@') === false){
                        $rowAll['box_caption_side'] = $checkElement['box_caption_side'];
                    }
                    $fieldsAll .= "box_caption_side='".$rowAll['box_caption_side']."',";
                    
                    if(strpos($rowAll['box_content'],'m@@') === false){
                        $rowAll['box_content'] = $checkElement['box_content'];
                    }
                    $fieldsAll .= "box_content='".$rowAll['box_content']."',";
                    
                    if(strpos($rowAll['box_page_break_before'],'m@@') === false){
                        $rowAll['box_page_break_before'] = $checkElement['box_page_break_before'];
                    }
                    $fieldsAll .= "box_page_break_before='".$rowAll['box_page_break_before']."',";
                    
                    if(strpos($rowAll['box_page_break_after'],'m@@') === false){
                        $rowAll['box_page_break_after'] = $checkElement['box_page_break_after'];
                    }
                    $fieldsAll .= "box_page_break_after='".$rowAll['box_page_break_after']."',";
                    
                    if(strpos($rowAll['box_page_break_inside'],'m@@') === false){
                        $rowAll['box_page_break_inside'] = $checkElement['box_page_break_inside'];
                    }
                    $fieldsAll .= "box_page_break_inside='".$rowAll['box_page_break_inside']."',";
                    
                    if(strpos($rowAll['box_orfans'],'m@@') === false){
                        $rowAll['box_orfans'] = $checkElement['box_orfans'];
                    }
                    $fieldsAll .= "box_orfans='".$rowAll['box_orfans']."',";
                    
                    if(strpos($rowAll['box_windows'],'m@@') === false){
                        $rowAll['box_windows'] = $checkElement['box_windows'];
                    }
                    $fieldsAll .= "box_windows='".$rowAll['box_windows']."',";
                    
                    if(strpos($rowAll['box_cursor'],'m@@') === false){
                        $rowAll['box_cursor'] = $checkElement['box_cursor'];
                    }
                    $fieldsAll .= "box_cursor='".$rowAll['box_cursor']."',";
                    
                    if(strpos($rowAll['box_direction'],'m@@') === false){
                        $rowAll['box_direction'] = $checkElement['box_direction'];
                    }
                    $fieldsAll .= "box_direction='".$rowAll['box_direction']."',";
                    
                    if(strpos($rowAll['box_border_top'],'m@@') === false){
                        $rowAll['box_border_top'] = $checkElement['box_border_top'];
                    }
                    $fieldsAll .= "box_border_top='".$rowAll['box_border_top']."',";
                    
                    if(strpos($rowAll['box_border_bottom'],'m@@') === false){
                        $rowAll['box_border_bottom'] = $checkElement['box_border_bottom'];
                    }
                    $fieldsAll .= "box_border_bottom='".$rowAll['box_border_bottom']."',";
                    
                    if(strpos($rowAll['box_border_left'],'m@@') === false){
                        $rowAll['box_border_left'] = $checkElement['box_border_left'];
                    }
                    $fieldsAll .= "box_border_left='".$rowAll['box_border_left']."',";
                    
                    if(strpos($rowAll['box_border_right'],'m@@') === false){
                        $rowAll['box_border_right'] = $checkElement['box_border_right'];
                    }
                    $fieldsAll .= "box_border_right='".$rowAll['box_border_right']."',";
                    
                    if(strpos($rowAll['box_border_top_color'],'m@@') === false){
                        $rowAll['box_border_top_color'] = $checkElement['box_border_top_color'];
                    }
                    $fieldsAll .= "box_border_top_color='".$rowAll['box_border_top_color']."',";
                    
                    if(strpos($rowAll['box_border_bottom_color'],'m@@') === false){
                        $rowAll['box_border_bottom_color'] = $checkElement['box_border_bottom_color'];
                    }
                    $fieldsAll .= "box_border_bottom_color='".$rowAll['box_border_bottom_color']."',";
                    
                    if(strpos($rowAll['box_border_left_color'],'m@@') === false){
                        $rowAll['box_border_left_color'] = $checkElement['box_border_left_color'];
                    }
                    $fieldsAll .= "box_border_left_color='".$rowAll['box_border_left_color']."',";
                    
                    if(strpos($rowAll['box_border_right_color'],'m@@') === false){
                        $rowAll['box_border_right_color'] = $checkElement['box_border_right_color'];
                    }
                    $fieldsAll .= "box_border_right_color='".$rowAll['box_border_right_color']."',";
                    
                    if(strpos($rowAll['box_border_top_left_radius'],'m@@') === false){
                        $rowAll['box_border_top_left_radius'] = $checkElement['box_border_top_left_radius'];
                    }
                    $fieldsAll .= "box_border_top_left_radius='".$rowAll['box_border_top_left_radius']."',";
                    
                    if(strpos($rowAll['box_border_bottom_left_radius'],'m@@') === false){
                        $rowAll['box_border_bottom_left_radius'] = $checkElement['box_border_bottom_left_radius'];
                    }
                    $fieldsAll .= "box_border_bottom_left_radius='".$rowAll['box_border_bottom_left_radius']."',";
                    
                    if(strpos($rowAll['box_border_top_right_radius'],'m@@') === false){
                        $rowAll['box_border_top_right_radius'] = $checkElement['box_border_top_right_radius'];
                    }
                    $fieldsAll .= "box_border_top_right_radius='".$rowAll['box_border_top_right_radius']."',";
                    
                    if(strpos($rowAll['box_border_bottom_right_radius'],'m@@') === false){
                        $rowAll['box_border_bottom_right_radius'] = $checkElement['box_border_bottom_right_radius'];
                    }
                    $fieldsAll .= "box_border_bottom_right_radius='".$rowAll['box_border_bottom_right_radius']."',";
                    
                    if(strpos($rowAll['box_min_width'],'m@@') === false){
                        $rowAll['box_min_width'] = $checkElement['box_min_width'];
                    }
                    $fieldsAll .= "box_min_width='".$rowAll['box_min_width']."',";
                    
                    if(strpos($rowAll['box_max_width'],'m@@') === false){
                        $rowAll['box_max_width'] = $checkElement['box_max_width'];
                    }
                    $fieldsAll .= "box_max_width='".$rowAll['box_max_width']."',";
                    
                    if(strpos($rowAll['box_min_height'],'m@@') === false){
                        $rowAll['box_min_height'] = $checkElement['box_min_height'];
                    }
                    $fieldsAll .= "box_min_height='".$rowAll['box_min_height']."',";
                    
                    if(strpos($rowAll['box_max_height'],'m@@') === false){
                        $rowAll['box_max_height'] = $checkElement['box_max_height'];
                    }
                    $fieldsAll .= "box_max_height='".$rowAll['box_max_height']."',";
                    
                    if(strpos($rowAll['box_list_style_type'],'m@@') === false){
                        $rowAll['box_list_style_type'] = $checkElement['box_list_style_type'];
                    }
                    $fieldsAll .= "box_list_style_type='".$rowAll['box_list_style_type']."',";
                    
                    if(strpos($rowAll['box_list_style_position'],'m@@') === false){
                        $rowAll['box_list_style_position'] = $checkElement['box_list_style_position'];
                    }
                    $fieldsAll .= "box_list_style_position='".$rowAll['box_list_style_position']."',";
                    
                    if(strpos($rowAll['h_text_color'],'m@@') === false){
                        $rowAll['h_text_color'] = $checkElement['h_text_color'];
                    }
                    $fieldsAll .= "h_text_color='".$rowAll['h_text_color']."',";
                    
                    if(strpos($rowAll['h_text_font_size'],'m@@') === false){
                        $rowAll['h_text_font_size'] = $checkElement['h_text_font_size'];
                    }
                    $fieldsAll .= "h_text_font_size='".$rowAll['h_text_font_size']."',";
                    
                    if(strpos($rowAll['h_text_font_family'],'m@@') === false){
                        $rowAll['h_text_font_family'] = $checkElement['h_text_font_family'];
                    }
                    $fieldsAll .= "h_text_font_family='".$rowAll['h_text_font_family']."',";
                    
                    if(strpos($rowAll['h_text_font_weight'],'m@@') === false){
                        $rowAll['h_text_font_weight'] = $checkElement['h_text_font_weight'];
                    }
                    $fieldsAll .= "h_text_font_weight='".$rowAll['h_text_font_weight']."',";
                    
                    if(strpos($rowAll['h_text_font_style'],'m@@') === false){
                        $rowAll['h_text_font_style'] = $checkElement['h_text_font_style'];
                    }
                    $fieldsAll .= "h_text_font_style='".$rowAll['h_text_font_style']."',";
                    
                    if(strpos($rowAll['h_text_font_variant'],'m@@') === false){
                        $rowAll['h_text_font_variant'] = $checkElement['h_text_font_variant'];
                    }
                    $fieldsAll .= "h_text_font_variant='".$rowAll['h_text_font_variant']."',";
                    
                    if(strpos($rowAll['h_text_font_line_height'],'m@@') === false){
                        $rowAll['h_text_font_line_height'] = $checkElement['h_text_font_line_height'];
                    }
                    $fieldsAll .= "h_text_font_line_height='".$rowAll['h_text_font_line_height']."',";
                    
                    if(strpos($rowAll['h_text_font_align'],'m@@') === false){
                        $rowAll['h_text_font_align'] = $checkElement['h_text_font_align'];
                    }
                    $fieldsAll .= "h_text_font_align='".$rowAll['h_text_font_align']."',";
                    
                    if(strpos($rowAll['h_text_font_decoration'],'m@@') === false){
                        $rowAll['h_text_font_decoration'] = $checkElement['h_text_font_decoration'];
                    }
                    $fieldsAll .= "h_text_font_decoration='".$rowAll['h_text_font_decoration']."',";
                    
                    if(strpos($rowAll['h_text_font_transform'],'m@@') === false){
                        $rowAll['h_text_font_transform'] = $checkElement['h_text_font_transform'];
                    }
                    $fieldsAll .= "h_text_font_transform='".$rowAll['h_text_font_transform']."',";
                    
                    if(strpos($rowAll['h_text_font_letter_spacing'],'m@@') === false){
                        $rowAll['h_text_font_letter_spacing'] = $checkElement['h_text_font_letter_spacing'];
                    }
                    $fieldsAll .= "h_text_font_letter_spacing='".$rowAll['h_text_font_letter_spacing']."',";
                    
                    if(strpos($rowAll['h_text_font_word_spacing'],'m@@') === false){
                        $rowAll['h_text_font_word_spacing'] = $checkElement['h_text_font_word_spacing'];
                    }
                    $fieldsAll .= "h_text_font_word_spacing='".$rowAll['h_text_font_word_spacing']."',";
                    
                    if(strpos($rowAll['h_text_font_vertical_align'],'m@@') === false){
                        $rowAll['h_text_font_vertical_align'] = $checkElement['h_text_font_vertical_align'];
                    }
                    $fieldsAll .= "h_text_font_vertical_align='".$rowAll['h_text_font_vertical_align']."',";
                    
                    if(strpos($rowAll['h_text_font_white_space'],'m@@') === false){
                        $rowAll['h_text_font_white_space'] = $checkElement['h_text_font_white_space'];
                    }
                    $fieldsAll .= "h_text_font_white_space='".$rowAll['h_text_font_white_space']."',";
                    
                    if(strpos($rowAll['h_box_background_color'],'m@@') === false){
                        $rowAll['h_box_background_color'] = $checkElement['h_box_background_color'];
                    }
                    $fieldsAll .= "h_box_background_color='".$rowAll['h_box_background_color']."',";
                    
                    if(strpos($rowAll['h_box_width'],'m@@') === false){
                        $rowAll['h_box_width'] = $checkElement['h_box_width'];
                    }
                    $fieldsAll .= "h_box_width='".$rowAll['h_box_width']."',";
                    
                    if(strpos($rowAll['h_box_height'],'m@@') === false){
                        $rowAll['h_box_height'] = $checkElement['h_box_height'];
                    }
                    $fieldsAll .= "h_box_height='".$rowAll['h_box_height']."',";
                    
                    if(strpos($rowAll['h_box_background_image'],'m@@') === false){
                        $rowAll['h_box_background_image'] = $checkElement['h_box_background_image'];
                    }
                    $fieldsAll .= "h_box_background_image='".$rowAll['h_box_background_image']."',";
                    
                    if(strpos($rowAll['h_box_background_size'],'m@@') === false){
                        $rowAll['h_box_background_size'] = $checkElement['h_box_background_size'];
                    }
                    $fieldsAll .= "h_box_background_size='".$rowAll['h_box_background_size']."',";
                    
                    if(strpos($rowAll['h_box_background_position_x'],'m@@') === false){
                        $rowAll['h_box_background_position_x'] = $checkElement['h_box_background_position_x'];
                    }
                    $fieldsAll .= "h_box_background_position_x='".$rowAll['h_box_background_position_x']."',";
                    
                    if(strpos($rowAll['h_box_background_position_y'],'m@@') === false){
                        $rowAll['h_box_background_position_y'] = $checkElement['h_box_background_position_y'];
                    }
                    $fieldsAll .= "h_box_background_position_y='".$rowAll['h_box_background_position_y']."',";
                    
                    if(strpos($rowAll['h_box_background_repeat'],'m@@') === false){
                        $rowAll['h_box_background_repeat'] = $checkElement['h_box_background_repeat'];
                    }
                    $fieldsAll .= "h_box_background_repeat='".$rowAll['h_box_background_repeat']."',";
                    
                    if(strpos($rowAll['h_box_padding_top'],'m@@') === false){
                        $rowAll['h_box_padding_top'] = $checkElement['h_box_padding_top'];
                    }
                    $fieldsAll .= "h_box_padding_top='".$rowAll['h_box_padding_top']."',";
                    
                    if(strpos($rowAll['h_box_padding_bottom'],'m@@') === false){
                        $rowAll['h_box_padding_bottom'] = $checkElement['h_box_padding_bottom'];
                    }
                    $fieldsAll .= "h_box_padding_bottom='".$rowAll['h_box_padding_bottom']."',";
                    
                    if(strpos($rowAll['h_box_padding_left'],'m@@') === false){
                        $rowAll['h_box_padding_left'] = $checkElement['h_box_padding_left'];
                    }
                    $fieldsAll .= "h_box_padding_left='".$rowAll['h_box_padding_left']."',";
                    
                    if(strpos($rowAll['h_box_padding_right'],'m@@') === false){
                        $rowAll['h_box_padding_right'] = $checkElement['h_box_padding_right'];
                    }
                    $fieldsAll .= "h_box_padding_right='".$rowAll['h_box_padding_right']."',";
                    
                    if(strpos($rowAll['h_box_margin_top'],'m@@') === false){
                        $rowAll['h_box_margin_top'] = $checkElement['h_box_margin_top'];
                    }
                    $fieldsAll .= "h_box_margin_top='".$rowAll['h_box_margin_top']."',";
                    
                    if(strpos($rowAll['h_box_margin_bottom'],'m@@') === false){
                        $rowAll['h_box_margin_bottom'] = $checkElement['h_box_margin_bottom'];
                    }
                    $fieldsAll .= "h_box_margin_bottom='".$rowAll['h_box_margin_bottom']."',";
                    
                    if(strpos($rowAll['h_box_margin_left'],'m@@') === false){
                        $rowAll['h_box_margin_left'] = $checkElement['h_box_margin_left'];
                    }
                    $fieldsAll .= "h_box_margin_left='".$rowAll['h_box_margin_left']."',";
                    
                    if(strpos($rowAll['h_box_margin_right'],'m@@') === false){
                        $rowAll['h_box_margin_right'] = $checkElement['h_box_margin_right'];
                    }
                    $fieldsAll .= "h_box_margin_right='".$rowAll['h_box_margin_right']."',";
                    
                    if(strpos($rowAll['h_box_border'],'m@@') === false){
                        $rowAll['h_box_border'] = $checkElement['h_box_border'];
                    }
                    $fieldsAll .= "h_box_border='".$rowAll['h_box_border']."',";
                    
                    if(strpos($rowAll['h_box_border_color'],'m@@') === false){
                        $rowAll['h_box_border_color'] = $checkElement['h_box_border_color'];
                    }
                    $fieldsAll .= "h_box_border_color='".$rowAll['h_box_border_color']."',";
                    
                    if(strpos($rowAll['h_box_border_radius'],'m@@') === false){
                        $rowAll['h_box_border_radius'] = $checkElement['h_box_border_radius'];
                    }
                    $fieldsAll .= "h_box_border_radius='".$rowAll['h_box_border_radius']."',";
                    
                    if(strpos($rowAll['h_box_outline'],'m@@') === false){
                        $rowAll['h_box_outline'] = $checkElement['h_box_outline'];
                    }
                    $fieldsAll .= "h_box_outline='".$rowAll['h_box_outline']."',";
                    
                    if(strpos($rowAll['h_box_outline_color'],'m@@') === false){
                        $rowAll['h_box_outline_color'] = $checkElement['h_box_outline_color'];
                    }
                    $fieldsAll .= "h_box_outline_color='".$rowAll['h_box_outline_color']."',";
                    
                    if(strpos($rowAll['h_box_position'],'m@@') === false){
                        $rowAll['h_box_position'] = $checkElement['h_box_position'];
                    }
                    $fieldsAll .= "h_box_position='".$rowAll['h_box_position']."',";
                    
                    if(strpos($rowAll['h_box_top'],'m@@') === false){
                        $rowAll['h_box_top'] = $checkElement['h_box_top'];
                    }
                    $fieldsAll .= "h_box_top='".$rowAll['h_box_top']."',";
                    
                    if(strpos($rowAll['h_box_bottom'],'m@@') === false){
                        $rowAll['h_box_bottom'] = $checkElement['h_box_bottom'];
                    }
                    $fieldsAll .= "h_box_bottom='".$rowAll['h_box_bottom']."',";
                    
                    if(strpos($rowAll['h_box_left'],'m@@') === false){
                        $rowAll['h_box_left'] = $checkElement['h_box_left'];
                    }
                    $fieldsAll .= "h_box_left='".$rowAll['h_box_left']."',";
                    
                    if(strpos($rowAll['h_box_right'],'m@@') === false){
                        $rowAll['h_box_right'] = $checkElement['h_box_right'];
                    }
                    $fieldsAll .= "h_box_right='".$rowAll['h_box_right']."',";
                    
                    if(strpos($rowAll['h_box_overflow'],'m@@') === false){
                        $rowAll['h_box_overflow'] = $checkElement['h_box_overflow'];
                    }
                    $fieldsAll .= "h_box_overflow='".$rowAll['h_box_overflow']."',";
                    
                    if(strpos($rowAll['h_box_z_index'],'m@@') === false){
                        $rowAll['h_box_z_index'] = $checkElement['h_box_z_index'];
                    }
                    $fieldsAll .= "h_box_z_index='".$rowAll['h_box_z_index']."',";
                    
                    if(strpos($rowAll['h_box_float'],'m@@') === false){
                        $rowAll['h_box_float'] = $checkElement['h_box_float'];
                    }
                    $fieldsAll .= "h_box_float='".$rowAll['h_box_float']."',";
                    
                    if(strpos($rowAll['h_box_clear'],'m@@') === false){
                        $rowAll['h_box_clear'] = $checkElement['h_box_clear'];
                    }
                    $fieldsAll .= "h_box_clear='".$rowAll['h_box_clear']."',";
                    
                    if(strpos($rowAll['h_box_display'],'m@@') === false){
                        $rowAll['h_box_display'] = $checkElement['h_box_display'];
                    }
                    $fieldsAll .= "h_box_display='".$rowAll['h_box_display']."',";
                    
                    if(strpos($rowAll['h_box_visibility'],'m@@') === false){
                        $rowAll['h_box_visibility'] = $checkElement['h_box_visibility'];
                    }
                    $fieldsAll .= "h_box_visibility='".$rowAll['h_box_visibility']."',";
                    
                    if(strpos($rowAll['h_box_border_collapse'],'m@@') === false){
                        $rowAll['h_box_border_collapse'] = $checkElement['h_box_border_collapse'];
                    }
                    $fieldsAll .= "h_box_border_collapse='".$rowAll['h_box_border_collapse']."',";
                    
                    if(strpos($rowAll['h_box_caption_side'],'m@@') === false){
                        $rowAll['h_box_caption_side'] = $checkElement['h_box_caption_side'];
                    }
                    $fieldsAll .= "h_box_caption_side='".$rowAll['h_box_caption_side']."',";
                    
                    if(strpos($rowAll['h_box_content'],'m@@') === false){
                        $rowAll['h_box_content'] = $checkElement['h_box_content'];
                    }
                    $fieldsAll .= "h_box_content='".$rowAll['h_box_content']."',";
                    
                    if(strpos($rowAll['h_box_page_break_before'],'m@@') === false){
                        $rowAll['h_box_page_break_before'] = $checkElement['h_box_page_break_before'];
                    }
                    $fieldsAll .= "h_box_page_break_before='".$rowAll['h_box_page_break_before']."',";
                    
                    if(strpos($rowAll['h_box_page_break_after'],'m@@') === false){
                        $rowAll['h_box_page_break_after'] = $checkElement['h_box_page_break_after'];
                    }
                    $fieldsAll .= "h_box_page_break_after='".$rowAll['h_box_page_break_after']."',";
                    
                    if(strpos($rowAll['h_box_page_break_inside'],'m@@') === false){
                        $rowAll['h_box_page_break_inside'] = $checkElement['h_box_page_break_inside'];
                    }
                    $fieldsAll .= "h_box_page_break_inside='".$rowAll['h_box_page_break_inside']."',";
                    
                    if(strpos($rowAll['h_box_orfans'],'m@@') === false){
                        $rowAll['h_box_orfans'] = $checkElement['h_box_orfans'];
                    }
                    $fieldsAll .= "h_box_orfans='".$rowAll['h_box_orfans']."',";
                    
                    if(strpos($rowAll['h_box_windows'],'m@@') === false){
                        $rowAll['h_box_windows'] = $checkElement['h_box_windows'];
                    }
                    $fieldsAll .= "h_box_windows='".$rowAll['h_box_windows']."',";
                    
                    if(strpos($rowAll['h_box_cursor'],'m@@') === false){
                        $rowAll['h_box_cursor'] = $checkElement['h_box_cursor'];
                    }
                    $fieldsAll .= "h_box_cursor='".$rowAll['h_box_cursor']."',";
                    
                    if(strpos($rowAll['h_box_direction'],'m@@') === false){
                        $rowAll['h_box_direction'] = $checkElement['h_box_direction'];
                    }
                    $fieldsAll .= "h_box_direction='".$rowAll['h_box_direction']."',";
                    
                    if(strpos($rowAll['h_box_border_top'],'m@@') === false){
                        $rowAll['h_box_border_top'] = $checkElement['h_box_border_top'];
                    }
                    $fieldsAll .= "h_box_border_top='".$rowAll['h_box_border_top']."',";
                    
                    if(strpos($rowAll['h_box_border_bottom'],'m@@') === false){
                        $rowAll['h_box_border_bottom'] = $checkElement['h_box_border_bottom'];
                    }
                    $fieldsAll .= "h_box_border_bottom='".$rowAll['h_box_border_bottom']."',";
                    
                    if(strpos($rowAll['h_box_border_left'],'m@@') === false){
                        $rowAll['h_box_border_left'] = $checkElement['h_box_border_left'];
                    }
                    $fieldsAll .= "h_box_border_left='".$rowAll['h_box_border_left']."',";
                    
                    if(strpos($rowAll['h_box_border_right'],'m@@') === false){
                        $rowAll['h_box_border_right'] = $checkElement['h_box_border_right'];
                    }
                    $fieldsAll .= "h_box_border_right='".$rowAll['h_box_border_right']."',";
                    
                    if(strpos($rowAll['h_box_border_top_color'],'m@@') === false){
                        $rowAll['h_box_border_top_color'] = $checkElement['h_box_border_top_color'];
                    }
                    $fieldsAll .= "h_box_border_top_color='".$rowAll['h_box_border_top_color']."',";
                    
                    if(strpos($rowAll['h_box_border_bottom_color'],'m@@') === false){
                        $rowAll['h_box_border_bottom_color'] = $checkElement['h_box_border_bottom_color'];
                    }
                    $fieldsAll .= "h_box_border_bottom_color='".$rowAll['h_box_border_bottom_color']."',";
                    
                    if(strpos($rowAll['h_box_border_left_color'],'m@@') === false){
                        $rowAll['h_box_border_left_color'] = $checkElement['h_box_border_left_color'];
                    }
                    $fieldsAll .= "h_box_border_left_color='".$rowAll['h_box_border_left_color']."',";
                    
                    if(strpos($rowAll['h_box_border_right_color'],'m@@') === false){
                        $rowAll['h_box_border_right_color'] = $checkElement['h_box_border_right_color'];
                    }
                    $fieldsAll .= "h_box_border_right_color='".$rowAll['h_box_border_right_color']."',";
                    
                    if(strpos($rowAll['h_box_border_top_left_radius'],'m@@') === false){
                        $rowAll['h_box_border_top_left_radius'] = $checkElement['h_box_border_top_left_radius'];
                    }
                    $fieldsAll .= "h_box_border_top_left_radius='".$rowAll['h_box_border_top_left_radius']."',";
                    
                    if(strpos($rowAll['h_box_border_bottom_left_radius'],'m@@') === false){
                        $rowAll['h_box_border_bottom_left_radius'] = $checkElement['h_box_border_bottom_left_radius'];
                    }
                    $fieldsAll .= "h_box_border_bottom_left_radius='".$rowAll['h_box_border_bottom_left_radius']."',";
                    
                    if(strpos($rowAll['h_box_border_top_right_radius'],'m@@') === false){
                        $rowAll['h_box_border_top_right_radius'] = $checkElement['h_box_border_top_right_radius'];
                    }
                    $fieldsAll .= "h_box_border_top_right_radius='".$rowAll['h_box_border_top_right_radius']."',";
                    
                    if(strpos($rowAll['h_box_border_bottom_right_radius'],'m@@') === false){
                        $rowAll['h_box_border_bottom_right_radius'] = $checkElement['h_box_border_bottom_right_radius'];
                    }
                    $fieldsAll .= "h_box_border_bottom_right_radius='".$rowAll['h_box_border_bottom_right_radius']."',";
                    
                    if(strpos($rowAll['h_box_min_width'],'m@@') === false){
                        $rowAll['h_box_min_width'] = $checkElement['h_box_min_width'];
                    }
                    $fieldsAll .= "h_box_min_width='".$rowAll['h_box_min_width']."',";
                    
                    if(strpos($rowAll['h_box_max_width'],'m@@') === false){
                        $rowAll['h_box_max_width'] = $checkElement['h_box_max_width'];
                    }
                    $fieldsAll .= "h_box_max_width='".$rowAll['h_box_max_width']."',";
                    
                    if(strpos($rowAll['h_box_min_height'],'m@@') === false){
                        $rowAll['h_box_min_height'] = $checkElement['h_box_min_height'];
                    }
                    $fieldsAll .= "h_box_min_height='".$rowAll['h_box_min_height']."',";
                    
                    if(strpos($rowAll['h_box_max_height'],'m@@') === false){
                        $rowAll['h_box_max_height'] = $checkElement['h_box_max_height'];
                    }
                    $fieldsAll .= "h_box_max_height='".$rowAll['h_box_max_height']."',";
                    
                    if(strpos($rowAll['h_box_list_style_type'],'m@@') === false){
                        $rowAll['h_box_list_style_type'] = $checkElement['h_box_list_style_type'];
                    }
                    $fieldsAll .= "h_box_list_style_type='".$rowAll['h_box_list_style_type']."',";
                    
                    if(strpos($rowAll['h_box_list_style_position'],'m@@') === false){
                        $rowAll['h_box_list_style_position'] = $checkElement['h_box_list_style_position'];
                    }
                    $fieldsAll .= "h_box_list_style_position='".$rowAll['h_box_list_style_position']."',";
                    $fieldsAll .= "unix_created_date='".$unixDateCreated."'";

                    // UPDATE
                    $updateElement = "UPDATE `".WDHSVWE_CSS_table."` SET ".$fieldsAll." ".$checkCondition;
                    $wpdb->query($updateElement);
                    $added++;
                } else {
                    $fieldsAll .= "(wid,used_for,container_full_path,container_wdh_path,container_classes,container_id,element_tag,element_position,resolution,page_url,page_on,role,text_color,text_font_size,text_font_family,text_font_weight,text_font_style,text_font_variant,text_font_line_height,text_font_align,text_font_decoration,text_font_transform,text_font_letter_spacing,text_font_word_spacing,text_font_vertical_align,text_font_white_space,box_background_color,box_width,box_height,box_background_image,box_background_size,box_background_position_x,box_background_position_y,box_background_repeat,box_padding_top,box_padding_bottom,box_padding_left,box_padding_right,box_margin_top,box_margin_bottom,box_margin_left,box_margin_right,box_border,box_border_color,box_border_radius,box_outline,box_outline_color,box_position,box_top,box_bottom,box_left,box_right,box_overflow,box_z_index,box_float,box_clear,box_display,box_visibility,box_border_collapse,box_caption_side,box_content,box_page_break_before,box_page_break_after,box_page_break_inside,box_orfans,box_windows,box_cursor,box_direction,box_border_top,box_border_bottom,box_border_left,box_border_right,box_border_top_color,box_border_bottom_color,box_border_left_color,box_border_right_color,box_border_top_left_radius,box_border_bottom_left_radius,box_border_top_right_radius,box_border_bottom_right_radius,box_min_width,box_max_width,box_min_height,box_max_height,box_list_style_type,box_list_style_position,h_text_color,h_text_font_size,h_text_font_family,h_text_font_weight,h_text_font_style,h_text_font_variant,h_text_font_line_height,h_text_font_align,h_text_font_decoration,h_text_font_transform,h_text_font_letter_spacing,h_text_font_word_spacing,h_text_font_vertical_align,h_text_font_white_space,h_box_background_color,h_box_width,h_box_height,h_box_background_image,h_box_background_size,h_box_background_position_x,h_box_background_position_y,h_box_background_repeat,h_box_padding_top,h_box_padding_bottom,h_box_padding_left,h_box_padding_right,h_box_margin_top,h_box_margin_bottom,h_box_margin_left,h_box_margin_right,h_box_border,h_box_border_color,h_box_border_radius,h_box_outline,h_box_outline_color,h_box_position,h_box_top,h_box_bottom,h_box_left,h_box_right,h_box_overflow,h_box_z_index,h_box_float,h_box_clear,h_box_display,h_box_visibility,h_box_border_collapse,h_box_caption_side,h_box_content,h_box_page_break_before,h_box_page_break_after,h_box_page_break_inside,h_box_orfans,h_box_windows,h_box_cursor,h_box_direction,h_box_border_top,h_box_border_bottom,h_box_border_left,h_box_border_right,h_box_border_top_color,h_box_border_bottom_color,h_box_border_left_color,h_box_border_right_color,h_box_border_top_left_radius,h_box_border_bottom_left_radius,h_box_border_top_right_radius,h_box_border_bottom_right_radius,h_box_min_width,h_box_max_width,h_box_min_height,h_box_max_height,h_box_list_style_type,h_box_list_style_position,unix_created_date) VALUES(";
                    $fieldsAll .= "'".$wid."','".$wdhPublishFor."','".$domPath."','".$wdhPath."','".$wdhClass."','".$wdhID."','".$elementTag."','".$elementPosition."','".$resolution."','".$wdhPageUrl."','".$wdhPageOn."','".$wdhRole."',";
                    $fieldsAll .= "'".$rowAll['text_color']."',";
                    $fieldsAll .= "'".$rowAll['text_font_size']."',";
                    $fieldsAll .= "'".$rowAll['text_font_family']."',";
                    $fieldsAll .= "'".$rowAll['text_font_weight']."',";
                    $fieldsAll .= "'".$rowAll['text_font_style']."',";
                    $fieldsAll .= "'".$rowAll['text_font_variant']."',";
                    $fieldsAll .= "'".$rowAll['text_font_line_height']."',";
                    $fieldsAll .= "'".$rowAll['text_font_align']."',";
                    $fieldsAll .= "'".$rowAll['text_font_decoration']."',";
                    $fieldsAll .= "'".$rowAll['text_font_transform']."',";
                    $fieldsAll .= "'".$rowAll['text_font_letter_spacing']."',";
                    $fieldsAll .= "'".$rowAll['text_font_word_spacing']."',";
                    $fieldsAll .= "'".$rowAll['text_font_vertical_align']."',";
                    $fieldsAll .= "'".$rowAll['text_font_white_space']."',";
                    $fieldsAll .= "'".$rowAll['box_background_color']."',";
                    $fieldsAll .= "'".$rowAll['box_width']."',";
                    $fieldsAll .= "'".$rowAll['box_height']."',";
                    $fieldsAll .= "'".$rowAll['box_background_image']."',";
                    $fieldsAll .= "'".$rowAll['box_background_size']."',";
                    $fieldsAll .= "'".$rowAll['box_background_position_x']."',";
                    $fieldsAll .= "'".$rowAll['box_background_position_y']."',";
                    $fieldsAll .= "'".$rowAll['box_background_repeat']."',";
                    $fieldsAll .= "'".$rowAll['box_padding_top']."',";
                    $fieldsAll .= "'".$rowAll['box_padding_bottom']."',";
                    $fieldsAll .= "'".$rowAll['box_padding_left']."',";
                    $fieldsAll .= "'".$rowAll['box_padding_right']."',";
                    $fieldsAll .= "'".$rowAll['box_margin_top']."',";
                    $fieldsAll .= "'".$rowAll['box_margin_bottom']."',";
                    $fieldsAll .= "'".$rowAll['box_margin_left']."',";
                    $fieldsAll .= "'".$rowAll['box_margin_right']."',";
                    $fieldsAll .= "'".$rowAll['box_border']."',";
                    $fieldsAll .= "'".$rowAll['box_border_color']."',";
                    $fieldsAll .= "'".$rowAll['box_border_radius']."',";
                    $fieldsAll .= "'".$rowAll['box_outline']."',";
                    $fieldsAll .= "'".$rowAll['box_outline_color']."',";
                    $fieldsAll .= "'".$rowAll['box_position']."',";
                    $fieldsAll .= "'".$rowAll['box_top']."',";
                    $fieldsAll .= "'".$rowAll['box_bottom']."',";
                    $fieldsAll .= "'".$rowAll['box_left']."',";
                    $fieldsAll .= "'".$rowAll['box_right']."',";
                    $fieldsAll .= "'".$rowAll['box_overflow']."',";
                    $fieldsAll .= "'".$rowAll['box_z_index']."',";
                    $fieldsAll .= "'".$rowAll['box_float']."',";
                    $fieldsAll .= "'".$rowAll['box_clear']."',";
                    $fieldsAll .= "'".$rowAll['box_display']."',";
                    $fieldsAll .= "'".$rowAll['box_visibility']."',";
                    $fieldsAll .= "'".$rowAll['box_border_collapse']."',";
                    $fieldsAll .= "'".$rowAll['box_caption_side']."',";
                    $fieldsAll .= "'".$rowAll['box_content']."',";
                    $fieldsAll .= "'".$rowAll['box_page_break_before']."',";
                    $fieldsAll .= "'".$rowAll['box_page_break_after']."',";
                    $fieldsAll .= "'".$rowAll['box_page_break_inside']."',";
                    $fieldsAll .= "'".$rowAll['box_orfans']."',";
                    $fieldsAll .= "'".$rowAll['box_windows']."',";
                    $fieldsAll .= "'".$rowAll['box_cursor']."',";
                    $fieldsAll .= "'".$rowAll['box_direction']."',";
                    $fieldsAll .= "'".$rowAll['box_border_top']."',";
                    $fieldsAll .= "'".$rowAll['box_border_bottom']."',";
                    $fieldsAll .= "'".$rowAll['box_border_left']."',";
                    $fieldsAll .= "'".$rowAll['box_border_right']."',";
                    $fieldsAll .= "'".$rowAll['box_border_top_color']."',";
                    $fieldsAll .= "'".$rowAll['box_border_bottom_color']."',";
                    $fieldsAll .= "'".$rowAll['box_border_left_color']."',";
                    $fieldsAll .= "'".$rowAll['box_border_right_color']."',";
                    $fieldsAll .= "'".$rowAll['box_border_top_left_radius']."',";
                    $fieldsAll .= "'".$rowAll['box_border_bottom_left_radius']."',";
                    $fieldsAll .= "'".$rowAll['box_border_top_right_radius']."',";
                    $fieldsAll .= "'".$rowAll['box_border_bottom_right_radius']."',";
                    $fieldsAll .= "'".$rowAll['box_min_width']."',";
                    $fieldsAll .= "'".$rowAll['box_max_width']."',";
                    $fieldsAll .= "'".$rowAll['box_min_height']."',";
                    $fieldsAll .= "'".$rowAll['box_max_height']."',";
                    $fieldsAll .= "'".$rowAll['box_list_style_type']."',";
                    $fieldsAll .= "'".$rowAll['box_list_style_position']."',";
                    $fieldsAll .= "'".$rowAll['h_text_color']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_size']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_family']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_weight']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_style']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_variant']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_line_height']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_align']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_decoration']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_transform']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_letter_spacing']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_word_spacing']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_vertical_align']."',";
                    $fieldsAll .= "'".$rowAll['h_text_font_white_space']."',";
                    $fieldsAll .= "'".$rowAll['h_box_background_color']."',";
                    $fieldsAll .= "'".$rowAll['h_box_width']."',";
                    $fieldsAll .= "'".$rowAll['h_box_height']."',";
                    $fieldsAll .= "'".$rowAll['h_box_background_image']."',";
                    $fieldsAll .= "'".$rowAll['h_box_background_size']."',";
                    $fieldsAll .= "'".$rowAll['h_box_background_position_x']."',";
                    $fieldsAll .= "'".$rowAll['h_box_background_position_y']."',";
                    $fieldsAll .= "'".$rowAll['h_box_background_repeat']."',";
                    $fieldsAll .= "'".$rowAll['h_box_padding_top']."',";
                    $fieldsAll .= "'".$rowAll['h_box_padding_bottom']."',";
                    $fieldsAll .= "'".$rowAll['h_box_padding_left']."',";
                    $fieldsAll .= "'".$rowAll['h_box_padding_right']."',";
                    $fieldsAll .= "'".$rowAll['h_box_margin_top']."',";
                    $fieldsAll .= "'".$rowAll['h_box_margin_bottom']."',";
                    $fieldsAll .= "'".$rowAll['h_box_margin_left']."',";
                    $fieldsAll .= "'".$rowAll['h_box_margin_right']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_color']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_radius']."',";
                    $fieldsAll .= "'".$rowAll['h_box_outline']."',";
                    $fieldsAll .= "'".$rowAll['h_box_outline_color']."',";
                    $fieldsAll .= "'".$rowAll['h_box_position']."',";
                    $fieldsAll .= "'".$rowAll['h_box_top']."',";
                    $fieldsAll .= "'".$rowAll['h_box_bottom']."',";
                    $fieldsAll .= "'".$rowAll['h_box_left']."',";
                    $fieldsAll .= "'".$rowAll['h_box_right']."',";
                    $fieldsAll .= "'".$rowAll['h_box_overflow']."',";
                    $fieldsAll .= "'".$rowAll['h_box_z_index']."',";
                    $fieldsAll .= "'".$rowAll['h_box_float']."',";
                    $fieldsAll .= "'".$rowAll['h_box_clear']."',";
                    $fieldsAll .= "'".$rowAll['h_box_display']."',";
                    $fieldsAll .= "'".$rowAll['h_box_visibility']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_collapse']."',";
                    $fieldsAll .= "'".$rowAll['h_box_caption_side']."',";
                    $fieldsAll .= "'".$rowAll['h_box_content']."',";
                    $fieldsAll .= "'".$rowAll['h_box_page_break_before']."',";
                    $fieldsAll .= "'".$rowAll['h_box_page_break_after']."',";
                    $fieldsAll .= "'".$rowAll['h_box_page_break_inside']."',";
                    $fieldsAll .= "'".$rowAll['h_box_orfans']."',";
                    $fieldsAll .= "'".$rowAll['h_box_windows']."',";
                    $fieldsAll .= "'".$rowAll['h_box_cursor']."',";
                    $fieldsAll .= "'".$rowAll['h_box_direction']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_top']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_bottom']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_left']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_right']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_top_color']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_bottom_color']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_left_color']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_right_color']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_top_left_radius']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_bottom_left_radius']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_top_right_radius']."',";
                    $fieldsAll .= "'".$rowAll['h_box_border_bottom_right_radius']."',";
                    $fieldsAll .= "'".$rowAll['h_box_min_width']."',";
                    $fieldsAll .= "'".$rowAll['h_box_max_width']."',";
                    $fieldsAll .= "'".$rowAll['h_box_min_height']."',";
                    $fieldsAll .= "'".$rowAll['h_box_max_height']."',";
                    $fieldsAll .= "'".$rowAll['h_box_list_style_type']."',";
                    $fieldsAll .= "'".$rowAll['h_box_list_style_position']."',";
                    $fieldsAll .= "'".$unixDateCreated."')";

                    // INSERT
                    $insertElement = "INSERT INTO `".WDHSVWE_CSS_table."` ".$fieldsAll;
                    $wpdb->query($insertElement);
                    $added++;
                }
                $fieldsAll = '';
            }
            
            if ($added > 0) {
                // DELETE TEMPORARY CSS
                // ---------------------------------------------------------
                $deleteTemporarryCSS = "DELETE FROM ".WDHSVWE_Temporary_CSS_table;
                $wpdb->query($deleteTemporarryCSS);

                // ADD IN HISTORY
                // ---------------------------------------------------------
                $fieldsAll  = '';
                $fieldsAll .= "(wid,used_for,page_url,page_on,role,created_date,created_date_full,unix_created_date) VALUES(";
                $fieldsAll .= "'".$wid."','".$wdhPublishFor."','".$wdhPageUrl."','".$wdhPageOn."','".$wdhRole."','".$dateCreated."','".$dateTimeCreated."','".$unixDateCreated."')";
                $insertHistory = "INSERT INTO `".WDHSVWE_History_table."` ".$fieldsAll;
                $wpdb->query($insertHistory);
                $historyID  = mysql_insert_id();

                // ADD / UPDATE Settings
                // ---------------------------------------------------------
                if ($wdhPublishFor == 'current_page'){
                    $wdhPageUrl = sanitize_text_field($this->clearPageUrl($_POST['wdhPageUrl']));
                    $checkSettingsCondition = "WHERE wid='".$wid."' AND used_for ='".$wdhPublishFor."' AND page_url ='".$wdhPageUrl."' AND page_on ='".$wdhPageOn."' AND page_url ='".$wdhRole."'";
                    $checkSettings = "SELECT * FROM `".WDHSVWE_Settings_table."` ".$checkSettingsCondition;
                    $checkSettings = $wpdb->get_row($checkSettings);
                    
                    if ($wpdb->num_rows < 1){
                        $fieldsAll  = '';
                        $fieldsAll .= "(wid,used_for,page_url,page_on,role,roll_back,created_date,unix_created_date) VALUES(";
                        $fieldsAll .= "'".$wid."','".$wdhPublishFor."','".$wdhPageUrl."','".$wdhPageOn."','".$wdhRole."','latest','".$dateTimeCreated."','".$unixDateCreated."')";
                        $insertHistory = "INSERT INTO `".WDHSVWE_Settings_table."` ".$fieldsAll;
                        $wpdb->query($insertHistory);
                    }
                }
            } else {// No changes
                echo ''; die();
            }
            
            // Generate CSS Files
            include_once WDHSVWE_Path.'wdh.svwe.css.php';
            
            if (!isset($wdhSVWE_CSS)) {
                $wdhSVWE_CSS = new wdhSVWE_CSS();
            }
            
            $styleData = array();
            
            if ($wdhPublishFor == 'current_page') {
                $wdhPhublishForIs = $historyID;
            } else {
                $wdhPhublishForIs = $wdhPublishFor;
            }
            $styleFile = WP_CONTENT_DIR."/wdhsvwe/css/style.".$wdhPhublishForIs.".".$wdhPageOn.".".$wdhRole.".".$unixDateCreated.".min.css";
            
            array_push($styleData, $wdhSVWE_CSS->generateCSSMin(WDHSVWE_CSS_table));
            
            if (!file_exists($styleFile) && ($added > 0)){
                $fh = fopen($styleFile,"w");
                fwrite($fh, implode('', $styleData));

                echo 'success'; die();
            }
        }
        
        /*
         * Resize Element
         */
        function resize(){
             global $wdhSVWE, $wpdb;
            
            $wid                = $wdhSVWE['WEBSITE_ID'];
            $domPath            = sanitize_text_field($_POST['domPath']);
            $wdhPath            = sanitize_text_field($_POST['wdhPath']);
            $wdhClass           = sanitize_text_field($_POST['wdhClass']);
            $wdhID              = sanitize_text_field($_POST['wdhID']);
            $elementTag         = sanitize_text_field($_POST['elementTag']);
            $elementPosition    = sanitize_text_field($_POST['elementPosition']);
            $resolution         = sanitize_text_field($_POST['resolution']);
            $wdhPageUrl         = sanitize_text_field($this->clearPageUrl($_POST['wdhPageUrl']));
            $wdhSVWE['page_on'] = sanitize_text_field($_POST['wdhPageOn']);
            $wdhPageOn          = $wdhSVWE['page_on'];
            $wdhSVWE['role']    = sanitize_text_field($_POST['wdhRole']);
            $wdhRole            = $wdhSVWE['role'];
            $width              = sanitize_text_field($_POST['width']);
            $height             = sanitize_text_field($_POST['height']);
            $minHeight          = sanitize_text_field($_POST['minHeight']);
            $fieldsAll          = '';

            $checkCondition = "WHERE wid='".$wid."' AND container_full_path ='".$domPath."' AND container_wdh_path ='".$wdhPath."' AND container_classes ='".$wdhClass."' AND container_id ='".$wdhID."' AND element_tag ='".$elementTag."' AND element_position ='".$elementPosition."' AND resolution ='".$resolution."' AND page_url ='".$wdhPageUrl."' AND page_on ='".$wdhPageOn."' AND role ='".$wdhRole."'";
            $checkElement = "SELECT * FROM `".WDHSVWE_Temporary_CSS_table."` ".$checkCondition;
            $elementCheck = $wpdb->get_row($checkElement);
            
            if ($wpdb->num_rows > 0){
                // UPDATE
                $fieldsAll .= "box_width='".$width."',";
                $fieldsAll .= "box_height='".$height."',";
                $fieldsAll .= "box_min_height='".$minHeight."'";

                $updateElement = "UPDATE `".WDHSVWE_Temporary_CSS_table."` SET ".$fieldsAll." ".$checkCondition;
                $wpdb->query($updateElement);
            } else {
                // INSERT
                $fieldsAll .= "(wid,container_full_path,container_wdh_path,container_classes,container_id,element_tag,element_position,resolution,page_url,page_on,role,box_width,box_height,box_min_height) VALUES(";
                $fieldsAll .= "'".$wid."','".$domPath."','".$wdhPath."','".$wdhClass."','".$wdhID."','".$elementTag."','".$elementPosition."','".$resolution."','".$wdhPageUrl."','".$wdhPageOn."','".$wdhRole."',";
                $fieldsAll .= "'".$width."',";
                $fieldsAll .= "'".$height."',";
                $fieldsAll .= "'".$minHeight."')";

                $insertElement = "INSERT INTO `".WDHSVWE_Temporary_CSS_table."` ".$fieldsAll;
                $wpdb->query($insertElement);
            }

            echo 'success'; die();
        }
        
        /*
         * Change Role
         */
        function changeRole(){
            global $wdhSVWE;
            
            $wdhSVWE['role'] = get_option('WDH_SVWE_role');
            $wdhRole         = sanitize_text_field($_POST['wdhRole']);
                
            if(!isset($wdhSVWE['role'])) {
                add_option('WDH_SVWE_role', $wdhRole);
            } else {
                update_option('WDH_SVWE_role', $wdhRole);
            }
            
            echo 'success'; die();
        }
        
        /*
         * Change Role
         */
        function changeLanguage(){
            global $wdhSVWE;
            
            $wdhLanguage    = get_option('WDH_SVWE_language');
            $wdhNewLanguage = sanitize_text_field($_POST['language']);
                
            if(!isset($wdhLanguage)) {
                add_option('WDH_SVWE_language', $wdhNewLanguage);
            } else {
                update_option('WDH_SVWE_language', $wdhNewLanguage);
            }
            
            echo 'success'; die();
        }
        
        /*
         * Logout
         */
        function logout(){
             
            wp_logout();
             
            echo 'success'; die();
        }
        
        
        /*
         * Add Roll Back Options JS 
         */
        function addRollBackJS($used_type = 'website', $page){
            // Update Database
            global $wdhSVWE, $wpdb;
            $optionsRollBackJS = array();
            
            $wid           = $wdhSVWE['WEBSITE_ID'];
            $wdhPageUrl    = $this->clearPageUrl((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            $wdhPageOn     = $wdhSVWE['page_on'];
            $wdhRole       = $wdhSVWE['role'];

            if ($used_type == 'current_page') {
                $settingsCSS   = "SELECT * FROM ".WDHSVWE_Settings_table." where wid='".$wid."' AND used_for='current_page' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' LIMIT 1";
                $resultSettings= $wpdb->get_results($settingsCSS);
                $historySQL    = "SELECT * FROM `".WDHSVWE_History_table."` where used_for='".$used_type."' AND page_url='".$page."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
                $result        = $wpdb->get_results($historySQL);
            } else {
                $settingsCSS    = "SELECT * FROM ".WDHSVWE_Settings_table." where wid='".$wid."' AND used_for='website' LIMIT 1";
                $resultSettings = $wpdb->get_results($settingsCSS);
                $historySQL     = "SELECT * FROM `".WDHSVWE_History_table."` where used_for='".$used_type."'";
                $result         = $wpdb->get_results($historySQL);
            }
            $wdhCurrentSettings = '';

            // Get Settings
            // ---------------------------------------------------------
            foreach ($resultSettings as $row) {
                $row = (array)$row;
                $wdhCurrentSettings = $row['roll_back'];
            }

            if ($wdhCurrentSettings == 'original') {
                array_push($optionsRollBackJS, '<option value="original" selected="selected">'.$wdhSVWE['TXT_EM_PUBLISH_ORIGINAL'].'</option>');
            } else {
                array_push($optionsRollBackJS, '<option value="original">'.$wdhSVWE['TXT_EM_PUBLISH_ORIGINAL'].'</option>');
            }

            // List all History Options
            // ---------------------------------------------------------
            foreach ($result as $row) {
                $row = (array)$row;
                
                if ($wdhCurrentSettings == $row['unix_created_date']) {
                    array_push($optionsRollBackJS, '<option value="'.$row['unix_created_date'].'" selected="selected">'.$row['created_date_full'].'</option>');
                } else {
                    array_push($optionsRollBackJS, '<option value="'.$row['unix_created_date'].'">'.$row['created_date_full'].'</option>');
                }
            }
            
            if ($wdhCurrentSettings == 'latest') {
                array_push($optionsRollBackJS, '<option value="latest" selected="selected">'.$wdhSVWE['TXT_EM_PUBLISH_LATEST'].'</option>');
            } else {
                array_push($optionsRollBackJS, '<option value="latest">'.$wdhSVWE['TXT_EM_PUBLISH_LATEST'].'</option>');
            }
            
            return "window.history_".$used_type." ='".implode('', $optionsRollBackJS)."';";
        }
        
        /*
         * Roll Back Design
         */
        function rollBack(){
            // Update Database
            global $wdhSVWE, $wpdb;
            $wid                = $wdhSVWE['WEBSITE_ID'];
            $wdhRollBackFor     = sanitize_text_field($_POST['wdhRollBackFor']);
            $wdhRollBackAt      = sanitize_text_field($_POST['wdhRollBackAt']);
            $wdhPageUrl         = sanitize_text_field($this->clearPageUrl($_POST['wdhPageUrl']));
            $wdhSVWE['page_on'] = sanitize_text_field($_POST['wdhPageOn']);
            $wdhPageOn          = $wdhSVWE['page_on'];
            $wdhSVWE['role']    = sanitize_text_field($_POST['wdhRole']);
            $wdhRole            = $wdhSVWE['role'];
            
            // UPDATE
            if ($wdhRollBackFor == 'website') {
                $updateRollBack = "UPDATE `".WDHSVWE_Settings_table."` SET roll_back='".$wdhRollBackAt."' WHERE wid='".$wid."' AND used_for='".$wdhRollBackFor."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
            } else {
                $updateRollBack = "UPDATE `".WDHSVWE_Settings_table."` SET roll_back='".$wdhRollBackAt."' WHERE wid='".$wid."' AND used_for='".$wdhRollBackFor."' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
            }

            $wpdb->query($updateRollBack);
            
            echo 'success'; die();
        }
        
        /*
         * Delete Design
         */
        function delete(){
            // Delete Design/Changes Database
            global $wdhSVWE, $wpdb;
            $wid              = $wdhSVWE['WEBSITE_ID'];
            $deleteDesignType = sanitize_text_field($_POST['deleteDesignType']);
            $deleteDesignFor  = sanitize_text_field($_POST['deleteDesignFor']);
            $deleteDesignAt   = sanitize_text_field($_POST['deleteDesignAt']);
            $wdhPageUrl       = sanitize_text_field($this->clearPageUrl($_POST['wdhPageUrl']));
            
            if ($deleteDesignType == 'unsaved') {
                // DELETE TEMPORARY CSS
                // ---------------------------------------------------------
                $deleteTemporarryCSS = "DELETE FROM ".WDHSVWE_Temporary_CSS_table;
                $wpdb->query($deleteTemporarryCSS);
            } else {
                $this->deleteHistory($deleteDesignType, $deleteDesignFor, $deleteDesignAt, $wdhPageUrl);
            }

            echo 'success'; die();
        }
        
        function deleteHistory($deleteDesignType, $deleteDesignFor, $deleteDesignAt, $wdhPageUrl){
            global $wdhSVWE, $wpdb;
            $wid        = $wdhSVWE['WEBSITE_ID'];
            // Generate CSS Files
            $wdhSVWE['page_on'] = sanitize_text_field($_POST['wdhPageOn']);
            $wdhPageOn          = $wdhSVWE['page_on'];
            $wdhSVWE['role']    = sanitize_text_field($_POST['wdhRole']);
            $wdhRole            = $wdhSVWE['role'];
                
            if($deleteDesignFor == 'website') {

                if ($deleteDesignAt != 'all'){
                    $prevHistory = $this->getHistory('prev','unix_created_date', $deleteDesignFor, $deleteDesignAt, $wdhPageUrl);
                    $nextHistory = $this->getHistory('next','unix_created_date', $deleteDesignFor, $deleteDesignAt, $wdhPageUrl);

//                        if($nextHistory > 0){
//                            // UPDATE CSS
//                            // ---------------------------------------------------------
//                            $updateCSS = "UPDATE wdh_svwe_css SET status='deleted' where unix_created_date='".$deleteDesignAt."'";
//                            $wpdb->query($updateCSS);
//                        } else {
                        // DELETE CSS
                        // ---------------------------------------------------------
                        $deleteCSS = "DELETE FROM ".WDHSVWE_CSS_table." where wid='".$wid."' AND unix_created_date='".$deleteDesignAt."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
                        $wpdb->query($deleteCSS);
//                        }

                    // DELETE HISTORY CSS
                    // ---------------------------------------------------------
                    $deleteCSS = "DELETE FROM ".WDHSVWE_History_table." where wid='".$wid."' AND used_for='".$deleteDesignFor."' AND unix_created_date='".$deleteDesignAt."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
                    $wpdb->query($deleteCSS);

                    // UPDATE SETTINGS
                    // ---------------------------------------------------------
                    $updateToHistory = 'latest';

                    if ($prevHistory > 0){
                        $updateToHistory = $prevHistory;
                    } else if($nextHistory > 0){
                        $updateToHistory = $nextHistory;
                    }

                    // UPDATE
                    $updateSettings = "UPDATE `".WDHSVWE_Settings_table."` SET roll_back='".$updateToHistory."' where wid='".$wid."' AND used_for='".$deleteDesignFor."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
                    $wpdb->query($updateSettings);

                    // Delete CSS File
                    $styleFile = WP_CONTENT_DIR."/wdhsvwe/css/style.".$deleteDesignFor.".".$wdhPageOn.".".$wdhRole.".".$deleteDesignAt.".min.css";
                    
                    if (file_exists($styleFile)) {
                        unlink($styleFile);
                    }
                } else {
                    $historySQL     = "SELECT * FROM `".WDHSVWE_History_table."` where used_for='".$deleteDesignFor."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date DESC";
                    $result         = $wpdb->get_results($historySQL);

                    // Get Settings
                    // ---------------------------------------------------------
                    foreach ($result as $row) {
                        $row = (array)$row;
                        // DELETE CSS
                        // ---------------------------------------------------------
                        $deleteDesignAt = $row['unix_created_date'];
                        $deleteCSS = "DELETE FROM ".WDHSVWE_CSS_table." where wid='".$wid."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND unix_created_date='".$deleteDesignAt."'";
                        $wpdb->query($deleteCSS);

                        // Delete CSS File
                        $styleFile = WP_CONTENT_DIR."/wdhsvwe/css/style.".$deleteDesignFor.".".$wdhPageOn.".".$wdhRole.".".$deleteDesignAt.".min.css";
                        
                        if (file_exists($styleFile)) {
                            unlink($styleFile);
                        }
                    }

                    // DELETE HISTORY CSS
                    // ---------------------------------------------------------
                    $deleteCSS = "DELETE FROM ".WDHSVWE_History_table." where wid='".$wid."' AND used_for='".$deleteDesignFor."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
                    $wpdb->query($deleteCSS);

                    // UPDATE SETTINGS
                    // ---------------------------------------------------------
                    $updateToHistory = 'latest';
                    // UPDATE
                    $updateSettings = "UPDATE `".WDHSVWE_Settings_table."` SET roll_back='".$updateToHistory."' where wid='".$wid."' AND used_for='".$deleteDesignFor."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
                    $wpdb->query($updateSettings);
                }
            } else {

                if ($deleteDesignAt != 'all'){
                    $prevHistory = $this->getHistory('prev','unix_created_date', $deleteDesignFor, $deleteDesignAt, $wdhPageUrl);
                    $nextHistory = $this->getHistory('next','unix_created_date', $deleteDesignFor, $deleteDesignAt, $wdhPageUrl);

                    $currentHistoryID = $this->getHistory('current','id', $deleteDesignFor, $deleteDesignAt, $wdhPageUrl);

//                        if($nextHistory > 0){
//                            // UPDATE CSS
//                            // ---------------------------------------------------------
//                            $updateCSS = "UPDATE wdh_svwe_css SET status='deleted' where unix_created_date='".$deleteDesignAt."'";
//                            $wpdb->query($updateCSS);
//                        } else {
                    // DELETE CSS
                    // ---------------------------------------------------------
                    $deleteCSS = "DELETE FROM ".WDHSVWE_CSS_table." where wid='".$wid."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND unix_created_date='".$deleteDesignAt."'";
                    $wpdb->query($deleteCSS);
//                        }

                    // DELETE HISTORY CSS
                    // ---------------------------------------------------------
                    $deleteCSS = "DELETE FROM ".WDHSVWE_History_table." where used_for='".$deleteDesignFor."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND unix_created_date='".$deleteDesignAt."'";
                    $wpdb->query($deleteCSS);

                    // UPDATE SETTINGS
                    // ---------------------------------------------------------
                    $updateToHistory = 'latest';

                    if ($prevHistory > 0){
                        $updateToHistory = $prevHistory;
                    } else if($nextHistory > 0){
                        $updateToHistory = $nextHistory;
                    }

                    // UPDATE
                    $updateSettings = "UPDATE `".WDHSVWE_Settings_table."` SET roll_back='".$updateToHistory."' where wid='".$wid."' AND used_for='".$deleteDesignFor."' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
                    $wpdb->query($updateSettings);

                    // Delete CSS File
                    $styleFile = WP_CONTENT_DIR."/wdhsvwe/css/style.".$currentHistoryID.".".$wdhPageOn.".".$wdhRole.".".$deleteDesignAt.".min.css";
                    
                    if (file_exists($styleFile)) {
                        unlink($styleFile);
                    }
                } else {
                    $historySQL     = "SELECT * FROM `".WDHSVWE_History_table."` where wid='".$wid."' AND used_for='".$deleteDesignFor."' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date DESC";
                    $result         = $wpdb->get_results($historySQL);

                    // Get Settings
                    // ---------------------------------------------------------
                    foreach ($result as $row) {
                        $row = (array)$row;
                        // DELETE CSS
                        // ---------------------------------------------------------
                        $deleteDesignAt = $row['unix_created_date'];
                        $deleteCSS = "DELETE FROM ".WDHSVWE_CSS_table." where wid='".$wid."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND unix_created_date='".$deleteDesignAt."'";
                        $wpdb->query($deleteCSS);
                        
                        // Delete CSS File
                        $styleFile = WP_CONTENT_DIR."/wdhsvwe/css/style.".$row['id'].".".$wdhPageOn.".".$wdhRole.".".$deleteDesignAt.".min.css";
                        
                        if (file_exists($styleFile)) {
                            unlink($styleFile);
                        }
                    }

                    // DELETE HISTORY CSS
                    // ---------------------------------------------------------
                    $deleteCSS = "DELETE FROM ".WDHSVWE_History_table." where wid='".$wid."' AND used_for='".$deleteDesignFor."' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
                    $wpdb->query($deleteCSS);

                    // UPDATE SETTINGS
                    // ---------------------------------------------------------
                    $updateToHistory = 'latest';
                    // UPDATE
                    $updateSettings = "UPDATE `".WDHSVWE_Settings_table."` SET roll_back='".$updateToHistory."' where wid='".$wid."' AND used_for='".$deleteDesignFor."' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
                    $wpdb->query($updateSettings);
                }
            }
        }
        
        function getHistory($type,$return = 'unix_created_date', $used_type, $created_date = '', $wdhPageUrl = ''){
            global $wdhSVWE, $wpdb;
            $wid              = $wdhSVWE['WEBSITE_ID'];
            $wdhPageOn        = $wdhSVWE['page_on'];
            $wdhRole          = $wdhSVWE['role'];
            
            if ($used_type == 'website') {

                if ($type == 'prev') {
                    $historySQL     = "SELECT * FROM `".WDHSVWE_History_table."` where used_for='".$used_type."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date DESC";
                    $result         = $wpdb->get_results($historySQL);

                    // Get Settings
                    // ---------------------------------------------------------
                    foreach ($result as $row) {
                        $row = (array)$row;
                        
                        if($row['unix_created_date'] < $created_date) {
                            return $row[$return]; die();
                        }

                    }
                } else if($type == 'next') {
                    $historySQL     = "SELECT * FROM `".WDHSVWE_History_table."` where used_for='".$used_type."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date ASC";
                    $result         = $wpdb->get_results($historySQL);

                    // Get Settings
                    // ---------------------------------------------------------
                    foreach ($result as $row) {
                        $row = (array)$row;
                        
                        if($row['unix_created_date'] > $created_date) {
                            return $row[$return]; die();
                        }

                    }
                } else if($type == 'latest') {
                    $historySQL     = "SELECT * FROM `".WDHSVWE_History_table."` where used_for='".$used_type."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date DESC LIMIT 1";
                    $result         = $wpdb->get_results($historySQL);

                    // Get Settings
                    // ---------------------------------------------------------
                    foreach ($result as $row) {
                        $row = (array)$row;
                        
                        return $row[$return]; die();
                    }
                } else if($type == 'current') {
                    $historySQL     = "SELECT * FROM `".WDHSVWE_History_table."` where wid='".$wid."' AND used_for='".$used_type."' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date DESC LIMIT 1";
                    $result         = $wpdb->get_results($historySQL);

                    // Get Settings
                    // ---------------------------------------------------------
                    foreach ($result as $row) {
                        $row = (array)$row;
                        
                        return $row[$return]; die();
                    }
                }
            } else {

                if ($type == 'prev') {
                    $historySQL     = "SELECT * FROM `".WDHSVWE_History_table."` where used_for='".$used_type."' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date DESC";
                    $result         = $wpdb->get_results($historySQL);

                    // Get Settings
                    // ---------------------------------------------------------
                    foreach ($result as $row) {
                        $row = (array)$row;
                        
                        if($row['unix_created_date'] < $created_date) {
                            return $row[$return]; die();
                        }

                    }
                } else if($type == 'next') {
                    $historySQL     = "SELECT * FROM `".WDHSVWE_History_table."` where used_for='".$used_type."' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date ASC";
                    $result         = $wpdb->get_results($historySQL);

                    // Get Settings
                    // ---------------------------------------------------------
                    foreach ($result as $row) {
                        $row = (array)$row;
                        
                        if($row['unix_created_date'] > $created_date) {
                            return $row[$return]; die();
                        }

                    }
                } else if($type == 'latest') {
                    $historySQL     = "SELECT * FROM `".WDHSVWE_History_table."` where used_for='".$used_type."' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date DESC LIMIT 1";
                    $result         = $wpdb->get_results($historySQL);

                    // Get Settings
                    // ---------------------------------------------------------
                    foreach ($result as $row) {
                        $row = (array)$row;
                        
                        return $row[$return]; die();
                    }
                } else if($type == 'current') {
                    $historySQL     = "SELECT * FROM `".WDHSVWE_History_table."` where wid='".$wid."' AND used_for='".$used_type."' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date DESC LIMIT 1";
                    $result         = $wpdb->get_results($historySQL);

                    // Get Settings
                    // ---------------------------------------------------------
                    foreach ($result as $row) {
                        $row = (array)$row;
                        
                        return $row[$return]; die();
                    }
                }
            }

            return 0;
        }
        
        function rgbToHex($rgb) {
            $hex  = str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

            return $hex;
        }
    }
}

?>