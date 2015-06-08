<?php
/*
Plugin Name: Synoptic Web Designer: best WordPress design tool
Version: 1.1
Plugin URI: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool/
Description: Synoptic Web Designer: best WordPress design tool helps you to edit/change the design of your website, admin/user dashboard, forms, woocommerce pages, events calendars, galleries, bbPress pages and others in just a few minutes (no coding needed).
Author: Web Developers House
Author URI: http://www.wdh.im

Change log:

        1.1 (2015-06-08)
 
     		* debug class - added
     		* extend class - added
                * google fonts - added

        1.0 (2015-05-25)
	
		* Initial release.
		
Installation: Upload the folder synoptic-web-designer-best-design-tool from the zip file to "wp-content/plugins/" and activate the plugin in your wp-admin panel or upload synoptic-web-designer-best-design-tool.zip in the "Add new" area.
 */

    include_once 'wdh.svwe.debug.php';
    include_once 'svwe-config.php';
    include_once 'wdh.libs.php';
    include_once 'wdh.svwe.main.php';
    include_once 'wdh.svwe.extend.php';
    include_once 'wdh.svwe.css.php';
    include_once 'wdh.svwe.js.php';
    include_once 'wdh.svwe.panel.php';
    include_once 'wdh.svwe.uninstall.php';
    
    // WDH WP EDFP LIBRARY
    include_once 'wdhedfp/wdh.edfp.php';
    
    global $wdhSVWE_debug, $wdhSVWE, $wdhSVWE_extend, $wdhSVWE_plugin, $wdhSVWE_panel, $wdhLibs, $wdhSVWE_CSS, $wdhSVWE_JS, $WDH_EDFP;
    
    if (class_exists("wdhSVWE_Debug")){
        $wdhSVWE_debug = new wdhSVWE_Debug();
    }
    
    // Set Icons
    $wdhSVWE['ICON_PM_TEXT_SETTINGS']    = 'icon-text-settings';
    $wdhSVWE['ICON_PM_BOX_SETTINGS']     = 'icon-box-settings';
    
    // EXTRA GROUPS
    $wdhSVWE['WDH_SVWE_EXTRA_GROUPS'] = '';
    
    // EXTRA FIELDS
    $wdhSVWE['WDH_SVWE_EXTRA_FIELDS'] = array();
    
    // Get selected language
    $wdh_svwe_language = get_option('WDH_SVWE_language');

    if (isset($wdh_svwe_language) && $wdh_svwe_language != ''){
       $wdhSVWE['LANGUAGE'] = $wdh_svwe_language;
    }

    if (class_exists("WdhEditFieldDb")){
        $WDH_EDFP = new WdhEditFieldDb();
    }

    if (class_exists("wdhSVWE")){
        $wdhSVWE_plugin = new wdhSVWE();
    }

    if (class_exists("wdhSVWE_Extend")){
        $wdhSVWE_extend = new wdhSVWE_Extend();
    }
    
    if (!class_exists("wdhLibs") && !isset($wdhLibs)) {
        $wdhLibs = new wdhLibs();
    }
    
    if (!class_exists("wdhSVWE_CSS") && !isset($wdhSVWE_CSS)) {
        $wdhSVWE_CSS = new wdhSVWE_CSS();
    }
    
    if (!class_exists("wdhSVWE_JS")) {
        $wdhSVWE_JS = new wdhSVWE_JS();
    }
    
    if (!class_exists("wdhSVWE_Panel") || !isset($wdhSVWE_panel)) {
        $wdhSVWE_panel = new wdhSVWE_Panel();
    }

    // Language File
    include_once 'languages/'.$wdhSVWE['LANGUAGE'].'.php';
    require_once 'wdhedfp/languages/'.$wdhSVWE['LANGUAGE'].'.php';
    
    if (isset($wdhSVWE_plugin)){// Requests
        
        if(isset($wdhSVWE_panel)) {
            // Display Panel
            add_action('wp_ajax_nopriv_wdh_svwe_display_panel', array(&$wdhSVWE_panel, 'display'));
            add_action('wp_ajax_wdh_svwe_display_panel', array(&$wdhSVWE_panel, 'display'));
        }
        
        // Paste Design
        add_action('wp_ajax_nopriv_wdh_svwe_paste', array(&$wdhSVWE_plugin, 'pasteDesign'));
        add_action('wp_ajax_wdh_svwe_paste', array(&$wdhSVWE_plugin, 'pasteDesign'));
        
        // Publish Design
        add_action('wp_ajax_nopriv_wdh_svwe_publish', array(&$wdhSVWE_plugin, 'publish'));
        add_action('wp_ajax_wdh_svwe_publish', array(&$wdhSVWE_plugin, 'publish'));
        
        // Roll Back Design
        add_action('wp_ajax_nopriv_wdh_svwe_roll_back', array(&$wdhSVWE_plugin, 'rollBack'));
        add_action('wp_ajax_wdh_svwe_roll_back', array(&$wdhSVWE_plugin, 'rollBack'));
        
        // Delete Design
        add_action('wp_ajax_nopriv_wdh_svwe_delete', array(&$wdhSVWE_plugin, 'delete'));
        add_action('wp_ajax_wdh_svwe_delete', array(&$wdhSVWE_plugin, 'delete'));
        
        // Resize Element
        add_action('wp_ajax_nopriv_wdh_svwe_resize', array(&$wdhSVWE_plugin, 'resize'));
        add_action('wp_ajax_wdh_svwe_resize', array(&$wdhSVWE_plugin, 'resize'));
        
        // Change Role
        add_action('wp_ajax_nopriv_wdh_svwe_change_role', array(&$wdhSVWE_plugin, 'changeRole'));
        add_action('wp_ajax_wdh_svwe_change_role', array(&$wdhSVWE_plugin, 'changeRole'));
        
        // Change Role
        add_action('wp_ajax_nopriv_wdh_svwe_change_language', array(&$wdhSVWE_plugin, 'changeLanguage'));
        add_action('wp_ajax_wdh_svwe_change_language', array(&$wdhSVWE_plugin, 'changeLanguage'));
        
        // Logout
        add_action('wp_ajax_nopriv_wdh_svwe_logout', array(&$wdhSVWE_plugin, 'logout'));
        add_action('wp_ajax_wdh_svwe_logout', array(&$wdhSVWE_plugin, 'logout'));
    }
    
// Uninstall Hook
register_uninstall_hook(__FILE__, 'wdhsvweUninstall');

?>