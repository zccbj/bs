<?php
class NoteBoardObjModel{
	private $noteBoardId;
	private $userId;
	private $boardBackGroundId;
	public function __set($key,$value){
		$this->$key=$value;
	}
	public function __get($key){
		if (isset($this->$key)) {
			return $this->$key;
		}else{
			return NULL;
		}
	}
}