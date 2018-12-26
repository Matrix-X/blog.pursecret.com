
(function( $ ) {
    'use strict';
    var filebird_media = {};
    // For add new media
    filebird_media.addMedia = function(){

        if (!$("body").hasClass("media-new-php")) {
            return;
        }
        setTimeout(function() {
            if (uploader) {
                uploader.bind('BeforeUpload', function(uploader, file) {
                    var params = uploader.settings.multipart_params;
                    params.ntWMCFolder = $('.njt-filebird-editcategory-filter').val();
                    var mediaRowFilename = $('#media-item-' + file.id).find(".filename");
                });
            }
        }.bind(this), 500);
    }

    $(document).ready(function(){
        var wp = window.wp;
       
        filebird_media.addMedia();

    });
})( jQuery );
/*
 * For Media > "Add new"
 * 
 * Adds the property to the asyn-upload.php file and modifies the output row while
 * uploading a new file. 
 * 
 * @see wp-includes/js/plupload/handlers.js
 */