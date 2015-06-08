<?php

/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool Light
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool-light/
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