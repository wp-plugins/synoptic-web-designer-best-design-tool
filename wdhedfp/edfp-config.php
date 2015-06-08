<?php
//Project Name: WDH - Edit Database Field PRO (Ajax + PHP)
//Project Version: 2.5.1
//Project URL: http://www.wdh.im/projects/edit-database-field-pro/
//Author: WDH - Web Developers House
//Author URL: http://www.wdh.im/
//File: config.php
//File Description: Configuration File
//File Version: 2.5
//Last Update File : 01.06.2014

global $wdhDB, $wdhFIELD, $wdhINPUT, $wdhTOOLTIP, $wdhFILTER, $wdhERROR, $wdhUPLOAD, $wdhForm, $wdhSettings;

$wdhURL = ''; 

// Language
$wdhFIELD['language']    = 'en';  

// CSS Template 
$wdhFIELD['template']    = 'black_yellow';

$wdhDB['host']     = '';
$wdhDB['database'] = '';
$wdhDB['user']     = '';
$wdhDB['password'] = '';
$wdhDB['table']    = '';
$wdhDB['key']      = '#W3bD3v3l@p3rsH@us3#';

$wdhFIELD['field_name'] = '';
$wdhFIELD['json_value'] = ''; 
$wdhFIELD['edit']       = false; 
$wdhFIELD['class']      = ''; 
$wdhFIELD['token']      = '#W3bD3v3l@p3rsH@us3#'; 
$wdhFIELD['auto_add']   = true; 
$wdhFIELD['conditions'] = array(
    0 => array(
        'field_label' => '',
        'field_value' => '',
        'field_condition' => '', 
        'field_added' => false
    ),
    1 => array(
        'field_label' => '',
        'field_value' => '',
        'field_condition' => 'AND', 
        'field_added' => false
    )
);

// INPUT
$wdhINPUT['type']               = 'text'; 
$wdhINPUT['values']             = 'Value1|Value2|Value3';
$wdhINPUT['slider_min']         = 300; 
$wdhINPUT['slider_max']         = 800; 
$wdhINPUT['slider_range']       = 10;  
$wdhINPUT['map_width']          = 300; 
$wdhINPUT['map_height']         = 200; 
$wdhINPUT['map_zoom']           = 12;  
$wdhINPUT['video_width']        = 300; 
$wdhINPUT['video_height']       = 243; 
$wdhINPUT['html_editor_width']  = 250; 
$wdhINPUT['html_editor_height'] = 250; 

// TOOLTIP
$wdhTOOLTIP['text']             = 'Click here to edit.';
$wdhTOOLTIP['position']         = 'right'; 

// FILTER
$wdhFILTER['is_required']       = false;
$wdhFILTER['is_email']          = false;
$wdhFILTER['is_url']            = false;
$wdhFILTER['is_phone']          = false;
$wdhFILTER['is_alpha']          = false;
$wdhFILTER['is_numeric']        = false;
$wdhFILTER['is_alphanumeric']   = false;
$wdhFILTER['is_date']           = false;
$wdhFILTER['is_unique']         = false;
$wdhFILTER['is_adult_video']    = false;  
$wdhFILTER['is_min_chars']      = -1;     
$wdhFILTER['is_equal_chars']    = -1;     
$wdhFILTER['is_max_chars']      = -1;     
$wdhFILTER['is_bigger']         = -1;     
$wdhFILTER['is_equal']          = -1;     
$wdhFILTER['is_lower']          = -1;     

$wdhUPLOAD['image_upload_extensions'] = 'jpg|jpeg|gif|png'; 
$wdhUPLOAD['image_upload_max_size']   = 6; 
$wdhUPLOAD['image_upload_width']      = 100; 
$wdhUPLOAD['image_upload_height']     = 100; 

$wdhUPLOAD['file_upload_extensions'] = 'doc|docx|pdf'; 
$wdhUPLOAD['file_upload_max_size']   = 20; 

// ==== DO NOT REMOVE ==== // 
// JAVASCRIPT HOOKS ON CHANGE
$wdhINPUT['js_wdhedfp_onchange']   = ''; 
// JAVASCRIPT HOOKS AFTER SAVE
$wdhINPUT['js_wdhedfp_after_save'] = ''; 

// ==== DO NOT MODIFY ==== // 
// Define WDH URL
$wdhFIELD['WDH_WEBSITE_URL'] = $wdhURL;
// Include Language Filez
include_once 'languages/'.$wdhFIELD['language'].'.php';

// Plugins 
// -----------------------------------
// FORM GENERATOR 
// -----------------------------------
$wdhFIELD['WDH_FORM_GENERATOR']     = false;

// Form Settings
//-----------------------------------

$wdhSettings['form_id']             = 1;            
$wdhSettings['form_type']           = 'normal';     
$wdhSettings['form_mode']           = 'normal';     
$wdhSettings['form_popup_button']   = 'Show Form';  
$wdhSettings['form_class']          = '';           
$wdhSettings['form_css']            = array();      

// Sent Message
//-----------------------------------

$wdhSettings['form_msg_sent']   = 'Congratualations your data has been sent.';  
$wdhSettings['form_msg_failed'] = 'Message was not sent.';                      
$wdhSettings['form_msg_class']  = '';                                           
$wdhSettings['form_msg_css']    = array();                                      

// Email Messages
//-----------------------------------

$wdhSettings['sender_email']             = '';        
$wdhSettings['admin_email_notification'] = true;                            
$wdhSettings['admin_email']              = '';         
$wdhSettings['admin_subject']            = '';           
$wdhSettings['admin_email_template']     = 'standard';                      
$wdhSettings['user_email_notification']  = true;                            
$wdhSettings['user_email_subject']       = '';            

// JS HOOK AFTER FORM SENT DATA
//-----------------------------------
$wdhSettings['js_wdhedfp_after_save'] = ''; 


// WEBSITE REQUEST -------------------------------------------------------------
$wdhSettings['WDH_WEBSITE_URL'] = $wdhFIELD['WDH_WEBSITE_URL']; // Don't Modify
// -----------------------------------------------------------------------------

//--- Form Field 
//-----------------------------------
 // DB Settings
$wdhFIELD['name']            = '';      
$wdhFIELD['table']           = '';      
 // ID
 $wdhFIELD['id']             = '';      
 // Label Settings
$wdhFIELD['label']           = '';      
$wdhFIELD['second_label']    = '';      
$wdhFIELD['value']           = '';      
$wdhFIELD['link']            = '';      
$wdhFIELD['class']           = '';      
$wdhFIELD['css']             = array(); 
 // Input Settings
$wdhINPUT['type']            = 'text';  // text , textarea, select , radio button, date , slider, checkbox, switch on/off button, map, video, colorpicker, password, image, file, html_editor;
$wdhINPUT['class']           = '';      
$wdhINPUT['css']             = array(); 
$wdhINPUT['values']          = 'label 1@@ value 1|label 2@@ value 2'; // select, radio, checkbox

 // Tooltip 
$wdhTOOLTIP['text']         = 'Click here to edit.';

// -----------------------------------
// PAYMENT SYSTEM
// -----------------------------------
// Attention : set true only if you have Form Generator and Payment plugin for EDFP 
$wdhSettings['WDH_PAYMENT_SYSTEM']      = false;                    
$wdhSettings['WDH_PS_TYPE']             = 'paypal';                 
$wdhSettings['WDH_PS_MODE']             = 'developer';              
$wdhSettings['WDH_PS_USERNAME']         = '';   
$wdhSettings['WDH_PS_PASSWORD']         = '';   
$wdhSettings['WDH_PS_SIGNATURE']        = '';  
$wdhSettings['WDH_PS_CREDIT_CARD']      = true;                     
$wdhSettings['WDH_PS_PRICE']            = 0;                        
$wdhSettings['WDH_PS_CURRENCY']         = '$';                      
$wdhSettings['WDH_PS_CURRENCY_CODE']    = 'USD';                    


?>