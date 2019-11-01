<?php
/**
 * chenyu_uniapp头条小程序接口定义
 *
 * @author 尘雨雾录
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Chenyu_uniappModuleToutiaoapp extends WeModuleToutiaoapp {
    public function doPageTest(){
        global $_GPC, $_W;
        $errno = 0;
        $message = '返回消息';
        $data = array(
            'w'=>$_W,
            'gpc'=>$_GPC
        );
        return $this->result($errno, $message, $data);
    }
    public function doPageGetuserinfo(){
        //sdk直接用微信的就可以，头条应该是懒得自己弄了，所以规则用的和微信一样
        include_once (IA_ROOT . '/addons/chenyu_uniapp/inc/SDK/byte/wxBizDataCrypt.php');
        load()->func('communication');
        global $_GPC, $_W;
        $errno = 0;
        $message = '返回用户信息';
        $loginurl = 'https://developer.toutiao.com/api/apps/jscode2session?appid='.$_W['account']['appid'].'&secret='.$_W['account']['secret'].'&code='.$_GPC['code'];
        $post = array(
            'appid' => $_W['account']['appid'],
            'secret' => $_W['account']['secret'],
            'code' => $_GPC['code'],
            'anonymous_code' => $_GPC['anonymous_code'],
        );
        $response = ihttp_get($loginurl);
        $response['content'] = json_decode($response['content'],true);
        $pc = new WXBizDataCrypt($_W['account']['appid'], $response['content']['session_key']);
        $errCode = $pc->decryptData($_GPC['encryptedData'], $_GPC['iv'], $datas );
        $data = array(
            'userInfo'=>json_decode($datas,true)
        );
        $datas = json_decode($datas,true);
        $list = pdo_fetch('select * from '.tablename('chenyu_uniapp_user_mp_byte').' where uniacid=:uniacid and openId=:openId ',array(':uniacid'=>$_W['uniacid'],':openId'=>$datas['openId']));
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
            $result=pdo_insert('chenyu_uniapp_user_mp_byte', $info);
            if (!empty($result)) {
                $userlist = pdo_fetch("SELECT * FROM ".tablename('chenyu_uniapp_user_mp_byte')." WHERE uniacid=:uniacid and openId=:openId ", array(':uniacid'=>$_W['uniacid'],':openId'=>$datas['openId']));
                $data = $userlist;
            }
        } else {
            $errno = 0;
            $data = $list;
        }
        return $this->result($errno, $message, $data);
    }
}