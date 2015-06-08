<?php
/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool Light
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool-light/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: svwe-config.php
 * File Description: Config File
 * File Version: 1.0
 * Last Update File : 28.03.2015
 * ------------------------------------------------------------------- 
 */
 
global $wdhSVWE;
 
// Synoptic Version
$wdhSVWE["version"]     = 1.0;
 
// Synoptic Enabled
$wdhSVWE["ENABLED"]     = true;
 
// Synoptic Language
$wdhSVWE["LANGUAGE"]    = "en";

// Website ID
$wdhSVWE["WEBSITE_ID"]  = 1;

// Website Box Sizing
$wdhSVWE["BOX_SIZING"]  = true;
 
 
// Default Setting
// -----------------------------------------------------------------------------
$wdhSVWE["WDH_DEFAULT_WIDTH"]                   = "px";                                                  // px or percent
$wdhSVWE["WDH_DEFAULT_HEIGHT"]                  = "min-height";                                          // min-height or height
$wdhSVWE["WDH_DEFAULT_CONTAINER"]               = "body";                                                // body for all elements or write your container path
$wdhSVWE["WDH_DEFAULT_DESIGN_CREATE_FOR_ROLES"] = "administrator,editor,author,contributor,subscriber";  // write your wp-admin roles separated by comma
$wdhSVWE["WDH_DEFAULT_CSS_IMPORTANT"]           = true;                                                  // add !important to all CSS properties if is set true

// Demo Mode
$wdhSVWE["WDH_DEFAULT_DEMO_MODE"]               = 'false';                                                 // Set true if you want to test it without save changes
?>
