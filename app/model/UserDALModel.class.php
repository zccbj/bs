<?php
class UserDALModel extends Model{
	//{$this->table()}来自于父类
	protected $table_name = 'user';
	public function userArr_Obj($User_info){
		$user=new UserObjModel;
			$user->userId=$User_info['userId'];
			$user->nickName=$User_info['nickName'];
			$user->userIntro=$User_info['userIntro'];
			$user->account=$User_info['account'];
			$user->password=$User_info['password'];
			$user->gender=$User_info['gender'];			
			$user->headimgURL=$User_info['headimgURL'];
			$user->openId=$User_info['openId'];
			$user->EmailAddress=$User_info['EmailAddress'];
			
			$user->age=$User_info['age'];
			$user->emotionStatus=$User_info['emotionStatus'];
			$user->addCountry=$User_info['addCountry'];
			$user->addProvince=$User_info['addProvince'];
			$user->addCity=$User_info['addCity'];

			return $user;
	}
	//openid查找用户，返回对象
	public function checkByOpenId($openId){
		$sql="select * from {$this->table()} where openId='$openId' ";
		$User_info=$this->db->fetchRow($sql);
		if ($User_info) {
			$user=$this->userArr_Obj($User_info);
			return $user;
		}else{
			return NULL;
		}
	}
	//通过用户名登入。返回对象
	public function checkByAccount($account){
		$sql="select * from {$this->table()} where account='$account' ";
		$User_info=$this->db->fetchRow($sql);
		if ($User_info) {
			$user=$this->userArr_Obj($User_info);
			return $user;
		}else{
			return NULL;
		}
	}
	//通过useid来查询。返回对象
	public function SelectByUserId($userId){

		if ($message=$this->autoSelectRow($userId)) {
			return $this->userArr_Obj($message);
		}
	}
	//pc注册，返回的对象
	public function InsertByUser($userArr){
		if($this->checkByaccount($userArr['account'])){
				return false;
		}
		if ($message=$this->autoInsert($userArr)) {
			$user=$this->checkByaccount($userArr['account']);
			return $user;
		}

	}
	//相当于注册微信用户，返回对象
	public function InsertByUserWc($userArr){
		if ($message=$this->autoInsert($userArr)) {
			$user=$this->checkByOpenId($userArr['openId']);
			return $user;
		}
	}
	//修改用户信息,返回对象//通过传入的数组是整个或者一个进行数组拼接。
	public function ModifyByUser($userArr){
		if ($message=$this->autoModify($userArr)) {
			$user=$this->SelectByUserId($userArr['userId']);
			return $user;
		}
	}
	
}
