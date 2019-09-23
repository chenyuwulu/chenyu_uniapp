<?php
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
//在通过入口文件后，重新通过uni.request即可访问到这个文件,不会触发微擎的公众号用户授权代码了
die(json_encode(array(
    'w'=>$_W,
    'gpc'=>$_GPC
)));
?>