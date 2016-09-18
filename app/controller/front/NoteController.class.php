<?php
date_default_timezone_set("PRC");
class NoteController extends BackPlatformController{
	//g,d,m,a,
	public function gNoteAction(){
		$userId=$_POST['userId'];
		$noteBoardObj=new NoteBoardObjModel;
		$noteBoardObj->userId=$userId;

		$noteBLLModel=new NoteBLLModel;
		$noteObj=$noteBLLModel->infoNote($noteBoardObj);
		echo ($noteObj);
	}
	public function gNoteByIdAction(){
		 $userId=$_POST['userId'];
		 $noteId=$_POST['noteId'];
	
		$noteBoardObj=new NoteBoardObjModel;
		$noteBoardObj->userId=$userId;
		//var_dump($noteBoardObj);
		$noteBLLModel=new NoteBLLModel;
		$noteObj=$noteBLLModel->infoNoteById($noteBoardObj,$noteId);
		echo ($noteObj);
	}
	public function aNoteAction(){
		
		$userId=$_POST['userId'];
		$data=$_POST['data'];
		//$userId=1;
		//$data='{"noteStatus":"1","pictureURL":"","boolPicture":"","noteContent":"你好，世界","boolUrgent":"","voiceURL":"","boolVoice":"","noteTypeId":"2","boolOpen":"1","noteUpdateTime":null,"likeCount":"1","noteBoardId":"7"}';
		$data= json_decode($data);

 		$noteObj=new NoteObjModel;
 		// $noteObj->noteBoardId=$noteBoardId;
 		$noteObj->noteDateTime=date('Y-m-d H:i:s');

 		$noteObj->noteStatus=$data->noteStatus;
		$noteObj->pictureURL=$data->pictureURL;
		$noteObj->boolPicture=$data->boolPicture;
		$noteObj->noteContent=$data->noteContent;
		$noteObj->boolUrgent=$data->boolUrgent;
		$noteObj->voiceURL=$data->voiceURL;
		$noteObj->boolVoice=$data->boolVoice;
		$noteObj->noteTypeId=$data->noteTypeId;
		$noteObj->boolOpen=$data->boolOpen;
		$noteObj->noteUpdateTime=$data->noteUpdateTime;
		$noteObj->likeCount=$data->likeCount;

		//var_dump($noteObj);
		$noteBLLModel=new NoteBLLModel;
		$result=$noteBLLModel->addNote($userId,$noteObj);
		echo $result;
	}
	public function uNoteAction(){
		$data=$_POST['data'];
		$data='{"noteId":"7","noteStatus":"1","pictureURL":"","boolPicture":"","noteContent":"你好，界","boolUrgent":"","voiceURL":"","boolVoice":"","noteTypeId":"2","boolOpen":"1","noteUpdateTime":null,"likeCount":"1","noteBoardId":"7"}';
		$data= json_decode($data);
 		$noteObj=new NoteObjModel;
 		$noteObj->noteId=$data->noteId;
 		$noteObj->noteBoardId=$data->noteBoardId;
 		$noteObj->noteDateTime=$data->noteDateTime;
 		$noteObj->noteStatus=$data->noteStatus;
		$noteObj->pictureURL=$data->pictureURL;
		$noteObj->boolPicture=$data->boolPicture;
		$noteObj->noteContent=$data->noteContent;
		$noteObj->boolUrgent=$data->boolUrgent;
		$noteObj->voiceURL=$data->voiceURL;
		$noteObj->boolVoice=$data->boolVoice;
		$noteObj->noteTypeId=$data->noteTypeId;
		$noteObj->boolOpen=$data->boolOpen;
		$noteObj->noteUpdateTime=date('Y-m-d H:i:s');
		$noteObj->likeCount=$data->likeCount;


		$noteBLLModel=new NoteBLLModel;
		$result=$noteBLLModel->modifyNote($noteObj);
		echo $result;


	}
	public function dNoteAction(){
		$noteId=$_POST['noteId'];
		$userId=$_POST['userId'];
	
		$noteObj=new NoteObjModel;
 		$noteObj->noteId=$noteId;
 		$noteBLLModel=new NoteBLLModel;
 		$result=$noteBLLModel->delNote($userId,$noteObj);
 		echo $result;

	}
}