<?php
date_default_timezone_set('Asia/Jakarta');
//MyApp::sendEmail('testing', 'muhmdysf@gmail.com', 'konten', 'Testing', 'tetsing', 123);
class SessionPintechCommand extends CConsoleCommand{
	public function run($args){
		$session_pintech	=	PintechRest::Login();
	}
}
?>