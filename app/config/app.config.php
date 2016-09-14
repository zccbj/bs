<?php
//配置文件

return array(
'database'=> array(
		'host'=>'139.196.228.34',
		'port'=>'3306',
		'user'=>'board_admin',
		'pass'=>'banshu120...',
		'charset'=>'utf8',
		'dbname'=>'B_Note',
		'prefix'=>'',
	),//数据库组
'app' => array(
	'run_mode'=>'dev',//运行模型dev 。pro
),//应用程序项目组
'back' => array(
	'goods_list_pagesize'=>2,
),//后台
'front' => array(),
);
