<?php
/**
 * 微信接口控制器
 * @author mango
 * @version 2014.07.26
 */
class WxAction extends BaseAction
{
	//定义一个接口方法
	public function api()
	{
		//实例化一个Wx模型
		$wxObj = D('Wx');
		$wxObj->responseMsg();
	}
}
?>