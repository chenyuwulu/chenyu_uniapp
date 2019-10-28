<?php
/**
 * chenyu_uniapp模块小程序接口定义
 *
 * @author 尘雨雾录
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Chenyu_uniappModuleWxapp extends WeModuleWxapp {

    public function doPageMe_getuserinfo(){
        include_once (IA_ROOT . '/addons/chenyu_uniapp/inc/SDK/weixin/wxBizDataCrypt.php');
        load()->func('communication');
        global $_GPC, $_W;
        $errno = 0;
        $message = '此处是微擎小程序后端返回消息';
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $_W['account']['key'] . "&secret=" . $_W['account']['secret'] . "&js_code=" . $_GPC['code'] . "&grant_type=authorization_code";
        $res = ihttp_get($url);
        $res = json_decode($res['content'],1);
        $openid = $res['openid'];
        $session_key = $res['session_key'];
        // 数据签名校验
        $signature2 = sha1(htmlspecialchars_decode($_GPC['rawData']).$session_key);
        if ($_GPC['signature'] != $signature2) {
            $data = array(
                'status'=>500,
                'msg'=>'数据签名验证失败！',
                '$signature2'=>$signature2,
                '$session_key'=>$session_key,
                'rawData'=>$_GPC['rawData'],
                'signature'=>$_GPC['signature']
            );
            return $this->result($errno, $message, $data);
        }
        $pc =new WXBizDataCrypt($_W['account']['key'],$session_key);
        $errCode = $pc->decryptData($_GPC['encryptedData'], $_GPC['iv'], $datas);  //其中$data包含用户的所有数据
        $datas = json_decode($datas,true);
        $list = pdo_fetch('select * from '.tablename('chenyu_uniapp_user_mp_wx').' where uniacid=:uniacid and openId=:openId ',array(':uniacid'=>$_W['uniacid'],':openId'=>$datas['openId']));
        if(empty($list)){
            $errno = 0;
            $info = array(
                'uniacid'=>$_W['uniacid'],
                'avatarUrl'=>$datas['avatarUrl'],
                'city'=>$datas['city'],
                'country'=>$datas['country'],
                'gender'=>$datas['gender'],
                'language'=>$datas['language'],
                'nickName'=>$datas['nickName'],
                'openId'=>$datas['openId'],
                'province'=>$datas['province'],
                'createtime'=>time(),
            );
            $result=pdo_insert('chenyu_uniapp_user_mp_wx', $info);
            if (!empty($result)) {
                $userlist = pdo_fetch("SELECT * FROM ".tablename('chenyu_uniapp_user_mp_wx')." WHERE uniacid=:uniacid and openId=:openId ", array(':uniacid'=>$_W['uniacid'],':openId'=>$datas['openId']));
                $data = $userlist;
            }
        } else {
            $errno = 0;
            $data = $list;
        }
        return $this->result($errno, $message, $data);
    }

	public function doPageTest(){
        global $_GPC, $_W;
        $errno = 0;
        $message = '此处是微擎小程序后端返回消息';
        $data = array(
            'w'=>$_W,
            'gpc'=>$_GPC
        );
        return $this->result($errno, $message, $data);
	}
}