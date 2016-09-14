<?php
class NoteBoardDALModel extends Model{
	protected $table_name='noteBoard';
	public function noteBoardArr_Obj($noteBoardArr){
		
		$noteBoardObjFromDb=new NoteBoardObjModel;
		$noteBoardObjFromDb->noteBoardId=$noteBoardArr['noteBoardId'];
		$noteBoardObjFromDb->userId=$noteBoardArr['userId'];
		$noteBoardObjFromDb->boardBackGroundId=$noteBoardArr['boardBackGroundId'];
		return $noteBoardObjFromDb;
	}
	//在表中插入userId。
	public function insertNoteBoard($noteBoardArr){
		if ($reslut=$this->autoInsert($noteBoardArr)) {
			
			$noteBoardObjFromDb=$this->selectByUserId($noteBoardArr['userId']);

			return $noteBoardObjFromDb;
		}
	}
	public function selectByUserId($userId){
		$sql=$this->from($this->table_name)->where("userId='$userId'")->select();
		 $noteBoardFromDbArr= $this->db->fetchRow($sql);
		//链接查询，返回可能是二维数组。
		$noteBoardObjFromDb=$this->noteBoardArr_Obj($noteBoardFromDbArr);
		return $noteBoardObjFromDb;

	}
	public function updateNoteBoard($noteBoardArr){
		$message=$this->autoModify($noteBoardArr);
		return $this->selectByUserId($noteBoardArr['userId']);
	}
	
}