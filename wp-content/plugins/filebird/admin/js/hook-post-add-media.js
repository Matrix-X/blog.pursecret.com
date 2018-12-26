//add media to folder on all page
(function( $ ) {
    'use strict';
    var nt_wcm_post_folder_id = -1;
    setInterval(function(){ 


        $( ".njt-filebird-editcategory-filter" ).change(function(e){
            //check human select
            if (e.originalEvent !== undefined)
            {
                nt_wcm_post_folder_id = Number($( ".njt-filebird-editcategory-filter" ).val());
            }else{

            }
        });

        var $filebird_category_filter = $('.media-toolbar-secondary .wpmediacategory-filter');
        var $filebird_editcategory_filter = $('.njt-filebird-editcategory-filter');

        if($filebird_category_filter.length && $filebird_editcategory_filter.length){
            $filebird_category_filter.on('change', function(){
                
                $filebird_editcategory_filter.val($filebird_category_filter.val());
                $filebird_editcategory_filter.trigger('change');
                nt_wcm_post_folder_id = Number($filebird_category_filter.val());
                
            });     
        }



     }, 1000);
    $(document).ready(function(){
        var wp = window.wp;
        
        
        //Upload on page Media Library (upload.php)
        if (typeof wp !== 'undefined' && typeof wp.Uploader === 'function') {
            $.extend( wp.Uploader.prototype, {
                init : function() {
                  
                    if (this.uploader) {

                        this.uploader.bind('FileFiltered', function( up, file ) {
                           
                        });

                       this.uploader.bind('FilesAdded', function( up, files ) {
                            // for ( var i = 0 ; i < files.length ; i++ ) {
                            //     // Get current folder options
                            //    var post_folder_id = Number($( ".njt-filebird-editcategory-filter" ).val());
                            // }
                        });   

                        this.uploader.bind('BeforeUpload', function(uploader, file) {
                            var params = uploader.settings.multipart_params;
                             console.log('nt_wcm_post_folder_id', nt_wcm_post_folder_id)
                            if(Number.isInteger(nt_wcm_post_folder_id) && nt_wcm_post_folder_id > 0){
                                params.ntWMCFolder = nt_wcm_post_folder_id;
                            }
                        
                            
                        })

                        this.uploader.bind('UploadProgress', function(up, file) {
                         
                        });

                        this.uploader.bind('UploadComplete', function(up, files) {

                            // if($('.wpmediacategory-filter.need-refresh').length){

                                var $media_toolbar_secondary = $('.media-toolbar-secondary');

                                var backbone = ntWMC.ntWMCgetBackboneOfMedia($media_toolbar_secondary);
                                
                                if (backbone.browser.length > 0 && typeof backbone.view == "object") {
                                   
                                    // Refresh the backbone view
                                    try {
                                        backbone.view.collection.props.set({ignore: (+ new Date())});
                                    }catch(e) {console.log(e);};
                                }else{
                                    console.log('test-err')
                                   // window.location.reload();
                                }
                               // $('.wpmediacategory-filter.need-refresh').removeClass('need-refresh');

                            // }

                            //backbone here
                        });

                    }

                }
            });
        }

        
    });


})( jQuery );