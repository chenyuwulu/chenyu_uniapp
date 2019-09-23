<?php
global $_GPC, $_W;
$url = "https://".$_SERVER['HTTP_HOST']."/".str_replace('./','app/',$this->createMobileUrl('entry'));

include $this->template('web/app_wx/site');