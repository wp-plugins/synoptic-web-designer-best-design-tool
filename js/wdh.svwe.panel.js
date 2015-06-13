/* -------------------------------------------------------------------
 * Project Name: WDH - Panel JSON
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/panel-json/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: js/wdh.svwe.panel.js
 * File Description: Panel JSON File
 * File Version: 1.0
 * Last Update File : 22.09.2014
 * ------------------------------------------------------------------- 
 */

var $jWDH = jQuery.noConflict(),
    ajaxurl = window.ajaxurl;

$jWDH.fn.extend({
    
    wdhPanelJS:function (options){
        var id = $jWDH(this)['selector'],
            defaultOptions = {'normaltext': window.TXT_PM_NORMAL,
                              'hovertext': window.TXT_PM_HOVER,
                              'textSettings': {'text':window.TXT_PM_TEXT_SETTINGS,
                                               'icon':window.ICON_PM_TEXT_SETTINGS,
                                               'id':'wdh-svwe-panel-group-text'},
                              'boxSettings': {'text':window.TXT_PM_BOX_SETTINGS,
                                              'icon':window.ICON_PM_BOX_SETTINGS,
                                              'id':'wdh-svwe-panel-group-box'},
                              'extraSettings': window.WDH_SVWE_EXTRA_GROUPS,
                              'label1': 'Option 1',
                              'label2': 'Option 2',
                              'advancedsettings': 'Advanced Settings',
                              'wdhPath': '',
                              'domPath': '',
                              'wdhID': '',
                              'wdhRole': '',
                              'wdhAllCSS': {},
                              'wdhPageUrl': '',
                              'elementTag': '',
                              'elementPosition': '',
                              'wdhClass': '',
                              'resolution': 'all',
                              'selectedPath': 'full'
                              },    
            
           
        panel = {
            start: function(){
                // Add Properties
                panel.properties();
                
                // Generating Panel
                if (typeof $jWDH(id).find('.wdh-panel').eq(0).html() === 'undefined') {
                    // Show form
                    panel.view();
                    // Adding Events
                    panel.events();
                }
                
                // Show form
                panel.open('text-settings');
            },
                    
            events: function(){
                // Normal/Hover Settings
                $jWDH('.wdh-panel-top-setting').click(function() { 
                    
                    if ($jWDH(this).hasClass('wdh-normal-settings-button') === true) {
                        $jWDH('.wdh-hover-settings').css('display','block'); 
                        $jWDH('.wdh-panel-top-setting').removeClass('setting-selected'); 
                        $jWDH(this).addClass('setting-selected'); 
                        $jWDH('.wdh-normal-settings').css('display','none');
                        $jWDH('#wdh-panel-category-settings').val('normal');
                        panel.openSection('normal', $jWDH('#wdh-panel-type-settings').val(), $jWDH('#wdh-panel-subtype-settings').val());
                    } else {
                        $jWDH('.wdh-normal-settings').css('display','block !important'); 
                        $jWDH('.wdh-panel-top-setting').removeClass('setting-selected'); 
                        $jWDH(this).addClass('setting-selected'); 
                        $jWDH('.wdh-hover-settings').css('display','none'); 
                        $jWDH('#wdh-panel-category-settings').val('hover');
                        panel.openSection('hover', $jWDH('#wdh-panel-type-settings').val(), $jWDH('#wdh-panel-subtype-settings').val());
                    }
                });
                
                // Switch Panel Position
                $jWDH('.wdh-left-right').click(function() { 
                    
                    if ($jWDH('.wdh-panel' ).hasClass('wdh-move')) { 
                        $jWDH('.wdh-panel').removeClass('wdh-move');
                    } else{
                        $jWDH('.wdh-panel').addClass('wdh-move');
                    }
                });  
                
                // Close Panel
                $jWDH('.wdh-panel-top-x').click(function() { 
                    $jWDH('.wdh-panel').animate({'bottom':'-2001px'}, 300);
                });
                
                // Switch Panel
                $jWDH('.wdh-elemnt-type').click(function() { 
                    $jWDH('.wdh-elemnt-type').removeClass('element-type-selected'); 
                    $jWDH(this).addClass('element-type-selected');
                    
                    var group = $jWDH(this).attr('id').split('wdh-svwe-panel-group-')[1];
                    
                    $jWDH('#wdh-panel-subtype-settings').val(group);
                    panel.openSection($jWDH('#wdh-panel-category-settings').val(), $jWDH('#wdh-panel-type-settings').val(), $jWDH('#wdh-panel-subtype-settings').val());
                });
                
                // Search
                $jWDH('.wdh-search-input').unbind('change keyup input');
                $jWDH('.wdh-search-input').bind('change keyup input',function() { 
                    
                    var elementsSettings = $jWDH('#wdh-settings-id li label'),
                        elementsNo = elementsSettings.length;
                        
                    if($jWDH(this).val().length > 0) {
                        $jWDH('#wdh-settings-id li').css('display','none');
                        
                        for(var i = 0; i<=elementsNo; i++) {
                            var textFind = elementsSettings.eq(i).text().toLowerCase(),
                                textToFind = $jWDH(this).val().toLowerCase();
                                
                            if (textFind.indexOf(textToFind) !== -1) {
                                elementsSettings.eq(i).parent().css('display','block');
                            }
                        }
                    } else {
                        var category = $jWDH('#wdh-panel-category-settings').val(),
                            type = $jWDH('#wdh-panel-type-settings').val(),
                            subtype = $jWDH('#wdh-panel-subtype-settings').val();
                            
                        // Display All existing
                        $jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).css('display','block');
                    }
                });
                
                // Hide All Tooltips
                $jWDH('.wdh-svwe-tooltip').css('display','none');

                // Add Tooltip
                $jWDH('.wdh-use-tooltip').hover(function(){
                    $jWDH('.wdh-svwe-tooltip').css('display','block');
                    $jWDH(this).find('.wdh-svwe-information').fadeIn(300);
                },
                function(){
                    $jWDH('.wdh-svwe-tooltip').css('display','none');
                    $jWDH(this).find('.wdh-svwe-information').fadeOut(100);
                });
                
                // Panel Settings Events
                panel.settingsEvents();
            },
            
            settingsEvents: function(){
                // Switch To Advanced Settings
                $jWDH('.wdh-set-advanced-settings').unbind('click');
                $jWDH('.wdh-set-advanced-settings').bind('click',function() {
                    // Change Button
                    $jWDH(this).removeClass('wdh-set-advanced-settings');
                    $jWDH(this).addClass('wdh-set-general-settings');
                    // Change Tooltip Text
                    $jWDH(this).find('.wdh-svwe-information').eq(0).html(window.TXT_PM_GENERAL_SETTINGS);
                    // Change type
                    $jWDH('#wdh-panel-type-settings').val('advanced');
                    panel.openSection($jWDH('#wdh-panel-category-settings').val(), 'advanced', $jWDH('#wdh-panel-subtype-settings').val());
                    
                    // Panel Settings Events
                    panel.settingsEvents();
                });
                
                // Switch To General Settings
                $jWDH('.wdh-set-general-settings').unbind('click');
                $jWDH('.wdh-set-general-settings').bind('click',function() {
                    // Change Button
                    $jWDH(this).removeClass('wdh-set-general-settings');
                    $jWDH(this).addClass('wdh-set-advanced-settings');
                    // Change Tooltip Text
                    $jWDH(this).find('.wdh-svwe-information').eq(0).html(window.TXT_PM_ADVANCED_SETTINGS);
                    // Change type
                    $jWDH('#wdh-panel-type-settings').val('general');
                    panel.openSection($jWDH('#wdh-panel-category-settings').val(), 'general', $jWDH('#wdh-panel-subtype-settings').val());
                    
                    // Panel Settings Events
                    panel.settingsEvents();
                });
            },
                    
            properties: function(){
                
                if (typeof options !== 'undefined'){
                    $jWDH.extend(defaultOptions,options);
                }
            }, 
                    
            tooltip: function(){
                // Add Tooltip
                $jWDH('.wdh-tooltip').hover(function(){
                    var html = $jWDH(this).find('.wdh-information').html(),
                        width = $jWDH(this).find('.wdh-information').wdhTextWidth(html);
                    $jWDH(this).find('.wdh-information').css('width',width);
                    $jWDH(this).find('.wdh-information').fadeIn(300);

                },
                function(){
                    $jWDH(this).find('.wdh-information').fadeOut(100);
                });
            },
                    
            open: function(step){
        
                // Open Panel
                $jWDH('#wdh-panel').animate({
                    'bottom':'0px'
                },600);
                
                var category = $jWDH('#wdh-panel-category-settings').val(),
                    type = $jWDH('#wdh-panel-type-settings').val(),
                    subtype = $jWDH('#wdh-panel-subtype-settings').val();
                
                if(typeof $jWDH('.wdh-loader-in-progress-'+category+'-'+type+'-'+subtype).eq(0).html() === 'undefined') {
                    
                    // Remove All existing
                    $jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).remove();
                    
                    // Select Text Settings
                    $jWDH('.wdh-elemnt-type').removeClass('element-type-selected');
                    $jWDH('.wdh-elemnt-type').eq(0).addClass('element-type-selected');
                    // Loader in progress
                    $jWDH('#wdh-settings-id .wdh-settings-loader').addClass('wdh-loader-in-progress-'+category+'-'+type+'-'+subtype);
                    
                    if(typeof $jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).eq(0).html() === 'undefined') {
                        // Loader
                        $jWDH('#wdh-settings-id .wdh-settings-loader').css('display','block');
                        // Remove All existing
                        $jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).remove();

                        // Load Settings
                        $jWDH.post(ajaxurl,{action: 'wdh_svwe_display_panel',
                                            category: $jWDH('#wdh-panel-category-settings').val(),
                                            type: $jWDH('#wdh-panel-type-settings').val(),
                                            subtype: $jWDH('#wdh-panel-subtype-settings').val(),
                                            loadstep: step,
                                            wdhPath: defaultOptions['wdhPath'],
                                            domPath: defaultOptions['domPath'],
                                            wdhID: defaultOptions['wdhID'],
                                            wdhAllCSS: defaultOptions['wdhAllCSS'],
                                            wdhPageUrl: defaultOptions['wdhPageUrl'],
                                            wdhPageOn: window.wdhSVWEPageIsOn,
                                            wdhRole: window.wdhSVWERole,
                                            elementTag: defaultOptions['elementTag'],
                                            elementPosition: defaultOptions['elementPosition'],
                                            wdhClass: defaultOptions['wdhClass'],
                                            resolution: defaultOptions['resolution'],
                                            selectedPath: defaultOptions['selectedPath']
                                            }, function(data){
                            // Show Settings
                            $jWDH('#wdh-settings-id').append(data);
                            // Adding Tooltip
                            panel.tooltip();
                            
                            // Display All
                            $jWDH('#wdh-settings-id li').css('display','none');
                            $jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).css('display','block');
                            
                            // Remove Load in progress
                            $jWDH('#wdh-settings-id .wdh-settings-loader').removeClass('wdh-loader-in-progress-'+category+'-'+type+'-'+subtype);
                            // Open In Background
                            //panel.openInBackground('normal', 'advanced', 'text');

                        });
                    } else {
                        // Display All
                        $jWDH('#wdh-settings-id li').css('display','none');
                        $jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).css('display','block');
                    }
                } else {
                    // Display All
                    $jWDH('#wdh-settings-id li').css('display','none');
                    $jWDH('#wdh-settings-id .wdh-settings-loader').removeClass('wdh-loader-in-progress-'+category+'-'+type+'-'+subtype);
                    $jWDH('#wdh-settings-id .wdh-settings-loader').css('display','block');
                }
            }, 
            
            openInBackground: function(category, type, subtype){
        
                // Open Panel
                $jWDH('#wdh-panel').animate({
                    'bottom':'0px'
                },600);
                
                var loadStep = '',
                    nextCategory = category,
                    nextType = type,
                    nextSubtype = subtype;
                
                if(typeof $jWDH('.wdh-loader-in-progress-'+category+'-'+type+'-'+subtype).eq(0).html() === 'undefined') {
                
                    // Loader in progress
                    $jWDH('#wdh-settings-id .wdh-settings-loader').addClass('wdh-loader-in-progress-'+category+'-'+type+'-'+subtype);

                    if(typeof $jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).eq(0).html() === 'undefined') {

                        if(category+'-'+type+'-'+subtype === 'normal-general-text' || category+'-'+type+'-'+subtype === 'hover-general-text'){
                            loadStep = 'text-settings';
                            
                            if (category+'-'+type+'-'+subtype === 'normal-text-general') {
                                nextCategory = 'normal';
                                nextType = 'advanced';
                                nextSubtype = 'text';
                            } else {
                                nextCategory = 'hover';
                                nextType = 'advanced';
                                nextSubtype = 'text';
                            }
                        } else if(category+'-'+type+'-'+subtype === 'normal-advanced-text' || category+'-'+type+'-'+subtype === 'hover-advanced-text'){
                            loadStep = 'advanced-text-settings';
                            
                            if (category+'-'+type+'-'+subtype === 'normal-advanced-text') {
                                nextCategory = 'normal';
                                nextType = 'general';
                                nextSubtype = 'box';
                            } else {
                                nextCategory = 'hover';
                                nextType = 'general';
                                nextSubtype = 'box';
                            }
                        } else if(category+'-'+type+'-'+subtype === 'normal-general-box' || category+'-'+type+'-'+subtype === 'hover-general-box'){
                            loadStep = 'box-settings';
                            
                            if (category+'-'+type+'-'+subtype === 'normal-general-box') {
                                nextCategory = 'normal';
                                nextType = 'advanced';
                                nextSubtype = 'box';
                            } else {
                                nextCategory = 'hover';
                                nextType = 'advanced';
                                nextSubtype = 'box';
                            }
                        } else if(category+'-'+type+'-'+subtype === 'normal-advanced-box' || category+'-'+type+'-'+subtype === 'hover-advanced-box'){
                            loadStep = 'advanced-box-settings';
                            
                            if (category+'-'+type+'-'+subtype === 'normal-advanced-box') {
                                nextCategory = 'hover';
                                nextType = 'general';
                                nextSubtype = 'text';
                            } else {
                                nextCategory = 'stop';
                                nextType = 'stop';
                                nextSubtype = 'stop';
                            }
                        }
                        
                        // Load Settings
                        $jWDH.post(ajaxurl,{action: 'wdh_svwe_display_panel',
                                            category: category,
                                            type: type,
                                            subtype: subtype,
                                            loadstep: loadStep,
                                            wdhPath: defaultOptions['wdhPath'],
                                            domPath: defaultOptions['domPath'],
                                            wdhID: defaultOptions['wdhID'],
                                            wdhAllCSS: defaultOptions['wdhAllCSS'],
                                            wdhPageUrl: defaultOptions['wdhPageUrl'],
                                            wdhPageOn: window.wdhSVWEPageIsOn,
                                            wdhRole: window.wdhSVWERole,
                                            elementTag: defaultOptions['elementTag'],
                                            elementPosition: defaultOptions['elementPosition'],
                                            wdhClass: defaultOptions['wdhClass'],
                                            resolution: defaultOptions['resolution'],
                                            selectedPath: defaultOptions['selectedPath']
                                            }, function(data){

                            // Show Settings
                            $jWDH('#wdh-settings-id').append(data);
                            // Adding Tooltip
                            panel.tooltip();
                            // Hide All Appended
                            $jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).css('display','none');
                            
                            // Remove Load in progress
                            $jWDH('#wdh-settings-id .wdh-settings-loader').removeClass('wdh-loader-in-progress-'+category+'-'+type+'-'+subtype);
                            // Continue Load in Background
                            if (nextCategory !== 'stop' && nextType !== 'stop' && nextSubtype !== 'stop') {
                                // Open In Background
                                panel.openInBackground(nextCategory, nextType, nextSubtype);
                            }

                        });
                    } else {
                        // Display All
                        $jWDH('#wdh-settings-id li').css('display','none');
                        $jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).css('display','block');
                    }
                } else {
                    // Display Loader
                    $jWDH('#wdh-settings-id li').css('display','none');
                    $jWDH('#wdh-settings-id .wdh-settings-loader').css('display','block');
                }
            },
            
            openSection: function(category, type, subtype){
                var element = window.wdhSVWESelectedElementJS,
                    elementTag = element.getDomTag(),
                    elementPosition = element.getDomPosition()+1,
                    elementSecondPosition = parseInt(elementPosition)+1,
                    wdhPath = element.getDomPath(),
                    domPath = wdhPath,
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
                    
                    if($jWDH(window.elementSelectNowIs).css('animation-duration') === '0s') {
                        $jWDH(window.elementSelectNowIs).css('animation-duration','1s');
                    }
                    
                    defaultOptions['wdhPath']           = wdhPath;
                    defaultOptions['domPath']           = domPath;
                    defaultOptions['wdhID']             = wdhID;
                    defaultOptions['wdhAllCSS']         = wdhAllCSS;
                    defaultOptions['wdhPageUrl']        = wdhPageUrl;
                    defaultOptions['elementTag']        = elementTag;
                    defaultOptions['elementPosition']   = elementPosition;
                    defaultOptions['wdhClass']          = wdhClass;
                    defaultOptions['resolution']        = wdhCurrentResolution;
                    defaultOptions['selectedPath']      = wdhCurrentPath;
                    
                // Load Settings
                var loadStep = '';
                
                if(category+'-'+type+'-'+subtype === 'normal-general-text' || category+'-'+type+'-'+subtype === 'hover-general-text'){
                    loadStep = 'text-settings';
                } else if(category+'-'+type+'-'+subtype === 'normal-advanced-text' || category+'-'+type+'-'+subtype === 'hover-advanced-text'){
                    loadStep = 'advanced-text-settings';
                } else if(category+'-'+type+'-'+subtype === 'normal-general-box' || category+'-'+type+'-'+subtype === 'hover-general-box'){
                    loadStep = 'box-settings';
                } else if(category+'-'+type+'-'+subtype === 'normal-advanced-box' || category+'-'+type+'-'+subtype === 'hover-advanced-box'){
                    loadStep = 'advanced-box-settings';
                }
                
                // Loader
                $jWDH('#wdh-settings-id .wdh-settings-loader').css('display','block');
                // Remove All existing
                //$jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).remove();
                $jWDH('.wdh-settings-normal-general-text').remove();
                $jWDH('.wdh-settings-normal-advanced-text').remove();
                $jWDH('.wdh-settings-normal-general-box').remove();
                $jWDH('.wdh-settings-normal-advanced-box').remove();
                $jWDH('.wdh-settings-hover-general-text').remove();
                $jWDH('.wdh-settings-hover-advanced-text').remove();
                $jWDH('.wdh-settings-hover-general-box').remove();
                $jWDH('.wdh-settings-hover-advanced-box').remove();
                $jWDH('.wdh-settings-hover-general-animator').remove();
                $jWDH('.wdh-settings-normal-general-animator').remove();
                
                
                $jWDH.post(ajaxurl,{action: 'wdh_svwe_display_panel',
                                    category: category,
                                    type: type,
                                    subtype: subtype,
                                    loadstep: loadStep,
                                    wdhPath: defaultOptions['wdhPath'],
                                    domPath: defaultOptions['domPath'],
                                    wdhID: defaultOptions['wdhID'],
                                    wdhAllCSS: defaultOptions['wdhAllCSS'],
                                    wdhPageUrl: defaultOptions['wdhPageUrl'],
                                    wdhPageOn: window.wdhSVWEPageIsOn,
                                    wdhRole: window.wdhSVWERole,
                                    elementTag: defaultOptions['elementTag'],
                                    elementPosition: defaultOptions['elementPosition'],
                                    wdhClass: defaultOptions['wdhClass'],
                                    resolution: defaultOptions['resolution'],
                                    selectedPath: defaultOptions['selectedPath']
                                    }, function(data){

                    // Show Settings
                    $jWDH('#wdh-settings-id').append(data);
                    // Adding Tooltip
                    panel.tooltip();
                    // Hide All Appended
                    $jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).css('display','none');

                    // Remove Load in progress
                    $jWDH('#wdh-settings-id .wdh-settings-loader').removeClass('wdh-loader-in-progress-'+category+'-'+type+'-'+subtype);
                    
                    // Display All
                    $jWDH('#wdh-settings-id li').css('display','none');
                    $jWDH('.wdh-settings-'+category+'-'+type+'-'+subtype).css('display','block');
                });
            },
           
            view: function(){
               //Add form in container 
               $jWDH(id).append(panel.generate());
            },
            
            generate: function(){
                var contentHTML     = new Array();

                contentHTML.push('  <div class="wdh-panel wdh-svwe-exclude" id="wdh-panel">');
                contentHTML.push(       paneltop.view());
                contentHTML.push(       panelmiddle.view());
                contentHTML.push('  </div>');

                return contentHTML.join('');
     
            }        
            
        },
                
        paneltop = {
            view: function(){
                
              return paneltop.generate();
                
            },
                    
            generate: function(){
                var contentHTML = new Array();
                
                contentHTML.push('      <div class="wdh-panel-top wdh-svwe-exclude">');
                contentHTML.push('          <div class="wdh-panel-top-setting wdh-normal-settings-button setting-selected wdh-svwe-exclude">'+defaultOptions['normaltext']+'</div>'); 
                contentHTML.push('          <div class="wdh-panel-top-setting wdh-hover-settings-button wdh-svwe-exclude">'+defaultOptions['hovertext']+'</div>');
                contentHTML.push('          <div class="wdh-left-right wdh-use-tooltip wdh-svwe-exclude">');
                contentHTML.push('              <span class="wdh-svwe-tooltip wdh-svwe-exclude"><span class="wdh-svwe-information wdh-svwe-exclude">'+window.TXT_PM_SWITCH_POSITION+'</span></span>');
                contentHTML.push('          </div>');
                contentHTML.push('          <div class="wdh-panel-top-x wdh-svwe-exclude">X</div>');
                // Panel Current Settings
                contentHTML.push('          <input type="hidden" id="wdh-panel-category-settings" value="normal">');
                contentHTML.push('          <input type="hidden" id="wdh-panel-type-settings" value="general">'); // general - advanced
                contentHTML.push('          <input type="hidden" id="wdh-panel-subtype-settings" value="text">');
                contentHTML.push('      </div>');
                
                return contentHTML.join('');
            }
           
        },
                
        panelmiddle = {
            view: function(){
                
              return panelmiddle.generate();
                
            },
                    
            generate: function(){
                var contentHTML = new Array();
                
                contentHTML.push('      <div class="wdh-panel-middle wdh-svwe-exclude">');
                contentHTML.push(       submenu.view());
                contentHTML.push('      </div>');
                
                return contentHTML.join('');
            }
           
        },
                
        submenu = {
            view: function(){
                
              return submenu.generate();
              
            },
                    
            generate:function(){
                var contentHTML = new Array();

                contentHTML.push('         <div class="wdh-general-settings wdh-svwe-exclude" id="wdh-general-settings-id">');
                contentHTML.push(               types.view());
                contentHTML.push(               settings.view());
                contentHTML.push('          </div>');
                
                return contentHTML.join('');
                 
            }        
        },
                
        types = {
            view: function(){
                
              return types.generate();
              
            },
                    
            generate:function(){
                var contentHTML = new Array(),
                    extraSettings = window.WDH_SVWE_EXTRA_GROUPS;
                
                contentHTML.push('          <div class="wdh-search-properties wdh-svwe-exclude">');
                contentHTML.push('              <input type="text" class="wdh-search-input wdh-svwe-exclude" id="wdh-search-input-id" value="" placeholder="'+window.TXT_PM_TYPE_PROPERTY+'">');
                contentHTML.push('          </div>');
                contentHTML.push('         <ul class="wdh-types wdh-svwe-exclude">');
                contentHTML.push('              <li id="'+defaultOptions['textSettings']['id']+'" class="'+defaultOptions['textSettings']['icon']+' wdh-elemnt-type wdh-svwe-exclude element-type-selected"><span class="wdh-svwe-exclude">'+defaultOptions['textSettings']['text']+'</span></li>');
                contentHTML.push('              <li id="'+defaultOptions['boxSettings']['id']+'" class="'+defaultOptions['boxSettings']['icon']+' wdh-elemnt-type wdh-svwe-exclude"><span class="wdh-svwe-exclude">'+defaultOptions['boxSettings']['text']+'</span></li>');
                
                if (extraSettings !== '') {
                    for (var key in extraSettings) {
                        contentHTML.push('              <li id="'+extraSettings[key]['id']+'" class="'+extraSettings[key]['icon']+' wdh-elemnt-type wdh-svwe-exclude"><span class="wdh-svwe-exclude">'+extraSettings[key]['text']+'</span></li>');
                    }
                }
                
                contentHTML.push('          </ul>');
                
                return contentHTML.join('');
                 
            }        
        },
        
        settings = {
            view: function(){
                
              return settings.generate();
              
            },
                    
            generate:function(){
                var contentHTML = new Array();

                contentHTML.push('         <ul class="wdh-settings wdh-svwe-exclude" id="wdh-settings-id">');
                contentHTML.push(           '<li class="wdh-settings-loader wdh-svwe-exclude"><span class="wdh-svwe-exclude">'+window.TXT_GENERAL_LOADING+'</span></li>');
                // .wdh-settings-loader - Loader 
                // --------------------------------------------------------------------
                // .wdh-settings-normal-text-general - Normal Text Settings - General
                // .wdh-settings-normal-text-advanced - Normal Text Settings - Advanced
                // .wdh-settings-normal-box-general - Normal Box Settings - General
                // .wdh-settings-normal-box-advanced - Normal Box Settings - Advanced
                // --------------------------------------------------------------------
                // .wdh-settings-hover-text-general - Hover Text Settings - General
                // .wdh-settings-hover-text-advanced - Hover Text Settings - Advanced
                // .wdh-settings-hover-box-general - Hover Box Settings - General
                // .wdh-settings-hover-box-advanced - Hover Box Settings - Advanced
                contentHTML.push('         </ul>');
                
                return contentHTML.join('');
                 
            }
            
            
        },
                
        advanced = {
            view: function(){
                
              return advanced.generate();
              
            },
                    
            loading: function(){
                var popupLoaderHTML = '<div class="wdh-options-loader"></div>'; 
                $jWDH('.wdh-panel-advanced-settings').html(popupLoaderHTML);
            },
                    
            success: function(newHTML){
                $jWDH('.wdh-panel-advanced-settings').html(newHTML).fadeIn(500);
            },
                    
            generate:function(){
                var contentHTML = new Array();

                contentHTML.push('         <div class="wdh-advanced-settings wdh-svwe-exclude">');
                contentHTML.push('          <span class="wdh-advanced-text wdh-svwe-exclude">'+defaultOptions['advancedsettings']+'</span>');
                contentHTML.push('          <span class="wdh-advanced-box wdh-svwe-exclude">+</span>');
                contentHTML.push('          <ul class="wdh-panel-advanced-settings wdh-svwe-exclude"></ul>');
                contentHTML.push('         </div>');
                
                return contentHTML.join('');
            }        
        };
        
        // End Plugin
        panel.start();
    }   
});