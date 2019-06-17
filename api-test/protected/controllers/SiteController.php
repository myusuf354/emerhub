<?php
class SiteController extends Controller{
	public function actionIndex(){
		if(MyApp::check_auth($_SERVER['HTTP_X_API_KEY'], $_SERVER['HTTP_AUTHORIZATION'])){
			$data['x_api_key'] 			= $_SERVER['HTTP_X_API_KEY']; // md5
			$data['authorization']	= $_SERVER['HTTP_AUTHORIZATION']; // sha1
			
			$data['response'] 			= array('status' => true, 'code' => '200', 'message' => 'success');
			
			$data['data'] 					= array(
																	'first_name' => $_POST['first_name'], 
																	'name_card' => $_POST['name_card'], 
																	'description' => $_POST['description'],
																	'comment' => $_POST['comment'],
																	'status_issue' => $_POST['status_issue']
																);
		}else{
			$data['response'] 			= array('status' => false, 'message' => 'invalid auth token');
		}
															
		echo CJSON::encode($data); exit;
	}
	
	public function actionError(){
		if($error=Yii::app()->errorHandler->error){
			$data['status'] 		= false;
			$data['status_code'] 	= "400";
			$data['message'] 		= $error;
			echo CJSON::encode($data); exit;
		}
	}
}