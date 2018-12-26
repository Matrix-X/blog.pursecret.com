( function( $ ) {

	'use strict';

	$(document).ready(function($){

		$('.saga-about-notice .btn-dismiss').on('click',function(e) {

			e.preventDefault();

			var $this = $(this);

			var userid = $(this).data('userid');
			var nonce = $(this).data('nonce');

			$.ajax({
				type     : 'GET',
				dataType : 'json',
				url      : ajaxurl,
				data     : {
					'action'   : 'blog_elite_dismiss',
					'userid'   : userid,
					'_wpnonce' : nonce
				},
				success  : function (response) {
					if ( true === response.status ) {
						$this.parents('.saga-about-notice').fadeOut('slow');
					}
				}
			});
		});

        $('.saga-section .faq-title').on('click',function(e) {
        	e.preventDefault();
            $(this).next().slideToggle();
            $(".faq-content").not($(this).next()).slideUp();
		});

	});

} )( jQuery );