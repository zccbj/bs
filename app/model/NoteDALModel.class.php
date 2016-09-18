<?php
class NoteDALModel extends Model{

	protected $table_name='note0';
	//转换二维数组
	public function noteObjArr_Arr($noteObjArr){
		$objArr=array();
		foreach ($noteObjArr as $key => $value) {
			$noteObjFromDbArr=array();
			$noteObjFromDbArr['noteId']=$value['noteId'];
			$noteObjFromDbArr['noteStatus']=$value['noteStatus'];
			$noteObjFromDbArr['pictureURL']=$value['pictureURL'];
			$noteObjFromDbArr['boolPicture']=$value['boolPicture'];
			$noteObjFromDbArr['noteDateTime']=$value['noteDateTime'];
			$noteObjFromDbArr['noteContent']=$value['noteContent'];
			$noteObjFromDbArr['boolUrgent']=$value['boolUrgent'];
			$noteObjFromDbArr['voiceURL']=$value['voiceURL'];
			$noteObjFromDbArr['boolVoice']=$value['boolVoice'];
			$noteObjFromDbArr['noteBoardId']=$value['noteBoardId'];
			$noteObjFromDbArr['noteTypeId']=$value['noteTypeId'];

			$noteObjFromDbArr['boolOpen']=$value['boolOpen'];
			$noteObjFromDbArr['noteUpdateTime']=$value['noteUpdateTime'];
			$noteObjFromDbArr['likeCount']=$value['likeCount'];

			$objArr[]=$noteObjFromDbArr;
		}
			return $objArr;

		}
	public function noteObjArr_Obj($noteObjArr){
		$noteObjFromDb=new NoteObjModel;
		$noteObjFromDb->noteId=$noteObjArr['noteId'];
		$noteObjFromDb->noteStatus=$noteObjArr['noteStatus'];
		$noteObjFromDb->pictureURL=$noteObjArr['pictureURL'];
		$noteObjFromDb->boolPicture=$noteObjArr['boolPicture'];
		$noteObjFromDb->noteDateTime=$noteObjArr['noteDateTime'];
		$noteObjFromDb->noteContent=$noteObjArr['noteContent'];
		$noteObjFromDb->boolUrgent=$noteObjArr['boolUrgent'];
		$noteObjFromDb->voiceURL=$noteObjArr['voiceURL'];
		$noteObjFromDb->boolVoice=$noteObjArr['boolVoice'];
		$noteObjFromDb->noteBoardId=$noteObjArr['noteBoardId'];
		$noteObjFromDb->noteTypeId=$noteObjArr['noteTypeId'];
		$noteObjFromDb->boolOpen=$noteObjArr['boolOpen'];
		$noteObjFromDb->noteUpdateTime=$noteObjArr['noteUpdateTime'];
		$noteObjFromDb->likeCount=$noteObjArr['likeCount'];

		return $noteObjFromDb;
	}
	public function insertNote($noteObjArr,$noteNum){
		$this->table_name='note'.$noteNum;
		//var_dump($noteObjArr);
		if ($reslut=$this->autoInsert($noteObjArr)) {

				$noteObj=$this->selectByNoteBoardIdNew($noteObjArr['noteBoardId'],$noteNum);
				return $noteObj;
		}else{
			return false;
		}
	}

	//insert方法需要用。//按添加时间排序
	public function selectByNoteBoardIdNew($noteBoardId,$noteNum){
		$this->table_name='note'.$noteNum;

		$sql=$this->from($this->table_name)->where("noteBoardId='$noteBoardId'")->order("noteDateTime desc")->select();
	
		$noteObjFromDbArr=$this->db->fetchRow($sql);
	
		return $this->noteObjArr_Obj($noteObjFromDbArr);
	}
	//返回一维数组obj
	public function selectByNoteIdObj($noteId,$noteNum){
		$this->table_name='note'.$noteNum;
		return $this->noteObjArr_Obj($this->autoSelectRow($noteId));	
	}
	// //返回一维数组
	// public function selectByNoteId($noteId,$noteNum){
	// 	$this->table_name='note'.$noteNum;
	// 	return $this->autoSelectRow($noteId);	
	// }

		//返回二维数组
	public function selectByNoteBoardId($noteBoardId,$noteNum){
		$this->table_name='note'.$noteNum;
		$sql=$this->from($this->table_name)->where("noteBoardId='$noteBoardId'")->select();
		$erArr=$this->db->fetchAll($sql);
		return $this->noteObjArr_Arr($erArr);
	}
	public function updateByNoteArr($noteObjArr,$noteNum){
		$this->table_name='note'.$noteNum;
		$noteId=$noteObjArr['noteId'];
		if ($message=$this->autoModify($noteObjArr)) {
			$noteObjFromDb=$this->selectByNoteIdObj($noteId,$noteNum);
			return $noteObjFromDb;
		}
	}
	public function delByNoteId($noteId,$noteNum){
		$this->table_name='note'.$noteNum;
		return $this->autoDelete($noteId);
	}

}