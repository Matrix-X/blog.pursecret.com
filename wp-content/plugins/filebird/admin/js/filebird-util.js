'use strict';
var ntWMC = {};
ntWMC.filebird_begin_loading = function(){
	jQuery('.njt-filebird-loader').addClass('loading');
}
ntWMC.filebird_finish_loading = function(){

    jQuery('.njt-filebird-loader.loading').removeClass('loading').addClass('finish');
    setTimeout(function(){ 
         jQuery('.njt-filebird-loader.finish').removeClass('finish');
    }, 400);
	
}
ntWMC.ntWMCgetBackboneOfMedia = function(obj) {
    // Get the attachments browser
    var parentModal = obj.parents(".media-modal"),
        browser, backboneView;
    if (parentModal.length > 0) {
        browser = parentModal.find(".attachments-browser");
    }else{
        browser = jQuery("#wpbody-content .attachments-browser");
    }
    backboneView = browser.data("backboneView");
    return { browser: browser, view: backboneView };
}
ntWMC.updateCount = function(term_from, term_to){

    if(term_from == -1){
        jQuery('.menu-item.uncategory .jstree-anchor').addClass('need-refresh');
    }

    if(term_from != term_to){
        if(term_from){
            var count_term_from = jQuery('.menu-item[data-id="' + term_from + '"]').attr('data-number');
            count_term_from = Number(count_term_from) -1;
            if(count_term_from){
                jQuery('.menu-item[data-id="' + term_from + '"]').attr('data-number', count_term_from);
            }else{
                jQuery('.menu-item[data-id="' + term_from + '"]').removeAttr('data-number');
            }
        }
        if(term_to){
            var count_term_to = jQuery('.menu-item[data-id="' + term_to + '"]').attr('data-number');
            if(!count_term_to){
                count_term_to = 0;
            }
            count_term_to = Number(count_term_to) +1;

            jQuery('.menu-item[data-id="' + term_to + '"]').attr('data-number', count_term_to);
        }
    }
    
}

ntWMC.updateCountAfternDeleteFolder = function(deleted_count){

    var count_term_to = jQuery('.menu-item.uncategory').attr('data-number');
    if(typeof count_term_to == 'undefined'){
        count_term_to = 0;
    }
    count_term_to = Number(count_term_to) + Number(deleted_count);
    jQuery('.menu-item.uncategory').attr('data-number', count_term_to);
    jQuery('.menu-item.uncategory .jstree-anchor').addClass('need-refresh');
}