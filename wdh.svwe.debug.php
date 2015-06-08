<?php

/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: wdh.svwe.debug.php
 * File Description: Debug Class File
 * File Version: 1.0
 * Last Update File : 10.05.2015
 * ------------------------------------------------------------------- 
 */

if (!class_exists("wdhSVWE_Debug")) {
    
    class wdhSVWE_Debug {
        
        function wdhSVWE_Debug(){ // Constructor
        }
        
        /* 
         * Add Debug Option
         */
        function add($name, $value){
            $optionName  = 'wdhsvwe_debug_'.$name;
            $optionExist = get_option($optionName);
            
            if(!isset($optionExist)) {
                add_option($optionName, $value);
            } else {
                update_option($optionName, $value);
            }
        }
        
        /* 
         * Show Debug Option
         */
        function show($name){
            $optionName = get_option('wdhsvwe_debug_'.$name);
            
            return $optionName;
        }
        
        /* 
         * Clear Debug Options
         */
        function clear(){
            global $wpdb;
            
            $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name like %s", 'wdhsvwe_debug_'));
        }
        
    }
}

?>