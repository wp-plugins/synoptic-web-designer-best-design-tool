/*
Project Name: WDH - Edit Database Field PRO (Ajax + PHP)
Project Version: 2.4
Project URL: http://www.wdh.im/projects/edit-database-field-pro/
Author: WDH - Web Developers House
Author URL: http://www.wdh.im/
File Path: js/jquery.wdh.im.edfp.js
File Description: WDH - Edit Database Field PRO Scripts 
File Version: 2.4
Last Update File : 04.03.2014
*/
        
var $jWDH = jQuery.noConflict();

$jWDH(document).ready(function(){
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
});

$jWDH.fn.extend({
    // ALL
    wdhEditDbField:function (wdhDB_json,wdhFIELD_json,wdhINPUT_json,wdhTOOLTIP_json,wdhFILTER_json,wdhERROR_json,wdhUPLOAD_json,valueNow,idField){
        var id = $jWDH(this)['selector'],
            currHtml = $jWDH(id).html(),
            dbTable = JSON.parse($jWDH.trim(wdhDB_json))['table'],
            dbfieldName = JSON.parse($jWDH.trim(wdhFIELD_json))['field_name'],
            conditions = JSON.parse($jWDH.trim(wdhFIELD_json))['conditions'],
            editis = JSON.parse($jWDH.trim(wdhFIELD_json))['edit'],
            tokenis = JSON.parse($jWDH.trim(wdhFIELD_json))['token'],
            inputType = JSON.parse($jWDH.trim(wdhINPUT_json))['type'],
            tooltipType = JSON.parse($jWDH.trim(wdhTOOLTIP_json))['position'],
            tooltipTitle = JSON.parse($jWDH.trim(wdhTOOLTIP_json))['text'],
            submitText = JSON.parse($jWDH.trim(wdhINPUT_json))['save_button'],
            valuesList = JSON.parse($jWDH.trim(wdhINPUT_json))['values'],
            secondValuesList = JSON.parse($jWDH.trim(wdhINPUT_json))['second_values'],
            slider_min = JSON.parse($jWDH.trim(wdhINPUT_json))['slider_min'],
            slider_max = JSON.parse($jWDH.trim(wdhINPUT_json))['slider_max'],
            slider_range = JSON.parse($jWDH.trim(wdhINPUT_json))['slider_range'],
            map_width  = JSON.parse($jWDH.trim(wdhINPUT_json))['map_width'],
            map_height  = JSON.parse($jWDH.trim(wdhINPUT_json))['map_height'],
            map_zoom  = JSON.parse($jWDH.trim(wdhINPUT_json))['map_zoom'],
            video_width  = JSON.parse($jWDH.trim(wdhINPUT_json))['video_width'],
            video_height  = JSON.parse($jWDH.trim(wdhINPUT_json))['video_height'],
            html_editor_width  = JSON.parse($jWDH.trim(wdhINPUT_json))['html_editor_width'],
            html_editor_height  = JSON.parse($jWDH.trim(wdhINPUT_json))['html_editor_height'],
            filter_is_required = JSON.parse($jWDH.trim(wdhFILTER_json))['is_required'],
            filter_is_email = JSON.parse($jWDH.trim(wdhFILTER_json))['is_email'],
            filter_is_url = JSON.parse($jWDH.trim(wdhFILTER_json))['is_url'],
            filter_is_phone = JSON.parse($jWDH.trim(wdhFILTER_json))['is_phone'],
            filter_is_alpha = JSON.parse($jWDH.trim(wdhFILTER_json))['is_alpha'],
            filter_is_numeric = JSON.parse($jWDH.trim(wdhFILTER_json))['is_numeric'],
            filter_is_alphanumeric = JSON.parse($jWDH.trim(wdhFILTER_json))['is_alphanumeric'],
            filter_is_date = JSON.parse($jWDH.trim(wdhFILTER_json))['is_date'],
            filter_is_unique = JSON.parse($jWDH.trim(wdhFILTER_json))['is_unique'],
            filter_is_adult_video = JSON.parse($jWDH.trim(wdhFILTER_json))['is_adult_video'],
            error_is_required = JSON.parse($jWDH.trim(wdhERROR_json))['is_required'],
            error_is_email = JSON.parse($jWDH.trim(wdhERROR_json))['is_email'],
            error_is_url = JSON.parse($jWDH.trim(wdhERROR_json))['is_url'],
            error_is_phone = JSON.parse($jWDH.trim(wdhERROR_json))['is_phone'],
            error_is_alpha = JSON.parse($jWDH.trim(wdhERROR_json))['is_alpha'],
            error_is_numeric = JSON.parse($jWDH.trim(wdhERROR_json))['is_numeric'],
            error_is_alphanumeric = JSON.parse($jWDH.trim(wdhERROR_json))['is_alphanumeric'],
            error_is_date = JSON.parse($jWDH.trim(wdhERROR_json))['is_date'],
            error_is_unique = JSON.parse($jWDH.trim(wdhERROR_json))['is_unique'],
            error_is_adult_video = JSON.parse($jWDH.trim(wdhERROR_json))['is_adult_video'],
            error_not_video = JSON.parse($jWDH.trim(wdhERROR_json))['is_not_video'],
            error_video = JSON.parse($jWDH.trim(wdhERROR_json))['is_not_video'],
            video_not_exist = JSON.parse($jWDH.trim(wdhERROR_json))['video_not_exist'],
            error_password = JSON.parse($jWDH.trim(wdhERROR_json))['password'],
            password_message = JSON.parse($jWDH.trim(wdhFIELD_json))['password'],
            confirm_password_message = JSON.parse($jWDH.trim(wdhFIELD_json))['confirm'],
            js_wdhedfp_onchange = JSON.parse($jWDH.trim(wdhINPUT_json))['js_wdhedfp_onchange'],
            js_wdhedfp_after_save = JSON.parse($jWDH.trim(wdhINPUT_json))['js_wdhedfp_after_save'],
            errorTEXT = '',
            errorHTML = '',
            wdbfieldvalue = idField,
            startFormHTML = '<form>',
            inputHTML = '<input type="text" class="wdh-input" value="'+valueNow+'">',
            passwordHTML = '<input type="text" class="wdh-input-password wdh-password">',
            confirmpasswordHTML = '<input type="text" class="wdh-input-password wdh-confirm-password">',
            textareaHTML = '<textarea class="wdh-textarea">'+valueNow+'</textarea>',
            editorHTML = '<textarea class="wdh-html-editor">'+valueNow+'</textarea>',
            fieldHTML = '',
            valueSelect = '',
            submitHTML = '<input type="button" class="wdh-submit" value="'+submitText+'">',
            endFormHTML = '</form>',
            loaderHTML = '<div class="wdh-loader">&nbsp;</div>',
            conditionAll = '',
            condition = new Array(),
            wfieldvalue = '',
            valueRadio = valueNow,
            valueCheckboxNew =  valueNow,
            oldValue = valueNow,
            confirmValueNow = '',
            i = 0;  
    
            // Get Unique ID by conditions
            $jWDH.each(conditions,function(key){
                
                if (i < 1){
                    wfieldvalue += conditions[key]['field_label'];
                } else {
                    wfieldvalue += '-'+conditions[key]['field_label'];
                }
                i++;
            });
            
            wfieldvalue += '-'+dbfieldName;
        
        // Input type
        switch (inputType){
            case "text":
                fieldHTML = inputHTML;
                break;
            case "textarea":
                fieldHTML = textareaHTML;
                break;
            case "select":
                valueSelect = valuesList.split("|");
                fieldHTML  = '<select class="wdh-select">'; 
                             var valueNext = $jWDH(id+' .wdh-select').val(),
                                 selecLabel = '',
                                 selecValue = '';
                             $jWDH.each(valueSelect,function(key){
                                 
                                 if (valueSelect[key].indexOf("@@") != -1) {
                                    selecLabel = valueSelect[key].split('@@')[0];
                                    selecValue = valueSelect[key].split('@@')[1];
                                 } else {
                                    selecLabel = valueSelect[key];
                                    selecValue = valueSelect[key];
                                 }
                                 
                                 if (valueNow == valueSelect[key]){
                                    fieldHTML += '<option value="'+selecValue+'" selected>'+selecLabel+'</option>';
                                 } else {
                                    fieldHTML += '<option value="'+selecValue+'">'+selecLabel+'</option>';
                                 }
                             });
                fieldHTML += '</select>';
                break;
            case "radio":
                valueSelect = valuesList.split("|");
                    var valueNext = valueNow,
                        selecLabel = '',
                        selecValue = '';
                    fieldHTML += '<div class="wdh-radio-box">';
                    $jWDH.each(valueSelect,function(key){
                                 
                        if (valueSelect[key].indexOf("@@") != -1) {
                           selecLabel = valueSelect[key].split('@@')[0];
                           selecValue = valueSelect[key].split('@@')[1];
                        } else {
                           selecLabel = valueSelect[key];
                           selecValue = valueSelect[key];
                        }
                        
                        if (valueNow == valueSelect[key]){
                           fieldHTML += '<div class="wdh-radio-input"><input type="radio" class="wdh-radio" name="'+dbfieldName+'" value="'+selecValue+'" checked="checked">'+' '+selecLabel+'</div>';
                           fieldHTML += '<input type="hidden" class="wdh-radio-value" name="'+dbfieldName+'-value" value="'+valueSelect[key]+'">';
                        } else {
                            fieldHTML += '<div class="wdh-radio-input"><input type="radio" class="wdh-radio" name="'+dbfieldName+'" value="'+selecValue+'">'+' '+selecLabel+'</div>';
                        }
                    });
                    fieldHTML += '</div>';
                break;
            case "date":
                fieldHTML = '<input type="text" class="wdh-date" name="'+dbfieldName+'" value="'+valueNow+'">';
                break;
            case "slider":
                fieldHTML = '<div id="wdh-slider-'+wfieldvalue+'" class="wdh-slider">&nbsp;</div><input type="text" id="wdh-slider-value-'+wfieldvalue+'" class="wdh-slider-value" value="'+valueNow+'">';
                break;
            case "font":
                fieldHTML  = '<select class="wdh-select">';
                    var foundedFont = 0;
                    
                    // Arial, Helvetica, sans-serif
                    if (valueNow === 'Arial, Helvetica, sans-serif') {
                        foundedFont = 1;
                        fieldHTML  += '<option selected="selected" value="Arial, Helvetica, sans-serif">Arial, Helvetica, sans-serif</option>';
                    } else {
                        fieldHTML  += '<option value="Arial, Helvetica, sans-serif">Arial, Helvetica, sans-serif</option>';
                    }
                    
                    // Comic Sans MS, cursive
                    if (valueNow === 'Comic Sans MS, cursive') {
                        foundedFont = 1;
                        fieldHTML  += '<option selected="selected" value="Comic Sans MS, cursive">Comic Sans MS, cursive</option>';
                    } else {
                        fieldHTML  += '<option value="Comic Sans MS, cursive">Comic Sans MS, cursive</option>';
                    }
                    
                    // Courier New, Courier New, monospace
                    if (valueNow === 'Courier New, Courier New, monospace') {
                        foundedFont = 1;
                        fieldHTML  += '<option selected="selected" value="Courier New, Courier New, monospace">Courier New, Courier New, monospace</option>';
                    } else {
                        fieldHTML  += '<option value="Courier New, Courier New, monospace">Courier New, Courier New, monospace</option>';
                    }
                    
                    // Georgia, serif
                    if (valueNow === 'Georgia, serif') {
                        foundedFont = 1;
                        fieldHTML  += '<option selected="selected" value="Georgia, serif">Georgia, serif</option>';
                    } else {
                        fieldHTML  += '<option value="Georgia, serif">Georgia, serif</option>';
                    }
                    
                    // Impact, Charcoal, sans-serif
                    if (valueNow === 'Impact, Charcoal, sans-serif') {
                        foundedFont = 1;
                        fieldHTML  += '<option selected="selected" value="Impact, Charcoal, sans-serif">Impact, Charcoal, sans-serif</option>';
                    } else {
                        fieldHTML  += '<option value="Impact, Charcoal, sans-serif">Impact, Charcoal, sans-serif</option>';
                    }
                    
                    // Times New Roman, Times, serif
                    if (valueNow === 'Times New Roman, Times, serif') {
                        foundedFont = 1;
                        fieldHTML  += '<option selected="selected" value="Times New Roman, Times, serif">Times New Roman, Times, serif</option>';
                    } else {
                        fieldHTML  += '<option value="Times New Roman, Times, serif">Times New Roman, Times, serif</option>';
                    }
                    
                    // Verdana, Geneva, sans-serif
                    if (valueNow === 'Verdana, Geneva, sans-serif') {
                        foundedFont = 1;
                        fieldHTML  += '<option selected="selected" value="Verdana, Geneva, sans-serif">Verdana, Geneva, sans-serif</option>';
                    } else {
                        fieldHTML  += '<option value="Verdana, Geneva, sans-serif">Verdana, Geneva, sans-serif</option>';
                    }
                    
                fieldHTML  += '</select>';
                break;
            case "size":
                
                if(valueNow === '...............') {
                    var sliderValueNow = parseInt(slider_min);
                } else {
                    var sliderValueNow = parseInt(valueNow),
                        selectValueNow = valueNow.split(sliderValueNow)[1];
                }
                fieldHTML = '<div id="wdh-slider-'+wfieldvalue+'" class="wdh-slider">&nbsp;</div><input type="text" id="wdh-slider-value-'+wfieldvalue+'" class="wdh-slider-value" value="'+sliderValueNow+'">';
                valueSelect = valuesList.split("|");
                fieldHTML  += '<select id="wdh-select-'+wfieldvalue+'" class="wdh-select" style="width:40px;">'; 
                             var valueNext = $jWDH(id+' .wdh-select').val(),
                                 selecLabel = '',
                                 selecValue = '';
                             $jWDH.each(valueSelect,function(key){
                                 
                                 if (valueSelect[key].indexOf("@@") != -1) {
                                    selecLabel = valueSelect[key].split('@@')[0];
                                    selecValue = valueSelect[key].split('@@')[1];
                                 } else {
                                    selecLabel = valueSelect[key];
                                    selecValue = valueSelect[key];
                                 }
                                 
                                 if (selectValueNow == valueSelect[key]){
                                    fieldHTML += '<option value="'+selecValue+'" selected>'+selecLabel+'</option>';
                                 } else {
                                    fieldHTML += '<option value="'+selecValue+'">'+selecLabel+'</option>';
                                 }
                             });
                fieldHTML += '</select>';
                break;
            case "border":
                
                if(valueNow === '...............') {
                    var sliderValueNow = parseInt(slider_min);
                } else {
                    var sliderSizeValue = valueNow.split(' ')[0],
                        sliderValueNow = parseInt(sliderSizeValue),
                        selectValueNow = sliderSizeValue.split(sliderValueNow)[1],
                        selectValueNowType = valueNow.split(' ')[1];
                }
                
                fieldHTML = '<div id="wdh-slider-'+wfieldvalue+'" class="wdh-slider">&nbsp;</div><input type="text" id="wdh-slider-value-'+wfieldvalue+'" class="wdh-slider-value" value="'+sliderValueNow+'">';
                valueSelect = valuesList.split("|");
                fieldHTML  += '<select id="wdh-select-'+wfieldvalue+'" class="wdh-select" style="width:40px;">'; 
                             var valueNext = $jWDH(id+' .wdh-select').eq(0).val(),
                                 selecLabel = '',
                                 selecValue = '';
                             $jWDH.each(valueSelect,function(key){
                                 
                                 if (valueSelect[key].indexOf("@@") != -1) {
                                    selecLabel = valueSelect[key].split('@@')[0];
                                    selecValue = valueSelect[key].split('@@')[1];
                                 } else {
                                    selecLabel = valueSelect[key];
                                    selecValue = valueSelect[key];
                                 }
                                 
                                 if (selectValueNow == valueSelect[key]){
                                    fieldHTML += '<option value="'+selecValue+'" selected>'+selecLabel+'</option>';
                                 } else {
                                    fieldHTML += '<option value="'+selecValue+'">'+selecLabel+'</option>';
                                 }
                             });
                fieldHTML += '</select>';
                valueSelect = secondValuesList.split("|");
                fieldHTML  += '<select id="wdh-select-type-'+wfieldvalue+'" class="wdh-select" style="width:40px;">'; 
                             var valueNext = $jWDH(id+' .wdh-select').eq(1).val(),
                                 selecLabel = '',
                                 selecValue = '';
                             $jWDH.each(valueSelect,function(key){
                                 
                                 if (valueSelect[key].indexOf("@@") != -1) {
                                    selecLabel = valueSelect[key].split('@@')[0];
                                    selecValue = valueSelect[key].split('@@')[1];
                                 } else {
                                    selecLabel = valueSelect[key];
                                    selecValue = valueSelect[key];
                                 }
                                 
                                 if (selectValueNowType == valueSelect[key]){
                                    fieldHTML += '<option value="'+selecValue+'" selected>'+selecLabel+'</option>';
                                 } else {
                                    fieldHTML += '<option value="'+selecValue+'">'+selecLabel+'</option>';
                                 }
                             });
                fieldHTML += '</select>';
                break;
            case "checkbox":
                valueSelect = valuesList.split("|"),
                selecLabel = '',
                selecValue = '';
                    fieldHTML += '<div class="wdh-checkbox-box">';
                    $jWDH.each(valueSelect,function(key){
                        
                        if (valueSelect[key].indexOf("@@") != -1) {
                           selecLabel = valueSelect[key].split('@@')[0];
                           selecValue = valueSelect[key].split('@@')[1];
                        } else {
                           selecLabel = valueSelect[key];
                           selecValue = valueSelect[key];
                        }
                        
                        if (valueNow.search(valueSelect[key]) != -1 ){
                           fieldHTML += '<div class="wdh-checkbox-input"><input type="checkbox" class="wdh-checkbox" name="'+dbfieldName+'" value="'+selecValue+'" checked="checked">'+' '+selecLabel+'</div>';
                        } else {
                            fieldHTML += '<div class="wdh-checkbox-input"><input type="checkbox" class="wdh-checkbox" name="'+dbfieldName+'" value="'+selecValue+'">'+' '+selecLabel+'</div>';
                        }
                    });
                    fieldHTML += '<input type="text" style="display:none;" class="wdh-checkbox-value" name="'+dbfieldName+'-value" value="'+valueNow+'">';
                    fieldHTML += '</div>';
                break;
            case "map":
                fieldHTML = inputHTML;
                break;
            case "video":
                fieldHTML = inputHTML;
                break;
            case "password":
                fieldHTML = passwordHTML+confirmpasswordHTML;
                filter_is_required = true;
                break;
            case "html_editor":
                fieldHTML = editorHTML;
                break;
        }
        
        if (editis == true) {
            // Adding ToolTip
            if (inputType != 'html_editor'){
               // $jWDH(id).wdhTooltip(tooltipType);
            }
            // Adding Edit event
            $jWDH(id).click(function(){ 
            // Adding Input
            $jWDH(id).html(startFormHTML+fieldHTML+submitHTML+endFormHTML);
            
            if (inputType == "size" || inputType == "border"){
                $jWDH(id).parent().css('width','100%');
                
                if (inputType == "size") {
                    $jWDH(id+' .wdh-slider').css('width','120px');
                } else {
                    $jWDH(id+' .wdh-slider').css('width','75px');
                }
            }
            
            // JAVASCRIPT HOOK - ON CHANGE TEXT, TEXTAREA, RADIO, SELECT, MAP, VIDEO, DATE, SLIDER
            if (inputType == "text"){
                $jWDH(id+' .wdh-input').keyup(function(){
                    valueNow = $jWDH(id+' .wdh-input').val();
                    // Values For Hook
                    window.valueNow = valueNow;
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                });
            }
            
            if (inputType == "textarea"){
                $jWDH(id+' .wdh-textarea').keyup(function(){
                    valueNow = $jWDH(id+' .wdh-textarea').val();
                    // Values For Hook
                    window.valueNow = valueNow;
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                });
            }
            
            if (inputType == "select"){
                $jWDH(id+' .wdh-select').change(function(){
                    valueNow = $jWDH(id+' .wdh-select').val();
                    // Values For Hook
                    window.valueNow = valueNow;
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                });
            }
            
            if (inputType == "font"){
                $jWDH(id+' .wdh-select').change(function(){
                    valueNow = $jWDH(id+' .wdh-select').val();
                    
                    if (valueNow.indexOf(':') !== -1) {
                        // Load Font
                        $jWDH('head').append('<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='+valueNow+'">');
                    }
                    // Values For Hook
                    window.valueNow = valueNow;
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                });
            }
            
            if (inputType == "map"){
                $jWDH(id+' .wdh-input').keyup(function(){
                    valueNow = $jWDH(id+' .wdh-input').val();
                    // Values For Hook
                    window.valueNow = valueNow;
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                });
            }
            
            // Video
            if (inputType == "video"){
                $jWDH(id+' .wdh-input').keyup(function(){
                    valueNow = wdhReplace("http://","",$jWDH(id+' .wdh-input').val());
                    $jWDH(id+' .wdh-input').val(valueNow);
                    valueNow = wdhReplace("https://","",$jWDH(id+' .wdh-input').val());
                    $jWDH(id+' .wdh-input').val(valueNow);
                    // Values For Hook
                    window.valueNow = valueNow;
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                });
                
                $jWDH(id+' .wdh-input').blur(function(){
                    valueNow = wdhReplace("http://","",$jWDH(id+' .wdh-input').val());
                    $jWDH(id+' .wdh-input').val(valueNow);
                    valueNow = wdhReplace("https://","",$jWDH(id+' .wdh-input').val());
                    $jWDH(id+' .wdh-input').val(valueNow);
                });
            }
            
            // Adding Password form class
            if (inputType == 'password'){
                $jWDH(id+' form').addClass('form-password');
            }
            // Adding video margin-top
            $jWDH(id+'-player').css('marginTop','25px');
            // Remove Hover
            $jWDH(id).unbind('mouseenter mouseleave');
            // Remove click 
            $jWDH(id).unbind('click');
            
            // Adding radio checked value
            $jWDH(id+' input.wdh-radio').unbind('click');
            $jWDH(id+' input.wdh-radio').bind('click',function(){
               valueRadio = $jWDH(this).val();
               $jWDH(id+' .wdh-radio-value').val(valueRadio); 
               
               // Values For Hook
               window.valueNow = valueRadio;
               // Adding Hook
               setTimeout(js_wdhedfp_onchange, 0);
            });
            
            // Adding password placeholders
            $jWDH('.wdh-password').wdhPlacehoder(password_message);
            $jWDH('.wdh-confirm-password').wdhPlacehoder(confirm_password_message);
            
            // Adding HTML Editor
            if (inputType == 'html_editor'){
                $jWDH(id+' .wdh-html-editor').cleditor({width:html_editor_width, height:html_editor_height});
                $jWDH(id+' .wdh-html-editor').cleditor().change(function(){
                    var valueNowTEMP = $jWDH(id+' .wdh-html-editor').val();
                    $jWDH(id+' .wdh-html-editor').val(valueNowTEMP);
                });
            }
            
            // Adding checkbox checked value
            $jWDH(id+' input.wdh-checkbox').unbind('click');
            $jWDH(id+' input.wdh-checkbox').bind('click',function(){
               
               var valueCheckbox = $jWDH(this).val(),
                   valueCheckboxAll = wdhReplace(",","#",$jWDH(id+' input.wdh-checkbox-value').val()),
                   isCheckedCheckbox = $jWDH(this).prop('checked'),
                   valueNew = new Array();
                   
                
                
                // CHECKED GENERATE VALUES
                if (isCheckedCheckbox && (typeof isCheckedCheckbox !== 'undefined')){
                   
                    if (valueCheckboxAll.search(valueCheckbox) == -1 ){
                        
                        if (valueCheckboxAll != ""){
                            valueNew.push(valueCheckboxAll);
                            valueNew.push(valueCheckbox);
                        } else {
                            valueNew.push(valueCheckbox);
                        }
                    } else {
                        valueNew.push(valueCheckboxAll);
                    }
                    
                    $jWDH(this).attr('checked','checked');
                } 
                else { // UNCHECKED GENERATE VALUES
                        var valueRegen = valueCheckboxAll.split("#");
                        $jWDH.each(valueRegen,function(key){
                            if (valueCheckbox != valueRegen[key]){
                                valueNew.push(valueRegen[key]);
                            }
                        });
                        $jWDH(this).attr('checked','');
                }
               $jWDH(id+' .wdh-checkbox-value').val(valueNew.join('#'));
               
               // Values For Hook
               window.valueNow = valueNew.join('#');
               // Adding Hook
               setTimeout(js_wdhedfp_onchange, 0);
            });
            
            // Adding datepicker
            if (inputType == 'date'){
                $jWDH(id+' input.wdh-date').datepicker({defaultDate: valueNow,onSelect: function(dateText){
                    $jWDH(id+' .wdh-date').val(dateText);
                    // Values For Hook
                    window.valueNow = dateText;
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                }});
            }
            // Adding slider 
            if (inputType === 'slider'){
                
                $jWDH('#wdh-slider-'+wfieldvalue).append('<div class="wdh-slider-selected">&nbsp;</div>');
                $jWDH('#wdh-slider-'+wfieldvalue).slider({min: slider_min, max: slider_max, value: valueNow, step: slider_range,slide:function(event,ui){
                        $jWDH('#wdh-slider-value-'+wfieldvalue).val(ui.value);
                        // Values For Hook
                        window.valueNow = ui.value;
                        // Adding selected value
                        var widthMax = $jWDH('#wdh-slider-'+wfieldvalue).width(),
                            posSlider = $jWDH('#wdh-slider-'+wfieldvalue+' .ui-slider-handle').position(),
                            calcWidth = posSlider['left']*100/widthMax;
                        //$jWDH('#wdh-slider-'+wfieldvalue+' .wdh-slider-selected').css('width',parseInt(calcWidth)+'%');
                        // Adding Hook
                        setTimeout(js_wdhedfp_onchange, 0);
                }});
                var widthMax = $jWDH('#wdh-slider-'+wfieldvalue).width(),
                    posSlider = $jWDH('#wdh-slider-'+wfieldvalue+' .ui-slider-handle').position(),
                    calcWidth = posSlider['left']*100/widthMax;
                //$jWDH('#wdh-slider-'+wfieldvalue+' .wdh-slider-selected').css('width',parseInt(calcWidth)+'%');
            }
            //{min: slider_min, max: slider_max, value: valueNow, range: slider_range}
            
            
            // Adding slider & select in Size
            if (inputType === 'size'){
                // Adding slider in Size
                $jWDH('#wdh-slider-'+wfieldvalue).append('<div class="wdh-slider-selected">&nbsp;</div>');
                $jWDH('#wdh-slider-'+wfieldvalue).slider({min: slider_min, max: slider_max, value: sliderValueNow, step: slider_range,slide:function(event,ui){
                        $jWDH('#wdh-slider-value-'+wfieldvalue).val(parseInt(ui.value));
                        // Values For Hook
                        window.valueNow = ui.value+$jWDH(id+' .wdh-select').val();
                        // Adding selected value
                        var widthMax = $jWDH('#wdh-slider-'+wfieldvalue).width(),
                            posSlider = $jWDH('#wdh-slider-'+wfieldvalue+' .ui-slider-handle').position(),
                            calcWidth = posSlider['left']*100/widthMax;
                        $jWDH('#wdh-slider-'+wfieldvalue+' .wdh-slider-selected').css('width',parseInt(calcWidth)+'%');
                        // Adding Hook
                        setTimeout(js_wdhedfp_onchange, 0);
                }});
                var widthMax = $jWDH('#wdh-slider-'+wfieldvalue).width(),
                    posSlider = $jWDH('#wdh-slider-'+wfieldvalue+' .ui-slider-handle').position(),
                    calcWidth = posSlider['left']*100/widthMax;
                $jWDH('#wdh-slider-'+wfieldvalue+' .wdh-slider-selected').css('width',parseInt(calcWidth)+'%');
                
                // Slider Changed Value
                $jWDH('#wdh-slider-value-'+wfieldvalue).unbind('keyup change blur');
                $jWDH('#wdh-slider-value-'+wfieldvalue).bind('keyup change blur', function(){
                    
                    if(parseInt($jWDH(this).val()) >= slider_min && parseInt($jWDH(this).val()) <= slider_max){
                        var sliderValueIs = parseInt($jWDH(this).val());
                    } else if(parseInt($jWDH(this).val()) >= slider_min){
                        var sliderValueIs = slider_max;
                        $jWDH(this).val(sliderValueIs);
                    } else {
                        var sliderValueIs = slider_min;
                        $jWDH(this).val(sliderValueIs);
                    }
                    $jWDH('#wdh-slider-'+wfieldvalue).slider('value',sliderValueIs);
                    
                    window.valueNow = $jWDH('#wdh-slider-'+wfieldvalue).slider('value')+$jWDH('#wdh-select-'+wfieldvalue).val();
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                });
                
                // Adding select in Size
                $jWDH('#wdh-select-'+wfieldvalue).unbind('change');
                $jWDH('#wdh-select-'+wfieldvalue).bind('change', function(){
                    
                    window.valueNow = $jWDH('#wdh-slider-'+wfieldvalue).slider('value')+$jWDH(this).val();
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                });
            }
            
            
            // Adding slider & select in border
            if (inputType === 'border'){
                // Adding slider in Size
                $jWDH('#wdh-slider-'+wfieldvalue).append('<div class="wdh-slider-selected">&nbsp;</div>');
                $jWDH('#wdh-slider-'+wfieldvalue).slider({min: slider_min, max: slider_max, value: sliderValueNow, step: slider_range,slide:function(event,ui){
                        $jWDH('#wdh-slider-value-'+wfieldvalue).val(parseInt(ui.value));
                        // Values For Hook
                        window.valueNow = ui.value+$jWDH(id+' .wdh-select').eq(0).val()+' '+$jWDH(id+' .wdh-select').eq(1).val();
                        // Adding selected value
                        var widthMax = $jWDH('#wdh-slider-'+wfieldvalue).width(),
                            posSlider = $jWDH('#wdh-slider-'+wfieldvalue+' .ui-slider-handle').position(),
                            calcWidth = posSlider['left']*100/widthMax;
                        $jWDH('#wdh-slider-'+wfieldvalue+' .wdh-slider-selected').css('width',parseInt(calcWidth)+'%');
                        // Adding Hook
                        setTimeout(js_wdhedfp_onchange, 0);
                }});
                var widthMax = $jWDH('#wdh-slider-'+wfieldvalue).width(),
                    posSlider = $jWDH('#wdh-slider-'+wfieldvalue+' .ui-slider-handle').position(),
                    calcWidth = posSlider['left']*100/widthMax;
                $jWDH('#wdh-slider-'+wfieldvalue+' .wdh-slider-selected').css('width',parseInt(calcWidth)+'%');
                
                // Slider Changed Value
                $jWDH('#wdh-slider-value-'+wfieldvalue).unbind('keyup change blur');
                $jWDH('#wdh-slider-value-'+wfieldvalue).bind('keyup change blur', function(){
                    
                    if(parseInt($jWDH(this).val()) >= slider_min && parseInt($jWDH(this).val()) <= slider_max){
                        var sliderValueIs = parseInt($jWDH(this).val());
                    } else if(parseInt($jWDH(this).val()) >= slider_min){
                        var sliderValueIs = slider_max;
                        $jWDH(this).val(sliderValueIs);
                    } else {
                        var sliderValueIs = slider_min;
                        $jWDH(this).val(sliderValueIs);
                    }
                    $jWDH('#wdh-slider-'+wfieldvalue).slider('value',sliderValueIs);
                    
                    window.valueNow = $jWDH('#wdh-slider-'+wfieldvalue).slider('value')+$jWDH(id+' .wdh-select').eq(0).val()+' '+$jWDH(id+' .wdh-select').eq(1).val();
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                });
                
                // Adding select in Border
                $jWDH('#wdh-select-'+wfieldvalue).unbind('change');
                $jWDH('#wdh-select-'+wfieldvalue).bind('change', function(){
                    
                    window.valueNow = $jWDH('#wdh-slider-'+wfieldvalue).slider('value')+$jWDH(this).val()+' '+$jWDH(id+' .wdh-select').eq(1).val();
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                });
                
                // Adding select type in Border
                $jWDH('#wdh-select-type-'+wfieldvalue).unbind('change');
                $jWDH('#wdh-select-type-'+wfieldvalue).bind('change', function(){
                    
                    window.valueNow = $jWDH('#wdh-slider-'+wfieldvalue).slider('value')+$jWDH(id+' .wdh-select').eq(0).val()+' '+$jWDH(this).val();
                    // Adding Hook
                    setTimeout(js_wdhedfp_onchange, 0);
                });
            }
            //{min: slider_min, max: slider_max, value: valueNow, range: slider_range}
            // Disable enter
            $jWDH("body").keypress(function (evt) {
                var charCode = evt.charCode || evt.keyCode;
                
                if (charCode  == 13) { //Enter key's keycode
                    return false;
                }
            });
            
            // Adding save event
            $jWDH(id+' .wdh-submit').click(function(event){
                var submit = $jWDH(id+' .wdh-submit'),
                    submitHTMLis = submit.html();
                // New value
                switch (inputType){
                    case "text":
                        valueNow = $jWDH(id+' .wdh-input').val();
                        break;
                    case "textarea":
                        valueNow = $jWDH(id+' .wdh-textarea').val();
                        break;
                    case "select":
                        valueNow = $jWDH(id+' .wdh-select').val();
                    case "font":
                        valueNow = $jWDH(id+' .wdh-select').val();
                        break;
                    case "radio":
                        valueNow = $jWDH(id+' .wdh-radio-value').val();
                        break;
                    case "date":
                        valueNow = $jWDH(id+' .wdh-date').val();
                        break;
                    case "slider":
                        valueNow = $jWDH('#wdh-slider-value-'+wfieldvalue).val();
                        break;
                    case "size":
                        $jWDH(id).parent().css('width','50%');
                        valueNow = $jWDH('#wdh-slider-value-'+wfieldvalue).val()+$jWDH(id+' .wdh-select').val();
                        break;
                    case "border":
                        $jWDH(id).parent().css('width','50%');
                        valueNow = $jWDH('#wdh-slider-value-'+wfieldvalue).val()+$jWDH(id+' .wdh-select').eq(0).val()+' '+$jWDH(id+' .wdh-select').eq(1).val();
                        break;
                    case "checkbox":
                        valueNow = $jWDH(id+' .wdh-checkbox-value').val();
                        break;
                    case "map":
                        valueNow = $jWDH(id+' .wdh-input').val();
                        break;
                    case "video":
                        valueNow = wdhReplace("http://","",$jWDH(id+' .wdh-input').val());
                        valueNow = wdhReplace("https://","",$jWDH(id+' .wdh-input').val());
                        break;
                    case "password":
                        valueNow = $jWDH(id+' .wdh-password').val();
                        confirmValueNow = $jWDH(id+' .wdh-confirm-password').val();
                        break;
                    case "html_editor":
                        valueNow = $jWDH(id+' .wdh-html-editor').val();
                        break;
                }
                
                if (inputType != 'html_editor'){
                    valueNow = wdhSafeTags(valueNow);
                } else {
                    valueNow = wdhHTMLencode(valueNow);
                }
                
                errorTEXT = '';
                                        
                // Filters 
                // filter_is_required, filter_is_email, filter_is_url, filter_is_phone, filter_is_alpha, filter_is_numeric, filter_is_alphanumeric, filter_is_date 

                // Is Required 
                if (filter_is_required == true){

                    if(valueNow.length < 1 || valueNow =='...............'){
                        errorTEXT= error_is_required;
                    }
                }
                
                if (inputType == "text" || inputType == "textarea"){
                    
                    // Is email
                    if (filter_is_email == true){

                        if($jWDH(document).wdhIsEmail(valueNow) == false){
                            errorTEXT= error_is_email;
                        }
                    }

                    // Is url
                    if (filter_is_url == true){
                        valueNow = valueNow.replace('http://','');
                        valueNow = valueNow.replace('https://','');
                        if($jWDH(document).wdhIsUrl(valueNow) == false){
                            errorTEXT= error_is_url;
                        }
                    }

                    // Is Phone
                    if (filter_is_phone == true){
                        if($jWDH(document).wdhIsPhone(valueNow) == false){
                            errorTEXT= error_is_phone;
                        }
                    }

                    // Is Alpha
                    if (filter_is_alpha == true){
                        if($jWDH(document).wdhIsAlpha(valueNow) == false){
                            errorTEXT= error_is_alpha;
                        }
                    }

                    // Is AlphaNumeric
                    if (filter_is_alphanumeric == true){
                        if($jWDH(document).wdhIsAlphaNumeric(valueNow) == false){
                            errorTEXT= error_is_alphanumeric;
                        }
                    }
                }
                
                if (inputType == "text" || inputType == "textarea" || inputType == "slider"){
                    
                    // Is Numeric
                    if (filter_is_numeric == true){
                        if($jWDH(document).wdhIsNumeric(valueNow) == false){
                            errorTEXT= error_is_numeric;
                        }
                    }
                }
                
                if (inputType == "text" || inputType == "textarea" || inputType == "date"){
                    
                    // Is Date
                    if (filter_is_date == true){
                        
                        if($jWDH(document).wdhIsDate(valueNow) == false){
                            errorTEXT = error_is_date;
                        }
                    }
                }
                
                if (inputType == "video"){
                    
                    if ($jWDH(document).wdhVideoAutodetect(valueNow) != 1 && $jWDH(document).wdhVideoAutodetect(valueNow) != 2 && $jWDH(document).wdhVideoAutodetect(valueNow) != 3 && $jWDH(document).wdhVideoAutodetect(valueNow) != 4 && $jWDH(document).wdhVideoAutodetect(valueNow) != 5 && $jWDH(document).wdhVideoAutodetect(valueNow) != 6){
                        errorTEXT = error_not_video;
                    }
                    
                    if (filter_is_adult_video == false && ($jWDH(document).wdhVideoAutodetect(valueNow) == 5 || $jWDH(document).wdhVideoAutodetect(valueNow) == 6)){
                        errorTEXT = error_is_adult_video;
                    }
                    
                }
                
                // Is Unique
                if (oldValue == valueNow){
                    filter_is_unique = false;
                }
                
                // Validate password
                if (inputType == "password"){
                    
                    if (valueNow != confirmValueNow){
                        errorTEXT = error_password;
                    }
                }
               
                
                // Adding error message
                if (errorTEXT != ""){
                    var errorWidth = $jWDH(document).wdhTextWidth(errorTEXT)+20,
                        errorHeight = $jWDH(document).wdhTextHeight(errorTEXT)+5,
                        errorRight = -errorWidth-18;
                        $jWDH(id+' form').css('position','relative'); 
                        errorHTML = '<div class="error-arrow">&nbsp;</div><div class="error-box">'+errorTEXT+'</div>';
                        // Adding HTML Error
                        submit.after(errorHTML);
                        // Adding dimension box
                        $jWDH(id+' .error-box').css('width',errorWidth);
                        $jWDH(id+' .error-box').css('height',errorHeight);
                        $jWDH(id+' .error-box').css('right',errorRight);
                        // Display error box
                        $jWDH(id+' .error-arrow').css('display','block');
                        $jWDH(id+' .error-box').css('display','block');
                        
                }
                
                if (errorTEXT == ""){
                    // Adding loader
                    $jWDH(id).html(loaderHTML);
                    // Saving data
                    $jWDH.post(request_url,
                              {action: 'wdh_edit_field_db',
                               wdhDB_json:wdhDB_json,
                               wdhFIELD_json:wdhFIELD_json,
                               value:valueNow,
                               type:inputType,
                               is_unique:filter_is_unique
                              }, function(data){
                                  
                            if (data != 'wrong' && data != 'field_exist') {
                                if (data == 'success' || inputType == 'map' || inputType == 'video'){
                                // Removing HTML Error
                                $jWDH(id+' .error-arrow').remove();
                                $jWDH(id+' .error-box').remove();
                                
                                window.wdhSVWEChanges++;
                                $jWDH('.wdh-publish').removeClass('wdh-disabled');
                                
                                if (inputType == 'checkbox'){
                                    valueNow = wdhReplace('#',',',valueNow);
                                }
                                
                                if (inputType == 'html_editor'){
                                    valueNow = wdhHTMLdecode(valueNow);
                                }
                                
                                if (inputType === 'font'){
                                    valueNow = wdhReplace("+"," ",wdhGFontsName(valueNow));
                                }
                                
                                if (inputType != 'video'){
                                    // Adding Password
                                    if (inputType == 'password'){
                                        valueNow = '******';
                                    }
                                    $jWDH(id).html(valueNow);
                                }
                                
                                if (inputType == 'map'){
                                    var mapHTML = '';
                                    mapHTML = "  <iframe id="+id+"-map-box' class='wdh-map-box' width='"+map_width+"' height='"+map_height+"' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;z="+map_zoom+"&amp;ll="+data+"&amp;output=embed'></iframe>";
                                    $jWDH(id+'-map').html(mapHTML);
                                }
                                
                                if (inputType == 'video'){
                                    // Removing video margin-top
                                    $jWDH(id+'-player').css('marginTop','0');

                                    var videoId = JSON.parse($jWDH.trim(data))['id'],
                                        videoTitle = JSON.parse($jWDH.trim(data))['title'],
                                        videoImage = JSON.parse($jWDH.trim(data))['image'],
                                        videoLogo = JSON.parse($jWDH.trim(data))['logo'],
                                        videoType = JSON.parse($jWDH.trim(data))['type'],
                                        videoHTML = new Array(),
                                        videoNEWHTML = new Array();

                                        if (videoType != '0'){

                                            var idnew = wdhReplace("#","",id);
                                            $jWDH(id).html(videoTitle);
                                            $jWDH(id+'-player').remove();
                                            videoHTML.push("<div id='"+idnew+"-player'  style='width:"+video_width+"px !important; height:"+video_height+"px !important;' class='wdh-video-player'>");
                                            videoHTML.push("    <div class='wdh-video-player-mask' style='width:"+video_width+"px !important; height:"+video_height+"px !important;'>&nbsp;</div>");
                                            videoHTML.push("    <div class='wdh-video-player-play' id='"+idnew+"-play-now' style='width:"+video_width+"px !important; height:"+video_height+"px !important;'>&nbsp;</div>");
                                            videoHTML.push("    <div class='wdh-video-player-logo-"+videoLogo+"'>&nbsp;</div>");
                                            videoHTML.push("    <img src='"+videoImage+"' class='wdh-video-player-image' style='width:"+video_width+"px !important; height:"+video_height+"px !important;'/>");
                                            videoHTML.push("    <input name='"+idnew+"-player-url' id='"+idnew+"-player-url' type='hidden' value='http://"+valueNow+"'>");
                                            videoHTML.push("    <input name='"+idnew+"-player-id' id='"+idnew+"-player-id' type='hidden' value='"+videoId+"'>");
                                            videoHTML.push("    <input name='"+idnew+"-player-width' id='"+idnew+"-player-width' type='hidden' value='"+video_width+"'>");
                                            videoHTML.push("    <input name='"+idnew+"-player-height' id='"+idnew+"-player-height' type='hidden' value='"+video_height+"'>");
                                            videoHTML.push("    <input name='"+idnew+"-player-type' id='"+idnew+"-player-type' type='hidden' value='"+videoType+"'>");
                                            videoHTML.push("</div>");
                                            $jWDH(id).after(videoHTML.join(''));

                                            // Adding Video Iframe
                                            $jWDH(id+'player').unbind('click');
                                            $jWDH(id+'player').click(function(){
                                                var videoId = $jWDH(id+'-player-id').val(),
                                                    videoWidth = $jWDH(id+'-player-width').val(),
                                                    videoHeight = $jWDH(id+'-player-height').val(),
                                                    videoType = $jWDH(id+'-player-type').val(),
                                                    idnew = wdhReplace("#","",id),
                                                    videoPlayer = '',
                                                    videoHTML = new Array();
                                                    switch(videoType){
                                                        case "1":
                                                            videoHTML.push('<iframe width="'+videoWidth+'" height="'+videoHeight+'" src="//www.youtube.com/embed/'+videoId+'?hl=en&fs=1&autoplay=1" frameborder="0" allowfullscreen></iframe>');
                                                            break;
                                                        case "2":
                                                            videoPlayer = 'http://player.vimeo.com/video/'+videoId+'?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=1';
                                                            videoHTML = '<iframe src="'+videoPlayer+'" frameborder=0 width="'+videoWidth+'" height="'+videoHeight+'" scrolling=no webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                                                            break;
                                                        case "3":
                                                            videoPlayer = 'http://www.dailymotion.com/embed/video/'+videoId+'?logo=0&amp;autoPlay=1';
                                                            videoHTML = '<iframe src="'+videoPlayer+'" frameborder=0 width="'+videoWidth+'" height="'+videoHeight+'" allowFullScreen></iframe>';
                                                            break;
                                                        case "4":
                                                            videoPlayer = 'http://www.metacafe.com/embed/'+videoId+'?autoPlay=1';
                                                            videoHTML = '<iframe src="'+videoPlayer+'" frameborder=0 width="'+videoWidth+'" flashVars="playerVars=autoPlay=yes" height="'+videoHeight+'" allowFullScreen></iframe>';
                                                            break;
                                                        case "5":
                                                            videoPlayer = 'http://embed.redtube.com/player/?id='+videoId+'&style=redtube';
                                                            videoHTML = '<object width="'+videoWidth+'" height="'+videoHeight+'"><param name="allowfullscreen" value="true"><param name="AllowScriptAccess" value="always"><param name="movie" value="'+videoPlayer+'"><param name="FlashVars" value="id='+videoId+'&style=redtube&autostart=true"><embed src="'+videoPlayer+'" allowfullscreen="true" AllowScriptAccess="always" flashvars="autostart=true" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'+videoWidth+'" height="'+videoHeight+'" /></object>';
                                                            break;
                                                        case "6":
                                                            videoPlayer = 'http://flashservice.xvideos.com/embedframe/'+videoId+'/?autoplay=1&wmode=opaque';
                                                            videoHTML = '<iframe src="'+videoPlayer+'" frameborder=0 width="'+videoWidth+'" flashVars="playerVars=autoPlay=yes" height="'+videoHeight+'" allowFullScreen scrolling=no></iframe>';
                                                            break;
                                                    }


                                                    $jWDH(id+'player').empty();
                                                    $jWDH(id+'player').html(videoHTML.join(''));
                                             });

                                        } 
                                    
                                }
                                
                                // Values For Hook
                                window.valueNow = valueNow;
                                // Adding Hook
                                setTimeout(js_wdhedfp_after_save, 0);
                                
                                $jWDH(id).attr('title',tooltipTitle);
                                $jWDH(id).wdhEditDbField(wdhDB_json,wdhFIELD_json,wdhINPUT_json,wdhTOOLTIP_json,wdhFILTER_json,wdhERROR_json,wdhUPLOAD_json,valueNow,idField);
                            }
                            } else if (data == 'wrong'){
                                alert(video_not_exist);
                                location.reload();
                            } else if (data == 'field_exist'){
                                alert(error_is_unique);
                                location.reload();
                            }
                        });
                }
            });
            
        });
        }
        
        // Adding Video Iframe
        $jWDH(id+'-play-now').click(function(){
           var videoId = $jWDH(id+'-player-id').val(),
               videoWidth = $jWDH(id+'-player-width').val(),
               videoHeight = $jWDH(id+'-player-height').val(),
               videoType = $jWDH(id+'-player-type').val(),
               videoPlayer = '',
               videoHTML = '';
               
               switch(videoType){
                   case "1":
                       videoHTML = '<object width="'+videoWidth+'" height="'+videoHeight+'"><param name="movie" value="http://www.youtube.com/v/'+videoId+'&hl=en&fs=1&autoplay=1"></param><param name="allowFullScreen" value="true"></param><embed src="http://www.youtube.com/v/'+videoId+'&hl=en&fs=1&autoplay=1" type="application/x-shockwave-flash" allowfullscreen="true" width="'+videoWidth+'" height="'+videoHeight+'"></embed></object>';
                       break;
                   case "2":
                       videoPlayer = 'http://player.vimeo.com/video/'+videoId+'?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=1';
                       videoHTML = '<iframe src="'+videoPlayer+'" frameborder=0 width="'+videoWidth+'" height="'+videoHeight+'" scrolling=no webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                       break;
                   case "3":
                       videoPlayer = 'http://www.dailymotion.com/embed/video/'+videoId+'?logo=0&amp;autoPlay=1';
                       videoHTML = '<iframe src="'+videoPlayer+'" frameborder=0 width="'+videoWidth+'" height="'+videoHeight+'" allowFullScreen></iframe>';
                       break;
                    case "4":
                        videoPlayer = 'http://www.metacafe.com/embed/'+videoId+'?autoPlay=1';
                        videoHTML = '<iframe src="'+videoPlayer+'" frameborder=0 flashVars="playerVars=autoPlay=yes" width="'+videoWidth+'" height="'+videoHeight+'" allowFullScreen></iframe>';
                        break;
                    case "5":
                        videoPlayer = 'http://embed.redtube.com/player/?id='+videoId+'&style=redtube';
                        videoHTML = '<object width="'+videoWidth+'" height="'+videoHeight+'"><param name="allowfullscreen" value="true"><param name="AllowScriptAccess" value="always"><param name="movie" value="'+videoPlayer+'"><param name="FlashVars" value="id='+videoId+'&style=redtube&autostart=true"><embed src="'+videoPlayer+'" allowfullscreen="true" AllowScriptAccess="always" flashvars="autostart=true" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'+videoWidth+'" height="'+videoHeight+'" /></object>';
                        break;
                    case "6":
                        videoPlayer = 'http://flashservice.xvideos.com/embedframe/'+videoId+'/?autoplay=1&wmode=opaque';
                        videoHTML = '<iframe src="'+videoPlayer+'" frameborder=0 width="'+videoWidth+'" flashVars="playerVars=autoPlay=yes" height="'+videoHeight+'" allowFullScreen scrolling=no></iframe>';
                        break;
               }
               
               $jWDH(id+'-player').html(videoHTML);
        });
        
        
    },
    wdhGoogleMapCoordinates: function(request_url,location,type){
        $jWDH.post(request_url,
                          {action: 'wdh_edit_field_db',
                           value:location,
                           type:type,
                           is_unique:false
                          }, function(data){
                              
                         return data;
                    });
    },
    // SWITCH
    wdhEditDbFieldSwitch:function (wdhDB_json,wdhFIELD_json,wdhINPUT_json,wdhTOOLTIP_json,wdhFILTER_json,wdhERROR_json,wdhUPLOAD_json,valueNow,idField){
        var id = $jWDH(this)['selector'],
            currHtml = $jWDH(id).html(),
            dbTable = JSON.parse($jWDH.trim(wdhDB_json))['table'],
            dbfieldName = JSON.parse($jWDH.trim(wdhFIELD_json))['field_name'],
            conditions = JSON.parse($jWDH.trim(wdhFIELD_json))['conditions'],
            inputType = JSON.parse($jWDH.trim(wdhINPUT_json))['type'],
            tooltipType = JSON.parse($jWDH.trim(wdhTOOLTIP_json))['position'],
            tooltipTitle = JSON.parse($jWDH.trim(wdhTOOLTIP_json))['text'],
            js_wdhedfp_onchange = JSON.parse($jWDH.trim(wdhINPUT_json))['js_wdhedfp_onchange'],
            js_wdhedfp_after_save = JSON.parse($jWDH.trim(wdhINPUT_json))['js_wdhedfp_after_save'],
            wdbfieldvalue = idField,
            conditionAll = '',
            condition = new Array(),
            wfieldvalue = '',
            valueRadio = valueNow,
            valueCheckboxNew = valueNow,
            i = 0;
    
            // Adding ToolTip
            //$jWDH(id).wdhTooltip(tooltipType);
            
            // Adding save event for Switch
            $jWDH(id).click(function(event){
            // Get Checked value
            var isChecked = $jWDH(id).prop('checked');
                
            if (isChecked && (typeof isChecked !== 'undefined')){
                valueNow = 'true';
                $jWDH(id).attr('checked','');
            } else {
                valueNow = 'false';
            }
            
            // Values For Hook
            window.valueNow = valueNow;
            // Adding Hook
            setTimeout(js_wdhedfp_onchange, 0);
            
                // Disabled until save value
                $jWDH(id).attr('disabled','disabled');
                // Saving data
                $jWDH.post(request_url,
                          {action: 'wdh_edit_field_db',
                           wdhDB_json:wdhDB_json,
                           wdhFIELD_json:wdhFIELD_json,
                           value:valueNow,
                           type:inputType,
                           is_unique:false
                          }, function(data){

                        if (data == 'success'){
                            // Enable again
                            $jWDH(id).attr('disabled',false);
                            // Values For Hook
                            window.valueNow = valueNow;
                            window.wdhSVWEChanges++;
                            $jWDH('.wdh-publish').removeClass('wdh-disabled');
                            // Adding Hook
                            setTimeout(js_wdhedfp_after_save, 0);
                        }
                    });
            });
            
            
    },
    // COLORPICKER
    wdhEditDbFieldColorPicker:function (wdhDB_json,wdhFIELD_json,wdhINPUT_json,wdhTOOLTIP_json,wdhFILTER_json,wdhERROR_json,wdhUPLOAD_json,valueNow,idField){
        var id = $jWDH(this)['selector'],
            currHtml = $jWDH(id).html(),
            dbTable = JSON.parse($jWDH.trim(wdhDB_json))['table'],
            dbfieldName = JSON.parse($jWDH.trim(wdhFIELD_json))['field_name'],
            conditions = JSON.parse($jWDH.trim(wdhFIELD_json))['conditions'],
            inputType = JSON.parse($jWDH.trim(wdhINPUT_json))['type'],
            tooltipType = JSON.parse($jWDH.trim(wdhTOOLTIP_json))['position'],
            tooltipTitle = JSON.parse($jWDH.trim(wdhTOOLTIP_json))['text'],
            js_wdhedfp_onchange = JSON.parse($jWDH.trim(wdhINPUT_json))['js_wdhedfp_onchange'],
            js_wdhedfp_after_save = JSON.parse($jWDH.trim(wdhINPUT_json))['js_wdhedfp_after_save'],
            wdbfieldvalue = idField,
            conditionAll = '',
            condition = new Array(),
            wfieldvalue = '',
            valueRadio = valueNow,
            i = 0;
            
            // Adding ToolTip
            //$jWDH(id).wdhTooltip(tooltipType);
            
            // Adding colorpicker
            if (inputType == 'colorpicker'){
               
                $jWDH(id).ColorPicker({color:valueNow,
                    onChange: function(hsb, hex, rgb){
                        $jWDH(id).css('background','#'+hex);
                        $jWDH(id).val(hex);
                        $jWDH(id).ColorPickerSetColor(hex);
                        // Values For Hook
                        window.valueNow = hex;
                        // Adding Hook
                        setTimeout(js_wdhedfp_onchange, 0);
                    },
                    onSubmit:function(hsb, hex, rgb){
                        // Hide colorpicker
                        $jWDH('.colorpicker').css('display','none');
                        // Saving data ( in background )
                        $jWDH.post(request_url,
                                  {action: 'wdh_edit_field_db',
                                   wdhDB_json:wdhDB_json,
                                   wdhFIELD_json:wdhFIELD_json,
                                   value:hex,
                                   type:inputType,
                                   is_unique:false
                                  }, function(data){console.log(data);
                                      
                                if (data == 'success'){
                                    // Values For Hook
                                    window.valueNow = hex;
                                    window.wdhSVWEChanges++;
                                    $jWDH('.wdh-publish').removeClass('wdh-disabled');
                                    // Adding Hook
                                    setTimeout(js_wdhedfp_after_save, 0);
                                }
                        });
                    }
                });
                $jWDH('.colorpicker').css('z-index','10');
            }
            
    },
    //=== Filters 

    // Is Email 
    wdhIsEmail: function(val){
        
        if(!val.match(/\S+@\S+\.\S+/)){ // Jaymon's / Squirtle's solution
          // do something
          return false;
        }
        
        if( val.indexOf(' ')!=-1 || val.indexOf('..')!=-1){
          // do something
          return false;
        }
        return true;
    },
    
    // Is Url
    wdhIsUrl: function(str) {
        var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
        '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
        
        if(!pattern.test(str)) {
          return false;
        } else {
          return true;
        }
    },
            
    // Is Phone Number
    wdhIsPhone: function(phoneNumber){
        phoneNumber = phoneNumber.replace(/\D/g,'');
        
        if (phoneNumber.length == 10) {
            return true;
            }
        else {
            return false;
        }
    },
            
    // Is Alpha
    wdhIsAlpha: function(x) {
    var alphaOnly=true;
        if (x!='') {
            for (c=0; c<x.length; c++) {
            if (x.substr(c,1).match(/[^a-zA-Z]/) != null) {
                alphaOnly=false;
                break;
                }
            }
        }
        return alphaOnly;
    },
            
    // Is Numeric
    wdhIsNumeric: function(input){
        var RE = /^-{0,1}\d*\.{0,1}\d+$/;
        return (RE.test(input));
    },
    
    // Is AlphaNumeric
    wdhIsAlphaNumeric: function validateCode(TCode){
        if( /[^a-zA-Z0-9]/.test( TCode ) ) {
           return false;
        }
        return true;     
    },
    
    // Is Date
    wdhIsDate: function(dateStr) {
        s = dateStr.split('/');
        d = new Date(+s[2], s[0]-1, +s[1]);
        // DD/MM/YYYY => MM/DD/YYYY
        if (Object.prototype.toString.call(d) === "[object Date]") {
            if (!isNaN(d.getTime()) && d.getDate() == s[1] && 
                d.getMonth() == (s[0] - 1)) {
                return true;
            }
        }
        return false;
    }, // Check if is in database
    wdhIsInDatabase: function(wdhDB_json,wdhFIELD_json,value,loaderHTML){
        var id = $jWDH(this)['selector'],
            isInDB = 0;
        // Adding loader
        $jWDH(id).html(loaderHTML);
        $jWDH.post(request_url,
                {wdhDB_json:wdhDB_json,
                 wdhFIELD_json:wdhFIELD_json,
                 value:value,
                 type:'is_in_db'
                }, function(data){
              // Delete cookie 
              wdhEraseCookie('wdh_is_unique');
              wdhCreateCookie('wdh_is_unique',data,1);
        });
        isInDB = wdhReadCookie('wdh_is_unique');
        // Delete cookie 
        wdhEraseCookie('wdh_is_unique');
        return isInDB;
    },
    // Object to String
    wdhObjtoStr: function(string) {
        var params = { string_value:string };
        return $jWDH.param( params, true );
    },
    // VIDEO
    wdhVideoAutodetect: function(url){
        // 1 - youtube , 2 vimeo
        var findurl = 0;
        
        if(url.search('youtube.com') != -1 ){
          findurl = 1;
        }
        
        if(url.search('youtu.be') != -1 ){
          findurl = 1;
        }
        
        if(url.search('vimeo.com') != -1 ){
          findurl = 2;
        }
        
        if(url.search('dailymotion.com') != -1 ){
          findurl = 3;
        }
        
        if(url.search('metacafe.com') != -1 ){
          findurl = 4;
        }
        
        if(url.search('redtube.com') != -1 ){
          findurl = 5;
        }
        
        if(url.search('xvideos.com') != -1 ){
          findurl = 6;
        }
        
        return findurl;
    },
    
    wdhYoutubePlayerImage: function(){
        var videoHTML = '';
    }, // Show Error Message
    wdhErrorMessage: function(errorTEXT){
        var id = $jWDH(this)['selector'],
            errorWidth = $jWDH(document).wdhTextWidth(errorTEXT)+20,
            errorHeight = $jWDH(document).wdhTextHeight(errorTEXT)+5,
            errorRight = -errorWidth-18,
            errorHTML = '';
            $jWDH(id+' form').css('position','relative'); 
            errorHTML = '<div class="error-arrow">&nbsp;</div><div class="error-box">'+errorTEXT+'</div>';
            // Adding HTML Error
            submit.after(errorHTML);
            // Adding dimension box
            $jWDH(id+' .error-box').css('width',errorWidth);
            $jWDH(id+' .error-box').css('height',errorHeight);
            $jWDH(id+' .error-box').css('right',errorRight);
            // Display error box
            $jWDH(id+' .error-arrow').css('display','block');
            $jWDH(id+' .error-box').css('display','block');
    }, // Clear Error Message
    wdhClearErrorMessage: function(){
        var id = $jWDH(this)['selector'];
            // Removing HTML Error
            $jWDH(id+' form .error-arrow').remove();
            $jWDH(id+' form .error-box').remove(); 
    },
    wdhPlacehoder: function(text){
        var id = $jWDH(this)['selector'],
            onblur = "if(this.value =='"+text+"') this.value=''",
            onfocus = "if(this.value =='') this.value='"+text+"'";
        // Adding placeholder
        $jWDH(id).attr('onfocus',onblur);
        $jWDH(id).attr('onblur',onfocus);
        $jWDH(id).val(text);
    },
    wdhTextWidth:function(text){
            calc = '<span style="display:none">' + text + '</span>';
            $jWDH('body').append(calc);
        var width = $jWDH('body').find('span:last').outerWidth();
        $jWDH('body').find('span:last').remove();
        return width;
    },
            
    wdhTextHeight:function(text){
            calc = '<span style="display:none">' + text + '</span>';
            $jWDH('body').append(calc);
        var height = $jWDH('body').find('span:last').outerHeight();
        $jWDH('body').find('span:last').remove();
        return height;
    }
});

function wdhescapeRegExp(str) {
  return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
}

function wdhReplace(find, replace, str){
    return str.replace(new RegExp(wdhescapeRegExp(find), 'g'), replace);
}

function wdhEncodeURIComponent (str) {
  return wdhEncodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
}

function wdhSafeTags(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') ;
}

function wdhHTMLencode(str){
   str = wdhReplace('<', '#wdh1#', str);
   str = wdhReplace('>', '#wdh2#', str);
   str = wdhReplace('"', '#wdh3#', str);
   str = wdhReplace("'", '#wdh4#', str);
   return str;
}

function wdhHTMLdecode(str){
   str = wdhReplace('#wdh1#', '<', str);
   str = wdhReplace('#wdh2#', '>', str);
   str = wdhReplace('#wdh3#', '"', str);
   str = wdhReplace('#wdh4#', "'", str);
   return str;
}

// Sleep
function wdhSleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
      
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

// Google Fonts Name
function wdhGFontsName(text){
    text = wdhReplace("100","Thin",text);
    text = wdhReplace("200","Extra-Light",text);
    text = wdhReplace("300","Light",text);
    text = wdhReplace("400","Normal",text);
    text = wdhReplace("regular","Normal",text);
    text = wdhReplace("500","Medium",text);
    text = wdhReplace("600","Semi-Bold",text);
    text = wdhReplace("700","Bold",text);
    text = wdhReplace("800","Extra-Bold",text);
    text = wdhReplace("900","Ultra-Bold",text);
    text = wdhReplace("italic"," Italic",text);
    text = wdhReplace("oblique"," Oblique",text);
    text = wdhReplace(":","  ",text);

    return text;
}

// Google Fonts Name To Value
function wdhGFontsNameToValue(text){
    text = wdhReplace(" Thin",":100",text);
    text = wdhReplace(" Extra-Light",":200",text);
    text = wdhReplace(" Light",":300",text);
    text = wdhReplace(" Normal",":normal",text);
    text = wdhReplace(" Normal",":400",text);
    text = wdhReplace(" Normal",":regular",text);
    text = wdhReplace(" Medium",":500",text);
    text = wdhReplace(" Semi-Bold",":600",text);
    text = wdhReplace(" Bold",":700",text);
    text = wdhReplace(" Extra-Bold",":800",text);
    text = wdhReplace(" Ultra-Bold",":900",text);
    text = wdhReplace(" Italic","italic",text);
    text = wdhReplace(" Oblique","oblique",text);

    return text;
}

// Google Fonts Value Encode
function wdhGFontsValue(text){
    
    text = wdhReplace(" ","+",text);
    
    return text;
}

// Google Font Set
function wdhGFontSet(element, font){
    
    font = wdhReplace("+"," ",font);
    
    // Add Font Family
    element.css("font-family",font.split(':')[0]);
    
    // Reset Font Weight
    element.css("font-weight","inherit");
    
    // Add Font Weight
    if (parseInt(font.split(':')[1]) > 99) {
        element.css("font-weight",parseInt(font.split(':')[1]));
        $jWDH('.wdh-swve-font-weight span').html(parseInt(font.split(':')[1]));
    } else {
        $jWDH('.wdh-swve-font-weight span').html("400");
    }
    
    // Reset Font Style
    element.css("font-style","normal");
    $jWDH('.wdh-swve-font-style span').html("normal");
    
    // Add Font Style Italic
    if (font.indexOf('italic') !== -1) {
        element.css("font-style","italic");
        $jWDH('.wdh-swve-font-style span').html("italic");
    }
    
    // Add Font Style Oblique
    if (font.indexOf('oblique') !== -1) {
        element.css("font-style","oblique");
        $jWDH('.wdh-swve-font-style span').html("oblique");
    }
}

// Google Font Set
function wdhGFontSetHover(element, font){
    
    font = wdhReplace("+"," ",font);
    
    // Add Font Family
    $jWDH('head').append('<style>'+element+':hover{ font-family: '+font.split(':')[0]+'; }</style>');
    
    // Reset Font Weight
    $jWDH('head').append('<style>'+element+':hover{ font-weight: inherit; }</style>');
    
    // Add Font Weight
    if (parseInt(font.split(':')[1]) > 99) {
        $jWDH('head').append('<style>'+element+':hover{ font-weight: '+parseInt(font.split(':')[1])+'; }</style>');
        $jWDH('.wdh-swve-font-weight span').html(parseInt(font.split(':')[1]));
    } else {
        $jWDH('.wdh-swve-font-weight span').html("400");
    }
    
    // Reset Font Style
    $jWDH('head').append('<style>'+element+':hover{ font-style: normal; }</style>');
    $jWDH('.wdh-swve-font-style span').html("normal");
    
    // Add Font Style Italic
    if (font.indexOf('italic') !== -1) {
        $jWDH('head').append('<style>'+element+':hover{ font-style: italic; }</style>');
        $jWDH('.wdh-swve-font-style span').html("italic");
    }
    
    // Add Font Style Oblique
    if (font.indexOf('oblique') !== -1) {
        $jWDH('head').append('<style>'+element+':hover{ font-style: oblique; }</style>');
        $jWDH('.wdh-swve-font-style span').html("oblique");
    }
}

// Cookies
function wdhCreateCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function wdhReadCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function wdhEraseCookie(name) {
    wdhCreateCookie(name,"",-1);
}