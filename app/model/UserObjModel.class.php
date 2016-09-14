<?php
class UserObjModel{
	private $userId;
	private $nickName;
	private $userIntro;
	private $account;
	private $password;
	private $gender;
//	private $collegeId;
//	private $characterId;
	private $headimgURL;
	private $openId;
//	private $headimg;
	private $EmailAddress;
	public function __set($key,$vaule){
		$this->$key=$vaule;
	}
	public function __get($key){
		if (isset($this->$key)) {
			return $this->$key;
		}else{
			return NULL;
		}
	}
}