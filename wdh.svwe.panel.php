<?php

/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: wdh.svwe.panel.php
 * File Description: Panel PHP Class
 * File Version: 1.0
 * Last Update File : 24.01.2015
 * ------------------------------------------------------------------- 
 */

if (!class_exists("wdhSVWE_Panel")) {
    
    class wdhSVWE_Panel extends wdhSVWE
    {
        private $WdhEditFieldDb;
        
        function wdhSVWE_Panel(){ // Constructor
            global $wdhSVWE, $wdhDB, $wdhFIELD, $wdhERROR, $wdhINPUT, $wdhTOOLTIP, $WDH_EDFP;
        }
        
        function display(){
            $type = sanitize_text_field($_POST['type']);
            
            switch($type) {
                case "div":
                    $this->generalPanel();
                    break;
                default:
                    $this->generalPanel();
                    break;
            }
        }
        
        function generalPanel(){
            global $wdhDB, $wdhFIELD, $wdhINPUT, $wdhTOOLTIP, $wdhFILTER, $wdhERROR, $wdhUPLOAD, $wdhSVWE, $WDH_EDFP;
            global $wdhSVWE;
            $importantCSS = '';
            
            // Add important
            if ($wdhSVWE["WDH_DEFAULT_CSS_IMPORTANT"] == true) {
                $importantCSS = ' !important';
            }
            
            $settingsHTML       = array();
            $category           = sanitize_text_field($_POST['category']);
            $type               = sanitize_text_field($_POST['type']);
            $subtype            = sanitize_text_field($_POST['subtype']);
            $loadStep           = sanitize_text_field($_POST['loadstep']);
            $wdhPath            = sanitize_text_field($_POST['wdhPath']);
            $domPath            = sanitize_text_field($_POST['domPath']);
            $wdhID              = sanitize_text_field($_POST['wdhID']);
            
            if(isset($_POST['wdhAllCSS'])) {
                
                if($_POST['wdhAllCSS'] != '') {
                    $wdhAllCSS          = sanitize_text_field(json_encode($_POST['wdhAllCSS']));
                    $wdhAllCSS          = (object)json_decode($wdhAllCSS);
                } else {
                    $wdhAllCSS      = array();
                    $wdhAllCSS      = (object)$wdhAllCSS;
                }
            } else {
                $wdhAllCSS      = array();
                $wdhAllCSS      = (object)$wdhAllCSS;
            }
            $elementTag         = sanitize_text_field($_POST['elementTag']);
            $elementPosition    = sanitize_text_field($_POST['elementPosition']);
            $wdhClass           = sanitize_text_field($_POST['wdhClass']);
            $wdhPageURL         = sanitize_text_field($_POST['wdhPageUrl']);
            $wdhPageOn          = sanitize_text_field($_POST['wdhPageOn']);
            $wdhRole            = sanitize_text_field($_POST['wdhRole']);
            $resolution         = sanitize_text_field($_POST['resolution']);
            $elementSelected    = 'window.elementSelectNowIs';
            $arrayNo            = 0;
            $wdhPageURL         = $this->clearPageUrl($wdhPageURL);
                    
            // -----------------------------------------------------------------
            //  Save Current Element Path / ID / Class 
            //  ----------------------------------------------------------------
            
            if ($wdhClass == '') { // Full Path or ID

                if ($wdhID != '') { // ID
                    $wdhFIELD['conditions'] = array( 
                        0 => array(
                             'field_label' => 'container_id',
                             'field_value' => $wdhID,
                             'field_condition' => '', // Allways must be EMPTY
                             'field_added' => 'false' 
                        ),
                        1 => array(
                             'field_label' => 'resolution',
                             'field_value' => $resolution,
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        ),
                        2 => array(
                             'field_label' => 'wid',
                             'field_value' => $wdhSVWE["WEBSITE_ID"],
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        ),
                        3 => array(
                             'field_label' => 'page_url',
                             'field_value' => $wdhPageURL,
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        ),
                        4 => array(
                             'field_label' => 'page_on',
                             'field_value' => $wdhPageOn,
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        ),
                        5 => array(
                             'field_label' => 'role',
                             'field_value' => $wdhRole,
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        )
                    );
                    $arrayNo = 6;
                } else { // Full Path
                    $wdhFIELD['conditions'] = array( 
                        0 => array(
                             'field_label' => 'container_full_path',
                             'field_value' => $domPath,
                             'field_condition' => '', // Allways must be EMPTY
                             'field_added' => 'false' 
                        ),
                        1 => array(
                             'field_label' => 'container_wdh_path',
                             'field_value' => $wdhPath,
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        ),
                        2 => array(
                             'field_label' => 'element_tag',
                             'field_value' => $elementTag,
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        ),
                        3 => array(
                             'field_label' => 'element_position',
                             'field_value' => $elementPosition,
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        ),
                        4 => array(
                             'field_label' => 'resolution',
                             'field_value' => $resolution,
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        ),
                        5 => array(
                             'field_label' => 'wid',
                             'field_value' => $wdhSVWE["WEBSITE_ID"],
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        ),
                        6 => array(
                             'field_label' => 'page_url',
                             'field_value' => $wdhPageURL,
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        ),
                        7 => array(
                             'field_label' => 'page_on',
                             'field_value' => $wdhPageOn,
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        ),
                        8 => array(
                             'field_label' => 'role',
                             'field_value' => $wdhRole,
                             'field_condition' => 'AND',
                             'field_added' => 'false'
                        )
                    );
                    $arrayNo = 9;
                }
            } else { // Classes
                $wdhFIELD['conditions'] = array( 
                    0 => array(
                         'field_label' => 'container_classes',
                         'field_value' => $wdhClass,
                         'field_condition' => '', // Allways must be EMPTY
                         'field_added' => 'false' 
                    ),
                    2 => array(
                         'field_label' => 'resolution',
                         'field_value' => $resolution,
                         'field_condition' => 'AND',
                         'field_added' => 'false'
                    ),
                    3 => array(
                         'field_label' => 'wid',
                         'field_value' => $wdhSVWE["WEBSITE_ID"],
                         'field_condition' => 'AND',
                         'field_added' => 'false'
                    ),
                    4 => array(
                         'field_label' => 'page_url',
                         'field_value' => $wdhPageURL,
                         'field_condition' => 'AND',
                         'field_added' => 'false'
                    ),
                    5 => array(
                         'field_label' => 'page_on',
                         'field_value' => $wdhPageOn,
                         'field_condition' => 'AND',
                         'field_added' => 'false'
                    ),
                    6 => array(
                         'field_label' => 'role',
                         'field_value' => $wdhRole,
                         'field_condition' => 'AND',
                         'field_added' => 'false'
                    )
                );
                $arrayNo = 7;
            }
            
            
                
            // -----------------------------------------------------------------
            //  Save Current CSS Propeties 
            //  ----------------------------------------------------------------

            // Color 
            if(isset($wdhAllCSS->color)) {

                $color = str_replace('rgb(', '',$wdhAllCSS->color);
                $color = str_replace(')', '',$color);
                $color = str_replace(' ', '',$color);
                $color = explode(',', $color);
                $color = $this->rgbToHex($color);

                $wdhFIELD['conditions'][$arrayNo] = array('field_label' => 'text_color',
                                                          'field_value' => $color,
                                                          'field_added' => 'true',
                                                          'field_condition' => 'AND');
                $arrayNo++;
            }
            
            // Font-Family 
            if(isset($wdhAllCSS->fontFamily)) {
                $wdhFIELD['conditions'][$arrayNo] = array('field_label' => 'text_font_family',
                                                          'field_added' => 'true',
                                                          'field_value' => str_replace("'","",$wdhAllCSS->fontFamily),
                                                          'field_condition' => 'AND');
                $arrayNo++;
            }
            
            // Font-Style
            if(isset($wdhAllCSS->fontStyle)) {
                $wdhFIELD['conditions'][$arrayNo] = array('field_label' => 'text_font_style',
                                                          'field_added' => 'true',
                                                          'field_value' => $wdhAllCSS->fontStyle,
                                                          'field_condition' => 'AND');
                $arrayNo++;
            }
            
            // Letter Spacing
            if(isset($wdhAllCSS->LetterSpacing)) {
                $wdhFIELD['conditions'][$arrayNo] = array('field_label' => 'text_font_letter_spacing',
                                                          'field_added' => 'true',
                                                          'field_value' => $wdhAllCSS->LetterSpacing,
                                                          'field_condition' => 'AND');
                $arrayNo++;
            }
            
            //Word Spacing
            if(isset($wdhAllCSS->WordSpacing)) {
                $wdhFIELD['conditions'][$arrayNo] = array('field_label' => 'text_font_word_spacing',
                                                          'field_added' => 'true',
                                                          'field_value' => $wdhAllCSS->WordSpacing,
                                                          'field_condition' => 'AND');
                $arrayNo++;
            }
            
            //Width
            if(isset($wdhAllCSS->Width)) {
                $wdhFIELD['conditions'][$arrayNo] = array('field_label' => 'box_width',
                                                          'field_added' => 'true',
                                                          'field_value' => $wdhAllCSS->Width,
                                                          'field_condition' => 'AND');
                $arrayNo++;
            }
            
            //Height
            if(isset($wdhAllCSS->Height)) {
                $wdhFIELD['conditions'][$arrayNo] = array('field_label' => 'box_height',
                                                          'field_added' => 'true',
                                                          'field_value' => $wdhAllCSS->Height,
                                                          'field_condition' => 'AND');
                $arrayNo++;
            }
            
             //Border
            if(isset($wdhAllCSS->Border)) {
                $border = explode(' rgb', $wdhAllCSS->Border); 
                $wdhFIELD['conditions'][$arrayNo] = array('field_label' => 'box_border',
                                                          'field_added' => 'true',
                                                          'field_value' => $border[0],
                                                          'field_condition' => 'AND');
                $arrayNo++;
            }
            
            // Border Color 
            if(isset($wdhAllCSS->BorderColor)) {

                $borderColor = str_replace('rgb(', '',$wdhAllCSS->BorderColor);
                $borderColor = str_replace(')', '',$borderColor);
                $borderColor = str_replace(' ', '',$borderColor);
                $borderColor = explode(',', $borderColor);
                $borderColor = $this->rgbToHex($borderColor);
                
                if (isset($borderColor[3])) {
                    $borderColor = '';
                } else {
                    $borderColor = $this->rgbToHex($borderColor);
                }

                $wdhFIELD['conditions'][$arrayNo] = array('field_label' => 'box_border_color',
                                                          'field_value' => $borderColor,
                                                          'field_added' => 'true',
                                                          'field_condition' => 'AND');
                $arrayNo++;
            }
            
             //Border Radius
            if(isset($wdhAllCSS->BorderRadius)) {
                $wdhFIELD['conditions'][$arrayNo] = array('field_label' => 'box_border_radius',
                                                          'field_added' => 'true',
                                                          'field_value' => $wdhAllCSS->BorderRadius,
                                                          'field_condition' => 'AND');
                $arrayNo++;
            }
            
             
            switch($loadStep){
                case 'text-settings':
                    // Text - General Settings
                    //--------------------------------------------------------------

                    // Text-Color- START
                    array_push($settingsHTML, '<li class="wdh-settings-'.$category.'-'.$type.'-'.$subtype.'">');
                    array_push($settingsHTML, ' <label class="wdh-label-left">'.$wdhSVWE['TXT_TEXT_COLOR'].':</label>');
                    array_push($settingsHTML, ' <div class="wdh-input-field wdh-input-left">');
                                                            $wdhDB['table'] = WDHSVWE_Temporary_CSS_table;
                                                            $wdhFIELD['field_name'] = ($category == 'normal'? '':'h_').'text_color';
                                                            $wdhFIELD['json_value'] = '';
                                                            $wdhFIELD['value']      = '';
                                                            $wdhFIELD['edit']       = true;
                                                            $wdhINPUT['type'] = 'colorpicker';
                                                            // TOOLTIP
                                                            $wdhTOOLTIP['text']     = $wdhSVWE['TXT_TEXT_COLOR_INFO'];
                                                            $wdhTOOLTIP['position'] = 'right';
                                                            // FILTER
                                                            $wdhFILTER['is_required']     = true;
                                                            //$elementID = $wdhPath;
                                                            if ($category == 'normal') {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"color:#\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"color:#\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                            } else {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ color: #\"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ color: #\"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ color: #\"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ color: #\"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                            }

                                                            // DISPLAY
                    array_push($settingsHTML ,              $WDH_EDFP->wdhShowField($wdhDB,$wdhFIELD,$wdhINPUT,$wdhTOOLTIP,$wdhFILTER,$wdhERROR,$wdhUPLOAD));
                    array_push($settingsHTML, ' </div>');
                    array_push($settingsHTML, '</li>');
                    // Text-Color END

                    // Font-Family - START
                    array_push($settingsHTML, '<li class="wdh-settings-'.$category.'-'.$type.'-'.$subtype.'">');
                    array_push($settingsHTML, ' <label class="wdh-label-left">'.$wdhSVWE['TXT_FONT_FAMILY'].':</label>');
                    array_push($settingsHTML, ' <div class="wdh-input-field wdh-input-left">');
                                                            $wdhDB['table'] = WDHSVWE_Temporary_CSS_table;
                                                            $wdhFIELD['field_name'] = ($category == 'normal'? '':'h_').'text_font_family';
                                                            $wdhFIELD['json_value'] = '';
                                                            $wdhFIELD['value']      = '';
                                                            $wdhFIELD['edit']       = true;


                                                            $wdhINPUT['type'] = 'font';

                                                            // TOOLTIP
                                                            $wdhTOOLTIP['text']     = $wdhSVWE['TXT_FONT_FAMILY_INFO'];
                                                            $wdhTOOLTIP['position'] = 'right';
                                                            // FILTER
                                                            $wdhFILTER['is_required']     = true;
                                                            //$elementID = $wdhPath;

                                                            if ($category == 'normal') {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = '';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = 'var wdhCurrVar = window.valueNow+\"'.$importantCSS.';\"; if (wdhCurrVar.indexOf(\":\") !== -1) { wdhGFontSet($jWDH('.$elementSelected.'), wdhCurrVar); } else { $jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"font-family\",window.valueNow+\"'.$importantCSS.';\"}); }';
                                                            } else {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = '';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = 'var elementPosition = $jWDH('.$elementSelected.').getDomPosition()+1; currentDomPath = removeWDH(wdhRemover($jWDH('.$elementSelected.').getDomPath()))+\":nth-child(\"+elementPosition+\")\", wdhCurrVar = window.valueNow+\"'.$importantCSS.';\"; console.log(currentDomPath); if (wdhCurrVar.indexOf(\":\") !== -1) { wdhGFontSetHover(currentDomPath, wdhCurrVar); } else { $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ font-family: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); }';
                                                            }

                                                            // DISPLAY
                    array_push($settingsHTML ,               $WDH_EDFP->wdhShowField($wdhDB,$wdhFIELD,$wdhINPUT,$wdhTOOLTIP,$wdhFILTER,$wdhERROR,$wdhUPLOAD));
                    array_push($settingsHTML, ' </div>');
                    array_push($settingsHTML, '</li>');
                    // Font-Family - END

                    // Font-Style- START
                    array_push($settingsHTML, '<li class="wdh-settings-'.$category.'-'.$type.'-'.$subtype.' wdh-swve-font-style">');
                    array_push($settingsHTML, ' <label class="wdh-label-left">'.$wdhSVWE['TXT_FONT_STYLE'].':</label>');
                    array_push($settingsHTML, ' <div class="wdh-input-field wdh-input-left">');
                                                            $wdhDB['table'] = WDHSVWE_Temporary_CSS_table;
                                                            $wdhFIELD['field_name'] = ($category == 'normal'? '':'h_').'text_font_style';
                                                            $wdhFIELD['json_value'] = '';
                                                            $wdhFIELD['value']      = '';
                                                            $wdhFIELD['edit']       = true;


                                                            $wdhINPUT['type'] = 'select';
                                                            $wdhINPUT['values'] = 'inherit|normal|italic|oblique';
                                                            // TOOLTIP
                                                            $wdhTOOLTIP['text']     = $wdhSVWE['TXT_FONT_STYLE_INFO'];
                                                            $wdhTOOLTIP['position'] = 'right';
                                                            // FILTER
                                                            $wdhFILTER['is_required']     = true;
                                                            //$elementID = $wdhPath;
                                                            if ($category == 'normal') {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"font-style:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"font-style:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                            } else {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ font-style: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ font-style: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ font-style: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ font-style: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                            }

                                                            // DISPLAY
                    array_push($settingsHTML ,               $WDH_EDFP->wdhShowField($wdhDB,$wdhFIELD,$wdhINPUT,$wdhTOOLTIP,$wdhFILTER,$wdhERROR,$wdhUPLOAD));
                    array_push($settingsHTML, ' </div>');
                    array_push($settingsHTML, '</li>');
                    // Font-Style- END
                    // Letter-Spacing START
                    array_push($settingsHTML, '<li class="wdh-settings-'.$category.'-'.$type.'-'.$subtype.'">');
                    array_push($settingsHTML, ' <label class="wdh-label-left">'.$wdhSVWE['TXT_LETTER_SPACING'].':</label>');
                    array_push($settingsHTML, ' <div class="wdh-input-field wdh-input-left">');
                                                            $wdhDB['table'] = WDHSVWE_Temporary_CSS_table;
                                                            $wdhFIELD['field_name'] = ($category == 'normal'? '':'h_').'text_font_letter_spacing';
                                                            $wdhFIELD['json_value'] = '';
                                                            $wdhFIELD['value']      = '';
                                                            $wdhFIELD['edit']       = true;


                                                            $wdhINPUT['type'] = 'size';
                                                            $wdhINPUT['slider_min']   = 0; // set slider min
                                                            $wdhINPUT['slider_max']   = 100; // set slider max
                                                            $wdhINPUT['slider_range'] = 1; // set slider step
                                                            $wdhINPUT['values'] = 'px|em|%|in|cm|mm|ex|pt|pc';

                                                            // TOOLTIP
                                                            $wdhTOOLTIP['text']     = $wdhSVWE['TXT_LETTER_SPACING_INFO'];
                                                            $wdhTOOLTIP['position'] = 'right';
                                                            // FILTER
                                                            $wdhFILTER['is_required']     = true;
                                                            //$elementID = $wdhPath;
                                                            if ($category == 'normal') {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"letter-spacing:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"letter-spacing:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                            } else {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ letter-spacing: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ letter-spacing: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ letter-spacing: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ letter-spacing: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                            }

                                                            // DISPLAY
                    array_push($settingsHTML ,               $WDH_EDFP->wdhShowField($wdhDB,$wdhFIELD,$wdhINPUT,$wdhTOOLTIP,$wdhFILTER,$wdhERROR,$wdhUPLOAD));
                    array_push($settingsHTML, ' </div>');
                    array_push($settingsHTML, '</li>');
                    // Letter Spacing- END

                    // Word-Spacing START
                    array_push($settingsHTML, '<li class="wdh-settings-'.$category.'-'.$type.'-'.$subtype.'">');
                    array_push($settingsHTML, ' <label class="wdh-label-left">'.$wdhSVWE['TXT_WORD_SPACING'].':</label>');
                    array_push($settingsHTML, ' <div class="wdh-input-field wdh-input-left">');
                                                            $wdhDB['table'] = WDHSVWE_Temporary_CSS_table;
                                                            $wdhFIELD['field_name'] = ($category == 'normal'? '':'h_').'text_font_word_spacing';
                                                            $wdhFIELD['json_value'] = '';
                                                            $wdhFIELD['value']      = '';
                                                            $wdhFIELD['edit']       = true;


                                                            $wdhINPUT['type'] = 'size';
                                                            $wdhINPUT['slider_min']   = 0; // set slider min
                                                            $wdhINPUT['slider_max']   = 100; // set slider max
                                                            $wdhINPUT['slider_range'] = 1; // set slider step
                                                            $wdhINPUT['values'] = 'px|em|%|in|cm|mm|ex|pt|pc';

                                                            // TOOLTIP
                                                            $wdhTOOLTIP['text']     = $wdhSVWE['TXT_WORD_SPACING_INFO'];
                                                            $wdhTOOLTIP['position'] = 'right';
                                                            // FILTER
                                                            $wdhFILTER['is_required']     = true;
                                                            //$elementID = $wdhPath;
                                                            if ($category == 'normal') {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"word-spacing:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"word-spacing:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                            } else {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ word-spacing: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ word-spacing: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ word-spacing: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ word-spacing: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                            }

                                                            // DISPLAY
                    array_push($settingsHTML ,               $WDH_EDFP->wdhShowField($wdhDB,$wdhFIELD,$wdhINPUT,$wdhTOOLTIP,$wdhFILTER,$wdhERROR,$wdhUPLOAD));
                    array_push($settingsHTML, ' </div>');
                    array_push($settingsHTML, '</li>');
                    // Word Spacing- END
                    
                    break;
                
                case 'box-settings':
                    // Box - General Settings
                 
                    // Box-Width- START
                    array_push($settingsHTML, '<li class="wdh-settings-'.$category.'-'.$type.'-'.$subtype.'">');
                    array_push($settingsHTML, ' <label class="wdh-label-left">'.$wdhSVWE['BOX_WIDTH'].':</label>');
                    array_push($settingsHTML, ' <div class="wdh-input-field wdh-input-left">');
                                                            $wdhDB['table'] = WDHSVWE_Temporary_CSS_table;
                                                            $wdhFIELD['field_name'] = ($category == 'normal'? '':'h_').'box_width';
                                                            $wdhFIELD['json_value'] = '';
                                                            $wdhFIELD['value']      = '';
                                                            $wdhFIELD['edit']       = true;


                                                            $wdhINPUT['type'] = 'size';
                                                            $wdhINPUT['slider_min']   = 0; // set slider min
                                                            $wdhINPUT['slider_max']   = 1200; // set slider max
                                                            $wdhINPUT['slider_range'] = 1; // set slider step
                                                            $wdhINPUT['values'] = 'px|em|%|in|cm|mm|ex|pt|pc';

                                                            // TOOLTIP
                                                            $wdhTOOLTIP['text']     = $wdhSVWE['BOX_WIDTH_INFO'];
                                                            $wdhTOOLTIP['position'] = 'right';
                                                            // FILTER
                                                            $wdhFILTER['is_required']     = true;
                                                            //$elementID = $wdhPath;
                                                            if ($category == 'normal') {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"width:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"width:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                            } else {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ width: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ width: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ width: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ width: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                            }

                                                            // DISPLAY
                    array_push($settingsHTML ,               $WDH_EDFP->wdhShowField($wdhDB,$wdhFIELD,$wdhINPUT,$wdhTOOLTIP,$wdhFILTER,$wdhERROR,$wdhUPLOAD));
                    array_push($settingsHTML, ' </div>');
                    array_push($settingsHTML, '</li>');
                    // Box-Width END

                    // Box-Height- START
                    array_push($settingsHTML, '<li class="wdh-settings-'.$category.'-'.$type.'-'.$subtype.'">');
                    array_push($settingsHTML, ' <label class="wdh-label-left">'.$wdhSVWE['BOX_HEIGHT'].':</label>');
                    array_push($settingsHTML, ' <div class="wdh-input-field wdh-input-left">');
                                                            $wdhDB['table'] = WDHSVWE_Temporary_CSS_table;
                                                            $wdhFIELD['field_name'] = ($category == 'normal'? '':'h_').'box_height';
                                                            $wdhFIELD['json_value'] = '';
                                                            $wdhFIELD['value']      = '';
                                                            $wdhFIELD['edit']       = true;


                                                            $wdhINPUT['type'] = 'size';
                                                            $wdhINPUT['slider_min']   = 0; // set slider min
                                                            $wdhINPUT['slider_max']   = 1200; // set slider max
                                                            $wdhINPUT['slider_range'] = 1; // set slider step
                                                            $wdhINPUT['values'] = 'px|em|%|in|cm|mm|ex|pt|pc';

                                                            // TOOLTIP
                                                            $wdhTOOLTIP['text']     = $wdhSVWE['BOX_HEIGHT_INFO'];
                                                            $wdhTOOLTIP['position'] = 'right';
                                                            // FILTER
                                                            $wdhFILTER['is_required']     = true;
                                                            //$elementID = $wdhPath;
                                                            if ($category == 'normal') {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"height:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"height:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                            } else {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ height: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ height: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ height: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ height: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                            }

                                                            // DISPLAY
                    array_push($settingsHTML ,               $WDH_EDFP->wdhShowField($wdhDB,$wdhFIELD,$wdhINPUT,$wdhTOOLTIP,$wdhFILTER,$wdhERROR,$wdhUPLOAD));
                    array_push($settingsHTML, ' </div>');
                    array_push($settingsHTML, '</li>');
                    // Box-Height END

                    // Box-Border - START
                    array_push($settingsHTML, '<li class="wdh-settings-'.$category.'-'.$type.'-'.$subtype.'">');
                    array_push($settingsHTML, ' <label class="wdh-label-left">'.$wdhSVWE['BOX_BORDER'].':</label>');
                    array_push($settingsHTML, ' <div class="wdh-input-field wdh-input-left">');
                                                            $wdhDB['table'] = WDHSVWE_Temporary_CSS_table;
                                                            $wdhFIELD['field_name'] = ($category == 'normal'? '':'h_').'box_border';
                                                            $wdhFIELD['json_value'] = '';
                                                            $wdhFIELD['value']      = '';
                                                            $wdhFIELD['edit']       = true;


                                                            $wdhINPUT['type'] = 'border';
                                                            $wdhINPUT['slider_min']   = 0; // set slider min
                                                            $wdhINPUT['slider_max']   = 99; // set slider max
                                                            $wdhINPUT['slider_range'] = 1; // set slider step
                                                            $wdhINPUT['values'] = 'px|em|%|in|cm|mm|ex|pt|pc';
                                                            $wdhINPUT['second_values'] = 'none|dotted|dashed|solid|double|groove|inset|outset';

                                                            // TOOLTIP
                                                            $wdhTOOLTIP['text']     = $wdhSVWE['BOX_BORDER_INFO'];
                                                            $wdhTOOLTIP['position'] = 'right';
                                                            // FILTER
                                                            $wdhFILTER['is_required']     = true;
                                                            //$elementID = $wdhPath;
                                                            if ($category == 'normal') {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"border:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"border:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                            } else {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ border: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ border: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ border: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ border: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                            }

                                                            // DISPLAY
                    array_push($settingsHTML ,               $WDH_EDFP->wdhShowField($wdhDB,$wdhFIELD,$wdhINPUT,$wdhTOOLTIP,$wdhFILTER,$wdhERROR,$wdhUPLOAD));
                    array_push($settingsHTML, ' </div>');
                    array_push($settingsHTML, '</li>');
                    // Box-Border - END

                     // Box-Border-Color - START
                    array_push($settingsHTML, '<li class="wdh-settings-'.$category.'-'.$type.'-'.$subtype.'">');
                    array_push($settingsHTML, ' <label class="wdh-label-left">'.$wdhSVWE['BOX_BORDER_COLOR'].':</label>');
                    array_push($settingsHTML, ' <div class="wdh-input-field wdh-input-left">');
                                                            $wdhDB['table'] = WDHSVWE_Temporary_CSS_table;
                                                            $wdhFIELD['field_name'] = ($category == 'normal'? '':'h_').'box_border_color';
                                                            $wdhFIELD['json_value'] = '';
                                                            $wdhFIELD['value']      = '';
                                                            $wdhFIELD['edit']       = true;


                                                            $wdhINPUT['type']   = 'colorpicker';

                                                            // TOOLTIP
                                                            $wdhTOOLTIP['text']     = $wdhSVWE['BOX_BORDER_COLOR_INFO'];
                                                            $wdhTOOLTIP['position'] = 'right';
                                                            // FILTER
                                                            $wdhFILTER['is_required']     = true;
                                                            //$elementID = $wdhPath;
                                                            if ($category == 'normal') {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"border-color:#\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"border-color:#\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                            } else {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ border-color: #\"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ border-color: #\"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ border-color: #\"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ border-color: #\"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                            }

                                                            // DISPLAY
                    array_push($settingsHTML ,               $WDH_EDFP->wdhShowField($wdhDB,$wdhFIELD,$wdhINPUT,$wdhTOOLTIP,$wdhFILTER,$wdhERROR,$wdhUPLOAD));
                    array_push($settingsHTML, ' </div>');
                    array_push($settingsHTML, '</li>');
                    // Box-Border-Color - END

                    // Box-Border-Radius - START
                    array_push($settingsHTML, '<li class="wdh-settings-'.$category.'-'.$type.'-'.$subtype.'">');
                    array_push($settingsHTML, ' <label class="wdh-label-left">'.$wdhSVWE['BOX_BORDER_RADIUS'].':</label>');
                    array_push($settingsHTML, ' <div class="wdh-input-field wdh-input-left">');
                                                            $wdhDB['table'] = WDHSVWE_Temporary_CSS_table;
                                                            $wdhFIELD['field_name'] = ($category == 'normal'? '':'h_').'box_border_radius';
                                                            $wdhFIELD['json_value'] = '';
                                                            $wdhFIELD['value']      = '';
                                                            $wdhFIELD['edit']       = true;


                                                            $wdhINPUT['type'] = 'size';
                                                            $wdhINPUT['slider_min']   = 0; // set slider min
                                                            $wdhINPUT['slider_max']   = 500; // set slider max
                                                            $wdhINPUT['slider_range'] = 1; // set slider step
                                                            $wdhINPUT['values'] = 'px|em|%|in|cm|mm|ex|pt|pc';

                                                            // TOOLTIP
                                                            $wdhTOOLTIP['text']     = $wdhSVWE['BOX_BORDER_RADIUS_INFO'];
                                                            $wdhTOOLTIP['position'] = 'right';
                                                            // FILTER
                                                            $wdhFILTER['is_required']     = true;
                                                            //$elementID = $wdhPath;
                                                            if ($category == 'normal') {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"border-radius:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"border-radius:\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                            } else {
                                                                $wdhINPUT['js_wdhedfp_after_save'] = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ border-radius: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ border-radius: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                                $wdhINPUT['js_wdhedfp_onchange']   = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ border-radius: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ border-radius: \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                            }

                                                            // DISPLAY
                    array_push($settingsHTML ,               $WDH_EDFP->wdhShowField($wdhDB,$wdhFIELD,$wdhINPUT,$wdhTOOLTIP,$wdhFILTER,$wdhERROR,$wdhUPLOAD));
                    array_push($settingsHTML, ' </div>');
                    array_push($settingsHTML, '</li>');
                    // Box-Border-Radius - END

                    break;
                
                default:
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

                                        // START
                                        array_push($settingsHTML, '<li class="wdh-settings-'.$category.'-'.$type.'-'.$subtype.'">');
                                        array_push($settingsHTML, ' <label class="wdh-label-left">'.$extraFieldSelected[$subkey]['label'].':</label>');
                                        array_push($settingsHTML, ' <div class="wdh-input-field wdh-input-left">');
                                                                                $wdhDB['table'] = WDHSVWE_Temporary_CSS_table;
                                                                                $wdhFIELD['field_name'] = ($category == 'normal'? '':'h_').$extraFieldSelected[$subkey]['name'];
                                                                                $wdhFIELD['json_value'] = '';
                                                                                $wdhFIELD['value']      = '';
                                                                                $wdhFIELD['edit']       = true;


                                                                                $wdhINPUT['type']   = $extraFieldSelected[$subkey]['type'];
                                                                                
                                                                                if(isset($extraFieldSelected[$subkey]['min'])) {
                                                                                    $wdhINPUT['slider_min']   = $extraFieldSelected[$subkey]['min']; // set slider min
                                                                                }
                                                                                
                                                                                if(isset($extraFieldSelected[$subkey]['max'])) {
                                                                                    $wdhINPUT['slider_max']   = $extraFieldSelected[$subkey]['max']; // set slider max
                                                                                }
                                                                                
                                                                                if(isset($extraFieldSelected[$subkey]['range'])) {
                                                                                    $wdhINPUT['slider_range']   = $extraFieldSelected[$subkey]['range']; // set slider range
                                                                                }
                                                                                
                                                                                if(isset($extraFieldSelected[$subkey]['values'])) {
                                                                                    $wdhINPUT['values'] = $extraFieldSelected[$subkey]['values'];
                                                                                }
                                                                                
                                                                                // TOOLTIP
                                                                                $wdhTOOLTIP['text']     = $extraFieldSelected[$subkey]['info'];
                                                                                $wdhTOOLTIP['position'] = 'right';
                                                                                // FILTER
                                                                                $wdhFILTER['is_required']     = true;
                                                                                $webkit      = '';
                                                                                $webkithover = '';
                                                                                
                                                                                if (isset($extraFieldSelected[$subkey]['css_web_kit'])) {
                                                                                    
                                                                                    if ($extraFieldSelected[$subkey]['css_web_kit'] == true) {
                                                                                        $webkit = '-webkit-'.$extraFieldSelected[$subkey]['css'].':\"+window.valueNow+\"'.$importantCSS.';';
                                                                                        $webkithover = '-webkit-'.$extraFieldSelected[$subkey]['css'].': \"+window.valueNow+\"'.$importantCSS.';\"+\";';
                                                                                    }
                                                                                }
                                                                                
                                                                                if ($category == 'normal') {// 
                                                                                    $wdhINPUT['js_wdhedfp_after_save'] = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"'.$webkit.$extraFieldSelected[$subkey]['css'].':\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                                                    $wdhINPUT['js_wdhedfp_onchange']   = '$jWDH('.$elementSelected.').attr(\"style\", function(i,s) { if(typeof s === undefined || s === undefined) { s = \"\"; } return s + \"'.$webkit.$extraFieldSelected[$subkey]['css'].':\"+window.valueNow+\"'.$importantCSS.';\"});';
                                                                                } else {
                                                                                    $wdhINPUT['js_wdhedfp_after_save'] = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ '.$webkithover.$extraFieldSelected[$subkey]['css'].': \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ '.$webkithover.$extraFieldSelected[$subkey]['css'].': \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                                                    $wdhINPUT['js_wdhedfp_onchange']   = 'var currentDomPath = wdhRemover($jWDH('.$elementSelected.').getDomPath()), currentWDHPath = $jWDH('.$elementSelected.').getDomPath(); $jWDH(\"head\").append(\"<style>\"+currentDomPath+\":hover{ '.$webkithover.$extraFieldSelected[$subkey]['css'].': \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\"); $jWDH(\"head\").append(\"<style>\"+currentWDHPath+\":hover{ '.$webkithover.$extraFieldSelected[$subkey]['css'].': \"+window.valueNow+\"'.$importantCSS.';\"+\"; }</style>\");';
                                                                                }

                                                                                // DISPLAY
                                        array_push($settingsHTML ,               $WDH_EDFP->wdhShowField($wdhDB,$wdhFIELD,$wdhINPUT,$wdhTOOLTIP,$wdhFILTER,$wdhERROR,$wdhUPLOAD));
                                        array_push($settingsHTML, ' </div>');
                                        array_push($settingsHTML, '</li>');
                                        // END

                                    }
                                }
                            }
                            
                            $ext++;
                        }
                        
                        if($ext < 1) {
                            array_push($settingsHTML, 'done');
                        }
                    } else {
                        array_push($settingsHTML, 'done');
                    }
                    break;
            }
            
            echo implode('', $settingsHTML); die();
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
