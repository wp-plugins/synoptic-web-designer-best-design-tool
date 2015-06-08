<?php

/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool Light
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool-light/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: wdh.svwe.js.php
 * File Description: Generate JS File
 * File Version: 1.0
 * Last Update File : 25.09.2014
 * ------------------------------------------------------------------- 
 */

if (!class_exists("wdhSVWE_JS")) {
    
    class wdhSVWE_JS extends wdhSVWE
    {
        
        function wdhSVWE_JS(){ // Constructor
        }
        
        function startJS(){
            // Header 
            header("content-type: application/x-javascript");
            $this->generateJS();
        }
        
        function generateJSHeader($newline){ // Generate JS Header
            $javascriptHTML = array();
            
            array_push($javascriptHTML, '/*');
            array_push($javascriptHTML, ' * -------------------------------------------');
            array_push($javascriptHTML, ' * Synoptic Website Design Editor');
            array_push($javascriptHTML, ' * -------------------------------------------');
            array_push($javascriptHTML, ' *');
            array_push($javascriptHTML, ' *    Generated JS for page: ');
            array_push($javascriptHTML, ' *    '.$_SERVER["HTTP_REFERER"]);
            array_push($javascriptHTML, ' *');
            array_push($javascriptHTML, ' * -------------------------------------------');
            array_push($javascriptHTML, '*/');
            
            echo implode($newline, $javascriptHTML);
        }
        
        function generateJSMin(){ // Generate Minified JS 
            $javascriptHTML = array();
            $newline = '';
            
            // Header
            array_push($javascriptHTML, $this->generateJSHeader($newline));
            
//             Example
            array_push($javascriptHTML, 'var $jWDH = jQuery.noConflict();');
            
            echo implode('',$javascriptHTML);
        }
        
        function generateJS(){ // Generate JS 
            $javascriptHTML = array();
            // Nu identa !!!
            $newline = '
';
            
            // Header
            array_push($javascriptHTML, $this->generateJSHeader($newline));
            
//             Example
            array_push($javascriptHTML, 'var $jWDH = jQuery.noConflict();');
            
            echo implode($newline, $javascriptHTML);
        }
    }
}


//// Autoload JS
//new wdhSVWE_JS();

?>