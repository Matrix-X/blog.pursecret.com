<?php
/**
 * Show media category filter on top bar
 *
 * @link       https://ninjateam.org
 * @since      1.0.0
 *
 * @package    FileBird_Topbar
 * @subpackage FileBird_Topbar/includes
 */
/** If this file is called directly, abort. */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * class FileBird_Topbar
 * the main class
 */
class FileBird_Topbar {
    public $plugin_version = NJT_FILEBIRD_VERSION;

    /**
     * Initialize the hooks and filters
     */
    public function __construct() {
        // load code that is only needed in the admin section
        if ( is_admin() ) {

            add_action( 'add_attachment', array( $this, 'filebird_add_attachment_category' ) );
            add_action( 'edit_attachment', array( $this, 'filebird_set_attachment_category' ) );
            add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'filebird_add_plugin_action_links' ) );
            add_filter( 'ajax_query_attachments_args', array( $this, 'filebird_ajax_query_attachments_args' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'filebird_enqueue_media_action' ) );
            add_action( 'wp_ajax_save-attachment-compat', array( $this, 'filebird_save_attachment_compat' ), 0 );
            add_action( 'wp_ajax_filebird_save_attachment', array( $this, 'filebird_save_attachment' ), 0 );
            add_action( 'wp_ajax_nt_wcm_get_terms_by_attachment', array( $this, 'nt_wcm_get_terms_by_attachment' ), 0 );
            add_action( 'wp_ajax_filebird_save_multi_attachments', array( $this, 'filebird_save_multi_attachments' ), 0 );

            add_filter( 'attachment_fields_to_edit', array( $this, 'filebird_attachment_fields_to_edit' ), 10, 2 );

        }
    }

    public function filebird_add_attachment_category( $post_ID ) {
        $filebird_Folder = isset($_REQUEST["ntWMCFolder"]) ? $_REQUEST["ntWMCFolder"] : null;
        if (is_null($filebird_Folder)) {
            $filebird_Folder = isset($_REQUEST["njt_filebird_folder"]) ? $_REQUEST["njt_filebird_folder"] : null;
        }
        if ($filebird_Folder !== null) {
            $filebird_Folder = (int)$filebird_Folder;
            if ($filebird_Folder > 0) {
                wp_set_object_terms($post_ID, $filebird_Folder, NJT_FILEBIRD_FOLDER, false);
            }
        }
    }

    /**
     * Handle default category of attachments without category
     * @action add_attachment
     * @param array $post_ID
     */
    public function filebird_set_attachment_category( $post_ID ) {

        // default taxonomy
        $taxonomy = NJT_FILEBIRD_FOLDER;
        // add filter to change the default taxonomy
        $taxonomy = apply_filters( 'filebird_taxonomy', $taxonomy );

        // if attachment already have categories, stop here
        if ( wp_get_object_terms( $post_ID, $taxonomy ) ) {
            return;
        }

        // no, then get the default one
        $post_category = array( get_option( 'default_category' ) );

        // then set category if default category is set on writting page
        if ( $post_category ) {
            wp_set_post_categories( $post_ID, $post_category );
        }
    }


    public static function filebird_get_terms_values( $keys = 'ids' ) {

        // Get media taxonomy
        $media_terms = get_terms( NJT_FILEBIRD_FOLDER, array(
            'hide_empty' => 0,
            'fields'     => 'id=>slug',
        ) );

        $media_values = array();
        foreach ( $media_terms as $key => $value ) {
            $media_values[] = ( $keys === 'ids' )
                ? $key
                : $value;
        }

        return $media_values;
    }


    /**
     * Changing categories in the 'grid view'
     * @action ajax_query_attachments_args
     * @param array $query
     */
    public function filebird_ajax_query_attachments_args( $query = array() ) {
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        // grab original query, the given query has already been filtered by WordPress
        $taxquery = isset( $_REQUEST['query'] ) ? (array) $_REQUEST['query'] : array();

        $taxonomies = get_object_taxonomies( 'attachment', 'names' );
        $taxquery = array_intersect_key( $taxquery, array_flip( $taxonomies ) );

        // merge our query into the WordPress query
        $query = array_merge( $query, $taxquery );

        $query['tax_query'] = array( 'relation' => 'AND' );

        foreach ( $taxonomies as $taxonomy ) {
            if ( isset( $query[$taxonomy] ) && is_numeric( $query[$taxonomy] ) ) {
                if ( $query[ $taxonomy ] > 0 ) {
                   // $query['post_status'] = 'inherit,private';
                    array_push( $query['tax_query'], array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'id',
                        'terms'    => $query[$taxonomy],
                        'include_children'  => false
                    ));
                    //$query['include_children'] = false;
                }else{
                    $all_terms_ids = self::filebird_get_terms_values( 'ids' );
                    array_push( $query[ 'tax_query' ], array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'id',
                        'terms'    => $all_terms_ids,
                        'operator' => 'NOT IN',
                    ) );
                }
                
            }
            unset( $query[$taxonomy] );
        }
        //print_r($query);die;
        return $query;
    }


    /**
     * Enqueue admin scripts and styles
     * @action admin_enqueue_scripts
     */
    public function filebird_enqueue_media_action() {

        global $pagenow;

        $suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';
        // $suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

        //if ( wp_script_is( 'media-editor' ) && ('upload.php' == $pagenow  || ( 'post.php' == $pagenow ) || ( 'post-new.php' == $pagenow ))     ) {

            // Default taxonomy
            $taxonomy = NJT_FILEBIRD_FOLDER;
            // Add filter to change the default taxonomy
            $taxonomy = apply_filters( 'filebird_taxonomy', $taxonomy );

            if ( $taxonomy != NJT_FILEBIRD_FOLDER ) {
                $dropdown_options = array(
                    'taxonomy'        => $taxonomy,
                    'hide_empty'      => false,
                    'hierarchical'    => true,
                    'orderby'         => 'name',
                    'show_count'      => true,
                    'walker'          => new filebird_walker_category_mediagridfilter(),
                    'value'           => 'id',
                    'echo'            => false
                );
            } else {
                $dropdown_options = array(
                    'taxonomy'        => $taxonomy,
                    'hide_empty'      => false,
                    'hierarchical'    => true,
                    'orderby'         => 'name',
                    'show_count'      => true,
                    'walker'          => new filebird_walker_category_mediagridfilter(),
                    'value'           => 'id',
                    'echo'            => false
                );
            }
            $attachment_terms = wp_dropdown_categories( $dropdown_options );
            $attachment_terms = preg_replace( array( "/<select([^>]*)>/", "/<\/select>/" ), "", $attachment_terms );
            $all_count = wp_count_posts('attachment')->inherit;
            $uncatetory_count = FileBird_Topbar::get_uncategories_attachment();

            // echo '<script type="text/javascript">';
            // echo '/* <![CDATA[ */';
            // echo 'var filebird_folder = "'. NJT_FILEBIRD_FOLDER .'";';
            // echo 'var filebird_taxonomies = {"folder":{"list_title":"' . html_entity_decode( __( 'All categories (' . $all_count .')' , 'wp-media-library-categories' ), ENT_QUOTES, 'UTF-8' ) . '","term_list":[{"term_id":"-1","term_name":"Uncategory (' . $uncatetory_count. ')"},' . substr( $attachment_terms, 2 ) . ']}};';
            // echo '/* ]]> */';
            // echo '</script>';



            echo '<script type="text/javascript">';
            echo '/* <![CDATA[ */';
            echo 'var filebird_folder = "'. NJT_FILEBIRD_FOLDER .'";';
            echo 'var filebird_taxonomies = {"folder":{"list_title":"' . html_entity_decode( __( 'All categories' , NJT_FILEBIRD_TEXT_DOMAIN ), ENT_QUOTES, 'UTF-8' ) . '","term_list":[{"term_id":"-1","term_name":"'.__( 'Uncategories' , NJT_FILEBIRD_TEXT_DOMAIN ).'"},' . substr( $attachment_terms, 2 ) . ']}};';
            echo '/* ]]> */';
            echo '</script>';

            wp_enqueue_script( 'filebird-admin-topbar', plugins_url( 'admin/js/filebird-admin-topbar' . $suffix . '.js', dirname(__FILE__) ), array( 'media-views' ), $this->plugin_version, true );
           // wp_enqueue_style( 'filebird', plugins_url( 'css/filebird' . $suffix . '.css', __FILE__ ), array(), $plugin_version );
       // }
    }


    /**
     * Save categories from attachment details on insert media popup
     * @action wp_ajax_save-attachment-compat
     */
    public function filebird_save_attachment_compat() {
        if ( ! isset( $_REQUEST['id'] ) ) {
            wp_send_json_error();
        }

        if ( ! $id = absint( $_REQUEST['id'] ) ) {
            wp_send_json_error();
        }

        if ( empty( $_REQUEST['attachments'] ) || empty( $_REQUEST['attachments'][ $id ] ) ) {
            wp_send_json_error();
        }
        $attachment_data = $_REQUEST['attachments'][ $id ];
       
        check_ajax_referer( 'update-post_' . $id, 'nonce' );

        if ( ! current_user_can( 'edit_post', $id ) ) {
            wp_send_json_error();
        }

        $post = get_post( $id, ARRAY_A );

        if ( 'attachment' != $post['post_type'] ) {
            wp_send_json_error();
        }

        /** This filter is documented in wp-admin/includes/media.php */
        $post = apply_filters( 'attachment_fields_to_save', $post, $attachment_data );

        if ( isset( $post['errors'] ) ) {
            $errors = $post['errors']; // @todo return me and display me!
            unset( $post['errors'] );
        }

        wp_update_post( $post );
//         print_r($attachment_data);die;
//         Array
// (
//     [menu_order] => 0
// )

//         print_r(get_attachment_taxonomies( $post ));die;
//         Array
// (
//     [0] => folder
// )


        foreach ( get_attachment_taxonomies( $post ) as $taxonomy ) {
            //print_r($taxonomy);die;
            //=> folder
            if ( isset( $attachment_data[ $taxonomy ] ) ) {
               
                wp_set_object_terms( $id, array_map( 'trim', preg_split( '/,+/', $attachment_data[ $taxonomy ] ) ), $taxonomy, false );
            } else if ( isset($_REQUEST['tax_input']) && isset( $_REQUEST['tax_input'][ $taxonomy ] ) ) {
               
                 //add attachment into foder-term
                wp_set_object_terms( $id, $_REQUEST['tax_input'][ $taxonomy ], $taxonomy, false );
            } else {
                //remove all folder-terms out of attachment
                wp_set_object_terms( $id, '', $taxonomy, false );
            }
            
        }

        if ( ! $attachment = wp_prepare_attachment_for_js( $id ) ) {
            wp_send_json_error();
        }

        wp_send_json_success( $attachment );
    }

    public function filebird_save_multi_attachments(){

        $ids = $_REQUEST['ids'];

        $result = array();

        foreach ($ids as $key => $id) {

            $term_list = wp_get_post_terms( $id, NJT_FILEBIRD_FOLDER, array( 'fields' => 'ids' ) );

            $from = -1;

            if(count($term_list)){

                $from = $term_list[0];

            }

            $obj = (object) array('id' => $id, 'from' => $from, 'to' => $_REQUEST['folder_id']);

            $result[] = $obj;

            wp_set_object_terms( $id, intval($_REQUEST['folder_id']), NJT_FILEBIRD_FOLDER, false );

        }

        wp_send_json_success( $result );

    }

    public function filebird_save_attachment() {
        
        if ( ! isset( $_REQUEST['id'] ) ) {
            wp_send_json_error();
        }

        if ( ! $id = absint( $_REQUEST['id'] ) ) {
            wp_send_json_error();
        }

        if ( empty( $_REQUEST['attachments'] ) || empty( $_REQUEST['attachments'][ $id ] ) ) {
            wp_send_json_error();
        }
        $attachment_data = $_REQUEST['attachments'][ $id ];
       
        //check_ajax_referer( 'update-post_' . $id, 'nonce' );

        // if ( ! current_user_can( 'edit_post', $id ) ) {
        //     wp_send_json_error();
        // }

        $post = get_post( $id, ARRAY_A );

        if ( 'attachment' != $post['post_type'] ) {
            wp_send_json_error();
        }

        /** This filter is documented in wp-admin/includes/media.php */
        $post = apply_filters( 'attachment_fields_to_save', $post, $attachment_data );

        if ( isset( $post['errors'] ) ) {
            $errors = $post['errors']; // @todo return me and display me!
            unset( $post['errors'] );
        }

        wp_update_post( $post );



        //add attachment into foder-term
        wp_set_object_terms( $id, intval($_REQUEST['folder_id']), NJT_FILEBIRD_FOLDER, false );
        if ( ! $attachment = wp_prepare_attachment_for_js( $id ) ) {
            //echo 1;die;
            wp_send_json_error();
        }

        wp_send_json_success( $attachment );
    }

    public function nt_wcm_get_terms_by_attachment(){
        if ( ! isset( $_REQUEST['id'] ) ) {
            wp_send_json_error();
        }
        if ( ! $id = absint( $_REQUEST['id'] ) ) {
            wp_send_json_error();
        }
        $terms  = get_the_terms($id, NJT_FILEBIRD_FOLDER);
        wp_send_json_success( $terms );
    }


    /**
     * Add category checkboxes to attachment details on insert media popup
     * @action attachment_fields_to_edit
     */
    public function filebird_attachment_fields_to_edit( $form_fields, $post ) {
        

        // $dropdown_options = array(
        //     'show_option_all' => '- ' . __("Select", NJT_FILEBIRD_TEXT_DOMAIN) . ' -',
        //     'taxonomy'        => NJT_FILEBIRD_FOLDER,
        //     'name'=> 'attachments[' . $post->ID . ']['.NJT_FILEBIRD_FOLDER.']' ,
        //     'hide_empty'      => false,
        //     'hierarchical'    => true,
        //     'meta_key'        => 'folder_position',
        //     'orderby'         => 'meta_value',
        //     'show_count'      => true,
        //     'walker'          => new Walker_CategoryDropdown(),
        //     'value'           => 'id',
        //     'echo'            => false
        // );

        // $terms = wp_get_post_terms( $post->ID, NJT_FILEBIRD_FOLDER ); 
       
        // if(count($terms)){
           
        //     $dropdown_options['selected'] = $terms[0]->term_id;
        // }
            
        // $attachment_terms = wp_dropdown_categories( $dropdown_options );

        // $form_fields[NJT_FILEBIRD_FOLDER] = array(
        //     'label' => __('Folder', NJT_FILEBIRD_TEXT_DOMAIN),
        //     'input' => 'html',
        //     'html'  => 
        //         '<div class="njt-filebird-folder-edit">'
        //         . $attachment_terms .
        //         '</div>',
        // );
        $form_fields[NJT_FILEBIRD_FOLDER] = [];
        return $form_fields;
    }

    public static function get_uncategories_attachment(){
        $args = array(
            'post_type' => 'attachment',
            'post_status' => 'inherit,private',
            'posts_per_page' => -1,
            'tax_query' => Array
                (
                    'relation' => 'AND',
                    0 => Array
                        (
                            'taxonomy' => NJT_FILEBIRD_FOLDER,
                            'field' => 'id',
                            'terms' =>  self::filebird_get_terms_values('ids'),
                            'operator' => 'NOT IN'
                        )
                   
                )
            
        );
        $result = get_posts($args);//don't use WP_query in backend
        return count($result);
    }

}
$filebird_topbar = new FileBird_Topbar();

