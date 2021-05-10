<?php
//defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
if (empty($_W['fans']['nickname'])) {//判断是否有获取到用户信息，没有的话，触发微擎自身的获取用户信息的功能
    mc_oauth_userinfo();
}
include $this->template('weixin_login');
//重定向跳转
//header("Location:https://".$_SERVER['HTTP_HOST']."/addons/chenyu_uniapp/template/mobile/h5/");
?>