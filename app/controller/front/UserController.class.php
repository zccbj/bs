<?php 
class UserController extends BackPlatformController{
	/**wx、pc用户登入
	 * 参数:wehcat,openId,headimgURL,nickName,addCountry,addProvice,addCity,
	 */
	public function signAction(){
		$from=$_POST['from'];
		if ($from=='wechat') {
				$openId=$_POST['openId'];
				$headimgURL=$_POST['headimgURL'];
				$nickName=$_POST['nickName'];
				@$addCountry=$_POST['addCountry'];
				@$addProvince=$_POST['addProvince'];
				@$addCity=$_POST['addCity'];

				$userFromView=new UserObjModel;
				$userFromView->openId=$openId;
				$userFromView->headimgURL=$headimgURL;
				$userFromView->nickName=$nickName;
				$userFromView->addCountry=$addCountry;
				$userFromView->addProvince=$addProvince;
				$userFromView->addCity=$addCity;
				$userBLLModel=new UserBLLModel;
				$result=$userBLLModel->signWc($userFromView);
				echo $result;
		}elseif($from=='pc') {
			$account=$_POST['account'];
			$password=$_POST['password'];
			$userFromView=new UserObjModel;
			$userFromView->account=$account;
			$userFromView->password=md5($password);
			$userBLLModel=new UserBLLModel;
			$result=$userBLLModel->signPc($userFromView);
			echo $result;
		}
	}
	/**
	 * pc注册（微信不需要注册）
	 *参数：用户用、密码
	 *
	 */
	public function registerAction(){
		$account=$_POST['account'];
		$password=$_POST['password'];
		$userFromView=new UserObjModel;
		$userFromView->account=$account;
		$userFromView->password=md5($password);
		$userBLLModel=new UserBLLModel;
		$result=$userBLLModel->registerPc($userFromView);
		echo $result;
	}
	public function modifyAction(){
		  $data=$_POST['data'];
		// echo $data;
		// $data='{"userId":"46","nickName":"32"}';
		$data=json_decode($data);//转换为为了data对象
		$userFromView=new UserObjModel;
		$userFromView->userId=$data->userId;
		$userFromView->nickName=$data->nickName;
		$userFromView->userIntro=$data->userIntro;
		$userFromView->account=$data->account;
		$userFromView->password=$data->password;
		$userFromView->gender=$data->gender;
		$userFromView->headimgURL=$data->headimgURL;
		$userFromView->openId=$data->openId;
		$userFromView->EmailAddress=$data->EmailAddress;
		$userBLLModel=new UserBLLModel;
		$result=$userBLLModel->modifyUser($userFromView);
		echo $result;

	}
	/**查询user信息
	 * 
	 */
	public function infouserAction(){
		$userId=$_POST['userId'];
		// if ($userId==null) {
		// 	echo 'aaa';
		// 	die();
		// }
		$userFromView=new UserObjModel;
		$userFromView->userId=$userId;
		$userBLLModel=new UserBLLModel;
		$result=$userBLLModel->infoUser($userFromView);
		echo $result;
	}
	public function modifyoneAction(){
		$userId=$_POST['userId'];
		@$nickName=$_POST['nickName']?$_POST['nickName']:null;
		@$userIntro=$_POST['userIntro']?$_POST['userIntro']:null;
		$userFromView=new UserObjModel;
		$userFromView->userId=$userId;
		$userFromView->nickName=$nickName;
		$userFromView->userIntro=$userIntro;
		$userBLLModel=new UserBLLModel;
		$result=$userBLLModel->modifyOne($userFromView);
		echo $result;
	}
	
}

