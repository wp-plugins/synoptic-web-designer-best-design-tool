<?php

/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: wdh.svwe.extend.php
 * File Description: Extend File
 * File Version: 1.0
 * Last Update File : 06.05.2015
 * ------------------------------------------------------------------- 
 */

if (!class_exists("wdhSVWE_Extend")) {
    
    class wdhSVWE_Extend {
        
        function wdhSVWE_Extend(){ // Constructor
        }
        
        /*
         * How to add a field
         * 
         * global $wdhSVWE_extend;
         * 
         * // Add fields
         * $wdhSVWE_extend->addFields($fields);
         * 
         * // Add fields for table like in example bellow
         * 
         *  // Animation Effect Field
            $fields[0]['table']     = 'css';                // table: general_settings, settings, history, css
            $fields[0]['name']      = 'animation_effect';   // field name
            $fields[0]['type']      = 'VARCHAR(128)';       // field type
            $fields[0]['default']   = '';                   // default value
            $fields[0]['collate']   = 'utf8_unicode_ci';    // collation
            $fields[0]['null']      = 'NOT NULL';           // NOT NULL or NULL
         * 
         * // Add fields
         * $wdhSVWE_extend->addFields($fields);
         */
        
        function addFields($fields = array()){
            
            foreach($fields as $key => $value) {
                
                switch ($fields[$key]['table']) {
                    case 'general_settings':
                        $fields[$key]['table'] = WDHSVWE_General_Settings_table;
                        $this->addField($fields[$key]);
                        break;
                    case 'settings':
                        $fields[$key]['table'] = WDHSVWE_Settings_table;
                        $this->addField($fields[$key]);
                        break;
                    case 'history':
                        $fields[$key]['table'] = WDHSVWE_History_table;
                        $this->addField($fields[$key]);
                        break;
                    case 'css':
                        $fields[$key]['table'] = WDHSVWE_CSS_table;
                        $this->addField($fields[$key]);
                        $fields[$key]['table'] = WDHSVWE_Temporary_CSS_table;
                        $this->addField($fields[$key]);
                        // Hover CSS
                        $fields[$key]['name'] = 'h_'.$fields[$key]['name'];
                        $this->addField($fields[$key]);
                        $fields[$key]['table'] = WDHSVWE_CSS_table;
                        $this->addField($fields[$key]);
                        break;
                }
            }
        }
        
        function addField($field){
            global $wpdb;
            
            $fieldExist = $wpdb->query('SHOW columns from '.$field['table'].' where field="'.$field['name'].'"');
            
            if($fieldExist < 1) {
                $wpdb->query('ALTER TABLE '.$field['table'].' ADD '.$field['name'].' '.$field['type'].' DEFAULT "'.$field['default'].'" COLLATE '.$field['collate'].' '.$field['null']);
            } else {
                $wpdb->query('ALTER TABLE '.$field['table'].' MODIFY '.$field['name'].' '.$field['type'].' DEFAULT "'.$field['default'].'" COLLATE '.$field['collate'].' '.$field['null']);
            }
        }
        
        function createPanelGroup($groups, $fields){
            global $wdhSVWE;
            $i = 0;
            $j = 0;
            $newGroup = array();
            $oldGroups = $wdhSVWE['WDH_SVWE_EXTRA_GROUPS'];
            $newFields = array();
            $oldFields = $wdhSVWE['WDH_SVWE_EXTRA_FIELDS'];
            
            if (!empty($oldGroups) && is_array($oldGroups)) {
                
                foreach($oldGroups as $key => $value) {
                    $newGroup[$i] = $oldGroups[$key];
                    $i++;
                }
            }
            
            foreach($groups as $key => $value) {
                $newGroup[$i] = $groups[$key];
                $i++;
            }
            
            if (!empty($oldFields) && is_array($oldFields)) {
                
                foreach($oldFields as $key => $value) {
                    $newFields[$j] = $oldFields[$key];
                    $i++;
                }
            }
            
            foreach($fields as $key => $value) {
                $newFields[$j] = $fields[$key];
                $i++;
            }
            
            $wdhSVWE['WDH_SVWE_EXTRA_GROUPS'] = str_replace('"',"'",json_encode((object)$newGroup));
            $wdhSVWE['WDH_SVWE_EXTRA_FIELDS'] = $fields;
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
        
    }
}

?>