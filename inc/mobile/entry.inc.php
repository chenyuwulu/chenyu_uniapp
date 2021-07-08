<?php
//defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
if (empty($_W['fans']['openid'])) {//判断是否有获取到用户信息，没有的话，触发微擎自身的获取用户信息的功能
    mc_oauth_userinfo();
}
$list = pdo_fetch('select * from '.tablename('chenyu_uniapp_user_wxapp').' where uniacid=:uniacid and openId=:openId ',array(':uniacid'=>$_W['uniacid'],':openId'=>$_W['fans']['openid']));
if(empty($list)){
    $errno = 0;
    $info = array(
        'uniacid'=>$_W['uniacid'],
        'avatar'=>$_W['fans']['avatar'],
        'gender'=>$_W['fans']['gender'],
        'nickName'=>$_W['fans']['nickname'],
        'openId'=>$_W['fans']['openid'],
        'createtime'=>time(),
    );
    $result=pdo_insert('chenyu_uniapp_user_wxapp', $info);
    if (!empty($result)) {
        $userlist = pdo_fetch("SELECT * FROM ".tablename('chenyu_uniapp_user_wxapp')." WHERE uniacid=:uniacid and openId=:openId ", array(':uniacid'=>$_W['uniacid'],':openId'=>$_W['fans']['openid']));
        $data = $userlist;
    }
} else {
    $errno = 0;
    $data = $list;
}
include $this->template('weixin_login');
//重定向跳转
//header("Location:https://".$_SERVER['HTTP_HOST']."/addons/chenyu_uniapp/template/mobile/h5/");
?>