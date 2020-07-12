#
# PHP Xoops*Visit - MySQL schema
#

CREATE TABLE `visit` (
  `visit_id` mediumint(8) unsigned NOT NULL auto_increment,
  `visit_referer` varchar(255) NOT NULL default '',
  `visit_useragent` varchar(255) NOT NULL default '',
  `visit_ip` varchar(15) NOT NULL default '',
  `visit_robot` tinyint(1) NOT NULL default '0',
  `visit_date` date NOT NULL default '0000-00-00',
  `visit_time` time NOT NULL default '00:00:00',
  PRIMARY KEY  (`visit_id`)
) TYPE=MyISAM;