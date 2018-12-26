(function( $ ) {
	'use strict';

	$(document).ready(function(){

		var Attachment = wp.media.view.Attachment.Library;

		var text_drag = filebird_translate.move_1_file;
		
		$("body").append('<div id="njt-filebird-attachment" data-id="">'+text_drag+'</div>');

		var drag_item = $("#njt-filebird-attachment");

		wp.media.view.Attachment.Library = wp.media.view.Attachment.Library.extend({

			initialize: function() {

				Attachment.prototype.initialize.apply(this, arguments);
				
				this.on("ready", function() {

					$(this.el)
						.drag("start",function(){

							var selected_files = $('.attachments li.selected');
							
							if(selected_files.length > 0){

								text_drag = filebird_translate.Move + ' ' + selected_files.length + ' ' + filebird_translate.files;

							}
							drag_item.html(text_drag) ;
							$('body').addClass('njt-draging');
							drag_item.show();
						})
						.drag("end",function(){
							drag_item.hide();
							$('body').removeClass('njt-draging');
						})
						.drag(function( ev, dd ){

							var id = $(this).data("id");

							drag_item.data("id", id);

							drag_item.css({
								"top" : ev.clientY - 15,
								"left" : ev.clientX - 15,
							});

						});

				});
			}
		});

		
		
		$("#wpcontent").on("drop", ".jstree-anchor", function(event){
			
			var des_folder_id = $(this).parent().attr('data-id');

			var ids = njt_get_seleted_files();

			if(ids.length){

				njt_move_multi_attachments(ids, des_folder_id, event);

			}else{
				
				njt_move_1_attachment(event, des_folder_id);

			}
			
			


		});//#wpcontent


		function njt_get_seleted_files(){

			var selected_files = $('.attachments li.selected');
			
			var ids = [];

			if(selected_files.length){

				selected_files.each(function(index, item) {

				    ids.push($(item).data("id"));

				});

				return ids;

			}

			return false;

		}//njt_get_seleted_files

		function njt_move_multi_attachments(ids, des_folder_id, event){

			$(event.target).addClass("need-refresh");
              	
				var data = {};

				data.ids = ids;

				data.folder_id = des_folder_id;

				data.action = 'filebird_save_multi_attachments';
				ntWMC.filebird_begin_loading ();
				jQuery.ajax({
	             	type : "POST",
	              	dataType: 'json',
	              	data : data,
	              	url : ajaxurl,
	              	success: function (res){

	              		if(res.success){
	              		
	              			res.data.forEach(function(item){
	              			

	              				ntWMC.updateCount(item.from, item.to);

	              			});
	              			$('.jstree-anchor').addClass("need-refresh");
	              			$('#menu-item-' + des_folder_id + ' .jstree-anchor').trigger('click');
							
	              		}

		              	ntWMC.filebird_finish_loading ();
		                
	              	}
		         });// ajax 2



		}//njt_move_multi_attachments

		function njt_move_1_attachment(event, des_folder_id){

			var attachment_id = drag_item.data("id");		

			var attachment_item = $('.attachment[data-id="' + attachment_id + '"]');

			

			var current_folder = $( ".wpmediacategory-filter" ).val();

			if(des_folder_id === 'all' || des_folder_id == current_folder)
				return;

			ntWMC.filebird_begin_loading ();

			jQuery.ajax({
              type : "POST",
              dataType: 'json',
              data : {id: attachment_id, action: 'nt_wcm_get_terms_by_attachment'},
              url : ajaxurl,
              success: function (resp){
              	// get terms of attachment
              	var terms = Array.from(resp.data, v => v.term_id);
              	//check if drag to owner folder
              
              	if(terms.includes(Number(des_folder_id))){

              		ntWMC.filebird_finish_loading ();

              		return;
              	}

              	$(event.target).addClass("need-refresh");
              	
				var data = {};

				data.id = attachment_id;

				//data.nonce = '158b7ba0e5';
				data.attachments = {};

				data.attachments[attachment_id] = { menu_order: 0};

				data.folder_id = des_folder_id;

				data.action = 'filebird_save_attachment';

				jQuery.ajax({
	             	type : "POST",
	              	dataType: 'json',
	              	data : data,
	              	url : ajaxurl,
	              	success: function (res){

	              		if(res.success){
	              		
	              			$.each(terms, function(index, value){
	              				
	              				ntWMC.updateCount(value, des_folder_id);
							});
	              			console.log(current_folder, terms.length);	
		              		//if attachment not in any terms (folder)
		              		if(current_folder === 'all' && !terms.length){
		              			
		              			//ntWMC.updateCount(-1, null);
		              			
		              			ntWMC.updateCount(-1, des_folder_id);
		              		}
		              		
		              		if(current_folder == -1){
		              		
		              			ntWMC.updateCount(-1, des_folder_id);
		              		}

							if(current_folder != 'all' ){

								attachment_item.detach();
							}
							
	              		}

		              	ntWMC.filebird_finish_loading ();
		              	$('#menu-item-' + des_folder_id + ' .jstree-anchor').trigger('click');
		                
	              	}
		         });// ajax 2
				

              }
          	});//ajax 1
		} //njt_move_1_attachment

		setTimeout(function(){
			var curr_folder = localStorage.getItem('current_folder') || 'all';
			$('#menu-item-' + curr_folder + ' .jstree-anchor').trigger('click');
		}, 1000);

		$('.menu-item-bar').bind({

			mouseenter: function() {
		        var $this = $(this);
			    var parentWidth = $this.find('.item-title').innerWidth();
			    var childWidth = $this.find('.menu-item-title').innerWidth();
			   	var title = 	$this.find('.menu-item-title').text();
			   	//console.log(parentWidth, childWidth)
			     if (parentWidth < (childWidth + 10) ) {
			     	
			         $this.tooltip({
			             title: title,
			             placement: "bottom",
							//delay: { "show": 500, "hide": 100 }
			         });
			         $this.tooltip('show');
			     }
		    },
		    mouseleave: function() {
		        var $this = $(this);
	    		$this.tooltip('hide');
		    }

		});


	});//ready

		
	// $(document).on('ready', function () {

	//      var $this = $('#menu-item-355 .jstree-anchor');
	   
	     
	     	
	//          $this.tooltip({
	//              title: 'aaaaaaa aaaaaaa aaaaaaa aaaaaaa aaaaaaa aaaaaaa aaaaaaa aaaaaaa aaaaaaa aaaaaaa',
	//              placement: "bottom"
	//          });
	//          $this.tooltip('show');
	    
	//  });

})( jQuery );