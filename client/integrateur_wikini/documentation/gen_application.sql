INSERT INTO `gen_application` ( `gap_id_application` , `gap_nom` , `gap_description` , `gap_chemin` , `gap_bool_applette` )
VALUES (
'30', 'Integrateur - wikini', 'Permet d''insérer des pages d''un wikini.', 'client/integrateur_wikini/integrateur_wikini.php', '0'
);
INSERT INTO `gen_application` ( `gap_id_application` , `gap_nom` , `gap_description` , `gap_chemin` , `gap_bool_applette` )
VALUES (
'31', 'Administration - Wikini', 'Administration Wikini', 'client/integrateur_wikini/admin_wikini.php', '0'
) ;

CREATE TABLE `gen_dummy_wikini_acls` (
  `page_tag` varchar(50) NOT NULL default '',
  `privilege` varchar(20) NOT NULL default '',
  `list` text NOT NULL,
  PRIMARY KEY  (`page_tag`,`privilege`)
); 


CREATE TABLE `gen_dummy_wikini_links` (
  `from_tag` char(50) NOT NULL default '',
  `to_tag` char(50) NOT NULL default '',
  UNIQUE KEY `from_tag` (`from_tag`,`to_tag`),
  KEY `idx_from` (`from_tag`),
  KEY `idx_to` (`to_tag`)
);

CREATE TABLE `gen_dummy_wikini_pages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(50) NOT NULL default '',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `body` text NOT NULL,
  `body_r` text NOT NULL,
  `owner` varchar(50) NOT NULL default '',
  `user` varchar(50) NOT NULL default '',
  `latest` enum('Y','N') NOT NULL default 'N',
  `handler` varchar(30) NOT NULL default 'page',
  `comment_on` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `idx_tag` (`tag`),
  KEY `idx_time` (`time`),
  KEY `idx_latest` (`latest`),
  KEY `idx_comment_on` (`comment_on`),
  FULLTEXT KEY `tag` (`tag`,`body`)
);

CREATE TABLE `gen_dummy_wikini_referrers` (
  `page_tag` char(50) NOT NULL default '',
  `referrer` char(150) NOT NULL default '',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  KEY `idx_page_tag` (`page_tag`),
  KEY `idx_time` (`time`)
);


CREATE TABLE `gen_dummy_wikini_users` (
  `name` varchar(80) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `motto` text NOT NULL,
  `revisioncount` int(10) unsigned NOT NULL default '20',
  `changescount` int(10) unsigned NOT NULL default '50',
  `doubleclickedit` enum('Y','N') NOT NULL default 'Y',
  `signuptime` datetime NOT NULL default '0000-00-00 00:00:00',
  `show_comments` enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (`name`),
  KEY `idx_name` (`name`),
  KEY `idx_signuptime` (`signuptime`)
);

CREATE TABLE `gen_wikini` (
  `gewi_id_wikini` int(11) NOT NULL default '0',
  `gewi_code_alpha_wikini` varchar(255) NOT NULL default '',
  `gewi_bdd_hote` varchar(20) NOT NULL default '',
  `gewi_bdd_nom` varchar(20) NOT NULL default '',
  `gewi_bdd_utilisateur` varchar(20) NOT NULL default '',
  `gewi_bdd_mdp` varchar(20) NOT NULL default '',
  `gewi_table_prefix` varchar(255) NOT NULL default '',
  `gewi_page` varchar(20) NOT NULL default '',
  `gewi_chemin` varchar (100) NOT NULL,
  PRIMARY KEY  (`gewi_id_wikini`)
) ;

ALTER TABLE `gen_wikini` CHANGE `gewi_code_alpha_wikini` `gewi_code_alpha_wikini` VARCHAR( 255 )  NOT NULL;
ALTER TABLE `gen_wikini` CHANGE `gewi_table_prefix` `gewi_table_prefix` VARCHAR( 255 ) NOT NULL;
