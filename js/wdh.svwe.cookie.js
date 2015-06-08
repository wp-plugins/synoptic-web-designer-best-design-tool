/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: js/wdh.svwe.cookie.js
 * File Description: Cookie Javascript File
 * File Version: 1.0
 * Last Update File : 22.09.2014
 * ------------------------------------------------------------------- 
 */

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

function svweInstallValidateField(field){
    var fieldValue = field.find('input').val(),
        error = false;

    if (fieldValue.length < 1) {
        error = true;
        field.find('.error').css('display','block');
    } else {
        field.find('.error').css('display','none');
    }
    
    return error;
}

