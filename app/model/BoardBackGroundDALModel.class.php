<?php
	class BoardBackGroundDALModel extends Model{
		protected $table_name='boardBackGround';
		
		//二维数组
		public function boardBackGroundArr_Arr($boardBackGroundArr){
			$objArr=array();
			foreach ($boardBackGroundArr as $key => $value) {
				$boardBackGroundArr=array();
				$boardBackGroundArr['boardBackGroundId']=$value['boardBackGroundId'];
				$boardBackGroundArr['boardBackGroundName']=$value['boardBackGroundName'];
				$objArr[]=$boardBackGroundArr;
			}
			return $objArr;
		}
		//返回的是二维数组，因为要转json
		public function selectByNo(){
			$sql=$this->from($this->table_name)->select();
			$boardBackGroundArr=$this->db->fetchAll($sql);
			//return $boardBackGroundArr;
			return $this->boardBackGroundArr_Arr($boardBackGroundArr);
		}


	}