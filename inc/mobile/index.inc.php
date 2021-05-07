<?php
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
//var_dump(111);die;
//$account_api = WeAccount::create();
//$token = $account_api->getAccessToken();
//$ticket = ihttp_get('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$token.'&type=jsapi')['content'];
//$noncestr='Wm3WZYTPz0wzccnW';
//$jsapi_ticket=$ticket;
//$timestamp = time();
//$url = 'http://192.168.8.63:8080/';
//$x = 'jsapi_ticket='.$jsapi_ticket.'&noncestr='.$noncestr.'&timestamp='.$timestamp.'url='.$url;
//$y = sha1($x);
//$account_api = WeAccount::create();
//$jssdk = $account_api->getJssdkConfig('http://localhost:8080/addons/chenyu_uniapp/template/mobile/h5/');
//$jssdk = $account_api->getJssdkConfig('https://weiqing.chenyuwulu.top/addons/chenyu_uniapp/template/mobile/h5/');

//var_dump(111);die;
//if (empty($_W['fans']['nickname'])) {
//    mc_oauth_userinfo();
//}

die(json_encode(array(
    'data'=>array(
        'w'=>$_W,
        'gpc'=>$_GPC,
//        'jssdk'=>$jssdk
    ),
    'message'=>"正常",
    'errno'=>0
)));
//include $this->template('index');
?>