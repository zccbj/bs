<?php
class BackPlatformController extends Controller{
	// public function __construct(){
	// 	$this->initSession();
	// 	$this->checkLogin();
	// }
	// Protected function initSession(){
	// 	new SessionDBTool();
	// }
	// Protected function checkLogin(){
	// 	if (CONTROLLER=='Admin'&&(ACTION=='login'||ACTION=='signin'||ACTION=='captcha')) {
	// 		#不需要验证是否登入
	// 	}else{
	// 		//需要
	// 		if(isset($_SESSION['is_login']) && $_SESSION['is_login'] =='yes') {
	// 			//继续执行
	// 		} else {
				
	// 			//没有session登陆标记
	// 			//判断是否存在合法的cookie值，利用模型验证是否合法
	// 			$model_admin  = new AdminModel;
	// 			if( $model_admin->checkByCookie() ) {
	// 				//有合法的cookie
	// 				$_SESSION['is_login'] = 'yes';
	// 			} else {
	// 				//没有合法的cookie
	// 				$this->jump('index.php?p=back&c=Admin&a=login', '请先登录', 2);
	// 			}
	// 		}
	// 	}
		
	// }
	
	
}