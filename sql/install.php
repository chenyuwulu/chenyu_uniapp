<?php

$installSql = <<<sql

DROP TABLE IF EXISTS `ims_chenyu_uniapp_site`;
CREATE TABLE `ims_chenyu_uniapp_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `site` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ims_chenyu_uniapp_user`;
CREATE TABLE `ims_chenyu_uniapp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `headimage` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `wxapp_openid` varchar(255) DEFAULT NULL,
  `wxapp_info` text,
  `mp_wx_openid` varchar(255) DEFAULT NULL,
  `mp_wx_info` text,
  `mp_alipay_userid` varchar(255) DEFAULT NULL,
  `mp_alipay_info` text,
  `mp_toutiao_openid` varchar(255) DEFAULT NULL,
  `mp_toutiao_info` text,
  `app_qq_openid` varchar(255) DEFAULT NULL,
  `app_qq_info` text,
  `app_wx_openid` varchar(255) DEFAULT NULL,
  `app_wx_info` text,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

sql;
$row = pdo_run($installSql);