<?php
class Framework{
	public static function run(){
		Framework::initRequest();
		Framework::initPath();
		Framework::loadConfig();
		//初始化错误处理的配置
		self::initErrorHandler();
		//注册自己的自动加载方法，类名，方法名
		spl_autoload_register(array('Framework','itcast_autoload'));
		Framework::dispatch();
	}
	private static function initErrorHandler() {
		if('dev' == $GLOBALS['config']['app']['run_mode']) {
			ini_set('error_reporting', E_ALL | E_STRICT);
			ini_set('display_errors', 1);
			ini_set('log_errors', 0);
		} elseif ('pro' == $GLOBALS['config']['app']['run_mode']) {
			ini_set('display_errors', 0);
			ini_set('error_log', APP_DIR . 'error.log');
			ini_set('log_errors', 1);
		}

	}
	private static function initRequest(){
		define('PLATFORM', isset($_GET['p']) ? $_GET['p'] : 'back');
		define('CONTROLLER', isset($_GET['c']) ? $_GET['c'] : 'Admin');
		define('ACTION', isset($_GET['a']) ? $_GET['a'] : 'login');


	}
	private static function initPath(){
		define('DS', DIRECTORY_SEPARATOR);//分隔符
		define('ROOT_DIR', dirname(dirname(__FILE__)).DS);//app/
		define('APP_DIR', ROOT_DIR.'app'.DS);//app/
		define('CONT_DIR', APP_DIR.'controller'.DS);//app/controller/
		define('CURR_CONT_DIR', CONT_DIR.PLATFORM.DS);//app/controller/back??/
		define('VIEW_DIR', APP_DIR.'view'.DS);//app/view/
		define('CURR_VIEW_DIR', VIEW_DIR.PLATFORM.DS);//app/view/back??/
		define('MODEL_DIR', APP_DIR.'model'.DS);//app/model
		define('FRAME_DIR', ROOT_DIR.'framework'.DS);//app/framework/ 
		define('CONFIG_DIR', APP_DIR . 'config' . DS);//app/config/ 
		define('TOOL_DIR', FRAME_DIR . 'tool' . DS);//app/framework/tool/ 
		define('UPLOAD_DIR', APP_DIR . 'upload' . DS);//app/upload/ 
	
	}
	private static function dispatch(){
			$controller_name=CONTROLLER.'Controller';
			$action_name=ACTION.'Action';
			$controller=new $controller_name;
			$controller->$action_name();
	}

	private static function itcast_autoload($class_name){
	//找不到new的东西，自动调用这个
	$map=array(
		'MySQLDB'=>FRAME_DIR.'MySQLDB.class.php',
		'Model'=>FRAME_DIR.'Model.class.php',
		'Controller'=>FRAME_DIR.'Controller.class.php'
		);
	if (isset($map[$class_name])) {

		require $map[$class_name];
		
	}elseif (substr($class_name, -10)=='Controller') {
	
		require CURR_CONT_DIR.$class_name.'.class.php';

	}elseif (substr($class_name, -5)=='Model') {
		
		require MODEL_DIR.$class_name.'.class.php';
	}elseif (substr($class_name, -4)=='Tool') {
		
		require TOOL_DIR.$class_name.'.class.php';
	}
	}
	private static function loadConfig(){
		$GLOBALS['config'] = require CONFIG_DIR.'app.config.php';
	}
}