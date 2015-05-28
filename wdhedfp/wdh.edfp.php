<?php
//Project Name: WDH - Edit Database Field PRO (Ajax + PHP)
//Project Version: 2.6
//Project Description: Edit Database Field PRO is a web script which help you to display the field you want from database and you can edit it with Ajax ( without reloading page ).The Field can be edit in different types : text , textarea, select , radio button, date , slider, checkbox, switch on/off button, map, video, colorpicker, password, wsyghtml editor, image upload, file upload.Also you can add to the editable field filters ( is email , is url and others ).
//Project URL: http://www.wdh.im/projects/edit-database-field-pro/
//Author: WDH - Web Developers House
//Author URL: http://www.wdh.im/
//File: wdh.edfp.php
//File Description: Main PHP Class
//File Version: 2.6
//Last Update File : 01.06.2014
//
//Change log:
//
//
//        2.7 (2014-16-11)
//      
//              * Font Family Type added        
//              * Border Type added
//              * Size Type added
//              * Change Return Method ( echo -> array_push )
//              * Multiple Slider bug fixed
//
//        2.6 (2014-22-09)
//              
//              * MySQL deprecated fixed
//              * MySQLi added
//
//        2.5.1 (2014-01-06)
//              
//              * Form Generator with Payment compatibility added           
//              
//        2.5 (2014-11-04)
//              
//              * Plugins Allowed
//              * FASTER TOOLTIP ...
//              * Possibility to add distinct label and value in checkbox , select , radio : label 1@@value 1||label 2@@value 2
//              * JSON one level Value: for example you can use for this: {"id":5,"name":"Test"} ) but not for this: {"0":{"id":5,"name":"Test"},"1":{"id":6,"name":"Test 2"}}
//              
//        2.4 (2014-04-03)
//        
//              * disable reloading page action from enter button 
//              * image & file upload text added in languages
//              * xamp problem fixed ( config.php is renamed to: edfp-config.php )
//              * wdhHeadAutoInit function added ( autogenerate css & and js links for head section )
//              * sample2 added
//              * sample fixed
//              
//        2.3 (2014-01-03)
//
//              * CSS Templates : Black & Yellow template added
//              * Sample files added ( sample files, database and instructions ) 
//              * html_editor bug fixed
//              * is_unique bug fixed
//              * Config bugs fixed ( auto add & WDH_WEBSITE_URL )
//              * Session bugs fixed
//              
//        2.2 (2014-01-02)
//
//              * JS HOOKS : You can add javascript code after the value is changed or saved.
//              * Auto ADD Field : If don't find a field you can set auto_add true and the field will be created with values from conditions
//              * CSS Templating : You can create your own css template and integrate here very easy
//              * Multilanguge
//		
//        2.1 (2014-28-01)
//
//              * Autogenerate Video from 3 new video websites : Vimeo.com, DailyMotion.com, Metacafe.com 
//              * Autogenerate Video from 2 adult video websites : Redtube.com and Xvideos.com
//              * Filter is_adult_video ( set true if allow video from adult websites : redtube.com or xvideos.com )
//		
//        2.0 (2014-17-01)
//
//              * Edit type : file upload added
//              * Edit type : image ( image autoresize & upload ) added
//              * Edit type : html_editor ( WSYG HTML EDITOR ) added
//              * Edit type : password ( for changing password live ) added
//              * Display type : file url added
//              * Display type : image added
//              * Display type : password added
//              * Display type : html added
//              * Filter is_unique ( checking if is unique value from table x )
//              * SAFE TAGS added ( preventing XSS attacks )
//		* Video size bug fixed
//		
//        1.02 (2013-22-12)
//	
//		* Encrypt Database Login Details
//		
//        1.01 (2013-17-12)
//	
//		* check boxes bug fix
//		* video bug fix
//		
//        1.0 (2013-16-12)
//	
//		* Initial release.

if (!class_exists("WdhEditFieldDb")) {
    class WdhEditFieldDb
    {
        
        function WdhEditFieldDb($session_start = true)
        {
            ob_start();
            
            include_once 'edfp-config.php';
            
            global $wdhDB, $wdhFIELD, $wdhINPUT, $wdhTOOLTIP, $wdhFILTER, $wdhERROR, $wdhUPLOAD, $edfp, $wdhForm, $wdhSettings;
            
            if ($session_start  == true) {
                if (session_id() == ""){
                    session_start();
                }
            }

            if (!defined('WDHSVWE_URL')) {
                define('WDHSVWE_URL', WP_PLUGIN_URL.'/wdhsvwe/');
            }
            
            $wdhFIELD['WDH_WEBSITE_URL'] = WDHSVWE_URL.'wdhedfp/';
            
            define('EDFP_PATH', dirname(__FILE__) . '/');
        }
        
        function wdhHeadAutoInit(){
            // Add Admin CSS
            add_action('admin_enqueue_scripts', array(&$this, 'addCSS'));
            // Add Frontend CSS
            add_action('wp_enqueue_scripts', array(&$this, 'addCSS'));
            // Add Admin JS
            add_action('admin_enqueue_scripts', array(&$this, 'addJS'));
            // Add Frontend JS
            add_action('wp_enqueue_scripts', array(&$this, 'addJS'));
                
            // Save Field
            add_action('wp_ajax_nopriv_wdh_edit_field_db', array(&$this, 'wdhSaveDbFieldData'));
            add_action('wp_ajax_wdh_edit_field_db', array(&$this, 'wdhSaveDbFieldData'));
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
        
        function addCSS(){
            
            if($this->userIsAdmin()){
                // Register Styles.
                wp_register_style('WDH_jQuery_UI_CSS', plugins_url('css/jquery-ui.css', __FILE__));
                wp_register_style('WDH_ColorPicker_CSS', plugins_url('css/colorpicker.css', __FILE__));
                wp_register_style('WDH_Tooltip_CSS', plugins_url('css/wdh.im.tooltip.css', __FILE__));
                wp_register_style('WDH_EditDatabaseFieldPRO_CSS', plugins_url('templates/black_yellow/black_yellow.css', __FILE__));

                // Enqueue Styles.
                wp_enqueue_style('WDH_jQuery_UI_CSS');
                wp_enqueue_style('WDH_ColorPicker_CSS');
                wp_enqueue_style('WDH_Tooltip_CSS');
                wp_enqueue_style('WDH_EditDatabaseFieldPRO_CSS');
            }
        }
        
        function addJS(){
            
            if($this->userIsAdmin()){
                // Register JavaScript.
                wp_register_script('WDH_ColorPicker_JS', plugins_url('js/colorpicker.js', __FILE__), array('jquery'));
                wp_register_script('WDH_JSON2_JS', plugins_url('js/json2.js', __FILE__), array('jquery'));
                wp_register_script('WDH_Slider_JS', plugins_url('js/jquery-ui-slider.js', __FILE__), array('jquery'));
                wp_register_script('WDH_EditDatabaseFieldPRO_JS', plugins_url('js/jquery.wdh.im.edfp.js', __FILE__), array('jquery'));

                // Enqueue JavaScript.
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }

                if (!wp_script_is('jquery-ui-core', 'jquery')){
                    wp_enqueue_script('jquery-ui-core');
                }

                wp_enqueue_script('WDH_Slider_JS');

                if (!wp_script_is('jquery-ui-datepicker', 'queue')){
                    wp_enqueue_script('jquery-ui-datepicker');
                }

                if (!wp_script_is('jquery-ui-tooltip', 'queue')){
                    wp_enqueue_script('jquery-ui-tooltip');
                }

                wp_enqueue_script('WDH_ColorPicker_JS');
                wp_enqueue_script('WDH_JSON2_JS');
                wp_enqueue_script('WDH_EditDatabaseFieldPRO_JS');
            }
        }
        
        function wdhfield($wdhDB, $wdhFIELD, $wdhJSONCheck = 'yes'){
            global $wpdb;
            $table        = $wdhDB['table'];
            $fieldname    = $wdhFIELD['field_name'];
            $conditions   = $wdhFIELD['conditions'];
            $i            = 0;
            $conditionAll = '';
            
            foreach ($conditions as $condition) {
                
                if($condition['field_added'] == 'false'){
                    
                    if ($i < 1) {
                        $conditionAll .= $condition['field_label'] . '="' . $condition['field_value'] . '"';
                    } else {
                        $conditionAll .= ' ' . $condition['field_condition'] . ' ' . $condition['field_label'] . '="' . $condition['field_value'] . '"';
                    }
                    $i++;
                }
            }
            
            $query = 'SELECT * FROM ' . $table . ' WHERE ' . $conditionAll . ' LIMIT 1';
            $row = $wpdb->get_row($query, ARRAY_A);
            $field = $row[$fieldname];
            
            // JSON Field Value
            if ($wdhJSONCheck == 'yes'){
                if ($wdhFIELD['json_value'] != ''){
                    $fieldJSON = $wdhFIELD['json_value'];
                    $field = json_decode($field);
                    $field = $field->$fieldJSON;
                }
            }
            
            if ($field == "") {
                $field = "...............";
            }
            
            return $field;
        }
        
        function wdhExistField($wdhDB, $wdhFIELD){
            global $wpdb;
            
            $table        = $wdhDB['table'];
            $fieldname    = $wdhFIELD['field_name'];
            $conditions   = $wdhFIELD['conditions'];
            $i            = 0;
            $conditionAll = '';
            
            foreach ($conditions as $condition) {
                    
                if($condition['field_added'] == 'false'){
                    
                    if ($i < 1) {
                        $conditionAll .= $condition['field_label'] . '="' . $condition['field_value'] . '"';
                    } else {
                        $conditionAll .= ' ' . $condition['field_condition'] . ' ' . $condition['field_label'] . '="' . $condition['field_value'] . '"';
                    }
                }
                $i++;
            }
            
            $query = 'SELECT * FROM ' . $table . ' WHERE ' . $conditionAll . ' LIMIT 1';
            $result = $wpdb->get_results($query); 
            $no = 0;
            
            foreach ($result as $row) {
                $no++;
            }
            
            return $no;
        }
        
        function wdhExistFieldValue($wdhDB, $wdhFIELD, $fieldValue){
            global $wpdb;
            
            $table        = $wdhDB['table'];
            $fieldname    = $wdhFIELD['field_name'];
            $conditions   = $wdhFIELD['conditions'];
            $i            = 0;
            $conditionAll = '';
            
            $query = 'SELECT * FROM ' . $table . ' WHERE ' . $fieldname . '="' . $fieldValue . '"';
            
            $result = $wpdb->get_restuls($query);
            $no = 0;
            // Print out result
            foreach ($result as $row) {
                $no++;
            }
            
            return $no;
        }
        
        function wdhAddField($wdhDB, $wdhFIELD){
            global $wpdb;
            
            $table        = $wdhDB['table'];
            $fieldname    = $wdhFIELD['field_name'];
            $conditions   = $wdhFIELD['conditions'];
            $fields_label = '';
            $fields_value = '';
            $fieldAdded   = false;
            $value        = '';
            $i            = 0;
            
            foreach ($conditions as $condition) {
                
                if ($fieldname != $condition['field_label']) {
                    $fieldAdded = true;
                }
                    
                if ($i < 1) {
                    $fields_label .= $condition['field_label'];
                    $fields_value .= '"' . $condition['field_value'] . '"';
                } else {
                    $fields_label .= ',' . $condition['field_label'];
                    $fields_value .= ',"' . $condition['field_value'] . '"';
                }
                $i++;
            }
            
            if ($fieldAdded == false) {
                $query = 'INSERT INTO ' . $table . ' (' . $fieldname . ',' . $fields_label . ') 
                         VALUES("",' . $fields_value . ')';
            } else {
                $query = 'INSERT INTO ' . $table . ' (' . $fields_label . ') 
                         VALUES(' . $fields_value . ')';
            }
            
            $wpdb->query($query);
        }
        
        function wdhShowField($wdhDB, $wdhFIELD, $wdhINPUT, $wdhTOOLTIP, $wdhFILTER, $wdhERROR, $wdhUPLOAD){
            global $wpdb;
            $table             = $wdhDB['table'];
            $fieldname         = $wdhFIELD['field_name'];
            $conditions        = $wdhFIELD['conditions'];
            $autoAddField      = $wdhFIELD['auto_add'];
            $wfieldvalue       = '';
            $title             = $wdhTOOLTIP['text'];
            $inputType         = $wdhINPUT['type'];
            $tooltipType       = $wdhTOOLTIP['position'];
            $submitText        = $wdhINPUT['save_button'];
            $valuesList        = $wdhINPUT['values'];
            $fieldHTML         = array();
            // Encrypt
            $wdhDB['host']     = $this->wdhEncrypt($wdhDB['host'], $wdhDB['key']);
            $wdhDB['database'] = $this->wdhEncrypt($wdhDB['database'], $wdhDB['key']);
            $wdhDB['user']     = $this->wdhEncrypt($wdhDB['user'], $wdhDB['key']);
            $wdhDB['password'] = $this->wdhEncrypt($wdhDB['password'], $wdhDB['key']);
            $wdhDB_json        = json_encode($wdhDB);
            // Adding TOKEN
            if (session_id() == ""){
                session_start();
            }
            $token_value                     = md5(date('Y-m-d H:i'));
            $_SESSION['token_' . $fieldname] = $token_value;
            $wdhFIELD['token']               = $token_value;
            $wdhFIELD_json                   = json_encode($wdhFIELD);
            $wdhINPUT_json                   = json_encode($wdhINPUT);
            $wdhTOOLTIP_json                 = json_encode($wdhTOOLTIP);
            $wdhFILTER_json                  = json_encode($wdhFILTER);
            $wdhERROR_json                   = json_encode($wdhERROR);
            $wdhUPLOAD_json                  = json_encode($wdhUPLOAD);
            
            $i = 0;
            
            foreach ($conditions as $condition) {
                
                if ($i < 1) {
                    $wfieldvalue .= $condition['field_label'];
                } else {
                    $wfieldvalue .= '-' . $condition['field_label'];
                }
                $i++;
            }
            
            $fieldFound = $this->wdhExistField($wdhDB, $wdhFIELD);
            
            if ($autoAddField == true) {
                
                // Add field
                if ($fieldFound < 1) {
                    $this->wdhAddField($wdhDB, $wdhFIELD);
                    $fieldFound = 1;
                }
            }
            
            // Verify if field exist
            if ($fieldFound > 0) {
                
                $jWDH  = '$jWDH';
                $class = $wdhFIELD['class'];
                
                // DISPLAY & EDIT
                if ($wdhFIELD['edit'] == true) {
                    
                    if ($wdhINPUT['type'] == 'colorpicker') {
                        $addClass = 'wdh-colorpicker-preview';
                        $addStyle = 'background:#';
                        
                        if (isset($title) || $title != '') {
                            $tooltip = "<span class='wdh-tooltip'><span class='wdh-information'>".$title."</span></span>";
                        }
                        
                        array_push($fieldHTML,  "<span id='wdh-field-" . $fieldname . "-" . $wfieldvalue . "' class='wdh-field " . $class . " " . $addClass . "' style='" . $addStyle . str_replace('m@@','',$this->wdhfield($wdhDB, $wdhFIELD)) . ";' title='" . $title . "'>&nbsp;</span>");
                        array_push($fieldHTML,  '<div class="wdh-field" style="float:left;">'.$tooltip.'</div>');
                        array_push($fieldHTML,  "<script type='text/javascript'>
                                var request_url = '" .admin_url('admin-ajax.php'). "';
                                    window.website_url = '" . $wdhFIELD['WDH_WEBSITE_URL'] . "';
                                $jWDH('#wdh-field-" . $fieldname . "-" . $wfieldvalue . "').wdhEditDbFieldColorPicker('" . $wdhDB_json . "','" . $wdhFIELD_json . "','" . $wdhINPUT_json . "','" . $wdhTOOLTIP_json . "','" . $wdhFILTER_json . "','" . $wdhERROR_json . "','" . $wdhUPLOAD_json . "','" . str_replace('m@@','',$this->wdhfield($wdhDB, $wdhFIELD)) . "','" . $wfieldvalue . "');
                              </script>");
                    } else  if ($wdhINPUT['type'] == 'font') {
                        $value = $this->wdhGFontsName(str_replace('m@@','',$this->wdhfield($wdhDB, $wdhFIELD)));
                        
                        if (isset($title) || $title != '') {
                            $tooltip = "<span class='wdh-tooltip'><span class='wdh-information'>".$title."</span></span>";
                        }
                        
                        array_push($fieldHTML, "<span id='wdh-field-" . $fieldname . "-" . $wfieldvalue . "' class='wdh-field " . $class . "'><span style='float:left;'>" . $value . "</span> ".$tooltip." </span>");
                        
                        $value = str_replace('m@@','',$this->wdhfield($wdhDB, $wdhFIELD));
                        array_push($fieldHTML, "<script type='text/javascript'>
                                var request_url = '" .admin_url('admin-ajax.php'). "';
                                    window.website_url = '" . $wdhFIELD['WDH_WEBSITE_URL'] . "';
                                $jWDH('#wdh-field-" . $fieldname . "-" . $wfieldvalue . "').wdhEditDbField('" . $wdhDB_json . "','" . $wdhFIELD_json . "','" . $wdhINPUT_json . "','" . $wdhTOOLTIP_json . "','" . $wdhFILTER_json . "','" . $wdhERROR_json . "','" . $wdhUPLOAD_json . "','" . $value . "','" . $wfieldvalue . "');
                              </script>");
                        // ALL
                    } else {
                        
                        $value = str_replace('m@@','',$this->wdhfield($wdhDB, $wdhFIELD));
                        
                        if (isset($title) || $title != '') {
                            $tooltip = "<span class='wdh-tooltip'><span class='wdh-information'>".$title."</span></span>";
                        }
                        
                        array_push($fieldHTML, "<span id='wdh-field-" . $fieldname . "-" . $wfieldvalue . "' class='wdh-field " . $class . "'><span style='float:left;'>" . $value . "</span> ".$tooltip." </span>");
                        array_push($fieldHTML, "<script type='text/javascript'>
                                var request_url = '" .admin_url('admin-ajax.php'). "';
                                    window.website_url = '" . $wdhFIELD['WDH_WEBSITE_URL'] . "';
                                $jWDH('#wdh-field-" . $fieldname . "-" . $wfieldvalue . "').wdhEditDbField('" . $wdhDB_json . "','" . $wdhFIELD_json . "','" . $wdhINPUT_json . "','" . $wdhTOOLTIP_json . "','" . $wdhFILTER_json . "','" . $wdhERROR_json . "','" . $wdhUPLOAD_json . "','" . str_replace('m@@','',$this->wdhfield($wdhDB, $wdhFIELD)) . "','" . $wfieldvalue . "');
                              </script>");
                    }
                    // DISPLAY ONLY
                } else {
                    
                    // COLORPICKER
                    if ($wdhINPUT['type'] == 'colorpicker') {
                        $addClass = 'wdh-colorpicker-preview';
                        $addStyle = 'background:#';
                        echo "<span id='wdh-field-" . $fieldname . "-" . $wfieldvalue . "' class='wdh-field " . $class . " " . $addClass . "' style='" . $addStyle . str_replace('m@@','',$this->wdhfield($wdhDB, $wdhFIELD)) . ";cursor:inherit;'>&nbsp;</span>";
                        
                       // ALL   
                    } else {
                        $value = str_replace('m@@','',$this->wdhfield($wdhDB, $wdhFIELD));
                        
                        // CHECKBOX
                        if ($wdhINPUT['type'] == 'checkbox') {
                            $value = str_replace('#', ',', $value);
                        }
                        echo "<span id='wdh-field-" . $fieldname . "-" . $wfieldvalue . "' class='wdh-field " . $class . "' style='cursor:inherit;'>" . $value . "</span>";
                    }
                    
                }
            } else {
                $class = $wdhFIELD['class'];
                echo "<span id='wdh-field-" . $fieldname . "-" . $wfieldvalue . "' class='wdh-error " . $class . "' style='cursor:inherit;'>" . $wdhFIELD['not_exist'] . "</span>";
            }
            
            return implode('', $fieldHTML);
        }
        
        function wdhSaveDbFieldData(){
            global $wpdb, $wdhFIELD;
            // Saving Data
            $wdhDB_mod         = sanitize_text_field($_POST['wdhDB_json']);
            $wdhDB_mod         = (object)json_decode(stripslashes($wdhDB_mod));
            $wdhFIELD_mod      = sanitize_text_field($_POST['wdhFIELD_json']);
            $wdhFIELD_mod      = (object)json_decode(stripslashes($wdhFIELD_mod));
            
            $value     = sanitize_text_field($_POST['value']);
            $value     = str_replace('...............#','',$value);
            $value     = str_replace('#...............','',$value);
            $value     = str_replace('...............','',$value);
            $type      = sanitize_text_field($_POST['type']);
            $is_unique = sanitize_text_field($_POST['is_unique']);
            
            // Mysql connection data define
            $wdhDB['table'] = $wdhDB_mod->table;

            // Field define
            $wdhFIELD['field_name'] = $wdhFIELD_mod->field_name;
            $wdhFIELD['conditions'] = array();
            $conditionIs = array();
            $wdhFIELD['json_value'] = $wdhFIELD_mod->json_value;
            
            foreach ($wdhFIELD_mod->conditions as $condition){
                $conditionIs['field_added'] = $condition->field_added;
                $conditionIs['field_label'] = $condition->field_label;
                $conditionIs['field_value'] = $condition->field_value;
                $conditionIs['field_condition'] = $condition->field_condition;
                array_push($wdhFIELD['conditions'],$conditionIs);
            }
            
            $dbTable=$wdhDB['table'];
            $dbfieldName=$wdhFIELD['field_name'];
            $conditions = $wdhFIELD['conditions'];
            $i            = 0;
            $conditionAll = '';

            foreach ($conditions as $condition) {

                if($condition['field_added'] == 'false'){

                    if ($i < 1) {
                        $conditionAll .= $condition['field_label'] . '="' . $condition['field_value'] . '"';
                    } else {
                        $conditionAll .= ' ' . $condition['field_condition'] . ' ' . $condition['field_label'] . '="' . $condition['field_value'] . '"';
                    }
                    $i++;
                }
            }

            // XSS PROTECTION
            $value = $this->xss_cleaner($value);

            // Check if is unique
            if ($is_unique == 'true') {
                // Exist Field
                $fieldValueExist = $this->wdhExistFieldValue($wdhDB, $wdhFIELD, $value);

                if ($fieldValueExist > 0) {
                    echo 'field_exist';
                    die();
                }
            }
            
            $value = 'm@@'.$value;
            
            
            global $wdhSVWE;
            
            if ($wdhSVWE["WDH_DEFAULT_DEMO_MODE"] == 'true') {
                echo 'success'; die();
            }

            if ($type != 'map' && $type != 'video' && $type != 'is_in_db') {
                // Update field
                $query = 'UPDATE ' . $dbTable . ' SET ' . $dbfieldName . '="' . $value . '" WHERE ' . $conditionAll;

                if ($type == 'font' && (strpos($value,':') !== false)){
                    $fontSecond = explode(":",$value);
                    $fontWeight = intval($fontSecond[1]);
                    $fontStyle = str_replace($fontWeight, "", $fontSecond[1]);

                    if ($fontWeight < 1){
                        $fontWeight = 400;
                    }

                    if ($dbfieldName == 'text_font_family') {
                        $fontWeightText = 'text_font_weight';
                        $fontStyleText = 'text_font_style';
                    } else {
                        $fontWeightText = 'h_text_font_weight';
                        $fontStyleText = 'h_text_font_style';
                    }
                    // Update field
                    $query = 'UPDATE ' . $dbTable . ' SET ' . $dbfieldName . '="' . $value . '",'.$fontWeightText.'="'.$fontWeight.'", '.$fontStyleText.'="'.$fontStyle.'" WHERE ' . $conditionAll;
                }

                if ($type == 'border'){

                    if ($dbfieldName == 'box_border' || $dbfieldName == 'h_box_border') {

                        if ($dbfieldName == 'box_border') {
                            $boxBorderTopText = 'box_border_top';
                            $boxBorderLeftText = 'box_border_left';
                            $boxBorderRightText = 'box_border_right';
                            $boxBorderBottomText = 'box_border_bottom';
                        }

                        if ($dbfieldName == 'h_box_border') {
                            $boxBorderTopText = 'h_box_border_top';
                            $boxBorderLeftText = 'h_box_border_left';
                            $boxBorderRightText = 'h_box_border_right';
                            $boxBorderBottomText = 'h_box_border_bottom';
                        }
                       // Update field
                        $query = 'UPDATE ' . $dbTable . ' SET ' . $dbfieldName . '="' . $value . '",'.$boxBorderTopText.'="'.$value.'", '.$boxBorderLeftText.'="'.$value.'", '.$boxBorderRightText.'="'.$value.'", '.$boxBorderBottomText.'="'.$value.'" WHERE ' . $conditionAll;
                    }
                }

                // Border Radius
                if ($dbfieldName == 'box_border_radius') {
                    $boxBorderTopRadiusText = 'box_border_top_left_radius';
                    $boxBorderLeftRadiusText = 'box_border_top_right_radius';
                    $boxBorderRightRadiusText = 'box_border_bottom_left_radius';
                    $boxBorderBottomRadiusText = 'box_border_bottom_right_radius';
                    // Update field
                    $query = 'UPDATE ' . $dbTable . ' SET ' . $dbfieldName . '="' . $value . '",'.$boxBorderTopRadiusText.'="'.$value.'", '.$boxBorderLeftRadiusText.'="'.$value.'", '.$boxBorderRightRadiusText.'="'.$value.'", '.$boxBorderBottomRadiusText.'="'.$value.'" WHERE ' . $conditionAll;
                }

                // Border Radius
                if ($dbfieldName == 'h_box_border_radius') {
                    $boxBorderTopRadiusText = 'h_box_border_top_radius';
                    $boxBorderLeftRadiusText = 'h_box_border_left_radius';
                    $boxBorderRightRadiusText = 'h_box_border_right_radius';
                    $boxBorderBottomRadiusText = 'h_box_border_bottom_radius';
                    // Update field
                    $query = 'UPDATE ' . $dbTable . ' SET ' . $dbfieldName . '="' . $value . '",'.$boxBorderTopRadiusText.'="'.$value.'", '.$boxBorderLeftRadiusText.'="'.$value.'", '.$boxBorderRightRadiusText.'="'.$value.'", '.$boxBorderBottomRadiusText.'="'.$value.'" WHERE ' . $conditionAll;
                }

                // Border Color
                if ($dbfieldName == 'box_border_color') {
                    $boxBorderTopColorText = 'box_border_top_color';
                    $boxBorderLeftColorText = 'box_border_left_color';
                    $boxBorderRightColorText = 'box_border_right_color';
                    $boxBorderBottomColorText = 'box_border_bottom_color';
                    // Update field
                    $query = 'UPDATE ' . $dbTable . ' SET ' . $dbfieldName . '="' . $value . '",'.$boxBorderTopColorText.'="'.$value.'", '.$boxBorderLeftColorText.'="'.$value.'", '.$boxBorderRightColorText.'="'.$value.'", '.$boxBorderBottomColorText.'="'.$value.'" WHERE ' . $conditionAll;
                }

                // Border Color
                if ($dbfieldName == 'h_box_border_color') {
                    $boxBorderTopColorText = 'h_box_border_top_color';
                    $boxBorderLeftColorText = 'h_box_border_left_color';
                    $boxBorderRightColorText = 'h_box_border_right_color';
                    $boxBorderBottomColorText = 'h_box_border_bottom_color';
                    // Update field
                    $query = 'UPDATE ' . $dbTable . ' SET ' . $dbfieldName . '="' . $value . '",'.$boxBorderTopColorText.'="'.$value.'", '.$boxBorderLeftColorText.'="'.$value.'", '.$boxBorderRightColorText.'="'.$value.'", '.$boxBorderBottomColorText.'="'.$value.'" WHERE ' . $conditionAll;
                }

                $wpdb->query($query);

                echo 'success'; die();
            } else if ($type == 'map') {
                // Update field
                $query = 'UPDATE ' . $dbTable . ' SET ' . $dbfieldName . '="' . $value . '" WHERE ' . $conditionAll;

                $wpdb->query($query);
                $this->wdhGetCoordinates($value);
            } else if ($type == 'video') {

                $video_url  = "http://" . $value;
                $video_from = $this->wdhAutodetectVideo($video_url);
                $video      = array();
                $video_id   = '';

                switch ($video_from) {
                    // Youtube.com
                    case "1":
                        $video_id = $this->wdhYoutubeId($value);
                        break;
                    // Vimeo.com
                    case "2":
                        $video_id = $this->wdhVimeoId($value);
                        break;
                    case "3":
                        // Dailymotion.com
                        $video_id = $this->wdhDailymotionId($value);
                        break;
                    // Metacafe.com
                    case "4":
                        $video_id = $this->wdhMetacafeId($value);
                        break;
                    // Redtube.com
                    case "5":
                        $video_id = $this->wdhRedTubeId($value);
                        break;
                    // Xvideos.com
                    case "6":
                        $video_id = $this->wdhXvideosId($value);
                        break;
                }

                if (strlen($video_id) > 0) {

                    switch ($video_from) {
                        // Youtube.com
                        case "1":
                            $video_title = str_replace(" ", "", $this->wdhYoutubeTitle($video_id));
                            break;
                        // Vimeo.com
                        case "2":
                            $vimeoData   = $this->wdhVimeoData($video_id);
                            $video_title = str_replace(" ", "", $vimeoData[0]->title);
                            break;
                        // Dailymotion.com
                        case "3":
                            $video_title = $this->wdhDailymotionTitle($value);
                            break;
                        // Metacafe.com
                        case "4":
                            $video_title = $this->wdhShorter($this->wdhMetacafeTitle($video_url), 38);
                            break;
                        // Redtube.com
                        case "5":
                            $video_title = $this->wdhShorter($this->wdhRedTubeTitle($video_url), 38);
                            break;
                        // Xvideos.com
                        case "6":
                            $video_title = $this->wdhShorter($this->wdhXvideosTitle($video_url), 38);
                            break;
                    }

                    if (strlen($video_title) > 0) {
                        // Update field
                        $query = 'UPDATE ' . $dbTable . ' SET ' . $dbfieldName . '="' . $value . '" WHERE ' . $conditionAll;

                        $wpdb->query($query);
                        print_r($this->wdhReturnVideo($value));
                        die();
                    } else {
                        echo "wrong";
                    }

                } else {
                    echo "wrong";
                }
            }
            
            die();
        }
        
        
        // XSS CLEANER
        function xss_cleaner($input_str)
        {
            $return_str = str_replace(array(
                '<',
                '>',
                "'",
                '"',
                ')',
                '('
            ), array(
                '&lt;',
                '&gt;',
                '&apos;',
                '&#x22;',
                '&#x29;',
                '&#x28;'
            ), $input_str);
            $return_str = str_ireplace('%3Cscript', '', $return_str);
            return $return_str;
        }
        
        // VIDEO : YOUTUBE.com
        
        // Youtube Video ID
        function wdhYoutubeId($url)
        {
            $url   = str_replace("&amp;", "&", $url);
            $parts = parse_url($url);
            if (isset($parts['query'])) {
                parse_str($parts['query'], $qs);
                if (isset($qs['v'])) {
                    return $qs['v'];
                } else if ($qs['vi']) {
                    return $qs['vi'];
                }
            }
            if (isset($parts['path'])) {
                $path = explode('/', trim($parts['path'], '/'));
                return $path[count($path) - 1];
            }
            return false;
        }
        
        // Youtube Video Title
        function wdhYoutubeTitle($video_id)
        {
            $url = "http://gdata.youtube.com/feeds/api/videos/" . $video_id;
            $doc = new DOMDocument;
            $doc->load($url);
            $title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
            
            return $this->wdhShorter($title, 38);
        }
        
        function wdhReturnVideo($video_url)
        {
            $video_url  = "http://" . $video_url;
            $video_from = $this->wdhAutodetectVideo($video_url);
            $video      = array();
            $video_id   = '';
            
            switch ($video_from) {
                // Youtube.com
                case "1":
                    $video['id']    = $this->wdhYoutubeId($video_url);
                    $video_id       = $video['id'];
                    $video['title'] = $this->wdhYoutubeTitle($video_id);
                    $video['logo']  = 'youtube';
                    $video['image'] = 'http://img.youtube.com/vi/' . $video_id . '/0.jpg';
                    $video['type']  = '1';
                    break;
                // Vimeo.com
                case "2":
                    $video['id']    = $this->wdhVimeoId($video_url);
                    $video_id       = $video['id'];
                    $videoData      = $this->wdhVimeoData($video_id);
                    $video['title'] = $this->wdhShorter($videoData[0]->title, 38);;
                    $video['logo']  = 'vimeo';
                    $video['image'] = $videoData[0]->thumbnail_large;
                    $video['type']  = '2';
                    break;
                // Dailymotion.com
                case "3":
                    $video['id']    = $this->wdhDailymotionId($video_url);
                    $video_id       = $video['id'];
                    $video['title'] = $this->wdhDailymotionTitle($video_url);
                    $video['logo']  = 'dailymotion';
                    $video['image'] = $this->wdhDailymotionImage($video_id);
                    $video['type']  = '3';
                    break;
                // Metacafe.com
                case "4":
                    $video['id']    = $this->wdhMetacafeId($video_url);
                    $video_id       = $video['id'];
                    $video['title'] = $this->wdhShorter($this->wdhMetacafeTitle($video_url), 38);
                    $video['logo']  = 'metacafe';
                    $video['image'] = 'http://s4.mcstatic.com/thumb/' . $video_id . '/0/6/videos/0/6/' . $this->wdhMetacafeTitleUrl($video_url) . '.jpg';
                    $video['type']  = '4';
                    break;
                // Redtube.com
                case "5":
                    $video['id']    = $this->wdhRedTubeId($video_url);
                    $video_id       = $video['id'];
                    $video['title'] = $this->wdhShorter($this->wdhRedTubeTitle($video_url), 38);
                    $video['logo']  = 'redtube';
                    $video['image'] = $this->wdhRedTubeImage($video_id);
                    $video['type']  = '5';
                    break;
                // Xvideos.com
                case "6":
                    $video['id']    = $this->wdhXvideosId($video_url);
                    $video_id       = $video['id'];
                    $video['title'] = $this->wdhShorter($this->wdhXvideosTitle($video_url), 38);
                    $video['logo']  = 'xvideos';
                    $video['image'] = $this->wdhXvideosImage($video_url);
                    $video['type']  = '6';
                    break;
            }
            
            if ($video_id == '') {
                $video['id']    = '';
                $video['title'] = '';
                $video['logo']  = '';
                $video['image'] = '';
                $video['type']  = '0';
            }
            
            echo json_encode($video);
            die();
        }
        
        // VIDEO : Vimeo.com
        
        // Vimeo Video ID
        function wdhVimeoId($text)
        {
            $mod      = explode("vimeo.com/", $text);
            $video_id = $mod[1];
            
            return $video_id;
        }
        // Vimeo Video DATA
        function wdhVimeoData($videoID)
        {
            $xmlData = file_get_contents('http://vimeo.com/api/v2/video/' . $videoID . '.json');
            
            return json_decode($xmlData);
        }
        
        // VIDEO : DailyMotion.com
        // DailyMotion Video ID
        function wdhDailymotionId($video_url)
        {
            $videomod  = explode("dailymotion.com/video/", $video_url);
            $videomodd = explode("_", $videomod[1]);
            $video_id  = $videomodd[0];
            return $video_id;
        }
        
        // DailyMotion Video IMAGE
        function wdhDailymotionImage($video_id)
        {
            $url       = "http://www.dailymotion.com/rss/video/$video_id";
            $xml       = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
            $thumb     = $xml->xpath("/rss/channel/item/media:thumbnail/@url");
            $thumb_url = (string) $thumb[0]['url'];
            return $thumb_url;
        }
        
        // DailyMotion Video Title
        function wdhDailymotionTitle($video_url)
        {
            $video_url = str_replace("http://", "", $video_url);
            $video_url = "http://" . $video_url;
            $file      = file($video_url);
            $file      = implode("", $file);
            
            if (preg_match("/<title>(.+)<\/title>/i", $file, $m)) {
                $title = $m[1];
            }
            return $this->wdhShorter($title, 38);
        }
        
        // VIDEO : Metacafe.com
        // Metacafe Video ID
        function wdhMetacafeId($video_url)
        {
            $videomod  = explode("metacafe.com/watch/", $video_url);
            $videomodd = explode("/", $videomod[1]);
            $video_id  = $videomodd[0];
            
            return $video_id;
        }
        
        // Metacafe Video Data
        function wdhMetacafeData($video_id)
        {
            $buffer = file_get_contents("http://www.metacafe.com/api/item/$video_id");
            $xml    = new SimpleXMLElement($buffer);
            
            return array(
                'title' => current($xml->xpath('/rss/channel/item/title')),
                //'description' => strip_tags(current($xml->xpath('/rss/channel/item/description'))),
                'thumbnail' => current($xml->xpath('/rss/channel/item/media:thumbnail/@url')),
                'embedurl' => current($xml->xpath('/rss/channel/item/media:content/@url'))
            );
        }
        
        // Metacafe Video Title
        function wdhMetacafeTitle($video_url)
        {
            $video_url = str_replace("http://", "", $video_url);
            $video_url = "http://" . $video_url;
            $file      = file($video_url);
            $file      = implode("", $file);
            
            if (preg_match("/<title>(.+)<\/title>/i", $file, $m)) {
                $title = $m[1];
            }
            return $this->wdhShorter($title, 38);
        }
        
        // Metacafe Video Title Url
        function wdhMetacafeTitleUrl($video_url)
        {
            $video_urlData = explode('/', strrev($video_url));
            $videoUrl      = str_replace('/', '', strrev($video_urlData[1]));
            return $videoUrl;
        }
        
        // VIDEO : Redtube.com
        // Redtube Video ID
        function wdhRedTubeId($text)
        {
            $mod      = explode("redtube.com/", $text);
            $video_id = $mod[1];
            return $video_id;
        }
        
        // Redtube Video Title
        function wdhRedTubeTitle($video_url)
        {
            $video_url = str_replace("http://", "", $video_url);
            $video_url = "http://" . $video_url;
            $file      = file($video_url);
            $file      = implode("", $file);
            
            if (preg_match("/<title>(.+)<\/title>/i", $file, $m)) {
                $mod   = $m[1];
                $modd  = explode(" | Redtube", $mod);
                $title = $modd[0];
            } else {
                $title = "Redtube";
            }
            
            return $title;
        }
        
        // Redtube Video Image
        function wdhRedTubeImage($videoid)
        {
            $video_url = "http://api.redtube.com/?data=redtube.Videos.getVideoById&video_id=$videoid&output=xml&thumbsize=big";
            $file      = file($video_url);
            $file      = implode("", $file);
            $mod       = explode('<thumbs><thumb size="big" width="432" height="324">', $file);
            $modd      = explode("</thumb>", $mod[1]);
            $moddd     = explode("$videoid" . "_", $modd[0]);
            $img       = "$moddd[0]" . "$videoid" . "_003b.jpg";
            return $img;
        }
        
        // VIDEO : Xvideos.com
        // Xvideos Video ID
        function wdhXvideosId($text)
        {
            $mod      = explode("/video", $text);
            $modd     = explode("/", $mod[1]);
            $video_id = $modd[0];
            
            return $video_id;
        }
        
        // Xvideos Video IMAGE
        function wdhXvideosImage($video_url)
        {
            $video_url = str_replace("http://", "", $video_url);
            $video_url = "http://" . $video_url;
            $file      = file($video_url);
            $file      = implode("", $file);
            $mod       = explode("url_bigthumb=", $file);
            $modd      = explode("&amp;", $mod[1]);
            $img       = $modd[0];
            return $img;
        }
        
        // Xvideos Video Title
        function wdhXvideosTitle($video_url)
        {
            $video_url = str_replace("http://", "", $video_url);
            $video_url = "http://" . $video_url;
            $file      = file($video_url);
            $file      = implode("", $file);
            
            if (preg_match("/<title>(.+)<\/title>/i", $file, $m)) {
                $mod   = $m[1];
                $modd  = explode("- XVIDEOS.COM", $mod);
                $title = $modd[0];
            } else {
                $title = "Xvideos";
            }
            return $title;
        }
        
        function wdhShorter($text, $chars_limit)
        {
            if (strlen($text) > $chars_limit) {
                $rpos = strrpos(substr($text, 0, $chars_limit), " ");
                if ($rpos !== false) {
                    // if there's whitespace, cut off at last whitespace
                    return substr($text, 0, $rpos) . '...';
                } else {
                    // otherwise, just cut after $chars_limit chars
                    return substr($text, 0, $chars_limit) . '...';
                }
            } else {
                return $text;
            }
        }
        
        // Encypt
        function wdhEncrypt($decrypted, $password)
        {
            $encrypted = base64_encode($password . $decrypted);
            
            return $encrypted;
        }
        
        function wdhDecrypt($encrypted, $password)
        {
            $decrypted = base64_decode($encrypted);
            $decrypted = str_replace($password, '', $decrypted);
            
            return $decrypted;
        }
        
        // Get IP Address
        function getRealIpAddr()
        {
            //check ip from share internet
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } //to check ip is pass from proxy
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }
        
        // Get Data : Country , City
        function geIpData($ipAddress)
        {
            $url  = 'http://www.geoplugin.net/json.gp?ip=' . $ipAddress;
            $json = file_get_contents($url);
            $obj  = json_decode($json);
            return $obj;
        }
        
        // Insert fields in Multiple Tables
        function insertFields($fields,$settings,$formtype = 'free')
        {   
            
            $fields = (array)$fields;
            global $edfp,$wdhDB,$wdhSettings,$wdhUPLOAD;
            $wdhSettings = $settings;
            // Encrypt Database
            $wdhDB['host']     = $this->wdhEncrypt($wdhDB['host'], $wdhDB['key']);
            $wdhDB['database'] = $this->wdhEncrypt($wdhDB['database'], $wdhDB['key']);
            $wdhDB['user']     = $this->wdhEncrypt($wdhDB['user'], $wdhDB['key']);
            $wdhDB['password'] = $this->wdhEncrypt($wdhDB['password'], $wdhDB['key']);
            $wdhURL = $wdhSettings->WDH_WEBSITE_URL;
            // Connect to DB
            $this->wdhConnectToDb($wdhDB);
            
            $fieldsDB = array();
            $emails = array();
            $fieldsRequiredMessage = '';
            $fieldsAllMessage = '';
            $loginConditions = '';
            $i = 0;
            $cookieAll = '';
            foreach($fields as $key => $fieldsTable){
                $fieldsValues = array();
                $fieldsNames = array();
                $fieldsADD = array();
                
                $fieldsTable = (array)$fieldsTable;
                
                foreach($fieldsTable as $field){
                    $field = (array)$field;
                    
                    if ($field[field_type] == 'email') {
                        array_push($emails, $field[field_value]);
                    }
                    
                    // HTML EDITOR
                    if ($field[field_type] == 'html_editor') {
                        $field[field_value] = str_replace('#wdh1#', '<', $field[field_value]);
                        $field[field_value] = str_replace('#wdh2#', '>', $field[field_value]);
                        $field[field_value] = str_replace('#wdh3#', '\"', $field[field_value]);
                        $field[field_value] = str_replace('#wdh3#', "\'", $field[field_value]);
                    }
                    
                    // Put Field in Message Fields
                    if ($field[field_type] != "image" && $field[field_type] != "file") {
                        $fieldsAllMessage .= '<b>'.$field[field_label].'</b> '.$field[field_value].'</br>';
                    } else if ($field[field_type] == "image"){
                        $fieldsAllMessage .= '<b>'.$field[field_label].'</b> <img src="'.WP_CONTENT_URL.'/wdhsvwe/uploads/images/'.$field[field_value].'"/></br>';
                    } else {
                        $fieldsAllMessage .= '<b>'.$field[field_label].'</b> <a href="'.WP_CONTENT_URL.'/wdhsvwe/uploads/files/'.$field[field_value].'">'.$wdhUPLOAD['file_name'].'</a></br>';
                    }
                    
                    // Put Field in Message Required Fields
                    if ($field[field_required] == 'true') {
                        $fieldsRequiredMessage .= '<b>'.$field[field_label].'</b> '.$field[field_value].'</br>';
                    }
                    
                    if ($field[field_type] == "password") {
                        $field[field_value] = md5($field[field_value]);
                    }
                    
                    // XSS PROTECTION
                    $field[field_value] = $this->xss_cleaner($field[field_value]);

                    // SQL INJECT PROTECTION
                    if($this->mysqliCheck() == true) {
                        $field[field_value] = mysqli_real_escape_string($field[field_value]);
                        $field[field_name] = mysqli_real_escape_string($field[field_name]);
                    } else {
                        $field[field_value] = mysql_real_escape_string($field[field_value]);
                        $field[field_name] = mysql_real_escape_string($field[field_name]);
                    }
                    
                    array_push($fieldsValues, '"'.$field[field_value].'"');
                    array_push($fieldsNames, $field[field_name]);
                    
                    // Login Condition
                    if ($field[field_type] != 'price') {
                        if ($i<1) {
                            $loginConditions .= 'Select * from '.$field[field_table].' where '.$field[field_name].'="'.$field[field_value].'"';
                            $cookieAll .= "$field[field_name]@@$field[field_value]";
                        } else{
                            $loginConditions .= ' AND '.$field[field_name].'="'.$field[field_value].'"';
                            $cookieAll .= "|$field[field_name]@@$field[field_value]";
                        }
                    }
                    $i++;
                }
                
                $fieldsADD = array('fields' => $fieldsNames,
                                   'values' => $fieldsValues,
                                   'table' => $key
                                   ); 
                array_push($fieldsDB, $fieldsADD);
            }
            if ($wdhSettings->form_mode == 'normal') { // Insert Fields in DB
                foreach ($fieldsDB as $field){
                   $query = 'INSERT INTO ' . $field["table"] . ' (' . implode(",",$field["fields"]) . ') VALUES(' . implode(",",$field["values"]) . ')';
                   
                   if($this->mysqliCheck() == true) {
                       $connection = mysqli_connect($wdhDB['host'], $wdhDB['user'], $wdhDB['password'], $wdhDB['database']) or die(mysqli_error());
                       mysqli_query($connection, $query) or die(mysqli_error()); 
                   } else {
                       mysql_query($query) or die(mysql_error()); 
                   }
                }
            }
            if ($wdhSettings->form_mode != 'login') {
                // Sending Emails to admin
                if ($wdhSettings->admin_email_notification) {
                    $this->sendMail("$wdhSettings->admin_email",'admin',$fieldsRequiredMessage,$fieldsAllMessage);
                }

                // Sending Emails to user
                if ($wdhSettings->user_email_notification) {
                    foreach($emails as $email){
                        $this->sendMail($email,'user',$fieldsRequiredMessage,$fieldsAllMessage);
                    }
                }
            }
            
            if ($wdhSettings->form_mode == 'login' ) {
                global $wdhDB; 
                
                if($this->mysqliCheck() == true) {
                    $connection = mysqli_connect($wdhDB['host'], $wdhDB['user'], $wdhDB['password'], $wdhDB['database']) or die(mysqli_error());
                    $result = mysqli_query($connection, $loginConditions) or die(mysqli_error());

                    $no = 0;
                    // Print out result
                    while ($row = mysqli_fetch_array($result)) {
                        $no++;
                    }
                } else {
                    $result = mysql_query($loginConditions) or die(mysql_error());

                    $no = 0;
                    // Print out result
                    while ($row = mysql_fetch_array($result)) {
                        $no++;
                    }
                }
                
                if ($no < 1) {
                    echo 'no_login'; die();
                } else{
                    $cookieAll = $this->wdhEncrypt($cookieAll, $wdhDB['key']);
                    setcookie("wdh-login", $cookieAll, time()+3600*24,'/');
                    if ($formtype == 'free') {
                        echo 'success'; die();
                    } else {
                        $sign = '?';
                
                        if (strpos($_SESSION['wdhPS_CancelPage'],'?') !== false) {
                            $sign = '&';
                        }

                        echo '<script type="text/JavaScript">
                                window.location.href = "'.$_SESSION['wdhPS_CancelPage'].$sign.'wdh_payment=success#wdh-edfp-form-success-id-'.$_SESSION['wdhPS_FormID'].'";
                              </script>';
                    }
                }
            }
            
            if ($formtype == 'free') {
                echo 'success';
            } else {
                $sign = '?';
                
                if (strpos($_SESSION['wdhPS_CancelPage'],'?') !== false) {
                    $sign = '&';
                }
                
                echo '<script type="text/JavaScript">
                        window.location.href = "'.$_SESSION['wdhPS_CancelPage'].$sign.'wdh_payment=success#wdh-edfp-form-success-id-'.$_SESSION['wdhPS_FormID'].'";
                      </script>';
            }
            
        }
        
        function getCookieData($wdh_login){
            global $wdhDB;
            $wdh_login = $this->wdhDecrypt($wdh_login, $wdhDB['key']);
            $wdh_elements = explode('|',$wdh_login);
            $wdh_cookie = array();
            
            foreach($wdh_elements as $element){
                $element = explode('@@',$element);
                $wdh_cookie[$element[0]] = $element[1];
            }
            
            return $wdh_cookie;
        }
        
        function sendMail($to,$type = 'user',$fieldsRequiredMessage,$fieldsAllMessage)
        {
            global $wdhSettings;
                    
            $header  = '';
            $header .= "Content-type: text/html; charset=utf-8"."\r\n";
            $header .= "MIME-Version: 1.1"."\r\n";
            $header .= "From: <".$wdhSettings->sender_email.">\r\n";
            $header .= "Reply-To:".$wdhSettings->sender_email;
            
            if ($type == 'user'){
                $body = file_get_contents($wdhSettings->WDH_WEBSITE_URL.'plugins/formgenerator/email_templates/'.$wdhSettings->user_email_template.'/user.html');
                
                // ADD Shortcodes
                $body = $this->addShortcodes('[[FIELD_LIST_ALL]]',$body,$fieldsAllMessage);
                $body = $this->addShortcodes('[[FIELD_LIST_ONLY_REQUIRED]]',$body,$fieldsRequiredMessage);
                
                if ($wdhSettings->user_email_notification) {
                    mail($to, $wdhSettings->user_email_subject, $body, $header);
                }
            } else {
                $body = file_get_contents($wdhSettings->WDH_WEBSITE_URL.'plugins/formgenerator/email_templates/'.$wdhSettings->admin_email_template.'/admin.html');
                
                // ADD Shortcodes
                $body = $this->addShortcodes('[[FIELD_LIST_ALL]]',$body,$fieldsAllMessage);
                $body = $this->addShortcodes('[[FIELD_LIST_ONLY_REQUIRED]]',$body,$fieldsRequiredMessage);
                
                if ($wdhSettings->admin_email_notification) {
                    mail($to, $wdhSettings->admin_subject, $body, $header);
                }
            }
            
            
        }
        
        function addShortcodes($shortcode,$content,$add_content){
            $content = str_replace($shortcode,$add_content,$content);
            
            return $content;
        }
        
        function wdhGetVideoData(){
            $video_url = sanitize_text_field($_POST['value']);
            $video_from = $this->wdhAutodetectVideo($video_url);
            $video_id   = '';

            switch ($video_from) {
                // Youtube.com
                case "1":
                    $video_id     = $this->wdhYoutubeId($video_url);
                    $video_title  = $this->wdhYoutubeTitle($video_id);
                    $video_logo   = 'youtube';
                    $video_img    = 'http://img.youtube.com/vi/' . $video_id . '/0.jpg';
                    $video_type   = '1';
                    break;
                // Vimeo.com
                case "2":
                    $video_id    = $this->wdhVimeoId($video_url);
                    $videoData   = $this->wdhVimeoData($video_id);
                    $video_title = $this->wdhShorter($videoData[0]->title, 38);;
                    $video_logo   = 'vimeo';
                    $video_img    = $videoData[0]->thumbnail_large;
                    $video_type   = '2';
                    break;
                // Dailymotion.com
                case "3":
                    $video_id     = $this->wdhDailymotionId($video_url);
                    $video_title  = $this->wdhDailymotionTitle($video_url);
                    $video_logo   = 'dailymotion';
                    $video_img    = $this->wdhDailymotionImage($video_id);
                    $video_type   = '3';
                    break;
                // Metacafe.com
                case "4":
                    $video_id     = $this->wdhMetacafeId($video_url);
                    $video_title  = $this->wdhShorter($this->wdhMetacafeTitle($video_url), 38);
                    $video_logo   = 'metacafe';
                    $video_img    = 'http://s4.mcstatic.com/thumb/' . $video_id . '/0/6/videos/0/6/' . $this->wdhMetacafeTitleUrl($video_url) . '.jpg';
                    $video_type   = '4';
                    break;
                // Redtube.com
                case "5":
                    $video_id     = $this->wdhRedTubeId($video_url);
                    $video_title  = $this->wdhShorter($this->wdhRedTubeTitle($video_url), 38);
                    $video_logo   = 'redtube';
                    $video_img    = $this->wdhRedTubeImage($video_id);
                    $video_type   = '5';
                    break;
                // Xvideos.com
                case "6":
                    $video_id     = $this->wdhXvideosId($video_url);
                    $video_title  = $this->wdhShorter($this->wdhXvideosTitle($video_url), 38);
                    $video_logo   = 'xvideos';
                    $video_img    = $this->wdhXvideosImage($video_url);
                    $video_type   = '6';
                    break;
            }
            
            $video = array();
            $video['id']    = $video_id;
            $video['title'] = $video_title;
            $video['logo']  = $video_logo;
            $video['image'] = $video_img;
            $video['type']  = $video_type;
            
            echo json_encode($video);
            die();
        }
        
        function wdhGetMapData(){
            
            if (isset($_POST['value'])) {
                $value = sanitize_text_field($_POST['value']);
                $this->wdhGetCoordinates($value);
            }
        }
        
        function mysqliCheck(){
            $mysqli = false;
            
            if (function_exists('mysqli_connect')){
                $phpVersion = phpversion();
                  
                if ((floatval($phpVersion) >=  5.5) || !function_exists('mysql_connect')) {
                        $mysqli = true;
                }
            }
            
            return $mysqli;
        }
        
        function wdhGFontsNameToValue($text){
            $text = str_replace(" Thin",":100",$text);
            $text = str_replace(" Extra-Light",":200",$text);
            $text = str_replace(" Light",":300",$text);
            $text = str_replace(" Normal",":normal",$text);
            $text = str_replace(" Normal",":400",$text);
            $text = str_replace(" Normal",":regular",$text);
            $text = str_replace(" Medium",":500",$text);
            $text = str_replace(" Semi-Bold",":600",$text);
            $text = str_replace(" Bold",":700",$text);
            $text = str_replace(" Extra-Bold",":800",$text);
            $text = str_replace(" Ultra-Bold",":900",$text);
            $text = str_replace(" Normal","normal",$text);
            $text = str_replace(" Italic","italic",$text);
            $text = str_replace(" Oblique","oblique",$text);

            return $text;
        }
        
        function wdhGFontsName($text){
            $text = str_replace("100","Thin",$text);
            $text = str_replace("200","Extra-Light",$text);
            $text = str_replace("300","Light",$text);
            $text = str_replace("400","Normal",$text);
            $text = str_replace("regular","Normal",$text);
            $text = str_replace("500","Medium",$text);
            $text = str_replace("600","Semi-Bold",$text);
            $text = str_replace("700","Bold",$text);
            $text = str_replace("800","Extra-Bold",$text);
            $text = str_replace("900","Ultra-Bold",$text);
            $text = str_replace("italic"," Italic",$text);
            $text = str_replace("normal"," Normal",$text);
            $text = str_replace("oblique"," Oblique",$text);
            $text = str_replace("+"," ",$text);
            $text = str_replace(":"," ",$text);

            return $text;
        }
    }
}

?>