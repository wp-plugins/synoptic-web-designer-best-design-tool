/* -------------------------------------------------------------------
 * Project Name: Synoptic Web Designer: best WordPress design tool Light
 * Project Version: 1.0
 * Project URL: http://www.wdh.im/projects/synoptic-web-designer-best-wordpress-design-tool-light/
 * Author: WDH - Web Developers House
 * Author URL: http://www.wdh.im/
 * File: js/jquery.dom.path.js
 * File Description: DOM Path Library Javascript File
 * File Version: 1.0
 * Last Update File : 22.09.2014
 * ------------------------------------------------------------------- 
 */

(function( $ ){
    var getStringForElement = function (el) {
        var string = el.tagName.toLowerCase(),
            currentTag = el.tagName.toLowerCase(),
            nthChild = 0;
        
        if (currentTag !== 'body') {
            
            if (el.id && el.id.indexOf(' ') === -1) {
                string += "#" + el.id;
            }

            if (el.className && el.className.indexOf(' ') === -1) {
                string += "." + el.className.replace(/ /g, '.');
            }
        }
        
        if (string.indexOf('body') === -1) {
            
            nthChild = $(el).prevAll().length+1;

            if(nthChild > 0 && !el.id) {
                string += ':nth-child('+nthChild+')';
            }
            
        }
        
        return string;
    };

    $.fn.getDomPath = function(string) {
        var returned = '',
            elementNo = '';
        if (typeof(string) === "undefined") {
            string = true;
        }

        var p = [],
            el = $(this).first();
        el.parents().not('html').each(function() {
            var currentString = getStringForElement(this);
            
            if (currentString !== '') {
                p.push(currentString);
            }
        });
        p.reverse();
        p.push(getStringForElement(el[0]));
        returned = string ? p.join(" > ") : p;
        
        returned = removeHover(returned);
        returned = removeWDH(returned);
        returned = returned.split('.:').join(':');

        return returned;
    };

    // Element Position
    $.fn.getDomPosition = function(el, allItems){
        
        if (typeof el === 'undefined') {
            var el = $(this).first();
        }
        
        if (typeof allItems === 'undefined') {
            var allItems = $("body .wdh-"+elementTag);
        }
        
        var elementTag = $(el)[0].tagName.toLowerCase(),
            allItems = $("body .wdh-"+elementTag),
            elementPosition = elementIndex($(el)[0], allItems);
        return elementPosition;
    };

    // Element Tag
    $.fn.getDomTag = function(el){
        
        if (typeof el === 'undefined') {
            var el = $(this).first();
        }
        
        var elementTag = $(el)[0].tagName.toLowerCase();
            
        return elementTag;
    };
})( jQuery );


function wdhHoverRemover(text){
    var htmlElements = window.wdhSVWETags,
        htmlElementPrefix = window.wdhSVWETagPrefix,
        $ = jQuery.noConflict();

    // Remove Tags
    $.each(htmlElements, function(index, value){
        text = text.replace(new RegExp('.'+htmlElementPrefix+'-'+value+'-hover', 'g'), '');      text = text.replace(new RegExp('.wdh-h-hover', 'g'), '');
    });
    
    return text;
}

function reverse(s){
    return s.split("").reverse().join("");
}

function elementIndex(ele, allItems) {
    
    if(ele.sourceIndex){
        var eles = ele.parentNode.children;
        var low = 0, high = eles.length-1, mid = 0;
        var esi = ele.sourceIndex, nsi;
        //use binary search algorithm
        while (low <= high) {
            mid = (low + high) >> 1;
            nsi = eles[mid].sourceIndex;
            if (nsi > esi) {
                high = mid - 1;
            } else if (nsi < esi) {
                low = mid + 1;
            } else {
                return mid;
            }
        }
    }
    //other browsers
    var i=0;
    while(ele = ele.previousElementSibling){
        i++;
    }
    return i;
    //return -1;
}

function removeWDH(text){
    var htmlElements = window.wdhSVWETags,
        htmlElementPrefix = window.wdhSVWETagPrefix,
        $ = jQuery.noConflict();

    // Remove Tags
    $.each(htmlElements, function(index, value){
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
}

function removeHover(text){

    var htmlElements = window.wdhSVWETags,
        htmlElementPrefix = window.wdhSVWETagPrefix,
        $ = jQuery.noConflict();

    // Remove Tags
    $.each(htmlElements, function(index, value){
        text = text.replace(new RegExp('.'+htmlElementPrefix+'-'+value+'-hover', 'g'), '');      text = text.replace(new RegExp('.wdh-h-hover', 'g'), '');
    });
    
    text = text.replace(new RegExp('.ui-resizable', 'g'), '');
    text = text.replace(new RegExp('.ui-sortable', 'g'), '');

    return text;
}