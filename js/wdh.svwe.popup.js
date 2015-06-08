/* -------------------------------------------------------------------
 * Project Name: WDH - Popup JSON
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/popup-json/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: js/wdh.svwe.popup.js
 * File Description: Popup JSON File
 * File Version: 1.0
 * Last Update File : 22.09.2014
 * ------------------------------------------------------------------- 
 */

var $jWDH = jQuery.noConflict();
window.wdhPopupStart = false;

$jWDH.fn.extend({
    
    
    wdhPopupJS:function (options){
        
        var id = $jWDH(this)['selector'],
            defaultOptions = {"message": "Are you sure you want to do this action ?",
                              "labelYes": "Yes",
                              "labelNo": "No",
                              "functionYes": "",
                              "functionNo": "",
                              "functionLoading": "",
                              "sendData": {},
                              "reset": false,
                              "message_class": "",
                              "message_css": "",
                              "popup_class": "",
                              "popup_css": "",
                              "labelno_class": "",
                              "labelyes_class": "",
                              "labelno_css": "",
                              "popup_id": "wdh-popup-id",
                              "bg_class": "",
                              "bg_css": "",
                              "bg_id": "wdh-popup-body-bg-id",
                              "type": "view",
//                              "fields": { "0":{"id": "wdh-field",
//                                          "name": "wdh-field",
//                                          "type": "text",
//                                          "display_type": "left", // left , top
//                                          "class": "",
//                                          "css": "",
//                                          "label": {"for": "wdh-label-1",
//                                                    "text": "label 1",
//                                                    "class": "",
//                                                    "css": ""
//                                                   },
//                                          "input": {"id": "wdh-input-1",
//                                                    "name": "wdh-input-1",
//                                                    "value": "",
//                                                    "class": "",
//                                                    "css": "",
//                                                    "options": {"0":{"name": "option 1",
//                                                                     "value": "option 1"
//                                                                    }
//                                                               },
//                                                    "options_type": "html", // html or json
//                                                    "options_html": ""
//                                                   }
//                                      }      
//                                  }
                                "fields": {}
                                },
                          
        popup = {
            start: function(){
                // Add Properties
                popup.properties();
                
                switch(defaultOptions['view']){
                    case "view":
                        popup.view();
                        break;
                    case "loading":
                        popup.view();
                        popup.loading();
                        
                        if (defaultOptions['functionLoading'] !== "undefined") {
                            var loadingFunction = eval(defaultOptions['functionLoading']+'('+defaultOptions['sendData']+');');
                            setTimeout(loadingFunction,0);
                        }
                        break;
                    case "success":
                        popup.view();
                        popup.success();
                        break;
                    default:
                        popup.view();
                        break;
                }
            },
                    
            properties: function(){
                
                if (typeof options !== 'undefined'){
                    $jWDH.extend(defaultOptions,options);
                }
            },
           
            view: function(){
               
               var allHTML = $jWDH(id).html();
               
               if (allHTML.indexOf("wdh-popup-message") !== -1) {
                   
                   if(defaultOptions['reset'] === false) {
                        // Show Popup
                        $jWDH('#wdh-popup-body-bg-id').css('display','block');
                        $jWDH('.wdh-popup-action').css('display','block');
                        // Update Popupconsole.log('test ...');
                        $jWDH('.wdh-popup-message').html(defaultOptions['message']);
                        // Hide Loader
                        $jWDH('.wdhpopup-loader').css('display','none');
                        // Show Fields
                        $jWDH('.wdh-popup-fields').css('display','block');
                        // Show Buttons 
                        $jWDH('.wdh-popup-action-buttons').css('display','block');
                   } else {
                       // Show Popup
                        $jWDH('.wdh-popup-action').html(content.view());
                        $jWDH('#wdh-popup-body-bg-id').css('display','block');
                        $jWDH('.wdh-popup-action').css('display','block');
                        // Update Popupconsole.log('test ...');
                        $jWDH('.wdh-popup-message').html(defaultOptions['message']);
                        // Hide Loader
                        $jWDH('.wdhpopup-loader').css('display','none');
                        // Show Fields
                        $jWDH('.wdh-popup-fields').css('display','block');
                        // Show Buttons 
                        $jWDH('.wdh-popup-action-buttons').css('display','block');
                   }
               } else {
                   // Generate Popup
                   $jWDH(id).append(popup.generate()); 
               }
            },
                    
            loading: function(){
                 var popupLoaderHTML = '<div class="wdhpopup-loader"></div>'; 
                 
                 $jWDH('.wdh-popup-action-buttons').css('display','none');
                 $jWDH('.wdh-popup-fields').css('display','none');
                 $jWDH('.wdhpopup-loader').css('display','block');
            },
                    
            success: function(){
                $jWDH('.wdh-popup-action-buttons').css('display','none');
                $jWDH('.wdh-popup-fields').css('display','none');
                $jWDH('.wdhpopup-loader').css('display','none');
                
                $jWDH('.wdh-popup-body-bg').fadeOut(2500, function(){
                    $jWDH(this).remove();
                });
                $jWDH('.wdh-popup-action').fadeOut(2500, function(){
                    $jWDH(this).remove();
                });
                 
            },
            
            generate: function(){
                var wdhWindowWidth  = $jWDH(window).width(),
                    wdhWindowHeight = $jWDH(window).height(),
                    contentHTML     = new Array();
                
                contentHTML.push('     <div class="wdh-popup-body-bg '+defaultOptions['bg_class']+' wdh-popup wdh-svwe-exclude" style="'+defaultOptions['bg_css']+'" id="'+defaultOptions['bg_id']+'"></div>');
                contentHTML.push('     <div class="wdh-popup-action '+defaultOptions['popup_class']+' wdh-popup wdh-svwe-exclude" style='+defaultOptions['popup_css']+' id="'+defaultOptions['popup_id']+'">');
                contentHTML.push(       content.view());
                contentHTML.push('     </div>');

                $jWDH('body').append(contentHTML.join(''));
                $jWDH('.wdh-popup-body-bg').css({
                    'width' : wdhWindowWidth,
                    'height': wdhWindowHeight
                 });
            }        
            
        },
                
        content = {
            view: function(){
              return content.generate();
                
            },
                    
            generate: function(){
                var contentHTML = new Array();
                
                contentHTML.push(' <div class="wdh-popup-action-content wdh-svwe-exclude">');
                contentHTML.push(   close.view());
                contentHTML.push(   message.view());
                contentHTML.push(   fields.view());
                contentHTML.push(   '<div class="wdhpopup-loader"></div>');
                contentHTML.push(   content3.view());
                contentHTML.push('  </div>');
                return contentHTML.join('');
            }
           
        },
                
        close = {
            view: function(){
              return close.generate();
            },
                    
            generate:function(){
                var closeHTML = new Array();

                closeHTML.push('             <span class="wdh-popup-exit-element wdh-svwe-exclude" onclick="'+defaultOptions['functionNo']+'; $jWDH(\'.wdh-popup\').remove();">X</span>');
                
                return closeHTML.join('');
                 
            }        
        },
                
        message = {
            view: function(){
              return message.generate();
            },
                    
            generate:function(){
                var messageHTML = new Array();

                messageHTML.push('         <div class="wdh-popup-message '+defaultOptions['message_class']+' wdh-svwe-exclude" style="'+defaultOptions['message_css']+'">'+defaultOptions['message']+'</div>');
                
                return messageHTML.join('');
                 
            }        
        },  
                
        fields = {
            view: function(){
                
                if(typeof defaultOptions['fields']['0'] !== 'undefined') {
                    return fields.generate();
                }
            },
            generate: function(){
                var fieldsHTML = new Array(),
                    fields = defaultOptions['fields'],
                    changeField = '';
                
                fieldsHTML.push('<div class="wdh-popup-fields" id="wdh-popup-fields">');
                    
                    
                    $jWDH.each( fields, function( key, field ) {
                        // Display Field
                        fieldsHTML.push(fieldElement.view(field));
                    });
                
                fieldsHTML.push('</div>');
                
                return fieldsHTML.join('');
            }
        },
                
        fieldElement = {
            view: function(field){
                var fieldHTML = new Array(),
                    hideField = '';
                
                if (field['visible'] === false){
                    hideField = 'display:none;';
                }
                
                fieldHTML.push('    <div class="wdh-popup-field '+field['class']+'" style="'+field['css']+hideField+'">');
                // Label
                fieldHTML.push('        <label class="wdh-popup-field-label wdh-popup-field-label-'+field['display_type']+' '+field['label']['class']+'" style="'+field['label']['css']+'" for="'+field['label']['for']+'">'+field['label']['text']+':</label>');
                // Input
                switch(field['type']){
                    case "text":
                        fieldHTML.push('        <input class="wdh-popup-field-input wdh-popup-field-input-'+field['display_type']+' '+field['input']['class']+'" style="'+field['input']['css']+'" id="'+field['input']['id']+'" type="text" value="'+field['input']['value']+'"/>');
                        break;
                    case "select":
                        
                        if (typeof field['onChange'] !== 'undefined') {
                            fieldHTML.push('        <select class="wdh-popup-field-input wdh-popup-field-input-'+field['display_type']+' '+field['input']['class']+'" style="'+field['input']['css']+'" id="'+field['input']['id']+'" onChange="'+field['onChange']+'();'+'" type="text" value="'+field['input']['value']+'">');
                        } else {
                            fieldHTML.push('        <select class="wdh-popup-field-input wdh-popup-field-input-'+field['display_type']+' '+field['input']['class']+'" style="'+field['input']['css']+'" id="'+field['input']['id']+'" type="text" value="'+field['input']['value']+'">');
                        }
                        
                        if(field['input']['options_type'] === 'html'){
                            fieldHTML.push(         field['input']['options_html']);
                        }
                        fieldHTML.push('        </select>');
                        break;
                    default:
                        fieldHTML.push('        <input class="wdh-popup-field-input wdh-popup-field-input-'+field['display_type']+' '+field['input']['class']+'" style="'+field['input']['css']+'" id="'+field['input']['id']+'" type="text" value="'+field['input']['value']+'"/>');
                        break;
                }
                fieldHTML.push('    </div>');
                
                return fieldHTML.join('');
            }
        },
                
        content3 = {
            view: function(){
              return content3.generate();
            },
                    
            generate:function(){
                var content3HTML = new Array();

                content3HTML.push('         <div class="wdh-popup-action-buttons wdh-svwe-exclude">');
                content3HTML.push(            buttons.view());
                content3HTML.push('         </div>');
                
                return content3HTML.join('');
                 
            }        
        },
        buttons = {
            view: function(){
              return buttons.generate();
            },
                    
            generate:function(){
                var buttonsHTML = new Array();

                buttonsHTML.push('             <span class="wdh-popup-action-btn wdh-popup-btn-selected '+defaultOptions['labelno_class']+' '+defaultOptions['labelyes_class']+' wdh-svwe-exclude" style="'+defaultOptions['labelyes_css']+'" id="wdh-popup-id-yes" onclick="'+defaultOptions['functionYes']+';">'+defaultOptions['labelYes']+'</span>');
                buttonsHTML.push('             <span class="wdh-popup-action-btn '+defaultOptions['labelno_class']+' wdh-svwe-exclude" style="'+defaultOptions['labelno_css']+'" id="wdh-popup-id-no" onclick="'+defaultOptions['functionNo']+'; $jWDH(\'.wdh-popup\').remove();">'+defaultOptions['labelNo']+'</span>');
                
                return buttonsHTML.join('');
                 
            }        
        };        
        
        // End Plugin
        popup.start();
    
    }   
    
});