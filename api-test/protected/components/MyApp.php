<?php
class MyApp{
	public static function check_auth($api_key, $authorization){
		if($api_key==md5('emerhub') AND $authorization==sha1('emerhub')){
			return true;
		}else{
			return false;
		}
	}	
}
?>