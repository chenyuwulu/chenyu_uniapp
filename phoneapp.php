<?php
/**
 * chenyu_uniapp模块APP接口定义
 *
 * @author 尘雨雾录
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Chenyu_uniappModulePhoneapp extends WeModulePhoneapp {
	public function doPageTest(){
		global $_GPC, $_W;
		$errno = 0;
		$message = 'android返回消息';
        $data = array(
            'w'=>$_W,
            'gpc'=>$_GPC
        );
        return $this->result($errno, $message, $data);
	}
	
	
}