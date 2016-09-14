<?php 
class NoteBoardController extends BackPlatformController{
	public function gnoteboardAction(){
		$userId=$_POST['userId'];
		$noteBoardObjModel=new NoteBoardObjModel;
		$noteBoardObjModel->userId=$userId;
		$noteBoardBLLModel=new NoteBoardBLLModel;
		$result=$noteBoardBLLModel->infoNoteBoard($noteBoardObjModel);
		echo $result;
	}
	public function cgnoteboardAction(){
		$userId=$_POST['userId'];
		$boardBackGroundId=$_POST['boardBackGroundId'];
		$noteBoardId=$_POST['noteBoardId'];
		$noteBoardObjModel=new NoteBoardObjModel;
		$noteBoardObjModel->userId=$userId;
		$noteBoardObjModel->boardBackGroundId=$boardBackGroundId;
		$noteBoardObjModel->noteBoardId=$noteBoardId;
		$noteBoardBLLModel=new NoteBoardBLLModel;
		$result=$noteBoardBLLModel->modifyNoteBoerd($noteBoardObjModel);
		echo $result;
	}



	//查询boardbackground
	public function gboardbackgroundAction(){
		$boardBackGroundBLLModel=new BoardBackGroundBLLModel;
		$result=$boardBackGroundBLLModel->infoBoardBackGround();
		echo $result;
	}
	
}