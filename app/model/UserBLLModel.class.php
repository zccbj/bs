<?php
date_default_timezone_set("PRC");
class UserBLLModel{
	public function userObj_Arr($user){
		$userArr=array();
		$userArr['userId']=$user->userId;
		$userArr['nickName']=$user->nickName;
		$userArr['userIntro']=$user->userIntro;
		$userArr['account']=$user->account;
		$userArr['password']=$user->password;
		$userArr['gender']=$user->gender;
		$userArr['headimgURL']=$user->headimgURL;
		$userArr['openId']=$user->openId;
		$userArr['EmailAddress']=$user->EmailAddress;
		return $userArr;
	}

	public function NoteBoardObj_Arr($noteBoardObj){
		$noteBoardObjArr=array();
		$noteBoardObjArr['noteBoardId']=$noteBoardObj->noteBoardId;
		$noteBoardObjArr['userId']=$noteBoardObj->userId;
		$NoteBoardObj_Arr['boardBackGroundId']=$noteBoardObj->boardBackGroundId;
		return $noteBoardObjArr;
	}
	public function NoteObj_Arr($noteObj){
		$noteArr=array();
	$noteArr['noteId']=$noteObj->noteId;
	$noteArr['noteStatus']=$noteObj->noteStatus;
	$noteArr['pictureURL']=$noteObj->pictureURL;
	$noteArr['boolPicture']=$noteObj->boolPicture;
	$noteArr['noteDateTime']=$noteObj->noteDateTime;
	$noteArr['noteContent']=$noteObj->noteContent;
	$noteArr['boolUrgent']=$noteObj->boolUrgent;
	$noteArr['voiceURL']=$noteObj->voiceURL;
	$noteArr['boolVoice']=$noteObj->boolVoice;
	// $noteArr['backGroundId']=$noteObj->backGroundId;
	// $noteArr['boolBackGround']=$noteObj->boolBackGround;
	$noteArr['noteBoardId']=$noteObj->noteBoardId;
	$noteArr['noteTypeId']=$noteObj->noteTypeId;
		return $noteArr;
	}
	public function userArr_json($userarr,$error=NULL){
		$sign=implode('',$userarr);
		//有值为真
		 
		if ($sign) {
			// $userarr=$this->userObj_Arr($userFromDb);
			$userarr=array("sign"=>"1","data"=>$userarr);
	      	$message=json_encode($userarr,JSON_UNESCAPED_UNICODE);//JSON_UNESCAPED_UNICODE中文防止乱码
	      	$message=str_replace('\\u0000', '', $message);
	      	return $message;

		}else{
			$message=array("sign"=>"0","data"=>$error);
			$message=json_encode($message,JSON_UNESCAPED_UNICODE);
			return $message;
		}
	}
	//提取代码。注册时默认在NoteBoard添加数据
	private function addNoteBoard($userFromDb){
		$userId=$userFromDb->userId;
		$noteBoardObj=new NoteBoardObjModel;
		$noteBoardObj->userId=$userId;
		$noteBoardObj->boardBackGroundId=1;
		$noteBoardDALModel=new NoteBoardDALModel;
		$noteBoardObjFromDb=$noteBoardDALModel->InsertNoteBoard($this->NoteBoardObj_Arr($noteBoardObj));
		if(!$noteBoardObjFromDb) {
			echo 'error:001';
		}else{
			return $noteBoardObjFromDb;
		}
	}
	//提取代码。注册时默认在note中添加数据
	private function addNote($noteBoardObjFromDb){
		$noteBoardId=$noteBoardObjFromDb->noteBoardId;
		$noteNum=$noteBoardId%7;
		$noteObj=new NoteObjModel;
		$noteObj->noteBoardId=$noteBoardId;
		$noteObj->noteDateTime=date('Y-m-d H:i:s');
		$noteObj->noteContent="你好，世界";
		$noteObj->noteTypeId=2;
		$noteObj->noteStatus=1;
		$noteObj->boolUrgent=0;
		$noteDALModel=new NoteDALModel;

		$noteObjFromDb=$noteDALModel->insertNote($this->NoteObj_Arr($noteObj),$noteNum);
		$noteObjFromDbArr=$this->NoteObj_Arr($noteObjFromDb);
		if ($noteObjFromDbArr) {
			return $noteObjFromDbArr;
		}else{
			return false;
		}
	}
	//微信登入
	public function signWc($userFromView){
		$userDALModel=new UserDALModel;
		$userFromDb=new UserObjModel;
		$userFromDb=$userDALModel->checkByOpenId($userFromView->openId);
		if ($userFromDb) {
			$userarr=$this->userObj_Arr($userFromDb);
		}else{
			//没找到这个用户则insert
			 $userFromDb=$userDALModel->InsertByUserWc($this->userObj_Arr($userFromView));
			 $userarr=$this->userObj_Arr($userFromDb);
			//在noteBoard里插入数据
			$noteBoardObjFromDb=$this->addNoteBoard($userFromDb);
			//在note里添加数据
			$noteObjFromDbArr=$this->addNote($noteBoardObjFromDb);

		}
		return $this->userArr_json($userarr);
	}
	//pc登入
	public function signPc($userFromView){
		$userDALModel=new UserDALModel;
		$userFromDb=new UserObjModel;
		$userFromDb=$userDALModel->checkByAccount($userFromView->account);
		$userarr=($userFromDb->password==$userFromView->password)?$this->userObj_Arr($userFromDb):NULL;
		return $this->userArr_json($userarr);

	}
	//注册pc，可能会出现用户已存在
	public function registerPc($userFromView){
		$userDALModel=new UserDALModel;
		$userFromDb=$userDALModel->InsertByUser($this->userObj_Arr($userFromView));
		$error=NULL;
		if (!$userFromDb) {
			$error="{error:'用户已存在'}";
		}
		//在noteBoard里插入数据
		$this->addNoteBoard($userFromDb);
		//在note里添加数据
		$noteObjFromDbArr=$this->addNote($noteBoardObjFromDb);

		return $this->userArr_json($this->userObj_Arr($userFromDb),$error);

	}
	//修改用户全部信息
	public function modifyUser($userFromView){
		$userDALModel=new UserDALModel;
		$userFromDbArr=$userDALModel->ModifyByUser($this->userObj_Arr($userFromView));
		return $this->userArr_json($userFromDbArr);
	}
	//修改单个信息
	public function modifyOne($userFromView){
	//	var_dump($userFromView);
		$userArr=array();
		$userArr['userId']=$userFromView->userId;
		if ($value=$userFromView->nickName) {
			$userArr['nickName']=$value;
		}elseif ($value=$userFromView->userIntro) {
			$userArr['userIntro']=$value;
		}
		$userDALModel=new UserDALModel;
		$userFromDb=$userDALModel->ModifyByUser($userArr);
		return $this->userArr_json($this->userObj_Arr($userFromDb));
	}
	//通过id查用户信息
	public function infoUser($userFromView){
		$userDALModel=new UserDALModel;
		$userFromDb=$userDALModel->SelectByUserId($userFromView->userId);
		return $this->userArr_json($this->userObj_Arr($userFromDb));
	}

}