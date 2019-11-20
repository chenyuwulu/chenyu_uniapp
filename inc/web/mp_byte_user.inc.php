<?php
global $_GPC, $_W;
$op = $op?$op:'userlist';

$condition = ' WHERE uniacid = :uniacid ';
$params[':uniacid'] = $_W['uniacid'];
$sqlreg = 'SELECT * FROM '.tablename('chenyu_uniapp_user_mp_byte');
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$limit = ' LIMIT '.($pindex - 1) * $psize.','.$psize;
$userlist = pdo_fetchall($sqlreg.$condition." order by createtime desc ".$limit,$params);
$total = pdo_fetchcolumn( 'SELECT COUNT(*) FROM '.tablename('chenyu_uniapp_user_mp_byte').$condition, $params);
$pager = pagination($total, $pindex, $psize);

include $this->template('web/mp_byte/user');