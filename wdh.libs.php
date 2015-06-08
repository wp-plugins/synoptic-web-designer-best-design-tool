<?php

/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: wdh.libs.php
 * File Description: WDH Library File
 * File Version: 1.0
 * Last Update File : 22.09.2014
 * ------------------------------------------------------------------- 
 */

if (!class_exists("wdhLibs")) {
    
    class wdhLibs{
        
        function wdhLibs(){ // Constructor
        }
        
        function getLanguagesOptions($selectedLanguage, $languages = ''){
            //$WDHLanguages = '[{"Code":"af","Name":"Afrikaans (Afrikaans)"},{"Code":"sq","Name":"Albanian (Shqiptar)"},{"Code":"ar","Name":"Arabic (>العربية)"},{"Code":"az","Name":"Azerbaijani (Azərbaycan)"},{"Code":"eu","Name":"Basque (Euskal)"},{"Code":"be","Name":"Belarusian (Беларускай)"},{"Code":"bg","Name":"Bulgarian (Български)"},{"Code":"ca","Name":"Catalan (Català)"},{"Code":"zh","Name":"Chinese (中国的)"},{"Code":"hr","Name":"Croatian (Hrvatski)"},{"Code":"cs","Name":"Czech (Český)"},{"Code":"da","Name":"Danish (Dansk)"},{"Code":"nl","Name":"Dutch (Nederlands)"},{"Code":"en","Name":"English"},{"Code":"eo","Name":"Esperanto (Esperanto)"},{"Code":"et","Name":"Estonian (Eesti)"},{"Code":"fl","Name":"Filipino (na Filipino)"},{"Code":"fi","Name":"Finnish (Suomi)"},{"Code":"fr","Name":"French (Français)"},{"Code":"gl","Name":"Galician (Galego)"},{"Code":"de","Name":"German (Deutsch)"},{"Code":"el","Name":"Greek (Ɛλληνικά)"},{"Code":"ht","Name":"Haitian Creole (Kreyòl Ayisyen)"},{"Code":"he","Name":"Hebrew (עברית)"},{"Code":"hi","Name":"Hindi (हिंदी)"},{"Code":"hu","Name":"Hungarian (Magyar)"},{"Code":"is","Name":"Icelandic (Íslenska)"},{"Code":"id","Name":"Indonesian (Indonesia)"},{"Code":"ga","Name":"Irish (Gaeilge)"},{"Code":"it","Name":"Italian (Italiano)"},{"Code":"ja","Name":"Japanese (日本の)"},{"Code":"ko","Name":"Korean (한국의)"},{"Code":"lv","Name":"Latvian (Latvijas)"},{"Code":"lt","Name":"Lithuanian (Lietuvos)"},{"Code":"mk","Name":"Macedonian (македонски)"},{"Code":"ms","Name":"Malay (Melayu)"},{"Code":"mt","Name":"Maltese (Maltija)"},{"Code":"no","Name":"Norwegian (Norske)"},{"Code":"fa","Name":"Persian (فارسی)"},{"Code":"pl","Name":"Polish (Polski)"},{"Code":"pt","Name":"Portuguese (Português)"},{"Code":"ro","Name":"Romanian (Română)"},{"Code":"ru","Name":"Russian (Pусский)"},{"Code":"sr","Name":"Serbian (Cрпски)"},{"Code":"sk","Name":"Slovak (Slovenských)"},{"Code":"sl","Name":"Slovenian (Slovenski)"},{"Code":"es","Name":"Spanish (Español)"},{"Code":"sw","Name":"Swahili (Kiswahili)"},{"Code":"sv","Name":"Swedish (Svenskt)"},{"Code":"th","Name":"Thai (ภาษาไทย)"},{"Code":"tr","Name":"Turkish (Türk)"},{"Code":"uk","Name":"Ukrainian (Український)"},{"Code":"ur","Name":"Urdu (اردو)"},{"Code":"vi","Name":"VietNamese (Việt)"},{"Code":"cy","Name":"Welsh (Cymraeg)"},{"Code":"yi","Name":"Yiddish (ייִדיש)"}]';
            $WDHLanguages = '[{"Code":"ar","Name":"Arabic - >العربية"},{"Code":"ma","Name":"Chinese - 中国的"},{"Code":"en","Name":"English"},{"Code":"fr","Name":"French - Français"},{"Code":"ge","Name":"German - Deutsch"},{"Code":"hi","Name":"Hindi - हिंदी"},{"Code":"it","Name":"Italian - Italiano"},{"Code":"ja","Name":"Japanese - 日本の"},{"Code":"pt","Name":"Portuguese - Português"},{"Code":"ru","Name":"Russian - Pусский"},{"Code":"es","Name":"Spanish - Español"},{"Code":"ot","Name":"Other"}]';
            $languagesHTML = array();
            $WDHLanguages = json_decode($WDHLanguages);
            $selected = '';
            $i = 0;
            
            foreach($WDHLanguages as $WDHLanguage){

                if ($WDHLanguage->Code == $selectedLanguage){
                    $selected = 'selected="selected"';
                }

                if ($languages == '') {
                    array_push($languagesHTML, '<option value="'.$WDHLanguage->Code.'" '.$selected.'>'.$WDHLanguage->Name.'</option>');
                } else {

                    if (strpos($languages,$WDHLanguage->Code) !== false) {
                        array_push($languagesHTML, '<option value="'.$WDHLanguage->Code.'" '.$selected.'>'.$WDHLanguage->Name.'</option>');
                    }
                }

                $selected = '';
                $i++;
            }

            return implode("",$languagesHTML);
        }
    }
}

?>
