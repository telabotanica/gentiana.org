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
  `a_lettre` tinyint(3) unsigned NOT NULL default '0',
  `a_site_internet` varchar(255) default NULL,
  `a_voir_sur_carto` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`a_id`)
) ;
CREATE TABLE `inscription_demande` (
  `id_identifiant_session` varchar(32) NOT NULL default '',
  `id_donnees` text NOT NULL,
  `id_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id_identifiant_session`)
) ;

-- Table pour faire des inscriptions avec wikini
-- OPTIONNELLE
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `gen_departement` (
  `gd_id_departement` int(11) NOT NULL default '0',
  `gd_nom` varchar(100) NOT NULL default '',
  `gd_region` int(11) NOT NULL default '900',
  PRIMARY KEY  (`gd_id_departement`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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


CREATE TABLE `gen_i18n_pays` (
  `gip_id_pays` char(2) NOT NULL default '',
  `gip_id_i18n` varchar(8) NOT NULL default '',
  `gip_nom_pays_traduit` varchar(255) default NULL,
  PRIMARY KEY  (`gip_id_pays`,`gip_id_i18n`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `gen_i18n_pays`
-- 

INSERT INTO `gen_i18n_pays` VALUES ('DE', 'fr-FR', 'Allemagne');
INSERT INTO `gen_i18n_pays` VALUES ('BG', 'fr-FR', 'Bulgarie');
INSERT INTO `gen_i18n_pays` VALUES ('CY', 'fr-FR', 'Chypre');
INSERT INTO `gen_i18n_pays` VALUES ('DK', 'fr-FR', 'Danemark');
INSERT INTO `gen_i18n_pays` VALUES ('ES', 'fr-FR', 'Espagne');
INSERT INTO `gen_i18n_pays` VALUES ('EE', 'fr-FR', 'Estonie');
INSERT INTO `gen_i18n_pays` VALUES ('FI', 'fr-FR', 'Finlande');
INSERT INTO `gen_i18n_pays` VALUES ('FR', 'fr-FR', 'France');
INSERT INTO `gen_i18n_pays` VALUES ('GR', 'fr-FR', 'Grèce');
INSERT INTO `gen_i18n_pays` VALUES ('HU', 'fr-FR', 'Hongrie');
INSERT INTO `gen_i18n_pays` VALUES ('IE', 'fr-FR', 'Irlande');
INSERT INTO `gen_i18n_pays` VALUES ('IT', 'fr-FR', 'Italie');
INSERT INTO `gen_i18n_pays` VALUES ('LV', 'fr-FR', 'Lettonie');
INSERT INTO `gen_i18n_pays` VALUES ('LT', 'fr-FR', 'Lituanie');
INSERT INTO `gen_i18n_pays` VALUES ('LU', 'fr-FR', 'Luxembourg');
INSERT INTO `gen_i18n_pays` VALUES ('NL', 'fr-FR', 'Pays-Bas');
INSERT INTO `gen_i18n_pays` VALUES ('PL', 'fr-FR', 'Pologne');
INSERT INTO `gen_i18n_pays` VALUES ('PT', 'fr-FR', 'Portugal');
INSERT INTO `gen_i18n_pays` VALUES ('CZ', 'fr-FR', 'République Tchèque');
INSERT INTO `gen_i18n_pays` VALUES ('RO', 'fr-FR', 'Roumanie');
INSERT INTO `gen_i18n_pays` VALUES ('UK', 'fr-FR', 'Royaume-Uni');
INSERT INTO `gen_i18n_pays` VALUES ('SK', 'fr-FR', 'Slovaquie');
INSERT INTO `gen_i18n_pays` VALUES ('SI', 'fr-FR', 'Slovénie');
INSERT INTO `gen_i18n_pays` VALUES ('SE', 'fr-FR', 'Suède');
INSERT INTO `gen_i18n_pays` VALUES ('si', 'es-ES', 'Eslovenia');
INSERT INTO `gen_i18n_pays` VALUES ('sk', 'es-ES', 'Eslovaquia');
INSERT INTO `gen_i18n_pays` VALUES ('uk', 'es-ES', 'Reino-Unido');
INSERT INTO `gen_i18n_pays` VALUES ('ro', 'es-ES', 'Rumania');
INSERT INTO `gen_i18n_pays` VALUES ('cz', 'es-ES', 'Rep&uacute;blica Checa');
INSERT INTO `gen_i18n_pays` VALUES ('pt', 'es-ES', 'Portugal');
INSERT INTO `gen_i18n_pays` VALUES ('pl', 'es-ES', 'Polonia');
INSERT INTO `gen_i18n_pays` VALUES ('nl', 'es-ES', 'Pa&iacute;ses Bajos');
INSERT INTO `gen_i18n_pays` VALUES ('lu', 'es-ES', 'Luxemburgo');
INSERT INTO `gen_i18n_pays` VALUES ('lt', 'es-ES', 'Lituania');
INSERT INTO `gen_i18n_pays` VALUES ('lv', 'es-ES', 'Letonia');
INSERT INTO `gen_i18n_pays` VALUES ('it', 'es-ES', 'Italia');
INSERT INTO `gen_i18n_pays` VALUES ('ie', 'es-ES', 'Irlanda');
INSERT INTO `gen_i18n_pays` VALUES ('hu', 'es-ES', 'Hungr&iacute;a');
INSERT INTO `gen_i18n_pays` VALUES ('gr', 'es-ES', 'Grecia');
INSERT INTO `gen_i18n_pays` VALUES ('fr', 'es-ES', 'Francia');
INSERT INTO `gen_i18n_pays` VALUES ('fi', 'es-ES', 'Finlandia');
INSERT INTO `gen_i18n_pays` VALUES ('ee', 'es-ES', 'Estonia');
INSERT INTO `gen_i18n_pays` VALUES ('es', 'es-ES', 'Espa&ntilde;a');
INSERT INTO `gen_i18n_pays` VALUES ('dk', 'es-ES', 'Dinamarca');
INSERT INTO `gen_i18n_pays` VALUES ('cy', 'es-ES', 'Chipre');
INSERT INTO `gen_i18n_pays` VALUES ('bg', 'es-ES', 'Bulgaria');
INSERT INTO `gen_i18n_pays` VALUES ('de', 'es-ES', 'Alemania');
INSERT INTO `gen_i18n_pays` VALUES ('BG', 'en-EN', 'BULGARIA');
INSERT INTO `gen_i18n_pays` VALUES ('CY', 'en-EN', 'CYPRUS');
INSERT INTO `gen_i18n_pays` VALUES ('CZ', 'en-EN', 'CZECH REPUBLIC');
INSERT INTO `gen_i18n_pays` VALUES ('DK', 'en-EN', 'DENMARK');
INSERT INTO `gen_i18n_pays` VALUES ('EE', 'en-EN', 'ESTONIA');
INSERT INTO `gen_i18n_pays` VALUES ('FI', 'en-EN', 'FINLAND');
INSERT INTO `gen_i18n_pays` VALUES ('FR', 'en-EN', 'FRANCE');
INSERT INTO `gen_i18n_pays` VALUES ('DE', 'en-EN', 'GERMANY');
INSERT INTO `gen_i18n_pays` VALUES ('GR', 'en-EN', 'GREECE');
INSERT INTO `gen_i18n_pays` VALUES ('HU', 'en-EN', 'HUNGARY');
INSERT INTO `gen_i18n_pays` VALUES ('IE', 'en-EN', 'IRELAND');
INSERT INTO `gen_i18n_pays` VALUES ('IT', 'en-EN', 'ITALY');
INSERT INTO `gen_i18n_pays` VALUES ('LV', 'en-EN', 'LATVIA');
INSERT INTO `gen_i18n_pays` VALUES ('LT', 'en-EN', 'LITHUANIA');
INSERT INTO `gen_i18n_pays` VALUES ('LU', 'en-EN', 'LUXEMBOURG');
INSERT INTO `gen_i18n_pays` VALUES ('NL', 'en-EN', 'NETHERLANDS');
INSERT INTO `gen_i18n_pays` VALUES ('PL', 'en-EN', 'POLAND');
INSERT INTO `gen_i18n_pays` VALUES ('PT', 'en-EN', 'PORTUGAL');
INSERT INTO `gen_i18n_pays` VALUES ('RO', 'en-EN', 'ROMANIA');
INSERT INTO `gen_i18n_pays` VALUES ('SK', 'en-EN', 'SLOVAKIA (Slovak Republic)');
INSERT INTO `gen_i18n_pays` VALUES ('SI', 'en-EN', 'SLOVENIA');
INSERT INTO `gen_i18n_pays` VALUES ('ES', 'en-EN', 'SPAIN');
INSERT INTO `gen_i18n_pays` VALUES ('SE', 'en-EN', 'SWEDEN');
INSERT INTO `gen_i18n_pays` VALUES ('lu', 'pt-PT', 'Luxemburgo');
INSERT INTO `gen_i18n_pays` VALUES ('lt', 'pt-PT', 'Lituania');
INSERT INTO `gen_i18n_pays` VALUES ('lv', 'pt-PT', 'Letonia');
INSERT INTO `gen_i18n_pays` VALUES ('it', 'pt-PT', 'Italia');
INSERT INTO `gen_i18n_pays` VALUES ('ie', 'pt-PT', 'Irlanda');
INSERT INTO `gen_i18n_pays` VALUES ('hu', 'pt-PT', 'Hungr&iacute;a');
INSERT INTO `gen_i18n_pays` VALUES ('gr', 'pt-PT', 'Grecia');
INSERT INTO `gen_i18n_pays` VALUES ('fr', 'pt-PT', 'Francia');
INSERT INTO `gen_i18n_pays` VALUES ('fi', 'pt-PT', 'Finlandia');
INSERT INTO `gen_i18n_pays` VALUES ('ee', 'pt-PT', 'Estonia');
INSERT INTO `gen_i18n_pays` VALUES ('es', 'pt-PT', 'Espa&ntilde;a');
INSERT INTO `gen_i18n_pays` VALUES ('dk', 'pt-PT', 'Dinamarca');
INSERT INTO `gen_i18n_pays` VALUES ('cy', 'pt-PT', 'Chipre');
INSERT INTO `gen_i18n_pays` VALUES ('bg', 'pt-PT', 'Bulgaria');
INSERT INTO `gen_i18n_pays` VALUES ('de', 'pt-PT', 'Alemania');
INSERT INTO `gen_i18n_pays` VALUES ('se', 'es-ES', 'Suecia');
INSERT INTO `gen_i18n_pays` VALUES ('nl', 'pt-PT', 'Pa&iacute;ses Bajos');
INSERT INTO `gen_i18n_pays` VALUES ('pl', 'pt-PT', 'Polonia');
INSERT INTO `gen_i18n_pays` VALUES ('pt', 'pt-PT', 'Portugal');
INSERT INTO `gen_i18n_pays` VALUES ('cz', 'pt-PT', 'Rep&uacute;blica Checa');
INSERT INTO `gen_i18n_pays` VALUES ('ro', 'pt-PT', 'Rumania');
INSERT INTO `gen_i18n_pays` VALUES ('uk', 'pt-PT', 'Reino-Unido');
INSERT INTO `gen_i18n_pays` VALUES ('sk', 'pt-PT', 'Eslovaquia');
INSERT INTO `gen_i18n_pays` VALUES ('si', 'pt-PT', 'Eslovenia');
INSERT INTO `gen_i18n_pays` VALUES ('se', 'pt-PT', 'Suecia');
        
