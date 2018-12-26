var njt_folder_in_content = {};
(function($){
	
	njt_folder_in_content.render = function(data){

		var html = '';

		if(data.length){

			var folder_container = '<div class="njt-filebird-container"><ul></ul></div>';

			$('.attachments').before(folder_container); 

			data.forEach(function(item){

				html += '<li data-id="'+item.term_id+'"><div class="item jstree-anchor"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve">' +
						'<path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z" fill="#8f8f8f"></path><path d="M0 0h24v24H0z" fill="none"></path></svg></span><span class="item-containt">'+
						'<span class="folder-name">' + item.name + '</span></span></div></li>';

			});

			$('.njt-filebird-container ul').html(html);

			njt_folder_in_content.action();

		}
		
	}

	njt_folder_in_content.action = function(){
		$('.njt-filebird-container .item').on('click', function(){
			$('.njt-filebird-container .item').removeClass('active');
			
			$(this).addClass('active');
		});
		$('.njt-filebird-container .item').on('dblclick', function(){
			var folder_id = $(this).parent().data('id');
			$('#menu-item-' + folder_id + ' .jstree-anchor').trigger('click');
		});

		$('.njt-filebird-container .item').bind({

			mouseenter: function() {
				
		        var $this = $(this);
			    var parentWidth = $this.find('.item-containt').innerWidth();
			    var childWidth = $this.find('.folder-name').innerWidth();
			   	var title = 	$this.find('.folder-name').text();
			     if (parentWidth < (childWidth + 16) ) {
			     	
			         $this.tooltip({
			             title: title,
			             placement: "bottom",
			         });

			         $this.tooltip('show');

			     }

		    },

		    mouseleave: function() {

		        var $this = $(this);
	    		$this.tooltip('hide');

		    }

		});
	}
	

})(jQuery)