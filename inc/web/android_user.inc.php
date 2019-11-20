<?php
global $_GPC, $_W;
$op = $_GPC['op']? $_GPC['op']:'userlist_qq';
if($op=='userlist_qq'){
    $condition = ' WHERE uniacid = :uniacid ';
    $params[':uniacid'] = $_W['uniacid'];
    $sqlreg = 'SELECT * FROM '.tablename('chenyu_uniapp_user_app_qq');
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $limit = ' LIMIT '.($pindex - 1) * $psize.','.$psize;
    $userlist = pdo_fetchall($sqlreg.$condition." order by createtime desc ".$limit,$params);
    $total = pdo_fetchcolumn( 'SELECT COUNT(*) FROM '.tablename('chenyu_uniapp_user_app_qq').$condition, $params);
    $pager = pagination($total, $pindex, $psize);
}
if($op=='userlist_wx'){
    $condition = ' WHERE uniacid = :uniacid ';
    $params[':uniacid'] = $_W['uniacid'];
    $sqlreg = 'SELECT * FROM '.tablename('chenyu_uniapp_user_app_wx');
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $limit = ' LIMIT '.($pindex - 1) * $psize.','.$psize;
    $userlist = pdo_fetchall($sqlreg.$condition." order by createtime desc ".$limit,$params);
    $total = pdo_fetchcolumn( 'SELECT COUNT(*) FROM '.tablename('chenyu_uniapp_user_app_wx').$condition, $params);
    $pager = pagination($total, $pindex, $psize);
}


include $this->template('web/android/user');