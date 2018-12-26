var DhTreeFolder, oldCurrentFolder = null ;

var njt_filebird_free = true;
var njt_filebird_pro_link = 'https://goo.gl/8e19F6';



(function($) {

    var api;

    api = DhTreeFolder = {

        options : {
            menuItemDepthPerLevel : 30, // Do not use directly. Use depthToPx and pxToDepth instead.
            globalMaxDepth:  11,
            sortableItems:   '> *',
            targetTolerance: 0
        },

        menuList : undefined,   // Set in init.
        menusChanged : false,
        isRTL: !! ( 'undefined' != typeof isRtl && isRtl ),
        negateIfRTL: ( 'undefined' != typeof isRtl && isRtl ) ? -1 : 1,
        menus: {"moveUp":"Move up one","moveDown":"Move down one","moveToTop":"Move to the top","moveUnder":"Move under %s","moveOutFrom":"Move out from under %s","under":"Under %s","outFrom":"Out from under %s","menuFocus":"%1$s. Menu item %2$d of %3$d.","subMenuFocus":"%1$s. Sub item number %2$d under %3$s."},
        current_folder: localStorage.getItem('current_folder') || 'all',
        current_parent: null,
        old_parent: null,
        state: (localStorage.getItem("tree_state"))? localStorage.getItem("tree_state").split(",") : [],

        // Functions that run on init.
        init : function() {
            api.menuList = $('#folders-to-edit');
            this.jQueryExtensions();
            if (api.menuList.length){
                this.initSortables();
            }
            this.setIcons();
            this.newBehavior();
        },
        njt_filebird_upgrade_options: function(){
            var options =  {
                        title : filebird_translate.notice,
                        html: filebird_translate.limit_folder, 
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: filebird_translate.ok,
                        cancelButtonText: filebird_translate.no_thank,
                        confirmButtonClass: 'bnt-upgrade',
                        cancelButtonClass: 'btn-text',
                      
                    };
                return options;

        },
        setIcons: function() {
            var lis = api.menuList.find('li.menu-item');
           
            $.each(lis, function(index, el) {
                var depth = $(el).menuItemDepth();

                var next_li = $(el).next();
                if (next_li.hasClass('menu-item')) {
                    var depth_next = next_li.menuItemDepth();

                    if (depth_next > depth) {
                      
                        if(api.state.indexOf($(el).data('id').toString()) < 0){

                            var children = $(el).childMenuItems();
                       
                            children.wrapAll('<li class="new-wrapper children_of_'+$(el).attr('id')+'"><ul></ul></li>');

                            $(el).find('.dh-tree-icon').addClass('has_children').addClass('close');

                        }else{

                            $(el).find('.dh-tree-icon').addClass('has_children').addClass('open');

                        }

                    }
                }
            });


            $(document).on('click', '.dh-tree-icon.has_children', function(event) {
                event.preventDefault();
                var $this = $(this);
                var li = $this.closest('li.menu-item');
                var li_id = li.data('id');
                if ($this.hasClass('open')) {
                    var children = li.childMenuItems();
                    
                    children.wrapAll('<li class="new-wrapper children_of_'+li.attr('id')+'"><ul></ul></li>');
                    $this.removeClass('open').addClass('close');

                  
                    api.state.splice(api.state.indexOf(li_id.toString()), 1);
                    localStorage.setItem("tree_state", api.state);

                } else if($this.hasClass('close')) {
                    var children = $('.children_of_'+li.attr('id') + ' >ul>li.menu-item');
                    /*var depthChange = children.first().menuItemDepth() - li.menuItemDepth();
                    if (depthChange > 1) {
                        children.shiftDepthClass(0 - (depthChange - 1));
                    }*/

                    children.unwrap().unwrap();
                    $this.removeClass('close').addClass('open');
                    if(api.state.indexOf(li_id.toString()) < 0){
                        api.state.push(li_id);
                        localStorage.setItem("tree_state", api.state);
                    }
                    
                    
                }
                oldCurrentFolder = localStorage.getItem("current_folder");
                localStorage.setItem("current_folder", li_id);
                li.find('.jstree-anchor').trigger('click');

            });
        },
        newBehavior: function() {
            $(document).on('click', '.menu-item-bar', function(event) {
                event.preventDefault();
                var $this = $(this);
                api.doSetCurrentFolder($this);
            });
            $.contextMenu({
                selector: '.menu-item-bar', 
                animation: {duration: 200, show: "slideDown", hide: "slideUp"},
                zIndex: 999,
                callback: function(key, options) {
                    if (key == 'new') {

                        if($('#folders-to-edit li').length >= 10 && njt_filebird_free){

                         
                            swal(api.njt_filebird_upgrade_options()).then((result) => {
                                     var value = result.value;
                                    switch (value) {
                                        case true:
                                           var win = window.open(njt_filebird_pro_link, '_blank');
                                          break;
                                        default:
                                          break;
                                    }
                            })

                            return false;
                        }

                        api.doSetCurrentFolder(options.$trigger);
                        api.doInsertFolder();
                    } else if(key == 'rename') {
                        if($('.folder-input').length){
                            $('.folder-input').focus();
                            var input = $('.folder-input');
                            input.putCursorAtEnd().on("focus", function() { // could be on any event
                              input.putCursorAtEnd();
                            });
                            return;
                        }
                        var li = options.$trigger.closest('.menu-item');
                        var e_id = li.find('.menu-item-data-db-id').val();
                        var folder_name = li.find('.menu-item-title').text();
                        var depth = li.menuItemDepth();
                        var html = api.editFolderFormTemplate(e_id, folder_name, 'menu-item-depth-' + depth);

                        $(html).insertAfter(li);
                        var input = $('.edit-folder-name')
                        input.putCursorAtEnd().on("focus", function() { // could be on any event
                          input.putCursorAtEnd();
                        });

                        li.hide();
                    } else if(key == 'delete') {

                        var li = options.$trigger.closest('.menu-item');

                        var e_id = li.find('.menu-item-data-db-id').val();

                        if ($(li).next().find(".menu-item-data-parent-id").length && $(li).next().find(".menu-item-data-parent-id").val() == e_id){
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
                                // confirmButtonColor: '#8CD4F5',
                                // cancelButtonColor: '#8CD4F5'
                                
                            }).then(function(result){
                                if (result.value) {

                                    njt_trigger_folder.delete(e_id);

                                    swal(filebird_translate.deleted + '!', filebird_translate.folder_deleted, "success");
                                    
                                }
                            });
                        }
                        
                    }
                },
                items: {
                    "new": {name: filebird_translate.new_folder, icon: 'context-menu-icon context-menu-icon-new'},
                    "rename": {name: filebird_translate.rename, icon: "context-menu-icon context-menu-icon-rename"},
                    "delete": {name: filebird_translate.delete, icon: "context-menu-icon context-menu-icon-delete"}
                }
            });
            $(document).on('click', '.edit-folder-cancel', function(event) {
                event.preventDefault();
                var $this = $(this);
                $('#menu-item-' + $this.closest('.edit-folder-wrap').data('id')).show();
                $('.edit-folder-wrap').remove();
            });
            $(document).on('click', '.edit-folder-now', function(event) {
                event.preventDefault();
                var $this = $(this);
                var new_name = $('.edit-folder-name').val();
                if (new_name == '') {
                    alert('Please enter your folder name.');
                    return false;
                } else {
                    var id = $this.closest('.edit-folder-wrap').data('id');
                    var li = $('#menu-item-' + id);
                    li.find('.menu-item-title').text(new_name);
                    li.show();
                    $('.edit-folder-wrap').remove();
                    njt_trigger_folder.rename( id, new_name);
                    $.event.trigger({
                        type: 'DhTreeFolder_renamed',
                        id: id,
                        new_name: new_name
                    });
                    
                }
                
            });
            $(document).on('keypress', '.edit-folder-name', function(event) {
               
                if ( event.which == 13 ) {

                    event.preventDefault();

                    $('.edit-folder-now').trigger('click');
                   
                }
                
                
            });

             $(document).on('keypress', '.add-new-folder-name', function(event) {
               
                if ( event.which == 13 ) {

                    event.preventDefault();

                    $('.add-new-folder-now').trigger('click');
                   
                }
                
                
            });



            $(document).on('click', '.add-new-folder-now', function(event) {
                event.preventDefault();
                if($('#folders-to-edit li').length >= 10 && njt_filebird_free){

                    var $content = $('div');
                    swal(api.njt_filebird_upgrade_options()).then((result) => {
                             var value = result.value;
                            switch (value) {
                                case true:
                                   var win = window.open(njt_filebird_pro_link, '_blank');
                                  break;
                                default:
                                  break;
                            }
                    })
                    return false;

                }
                var $this = $(this);
                var name = $('.add-new-folder-name').val();
                if (name == '') {
                    alert('Please enter folder name!');
                } else {
                    var parent = 0;
                    var depth = 0;

                    var parent_e = $('#menu-item-' + parent);
                    var parent_depth = 0;
                    if (api.current_folder != null) {
                        parent = api.current_folder;
                        //find depth
                        parent_e = $('#menu-item-' + parent);
                        depth = parent_e.menuItemDepth()
                        parent_depth = depth;
                        depth = parseInt(depth) + 1;
                        //end finding depth
                    }                    

                    ntWMC.filebird_begin_loading ();
        
                    var data = {
                        'action'    :   'filebird_ajax_update_folder_list',
                        'new_name'  :   name,
                        'parent'    : parent,
                        'folder_type': 'default',
                        'type': 'new'
                    };
                    
                 
                    $.post(ajaxurl,data,function(response){
                        if (response == 'error'){
                            swal({
                                title : filebird_translate.error,
                                text: filebird_translate.error_occurred, 
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

                      
                        var new_folder_html = api.newFolderTemplate(response.data.term_id, response.data.term_name, parent, depth);
                        $('.new-folder-wrap').remove();
                        if (api.current_folder == null) {
                            $('#folders-to-edit').append(new_folder_html);
                        } else {
                            //insert to the last child
                            var e = $('[class="menu-item-data-parent-id"][value="'+api.current_folder+'"]');
                            if(e.length == 0) {
                                $(new_folder_html).insertAfter($('#menu-item-' + api.current_folder));
                                $('#menu-item-' + api.current_folder).find('.dh-tree-icon').addClass('has_children open');
                            } else {
                                var li = $('#menu-item-' + api.current_folder);
                                var all_after_li = li.nextAll();
                                $.each(all_after_li, function(index, el) {
                                    var _depth = $(el).menuItemDepth();
                                    if (_depth <= parent_depth) {
                                        $(new_folder_html).insertAfter($(el).prev());
                                        //$(el).prev().find('.dh-tree-icon').addClass('has_children open');
                                        return false;
                                    } else if(index == (all_after_li.length - 1)) {
                                        $(new_folder_html).insertAfter($(el));
                                        //parent_e.find('.dh-tree-icon').addClass('has_children open');
                                    }
                                });
                               
                            }
                        }


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
                        //  $('#'+node.id).attr('data-id', response).attr('data-jstree', '{"type":"default"}').children('.jstree-anchor').addClass('jstree-clicked need-refresh');
                        // $("#" + node.id).data("id",response);


                        njt_trigger_folder.update_folder_position(); 
                        if(parent && api.state.indexOf(parent.toString()) < 0){
                            api.state.push(parent);
                            localStorage.setItem("tree_state", api.state);
                        }
                        

                        ntWMC.filebird_finish_loading();
                    });


                }
            });
            $(document).on('click', '.add-new-folder-cancel', function(event) {
                event.preventDefault();
                $('.new-folder-wrap').remove();
            });
            $('.new-folder').click(function(event) {

                if($('#folders-to-edit li').length >= 10 && njt_filebird_free){

                     
                     swal(api.njt_filebird_upgrade_options()).then((result) => {
                             var value = result.value;
                            switch (value) {
                                case true:
                                   var win = window.open(njt_filebird_pro_link, '_blank');

                                  break;
                                default:
                                  break;
                            }
                    })
                    return false;
                }

                api.doInsertFolder();
            });
             $(document).on('click', '#njt-filebird-defaultTree .jstree-anchor', function(event) {
                event.preventDefault();
                api.doSetCurrentFolder();
            });

            $( '#njt-filebird-folderTree .jstree-anchor').dblclick(function(e) {


                e.preventDefault();
                setTimeout(function(){ 
                    $('.js__nt_rename').trigger('click');

                   
                }, 100);
                
              
            });
            $('.js__nt_rename').click(function(event) {
                if($('.folder-input').length){
                    $('.folder-input').focus();
                    var input = $('.folder-input');
                    input.putCursorAtEnd().on("focus", function() { // could be on any event
                      input.putCursorAtEnd();
                    });
                    return false;
                }

                var li = $('.menu-item.current_folder');
                if(li.length){
                   // li = li[0];
                    var e_id = li.find('.menu-item-data-db-id').val();
                    var folder_name = li.find('.menu-item-title').text();
                    var depth = li.menuItemDepth();
                    var html = api.editFolderFormTemplate(e_id, folder_name, 'menu-item-depth-' + depth);
                    $(html).insertAfter(li);
                    li.hide();
                    $('.edit-folder-name').focus();

                    var input = $('.edit-folder-name')
                    input.putCursorAtEnd().on("focus", function() { // could be on any event
                      input.putCursorAtEnd();
                    });
                }
               
            });
        },
        doSetCurrentFolder: function($element)
        {
            if ($element == null) {
                api.menuList.find('li.menu-item').removeClass('current_folder');
                api.current_folder = null;
            } else {
                api.menuList.find('li.menu-item').removeClass('current_folder');
                $element.closest('.menu-item').addClass('current_folder');
                $('.jstree-anchor.jstree-clicked').removeClass('jstree-clicked');
                $('.jstree-node.current-dir').removeClass('current-dir');

                api.current_folder = $element.closest('.menu-item').find('.menu-item-data-db-id').val();

                localStorage.setItem('current_folder', api.current_folder);

            }
            
        },
        doInsertFolder: function()
        { 
            if($('.folder-input').length){
                    $('.folder-input').focus();
                    var input = $('.folder-input');
                    input.putCursorAtEnd().on("focus", function() { // could be on any event
                      input.putCursorAtEnd();
                    });
                    return false;
                }

            if(!$('#menu-item-' + api.current_folder).length){
                api.current_folder = null;
                localStorage.removeItem('current_folder');

            }
        
           
            //api.options.globalMaxDepth
            if (api.current_folder == null) {
                $('#folders-to-edit').append(api.newFolderFormTemplate());
            } else {
                 
                //find depth
                var parent_e = $('#menu-item-' + api.current_folder);
                var depth = parent_e.menuItemDepth()
                var parent_depth = depth;
                depth = parseInt(depth) + 1;
                //end finding depth
                if (depth >= (api.options.globalMaxDepth + 1)) {
                    alert('The max Depth is: ' + api.options.globalMaxDepth);
                } else {
                    //open folder if it was closed
                    var icon = $('#menu-item-' + api.current_folder).find('.dh-tree-icon');
                    if (icon.hasClass('close')) {
                        icon.trigger('click');
                    }
                    //insert to the last child
                    var e = $('[class="menu-item-data-parent-id"][value="'+api.current_folder+'"]');
                    if (e.length == 0) {

                        $(api.newFolderFormTemplate('menu-item-depth-' + depth)).insertAfter($('#menu-item-' + api.current_folder));
                    } else {
                        var li = $('#menu-item-' + api.current_folder);

                        var all_after_li = li.nextAll();
                        $.each(all_after_li, function(index, el) {
                            var _depth = $(el).menuItemDepth()
                            
                            if (_depth <= parent_depth) {
                                
                                $(api.newFolderFormTemplate('menu-item-depth-' + depth)).insertAfter($(el).prev());
                                return false;
                            } else if(index == (all_after_li.length - 1)) {
                                $(api.newFolderFormTemplate('menu-item-depth-' + depth)).insertAfter($(el));
                                return false;
                            }
                        });

                    }

                   
                }
            }
             $('.add-new-folder-name').focus();
        },
        newFolderFormTemplate: function(extra_class) {
            if (typeof extra_class == 'undefined') {
                extra_class = '';
            }
            return '<li class="new-folder-wrap '+extra_class+'"><input type="text" name="add-new-folder-name" value="" class="folder-input add-new-folder-name" id="" autocomplete="off" /><div class="action"><span class="add-new-folder-cancel button button-default button-small">Cancel</span>&nbsp<span class="add-new-folder-now button button-primary button-small">Ok</span></div></li>';
        },
        editFolderFormTemplate: function(id, val, extra_class) {
            if (typeof extra_class == 'undefined') {
                extra_class = '';
            }
            if (typeof val == 'undefined') {
                val = '';
            }
            return '<li data-id="'+id+'" class="edit-folder-wrap '+extra_class+'"><input type="text" name="edit-folder-name" value="'+val+'" class="folder-input edit-folder-name" id="" autocomplete="off" /><div class="action"><span class="edit-folder-cancel  button button-default button-small">Cancel</span>&nbsp;<span class="edit-folder-now  button button-primary button-small">Ok</span></div></li>';
        },
        newFolderTemplate: function(id, name, parent, depth) {
            return '<li id="menu-item-'+id+'" data-id= "' + id+  '" class="menu-item menu-item-depth-'+depth+'">'+
                '<i class="dh-tree-icon"></i>'+
                '<div class="menu-item-bar jstree-anchor">'+
                    '<div class="menu-item-handle ui-sortable-handle">'+
                        '<span class="item-title"><span class="menu-item-title">'+name+'</span>'+
                    '</span></div>'+
                '</div>'+
                '<ul class="menu-item-transport"></ul>'+
                '<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id['+id+']" value="'+id+'">'+
                '<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id['+id+']" value="'+parent+'">'+
            '</li>';
        },
        jQueryExtensions : function() {
            // jQuery extensions
            $.fn.extend({
                menuItemDepth : function() {
                    var margin = api.isRTL ? this.eq(0).css('margin-right') : this.eq(0).css('margin-left');
                    return api.pxToDepth( margin && -1 != margin.indexOf('px') ? margin.slice(0, -2) : 0 );
                },
                updateDepthClass : function(current, prev) {
                    return this.each(function(){
                        var t = $(this);
                        prev = prev || t.menuItemDepth();
                        $(this).removeClass('menu-item-depth-'+ prev )
                            .addClass('menu-item-depth-'+ current );
                    });
                },
                shiftDepthClass : function(change) {
                    return this.each(function(){
                        var t = $(this),
                            depth = t.menuItemDepth(),
                            newDepth = depth + change;

                        t.removeClass( 'menu-item-depth-'+ depth )
                            .addClass( 'menu-item-depth-'+ ( newDepth ) );

                        if ( 0 === newDepth ) {
                            t.find( '.is-submenu' ).hide();
                        }
                    });
                },
                childMenuItems_bk : function() {
                    var result = $();
                    this.each(function(){
                        var t = $(this), depth = t.menuItemDepth(), next = t.next( '.menu-item' );
                        while( next.length && next.menuItemDepth() > depth ) {
                            result = result.add( next );
                            next = next.next( '.menu-item' );
                        }
                    });
                    return result;
                },
                childMenuItems : function() {
                    var result = $();
                    this.each(function(){
                        var t = $(this), depth = t.menuItemDepth(), next = t.next( 'li' );
                        while( next.length && next.menuItemDepth() > depth || next.hasClass('new-wrapper')) {
                            //if(next.hasClass('menu-item')){
                                result = result.add( next );
                            //}
                            
                            next = next.next( 'li' );
                        }
                    });
                    return result;
                },
                updateParentMenuItemDBId : function() {
                    return this.each(function(){
                        var item = $(this),
                            input = item.find( '.menu-item-data-parent-id' ),
                            depth = parseInt( item.menuItemDepth(), 10 ),
                            parentDepth = depth - 1,
                            parent = item.prevAll( '.menu-item-depth-' + parentDepth ).first();
                        var new_parent = 0;   
                        if (0 !== depth) {
                            new_parent = parent.find('.menu-item-data-db-id').val();
                        }
                        input.val(new_parent);
                        if (new_parent != api.current_parent) {
                            $.event.trigger({
                                type: 'DhTreeFolder_parent_changed',
                                new_parent: new_parent,
                                id: item.find('.menu-item-data-db-id').val(),
                            })
                            console.log('parent changed');
                            api.state.push(new_parent);
                            localStorage.setItem("tree_state", api.state);
                        }
                        api.current_parent = null;
                    });
                },
                putCursorAtEnd : function() {

                      return this.each(function() {
                        
                        // Cache references
                        var $el = $(this),
                            el = this;

                        // Only focus if input isn't already
                        if (!$el.is(":focus")) {
                         $el.focus();
                        }

                        // If this function exists... (IE 9+)
                        if (el.setSelectionRange) {

                          // Double the length because Opera is inconsistent about whether a carriage return is one character or two.
                          var len = $el.val().length * 2;
                          
                          // Timeout seems to be required for Blink
                          setTimeout(function() {
                            el.setSelectionRange(len, len);
                          }, 1);
                        
                        } else {
                          
                          // As a fallback, replace the contents with itself
                          // Doesn't work in Chrome, but Chrome supports setSelectionRange
                          $el.val($el.val());
                          
                        }

                        // Scroll to the bottom, in case we're in a tall textarea
                        // (Necessary for Firefox and Chrome)
                        this.scrollTop = 999999;

                      });

                }
            });
        },
        initSortables : function() {
            var currentDepth = 0, originalDepth, minDepth, maxDepth,
                prev, next, prevBottom, nextThreshold, helperHeight, transport,
                menuEdge = api.menuList.offset().left,
                body = $('body'), maxChildDepth,
                menuMaxDepth = initialMenuMaxDepth();

            if( 0 !== $( '#folders-to-edit li' ).length )
                $( '.drag-instructions' ).show();

            // Use the right edge if RTL.
            menuEdge += api.isRTL ? api.menuList.width() : 0;

            api.menuList.sortable({
                handle: '.menu-item-handle',
                placeholder: 'sortable-placeholder',
                items: api.options.sortableItems,
                start: function(e, ui) {
                    var height, width, parent, children, tempHolder;

                    // handle placement for rtl orientation
                    if ( api.isRTL )
                        ui.item[0].style.right = 'auto';

                    transport = ui.item.children('.menu-item-transport');

                    // Set depths. currentDepth must be set before children are located.
                    originalDepth = ui.item.menuItemDepth();
                    updateCurrentDepth(ui, originalDepth);

                    // Attach child elements to parent
                    // Skip the placeholder
                    parent = ( ui.item.next()[0] == ui.placeholder[0] ) ? ui.item.next() : ui.item;
                    children = parent.childMenuItems();
                    if (true) {}
                    transport.append( children );

                    // Update the height of the placeholder to match the moving item.
                    height = transport.outerHeight();
                    // If there are children, account for distance between top of children and parent
                    height += ( height > 0 ) ? (ui.placeholder.css('margin-top').slice(0, -2) * 1) : 0;
                    height += ui.helper.outerHeight();
                    helperHeight = height;
                    height -= 2; // Subtract 2 for borders
                    ui.placeholder.height(height);

                    // Update the width of the placeholder to match the moving item.
                    maxChildDepth = originalDepth;
                    children.each(function(){
                        var depth = $(this).menuItemDepth();
                        maxChildDepth = (depth > maxChildDepth) ? depth : maxChildDepth;
                    });
                    width = ui.helper.find('.menu-item-handle').outerWidth(); // Get original width
                    width += api.depthToPx(maxChildDepth - originalDepth); // Account for children
                    width -= 2; // Subtract 2 for borders
                    ui.placeholder.width(width);

                    // Update the list of menu items.
                    tempHolder = ui.placeholder.next( '.menu-item' );
                    tempHolder.css( 'margin-top', helperHeight + 'px' ); // Set the margin to absorb the placeholder
                    ui.placeholder.detach(); // detach or jQuery UI will think the placeholder is a menu item
                    $(this).sortable( 'refresh' ); // The children aren't sortable. We should let jQ UI know.
                    ui.item.after( ui.placeholder ); // reattach the placeholder.
                    tempHolder.css('margin-top', 0); // reset the margin

                    // Now that the element is complete, we can update...
                    updateSharedVars(ui);
                    api.current_parent = ui.item.find('.menu-item-data-parent-id').val()

                    api.old_parent = ui.item.prev();
                },
                stop: function(e, ui) {
                    var children, subMenuTitle,
                        depthChange = currentDepth - originalDepth;

                    // Return child elements to the list
                    if ($('.children_of_' + ui.item.attr('id')).length) {
                        $('.children_of_' + ui.item.attr('id')).insertAfter(ui.item);
                    } else {
                        children = transport.children().insertAfter(ui.item);
                    }
                    $.each($('.new-wrapper'), function(index, el) {
                        $(el).insertAfter('#menu-item-' + $(el).attr('class').match(/children_of_menu-item-(\d)+/)[1]);
                    });
                    // Add "sub menu" description
                    subMenuTitle = ui.item.find( '.item-title .is-submenu' );
                    if ( 0 < currentDepth )
                        subMenuTitle.show();
                    else
                        subMenuTitle.hide();

                    // Update depth classes
                    if ( 0 !== depthChange ) {
                        ui.item.updateDepthClass( currentDepth );
                        
                        if ($('.children_of_' + ui.item.attr('id')).length) {
                            children = $('.children_of_' + ui.item.attr('id')).find('.menu-item');
                            children.shiftDepthClass( depthChange );
                        } else {
                            children.shiftDepthClass( depthChange );
                        }
                        updateMenuMaxDepth( depthChange );
                    }

                    // Register a change
                    api.registerChange();
                    // Update the item data.
                    ui.item.updateParentMenuItemDBId();

                    // address sortable's incorrectly-calculated top in opera
                    ui.item[0].style.top = 0;

                    // handle drop placement for rtl orientation
                    if ( api.isRTL ) {
                        ui.item[0].style.left = 'auto';
                        ui.item[0].style.right = 0;
                    }

                    //finally, remove or add icon for old_parent
                    if (api.old_parent.childMenuItems().length == 0) {
                        api.old_parent.find('.dh-tree-icon').removeClass('has_children open')
                    } else {
                        api.old_parent.find('.dh-tree-icon').addClass('has_children open')
                    }
                    //remove or add icon for new_parent
                    var new_parent = $('#menu-item-' + ui.item.find('.menu-item-data-parent-id').val())
                    if (new_parent.childMenuItems().length > 0) {
                        new_parent.find('.dh-tree-icon').addClass('has_children open');
                    }
                    if (new_parent.find('.dh-tree-icon').hasClass('close')) {
                        new_parent.find('.dh-tree-icon').trigger('click');
                    }
                    ui.item.move_folder();//chidang
                },
                change: function(e, ui) {
                    // Make sure the placeholder is inside the menu.
                    // Otherwise fix it, or we're in trouble.
                    if( ! ui.placeholder.parent().hasClass('menu') )
                        (prev.length) ? prev.after( ui.placeholder ) : api.menuList.prepend( ui.placeholder );

                    updateSharedVars(ui);
                    
                },
                sort: function(e, ui) {
                    var offset = ui.helper.offset(),
                        edge = api.isRTL ? offset.left + ui.helper.width() : offset.left,
                        depth = api.negateIfRTL * api.pxToDepth( edge - menuEdge );

                    // Check and correct if depth is not within range.
                    // Also, if the dragged element is dragged upwards over
                    // an item, shift the placeholder to a child position.
                    if ( depth > maxDepth || offset.top < ( prevBottom - api.options.targetTolerance ) ) {
                        depth = maxDepth;
                    } else if ( depth < minDepth ) {
                        depth = minDepth;
                    }

                    if( depth != currentDepth )
                        updateCurrentDepth(ui, depth);

                    // If we overlap the next element, manually shift downwards
                    if( nextThreshold && offset.top + helperHeight > nextThreshold ) {
                        next.after( ui.placeholder );
                        updateSharedVars( ui );
                        $( this ).sortable( 'refreshPositions' );
                    }
                }
            });

            function updateSharedVars(ui) {
                var depth;

                prev = ui.placeholder.prev( '.menu-item' );
                next = ui.placeholder.next( '.menu-item' );

                // Make sure we don't select the moving item.
                if( prev[0] == ui.item[0] ) prev = prev.prev( '.menu-item' );
                if( next[0] == ui.item[0] ) next = next.next( '.menu-item' );

                prevBottom = (prev.length) ? prev.offset().top + prev.height() : 0;
                nextThreshold = (next.length) ? next.offset().top + next.height() / 3 : 0;
                minDepth = (next.length) ? next.menuItemDepth() : 0;

                if( prev.length )
                    maxDepth = ( (depth = prev.menuItemDepth() + 1) > api.options.globalMaxDepth ) ? api.options.globalMaxDepth : depth;
                else
                    maxDepth = 0;
            }

            function updateCurrentDepth(ui, depth) {
                ui.placeholder.updateDepthClass( depth, currentDepth );
                currentDepth = depth;
            }

            function initialMenuMaxDepth() {
                if( ! body[0].className ) return 0;
                var match = body[0].className.match(/menu-max-depth-(\d+)/);
                return match && match[1] ? parseInt( match[1], 10 ) : 0;
            }

            function updateMenuMaxDepth( depthChange ) {
                var depth, newDepth = menuMaxDepth;
                if ( depthChange === 0 ) {
                    return;
                } else if ( depthChange > 0 ) {
                    depth = maxChildDepth + depthChange;
                    if( depth > menuMaxDepth )
                        newDepth = depth;
                } else if ( depthChange < 0 && maxChildDepth == menuMaxDepth ) {
                    while( ! $('.menu-item-depth-' + newDepth, api.menuList).length && newDepth > 0 )
                        newDepth--;
                }
                // Update the depth class.
                body.removeClass( 'menu-max-depth-' + menuMaxDepth ).addClass( 'menu-max-depth-' + newDepth );
                menuMaxDepth = newDepth;
            }
        },

        registerChange : function() {
            api.menusChanged = true;
        },

        depthToPx : function(depth) {
            return depth * api.options.menuItemDepthPerLevel;
        },

        pxToDepth : function(px) {
            return Math.floor(px / api.options.menuItemDepthPerLevel);
        }

    };

    // $(document).ready(function(){
    //     DhTreeFolder.init();
    // });

})(jQuery);
