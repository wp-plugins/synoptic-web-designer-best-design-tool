<?php

/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: wdh.svwe.css.php
 * File Description: Generate CSS File
 * File Version: 1.0
 * Last Update File : 25.01.2015
 * ------------------------------------------------------------------- 
 */

if (!class_exists("wdhSVWE_CSS")) {
    
    class wdhSVWE_CSS extends wdhSVWE
    {
        
        function wdhSVWE_CSS(){ // Constructor
            global $wdhSVWE;
        }
        
        function generateCSSTemp(){
            // Generate CSS 
            return $this->generateCSS();
        }
        
        function generateCSSFile(){
            // Header 
            header("Content-type: text/css; charset: UTF-8");
            $this->generateCSS();
                    
        }
        
        function generateCSSHeader($newline){ // Generate CSS Header
            $cssHTML = array();
            
            array_push($cssHTML, '/*');
            array_push($cssHTML, ' * -------------------------------------------');
            array_push($cssHTML, ' * Synoptic Website Design Editor');
            array_push($cssHTML, ' * -------------------------------------------');
            array_push($cssHTML, '*/');
            
            return implode($newline, $cssHTML);
        }
        
        function generateCSSMin($css_tbl = WDHSVWE_Temporary_CSS_table){ // Generate Minified CSS 
            global $wdhSVWE;
            $cssHTML = array();
            $newline = '';
            
            // Header
            array_push($cssHTML, $this->generateCSSHeader($newline));
            
            if ($wdhSVWE["BOX_SIZING"] == true) {
                // Padding Inside
                array_push($cssHTML, '* {');
//                array_push($cssHTML, '-moz-box-sizing: content-box;');
//                array_push($cssHTML, '-webkit-box-sizing: content-box;');
//                array_push($cssHTML, 'box-sizing: content-box;');
                array_push($cssHTML, '}');
            }
            
            // Get All CSS Properties
            array_push($cssHTML, $this->getAllCSS($newline, $css_tbl));
            
            return implode('',$cssHTML);
        }
        
        function generateCSS($css_tbl = WDHSVWE_Temporary_CSS_table){ // Generate CSS 
            global $wdhSVWE;
            $cssHTML = array();
            $newline = '
';
            
            // Header
            array_push($cssHTML, $this->generateCSSHeader($newline));
            
            if ($wdhSVWE["BOX_SIZING"] == true) {
                // Padding Inside
                array_push($cssHTML, '* {');
//                array_push($cssHTML, '  -moz-box-sizing: content-box;');
//                array_push($cssHTML, '  -webkit-box-sizing: content-box;');
//                array_push($cssHTML, '  box-sizing: content-box;');
                array_push($cssHTML, '}');
            }
            
            // Get All CSS Properties
            array_push($cssHTML, $this->getAllCSS($newline, $css_tbl));
            
            return implode($newline, $cssHTML);
        }
        
        function getAllCSS($newline,$css_tbl = WDHSVWE_Temporary_CSS_table){
            global $wdhSVWE, $wpdb;
            $cssHTML   = array();
            $wdhPageOn     = $wdhSVWE['page_on'];
            $wdhRole       = $wdhSVWE['role'];
            
            $wid           = $wdhSVWE['WEBSITE_ID'];
            $settingsCSS   = "SELECT * FROM ".WDHSVWE_Settings_table." where wid='".$wid."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
            $row           = $wpdb->get_row($settingsCSS, ARRAY_A);
            
            // GET ALL SETTINGS
            // -------------------------------------------------------------
            if($wpdb->num_rows > 0) {

                if ($row['roll_back'] == 'latest' || $css_tbl == WDHSVWE_Temporary_CSS_table) {
                    $css_query_all = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='all' ORDER by id ASC";
                    $css_query_1280 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='1280' ORDER by id ASC";
                    $css_query_1024 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='1024' ORDER by id ASC";
                    $css_query_768 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='768' ORDER by id ASC";
                    $css_query_568 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='568' ORDER by id ASC";
                    $css_query_480 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='480' ORDER by id ASC";
                    $css_query_320 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='320' ORDER by id ASC";
                    $css_max_device = 'max-width';
                    $css_min_device = 'min-width';
                } else if($row['roll_back'] == 'original') {
                    // No Add CSS
                } else {
                    $css_query_all = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='all' AND unix_created_date <=".$row['roll_back']." ORDER by id ASC";
                    $css_query_1280 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='1280' AND unix_created_date <=".$row['roll_back']." ORDER by id ASC";
                    $css_query_1024 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='1024' AND unix_created_date <=".$row['roll_back']." ORDER by id ASC";
                    $css_query_768 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='768' AND unix_created_date <=".$row['roll_back']." ORDER by id ASC";
                    $css_query_568 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='568' AND unix_created_date <=".$row['roll_back']." ORDER by id ASC";
                    $css_query_480 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='480' AND unix_created_date <=".$row['roll_back']." ORDER by id ASC";
                    $css_query_320 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='320' AND unix_created_date <=".$row['roll_back']." ORDER by id ASC";
                    $css_max_device = 'max-width';
                    $css_min_device = 'min-width';

                }

                if($row['roll_back'] != 'original') {
                    $result_all  = $wpdb->get_results($css_query_all);
                    $result_1280 = $wpdb->get_results($css_query_1280);
                    $result_1024 = $wpdb->get_results($css_query_1024);
                    $result_768 = $wpdb->get_results($css_query_768);
                    $result_568 = $wpdb->get_results($css_query_568);
                    $result_480 = $wpdb->get_results($css_query_480);
                    $result_320 = $wpdb->get_results($css_query_320);
                    $deleteDesignFor = '';
                    $deleteDesignAt = '';
                    $wdhPageUrl = '';

                    // Get All CSS PROPERTIES
                    // ---------------------------------------------------------
                    foreach ($result_all as $rowAll) {
                        $rowAll = (array)$rowAll;
                        
                        array_push($cssHTML, $this->getCssForRow($rowAll, $newline));

                        if ($css_tbl == WDHSVWE_CSS_table) {
                            $deleteDesignFor = $rowAll['used_for'];
                            $deleteDesignAt = $rowAll['unix_created_date'];
                            $wdhPageUrl = $rowAll['page_url'];
                        }
                    }

                    // Get Latest Design
                    if ($css_tbl == WDHSVWE_CSS_table) {
                        $latestHistory = $this->getHistory('latest','unix_created_date', $deleteDesignFor, $deleteDesignAt, $wdhPageUrl);

                        $css_query_latest_all  = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='all' AND unix_created_date =".$latestHistory." ORDER by id ASC";
                        $css_query_latest_1280 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='1280' AND unix_created_date =".$latestHistory." ORDER by id ASC";
                        $css_query_latest_1024 = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='1024' AND unix_created_date =".$latestHistory." ORDER by id ASC";
                        $css_query_latest_768  = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='768' AND unix_created_date =".$latestHistory." ORDER by id ASC";
                        $css_query_latest_568  = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='568' AND unix_created_date =".$latestHistory." ORDER by id ASC";
                        $css_query_latest_480  = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='480' AND unix_created_date =".$latestHistory." ORDER by id ASC";
                        $css_query_latest_320  = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND resolution='320' AND unix_created_date =".$latestHistory." ORDER by id ASC";

                        $result_latest_all  = $wpdb->get_results($css_query_latest_all);
                        $result_latest_1280 = $wpdb->get_results($css_query_latest_1280);
                        $result_latest_1024 = $wpdb->get_results($css_query_latest_1024);
                        $result_latest_768 = $wpdb->get_results($css_query_latest_768);
                        $result_latest_568 = $wpdb->get_results($css_query_latest_568);
                        $result_latest_480 = $wpdb->get_results($css_query_latest_480);
                        $result_latest_320 = $wpdb->get_results($css_query_latest_320);
                    }

                    // Get All LATEST CSS PROPERTIES
                    // ---------------------------------------------------------

                    if (isset($result_latest_all)) {

                        foreach ($result_latest_all as $rowLatestAll) {
                            $rowLatestAll = (array)$rowLatestAll;
                            array_push($cssHTML, $this->getCssForRow($rowLatestAll, $newline));
                        }
                    }

                    // Get All 1280 PROPERTIES
                    // ---------------------------------------------------------
                    array_push($cssHTML, "@media screen and (".$css_min_device.": 1025px){");

                    foreach ($result_1280 as $row1280) {
                        $row1280 = (array)$row1280;
                        array_push($cssHTML, $this->getCssForRow($row1280, $newline));
                    }

                    if (isset($result_latest_1280)) {

                        foreach ($result_latest_1280 as $rowLatest1280) {
                            $rowLatest1280 = (array)$rowLatest1280;
                            array_push($cssHTML, $this->getCssForRow($rowLatest1280, $newline));
                        }
                    }

                    array_push($cssHTML, "}");

                    // ---------------------------------------------------------
                    // Get All 1024 PROPERTIES
                    // ---------------------------------------------------------
                    array_push($cssHTML, "@media screen and (".$css_min_device.": 769px) and (".$css_max_device.": 1024px){");

                    foreach ($result_1024 as $row1024) {
                        $row1024 = (array)$row1024;
                        array_push($cssHTML, $this->getCssForRow($row1024, $newline));
                    }

                    if (isset($result_latest_1024)) {

                        foreach ($result_latest_1024 as $rowLatest1024) {
                            $rowLatest1024 = (array)$rowLatest1024;
                            array_push($cssHTML, $this->getCssForRow($rowLatest1024, $newline));
                        }
                    }

                    array_push($cssHTML, "}");

                    // ---------------------------------------------------------
                    // Get All 768 PROPERTIES
                    // ---------------------------------------------------------
                    array_push($cssHTML, "@media screen and (".$css_min_device.": 569px) and (".$css_max_device.": 768px){");

                    foreach ($result_768 as $row768) {
                        $row768 = (array)$row768;
                        array_push($cssHTML, $this->getCssForRow($row768, $newline));
                    }

                    if (isset($result_latest_768)) {

                        foreach ($result_latest_768 as $rowLatest768) {
                            $rowLatest768 = (array)$rowLatest768;
                            array_push($cssHTML, $this->getCssForRow($rowLatest768, $newline));
                        }
                    }

                    array_push($cssHTML, "}");

                    // ---------------------------------------------------------
                    // Get All 568 PROPERTIES
                    // ---------------------------------------------------------
                    array_push($cssHTML, "@media screen and (".$css_min_device.": 481px) and (".$css_max_device.": 568px){");

                    foreach ($result_568 as $row568) {
                        $row568 = (array)$row568;
                        array_push($cssHTML, $this->getCssForRow($row568, $newline));
                    }

                    if (isset($result_latest_568)) {

                        foreach ($result_latest_568 as $rowLatest568) {
                            $rowLatest568 = (array)$rowLatest568;
                            array_push($cssHTML, $this->getCssForRow($rowLatest568, $newline));
                        }
                    }

                    array_push($cssHTML, "}");

                    // ---------------------------------------------------------
                    // Get All 480 PROPERTIES
                    // ---------------------------------------------------------
                    array_push($cssHTML, "@media screen and (".$css_min_device.": 321px) and (".$css_max_device.": 480px){");

                    foreach ($result_480 as $row480) {
                        $row480 = (array)$row480;
                        array_push($cssHTML, $this->getCssForRow($row480, $newline));
                    }

                    if (isset($result_latest_480)) {

                        foreach ($result_latest_480 as $rowLatest480) {
                            $rowLatest480 = (array)$rowLatest480;
                            array_push($cssHTML, $this->getCssForRow($rowLatest480, $newline));
                        }
                    }

                    array_push($cssHTML, "}");

                    // ---------------------------------------------------------
                    // Get All 320 PROPERTIES
                    // ---------------------------------------------------------
                    array_push($cssHTML, "@media screen and (".$css_min_device.": 280px) and (".$css_max_device.": 320px){");

                    foreach ($result_320 as $row320) {
                        $row320 = (array)$row320;
                        array_push($cssHTML, $this->getCssForRow($row320, $newline));
                    }

                    if (isset($result_latest_320)) {

                        foreach ($result_latest_320 as $rowLatest320) {
                            $rowLatest320 = (array)$rowLatest320;
                            array_push($cssHTML, $this->getCssForRow($rowLatest320, $newline));
                        }
                    }

                    array_push($cssHTML, "}");
                }
            }
            
            return implode($newline, $cssHTML);
        }
        
        function getCssForRow($row, $newline) {
            $cssHTML = array();
                    
            // Adding Google Fonts
            // ---------------------------------------------------------
            // array_push($cssHTML, $this->getCSSProperties($row, $newline));  
            
            // Removing UI Wrapper
            $row['container_full_path'] = str_replace(' > div.ui-wrapper:nth-child(1)','',$row['container_full_path']);
            
            // Removing DOUBLE DOTS
            $row['container_full_path'] = str_replace('..','.',$row['container_full_path']);
            
            // Full Path CSS && TAGS Container
            // ---------------------------------------------------------
            if (($row['container_full_path'] != '') && ($row['container_wdh_path'] != '')) {

                // Website Mode Active
                array_push($cssHTML, $row['container_full_path'].'{');

                array_push($cssHTML, $this->getCSSProperties($row, $newline));

                array_push($cssHTML, '}');
                // Hover
                array_push($cssHTML, $row['container_full_path'].':hover{');

                array_push($cssHTML, $this->getCSSProperties($row, $newline, 'h_'));

                array_push($cssHTML, '}');
            } 
            // ID CSS
            // ---------------------------------------------------------
            else if ($row['container_id'] != '') {
                array_push($cssHTML, '#'.$row['container_id'].'{');

                array_push($cssHTML, $this->getCSSProperties($row, $newline));

                array_push($cssHTML, '}');
                // Hover
                array_push($cssHTML, '#'.$row['container_id'].':hover{');

                array_push($cssHTML, $this->getCSSProperties($row, $newline, 'h_'));

                array_push($cssHTML, '}');
            }
            // Classes CSS
            // ---------------------------------------------------------
            else if ($row['container_classes'] != '') {
                array_push($cssHTML, '.'.$row['container_classes'].'{');

                array_push($cssHTML, $this->getCSSProperties($row, $newline));

                array_push($cssHTML, '}');
                // Hover
                array_push($cssHTML, '.'.$row['container_classes'].':hover{');

                array_push($cssHTML, $this->getCSSProperties($row, $newline, 'h_'));

                array_push($cssHTML, '}');
            }
            // HTML TAGS ALL CSS
            // ---------------------------------------------------------
            else if ($row['element_tag'] != '') {
                array_push($cssHTML, $row['element_tag'].'{');

                array_push($cssHTML, $this->getCSSProperties($row, $newline));

                array_push($cssHTML, '}');
                // Hover
                array_push($cssHTML, $row['element_tag'].':hover{');

                array_push($cssHTML, $this->getCSSProperties($row, $newline, 'h_'));

                array_push($cssHTML, '}');
            }
            
            return implode($newline, $cssHTML);
        }
        
        function wdhGFontsName($text){
            $textNew = explode(":",$text);
            $text = $textNew[0];
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
        
        function getGoogleFonts($css_tbl = WDHSVWE_Temporary_CSS_table){
            global $wdhSVWE, $wpdb;
            $fontsHTML = array();
            $wid                = $wdhSVWE['WEBSITE_ID'];
            $wdhPageOn          = $wdhSVWE['page_on'];
            $wdhRole            = $wdhSVWE['role'];
            $settingsCSS        = "SELECT * FROM ".WDHSVWE_Settings_table." where wid='".$wid."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
            $rowSETs            = $wpdb->get_results($settingsCSS);
            $googleFontsDefault = '{"0":{"name":"ABeeZee regular","value":"ABeeZee:normal"},"1":{"name":"ABeeZee italic","value":"ABeeZee:italic"},"2":{"name":"Abel regular","value":"Abel:normal"},"3":{"name":"Abril Fatface regular","value":"Abril+Fatface:normal"},"4":{"name":"Aclonica regular","value":"Aclonica:normal"},"5":{"name":"Acme regular","value":"Acme:normal"},"6":{"name":"Actor regular","value":"Actor:normal"},"7":{"name":"Adamina regular","value":"Adamina:normal"},"8":{"name":"Advent Pro 100","value":"Advent+Pro:100"},"9":{"name":"Advent Pro 200","value":"Advent+Pro:200"},"10":{"name":"Advent Pro 300","value":"Advent+Pro:300"},"11":{"name":"Advent Pro regular","value":"Advent+Pro:normal"},"12":{"name":"Advent Pro 500","value":"Advent+Pro:500"},"13":{"name":"Advent Pro 600","value":"Advent+Pro:600"},"14":{"name":"Advent Pro 700","value":"Advent+Pro:700"},"15":{"name":"Aguafina Script regular","value":"Aguafina+Script:normal"},"16":{"name":"Akronim regular","value":"Akronim:normal"},"17":{"name":"Aladin regular","value":"Aladin:normal"},"18":{"name":"Aldrich regular","value":"Aldrich:normal"},"19":{"name":"Alef regular","value":"Alef:normal"},"20":{"name":"Alef 700","value":"Alef:700"},"21":{"name":"Alegreya regular","value":"Alegreya:normal"},"22":{"name":"Alegreya italic","value":"Alegreya:italic"},"23":{"name":"Alegreya 700","value":"Alegreya:700"},"24":{"name":"Alegreya 700italic","value":"Alegreya:700italic"},"25":{"name":"Alegreya 900","value":"Alegreya:900"},"26":{"name":"Alegreya 900italic","value":"Alegreya:900italic"},"27":{"name":"Alegreya SC regular","value":"Alegreya+SC:normal"},"28":{"name":"Alegreya SC italic","value":"Alegreya+SC:italic"},"29":{"name":"Alegreya SC 700","value":"Alegreya+SC:700"},"30":{"name":"Alegreya SC 700italic","value":"Alegreya+SC:700italic"},"31":{"name":"Alegreya SC 900","value":"Alegreya+SC:900"},"32":{"name":"Alegreya SC 900italic","value":"Alegreya+SC:900italic"},"33":{"name":"Alegreya Sans 100","value":"Alegreya+Sans:100"},"34":{"name":"Alegreya Sans 100italic","value":"Alegreya+Sans:100italic"},"35":{"name":"Alegreya Sans 300","value":"Alegreya+Sans:300"},"36":{"name":"Alegreya Sans 300italic","value":"Alegreya+Sans:300italic"},"37":{"name":"Alegreya Sans regular","value":"Alegreya+Sans:normal"},"38":{"name":"Alegreya Sans italic","value":"Alegreya+Sans:italic"},"39":{"name":"Alegreya Sans 500","value":"Alegreya+Sans:500"},"40":{"name":"Alegreya Sans 500italic","value":"Alegreya+Sans:500italic"},"41":{"name":"Alegreya Sans 700","value":"Alegreya+Sans:700"},"42":{"name":"Alegreya Sans 700italic","value":"Alegreya+Sans:700italic"},"43":{"name":"Alegreya Sans 800","value":"Alegreya+Sans:800"},"44":{"name":"Alegreya Sans 800italic","value":"Alegreya+Sans:800italic"},"45":{"name":"Alegreya Sans 900","value":"Alegreya+Sans:900"},"46":{"name":"Alegreya Sans 900italic","value":"Alegreya+Sans:900italic"},"47":{"name":"Alegreya Sans SC 100","value":"Alegreya+Sans+SC:100"},"48":{"name":"Alegreya Sans SC 100italic","value":"Alegreya+Sans+SC:100italic"},"49":{"name":"Alegreya Sans SC 300","value":"Alegreya+Sans+SC:300"},"50":{"name":"Alegreya Sans SC 300italic","value":"Alegreya+Sans+SC:300italic"},"51":{"name":"Alegreya Sans SC regular","value":"Alegreya+Sans+SC:normal"},"52":{"name":"Alegreya Sans SC italic","value":"Alegreya+Sans+SC:italic"},"53":{"name":"Alegreya Sans SC 500","value":"Alegreya+Sans+SC:500"},"54":{"name":"Alegreya Sans SC 500italic","value":"Alegreya+Sans+SC:500italic"},"55":{"name":"Alegreya Sans SC 700","value":"Alegreya+Sans+SC:700"},"56":{"name":"Alegreya Sans SC 700italic","value":"Alegreya+Sans+SC:700italic"},"57":{"name":"Alegreya Sans SC 800","value":"Alegreya+Sans+SC:800"},"58":{"name":"Alegreya Sans SC 800italic","value":"Alegreya+Sans+SC:800italic"},"59":{"name":"Alegreya Sans SC 900","value":"Alegreya+Sans+SC:900"},"60":{"name":"Alegreya Sans SC 900italic","value":"Alegreya+Sans+SC:900italic"},"61":{"name":"Alex Brush regular","value":"Alex+Brush:normal"},"62":{"name":"Alfa Slab One regular","value":"Alfa+Slab+One:normal"},"63":{"name":"Alice regular","value":"Alice:normal"},"64":{"name":"Alike regular","value":"Alike:normal"},"65":{"name":"Alike Angular regular","value":"Alike+Angular:normal"},"66":{"name":"Allan regular","value":"Allan:normal"},"67":{"name":"Allan 700","value":"Allan:700"},"68":{"name":"Allerta regular","value":"Allerta:normal"},"69":{"name":"Allerta Stencil regular","value":"Allerta+Stencil:normal"},"70":{"name":"Allura regular","value":"Allura:normal"},"71":{"name":"Almendra regular","value":"Almendra:normal"},"72":{"name":"Almendra italic","value":"Almendra:italic"},"73":{"name":"Almendra 700","value":"Almendra:700"},"74":{"name":"Almendra 700italic","value":"Almendra:700italic"},"75":{"name":"Almendra Display regular","value":"Almendra+Display:normal"},"76":{"name":"Almendra SC regular","value":"Almendra+SC:normal"},"77":{"name":"Amarante regular","value":"Amarante:normal"},"78":{"name":"Amaranth regular","value":"Amaranth:normal"},"79":{"name":"Amaranth italic","value":"Amaranth:italic"},"80":{"name":"Amaranth 700","value":"Amaranth:700"},"81":{"name":"Amaranth 700italic","value":"Amaranth:700italic"},"82":{"name":"Amatic SC regular","value":"Amatic+SC:normal"},"83":{"name":"Amatic SC 700","value":"Amatic+SC:700"},"84":{"name":"Amethysta regular","value":"Amethysta:normal"},"85":{"name":"Anaheim regular","value":"Anaheim:normal"},"86":{"name":"Andada regular","value":"Andada:normal"},"87":{"name":"Andika regular","value":"Andika:normal"},"88":{"name":"Angkor regular","value":"Angkor:normal"},"89":{"name":"Annie Use Your Telescope regular","value":"Annie+Use+Your+Telescope:normal"},"90":{"name":"Anonymous Pro regular","value":"Anonymous+Pro:normal"},"91":{"name":"Anonymous Pro italic","value":"Anonymous+Pro:italic"},"92":{"name":"Anonymous Pro 700","value":"Anonymous+Pro:700"},"93":{"name":"Anonymous Pro 700italic","value":"Anonymous+Pro:700italic"},"94":{"name":"Antic regular","value":"Antic:normal"},"95":{"name":"Antic Didone regular","value":"Antic+Didone:normal"},"96":{"name":"Antic Slab regular","value":"Antic+Slab:normal"},"97":{"name":"Anton regular","value":"Anton:normal"},"98":{"name":"Arapey regular","value":"Arapey:normal"},"99":{"name":"Arapey italic","value":"Arapey:italic"},"100":{"name":"Arbutus regular","value":"Arbutus:normal"},"101":{"name":"Arbutus Slab regular","value":"Arbutus+Slab:normal"},"102":{"name":"Architects Daughter regular","value":"Architects+Daughter:normal"},"103":{"name":"Archivo Black regular","value":"Archivo+Black:normal"},"104":{"name":"Archivo Narrow regular","value":"Archivo+Narrow:normal"},"105":{"name":"Archivo Narrow italic","value":"Archivo+Narrow:italic"},"106":{"name":"Archivo Narrow 700","value":"Archivo+Narrow:700"},"107":{"name":"Archivo Narrow 700italic","value":"Archivo+Narrow:700italic"},"108":{"name":"Arimo regular","value":"Arimo:normal"},"109":{"name":"Arimo italic","value":"Arimo:italic"},"110":{"name":"Arimo 700","value":"Arimo:700"},"111":{"name":"Arimo 700italic","value":"Arimo:700italic"},"112":{"name":"Arizonia regular","value":"Arizonia:normal"},"113":{"name":"Armata regular","value":"Armata:normal"},"114":{"name":"Artifika regular","value":"Artifika:normal"},"115":{"name":"Arvo regular","value":"Arvo:normal"},"116":{"name":"Arvo italic","value":"Arvo:italic"},"117":{"name":"Arvo 700","value":"Arvo:700"},"118":{"name":"Arvo 700italic","value":"Arvo:700italic"},"119":{"name":"Asap regular","value":"Asap:normal"},"120":{"name":"Asap italic","value":"Asap:italic"},"121":{"name":"Asap 700","value":"Asap:700"},"122":{"name":"Asap 700italic","value":"Asap:700italic"},"123":{"name":"Asset regular","value":"Asset:normal"},"124":{"name":"Astloch regular","value":"Astloch:normal"},"125":{"name":"Astloch 700","value":"Astloch:700"},"126":{"name":"Asul regular","value":"Asul:normal"},"127":{"name":"Asul 700","value":"Asul:700"},"128":{"name":"Atomic Age regular","value":"Atomic+Age:normal"},"129":{"name":"Aubrey regular","value":"Aubrey:normal"},"130":{"name":"Audiowide regular","value":"Audiowide:normal"},"131":{"name":"Autour One regular","value":"Autour+One:normal"},"132":{"name":"Average regular","value":"Average:normal"},"133":{"name":"Average Sans regular","value":"Average+Sans:normal"},"134":{"name":"Averia Gruesa Libre regular","value":"Averia+Gruesa+Libre:normal"},"135":{"name":"Averia Libre 300","value":"Averia+Libre:300"},"136":{"name":"Averia Libre 300italic","value":"Averia+Libre:300italic"},"137":{"name":"Averia Libre regular","value":"Averia+Libre:normal"},"138":{"name":"Averia Libre italic","value":"Averia+Libre:italic"},"139":{"name":"Averia Libre 700","value":"Averia+Libre:700"},"140":{"name":"Averia Libre 700italic","value":"Averia+Libre:700italic"},"141":{"name":"Averia Sans Libre 300","value":"Averia+Sans+Libre:300"},"142":{"name":"Averia Sans Libre 300italic","value":"Averia+Sans+Libre:300italic"},"143":{"name":"Averia Sans Libre regular","value":"Averia+Sans+Libre:normal"},"144":{"name":"Averia Sans Libre italic","value":"Averia+Sans+Libre:italic"},"145":{"name":"Averia Sans Libre 700","value":"Averia+Sans+Libre:700"},"146":{"name":"Averia Sans Libre 700italic","value":"Averia+Sans+Libre:700italic"},"147":{"name":"Averia Serif Libre 300","value":"Averia+Serif+Libre:300"},"148":{"name":"Averia Serif Libre 300italic","value":"Averia+Serif+Libre:300italic"},"149":{"name":"Averia Serif Libre regular","value":"Averia+Serif+Libre:normal"},"150":{"name":"Averia Serif Libre italic","value":"Averia+Serif+Libre:italic"},"151":{"name":"Averia Serif Libre 700","value":"Averia+Serif+Libre:700"},"152":{"name":"Averia Serif Libre 700italic","value":"Averia+Serif+Libre:700italic"},"153":{"name":"Bad Script regular","value":"Bad+Script:normal"},"154":{"name":"Balthazar regular","value":"Balthazar:normal"},"155":{"name":"Bangers regular","value":"Bangers:normal"},"156":{"name":"Basic regular","value":"Basic:normal"},"157":{"name":"Battambang regular","value":"Battambang:normal"},"158":{"name":"Battambang 700","value":"Battambang:700"},"159":{"name":"Baumans regular","value":"Baumans:normal"},"160":{"name":"Bayon regular","value":"Bayon:normal"},"161":{"name":"Belgrano regular","value":"Belgrano:normal"},"162":{"name":"Belleza regular","value":"Belleza:normal"},"163":{"name":"BenchNine 300","value":"BenchNine:300"},"164":{"name":"BenchNine regular","value":"BenchNine:normal"},"165":{"name":"BenchNine 700","value":"BenchNine:700"},"166":{"name":"Bentham regular","value":"Bentham:normal"},"167":{"name":"Berkshire Swash regular","value":"Berkshire+Swash:normal"},"168":{"name":"Bevan regular","value":"Bevan:normal"},"169":{"name":"Bigelow Rules regular","value":"Bigelow+Rules:normal"},"170":{"name":"Bigshot One regular","value":"Bigshot+One:normal"},"171":{"name":"Bilbo regular","value":"Bilbo:normal"},"172":{"name":"Bilbo Swash Caps regular","value":"Bilbo+Swash+Caps:normal"},"173":{"name":"Bitter regular","value":"Bitter:normal"},"174":{"name":"Bitter italic","value":"Bitter:italic"},"175":{"name":"Bitter 700","value":"Bitter:700"},"176":{"name":"Black Ops One regular","value":"Black+Ops+One:normal"},"177":{"name":"Bokor regular","value":"Bokor:normal"},"178":{"name":"Bonbon regular","value":"Bonbon:normal"},"179":{"name":"Boogaloo regular","value":"Boogaloo:normal"},"180":{"name":"Bowlby One regular","value":"Bowlby+One:normal"},"181":{"name":"Bowlby One SC regular","value":"Bowlby+One+SC:normal"},"182":{"name":"Brawler regular","value":"Brawler:normal"},"183":{"name":"Bree Serif regular","value":"Bree+Serif:normal"},"184":{"name":"Bubblegum Sans regular","value":"Bubblegum+Sans:normal"},"185":{"name":"Bubbler One regular","value":"Bubbler+One:normal"},"186":{"name":"Buda 300","value":"Buda:300"},"187":{"name":"Buenard regular","value":"Buenard:normal"},"188":{"name":"Buenard 700","value":"Buenard:700"},"189":{"name":"Butcherman regular","value":"Butcherman:normal"},"190":{"name":"Butterfly Kids regular","value":"Butterfly+Kids:normal"},"191":{"name":"Cabin regular","value":"Cabin:normal"},"192":{"name":"Cabin italic","value":"Cabin:italic"},"193":{"name":"Cabin 500","value":"Cabin:500"},"194":{"name":"Cabin 500italic","value":"Cabin:500italic"},"195":{"name":"Cabin 600","value":"Cabin:600"},"196":{"name":"Cabin 600italic","value":"Cabin:600italic"},"197":{"name":"Cabin 700","value":"Cabin:700"},"198":{"name":"Cabin 700italic","value":"Cabin:700italic"},"199":{"name":"Cabin Condensed regular","value":"Cabin+Condensed:normal"},"200":{"name":"Cabin Condensed 500","value":"Cabin+Condensed:500"},"201":{"name":"Cabin Condensed 600","value":"Cabin+Condensed:600"},"202":{"name":"Cabin Condensed 700","value":"Cabin+Condensed:700"},"203":{"name":"Cabin Sketch regular","value":"Cabin+Sketch:normal"},"204":{"name":"Cabin Sketch 700","value":"Cabin+Sketch:700"},"205":{"name":"Caesar Dressing regular","value":"Caesar+Dressing:normal"},"206":{"name":"Cagliostro regular","value":"Cagliostro:normal"},"207":{"name":"Calligraffitti regular","value":"Calligraffitti:normal"},"208":{"name":"Cambo regular","value":"Cambo:normal"},"209":{"name":"Candal regular","value":"Candal:normal"},"210":{"name":"Cantarell regular","value":"Cantarell:normal"},"211":{"name":"Cantarell italic","value":"Cantarell:italic"},"212":{"name":"Cantarell 700","value":"Cantarell:700"},"213":{"name":"Cantarell 700italic","value":"Cantarell:700italic"},"214":{"name":"Cantata One regular","value":"Cantata+One:normal"},"215":{"name":"Cantora One regular","value":"Cantora+One:normal"},"216":{"name":"Capriola regular","value":"Capriola:normal"},"217":{"name":"Cardo regular","value":"Cardo:normal"},"218":{"name":"Cardo italic","value":"Cardo:italic"},"219":{"name":"Cardo 700","value":"Cardo:700"},"220":{"name":"Carme regular","value":"Carme:normal"},"221":{"name":"Carrois Gothic regular","value":"Carrois+Gothic:normal"},"222":{"name":"Carrois Gothic SC regular","value":"Carrois+Gothic+SC:normal"},"223":{"name":"Carter One regular","value":"Carter+One:normal"},"224":{"name":"Caudex regular","value":"Caudex:normal"},"225":{"name":"Caudex italic","value":"Caudex:italic"},"226":{"name":"Caudex 700","value":"Caudex:700"},"227":{"name":"Caudex 700italic","value":"Caudex:700italic"},"228":{"name":"Cedarville Cursive regular","value":"Cedarville+Cursive:normal"},"229":{"name":"Ceviche One regular","value":"Ceviche+One:normal"},"230":{"name":"Changa One regular","value":"Changa+One:normal"},"231":{"name":"Changa One italic","value":"Changa+One:italic"},"232":{"name":"Chango regular","value":"Chango:normal"},"233":{"name":"Chau Philomene One regular","value":"Chau+Philomene+One:normal"},"234":{"name":"Chau Philomene One italic","value":"Chau+Philomene+One:italic"},"235":{"name":"Chela One regular","value":"Chela+One:normal"},"236":{"name":"Chelsea Market regular","value":"Chelsea+Market:normal"},"237":{"name":"Chenla regular","value":"Chenla:normal"},"238":{"name":"Cherry Cream Soda regular","value":"Cherry+Cream+Soda:normal"},"239":{"name":"Cherry Swash regular","value":"Cherry+Swash:normal"},"240":{"name":"Cherry Swash 700","value":"Cherry+Swash:700"},"241":{"name":"Chewy regular","value":"Chewy:normal"},"242":{"name":"Chicle regular","value":"Chicle:normal"},"243":{"name":"Chivo regular","value":"Chivo:normal"},"244":{"name":"Chivo italic","value":"Chivo:italic"},"245":{"name":"Chivo 900","value":"Chivo:900"},"246":{"name":"Chivo 900italic","value":"Chivo:900italic"},"247":{"name":"Cinzel regular","value":"Cinzel:normal"},"248":{"name":"Cinzel 700","value":"Cinzel:700"},"249":{"name":"Cinzel 900","value":"Cinzel:900"},"250":{"name":"Cinzel Decorative regular","value":"Cinzel+Decorative:normal"},"251":{"name":"Cinzel Decorative 700","value":"Cinzel+Decorative:700"},"252":{"name":"Cinzel Decorative 900","value":"Cinzel+Decorative:900"},"253":{"name":"Clicker Script regular","value":"Clicker+Script:normal"},"254":{"name":"Coda regular","value":"Coda:normal"},"255":{"name":"Coda 800","value":"Coda:800"},"256":{"name":"Coda Caption 800","value":"Coda+Caption:800"},"257":{"name":"Codystar 300","value":"Codystar:300"},"258":{"name":"Codystar regular","value":"Codystar:normal"},"259":{"name":"Combo regular","value":"Combo:normal"},"260":{"name":"Comfortaa 300","value":"Comfortaa:300"},"261":{"name":"Comfortaa regular","value":"Comfortaa:normal"},"262":{"name":"Comfortaa 700","value":"Comfortaa:700"},"263":{"name":"Coming Soon regular","value":"Coming+Soon:normal"},"264":{"name":"Concert One regular","value":"Concert+One:normal"},"265":{"name":"Condiment regular","value":"Condiment:normal"},"266":{"name":"Content regular","value":"Content:normal"},"267":{"name":"Content 700","value":"Content:700"},"268":{"name":"Contrail One regular","value":"Contrail+One:normal"},"269":{"name":"Convergence regular","value":"Convergence:normal"},"270":{"name":"Cookie regular","value":"Cookie:normal"},"271":{"name":"Copse regular","value":"Copse:normal"},"272":{"name":"Corben regular","value":"Corben:normal"},"273":{"name":"Corben 700","value":"Corben:700"},"274":{"name":"Courgette regular","value":"Courgette:normal"},"275":{"name":"Cousine regular","value":"Cousine:normal"},"276":{"name":"Cousine italic","value":"Cousine:italic"},"277":{"name":"Cousine 700","value":"Cousine:700"},"278":{"name":"Cousine 700italic","value":"Cousine:700italic"},"279":{"name":"Coustard regular","value":"Coustard:normal"},"280":{"name":"Coustard 900","value":"Coustard:900"},"281":{"name":"Covered By Your Grace regular","value":"Covered+By+Your+Grace:normal"},"282":{"name":"Crafty Girls regular","value":"Crafty+Girls:normal"},"283":{"name":"Creepster regular","value":"Creepster:normal"},"284":{"name":"Crete Round regular","value":"Crete+Round:normal"},"285":{"name":"Crete Round italic","value":"Crete+Round:italic"},"286":{"name":"Crimson Text regular","value":"Crimson+Text:normal"},"287":{"name":"Crimson Text italic","value":"Crimson+Text:italic"},"288":{"name":"Crimson Text 600","value":"Crimson+Text:600"},"289":{"name":"Crimson Text 600italic","value":"Crimson+Text:600italic"},"290":{"name":"Crimson Text 700","value":"Crimson+Text:700"},"291":{"name":"Crimson Text 700italic","value":"Crimson+Text:700italic"},"292":{"name":"Croissant One regular","value":"Croissant+One:normal"},"293":{"name":"Crushed regular","value":"Crushed:normal"},"294":{"name":"Cuprum regular","value":"Cuprum:normal"},"295":{"name":"Cuprum italic","value":"Cuprum:italic"},"296":{"name":"Cuprum 700","value":"Cuprum:700"},"297":{"name":"Cuprum 700italic","value":"Cuprum:700italic"},"298":{"name":"Cutive regular","value":"Cutive:normal"},"299":{"name":"Cutive Mono regular","value":"Cutive+Mono:normal"},"300":{"name":"Damion regular","value":"Damion:normal"},"301":{"name":"Dancing Script regular","value":"Dancing+Script:normal"},"302":{"name":"Dancing Script 700","value":"Dancing+Script:700"},"303":{"name":"Dangrek regular","value":"Dangrek:normal"},"304":{"name":"Dawning of a New Day regular","value":"Dawning+of+a+New+Day:normal"},"305":{"name":"Days One regular","value":"Days+One:normal"},"306":{"name":"Delius regular","value":"Delius:normal"},"307":{"name":"Delius Swash Caps regular","value":"Delius+Swash+Caps:normal"},"308":{"name":"Delius Unicase regular","value":"Delius+Unicase:normal"},"309":{"name":"Delius Unicase 700","value":"Delius+Unicase:700"},"310":{"name":"Della Respira regular","value":"Della+Respira:normal"},"311":{"name":"Denk One regular","value":"Denk+One:normal"},"312":{"name":"Devonshire regular","value":"Devonshire:normal"},"313":{"name":"Dhurjati regular","value":"Dhurjati:normal"},"314":{"name":"Didact Gothic regular","value":"Didact+Gothic:normal"},"315":{"name":"Diplomata regular","value":"Diplomata:normal"},"316":{"name":"Diplomata SC regular","value":"Diplomata+SC:normal"},"317":{"name":"Domine regular","value":"Domine:normal"},"318":{"name":"Domine 700","value":"Domine:700"},"319":{"name":"Donegal One regular","value":"Donegal+One:normal"},"320":{"name":"Doppio One regular","value":"Doppio+One:normal"},"321":{"name":"Dorsa regular","value":"Dorsa:normal"},"322":{"name":"Dosis 200","value":"Dosis:200"},"323":{"name":"Dosis 300","value":"Dosis:300"},"324":{"name":"Dosis regular","value":"Dosis:normal"},"325":{"name":"Dosis 500","value":"Dosis:500"},"326":{"name":"Dosis 600","value":"Dosis:600"},"327":{"name":"Dosis 700","value":"Dosis:700"},"328":{"name":"Dosis 800","value":"Dosis:800"},"329":{"name":"Dr Sugiyama regular","value":"Dr+Sugiyama:normal"},"330":{"name":"Droid Sans regular","value":"Droid+Sans:normal"},"331":{"name":"Droid Sans 700","value":"Droid+Sans:700"},"332":{"name":"Droid Sans Mono regular","value":"Droid+Sans+Mono:normal"},"333":{"name":"Droid Serif regular","value":"Droid+Serif:normal"},"334":{"name":"Droid Serif italic","value":"Droid+Serif:italic"},"335":{"name":"Droid Serif 700","value":"Droid+Serif:700"},"336":{"name":"Droid Serif 700italic","value":"Droid+Serif:700italic"},"337":{"name":"Duru Sans regular","value":"Duru+Sans:normal"},"338":{"name":"Dynalight regular","value":"Dynalight:normal"},"339":{"name":"EB Garamond regular","value":"EB+Garamond:normal"},"340":{"name":"Eagle Lake regular","value":"Eagle+Lake:normal"},"341":{"name":"Eater regular","value":"Eater:normal"},"342":{"name":"Economica regular","value":"Economica:normal"},"343":{"name":"Economica italic","value":"Economica:italic"},"344":{"name":"Economica 700","value":"Economica:700"},"345":{"name":"Economica 700italic","value":"Economica:700italic"},"346":{"name":"Ek Mukta 200","value":"Ek+Mukta:200"},"347":{"name":"Ek Mukta 300","value":"Ek+Mukta:300"},"348":{"name":"Ek Mukta regular","value":"Ek+Mukta:normal"},"349":{"name":"Ek Mukta 500","value":"Ek+Mukta:500"},"350":{"name":"Ek Mukta 600","value":"Ek+Mukta:600"},"351":{"name":"Ek Mukta 700","value":"Ek+Mukta:700"},"352":{"name":"Ek Mukta 800","value":"Ek+Mukta:800"},"353":{"name":"Electrolize regular","value":"Electrolize:normal"},"354":{"name":"Elsie regular","value":"Elsie:normal"},"355":{"name":"Elsie 900","value":"Elsie:900"},"356":{"name":"Elsie Swash Caps regular","value":"Elsie+Swash+Caps:normal"},"357":{"name":"Elsie Swash Caps 900","value":"Elsie+Swash+Caps:900"},"358":{"name":"Emblema One regular","value":"Emblema+One:normal"},"359":{"name":"Emilys Candy regular","value":"Emilys+Candy:normal"},"360":{"name":"Engagement regular","value":"Engagement:normal"},"361":{"name":"Englebert regular","value":"Englebert:normal"},"362":{"name":"Enriqueta regular","value":"Enriqueta:normal"},"363":{"name":"Enriqueta 700","value":"Enriqueta:700"},"364":{"name":"Erica One regular","value":"Erica+One:normal"},"365":{"name":"Esteban regular","value":"Esteban:normal"},"366":{"name":"Euphoria Script regular","value":"Euphoria+Script:normal"},"367":{"name":"Ewert regular","value":"Ewert:normal"},"368":{"name":"Exo 100","value":"Exo:100"},"369":{"name":"Exo 100italic","value":"Exo:100italic"},"370":{"name":"Exo 200","value":"Exo:200"},"371":{"name":"Exo 200italic","value":"Exo:200italic"},"372":{"name":"Exo 300","value":"Exo:300"},"373":{"name":"Exo 300italic","value":"Exo:300italic"},"374":{"name":"Exo regular","value":"Exo:normal"},"375":{"name":"Exo italic","value":"Exo:italic"},"376":{"name":"Exo 500","value":"Exo:500"},"377":{"name":"Exo 500italic","value":"Exo:500italic"},"378":{"name":"Exo 600","value":"Exo:600"},"379":{"name":"Exo 600italic","value":"Exo:600italic"},"380":{"name":"Exo 700","value":"Exo:700"},"381":{"name":"Exo 700italic","value":"Exo:700italic"},"382":{"name":"Exo 800","value":"Exo:800"},"383":{"name":"Exo 800italic","value":"Exo:800italic"},"384":{"name":"Exo 900","value":"Exo:900"},"385":{"name":"Exo 900italic","value":"Exo:900italic"},"386":{"name":"Exo 2 100","value":"Exo+2:100"},"387":{"name":"Exo 2 100italic","value":"Exo+2:100italic"},"388":{"name":"Exo 2 200","value":"Exo+2:200"},"389":{"name":"Exo 2 200italic","value":"Exo+2:200italic"},"390":{"name":"Exo 2 300","value":"Exo+2:300"},"391":{"name":"Exo 2 300italic","value":"Exo+2:300italic"},"392":{"name":"Exo 2 regular","value":"Exo+2:normal"},"393":{"name":"Exo 2 italic","value":"Exo+2:italic"},"394":{"name":"Exo 2 500","value":"Exo+2:500"},"395":{"name":"Exo 2 500italic","value":"Exo+2:500italic"},"396":{"name":"Exo 2 600","value":"Exo+2:600"},"397":{"name":"Exo 2 600italic","value":"Exo+2:600italic"},"398":{"name":"Exo 2 700","value":"Exo+2:700"},"399":{"name":"Exo 2 700italic","value":"Exo+2:700italic"},"400":{"name":"Exo 2 800","value":"Exo+2:800"},"401":{"name":"Exo 2 800italic","value":"Exo+2:800italic"},"402":{"name":"Exo 2 900","value":"Exo+2:900"},"403":{"name":"Exo 2 900italic","value":"Exo+2:900italic"},"404":{"name":"Expletus Sans regular","value":"Expletus+Sans:normal"},"405":{"name":"Expletus Sans italic","value":"Expletus+Sans:italic"},"406":{"name":"Expletus Sans 500","value":"Expletus+Sans:500"},"407":{"name":"Expletus Sans 500italic","value":"Expletus+Sans:500italic"},"408":{"name":"Expletus Sans 600","value":"Expletus+Sans:600"},"409":{"name":"Expletus Sans 600italic","value":"Expletus+Sans:600italic"},"410":{"name":"Expletus Sans 700","value":"Expletus+Sans:700"},"411":{"name":"Expletus Sans 700italic","value":"Expletus+Sans:700italic"},"412":{"name":"Fanwood Text regular","value":"Fanwood+Text:normal"},"413":{"name":"Fanwood Text italic","value":"Fanwood+Text:italic"},"414":{"name":"Fascinate regular","value":"Fascinate:normal"},"415":{"name":"Fascinate Inline regular","value":"Fascinate+Inline:normal"},"416":{"name":"Faster One regular","value":"Faster+One:normal"},"417":{"name":"Fasthand regular","value":"Fasthand:normal"},"418":{"name":"Fauna One regular","value":"Fauna+One:normal"},"419":{"name":"Federant regular","value":"Federant:normal"},"420":{"name":"Federo regular","value":"Federo:normal"},"421":{"name":"Felipa regular","value":"Felipa:normal"},"422":{"name":"Fenix regular","value":"Fenix:normal"},"423":{"name":"Finger Paint regular","value":"Finger+Paint:normal"},"424":{"name":"Fira Mono regular","value":"Fira+Mono:normal"},"425":{"name":"Fira Mono 700","value":"Fira+Mono:700"},"426":{"name":"Fira Sans 300","value":"Fira+Sans:300"},"427":{"name":"Fira Sans 300italic","value":"Fira+Sans:300italic"},"428":{"name":"Fira Sans regular","value":"Fira+Sans:normal"},"429":{"name":"Fira Sans italic","value":"Fira+Sans:italic"},"430":{"name":"Fira Sans 500","value":"Fira+Sans:500"},"431":{"name":"Fira Sans 500italic","value":"Fira+Sans:500italic"},"432":{"name":"Fira Sans 700","value":"Fira+Sans:700"},"433":{"name":"Fira Sans 700italic","value":"Fira+Sans:700italic"},"434":{"name":"Fjalla One regular","value":"Fjalla+One:normal"},"435":{"name":"Fjord One regular","value":"Fjord+One:normal"},"436":{"name":"Flamenco 300","value":"Flamenco:300"},"437":{"name":"Flamenco regular","value":"Flamenco:normal"},"438":{"name":"Flavors regular","value":"Flavors:normal"},"439":{"name":"Fondamento regular","value":"Fondamento:normal"},"440":{"name":"Fondamento italic","value":"Fondamento:italic"},"441":{"name":"Fontdiner Swanky regular","value":"Fontdiner+Swanky:normal"},"442":{"name":"Forum regular","value":"Forum:normal"},"443":{"name":"Francois One regular","value":"Francois+One:normal"},"444":{"name":"Freckle Face regular","value":"Freckle+Face:normal"},"445":{"name":"Fredericka the Great regular","value":"Fredericka+the+Great:normal"},"446":{"name":"Fredoka One regular","value":"Fredoka+One:normal"},"447":{"name":"Freehand regular","value":"Freehand:normal"},"448":{"name":"Fresca regular","value":"Fresca:normal"},"449":{"name":"Frijole regular","value":"Frijole:normal"},"450":{"name":"Fruktur regular","value":"Fruktur:normal"},"451":{"name":"Fugaz One regular","value":"Fugaz+One:normal"},"452":{"name":"GFS Didot regular","value":"GFS+Didot:normal"},"453":{"name":"GFS Neohellenic regular","value":"GFS+Neohellenic:normal"},"454":{"name":"GFS Neohellenic italic","value":"GFS+Neohellenic:italic"},"455":{"name":"GFS Neohellenic 700","value":"GFS+Neohellenic:700"},"456":{"name":"GFS Neohellenic 700italic","value":"GFS+Neohellenic:700italic"},"457":{"name":"Gabriela regular","value":"Gabriela:normal"},"458":{"name":"Gafata regular","value":"Gafata:normal"},"459":{"name":"Galdeano regular","value":"Galdeano:normal"},"460":{"name":"Galindo regular","value":"Galindo:normal"},"461":{"name":"Gentium Basic regular","value":"Gentium+Basic:normal"},"462":{"name":"Gentium Basic italic","value":"Gentium+Basic:italic"},"463":{"name":"Gentium Basic 700","value":"Gentium+Basic:700"},"464":{"name":"Gentium Basic 700italic","value":"Gentium+Basic:700italic"},"465":{"name":"Gentium Book Basic regular","value":"Gentium+Book+Basic:normal"},"466":{"name":"Gentium Book Basic italic","value":"Gentium+Book+Basic:italic"},"467":{"name":"Gentium Book Basic 700","value":"Gentium+Book+Basic:700"},"468":{"name":"Gentium Book Basic 700italic","value":"Gentium+Book+Basic:700italic"},"469":{"name":"Geo regular","value":"Geo:normal"},"470":{"name":"Geo italic","value":"Geo:italic"},"471":{"name":"Geostar regular","value":"Geostar:normal"},"472":{"name":"Geostar Fill regular","value":"Geostar+Fill:normal"},"473":{"name":"Germania One regular","value":"Germania+One:normal"},"474":{"name":"Gidugu regular","value":"Gidugu:normal"},"475":{"name":"Gilda Display regular","value":"Gilda+Display:normal"},"476":{"name":"Give You Glory regular","value":"Give+You+Glory:normal"},"477":{"name":"Glass Antiqua regular","value":"Glass+Antiqua:normal"},"478":{"name":"Glegoo regular","value":"Glegoo:normal"},"479":{"name":"Glegoo 700","value":"Glegoo:700"},"480":{"name":"Gloria Hallelujah regular","value":"Gloria+Hallelujah:normal"},"481":{"name":"Goblin One regular","value":"Goblin+One:normal"},"482":{"name":"Gochi Hand regular","value":"Gochi+Hand:normal"},"483":{"name":"Gorditas regular","value":"Gorditas:normal"},"484":{"name":"Gorditas 700","value":"Gorditas:700"},"485":{"name":"Goudy Bookletter 1911 regular","value":"Goudy+Bookletter+1911:normal"},"486":{"name":"Graduate regular","value":"Graduate:normal"},"487":{"name":"Grand Hotel regular","value":"Grand+Hotel:normal"},"488":{"name":"Gravitas One regular","value":"Gravitas+One:normal"},"489":{"name":"Great Vibes regular","value":"Great+Vibes:normal"},"490":{"name":"Griffy regular","value":"Griffy:normal"},"491":{"name":"Gruppo regular","value":"Gruppo:normal"},"492":{"name":"Gudea regular","value":"Gudea:normal"},"493":{"name":"Gudea italic","value":"Gudea:italic"},"494":{"name":"Gudea 700","value":"Gudea:700"},"495":{"name":"Habibi regular","value":"Habibi:normal"},"496":{"name":"Halant 300","value":"Halant:300"},"497":{"name":"Halant regular","value":"Halant:normal"},"498":{"name":"Halant 500","value":"Halant:500"},"499":{"name":"Halant 600","value":"Halant:600"},"500":{"name":"Halant 700","value":"Halant:700"},"501":{"name":"Hammersmith One regular","value":"Hammersmith+One:normal"},"502":{"name":"Hanalei regular","value":"Hanalei:normal"},"503":{"name":"Hanalei Fill regular","value":"Hanalei+Fill:normal"},"504":{"name":"Handlee regular","value":"Handlee:normal"},"505":{"name":"Hanuman regular","value":"Hanuman:normal"},"506":{"name":"Hanuman 700","value":"Hanuman:700"},"507":{"name":"Happy Monkey regular","value":"Happy+Monkey:normal"},"508":{"name":"Headland One regular","value":"Headland+One:normal"},"509":{"name":"Henny Penny regular","value":"Henny+Penny:normal"},"510":{"name":"Herr Von Muellerhoff regular","value":"Herr+Von+Muellerhoff:normal"},"511":{"name":"Hind 300","value":"Hind:300"},"512":{"name":"Hind regular","value":"Hind:normal"},"513":{"name":"Hind 500","value":"Hind:500"},"514":{"name":"Hind 600","value":"Hind:600"},"515":{"name":"Hind 700","value":"Hind:700"},"516":{"name":"Holtwood One SC regular","value":"Holtwood+One+SC:normal"},"517":{"name":"Homemade Apple regular","value":"Homemade+Apple:normal"},"518":{"name":"Homenaje regular","value":"Homenaje:normal"},"519":{"name":"IM Fell DW Pica regular","value":"IM+Fell+DW+Pica:normal"},"520":{"name":"IM Fell DW Pica italic","value":"IM+Fell+DW+Pica:italic"},"521":{"name":"IM Fell DW Pica SC regular","value":"IM+Fell+DW+Pica+SC:normal"},"522":{"name":"IM Fell Double Pica regular","value":"IM+Fell+Double+Pica:normal"},"523":{"name":"IM Fell Double Pica italic","value":"IM+Fell+Double+Pica:italic"},"524":{"name":"IM Fell Double Pica SC regular","value":"IM+Fell+Double+Pica+SC:normal"},"525":{"name":"IM Fell English regular","value":"IM+Fell+English:normal"},"526":{"name":"IM Fell English italic","value":"IM+Fell+English:italic"},"527":{"name":"IM Fell English SC regular","value":"IM+Fell+English+SC:normal"},"528":{"name":"IM Fell French Canon regular","value":"IM+Fell+French+Canon:normal"},"529":{"name":"IM Fell French Canon italic","value":"IM+Fell+French+Canon:italic"},"530":{"name":"IM Fell French Canon SC regular","value":"IM+Fell+French+Canon+SC:normal"},"531":{"name":"IM Fell Great Primer regular","value":"IM+Fell+Great+Primer:normal"},"532":{"name":"IM Fell Great Primer italic","value":"IM+Fell+Great+Primer:italic"},"533":{"name":"IM Fell Great Primer SC regular","value":"IM+Fell+Great+Primer+SC:normal"},"534":{"name":"Iceberg regular","value":"Iceberg:normal"},"535":{"name":"Iceland regular","value":"Iceland:normal"},"536":{"name":"Imprima regular","value":"Imprima:normal"},"537":{"name":"Inconsolata regular","value":"Inconsolata:normal"},"538":{"name":"Inconsolata 700","value":"Inconsolata:700"},"539":{"name":"Inder regular","value":"Inder:normal"},"540":{"name":"Indie Flower regular","value":"Indie+Flower:normal"},"541":{"name":"Inika regular","value":"Inika:normal"},"542":{"name":"Inika 700","value":"Inika:700"},"543":{"name":"Irish Grover regular","value":"Irish+Grover:normal"},"544":{"name":"Istok Web regular","value":"Istok+Web:normal"},"545":{"name":"Istok Web italic","value":"Istok+Web:italic"},"546":{"name":"Istok Web 700","value":"Istok+Web:700"},"547":{"name":"Istok Web 700italic","value":"Istok+Web:700italic"},"548":{"name":"Italiana regular","value":"Italiana:normal"},"549":{"name":"Italianno regular","value":"Italianno:normal"},"550":{"name":"Jacques Francois regular","value":"Jacques+Francois:normal"},"551":{"name":"Jacques Francois Shadow regular","value":"Jacques+Francois+Shadow:normal"},"552":{"name":"Jim Nightshade regular","value":"Jim+Nightshade:normal"},"553":{"name":"Jockey One regular","value":"Jockey+One:normal"},"554":{"name":"Jolly Lodger regular","value":"Jolly+Lodger:normal"},"555":{"name":"Josefin Sans 100","value":"Josefin+Sans:100"},"556":{"name":"Josefin Sans 100italic","value":"Josefin+Sans:100italic"},"557":{"name":"Josefin Sans 300","value":"Josefin+Sans:300"},"558":{"name":"Josefin Sans 300italic","value":"Josefin+Sans:300italic"},"559":{"name":"Josefin Sans regular","value":"Josefin+Sans:normal"},"560":{"name":"Josefin Sans italic","value":"Josefin+Sans:italic"},"561":{"name":"Josefin Sans 600","value":"Josefin+Sans:600"},"562":{"name":"Josefin Sans 600italic","value":"Josefin+Sans:600italic"},"563":{"name":"Josefin Sans 700","value":"Josefin+Sans:700"},"564":{"name":"Josefin Sans 700italic","value":"Josefin+Sans:700italic"},"565":{"name":"Josefin Slab 100","value":"Josefin+Slab:100"},"566":{"name":"Josefin Slab 100italic","value":"Josefin+Slab:100italic"},"567":{"name":"Josefin Slab 300","value":"Josefin+Slab:300"},"568":{"name":"Josefin Slab 300italic","value":"Josefin+Slab:300italic"},"569":{"name":"Josefin Slab regular","value":"Josefin+Slab:normal"},"570":{"name":"Josefin Slab italic","value":"Josefin+Slab:italic"},"571":{"name":"Josefin Slab 600","value":"Josefin+Slab:600"},"572":{"name":"Josefin Slab 600italic","value":"Josefin+Slab:600italic"},"573":{"name":"Josefin Slab 700","value":"Josefin+Slab:700"},"574":{"name":"Josefin Slab 700italic","value":"Josefin+Slab:700italic"},"575":{"name":"Joti One regular","value":"Joti+One:normal"},"576":{"name":"Judson regular","value":"Judson:normal"},"577":{"name":"Judson italic","value":"Judson:italic"},"578":{"name":"Judson 700","value":"Judson:700"},"579":{"name":"Julee regular","value":"Julee:normal"},"580":{"name":"Julius Sans One regular","value":"Julius+Sans+One:normal"},"581":{"name":"Junge regular","value":"Junge:normal"},"582":{"name":"Jura 300","value":"Jura:300"},"583":{"name":"Jura regular","value":"Jura:normal"},"584":{"name":"Jura 500","value":"Jura:500"},"585":{"name":"Jura 600","value":"Jura:600"},"586":{"name":"Just Another Hand regular","value":"Just+Another+Hand:normal"},"587":{"name":"Just Me Again Down Here regular","value":"Just+Me+Again+Down+Here:normal"},"588":{"name":"Kalam 300","value":"Kalam:300"},"589":{"name":"Kalam regular","value":"Kalam:normal"},"590":{"name":"Kalam 700","value":"Kalam:700"},"591":{"name":"Kameron regular","value":"Kameron:normal"},"592":{"name":"Kameron 700","value":"Kameron:700"},"593":{"name":"Kantumruy 300","value":"Kantumruy:300"},"594":{"name":"Kantumruy regular","value":"Kantumruy:normal"},"595":{"name":"Kantumruy 700","value":"Kantumruy:700"},"596":{"name":"Karla regular","value":"Karla:normal"},"597":{"name":"Karla italic","value":"Karla:italic"},"598":{"name":"Karla 700","value":"Karla:700"},"599":{"name":"Karla 700italic","value":"Karla:700italic"},"600":{"name":"Karma 300","value":"Karma:300"},"601":{"name":"Karma regular","value":"Karma:normal"},"602":{"name":"Karma 500","value":"Karma:500"},"603":{"name":"Karma 600","value":"Karma:600"},"604":{"name":"Karma 700","value":"Karma:700"},"605":{"name":"Kaushan Script regular","value":"Kaushan+Script:normal"},"606":{"name":"Kavoon regular","value":"Kavoon:normal"},"607":{"name":"Kdam Thmor regular","value":"Kdam+Thmor:normal"},"608":{"name":"Keania One regular","value":"Keania+One:normal"},"609":{"name":"Kelly Slab regular","value":"Kelly+Slab:normal"},"610":{"name":"Kenia regular","value":"Kenia:normal"},"611":{"name":"Khand 300","value":"Khand:300"},"612":{"name":"Khand regular","value":"Khand:normal"},"613":{"name":"Khand 500","value":"Khand:500"},"614":{"name":"Khand 600","value":"Khand:600"},"615":{"name":"Khand 700","value":"Khand:700"},"616":{"name":"Khmer regular","value":"Khmer:normal"},"617":{"name":"Kite One regular","value":"Kite+One:normal"},"618":{"name":"Knewave regular","value":"Knewave:normal"},"619":{"name":"Kotta One regular","value":"Kotta+One:normal"},"620":{"name":"Koulen regular","value":"Koulen:normal"},"621":{"name":"Kranky regular","value":"Kranky:normal"},"622":{"name":"Kreon 300","value":"Kreon:300"},"623":{"name":"Kreon regular","value":"Kreon:normal"},"624":{"name":"Kreon 700","value":"Kreon:700"},"625":{"name":"Kristi regular","value":"Kristi:normal"},"626":{"name":"Krona One regular","value":"Krona+One:normal"},"627":{"name":"La Belle Aurore regular","value":"La+Belle+Aurore:normal"},"628":{"name":"Laila 300","value":"Laila:300"},"629":{"name":"Laila regular","value":"Laila:normal"},"630":{"name":"Laila 500","value":"Laila:500"},"631":{"name":"Laila 600","value":"Laila:600"},"632":{"name":"Laila 700","value":"Laila:700"},"633":{"name":"Lancelot regular","value":"Lancelot:normal"},"634":{"name":"Lato 100","value":"Lato:100"},"635":{"name":"Lato 100italic","value":"Lato:100italic"},"636":{"name":"Lato 300","value":"Lato:300"},"637":{"name":"Lato 300italic","value":"Lato:300italic"},"638":{"name":"Lato regular","value":"Lato:normal"},"639":{"name":"Lato italic","value":"Lato:italic"},"640":{"name":"Lato 700","value":"Lato:700"},"641":{"name":"Lato 700italic","value":"Lato:700italic"},"642":{"name":"Lato 900","value":"Lato:900"},"643":{"name":"Lato 900italic","value":"Lato:900italic"},"644":{"name":"League Script regular","value":"League+Script:normal"},"645":{"name":"Leckerli One regular","value":"Leckerli+One:normal"},"646":{"name":"Ledger regular","value":"Ledger:normal"},"647":{"name":"Lekton regular","value":"Lekton:normal"},"648":{"name":"Lekton italic","value":"Lekton:italic"},"649":{"name":"Lekton 700","value":"Lekton:700"},"650":{"name":"Lemon regular","value":"Lemon:normal"},"651":{"name":"Libre Baskerville regular","value":"Libre+Baskerville:normal"},"652":{"name":"Libre Baskerville italic","value":"Libre+Baskerville:italic"},"653":{"name":"Libre Baskerville 700","value":"Libre+Baskerville:700"},"654":{"name":"Life Savers regular","value":"Life+Savers:normal"},"655":{"name":"Life Savers 700","value":"Life+Savers:700"},"656":{"name":"Lilita One regular","value":"Lilita+One:normal"},"657":{"name":"Lily Script One regular","value":"Lily+Script+One:normal"},"658":{"name":"Limelight regular","value":"Limelight:normal"},"659":{"name":"Linden Hill regular","value":"Linden+Hill:normal"},"660":{"name":"Linden Hill italic","value":"Linden+Hill:italic"},"661":{"name":"Lobster regular","value":"Lobster:normal"},"662":{"name":"Lobster Two regular","value":"Lobster+Two:normal"},"663":{"name":"Lobster Two italic","value":"Lobster+Two:italic"},"664":{"name":"Lobster Two 700","value":"Lobster+Two:700"},"665":{"name":"Lobster Two 700italic","value":"Lobster+Two:700italic"},"666":{"name":"Londrina Outline regular","value":"Londrina+Outline:normal"},"667":{"name":"Londrina Shadow regular","value":"Londrina+Shadow:normal"},"668":{"name":"Londrina Sketch regular","value":"Londrina+Sketch:normal"},"669":{"name":"Londrina Solid regular","value":"Londrina+Solid:normal"},"670":{"name":"Lora regular","value":"Lora:normal"},"671":{"name":"Lora italic","value":"Lora:italic"},"672":{"name":"Lora 700","value":"Lora:700"},"673":{"name":"Lora 700italic","value":"Lora:700italic"},"674":{"name":"Love Ya Like A Sister regular","value":"Love+Ya+Like+A+Sister:normal"},"675":{"name":"Loved by the King regular","value":"Loved+by+the+King:normal"},"676":{"name":"Lovers Quarrel regular","value":"Lovers+Quarrel:normal"},"677":{"name":"Luckiest Guy regular","value":"Luckiest+Guy:normal"},"678":{"name":"Lusitana regular","value":"Lusitana:normal"},"679":{"name":"Lusitana 700","value":"Lusitana:700"},"680":{"name":"Lustria regular","value":"Lustria:normal"},"681":{"name":"Macondo regular","value":"Macondo:normal"},"682":{"name":"Macondo Swash Caps regular","value":"Macondo+Swash+Caps:normal"},"683":{"name":"Magra regular","value":"Magra:normal"},"684":{"name":"Magra 700","value":"Magra:700"},"685":{"name":"Maiden Orange regular","value":"Maiden+Orange:normal"},"686":{"name":"Mako regular","value":"Mako:normal"},"687":{"name":"Mallanna regular","value":"Mallanna:normal"},"688":{"name":"Mandali regular","value":"Mandali:normal"},"689":{"name":"Marcellus regular","value":"Marcellus:normal"},"690":{"name":"Marcellus SC regular","value":"Marcellus+SC:normal"},"691":{"name":"Marck Script regular","value":"Marck+Script:normal"},"692":{"name":"Margarine regular","value":"Margarine:normal"},"693":{"name":"Marko One regular","value":"Marko+One:normal"},"694":{"name":"Marmelad regular","value":"Marmelad:normal"},"695":{"name":"Marvel regular","value":"Marvel:normal"},"696":{"name":"Marvel italic","value":"Marvel:italic"},"697":{"name":"Marvel 700","value":"Marvel:700"},"698":{"name":"Marvel 700italic","value":"Marvel:700italic"},"699":{"name":"Mate regular","value":"Mate:normal"},"700":{"name":"Mate italic","value":"Mate:italic"},"701":{"name":"Mate SC regular","value":"Mate+SC:normal"},"702":{"name":"Maven Pro regular","value":"Maven+Pro:normal"},"703":{"name":"Maven Pro 500","value":"Maven+Pro:500"},"704":{"name":"Maven Pro 700","value":"Maven+Pro:700"},"705":{"name":"Maven Pro 900","value":"Maven+Pro:900"},"706":{"name":"McLaren regular","value":"McLaren:normal"},"707":{"name":"Meddon regular","value":"Meddon:normal"},"708":{"name":"MedievalSharp regular","value":"MedievalSharp:normal"},"709":{"name":"Medula One regular","value":"Medula+One:normal"},"710":{"name":"Megrim regular","value":"Megrim:normal"},"711":{"name":"Meie Script regular","value":"Meie+Script:normal"},"712":{"name":"Merienda regular","value":"Merienda:normal"},"713":{"name":"Merienda 700","value":"Merienda:700"},"714":{"name":"Merienda One regular","value":"Merienda+One:normal"},"715":{"name":"Merriweather 300","value":"Merriweather:300"},"716":{"name":"Merriweather 300italic","value":"Merriweather:300italic"},"717":{"name":"Merriweather regular","value":"Merriweather:normal"},"718":{"name":"Merriweather italic","value":"Merriweather:italic"},"719":{"name":"Merriweather 700","value":"Merriweather:700"},"720":{"name":"Merriweather 700italic","value":"Merriweather:700italic"},"721":{"name":"Merriweather 900","value":"Merriweather:900"},"722":{"name":"Merriweather 900italic","value":"Merriweather:900italic"},"723":{"name":"Merriweather Sans 300","value":"Merriweather+Sans:300"},"724":{"name":"Merriweather Sans 300italic","value":"Merriweather+Sans:300italic"},"725":{"name":"Merriweather Sans regular","value":"Merriweather+Sans:normal"},"726":{"name":"Merriweather Sans italic","value":"Merriweather+Sans:italic"},"727":{"name":"Merriweather Sans 700","value":"Merriweather+Sans:700"},"728":{"name":"Merriweather Sans 700italic","value":"Merriweather+Sans:700italic"},"729":{"name":"Merriweather Sans 800","value":"Merriweather+Sans:800"},"730":{"name":"Merriweather Sans 800italic","value":"Merriweather+Sans:800italic"},"731":{"name":"Metal regular","value":"Metal:normal"},"732":{"name":"Metal Mania regular","value":"Metal+Mania:normal"},"733":{"name":"Metamorphous regular","value":"Metamorphous:normal"},"734":{"name":"Metrophobic regular","value":"Metrophobic:normal"},"735":{"name":"Michroma regular","value":"Michroma:normal"},"736":{"name":"Milonga regular","value":"Milonga:normal"},"737":{"name":"Miltonian regular","value":"Miltonian:normal"},"738":{"name":"Miltonian Tattoo regular","value":"Miltonian+Tattoo:normal"},"739":{"name":"Miniver regular","value":"Miniver:normal"},"740":{"name":"Miss Fajardose regular","value":"Miss+Fajardose:normal"},"741":{"name":"Modern Antiqua regular","value":"Modern+Antiqua:normal"},"742":{"name":"Molengo regular","value":"Molengo:normal"},"743":{"name":"Molle italic","value":"Molle:italic"},"744":{"name":"Monda regular","value":"Monda:normal"},"745":{"name":"Monda 700","value":"Monda:700"},"746":{"name":"Monofett regular","value":"Monofett:normal"},"747":{"name":"Monoton regular","value":"Monoton:normal"},"748":{"name":"Monsieur La Doulaise regular","value":"Monsieur+La+Doulaise:normal"},"749":{"name":"Montaga regular","value":"Montaga:normal"},"750":{"name":"Montez regular","value":"Montez:normal"},"751":{"name":"Montserrat regular","value":"Montserrat:normal"},"752":{"name":"Montserrat 700","value":"Montserrat:700"},"753":{"name":"Montserrat Alternates regular","value":"Montserrat+Alternates:normal"},"754":{"name":"Montserrat Alternates 700","value":"Montserrat+Alternates:700"},"755":{"name":"Montserrat Subrayada regular","value":"Montserrat+Subrayada:normal"},"756":{"name":"Montserrat Subrayada 700","value":"Montserrat+Subrayada:700"},"757":{"name":"Moul regular","value":"Moul:normal"},"758":{"name":"Moulpali regular","value":"Moulpali:normal"},"759":{"name":"Mountains of Christmas regular","value":"Mountains+of+Christmas:normal"},"760":{"name":"Mountains of Christmas 700","value":"Mountains+of+Christmas:700"},"761":{"name":"Mouse Memoirs regular","value":"Mouse+Memoirs:normal"},"762":{"name":"Mr Bedfort regular","value":"Mr+Bedfort:normal"},"763":{"name":"Mr Dafoe regular","value":"Mr+Dafoe:normal"},"764":{"name":"Mr De Haviland regular","value":"Mr+De+Haviland:normal"},"765":{"name":"Mrs Saint Delafield regular","value":"Mrs+Saint+Delafield:normal"},"766":{"name":"Mrs Sheppards regular","value":"Mrs+Sheppards:normal"},"767":{"name":"Muli 300","value":"Muli:300"},"768":{"name":"Muli 300italic","value":"Muli:300italic"},"769":{"name":"Muli regular","value":"Muli:normal"},"770":{"name":"Muli italic","value":"Muli:italic"},"771":{"name":"Mystery Quest regular","value":"Mystery+Quest:normal"},"772":{"name":"NTR regular","value":"NTR:normal"},"773":{"name":"Neucha regular","value":"Neucha:normal"},"774":{"name":"Neuton 200","value":"Neuton:200"},"775":{"name":"Neuton 300","value":"Neuton:300"},"776":{"name":"Neuton regular","value":"Neuton:normal"},"777":{"name":"Neuton italic","value":"Neuton:italic"},"778":{"name":"Neuton 700","value":"Neuton:700"},"779":{"name":"Neuton 800","value":"Neuton:800"},"780":{"name":"New Rocker regular","value":"New+Rocker:normal"},"781":{"name":"News Cycle regular","value":"News+Cycle:normal"},"782":{"name":"News Cycle 700","value":"News+Cycle:700"},"783":{"name":"Niconne regular","value":"Niconne:normal"},"784":{"name":"Nixie One regular","value":"Nixie+One:normal"},"785":{"name":"Nobile regular","value":"Nobile:normal"},"786":{"name":"Nobile italic","value":"Nobile:italic"},"787":{"name":"Nobile 700","value":"Nobile:700"},"788":{"name":"Nobile 700italic","value":"Nobile:700italic"},"789":{"name":"Nokora regular","value":"Nokora:normal"},"790":{"name":"Nokora 700","value":"Nokora:700"},"791":{"name":"Norican regular","value":"Norican:normal"},"792":{"name":"Nosifer regular","value":"Nosifer:normal"},"793":{"name":"Nothing You Could Do regular","value":"Nothing+You+Could+Do:normal"},"794":{"name":"Noticia Text regular","value":"Noticia+Text:normal"},"795":{"name":"Noticia Text italic","value":"Noticia+Text:italic"},"796":{"name":"Noticia Text 700","value":"Noticia+Text:700"},"797":{"name":"Noticia Text 700italic","value":"Noticia+Text:700italic"},"798":{"name":"Noto Sans regular","value":"Noto+Sans:normal"},"799":{"name":"Noto Sans italic","value":"Noto+Sans:italic"},"800":{"name":"Noto Sans 700","value":"Noto+Sans:700"},"801":{"name":"Noto Sans 700italic","value":"Noto+Sans:700italic"},"802":{"name":"Noto Serif regular","value":"Noto+Serif:normal"},"803":{"name":"Noto Serif italic","value":"Noto+Serif:italic"},"804":{"name":"Noto Serif 700","value":"Noto+Serif:700"},"805":{"name":"Noto Serif 700italic","value":"Noto+Serif:700italic"},"806":{"name":"Nova Cut regular","value":"Nova+Cut:normal"},"807":{"name":"Nova Flat regular","value":"Nova+Flat:normal"},"808":{"name":"Nova Mono regular","value":"Nova+Mono:normal"},"809":{"name":"Nova Oval regular","value":"Nova+Oval:normal"},"810":{"name":"Nova Round regular","value":"Nova+Round:normal"},"811":{"name":"Nova Script regular","value":"Nova+Script:normal"},"812":{"name":"Nova Slim regular","value":"Nova+Slim:normal"},"813":{"name":"Nova Square regular","value":"Nova+Square:normal"},"814":{"name":"Numans regular","value":"Numans:normal"},"815":{"name":"Nunito 300","value":"Nunito:300"},"816":{"name":"Nunito regular","value":"Nunito:normal"},"817":{"name":"Nunito 700","value":"Nunito:700"},"818":{"name":"Odor Mean Chey regular","value":"Odor+Mean+Chey:normal"},"819":{"name":"Offside regular","value":"Offside:normal"},"820":{"name":"Old Standard TT regular","value":"Old+Standard+TT:normal"},"821":{"name":"Old Standard TT italic","value":"Old+Standard+TT:italic"},"822":{"name":"Old Standard TT 700","value":"Old+Standard+TT:700"},"823":{"name":"Oldenburg regular","value":"Oldenburg:normal"},"824":{"name":"Oleo Script regular","value":"Oleo+Script:normal"},"825":{"name":"Oleo Script 700","value":"Oleo+Script:700"},"826":{"name":"Oleo Script Swash Caps regular","value":"Oleo+Script+Swash+Caps:normal"},"827":{"name":"Oleo Script Swash Caps 700","value":"Oleo+Script+Swash+Caps:700"},"828":{"name":"Open Sans 300","value":"Open+Sans:300"},"829":{"name":"Open Sans 300italic","value":"Open+Sans:300italic"},"830":{"name":"Open Sans regular","value":"Open+Sans:normal"},"831":{"name":"Open Sans italic","value":"Open+Sans:italic"},"832":{"name":"Open Sans 600","value":"Open+Sans:600"},"833":{"name":"Open Sans 600italic","value":"Open+Sans:600italic"},"834":{"name":"Open Sans 700","value":"Open+Sans:700"},"835":{"name":"Open Sans 700italic","value":"Open+Sans:700italic"},"836":{"name":"Open Sans 800","value":"Open+Sans:800"},"837":{"name":"Open Sans 800italic","value":"Open+Sans:800italic"},"838":{"name":"Open Sans Condensed 300","value":"Open+Sans+Condensed:300"},"839":{"name":"Open Sans Condensed 300italic","value":"Open+Sans+Condensed:300italic"},"840":{"name":"Open Sans Condensed 700","value":"Open+Sans+Condensed:700"},"841":{"name":"Oranienbaum regular","value":"Oranienbaum:normal"},"842":{"name":"Orbitron regular","value":"Orbitron:normal"},"843":{"name":"Orbitron 500","value":"Orbitron:500"},"844":{"name":"Orbitron 700","value":"Orbitron:700"},"845":{"name":"Orbitron 900","value":"Orbitron:900"},"846":{"name":"Oregano regular","value":"Oregano:normal"},"847":{"name":"Oregano italic","value":"Oregano:italic"},"848":{"name":"Orienta regular","value":"Orienta:normal"},"849":{"name":"Original Surfer regular","value":"Original+Surfer:normal"},"850":{"name":"Oswald 300","value":"Oswald:300"},"851":{"name":"Oswald regular","value":"Oswald:normal"},"852":{"name":"Oswald 700","value":"Oswald:700"},"853":{"name":"Over the Rainbow regular","value":"Over+the+Rainbow:normal"},"854":{"name":"Overlock regular","value":"Overlock:normal"},"855":{"name":"Overlock italic","value":"Overlock:italic"},"856":{"name":"Overlock 700","value":"Overlock:700"},"857":{"name":"Overlock 700italic","value":"Overlock:700italic"},"858":{"name":"Overlock 900","value":"Overlock:900"},"859":{"name":"Overlock 900italic","value":"Overlock:900italic"},"860":{"name":"Overlock SC regular","value":"Overlock+SC:normal"},"861":{"name":"Ovo regular","value":"Ovo:normal"},"862":{"name":"Oxygen 300","value":"Oxygen:300"},"863":{"name":"Oxygen regular","value":"Oxygen:normal"},"864":{"name":"Oxygen 700","value":"Oxygen:700"},"865":{"name":"Oxygen Mono regular","value":"Oxygen+Mono:normal"},"866":{"name":"PT Mono regular","value":"PT+Mono:normal"},"867":{"name":"PT Sans regular","value":"PT+Sans:normal"},"868":{"name":"PT Sans italic","value":"PT+Sans:italic"},"869":{"name":"PT Sans 700","value":"PT+Sans:700"},"870":{"name":"PT Sans 700italic","value":"PT+Sans:700italic"},"871":{"name":"PT Sans Caption regular","value":"PT+Sans+Caption:normal"},"872":{"name":"PT Sans Caption 700","value":"PT+Sans+Caption:700"},"873":{"name":"PT Sans Narrow regular","value":"PT+Sans+Narrow:normal"},"874":{"name":"PT Sans Narrow 700","value":"PT+Sans+Narrow:700"},"875":{"name":"PT Serif regular","value":"PT+Serif:normal"},"876":{"name":"PT Serif italic","value":"PT+Serif:italic"},"877":{"name":"PT Serif 700","value":"PT+Serif:700"},"878":{"name":"PT Serif 700italic","value":"PT+Serif:700italic"},"879":{"name":"PT Serif Caption regular","value":"PT+Serif+Caption:normal"},"880":{"name":"PT Serif Caption italic","value":"PT+Serif+Caption:italic"},"881":{"name":"Pacifico regular","value":"Pacifico:normal"},"882":{"name":"Paprika regular","value":"Paprika:normal"},"883":{"name":"Parisienne regular","value":"Parisienne:normal"},"884":{"name":"Passero One regular","value":"Passero+One:normal"},"885":{"name":"Passion One regular","value":"Passion+One:normal"},"886":{"name":"Passion One 700","value":"Passion+One:700"},"887":{"name":"Passion One 900","value":"Passion+One:900"},"888":{"name":"Pathway Gothic One regular","value":"Pathway+Gothic+One:normal"},"889":{"name":"Patrick Hand regular","value":"Patrick+Hand:normal"},"890":{"name":"Patrick Hand SC regular","value":"Patrick+Hand+SC:normal"},"891":{"name":"Patua One regular","value":"Patua+One:normal"},"892":{"name":"Paytone One regular","value":"Paytone+One:normal"},"893":{"name":"Peralta regular","value":"Peralta:normal"},"894":{"name":"Permanent Marker regular","value":"Permanent+Marker:normal"},"895":{"name":"Petit Formal Script regular","value":"Petit+Formal+Script:normal"},"896":{"name":"Petrona regular","value":"Petrona:normal"},"897":{"name":"Philosopher regular","value":"Philosopher:normal"},"898":{"name":"Philosopher italic","value":"Philosopher:italic"},"899":{"name":"Philosopher 700","value":"Philosopher:700"},"900":{"name":"Philosopher 700italic","value":"Philosopher:700italic"},"901":{"name":"Piedra regular","value":"Piedra:normal"},"902":{"name":"Pinyon Script regular","value":"Pinyon+Script:normal"},"903":{"name":"Pirata One regular","value":"Pirata+One:normal"},"904":{"name":"Plaster regular","value":"Plaster:normal"},"905":{"name":"Play regular","value":"Play:normal"},"906":{"name":"Play 700","value":"Play:700"},"907":{"name":"Playball regular","value":"Playball:normal"},"908":{"name":"Playfair Display regular","value":"Playfair+Display:normal"},"909":{"name":"Playfair Display italic","value":"Playfair+Display:italic"},"910":{"name":"Playfair Display 700","value":"Playfair+Display:700"},"911":{"name":"Playfair Display 700italic","value":"Playfair+Display:700italic"},"912":{"name":"Playfair Display 900","value":"Playfair+Display:900"},"913":{"name":"Playfair Display 900italic","value":"Playfair+Display:900italic"},"914":{"name":"Playfair Display SC regular","value":"Playfair+Display+SC:normal"},"915":{"name":"Playfair Display SC italic","value":"Playfair+Display+SC:italic"},"916":{"name":"Playfair Display SC 700","value":"Playfair+Display+SC:700"},"917":{"name":"Playfair Display SC 700italic","value":"Playfair+Display+SC:700italic"},"918":{"name":"Playfair Display SC 900","value":"Playfair+Display+SC:900"},"919":{"name":"Playfair Display SC 900italic","value":"Playfair+Display+SC:900italic"},"920":{"name":"Podkova regular","value":"Podkova:normal"},"921":{"name":"Podkova 700","value":"Podkova:700"},"922":{"name":"Poiret One regular","value":"Poiret+One:normal"},"923":{"name":"Poller One regular","value":"Poller+One:normal"},"924":{"name":"Poly regular","value":"Poly:normal"},"925":{"name":"Poly italic","value":"Poly:italic"},"926":{"name":"Pompiere regular","value":"Pompiere:normal"},"927":{"name":"Pontano Sans regular","value":"Pontano+Sans:normal"},"928":{"name":"Port Lligat Sans regular","value":"Port+Lligat+Sans:normal"},"929":{"name":"Port Lligat Slab regular","value":"Port+Lligat+Slab:normal"},"930":{"name":"Prata regular","value":"Prata:normal"},"931":{"name":"Preahvihear regular","value":"Preahvihear:normal"},"932":{"name":"Press Start 2P regular","value":"Press+Start+2P:normal"},"933":{"name":"Princess Sofia regular","value":"Princess+Sofia:normal"},"934":{"name":"Prociono regular","value":"Prociono:normal"},"935":{"name":"Prosto One regular","value":"Prosto+One:normal"},"936":{"name":"Puritan regular","value":"Puritan:normal"},"937":{"name":"Puritan italic","value":"Puritan:italic"},"938":{"name":"Puritan 700","value":"Puritan:700"},"939":{"name":"Puritan 700italic","value":"Puritan:700italic"},"940":{"name":"Purple Purse regular","value":"Purple+Purse:normal"},"941":{"name":"Quando regular","value":"Quando:normal"},"942":{"name":"Quantico regular","value":"Quantico:normal"},"943":{"name":"Quantico italic","value":"Quantico:italic"},"944":{"name":"Quantico 700","value":"Quantico:700"},"945":{"name":"Quantico 700italic","value":"Quantico:700italic"},"946":{"name":"Quattrocento regular","value":"Quattrocento:normal"},"947":{"name":"Quattrocento 700","value":"Quattrocento:700"},"948":{"name":"Quattrocento Sans regular","value":"Quattrocento+Sans:normal"},"949":{"name":"Quattrocento Sans italic","value":"Quattrocento+Sans:italic"},"950":{"name":"Quattrocento Sans 700","value":"Quattrocento+Sans:700"},"951":{"name":"Quattrocento Sans 700italic","value":"Quattrocento+Sans:700italic"},"952":{"name":"Questrial regular","value":"Questrial:normal"},"953":{"name":"Quicksand 300","value":"Quicksand:300"},"954":{"name":"Quicksand regular","value":"Quicksand:normal"},"955":{"name":"Quicksand 700","value":"Quicksand:700"},"956":{"name":"Quintessential regular","value":"Quintessential:normal"},"957":{"name":"Qwigley regular","value":"Qwigley:normal"},"958":{"name":"Racing Sans One regular","value":"Racing+Sans+One:normal"},"959":{"name":"Radley regular","value":"Radley:normal"},"960":{"name":"Radley italic","value":"Radley:italic"},"961":{"name":"Rajdhani 300","value":"Rajdhani:300"},"962":{"name":"Rajdhani regular","value":"Rajdhani:normal"},"963":{"name":"Rajdhani 500","value":"Rajdhani:500"},"964":{"name":"Rajdhani 600","value":"Rajdhani:600"},"965":{"name":"Rajdhani 700","value":"Rajdhani:700"},"966":{"name":"Raleway 100","value":"Raleway:100"},"967":{"name":"Raleway 200","value":"Raleway:200"},"968":{"name":"Raleway 300","value":"Raleway:300"},"969":{"name":"Raleway regular","value":"Raleway:normal"},"970":{"name":"Raleway 500","value":"Raleway:500"},"971":{"name":"Raleway 600","value":"Raleway:600"},"972":{"name":"Raleway 700","value":"Raleway:700"},"973":{"name":"Raleway 800","value":"Raleway:800"},"974":{"name":"Raleway 900","value":"Raleway:900"},"975":{"name":"Raleway Dots regular","value":"Raleway+Dots:normal"},"976":{"name":"Ramabhadra regular","value":"Ramabhadra:normal"},"977":{"name":"Rambla regular","value":"Rambla:normal"},"978":{"name":"Rambla italic","value":"Rambla:italic"},"979":{"name":"Rambla 700","value":"Rambla:700"},"980":{"name":"Rambla 700italic","value":"Rambla:700italic"},"981":{"name":"Rammetto One regular","value":"Rammetto+One:normal"},"982":{"name":"Ranchers regular","value":"Ranchers:normal"},"983":{"name":"Rancho regular","value":"Rancho:normal"},"984":{"name":"Rationale regular","value":"Rationale:normal"},"985":{"name":"Redressed regular","value":"Redressed:normal"},"986":{"name":"Reenie Beanie regular","value":"Reenie+Beanie:normal"},"987":{"name":"Revalia regular","value":"Revalia:normal"},"988":{"name":"Ribeye regular","value":"Ribeye:normal"},"989":{"name":"Ribeye Marrow regular","value":"Ribeye+Marrow:normal"},"990":{"name":"Righteous regular","value":"Righteous:normal"},"991":{"name":"Risque regular","value":"Risque:normal"},"992":{"name":"Roboto 100","value":"Roboto:100"},"993":{"name":"Roboto 100italic","value":"Roboto:100italic"},"994":{"name":"Roboto 300","value":"Roboto:300"},"995":{"name":"Roboto 300italic","value":"Roboto:300italic"},"996":{"name":"Roboto regular","value":"Roboto:normal"},"997":{"name":"Roboto italic","value":"Roboto:italic"},"998":{"name":"Roboto 500","value":"Roboto:500"},"999":{"name":"Roboto 500italic","value":"Roboto:500italic"},"1000":{"name":"Roboto 700","value":"Roboto:700"},"1001":{"name":"Roboto 700italic","value":"Roboto:700italic"},"1002":{"name":"Roboto 900","value":"Roboto:900"},"1003":{"name":"Roboto 900italic","value":"Roboto:900italic"},"1004":{"name":"Roboto Condensed 300","value":"Roboto+Condensed:300"},"1005":{"name":"Roboto Condensed 300italic","value":"Roboto+Condensed:300italic"},"1006":{"name":"Roboto Condensed regular","value":"Roboto+Condensed:normal"},"1007":{"name":"Roboto Condensed italic","value":"Roboto+Condensed:italic"},"1008":{"name":"Roboto Condensed 700","value":"Roboto+Condensed:700"},"1009":{"name":"Roboto Condensed 700italic","value":"Roboto+Condensed:700italic"},"1010":{"name":"Roboto Slab 100","value":"Roboto+Slab:100"},"1011":{"name":"Roboto Slab 300","value":"Roboto+Slab:300"},"1012":{"name":"Roboto Slab regular","value":"Roboto+Slab:normal"},"1013":{"name":"Roboto Slab 700","value":"Roboto+Slab:700"},"1014":{"name":"Rochester regular","value":"Rochester:normal"},"1015":{"name":"Rock Salt regular","value":"Rock+Salt:normal"},"1016":{"name":"Rokkitt regular","value":"Rokkitt:normal"},"1017":{"name":"Rokkitt 700","value":"Rokkitt:700"},"1018":{"name":"Romanesco regular","value":"Romanesco:normal"},"1019":{"name":"Ropa Sans regular","value":"Ropa+Sans:normal"},"1020":{"name":"Ropa Sans italic","value":"Ropa+Sans:italic"},"1021":{"name":"Rosario regular","value":"Rosario:normal"},"1022":{"name":"Rosario italic","value":"Rosario:italic"},"1023":{"name":"Rosario 700","value":"Rosario:700"},"1024":{"name":"Rosario 700italic","value":"Rosario:700italic"},"1025":{"name":"Rosarivo regular","value":"Rosarivo:normal"},"1026":{"name":"Rosarivo italic","value":"Rosarivo:italic"},"1027":{"name":"Rouge Script regular","value":"Rouge+Script:normal"},"1028":{"name":"Rozha One regular","value":"Rozha+One:normal"},"1029":{"name":"Rubik Mono One regular","value":"Rubik+Mono+One:normal"},"1030":{"name":"Rubik One regular","value":"Rubik+One:normal"},"1031":{"name":"Ruda regular","value":"Ruda:normal"},"1032":{"name":"Ruda 700","value":"Ruda:700"},"1033":{"name":"Ruda 900","value":"Ruda:900"},"1034":{"name":"Rufina regular","value":"Rufina:normal"},"1035":{"name":"Rufina 700","value":"Rufina:700"},"1036":{"name":"Ruge Boogie regular","value":"Ruge+Boogie:normal"},"1037":{"name":"Ruluko regular","value":"Ruluko:normal"},"1038":{"name":"Rum Raisin regular","value":"Rum+Raisin:normal"},"1039":{"name":"Ruslan Display regular","value":"Ruslan+Display:normal"},"1040":{"name":"Russo One regular","value":"Russo+One:normal"},"1041":{"name":"Ruthie regular","value":"Ruthie:normal"},"1042":{"name":"Rye regular","value":"Rye:normal"},"1043":{"name":"Sacramento regular","value":"Sacramento:normal"},"1044":{"name":"Sail regular","value":"Sail:normal"},"1045":{"name":"Salsa regular","value":"Salsa:normal"},"1046":{"name":"Sanchez regular","value":"Sanchez:normal"},"1047":{"name":"Sanchez italic","value":"Sanchez:italic"},"1048":{"name":"Sancreek regular","value":"Sancreek:normal"},"1049":{"name":"Sansita One regular","value":"Sansita+One:normal"},"1050":{"name":"Sarina regular","value":"Sarina:normal"},"1051":{"name":"Sarpanch regular","value":"Sarpanch:normal"},"1052":{"name":"Sarpanch 500","value":"Sarpanch:500"},"1053":{"name":"Sarpanch 600","value":"Sarpanch:600"},"1054":{"name":"Sarpanch 700","value":"Sarpanch:700"},"1055":{"name":"Sarpanch 800","value":"Sarpanch:800"},"1056":{"name":"Sarpanch 900","value":"Sarpanch:900"},"1057":{"name":"Satisfy regular","value":"Satisfy:normal"},"1058":{"name":"Scada regular","value":"Scada:normal"},"1059":{"name":"Scada italic","value":"Scada:italic"},"1060":{"name":"Scada 700","value":"Scada:700"},"1061":{"name":"Scada 700italic","value":"Scada:700italic"},"1062":{"name":"Schoolbell regular","value":"Schoolbell:normal"},"1063":{"name":"Seaweed Script regular","value":"Seaweed+Script:normal"},"1064":{"name":"Sevillana regular","value":"Sevillana:normal"},"1065":{"name":"Seymour One regular","value":"Seymour+One:normal"},"1066":{"name":"Shadows Into Light regular","value":"Shadows+Into+Light:normal"},"1067":{"name":"Shadows Into Light Two regular","value":"Shadows+Into+Light+Two:normal"},"1068":{"name":"Shanti regular","value":"Shanti:normal"},"1069":{"name":"Share regular","value":"Share:normal"},"1070":{"name":"Share italic","value":"Share:italic"},"1071":{"name":"Share 700","value":"Share:700"},"1072":{"name":"Share 700italic","value":"Share:700italic"},"1073":{"name":"Share Tech regular","value":"Share+Tech:normal"},"1074":{"name":"Share Tech Mono regular","value":"Share+Tech+Mono:normal"},"1075":{"name":"Shojumaru regular","value":"Shojumaru:normal"},"1076":{"name":"Short Stack regular","value":"Short+Stack:normal"},"1077":{"name":"Siemreap regular","value":"Siemreap:normal"},"1078":{"name":"Sigmar One regular","value":"Sigmar+One:normal"},"1079":{"name":"Signika 300","value":"Signika:300"},"1080":{"name":"Signika regular","value":"Signika:normal"},"1081":{"name":"Signika 600","value":"Signika:600"},"1082":{"name":"Signika 700","value":"Signika:700"},"1083":{"name":"Signika Negative 300","value":"Signika+Negative:300"},"1084":{"name":"Signika Negative regular","value":"Signika+Negative:normal"},"1085":{"name":"Signika Negative 600","value":"Signika+Negative:600"},"1086":{"name":"Signika Negative 700","value":"Signika+Negative:700"},"1087":{"name":"Simonetta regular","value":"Simonetta:normal"},"1088":{"name":"Simonetta italic","value":"Simonetta:italic"},"1089":{"name":"Simonetta 900","value":"Simonetta:900"},"1090":{"name":"Simonetta 900italic","value":"Simonetta:900italic"},"1091":{"name":"Sintony regular","value":"Sintony:normal"},"1092":{"name":"Sintony 700","value":"Sintony:700"},"1093":{"name":"Sirin Stencil regular","value":"Sirin+Stencil:normal"},"1094":{"name":"Six Caps regular","value":"Six+Caps:normal"},"1095":{"name":"Skranji regular","value":"Skranji:normal"},"1096":{"name":"Skranji 700","value":"Skranji:700"},"1097":{"name":"Slabo 13px regular","value":"Slabo+13px:normal"},"1098":{"name":"Slabo 27px regular","value":"Slabo+27px:normal"},"1099":{"name":"Slackey regular","value":"Slackey:normal"},"1100":{"name":"Smokum regular","value":"Smokum:normal"},"1101":{"name":"Smythe regular","value":"Smythe:normal"},"1102":{"name":"Sniglet regular","value":"Sniglet:normal"},"1103":{"name":"Sniglet 800","value":"Sniglet:800"},"1104":{"name":"Snippet regular","value":"Snippet:normal"},"1105":{"name":"Snowburst One regular","value":"Snowburst+One:normal"},"1106":{"name":"Sofadi One regular","value":"Sofadi+One:normal"},"1107":{"name":"Sofia regular","value":"Sofia:normal"},"1108":{"name":"Sonsie One regular","value":"Sonsie+One:normal"},"1109":{"name":"Sorts Mill Goudy regular","value":"Sorts+Mill+Goudy:normal"},"1110":{"name":"Sorts Mill Goudy italic","value":"Sorts+Mill+Goudy:italic"},"1111":{"name":"Source Code Pro 200","value":"Source+Code+Pro:200"},"1112":{"name":"Source Code Pro 300","value":"Source+Code+Pro:300"},"1113":{"name":"Source Code Pro regular","value":"Source+Code+Pro:normal"},"1114":{"name":"Source Code Pro 500","value":"Source+Code+Pro:500"},"1115":{"name":"Source Code Pro 600","value":"Source+Code+Pro:600"},"1116":{"name":"Source Code Pro 700","value":"Source+Code+Pro:700"},"1117":{"name":"Source Code Pro 900","value":"Source+Code+Pro:900"},"1118":{"name":"Source Sans Pro 200","value":"Source+Sans+Pro:200"},"1119":{"name":"Source Sans Pro 200italic","value":"Source+Sans+Pro:200italic"},"1120":{"name":"Source Sans Pro 300","value":"Source+Sans+Pro:300"},"1121":{"name":"Source Sans Pro 300italic","value":"Source+Sans+Pro:300italic"},"1122":{"name":"Source Sans Pro regular","value":"Source+Sans+Pro:normal"},"1123":{"name":"Source Sans Pro italic","value":"Source+Sans+Pro:italic"},"1124":{"name":"Source Sans Pro 600","value":"Source+Sans+Pro:600"},"1125":{"name":"Source Sans Pro 600italic","value":"Source+Sans+Pro:600italic"},"1126":{"name":"Source Sans Pro 700","value":"Source+Sans+Pro:700"},"1127":{"name":"Source Sans Pro 700italic","value":"Source+Sans+Pro:700italic"},"1128":{"name":"Source Sans Pro 900","value":"Source+Sans+Pro:900"},"1129":{"name":"Source Sans Pro 900italic","value":"Source+Sans+Pro:900italic"},"1130":{"name":"Source Serif Pro regular","value":"Source+Serif+Pro:normal"},"1131":{"name":"Source Serif Pro 600","value":"Source+Serif+Pro:600"},"1132":{"name":"Source Serif Pro 700","value":"Source+Serif+Pro:700"},"1133":{"name":"Special Elite regular","value":"Special+Elite:normal"},"1134":{"name":"Spicy Rice regular","value":"Spicy+Rice:normal"},"1135":{"name":"Spinnaker regular","value":"Spinnaker:normal"},"1136":{"name":"Spirax regular","value":"Spirax:normal"},"1137":{"name":"Squada One regular","value":"Squada+One:normal"},"1138":{"name":"Stalemate regular","value":"Stalemate:normal"},"1139":{"name":"Stalinist One regular","value":"Stalinist+One:normal"},"1140":{"name":"Stardos Stencil regular","value":"Stardos+Stencil:normal"},"1141":{"name":"Stardos Stencil 700","value":"Stardos+Stencil:700"},"1142":{"name":"Stint Ultra Condensed regular","value":"Stint+Ultra+Condensed:normal"},"1143":{"name":"Stint Ultra Expanded regular","value":"Stint+Ultra+Expanded:normal"},"1144":{"name":"Stoke 300","value":"Stoke:300"},"1145":{"name":"Stoke regular","value":"Stoke:normal"},"1146":{"name":"Strait regular","value":"Strait:normal"},"1147":{"name":"Sue Ellen Francisco regular","value":"Sue+Ellen+Francisco:normal"},"1148":{"name":"Sunshiney regular","value":"Sunshiney:normal"},"1149":{"name":"Supermercado One regular","value":"Supermercado+One:normal"},"1150":{"name":"Suwannaphum regular","value":"Suwannaphum:normal"},"1151":{"name":"Swanky and Moo Moo regular","value":"Swanky+and+Moo+Moo:normal"},"1152":{"name":"Syncopate regular","value":"Syncopate:normal"},"1153":{"name":"Syncopate 700","value":"Syncopate:700"},"1154":{"name":"Tangerine regular","value":"Tangerine:normal"},"1155":{"name":"Tangerine 700","value":"Tangerine:700"},"1156":{"name":"Taprom regular","value":"Taprom:normal"},"1157":{"name":"Tauri regular","value":"Tauri:normal"},"1158":{"name":"Teko 300","value":"Teko:300"},"1159":{"name":"Teko regular","value":"Teko:normal"},"1160":{"name":"Teko 500","value":"Teko:500"},"1161":{"name":"Teko 600","value":"Teko:600"},"1162":{"name":"Teko 700","value":"Teko:700"},"1163":{"name":"Telex regular","value":"Telex:normal"},"1164":{"name":"Tenor Sans regular","value":"Tenor+Sans:normal"},"1165":{"name":"Text Me One regular","value":"Text+Me+One:normal"},"1166":{"name":"The Girl Next Door regular","value":"The+Girl+Next+Door:normal"},"1167":{"name":"Tienne regular","value":"Tienne:normal"},"1168":{"name":"Tienne 700","value":"Tienne:700"},"1169":{"name":"Tienne 900","value":"Tienne:900"},"1170":{"name":"Tinos regular","value":"Tinos:normal"},"1171":{"name":"Tinos italic","value":"Tinos:italic"},"1172":{"name":"Tinos 700","value":"Tinos:700"},"1173":{"name":"Tinos 700italic","value":"Tinos:700italic"},"1174":{"name":"Titan One regular","value":"Titan+One:normal"},"1175":{"name":"Titillium Web 200","value":"Titillium+Web:200"},"1176":{"name":"Titillium Web 200italic","value":"Titillium+Web:200italic"},"1177":{"name":"Titillium Web 300","value":"Titillium+Web:300"},"1178":{"name":"Titillium Web 300italic","value":"Titillium+Web:300italic"},"1179":{"name":"Titillium Web regular","value":"Titillium+Web:normal"},"1180":{"name":"Titillium Web italic","value":"Titillium+Web:italic"},"1181":{"name":"Titillium Web 600","value":"Titillium+Web:600"},"1182":{"name":"Titillium Web 600italic","value":"Titillium+Web:600italic"},"1183":{"name":"Titillium Web 700","value":"Titillium+Web:700"},"1184":{"name":"Titillium Web 700italic","value":"Titillium+Web:700italic"},"1185":{"name":"Titillium Web 900","value":"Titillium+Web:900"},"1186":{"name":"Trade Winds regular","value":"Trade+Winds:normal"},"1187":{"name":"Trocchi regular","value":"Trocchi:normal"},"1188":{"name":"Trochut regular","value":"Trochut:normal"},"1189":{"name":"Trochut italic","value":"Trochut:italic"},"1190":{"name":"Trochut 700","value":"Trochut:700"},"1191":{"name":"Trykker regular","value":"Trykker:normal"},"1192":{"name":"Tulpen One regular","value":"Tulpen+One:normal"},"1193":{"name":"Ubuntu 300","value":"Ubuntu:300"},"1194":{"name":"Ubuntu 300italic","value":"Ubuntu:300italic"},"1195":{"name":"Ubuntu regular","value":"Ubuntu:normal"},"1196":{"name":"Ubuntu italic","value":"Ubuntu:italic"},"1197":{"name":"Ubuntu 500","value":"Ubuntu:500"},"1198":{"name":"Ubuntu 500italic","value":"Ubuntu:500italic"},"1199":{"name":"Ubuntu 700","value":"Ubuntu:700"},"1200":{"name":"Ubuntu 700italic","value":"Ubuntu:700italic"},"1201":{"name":"Ubuntu Condensed regular","value":"Ubuntu+Condensed:normal"},"1202":{"name":"Ubuntu Mono regular","value":"Ubuntu+Mono:normal"},"1203":{"name":"Ubuntu Mono italic","value":"Ubuntu+Mono:italic"},"1204":{"name":"Ubuntu Mono 700","value":"Ubuntu+Mono:700"},"1205":{"name":"Ubuntu Mono 700italic","value":"Ubuntu+Mono:700italic"},"1206":{"name":"Ultra regular","value":"Ultra:normal"},"1207":{"name":"Uncial Antiqua regular","value":"Uncial+Antiqua:normal"},"1208":{"name":"Underdog regular","value":"Underdog:normal"},"1209":{"name":"Unica One regular","value":"Unica+One:normal"},"1210":{"name":"UnifrakturCook 700","value":"UnifrakturCook:700"},"1211":{"name":"UnifrakturMaguntia regular","value":"UnifrakturMaguntia:normal"},"1212":{"name":"Unkempt regular","value":"Unkempt:normal"},"1213":{"name":"Unkempt 700","value":"Unkempt:700"},"1214":{"name":"Unlock regular","value":"Unlock:normal"},"1215":{"name":"Unna regular","value":"Unna:normal"},"1216":{"name":"VT323 regular","value":"VT323:normal"},"1217":{"name":"Vampiro One regular","value":"Vampiro+One:normal"},"1218":{"name":"Varela regular","value":"Varela:normal"},"1219":{"name":"Varela Round regular","value":"Varela+Round:normal"},"1220":{"name":"Vast Shadow regular","value":"Vast+Shadow:normal"},"1221":{"name":"Vesper Libre regular","value":"Vesper+Libre:normal"},"1222":{"name":"Vesper Libre 500","value":"Vesper+Libre:500"},"1223":{"name":"Vesper Libre 700","value":"Vesper+Libre:700"},"1224":{"name":"Vesper Libre 900","value":"Vesper+Libre:900"},"1225":{"name":"Vibur regular","value":"Vibur:normal"},"1226":{"name":"Vidaloka regular","value":"Vidaloka:normal"},"1227":{"name":"Viga regular","value":"Viga:normal"},"1228":{"name":"Voces regular","value":"Voces:normal"},"1229":{"name":"Volkhov regular","value":"Volkhov:normal"},"1230":{"name":"Volkhov italic","value":"Volkhov:italic"},"1231":{"name":"Volkhov 700","value":"Volkhov:700"},"1232":{"name":"Volkhov 700italic","value":"Volkhov:700italic"},"1233":{"name":"Vollkorn regular","value":"Vollkorn:normal"},"1234":{"name":"Vollkorn italic","value":"Vollkorn:italic"},"1235":{"name":"Vollkorn 700","value":"Vollkorn:700"},"1236":{"name":"Vollkorn 700italic","value":"Vollkorn:700italic"},"1237":{"name":"Voltaire regular","value":"Voltaire:normal"},"1238":{"name":"Waiting for the Sunrise regular","value":"Waiting+for+the+Sunrise:normal"},"1239":{"name":"Wallpoet regular","value":"Wallpoet:normal"},"1240":{"name":"Walter Turncoat regular","value":"Walter+Turncoat:normal"},"1241":{"name":"Warnes regular","value":"Warnes:normal"},"1242":{"name":"Wellfleet regular","value":"Wellfleet:normal"},"1243":{"name":"Wendy One regular","value":"Wendy+One:normal"},"1244":{"name":"Wire One regular","value":"Wire+One:normal"},"1245":{"name":"Yanone Kaffeesatz 200","value":"Yanone+Kaffeesatz:200"},"1246":{"name":"Yanone Kaffeesatz 300","value":"Yanone+Kaffeesatz:300"},"1247":{"name":"Yanone Kaffeesatz regular","value":"Yanone+Kaffeesatz:normal"},"1248":{"name":"Yanone Kaffeesatz 700","value":"Yanone+Kaffeesatz:700"},"1249":{"name":"Yellowtail regular","value":"Yellowtail:normal"},"1250":{"name":"Yeseva One regular","value":"Yeseva+One:normal"},"1251":{"name":"Yesteryear regular","value":"Yesteryear:normal"},"1252":{"name":"Zeyada regular","value":"Zeyada:normal"}}';

            // GET ALL SETTINGS
            // -------------------------------------------------------------
            if($wpdb->num_rows > 0) {
                
                foreach($rowSETs as $rowSET) {
                    $rowSET = (array)$rowSET;
                    
                    if ($rowSET['roll_back'] == 'latest' || $css_tbl == WDHSVWE_Temporary_CSS_table) {
                        $query_all = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by id ASC";
                        $result_all  = $wpdb->get_results($query_all);
                    }else if($rowSET['roll_back'] == 'original') {
                        // No Add CSS
                    } else {
                        $query_all = "Select * FROM `".$css_tbl."` where wid='".$wdhSVWE["WEBSITE_ID"]."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND unix_created_date <=".$rowSET['roll_back']." ORDER by id ASC";
                        $result_all  = $wpdb->get_results($query_all);
                    }

                    foreach ($result_all as $row) {
                        $row = (array)$row;
                        $row['text_font_family'] = str_replace('m@@','',$row['text_font_family']);
                        
                        if (!in_array($row['text_font_family'], $fontsHTML) && $row['text_font_family'] !='' && strpos($googleFontsDefault, $row['text_font_family']) !== false) {
                            
                            if (strpos($row['text_font_family'],',') !== false) {
                                $fontExtract = explode(',', $row['text_font_family']);
                                $row['text_font_family'] = $fontExtract[0];
                            }

                            array_push($fontsHTML, $row['text_font_family']);
                        }
                        $row['h_text_font_family'] = str_replace('m@@','',$row['h_text_font_family']);
                        
                        if (!in_array($row['h_text_font_family'], $fontsHTML) && $row['h_text_font_family'] !='' && strpos($googleFontsDefault, $row['h_text_font_family']) !== false) {
                            
                            if (strpos($row['h_text_font_family'],',') !== false) {
                                $fontExtract = explode(',', $row['h_text_font_family']);
                                $row['h_text_font_family'] = $fontExtract[0];
                            }

                            array_push($fontsHTML, $row['h_text_font_family']);
                        }
                    }
                }
            }
            
            return implode('|', $fontsHTML);
        }
        
        function getCSSProperties($row, $newline, $type = ''){
            global $wdhSVWE;
            $cssHTML = array();
            $skip105 = false;
            $importantCSS = '';
            
            
            // Before 1.06 version
            $lastID_105 = get_option('WDH_SVWE_last_id_105');
            
            if(isset($lastID_105)) {
                
                if ($row['id'] <= $lastID_105) {
                    $skip105 = true;
                }
            }
            // End Before 1.06 version
            
            // Add important
            if ($wdhSVWE["WDH_DEFAULT_CSS_IMPORTANT"] == true) {
                $importantCSS = ' !important';
            }
            
            // Text Color
            if($row[$type.'text_color'] != '' && (strpos($row[$type.'text_color'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_color'] = str_replace('m@@','',$row[$type.'text_color']);
                array_push($cssHTML, 'color:#'.$row[$type.'text_color'].$importantCSS.';');
            }
            
            if (strpos($row[$type.'text_font_family'],':') === false) {

                // Text Font Family
                if($row[$type.'text_font_family'] != '' && (strpos($row[$type.'text_font_family'],'m@@') !== false || $skip105 == true)){
                    $row[$type.'text_font_family'] = str_replace('m@@','',$row[$type.'text_font_family']);
                    array_push($cssHTML, 'font-family:'.$row[$type.'text_font_family'].$importantCSS.';');
                }

                // Text Font Weight
                if($row[$type.'text_font_weight'] != '' && (strpos($row[$type.'text_font_weight'],'m@@') !== false || $skip105 == true)){
                    $row[$type.'text_font_weight'] = str_replace('m@@','',$row[$type.'text_font_weight']);
                    array_push($cssHTML, 'font-weight:'.$row[$type.'text_font_weight'].$importantCSS.';');
                }

                // Text Font Style
                if($row[$type.'text_font_style'] != '' && (strpos($row[$type.'text_font_style'],'m@@') !== false || $skip105 == true)){
                    $row[$type.'text_font_style'] = str_replace('m@@','',$row[$type.'text_font_style']);
                    array_push($cssHTML, 'font-style:'.$row[$type.'text_font_style'].$importantCSS.';');
                }
            } else {
                
                if (strpos($row[$type.'text_font_family'],',') === false) {
                    $fontSecond = explode(":",$row[$type.'text_font_family']);
                    $fontSecond = $fontSecond[1];
                    $fontWeight = intval($fontSecond);

                    if ($fontWeight < 1) {
                        $fontWeight = 400;
                    }

                    $fontStyle = str_replace($fontWeight,"", $fontSecond);
                    
                    // Google Font
                    if (strpos($row[$type.'text_font_family'],'m@@') !== false || $skip105 == true){
                        $row[$type.'text_font_family'] = str_replace('m@@','',$row[$type.'text_font_family']);
                        array_push($cssHTML, 'font-family:'.$this->wdhGFontsName($row[$type.'text_font_family']).$importantCSS.';');
                    }
                    
                    // Text Font Weight
                    if($row[$type.'text_font_weight'] != '' && (strpos($row[$type.'text_font_weight'],'m@@') !== false || $skip105 == true)){
                        $row[$type.'text_font_weight'] = str_replace('m@@','',$row[$type.'text_font_weight']);
                        array_push($cssHTML, 'font-weight:'.$fontWeight.$importantCSS.';');
                    }

                    // Text Font Style
                    if($row[$type.'text_font_style'] != '' && (strpos($row[$type.'text_font_style'],'m@@') !== false || $skip105 == true)){
                        $row[$type.'text_font_style'] = str_replace('m@@','',$row[$type.'text_font_style']);
                        array_push($cssHTML, 'font-style:'.$fontStyle.$importantCSS.';');
                    }
                } else {
                    // Text Font Style
                    if($row[$type.'text_font_style'] != '' && (strpos($row[$type.'text_font_style'],'m@@') !== false || $skip105 == true)){
                        $row[$type.'text_font_style'] = str_replace('m@@','',$row[$type.'text_font_style']);
                        array_push($cssHTML, 'font-style:'.$row[$type.'text_font_style'].$importantCSS.';');
                    }
                }
            }

            // Text Font Size
            if($row[$type.'text_font_size'] != '' && (strpos($row[$type.'text_font_size'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_font_size'] = str_replace('m@@','',$row[$type.'text_font_size']);
                array_push($cssHTML, 'font-size:'.$row[$type.'text_font_size'].$importantCSS.';');
            }

             // Text Font Variant
            if($row[$type.'text_font_variant'] != '' && (strpos($row[$type.'text_font_variant'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_font_variant'] = str_replace('m@@','',$row[$type.'text_font_variant']);
                array_push($cssHTML, 'font-variant:'.$row[$type.'text_font_variant'].$importantCSS.';');
            }

            // Text Font Line Height
            if($row[$type.'text_font_line_height'] != '' && (strpos($row[$type.'text_font_line_height'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_font_line_height'] = str_replace('m@@','',$row[$type.'text_font_line_height']);
                array_push($cssHTML, 'line-height:'.$row[$type.'text_font_line_height'].$importantCSS.';');
            }

            // Text Font Letter Spacing
            if($row[$type.'text_font_letter_spacing'] != '' && (strpos($row[$type.'text_font_letter_spacing'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_font_letter_spacing'] = str_replace('m@@','',$row[$type.'text_font_letter_spacing']);
                array_push($cssHTML, 'letter-spacing:'.$row[$type.'text_font_letter_spacing'].$importantCSS.';');
            }

            // Text Font Word Spacing
            if($row[$type.'text_font_word_spacing'] != '' && (strpos($row[$type.'text_font_word_spacing'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_font_word_spacing'] = str_replace('m@@','',$row[$type.'text_font_word_spacing']);
                array_push($cssHTML, 'word-spacing:'.$row[$type.'text_font_word_spacing'].$importantCSS.';');
            }

            // Text Font Align
            if($row[$type.'text_font_align'] != '' && (strpos($row[$type.'text_font_align'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_font_align'] = str_replace('m@@','',$row[$type.'text_font_align']);
                array_push($cssHTML, 'text-align:'.$row[$type.'text_font_align'].$importantCSS.';');
            }

            // Text Font Decoration
            if($row[$type.'text_font_decoration'] != '' && (strpos($row[$type.'text_font_decoration'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_font_decoration'] = str_replace('m@@','',$row[$type.'text_font_decoration']);
                array_push($cssHTML, 'text-decoration:'.$row[$type.'text_font_decoration'].$importantCSS.';');
            }

             // Text Font Transform
            if($row[$type.'text_font_transform'] != '' && (strpos($row[$type.'text_font_transform'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_font_transform'] = str_replace('m@@','',$row[$type.'text_font_transform']);
                array_push($cssHTML, 'text-transform:'.$row[$type.'text_font_transform'].$importantCSS.';');
            }

             // Text Font Indent
            if($row[$type.'text_font_indent'] != '' && (strpos($row[$type.'text_font_indent'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_font_indent'] = str_replace('m@@','',$row[$type.'text_font_indent']);
                array_push($cssHTML, 'text-indent:'.$row[$type.'text_font_indent'].$importantCSS.';');
            }

             // Text Font Vertical-Align
            if($row[$type.'text_font_vertical_align'] != '' && (strpos($row[$type.'text_font_vertical_align'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_font_vertical_align'] = str_replace('m@@','',$row[$type.'text_font_vertical_align']);
                array_push($cssHTML, 'vertical-align:'.$row[$type.'text_font_vertical_align'].$importantCSS.';');
            }

             // Text Font White-Space
            if($row[$type.'text_font_white_space'] != '' && (strpos($row[$type.'text_font_white_space'],'m@@') !== false || $skip105 == true)){
                $row[$type.'text_font_white_space'] = str_replace('m@@','',$row[$type.'text_font_white_space']);
                array_push($cssHTML, 'white-space:'.$row[$type.'text_font_white_space'].$importantCSS.';');
            }

             // Box Background
            if($row[$type.'box_background'] != '' && (strpos($row[$type.'box_background'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_background'] = str_replace('m@@','',$row[$type.'box_background']);
                array_push($cssHTML, 'background:'.$row[$type.'box_background'].$importantCSS.';');
            }

             // Box Background Color
            if($row[$type.'box_background_color'] != '' && (strpos($row[$type.'box_background_color'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_background_color'] = str_replace('m@@','',$row[$type.'box_background_color']);
                array_push($cssHTML, 'background-color:#'.$row[$type.'box_background_color'].$importantCSS.';');
            }

             // Box Background Size
            if($row[$type.'box_background_size'] != '' && (strpos($row[$type.'box_background_size'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_background_size'] = str_replace('m@@','',$row[$type.'box_background_size']);
                array_push($cssHTML, 'background-size:'.$row[$type.'box_background_size'].$importantCSS.';');
            }

             // Box Background Image
            if($row[$type.'box_background_image'] != '' && (strpos($row[$type.'box_background_image'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_background_image'] = str_replace('m@@','',$row[$type.'box_background_image']);
                array_push($cssHTML, 'background-image:url('.WP_CONTENT_URL.'/wdhsvwe/uploads/images/'.$row[$type.'box_background_image'].');');
            }

             // Box Background Repeat
            if($row[$type.'box_background_repeat'] != '' && (strpos($row[$type.'box_background_repeat'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_background_repeat'] = str_replace('m@@','',$row[$type.'box_background_repeat']);
                array_push($cssHTML, 'background-repeat:'.$row[$type.'box_background_repeat'].$importantCSS.';');
            }

             // Box Background Position X , Y
            if($row[$type.'box_background_position_x'] != '' && $row[$type.'box_background_position_y'] != '' && ((strpos($row[$type.'box_background_position_y'],'m@@') !== false && strpos($row[$type.'box_background_position_x'],'m@@') !== false) || $skip105 == true)){
                $row[$type.'box_background_position_x'] = str_replace('m@@','',$row[$type.'box_background_position_x']);
                $row[$type.'box_background_position_y'] = str_replace('m@@','',$row[$type.'box_background_position_y']);
                array_push($cssHTML, 'background-position:'.$row[$type.'box_background_position_x'].' '.$row[$type.'box_background_position_y'].$importantCSS.';');
            }

             // Box Background Attachment
            if($row[$type.'box_background_attachment'] != '' && (strpos($row[$type.'box_background_attachment'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_background_attachment'] = str_replace('m@@','',$row[$type.'box_background_attachment']);
                array_push($cssHTML, 'background-attachment:'.$row[$type.'box_background_attachment'].$importantCSS.';');
            }

            // Box Padding Top
            if($row[$type.'box_padding_top'] != '' && (strpos($row[$type.'box_padding_top'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_padding_top'] = str_replace('m@@','',$row[$type.'box_padding_top']);
                array_push($cssHTML, 'padding-top:'.$row[$type.'box_padding_top'].$importantCSS.';');
            }

            // Box Padding Bottom
            if($row[$type.'box_padding_bottom'] != '' && (strpos($row[$type.'box_padding_bottom'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_padding_bottom'] = str_replace('m@@','',$row[$type.'box_padding_bottom']);
                array_push($cssHTML, 'padding-bottom:'.$row[$type.'box_padding_bottom'].$importantCSS.';');
            }

            // Box Padding Right
            if($row[$type.'box_padding_right'] != '' && (strpos($row[$type.'box_padding_right'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_padding_right'] = str_replace('m@@','',$row[$type.'box_padding_right']);
                array_push($cssHTML, 'padding-right:'.$row[$type.'box_padding_right'].$importantCSS.';');
            }

            // Box Padding Left
            if($row[$type.'box_padding_left'] != ''){
                array_push($cssHTML, 'padding-left:'.$row[$type.'box_padding_left'].$importantCSS.';');
            }
            
            // Box Padding Left
            if($row[$type.'box_padding_left'] != '' && (strpos($row[$type.'box_padding_left'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_padding_left'] = str_replace('m@@','',$row[$type.'box_padding_left']);
                array_push($cssHTML, 'padding-left:'.$row[$type.'box_padding_left'].$importantCSS.';');
            }

            // Box Margin Top
            if($row[$type.'box_margin_top'] != '' && (strpos($row[$type.'box_margin_top'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_margin_top'] = str_replace('m@@','',$row[$type.'box_margin_top']);
                array_push($cssHTML, 'margin-top:'.$row[$type.'box_margin_top'].$importantCSS.';');
            }

            // Box Margin Bottom
            if($row[$type.'box_margin_bottom'] != '' && (strpos($row[$type.'box_margin_bottom'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_margin_bottom'] = str_replace('m@@','',$row[$type.'box_margin_bottom']);
                array_push($cssHTML, 'margin-bottom:'.$row[$type.'box_margin_bottom'].$importantCSS.';');
            }

            // Box Margin Right
            if($row[$type.'box_margin_right'] != '' && (strpos($row[$type.'box_margin_right'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_margin_right'] = str_replace('m@@','',$row[$type.'box_margin_right']);
                array_push($cssHTML, 'margin-right:'.$row[$type.'box_margin_right'].$importantCSS.';');
            }

            // Box Margin Left
            if($row[$type.'box_margin_left'] != '' && (strpos($row[$type.'box_margin_left'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_margin_left'] = str_replace('m@@','',$row[$type.'box_margin_left']);
                array_push($cssHTML, 'margin-left:'.$row[$type.'box_margin_left'].$importantCSS.';');
            }

            // Box Border
            if($row[$type.'box_border'] != '' && (strpos($row[$type.'box_border'],'m@@') !== false || $skip105 == true) && $row[$type.'box_border_color'] != ''){
                $row[$type.'box_border'] = str_replace('m@@','',$row[$type.'box_border']);
                $row[$type.'box_border_color'] = str_replace('m@@','',$row[$type.'box_border_color']);
                array_push($cssHTML, 'border:'.$row[$type.'box_border'].' #'.$row[$type.'box_border_color'].$importantCSS.';');
            }

            // Box Border Top
            if($row[$type.'box_border_top'] != '' && (strpos($row[$type.'box_border_top'],'m@@') !== false || $skip105 == true) && $row[$type.'box_border_top_color'] != ''){
                $row[$type.'box_border_top'] = str_replace('m@@','',$row[$type.'box_border_top']);
                $row[$type.'box_border_top_color'] = str_replace('m@@','',$row[$type.'box_border_top_color']);
                array_push($cssHTML, 'border-top:'.$row[$type.'box_border_top'].' #'.$row[$type.'box_border_top_color'].$importantCSS.';');
            }

            // Box Border Bottom
            if($row[$type.'box_border_bottom'] != '' && (strpos($row[$type.'box_border_bottom'],'m@@') !== false || $skip105 == true) && $row[$type.'box_border_bottom_color'] != ''){
                $row[$type.'box_border_bottom'] = str_replace('m@@','',$row[$type.'box_border_bottom']);
                $row[$type.'box_border_bottom_color'] = str_replace('m@@','',$row[$type.'box_border_bottom_color']);
                array_push($cssHTML, 'border-bottom:'.$row[$type.'box_border_bottom'].' #'.$row[$type.'box_border_bottom_color'].$importantCSS.';');
            }

            // Box Border Right
            if($row[$type.'box_border_right'] != '' && (strpos($row[$type.'box_border_right'],'m@@') !== false || $skip105 == true) && $row[$type.'box_border_right_color'] != ''){
                $row[$type.'box_border_right'] = str_replace('m@@','',$row[$type.'box_border_right']);
                $row[$type.'box_border_right_color'] = str_replace('m@@','',$row[$type.'box_border_right_color']);
                array_push($cssHTML, 'border-right:'.$row[$type.'box_border_right'].' #'.$row[$type.'box_border_right_color'].$importantCSS.';');
            }

            // Box Border Left
            if($row[$type.'box_border_left'] != '' && (strpos($row[$type.'box_border_left'],'m@@') !== false || $skip105 == true) && $row[$type.'box_border_left_color'] != ''){
                $row[$type.'box_border_left'] = str_replace('m@@','',$row[$type.'box_border_left']);
                $row[$type.'box_border_left_color'] = str_replace('m@@','',$row[$type.'box_border_left_color']);
                array_push($cssHTML, 'border-left:'.$row[$type.'box_border_left'].' #'.$row[$type.'box_border_left_color'].$importantCSS.';');
            }

            // Box Border Radius
            if($row[$type.'box_border_radius'] != '' && (strpos($row[$type.'box_border_radius'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_radius'] = str_replace('m@@','',$row[$type.'box_border_radius']);
                array_push($cssHTML, 'border-radius:'.$row[$type.'box_border_radius'].$importantCSS.';');
            }

            // Box Border Top Style
            if($row[$type.'box_border_top_style'] != '' && (strpos($row[$type.'box_border_top_style'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_top_style'] = str_replace('m@@','',$row[$type.'box_border_top_style']);
                array_push($cssHTML, 'border-top-style:'.$row[$type.'box_border_top_style'].$importantCSS.';');
            }

            // Box Border Bottom Style
            if($row[$type.'box_border_bottom_style'] != '' && (strpos($row[$type.'box_border_bottom_style'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_bottom_style'] = str_replace('m@@','',$row[$type.'box_border_bottom_style']);
                array_push($cssHTML, 'border-bottom-style:'.$row[$type.'box_border_bottom_style'].$importantCSS.';');
            }

            // Box Border Right Style
            if($row[$type.'box_border_right_style'] != '' && (strpos($row[$type.'box_border_right_style'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_right_style'] = str_replace('m@@','',$row[$type.'box_border_right_style']);
                array_push($cssHTML, 'border-right-style:'.$row[$type.'box_border_right_style'].$importantCSS.';');
            }

            // Box Border Left Style
            if($row[$type.'box_border_left_style'] != '' && (strpos($row[$type.'box_border_left_style'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_left_style'] = str_replace('m@@','',$row[$type.'box_border_left_style']);
                array_push($cssHTML, 'border-left-style:'.$row[$type.'box_border_left_style'].$importantCSS.';');
            }

            // Box Border Top Color
            if($row[$type.'box_border_top_color'] != '' && (strpos($row[$type.'box_border_top_color'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_top_color'] = str_replace('m@@','',$row[$type.'box_border_top_color']);
                array_push($cssHTML, 'border-top-color:#'.$row[$type.'box_border_top_color'].$importantCSS.';');
            }

            // Box Border Bottom Color
            if($row[$type.'box_border_bottom_color'] != '' && (strpos($row[$type.'box_border_bottom_color'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_bottom_color'] = str_replace('m@@','',$row[$type.'box_border_bottom_color']);
                array_push($cssHTML, 'border-bottom-color:#'.$row[$type.'box_border_bottom_color'].$importantCSS.';');
            }

            // Box Border Right Color
            if($row[$type.'box_border_right_color'] != '' && (strpos($row[$type.'box_border_right_color'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_right_color'] = str_replace('m@@','',$row[$type.'box_border_right_color']);
                array_push($cssHTML, 'border-right-color:#'.$row[$type.'box_border_right_color'].$importantCSS.';');
            }

            // Box Border Left Color
            if($row[$type.'box_border_left_color'] != '' && (strpos($row[$type.'box_border_left_color'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_left_color'] = str_replace('m@@','',$row[$type.'box_border_left_color']);
                array_push($cssHTML, 'border-left-color:#'.$row[$type.'box_border_left_color'].$importantCSS.';');
            }

            // Box Border  Top Left Radius
            if($row[$type.'box_border_top_left_radius'] != '' && (strpos($row[$type.'box_border_top_left_radius'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_top_left_radius'] = str_replace('m@@','',$row[$type.'box_border_top_left_radius']);
                array_push($cssHTML, 'border-top-left-radius:'.$row[$type.'box_border_top_left_radius'].$importantCSS.';');
            }

            // Box Border  Top Right Radius
            if($row[$type.'box_border_top_right_radius'] != '' && (strpos($row[$type.'box_border_top_right_radius'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_top_right_radius'] = str_replace('m@@','',$row[$type.'box_border_top_right_radius']);
                array_push($cssHTML, 'border-top-right-radius:'.$row[$type.'box_border_top_right_radius'].$importantCSS.';');
            }
            
            // Box Border Bottom Right Radius
            if($row[$type.'box_border_bottom_right_radius'] != '' && (strpos($row[$type.'box_border_bottom_right_radius'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_bottom_right_radius'] = str_replace('m@@','',$row[$type.'box_border_bottom_right_radius']);
                array_push($cssHTML, 'border-bottom-right-radius:'.$row[$type.'box_border_bottom_right_radius'].$importantCSS.';');
            }

             // Box Border Bottom Left Radius
            if($row[$type.'box_border_bottom_left_radius'] != '' && (strpos($row[$type.'box_border_bottom_left_radius'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_bottom_left_radius'] = str_replace('m@@','',$row[$type.'box_border_bottom_left_radius']);
                array_push($cssHTML, 'border-bottom-left-radius:'.$row[$type.'box_border_bottom_left_radius'].$importantCSS.';');
            }

            // Box Outline
            if($row[$type.'box_outline'] != '' && (strpos($row[$type.'box_outline'],'m@@') !== false || $skip105 == true) && $row[$type.'box_outline_color'] != ''){
                $row[$type.'box_outline'] = str_replace('m@@','',$row[$type.'box_outline']);
                $row[$type.'box_outline_color'] = str_replace('m@@','',$row[$type.'box_outline_color']);
                array_push($cssHTML, 'outline:'.$row[$type.'box_outline'].' #'.$row[$type.'box_outline_color'].$importantCSS.';');
            }

            // Box Width
            if($row[$type.'box_width'] != '' && (strpos($row[$type.'box_width'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_width'] = str_replace('m@@','',$row[$type.'box_width']);
                array_push($cssHTML, 'width:'.$row[$type.'box_width'].$importantCSS.';');
            }

            // Box Min Width
            if($row[$type.'box_min_width'] != '' && (strpos($row[$type.'box_min_width'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_min_width'] = str_replace('m@@','',$row[$type.'box_min_width']);
                array_push($cssHTML, 'min-width:'.$row[$type.'box_min_width'].$importantCSS.';');
            }

            // Box Max Width
            if($row[$type.'box_max_width'] != '' && (strpos($row[$type.'box_max_width'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_max_width'] = str_replace('m@@','',$row[$type.'box_max_width']);
                array_push($cssHTML, 'max-width:'.$row[$type.'box_max_width'].$importantCSS.';');
            }

            // Box Height
            if($row[$type.'box_height'] != '' && (strpos($row[$type.'box_height'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_height'] = str_replace('m@@','',$row[$type.'box_height']);
                array_push($cssHTML, 'height:'.$row[$type.'box_height'].$importantCSS.';');
            }

            // Box Min Height
            if($row[$type.'box_min_height'] != '' && (strpos($row[$type.'box_min_height'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_min_height'] = str_replace('m@@','',$row[$type.'box_min_height']);
                array_push($cssHTML, 'min-height:'.$row[$type.'box_min_height'].$importantCSS.';');
            }

            // Box Max Height
            if($row[$type.'box_max_height'] != '' && (strpos($row[$type.'box_max_height'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_max_height'] = str_replace('m@@','',$row[$type.'box_max_height']);
                array_push($cssHTML, 'max-height:'.$row[$type.'box_max_height'].$importantCSS.';');
            }

            // Box Position
            if($row[$type.'box_position'] != '' && (strpos($row[$type.'box_position'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_position'] = str_replace('m@@','',$row[$type.'box_position']);
                array_push($cssHTML, 'position:'.$row[$type.'box_position'].$importantCSS.';');
            }

            // Box Top
            if($row[$type.'box_top'] != '0px' && $row[$type.'box_top'] != '' && (strpos($row[$type.'box_top'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_top'] = str_replace('m@@','',$row[$type.'box_top']);
                array_push($cssHTML, 'top:'.$row[$type.'box_top'].$importantCSS.';');
            }

            // Box Bottom
            if($row[$type.'box_bottom'] != '0px' && $row[$type.'box_bottom'] != '' && (strpos($row[$type.'box_bottom'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_bottom'] = str_replace('m@@','',$row[$type.'box_bottom']);
                array_push($cssHTML, 'bottom:'.$row[$type.'box_bottom'].$importantCSS.';');
            }

            // Box Right
            if($row[$type.'box_right'] != '0px' && $row[$type.'box_right'] != '' && (strpos($row[$type.'box_right'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_right'] = str_replace('m@@','',$row[$type.'box_right']);
                array_push($cssHTML, 'right:'.$row[$type.'box_right'].$importantCSS.';');
            }

            // Box Left
            if($row[$type.'box_left'] != '0px' && $row[$type.'box_left'] != '' && (strpos($row[$type.'box_left'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_left'] = str_replace('m@@','',$row[$type.'box_left']);
                array_push($cssHTML, 'left:'.$row[$type.'box_left'].$importantCSS.';');
            }

            // Box Clip
            if($row[$type.'box_clip'] != '' && (strpos($row[$type.'box_clip'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_clip'] = str_replace('m@@','',$row[$type.'box_clip']);
                array_push($cssHTML, 'clip:'.$row[$type.'box_clip'].$importantCSS.';');
            }

            // Box Overflow
            if($row[$type.'box_overflow'] != '' && (strpos($row[$type.'box_overflow'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_overflow'] = str_replace('m@@','',$row[$type.'box_overflow']);
                array_push($cssHTML, 'overflow:'.$row[$type.'box_overflow'].$importantCSS.';');
            }
            
            // Box Z Index
            if($row[$type.'box_z_index'] != '' && (strpos($row[$type.'box_z_index'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_z_index'] = str_replace('m@@','',$row[$type.'box_z_index']);
                array_push($cssHTML, 'z-index:'.$row[$type.'box_z_index'].$importantCSS.';');
            }
            
            // Float
            if($row[$type.'box_float'] != '' && (strpos($row[$type.'box_float'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_float'] = str_replace('m@@','',$row[$type.'box_float']);
                array_push($cssHTML, 'float:'.$row[$type.'box_float'].$importantCSS.';');
            }

            // Box Clear
            if($row[$type.'box_clear'] != '' && (strpos($row[$type.'box_clear'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_clear'] = str_replace('m@@','',$row[$type.'box_clear']);
                array_push($cssHTML, 'clear:'.$row[$type.'box_clear'].$importantCSS.';');
            }

            // Box Display
            if($row[$type.'box_display'] != '' && (strpos($row[$type.'box_display'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_display'] = str_replace('m@@','',$row[$type.'box_display']);
                array_push($cssHTML, 'display:'.$row[$type.'box_display'].$importantCSS.';');
            }

            // Box Visibility
            if($row[$type.'box_visibility'] != '' && (strpos($row[$type.'box_visibility'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_visibility'] = str_replace('m@@','',$row[$type.'box_visibility']);
                array_push($cssHTML, 'visibility:'.$row[$type.'box_visibility'].$importantCSS.';');
            }

            // Box List-Style
            if($row[$type.'box_list_style'] != '' && (strpos($row[$type.'box_list_style'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_list_style'] = str_replace('m@@','',$row[$type.'box_list_style']);
                array_push($cssHTML, 'list-style:'.$row[$type.'box_list_style'].$importantCSS.';');
            }

            // Box List-Style Type
            if($row[$type.'box_list_style_type'] != '' && (strpos($row[$type.'box_list_style_type'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_list_style_type'] = str_replace('m@@','',$row[$type.'box_list_style_type']);
                array_push($cssHTML, 'list-style-type:'.$row[$type.'box_list_style_type'].$importantCSS.';');
            }

            // Box List-Style Position
            if($row[$type.'box_list_style_position'] != '' && (strpos($row[$type.'box_list_style_position'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_list_style_position'] = str_replace('m@@','',$row[$type.'box_list_style_position']);
                array_push($cssHTML, 'list-style-position:'.$row[$type.'box_list_style_position'].$importantCSS.';');
            }

            // Box List-Style Image
            if($row[$type.'box_list_style_image'] != '' && (strpos($row[$type.'box_list_style_image'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_list_style_image'] = str_replace('m@@','',$row[$type.'box_list_style_image']);
                array_push($cssHTML, 'list-style-image:'.$row[$type.'box_list_style_image'].$importantCSS.';');
            }

            // Box Table Layout
            if($row[$type.'box_table_layout'] != '' && (strpos($row[$type.'box_table_layout'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_table_layout'] = str_replace('m@@','',$row[$type.'box_table_layout']);
                array_push($cssHTML, 'table-layout:'.$row[$type.'box_table_layout'].$importantCSS.';');
            }

            // Box Border Collapse
            if($row[$type.'box_border_collapse'] != '' && (strpos($row[$type.'box_border_collapse'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_collapse'] = str_replace('m@@','',$row[$type.'box_border_collapse']);
                array_push($cssHTML, 'border-collapse:'.$row[$type.'box_border_collapse'].$importantCSS.';');
            }

            // Box Border Spacing
            if($row[$type.'box_border_spacing'] != '' && (strpos($row[$type.'box_border_spacing'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_border_spacing'] = str_replace('m@@','',$row[$type.'box_border_spacing']);
                array_push($cssHTML, 'border-spacing:'.$row[$type.'box_border_spacing'].$importantCSS.';');
            }

            // Box Caption Side
            if($row[$type.'box_caption_side'] != '' && (strpos($row[$type.'box_caption_side'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_caption_side'] = str_replace('m@@','',$row[$type.'box_caption_side']);
                array_push($cssHTML, 'caption-side:'.$row[$type.'box_caption_side'].$importantCSS.';');
            }

            // Box Content
            if($row[$type.'box_content'] != '' && (strpos($row[$type.'box_content'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_content'] = str_replace('m@@','',$row[$type.'box_content']);
                array_push($cssHTML, 'content:'.$row[$type.'box_content'].$importantCSS.';');
            }

            // Box Counter Increment
            if($row[$type.'box_counter_increment'] != '' && (strpos($row[$type.'box_counter_increment'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_counter_increment'] = str_replace('m@@','',$row[$type.'box_counter_increment']);
                array_push($cssHTML, 'counter-increment:'.$row[$type.'box_counter_increment'].$importantCSS.';');
            }

            // Box Page Break Before
            if($row[$type.'box_page_break_before'] != '' && (strpos($row[$type.'box_page_break_before'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_page_break_before'] = str_replace('m@@','',$row[$type.'box_page_break_before']);
                array_push($cssHTML, 'page-break-before:'.$row[$type.'box_page_break_before'].$importantCSS.';');
            }

            // Box Page Break After
            if($row[$type.'box_page_break_after'] != '' && (strpos($row[$type.'box_page_break_after'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_page_break_after'] = str_replace('m@@','',$row[$type.'box_page_break_after']);
                array_push($cssHTML, 'page-break-after:'.$row[$type.'box_page_break_after'].$importantCSS.';');
            }

            // Box Page Break Inside
            if($row[$type.'box_page_break_inside'] != '' && (strpos($row[$type.'box_page_break_inside'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_page_break_inside'] = str_replace('m@@','',$row[$type.'box_page_break_inside']);
                array_push($cssHTML, 'page-break-inside:'.$row[$type.'box_page_break_inside'].$importantCSS.';');
            }

            // Box Orfans
            if($row[$type.'box_orfans'] != '' && (strpos($row[$type.'box_orfans'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_orfans'] = str_replace('m@@','',$row[$type.'box_orfans']);
                array_push($cssHTML, 'orphans:'.$row[$type.'box_orfans'].$importantCSS.';');
            }

            // Box Windows
            if($row[$type.'box_windows'] != '' && (strpos($row[$type.'box_windows'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_windows'] = str_replace('m@@','',$row[$type.'box_windows']);
                array_push($cssHTML, 'widows:'.$row[$type.'box_windows'].$importantCSS.';');
            }

            // Box Cursor
            if($row[$type.'box_cursor'] != '' && (strpos($row[$type.'box_cursor'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_cursor'] = str_replace('m@@','',$row[$type.'box_cursor']);
                array_push($cssHTML, 'cursor:'.$row[$type.'box_cursor'].$importantCSS.';');
            }

            // Box Direction
            if($row[$type.'box_direction'] != '' && (strpos($row[$type.'box_direction'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_direction'] = str_replace('m@@','',$row[$type.'box_direction']);
                array_push($cssHTML, 'direction:'.$row[$type.'box_direction'].$importantCSS.';');
            }

            // Box Unicode Bidi
            if($row[$type.'box_unicode_bidi'] != '' && (strpos($row[$type.'box_unicode_bidi'],'m@@') !== false || $skip105 == true)){
                $row[$type.'box_unicode_bidi'] = str_replace('m@@','',$row[$type.'box_unicode_bidi']);
                array_push($cssHTML, 'unicode-bidi:'.$row[$type.'box_unicode_bidi'].$importantCSS.';');
            }
            
            
            $extraGroups = (object)json_decode(str_replace("'",'"',$wdhSVWE['WDH_SVWE_EXTRA_GROUPS']));
            $extraFields = $wdhSVWE['WDH_SVWE_EXTRA_FIELDS'];

            if (!empty($extraGroups)) {
                $ext = 0;

                foreach($extraGroups as $key => $value){
                    $groupName = $extraGroups->{$key}->name;

                    if (!empty($extraFields)) {
                        $extraFieldSelected = $extraFields[$groupName];

                        if (!empty($extraFieldSelected)) {
                            
                            foreach($extraFieldSelected as $subkey => $subvalue){
                                $skipProp = false;
                                
                                if(isset($extraFieldSelected[$subkey]['always'])) {
                                    
                                    if ($extraFieldSelected[$subkey]['always'] == true){
                                        $skipProp = true;
                                    }
                                }
                                // Extra CSS
                                if((strpos($row[$type.$extraFieldSelected[$subkey]['name']],'m@@') !== false || $skipProp == true)){
                                    $row[$type.$extraFieldSelected[$subkey]['name']] = str_replace('m@@','',$row[$type.$extraFieldSelected[$subkey]['name']]);
                                    array_push($cssHTML, $extraFieldSelected[$subkey]['css'].':'.$row[$type.$extraFieldSelected[$subkey]['name']].$importantCSS.';');
                                    
                                    if ($extraFieldSelected[$subkey]['css_web_kit'] == true) {
                                        array_push($cssHTML, '-webkit-'.$extraFieldSelected[$subkey]['css'].':'.$row[$type.$extraFieldSelected[$subkey]['name']].$importantCSS.';');
                                    } 
                                }
                            }
                        }
                    }

                    $ext++;
                }
            }
            
            return implode($newline, $cssHTML);
        }
        
        function generateCSSFiles($wdhRole){
            global $wdhSVWE, $wpdb;
            $cssFiles = array();
            
            $wid           = $wdhSVWE['WEBSITE_ID'];
            $wdhPageOn     = $wdhSVWE['page_on'];
//            $wdhRole       = $wdhSVWE['role'];
            $settingsCSS   = "SELECT * FROM ".WDHSVWE_Settings_table." where wid='".$wid."' AND used_for='website' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
            $row           = $wpdb->get_row($settingsCSS, ARRAY_A);
            
            $wdhPageUrl    = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            
            $wdhHistoryAddedID = '';
            // GET ALL SETTINGS FOR WEBSITE
            // -------------------------------------------------------------
            if ($wdhRole == 'all') {
                $wdhHistoryAddedID = '-all';
            }
            
            if($wpdb->num_rows > 0) {
                
                if ($row['roll_back'] == 'latest') {

                    // GET HISTORY FOR ENTIRE WEBSITE
                    // ---------------------------------------------------------
                    $historyCSS    = "SELECT * FROM ".WDHSVWE_History_table." where wid='".$wid."' AND used_for='website' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date DESC";
                    $history       = $wpdb->get_row($historyCSS, ARRAY_A);

                    if($wpdb->num_rows > 0) { 
                        array_push($cssFiles, '<link id="wdh-svwe-history-website'.$wdhHistoryAddedID.'" rel="stylesheet" href="'.WP_CONTENT_URL.'/wdhsvwe/css/style.website.'.$wdhPageOn.'.'.$wdhRole.'.'.$history['unix_created_date'].'.min.css">');
                    }

                } else if ($row['roll_back'] == 'original') {
                    // No Load CSS files
                } else {
                    // GET HISTORY FOR ENTIRE WEBSITE
                    // ---------------------------------------------------------
                    $historyCSS    = "SELECT * FROM ".WDHSVWE_History_table." where wid='".$wid."' AND used_for='website' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND unix_created_date='".$row['roll_back']."' ORDER by unix_created_date DESC";
                    $history = $wpdb->get_row($historyCSS, ARRAY_A);

                    if($wpdb->num_rows > 0) {
                        array_push($cssFiles, '<link id="wdh-svwe-history-website'.$wdhHistoryAddedID.'" rel="stylesheet" href="'.WP_CONTENT_URL.'/wdhsvwe/css/style.website.'.$wdhPageOn.'.'.$wdhRole.'.'.$history['unix_created_date'].'.min.css">');
                    }
                }
            }

            $settingsCSS   = "SELECT * FROM ".WDHSVWE_Settings_table." where wid='".$wid."' AND used_for='current_page' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."'";
            $row           = $wpdb->get_row($settingsCSS, ARRAY_A);

            // GET ALL SETTINGS FOR CURRENT PAGE
            // -------------------------------------------------------------
            if($wpdb->num_rows > 0) {

                if ($row['roll_back'] == 'latest') {

                    // GET HISTORY FOR CURRENT PAGE WEBSITE
                    // ---------------------------------------------------------
                    $historyCSS    = "SELECT * FROM ".WDHSVWE_History_table." where wid='".$wid."' AND used_for='current_page' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' ORDER by unix_created_date DESC";
                    $history       = $wpdb->get_row($historyCSS, ARRAY_A);

                    if($wpdb->num_rows > 0) {
                        array_push($cssFiles, '<link id="wdh-svwe-history-page'.$wdhHistoryAddedID.'" rel="stylesheet" href="'.WP_CONTENT_URL.'/wdhsvwe/css/style.'.$history['id'].'.'.$wdhPageOn.'.'.$wdhRole.'.'.$history['unix_created_date'].'.min.css">');
                    }
                } else if ($row['roll_back'] == 'original') {
                    // No Load CSS files
                } else {

                    // GET HISTORY FOR CURRENT PAGE WEBSITE
                    // ---------------------------------------------------------
                    $historyCSS    = "SELECT * FROM ".WDHSVWE_History_table." where wid='".$wid."' AND used_for='current_page' AND page_url='".$wdhPageUrl."' AND page_on='".$wdhPageOn."' AND role='".$wdhRole."' AND unix_created_date='".$row['roll_back']."' ORDER by unix_created_date DESC";
                    $history       = $wpdb->get_row($historyCSS, ARRAY_A);

                    if($wpdb->num_rows > 0) {
                        array_push($cssFiles, '<link id="wdh-svwe-history-page'.$wdhHistoryAddedID.'" rel="stylesheet" href="'.WP_CONTENT_URL.'/wdhsvwe/css/style.'.$history['id'].'.'.$wdhPageOn.'.'.$wdhRole.'.'.$history['unix_created_date'].'.min.css">');
                    }
                }
            }
            
            return implode('',$cssFiles);
        }
    }
}

?>