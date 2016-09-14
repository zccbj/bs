<?php
class MySQLDB{
	//数据库的连接
	private static $instance;
	
	private $host;
	private $port;
	private $user;
	private $pass;
	private $charset;
	private $dbname;

	private $last_sql;
	private $link;

	public static function getInstance($options){
		if (! (self::$instance instanceof self)) {
			self::$instance=new self($options);
		}
		return self::$instance;

	}	

	private function __construct($options=array()){
		$this->host=isset($options['host'])?$options['host']:'127.0.0.1';
		$this->port=isset($options['port'])?$options['port']:'3306';
		$this->user=isset($options['user'])?$options['user']:'rot';
		$this->pass=isset($options['pass'])?$options['pass']:'16';
		$this->charset=isset($options['charset'])?$options['charset']:'utf-8';
		$this->dbname=isset($options['dbname'])?$options['dbname']:'dbname';
		$this->connect();
		//$this->setCharst();
	}
	private function connect(){
		$this->link=mysqli_connect($this->host,$this->user,$this->pass,$this->dbname) or die('111');

	}
	private function setCharst(){
		$sql="set names $this->charset";
		return $this->query($sql);
	}
	public function query($sql){
		$this->last_sql=$sql;
		$result=mysqli_query($this->link,$sql);
		if($result===false){
			echo "sql错误";
			echo "出错sql:",$sql;
			echo '错误代码是：', mysqli_errno($this->link), '<br>';
			echo '错误信息是：', mysqli_error($this->link), '<br>';
			die;
		}else{
			return $result;
		}
	}
	public function affectedRows($sql){
		//update可能没有影响任何
		//除select。。。。。select用这个mysqli_num_rows($reslut);
		$result=$this->query($sql);
		return mysqli_affected_rows($this->link);	
	}
	public function fetchAll($sql){
		//返回一个二维数组
		if ($result=$this->query($sql)) {
			$rows=array();
			while ($row=mysqli_fetch_array($result)) {
				$rows[]=$row;
			}
			mysqli_free_result($result);
			return $rows;
		}else{
			return false;
		}
	}
	public function fetchRow($sql){
		//返回一维数组
		if ($result=$this->query($sql)) {
			$row=mysqli_fetch_array($result);
			mysqli_free_result($result);
			return $row;
		}else{
			return false;
		}
	}
	public function fetchColumn($sql){
		//返回一维数组中的第一个
		if ($result=$this->query($sql)) {
			if($row=mysqli_fetch_array($result)){
				return $row[0];
				mysqli_free_result($result);
			}
			
		}else{
			return false;
		}
	}
}