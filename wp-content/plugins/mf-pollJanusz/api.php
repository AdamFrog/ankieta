<?php

require_once( $_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );
header('Content-Type: application/json');
require_once('model/model.php');

if(isset($_GET['controller'])){
		$name = ucfirst(strtolower($_GET['controller']));
		require_once(plugin_dir_path( __FILE__ ) . 'controller/' . strtolower($name) . '.php');
		$controller = 'MFPController_' . ucfirst($name);
		$object = new $controller;
}

if(isset($_GET['action'])){
  $action = 'action_' . strtolower($_GET['action']);
  //$object->before();
  echo $object->{$action}();
}




// if (strpos($_SERVER['REQUEST_URI'],'mfpoll') !== false) {
//   //getQuestions
//   // if(isset($_GET['questions'])) {
//   //     $questions = $api->find_all('mf_poll_questions','poll_id','=',$_GET['questions']);
//   // }
//   // //getPolls
//   // if(isset($_GET['poll'])) {
//   //     $questions = $api->find_all('mf_polls','poll_id','!=','0');
//   // }
//
//   header('Content-Type: application/json');
//   echo json_encode($questions, JSON_NUMERIC_CHECK);
// }


 ?>
