<?php
/*
  Plugin Name: Cat App
  Plugin URI: http://www.salasarcybersolutions.com
  Description: A powerful and beautiful quiz plugin for WordPress.
  Version: 3.0
  Author: Salasar Cyber Solutions
  Author URI: http://www.salasarcybersolutions.com
  License: GNU
*/
register_uninstall_hook(__FILE__, 'catApp_uninstall');
register_activation_hook(__FILE__, 'catApp_create_table');
// register_activation_hook( __FILE__,'catApp_install_data');
defined('ABSPATH') || exit;
require_once(ABSPATH . 'wp-admin/includes/plugin.php');
$plugin_data = get_plugin_data(__FILE__);
define('catApp_url', plugin_dir_url(__FILE__));
define('catApp_path', plugin_dir_path(__FILE__));
define('catApp_plugin', plugin_basename(__FILE__));
$plugin = catApp_plugin;


// Includes code files
require_once plugin_dir_path( __FILE__ ) . 'functions.php';
require_once plugin_dir_path( __FILE__ ) . 'ajax-functions.php';
require_once plugin_dir_path( __FILE__ ) . 'ajax-gre-functions.php';
require_once plugin_dir_path( __FILE__ ) . 'ajax-gmat-functions.php';


/**********************************/
/*     Menu Configration          */
/**********************************/
function catApp_config_menu()
{
   if (function_exists('add_menu_page')) {
      $pluginurl     = dirname(plugin_basename(__FILE__)) . '/';
      $helperscripts = WP_PLUGIN_URL . '/' . $pluginurl;
   }
}

add_action('admin_menu', 'catApp_plugin_menu'  );
function catApp_plugin_menu(){
   add_menu_page('CatApp', 'CatApp', 'manage_options', 'CatApp', 'ctaCategoryList', 'dashicons-laptop',
        65);
   add_submenu_page('CatApp', 'CAT Adoptive Quiz', 'CAT Adoptive Quiz', 'manage_options', 'CatApp');
   add_submenu_page(null, 'Add Quiz', 'GRE Quiz', 'manage_options', 'addQuestion', 'addQuestion');
   add_submenu_page(null, 'Question List', 'Question List', 'manage_options', 'questionList', 'questionList');
   add_submenu_page(null, 'Edit Quiz', 'Edit Quiz', 'manage_options', 'editQuestion', 'editQuestion');
   add_submenu_page('CatApp', 'GRE Category List', 'GRE Category Quiz', 'manage_options', 'catGerCategoryList', 'catGerCategoryList');
   add_submenu_page(null, 'Gre Add Category', 'GRE Add Category', 'manage_options', 'greAddCategory', 'greAddCategory');
   add_submenu_page(null, 'Gre Edit Category', 'GRE Edit Category', 'manage_options', 'greEditCategory', 'greEditCategory');
   add_submenu_page(null, 'Gre Edit Question', 'GRE Edit Question', 'manage_options', 'greEditQuestion', 'greEditQuestion');
   add_submenu_page(null, 'Gre questions List', 'Gre questions List', 'manage_options', 'gerQuestionList', 'gerQuestionList');
   add_submenu_page(null, 'Add Gre question', 'Add Gre question', 'manage_options', 'addGreQuestion', 'addGreQuestion');
   add_submenu_page('CatApp', 'GMAT Category List', 'GMAT Category Quiz', 'manage_options', 'gmatCategoryList', 'gmatCategoryList');
   add_submenu_page(null, 'GMAT Add Category', 'GMAT Add Category', 'manage_options', 'gmatAddCategory', 'gmatAddCategory');
   add_submenu_page(null, 'GMAT Edit Category', 'GMAT Edit Category', 'manage_options', 'gmatEditCategory', 'gmatEditCategory');
   add_submenu_page(null, 'GMAT questions List', 'GMAT questions List', 'manage_options', 'gmatQuestionList', 'gmatQuestionList');
   add_submenu_page(null, 'Add GMAT question', 'Add GMAT question', 'manage_options', 'addGmatQuestion', 'addGmatQuestion');
   add_submenu_page(null, 'GMAT Edit Question', 'GMAT Edit Question', 'manage_options', 'gmatEditQuestion', 'gmatEditQuestion');
}

function ctaCategoryList(){
   global $wpdb;
   $ctest_table = $wpdb->prefix . "cta_category";
   $result = $wpdb->get_results("SELECT * FROM $ctest_table where quiz_mode = '0' ORDER BY qcategory_id DESC");
   include('view/categoryList.php');
}

//Question List
function questionList(){
   include('view/questionList.php');
}

//Edit Question Form
function editQuestion(){
   include('view/editQuestion.php');
}

// GRE Edit Questions
function greEditQuestion(){
  include('template/gre/greEditQuestion.php');
}
// Gre Category List
function catGerCategoryList(){
   global $wpdb;
   $ctest_table = $wpdb->prefix . "cta_category";
   $result = $wpdb->get_results("SELECT * FROM $ctest_table");
   
   include('template/gre/greCategoryList.php');
}
//Add Question
function addQuestion(){
   include('view/addQuestion.php');
}
//Add GRE Question
function addGreQuestion(){
   include('template/gre/greAddQuestion.php');
}
//Add GRE Question
function greAddCategory(){
   include('template/gre/greAddCategory.php');
}
//Edit GRE Category
function greEditCategory(){
   include('template/gre/greEditCategory.php');
}
//Question List
function gerQuestionList(){
   include('template/gre/greQuestionList.php');
}

// GMAT TEST FUNCTIONALITY START

function gmatCategoryList(){
   global $wpdb;
   $ctest_table = $wpdb->prefix . "cta_category";
   $result = $wpdb->get_results("SELECT * FROM $ctest_table WHERE quiz_mode = '3'");
   include('template/gmat/gmatCategoryList.php');
}

function gmatAddCategory(){
   include('template/gmat/gmatAddCategory.php');
}

//Edit GMAT Category
function gmatEditCategory(){
   include('template/gmat/gmatEditCategory.php');
}

//Question List
function gmatQuestionList(){
   include('template/gmat/gmatQuestionList.php');
}

//Add GMAT Question
function addGmatQuestion(){
   include('template/gmat/gmatAddQuestion.php');
}

// GMAT Edit Questions
function gmatEditQuestion(){
  include('template/gmat/gmatEditQuestion.php');
}

// GMAT TEST FUNCTIONALITY END



add_action('wp_enqueue_scripts', 'lsat_cat_app_enqueue_scripts');
function lsat_cat_app_enqueue_scripts(){

    wp_register_script('customFrontEndScript.js', WP_PLUGIN_URL  . '/catApp/assets/customFrontEndScript.js', array(), false, true);
    wp_enqueue_script('customFrontEndScript.js');
    //wp_register_script('gre_cat_app.js', WP_PLUGIN_URL  . '/catApp/assets/js/gre_cat_app.js', array(), false, true);
    //wp_enqueue_script('gre_cat_app.js');
    //wp_register_script('gmat_cat_app.js', WP_PLUGIN_URL  . '/catApp/assets/js/gmat_cat_app.js', array(), false, true);
    //wp_enqueue_script('gmat_cat_app.js');
    //wp_localize_script('flz_cat_app.js', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ));
    wp_enqueue_style('flz_cat_app.css', WP_PLUGIN_URL . '/catApp/assets/css/flz_cat_app.css');
    wp_enqueue_style('gre_cat_app.css', WP_PLUGIN_URL . '/catApp/assets/css/gre_cat_app.css');

}

function load_custom_wp_admin_style(){
     wp_enqueue_style('haq_cat_admin.css', WP_PLUGIN_URL . '/catApp/assets/css/haq_cat_admin.css');
     wp_enqueue_style( 'haq_cat_admin' );
     wp_enqueue_style('bootstrap.min.css', WP_PLUGIN_URL . '/catApp/assets/css/bootstrap.min.css');
     wp_enqueue_style( 'bootstrap.min' );
     wp_enqueue_style('awesome.min.css', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
     wp_enqueue_style( 'awesome.min.css' );
     wp_enqueue_style('dataTables.bootstrap.min.css', WP_PLUGIN_URL . '/catApp/assets/css/dataTables.bootstrap.min.css');
     wp_enqueue_style( 'dataTables.bootstrap' );
     wp_enqueue_script( 'bootstrap_script', WP_PLUGIN_URL . '/catApp/assets/js/bootstrap.min.js', array(), '1.0' );
     wp_enqueue_script( 'datatable_script', WP_PLUGIN_URL . '/catApp/assets/js/jquery.dataTables.min.js', array(), '1.0' );
     wp_enqueue_script( 'gre-script', WP_PLUGIN_URL . '/catApp/assets/js/gre-script.js', array(), '1.0' );
     wp_enqueue_script( 'gmat-script', WP_PLUGIN_URL . '/catApp/assets/js/gmat-script.js', array(), '1.0' );
}
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');

function CatApp_is_first_time()
{
    if (isset($_COOKIE['_wp_flzcat_first_time'])) {
        return false;
    }

    $sDomain = COOKIE_DOMAIN ? COOKIE_DOMAIN : $_SERVER['HTTP_HOST'];

    // expires in 30 days.
    setcookie('_wp_flzcat_first_time', '1', time() + (WEEK_IN_SECONDS * 4), '/', $sDomain);

    return true;
}

//Sort Code
function CatApp($atts)
{
   $id = $atts['id'];
   $userId = get_current_user_id();
   $user_info = get_userdata($userId);
   $email = $user_info->user_email;
   $userId == "" ? $myfunction = "userForm_" . $id . "('1')" : $myfunction = "start_" . $id . "()";
   $dir = plugin_dir_path(__DIR__);
   global $wpdb;
   $category_result  = $wpdb->get_row("SELECT * FROM wp_cta_category where qcategory_id=" . $id . "");
   $category_title   = $category_result->category_title;
   $test_height      = $category_result->test_height == '' ? '' : $category_result->test_height;
   $test_mode_height = $category_result->test_mode_height == '' ? '' : $category_result->test_mode_height;
   $expl_mode_height = $category_result->explanation_mode_height == '' ? '' : $category_result->explanation_mode_height;
   $category_quiz_mode = $category_result->quiz_mode;

   $aAllQ = array();
   //$aAllQ['category_quiz_mode'] = $category_quiz_mode;
   $result1 = $wpdb->get_results("SELECT * FROM wp_cta_question where qcategory_id=" . $id . " AND hard_level = 'very-easy'");
  
  
  foreach ($result1 as $aValue1) {
    $result = $wpdb->get_results("SELECT * FROM wp_cta_question where question_no=" . $aValue1->question_no);
    if(count($result) > 0){
      $aAllQ[$aValue1->question_no]= array();
      foreach ($result as $aValue) {
        $aAllQ[$aValue1->question_no][] = array(

          'qtest_id'         =>   $aValue->qtest_id, 
          'question_no'      =>   $aValue->question_no, 
          'qcategory_id'     =>   $aValue->qcategory_id, 
          'is_unseen'        =>   $aValue->is_unseen, 
          'unseen_passage'   =>   $aValue->unseen_passage, 
          'quiz_type'        =>   $aValue->quiz_type, 
          'quiz'             =>   $aValue->quiz, 
          'a_option'         =>   $aValue->a_option, 
          'a_explain'        =>   $aValue->a_explain, 
          'b_option'         =>   $aValue->b_option, 
          'b_explain'        =>   $aValue->b_explain, 
          'c_option'         =>   $aValue->c_option, 
          'c_explain'        =>   $aValue->c_explain, 
          'd_option'         =>   $aValue->d_option, 
          'd_explain'        =>   $aValue->d_explain, 
          'e_option'         =>   $aValue->e_option, 
          'e_explain'        =>   $aValue->e_explain, 
          'right_answer'     =>   $aValue->right_answer, 
          'answer_hint'      =>   $aValue->answer_hint, 
          'questions_explain'=>   $aValue->questions_explain, 
          'answer_explain'   =>   $aValue->answer_explain, 
          'hard_level'       =>   $aValue->hard_level, 
          'status'           =>   $aValue->status, 
          'is_essay'         =>   $aValue->is_essay, 
          'essay_explain'    =>   $aValue->essay_explain
        );
      }
    }
    
  }

   $aFirst = array(
      'total_time' => round(count($result1) * 1.5),
      'total_question' => count($result1)
   );


   $aData['category_id'] = $id;
   $sResData = json_encode($aAllQ);
   
   if($_REQUEST['dbmodify']){
      global $wpdb;

      $sql = "ALTER TABLE `wp_cta_question` ADD COLUMN `is_essay` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '0-No,1-Yes' AFTER `answer_explain`, ADD COLUMN `essay_explain` TEXT AFTER `is_essay`";
      $sql = "ALTER TABLE `wp_cta_question` CHANGE COLUMN `quiz_type` `quiz_type` ENUM('0','1','2') NOT NULL DEFAULT '0' COMMENT '0-Text Type,1-Image Type' AFTER `unseen_passage`";
      $results = $wpdb->query($sql);
      var_dump($results);

      $sql = "ALTER TABLE `wp_cta_category` ADD COLUMN `quiz_mode` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `explanation_mode_height`";
      $results = $wpdb->query($sql);
      var_dump($results);

      die();
   }
   echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>';
   // Get user answer stored in the DB
   $aUserDataDb = "";
   $sLevel = 'medium';
   if (get_current_user_id() != 0) {
       $aUserDataDb = $wpdb->get_var( "SELECT user_answer FROM ".($wpdb->prefix . 'cta_answers')." WHERE quiz_level = '".strtolower(trim($sLevel))."' AND category_id = ".$id." AND wp_user_id = " . get_current_user_id() . "");

       $aUserDataDb = str_replace('\\', '', unserialize($aUserDataDb));
   }

   $sFirstTime = 'false';
   if(CatApp_is_first_time() == true){
      $sFirstTime = 'true';
   }

   $sQuestionTypeClass = '';
   if($category_quiz_mode == '1'){
      $sQuestionTypeClass = 'is-quiz-mode';
   }

  echo '<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css?ver=5.5">';
  echo '<script src="'.WP_PLUGIN_URL.'/catApp/assets/js/gre_cat_app.js"></script>';
   extract(shortcode_atts(array('id' => ''), $atts));
   include('view/quizPaper.php');
}
add_shortcode('CatApp', 'CatApp');



function action_mailpoet_pre_config_screen( $roles ) { 
    if ( isset( $roles['administrator'] ) && !current_user_can('level_10') ){
        unset( $roles['administrator'] );
    }
    return $roles;
}; 
         
// add the action 
add_action( 'mailpoet_pre_config_screen', 'action_mailpoet_pre_config_screen', 10, 0 );