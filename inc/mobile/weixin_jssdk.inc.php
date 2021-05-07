<?php
global $_W, $_GPC;
$account_api = WeAccount::create();
$jssdk = $account_api->getJssdkConfig($_GPC["url"]);

die(json_encode(array(
    'data'=>array(
        'jssdk'=>$jssdk
    ),
    'message'=>"正常",
    'errno'=>0
)));
?>