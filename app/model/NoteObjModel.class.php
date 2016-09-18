<?php
	class NoteObjModel{
		//鼠标选中多行，按下 Ctrl Shift L (Command Shift L) 即可同时编辑这些行；
	private $noteId;
	private $noteStatus;
	private $pictureURL;
	private $boolPicture;
	private $noteDateTime;
	private $noteContent;
	private $boolUrgent;
	private $voiceURL;
	private $boolVoice;
	private $noteBoardId;
	private $noteTypeId;

	private $boolOpen;
	private $noteUpdateTime;
	private $likeCount;

	public function __set($key,$value){
		$this->$key=$value;
	}
	public function __get($key){
		if (isset($this->$key)) {
			return $this->$key;
		}
		return NULL;
	}	
}