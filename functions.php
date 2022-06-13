<?php

// Create default table for Lsat test

//Create Table
function catApp_create_table()
{
    global $wpdb;
    $sql = array();

    //For Cat Quiz answers
    $tableAnswers = $wpdb->prefix . "cta_answers";
    if ($wpdb->get_var("show tables like '" . $tableAnswers . "'") !== $tableAnswers) {
        $sql[] = "CREATE TABLE `" . $tableAnswers . "` (
		`id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`),
		`category_id` INT(11) NOT NULL,
		`wp_user_id` bigint(20) NOT NULL,
		`user_answer` text DEFAULT NULL,
      `level` ENUM('hard','medium','easy') NOT NULL,
		`answer_date` datetime NOT NULL  
		) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    }

        //For Cat Category
    $tableCategory = $wpdb->prefix . "cta_category";
    if ($wpdb->get_var("show tables like '" . $tableCategory . "'") !== $tableCategory) {
        $sql[] = "CREATE TABLE `" . $tableCategory . "` (
           `qcategory_id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`qcategory_id`),
           `category_title` text NOT NULL,
           `directions` text NOT NULL,
           `test_height` varchar(20) NOT NULL,
           `test_mode_height` varchar(20) NOT NULL,
           `explanation_mode_height` varchar(20) NOT NULL,
           `quiz_mode` enum('0','1') NOT NULL DEFAULT '0',
           `user_id` varchar(150) NOT NULL,
           `test_time` varchar(20) NOT NULL,
           `status` enum('0','1') NOT NULL,
           `create_date` datetime NOT NULL
         ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    }

   //For Cat Category
   $tableQuestion = $wpdb->prefix . "cta_question";
   if ($wpdb->get_var("show tables like '" . $tableQuestion . "'") !== $tableQuestion) {
        $sql[] = "CREATE TABLE `" . $tableQuestion . "` (
           `qtest_id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`qtest_id`),
           `question_no` varchar(120) NOT NULL,
           `qcategory_id` varchar(120) NOT NULL,
           `is_unseen` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0-No,1-Yes,2-Reading-Comprehension',
           `unseen_passage` text NOT NULL,
           `quiz_type` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0-Text Type,1-Image Type',
           `quiz` text NOT NULL,
           `a_option` text NOT NULL,
           `a_explain` text NOT NULL,
           `b_option` text NOT NULL,
           `b_explain` text NOT NULL,
           `c_option` text NOT NULL,
           `c_explain` text NOT NULL,
           `d_option` text NOT NULL,
           `d_explain` text NOT NULL,
           `e_option` text NOT NULL,
           `e_explain` text NOT NULL,
           `right_answer` enum('a_option','b_option','c_option','d_option','e_option') NOT NULL,
           `answer_hint` text NOT NULL,
           `questions_explain` text NOT NULL,
           `answer_explain` text NOT NULL,
           `is_essay` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0-No,1-Yes',
           `essay_explain` text,
           `hard_level` enum('hard','medium','easy') NOT NULL,
           `status` enum('0','1') NOT NULL,
           `add_date` datetime NOT NULL
         ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    } 

    if (!empty($sql)) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option("wnm_db_version", $wnm_db_version);
    }
}



//////////////////////////////////////// Sort Code for GRE & math test ///////////////////////////////////////////

function GreTestShortcode($atts)
{
   $id = $atts['id'];
  
   $dir = plugin_dir_path(__DIR__);
   global $wpdb;
   $category_result  = $wpdb->get_row("SELECT * FROM wp_cta_category where qcategory_id=" . $id . "");
   $category_title   = $category_result->category_title; 
   $test_height      = $category_result->test_height == '' ? '' : $category_result->test_height;
   $test_mode_height = $category_result->test_mode_height == '' ? '' : $category_result->test_mode_height;
   $expl_mode_height = $category_result->explanation_mode_height == '' ? '' : $category_result->explanation_mode_height;
   $category_quiz_mode = $category_result->quiz_mode;

   $aAllQ1 = array();

    // GRE Verbal 1
    $result1 = $wpdb->get_results("SELECT * FROM wp_cat_gre_questions where cat_id=" . $id ." AND  gre_level='verbal' AND gre_type='v1' ORDER BY id ASC" );
  
  foreach ($result1 as $aValue) {
     
        $aAllQ1[] = array(
          'qtest_id'         =>   $aValue->id, 
          'cat_id'           =>   $aValue->cat_id, 
          'question_type'    =>   $aValue->question_type, 
          'directions'       =>   $aValue->directions, 
          'quiz_type'        =>   $aValue->quiz_type, 
          'reading_comp'     =>   $aValue->reading_comp,
          'question_title'   =>   $aValue->question_title, 
          'qcb1'             =>   $aValue->qcb1, 
          'qcb2'             =>   $aValue->qcb2, 
          'qcb3'             =>   $aValue->qcb3, 
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
          'explanation'      =>   stripslashes($aValue->explanation), 
          'status'           =>   $aValue->status,
          'chkbox_option'    =>   $aValue->chkbox_option,
          'quantity_a'       =>   $aValue->quantity_a,
          'quantity_b'       =>   $aValue->quantity_b,
          'condition'        =>   $aValue->condition,
          'graphics_image'   =>   $aValue->graphics_image
        );
  }


// GRE Verbal 2
   $result2 = $wpdb->get_results("SELECT * FROM wp_cat_gre_questions where cat_id=" . $id ." AND  gre_level='verbal' AND gre_type='v2' ORDER BY id ASC" );
   $aAllQ2 =array();
  foreach ($result2 as $aValue) {
     
        $aAllQ2[] = array(
          'qtest_id'         =>   $aValue->id, 
          'cat_id'           =>   $aValue->cat_id, 
          'question_type'    =>   $aValue->question_type, 
          'directions'       =>   $aValue->directions, 
          'quiz_type'        =>   $aValue->quiz_type, 
          'reading_comp'     =>   $aValue->reading_comp,
          'question_title'   =>   $aValue->question_title, 
          'qcb1'             =>   $aValue->qcb1, 
          'qcb2'             =>   $aValue->qcb2, 
          'qcb3'             =>   $aValue->qcb3, 
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
          'explanation'      =>   stripslashes($aValue->explanation), 
          'status'           =>   $aValue->status,
          'chkbox_option'    =>   $aValue->chkbox_option,
          'quantity_a'       =>   $aValue->quantity_a,
          'quantity_b'       =>   $aValue->quantity_b,
          'condition'        =>   $aValue->condition,
          'graphics_image'   =>   $aValue->graphics_image
        );
  }


// Verbal 3
   $result3 = $wpdb->get_results("SELECT * FROM wp_cat_gre_questions where cat_id=" . $id ." AND  gre_level='verbal' AND gre_type='v3' ORDER BY id ASC" );
   $aAllQ3 =array();
  foreach ($result3 as $aValue) {
     
        $aAllQ3[] = array(
          'qtest_id'         =>   $aValue->id, 
          'cat_id'           =>   $aValue->cat_id, 
          'question_type'    =>   $aValue->question_type, 
          'directions'       =>   $aValue->directions, 
          'quiz_type'        =>   $aValue->quiz_type, 
          'reading_comp'     =>   $aValue->reading_comp,
          'question_title'   =>   $aValue->question_title, 
          'qcb1'             =>   $aValue->qcb1, 
          'qcb2'             =>   $aValue->qcb2, 
          'qcb3'             =>   $aValue->qcb3, 
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
          'explanation'      =>   stripslashes($aValue->explanation), 
          'status'           =>   $aValue->status,
          'chkbox_option'    =>   $aValue->chkbox_option,
          'quantity_a'       =>   $aValue->quantity_a,
          'quantity_b'       =>   $aValue->quantity_b,
          'condition'        =>   $aValue->condition,
          'graphics_image'   =>   $aValue->graphics_image
        );
  }


// Verbal 4
   $result4 = $wpdb->get_results("SELECT * FROM wp_cat_gre_questions where cat_id=" . $id ." AND  gre_level='verbal' AND gre_type='v4' ORDER BY id ASC" );
   $aAllQ4 =array();
  foreach ($result4 as $aValue) {
     
        $aAllQ4[] = array(
          'qtest_id'         =>   $aValue->id, 
          'cat_id'           =>   $aValue->cat_id, 
          'question_type'    =>   $aValue->question_type, 
          'directions'       =>   $aValue->directions, 
          'quiz_type'        =>   $aValue->quiz_type, 
          'reading_comp'     =>   $aValue->reading_comp,
          'question_title'   =>   $aValue->question_title, 
          'qcb1'             =>   $aValue->qcb1, 
          'qcb2'             =>   $aValue->qcb2, 
          'qcb3'             =>   $aValue->qcb3, 
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
          'explanation'      =>   stripslashes($aValue->explanation), 
          'status'           =>   $aValue->status,
          'chkbox_option'    =>   $aValue->chkbox_option,
          'quantity_a'       =>   $aValue->quantity_a,
          'quantity_b'       =>   $aValue->quantity_b,
          'condition'        =>   $aValue->condition,
          'graphics_image'   =>   $aValue->graphics_image
        );
  }


// GRE Math 1
   $result5 = $wpdb->get_results("SELECT * FROM wp_cat_gre_questions where cat_id=" . $id ." AND  gre_level='math' AND gre_type='m1' ORDER BY id ASC" );
   $aAllQ5 =array();
  foreach ($result5 as $aValue) {
     
        $aAllQ5[] = array(
          'qtest_id'         =>   $aValue->id, 
          'cat_id'           =>   $aValue->cat_id, 
          'question_type'    =>   $aValue->question_type, 
          'directions'       =>   $aValue->directions, 
          'quiz_type'        =>   $aValue->quiz_type, 
          'reading_comp'     =>   $aValue->reading_comp,
          'question_title'   =>   $aValue->question_title, 
          'qcb1'             =>   $aValue->qcb1, 
          'qcb2'             =>   $aValue->qcb2, 
          'qcb3'             =>   $aValue->qcb3, 
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
          'explanation'      =>   stripslashes($aValue->explanation), 
          'status'           =>   $aValue->status,
          'chkbox_option'    =>   $aValue->chkbox_option,
          'quantity_a'       =>   $aValue->quantity_a,
          'quantity_b'       =>   $aValue->quantity_b,
          'condition'        =>   $aValue->condition,
          'graphics_image'   =>   $aValue->graphics_image
        );
  }


// GRE Math 2
   $result6 = $wpdb->get_results("SELECT * FROM wp_cat_gre_questions where cat_id=" . $id ." AND  gre_level='math' AND gre_type='m2' ORDER BY id ASC" );
   $aAllQ6 =array();
  foreach ($result6 as $aValue) {
     
        $aAllQ6[] = array(
          'qtest_id'         =>   $aValue->id, 
          'cat_id'           =>   $aValue->cat_id, 
          'question_type'    =>   $aValue->question_type, 
          'directions'       =>   $aValue->directions, 
          'quiz_type'        =>   $aValue->quiz_type, 
          'reading_comp'     =>   $aValue->reading_comp,
          'question_title'   =>   $aValue->question_title, 
          'qcb1'             =>   $aValue->qcb1, 
          'qcb2'             =>   $aValue->qcb2, 
          'qcb3'             =>   $aValue->qcb3, 
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
          'explanation'      =>   stripslashes($aValue->explanation), 
          'status'           =>   $aValue->status,
          'chkbox_option'    =>   $aValue->chkbox_option,
          'quantity_a'       =>   $aValue->quantity_a,
          'quantity_b'       =>   $aValue->quantity_b,
          'condition'        =>   $aValue->condition,
          'graphics_image'   =>   $aValue->graphics_image
        );
  }

// GRE Math 3
   $result7 = $wpdb->get_results("SELECT * FROM wp_cat_gre_questions where cat_id=" . $id ." AND  gre_level='math' AND gre_type='m3' ORDER BY id ASC" );
   $aAllQ7 =array();
  foreach ($result7 as $aValue) {
     
        $aAllQ7[] = array(
          'qtest_id'         =>   $aValue->id, 
          'cat_id'           =>   $aValue->cat_id, 
          'question_type'    =>   $aValue->question_type, 
          'directions'       =>   $aValue->directions, 
          'quiz_type'        =>   $aValue->quiz_type, 
          'reading_comp'     =>   $aValue->reading_comp,
          'question_title'   =>   $aValue->question_title, 
          'qcb1'             =>   $aValue->qcb1, 
          'qcb2'             =>   $aValue->qcb2, 
          'qcb3'             =>   $aValue->qcb3, 
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
          'explanation'      =>   stripslashes($aValue->explanation), 
          'status'           =>   $aValue->status,
          'chkbox_option'    =>   $aValue->chkbox_option,
          'quantity_a'       =>   $aValue->quantity_a,
          'quantity_b'       =>   $aValue->quantity_b,
          'condition'        =>   $aValue->condition,
          'graphics_image'   =>   $aValue->graphics_image
        );
  }

  // GRE Math 4
   $result8 = $wpdb->get_results("SELECT * FROM wp_cat_gre_questions where cat_id=" . $id ." AND  gre_level='math' AND gre_type='m4' ORDER BY id ASC" );
   $aAllQ8 =array();
  foreach ($result8 as $aValue) {
     
        $aAllQ8[] = array(
          'qtest_id'         =>   $aValue->id, 
          'cat_id'           =>   $aValue->cat_id, 
          'question_type'    =>   $aValue->question_type, 
          'directions'       =>   $aValue->directions, 
          'quiz_type'        =>   $aValue->quiz_type, 
          'reading_comp'     =>   $aValue->reading_comp,
          'question_title'   =>   $aValue->question_title, 
          'qcb1'             =>   $aValue->qcb1, 
          'qcb2'             =>   $aValue->qcb2, 
          'qcb3'             =>   $aValue->qcb3, 
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
          'explanation'      =>   stripslashes($aValue->explanation), 
          'status'           =>   $aValue->status,
          'chkbox_option'    =>   $aValue->chkbox_option,
          'quantity_a'       =>   $aValue->quantity_a,
          'quantity_b'       =>   $aValue->quantity_b,
          'condition'        =>   $aValue->condition,
          'graphics_image'   =>   $aValue->graphics_image
        );
  }


   $aFirst = array(
      'total_time' => round(count($result1) * 1.5),
      'total_question' => count($result1)
   );

   global $wpdb;
    $aUserDataDb1 = $wpdb->get_row( "SELECT user_answer FROM ".($wpdb->prefix . 'gre_cta_answers')." WHERE category_id = ".$id." AND wp_user_id = '6100'");
    $aUserDataDb1 = stripslashes($aUserDataDb1->user_answer);


   $sResData1 = json_encode($aAllQ1);
   $sResData2 = json_encode($aAllQ2);
   $sResData3 = json_encode($aAllQ3);
   $sResData4 = json_encode($aAllQ4);
   $sResData5 = json_encode($aAllQ5);
   $sResData6 = json_encode($aAllQ6);
   $sResData7 = json_encode($aAllQ7);
   $sResData8 = json_encode($aAllQ8);

   echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>';
   $sFirstTime = 'false';
   if(CatApp_is_first_time() == true){
      $sFirstTime = 'true';
   }

  echo '<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css?ver=5.5">';
   echo '<script src="'.WP_PLUGIN_URL.'/catApp/assets/js/gre_cat_app.js"></script>';
  extract(shortcode_atts(array('id' => ''), $atts));
  include('template/gre/greTestShortcode.php');
}

add_shortcode('Gretest', 'GreTestShortcode');


//////////////////////////////////////// Shortcode for GMAT Test ///////////////////////////////////////////

function gmatTestShortcode($atts)
{
   $id = $atts['id'];
   
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
   $result1 = $wpdb->get_results("SELECT * FROM wp_gmat_question where qcategory_id=" . $id . " AND hard_level = 'very-easy'");
   $testTime = $wpdb->get_row("SELECT test_time FROM wp_cta_category where qcategory_id=" . $id . "");
  
  foreach ($result1 as $aValue1) {
    $result = $wpdb->get_results("SELECT * FROM wp_gmat_question where question_no=" . $aValue1->question_no);
    if(count($result) > 0){
      $aAllQ[$aValue1->question_no]= array();
      foreach ($result as $aValue) {
        $aAllQ[$aValue1->question_no][] = array(

          'id'               =>   $aValue->id, 
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

  $totalTestTime =  $testTime->test_time; 
  if($totalTestTime !='' || $totalTestTime != NULL){
      $aFirst = array(
        'total_time' => $totalTestTime,
        'total_question' => count($result1)
     );
  }else{
      $aFirst = array(
        'total_time' => round(count($result1) * 1.5),
        'total_question' => count($result1)
     );
  }
   

  
    $aData['category_id'] = $id;
 
    $sResData = json_encode($aAllQ);
    echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>';
    // Get user answer stored in the DB
    $aUserDataDb = "";
    global $wpdb;

    if ( is_user_logged_in() ) {
      $current_user = wp_get_current_user();
      $aUserDataDb = $wpdb->get_row( "SELECT user_answer FROM ".($wpdb->prefix . 'gmat_cta_answers')." WHERE category_id = ".$id." AND wp_user_id = ".$current_user->user_login);
      $aUserDataDb = stripslashes($aUserDataDb->user_answer);
    }else{
      $aUserDataDb = ' ';
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
   echo '<script src="'.WP_PLUGIN_URL.'/catApp/assets/js/gmat_cat_app.js"></script>';
   extract(shortcode_atts(array('id' => ''), $atts));
   include('template/gmat/gmatTestShortcode.php');
}

add_shortcode('GMAT-TEST', 'gmatTestShortcode');




function summeryFunction($catID, $userID, $type){
    global $wpdb;

    $res = $wpdb->get_row("SELECT * FROM wp_gmat_cta_answers where category_id=" . $catID . " AND wp_user_id = ". $userID);
    if(count($res) > 0){
        $val =  $res->status;
        if($val == 'running'){
           $res  = 'Progress';
        }elseif($val == 'explanation'){
           $res  = 'Review ('.round($res->final_score).')';
        }elseif($val == 'Reset'){
          $res  = 'Start';
        }
    }else{
      $res = 'Start';
    }
  return $res;
}

function arrayValues($num, $mathVal){
   
  $arrVerbal6 = array(500,490,480,470,460,450,440,430,420,420,410,400,390,380,370,360,350,340,330,330,320,310,300,290,280,270,260,250,240,240,230,220,210,200,190,180,170,160,150,150,140,130,120,110,100,90,80,70,60,60,50,40);
  sort($arrVerbal6);
  $arrVerbal['6']  = $arrVerbal6;

  $arrVerbal7 = array(500,490,490,480,470,460,450,440,430,420,410,400,400,390,380,370,360,350,340,330,320,310,310,300,290,280,270,260,250,240,230,220,220,210,200,190,180,170,160,150,140,130,130,120,110,100,90,80,70,60,50,40);
  sort($arrVerbal7);
  $arrVerbal['7']  = $arrVerbal7;

  $arrVerbal8 = array(510,500,490,480,470,470,460,450,440,430,420,410,400,390,380,380,370,360,350,340,330,320,310,300,290,290,280,270,260,250,240,230,220,210,200,200,190,180,170,160,150,140,130,120,110,110,100,90,80,70,60,50);
  sort($arrVerbal8);
  $arrVerbal['8']  = $arrVerbal8;

  $arrVerbal9 = array(520,210,200,490,480,470,460,450,450,440,430,420,410,400,390,380,370,360,360,350,340,330,320,310,300,290,280,270,270,260,250,240,230,220,210,200,190,180,180,170,160,150,140,130,120,110,100,90,90,80,70,60);
  sort($arrVerbal9);
  $arrVerbal['9']  = $arrVerbal9;

  $arrVerbal10 = array(500,490,480,470,470,460,450,440,440,420,420,410,410,400,390,380,370,360,350,340,330,320,310,300,290,280,270,260,250,240,230,220,210,200,220,210,200,190,180,170,160,160,150,140,130,120,110,100,90,80,70,70);
  sort($arrVerbal10);
  $arrVerbal['10']  = $arrVerbal10;
  
  $arrVerbal11 = array(510,500,490,480,470,470,460,450,440,440,420,420,420,420,420,410,400,390,380,370,360,350,350,340,330,320,310,300,290,280,270,260,250,240,230,220,210,200,190,180,170,160,150,140,140,130,120,110,100,90,80,70);
  sort($arrVerbal11);
  $arrVerbal['11']  = $arrVerbal11;
  
  $arrVerbal12 = array(510,500,490,490,480,470,470,460,450,440,440,420,420,410,400,410,400,390,380,370,370,360,350,340,330,320,310,300,290,280,270,260,250,240,230,220,210,210,200,190,180,170,160,150,140,130,120,110,110,100,90,80);
  sort($arrVerbal12);
  $arrVerbal['12']  = $arrVerbal12;
  
  $arrVerbal13 = array(520,510,500,490,490,480,470,470,460,450,440,440,420,420,410,400,400,390,380,370,370,370,360,350,340,330,320,310,300,290,280,270,260,250,240,230,220,210,200,200,190,180,170,160,150,140,130,120,110,100,100,90);
  sort($arrVerbal13);
  $arrVerbal['13']  = $arrVerbal13;
  
  $arrVerbal14 = array(530,520,510,500,490,490,480,470,470,460,450,440,440,420,420,410,400,390,380,370,360,350,350,340,340,340,330,320,310,300,290,280,270,260,250,240,230,220,210,200,190,180,170,170,160,150,140,130,120,110,100,90);
  sort($arrVerbal14);
  $arrVerbal['14']  = $arrVerbal14;

  $arrVerbal15 = array(540,530,520,510,500,490,490,480,470,470,460,450,440,440,420,420,410,400,390,380,370,360,350,340,340,340,330,320,310,300,290,280,270,260,250,240,240,230,220,210,200,190,180,170,160,150,150,140,130,120,110,100);
  sort($arrVerbal15);
  $arrVerbal['15']  = $arrVerbal15;

  $arrVerbal16 = array(560,550,540,530,520,510,500,490,490,480,470,470,460,450,440,440,420,420,410,400,390,380,400,390,380,370,360,360,360,360,360,350,340,320,260,250,240,230,220,220,210,200,190,180,170,160,150,140,130,130,120,110);
  sort($arrVerbal16);
  $arrVerbal['16']  = $arrVerbal16;

  $arrVerbal17 = array(570,560,550,540,540,530,520,520,510,500,490,490,480,470,470,460,450,440,430,420,410,410,400,390,380,370,360,360,360,360,340,340,330,320,270,260,250,240,230,220,210,200,200,190,180,170,160,150,140,130,120,110);
  sort($arrVerbal17);
  $arrVerbal['17']  = $arrVerbal17;

  $arrVerbal18 = array(580,560,550,540,540,530,520,520,510,500,490,490,480,470,470,460,450,440,430,420,410,400,400,390,380,370,360,350,340,330,320,310,300,290,270,270,260,250,240,230,220,210,200,190,180,180,170,160,150,140,130,120);
  sort($arrVerbal18);
  $arrVerbal['18']  = $arrVerbal18;

  $arrVerbal19 = array(590,580,560,550,540,540,530,530,520,520,510,500,490,490,480,470,470,460,450,440,430,420,410,400,390,380,370,360,350,340,330,320,310,300,280,270,260,250,250,240,230,220,210,200,190,180,170,160,160,150,140,130);
  sort($arrVerbal19);
  $arrVerbal['19']  = $arrVerbal19;

  $arrVerbal20 =  array(600,580,570,570,560,550,540,540,530,530,520,510,500,500,490,480,470,460,450,440,440,430,420,410,400,390,380,370,360,350,340,340,330,320,310,300,290,260,250,240,230,230,220,210,200,190,180,170,160,150,140,140);
  sort($arrVerbal20);
  $arrVerbal['20']  = $arrVerbal20;

  $arrVerbal21 =  array(610,600,580,570,570,560,560,550,540,540,530,520,510,500,500,490,480,470,460,450,440,440,430,420,410,400,390,380,370,360,350,350,340,330,320,310,300,270,260,250,240,230,220,210,210,200,190,180,170,160,150,140);
  sort($arrVerbal21);
  $arrVerbal['21']  = $arrVerbal21;
  
  $arrVerbal22 =  array(610,600,590,580,570,560,560,550,540,540,530,520,510,500,500,490,480,470,460,450,440,440,430,420,410,410,400,400,390,380,370,370,360,350,340,330,310,280,270,260,250,240,230,220,210,200,200,190,180,170,160,150);
  sort($arrVerbal22);
  $arrVerbal['22']  = $arrVerbal22;

  $arrVerbal23 =  array(620,620,600,590,580,570,570,570,560,550,540,530,520,520,510,510,500,490,480,480,470,460,450,440,430,430,420,410,400,390,380,380,370,360,350,340,310,280,270,260,260,250,240,230,220,210,200,190,180,170,170,160);
  sort($arrVerbal23);
  $arrVerbal['23']  = $arrVerbal23;
  
  $arrVerbal24 =  array(620,620,600,600,590,580,570,560,550,550,540,530,530,520,520,510,500,490,490,480,470,470,460,450,440,430,420,420,410,400,400,390,380,370,360,350,320,290,280,270,260,250,240,240,230,220,210,200,190,180,170,160);
  sort($arrVerbal24);
  $arrVerbal['24']  = $arrVerbal24;

  $arrVerbal25 =  array(640,630,620,600,590,580,580,570,560,560,550,550,540,540,530,520,510,500,490,480,470,460,460,450,440,430,420,420,410,410,400,390,380,370,360,350,340,300,290,280,270,260,250,240,230,220,220,210,200,190,180,170);
  sort($arrVerbal25);
  $arrVerbal['25']  = $arrVerbal25;

  $arrVerbal26 =  array(640,630,620,610,600,600,590,580,580,570,570,570,560,550,530,520,510,510,500,490,480,470,460,460,450,440,440,430,420,410,410,390,380,370,370,360,350,300,290,290,280,270,260,250,240,230,220,210,200,200,190,180);
  sort($arrVerbal26);
  $arrVerbal['26']  = $arrVerbal26;

  $arrVerbal27 =  array(640,630,630,620,610,600,600,600,590,580,570,560,560,550,540,530,520,510,500,490,490,480,470,460,450,440,430,420,420,420,410,410,400,390,380,370,360,310,300,290,280,270,270,260,250,240,230,220,210,200,190,180);
  sort($arrVerbal27);
  $arrVerbal['27']  = $arrVerbal27;

  $arrVerbal28 =  array(670,640,640,630,620,610,600,590,590,580,580,570,560,550,550,540,530,530,520,510,500,490,480,470,460,460,450,440,430,420,410,400,390,380,370,360,360,320,310,300,290,280,270,260,250,250,240,230,220,210,200,190);
  sort($arrVerbal28);
  $arrVerbal['28']  = $arrVerbal28;

  $arrVerbal29 =  array(670,660,640,640,640,630,620,610,600,590,580,580,570,560,550,540,530,530,520,510,500,500,490,480,470,460,460,450,440,440,430,420,410,400,390,380,370,330,320,310,300,290,280,270,260,250,240,230,230,220,210,200);
  sort($arrVerbal29);
  $arrVerbal['29']  = $arrVerbal29;
  
  $arrVerbal30 =  array(670,660,650,650,640,630,620,610,600,600,590,580,570,560,560,560,550,540,530,520,520,510,510,500,490,480,470,460,450,440,430,420,410,400,390,390,370,350,320,310,300,300,290,280,270,260,250,240,230,220,210,210);
  sort($arrVerbal30);
  $arrVerbal['30']  = $arrVerbal30;

  $arrVerbal31 =  array(690,680,670,650,640,630,620,610,600,600,590,580,580,570,560,550,540,550,540,540,530,520,520,510,500,490,480,470,460,450,440,430,420,410,400,390,380,370,330,320,310,300,290,280,280,270,260,250,240,230,220,210);
  sort($arrVerbal31);
  $arrVerbal['31']  = $arrVerbal31;

  $arrVerbal32 =  array(690,680,660,650,650,640,640,630,620,610,600,600,590,590,580,570,560,550,540,540,540,530,520,510,500,500,490,480,470,460,450,440,430,420,410,400,390,380,340,330,320,310,300,300,280,270,260,260,250,240,230,220);
  sort($arrVerbal32);
  $arrVerbal['32']  = $arrVerbal32;

  $arrVerbal33 =  array(700,700,680,660,660,650,640,630,620,610,600,600,590,580,570,570,560,550,540,530,530,530,520,510,510,500,490,480,470,460,450,450,440,430,420,410,400,390,340,330,330,320,310,300,290,280,270,260,250,240,240,230);
  sort($arrVerbal33);
  $arrVerbal['33']  = $arrVerbal33;

  $arrVerbal34 =  array(710,700,690,680,670,650,640,640,630,630,620,610,600,590,590,580,570,570,560,560,560,540,530,520,520,510,500,490,480,470,460,450,440,430,420,410,400,390,350,340,330,320,310,310,300,290,280,270,260,250,240,230);
  sort($arrVerbal34);
  $arrVerbal['34']  = $arrVerbal34;

  $arrVerbal35 =  array(710,710,700,700,670,660,660,650,640,640,630,620,610,600,600,590,580,580,570,560,550,550,540,530,520,510,500,490,480,470,460,450,450,440,440,430,410,390,360,350,340,330,320,310,300,300,290,280,270,260,250,240);
  sort($arrVerbal35);
  $arrVerbal['35']  = $arrVerbal35;

  $arrVerbal36 =  array(720,710,700,690,680,680,660,650,650,640,630,620,610,610,600,600,590,580,580,570,560,550,550,540,530,520,510,500,490,480,470,460,450,440,430,420,410,390,360,360,350,340,330,320,310,300,290,280,270,270,260,250);
  sort($arrVerbal36);
  $arrVerbal['36']  = $arrVerbal36;

  $arrVerbal37 =  array(720,720,700,690,680,680,660,660,650,650,640,640,630,630,620,610,600,600,590,580,570,560,550,540,530,530,520,510,500,490,480,470,460,450,440,430,420,410,370,360,350,340,340,330,320,310,300,290,280,270,260,250);
  sort($arrVerbal37);
  $arrVerbal['37']  = $arrVerbal37;

  $arrVerbal38 =  array(730,720,710,700,700,690,690,680,670,650,640,640,640,630,620,610,610,600,590,590,590,560,550,540,530,530,520,510,500,490,490,480,470,460,450,440,430,420,380,370,360,350,340,330,320,320,310,300,290,280,270,260);
  sort($arrVerbal38);
  $arrVerbal['38']  = $arrVerbal38;

  $arrVerbal39 =  array(740,740,720,710,700,700,690,680,670,660,660,650,650,640,630,620,610,600,600,590,580,570,560,550,540,530,520,510,500,490,480,470,460,450,440,430,430,420,390,380,370,360,350,340,330,320,310,300,300,290,280,270);
  sort($arrVerbal39);
  $arrVerbal['39']  = $arrVerbal39;

  $arrVerbal40 =  array(750,740,730,720,710,700,690,680,680,680,670,660,650,650,640,630,620,610,600,590,580,570,560,550,540,540,530,520,510,500,500,500,490,450,450,430,410,400,390,380,370,370,360,350,340,330,320,310,300,290,280,280);
  sort($arrVerbal40);
  $arrVerbal['40']  = $arrVerbal40;

  $arrVerbal41 =  array(760,750,730,730,720,710,700,700,690,690,680,670,660,650,650,640,630,620,610,600,590,580,570,560,550,540,530,520,520,510,500,500,490,490,460,430,420,410,400,390,380,370,360,350,350,340,330,320,310,300,290,280);
  sort($arrVerbal41);
  $arrVerbal['41']  = $arrVerbal41;

  $arrVerbal42 =  array(760,750,740,730,720,720,710,700,690,690,680,670,660,650,640,630,620,620,620,610,600,590,580,570,560,550,550,540,530,520,510,500,490,490,470,440,430,420,410,400,390,380,370,360,350,340,330,330,320,310,300,290);
  sort($arrVerbal42);
  $arrVerbal['42']  = $arrVerbal42;

  $arrVerbal43 =  array(760,750,740,730,720,720,710,700,690,690,680,670,660,650,650,630,630,620,630,620,600,580,580,580,570,560,560,550,540,530,520,530,520,510,470,440,430,420,410,400,400,390,380,370,360,350,340,330,320,310,300,300);
  sort($arrVerbal43);
  $arrVerbal['43']  = $arrVerbal43;

  $arrVerbal44 =  array(770,770,760,750,740,730,720,710,710,700,690,680,680,670,660,650,640,640,640,630,620,610,600,590,580,570,560,560,550,540,530,520,510,500,470,450,440,430,420,410,400,390,380,380,370,360,350,340,330,320,310,300);
  sort($arrVerbal44);
  $arrVerbal['44']  = $arrVerbal44;

  $arrVerbal45 =  array(780,770,760,750,750,740,730,720,720,710,710,700,690,680,680,670,660,650,640,630,620,600,610,600,590,580,570,560,550,540,540,530,520,510,490,460,450,440,430,420,410,400,390,380,370,360,360,350,340,330,320,310);
  sort($arrVerbal45);
  $arrVerbal['45']  = $arrVerbal45;

  $arrVerbal46 =  array(780,770,760,750,740,740,730,730,730,720,720,710,700,700,690,680,670,670,660,650,640,630,620,610,600,590,580,570,560,550,540,530,520,510,500,470,450,450,440,430,420,410,400,390,380,370,360,350,340,340,330,320);
  sort($arrVerbal46);
  $arrVerbal['46']  = $arrVerbal46;

  $arrVerbal47 =  array(790,780,770,770,760,750,740,730,730,720,720,710,710,700,700,690,680,670,660,650,640,630,620,610,600,590,580,570,570,560,550,540,530,520,510,480,470,450,440,440,430,420,410,400,390,380,370,360,350,340,330,320);
  sort($arrVerbal47);
  $arrVerbal['47']  = $arrVerbal47;

  $arrVerbal48 =  array(780,780,770,770,760,760,750,730,730,720,720,710,710,700,700,690,690,690,680,670,650,640,630,620,610,600,590,580,580,570,560,550,540,530,520,480,470,460,450,440,430,420,410,400,400,390,380,370,360,350,340,330);
  sort($arrVerbal48);
  $arrVerbal['48']  = $arrVerbal48;

  $arrVerbal49 =  array(800,780,770,770,760,760,750,750,740,740,730,730,730,720,720,710,710,700,690,680,670,660,650,630,620,610,600,590,580,570,560,550,540,530,520,490,480,470,460,450,440,430,420,410,400,400,390,380,370,360,350,340);
  sort($arrVerbal49);
  $arrVerbal['49']  = $arrVerbal49;

  $arrVerbal50 =  array(790,790,780,780,770,770,760,760,750,750,740,740,730,730,720,710,700,690,680,670,660,650,640,630,620,610,600,590,580,570,560,550,540,530,520,490,480,470,460,450,450,440,430,420,410,400,390,380,370,370,360,350);
  sort($arrVerbal50);
  $arrVerbal['50']  = $arrVerbal50;

  $arrVerbal51 =  array(800,790,790,780,780,780,770,770,760,760,750,750,740,730,730,720,710,700,690,680,670,660,650,640,630,620,610,600,590,580,570,560,550,540,530,510,500,490,460,450,440,430,420,420,420,410,400,390,380,370,360,350);
  sort($arrVerbal51);
  $arrVerbal['51']  = $arrVerbal51;

  return $arrVerbal[$num][$mathVal];
 
}

function finalResultSummery($userID, $verbaCatlId, $mathCatId){
    global $wpdb;
    $verbalScore  = $wpdb->get_row("SELECT * FROM wp_gmat_cta_answers where category_id=".$verbaCatlId." AND wp_user_id=".$userID);
    $mathScore    = $wpdb->get_row("SELECT * FROM wp_gmat_cta_answers where category_id=".$mathCatId." AND wp_user_id=".$userID);
    if(count($verbalScore) > 0 && count($mathScore) > 0){
      $scoreval =  arrayValues($verbalScore->final_score, $mathScore->final_score);
      if($scoreval > '200'){ echo $scoreval;  }else{ echo '200';}
    }else{
      echo '----';
    }
    
}