<?php
class NoteBLLModel{
	public function NoteObj_Arr($noteObj){
		$noteObjArr=array();
		$noteObjArr['noteId']=($noteObj->noteId)?$noteObj->noteId:null;
		$noteObjArr['noteStatus']=$noteObj->noteStatus;
		$noteObjArr['pictureURL']=$noteObj->pictureURL;
		$noteObjArr['boolPicture']=$noteObj->boolPicture;
		$noteObjArr['noteDateTime']=$noteObj->noteDateTime;
		$noteObjArr['noteContent']=$noteObj->noteContent;
		$noteObjArr['boolUrgent']=$noteObj->boolUrgent;
		$noteObjArr['voiceURL']=$noteObj->voiceURL;
		$noteObjArr['boolVoice']=$noteObj->boolVoice;
		$noteObjArr['noteBoardId']=($noteObj->noteBoardId)?$noteObj->noteBoardId:null;
		$noteObjArr['noteTypeId']=$noteObj->noteTypeId;

		$noteObjArr['boolOpen']=$noteObj->boolOpen;
		$noteObjArr['noteUpdateTime']=$noteObj->noteUpdateTime;
		$noteObjArr['likeCount']=$noteObj->likeCount;

		return $noteObjArr;
	}
	//封装了得到noteBoardId的值。
	public function gNoteBoardId($userId){
		$noteBoardDALModel=new NoteBoardDALModel;
		$noteBoardObjFromDb=$noteBoardDALModel->selectByUserId($userId);
		$noteBoardId=$noteBoardObjFromDb->noteBoardId;
		return $noteBoardId;
	}
	//获取note信息，二维
	public function infoNote($noteBoardObjFromView){
		$userId=$noteBoardObjFromView->userId;
		 $noteBoardId=$this->gNoteBoardId($userId);
		 $noteNum=$noteBoardId%7;

		$noteDALModel=new NoteDALModel;
		$noteObjFromDbArr=$noteDALModel->selectByNoteBoardId($noteBoardId,$noteNum);

		return ResponseTool::show(1,'note查询成功',$noteObjFromDbArr);
	}
	//获取note信息，一维
	public function infoNoteById($noteBoardObjFromView,$noteId){

		$userId=$noteBoardObjFromView->userId;
		$noteBoardId=$this->gNoteBoardId($userId);
		$noteNum=$noteBoardId%7;

		$noteDALModel=new NoteDALModel;
		$noteObjFromDb=$noteDALModel->selectByNoteIdObj($noteId,$noteNum);
		//return ($this->userArr_json($this->NoteObj_Arr($noteObjFromDb)));
		return ResponseTool::show(1,'note查询成功',$this->NoteObj_Arr($noteObjFromDb));
	}
	public function addNote($userId,$noteObjFromView){
		$noteBoardId=$this->gNoteBoardId($userId);
		$noteNum=$noteBoardId%7;
		
		$noteObjArr=$this->NoteObj_Arr($noteObjFromView);
		$noteObjArr['noteBoardId']=$noteBoardId;
		$noteDALModel=new NoteDALModel;
		$sign=$noteDALModel->insertNote($noteObjArr,$noteNum);

		if ($sign) {
			$noteObjNew=$noteDALModel->selectByNoteBoardIdNew($noteBoardId,$noteNum);
	      	return ResponseTool::show(1,'note添加成功',$this->NoteObj_Arr($noteObjNew));
	

		}else{
			return ResponseTool::show(403,'note添加失败',$this->NoteObj_Arr($noteObjFromDb));
	
		}
	}
	public function modifyNote($noteObjFromView){

		$noteObjArr=$this->NoteObj_Arr($noteObjFromView);
		$noteBoardId=$noteObjArr['noteBoardId'];
		$noteNum=$noteBoardId%7;
		$noteDALModel=new NoteDALModel;
		$noteObjFromDb=$noteDALModel->updateByNoteArr($noteObjArr,$noteNum);
		
			return ResponseTool::show(1,'note修改成功',$this->NoteObj_Arr($noteObjFromDb));
	
		
		
	}
	public function delNote($userId,$noteObjFromView){
		$noteBoardId=$this->gNoteBoardId($userId);
		$noteNum=$noteBoardId%7;
		$noteId=$noteObjFromView->noteId;
		$noteDALModel=new NoteDALModel;
		$sign=$noteDALModel->delByNoteId($noteId,$noteNum);
		if ($sign) {
			return ResponseTool::show(1,'note删除成功',null);
	

		}else{
			return ResponseTool::show(404,'note删除失败',null);		}

	}
}
	// public function userArr_json($userarr,$error=NULL){
	// 	$sign=implode('',$userarr);
	// 	//有值为真
		 
	// 	if ($sign) {
	// 		// $userarr=$this->userObj_Arr($userFromDb);
	// 		$userarr=array("sign"=>"1","data"=>$userarr);
	//       	$message=json_encode($userarr,JSON_UNESCAPED_UNICODE);//JSON_UNESCAPED_UNICODE中文防止乱码
	//       	$message=str_replace('\\u0000', '', $message);
	//       	return $message;

	// 	}else{
	// 		$message=array("sign"=>"0","data"=>$error);
	// 		$message=json_encode($message,JSON_UNESCAPED_UNICODE);
	// 		return $message;
	// 	}
	// }

// 		function arrayRecursive(&$array, $function, $apply_to_keys_also = false)  
// 	{  
// 	    foreach ($array as $key => $value) {  
// 	        if (is_array($value)) {  
// 	            $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);  
// 	        } else {  
// 	            $array[$key] = $function($value);  
// 	        }  
	   
// 	        if ($apply_to_keys_also && is_string($key)) {  
// 	            $new_key = $function($key);  
// 	            if ($new_key != $key) {  
// 	                $array[$new_key] = $array[$key];  
// 	                unset($array[$key]);  
// 	            }  
// 	        }  
// 	    }  
	     
// 	}
// 	function JSON($array) {  
// 	    $this->arrayRecursive($array, 'urlencode', true);  
// 	    $json = json_encode($array);  
// 	    return urldecode($json);  
// 	}
// }