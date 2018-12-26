
	var njt_trigger_folder = {};

	// var event = jQuery.Event( "logged" );

(function( $ ) {
	'use strict';


	njt_trigger_folder.jQueryExtensions = function() {

		$.fn.extend({

			move_folder : function(){
				return this.each(function(){
			                        var item = $(this),
			                            //input = item.find( '.menu-item-data-parent-id' ),
			                            depth = parseInt( item.menuItemDepth(), 10 ),
			                            parentDepth = depth - 1,
			                            parent = item.prevAll( '.menu-item-depth-' + parentDepth ).first();
			                        var new_parent = 0;   
			                        if (0 !== depth) {
			                            new_parent = parent.find('.menu-item-data-db-id').val();
			                        }
			                        //input.val(new_parent);

			                       
			                      	var current = item.find('.menu-item-data-db-id').val();
			                        njt_trigger_folder.updateFolderList(current, new_parent, 'move');
			                    });
			}

	 	});
	}();


	njt_trigger_folder.rename = function(current, new_name){

  		ntWMC.filebird_begin_loading ();

   		var jdata = {
						'action' 		: 	'filebird_ajax_update_folder_list',
						'current' 		: 	current,
						'new_name'		: 	new_name,
						'type' 			: 	'rename'
					};
					
		$.post(ajaxurl,jdata,function(response){

			if (response == 'error'){

				swal({
					title : filebird_translate.oops, 
					text: filebird_translate.this_folder_is_already_exists, 
					type: "error"
				}).then(function(){
					location.reload();

				});

			}

		}).fail(function() {

			swal({
				title : filebird_translate.error, 
				text: filebird_translate.error_occurred, 
				type: "error"
			}).then(function(){
				location.reload();

			});

		}).complete(function(){
			ntWMC.filebird_finish_loading();
		});
		
   		
	}

	njt_trigger_folder.delete = function(current){

  		ntWMC.filebird_begin_loading ();
  		
   		var data = {
			'action' 	: 	'filebird_ajax_delete_folder_list',
			'current' 	: 	current,
		};
		//2. Delete folder
		$.post(ajaxurl,data,function(response){
			if (response == 'error'){
				swal({
					title : filebird_translate.error,
					text: filebird_translate.folder_cannot_be_delete, 
					type: "error"
				}).then(function(){
					location.reload();
				});
			}
			
			
		}).fail(function() {
			swal({
				title : filebird_translate.error,
				text: filebird_translate.error_occurred,
				type: "error"
			}).then(function(){
				location.reload();
			});
		}).success(function(response){

			ntWMC.updateCountAfternDeleteFolder(response);
			$('.menu-item.uncategory .jstree-anchor').addClass('need-refresh');
			
			if(current == localStorage.getItem("current_folder")){
				localStorage.removeItem("current_folder");
			}

			var parent_id = $('#menu-item-'+current).find('.menu-item-data-parent-id').val();                                    
			
            if(parent_id){

                if (! $(".menu-item .menu-item-data-parent-id").filter(function() { 

                    return ($(this).val() == parent_id); 

                }).length) {
                	
                    $("#menu-item-" + parent_id + " .dh-tree-icon").removeClass('open close');
                }
                
            }

            $('#menu-item-'+current).remove();

			ntWMC.filebird_finish_loading();
		});
		
   		
	}

	njt_trigger_folder.new = function(name, parent){

  		ntWMC.filebird_begin_loading ();
  		
   		var data = {
			'action' 	: 	'filebird_ajax_update_folder_list',
			'new_name' 	: 	name,
			'parent'	: parent,
			'folder_type': 'default',
			'type': 'new'
		};
		
		//2. Delete folder
		$.post(ajaxurl,data,function(response){
			if (response == 'error'){
				swal({
					title : filebird_translate.error,
					text: filebird_translate.folder_cannot_be_delete, 
					type: "error"
				}).then(function(){
					location.reload();
				});
			}



		}).fail(function() {
			swal({
				title : filebird_translate.error,
				text: filebird_translate.error_occurred,
				type: "error"
			}).then(function(){
				location.reload();
			});
		}).success(function(response){

			filebird_taxonomies.folder.term_list.push({term_id: response.data.term_id, term_name: "new tmp folder"});
			var $filebird_sidebar = $('.filebird_sidebar');
			var backbone = ntWMC.ntWMCgetBackboneOfMedia ($filebird_sidebar);

			if (typeof backbone.view === "object") {
                var filebird_Filter = backbone.view.toolbar.get("folder-filter");
                if(typeof backbone.view === "object"){
                	filebird_Filter.createFilters();
                }
            }
           
            var $new_option = $("<option></option>").attr("value",response.data.term_id).text('new tmp folder');
			$( ".wpmediacategory-filter" ).append($new_option);
			$(".jstree-anchor.jstree-clicked").removeClass('jstree-clicked');
			// 	$('#'+node.id).attr('data-id', response).attr('data-jstree', '{"type":"default"}').children('.jstree-anchor').addClass('jstree-clicked need-refresh');
			// $("#" + node.id).data("id",response);


			njt_trigger_folder.update_folder_position(); 
			ntWMC.filebird_finish_loading();
		});
		
   		
	}

	njt_trigger_folder.updateFolderList = function(current, new_parent, type){
  
   		var jdata = {
						'action' 		: 	'filebird_ajax_update_folder_list',
						'current' 		: 	current,
						'new_name'		: 	0,
						'parent' 		: 	new_parent,
						'type' 			: 	type,
						'folder_type'	: 	'folder'
					};
					
		$.post(ajaxurl,jdata,function(response){

			if (response == 'error'){

				swal({
					title : filebird_translate.oops, 
					text: filebird_translate.this_folder_is_already_exists, 
					type: "error"
				}).then(function(){

					location.reload();

				});

			}else{
				// $('#njt-filebird-folderTree .jstree-container-ul').append($(data.element).parent());
				njt_trigger_folder.update_folder_position();
				
				$('.need-refresh').trigger( "click" );
			}
		}).fail(function() {

			swal({
				title : filebird_translate.error, 
				text: filebird_translate.error_occurred, 
				type: "error"
			}).then(function(){

				location.reload();

			});

		});
		
   		
	}

	njt_trigger_folder.update_folder_position = function(){

		ntWMC.filebird_begin_loading ();
			var result = "";
			var str = '';
			$("#njt-filebird-folderTree .menu-item-data-db-id").each(function(){
				str += '0'
				
				if (result != ""){
					result = result + "|";
				}
				result = result + $(this).val() + "," + str;
				
			});
				
			var data = {
				'action' : 'filebird_ajax_update_folder_position',
				'result' : result
			}
				
			// 3. Update position for folder order
			$.post(ajaxurl,data,function(response){
				if (response == 'error'){
					swal({
						title :filebird_translate.oops, 
						text: filebird_translate.something_not_correct + filebird_translate.this_page_will_reload,
						type: "error"
					}).then(function(){
						location.reload();
					});
				}
				ntWMC.filebird_finish_loading ();
			}).fail(function() {
				ntWMC.filebird_finish_loading ();
				swal({
					title : filebird_translate.error, 
					text: filebird_translate.error_occurred,
					type: "error"
				}).then(function(){
					location.reload();
				});
			}).success(function(response){
				
				var current_folder_id = $('.wpmediacategory-filter').val();
				$('#menu-item-' + current_folder_id + ' .jstree-anchor').addClass('need-load-children');
				$('#menu-item-' + current_folder_id + ' .jstree-anchor').trigger('click');

			});
	}

	njt_trigger_folder.filter_media = function($element){

		if ($element == null) {
             
        } else {
              
            //var catId = $element.closest('.menu-item').find('.menu-item-data-db-id').val();
            var catId = $element.closest('.menu-item').data('id');
            if($('.need-refresh').length){

				var $filebird_sidebar = $('.filebird_sidebar');

				var backbone = ntWMC.ntWMCgetBackboneOfMedia ($filebird_sidebar);
				
			    if (backbone.browser.length > 0 && typeof backbone.view == "object") {
			        // Refresh the backbone view
			        try {
			            backbone.view.collection.props.set({ignore: (+ new Date())});
			        }catch(e) {console.log(e);};
			    }else{
			    	//window.location.reload();
			    }
			    $('.need-refresh').removeClass('need-refresh');

			}
	 		//trigger category on topbar
		    $('.wpmediacategory-filter').val(catId);
			$('.wpmediacategory-filter').trigger('change');
			$('.attachments').css('height','auto');


        }

	}

	njt_trigger_folder.getChildFolder = function(folder_id){
		
		if($('.njt-filebird-container').length){

			$('.njt-filebird-container').remove();

		}

   		var data = {
			'action' 	: 	'filebird_ajax_get_child_folders',
			'folder_id' 	: 	folder_id,
		};
		
		$.post(ajaxurl,data,function(response){


		}).fail(function() {

			
		}).success(function(response){

			njt_folder_in_content.render(response.data);
		});

	}

    $( '#njt-filebird-folderTree .jstree-anchor').dblclick(function(e) {
    	 e.preventDefault();
        
      
    });

    var NJT_DELAY = 200, njt_clicks = 0, njt_timer = null;
    //check truong hop click va double click
	$(document).on('click', '.filebird_sidebar .jstree-anchor', function(event) {
		var $this = $(this), folder_id = $this.closest('.menu-item').data('id');
		njt_clicks++; 
		if(njt_clicks === 1) {
			if ($('select[name="njt_filebird_folder"]').length) {//list mode
				$('select[name="njt_filebird_folder"]').val(folder_id);
				if ($('.njt-filebird-loader').hasClass('loading')) {
					return;
				}
				ntWMC.filebird_begin_loading();
				njt_timer = setTimeout(function() {
			        var form_data = $('#posts-filter').serialize();
					$.ajax({
						url: njt_filebird_dh.upload_url,
						type: 'GET',
						data: form_data,
					})
					.done(function(html) {
						window.history.pushState({}, "", njt_filebird_dh.upload_url + '?' + form_data);
					    njt_after_loading_media(html, folder_id);
					})
					.fail(function() {
						ntWMC.filebird_finish_loading();
						console.log("error");
					});
			      	oldCurrentFolder = localStorage.getItem("current_folder")
	                njt_clicks = 0;             //after action performed, reset counter

	            }, NJT_DELAY);
            } else {
            	njt_timer = setTimeout(function() {
			        njt_trigger_folder.filter_media($this);
			        
	            	if(oldCurrentFolder != localStorage.getItem("current_folder") || $this.hasClass('need-load-children')){
	            		njt_trigger_folder.getChildFolder(folder_id);
	            		$this.removeClass('need-load-children')
	            	}
			      	oldCurrentFolder = localStorage.getItem("current_folder")

	                njt_clicks = 0;             //after action performed, reset counter

	            }, NJT_DELAY);	
            }
        } else {
            clearTimeout(njt_timer);    //prevent single-click action
            $('.js__nt_rename').trigger('click');  //perform double-click action
            njt_clicks = 0;             //after action performed, reset counter
        } 
    });
    $(document).on('click', '.pagination-links a', function(event) {
    	event.preventDefault();
    	var $this = $(this);
    	if ($('.njt-filebird-loader').hasClass('loading')) {
			return;
		}
    	ntWMC.filebird_begin_loading();
		$.ajax({
			url: $this.attr('href'),
			type: 'GET',
			data: {},
		})
		.done(function(html) {
			 window.history.pushState({}, "", $this.attr('href'));
			njt_after_loading_media(html, $('select[name="njt_filebird_folder"]').val());
		})
		.fail(function() {
			ntWMC.filebird_finish_loading();
			console.log("error");
		});
    	return false;
    });
    $(document).on('submit', '#posts-filter', function(event) {
    	event.preventDefault();
    	var $this = $(this);
    	if ($('.njt-filebird-loader').hasClass('loading')) {
			return;
		}
    	ntWMC.filebird_begin_loading();
    	var form_data = $('#posts-filter').serialize();
    	$.ajax({
			url: njt_filebird_dh.upload_url,
			type: 'GET',
			data: form_data,
		})
		.done(function(html) {
			window.history.pushState({}, "", njt_filebird_dh.upload_url + '?' + form_data);
			njt_after_loading_media(html, $('select[name="njt_filebird_folder"]').val());
		})
		.fail(function() {
			ntWMC.filebird_finish_loading();
			console.log("error");
		});
    	return false;
    });
	function njt_after_loading_media(html, folder_id)
	{
		$('.wrap').html($(html).find('.wrap').html());
		$('#folders-to-edit li').removeClass('current_folder');
		$('ul.jstree-container-ul li').removeClass('current-dir current_folder');

		//set curret folder
		if (folder_id == '' || folder_id == null) {
			$('#menu-item-all').addClass('current-dir');
		} else if (folder_id == '-1') {
			$('#menu-item--1').addClass('current-dir');
		} else {
			$('#menu-item-' + folder_id).addClass('current_folder');
		}
		//set folder select
		$.each(filebird_taxonomies.folder.term_list, function(index, el) {
			$('.wpmediacategory-filter').append('<option value="'+el.term_id+'">'+el.term_name+'</option>');
		});
		$('.wpmediacategory-filter').val(folder_id);
		//add behavior
		var drag_item = $("#njt-filebird-attachment");
		var text_drag = filebird_translate.move_1_file;
		$.each($('table.wp-list-table tr'), function(index, el) {
			$(el).drag("start",function(){
				var selected_files = $('.wp-list-table input[name="media[]"]:checked');
				if(selected_files.length > 0){
					text_drag = filebird_translate.Move + ' ' + selected_files.length + ' ' + filebird_translate.files;
				}
				drag_item.html(text_drag);
				drag_item.show();
				$('body').addClass('njt-draging');
			})
			.drag("end",function(){
				drag_item.hide();
				$('body').removeClass('njt-draging');
			})
			.drag(function( ev, dd ){
				var id = $(this).attr("id");
				id = id.match(/post-([\d]+)/);
				drag_item.data("id", id[1]);
				drag_item.css({
					"top" : ev.clientY - 15,
					"left" : ev.clientX - 15,
				});
			});
		});
		//remove loading
		ntWMC.filebird_finish_loading();
	}
})( jQuery );