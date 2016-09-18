<?php
class ResponseTool{
	/**
 * 按json方式输出通信数据
 *@praram iterger $code 状态码
 *@praram iterger $message 提示信息
 *@praram iterger $data 数据
  *@praram iterger $type 数据类型
 *return string 
 */
	public static function show($code,$message='',$data=array(),$type='json'){
		//保证只有一个入口
		if (!is_numeric($code)) {
			return '';
		}
		$result=array(
			'sign'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		if($type=='json'){
			self::json($code,$message,$data);
			exit();
		}elseif ($type=='array') {
			//相当于调试模式
			var_dump($result);
			exit();
		}elseif ($type=='xml') {
			self::xml($code,$message,$data);
			exit();
		}else{
			exit();
		}

	}
/**
 * 按json方式输出通信数据
 *@praram iterger $code 状态码
 *@praram iterger $message 提示信息
 *@praram iterger $data 数据
 *return string 
 */
	public static function json($code,$message='',$data=array()){
		if (!is_numeric($code)) {
			return '';
		}
		$result=array(
			'sign'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		
		echo json_encode($result,JSON_UNESCAPED_UNICODE);
		//echo self::JSON2($result);

	}
/**
 * 按xml方式输出通信数据
 *@praram iterger $code 状态码
 *@praram iterger $message 提示信息
 *@praram iterger $code 状态码
 *return string 
 */
	public static function xml($code,$message='',$data=array()){
		if (!is_numeric($code)) {
			return '';
		}
		$result=array(
			'sign'=>$code,
			'message'=>$message,
			'data'=>$data
		);
		// header("Content-Type:text/xml");
		$xml="<?xml version='1.0' encoding='UTF-8'?>";
		$xml.="<root>";
		$xml.=self::xmlToEncode($result);
		$xml.="</root>";
		echo $xml;

	}
	/**
	 * 数组－>xml字符串
	 */
	public static function xmlToEncode($data){
		$xml="";
		foreach($data as $key => $value) {
	        $attr = "";
	        if(is_numeric($key)) {
	            $attr = " id='{$key}'";
	            $key = "item";
	        }
	        $xml .= "<{$key}{$attr}>";
	        $xml .= is_array($value) ? self::xmlToEncode($value) : $value;
	        $xml .= "</{$key}>\n";
    	}
		return $xml;

	}

}
	//原来这个方法可以直接用JSON_UNESCAPED_UNICODE。。。。代替
	// public static function arrayRecursive(&$array, $function, $apply_to_keys_also = false)  
	// {  
	// 	//因为没有返回值，所以就用了&
	//     foreach ($array as $key => $value) {  
	//         if (is_array($value)) {  
	//             self::arrayRecursive($array[$key], $function, $apply_to_keys_also);  
	//         } else {  
	//         	//对value进行处理
	//             $array[$key] = $function($value);  
	//         }  
	   

	//         //对key处理
	//         if ($apply_to_keys_also && is_string($key)) {  
	//             $new_key = $function($key);  
	//             if ($new_key != $key) {  
	//                 $array[$new_key] = $array[$key];  
	//                 unset($array[$key]);  
	//             }  
	//         }  


	//     }  	    
	     
	// }
	// public static function JSON2($array) {  
	//     self::arrayRecursive($array, 'urlencode', true);  
	//     $json = json_encode($array);  
	//     return urldecode($json);  
	// }