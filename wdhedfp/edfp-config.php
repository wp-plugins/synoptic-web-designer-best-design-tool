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

// Website EDFP URL
$wdhURL = 'http://your website url/wdhedfp/'; // http://your website url/wdhedfp/ // structure must be : http://www.yourwebsite/wdhedfp/

// Language
$wdhFIELD['language']    = 'en';  // set current language : af, al, ar, az, bs, by, bg, ca, cn, cr, cz, dk, du, en, eo, et, fl, fi, fr, gl, de, gr, ha, he, hi, hu, is, id, ir, it, ja, ko, lv, lt, mk, mg, ma, no, pe, pl, pt, ro, ru, sr, sk, sl, sp, sw, se, th, tr, uk, ur, vi, we, yi

// CSS Template 
$wdhFIELD['template']    = 'black_yellow';  // set current css template : standard, black_yellow

// Default Mysql Connection
$wdhDB['host']     = 'your mysql host';
$wdhDB['database'] = 'your mysql database';
$wdhDB['user']     = 'your mysql user';
$wdhDB['password'] = 'your mysql password';
$wdhDB['table']    = 'your mysql table';
// Encrypt Database Login Details
$wdhDB['key']      = '#W3bD3v3l@p3rsH@us3#'; // You can change it but never leave it empty 

// Field name that you to display
$wdhFIELD['field_name'] = 'your field name';
$wdhFIELD['json_value'] = ''; // set empty if you not use json
$wdhFIELD['edit']       = false; // set true if you to be editable
$wdhFIELD['class']      = ''; // add CSS class to displayed field
$wdhFIELD['token']      = '#W3bD3v3l@p3rsH@us3#'; // You can change it but never leave it empty 
$wdhFIELD['auto_add']   = true; // set true if you want to add field if is not found
// Find field where condition: first field name = first field value AND second field name = second field value
$wdhFIELD['conditions'] = array(
    0 => array(
        'field_label' => 'first field name',
        'field_value' => 'first field value',
        'field_condition' => '', // Allways must be EMPTY
        'field_added' => false
    ),
    1 => array(
        'field_label' => 'second field name',
        'field_value' => 'second field value',
        'field_condition' => 'AND', // condition between
        'field_added' => false
    )
);

// INPUT
$wdhINPUT['type']               = 'text'; // text , textarea, select , radio button, date , slider, checkbox, switch on/off button, map, video, colorpicker, password, image, file, html_editor;
$wdhINPUT['values']             = 'Value1|Value2|Value3';
$wdhINPUT['slider_min']         = 300; // set slider min
$wdhINPUT['slider_max']         = 800; // set slider max
$wdhINPUT['slider_range']       = 10;  // set slider step
$wdhINPUT['map_width']          = 300; // set map width
$wdhINPUT['map_height']         = 200; // set map height
$wdhINPUT['map_zoom']           = 12;  // set map zoom
$wdhINPUT['video_width']        = 300; // set video width
$wdhINPUT['video_height']       = 243; // set video height
$wdhINPUT['html_editor_width']  = 250; // set html editor width
$wdhINPUT['html_editor_height'] = 250; // set html editor height

// TOOLTIP
$wdhTOOLTIP['text']             = 'Click here to edit.';
$wdhTOOLTIP['position']         = 'right'; // only right

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
$wdhFILTER['is_adult_video']    = false;  // set true if you allow Adult video
$wdhFILTER['is_min_chars']      = -1;     // Number of characters must be bigger than this value // set -1 to disable
$wdhFILTER['is_equal_chars']    = -1;     // Number of characters must be equl with this value // set -1 to disable
$wdhFILTER['is_max_chars']      = -1;     // Number of characters must be lower than this value // set -1 to disable
$wdhFILTER['is_bigger']         = -1;     // Number must be bigger than this value // set -1 to disable
$wdhFILTER['is_equal']          = -1;     // Number must be equl with this value // set -1 to disable
$wdhFILTER['is_lower']          = -1;     // Number must be lower than this value // set -1 to disable

// IMAGE UPLOAD TO : your_path/wdhedfp/uploads/images/
$wdhUPLOAD['image_upload_extensions'] = 'jpg|jpeg|gif|png'; // set image type accepted to be uploaded
$wdhUPLOAD['image_upload_max_size']   = 6; // set maximum size of image ( in MB )
$wdhUPLOAD['image_upload_width']      = 100; // set image width ( in px )
$wdhUPLOAD['image_upload_height']     = 100; // set image height ( in px )

// FILE UPLOAD TO : your_path/wdhedfp/uploads/files/
$wdhUPLOAD['file_upload_extensions'] = 'doc|docx|pdf'; // set file type accepted to be uploaded
$wdhUPLOAD['file_upload_max_size']   = 20; // set maximum size of file ( in MB )

// ==== DO NOT REMOVE ==== // 
// JAVASCRIPT HOOKS ON CHANGE
$wdhINPUT['js_wdhedfp_onchange']   = ''; // Return value is window.valueNow - Write every javascript code you want with escape ( use instead of " this \" and $jWDH instead of $ or jQuery).
// Example : $wdhINPUT['js_wdhedfp_onchange']   = 'console.log(\"Value: \"+window.valueNow);';
// JAVASCRIPT HOOKS AFTER SAVE
$wdhINPUT['js_wdhedfp_after_save'] = ''; // Return value is window.valueNow - Write every javascript code you want with escape ( use instead of " this \" and $jWDH instead of $ or jQuery).
// Example : $wdhINPUT['js_wdhedfp_after_save'] = 'console.log(\"Value: \"+window.valueNow);';

// ==== DO NOT MODIFY ==== // 
// Define WDH URL
$wdhFIELD['WDH_WEBSITE_URL'] = $wdhURL;
// Include Language Filez
include_once 'languages/'.$wdhFIELD['language'].'.php';

// Plugins 
// -----------------------------------
// FORM GENERATOR 
// -----------------------------------
// Attention : set true only if you have Form Generator and Payment plugin for EDFP 
$wdhFIELD['WDH_FORM_GENERATOR']     = false;        // set true if you want to enable formgenerator 

// Form Settings
//-----------------------------------

$wdhSettings['form_id']             = 1;            // set form id (number from 1 to 99999...)
$wdhSettings['form_type']           = 'normal';     // normal or popup
$wdhSettings['form_mode']           = 'normal';     // normal: save in database + send emails , contact: only send emails, login: only login ( save login data in cookie );
$wdhSettings['form_popup_button']   = 'Show Form';  // text button for display popup
$wdhSettings['form_class']          = '';           //  add form css class
$wdhSettings['form_css']            = array();      //  set css propeties example array('color' => '#000');

// Sent Message
//-----------------------------------

$wdhSettings['form_msg_sent']   = 'Congratualations your data has been sent.';  // Set succesfully sent form message 
$wdhSettings['form_msg_failed'] = 'Message was not sent.';                      // Set failed sent form message 
$wdhSettings['form_msg_class']  = '';                                           // add form class to sent message container
$wdhSettings['form_msg_css']    = array();                                      // set css propeties example array('color' => '#000');

// Email Messages
//-----------------------------------

$wdhSettings['sender_email']             = 'sender@yourwebsite.com';        // Set email sender 
$wdhSettings['admin_email_notification'] = true;                            // Set true if you want to send admin notification when somebody register / contact
$wdhSettings['admin_email']              = 'admin@yourwebsite.com';         // Set admin email where you want to be notify
$wdhSettings['admin_subject']            = 'Your admin subject.';           // Set admin email notification subject
$wdhSettings['admin_email_template']     = 'standard';                      // Select html mail template ( your_path/wdhedfp/plugins/formgenerator/standard/ )
$wdhSettings['user_email_notification']  = true;                            // Set true if you want to send user fields when use a form
$wdhSettings['user_email_subject']       = 'Your user subject.';            // Set user email notification subject

// JS HOOK AFTER FORM SENT DATA
//-----------------------------------
$wdhSettings['js_wdhedfp_after_save'] = ''; // Return fields array is window.valueNow - Write every javascript code you want with escape ( use instead of " this \" and $jWDH instead of $ or jQuery).
// Example : $wdhSettings['js_wdhedfp_after_save'] = 'console.log(\"Value: \"+window.valueNow);';


// WEBSITE REQUEST -------------------------------------------------------------
$wdhSettings['WDH_WEBSITE_URL'] = $wdhFIELD['WDH_WEBSITE_URL']; // Don't Modify
// -----------------------------------------------------------------------------

//--- Form Field 
//-----------------------------------
 // DB Settings
$wdhFIELD['name']            = '';      // db field name
$wdhFIELD['table']           = '';      // field db table 
 // ID
 $wdhFIELD['id']             = '';      // field id (number from 1 to 99999...)
 // Label Settings
$wdhFIELD['label']           = '';      // field label
$wdhFIELD['second_label']    = '';      // second field label is used for re-password label
$wdhFIELD['value']           = '';      // field value / only for hidden & price field type
$wdhFIELD['link']            = '';      // field link  / only for link field type
$wdhFIELD['class']           = '';      // field label class
$wdhFIELD['css']             = array(); // css for field label
 // Input Settings
$wdhINPUT['type']            = 'text';  // text , textarea, select , radio button, date , slider, checkbox, switch on/off button, map, video, colorpicker, password, image, file, html_editor;
$wdhINPUT['class']           = '';      // input class
$wdhINPUT['css']             = array(); // css for input
$wdhINPUT['values']          = 'label 1@@ value 1|label 2@@ value 2'; // select, radio, checkbox

 // Tooltip 
$wdhTOOLTIP['text']         = 'Click here to edit.';    // set your field tooltip text ( leave it blank if you don't want tooltip ) 

// -----------------------------------
// PAYMENT SYSTEM
// -----------------------------------
// Attention : set true only if you have Form Generator and Payment plugin for EDFP 
$wdhSettings['WDH_PAYMENT_SYSTEM']      = false;                    // set it false if you want to be free
$wdhSettings['WDH_PS_TYPE']             = 'paypal';                 // only paypal available
$wdhSettings['WDH_PS_MODE']             = 'developer';              // developer(used for testing) or live mode
$wdhSettings['WDH_PS_USERNAME']         = 'your_paypal_username';   // API username
$wdhSettings['WDH_PS_PASSWORD']         = 'your_paypal_password';   // API password
$wdhSettings['WDH_PS_SIGNATURE']        = 'your_paypal_signature';  // API signature
$wdhSettings['WDH_PS_CREDIT_CARD']      = true;                     // enable(true) or disable(false) credit card. 
$wdhSettings['WDH_PS_PRICE']            = 0;                        // set form price (set it 0 if you want to be free)
$wdhSettings['WDH_PS_CURRENCY']         = '$';                      // currency symbol (example: $ for U.S. Dollar)
$wdhSettings['WDH_PS_CURRENCY_CODE']    = 'USD';                    // currency code (example: USD for U.S. Dollar)


?>