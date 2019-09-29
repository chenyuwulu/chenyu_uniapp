<?php
global $_GPC, $_W;
$list = pdo_fetch("SELECT * FROM " . tablename('chenyu_uniapp_site') . " WHERE uniacid=:uniacid ", array(':uniacid' => $_W['uniacid']));
$siteinfo = unserialize($list['site']);
if(checksubmit()){
//    var_dump($siteinfo);die;
    $site = array(
        'qq_appId'=>$_GPC['appId'],
    );
    $data = array(
        'uniacid'=>$_W['uniacid'],
        'site'=>serialize($site),
    );
    if (!empty($list)) {
        pdo_update('chenyu_uniapp_site', $data, array('id' => $list['id']));
    } else {
        pdo_insert('chenyu_uniapp_site', $data);
        $id = pdo_insertid();
    }
    message("修改成功", $redirect = '', $type = 'success');
}
include $this->template('web/android/site');