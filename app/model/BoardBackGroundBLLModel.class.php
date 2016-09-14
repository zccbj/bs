<?php
	class BoardBackGroundBLLModel{


	//BoardBackGround的
	public function infoBoardBackGround(){
		$boardBackGroundDALModel=new BoardBackGroundDALModel;
		$arrFromDb=$boardBackGroundDALModel->selectByNo();
		return $this-> JSON($arrFromDb);
		
	}
	function arrayRecursive(&$array, $function, $apply_to_keys_also = false)  
	{  
	    foreach ($array as $key => $value) {  
	        if (is_array($value)) {  
	            $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);  
	        } else {  
	            $array[$key] = $function($value);  
	        }  
	   
	        if ($apply_to_keys_also && is_string($key)) {  
	            $new_key = $function($key);  
	            if ($new_key != $key) {  
	                $array[$new_key] = $array[$key];  
	                unset($array[$key]);  
	            }  
	        }  
	    }  
	     
	}
	function JSON($array) {  
	    $this->arrayRecursive($array, 'urlencode', true);  
	    $json = json_encode($array);  
	    return urldecode($json);  
	}  
}
