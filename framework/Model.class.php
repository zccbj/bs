<?php
/**
 * 模型的基础类
 */
class Model {
	protected $db;//保存MySQLDB类的对象
	protected $prefix;
	protected $fields;//所有的字段＋一个pri字段

	public function __construct() {
		$this->prefix=$GLOBALS['config']['database']['prefix'];
		//连接数据库
		$this->initLink();
		$this->getFields();
	}
	/**
	 * 初始化数据库的连接
	 */
	public function getFields() {
		//获得描述desc
		$sql = "desc {$this->table()}";
		$fields_rows = $this->db->fetchAll($sql);
		//获得其中的字段部分
		foreach ($fields_rows as $row) {
			$this->fields[] = $row['Field'];
			if($row['Key'] == 'PRI') {
				$this->fields['pk'] = $row['Field'];
			}
		}
	}
	public function autoDelete($pk_value) {
		//delete from 当前表名 where 主键字段=’主键字段值’
		$sql = "delete from {$this->table()} where `{$this->fields['pk']}`='{$pk_value}'";
		return $this->db->query($sql);
	}
	public function autoSelectRow($pk_value) {
		//select * from 当前表名 where 主键字段=’主键字段值’
		$sql = "select * from {$this->table()} where `{$this->fields['pk']}`='{$pk_value}'";
		return $this->db->fetchRow($sql);
	}
	public function autoInsert($data) {
//		insert into 表名 (字段1,字段2,字段N) values ('值1','值2','值N')
//		$data = array(
//			'字段1'=>'值1',
//			'字段2'=>'值2',
//			'字段3'=>'值3',
//		);
		$sql = "insert into {$this->table()} ";
		//拼凑字段列表部分
		$fields = array_keys($data);//取得所有键
		$fields = array_map(function($v){return '`'.$v.'`';}, $fields);//使用反引号包裹字段名
		$fields_str = implode(', ', $fields);//使用逗号连接起来即可
		$sql .= '(' . $fields_str . ')';
		//拼凑值列表部分
		$values = array_map(function($v) {return "'".$v."'";}, $data);//获得所有的值，将值增加引号包裹
		$values_str = implode(', ', $values);//再使用逗号连接
		$sql .= ' values (' . $values_str . ')';
		//执行该insert语句

		return $this->db->query($sql);
	}
	public function autoModify($data) {
//		update 表名 set 字段1='值1',字段2='值2',字段N='值N' where id='';
//		$data = array(
//			'字段1'=>'值1',
//			'字段2'=>'值2',
//			'字段3'=>'值3',
//		);
		$sql = "update {$this->table()} set ";
		foreach ($data as $key => $value) {
			if ($key==$this->fields['pk']) {
				$other=" $key='$value'";
			}else{
				$sql.="$key='$value',";
			}
		}
		$sql=substr($sql, 0,-1);
		$sql.=" where $other";
		return $this->db->query($sql);
	}
//链接查询
	private $sql=array("from"=>"",
            "where"=>"",
            "order"=>"",
            "limit"=>"");
  
    public function from($tableName) {
    	
        $this->sql["from"]="FROM ".$tableName;
        return $this;
    }
  
    public function where($_where='1=1') {
        $this->sql["where"]="WHERE ".$_where;
        return $this;
    }
  
    public function order($_order='id DESC') {
        $this->sql["order"]="ORDER BY ".$_order;
        return $this;
    }
  
    public function limit($_limit='30') {
        $this->sql["limit"]="LIMIT 0,".$_limit;
        return $this;
    }
    public function select($_select='*') {
        $sql= "SELECT ".$_select." ".(implode(" ",$this->sql));
        return $sql;
    }

//echo $sql->from("testTable")->where("id=1")->order("id DESC")->limit(10)->select();
	protected function initLink() {
//		require './framework/MySQLDB.class.php';
		// $options = array(
		// 	'host'=>'172.16.79.128',
		// 	'port'=>'3306',
		// 	'user'=>'root',
		// 	'pass'=>'123456',
		// 	'charset'=>'utf8',
		// 	'dbname'=>'itcast_shop'
		// );
		$this->db = MySQLDB::getInstance($GLOBALS['config']['database']);
	}
	protected function table() {
		//凭凑表名
		return '`' . $this->prefix . $this->table_name . '`';
	}
}