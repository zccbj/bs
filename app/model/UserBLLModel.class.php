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
		
		$userArr['age']=$user->age;
		$userArr['emotionStatus']=$user->emotionStatus;
		$userArr['addCountry']=$user->addCountry;
		$userArr['addProvince']=$user->addProvince;
		$userArr['addCity']=$user->addCity;

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
	$noteArr['noteBoardId']=$noteObj->noteBoardId;
	$noteArr['noteTypeId']=$noteObj->noteTypeId;

			$noteObjArr['boolOpen']=$noteObj->boolOpen;
		$noteObjArr['noteUpdateTime']=$noteObj->noteUpdateTime;
		$noteObjArr['likeCount']=$noteObj->likeCount;
		return $noteArr;
	}
	// public function userArr_json($userarr,$message=NULL){
	// 	$sign=implode('',$userarr);
	// 	//有值为真
		 
	// 	if ($sign) {
	// 		return ResponseTool::show(1,'注册成功',$userarr);


	// 		// var_dump($a);
	// 		// die();
	// 		// $userarr=array("sign"=>"1","data"=>$userarr);
	//   //     	$message=json_encode($userarr,JSON_UNESCAPED_UNICODE);//JSON_UNESCAPED_UNICODE中文防止乱码
	//   //     	$message=str_replace('\\u0000', '', $message);
	//   //     	return $message;

	// 	}else{
	// 		return ResponseTool::show(0,'微信注册失败',$userarr);
	// 		// $message=array("sign"=>"0","data"=>$error);
	// 		// $message=json_encode($message,JSON_UNESCAPED_UNICODE);
	// 		// return $message;
	// 	}
	// }
	//提取代码。注册时默认在NoteBoard添加数据
	private function addNoteBoard($userFromDb){
		$userId=$userFromDb->userId;
		$noteBoardObj=new NoteBoardObjModel;
		$noteBoardObj->userId=$userId;
		$noteBoardObj->boardBackGroundId=1;
		$noteBoardDALModel=new NoteBoardDALModel;
		$noteBoardObjFromDb=$noteBoardDALModel->InsertNoteBoard($this->NoteBoardObj_Arr($noteBoardObj));
			return $noteBoardObjFromDb;

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

			return $noteObjFromDbArr;
	}
	/**
	 * 微信登入
	 *查询用户是否存在，
	 *1不存在，先添加，后登入
	 *2存在，直接登入
	 *结果:肯定能登入
	 */
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
		return ResponseTool::show(1,'微信登入成功',$userarr);
		// return $this->userArr_json($userarr);
	}
	//pc登入
	public function signPc($userFromView){
		$userDALModel=new UserDALModel;
		$userFromDb=new UserObjModel;
		$userFromDb=$userDALModel->checkByAccount($userFromView->account);
		$userarr=($userFromDb->password==$userFromView->password)?$this->userObj_Arr($userFromDb):NULL;
		// return $this->userArr_json($userarr);

		if ($userarr) {
			return ResponseTool::show(1,'pc登入成功',$userarr);
		}else{
			return ResponseTool::show(402,'pc登入失败',NULL);
		}

	}
	/**pc注册
	 * 用户已存在，则返回false。
	*	用户不存在，则返回数组
	 */
	public function registerPc($userFromView){
		$message;
		$userDALModel=new UserDALModel;
		$userFromDb=$userDALModel->InsertByUser($this->userObj_Arr($userFromView));
		if ($userFromDb) {
			//在noteBoard里插入数据
			$noteBoardObjFromDb=$this->addNoteBoard($userFromDb);
			//在note里添加数据
			$noteObjFromDbArr=$this->addNote($noteBoardObjFromDb);
			return ResponseTool::show(1,'pc注册成功',$this->userObj_Arr($userFromDb));
		}else{
			return ResponseTool::show(401,'用户已存在',NULL);
		}

		
		

	//	return $this->userArr_json($this->userObj_Arr($userFromDb),$error);

	}
	//修改用户全部信息
	public function modifyUser($userFromView){
		$userDALModel=new UserDALModel;
		$userFromDb=$userDALModel->ModifyByUser($this->userObj_Arr($userFromView));
		return ResponseTool::show(1,'user修改成功',$this->userObj_Arr($userFromDb));
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
		return ResponseTool::show(1,'user修改成功',$this->userObj_Arr($userFromDb));
	}
	//通过id查用户信息
	public function infoUser($userFromView){
		$userDALModel=new UserDALModel;
		$userFromDb=$userDALModel->SelectByUserId($userFromView->userId);
		if ($userFromDb) {
			return ResponseTool::show(1,'user查询成功',$this->userObj_Arr($userFromDb));
		}else{
			//查无此人
			return false;
		}
		
	//	return $this->userArr_json($this->userObj_Arr($userFromDb));
	}

}