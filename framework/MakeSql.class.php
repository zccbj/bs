<?php
class MakeSql{
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
        return "SELECT ".$_select." ".(implode(" ",$this->sql));
    }
}

// $sql =new sql();
  
// echo $sql->from("testTable")->where("id=1")->order("id DESC")->limit(10)->select();