/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool Light
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool-light/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: js/wdh.svwe.js
 * File Description: Synoptic Visual Website Editor Javascript File
 * File Version: 1.0
 * Last Update File : 22.09.2014
 * ------------------------------------------------------------------- 
 */

var $jWDH                              = jQuery.noConflict();
    window.SWEActive                   = false;
    window.wdhID                       = 0;
    window.wdhSVWEChanges              = 0;
    window.wdhShowDesign               = 'original';
    window.wdhSVWEEditor               = this;
    
    // Current Element
    window.wdhSVWECurrentPath          = 'full';
    window.wdhSVWECurrentElement       = this;
    window.wdhSVWECurrentElementJS     = $jWDH(this);
    window.wdhSVWECurrentElementTag    = '';                                    // full path
    window.wdhSVWECurrentElementTagIS  = '';
    window.wdhSVWECurrentElementTop    = 0;
    window.wdhSVWECurrentElementLeft   = 0;
    window.wdhSVWECurrentElementWidth  = 0;
    window.wdhSVWECurrentElementHeight = 0;
    
    // Select Element
    window.wdhSVWESelectedElementOn      = false;
    window.wdhSVWESelectedElement        = this;
    window.wdhSVWESelectedElementJS      = $jWDH(this);
    window.wdhSVWESelectedElementTag     = '';
    window.wdhSVWESelectedElementTop     = 0;
    window.wdhSVWESelectedElementLeft    = 0;
    window.wdhSVWESelectedElementWidth   = 0;
    window.wdhSVWESelectedElementHeight  = 0;
    
    // Settings
    window.wdhSVWESettingsResizeWidth  = window.WDH_DEFAULT_WIDTH;
    window.wdhSVWESettingsResizeHeight = window.WDH_DEFAULT_HEIGHT;
    window.wdhSVWEPageIsOn             = 'wpsite';    // wpadmin
    
    // Cusor Position
    window.wdhSVWECursorPosX           = -1;
    window.wdhSVWECursorPosY           = -1;
    
    // History
    window.wdhHistoryWebsiteAll        = '';
    window.wdhHistoryPageAll           = '';
    window.wdhHistoryWebsite           = '';
    window.wdhHistoryPage              = '';
    window.wdhHistoryStyle             = '';
    
    // TAGS LIST
    window.wdhSVWETags                 = {"h1":"h","h2":"h","h3":"h","h4":"h","h5":"h","h6":"h","div":"div","table":"table","span":"span",
                                          "img":"qimg","ul":"ul","ol":"ol","thead":"qthead","tbody":"tbody","tfoot":"tfoot","tr":"tr",
                                          "td":"td","li":"li","form":"form","fieldset":"fieldset","legend":"legend","label":"label","button":"button",
                                          "input":"input","textarea":"textarea","select":"select","strong":"strong","code":"code","br":"br",
                                          "article":"qarticle","aside":"qaside","bdi":"qbdi","details":"qdetails","dialog":"qdialog","figcaption":"qfigcaption",               // HTML 5
                                          "figure":"qfigure","footer":"qfooter","header":"qheader","main":"qmain","mark":"qmark","menuitem":"qmenuitem","meter":"qmeter",      // HTML 5
                                          "nav":"qnav","progress":"qprogress","rp":"qrp","rt":"qrt","ruby":"qruby","section":"qsection","summary":"qsummary","time":"qtime",   // HTML 5
                                          "wbr":"qwbr","datalist":"qdatalist","keygen":"qkeygen","output":"qoutput","canvas":"qcanvas","svg":"qsvg","audio":"qaudio",          // HTML 5
                                          "embed":"qembed","source":"qsource","track":"qtrack","video":"qvideo",                                                               // HTML 5
                                          "area":"qarea","map":"map","object":"object","param":"qparam","pre":"qpre","a":"a","b":"b","i":"i","p":"p","th":"th"};
               
    window.wdhSVWETagPrefix            = 'wdh';

// Adding $_GET variables
var $_GET = {};

document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
    }

    $_GET[decode(arguments[1])] = decode(arguments[2]);
});
    
$jWDH(document).ready(function(){
    // Get Cursor position
    $jWDH(document).bind('mousemove',function(e){ 
        window.wdhSVWECursorPosX = e.pageX;
        window.wdhSVWECursorPosY = e.pageY; 
    }); 
    
    if(window.WDH_DEFAULT_DEMO_MODE === 'true') {
        window.onbeforeunload = function() {
            return "Attention !!! In DEMO version all changes will be reset after the refresh/close website.";
        };
    }
        
});
        
$jWDH.fn.extend({

    wdhSWE: function(){
        var id = $jWDH(this)['selector'],
        
        editor = {
            
            // Editor Events
            start: function(){
                window.SWEActive = true;
                // Mouse Position
                $jWDH(document).mousemove(function(event) {
                    window.wdhMouseX = event.pageX;
                    window.wdhMouseY = event.pageY;
                });
                
                // Adding Right Click Menu
                editor.addRightClickMenu();
                
                // Adding Events
                editor.addEvents();
                
                // Adding buttons
                
                if ($jWDH('.wdh-logo').hasClass('wdh-left') === false) {
                    $jWDH('.wdh-publish').animate({top:'40px', right:'103px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                    
                    $jWDH('.wdh-roll-back').animate({top:'72px', right:'102px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                    
                    $jWDH('.wdh-switch').animate({top:'100px', right:'91px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                    
                    $jWDH('.wdh-resolution').animate({top:'124px', right:'72px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                    
                    $jWDH('.wdh-show-hide').animate({top:'136px', right:'42px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                    
                    $jWDH('.wdh-role').animate({top:'138px', right:'10px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                } else {
                    $jWDH('.wdh-publish').animate({top:'40px', left:'103px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                    
                    $jWDH('.wdh-roll-back').animate({top:'72px', left:'102px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                    
                    $jWDH('.wdh-switch').animate({top:'100px', left:'91px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                    
                    $jWDH('.wdh-resolution').animate({top:'124px', left:'72px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                    
                    $jWDH('.wdh-show-hide').animate({top:'136px', left:'42px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                    
                    $jWDH('.wdh-role').animate({top:'138px', left:'10px', opacity: 0.75}, 650, function(){
                        $jWDH(this).css('opacity','1');
                    });
                }
                
                // Adding Leave Page Event       
                //$jWDH('body').attr('onbeforeunload', 'if (window.wdhSVWEChanges > 0) { return wdhExit(); }');
            },
                    
            stop: function(){
                window.SWEActive = false;
                // Remove Events
                editor.removeEvents();
                
                // Remove buttons
                $jWDH('.wdh-publish').animate({top:'-28px', right:'-28px', opacity: 0.75}, 300, function(){
                    $jWDH(this).css('opacity','1');
                });
                
                $jWDH('.wdh-roll-back').animate({top:'-28px', right:'-28px', opacity: 0.75}, 300, function(){
                    $jWDH(this).css('opacity','1');
                });
                
                $jWDH('.wdh-switch').animate({top:'-28px', right:'-28px', opacity: 0.75}, 300, function(){
                    $jWDH(this).css('opacity','1');
                });
                
                $jWDH('.wdh-resolution').animate({top:'-28px', right:'-28px', opacity: 0.75}, 300, function(){
                    $jWDH(this).css('opacity','1');
                });
                
                $jWDH('.wdh-show-hide').animate({top:'-28px', right:'-28px', opacity: 0.75}, 300, function(){
                    $jWDH(this).css('opacity','1');
                });
                
                $jWDH('.wdh-role').animate({top:'-28px', right:'-28px', opacity: 0.75}, 300, function(){
                    $jWDH(this).css('opacity','1');
                });
                
                // Deselect Element
                editor.deselectElement();
            },
                    
            addButton: function(){
                var buttonHTML = new Array();
                
                // Synoptic Logo
                buttonHTML.push('<wdhdiv class="wdh-logo wdh-svwe-exclude">&nbsp;</wdhdiv>');
                // Publish Button
                buttonHTML.push('<wdhdiv class="wdh-publish wdh-svwe-exclude">&nbsp;</wdhdiv>');
                // Publish Info
                buttonHTML.push('<wdhdiv class="wdh-publish-info wdh-svwe-exclude">');
                buttonHTML.push('   <wdhdiv class="wdh-arrow wdh-svwe-exclude"></wdhdiv>');
                buttonHTML.push('   <wdhdiv class="wdh-info-content wdh-svwe-exclude"><wdhspan class="wdh-info-content-text wdh-svwe-exclude">'+window.TXT_EM_PUBLISH_TITLE+'</wdhspan></wdhdiv>');
                buttonHTML.push('</wdhdiv>');
                // Roll Back Button
                buttonHTML.push('<wdhdiv class="wdh-roll-back wdh-svwe-exclude">&nbsp;</wdhdiv>');
                // Roll Back Info
                buttonHTML.push('<wdhdiv class="wdh-roll-back-info wdh-svwe-exclude">');
                buttonHTML.push('   <wdhdiv class="wdh-arrow wdh-svwe-exclude"></wdhdiv>');
                buttonHTML.push('   <wdhdiv class="wdh-info-content wdh-svwe-exclude"><wdhspan class="wdh-info-content-text wdh-svwe-exclude">'+window.TXT_EM_ROLL_BACK_TITLE+'</wdhspan></wdhdiv>');
                buttonHTML.push('</wdhdiv>');
                // Switch Button
                buttonHTML.push('<wdhdiv class="wdh-switch wdh-svwe-exclude">&nbsp;</wdhdiv>');
                // Switch Info
                buttonHTML.push('<wdhdiv class="wdh-switch-info wdh-svwe-exclude">');
                buttonHTML.push('   <wdhdiv class="wdh-arrow wdh-svwe-exclude"></wdhdiv>');
                buttonHTML.push('   <wdhdiv class="wdh-info-content wdh-svwe-exclude"><wdhspan class="wdh-info-content-text wdh-svwe-exclude">'+window.TXT_EM_SWITCH_TITLE+'</wdhspan></wdhdiv>');
                buttonHTML.push('</wdhdiv>');
                // Resolution Button
                buttonHTML.push('<wdhdiv class="wdh-resolution wdh-svwe-exclude">&nbsp;</wdhdiv>');
                // Resolution Info
                buttonHTML.push('<wdhdiv class="wdh-resolution-info wdh-svwe-exclude">');
                buttonHTML.push('   <wdhdiv class="wdh-arrow wdh-svwe-exclude"></wdhdiv>');
                buttonHTML.push('   <wdhdiv class="wdh-info-content wdh-svwe-exclude"><wdhspan class="wdh-info-content-text wdh-svwe-exclude">'+window.TXT_EM_RESOLUTION_TITLE+'</wdhspan></wdhdiv>');
                buttonHTML.push('</wdhdiv>');
                // Show/Hide Hidden Elements Button
                buttonHTML.push('<wdhdiv class="wdh-show-hide wdh-svwe-exclude">&nbsp;</wdhdiv>');
                // Show/Hide Hidden Elements Info
                buttonHTML.push('<wdhdiv class="wdh-show-hide-info wdh-svwe-exclude">');
                buttonHTML.push('   <wdhdiv class="wdh-arrow wdh-svwe-exclude"></wdhdiv>');
                buttonHTML.push('   <wdhdiv class="wdh-info-content wdh-svwe-exclude"><wdhspan class="wdh-info-content-text wdh-svwe-exclude">'+window.TXT_EM_DELETE_CHANGES_TITLE+'</wdhspan></wdhdiv>');
                buttonHTML.push('</wdhdiv>');
                // Role Button
                buttonHTML.push('<wdhdiv class="wdh-role wdh-svwe-exclude">&nbsp;</wdhdiv>');
                // Role Info
                buttonHTML.push('<wdhdiv class="wdh-role-info wdh-svwe-exclude">');
                buttonHTML.push('   <wdhdiv class="wdh-arrow wdh-svwe-exclude"></wdhdiv>');
                buttonHTML.push('   <wdhdiv class="wdh-info-content wdh-svwe-exclude"><wdhspan class="wdh-info-content-text wdh-svwe-exclude">'+window.TXT_EM_USER_ROLE_TITLE+'</wdhspan></wdhdiv>');
                buttonHTML.push('</wdhdiv>');
                
                // Remove old buttons
                $jWDH('wdh-logo').remove();
                // Add new buttons
                $jWDH(id).append(buttonHTML.join(''));
                
                // Remove Old Event
                $jWDH('.wdh-logo').unbind('click');
                // Add New Event
                $jWDH('.wdh-logo').bind('click', function(){
                    
                    if ($jWDH(this).hasClass('selected') === true) {
                        // Stop Editor
                        editor.stop();
                        // Remove Selected
                        $jWDH(this).removeClass('selected');
                    } else {
                        // Start Editor
                        editor.start();
                        // Add Selected
                        $jWDH(this).addClass('selected');
                    }
                });
            },
            
            // CSS Events
            addCSS: function(){
                var htmlElements = window.wdhSVWETags,
                    htmlElementPrefix = window.wdhSVWETagPrefix;
                
                $jWDH.each(htmlElements, function(index, value){
                    $jWDH(id+' '+index).addClass(htmlElementPrefix+'-'+value);                // $jWDH(id+' h1').addClass('wdh-h');
                    $jWDH(id+' '+index).addClass(htmlElementPrefix+'-editable');              // $jWDH(id+' h1').addClass('wdh-editable');
                    $jWDH(id+' .wdh-svwe-exclude').removeClass(htmlElementPrefix+'-'+value);  // $jWDH(id+' .wdh-svwe-exclude').removeClass('wdh-div');
                });
                
                // Remove Editable from Excluded Elements
                $jWDH(id+' .wdh-svwe-exclude').removeClass('wdh-editable');
            },
                    
            removeCSS: function(){
                var htmlElements = window.wdhSVWETags,
                    htmlElementPrefix = window.wdhSVWETagPrefix;
            
                $jWDH.each(htmlElements, function(index, value){
                    $jWDH(id+' '+index).removeClass(htmlElementPrefix+'-'+value);                // $jWDH(id+' h1').removeClass('wdh-h');
                    $jWDH(id+' '+index).removeClass(htmlElementPrefix+'-editable');              // $jWDH(id+' h1').removeClass('wdh-editable');
                });
            },
            
            // JS Events
            addJS: function(){
                // Add Hover Events
                editor.addHoverEvents();
                // Add General Events
                editor.generalEvents();
            },
                    
            removeJS: function(){
                // Close Panel
                $jWDH('.wdh-panel').css('display','none').remove();
                // Add Resize Events
                editor.removeHoverEvents();
            },
            
            // Activator Menu        
            activatorMenu: function(){
                var activatorMenuHTML  = new Array(),
                    activatorMenuClass = 'wdh-svwe-menu-activate-20';
            
                if (window.wdhSVWECurrentElementWidth > 23){
                    activatorMenuClass = 'wdh-svwe-menu-activate-30';
                } else if (window.wdhSVWECurrentElementWidth > 33){
                    activatorMenuClass = 'wdh-svwe-menu-activate-40';
                }
                // Adding Menu Activator
                activatorMenuHTML.push('<wdhdiv class="wdh-svwe-menu-activate wdh-svwe-exclude">');
                activatorMenuHTML.push('    <wdhdiv class="wdh-svwe-menu-activate-content wdh-svwe-exclude">');
                activatorMenuHTML.push('        <wdhdiv class="wdh-svwe-menu-activate-synoptic wdh-svwe-exclude '+activatorMenuClass+' "></wdhdiv>');
                activatorMenuHTML.push('        <wdhdiv class="wdh-svwe-menu-activate-tooltip wdh-svwe-exclude">');
                activatorMenuHTML.push('            <wdhdiv class="wdh-svwe-menu-activate-tooltip-arrow wdh-svwe-exclude"></wdhdiv>');
                activatorMenuHTML.push('            <wdhdiv class="wdh-svwe-menu-activate-tooltip-text wdh-svwe-exclude">'+window.TXT_GENERAL_ENABLE+': '+window.TXT_PM_EDIT_BUTTON+'</wdhdiv>');
                activatorMenuHTML.push('        </wdhdiv>');
                activatorMenuHTML.push('    </wdhdiv>');
                activatorMenuHTML.push('</wdhdiv>');
                
                $jWDH('body').append(activatorMenuHTML.join(''));
            },
                    
            activatorMenuEvents: function(){
                
                // Show Moved Menu Activator Event
                if(window.wdhSVWESelectedElementOn === false){
                    editor.activatorMenuShowMovedEvent();
                }
                
                // Enable Element Menu Event
                editor.activatorMenuEnableDisableEvent();
                
                // Tooltip Event
                editor.activatorMenuTooltipEvent();
            },
                    
            activatorMenuEnableDisableEvent:function(){
                $jWDH('.wdh-svwe-menu-activate-synoptic').unbind('click');
                $jWDH('.wdh-svwe-menu-activate-synoptic').bind('click', function(){
                
                    if (window.wdhSVWESelectedElementOn === false && window.wdhSVWESelectedElement !== window.wdhSVWECurrentElement) {
                        // Enable
                        editor.activatorMenuStart();
                    } else {
                        // Disable
                        editor.activatorMenuStop();
                    
                        // Close Panel
                        $jWDH('.wdh-panel').animate({'bottom':'-2001px'}, 300);
                    }
                });
            },
                    
            activatorMenuShowMovedEvent: function(){
                var activatorTop       = parseInt(window.wdhSVWECurrentElementTop)+parseInt(window.wdhSVWECurrentElementHeight)/2,
                    activatorTopAdd    = 9,
                    activatorLeft      = window.wdhSVWECurrentElementLeft+parseInt(window.wdhSVWECurrentElementWidth)/2,
                    activatorLeftAdd   = 10,
                    activatorMenuClass = 'wdh-svwe-menu-activate-20';
            
                // Calculate Synoptic Menu Activator
                if (parseInt(window.wdhSVWECurrentElementWidth) < 22 || parseInt(window.wdhSVWECurrentElementHeight) < 22){
                    activatorMenuClass = 'wdh-svwe-menu-activate-20';
                    activatorTopAdd    = 10;
                    activatorLeftAdd   = 9;
                }
            
                if (parseInt(window.wdhSVWECurrentElementWidth) > 23 && parseInt(window.wdhSVWECurrentElementHeight) > 23){
                    activatorMenuClass = 'wdh-svwe-menu-activate-30';
                    activatorTopAdd    = 12;
                    activatorLeftAdd   = 12;
                }  
                
                if (parseInt(window.wdhSVWECurrentElementWidth) > 33 && parseInt(window.wdhSVWECurrentElementHeight) > 33){
                    activatorMenuClass = 'wdh-svwe-menu-activate-40';
                    activatorTopAdd    = 15;
                    activatorLeftAdd   = 17;
                }
                
                $jWDH('.wdh-svwe-menu-activate-synoptic').removeClass('wdh-svwe-menu-activate-20')
                                                         .removeClass('wdh-svwe-menu-activate-30')
                                                         .removeClass('wdh-svwe-menu-activate-40')
                                                         .addClass(activatorMenuClass);
                
                // Show / Hide Menu Activator
                $jWDH('.wdh-svwe-menu-activate').css({'display':'none','top':activatorTop-activatorTopAdd,'left':activatorLeft-activatorLeftAdd})
                                                .fadeIn(100);
                                                                   
            },
                    
            activatorMenuStart: function(){
                // Set Selected Element
                window.wdhSVWESelectedElementOn      = true;
                window.wdhSVWESelectedElement        = window.wdhSVWECurrentElement;
                window.wdhSVWESelectedElementJS      = window.wdhSVWECurrentElementJS;
                window.wdhSVWESelectedElementTag     = window.wdhSVWECurrentElementTag;
                window.wdhSVWESelectedElementTop     = window.wdhSVWECurrentElementTop;
                window.wdhSVWESelectedElementLeft    = window.wdhSVWECurrentElementLeft;
                window.wdhSVWESelectedElementWidth   = window.wdhSVWECurrentElementWidth;
                window.wdhSVWESelectedElementHeight  = window.wdhSVWECurrentElementHeight;
                
                $jWDH('body').addClass('wdh-svwe-element-selected');
                $jWDH('.wdh-svwe-menu-activate-synoptic').addClass('wdh-svwe-menu-activated');
                
                // Change Tooltip Text
                $jWDH('.wdh-svwe-menu-activate-tooltip-text').text(window.TXT_GENERAL_DISABLE+': '+window.TXT_PM_EDIT_BUTTON);
                
                // Add Selected
                $jWDH(window.wdhSVWESelectedElement).addClass('wdh-svwe-element-is-selected');
                
                // Display Element Menu
                if(parseInt(window.wdhSVWESelectedElementTop) > 22) {
                    $jWDH('.wdh-svwe-element-menu').css({'display':'none','top':parseInt(window.wdhSVWESelectedElementTop)-22,'left':parseInt(window.wdhSVWESelectedElementLeft)})
                                                   .fadeIn(200);
                } else {
                    $jWDH('.wdh-svwe-element-menu').css({'display':'none','top':parseInt(window.wdhSVWESelectedElementTop)+window.wdhSVWESelectedElementHeight,'left':parseInt(window.wdhSVWESelectedElementLeft)})
                                                   .fadeIn(200);
                }
                // Adding Menu Events
                editor.elementMenuEvents();
                
                // Adding Resize Event
                editor.activatorMenuResizeEvent();
            },
                    
            activatorMenuStop: function(){
                // Reset Selected Element
                window.wdhSVWESelectedElementOn = false;
                
                // Remove Selected
                window.wdhSVWESelectedElementJS.removeClass('wdh-svwe-element-is-selected');
                
                if(window.wdhSVWECurrentPath === 'tags_all'){
                    var currentElementTag       = window.wdhSVWESelectedElementJS.getDomTag();
                
                    $jWDH(currentElementTag).removeClass('wdh-svwe-element-is-selected-second');
                } else if(window.wdhSVWECurrentPath === 'tags_container'){
                    var currentElementTag       = window.wdhSVWESelectedElementJS.getDomTag(),
                        currentElementContainer = window.wdhSVWESelectedElementJS.parent();
                
                    $jWDH(currentElementTag, currentElementContainer).removeClass('wdh-svwe-element-is-selected-second');
                } else if(window.wdhSVWECurrentPath.indexOf('class.')){ 
                    // Classes
                    $jWDH('.'+window.wdhSVWECurrentPath.split('class.')[1]).removeClass('wdh-svwe-element-is-selected-second');
                } else {
                    // Full & ID
                    window.wdhSVWESelectedElementJS.removeClass('wdh-svwe-element-is-selected-second');
                }
                window.wdhSVWESelectedElement        = '';
                window.wdhSVWESelectedElementJS      = '';
                window.wdhSVWESelectedElementTag     = '';
                window.wdhSVWESelectedElementTop     = 0;
                window.wdhSVWESelectedElementLeft    = 0;
                window.wdhSVWESelectedElementWidth   = 0;
                window.wdhSVWESelectedElementHeight  = 0;
                // Reset Current Path
                window.wdhSVWECurrentPath            = 'full';
                
                $jWDH('body').removeClass('wdh-svwe-element-selected');
                $jWDH('.wdh-svwe-menu-activate-synoptic').removeClass('wdh-svwe-menu-activated');
                
                // Change Tooltip Text
                $jWDH('.wdh-svwe-menu-activate-tooltip-text').text(window.TXT_GENERAL_ENABLE+': '+window.TXT_PM_EDIT_BUTTON);
                
                // Hide Edit Menu
                $jWDH('.wdh-svwe-element-menu').css('display','none');
            },
                    
            activatorMenuTooltipEvent: function(){
                // General Tags: H1, H2, H3, H4, H5, DIV , P , SPAN, A, IMG, UL, OL , LI
                $jWDH('.wdh-svwe-menu-activate-synoptic').unbind('hover');
                $jWDH('.wdh-svwe-menu-activate-synoptic').hover(function(){
                    $jWDH('.wdh-svwe-menu-activate-tooltip').css('display','block');
                },
                function(){
                    $jWDH('.wdh-svwe-menu-activate-tooltip').css('display','none');
                });
            },
            
            activatorMenuResizeEvent: function(){
                
                if(window.wdhSVWESelectedElementOn) {
                    // Resize Event
                    var elementTag = window.wdhSVWESelectedElementJS.getDomTag();
                    
                    if (elementTag !== 'input' && elementTag !== 'select' && elementTag !== 'textarea' && elementTag !== 'img') {
                        $jWDH(window.wdhSVWESelectedElement).resizable({
                            disabled: false,
                            stop: function(event, ui){
                                var width = ui.size.width,
                                    height = ui.size.height,
                                    minHeight = '',
                                    containerWidth = $jWDH(this).parent().width(),
                                    widthPercent=parseInt(width*100/containerWidth),
                                    element = $jWDH(window.wdhSVWESelectedElementJS),
                                    heightCheck = height;

                                    if (window.wdhSVWESettingsResizeWidth === 'px') {
                                        width = width+'px';
                                    } else {
                                        width = widthPercent+'%';
                                    }

                                    if (window.wdhSVWESettingsResizeHeight === 'min-height'){
                                        minHeight = height+'px';
                                        height    = '';
                                        heightCheck = minHeight;
                                    }

                                    window.elementSelectNowIs = window.wdhSVWESelectedElementJS;

                                var elementTag = element.getDomTag(),
                                    elementPosition = element.getDomPosition()+1,
                                    elementSecondPosition = parseInt(elementPosition)+1,
                                    wdhPath = general.removeHover(element.getDomPath()),
                                    domPath = general.removeWDH(wdhPath),
                                    wdhID = '',
                                    wdhClass = '',
                                    wdhCurrentResolution = 'all',
                                    wdhCurrentPath = window.wdhSVWECurrentPath,
                                    wdhPageUrl = window.location.href;

                                    if (typeof $_GET['wdhResolution'] !== 'undefined') {
                                        wdhCurrentResolution = $_GET['wdhResolution'];
                                    }

                                    // Full Path
                                    if (wdhCurrentPath === 'full') {
                                        wdhPath = domPath+'.wdh-svwe-element-added:nth-child('+elementSecondPosition+')';
                                        domPath = domPath.replace(new RegExp('-hover', 'g'), '');
                                        //domPath = domPath+':nth-child('+elementPosition+')';
                                    }

                                    // HTML TAGS Container
                                    if (wdhCurrentPath === 'tags_container') {
                                        wdhPath = domPath+'.wdh-svwe-element-added';
                                        domPath = domPath.replace(new RegExp('-hover', 'g'), '');
                                        window.elementSelectNowIs = domPath;
                                    }

                                    // ID
                                    if(typeof element.attr('id') !== 'undefined' && wdhCurrentPath === 'id') {
                                        wdhID = element.attr('id');
                                        domPath = '';
                                        wdhPath = '';
                                        window.elementSelectNowIs = '#'+wdhID;
                                    }

                                    if (wdhCurrentPath.indexOf('class.') !== -1){
                                        wdhClass = wdhCurrentPath.split('class.')[1];
                                        window.elementSelectNowIs = '.'+wdhClass;
                                    }

                                    if (wdhCurrentPath === 'tags_all'){
                                        domPath = '';
                                        wdhPath = '';
                                        window.elementSelectNowIs = elementTag;
                                    }


                                    // Change Synoptic Position & Size
                                    // ---------------------------------------------


                                var activatorTop       = parseInt(window.wdhSVWESelectedElementTop)+parseInt(heightCheck)/2,
                                    activatorTopAdd    = 9,
                                    activatorLeft      = window.wdhSVWESelectedElementLeft+parseInt(width)/2,
                                    activatorLeftAdd   = 10,
                                    activatorMenuClass = 'wdh-svwe-menu-activate-20';

                                    // Calculate Synoptic Menu Activator
                                    if (parseInt(width) < 22 || parseInt(heightCheck) < 22){
                                        activatorMenuClass = 'wdh-svwe-menu-activate-20';
                                        activatorTopAdd    = 10;
                                        activatorLeftAdd   = 9;
                                    }

                                    if (parseInt(width) > 23 && parseInt(heightCheck) > 23){
                                        activatorMenuClass = 'wdh-svwe-menu-activate-30';
                                        activatorTopAdd    = 12;
                                        activatorLeftAdd   = 12;
                                    }  

                                    if (parseInt(width) > 33 && parseInt(heightCheck) > 33){
                                        activatorMenuClass = 'wdh-svwe-menu-activate-40';
                                        activatorTopAdd    = 15;
                                        activatorLeftAdd   = 17;
                                    }

                                    $jWDH('.wdh-svwe-menu-activate-synoptic').removeClass('wdh-svwe-menu-activate-20')
                                                             .removeClass('wdh-svwe-menu-activate-30')
                                                             .removeClass('wdh-svwe-menu-activate-40')
                                                             .addClass(activatorMenuClass);

                                    // Change Activator 
                                    $jWDH('.wdh-svwe-menu-activate').css({'display':'none','top':activatorTop-activatorTopAdd,'left':activatorLeft-activatorLeftAdd})
                                                                    .fadeIn(200);

                                    if (window.WDH_DEFAULT_DEMO_MODE === 'false') {
                                        // Save
                                        $jWDH.post(ajaxurl,{action: 'wdh_svwe_resize',
                                                            wdhPath: wdhPath,
                                                            domPath: domPath,
                                                            wdhID: wdhID,
                                                            wdhPageUrl: wdhPageUrl,
                                                            wdhPageOn: window.wdhSVWEPageIsOn,
                                                            wdhRole: window.wdhSVWERole,
                                                            elementTag: elementTag,
                                                            elementPosition: elementPosition,
                                                            wdhClass: wdhClass,
                                                            resolution: wdhCurrentResolution,
                                                            selectedPath: wdhCurrentPath,
                                                            width: width,
                                                            height: height,
                                                            minHeight: minHeight
                                                            }, function(data){
                                        });
                                    }

                            }
                        });  
                    }
                }
            },
                    
            deselectElement:function(){
                // Reset Selected Element
                window.wdhSVWESelectedElementOn = false;
                // Remove Selected
                $jWDH(window.wdhSVWESelectedElement).removeClass('wdh-svwe-element-is-selected');
                window.wdhSVWESelectedElement        = '';
                window.wdhSVWESelectedElementJS      = '';
                window.wdhSVWESelectedElementTag     = '';
                window.wdhSVWESelectedElementTop     = 0;
                window.wdhSVWESelectedElementLeft    = 0;
                window.wdhSVWESelectedElementWidth   = 0;
                window.wdhSVWESelectedElementHeight  = 0;
                // Reset Current Path
                window.wdhSVWECurrentPath            = 'full';
                
                $jWDH('body').removeClass('wdh-svwe-element-selected');
                $jWDH('.wdh-svwe-menu-activate-synoptic').removeClass('wdh-svwe-menu-activated');
                
                // Change Tooltip Text
                $jWDH('.wdh-svwe-menu-activate-tooltip-text').text(window.TXT_GENERAL_ENABLE+': '+window.TXT_PM_EDIT_BUTTON);
                
                // Hide Edit Menu
                $jWDH('.wdh-svwe-element-menu').css('display','none');
                
                // Disable Activator
                $jWDH('.wdh-svwe-menu-activate').css('display','none');
            },
            
            changeElement: function(element){
                // Remove Selected
                $jWDH(window.wdhSVWESelectedElement).removeClass('wdh-svwe-element-is-selected');
                
                // Save New Element
                editor.saveCurrentElement(element);
                
                // Set Selected Element
                window.wdhSVWESelectedElementOn      = true;
                window.wdhSVWESelectedElement        = window.wdhSVWECurrentElement;
                window.wdhSVWESelectedElementJS      = window.wdhSVWECurrentElementJS;
                window.wdhSVWESelectedElementTag     = window.wdhSVWECurrentElementTag;
                window.wdhSVWESelectedElementTop     = window.wdhSVWECurrentElementTop;
                window.wdhSVWESelectedElementLeft    = window.wdhSVWECurrentElementLeft;
                window.wdhSVWESelectedElementWidth   = window.wdhSVWECurrentElementWidth;
                window.wdhSVWESelectedElementHeight  = window.wdhSVWECurrentElementHeight;
                
                // Add Selected
                $jWDH(window.wdhSVWESelectedElement).addClass('wdh-svwe-element-is-selected');
                
                // Display Element Menu
                if(parseInt(window.wdhSVWESelectedElementTop) > 22) {
                    $jWDH('.wdh-svwe-element-menu').css({'display':'none','top':parseInt(window.wdhSVWESelectedElementTop)-22,'left':parseInt(window.wdhSVWESelectedElementLeft)})
                                                   .fadeIn(200);
                } else {
                    $jWDH('.wdh-svwe-element-menu').css({'display':'none','top':parseInt(window.wdhSVWESelectedElementTop)+window.wdhSVWESelectedElementHeight,'left':parseInt(window.wdhSVWESelectedElementLeft)})
                                                   .fadeIn(200);
                }
                // Adding Menu Events
                editor.elementMenuEvents();
                
                // Adding Show Menu Activator
                editor.activatorMenuShowMovedEvent();
                
                // Adding Resize Event
                editor.activatorMenuResizeEvent();  
            },
            
            zoomOutElement: function(){
                var elementJS   = window.wdhSVWESelectedElement,
                    element     = elementJS.parentNode,
                    elementPath = $jWDH(element).getDomPath();
            
                    if(element !== null && elementPath.indexOf(window.WDH_DEFAULT_CONTAINER) !== -1) {
                        // Change Element
                        editor.changeElement(element);
                    }
            },
            
            zoomInElement: function(){
                var elementJS = window.wdhSVWESelectedElement,
                    element   = elementJS.children[0];
                    
                    if(element !== null) {
                        // Change Element
                        editor.changeElement(element);
                    }
            },
            
            nextElement: function(){
                var elementJS = window.wdhSVWESelectedElement,
                    element   = elementJS.nextElementSibling;
            
                    if(element !== null) {
                        // Change Element
                        editor.changeElement(element);
                    }
            },
            
            previousElement: function(){
                var elementJS = window.wdhSVWESelectedElement,
                    element   = elementJS.previousElementSibling;
                    
                    if(element !== null) {
                        // Change Element
                        editor.changeElement(element);
                    }
            },
                    
            addHoverEvents: function(){
                var htmlElements = window.wdhSVWETags,
                    htmlElementPrefix = window.wdhSVWETagPrefix,
                    htmlElementsAll = new Array(),
                    htmlElementsAllText = '';
                
                $jWDH.each(htmlElements, function(index, value){
                    htmlElementsAll.push('.'+htmlElementPrefix+'-'+value);      // .wdh-h,.wdh-div,.wdh-table,...
                });
               
                htmlElementsAllText = htmlElementsAll.join(',');
                
                // General Tags: H1, H2, H3, H4, H5, DIV , P , SPAN, A, IMG, UL, OL , LI...
                $jWDH(id+' '+htmlElementsAllText).unbind('hover');
                $jWDH(id+' '+htmlElementsAllText).hover(function(){
                    
                    // Click Event
                    if ($jWDH(this).hasClass('wdh-logo') === false) {
                        
                        if ($jWDH('body').hasClass('wdh-svwe-exclude') === false){
                            // Save Current ELement
                            editor.saveCurrentElement(this);
                        }
                        
                        if (($jWDH(":first-child", $jWDH('body')).hasClass('wdh-svwe-element-added').toString() === 'false' && $jWDH(":first-child", $jWDH('body')).hasClass('wdh-svwe-exclude').toString() === 'false') || ($jWDH('body').hasClass('wdh-svwe-element-added').toString() === 'false' && $jWDH('body').hasClass('wdh-svwe-exclude').toString() === 'false')) {

                            
                            var menuHTML = new Array();
                            
                            // Adding Menu Activator
                            editor.activatorMenu();
                            
                            // Adding Element Menu
//                            menuHTML.push('<wdhdiv class="wdh-svwe-element wdh-svwe-exclude">');
                            menuHTML.push('     <wdhdiv class="wdh-svwe-element-menu wdh-svwe-exclude">');
                            // Edit Element Design
                            menuHTML.push('         <wdhdiv class="wdh-svwe-em-button wdh-svwe-em-button-edit wdh-svwe-left-round wdh-svwe-right-border wdh-svwe-exclude">');
                            menuHTML.push('             <wdhspan class="wdh-svwe-tooltip wdh-svwe-exclude"><wdhspan class="wdh-svwe-information wdh-min100 wdh-svwe-exclude">'+window.TXT_PM_EDIT_BUTTON+'</wdhspan></wdhspan>');
                            menuHTML.push('         </wdhdiv>');
                            // Edit Element Texts
//                            menuHTML.push('         <wdhdiv class="wdh-svwe-em-button wdh-svwe-em-button-edit-text wdh-svwe-right-border wdh-svwe-right-border wdh-svwe-exclude">');
//                            menuHTML.push('             <wdhspan class="wdh-svwe-tooltip wdh-svwe-exclude"><wdhspan class="wdh-svwe-information wdh-min100 wdh-svwe-exclude">'+window.TXT_PM_EDIT_TEXT_BUTTON+'</wdhspan></wdhspan>');
//                            menuHTML.push('         </wdhdiv>');
                            // Zoom In
                            menuHTML.push('         <wdhdiv class="wdh-svwe-em-button wdh-svwe-em-button-zoom-in wdh-svwe-right-border wdh-svwe-right-border wdh-svwe-exclude">');
                            menuHTML.push('             <wdhspan class="wdh-svwe-tooltip wdh-svwe-exclude"><wdhspan class="wdh-svwe-information wdh-min100 wdh-svwe-exclude">'+window.TXT_PM_ZOOM_IN+'</wdhspan></wdhspan>');
                            menuHTML.push('         </wdhdiv>');
                            // Zoom Out
                            menuHTML.push('         <wdhdiv class="wdh-svwe-em-button wdh-svwe-em-button-zoom-out wdh-svwe-right-border wdh-svwe-right-border wdh-svwe-exclude">');
                            menuHTML.push('             <wdhspan class="wdh-svwe-tooltip wdh-svwe-exclude"><wdhspan class="wdh-svwe-information wdh-min100 wdh-svwe-exclude">'+window.TXT_PM_ZOOM_OUT+'</wdhspan></wdhspan>');
                            menuHTML.push('         </wdhdiv>');
                            // Previous
                            menuHTML.push('         <wdhdiv class="wdh-svwe-em-button wdh-svwe-em-button-previous wdh-svwe-right-border wdh-svwe-right-border wdh-svwe-exclude">');
                            menuHTML.push('             <wdhspan class="wdh-svwe-tooltip wdh-svwe-exclude"><wdhspan class="wdh-svwe-information wdh-min100 wdh-svwe-exclude">'+window.TXT_PM_PREVIOUS+'</wdhspan></wdhspan>');
                            menuHTML.push('         </wdhdiv>');
                            // Next
                            menuHTML.push('         <wdhdiv class="wdh-svwe-em-button wdh-svwe-em-button-next wdh-svwe-right-border wdh-svwe-right-border wdh-svwe-exclude">');
                            menuHTML.push('             <wdhspan class="wdh-svwe-tooltip wdh-svwe-exclude"><wdhspan class="wdh-svwe-information wdh-min100 wdh-svwe-exclude">'+window.TXT_PM_NEXT+'</wdhspan></wdhspan>');
                            menuHTML.push('         </wdhdiv>');
                            // Copy Element Design
                            menuHTML.push('         <wdhdiv class="wdh-svwe-em-button wdh-svwe-em-button-copy wdh-svwe-right-border wdh-svwe-exclude">');
                            menuHTML.push('             <wdhspan class="wdh-svwe-tooltip wdh-svwe-exclude"><wdhspan class="wdh-svwe-information wdh-min100 wdh-svwe-exclude">'+window.TXT_PM_COPY_BUTTON+'</wdhspan></wdhspan>');
                            menuHTML.push('         </wdhdiv>');
                            // Paste Element Design
                            menuHTML.push('         <wdhdiv class="wdh-svwe-em-button wdh-svwe-em-button-paste wdh-svwe-right-border wdh-svwe-exclude">');
                            menuHTML.push('             <wdhspan class="wdh-svwe-tooltip wdh-svwe-exclude"><wdhspan class="wdh-svwe-information wdh-min100 wdh-svwe-exclude">'+window.TXT_PM_PASTE_BUTTON+'</wdhspan></wdhspan>');
                            menuHTML.push('         </wdhdiv>');
                            // Path Element
                            menuHTML.push('         <wdhdiv class="wdh-svwe-em-button wdh-svwe-em-button-path wdh-svwe-right-round wdh-svwe-exclude">');
                            menuHTML.push('             <wdhspan class="wdh-svwe-tooltip wdh-svwe-exclude"><wdhspan class="wdh-svwe-information wdh-min100 wdh-svwe-exclude">'+window.TXT_PM_PATH_BUTTON+'</wdhspan></wdhspan>');
                            menuHTML.push('             <input type="hidden" class="wdh-svwe-em-selected-path" value="full">'); // full , x class
                            menuHTML.push('         </wdhdiv>');
                            // Roll Back Element
//                            menuHTML.push('         <wdhdiv class="wdh-svwe-em-button wdh-svwe-em-button-roll-back wdh-svwe-right-round wdh-svwe-exclude">');
//                            menuHTML.push('             <wdhspan class="wdh-svwe-tooltip wdh-svwe-exclude"><wdhspan class="wdh-svwe-information wdh-min50 wdh-svwe-exclude">'+window.TXT_PM_ROLL_BACK_BUTTON+'</wdhspan></wdhspan>');
//                            menuHTML.push('         </wdhdiv>');
                            menuHTML.push('     </wdhdiv>');
//                            menuHTML.push('</wdhdiv>');
                            
                            $jWDH('body').append(menuHTML.join(''));
                            $jWDH('body').addClass('wdh-svwe-element-added');
                            
                            // Hide All Tooltips
                            $jWDH('.wdh-svwe-tooltip').css('display','none');

                            // Add Tooltip
                            $jWDH('.wdh-svwe-em-button').hover(function(){
                                $jWDH(this).find('.wdh-svwe-tooltip').css('display','block');
                                $jWDH(this).find('.wdh-svwe-information').fadeIn(300);
                            },
                            function(){
                                $jWDH('.wdh-svwe-tooltip').css('display','none');
                                $jWDH('.wdh-svwe-information').css('display','none');
                            });
                        }
                        
                        if (window.SWEActive === true) {
                            // Adding Menu Activator Events
                            editor.activatorMenuEvents();
                        }
                        
                        
                        if(window.wdhSVWESelectedElementOn === false){
                            // Adding Hover Classes
                                
                            if($jWDH(this).hasClass(window.wdhSVWETagPrefix+'-'+window.wdhSVWECurrentElementTagIS) === true){
                                
                                if($jWDH(this).css('background').indexOf("url") === -1 && $jWDH(this).css('background-image').indexOf("url") === -1) {
                                    $jWDH(this).addClass(window.wdhSVWETagPrefix+'-'+window.wdhSVWECurrentElementTagIS+'-hover');
                                } else {
                                    $jWDH(this).addClass(window.wdhSVWETagPrefix+'-'+window.wdhSVWECurrentElementTagIS+'-hover-color');
                                }
                            }
                        }
                    }
                   
                   // Move Events
//                   $jWDH(this).sortable({
//                        disabled: false,
//                        update: function( event, ui ) {
//                             var currentElemnt = ui.item.context.id;
//                        }
//                    });
                },
                function(){
                    var elementHovered = $jWDH(this);
                    $jWDH.each(window.wdhSVWETags, function(index, value){
                        elementHovered.removeClass(window.wdhSVWETagPrefix+'-'+value+'-hover');
                        elementHovered.removeClass(window.wdhSVWETagPrefix+'-'+value+'-hover-color');
                    });
                });
            },
            
            removeHoverEvents: function(){
                var htmlElements = window.wdhSVWETags,
                    htmlElementPrefix = window.wdhSVWETagPrefix,
                    htmlElementsAll = new Array(),
                    htmlElementsAllText = '';
            
                $jWDH.each(htmlElements, function(index, value){
                    htmlElementsAll.push('.'+htmlElementPrefix+'-'+value);      // .wdh-h,.wdh-div,.wdh-table,...
                });
               
                htmlElementsAllText = htmlElementsAll.join(',');
                // Remove Hove
                $jWDH(id+' '+htmlElementsAllText).unbind('hover');
                $jWDH(id+' '+htmlElementsAllText).hover(function(){
                    
                    // Remove Click Event 
                    if ($jWDH(this).hasClass('wdh-logo') === false) {
                        $jWDH(this).unbind('click');
                    }
                    
                    // Remove Hover Class
                    $jWDH(this).removeClass(window.wdhSVWETagPrefix+'-'+window.wdhSVWECurrentElementTagIS+'-hover');
                    $jWDH(this).removeClass(window.wdhSVWETagPrefix+'-'+window.wdhSVWECurrentElementTagIS+'-hover-color');
                    
                    // Headers: H1, H2, H3, H4, H5, H6 
//                    $jWDH(this).sortable({ disabled: true });
//                    $jWDH(this).resizable({ disabled: true });
                },
                function(){
                    
                });
            },
            
            generalEvents: function(){
                // Publish Events
                $jWDH('.wdh-publish').unbind('hover');
                $jWDH('.wdh-publish').hover(function (){
                    $jWDH('.wdh-publish-info').css('display','block');
                }, function(){
                    $jWDH('.wdh-publish-info').css('display','none');
                });
                
                $jWDH('.wdh-publish, .wdh-svwe-rcm-publish').unbind('click');
                $jWDH('.wdh-publish, .wdh-svwe-rcm-publish').bind('click',function (){
                    
                    if ($jWDH(this).hasClass('wdh-disabled') === false) {
                        var optionsHTML = new Array();

                        optionsHTML.push('<option value="current_page">'+window.TXT_EM_PUBLISH_FOR_PAGE+'</option>');
                        optionsHTML.push('<option value="website">'+window.TXT_EM_PUBLISH_FOR_WEBSITE+'</option>');

                        $jWDH("body").wdhPopupJS({"message": window.TXT_EM_PUBLISH_TITLE,
                              "labelYes": window.TXT_GENERAL_SAVE,
                              "labelNo": window.TXT_GENERAL_CLOSE,
                              "functionYes": 'wdhPublishFor()',
                              "fields": {"0":{"id": "wdh-field",
                                            "name": "wdh-field",
                                            "type": "select",
                                            "display_type": "top", // left , top
                                            "class": "",
                                            "css": "",
                                            "label": {"for": "wdh-swve-select-publish-for",
                                                      "text": window.TXT_EM_PUBLISH_SAVE_CSS,
                                                      "class": "",
                                                      "css": ""
                                                     },
                                            "input": {"id": "wdh-swve-select-publish-for",
                                                      "name": "wdh-swve-select-publish-for",
                                                      "value": "",
                                                      "class": "",
                                                      "css": "",
                                                      "options": {"0":{"name": "option 1",
                                                                       "value": "option 1"
                                                                      }
                                                                 },
                                                      "options_type": "html",
                                                      "options_html": optionsHTML.join('')
                                                     }
                                        }      
                                    }
                        });
                        
                        editor.stopRightClickMenu();
                    }
                    
                });
                
                // Roll Back Events
                $jWDH('.wdh-roll-back').unbind('hover');
                $jWDH('.wdh-roll-back').hover(function (){
                    $jWDH('.wdh-roll-back-info').css('display','block');
                }, function(){
                    $jWDH('.wdh-roll-back-info').css('display','none');
                });
                
                $jWDH('.wdh-roll-back, .wdh-svwe-rcm-rollback').unbind('click');
                $jWDH('.wdh-roll-back, .wdh-svwe-rcm-rollback').bind('click',function (){
                    var optionsHTML = new Array();
                    
                    optionsHTML.push('<option value="current_page">'+window.TXT_EM_PUBLISH_FOR_PAGE+'</option>');
                    optionsHTML.push('<option value="website" selected="selected">'+window.TXT_EM_PUBLISH_FOR_WEBSITE+'</option>');
                    
                    $jWDH("body").wdhPopupJS({"message": window.TXT_EM_ROLLBACK_TITLE,
                          "labelYes": window.TXT_GENERAL_SAVE,
                          "labelNo": window.TXT_GENERAL_CLOSE,
                          "functionYes": 'wdhRollBack()',
                          "fields": {"0":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "top", // left , top
                                        "class": "",
                                        "css": "",
                                        "onChange": "wdhRollBackChange",
                                        "label": {"for": "wdh-swve-select-rollback-for",
                                                  "text": window.TXT_EM_ROLLBACK_FOR,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-rollback-for",
                                                  "name": "wdh-swve-select-rollback-for",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": optionsHTML.join('')
                                                 }
                                    },
                                    "1":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "top", // left , top
                                        "class": "",
                                        "css": "",
                                        "label": {"for": "wdh-swve-select-rollback-at-website",
                                                  "text": window.TXT_EM_ROLLBACK_AT,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-rollback-at-website",
                                                  "name": "wdh-swve-select-rollback-at-website",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": window.history_website
                                                 }
                                    },
                                    "2":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "top", // left , top
                                        "class": "",
                                        "css": "",
                                        "visible": false,
                                        "label": {"for": "wdh-swve-select-rollback-at-current-page",
                                                  "text": window.TXT_EM_ROLLBACK_AT,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-rollback-at-current-page",
                                                  "name": "wdh-swve-select-rollback-at-current-page",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": window.history_current_page
                                                 }
                                    }
                                }
                            });
                            
                            editor.stopRightClickMenu();
                });
                
                // Switch Events
                $jWDH('.wdh-switch').unbind('hover');
                $jWDH('.wdh-switch').hover(function (){
                    $jWDH('.wdh-switch-info').css('display','block');
                }, function(){
                    $jWDH('.wdh-switch-info').css('display','none');
                });
                
                $jWDH('.wdh-switch').unbind('click');
                $jWDH('.wdh-switch').bind('click',function (){
                    if($jWDH('.wdh-logo').hasClass('wdh-left') === false) {
                        $jWDH('.wdh-logo').addClass('wdh-left');
                        $jWDH('.wdh-publish').addClass('wdh-left');
                        $jWDH('.wdh-publish').css('left',$jWDH('.wdh-publish').css('right'));
                        $jWDH('.wdh-publish-info').addClass('wdh-left');
                        $jWDH('.wdh-publish-info').css('left',$jWDH('.wdh-publish-info').css('right'));
                        $jWDH('.wdh-roll-back').addClass('wdh-left');
                        $jWDH('.wdh-roll-back').css('left',$jWDH('.wdh-roll-back').css('right'));
                        $jWDH('.wdh-roll-back-info').addClass('wdh-left');
                        $jWDH('.wdh-roll-back-info').css('left',$jWDH('.wdh-roll-back-info').css('right'));
                        $jWDH('.wdh-switch').addClass('wdh-left');
                        $jWDH('.wdh-switch').css('left',$jWDH('.wdh-switch').css('right'));
                        $jWDH('.wdh-switch-info').addClass('wdh-left');
                        $jWDH('.wdh-switch-info').css('left',$jWDH('.wdh-switch-info').css('right'));
                        $jWDH('.wdh-resolution').addClass('wdh-left');
                        $jWDH('.wdh-resolution').css('left',$jWDH('.wdh-resolution').css('right'));
                        $jWDH('.wdh-resolution-info').addClass('wdh-left');
                        $jWDH('.wdh-resolution-info').css('left',$jWDH('.wdh-resolution-info').css('right'));
                        $jWDH('.wdh-show-hide').addClass('wdh-left');
                        $jWDH('.wdh-show-hide').css('left',$jWDH('.wdh-show-hide').css('right'));
                        $jWDH('.wdh-show-hide-info').addClass('wdh-left');
                        $jWDH('.wdh-show-hide-info').css('left',$jWDH('.wdh-show-hide-info').css('right'));
                        $jWDH('.wdh-role').addClass('wdh-left');
                        $jWDH('.wdh-role').css('left',$jWDH('.wdh-role').css('right'));
                        $jWDH('.wdh-role-info').addClass('wdh-left');
                        $jWDH('.wdh-role-info').css('left',$jWDH('.wdh-role-info').css('right'));
                    } else {
                        $jWDH('.wdh-logo').removeClass('wdh-left');
                        $jWDH('.wdh-publish').removeClass('wdh-left');
                        $jWDH('.wdh-publish').css('right',$jWDH('.wdh-publish').css('left'));
                        $jWDH('.wdh-publish').css('left',$jWDH('.wdh-publish').css('left','auto'));
                        $jWDH('.wdh-publish-info').removeClass('wdh-left');
                        $jWDH('.wdh-publish-info').css('right',$jWDH('.wdh-publish-info').css('left'));
                        $jWDH('.wdh-publish-info').css('left',$jWDH('.wdh-publish-info').css('left','auto'));
                        $jWDH('.wdh-roll-back').removeClass('wdh-left');
                        $jWDH('.wdh-roll-back').css('right',$jWDH('.wdh-roll-back').css('left'));
                        $jWDH('.wdh-roll-back').css('left',$jWDH('.wdh-roll-back').css('left','auto'));
                        $jWDH('.wdh-roll-back-info').removeClass('wdh-left');
                        $jWDH('.wdh-roll-back-info').css('right',$jWDH('.wdh-roll-back-info').css('left'));
                        $jWDH('.wdh-roll-back-info').css('left',$jWDH('.wdh-roll-back-info').css('left','auto'));
                        $jWDH('.wdh-switch').removeClass('wdh-left');
                        $jWDH('.wdh-switch').css('right',$jWDH('.wdh-switch').css('left'));
                        $jWDH('.wdh-switch').css('left',$jWDH('.wdh-switch').css('left','auto'));
                        $jWDH('.wdh-switch-info').removeClass('wdh-left');
                        $jWDH('.wdh-switch-info').css('right',$jWDH('.wdh-switch-info').css('left'));
                        $jWDH('.wdh-switch-info').css('left',$jWDH('.wdh-switch-info').css('left','auto'));
                        $jWDH('.wdh-resolution').removeClass('wdh-left');
                        $jWDH('.wdh-resolution').css('right',$jWDH('.wdh-resolution').css('left'));
                        $jWDH('.wdh-resolution').css('left',$jWDH('.wdh-resolution').css('left','auto'));
                        $jWDH('.wdh-resolution-info').removeClass('wdh-left');
                        $jWDH('.wdh-resolution-info').css('right',$jWDH('.wdh-resolution-info').css('left'));
                        $jWDH('.wdh-resolution-info').css('left',$jWDH('.wdh-resolution-info').css('left','auto'));
                        $jWDH('.wdh-show-hide').removeClass('wdh-left');
                        $jWDH('.wdh-show-hide').css('right',$jWDH('.wdh-show-hide').css('left'));
                        $jWDH('.wdh-show-hide').css('left',$jWDH('.wdh-show-hide').css('left','auto'));
                        $jWDH('.wdh-show-hide-info').removeClass('wdh-left');
                        $jWDH('.wdh-show-hide-info').css('right',$jWDH('.wdh-show-hide-info').css('left'));
                        $jWDH('.wdh-show-hide-info').css('left',$jWDH('.wdh-show-hide-info').css('left','auto'));
                        $jWDH('.wdh-role').removeClass('wdh-left');
                        $jWDH('.wdh-role').css('right',$jWDH('.wdh-role').css('left'));
                        $jWDH('.wdh-role').css('left',$jWDH('.wdh-role').css('left','auto'));
                        $jWDH('.wdh-role-info').removeClass('wdh-left');
                        $jWDH('.wdh-role-info').css('right',$jWDH('.wdh-role-info').css('left'));
                        $jWDH('.wdh-role-info').css('left',$jWDH('.wdh-role-info').css('left','auto'));
                    }
                });
                
                // Resolution Events
                $jWDH('.wdh-resolution').unbind('hover');
                $jWDH('.wdh-resolution').hover(function (){
                    $jWDH('.wdh-resolution-info').css('display','block');
                }, function(){
                    $jWDH('.wdh-resolution-info').css('display','none');
                });
                
                $jWDH('.wdh-resolution, .wdh-svwe-rcm-resolution').unbind('click');
                $jWDH('.wdh-resolution, .wdh-svwe-rcm-resolution').bind('click',function (){
                    var optionsHTML = new Array(),
                        currentResolution = 'all',
                        selected320 = '',
                        selected480 = '',
                        selected568 = '',
                        selected768 = '',
                        selected1024 = '',
                        selected1280 = '',
                        selectedAll = '';
                        
                    if (typeof $_GET['wdhResolution'] !== 'undefined') {
                        currentResolution = $_GET['wdhResolution'];
                    }
                    
                    if(parseInt(currentResolution) === 320) { selected320 = 'selected="selected"'; }
                    if(parseInt(currentResolution) === 480) { selected480 = 'selected="selected"'; }
                    if(parseInt(currentResolution) === 568) { selected568 = 'selected="selected"'; }
                    if(parseInt(currentResolution) === 768) { selected768 = 'selected="selected"'; }
                    if(parseInt(currentResolution) === 1024) { selected1024 = 'selected="selected"'; }
                    if(parseInt(currentResolution) === 1280) { selected1280 = 'selected="selected"'; }
                    if(currentResolution === 'all') { selectedAll = 'selected="selected"'; }
                    
                    // Selecct Options 
                    optionsHTML.push('<option '+selected320+' value="320">'+window.TXT_EM_RESOLUTION_320_PX+'</option>');
                    optionsHTML.push('<option '+selected480+' value="480">'+window.TXT_EM_RESOLUTION_480_PX+'</option>');
                    optionsHTML.push('<option '+selected568+' value="568">'+window.TXT_EM_RESOLUTION_568_PX+'</option>');
                    optionsHTML.push('<option '+selected768+' value="768">'+window.TXT_EM_RESOLUTION_768_PX+'</option>');
                    optionsHTML.push('<option '+selected1024+' value="1024">'+window.TXT_EM_RESOLUTION_1024_PX+'</option>');
                    optionsHTML.push('<option '+selected1280+' value="1280">'+window.TXT_EM_RESOLUTION_1280_PX+'</option>');
                    optionsHTML.push('<option '+selectedAll+' value="all">'+window.TXT_EM_RESOLUTION_ALL+'</option>');
                    
                    $jWDH("body").wdhPopupJS({"message": window.TXT_EM_RESOLUTION_TITLE,
                          "labelYes": window.TXT_GENERAL_SAVE,
                          "labelNo": window.TXT_GENERAL_CLOSE,
                          "functionYes": 'wdhChangeResolution()',
                          "fields": {"0":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "top", // left , top
                                        "class": "",
                                        "css": "",
                                        "label": {"for": "wdh-swve-select-resolution",
                                                  "text": window.TXT_EM_RESOLUTION_SELECT,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-resolution",
                                                  "name": "wdh-swve-select-resolution",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": optionsHTML.join('')
                                                 }
                                    }      
                                }
                            });
                            
                    editor.stopRightClickMenu();
                });
                
                // Delete Changes Events
                $jWDH('.wdh-show-hide').unbind('hover');
                $jWDH('.wdh-show-hide').hover(function (){
                    $jWDH('.wdh-show-hide-info').css('display','block');
                }, function(){
                    $jWDH('.wdh-show-hide-info').css('display','none');
                });
                
                $jWDH('.wdh-show-hide, .wdh-svwe-rcm-delete').unbind('click');
                $jWDH('.wdh-show-hide, .wdh-svwe-rcm-delete').bind('click',function (){
                    var optionsHTML = new Array(),
                        firstOptionsHTML = new Array();
                    
                    firstOptionsHTML.push('<option value="unsaved" selected="selected">'+window.TXT_EM_DELETE_TYPE_UNSAVED+'</option>');
                    firstOptionsHTML.push('<option value="saved">'+window.TXT_EM_DELETE_TYPE_SAVED+'</option>');
                    
                    optionsHTML.push('<option value="current_page">'+window.TXT_EM_PUBLISH_FOR_PAGE+'</option>');
                    optionsHTML.push('<option value="website" selected="selected">'+window.TXT_EM_PUBLISH_FOR_WEBSITE+'</option>');
                    
                    var wdhCurrentHistoryWebsite = window.history_website;
                        wdhCurrentHistoryWebsite = wdhCurrentHistoryWebsite.replace(new RegExp('<option value="original" selected="selected">'+window.TXT_EM_PUBLISH_ORIGINAL+'</option>', 'g'), '');
                        wdhCurrentHistoryWebsite = wdhCurrentHistoryWebsite.replace(new RegExp('<option value="original">'+window.TXT_EM_PUBLISH_ORIGINAL+'</option>', 'g'), '');
                        wdhCurrentHistoryWebsite = wdhCurrentHistoryWebsite.replace(new RegExp('<option value="latest" selected="selected">'+window.TXT_EM_PUBLISH_LATEST+'</option>', 'g'), '');
                        wdhCurrentHistoryWebsite = wdhCurrentHistoryWebsite.replace(new RegExp('<option value="latest">'+window.TXT_EM_PUBLISH_LATEST+'</option>', 'g'), '');
                        wdhCurrentHistoryWebsite += '<option value="all">'+window.TXT_EM_DELETE_ALL+'</option>';
                        
                    var wdhCurrentHistoryPage = window.history_current_page;
                        wdhCurrentHistoryPage = wdhCurrentHistoryPage.replace(new RegExp('<option value="original" selected="selected">'+window.TXT_EM_PUBLISH_ORIGINAL+'</option>', 'g'), '');
                        wdhCurrentHistoryPage = wdhCurrentHistoryPage.replace(new RegExp('<option value="original">'+window.TXT_EM_PUBLISH_ORIGINAL+'</option>', 'g'), '');
                        wdhCurrentHistoryPage = wdhCurrentHistoryPage.replace(new RegExp('<option value="latest" selected="selected">'+window.TXT_EM_PUBLISH_LATEST+'</option>', 'g'), '');
                        wdhCurrentHistoryPage = wdhCurrentHistoryPage.replace(new RegExp('<option value="latest">'+window.TXT_EM_PUBLISH_LATEST+'</option>', 'g'), '');
                        wdhCurrentHistoryPage += '<option value="all">'+window.TXT_EM_DELETE_ALL+'</option>';
                        
                    $jWDH("body").wdhPopupJS({"message": window.TXT_EM_DELETE_TITLE,
                          "labelYes": window.TXT_GENERAL_DELETE,
                          "labelNo": window.TXT_GENERAL_CLOSE,
                          "functionYes": 'wdhDeleteDesign()',
                          "fields": {"0":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "top", // left , top
                                        "class": "",
                                        "css": "",
                                        "onChange": "wdhDeleteDesignTypeChange",
                                        "label": {"for": "wdh-swve-select-delete-design-type",
                                                  "text": window.TXT_EM_DELETE_TYPE,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-delete-design-type",
                                                  "name": "wdh-swve-select-delete-design-type",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": firstOptionsHTML.join('')
                                                 }
                                    },
                                    "1":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "top", // left , top
                                        "class": "",
                                        "css": "",
                                        "visible": false,
                                        "onChange": "wdhDeleteDesignForChange",
                                        "label": {"for": "wdh-swve-select-delete-design-for",
                                                  "text": window.TXT_EM_DELETE_FOR,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-delete-design-for",
                                                  "name": "wdh-swve-select-delete-design-for",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": optionsHTML.join('')
                                                 }
                                    },
                                    "2":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "top", // left , top
                                        "class": "",
                                        "css": "",
                                        "visible": false,
                                        "label": {"for": "wdh-swve-select-delete-design-at-website",
                                                  "text": window.TXT_EM_DELETE_AT,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-delete-design-at-website",
                                                  "name": "wdh-swve-select-delete-design-at-website",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": wdhCurrentHistoryWebsite
                                                 }
                                    },
                                    "3":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "top", // left , top
                                        "class": "",
                                        "css": "",
                                        "visible": false,
                                        "label": {"for": "wdh-swve-select-delete-design-at-current-page",
                                                  "text": window.TXT_EM_DELETE_AT,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-delete-design-at-current-page",
                                                  "name": "wdh-swve-select-delete-design-at-current-page",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": wdhCurrentHistoryPage
                                                 }
                                    }
                                }
                            });
                            
                    editor.stopRightClickMenu();
                });
                
                $jWDH('.wdh-svwe-rcm-logout').unbind('click');
                $jWDH('.wdh-svwe-rcm-logout').bind('click',function (){
                    $jWDH("body").wdhPopupJS({"message": window.TXT_GENERAL_LOADING,
                                              "functionLoading": 'wdhLogout',
                                              "sendData": "",
                                              "view": "loading",
                                              "reset": true
                    });
                });
                
                // Role Events
                $jWDH('.wdh-role').unbind('hover');
                $jWDH('.wdh-role').hover(function (){
                    $jWDH('.wdh-role-info').css('display','block');
                }, function(){
                    $jWDH('.wdh-role-info').css('display','none');
                });
                
                $jWDH('.wdh-role').unbind('click');
                $jWDH('.wdh-role').bind('click',function (){
                    var optionsHTML = new Array(),
                        currentRole             = window.wdhSVWERole,
                        selectedAll             = '',
                        selectedRegistered      = '',
                        wdhRoles                = window.wdhSVWERoles;
                    
                    if (window.wdhSVWEPageIsOn !== 'wpadmin') {
                        if(currentRole === 'all') { selectedAll = 'selected="selected"'; }
                        if(currentRole === 'registered') { selectedRegistered = 'selected="selected"'; }

                        // Selecct Options 
                        optionsHTML.push('<option '+selectedAll+' value="all">'+window.TXT_EM_USER_FOR_ALL+'</option>');
                        //optionsHTML.push('<option '+selectedRegistered+' value="registered">'+window.TXT_EM_USER_FOR_USERS+'</option>');
                    } else {
                        
                        if(currentRole === 'all') {
                            currentRole = 'administrator';
                        }
                    }
                    
                    if(wdhRoles.indexOf(',') !== -1) {
                        wdhRoles = wdhRoles.split(',');
                        
                        for (var k=0; k<wdhRoles.length;k++){
                            
                            if(wdhRoles[k] === currentRole) {
                                optionsHTML.push('<option value="'+wdhRoles[k]+'" selected="selected">'+wdhRoles[k]+'</option>');
                            } else {
                                optionsHTML.push('<option value="'+wdhRoles[k]+'">'+wdhRoles[k]+'</option>');
                            }
                        }
                    } else {
                        if(wdhRoles === currentRole) {
                            optionsHTML.push('<option value="'+wdhRoles+'" selected="selected">'+wdhRoles+'</option>');
                        } else {
                            optionsHTML.push('<option value="'+wdhRoles+'">'+wdhRoles+'</option>');
                        }
                    }
                    
                    $jWDH("body").wdhPopupJS({"message": window.TXT_EM_USER_EDIT_DESIGN,
                          "labelYes": window.TXT_GENERAL_SAVE,
                          "labelNo": window.TXT_GENERAL_CLOSE,
                          "functionYes": 'wdhChangeRole()',
                          "fields": {"0":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "top", // left , top
                                        "class": "",
                                        "css": "",
                                        "label": {"for": "wdh-swve-select-role",
                                                  "text": window.TXT_EM_USER_FOR,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-role",
                                                  "name": "wdh-swve-select-role",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": optionsHTML.join('')
                                                 }
                                    }      
                                }
                            });
                });
                
                
                // Language Events
                $jWDH('.wdh-svwe-rcm-language').unbind('click');
                $jWDH('.wdh-svwe-rcm-language').bind('click',function (){
                
                    $jWDH('.wdh-svwe-right-click-menu').css('display','none');

                    $jWDH("body").wdhPopupJS({"message": window.TXT_LANGUAGE,
                          "labelYes": window.TXT_GENERAL_SAVE,
                          "labelNo": window.TXT_GENERAL_CLOSE,
                          "functionYes": 'wdhChangeLanguage()',
                          "fields": {"0":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "top", // left , top
                                        "class": "",
                                        "css": "",
                                        "label": {"for": "wdh-swve-select-language",
                                                  "text": window.TXT_LANGUAGE,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-language",
                                                  "name": "wdh-swve-select-language",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": window.wdhSVWELanguages
                                                 }
                                    }      
                                }
                            });
                });
                
            },
                    
            elementMenuEvents: function (){
                var element = window.wdhSVWESelectedElementJS;
                
                // Edit Design
                $jWDH('.wdh-svwe-em-button-edit').eq(0).unbind('click');
                $jWDH('.wdh-svwe-em-button-edit').eq(0).bind('click', function(){
                    
                    // Remove Old Panel Properties 
                    $jWDH('.wdh-settings-normal-general-text').remove();
                    $jWDH('.wdh-settings-hover-general-text').remove();
                    $jWDH('.wdh-settings-normal-general-box').remove();
                    $jWDH('.wdh-settings-hover-general-box').remove();
                    $jWDH('.wdh-settings-normal-advanced-text').remove();
                    $jWDH('.wdh-settings-hover-advanced-text').remove();
                    $jWDH('.wdh-settings-normal-advanced-box').remove();
                    $jWDH('.wdh-settings-hover-advanced-box').remove();
                    
                    window.elementSelectNowIs = window.wdhSVWESelectedElementJS;
                    
                    var elementTag = element.getDomTag(),
                        elementPosition = element.getDomPosition()+1,
                        elementSecondPosition = parseInt(elementPosition)+1,
                        wdhPath = general.removeHover(element.getDomPath()),
                        domPath = general.removeWDH(wdhPath),
                        modDomPath = '',
                        newDomPath = new Array(),
                        wdhID = '',
                        wdhClass = '',
                        wdhAllCSS = css(element),
                        wdhCurrentResolution = 'all',
                        wdhCurrentPath = window.wdhSVWECurrentPath,
                        wdhPageUrl = window.location.href;
                        
                        if (typeof $_GET['wdhResolution'] !== 'undefined') {
                            wdhCurrentResolution = $_GET['wdhResolution'];
                        }
                        
                        // Full Path
                        if (wdhCurrentPath === 'full') {
                            wdhPath = domPath+'.wdh-svwe-element-added:nth-child('+elementSecondPosition+')';
                            domPath = domPath.replace(new RegExp('-hover', 'g'), '');
                            //domPath = domPath+':nth-child('+elementPosition+')';
                        }
                        
                        // HTML TAGS Container
                        if (wdhCurrentPath === 'tags_container') {
                            wdhPath = domPath+'.wdh-svwe-element-added';
                            domPath = domPath.replace(new RegExp('-hover', 'g'), '');
                            
                            modDomPath = domPath.split('').reverse().join('');
                            modDomPath = modDomPath.split('>');
                            
                            $jWDH.each(modDomPath, function(index, value){
                                
                                if (index < 1) { 
                                    newDomPath.push(elementTag.split('').reverse().join(''));
                                } else {
                                    newDomPath.push(value);
                                }
                            });
                            modDomPath = newDomPath.join('>').split('').reverse().join('');
                            domPath = modDomPath;
                            window.elementSelectNowIs = domPath;
                        }
                        
                        // ID
                        if(typeof element.attr('id') !== 'undefined' && wdhCurrentPath === 'id') {
                            wdhID = element.attr('id');
                            domPath = '';
                            wdhPath = '';
                            window.elementSelectNowIs = '#'+wdhID;
                        }
                        
                        if (wdhCurrentPath.indexOf('class.') !== -1){
                            wdhClass = wdhCurrentPath.split('class.')[1];
                            window.elementSelectNowIs = '.'+wdhClass;
                        }
                        
                        if (wdhCurrentPath === 'tags_all'){
                            domPath = elementTag;
                            wdhPath = '';
                            wdhAllCSS = {};
                            window.elementSelectNowIs = elementTag;
                        }
                        
                        // Reset to default panel settings
                        $jWDH('#wdh-panel-category-settings').val('normal');
                        $jWDH('#wdh-panel-type-settings').val('general');
                        $jWDH('#wdh-panel-subtype-settings').val('text');
                        
                        $jWDH('body').wdhPanelJS({'wdhPath': wdhPath,
                                                  'domPath': domPath,
                                                  'wdhID': wdhID,
                                                  'wdhRole': window.wdhSVWERole,
                                                  'wdhClass': wdhClass,
                                                  'wdhAllCSS': wdhAllCSS,
                                                  'wdhPageUrl': wdhPageUrl,
                                                  'elementTag': elementTag,
                                                  'elementPosition': elementPosition,
                                                  'resolution': wdhCurrentResolution,
                                                  'selectedPath': wdhCurrentPath
                                               });
                    
                });
                
                // Zoom In
                $jWDH('.wdh-svwe-em-button-zoom-in').unbind('click');
                $jWDH('.wdh-svwe-em-button-zoom-in').bind('click', function(){
                    editor.zoomInElement();
                    
                    // Close Panel
                    $jWDH('.wdh-panel').animate({'bottom':'-2001px'}, 300);
                });
                
                // Zoom Out
                $jWDH('.wdh-svwe-em-button-zoom-out').unbind('click');
                $jWDH('.wdh-svwe-em-button-zoom-out').bind('click', function(){
                    editor.zoomOutElement();
                    
                    // Close Panel
                    $jWDH('.wdh-panel').animate({'bottom':'-2001px'}, 300);
                });
                
                // Next
                $jWDH('.wdh-svwe-em-button-next').unbind('click');
                $jWDH('.wdh-svwe-em-button-next').bind('click', function(){
                    editor.nextElement();
                    
                    // Close Panel
                    $jWDH('.wdh-panel').animate({'bottom':'-2001px'}, 300);
                });
                
                // Previous
                $jWDH('.wdh-svwe-em-button-previous').unbind('click');
                $jWDH('.wdh-svwe-em-button-previous').bind('click', function(){
                    editor.previousElement();
                    
                    // Close Panel
                    $jWDH('.wdh-panel').animate({'bottom':'-2001px'}, 300);
                });
                
                // Copy Design
                $jWDH('.wdh-svwe-em-button-copy').eq(0).unbind('click');
                $jWDH('.wdh-svwe-em-button-copy').eq(0).bind('click', function(){
                    window.elementCopiedIs = window.wdhSVWESelectedElementJS;
                    $jWDH(this).removeClass('wdh-svwe-selected')
                               .addClass('wdh-svwe-selected');
                });
                
                // Paste Design
                $jWDH('.wdh-svwe-em-button-paste').eq(0).unbind('click');
                $jWDH('.wdh-svwe-em-button-paste').eq(0).bind('click', function(){
                    
                    if(typeof window.elementCopiedIs !== 'undefined'){
                        window.elementSelectNowIs = window.wdhSVWESelectedElementJS;
                    
                    var elementTag = element.getDomTag(),
                        elementPosition = element.getDomPosition()+1,
                        elementSecondPosition = parseInt(elementPosition)+1,
                        wdhPath = general.removeHover(element.getDomPath()),
                        domPath = general.removeWDH(wdhPath),
                        modDomPath = '',
                        newDomPath = new Array(),
                        wdhID = '',
                        wdhClass = '',
                        wdhAllCSS = css(window.elementCopiedIs),
                        wdhCurrentResolution = 'all',
                        wdhCurrentPath = window.wdhSVWECurrentPath,
                        wdhPageUrl = window.location.href;
                        
                        if (typeof $_GET['wdhResolution'] !== 'undefined') {
                            wdhCurrentResolution = $_GET['wdhResolution'];
                        }
                        
                        // Full Path
                        if (wdhCurrentPath === 'full') {
                            wdhPath = domPath+'.wdh-svwe-element-added:nth-child('+elementSecondPosition+')';
                            domPath = domPath.replace(new RegExp('-hover', 'g'), '');
                            //domPath = domPath+':nth-child('+elementPosition+')';
                        }
                        
                        // HTML TAGS Container
                        if (wdhCurrentPath === 'tags_container') {
                            wdhPath = domPath+'.wdh-svwe-element-added';
                            domPath = domPath.replace(new RegExp('-hover', 'g'), '');
                            
                            modDomPath = domPath.split('').reverse().join('');
                            modDomPath = modDomPath.split('>');
                            
                            $jWDH.each(modDomPath, function(index, value){
                                
                                if (index < 1) { 
                                    newDomPath.push(elementTag.split('').reverse().join(''));
                                } else {
                                    newDomPath.push(value);
                                }
                            });
                            modDomPath = newDomPath.join('>').split('').reverse().join('');
                            domPath = modDomPath;
                            window.elementSelectNowIs = domPath;
                        }
                        
                        // ID
                        if(typeof element.attr('id') !== 'undefined' && wdhCurrentPath === 'id') {
                            wdhID = element.attr('id');
                            domPath = '';
                            wdhPath = '';
                            window.elementSelectNowIs = '#'+wdhID;
                        }
                        
                        if (wdhCurrentPath.indexOf('class.') !== -1){
                            wdhClass = wdhCurrentPath.split('class.')[1];
                            window.elementSelectNowIs = '.'+wdhClass;
                        }
                        
                        if (wdhCurrentPath === 'tags_all'){
                            domPath = elementTag;
                            wdhPath = '';
                            window.elementSelectNowIs = elementTag;
                        }
                        
                        var pasteData = {
                            'wdhPath': wdhPath,
                            'domPath': domPath,
                            'wdhID': wdhID,
                            'wdhClass': wdhClass,
                            'wdhAllCSS': wdhAllCSS,
                            'wdhPageUrl': wdhPageUrl,
                            'elementTag': elementTag,
                            'elementPosition': elementPosition,
                            'resolution': wdhCurrentResolution,
                            'selectedPath': element.find('.wdh-svwe-em-selected-path').eq(0).val()
                        };
                        
                        pasteData = JSON.stringify(pasteData);
                        
                        $jWDH("body").wdhPopupJS({"message": window.TXT_PM_PASTE_SAVING,
                                                  "functionLoading": 'wdhPasteDesign',
                                                  "sendData": pasteData,
                                                  "view": "loading",
                                                  "reset": true
                        });
                    } else {
                        alert(window.TXT_PM_PASTE_NOT_COPIED);
                    }
                });
                
                // Edit Text
                $jWDH('.wdh-svwe-em-button-edit-text').eq(0).unbind('click');
                $jWDH('.wdh-svwe-em-button-edit-text').eq(0).bind('click', function(){
                    
                    if(element.attr('contenteditable') === 'true') {
                        // Edit Text Deselected 
                        $jWDH(this).removeClass('wdh-svwe-selected');
                        // Disable
                        element.attr('contenteditable', 'false');
                        
                        // Add Hover Class
                        var htmlElements = window.wdhSVWETags,
                            htmlElementPrefix = window.wdhSVWETagPrefix;

                        $jWDH.each(htmlElements, function(index, value){
                            element.addClass(htmlElementPrefix+'-'+value+'-hover');                      // element.addClass('wdh-h-hover');
                            element.addClass(htmlElementPrefix+'-'+value+'-hover-color');                // element.addClass('wdh-h-hover-color');
                        });
                        
                        // Change Cursor
                        element.css('cursor', 'move');
                        
                        // Sortable & Resizeble
//                        element.sortable({ disabled: false });
//                        element.resizable({ disabled: false });
                        element.addClass('ui-resizable');
                        element.addClass('ui-sortable');
                        element.addClass('ui-sortable-handle');
                    } else {
                        // Edit Text Selected 
                        $jWDH(this).addClass('wdh-svwe-selected');
                        
                        // Remove Hover Class
                        var htmlElements = window.wdhSVWETags,
                            htmlElementPrefix = window.wdhSVWETagPrefix;

                        $jWDH.each(htmlElements, function(index, value){
                            element.removeClass(htmlElementPrefix+'-'+value+'-hover');                      // element.removeClass('wdh-h-hover');
                            element.removeClass(htmlElementPrefix+'-'+value+'-hover-color');                // element.removeClass('wdh-h-hover-color');
                        });
                        
                        // Change Cursor
                        element.css('cursor', 'text');
                        
                        // Sortable & Resizeble
//                        element.sortable({ disabled: true });
//                        element.resizable({ disabled: true });
                        element.removeClass('ui-resizable');
                        element.removeClass('ui-sortable');
                        element.removeClass('ui-sortable-handle');
                        
                        element.attr('contenteditable', 'true');
                        element.focus();
                        element.attr('tabindex', '0');
                    }
                });
                
                
                // Change Path
                $jWDH('.wdh-svwe-em-button-path').unbind('click');
                $jWDH('.wdh-svwe-em-button-path').bind('click', function(){
                    
                    window.elementSelectNowIs = window.wdhSVWESelectedElementJS;
                    
                    var elementTag = element.getDomTag(),
                        elementPosition = element.getDomPosition()+1,
                        elementSecondPosition = parseInt(elementPosition)+1,
                        wdhPath = general.removeHover(element.getDomPath()),
                        domPath = general.removeWDH(wdhPath),
                        wdhID = '',
                        wdhAllCSS = css(element),
                        wdhAllCSSClasses = '',
                        wdhCurrentResolution = 'all',
                        wdhCurrentPath = window.wdhSVWECurrentPath,
                        wdhPageUrl = window.location.href;
                        
                        if (typeof $_GET['wdhResolution'] !== 'undefined') {
                            wdhCurrentPath = $_GET['wdhResolution'];
                        }
                        
                        wdhPath = domPath+'.wdh-svwe-element-added:nth-child('+elementSecondPosition+')';
                        domPath = domPath.replace(new RegExp('-hover', 'g'), '');
                        //domPath = domPath+':nth-child('+elementPosition+')';
                        
                        // Get All Classes
                        if(typeof element.attr('class') !== 'undefined') {
                            wdhAllCSSClasses = element.attr('class');
                            wdhAllCSSClasses = general.removeHover(wdhAllCSSClasses);
                            wdhAllCSSClasses = general.removeWDH(wdhAllCSSClasses);
                        }
                        
                        var optionsHTML = new Array(),
                        wdhSelectedFull = '',
                        wdhSelectedID = '',
                        wdhSelectedClasses = '',
                        wdhSelectedTagsAll = '',
                        wdhSelectedTagsContainer = '';
                        
                        if (wdhCurrentPath === 'full') {
                            wdhSelectedFull = 'selected="selected"';
                        }
                        
                        if (wdhCurrentPath === 'id') {
                            wdhSelectedID = 'selected="selected"';
                        }
                        
                        if (wdhCurrentPath === 'tags_all') {
                            wdhSelectedTagsAll = 'selected="selected"';
                        }
                        
                        if (wdhCurrentPath === 'tags_container') {
                            wdhSelectedTagsContainer = 'selected="selected"';
                        }
                        
                    // Selecct Options 
                    optionsHTML.push('<option '+wdhSelectedFull+' value="full">'+window.TXT_PM_PATH_FULL+'</option>');
                    
                    if(typeof element.attr('id') !== 'undefined') {
                        wdhID = element.attr('id');
                        optionsHTML.push('<option '+wdhSelectedID+' value="id">'+window.TXT_PM_PATH_ID+': '+wdhID+'</option>');
                    }
                    // Classes
                    if (typeof wdhAllCSSClasses !== 'undefined' && wdhAllCSSClasses.trim() !== '') {

                        if (wdhAllCSSClasses.indexOf(' ')){
                            var wdhAllCSSClass = wdhAllCSSClasses.split(' ');

                            for (var i=0; i<wdhAllCSSClass.length; i++) {

                                if (wdhCurrentPath === 'class.'+wdhAllCSSClass[i]){
                                    optionsHTML.push('<option value="class.'+wdhAllCSSClass[i]+'" selected="selected">'+window.TXT_PM_PATH_CLASS+': '+wdhAllCSSClass[i]+'</option>');
                                } else {
                                    optionsHTML.push('<option value="class.'+wdhAllCSSClass[i]+'">'+window.TXT_PM_PATH_CLASS+': '+wdhAllCSSClass[i]+'</option>');
                                }
                            }
                        } else {

                            if (wdhCurrentPath === 'class.'+wdhAllCSSClasses){
                                optionsHTML.push('<option value="class.'+wdhAllCSSClasses+'" selected="selected">'+window.TXT_PM_PATH_CLASS+': '+wdhAllCSSClasses+'</option>');
                            } else {
                                optionsHTML.push('<option value="class.'+wdhAllCSSClasses+'">'+window.TXT_PM_PATH_CLASS+': '+wdhAllCSSClasses+'</option>');
                            }
                        }
                    }
                    
                    optionsHTML.push('<option '+wdhSelectedTagsAll+' value="tags_all">'+window.TXT_PM_PATH_TAGS_ALL+'</option>');
                    optionsHTML.push('<option '+wdhSelectedTagsContainer+' value="tags_container">'+window.TXT_PM_PATH_TAGS_CONTAINER+'</option>');
                    
                    $jWDH("body").wdhPopupJS({"message": window.TXT_PM_PATH_TITLE,
                          "labelYes": window.TXT_GENERAL_SAVE,
                          "labelNo": window.TXT_GENERAL_CLOSE,
                          "functionYes": 'wdhChangePath()',
                          "reset": true,
                          "fields": {"0":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "top", // left , top
                                        "class": "",
                                        "css": "",
                                        "label": {"for": "wdh-swve-select-path",
                                                  "text": window.TXT_PM_PATH_LABEL,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-path",
                                                  "name": "wdh-swve-select-path",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": optionsHTML.join('')
                                                 }
                                    }      
                        }
                    });
                    
                });
            },
                    
            // All Events        
            addEvents: function() {
                var start = new Date().getTime();
                // Add CSS
                editor.addCSS();
                var end = new Date().getTime();
                var time = end - start;
                console.log('Add CSS -- Execution time: ' + time);
                
                var start = new Date().getTime();
                // Add JS
                editor.addJS();
                var end = new Date().getTime();
                var time = end - start;
                console.log('Add JS -- Execution time: ' + time);
            },
            
            removeEvents: function(){
                var start = new Date().getTime();
                // Remove JS
                editor.removeJS();
                var end = new Date().getTime();
                var time = end - start;
                console.log('Remove JS -- Execution time: ' + time);
                
                
                var start = new Date().getTime();
                // Remove CSS
                editor.removeCSS();
                var end = new Date().getTime();
                var time = end - start;
                console.log('Remove CSS -- Execution time: ' + time);
            },
                    
            addRightClickMenu: function(){
        
                $jWDH('body').unbind('contextmenu');
                $jWDH('body').bind('contextmenu', function(){
                    
                    // Right Click Menu
                    if ($jWDH('body').html().indexOf('wdh-svwe-right-click-menu') === -1) {
                        var wdhRCMenu = new Array();
                        
                        wdhRCMenu.push('<ul class="wdh-svwe-right-click-menu wdh-svwe-exclude">');
                        
                        if (window.wdhShowDesign === 'original') {
                            wdhRCMenu.push('<li class="wdh-svwe-rcm-show-original wdh-svwe-exclude">'+window.TXT_RCM_SHOW_ORIGINAL_TITLE+'</li>');
                        } else {
                            wdhRCMenu.push('<li class="wdh-svwe-rcm-show-modified wdh-svwe-exclude">'+window.TXT_RCM_SHOW_MODIFIED_TITLE+'</li>');
                        }
                        wdhRCMenu.push('    <li class="wdh-svwe-rcm-language wdh-svwe-exclude">'+window.TXT_LANGUAGE+'</li>');
                        wdhRCMenu.push('    <li class="wdh-svwe-rcm-publish wdh-svwe-exclude">'+window.TXT_RCM_PUBLISH_TITLE+'</li>');
                        wdhRCMenu.push('    <li class="wdh-svwe-rcm-rollback wdh-svwe-exclude">'+window.TXT_RCM_ROLL_BACK_TITLE+'</li>');
                        wdhRCMenu.push('    <li class="wdh-svwe-rcm-resolution wdh-svwe-exclude">'+window.TXT_RCM_RESOLUTION_TITLE+'</li>');
                        wdhRCMenu.push('    <li class="wdh-svwe-rcm-delete wdh-svwe-exclude">'+window.TXT_RCM_DELETE_CHANGES_TITLE+'</li>');
                        wdhRCMenu.push('    <li class="wdh-svwe-rcm-settings wdh-svwe-exclude">'+window.TXT_RCM_SETTINGS_CHANGES_TITLE+'</li>');
                        wdhRCMenu.push('    <li class="wdh-svwe-rcm-logout wdh-svwe-exclude">'+window.TXT_RCM_LOGOUT_TITLE+'</li>');
                        wdhRCMenu.push('</ul>');
                        
                        $jWDH('body').append(wdhRCMenu.join(''));
                        editor.generalEvents();
                        editor.eventsRightClickMenu();
                    }
                    
                    $jWDH('.wdh-svwe-right-click-menu').css({'display':'none','top': window.wdhMouseY, 'left': window.wdhMouseX})
                                                       .fadeIn(10);
                    
                    $jWDH("html").click(function(event) {
                        
                        if ($jWDH(event.target).closest('.wdh-svwe-right-click-menu').length === 0) {
                            $jWDH('.wdh-svwe-right-click-menu').hide();
                        }
                    });
                    
                    return false;
                });
            }, 
            
            stopRightClickMenu: function(){
                
                if ($jWDH('body').html().indexOf('wdh-svwe-right-click-menu') !== -1) {
                    $jWDH('.wdh-svwe-right-click-menu').css('display', 'none');
                }
            },
                    
            eventsRightClickMenu: function(){
                // Show Modified Design
                $jWDH('.wdh-svwe-rcm-show-modified').unbind('click');
                $jWDH('.wdh-svwe-rcm-show-modified').bind('click',function (){
                    
                    // Add Saved Design
                    if (window.wdhHistoryWebsite !== '' && window.wdhHistoryWebsite !== 'undefined') {
                        $jWDH('#wdh-svwe-history-website').attr('href', window.wdhHistoryWebsite);
                    }
                    
                    if (window.wdhHistoryPage !== '' && window.wdhHistoryPage !== 'undefined') {
                        $jWDH('#wdh-svwe-history-page').attr('href', window.wdhHistoryPage);
                    }
                    
                    // Add All people Saved Design
                    if (window.wdhHistoryWebsiteAll !== '' && window.wdhHistoryWebsiteAll !== 'undefined') {
                        $jWDH('#wdh-svwe-history-website-all').attr('href', window.wdhHistoryWebsiteAll);
                    }
                    
                    if (window.wdhHistoryPageAll !== '' && window.wdhHistoryPageAll !== 'undefined') {
                        $jWDH('#wdh-svwe-history-page-all').attr('href', window.wdhHistoryPageAll);
                    }
                    
                    window.wdhShowDesign = 'original';
                    
                    editor.stopRightClickMenu();
                    
                    $jWDH('.wdh-svwe-rcm-show-modified').addClass('wdh-svwe-rcm-show-original');
                    $jWDH('.wdh-svwe-rcm-show-original').removeClass('wdh-svwe-rcm-show-modified');
                    $jWDH('.wdh-svwe-rcm-show-original').html(window.TXT_RCM_SHOW_ORIGINAL_TITLE);
                    
                    editor.eventsRightClickMenu();
                    
                    // Add UnSaved Design
                    if (window.wdhHistoryStyle !== ''){
                        $jWDH('body').append('<style>'+window.wdhHistoryStyle+'</style>');
                    }
                });
                
                // Show Original Design
                $jWDH('.wdh-svwe-rcm-show-original').unbind('click');
                $jWDH('.wdh-svwe-rcm-show-original').bind('click',function (){
                    // Remove Saved Design
                    window.wdhHistoryWebsite = $jWDH('#wdh-svwe-history-website').attr('href');
                    window.wdhHistoryPage = $jWDH('#wdh-svwe-history-page').attr('href');
                    $jWDH('#wdh-svwe-history-website').removeAttr('href');
                    $jWDH('#wdh-svwe-history-page').removeAttr('href');
                    
                    // Remove All Saved Design
                    window.wdhHistoryWebsiteAll = $jWDH('#wdh-svwe-history-website-all').attr('href');
                    window.wdhHistoryPageAll = $jWDH('#wdh-svwe-history-page-all').attr('href');
                    $jWDH('#wdh-svwe-history-website-all').removeAttr('href');
                    $jWDH('#wdh-svwe-history-page-all').removeAttr('href');
                    
                    window.wdhShowDesign = 'modified';
                    
                    editor.stopRightClickMenu();
                    
                    $jWDH('.wdh-svwe-rcm-show-original').addClass('wdh-svwe-rcm-show-modified');
                    $jWDH('.wdh-svwe-rcm-show-modified').removeClass('wdh-svwe-rcm-show-original');
                    $jWDH('.wdh-svwe-rcm-show-modified').html(window.TXT_RCM_SHOW_MODIFIED_TITLE);
                    
                    editor.eventsRightClickMenu();
                    
                    // Save UnSaved Design
                    var wdhStyleTag = $jWDH('style'),
                        wdhStyleTags = wdhStyleTag.length,
                        wdhStyleTagHTML = '';
                        
                        for(var i=0; i<wdhStyleTags; i++){
                            var wdhCurrrentStyle = $jWDH('style').eq(i).html();
                            wdhStyleTagHTML += wdhCurrrentStyle;
                        }
                        
                        window.wdhHistoryStyle = wdhStyleTagHTML;
                        
                        // Remove UnSaved Design
                        wdhStyleTag.remove();
                });
                
                // Settings
                $jWDH('.wdh-svwe-rcm-settings').unbind('click');
                $jWDH('.wdh-svwe-rcm-settings').bind('click',function (){
                    var settingsWidthHTML = new Array(),
                        settingsHeightHTML = new Array();
                        
                        // Width Settings
                        if (window.wdhSVWESettingsResizeWidth === 'px') {
                            settingsWidthHTML.push('<option value="px" selected="selected">px</option>');
                            settingsWidthHTML.push('<option value="percent">%</option>');
                        } else {
                            settingsWidthHTML.push('<option value="px">px</option>');
                            settingsWidthHTML.push('<option value="percent" selected="selected">%</option>');
                        }
                        
                        // Height Settings
                        if (window.wdhSVWESettingsResizeHeight === 'height') {
                            settingsHeightHTML.push('<option value="height" selected="selected">height</option>');
                            settingsHeightHTML.push('<option value="min-height">min-height</option>');
                        } else {
                            settingsHeightHTML.push('<option value="height">height</option>');
                            settingsHeightHTML.push('<option value="min-height" selected="selected">min-height</option>');
                        }
                        
                    // Stop Right Click Menu
                    editor.stopRightClickMenu();
                        
                    $jWDH("body").wdhPopupJS({"message": window.TXT_RCM_SETTINGS_CHANGES_TITLE,
                          "labelYes": window.TXT_GENERAL_SAVE,
                          "labelNo": window.TXT_GENERAL_CLOSE,
                          "functionYes": 'wdhChangeSettings()',
                          "reset": true,
                          "fields": {"0":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "left", // left , top
                                        "class": "",
                                        "css": "",
                                        "label": {"for": "wdh-swve-select-settings-resize-width",
                                                  "text": window.BOX_WIDTH,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-settings-resize-width",
                                                  "name": "wdh-swve-select-settings-resize-width",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": settingsWidthHTML.join('')
                                                 }
                                    },
                                    "1":{"id": "wdh-field",
                                        "name": "wdh-field",
                                        "type": "select",
                                        "display_type": "left", // left , top
                                        "class": "",
                                        "css": "",
                                        "label": {"for": "wdh-swve-select-settings-resize-height",
                                                  "text": window.BOX_HEIGHT,
                                                  "class": "",
                                                  "css": ""
                                                 },
                                        "input": {"id": "wdh-swve-select-settings-resize-height",
                                                  "name": "wdh-swve-select-settings-resize-height",
                                                  "value": "",
                                                  "class": "",
                                                  "css": "",
                                                  "options": {"0":{"name": "option 1",
                                                                   "value": "option 1"
                                                                  }
                                                             },
                                                  "options_type": "html",
                                                  "options_html": settingsHeightHTML.join('')
                                                 }
                                    }
                        }
                    });
                });
            },
                    
            saveCurrentElement: function(elementSent){
                var element    = $jWDH(elementSent),
                    elementTag = element.getDomTag(),
                    elementPosition = element.getDomPosition()+1,
                    elementSecondPosition = parseInt(elementPosition)+1,
                    wdhPath = general.removeHover(element.getDomPath()),
                    domPath = general.removeWDH(wdhPath),
                    wdhID = '',
                    wdhClass = '',
                    wdhAllCSS = css(element),
                    wdhCurrentResolution = 'all',
                    wdhCurrentPath = window.wdhSVWECurrentPath;
            
                    window.wdhSVWECurrentElementTagIS = elementTag;

                    if (typeof $_GET['wdhResolution'] !== 'undefined') {
                        wdhCurrentResolution = $_GET['wdhResolution'];
                    }
                    
                    // Full Path
                    if (wdhCurrentPath === 'full') {
                        wdhPath = domPath+'.wdh-svwe-element-added:nth-child('+elementSecondPosition+')';
                        domPath = domPath.replace(new RegExp('-hover', 'g'), '');
                        //domPath = domPath+':nth-child('+elementPosition+')';
                        window.wdhSVWECurrentElementTag = domPath;
                    }
                    
                    // HTML TAGS Container
                    if (wdhCurrentPath === 'tags_container') {
                        wdhPath = domPath+'.wdh-svwe-element-added';
                        domPath = domPath.replace(new RegExp('-hover', 'g'), '');
                        window.wdhSVWECurrentElementTag = domPath;
                    }

                    // ID
                    if(typeof element.attr('id') !== 'undefined' && wdhCurrentPath === 'id') {
                        wdhID = element.attr('id');
                        window.wdhSVWECurrentElementTag = '#'+wdhID;
                    }

                    if (wdhCurrentPath.indexOf('class.') !== -1){
                        wdhClass = wdhCurrentPath.split('class.')[1];
                        window.wdhSVWECurrentElementTag = '.'+wdhClass;
                    }

                    if (wdhCurrentPath === 'tags_all'){
                        window.wdhSVWECurrentElementTag = elementTag;
                    }
                    
                    window.wdhSVWECurrentElement    = elementSent;
                    window.wdhSVWECurrentElementJS  = element;
                    
                    window.wdhSVWECurrentElementTop    = element.offset().top;
                    window.wdhSVWECurrentElementLeft   = element.offset().left;
                    
                    if (typeof element.css('box-sizing') !== 'undefined') {
                        
                        if (element.css('box-sizing') === 'content-box' || element.css('box-sizing') === 'border-box') {
                            window.wdhSVWECurrentElementWidth  = element.width();
                            window.wdhSVWECurrentElementHeight = element.height();
                        } else {
                            window.wdhSVWECurrentElementWidth  = element.width()+element.css('padding-left')+element.css('padding-right');
                            window.wdhSVWECurrentElementHeight = element.height()+element.css('padding-top')+element.css('padding-bottom');
                        }
                    } else {
                        window.wdhSVWECurrentElementWidth  = element.width()+element.css('padding-left')+element.css('padding-right');
                        window.wdhSVWECurrentElementHeight = element.height()+element.css('padding-top')+element.css('padding-bottom');
                    }
            }
            
        },
                
        general = {
            removeWDH: function(text){
                
                var htmlElements = window.wdhSVWETags,
                    htmlElementPrefix = window.wdhSVWETagPrefix;

                // Remove Tags
                $jWDH.each(htmlElements, function(index, value){
                    text = text.replace(new RegExp('.'+htmlElementPrefix+'-'+value, 'g'), '');      // text = text.replace(new RegExp('.wdh-h', 'g'), '');
                    text = text.replace(new RegExp(htmlElementPrefix+'-'+value, 'g'), '');          // text = text.replace(new RegExp('wdh-h', 'g'), '');
                });
                
                text = text.replace(new RegExp('.wdh-editable', 'g'), '');
                text = text.replace(new RegExp('wdh-editable', 'g'), '');
                text = text.replace(new RegExp('.ui-resizable', 'g'), '');
                text = text.replace(new RegExp('ui-resizable', 'g'), '');
                text = text.replace(new RegExp('.ui-sortable', 'g'), '');
                text = text.replace(new RegExp('ui-sortable', 'g'), '');
                text = text.replace(new RegExp('.ui-sortable-handle', 'g'), '');
                text = text.replace(new RegExp('ui-sortable-handle', 'g'), '');
                text = text.replace(new RegExp('.wdh-svwe-element-added-hover-color', 'g'), '');
                text = text.replace(new RegExp('wdh-svwe-element-added-hover-color', 'g'), '');
                text = text.replace(new RegExp('.wdh-svwe-element-added-hover', 'g'), '');
                text = text.replace(new RegExp('wdh-svwe-element-added-hover', 'g'), '');
                text = text.replace(new RegExp('.wdh-svwe-element-added', 'g'), '');
                text = text.replace(new RegExp('wdh-svwe-element-added', 'g'), '');
                text = text.replace(new RegExp('-handle', 'g'), '');
                text = text.replace(new RegExp('.wdh-svwe-element-selected', 'g'), '');
                text = text.replace(new RegExp('.wdh-svwe-element-is-selected', 'g'), '');
                
                return text;
            },
            removeHover: function(text){
        
                text = text.replace(new RegExp('.ui-resizable', 'g'), '');
                text = text.replace(new RegExp('.ui-sortable', 'g'), '');
                
                return text;
            }
        };
        
        // Start Plugin
        if (window.SWEActive === true) {
            // Start Editor
            editor.start();
        } else {
            editor.addButton();
        }
        
        window.wdhSVWEEditor = editor;
    } 

});

function wdhChangeResolution(){
    var wdhWindowWidth = $jWDH(window).width(),
        wdhWindowHeight = $jWDH(window).height(),
        resolution = $jWDH('#wdh-swve-select-resolution').val(),
        resolutionWidth = parseInt(resolution),
        wdhWindowLeft = $jWDH(window).width()/2;

    if(resolution !== 'all'){
        // Create Resolution Panel
        wdhWindowLeft = (wdhWindowWidth / 2) - (resolutionWidth / 2); 
        
        var wdhFullUrlIs = window.location.href;
        
        if(wdhFullUrlIs.indexOf('?') !== -1) {
            var wdhNewURL = window.location.href+'&wdhResolution='+resolution;
        } else {
            var wdhNewURL = window.location.href+'?wdhResolution='+resolution;
        }
        
        window.close();
        window.open(wdhNewURL,"wdhResolutionWindow","menubar=1,resizable=1,left="+wdhWindowLeft+",width="+resolutionWidth+",height="+wdhWindowHeight);
    }
    
    // Hide Popup
    $jWDH('#wdh-popup-body-bg-id').css('display','none');
    $jWDH('.wdh-popup-action').css('display','none');
}

function wdhChangeRole(){
    // Change Role
    window.wdhSVWERole = $jWDH('#wdh-swve-select-role').val();
    
    $jWDH("body").wdhPopupJS({"message": window.TXT_EM_USER_FOR_SAVING,
                              "functionLoading": 'wdhChangeRoleSave',
                              "sendData": '{"role": "'+window.wdhSVWERole+'"}',
                              "view": "loading",
                              "reset": true
    });
}

function wdhChangeRoleSave(sendData){
    // Change Role
    window.wdhSVWERole = $jWDH('#wdh-swve-select-role').val();
    
    if (window.WDH_DEFAULT_DEMO_MODE === 'false') {
        $jWDH.post(ajaxurl,{action:'wdh_svwe_change_role',
                            wdhRole: sendData["role"]}, function(data){

            if (data === 'success') {

                if(typeof window.wdhSVWEPageWPadminURL === 'undefined') {
                    window.location.href = location.href;
                } else {
                    window.location.href = window.wdhSVWEPageWPadminURL;
                }
            }

        });
    } else {
        alert('Sorry in DEMO version you can\'t use this option.');
        // Hide Popup
        $jWDH('#wdh-popup-body-bg-id').css('display','none').remove();
        $jWDH('.wdh-popup-action').css('display','none').remove();
    }
}

function wdhChangeLanguage(){
    // Change Language
    window.wdhSVWELanguage = $jWDH('#wdh-swve-select-language').val();
    
    $jWDH("body").wdhPopupJS({"message": window.TXT_RCM_LANGUAGE_SAVE,
                              "functionLoading": 'wdhChangeLanguageSave',
                              "sendData": '{"language": "'+window.wdhSVWELanguage+'"}',
                              "view": "loading",
                              "reset": true
    });
}

function wdhChangeLanguageSave(sendData){
    
    if(window.WDH_DEFAULT_DEMO_MODE === 'false') {
        // Change Language
        window.wdhSVWELanguage = $jWDH('#wdh-swve-select-language').val();
        $jWDH.post(ajaxurl,{action:'wdh_svwe_change_language',
                            language: sendData["language"]}, function(data){

            if (data === 'success') {
                window.location.href = location.href;
            }

        });
    } else {
        alert('Sorry in DEMO version you can\'t change the language. You can use it only in english.');
        // Hide Popup
        $jWDH('#wdh-popup-body-bg-id').css('display','none').remove();
        $jWDH('.wdh-popup-action').css('display','none').remove();
    }
}

function wdhChangePath(){
    var element = window.elementSelectNowIs;
    window.wdhSVWECurrentPath = $jWDH('#wdh-swve-select-path').val();
    
    // Remove Selected Element
    var currentElementTag       = window.wdhSVWESelectedElementJS.getDomTag(),
        currentElementContainer = window.wdhSVWESelectedElementJS.parent();
    
    if(window.wdhSVWECurrentPath !== 'tags_all'){
        $jWDH(currentElementTag).removeClass('wdh-svwe-element-is-selected-second');
    }
    
    // Select Element(s)
    
    // Classes
    if(window.wdhSVWECurrentPath.indexOf('class.') !== -1) {
        $jWDH('.'+window.wdhSVWECurrentPath.split('class.')[1]).addClass('wdh-svwe-element-is-selected-second');
    }
    
    // Full & ID
    if(window.wdhSVWECurrentPath === 'full' || window.wdhSVWECurrentPath === 'id'){
        window.wdhSVWESelectedElementJS.addClass('wdh-svwe-element-is-selected');
    }
    
    // Tags Container
    if(window.wdhSVWECurrentPath === 'tags_container'){
        $jWDH(currentElementTag, currentElementContainer).addClass('wdh-svwe-element-is-selected-second');
    }
    
    // Tags All
    if(window.wdhSVWECurrentPath === 'tags_all'){
        $jWDH(currentElementTag).addClass('wdh-svwe-element-is-selected-second');
    }
    
    // Hide Popup
    $jWDH('#wdh-popup-body-bg-id').css('display','none');
    $jWDH('.wdh-popup-action').css('display','none');
}

function wdhPublishFor(){
    var publishFor = $jWDH('#wdh-swve-select-publish-for').val(),
        publishRole = $jWDH('#wdh-swve-select-publish-role').val();
    $jWDH("body").wdhPopupJS({"message": window.TXT_EM_PUBLISH_FOR_SAVING,
                              "functionLoading": 'wdhPublishForSave',
                              "sendData": '{"publishFor": "'+publishFor+'","publishRole": "'+publishRole+'"}',
                              "view": "loading",
                              "reset": true
    });
}

function wdhPublishForSave(sendData){
    
    if(window.WDH_DEFAULT_DEMO_MODE === 'false') {
        // Publish Design
        $jWDH.post(ajaxurl,{action:'wdh_svwe_publish',
                            wdhPageUrl: window.location.href,
                            wdhPublishFor: sendData["publishFor"],
                            wdhPageOn: window.wdhSVWEPageIsOn,
                            wdhRole: window.wdhSVWERole}, function(data){

            if (data === 'success') {
                window.wdhSVWEChanges = 0;
                $jWDH("body").wdhPopupJS({"message": window.TXT_EM_PUBLISH_FOR_SAVED,
                                          "view": "success",
                                          "reset": true
                });
            }

            if ($jWDH.trim(data) === '') {
                alert(window.TXT_EM_PUBLISH_NO_CHANGES);
                $jWDH('.wdh-popup-body-bg').css('display','none').remove();
                $jWDH('.wdh-popup-action').css('display','none').remove();
            }

        });
    
    } else {
        alert('Sorry in DEMO version you can\'t save the changes.');
        // Hide Popup
        $jWDH('#wdh-popup-body-bg-id').css('display','none').remove();
        $jWDH('.wdh-popup-action').css('display','none').remove();
    }
}

function wdhRemover(text){
    var htmlElements = window.wdhSVWETags,
        htmlElementPrefix = window.wdhSVWETagPrefix;

    // Remove Tags
    $jWDH.each(htmlElements, function(index, value){
        text = text.replace(new RegExp('.'+htmlElementPrefix+'-'+value, 'g'), '');      // text = text.replace(new RegExp('.wdh-h', 'g'), '');
    });
    
    text = text.replace(new RegExp('.wdh-editable', 'g'), '');
    text = text.replace(new RegExp('.ui-resizable', 'g'), '');
    text = text.replace(new RegExp('.ui-sortable', 'g'), '');
    text = text.replace(new RegExp('.ui-sortable-handle', 'g'), '');
    text = text.replace(new RegExp('.wdh-svwe-element-added-hover-color', 'g'), '');
    text = text.replace(new RegExp('.wdh-svwe-element-added-hover', 'g'), '');
    text = text.replace(new RegExp('.wdh-svwe-element-added', 'g'), '');
    text = text.replace(new RegExp('-handle', 'g'), '');
    text = text.replace(new RegExp('.wdh-svwe-element-selected', 'g'), '');
    text = text.replace(new RegExp('.wdh-svwe-element-is-selected', 'g'), '');
    
    return text;
}

function css(element) {
    
    if (element.css('max-height') === 'none'){
        var maxHeight = element.css('height');
    } else {
        var maxHeight = element.css('max-height');
    }
    
    var currentMaxWidth = element.css('max-width');
    
    if (currentMaxWidth < element.css('width') && currentMaxWidth.indexOf('%') === false || currentMaxWidth === 'none'){
        var maxWidth = element.css('width');
    } else {
        var maxWidth = element.css('max-width');
    }
    
    var fontFamily = element.css('font-family').replace(new RegExp("'", 'g'),''),
        lineHeight = element.css('line-height');

    if (lineHeight !== 'normal'){
        lineHeight = (Math.round(parseFloat(lineHeight) * 100) / 100)+'px';
    }
    
    var wdhBackgroundImage = element.css('background-image');
    
    if (wdhBackgroundImage.indexOf('wdhsvwe/uploads/images/') !== -1) {
        wdhBackgroundImage = wdhBackgroundImage.split('wdhsvwe/uploads/images/')[1];
        wdhBackgroundImage = wdhBackgroundImage.replace(/\(|\)/g, '');
    }
    
    if(wdhBackgroundImage === 'none'){
        wdhBackgroundImage = '';
    }

    var o = {
        'fontSize': element.css('font-size'),
        'color': element.css('color'),
        'fontWeight': element.css('font-weight'),
        'fontFamily': fontFamily,
        'fontStyle': element.css('font-style'),
        'fontVariant': element.css('font-variant'),
        'LineHeight': lineHeight,
        'FontAlign': element.css('text-align'),
        'TextDecoration': element.css('text-decoration'),
        'TextTransform': element.css('text-transform'),
        'LetterSpacing': element.css('letter-spacing'),
        'WordSpacing': element.css('word-spacing'),
        'VerticalAlign': element.css('vertical-align'),
        'WhiteSpace': element.css('white-space'),
        'BackgroundColor': element.css('background-color'),
        'Width': element.css('width'),
        'Height': '', //element.css('height')
        'BackgroundSize': element.css('background-size'),
        'BackgroundImage': wdhBackgroundImage,
        'BackgroundPositionX': element.css('background-position-x'),
        'BackgroundPositionY': element.css('background-position-y'),
        'BackgroundRepeat': element.css('background-repeat'),
        'PaddingTop': element.css('padding-top'),
        'PaddingBottom': element.css('padding-bottom'),
        'PaddingLeft': element.css('padding-left'),
        'PaddingRight': element.css('padding-right'),
        'MarginTop': element.css('margin-top'),
        'MarginBottom': element.css('margin-bottom'),
        'MarginLeft': element.css('margin-left'),
        'MarginRight': element.css('margin-right'),
        'Border': element.css('border'),
        'BorderColor': element.css('border-color'),
        'BorderRadius': element.css('border-radius'),
        'Outline': element.css('outline'),
        'OutlineColor': element.css('outline-color'),
        'Position': element.css('position'),
        'Top': element.css('top'),
        'Bottom': element.css('bottom'),
        'Left': element.css('left'),
        'Right': element.css('right'),
        'Overflow': element.css('overflow'),
        'ZIndex': element.css('z-index'),
        'Float': element.css('float'),
        'Clear': element.css('clear'),
        'Display': element.css('display'),
        'Visibility': element.css('visibility'),
        'ListStyle': element.css('list-style'),
        'TableLayout': element.css('table-layout'),
        'BorderCollapse': element.css('border-collapse'),
        'BorderSpacing': element.css('border-spacing'),
        'CaptionSide': element.css('caption-side'),
        'Content': element.css('content'),
        'PageBreakBefore': element.css('page-break-before'),
        'PageBreakAfter': element.css('page-break-after'),
        'PageBreakInside': element.css('page-break-inside'),
        'Orfans': element.css('orphans'),
        'Windows': element.css('widows'),
        'Cursor': element.css('cursor'),
        'Direction': element.css('direction'),
        'BorderTop': element.css('border-top'),
        'BorderBottom': element.css('border-bottom'),
        'BorderLeft': element.css('border-left'),
        'BorderRight': element.css('border-right'),
        'BorderTopColor': element.css('border-top-color'),
        'BorderBottomColor': element.css('border-bottom-color'),
        'BorderLeftColor': element.css('border-left-color'),
        'BorderRightColor': element.css('border-right-color'),
        'BorderTopLeftRadius': element.css('border-top-left-radius'),
        'BorderTopRightRadius': element.css('border-top-right-radius'),
        'BorderBottomLeftRadius': element.css('border-bottom-left-radius'),
        'BorderBottomRightRadius': element.css('border-bottom-right-radius'),
        'MinWidth': element.css('min-width'),
        'MaxWidth': '',
        'MinHeight': '', // element.css('min-height')
        'MaxHeight': '', // maxHeight
        'ListStyleType': element.css('list-style-type'),
        'ListStylePosition': element.css('list-style-position'),
        'ListStyleImage': element.css('list-style-image')
     };
     
    return o;
}

function cssPaste(element,elementTo) {
    var lineHeight = element.css('line-height');

    if (lineHeight !== 'normal'){
        lineHeight = (Math.round(parseFloat(lineHeight) * 100) / 100)+'px';
    }
    
    var currentMaxWidth = element.css('max-width');
    
    if (currentMaxWidth < element.css('width') && currentMaxWidth.indexOf('%') === false || currentMaxWidth === 'none'){
        var maxWidth = element.css('width');
    } else {
        var maxWidth = element.css('max-width');
    }
    
    $jWDH(elementTo).css('font-size', element.css('font-size'));
    $jWDH(elementTo).css('color', element.css('color'));
    $jWDH(elementTo).css('font-weight', element.css('font-weight'));
    $jWDH(elementTo).css('font-family', element.css('font-family'));
    $jWDH(elementTo).css('font-style', element.css('font-style'));
    $jWDH(elementTo).css('font-variant', element.css('font-variant'));
    $jWDH(elementTo).css('line-height', lineHeight);
    $jWDH(elementTo).css('text-align', element.css('text-align'));
    $jWDH(elementTo).css('text-decoration', element.css('text-decoration'));
    $jWDH(elementTo).css('text-transform', element.css('text-transform'));
    $jWDH(elementTo).css('letter-spacing', element.css('letter-spacing'));
    $jWDH(elementTo).css('word-spacing', element.css('word-spacing'));
    $jWDH(elementTo).css('vertical-align', element.css('vertical-align'));
    $jWDH(elementTo).css('white-space', element.css('white-space'));
    $jWDH(elementTo).css('background-color', element.css('background-color'));
    $jWDH(elementTo).css('width', element.css('width'));
//    $jWDH(elementTo).css('height', element.css('height'));
    $jWDH(elementTo).css('background-image', element.css('background-image'));
    $jWDH(elementTo).css('background-size', element.css('background-size'));
    $jWDH(elementTo).css('background-position-x', element.css('background-position-x'));
    $jWDH(elementTo).css('background-position-y', element.css('background-position-y'));
    $jWDH(elementTo).css('background-repeat', element.css('background-repeat'));
    $jWDH(elementTo).css('padding-top', element.css('padding-top'));
    $jWDH(elementTo).css('padding-bottom', element.css('padding-bottom'));
    $jWDH(elementTo).css('padding-left', element.css('padding-left'));
    $jWDH(elementTo).css('padding-right', element.css('padding-right'));
    $jWDH(elementTo).css('margin-top', element.css('margin-top'));
    $jWDH(elementTo).css('margin-bottom', element.css('margin-bottom'));
    $jWDH(elementTo).css('margin-left', element.css('margin-left'));
    $jWDH(elementTo).css('margin-right', element.css('margin-right'));
    $jWDH(elementTo).css('border', element.css('border'));
    $jWDH(elementTo).css('border-color', element.css('border-color'));
    $jWDH(elementTo).css('border-radius', element.css('border-radius'));
    $jWDH(elementTo).css('outline', element.css('outline'));
    $jWDH(elementTo).css('outline-color', element.css('outline-color'));
    $jWDH(elementTo).css('position', element.css('position'));
    $jWDH(elementTo).css('top', element.css('top'));
    $jWDH(elementTo).css('bottom', element.css('bottom'));
    $jWDH(elementTo).css('left', element.css('left'));
    $jWDH(elementTo).css('right', element.css('right'));
    $jWDH(elementTo).css('overflow', element.css('overflow'));
    $jWDH(elementTo).css('z-index', element.css('z-index'));
    $jWDH(elementTo).css('float', element.css('float'));
    $jWDH(elementTo).css('clear', element.css('clear'));
    $jWDH(elementTo).css('display', element.css('display'));
    $jWDH(elementTo).css('visibility', element.css('visibility'));
    $jWDH(elementTo).css('list-style', element.css('list-style'));
    $jWDH(elementTo).css('table-layout', element.css('table-layout'));
    $jWDH(elementTo).css('border-collapse', element.css('border-collapse'));
    $jWDH(elementTo).css('border-spacing', element.css('border-spacing'));
    $jWDH(elementTo).css('caption-side', element.css('caption-side'));
    $jWDH(elementTo).css('content', element.css('content'));
    $jWDH(elementTo).css('page-break-before', element.css('page-break-before'));
    $jWDH(elementTo).css('page-break-after', element.css('page-break-after'));
    $jWDH(elementTo).css('page-break-inside', element.css('page-break-inside'));
    $jWDH(elementTo).css('orfans', element.css('orfans'));
    $jWDH(elementTo).css('windows', element.css('windows'));
    $jWDH(elementTo).css('cursor', element.css('cursor'));
    $jWDH(elementTo).css('direction', element.css('direction'));
    $jWDH(elementTo).css('border-top', element.css('border-top'));
    $jWDH(elementTo).css('border-bottom', element.css('border-bottom'));
    $jWDH(elementTo).css('border-left', element.css('border-left'));
    $jWDH(elementTo).css('border-right', element.css('border-right'));
    $jWDH(elementTo).css('border-top-color', element.css('border-top-color'));
    $jWDH(elementTo).css('border-bottom-color', element.css('border-bottom-color'));
    $jWDH(elementTo).css('border-left-color', element.css('border-left-color'));
    $jWDH(elementTo).css('border-right-color', element.css('border-right-color'));
    $jWDH(elementTo).css('border-top-left-radius', element.css('border-top-left-radius'));
    $jWDH(elementTo).css('border-top-right-radius', element.css('border-top-right-radius'));
    $jWDH(elementTo).css('border-bottom-left-radius', element.css('border-bottom-left-radius'));
    $jWDH(elementTo).css('border-top-right-radius', element.css('border-top-right-radius'));
    $jWDH(elementTo).css('min-width', element.css('min-width'));
//    $jWDH(elementTo).css('max-width', maxWidth);
    $jWDH(elementTo).css('min-height', element.css('min-height'));
//    $jWDH(elementTo).css('max-height', element.css('max-height'));
    $jWDH(elementTo).css('list-style-type', element.css('list-style-type'));
    $jWDH(elementTo).css('list-style-position', element.css('list-style-position'));
    $jWDH(elementTo).css('list-style-image', element.css('list-style-image'));
}

function wdhPasteDesign(sendData){
    // Appliyng CSS Design
    cssPaste(window.elementCopiedIs,window.elementSelectNowIs);
    
    if (window.WDH_DEFAULT_DEMO_MODE === 'false') {
        // Saving Design
        $jWDH.post(ajaxurl,{action:'wdh_svwe_paste',
                            wdhPath: sendData['wdhPath'],
                            domPath: sendData['domPath'].replace(new RegExp(' > div.ui-wrapper:nth-child(1)', 'g'), ''),
                            wdhID: sendData['wdhID'],
                            wdhClass: sendData['wdhClass'],
                            wdhAllCSS: sendData['wdhAllCSS'],
                            elementTag: sendData['elementTag'],
                            elementPosition: sendData['elementPosition'],
                            resolution: sendData['resolution'],
                            wdhPageUrl: window.location.href,
                            wdhPageOn: window.wdhSVWEPageIsOn,
                            wdhRole: window.wdhSVWERole,
                            selectedPath: sendData['selectedPath']}, function(data){

            if (data === 'success') {
                window.wdhSVWEChanges++;
                $jWDH('.wdh-publish').removeClass('wdh-disabled');
                $jWDH("body").wdhPopupJS({"message": window.TXT_PM_PASTE_SAVED,
                                          "view": "success",
                                          "reset": true
                });
                var editor = window.wdhSVWEEditor;
                    editor.changeElement(window.wdhSVWESelectedElement);
            }

        });
    
    } else {
        // Hide Popup
        $jWDH('#wdh-popup-body-bg-id').css('display','none').remove();
        $jWDH('.wdh-popup-action').css('display','none').remove();
    }
}

function wdhRollBackChange(){
    var currentValue = $jWDH('#wdh-swve-select-rollback-for').val();

    if (currentValue === 'website') {
        $jWDH('#wdh-swve-select-rollback-at-website').parent().css('display','block');
        $jWDH('#wdh-swve-select-rollback-at-current-page').parent().css('display','none');
    } else {
        $jWDH('#wdh-swve-select-rollback-at-website').parent().css('display','none');
        $jWDH('#wdh-swve-select-rollback-at-current-page').parent().css('display','block');
    }
}

function wdhRollBack(){
    var rollBackAt = '',
        wdhRollBackFor = $jWDH('#wdh-swve-select-rollback-for').val();
    
    if (wdhRollBackFor === 'website') {
        rollBackAt = $jWDH('#wdh-swve-select-rollback-at-website').val();
    } else {
        rollBackAt = $jWDH('#wdh-swve-select-rollback-at-current-page').val();
    }
    
    $jWDH("body").wdhPopupJS({"message": window.TXT_EM_ROLLBACK_SAVING,
                              "functionLoading": 'wdhRollBackSave',
                              "sendData": '{"wdhRollBackFor": "'+wdhRollBackFor+'", "wdhRollBackAt": "'+rollBackAt+'"}',
                              "view": "loading",
                              "reset": true
    });
}

function wdhRollBackSave(sendData){
    
    if (window.WDH_DEFAULT_DEMO_MODE === 'false') {
        // RollBack Design
        $jWDH.post(ajaxurl,{action:'wdh_svwe_roll_back',
                            wdhPageUrl: window.location.href,
                            wdhPageOn: window.wdhSVWEPageIsOn,
                            wdhRole: window.wdhSVWERole,
                            wdhRollBackFor: sendData['wdhRollBackFor'],
                            wdhRollBackAt: sendData['wdhRollBackAt']}, function(data){

            if (data === 'success') {
                $jWDH("body").wdhPopupJS({"message": window.TXT_EM_ROLLBACK_SAVED,
                                          "view": "success",
                                          "reset": true
                });
    //            $jWDH('body').removeAttr('onbeforeunload');
                window.location = window.location.pathname;
            }

        });
    
    } else {
        alert('Sorry in DEMO version you can\'t use this option.');
        // Hide Popup
        $jWDH('#wdh-popup-body-bg-id').css('display','none').remove();
        $jWDH('.wdh-popup-action').css('display','none').remove();
    }
}

function wdhDeleteDesignTypeChange(){
    var currentValue = $jWDH('#wdh-swve-select-delete-design-type').val();

    if (currentValue === 'saved') {
        $jWDH('#wdh-swve-select-delete-design-for').parent().css('display','block');
        
        if ($jWDH('#wdh-swve-select-delete-design-for').val() === 'website') {
            $jWDH('#wdh-swve-select-delete-design-at-website').parent().css('display','block');
            $jWDH('#wdh-swve-select-delete-design-at-current-page').parent().css('display','none');
        } else {
            $jWDH('#wdh-swve-select-delete-design-at-website').parent().css('display','none');
            $jWDH('#wdh-swve-select-delete-design-at-current-page').parent().css('display','block');
        }
    } else {
        $jWDH('#wdh-swve-select-delete-design-for').parent().css('display','none');
        $jWDH('#wdh-swve-select-delete-design-at-website').parent().css('display','none');
        $jWDH('#wdh-swve-select-delete-design-at-current-page').parent().css('display','none');
    }
}
function wdhDeleteDesignForChange(){
    
    if ($jWDH('#wdh-swve-select-delete-design-for').val() === 'website') {
        $jWDH('#wdh-swve-select-delete-design-at-website').parent().css('display','block');
        $jWDH('#wdh-swve-select-delete-design-at-current-page').parent().css('display','none');
    } else {
        $jWDH('#wdh-swve-select-delete-design-at-website').parent().css('display','none');
        $jWDH('#wdh-swve-select-delete-design-at-current-page').parent().css('display','block');
    }
}

function wdhDeleteDesign(){
    var deleteDesignAt = '',
        deleteDesignType = $jWDH('#wdh-swve-select-delete-design-type').val(),
        deleteDesignFor = $jWDH('#wdh-swve-select-delete-design-for').val();
    
    if (deleteDesignFor === 'website') {
        deleteDesignAt = $jWDH('#wdh-swve-select-delete-design-at-website').val();
    } else {
        deleteDesignAt = $jWDH('#wdh-swve-select-delete-design-at-current-page').val();
    }
    
    $jWDH("body").wdhPopupJS({"message": window.TXT_EM_DELETE_SAVING,
                              "functionLoading": 'wdhDeleteDesignSave',
                              "sendData": '{"deleteDesignType": "'+deleteDesignType+'", "deleteDesignFor": "'+deleteDesignFor+'", "deleteDesignAt": "'+deleteDesignAt+'"}',
                              "view": "loading",
                              "reset": true
    });
}

function wdhDeleteDesignSave(sendData){
    
    if (window.WDH_DEFAULT_DEMO_MODE === 'false') {
        // Delete Design
        $jWDH.post(ajaxurl,{action:'wdh_svwe_delete',
                            wdhPageUrl: window.location.href,
                            wdhPageOn: window.wdhSVWEPageIsOn,
                            wdhRole: window.wdhSVWERole,
                            deleteDesignType: sendData['deleteDesignType'],
                            deleteDesignFor: sendData['deleteDesignFor'],
                            deleteDesignAt: sendData['deleteDesignAt']}, function(data){

            if (data === 'success') {
                $jWDH("body").wdhPopupJS({"message": window.TXT_EM_DELETE_SAVED,
                                          "view": "success",
                                          "reset": true
                });
    //            $jWDH('body').removeAttr('onbeforeunload');
                window.location = window.location.pathname;
            }

        });
    
    } else {
        alert('Sorry in DEMO version you can\'t delete changes.');
        // Hide Popup
        $jWDH('#wdh-popup-body-bg-id').css('display','none').remove();
        $jWDH('.wdh-popup-action').css('display','none').remove();
    }
}

function wdhChangeSettings(){
    window.wdhSVWESettingsResizeWidth  = $jWDH('#wdh-swve-select-settings-resize-width').val();
    window.wdhSVWESettingsResizeHeight = $jWDH('#wdh-swve-select-settings-resize-height').val();
    
    // Close Popup
    $jWDH('.wdh-popup-body-bg').fadeOut(500).remove();
    $jWDH('.wdh-popup-action').fadeOut(500).remove();
}

function wdhLogout(){
    var editor = window.wdhSVWEEditor;
    editor.stopRightClickMenu();
    
    $jWDH.post(ajaxurl,{action: 'wdh_svwe_logout',
                        logout: true}, function(data){
                            
         if(data === 'success') {
            window.location.href = location.href;
         }
    });
}

function css2json(css) {
    var s = {};
    if (!css) return s;
    if (css instanceof CSSStyleDeclaration) {
        for (var i in css) {
            if ((css[i]).toLowerCase) {
                s[(css[i]).toLowerCase()] = (css[css[i]]);
            }
        }
    } else if (typeof css === "string") {
        css = css.split("; ");
        for (var i in css) {
            var l = css[i].split(": ");
            s[l[0].toLowerCase()] = (l[1]);
        }
    }
    return s;
}

function wdhExit(){
    return window.TXT_GENERAL_EXIT; 
}