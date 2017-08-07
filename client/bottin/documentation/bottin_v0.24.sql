INSERT INTO `gen_application` ( `gap_id_application` , `gap_nom` , `gap_description` , `gap_chemin` , `gap_bool_applette` )
VALUES (
'19', 'Inscription', 'Gestionnaire des inscriptions au bottin', 'client/bottin/inscription.php', '0'
);
INSERT INTO `gen_application` ( `gap_id_application` , `gap_nom` , `gap_description` , `gap_chemin` , `gap_bool_applette` )
VALUES (
'14', 'Cartographie', 'Cartographie associ&eacute;e au bottin', 'client/bottin/cartographie.php', '0'
);
INSERT INTO `gen_application` ( `gap_id_application` , `gap_nom` , `gap_description` , `gap_chemin` , `gap_bool_applette` )
VALUES (
'15', 'Annuaire', 'Annuaire associ&eacute;e au bottin', 'client/bottin/annuaire.php', '0'
);
-- 
-- Structure de la table `annuaire`
-- 
CREATE TABLE `annuaire` (
  `a_id` int(11) unsigned NOT NULL default '0',
  `a_ce_i18n` varchar(8) NOT NULL default '',
  `a_nom` varchar(32) NOT NULL default '',
  `a_prenom` varchar(32) NOT NULL default '',
  `a_profession` varchar(255) NOT NULL default '',
  `a_mot_de_passe` varchar(32) NOT NULL default 'X X',
  `a_mail` varchar(128) NOT NULL default '',
  `a_nom_wikini` varchar(255) NOT NULL default '',
  `a_adresse1` text,
  `a_adresse2` text,
  `a_telephone` varchar(32) NOT NULL default '',
  `a_fax` varchar(32) NOT NULL default '',
  `a_code_postal` varchar(32) default NULL,
  `a_ville` varchar(255) default NULL,
  `a_ce_pays` char(3) default NULL,
  `a_region` varchar(255) default NULL,
  `a_code_insee_commune` varchar(255) default NULL,
  `a_numero_dpt` int(10) unsigned default NULL,
  `a_date_inscription` datetime NOT NULL default '0000-00-00 00:00:00',
  `a_est_structure` tinyint(3) unsigned NOT NULL default '0',
  `a_structure` varchar(255) NOT NULL default '',
  `a_appartient_structure` int(10) unsigned NOT NULL default '0',
  `a_sigle_structure` varchar(64) NOT NULL default '',
  `a_num_agrement_fpc` varchar(64) NOT NULL default '',
  `a_lettre` tinyint(3) unsigned NOT NULL default '0',
  `a_site_internet` varchar(255) default NULL,
  `a_voir_sur_carto` tinyint(3) unsigned NOT NULL default '0',
  `a_logo` varchar(255) NOT NULL,
  PRIMARY KEY  (`a_id`)
);

-- --------------------------------------------------------
-- 
-- Structure de la table `inscription_demande`
-- 
DROP TABLE IF EXISTS `inscription_demande`;
CREATE TABLE IF NOT EXISTS `inscription_demande` (
  `id_identifiant_session` varchar(32) NOT NULL default '',
  `id_donnees` text NOT NULL,
  `id_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id_identifiant_session`)
);

-- --------------------------------------------------------
-- 
-- Structure de la table `inscription_template`
-- 
DROP TABLE IF EXISTS `inscription_template`;
CREATE TABLE IF NOT EXISTS `inscription_template` (
  `it_id_template` smallint(5) unsigned NOT NULL default '0',
  `it_i18n` varchar(5) NOT NULL default '',
  `it_template` text NOT NULL,
  PRIMARY KEY  (`it_id_template`)
);

-- --------------------------------------------------------
-- 
-- Contenu de la table `inscription_template`
-- 
INSERT INTO `inscription_template` (`it_id_template`, `it_i18n`, `it_template`) VALUES (1, 'fr-FR', '<h2>D&eacute;j&agrave;  inscrit, identifiez-vous pour acc&eacute;der &agrave;  votre fiche personnelle :</h2>\r\n\r\n<form  action="{URL_INSCRIPTION}" method="post" name="inscription_identification" id="inscription_identification" style="width:300px;">\r\n\r\n<p class="label100">Adresse mail : &nbsp;</p>\r\n<input name="username" type="text" /><br />\r\n<p class="label100">Mot de passe : &nbsp;</p>\r\n<input name="password" type="password" /><br />\r\n<p class="label100">&nbsp;</p>\r\n<input name="valider" value="Valider" type="submit" /><br />\r\n\r\n</form>\r\n\r\n<br /><h2 style="width:100%;">Pas encore inscrit, inscrivez-vous !</h2>\r\n<ul>\r\n<li><a href="{URL_INSCRIPTION}&amp;action=inscription&amp;form_structure=0">S''inscrire en tant que personne</a></li>\r\n<li><a href="{URL_INSCRIPTION}&amp;action=inscription&amp;form_structure=1">S''inscrire en tant que structure</a></li>\r\n</ul>\r\n\r\n<br />\r\n<div><strong>L''inscription est libre et gratuite</strong>, elle vous permet de :<br /><ul>\r\n<li> consulter l''annuaire des personnes inscrites au R&eacute;seau et pouvoir ainsi &eacute;changer des informations</li>\r\n<li> acc&eacute;der &agrave;  certaines informations diffus&eacute;es sur le site</li>\r\n<li> vous inscrire &agrave;  des projets</li>\r\n\r\n<li> r&eacute;diger des annonces d''actualit&eacute;, d''&eacute;v&eacute;nements, de s&eacute;jours et rencontres</li>\r\n<li> r&eacute;diger des fiches ressources</li>\r\n<li> recevoir un bulletin &eacute;lectronique d''informations.</li></ul></div>'),
(2, 'fr-FR', 'Bonjour,\r\n\r\nNous avons recu une demande d''inscription pour cette adresse mail.\r\n\r\nPour confirmer, cliquer sur le lien ci-dessous.\r\n\r\n{URL_INSCRIPTION}\r\nL''&eacute;quipe');

-- --------------------------------------------------------
--   
-- Structure de la table `interwikini_users` pour faire des inscriptions avec wikini (OPTIONNELLE)
-- 
DROP TABLE IF EXISTS `interwikini_users`;
CREATE TABLE `interwikini_users` (
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

-- --------------------------------------------------------
-- 
-- Structure de la table `gen_departement`
-- 
DROP TABLE IF EXISTS `gen_departement`;
CREATE TABLE `gen_departement` (
  `gd_id_departement` int(11) NOT NULL default '0',
  `gd_nom` varchar(100) NOT NULL default '',
  `gd_region` int(11) NOT NULL default '900',
  PRIMARY KEY  (`gd_id_departement`)
);

-- 
-- Contenu de la table `gen_departement`
-- 
INSERT INTO `gen_departement` VALUES (1, 'Ain', 22);
INSERT INTO `gen_departement` VALUES (2, 'Aisne', 19);
INSERT INTO `gen_departement` VALUES (3, 'Allier', 3);
INSERT INTO `gen_departement` VALUES (4, 'Alpes-de-Haute-Provence', 21);
INSERT INTO `gen_departement` VALUES (5, 'Hautes-Alpes', 21);
INSERT INTO `gen_departement` VALUES (6, 'Alpes-Maritimes', 21);
INSERT INTO `gen_departement` VALUES (7, 'Ardèche', 22);
INSERT INTO `gen_departement` VALUES (8, 'Ardennes', 8);
INSERT INTO `gen_departement` VALUES (9, 'Ariège', 16);
INSERT INTO `gen_departement` VALUES (10, 'Aube', 8);
INSERT INTO `gen_departement` VALUES (11, 'Aude', 13);
INSERT INTO `gen_departement` VALUES (12, 'Aveyron', 16);
INSERT INTO `gen_departement` VALUES (13, 'Bouches-du-Rhône', 21);
INSERT INTO `gen_departement` VALUES (14, 'Calvados', 4);
INSERT INTO `gen_departement` VALUES (15, 'Cantal', 3);
INSERT INTO `gen_departement` VALUES (16, 'Charente', 20);
INSERT INTO `gen_departement` VALUES (17, 'Charente-Maritime', 20);
INSERT INTO `gen_departement` VALUES (18, 'Cher', 7);
INSERT INTO `gen_departement` VALUES (19, 'Corrèze', 14);
INSERT INTO `gen_departement` VALUES (20, 'Corse', 9);
INSERT INTO `gen_departement` VALUES (21, 'Côte-d''Or', 5);
INSERT INTO `gen_departement` VALUES (22, 'Côtes-d''Armor', 6);
INSERT INTO `gen_departement` VALUES (23, 'Creuse', 14);
INSERT INTO `gen_departement` VALUES (24, 'Dordogne', 2);
INSERT INTO `gen_departement` VALUES (25, 'Doubs', 10);
INSERT INTO `gen_departement` VALUES (26, 'Drôme', 22);
INSERT INTO `gen_departement` VALUES (27, 'Eure', 11);
INSERT INTO `gen_departement` VALUES (28, 'Eure-et-Loir', 7);
INSERT INTO `gen_departement` VALUES (29, 'Finistère', 6);
INSERT INTO `gen_departement` VALUES (30, 'Gard', 13);
INSERT INTO `gen_departement` VALUES (31, 'Haute-Garonne', 16);
INSERT INTO `gen_departement` VALUES (32, 'Gers', 16);
INSERT INTO `gen_departement` VALUES (33, 'Gironde', 2);
INSERT INTO `gen_departement` VALUES (34, 'Hérault', 13);
INSERT INTO `gen_departement` VALUES (35, 'Ille-et-Vilaine', 6);
INSERT INTO `gen_departement` VALUES (36, 'Indre', 7);
INSERT INTO `gen_departement` VALUES (37, 'Indre-et-Loire', 7);
INSERT INTO `gen_departement` VALUES (38, 'Isère', 22);
INSERT INTO `gen_departement` VALUES (39, 'Jura', 10);
INSERT INTO `gen_departement` VALUES (40, 'Landes', 2);
INSERT INTO `gen_departement` VALUES (41, 'Loir-et-Cher', 7);
INSERT INTO `gen_departement` VALUES (42, 'Loire', 22);
INSERT INTO `gen_departement` VALUES (43, 'Haute-Loire', 3);
INSERT INTO `gen_departement` VALUES (44, 'Loire-Atlantique', 18);
INSERT INTO `gen_departement` VALUES (45, 'Loiret', 7);
INSERT INTO `gen_departement` VALUES (46, 'Lot', 16);
INSERT INTO `gen_departement` VALUES (47, 'Lot-et-Garonne', 2);
INSERT INTO `gen_departement` VALUES (48, 'Lozére', 13);
INSERT INTO `gen_departement` VALUES (49, 'Maine-et-Loire', 18);
INSERT INTO `gen_departement` VALUES (50, 'Manche', 4);
INSERT INTO `gen_departement` VALUES (51, 'Marne', 8);
INSERT INTO `gen_departement` VALUES (52, 'Haute-Marne', 8);
INSERT INTO `gen_departement` VALUES (53, 'Mayenne', 18);
INSERT INTO `gen_departement` VALUES (54, 'Meurthe-et-Moselle', 15);
INSERT INTO `gen_departement` VALUES (55, 'Meuse', 15);
INSERT INTO `gen_departement` VALUES (56, 'Morbihan', 6);
INSERT INTO `gen_departement` VALUES (57, 'Moselle', 15);
INSERT INTO `gen_departement` VALUES (58, 'Nièvre', 5);
INSERT INTO `gen_departement` VALUES (59, 'Nord', 17);
INSERT INTO `gen_departement` VALUES (60, 'Oise', 19);
INSERT INTO `gen_departement` VALUES (61, 'Orne', 4);
INSERT INTO `gen_departement` VALUES (62, 'Pas-de-Calais', 17);
INSERT INTO `gen_departement` VALUES (63, 'Puy-de-Dôme', 3);
INSERT INTO `gen_departement` VALUES (64, 'Pyrénées-Atlantiques', 2);
INSERT INTO `gen_departement` VALUES (65, 'Hautes-Pyrénées', 16);
INSERT INTO `gen_departement` VALUES (66, 'Pyrénées-Orientales', 13);
INSERT INTO `gen_departement` VALUES (67, 'Bas-Rhin', 1);
INSERT INTO `gen_departement` VALUES (68, 'Haut-Rhin', 1);
INSERT INTO `gen_departement` VALUES (69, 'Rhône', 22);
INSERT INTO `gen_departement` VALUES (70, 'Haute-Saône', 10);
INSERT INTO `gen_departement` VALUES (71, 'Saône-et-Loire', 5);
INSERT INTO `gen_departement` VALUES (72, 'Sarthe', 18);
INSERT INTO `gen_departement` VALUES (73, 'Savoie', 22);
INSERT INTO `gen_departement` VALUES (74, 'Haute-Savoie', 22);
INSERT INTO `gen_departement` VALUES (75, 'Paris', 12);
INSERT INTO `gen_departement` VALUES (76, 'Seine-Maritime', 11);
INSERT INTO `gen_departement` VALUES (77, 'Seine-et-Marne', 12);
INSERT INTO `gen_departement` VALUES (78, 'Yvelines', 12);
INSERT INTO `gen_departement` VALUES (79, 'Deux-Sèvres', 20);
INSERT INTO `gen_departement` VALUES (80, 'Somme', 19);
INSERT INTO `gen_departement` VALUES (81, 'Tarn', 16);
INSERT INTO `gen_departement` VALUES (82, 'Tarn-et-Garonne', 16);
INSERT INTO `gen_departement` VALUES (83, 'Var', 21);
INSERT INTO `gen_departement` VALUES (84, 'Vaucluse', 21);
INSERT INTO `gen_departement` VALUES (85, 'Vendée', 18);
INSERT INTO `gen_departement` VALUES (86, 'Vienne', 20);
INSERT INTO `gen_departement` VALUES (87, 'Haute-Vienne', 14);
INSERT INTO `gen_departement` VALUES (88, 'Vosges', 15);
INSERT INTO `gen_departement` VALUES (89, 'Yonne', 5);
INSERT INTO `gen_departement` VALUES (90, 'Territoire-de-Belfort', 10);
INSERT INTO `gen_departement` VALUES (91, 'Essonne', 12);
INSERT INTO `gen_departement` VALUES (92, 'Hauts-de-Seine', 12);
INSERT INTO `gen_departement` VALUES (93, 'Seine-Saint-Denis', 12);
INSERT INTO `gen_departement` VALUES (94, 'Val-de-Marne', 12);
INSERT INTO `gen_departement` VALUES (95, 'Val-d''Oise', 12);
INSERT INTO `gen_departement` VALUES (99, 'Etranger', 900);
INSERT INTO `gen_departement` VALUES (971, 'Guadeloupe', 900);
INSERT INTO `gen_departement` VALUES (972, 'Martinique', 900);
INSERT INTO `gen_departement` VALUES (973, 'Guyane', 900);
INSERT INTO `gen_departement` VALUES (974, 'Réunion', 900);
INSERT INTO `gen_departement` VALUES (975, 'St-Pierre-et-Miquelon', 900);
INSERT INTO `gen_departement` VALUES (976, 'Mayotte', 900);
INSERT INTO `gen_departement` VALUES (980, 'Monaco', 900);
INSERT INTO `gen_departement` VALUES (986, 'Wallis-et-Futuna', 900);
INSERT INTO `gen_departement` VALUES (987, 'Polynésie-Française', 900);
INSERT INTO `gen_departement` VALUES (988, 'Nouvelle-Calédonie', 900);
INSERT INTO `gen_departement` VALUES (900, '', 900);


#
# Structure de la table `carto_ACTION`
#

CREATE TABLE `carto_ACTION` (
  `CA_ID_Projet_Carto` int(11) NOT NULL default '0',
  `CA_ID_Carte` varchar(32) NOT NULL default '',
  `CA_ID_Zone_geo` varchar(255) NOT NULL default '',
  `CA_Type_zone` int(11) NOT NULL default '0',
  `CA_Action` varchar(10) NOT NULL default '',
  `CA_ID_Carte_destination` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`CA_ID_Projet_Carto`,`CA_ID_Carte`,`CA_ID_Zone_geo`,`CA_Type_zone`,`CA_ID_Carte_destination`,`CA_Action`),
  KEY `CA_PROJECT` (`CA_ID_Carte`)
);

#
# Contenu de la table `carto_ACTION`
#

INSERT INTO `carto_ACTION` VALUES (1, 'afrique', '0', 2, 'Recharger', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'ao', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'bf', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'bi', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'bj', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'bw', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'cd', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'cf', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'cg', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'ci', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'cm', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'cv', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'dj', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'dz', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'eg', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'er', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'et', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'ga', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'gh', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'gm', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'gn', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'gq', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'gw', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'ke', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'km', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'lr', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'ls', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'ly', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'ma', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'mg', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'ml', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'mr', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'mu', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'mw', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'mz', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'na', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'ne', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'ng', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'rw', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'sc', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'sd', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'sl', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'sn', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'so', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'st', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'sz', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'td', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'tg', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'tn', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'tz', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'ug', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'za', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'zm', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'afrique', 'zw', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', '0', 2, 'Recharger', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'bd', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'bn', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'bt', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'cn', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'id', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'in', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'jp', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'kh', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'kp', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'kr', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'kz', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'la', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'lk', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'mm', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'mn', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'mv', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'my', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'np', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'ph', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'rua', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'sg', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'th', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'tw', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'asie', 'vn', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'continent', '0', 1, 'Recharger', '');
INSERT INTO `carto_ACTION` VALUES (1, 'continent', '1', 1, 'Aller_a', 'afrique');
INSERT INTO `carto_ACTION` VALUES (1, 'continent', '2', 1, 'Aller_a', 'namerique');
INSERT INTO `carto_ACTION` VALUES (1, 'continent', '3', 1, 'Aller_a', 'asie');
INSERT INTO `carto_ACTION` VALUES (1, 'continent', '4', 1, 'Aller_a', 'europe');
INSERT INTO `carto_ACTION` VALUES (1, 'continent', '5', 1, 'Aller_a', 'oceanie');
INSERT INTO `carto_ACTION` VALUES (1, 'continent', '6', 1, 'Aller_a', 'samerique');
INSERT INTO `carto_ACTION` VALUES (1, 'continent', '7', 1, 'Aller_a', 'moyenorient');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', '0', 2, 'Recharger', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'al', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'an', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'at', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'ba', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'be', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'bg', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'by', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'ch', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'cy', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'cz', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'de', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'dk', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'ee', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'es', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'fi', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'fr', 2, 'Aller_a', 'france');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'gr', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'hr', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'hu', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'ie', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'is', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'it', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'li', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'lt', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'lu', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'lv', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'mc', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'md', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'mk', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'mt', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'nl', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'no', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'pl', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'pt', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'ro', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'ru', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'se', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'si', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'sk', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'sm', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'ua', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'uk', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'europe', 'yu', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '1', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '10', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '11', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '12', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '13', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '14', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '15', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '16', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '17', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '18', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '19', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '2', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '20', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '21', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '22', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '23', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '24', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '25', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '26', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '27', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '28', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '29', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '3', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '30', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '31', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '32', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '33', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '34', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '35', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '36', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '37', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '38', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '39', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '4', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '40', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '41', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '42', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '43', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '44', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '45', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '46', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '47', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '48', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '49', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '5', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '50', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '51', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '52', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '53', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '54', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '55', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '56', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '57', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '58', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '59', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '6', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '60', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '61', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '62', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '63', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '64', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '65', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '66', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '67', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '68', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '69', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '7', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '70', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '71', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '72', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '73', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '74', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '75', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '76', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '77', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '78', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '79', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '8', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '80', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '81', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '82', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '83', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '84', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '85', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '86', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '87', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '88', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '89', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '9', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '90', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '91', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '92', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '93', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '94', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '95', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '971', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '972', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '973', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '974', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '975', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '976', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '980', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '986', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '987', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '988', 4, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'france', '99', 4, 'Recharger', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', '0', 2, 'Recharger', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'ae', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'af', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'am', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'az', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'bh', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'ge', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'il', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'iq', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'ir', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'jo', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'kg', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'kw', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'lb', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'om', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'pk', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'ps', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'qa', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'sa', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'sy', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'tj', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'tm', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'tr', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'uz', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'moyenorient', 'ye', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', '0', 2, 'Recharger', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'ag', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'bb', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'bs', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'bz', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'ca', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'cr', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'cu', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'dm', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'gd', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'gl', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'gt', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'hn', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'ht', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'jm', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'lc', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'mx', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'ni', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'pa', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'sv', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'tt', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'us', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'namerique', 'vc', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', '0', 2, 'Recharger', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'au', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'fj', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'fm', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'ki', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'mh', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'nr', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'nz', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'pg', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'pw', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'sb', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'to', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'tv', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'vu', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'oceanie', 'ws', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', '0', 2, 'Recharger', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 'ar', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 'bo', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 'br', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 'cl', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 'co', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 'ec', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 'gy', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 'pe', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 'py', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 'sr', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 'uy', 2, 'Stop', '');
INSERT INTO `carto_ACTION` VALUES (1, 'samerique', 've', 2, 'Stop', '');

# --------------------------------------------------------

#
# Structure de la table `carto_CONTINENT`
#

CREATE TABLE `carto_CONTINENT` (
  `CC_ID_Continent` tinyint(4) unsigned NOT NULL default '0',
  `CC_Intitule_continent` varchar(100) NOT NULL default '',
  `CC_Couleur_R` tinyint(4) unsigned NOT NULL default '0',
  `CC_Couleur_V` tinyint(4) unsigned NOT NULL default '0',
  `CC_Couleur_B` tinyint(4) unsigned NOT NULL default '0'
);

#
# Contenu de la table `carto_CONTINENT`
#

INSERT INTO `carto_CONTINENT` VALUES (1, 'Afrique', 60, 174, 15);
INSERT INTO `carto_CONTINENT` VALUES (2, 'Amérique du Nord', 128, 218, 141);
INSERT INTO `carto_CONTINENT` VALUES (3, 'Asie', 189, 179, 25);
INSERT INTO `carto_CONTINENT` VALUES (4, 'Europe', 0, 128, 218);
INSERT INTO `carto_CONTINENT` VALUES (5, 'Océanie', 206, 0, 0);
INSERT INTO `carto_CONTINENT` VALUES (6, 'Amérique du Sud', 255, 125, 0);
INSERT INTO `carto_CONTINENT` VALUES (7, 'Moyen-Orient', 0, 0, 255);
INSERT INTO `carto_CONTINENT` VALUES (0, '&nbsp;', 255, 255, 255);

# --------------------------------------------------------

#
# Structure de la table `carto_DEPARTEMENT`
#

CREATE TABLE `carto_DEPARTEMENT` (
  `CD_ID_Departement` smallint(3) unsigned NOT NULL default '0',
  `CD_Intitule_departement` varchar(100) NOT NULL default '',
  `CD_Couleur_R` tinyint(3) unsigned NOT NULL default '0',
  `CD_Couleur_V` tinyint(3) unsigned NOT NULL default '0',
  `CD_Couleur_B` tinyint(3) unsigned NOT NULL default '0',
  `CD_ID_Region` int(10) unsigned NOT NULL default '0',
  `CD_ID_Pays` char(3) NOT NULL default '',
  PRIMARY KEY  (`CD_ID_Departement`)
);

#
# Contenu de la table `carto_DEPARTEMENT`
#

INSERT INTO `carto_DEPARTEMENT` VALUES (1, 'Ain', 0, 204, 51, 22, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (2, 'Aisne', 240, 240, 255, 19, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (3, 'Allier', 255, 125, 125, 3, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (4, 'Alpes-de-Haute-Provence', 51, 51, 153, 21, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (5, 'Hautes-Alpes', 51, 51, 204, 21, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (6, 'Alpes-Maritimes', 51, 51, 102, 21, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (7, 'Ardèche', 0, 102, 51, 22, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (8, 'Ardennes', 0, 255, 0, 8, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (9, 'Ariège', 255, 102, 102, 16, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (10, 'Aube', 50, 255, 50, 8, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (11, 'Aude', 102, 51, 0, 13, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (12, 'Aveyron', 255, 153, 0, 16, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (13, 'Bouches-du-Rhône', 0, 0, 153, 21, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (14, 'Calvados', 150, 150, 255, 4, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (15, 'Cantal', 255, 175, 175, 3, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (16, 'Charente', 175, 255, 175, 20, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (17, 'Charente-Maritime', 150, 255, 150, 20, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (18, 'Cher', 125, 255, 255, 7, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (19, 'Corrèze', 255, 255, 150, 14, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (20, 'Corse', 51, 255, 204, 9, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (21, 'Côte-d\'Or', 50, 151, 255, 5, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (22, 'Côtes-d\'Armor', 75, 75, 255, 6, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (23, 'Creuse', 255, 255, 125, 14, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (24, 'Dordogne', 102, 153, 102, 2, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (25, 'Doubs', 255, 255, 50, 10, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (26, 'Drôme', 1, 51, 51, 22, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (27, 'Eure', 204, 255, 0, 11, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (28, 'Eure-et-Loir', 0, 255, 255, 7, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (29, 'Finistère', 25, 25, 255, 6, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (30, 'Gard', 255, 204, 0, 13, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (31, 'Haute-Garonne', 204, 102, 102, 16, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (32, 'Gers', 204, 153, 51, 16, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (33, 'Gironde', 153, 204, 153, 2, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (34, 'Hérault', 204, 153, 0, 13, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (35, 'Ille-et-Vilaine', 100, 100, 255, 6, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (36, 'Indre', 100, 255, 255, 7, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (37, 'Indre-et-Loire', 75, 255, 255, 7, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (38, 'Isère', 51, 102, 102, 22, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (39, 'Jura', 255, 255, 75, 10, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (40, 'Landes', 153, 255, 153, 2, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (41, 'Loir-et-Cher', 50, 255, 255, 7, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (42, 'Loire', 0, 153, 51, 22, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (43, 'Haute-Loire', 255, 200, 200, 3, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (44, 'Loire-Atlantique', 255, 0, 0, 18, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (45, 'Loiret', 25, 255, 255, 7, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (46, 'Lot', 204, 102, 0, 16, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (47, 'Lot-et-Garonne', 204, 255, 204, 2, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (48, 'Lozére', 153, 102, 0, 13, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (49, 'Maine-et-Loire', 255, 100, 100, 18, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (50, 'Manche', 125, 125, 255, 4, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (51, 'Marne', 25, 255, 25, 8, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (52, 'Haute-Marne', 75, 255, 75, 8, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (53, 'Mayenne', 255, 75, 75, 18, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (54, 'Meurthe-et-Moselle', 102, 0, 102, 15, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (55, 'Meuse', 153, 0, 153, 15, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (56, 'Morbihan', 50, 50, 255, 6, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (57, 'Moselle', 204, 0, 204, 15, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (58, 'Nièvre', 100, 151, 255, 5, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (59, 'Nord', 153, 153, 51, 17, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (60, 'Oise', 225, 225, 255, 19, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (61, 'Orne', 175, 175, 255, 4, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (62, 'Pas-de-Calais', 102, 102, 51, 17, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (63, 'Puy-de-Dôme', 255, 150, 150, 3, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (64, 'Pyrénnées-Atlantiques', 102, 255, 102, 2, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (65, 'Hautes-Pyrénnées', 153, 102, 51, 16, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (66, 'Pyrénnées-Orientales', 51, 51, 0, 13, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (67, 'Bas-Rhin', 204, 204, 51, 1, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (68, 'Haut-Rhin', 153, 153, 0, 1, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (69, 'Rhône', 0, 255, 51, 22, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (70, 'Haute-Saône', 255, 255, 0, 10, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (71, 'Saône-et-Loire', 150, 151, 255, 5, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (72, 'Sarthe', 255, 25, 25, 18, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (73, 'Savoie', 51, 153, 153, 22, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (74, 'Haute-Savoie', 0, 204, 204, 22, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (75, 'Paris', 199, 255, 175, 12, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (76, 'Seine-Maritime', 204, 204, 0, 11, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (77, 'Seine-et-Marne', 199, 255, 75, 12, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (78, 'Yvelines', 199, 255, 25, 12, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (79, 'Deux-Sèvres', 100, 255, 100, 20, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (80, 'Somme', 200, 200, 255, 19, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (81, 'Tarn', 153, 102, 102, 16, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (82, 'Tarn-et-Garonne', 153, 51, 0, 16, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (83, 'Var', 0, 0, 204, 21, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (84, 'Vaucluse', 0, 0, 102, 21, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (85, 'Vendée', 255, 50, 50, 18, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (86, 'Vienne', 125, 255, 125, 20, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (87, 'Haute-Vienne', 255, 255, 100, 14, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (88, 'Vosges', 255, 0, 255, 15, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (89, 'Yonne', 0, 151, 255, 5, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (90, 'Territoire-de-Belfort', 255, 255, 25, 10, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (91, 'Essonne', 199, 255, 50, 12, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (92, 'Hauts-de-Seine', 199, 255, 100, 12, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (93, 'Seine-Saint-Denis', 199, 255, 125, 12, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (94, 'Val-de-Marne', 199, 255, 150, 12, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (95, 'Val-d\'Oise', 199, 255, 0, 12, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (99, 'Etranger', 255, 255, 255, 900, '');
INSERT INTO `carto_DEPARTEMENT` VALUES (971, 'Guadeloupe', 161, 161, 25, 900, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (972, 'Martinique', 161, 161, 125, 900, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (973, 'Guyane', 161, 161, 200, 900, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (974, 'Réunion', 161, 161, 225, 900, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (975, 'St-Pierre-et-Miquelon', 25, 161, 161, 900, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (976, 'Mayotte', 125, 161, 161, 900, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (980, 'Monaco', 1, 1, 1, 900, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (986, 'Wallis-et-Futuna', 200, 161, 161, 900, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (987, 'Polynésie-Française', 225, 161, 161, 900, 'fr');
INSERT INTO `carto_DEPARTEMENT` VALUES (988, 'Nouvelle-Calédonie', 225, 225, 161, 900, 'fr');

# --------------------------------------------------------

#
# Structure de la table `carto_DESCRIPTION_CARTE`
#

CREATE TABLE `carto_DESCRIPTION_CARTE` (
  `CDC_ID_Carte` varchar(32) NOT NULL default '',
  `CDC_Titre_carte` varchar(100) NOT NULL default '',
  `CDC_Infos_carte` mediumblob NOT NULL,
  `CDC_Carte_fond` varchar(100) NOT NULL default '',
  `CDC_Carte_masque` varchar(100) NOT NULL default '',
  `CDC_ID_Zone_geo_carte` varchar(255) NOT NULL default '',
  `CDC_Type_zone_carte` int(10) unsigned NOT NULL default '0',
  `CDC_Type_zone_contenu_carte` int(10) unsigned NOT NULL default '0',
  KEY `CM_PROJECT` (`CDC_ID_Carte`)
);

#
# Contenu de la table `carto_DESCRIPTION_CARTE`
#

INSERT INTO `carto_DESCRIPTION_CARTE` VALUES ('europe', 'Europe', '', 'europe.png', 'europe_masque.png', '4', 1, 2);
INSERT INTO `carto_DESCRIPTION_CARTE` VALUES ('france', 'France', '', 'france_region.png', 'france_masque.png', 'fr', 2, 4);
INSERT INTO `carto_DESCRIPTION_CARTE` VALUES ('continent', 'Monde', '', 'monde5c.png', 'monde_masque5c.png', '', 0, 1);
INSERT INTO `carto_DESCRIPTION_CARTE` VALUES ('afrique', 'Afrique', '', 'afrique.png', 'afrique_masque.png', '1', 1, 2);
INSERT INTO `carto_DESCRIPTION_CARTE` VALUES ('oceanie', 'Océanie', '', 'oceanie.png', 'oceanie_masque.png', '5', 1, 2);
INSERT INTO `carto_DESCRIPTION_CARTE` VALUES ('namerique', 'Amérique du Nord', '', 'namerique.png', 'namerique_masque.png', '2', 1, 2);
INSERT INTO `carto_DESCRIPTION_CARTE` VALUES ('samerique', 'Amérique du Sud', '', 'samerique.png', 'samerique_masque.png', '6', 1, 2);
INSERT INTO `carto_DESCRIPTION_CARTE` VALUES ('asie', 'Asie - Extrême Orient', '', 'asie.png', 'asie_masque.png', '3', 1, 2);
INSERT INTO `carto_DESCRIPTION_CARTE` VALUES ('moyenorient', 'Moyen-Orient', '', 'moyenorient.png', 'moyenorient_masque.png', '7', 1, 2);

# --------------------------------------------------------

#
# Structure de la table `carto_PAYS`
#

CREATE TABLE `carto_PAYS` (
  `CP_ID_Pays` char(3) NOT NULL default '',
  `CP_Langue_intitule` char(3) NOT NULL default '',
  `CP_Intitule_pays` varchar(100) NOT NULL default '',
  `CP_Intitule_capitale` varchar(100) NOT NULL default '',
  `CP_Couleur_R` tinyint(3) unsigned NOT NULL default '0',
  `CP_Couleur_V` tinyint(3) unsigned NOT NULL default '0',
  `CP_Couleur_B` tinyint(3) unsigned NOT NULL default '0',
  `CP_ID_Continent` tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`CP_ID_Pays`)
);

#
# Contenu de la table `carto_PAYS`
#

INSERT INTO `carto_PAYS` VALUES ('af', 'fr', 'Afghanistan', 'Kaboul', 60, 140, 60, 7);
INSERT INTO `carto_PAYS` VALUES ('za', 'fr', 'Afrique du Sud', 'Pretoria', 255, 25, 25, 1);
INSERT INTO `carto_PAYS` VALUES ('al', 'fr', 'Albanie', 'Tirana', 150, 150, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('dz', 'fr', 'Algérie', 'Alger', 255, 25, 75, 1);
INSERT INTO `carto_PAYS` VALUES ('de', 'fr', 'Allemagne', 'Berlin', 255, 75, 75, 4);
INSERT INTO `carto_PAYS` VALUES ('an', 'fr', 'Andorre', 'Andorre la vielle', 51, 51, 51, 4);
INSERT INTO `carto_PAYS` VALUES ('ao', 'fr', 'Angola', 'Luanda', 255, 25, 125, 1);
INSERT INTO `carto_PAYS` VALUES ('ag', 'fr', 'Antigua et Barbuda', 'St Jean', 200, 100, 0, 2);
INSERT INTO `carto_PAYS` VALUES ('sa', 'fr', 'Arabie Saoudite', 'Riyad', 60, 100, 60, 7);
INSERT INTO `carto_PAYS` VALUES ('ar', 'fr', 'Argentine', 'Buenos Aires', 20, 220, 120, 6);
INSERT INTO `carto_PAYS` VALUES ('am', 'fr', 'Arménie', 'Erevan', 60, 180, 60, 7);
INSERT INTO `carto_PAYS` VALUES ('au', 'fr', 'Australie', 'Canberra', 255, 25, 25, 5);
INSERT INTO `carto_PAYS` VALUES ('at', 'fr', 'Autriche', 'Vienne', 179, 179, 179, 4);
INSERT INTO `carto_PAYS` VALUES ('az', 'fr', 'Azerbaïdjan', 'Bakou', 60, 240, 60, 7);
INSERT INTO `carto_PAYS` VALUES ('bs', 'fr', 'Bahamas', 'Nassau', 200, 100, 50, 2);
INSERT INTO `carto_PAYS` VALUES ('bh', 'fr', 'Bahreïn', 'Manama', 140, 0, 0, 7);
INSERT INTO `carto_PAYS` VALUES ('bd', 'fr', 'Bangladesh', 'Dhaka', 140, 40, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('bb', 'fr', 'Barbade', 'Bridgetown', 200, 100, 75, 2);
INSERT INTO `carto_PAYS` VALUES ('be', 'fr', 'Belgique', 'Bruxelles', 204, 204, 204, 4);
INSERT INTO `carto_PAYS` VALUES ('bz', 'fr', 'Bélize', 'Belmopan', 200, 100, 100, 2);
INSERT INTO `carto_PAYS` VALUES ('bj', 'fr', 'Bénin', 'Porto-Novo', 255, 25, 175, 1);
INSERT INTO `carto_PAYS` VALUES ('bt', 'fr', 'Bhoutan', 'Timphou', 140, 80, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('by', 'fr', 'Biélorussie', 'Minsk', 225, 255, 225, 4);
INSERT INTO `carto_PAYS` VALUES ('bo', 'fr', 'Bolivie', 'La Paz', 120, 220, 120, 6);
INSERT INTO `carto_PAYS` VALUES ('ba', 'fr', 'Bosnie-Herzégovine', 'Sarajevo', 255, 25, 25, 4);
INSERT INTO `carto_PAYS` VALUES ('bw', 'fr', 'Botswana', 'Gaborone', 255, 25, 225, 1);
INSERT INTO `carto_PAYS` VALUES ('br', 'fr', 'Brésil', 'Brasillia', 250, 220, 120, 6);
INSERT INTO `carto_PAYS` VALUES ('bn', 'fr', 'Brunei Darusalam', 'Bandar Seri Begawan', 140, 120, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('bg', 'fr', 'Bulgarie', 'Sofia', 75, 75, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('bf', 'fr', 'Burkina Faso', 'Ouagadougou', 255, 150, 25, 1);
INSERT INTO `carto_PAYS` VALUES ('bi', 'fr', 'Burundi', 'Bujumbura', 255, 150, 75, 1);
INSERT INTO `carto_PAYS` VALUES ('kh', 'fr', 'Cambodge', 'Phnom Penh', 140, 140, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('cm', 'fr', 'Cameroun', 'Yaoundé', 255, 150, 125, 1);
INSERT INTO `carto_PAYS` VALUES ('ca', 'fr', 'Canada', 'Ottawa', 200, 100, 125, 2);
INSERT INTO `carto_PAYS` VALUES ('cv', 'fr', 'Cap Vert', 'Praia', 25, 100, 150, 1);
INSERT INTO `carto_PAYS` VALUES ('cl', 'fr', 'Chili', 'Santiago', 220, 20, 120, 6);
INSERT INTO `carto_PAYS` VALUES ('cn', 'fr', 'Chine', 'Pékin', 140, 180, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('cy', 'fr', 'Chypre', 'Nicosie', 200, 200, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('co', 'fr', 'Colombie', 'Bogota', 220, 120, 120, 6);
INSERT INTO `carto_PAYS` VALUES ('km', 'fr', 'Comores', 'Moroni', 255, 150, 175, 1);
INSERT INTO `carto_PAYS` VALUES ('cr', 'fr', 'Costa Rica', 'San José', 200, 100, 150, 2);
INSERT INTO `carto_PAYS` VALUES ('ci', 'fr', 'Côte d\'Ivoire', 'Yamoussoukro', 255, 150, 225, 1);
INSERT INTO `carto_PAYS` VALUES ('hr', 'fr', 'Croatie', 'Zaghreb', 255, 225, 225, 4);
INSERT INTO `carto_PAYS` VALUES ('cu', 'fr', 'Cuba', 'La Havane', 200, 100, 175, 2);
INSERT INTO `carto_PAYS` VALUES ('dk', 'fr', 'Danemark', 'Copenhague', 25, 255, 25, 4);
INSERT INTO `carto_PAYS` VALUES ('dj', 'fr', 'Djibouti', 'Djibouti', 255, 250, 25, 1);
INSERT INTO `carto_PAYS` VALUES ('dm', 'fr', 'Dominique', 'Roseau', 200, 100, 250, 2);
INSERT INTO `carto_PAYS` VALUES ('eg', 'fr', 'Egypte', 'Le Caire', 255, 250, 75, 1);
INSERT INTO `carto_PAYS` VALUES ('sv', 'fr', 'Salvador', 'San Salvador', 200, 200, 0, 2);
INSERT INTO `carto_PAYS` VALUES ('ae', 'fr', 'Emirats Arabes Unis', 'Abou Dabi', 140, 220, 0, 7);
INSERT INTO `carto_PAYS` VALUES ('ec', 'fr', 'Equateur', 'Quito', 220, 250, 120, 6);
INSERT INTO `carto_PAYS` VALUES ('er', 'fr', 'Erythrée', 'Asmara', 255, 250, 125, 1);
INSERT INTO `carto_PAYS` VALUES ('es', 'fr', 'Espagne', 'Madrid', 102, 102, 102, 4);
INSERT INTO `carto_PAYS` VALUES ('ee', 'fr', 'Estonie', 'Tallin', 125, 255, 125, 4);
INSERT INTO `carto_PAYS` VALUES ('us', 'fr', 'Etats-Unis', 'Washington', 200, 200, 100, 2);
INSERT INTO `carto_PAYS` VALUES ('et', 'fr', 'Ethiopie', 'Addis-Abeba', 255, 250, 175, 1);
INSERT INTO `carto_PAYS` VALUES ('fj', 'fr', 'Fidji', 'Suva', 255, 25, 75, 5);
INSERT INTO `carto_PAYS` VALUES ('fi', 'fr', 'Finlande', 'Helsinki', 100, 255, 100, 4);
INSERT INTO `carto_PAYS` VALUES ('fr', 'fr', 'France', 'Paris', 77, 77, 77, 4);
INSERT INTO `carto_PAYS` VALUES ('ga', 'fr', 'Gabon', 'Libreville', 25, 50, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('gm', 'fr', 'Gambie', 'Banjul', 75, 50, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('ge', 'fr', 'Géorgie', 'T\'billisi', 170, 15, 50, 7);
INSERT INTO `carto_PAYS` VALUES ('gh', 'fr', 'Ghana', 'Accra', 125, 50, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('gr', 'fr', 'Grèce', 'Athènes', 175, 175, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('gd', 'fr', 'Grenade', 'Saint-Georges', 200, 200, 125, 2);
INSERT INTO `carto_PAYS` VALUES ('gl', 'fr', 'Groenland', 'Nuuk', 200, 200, 250, 2);
INSERT INTO `carto_PAYS` VALUES ('gt', 'fr', 'Guatémala', 'Guatemala', 0, 100, 200, 2);
INSERT INTO `carto_PAYS` VALUES ('gw', 'fr', 'Guinée Bissau', 'Bissau', 175, 50, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('gq', 'fr', 'Guinée équatoriale', 'Malabo', 225, 50, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('gy', 'fr', 'Guyana', 'Georgetown', 20, 0, 160, 6);
INSERT INTO `carto_PAYS` VALUES ('ht', 'fr', 'Haïti', 'Port au Prince', 50, 100, 200, 2);
INSERT INTO `carto_PAYS` VALUES ('hn', 'fr', 'Honduras', 'Tegucigalpa', 75, 100, 200, 2);
INSERT INTO `carto_PAYS` VALUES ('hu', 'fr', 'Hongrie', 'Budapest', 255, 175, 175, 4);
INSERT INTO `carto_PAYS` VALUES ('in', 'fr', 'Inde', 'New Delhi', 255, 0, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('id', 'fr', 'Indonésie', 'Jakarta', 255, 40, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('iq', 'fr', 'Irak', 'Bagdad', 255, 80, 0, 7);
INSERT INTO `carto_PAYS` VALUES ('ir', 'fr', 'Iran', 'Téhéran', 255, 120, 0, 7);
INSERT INTO `carto_PAYS` VALUES ('ie', 'fr', 'Irlande', 'Dublin', 0, 255, 0, 4);
INSERT INTO `carto_PAYS` VALUES ('is', 'fr', 'Islande', 'Reykjavik', 255, 50, 50, 4);
INSERT INTO `carto_PAYS` VALUES ('il', 'fr', 'Israël', 'Tel-Aviv', 255, 160, 0, 7);
INSERT INTO `carto_PAYS` VALUES ('it', 'fr', 'Italie', 'Rome', 153, 153, 153, 4);
INSERT INTO `carto_PAYS` VALUES ('jm', 'fr', 'Jamaïque', 'Kingston', 100, 100, 200, 2);
INSERT INTO `carto_PAYS` VALUES ('jp', 'fr', 'Japon', 'Tokyo', 255, 200, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('jo', 'fr', 'Jordanie', 'Amman', 255, 240, 0, 7);
INSERT INTO `carto_PAYS` VALUES ('kz', 'fr', 'Kazakhstan', 'Astana', 0, 100, 255, 3);
INSERT INTO `carto_PAYS` VALUES ('ke', 'fr', 'Kenya', 'Nairobo', 25, 150, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('kg', 'fr', 'Kirghizstan', 'Bichkek', 40, 100, 255, 7);
INSERT INTO `carto_PAYS` VALUES ('ki', 'fr', 'Kiribati', 'Tarawa', 255, 25, 125, 5);
INSERT INTO `carto_PAYS` VALUES ('kw', 'fr', 'Koweït', 'Keweït', 80, 100, 255, 7);
INSERT INTO `carto_PAYS` VALUES ('ls', 'fr', 'Lesotho', 'Maseru', 75, 150, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('lv', 'fr', 'Lettonie', 'Rïga', 150, 255, 150, 4);
INSERT INTO `carto_PAYS` VALUES ('lb', 'fr', 'Liban', 'Beyrouth', 120, 100, 255, 7);
INSERT INTO `carto_PAYS` VALUES ('lr', 'fr', 'Libéria', 'Monrovia', 125, 150, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('ly', 'fr', 'Libye', 'Tripoli', 175, 150, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('li', 'fr', 'Liechtenstein', 'Vaduz', 0, 255, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('lt', 'fr', 'Lituanie', 'Vinius', 175, 255, 175, 4);
INSERT INTO `carto_PAYS` VALUES ('lu', 'fr', 'Luxembourg', 'Luxembourg', 229, 229, 229, 4);
INSERT INTO `carto_PAYS` VALUES ('mk', 'fr', 'Macédoine', 'Skopje', 125, 125, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('mg', 'fr', 'Madagascar', 'Antananarivo', 225, 150, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('my', 'fr', 'Malaisie', 'Kuala Lumpur', 140, 100, 255, 3);
INSERT INTO `carto_PAYS` VALUES ('mw', 'fr', 'Malawi', 'Lilongwe', 25, 250, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('mv', 'fr', 'Maldives', 'Malé', 160, 100, 255, 3);
INSERT INTO `carto_PAYS` VALUES ('ml', 'fr', 'Mali', 'Bamoko', 75, 250, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('mt', 'fr', 'Malte', 'La Valette', 225, 225, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('ma', 'fr', 'Maroc', 'Rabat', 125, 250, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('mh', 'fr', 'Marshall', 'Majuro', 255, 25, 175, 5);
INSERT INTO `carto_PAYS` VALUES ('mu', 'fr', 'Maurice', 'Port-Louis', 175, 250, 255, 1);
INSERT INTO `carto_PAYS` VALUES ('mr', 'fr', 'Mauritanie', 'Nouakchott', 25, 255, 50, 1);
INSERT INTO `carto_PAYS` VALUES ('mx', 'fr', 'Mexique', 'Mexico', 125, 100, 200, 2);
INSERT INTO `carto_PAYS` VALUES ('fm', 'fr', 'Micronésie', 'Palikir', 255, 25, 225, 5);
INSERT INTO `carto_PAYS` VALUES ('md', 'fr', 'Moldavie', 'Chisinau', 25, 25, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('mc', 'fr', 'Monaco', 'Monaco', 50, 255, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('mn', 'fr', 'Mongolie', 'Oulan-Bator', 180, 100, 255, 3);
INSERT INTO `carto_PAYS` VALUES ('mz', 'fr', 'Mozambique', 'Maputo', 75, 255, 50, 1);
INSERT INTO `carto_PAYS` VALUES ('na', 'fr', 'Namibie', 'Windhoek', 125, 255, 50, 1);
INSERT INTO `carto_PAYS` VALUES ('nr', 'fr', 'Nauru', 'Yaren District', 255, 75, 25, 5);
INSERT INTO `carto_PAYS` VALUES ('np', 'fr', 'Népal', 'Kathmandou', 200, 100, 255, 3);
INSERT INTO `carto_PAYS` VALUES ('ni', 'fr', 'Nicaragua', 'Managua', 150, 100, 200, 2);
INSERT INTO `carto_PAYS` VALUES ('ne', 'fr', 'Niger', 'Niamey', 175, 255, 50, 1);
INSERT INTO `carto_PAYS` VALUES ('ng', 'fr', 'Nigéria', 'Abuja', 225, 255, 50, 1);
INSERT INTO `carto_PAYS` VALUES ('no', 'fr', 'Norvège', 'Oslo', 50, 255, 50, 4);
INSERT INTO `carto_PAYS` VALUES ('nz', 'fr', 'Nouvelle-Zélande', 'Wellington', 255, 75, 75, 5);
INSERT INTO `carto_PAYS` VALUES ('om', 'fr', 'Oman', 'Mascate', 220, 100, 255, 7);
INSERT INTO `carto_PAYS` VALUES ('ug', 'fr', 'Ouganda', 'Kampala', 25, 255, 150, 1);
INSERT INTO `carto_PAYS` VALUES ('uz', 'fr', 'Ouzbekistan', 'Tachkent', 240, 100, 255, 7);
INSERT INTO `carto_PAYS` VALUES ('pk', 'fr', 'Pakistan', 'Islamabad', 0, 255, 0, 7);
INSERT INTO `carto_PAYS` VALUES ('pw', 'fr', 'Palau', 'Koror', 255, 75, 125, 5);
INSERT INTO `carto_PAYS` VALUES ('ps', 'fr', 'Palestine', 'Jérusalem', 40, 255, 0, 7);
INSERT INTO `carto_PAYS` VALUES ('pa', 'fr', 'Panama', 'Panama', 175, 100, 200, 2);
INSERT INTO `carto_PAYS` VALUES ('pg', 'fr', 'Papouasie - Nouvelle Guinée', 'Port Moresby', 255, 75, 175, 5);
INSERT INTO `carto_PAYS` VALUES ('py', 'fr', 'Paraguay', 'Assomption', 20, 120, 160, 6);
INSERT INTO `carto_PAYS` VALUES ('nl', 'fr', 'Pays-Bas', 'Amsterdam', 245, 245, 245, 4);
INSERT INTO `carto_PAYS` VALUES ('pe', 'fr', 'Pérou', 'Lima', 20, 160, 160, 6);
INSERT INTO `carto_PAYS` VALUES ('ph', 'fr', 'Philippines', 'Manille', 80, 255, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('pl', 'fr', 'Pologne', 'Varsovie', 255, 100, 100, 4);
INSERT INTO `carto_PAYS` VALUES ('pt', 'fr', 'Portugal', 'Lisbonne', 26, 26, 26, 4);
INSERT INTO `carto_PAYS` VALUES ('qa', 'fr', 'Qatar', 'Doha', 120, 255, 0, 7);
INSERT INTO `carto_PAYS` VALUES ('cf', 'fr', 'République Centrafricaine', 'Bangui', 75, 255, 150, 1);
INSERT INTO `carto_PAYS` VALUES ('kr', 'fr', 'République de Corée', 'Séoul', 140, 255, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('cd', 'fr', 'République Démocratique du Congo', 'Kinshasa', 125, 255, 150, 1);
INSERT INTO `carto_PAYS` VALUES ('kp', 'fr', 'République Populaire Démocratique de Corée', 'Pyongyang', 180, 255, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('cz', 'fr', 'République Tchèque', 'Prague', 255, 125, 125, 4);
INSERT INTO `carto_PAYS` VALUES ('ro', 'fr', 'Roumanie', 'Bucarest', 50, 50, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('uk', 'fr', 'Royaume-Uni', 'Londres', 255, 0, 0, 4);
INSERT INTO `carto_PAYS` VALUES ('ru', 'fr', 'Russie', 'Moscou', 200, 255, 200, 4);
INSERT INTO `carto_PAYS` VALUES ('rw', 'fr', 'Rwanda', 'Kigali', 175, 255, 150, 1);
INSERT INTO `carto_PAYS` VALUES ('sm', 'fr', 'San Marin', 'Saint marin', 25, 255, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('vc', 'fr', 'Saint Vincent et les Grenadines', 'Kingston', 200, 100, 200, 2);
INSERT INTO `carto_PAYS` VALUES ('lc', 'fr', 'Sainte Lucie', 'Castries', 0, 100, 100, 2);
INSERT INTO `carto_PAYS` VALUES ('sb', 'fr', 'Salomon', 'Honiara', 255, 75, 225, 5);
INSERT INTO `carto_PAYS` VALUES ('ws', 'fr', 'Samoa', 'Apia', 255, 125, 25, 5);
INSERT INTO `carto_PAYS` VALUES ('st', 'fr', 'Sao Tomé et Principe', 'Sao Tomé', 25, 255, 250, 1);
INSERT INTO `carto_PAYS` VALUES ('sn', 'fr', 'Sénégal', 'Dakar', 75, 255, 250, 1);
INSERT INTO `carto_PAYS` VALUES ('sc', 'fr', 'Seychelles', 'Victoria', 100, 255, 250, 1);
INSERT INTO `carto_PAYS` VALUES ('sl', 'fr', 'Sierra Leone', 'Freetown', 125, 255, 250, 1);
INSERT INTO `carto_PAYS` VALUES ('sg', 'fr', 'Singapour', 'Singapour', 200, 255, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('sk', 'fr', 'Slovaquie', 'Bratislava', 255, 150, 150, 4);
INSERT INTO `carto_PAYS` VALUES ('si', 'fr', 'Slovénie', 'Ljubljana', 255, 200, 200, 4);
INSERT INTO `carto_PAYS` VALUES ('so', 'fr', 'Somalie', 'Mogadiscio', 175, 255, 250, 1);
INSERT INTO `carto_PAYS` VALUES ('sd', 'fr', 'Soudan', 'Khartoum', 151, 151, 25, 1);
INSERT INTO `carto_PAYS` VALUES ('lk', 'fr', 'Sri Lanka', 'Sri Jayawardhanapura', 220, 255, 0, 3);
INSERT INTO `carto_PAYS` VALUES ('se', 'fr', 'Suède', 'Stokholm', 75, 255, 75, 4);
INSERT INTO `carto_PAYS` VALUES ('ch', 'fr', 'Suisse', 'Berne', 128, 128, 128, 4);
INSERT INTO `carto_PAYS` VALUES ('sr', 'fr', 'Surinam', 'Paramaribo', 20, 160, 250, 6);
INSERT INTO `carto_PAYS` VALUES ('sz', 'fr', 'Swaziland', 'Mbabe', 151, 151, 75, 1);
INSERT INTO `carto_PAYS` VALUES ('sy', 'fr', 'Syrie', 'Damas', 240, 255, 0, 7);
INSERT INTO `carto_PAYS` VALUES ('tj', 'fr', 'Tadjikistan', 'Douchanbé', 0, 100, 50, 7);
INSERT INTO `carto_PAYS` VALUES ('tz', 'fr', 'Tanzanie', 'Dar es Salaam', 151, 151, 125, 1);
INSERT INTO `carto_PAYS` VALUES ('td', 'fr', 'Tchad', 'Ndjamena', 151, 151, 175, 1);
INSERT INTO `carto_PAYS` VALUES ('th', 'fr', 'Thaïlande', 'Bangkok', 50, 100, 50, 3);
INSERT INTO `carto_PAYS` VALUES ('tg', 'fr', 'Togo', 'Lomé', 151, 151, 225, 1);
INSERT INTO `carto_PAYS` VALUES ('to', 'fr', 'Tonga', 'Nuku\'alofa', 25, 125, 225, 5);
INSERT INTO `carto_PAYS` VALUES ('tt', 'fr', 'Trinité et Tobago', 'Port d\'Espagne', 75, 100, 100, 2);
INSERT INTO `carto_PAYS` VALUES ('tn', 'fr', 'Tunisie', 'Tunis', 25, 151, 151, 1);
INSERT INTO `carto_PAYS` VALUES ('tm', 'fr', 'Turkmenistan', 'Asgabad', 100, 100, 50, 7);
INSERT INTO `carto_PAYS` VALUES ('tr', 'fr', 'Turquie', 'Ankara', 150, 100, 50, 7);
INSERT INTO `carto_PAYS` VALUES ('tv', 'fr', 'Tuvalu', 'Funafuti', 25, 175, 25, 5);
INSERT INTO `carto_PAYS` VALUES ('ua', 'fr', 'Ukraine', 'Kiev', 0, 0, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('uy', 'fr', 'Uruguay', 'Montevideo', 220, 220, 60, 6);
INSERT INTO `carto_PAYS` VALUES ('vu', 'fr', 'Vanuatu', 'Port-Vila', 255, 125, 175, 5);
INSERT INTO `carto_PAYS` VALUES ('ve', 'fr', 'Vénézuéla', 'Caracas', 220, 60, 60, 6);
INSERT INTO `carto_PAYS` VALUES ('vn', 'fr', 'Vietnam', 'Hanoï', 200, 100, 50, 3);
INSERT INTO `carto_PAYS` VALUES ('ye', 'fr', 'Yémen', 'Sanaa', 250, 100, 50, 7);
INSERT INTO `carto_PAYS` VALUES ('yu', 'fr', 'Yougoslavie', 'Belgrade', 100, 100, 255, 4);
INSERT INTO `carto_PAYS` VALUES ('zm', 'fr', 'Zambie', 'Lusaka', 75, 151, 151, 1);
INSERT INTO `carto_PAYS` VALUES ('zw', 'fr', 'Zimbabwe', 'Harare', 225, 151, 151, 1);
INSERT INTO `carto_PAYS` VALUES ('cg', 'fr', 'Congo', 'Brazzaville', 175, 151, 151, 1);
INSERT INTO `carto_PAYS` VALUES ('gn', 'fr', 'Guinée', 'Conakry', 125, 151, 151, 1);
INSERT INTO `carto_PAYS` VALUES ('la', 'fr', 'Laos', 'Vientiane', 160, 200, 250, 3);
INSERT INTO `carto_PAYS` VALUES ('mm', 'fr', 'Birmanie', 'Rangoon', 210, 200, 250, 3);
INSERT INTO `carto_PAYS` VALUES ('rua', 'fr', 'Russie (Asie)', 'Moscou', 0, 125, 125, 3);
INSERT INTO `carto_PAYS` VALUES ('tw', 'fr', 'Taïwan', 'Taïpei', 0, 200, 250, 3);
INSERT INTO `carto_PAYS` VALUES ('0', '', '&nbsp;', '&nbsp;', 255, 255, 255, 0);

# --------------------------------------------------------

#
# Structure de la table `carto_PROJET`
#

CREATE TABLE `carto_PROJET` (
  `CP_ID_Projet` int(10) unsigned NOT NULL default '0',
  `CP_Nom_projet` varchar(100) NOT NULL default '',
  `CP_Description_projet` text,
  PRIMARY KEY  (`CP_ID_Projet`)
);

#
# Contenu de la table `carto_PROJET`
#

INSERT INTO `carto_PROJET` VALUES (1, 'Actions génériques', 'La carte des continents appelle les cartes des pays de chaque continent. La carte du continent Europe appelle la carte des départements français pour le pays \'fr\'.');

# --------------------------------------------------------

#
# Structure de la table `carto_REGION`
#

CREATE TABLE `carto_REGION` (
  `CR_ID_Region` int(11) NOT NULL default '0',
  `CR_Intitule_region` varchar(100) NOT NULL default '',
  `CR_Couleur_R` tinyint(3) unsigned NOT NULL default '0',
  `CR_Couleur_V` tinyint(3) unsigned NOT NULL default '0',
  `CR_Couleur_B` tinyint(3) unsigned NOT NULL default '0',
  `CR_ID_Pays` char(3) NOT NULL default '',
  PRIMARY KEY  (`CR_ID_Region`)
);

#
# Contenu de la table `carto_REGION`
#

INSERT INTO `carto_REGION` VALUES (1, 'Alsace', 51, 153, 153, 'fr');
INSERT INTO `carto_REGION` VALUES (2, 'Aquitaine', 51, 51, 204, 'fr');
INSERT INTO `carto_REGION` VALUES (3, 'Auvergne', 51, 51, 153, 'fr');
INSERT INTO `carto_REGION` VALUES (4, 'Basse-Normandie', 102, 102, 255, 'fr');
INSERT INTO `carto_REGION` VALUES (5, 'Bourgogne', 0, 204, 204, 'fr');
INSERT INTO `carto_REGION` VALUES (6, 'Bretagne', 102, 102, 204, 'fr');
INSERT INTO `carto_REGION` VALUES (7, 'Centre', 51, 204, 102, 'fr');
INSERT INTO `carto_REGION` VALUES (8, 'Champagne-Ardenne', 153, 255, 255, 'fr');
INSERT INTO `carto_REGION` VALUES (9, 'Corse', 0, 0, 102, 'fr');
INSERT INTO `carto_REGION` VALUES (10, 'Franche-Comté', 0, 102, 102, 'fr');
INSERT INTO `carto_REGION` VALUES (11, 'Haute-Normandie', 153, 153, 255, 'fr');
INSERT INTO `carto_REGION` VALUES (12, 'Ile-de-France', 0, 102, 51, 'fr');
INSERT INTO `carto_REGION` VALUES (13, 'Languedoc-Roussillon', 0, 0, 204, 'fr');
INSERT INTO `carto_REGION` VALUES (14, 'Limousin', 51, 51, 102, 'fr');
INSERT INTO `carto_REGION` VALUES (15, 'Lorraine', 102, 204, 204, 'fr');
INSERT INTO `carto_REGION` VALUES (16, 'Midi-Pyrénnées', 51, 51, 255, 'fr');
INSERT INTO `carto_REGION` VALUES (17, 'Nord-Pas-de-Calais', 153, 204, 204, 'fr');
INSERT INTO `carto_REGION` VALUES (18, 'Pays-de-la-Loire', 102, 102, 153, 'fr');
INSERT INTO `carto_REGION` VALUES (19, 'Picardie', 153, 153, 204, 'fr');
INSERT INTO `carto_REGION` VALUES (20, 'Poitou-Charentes', 102, 102, 102, 'fr');
INSERT INTO `carto_REGION` VALUES (21, 'Provence-Alpes-Côte-d\'Azur', 0, 0, 153, 'fr');
INSERT INTO `carto_REGION` VALUES (22, 'Rhône-Alpes', 0, 0, 255, 'fr');
INSERT INTO `carto_REGION` VALUES (900, '&nbsp;', 255, 255, 255, '');

# --------------------------------------------------------

#
# Structure de la table `carto_TYPE_ZONE`
#

CREATE TABLE `carto_TYPE_ZONE` (
  `CTZ_ID_Type_zone` int(11) NOT NULL default '0',
  `CTZ_Intitule_type_zone` varchar(100) NOT NULL default '',
  `CTZ_Nom_table` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`CTZ_ID_Type_zone`)
);

#
# Contenu de la table `carto_TYPE_ZONE`
#

INSERT INTO `carto_TYPE_ZONE` VALUES (1, 'Continent', 'carto_COULEUR_CONTINENT');
INSERT INTO `carto_TYPE_ZONE` VALUES (2, 'Pays', 'carto_COULEUR_PAYS');
INSERT INTO `carto_TYPE_ZONE` VALUES (3, 'Région', 'carto_COULEUR_REGION');
INSERT INTO `carto_TYPE_ZONE` VALUES (4, 'Département', 'carto_COULEUR_DEPARTEMENT');
INSERT INTO `carto_TYPE_ZONE` VALUES (0, 'Monde', '');

# --------------------------------------------------------

#
# Structure de la table `carto_communes`
#

CREATE TABLE `carto_communes` (
  `cc_code_insee` int(10) unsigned NOT NULL default '0',
  `cc_code_couleur_rouge` tinyint(3) unsigned NOT NULL default '0',
  `cc_code_couleur_vert` tinyint(3) unsigned NOT NULL default '0',
  `cc_code_couleur_bleu` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cc_code_insee`)
);

#
# Contenu de la table `carto_communes`
#


# --------------------------------------------------------

CREATE TABLE `carto_config` (
  `cc_menu_id` int(11) NOT NULL default '0',
  `cc_titre_carto` varchar(255) NOT NULL,
  `cc_table1` varchar(255) NOT NULL default '',
  `cc_table2` varchar(255) NOT NULL default '',
  `cc_pays` varchar(255) NOT NULL,
  `cc_cp` varchar(255) NOT NULL,
  `cc_sql` text NOT NULL,
  `cc_ce_premiere_carte` int(11) NOT NULL,
  PRIMARY KEY  (`cc_menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `carto_config`
-- 

INSERT INTO `carto_config` (`cc_menu_id`, `cc_titre_carto`, `cc_table1`, `cc_table2`, `cc_pays`, `cc_cp`, `cc_sql`, `cc_ce_premiere_carte`) VALUES (12, 'hghg', 'annuaire', '0', 'a_ce_pays', 'a_code_postal', '', 1);


CREATE TABLE `carto_zone_hierarchie` (
  `czh_id_zone` int(10) unsigned NOT NULL,
  `czh_id_zone_pere` int(10) unsigned NOT NULL,
  `czh_nom` varchar(255) NOT NULL,
  `czh_code_alpha` varchar(255) NOT NULL,
  `czh_i18n` varchar(5) NOT NULL,
  `czh_fichier_masque` varchar(255) NOT NULL,
  `czh_fichier_image` varchar(255) NOT NULL,
  `czh_coloration` tinyint(1) NOT NULL,
  `czh_nom_table_info_couleur` varchar(255) NOT NULL,
  `czh_identifiant_table_info_couleur` varchar(255) NOT NULL,
  `czh_champs_jointure_annuaire` varchar(255) NOT NULL,
  `czh_sql_complementaire` varchar(255) NOT NULL,
  `czh_nom_champs_id` varchar(255) NOT NULL,
  `czh_nom_champs_id_pere` varchar(255) NOT NULL,
  `czh_nom_champs_intitule` varchar(255) NOT NULL,
  `czh_nom_champs_couleur_R` varchar(255) NOT NULL,
  `czh_nom_champs_couleur_V` varchar(255) NOT NULL,
  `czh_nom_champs_couleur_B` varchar(255) NOT NULL,
  PRIMARY KEY  (`czh_id_zone`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# Contenu de la table `carto_zone_hierarchie`
#

INSERT INTO `carto_zone_hierarchie` VALUES (1, 0, 'Monde', 'continent', 'fr-FR', 'monde_masque5c.png', 'monde5c.png', 1, 'carto_CONTINENT', '', 'a_ce_continent', '', 'CC_ID_Continent', '', 'CC_Intitule_continent', 'CC_Couleur_R', 'CC_Couleur_V', 'CC_Couleur_B');
INSERT INTO `carto_zone_hierarchie` VALUES (2, 1, 'Europe', 'europe', 'fr-FR', 'europe_masque.png', 'europe.png', 1, 'carto_PAYS', '4', 'a_ce_pays', '', 'CP_ID_Pays', 'CP_ID_Continent', 'CP_Intitule_pays', 'CP_Couleur_R', 'CP_Couleur_V', 'CP_Couleur_B');
INSERT INTO `carto_zone_hierarchie` VALUES (3, 2, 'France', 'france', 'fr-FR', 'france_masque.png', 'france.png', 1, 'carto_DEPARTEMENT', 'fr', 'bfvl_valeur', 'france.bfvl_ce_liste=19 and france.bfvl_ce_fiche=bf_id_fiche', 'CD_ID_Departement', 'CD_ID_Pays', 'CD_Intitule_departement', 'CD_Couleur_R', 'CD_Couleur_V', 'CD_Couleur_B');
INSERT INTO `carto_zone_hierarchie` VALUES (4, 3, 'Drôme', 'drome', 'fr-FR', 'carte_drome_masque.png', 'carte_drome.png', 1, 'carto_DROME', '26', 'bfvl_valeur', 'drome.bfvl_ce_liste=29 and drome.bfvl_ce_fiche=bf_id_fiche', 'cd_id', 'cd_id_pays', 'cd_nom', 'cd_rouge', 'cd_vert', 'cd_bleu');
    