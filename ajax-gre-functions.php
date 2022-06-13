<?php

//Save  GRE Questions.
add_action('wp_ajax_saveGRETest', 'saveGRETest');
add_action('wp_ajax_nopriv_saveGRETest', 'saveGRETest');
function saveGRETest(){
   

   $user_id     = get_current_user_id();
    $select_type = $_POST['select_type'];

   if($select_type == '1'){
      $directions       = $_POST['obt_directions']; 
      $cat_id           = $_POST['cat_id']; 
      $question         = $_POST['obt_question'];
      $qcb1             = $_POST['obt_qcb1'];
      $right_answer     = $_POST['obt_right_answer'];
      $explanation      = $_POST['obt_explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'directions' => $directions,'question_title' =>$question,'qcb1'=>$qcb1, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'explanation'=>$explanation);
   } 

   if($select_type == '2'){
      $directions       = $_POST['directions']; 
      $cat_id           = $_POST['cat_id']; 
      $question         = $_POST['question'];
      $qcb1             = $_POST['qcb1'];
      $qcb2             = $_POST['qcb2'];
      $right_answer     = $_POST['right_answer'];
      $explanation      = $_POST['explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'directions' => $directions,'question_title' =>$question,'qcb1'=>$qcb1, 'qcb2'=>$qcb2, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'explanation'=>$explanation);
   }

   if($select_type == '3'){
      $directions       = $_POST['directions']; 
      $cat_id           = $_POST['cat_id']; 
      $question         = $_POST['question'];
      $qcb1             = $_POST['qcb1'];
      $qcb2             = $_POST['qcb2'];
      $qcb3             = $_POST['qcb3'];
      $right_answer     = $_POST['right_answer'];
      $explanation      = $_POST['explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'directions' => $directions,'question_title' =>$question,'qcb1'=>$qcb1, 'qcb2'=>$qcb2, 'qcb3'=>$qcb3, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'explanation'=>$explanation);
   }

   if($select_type == '4'){
      $reading_comp     = $_POST['reading_comp'];  
      $directions       = $_POST['directions']; 
      $cat_id           = $_POST['cat_id']; 
      $question         = $_POST['question'];
      $option_a         = $_POST['option_a'];
      $a_explain        = $_POST['a_explain'];
      $option_b         = $_POST['option_b'];
      $b_explain        = $_POST['b_explain'];
      $option_c         = $_POST['option_c'];
      $c_explain        = $_POST['c_explain'];
      $option_d         = $_POST['option_d'];
      $d_explain        = $_POST['d_explain'];
      $option_e         = $_POST['option_e'];
      $e_explain        = $_POST['e_explain'];
      $right_answer     = $_POST['right_answer'];
      $explanation      = $_POST['explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'directions' => $directions, 'reading_comp' => $reading_comp,'question_title' =>$question,'a_option'=>$option_a, 'a_explain'=>$a_explain, 'b_option'=>$option_b, 'b_explain'=>$b_explain, 'c_option'=>$option_c, 'c_explain'=>$c_explain,'d_option'=>$option_d, 'd_explain'=>$d_explain, 'e_option'=>$option_e, 'e_explain'=>$e_explain, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'explanation'=>$explanation);
   }

   if($select_type == '5'){
      $directions       = $_POST['directions']; 
      $cat_id           = $_POST['cat_id']; 
      $question         = $_POST['question'];
      $chkbox_option    = $_POST['chkbox_option'];
      $right_answer     = $_POST['right_answer'];
      $explanation      = $_POST['explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'directions' => $directions,'question_title' =>$question,'chkbox_option'=>$chkbox_option, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level,'explanation'=>$explanation);

      
   }

   if($select_type == '6'){
      
      $cat_id           = $_POST['cat_id']; 
      $question         = $_POST['question'];
      $reading_comp     = $_POST['reading_comp']; 
      $explanation      = $_POST['explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $right_answer     = $_POST['right_answer'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'reading_comp' => $reading_comp,'question_title' =>$question, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'explanation'=>$explanation);
   }

    if($select_type == '7'){

      
      $optionType = $_POST['option_type'];
      if(!empty( $_FILES["quiz_image_1"]["name"])){
           $str         = $_FILES["quiz_image_1"]["name"];
           $extension   = end(explode(".", $str));
           $newfilename = "IMG_".time().".".$extension;
           move_uploaded_file($_FILES['quiz_image_1']['tmp_name'], plugin_dir_path( __FILE__ ).'assets/quizImage/'.$newfilename);
           $graphics_image   = $newfilename;
      }else{
         //$graphics_image = $_POST['quiz_image_1_old'];
         $graphics_image = '';
      }

      if($optionType == 0 || $optionType == 3){

         $cat_id           = $_POST['cat_id']; 
         $question         = $_POST['question'];
         $option_a         = $_POST['option_a'];
         $option_b         = $_POST['option_b'];
         $option_c         = $_POST['option_c'];
         $option_d         = $_POST['option_d'];
         $option_e         = $_POST['option_e'];
         $right_answer     = $_POST['right_answer'];
         $explanation      = $_POST['explanation'];
         $gre_type         = $_POST['gre_type'];
         $gre_level        = $_POST['gre_level'];

         $data  = array('cat_id' => $cat_id, 'question_type' => $select_type, 'question_title' =>$question, 'graphics_image' => $graphics_image, 'a_option'=>$option_a, 'b_option'=>$option_b, 'c_option'=>$option_c,'d_option'=>$option_d, 'e_option'=>$option_e, 'right_answer'=>$right_answer, 'explanation'=>$explanation, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'condition' => $optionType);


      }elseif ($optionType == 1) {
         $cat_id           = $_POST['cat_id']; 
         $question         = $_POST['question'];
         $quantity_a       = $_POST['quantity_a'];
         $quantity_b       = $_POST['quantity_b'];
         $option_a         = $_POST['option_a'];
         $option_b         = $_POST['option_b'];
         $option_c         = $_POST['option_c'];
         $option_d         = $_POST['option_d'];
         $option_e         = $_POST['option_e'];
         $right_answer     = $_POST['right_answer'];
         $explanation      = $_POST['explanation'];
         $gre_type         = $_POST['gre_type'];
         $gre_level        = $_POST['gre_level'];
         $gre_type         = $_POST['gre_type'];
         $gre_level        = $_POST['gre_level'];

         $data  = array('cat_id' => $cat_id, 'question_type' => $select_type, 'question_title' =>$question, 'graphics_image' => $graphics_image, 'a_option'=>$option_a, 'b_option'=>$option_b, 'c_option'=>$option_c,'d_option'=>$option_d, 'e_option'=>$option_e, 'right_answer'=>$right_answer, 'quantity_a'=>$quantity_a, 'quantity_b'=>$quantity_b, 'explanation'=>$explanation, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'condition' => $optionType);

      }elseif ($optionType == 2 ) {
         
         $cat_id           = $_POST['cat_id']; 
         $question         = $_POST['question'];
         $right_answer     = $_POST['right_answer'];
         $explanation      = $_POST['explanation'];
         $gre_type         = $_POST['gre_type'];
         $gre_level        = $_POST['gre_level'];

         $data  = array('cat_id' => $cat_id, 'question_type' => $select_type, 'question_title' =>$question, 'graphics_image' => $graphics_image,  'right_answer'=>$right_answer, 'explanation'=>$explanation, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'condition' => $optionType );
      }
   
      
   }

   global $wpdb;
   $table = $wpdb->prefix."cat_gre_questions";
   $wpdb->insert($table, $data);
   $lastid = $wpdb->insert_id;
    
   if($lastid > 0){
      echo "succesc";
   }else{
      echo "error";   
   }   
   die();
}

////////////////////////////////////// Update GRE Questions /////////////////////////////////////////////


add_action('wp_ajax_updateGREQuestion', 'updateGREQuestions');
add_action('wp_ajax_nopriv_updateGREQuestion', 'updateGREQuestions');
function updateGREQuestions(){
   

   $user_id     = get_current_user_id();
   $select_type = $_POST['select_type'];
   $id          = $_POST['obt_question_id'];
  
  
   if($select_type == '1'){
      $directions       = $_POST['obt_directions']; 
      $question         = $_POST['obt_question'];
      $cat_id           = $_POST['cat_id']; 
      $qcb1             = $_POST['obt_qcb1'];
      $right_answer     = $_POST['right_answer'];
      $explanation      = $_POST['obt_explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'directions' => $directions,'question_title' =>$question,'qcb1'=>$qcb1, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'explanation'=>$explanation);
   } 

   if($select_type == '2'){
      $directions       = $_POST['directions']; 
      $cat_id           = $_POST['cat_id']; 
      $question         = $_POST['question'];
      $qcb1             = $_POST['qcb1'];
      $qcb2             = $_POST['qcb2'];
      $right_answer     = $_POST['right_answer'];
      $explanation      = $_POST['explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'directions' => $directions,'question_title' =>$question,'qcb1'=>$qcb1, 'qcb2'=>$qcb2, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'explanation'=>$explanation);
   }

   if($select_type == '3'){

      $directions       = $_POST['directions']; 
      $cat_id           = $_POST['cat_id']; 
      $question         = $_POST['question'];
      $qcb1             = $_POST['qcb1'];
      $qcb2             = $_POST['qcb2'];
      $qcb3             = $_POST['qcb3'];
      $right_answer     = $_POST['right_answer'];
      $explanation      = $_POST['explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'directions' => $directions,'question_title' =>$question,'qcb1'=>$qcb1, 'qcb2'=>$qcb2, 'qcb3'=>$qcb3, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'explanation'=>$explanation);
   }

   if($select_type == '4'){
      $reading_comp     = $_POST['reading_comp'];  
      $cat_id           = $_POST['cat_id']; 
      $question         = $_POST['question'];
      $option_a         = $_POST['option_a'];
      $a_explain        = $_POST['a_explain'];
      $option_b         = $_POST['option_b'];
      $b_explain        = $_POST['b_explain'];
      $option_c         = $_POST['option_c'];
      $c_explain        = $_POST['c_explain'];
      $option_d         = $_POST['option_d'];
      $d_explain        = $_POST['d_explain'];
      $option_e         = $_POST['option_e'];
      $e_explain        = $_POST['e_explain'];
      $right_answer     = $_POST['right_answer'];
      $explanation      = $_POST['explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'reading_comp' => $reading_comp,'question_title' =>$question,'a_option'=>$option_a, 'a_explain'=>$a_explain, 'b_option'=>$option_b, 'b_explain'=>$b_explain, 'c_option'=>$option_c, 'c_explain'=>$c_explain,'d_option'=>$option_d, 'd_explain'=>$d_explain, 'e_option'=>$option_e, 'e_explain'=>$e_explain, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'explanation'=>$explanation);
   }

   if($select_type == '5'){
      $directions       = $_POST['directions']; 
      $cat_id           = $_POST['cat_id']; 
      $question         = $_POST['question'];
      $chkbox_option    = $_POST['chkbox_option'];
      $right_answer     = $_POST['right_answer'];
      $explanation      = $_POST['explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'directions' => $directions,'question_title' =>$question,'chkbox_option'=>$chkbox_option, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level,'explanation'=>$explanation);

      // echo '<pre>';
      // print_r(print_r($data));
      // echo '</pre>'; die;
   }

   if($select_type == '6'){
      
      $cat_id           = $_POST['cat_id']; 
      $question         = $_POST['question'];
      $reading_comp     = $_POST['reading_comp']; 
      $explanation      = $_POST['explanation'];
      $gre_type         = $_POST['gre_type'];
      $gre_level        = $_POST['gre_level'];
      $right_answer     = $_POST['right_answer'];
      $data             = array('cat_id' => $cat_id, 'question_type' => $select_type, 'reading_comp' => $reading_comp, 'question_title' =>$question, 'right_answer'=>$right_answer, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'explanation'=>$explanation);


   }

   if($select_type == '7'){
      $optionType = $_POST['option_type'];
      if(!empty( $_FILES["quiz_image_1"]["name"])){
           $str         = $_FILES["quiz_image_1"]["name"];
           $extension   = end(explode(".", $str));
           $newfilename = "IMG_".time().".".$extension;
           move_uploaded_file($_FILES['quiz_image_1']['tmp_name'], plugin_dir_path( __FILE__ ).'assets/quizImage/'.$newfilename);
           $graphics_image   = $newfilename;
      }else{
         $graphics_image = '';
      }

      if($optionType == 0 || $optionType == 3){

         $cat_id           = $_POST['cat_id']; 
         $question         = $_POST['question'];
         $option_a         = $_POST['option_a'];
         $option_b         = $_POST['option_b'];                        
         $option_c         = $_POST['option_c'];
         $option_d         = $_POST['option_d'];
         $option_e         = $_POST['option_e'];
         $right_answer     = $_POST['right_answer'];
         $explanation      = $_POST['explanation'];
         $gre_type         = $_POST['gre_type'];
         $gre_level        = $_POST['gre_level'];

         $data  = array('cat_id' => $cat_id, 'question_type' => $select_type, 'question_title' =>$question, 'graphics_image' => $graphics_image, 'a_option'=>$option_a, 'b_option'=>$option_b, 'c_option'=>$option_c,'d_option'=>$option_d, 'e_option'=>$option_e, 'right_answer'=>$right_answer, 'explanation'=>$explanation, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'condition' => $optionType);


      }elseif ($optionType == 1) {
         $cat_id           = $_POST['cat_id']; 
         $question         = $_POST['question'];
         $quantity_a       = $_POST['quantity_a'];
         $quantity_b       = $_POST['quantity_b'];
         $option_a         = $_POST['option_a'];
         $option_b         = $_POST['option_b'];
         $option_c         = $_POST['option_c'];
         $option_d         = $_POST['option_d'];
         $option_e         = $_POST['option_e'];
         $right_answer     = $_POST['right_answer'];
         $explanation      = $_POST['explanation'];
         $gre_type         = $_POST['gre_type'];
         $gre_level        = $_POST['gre_level'];
         $gre_type         = $_POST['gre_type'];
         $gre_level        = $_POST['gre_level'];

         $data  = array('cat_id' => $cat_id, 'question_type' => $select_type, 'question_title' =>$question, 'graphics_image' => $graphics_image, 'a_option'=>$option_a, 'b_option'=>$option_b, 'c_option'=>$option_c,'d_option'=>$option_d, 'e_option'=>$option_e, 'right_answer'=>$right_answer, 'quantity_a'=>$quantity_a, 'quantity_b'=>$quantity_b, 'explanation'=>$explanation, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'condition' => $optionType);

      }elseif ($optionType == 2 ) {
         
         $cat_id           = $_POST['cat_id']; 
         $question         = $_POST['question'];
         $right_answer     = $_POST['right_answer'];
         $explanation      = $_POST['explanation'];
         $gre_type         = $_POST['gre_type'];
         $gre_level        = $_POST['gre_level'];

         $data  = array('cat_id' => $cat_id, 'question_type' => $select_type, 'question_title' =>$question, 'graphics_image' => $graphics_image,  'right_answer'=>$right_answer, 'explanation'=>$explanation, 'gre_type'=>$gre_type, 'gre_level'=>$gre_level, 'condition' => $optionType );
      }
   
      
   }

   global $wpdb;
   

   $table = $wpdb->prefix."cat_gre_questions";
   $where = array('id' => $id);
   $wpdb->update($table, $data, $where);
   $lastid =  $wpdb->last_query;
   echo "succesc";  
   die();
}


 
//////////////////////Update GRE Category////////////////////////////////////////////////

add_action('wp_ajax_updateGreCategory', 'updateGreCategory');
add_action('wp_ajax_nopriv_updateGreCategory', 'updateGreCategory');
function updateGreCategory(){

   $qcategory_id                 = $_POST['qcategory_id'];
   $category_title               = $_POST['category_title'];
   $test_height                  = $_POST['test_height'];
   $questions_test_height        = $_POST['questions_test_height'];
   $questions_explanation_height = $_POST['questions_explanation_height'];
   $e_question_mode              = $_POST['e_question_mode'];
   $directions = $_POST['e_directions'];
   $where        = array('qcategory_id' => $qcategory_id);
   $data = array('category_title' => $category_title, 'test_height' => $test_height, 'test_mode_height' => $questions_test_height, 'explanation_mode_height' => $questions_explanation_height, 'directions' => $directions, 'quiz_mode' => $e_question_mode);
   global $wpdb;
   $qtest_table = $wpdb->prefix . "cta_category";
   $wpdb->update($qtest_table, $data, $where);
   echo $wpdb->last_query;
   die;
   echo "suces";
   die();
}

/////////////////////////////////////////// Delete GRE Category /////////////////////////////////////////

add_action('wp_ajax_deleteGreCatTest', 'deleteGreCatTest');
add_action('wp_ajax_nopriv_deleteGreCatTest', 'deleteGreCatTest');
function deleteGreCatTest(){
   $qcategory_id    = $_POST['qcategory_id'];
   $where = array('qcategory_id' => $qcategory_id);
   global $wpdb;
   $qtest_table = $wpdb->prefix . "cta_category";
   $wpdb->delete($qtest_table, $where);
   $result = $wpdb->get_results("SELECT * FROM wp_cta_question where qcategory_id ='" . $qcategory_id . "'");
   foreach ($result as   $value) {
      $wpdb->delete('wp_cta_question', array('qtest_id' => $value->qtest_id));
   }
   echo "suces";
   die();
}

////////////////////////////////////////////// Delete GRE Question //////////////////////////////////////

add_action('wp_ajax_deleteGreQuestion', 'deleteGreQuestion');
add_action('wp_ajax_nopriv_deleteGreQuestion', 'deleteGreQuestion');
function deleteGreQuestion(){
   $question_id    = $_POST['question_id'];
   $where = array('id' => $question_id);
   global $wpdb;
   $table = $wpdb->prefix . "cat_gre_questions";
   $wpdb->delete($table, $where);
   echo "suces";
   die();
}


add_action('wp_ajax_gre_saveAnswer', 'gre_saveAnswer');
add_action('wp_ajax_nopriv_gre_saveAnswer', 'gre_saveAnswer');
function gre_saveAnswer()
{
if (isset($_POST['user_id']) && $_POST['user_id'] !='') { 

      $category_id    = $_POST['category_id'];
      $answer_date    = date('Y-m-d');
      $wp_user_id     = $_POST['user_id'];      
      $stopwatch      = $_POST['stopwatch'];
      $final_score    = $_POST['final_score'];
      if($stopwatch =='0'){
         $status         = 'Reset';
      }else{
         $status         = $_POST['status'];
      }

      global $wpdb;
      $recID = $wpdb->get_var( "SELECT id FROM ".($wpdb->prefix . 'gre_cat_answers')." WHERE category_id = ".intval($category_id)." AND wp_user_id = " . $wp_user_id . "");
      if($recID > '0'){
            $wpdb->replace( $wpdb->prefix . 'gre_cat_answers', 
            array( 
                'id'            => $recID,
                'category_id'   => $category_id,
                'wp_user_id'    => $wp_user_id,
                'user_answer'   => trim($_POST['user_answer']),
                'final_score'   => $final_score,
                'status'        => $status,
                'stopwatch'     => $stopwatch,
                'answer_date'   => $answer_date
            ),
            array(
                '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s'
            )
         );
      }else{
         $wpdb->insert( $wpdb->prefix . 'gre_cat_answers', 
            array( 
                'category_id'   => $category_id,
                'wp_user_id'    => $wp_user_id,
                'user_answer'   => trim($_POST['user_answer']),
                'status'        => $status,
                'stopwatch'     => $stopwatch,
                'answer_date'   => $answer_date
            ),
            array(
                '%d', '%d', '%s', '%s', '%s', '%s', '%s'
            )
         );
      }
      $msg = array('msg' => 'success');
      echo json_encode($msg);
      die();
   }
   $msg = array('msg' => 'fail, user not logged in');
   echo json_encode($msg);
   die();
}

