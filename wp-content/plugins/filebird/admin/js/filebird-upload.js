
(function( $ ) {
	'use strict';

	var html = '',
		Core = {};

	$(document).ready(function(){
		Core.init();
		//Core.tooltip.init();
		Core.jstree.init();
		$( window ).scroll(function() {
		  
		   var scroll = $(window).scrollTop();
		   $('.filebird_sidebar, .njt-splitter').css('margin-top', scroll - 20 + 'px');

		});
		$('#njt-filebird-folderTree').mCustomScrollbar({
	        autoHideScrollbar: true
	    });
		
	});

	$(window).bind("load",function(){
		Core.toolbar.init();
	});
 	
	Core = {
		init : function(){
			html = '';
			html += $("#filebird_sidebar").html();
			$("#filebird_sidebar").remove();
			if($('.update-nag').length){
				$("#wp-media-grid").before('<div class="clear"></div>');
				$("#wp-media-grid").css('margin-top', '10px');
			}
			
			$("#wpbody .wrap").before(html);
			
			var tempStopResize = true;
			var njtMinWidth = 240;
			var njtMaxWidth = 800;

			$(".panel-left").fileBirdResizable({
				handleSelector: ".njt-splitter",
				resizeHeight: false,
				onDrag: function (e, $el, newWidth, newHeight, opt) {
				 // limit box size
					
				 	var x = e.pageX - $el.offset().left;
				 	
				 	if (newWidth < njtMinWidth){

				 		if(x > njtMinWidth - 40 ){
				 			
				 			return false;
				 			
				 		}
				 						 		
				 		$el.css('max-width', '0');

				 		$el.css('overflow', 'hidden');

				 		var $wrapAll = $('.wrap-all');
				 		$( ".njt-splitter").hide()
				 		$wrapAll.addClass('show-expand');
				 		if(!$('.wrap-all >  span').length){
				 			$('.wrap-all').prepend("<span class='njt-expand'></span>");
				 		}
				 		setTimeout(function(){
				 			$('.njt-expand').show();
				 		}, 600);	
			 			

			 			$('.njt-expand').on('click', function(){
							
							$(this).hide();
							$('.filebird_sidebar').css({'max-width': '800px', 'width': njtMinWidth + 5+ 'px'});
							$('.njt-splitter').show();
							$wrapAll.removeClass('show-expand');

						});
				 		
				 		return false;

				 	}else if(newWidth > njtMinWidth && $el.width > 0){
				 	
				 		
				 		$el.css('overflow', 'initial');
				 	}
				 	
				 	if(newWidth >= njtMaxWidth){
				 			
				 		return false;
				 	}

				 	
				 	
				 	//return false;

				}
			});

			
			
			
			$("#wpbody .wrap").addClass("appended")
			$('.filebird_sidebar, .njt-splitter, #wpbody .wrap').wrapAll('<div class="wrap-all"></div>');
			var data = {
				'action' : 'filebird_ajax_get_folder_list'
			};
			DhTreeFolder.init();
		},

		// Vakata Jstree
		jstree : {
			init: function(){
				Core.jstree.default();

				if(localStorage.getItem('current_folder') === 'all' || localStorage.getItem('current_folder') === 'undefined' || localStorage.getItem('current_folder') == null){
					$('#menu-item-all .menu-item-bar').trigger('click');
					
				}
			},
			// Init

			default: function(){
				if ($("#njt-filebird-defaultTree").length){

					$("#njt-filebird-defaultTree").jstree({
						'core' : {
							'themes' : {
								'responsive': false,
								 "icons":false
							}
						}
					});

					$('#njt-filebird-defaultTree').on("changed.jstree", function (e, data) {
						

						if(data.node){
							//only active selected node
							var catId = data.node.li_attr['data-id'];

							localStorage.setItem('current_folder', catId);
							$(".jstree-anchor.jstree-clicked").removeClass('jstree-clicked');
							$(".jstree-node.current-dir").removeClass('current-dir');
							$(".jstree-node[data-id='" + catId + "']").addClass('current-dir');
					 		$(".jstree-node[data-id='" + catId + "']").children('.jstree-anchor').addClass('jstree-clicked');

					 		if($('.jstree-anchor.need-refresh').length){

								var $filebird_sidebar = $('.filebird_sidebar');

								var backbone = ntWMC.ntWMCgetBackboneOfMedia ($filebird_sidebar);
								
							    if (backbone.browser.length > 0 && typeof backbone.view == "object") {
							        // Refresh the backbone view
							        try {
							            backbone.view.collection.props.set({ignore: (+ new Date())});
							        }catch(e) {console.log(e);};
							    }else{
							    	
							        window.location.reload();
							    }
							    $('.jstree-anchor.need-refresh').removeClass('need-refresh');

							}


					 		//trigger category on topbar
						    $('.wpmediacategory-filter').val(catId);
							$('.wpmediacategory-filter').trigger('change');
						}
						
						if($('.menu-item.current_folder').length){
							if (!$('select[name="njt_filebird_folder"]').length) {//grid list
								$('.menu-item.current_folder').removeClass('current_folder');
							}
						}
					 	
					});
				}
			},
			// Default			
		},
		//Jstree

		sweetAlert: {
			delete : function(node){
				
				var id = 0;
				if (Array.isArray(node)){
					id = node[0].data("id");;
				}else{
					id = node.data("id");;
				}
			

                var li = $('menu-item-'+id);

                if($(li).next().find(".menu-item-data-parent-id").length && $(li).next().find(".menu-item-data-parent-id").val() == id){
					swal({
						title: filebird_translate.oops,
						text: filebird_translate.folder_are_sub_directories,
						type: "error"
					});
				}else{

					swal({
						title: filebird_translate.are_you_sure, 
                        text: filebird_translate.not_able_recover_folder,
                        type: "warning",
                        confirmButtonText: filebird_translate.yes_delete_it,
                        showCancelButton: true,
                        cancelButtonText: filebird_translate.cancel,
					}).then(function(result){

						if (result.value) {

                            njt_trigger_folder.delete(id);

                            swal(filebird_translate.deleted + '!', filebird_translate.folder_deleted, "success");
                            
                        }
					});
				}
			}
		},
		//Sweet Alert

		toolbar: {
			init: function(){
				Core.toolbar.create();
				Core.toolbar.delete();
			},
			//Init

			create: function(){
				if ($(".js__nt_create").length){
					$(".js__nt_create").on("click",function(){

						var ref = $('#njt-filebird-folderTree').jstree(true),
								sel,
								type = $(this).data("type");
						sel = ref.create_node(null, {"type":type});

						if(sel) {
							ref.edit(sel);
						}
						
					});
				}				
			},
			//Create

			delete: function(){
				if ($(".js__nt_delete").length){
					$(".js__nt_delete").on("click",function(){
						var ref = $('#njt-filebird-folderTree .current_folder');
								
						if(!ref.length) { return false; }
						Core.sweetAlert.delete(ref);				
					});
				}				
			},
			//Delete
			
		},
		//Toolbar

		// Tipped Plugin
		tooltip : { 
			init: function(){
				if ($(".js__nt_tipped").length){
					Tipped.create(".js__nt_tipped",function(element){
						return {
							title : $(element).data("title"),
							content : $(element).data("content"),
						};
					},{
						skin: 'blue',
						maxWidth: 250,
					});
				}
			}
		},
		//Tooltip
	}

})( jQuery );
