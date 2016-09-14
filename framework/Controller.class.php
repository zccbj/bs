<?php
class Controller{
	protected function jump($url,$message='',$time=3){
		if ($message=='') {
			header('Location:'.$url);

		}else{
			//判断是否有条转模版
			if(file_exists(CURR_VIEW_DIR.'jump.html')){
				//用户可以自己定义模版
				require CURR_VIEW_DIR.'jump.html';
			}else{//在<<<HTML这一行不能写任何东西，包括空格
					echo <<<HTML

<HTML>
 <HEAD>
  <TITLE> 提示：$message </TITLE>
  <META HTTP-EQUIV="Content-Type" CONTENT="text/html ;charset=utf-8">
  <META HTTP-EQUIV="Refresh" CONTENT="$time; url=$url">
 </HEAD>
 <BODY>
	默认的：$message
 </BODY>
</HTML>
HTML;


 			}
		}
		die;

	}
}