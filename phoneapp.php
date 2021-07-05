<?php
/**
 * chenyu_uniapp模块APP接口定义
 *
 * @author 尘雨雾录
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Chenyu_uniappModulePhoneapp extends WeModulePhoneapp {
	public function doPageIndex(){
		global $_GPC, $_W;
		$errno = 0;
		$message = '返回消息';
        $data = array(
            'w'=>$_W,
            'gpc'=>$_GPC
        );
        return $this->result($errno, $message, $data);
	}

	public function doPageMe_userinfo_qq(){
        global $_GPC, $_W;
        $errno = 0;
        $data=array();
        $message = '返回消息';
        $list = pdo_fetch('select * from '.tablename('chenyu_uniapp_user_app_qq').' where uniacid=:uniacid and openId=:openId ',array(':uniacid'=>$_W['uniacid'],':openId'=>$_GPC['openId']));
        if(empty($list)){
            $errno = 0;
            $info = array(
                'uniacid'=>$_W['uniacid'],
                'figureurl_qq'=>$_GPC['figureurl_qq'],
                'nickName'=>$_GPC['nickName'],
                'gender'=>$_GPC['gender'],
                'province'=>$_GPC['province'],
                'city'=>$_GPC['city'],
                'year'=>$_GPC['year'],
                'openId'=>$_GPC['openId'],
                'createtime'=>time(),
            );
            $result=pdo_insert('chenyu_uniapp_user_app_qq', $info);
            if (!empty($result)) {
                $userlist = pdo_fetch("SELECT * FROM ".tablename('chenyu_uniapp_user_app_qq')." WHERE uniacid=:uniacid and openId=:openId ", array(':uniacid'=>$_W['uniacid'],':openId'=>$_GPC['openId']));
                $data = $userlist;
            }
        } else {
            $errno = 0;
            $data = $list;
        }
        return $this->result($errno, $message, $data);
    }
    public function doPageMe_userinfo_wx(){
        global $_GPC, $_W;
        $errno = 0;
        $data=array();
        $message = '返回消息';
        $list = pdo_fetch('select * from '.tablename('chenyu_uniapp_user_app_wx').' where uniacid=:uniacid and openId=:openId ',array(':uniacid'=>$_W['uniacid'],':openId'=>$_GPC['openId']));
        if(empty($list)){
            $errno = 0;
            $info = array(
                'uniacid'=>$_W['uniacid'],
                'avatarUrl'=>$_GPC['avatarUrl'],
                'nickName'=>$_GPC['nickName'],
                'gender'=>$_GPC['gender'],
                'province'=>$_GPC['province'],
                'city'=>$_GPC['city'],
                'country'=>$_GPC['country'],
                'openId'=>$_GPC['openId'],
                'createtime'=>time(),
            );
            $result=pdo_insert('chenyu_uniapp_user_app_wx', $info);
            if (!empty($result)) {
                $userlist = pdo_fetch("SELECT * FROM ".tablename('chenyu_uniapp_user_app_wx')." WHERE uniacid=:uniacid and openId=:openId ", array(':uniacid'=>$_W['uniacid'],':openId'=>$_GPC['openId']));
                $data = $userlist;
            }
        } else {
            $errno = 0;
            $data = $list;
        }
        return $this->result($errno, $message, $data);
    }
	
}