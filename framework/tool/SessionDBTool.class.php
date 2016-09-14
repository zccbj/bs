<?php
class SessionDBTool{
	//session的执行流程就是这样的,但是是对于session操作的，我们要写入数据库，所以需要重写
	private $db;
	public function __construct() {
		ini_set('session.save_handler', 'user');
		//设置配置值，sesion存储方式为用户自定义
		//设置处理器方法。数组表示方法。字符串表示函数
		session_set_save_handler(
			array($this, 'sess_open'),
			array($this, 'sess_close'),
			array($this, 'sess_read'),
			array($this, 'sess_write'),
			array($this, 'sess_destroy'),
			array($this, 'sess_gc')
		);
		//开启session
		session_start();
	}
	public function sess_open() {
		//echo "open<br>";
		$this->db = MySQLDB::getInstance($GLOBALS['config']['database']);
	}

	public function sess_close() {
		// var_dump($this->db);
		return true;
	}

	public function sess_read($sess_id) {
		// echo "read<br>";
		// var_dump($this->db);
		$sql = "select sess_data from it_session where sess_id='$sess_id'";
		return (string) $this->db->fetchColumn($sql);
	}

	public function sess_write($sess_id, $sess_data) {
		// echo "write<br>";
		// var_dump($this->db);
		$expire = time();
		$sql = "insert into it_session values ('$sess_id', '$sess_data', '$expire') on duplicate key update sess_data='$sess_data', expire=$expire";
		return $this->db->query($sql);
	}

	public function sess_destroy($sess_id) {
		//echo "desotory<br>";
		$sql = "delete from it_session where sess_id='$sess_id'";
		return $this->db->query($sql);
	}

	public function sess_gc($ttl) {
		//默认保存时间为3600
		//echo "gc<br>";
		$last_time = time()-$ttl;
		$sql = "delete from it_session where expire < $last_time";
		return $this->db->query($sql);
	}
}