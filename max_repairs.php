<?php
/*
Plugin Name: max_repairs
Plugin URI: https:/max_repairs.com/
Description: max_repairs plugin used by millions,
Version: 1.1
Author: Max
Author URI: https://max.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: max_repairs
*/

if(!defined('ABSPATH')){
    die();
}

define( 'MAX_REPAIRS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require MAX_REPAIRS_PLUGIN_DIR.'includes/meta-box-class/class-repairs-metaboxes.php';

if(!class_exists('Gamajo_Template_Loader')){
    require MAX_REPAIRS_PLUGIN_DIR.'includes/class-gamajo-template-loader.php';
}
require MAX_REPAIRS_PLUGIN_DIR.'includes/class-max-repairs-template-loader.php';
require MAX_REPAIRS_PLUGIN_DIR.'includes/class-max-repairs-filter.php';

class Newrepairs{
    function __construct(){
    }

    function register(){
        add_action('init',[$this,'create_repairs']);
        add_action('admin_enqueue_scripts',[$this,'enqueue_admin']);
        add_action('admin_enqueue_scripts',[$this,'next_number_script']);
        add_action('wp_enqueue_scripts',[$this,'enqueue_front']);
        add_filter('template_include',[$this,'repairs_archive_template']);
        add_action( 'wp_ajax_get_posts_for_datatables', [$this,'my_ajax_get_posts_for_datatables'] );
        add_action( 'wp_ajax_nopriv_get_posts_for_datatables',[$this, 'my_ajax_get_posts_for_datatables'] );
    }

   static function activation(){
        //update links
        flush_rewrite_rules();
    }

    function next_number_script($hook) {
        if ( 'post-new.php' != $hook ) {
            return;
        }
        $count_posts = wp_count_posts('repairs');
        $published_posts = ($count_posts->publish)+1;
        $data_passed=array(
            'title_of_post'=>$published_posts,
        );
        wp_add_inline_script('repairscriptadmin','var data_passed='.json_encode($data_passed),'before');
    }

  public function my_ajax_get_posts_for_datatables() {
        $posts_per_page = 100;
        $page = 1;
        $args = array(
            'post_type'             => 'repairs',
            'posts_per_page'        => $posts_per_page,
            'paged'                 => $page
        );

        $postsQ = new WP_Query( $args );
        $return_json = array();
        while($postsQ->have_posts()) {
            $postsQ->the_post();

            $row = array(
                'id' => get_the_ID(),
                'date' => get_the_date('Y-m-d'),
                'number' => get_the_title(),
                'phone' =>  get_post_meta(get_the_ID(), 'phone_customer',true),
                'company' =>  $this->uppercase(get_post_meta(get_the_ID(), 'company',true)),
                'instrument_type' =>   $this->uppercase(get_post_meta(get_the_ID(), 'instrument_type',true)),
                'complaint' =>  $this->uppercase(get_post_meta(get_the_ID(), 'complaint',true)),
                'repeat_number' =>  get_post_meta(get_the_ID(), 'repeat_number',true),
                'agreement' =>  get_post_meta(get_the_ID(), 'agreement', true),
                'ready' =>   get_post_meta(get_the_ID(), 'ready',true),
                'given' =>  get_post_meta(get_the_ID(), 'given',true),
            );
            $return_json[] = $row;
        }
        //return the result to the ajax request and die
        echo json_encode(array('data' => $return_json));
      wp_reset_postdata();
        wp_die();
    }

    static function deactivation(){
        //update links
        flush_rewrite_rules();
    }

    function enqueue_admin(){
        wp_enqueue_style('repairstyle',plugins_url('/assets/admin/styles.css',__FILE__));
        wp_enqueue_script('repairscriptadmin',plugins_url('/assets/admin/scripts.js',__FILE__), array(), '', true);
    }

    function enqueue_front(){
        wp_enqueue_style('repairstyle',plugins_url('/assets/front/styles.css',__FILE__));
        wp_enqueue_script('repairscript',plugins_url('/assets/front/scripts.js',__FILE__));

        wp_enqueue_script('datatables', 'https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js', array('jquery') );
        wp_localize_script( 'datatables', 'datatablesajax', array('url' => admin_url('admin-ajax.php')) );
        wp_enqueue_style('datatables', 'https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css' );
        wp_enqueue_script('datatables_my_script',plugins_url('/includes/datatables/datatables.js',__FILE__));
    }

    public function repairs_archive_template($template){
        if(is_post_type_archive('repairs')){
        $template_files=['archive-repairs.php','max_repairs/archive-repairs.php'];
        $exist_in_theme=locate_template($template_files,false);
            if($exist_in_theme!=''){
                return $exist_in_theme;
            }else{
                return MAX_REPAIRS_PLUGIN_DIR.'templates/archive-repairs.php';
            }
    }return $template;
    }

    function uppercase($str){
        $first = mb_substr($str,0,1, 'UTF-8');//первая буква
        $last = mb_substr($str,1);//все кроме первой буквы
        $first = mb_strtoupper($first, 'UTF-8');
        $last = mb_strtolower($last, 'UTF-8');
        $str_out = $first.$last;
        return $str_out;
    }

    function create_repairs(){
        register_post_type('repairs',
            [
                'public' => true,
                'label' => esc_html__('repairs', 'max_repairs'),
                'has_archive'=>true,
                'rewrite'=>['slug'=>'repairs'],
                'supports' => ['title','thumbnail']
            ]
        );
    }
}
if(class_exists('Newrepairs')){
    $new_repairs=new Newrepairs();
    $new_repairs->register();
}
register_activation_hook(__FILE__,array($new_repairs,'activation'));
register_deactivation_hook(__FILE__,array($new_repairs,'deactivation'));