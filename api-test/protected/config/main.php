<?php
date_default_timezone_set('Asia/Jakarta');
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/x-www-form-urlencoded');
header('Access-Control-Allow-Headers: Content-Type, Authorization, x-api-key');
header('Access-Control-Expose-Headers: Content-Type, Authorization, x-api-key');
header("Access-Control-Allow-Origin: *");
//$_POST = json_decode(file_get_contents('php://input'), true);

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Emerhub',
	
	'preload'=>array('log'),
	
	'import'=>array(
		'application.models.*',
		'application.components.*',
    'application.extensions.*',
	),

	'modules'=>array(
	
	),

	// application components
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
		),		
		
		'JWT' => array(
			'class' => 'ext.jwt.JWT',
			'key' => '0ubequ354barokah0',
		),		
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'caseSensitive'=>false
		),		
		
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),		
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
	
	'params'=>array(
		'adminEmail'=>'webmaster@example.com',
	),
);