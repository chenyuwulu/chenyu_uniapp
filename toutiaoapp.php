<?php
/**
 * chenyu_uniapp头条小程序接口定义
 *
 * @author 尘雨雾录
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Chenyu_uniappModuleToutiaoapp extends WeModuleToutiaoapp {
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
    public function doPageGetuserinfo(){
        load()->func('communication');
        global $_GPC, $_W;
        $errno = 0;
        $message = '返回用户信息';
        $loginurl = 'https://developer.toutiao.com/api/apps/jscode2session?appid='.$_W['account']['appid'].'&secret='.$_W['account']['secret'].'&code='.$_GPC['code'];
        $response = ihttp_get($loginurl);
        $response['content'] = json_decode($response['content'],true);
        $datass = openssl_decrypt(base64_decode($_GPC['encryptedData'],true), 'AES-128-CBC', base64_decode($response['content']['session_key']), OPENSSL_RAW_DATA, base64_decode($_GPC['iv']));
        $datas = json_decode($datass,true);
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