
//create hidden select to filter
window.wp = window.wp || {};

(function($){
	'use strict';
	var media = wp.media;
	
	media.view.AttachmentFilters.Taxonomy = media.view.AttachmentFilters.extend({	
	
		tagName:   'select',
		
		createFilters: function() {
			
			var filters = {};
		
			_.each(filebird_taxonomies.folder.term_list || {}, function( term, key ) {
				var term_id = term['term_id'];
				var term_name = $("<div/>").html(term['term_name']).text();
				filters[ term_id ] = {
					text: term_name,
					priority: key+2
				};
				filters[term_id]['props'] = {};
				filters[term_id]['props'][filebird_folder] = term_id;
			});
			
			filters.all = {
				text: filebird_taxonomies.folder.list_title,
				priority: 1
			};
			filters['all']['props'] = {};
			filters['all']['props'][filebird_folder] = null;

			this.filters = filters;
		}
	});
	
	var curAttachmentsBrowser = media.view.AttachmentsBrowser;
	
	media.view.AttachmentsBrowser = media.view.AttachmentsBrowser.extend({
		
		createToolbar: function() {

			//set backbone for attachment container
	    	var treeLoaded = jQuery.Deferred();
	        this.$el.data("backboneView", this);
          
	        this._treeLoaded = treeLoaded;
	        //end set backbon for attachment container
			
			curAttachmentsBrowser.prototype.createToolbar.apply(this,arguments);

			var that = this;
			var myNewFilter = new wp.media.view.AttachmentFilters.Taxonomy({
	        		className: 'wpmediacategory-filter attachment-filters',
    				controller: that.controller,
    				model:      that.collection.props,
    				priority:   -75
    			}).render();

			this.toolbar.set('folder-filter', myNewFilter);
			myNewFilter.initialize();
			
		}
	});
	
})( jQuery );