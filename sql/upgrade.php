<?php

$installSql = <<<sql

CREATE TABLE IF NOT EXISTS `ims_chenyu_uniapp_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `site` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

sql;
$row = pdo_run($installSql);