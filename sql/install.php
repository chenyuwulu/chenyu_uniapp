<?php

$installSql = <<<sql
-- ----------------------------
-- Table structure for `ims_ewei_message_mass_sign`
-- ----------------------------
DROP TABLE IF EXISTS `ims_chenyu_uniapp_site`;
CREATE TABLE `ims_chenyu_uniapp_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `site` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_ewei_message_mass_sign
-- ----------------------------

sql;
$row = pdo_run($installSql);