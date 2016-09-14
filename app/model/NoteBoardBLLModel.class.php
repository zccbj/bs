<?php
class NoteBoardBLLModel{
	public function arr_json($arr,$error=NULL){
		
		$sign=implode('',$arr);
		//有值为真
		if ($sign) {
			// $arr=$this->userObj_Arr($userFromDb);
			$arr=array("sign"=>"1","data"=>$arr);
	      	$message=json_encode($arr,JSON_UNESCAPED_UNICODE);//JSON_UNESCAPED_UNICODE中文防止乱码
	      	$message=str_replace('\\u0000', '', $message);
	      	return $message;

		}else{
			$message=array("sign"=>"0","data"=>$error);
			$message=json_encode($message,JSON_UNESCAPED_UNICODE);
			return $message;
		}
	}
	public function noteBoardObj_Arr($noteBoardObj){
		$noteBoardArr=array();

		$noteBoardArr['noteBoardId']=$noteBoardObj->noteBoardId;
		$noteBoardArr['userId']=$noteBoardObj->userId;
		$noteBoardArr['boardBackGroundId']=$noteBoardObj->boardBackGroundId;
		return $noteBoardArr;

	}
	public function infoNoteBoard($noteBoardObjModel){
		$userId=$noteBoardObjModel->userId;
		$noteBoardDALModel=new NoteBoardDALModel;
		$noteBoardObjFromDb=$noteBoardDALModel->selectByUserId($userId);
		$noteBoardObjFromDbArr=$this->noteBoardObj_Arr($noteBoardObjFromDb);
		return $this->arr_json($noteBoardObjFromDbArr);

	}
	public function modifyNoteBoerd($noteBoardObjModel){
		$noteBoardArr=$this->noteBoardObj_Arr($noteBoardObjModel);
		$noteBoardDALModel=new NoteBoardDALModel;

		$noteBoardObjFromDb=$noteBoardDALModel->updateNoteBoard($noteBoardArr);
		return $this->arr_json($this->noteBoardObj_Arr($noteBoardObjFromDb));

	}


}