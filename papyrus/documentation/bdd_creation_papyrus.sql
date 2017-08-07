-- phpMyAdmin SQL Dump
-- version 2.6.0-pl1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Jeudi 14 Octobre 2004 à 18:05
-- Version du serveur: 4.0.18
-- Version de PHP: 4.3.4
-- 
-- Base de données: `papyrus`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_annuaire`
-- 

CREATE TABLE `gen_annuaire` (
  `ga_id_administrateur` int(11) unsigned NOT NULL default '0',
  `ga_ce_i18n` varchar(8) NOT NULL default '',
  `ga_nom` varchar(32) NOT NULL default '',
  `ga_prenom` varchar(32) NOT NULL default '',
  `ga_mot_de_passe` varchar(32) NOT NULL default 'X X',
  `ga_mail` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`ga_id_administrateur`),
  KEY `gen_annuaire_FKIndex1` (`ga_ce_i18n`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_annuaire`
-- 

INSERT INTO `gen_annuaire` VALUES (0, '', 'Non renseigné', '', '', '');
INSERT INTO `gen_annuaire` VALUES (1, 'fr-FR', 'Administrateur', 'Super', 'd41d8cd98f00b204e9800998ecf8427e', 'admin@tela-botanica.org');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_application`
-- 

CREATE TABLE `gen_application` (
  `gap_id_application` int(11) unsigned NOT NULL default '0',
  `gap_nom` varchar(100) NOT NULL default '',
  `gap_description` mediumtext NOT NULL,
  `gap_chemin` varchar(255) NOT NULL default '',
  `gap_bool_applette` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`gap_id_application`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_application`
-- 

INSERT INTO `gen_application` VALUES (0, 'Inconnue', 'Pour les menu ne contenant auncune application.', 'inconnu', 0);
INSERT INTO `gen_application` VALUES (1, 'Administrateur des sites', 'Permet de rajouter des sites sur les serveurs.\r\nProchainement permetra de gérer le cache, les squelettes et leurs fichiers CSS et JS.\r\nPermetra aussi de visualiser les statistiques de chaque site.', 'papyrus/applications/admin_site/admin_site.php', 0);
INSERT INTO `gen_application` VALUES (2, 'Administrateur des menus', 'Permet de modifier la hiérarchie et les informations concernant les menus d''un site.\r\n', 'papyrus/applications/admin_menu/admin_menu.php', 0);
INSERT INTO `gen_application` VALUES (3, 'Afficheur', 'L''application standart qui permet d''afficher du contenu XHTML dans les pages.', 'papyrus/applications/afficheur/afficheur.php', 0);
INSERT INTO `gen_application` VALUES (4, 'Plan du site', 'Application affichant le plan d''un site Génésia.', 'papyrus/applications/plan/plan.php', 0);
INSERT INTO `gen_application` VALUES (5, 'Menu classique mono ou multi niveaux', 'Génère une liste de listes correspondant à la hiérarchie des menus.\r\nLa liste dépend des paramètres passés dans la balise.\r\nBalise de type MENU_n_m : affiche tous les menus de niveaux n à m.\r\nExemple :\r\nMENU_1_1 : affiche tous les menus de niveaux 1.\r\nMENU_1_3 : affiche tous les menus de niveaux 1 à 3.', 'papyrus/applettes/menu/menu.php', 1);
INSERT INTO `gen_application` VALUES (6, 'Menu commun', 'Génère une liste de menus communs à l''ensemble du site.', 'papyrus/applettes/menu_commun/menu_commun.php', 1);
INSERT INTO `gen_application` VALUES (7, 'Sélecteur de sites', 'Génère un formulaire permettant de passer de site en site pour une langue donnée.', 'papyrus/applettes/selecteur_sites/selecteur_sites.php', 1);
INSERT INTO `gen_application` VALUES (8, 'Identification', 'Génère un formulaire permettant de s''identifier ou fournissant les informations sur la personne identifiée.', 'papyrus/applettes/identification/identification.php', 1);
INSERT INTO `gen_application` VALUES (9, 'Vous-êtes-ici', 'Affiche  la suite des menus visité, sous forme de lien, pour arriver au menu courant visioné par l''utilisateur.', 'papyrus/applettes/vous_etes_ici/vous_etes_ici.php', 1);
INSERT INTO `gen_application` VALUES (10, 'Annuaire (Front-office)', 'Application affichant l''annuaire.', 'client/bottin/annuaire.php', 0);
INSERT INTO `gen_application` VALUES (11, 'Annuaire (Back-office)', 'Application affichant le back-office de l''annuaire.', 'client/bottin/annuaire_backoffice.php', 0);
-- --------------------------------------------------------

-- 
-- Structure de la table `gen_i18n`
-- 

CREATE TABLE `gen_i18n` (
  `gi_id_i18n` varchar(8) NOT NULL default '',
  `gi_ce_langue` char(2) NOT NULL default '',
  `gi_ce_pays` char(2) NOT NULL default '',
  `gi_jeu_de_caracteres` varchar(50) default NULL,
  `gi_nom` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`gi_id_i18n`),
  KEY `gen_i18n_FKIndex1` (`gi_ce_pays`),
  KEY `gen_i18n_FKIndex2` (`gi_ce_langue`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_i18n`
-- 

INSERT INTO `gen_i18n` VALUES ('fr', 'fr', '', 'iso-8859-15', 'Français');
INSERT INTO `gen_i18n` VALUES ('en', 'en', '', 'iso-8859-15', 'English');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_i18n_langue`
-- 

CREATE TABLE `gen_i18n_langue` (
  `gil_id_langue` char(2) NOT NULL default '',
  `gil_nom` varchar(255) default NULL,
  `gil_direction` varchar(20) default NULL,
  PRIMARY KEY  (`gil_id_langue`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_i18n_langue`
-- 

INSERT INTO `gen_i18n_langue` VALUES ('fr', 'français', 'ltr');
INSERT INTO `gen_i18n_langue` VALUES ('en', 'anglais', 'ltr');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_i18n_pays`
-- 

CREATE TABLE `gen_i18n_pays` (
  `gip_id_pays` char(2) NOT NULL default '',
  `gip_nom` varchar(255) default NULL,
  `gip_fichier_drapeau` varchar(255) default NULL,
  PRIMARY KEY  (`gip_id_pays`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_i18n_pays`
-- 

INSERT INTO `gen_i18n_pays` VALUES ('FR', 'France', 'FR.png');
INSERT INTO `gen_i18n_pays` VALUES ('UK', 'Royaume-Uni', 'UK.png');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_menu`
-- 

CREATE TABLE `gen_menu` (
  `gm_id_menu` int(11) unsigned NOT NULL default '0',
  `gm_ce_i18n` varchar(8) NOT NULL default '',
  `gm_ce_site` int(11) unsigned NOT NULL default '0',
  `gm_ce_application` int(11) unsigned NOT NULL default '0',
  `gm_application_arguments` varchar(255) default NULL,
  `gm_fichier_squelette` varchar(255) default NULL,
  `gm_code_num` int(11) NOT NULL default '0',
  `gm_code_alpha` varchar(20) NOT NULL default '',
  `gm_nom` varchar(100) default NULL,
  `gm_raccourci_clavier` char(1) default NULL,
  `gm_robot` varchar(100) default 'index,follow',
  `gm_titre` varchar(255) default NULL,
  `gm_titre_alternatif` varchar(255) default NULL,
  `gm_mots_cles` text,
  `gm_description_libre` text,
  `gm_description_resume` text,
  `gm_description_table_matieres` text,
  `gm_source` varchar(255) default NULL,
  `gm_auteur` varchar(255) default NULL,
  `gm_contributeur` text,
  `gm_editeur` text,
  `gm_date_creation` datetime default NULL,
  `gm_date_soumission` datetime default NULL,
  `gm_date_acceptation` datetime default NULL,
  `gm_date_publication` datetime default NULL,
  `gm_date_debut_validite` datetime default NULL,
  `gm_date_fin_validite` datetime default NULL,
  `gm_date_copyright` datetime default NULL,
  `gm_licence` varchar(255) default NULL,
  `gm_categorie` varchar(100) default NULL,
  `gm_public` varchar(255) default NULL,
  `gm_public_niveau` varchar(45) default NULL,
  `gm_ce_type_portee_spatiale` int(11) unsigned default NULL,
  `gm_portee_spatiale` varchar(100) default NULL,
  `gm_ce_type_portee_temporelle` int(11) unsigned default NULL,
  `gm_portee_temporelle` varchar(100) default NULL,
  `gm_ce_admin` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`gm_id_menu`),
  KEY `gen_menu_FKIndex2` (`gm_ce_admin`),
  KEY `gen_menu_FKIndex3` (`gm_ce_application`),
  KEY `gen_menu_FKIndex4` (`gm_ce_i18n`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_menu`
-- 

INSERT INTO `gen_menu` VALUES (1, 'fr', 1, 0, '', '', 1, 'config', 'Configuration', 'C', 'index,follow', '', '', '', '', 'Configuration des sites de Génésia', '', '', '', '', '', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '', '', '', '', 0, '', 0, '', 0);
INSERT INTO `gen_menu` VALUES (2, 'fr', 1, 1, '', '', 2, 'sites', 'Administration sites', 'S', 'index,follow', 'Administration des sites de Génésia.', '', 'Administration, sites.', 'Interface d''administration des sites de Génésia.', 'Administration des sites de Génésia.', '', '', 'Tela Botanica', '', 'Tela Botanica', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', 0, '', 0, '', 0);
INSERT INTO `gen_menu` VALUES (4, 'fr', 1, 3, '', '', 4, 'aide', 'Aide', '', 'index,follow', 'Aide des interfaces de Génésia.', '', 'Aide, Génésia.', 'Contient une aide sur les interfaces de Génésia.', 'Une aide sur les interfaces de Génésia.', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', NULL, '', NULL, '', 0);
INSERT INTO `gen_menu` VALUES (6, 'fr', 1, 4, '', '', 6, 'plan_genesia', 'Plan du site', '', 'index,follow', 'Plan du site d''administration.', 'Plan du site d''administration', 'plan, administration.', '', 'Plan du site d''administration de Génésia.', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu commun', '', '', NULL, '', NULL, '', 0);
INSERT INTO `gen_menu` VALUES (5, 'fr', 1, 3, '', '', 5, 'accessibilite', 'Chartre d''accessibilité', '', 'index,follow', 'Chartre d''accessibilité de Tela Botanica.', '', 'accessibilité, chartre, handicap.', 'Fournit des informations sur l''accessibilité de ce site.', 'La chartre d''accessibilité de Tela Botanica.', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu commun', '', '', NULL, '', NULL, '', 0);
INSERT INTO `gen_menu` VALUES (3, 'fr', 1, 2, '', '', 3, 'gestion', 'Administration des menus', 'G', 'index,follow', '', '', '', '', 'Gestion des menus des différents sites', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', 0, '', 0, '', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_menu_cache`
-- 

CREATE TABLE `gen_menu_cache` (
  `gmcac_id_md5_url` varchar(32) NOT NULL default '',
  `gmcac_ce_site` int(11) unsigned NOT NULL default '0',
  `gmcac_corps` longblob NOT NULL,
  `gmcac_date_heure` datetime NOT NULL default '0000-00-00 00:00:00',
  `gmcac_taille` int(11) NOT NULL default '0',
  `gmcac_gz_taille` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gmcac_id_md5_url`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_menu_cache`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `gen_menu_categorie`
-- 

CREATE TABLE `gen_menu_categorie` (
  `gmca_id_categorie` int(10) unsigned NOT NULL auto_increment,
  `gmca_intitule_categorie` varchar(255) default NULL,
  PRIMARY KEY  (`gmca_id_categorie`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Contenu de la table `gen_menu_categorie`
-- 

INSERT INTO `gen_menu_categorie` VALUES (1, 'Relation entre menus');
INSERT INTO `gen_menu_categorie` VALUES (2, 'Type de menu');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_menu_categorie_valeur`
-- 

CREATE TABLE `gen_menu_categorie_valeur` (
  `gmcv_id_valeur` int(11) unsigned NOT NULL auto_increment,
  `gmcv_id_categorie` int(10) unsigned NOT NULL default '0',
  `gmcv_intitule_valeur` varchar(255) default NULL,
  PRIMARY KEY  (`gmcv_id_valeur`),
  KEY `gen_menu_categorie_valeur_FKIndex1` (`gmcv_id_categorie`)
) TYPE=MyISAM AUTO_INCREMENT=105 ;

-- 
-- Contenu de la table `gen_menu_categorie_valeur`
-- 

INSERT INTO `gen_menu_categorie_valeur` VALUES (1, 1, 'avoir père');
INSERT INTO `gen_menu_categorie_valeur` VALUES (2, 1, 'avoir traduction');
INSERT INTO `gen_menu_categorie_valeur` VALUES (101, 2, 'défaut');
INSERT INTO `gen_menu_categorie_valeur` VALUES (102, 2, 'commun');
INSERT INTO `gen_menu_categorie_valeur` VALUES (103, 2, 'traduction');
INSERT INTO `gen_menu_categorie_valeur` VALUES (104, 2, 'copyright');
INSERT INTO `gen_menu_categorie_valeur` VALUES (3, 1, 'avoir suivant logique');
INSERT INTO `gen_menu_categorie_valeur` VALUES (4, 1, 'avoir précédent logique');
INSERT INTO `gen_menu_categorie_valeur` VALUES (100, 2, 'menu classique');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_menu_contenu`
-- 

CREATE TABLE `gen_menu_contenu` (
  `gmc_id_contenu` int(11) unsigned NOT NULL default '0',
  `gmc_ce_admin` int(11) unsigned NOT NULL default '0',
  `gmc_ce_menu` int(11) unsigned NOT NULL default '0',
  `gmc_ce_type_contenu` int(11) unsigned default NULL,
  `gmc_contenu` mediumtext,
  `gmc_ce_type_modification` int(11) unsigned default NULL,
  `gmc_resume_modification` varchar(255) default NULL,
  `gmc_date_modification` datetime default NULL,
  `gmc_bool_dernier` tinyint(1) unsigned default '1',
  PRIMARY KEY  (`gmc_id_contenu`),
  KEY `gen_menu_contenu_FKIndex2` (`gmc_ce_menu`),
  KEY `idx_fk_gp_ce_admin` (`gmc_ce_admin`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_menu_contenu`
-- 

INSERT INTO `gen_menu_contenu` VALUES (1, 1, 4, 1, '<h1>Aide</h1>\r\n<p>Ici figurera l''aide de Papyrus!</p>', 2, 'Origine', '2004-10-14 17:57:29', 1);
INSERT INTO `gen_menu_contenu` VALUES (2, 1, 5, 1, '<h1>Accessibilité</h1>\r\n<p>Ici figurera la charte d''accessibilité de Papyrus!</p>', 2, 'Origine', '2004-10-14 17:58:09', 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_menu_relation`
-- 

CREATE TABLE `gen_menu_relation` (
  `gmr_id_menu_01` int(11) unsigned NOT NULL default '0',
  `gmr_id_menu_02` int(11) unsigned NOT NULL default '0',
  `gmr_id_valeur` int(11) unsigned NOT NULL default '0',
  `gmr_ordre` int(11) unsigned default NULL,
  PRIMARY KEY  (`gmr_id_menu_01`,`gmr_id_menu_02`,`gmr_id_valeur`),
  KEY `gen_menu_relation_FKIndex2` (`gmr_id_menu_01`),
  KEY `gen_menu_relation_FKIndex3` (`gmr_id_valeur`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_menu_relation`
-- 

INSERT INTO `gen_menu_relation` VALUES (1, 0, 1, 1);
INSERT INTO `gen_menu_relation` VALUES (2, 1, 1, 1);
INSERT INTO `gen_menu_relation` VALUES (3, 1, 1, 2);
INSERT INTO `gen_menu_relation` VALUES (1, 1, 101, NULL);
INSERT INTO `gen_menu_relation` VALUES (5, 5, 102, 1);
INSERT INTO `gen_menu_relation` VALUES (6, 0, 1, 2);
INSERT INTO `gen_menu_relation` VALUES (4, 4, 100, 4);
INSERT INTO `gen_menu_relation` VALUES (4, 0, 1, 5);
INSERT INTO `gen_menu_relation` VALUES (1, 1, 100, 2);
INSERT INTO `gen_menu_relation` VALUES (2, 2, 100, 2);
INSERT INTO `gen_menu_relation` VALUES (3, 3, 100, 2);
INSERT INTO `gen_menu_relation` VALUES (5, 0, 1, 1);
INSERT INTO `gen_menu_relation` VALUES (6, 6, 102, 2);

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_menu_url_alternative`
-- 

CREATE TABLE `gen_menu_url_alternative` (
  `gmua_id_url` int(11) unsigned NOT NULL default '0',
  `gmua_ce_menu` int(11) unsigned NOT NULL default '0',
  `gmua_url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`gmua_id_url`),
  KEY `gen_menu_url_alternative_FKIndex1` (`gmua_ce_menu`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_menu_url_alternative`
-- 


-- --------------------------------------------------------

-- 
-- Structure de la table `gen_site`
-- 

CREATE TABLE `gen_site` (
  `gs_id_site` int(11) unsigned NOT NULL default '0',
  `gs_ce_admin` int(11) unsigned NOT NULL default '0',
  `gs_ce_i18n` varchar(8) NOT NULL default '',
  `gs_ce_auth` int(11) unsigned NOT NULL default '0',
  `gs_code_num` int(11) NOT NULL default '0',
  `gs_code_alpha` varchar(20) NOT NULL default '',
  `gs_nom` varchar(100) NOT NULL default '',
  `gs_raccourci_clavier` char(1) default NULL,
  `gs_titre` varchar(255) default NULL,
  `gs_mots_cles` text,
  `gs_description` text,
  `gs_auteur` varchar(255) default NULL,
  `gs_date_creation` datetime default NULL,
  `gs_fichier_squelette` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`gs_id_site`),
  KEY `idx_fk_gsi_ce_auth` (`gs_ce_auth`),
  KEY `gen_site_FKIndex3` (`gs_ce_i18n`),
  KEY `gen_site_FKIndex4` (`gs_ce_admin`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_site`
-- 

INSERT INTO `gen_site` VALUES (1, 2, 'fr', 1, 1, 'admin', 'Administration', '', 'Administration de Génésia.', 'Administration, Génésia.', 'Site de test de l''administration de Génésia.', 'Tela Botanica', '2004-07-06 19:06:16', 'admin.html');
INSERT INTO `gen_site` VALUES (2, 1, 'en', 1, 1, 'admin', 'Administration', '', 'Administration of Génésia.', 'Administration, Génésia.', 'Web administration interface of Génésia.', 'Tela Botanica', '2004-04-23 14:18:21', '../sites/admin/en/squelettes/admin.html');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_site_auth`
-- 

CREATE TABLE `gen_site_auth` (
  `gsa_id_auth` int(10) unsigned NOT NULL default '0',
  `gsa_nom` varchar(100) NOT NULL default '',
  `gsa_ce_auth_bdd` int(11) unsigned NOT NULL default '0',
  `gsa_ce_auth_ldap` int(10) unsigned NOT NULL default '0',
  `gsa_ce_type_auth` int(11) unsigned default NULL,
  PRIMARY KEY  (`gsa_id_auth`),
  KEY `idx_fk_gsa_ce_auth_ldap` (`gsa_ce_auth_ldap`),
  KEY `idx_fk_gsa_ce_auth_bdd` (`gsa_ce_auth_bdd`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_site_auth`
-- 

INSERT INTO `gen_site_auth` VALUES (0, 'Aucune identification', 0, 0, 0);
INSERT INTO `gen_site_auth` VALUES (1, 'Administrateur de Papyrus', 1, 0, 1);

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_site_auth_bdd`
-- 

CREATE TABLE `gen_site_auth_bdd` (
  `gsab_id_auth_bdd` int(11) unsigned NOT NULL default '0',
  `gsab_dsn` varchar(255) default NULL,
  `gsab_nom_table` varchar(100) default NULL,
  `gsab_nom_champ_login` varchar(100) default NULL,
  `gsab_nom_champ_mdp` varchar(100) default NULL,
  `gsab_cryptage_mdp` varchar(100) default NULL,
  PRIMARY KEY  (`gsab_id_auth_bdd`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_site_auth_bdd`
-- 

INSERT INTO `gen_site_auth_bdd` VALUES (0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `gen_site_auth_bdd` VALUES (1, 'mysql://root:0000@127.0.0.1/tela_prod_genesia', 'gen_annuaire', 'ga_mail', 'ga_mot_de_passe', 'md5');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_site_auth_ldap`
-- 

CREATE TABLE `gen_site_auth_ldap` (
  `gsal_id_auth_ldap` int(10) unsigned NOT NULL default '0',
  `gsal_serveur` varchar(100) default NULL,
  `gsal_port` int(11) unsigned default NULL,
  `gsal_base_dn` varchar(255) default NULL,
  `gsal_uid` varchar(100) default NULL,
  PRIMARY KEY  (`gsal_id_auth_ldap`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_site_auth_ldap`
-- 

INSERT INTO `gen_site_auth_ldap` VALUES (0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_site_categorie`
-- 

CREATE TABLE `gen_site_categorie` (
  `gsc_id_categorie` int(10) unsigned NOT NULL auto_increment,
  `gsc_intitule_categorie` varchar(255) default NULL,
  PRIMARY KEY  (`gsc_id_categorie`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Contenu de la table `gen_site_categorie`
-- 

INSERT INTO `gen_site_categorie` VALUES (1, 'Relation entre sites');
INSERT INTO `gen_site_categorie` VALUES (2, 'Type de site');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_site_categorie_valeur`
-- 

CREATE TABLE `gen_site_categorie_valeur` (
  `gscv_id_valeur` int(11) unsigned NOT NULL auto_increment,
  `gsc_id_categorie` int(10) unsigned NOT NULL default '0',
  `gscv_intitule_valeur` varchar(255) default NULL,
  PRIMARY KEY  (`gscv_id_valeur`)
) TYPE=MyISAM AUTO_INCREMENT=103 ;

-- 
-- Contenu de la table `gen_site_categorie_valeur`
-- 

INSERT INTO `gen_site_categorie_valeur` VALUES (1, 1, 'avoir traduction');
INSERT INTO `gen_site_categorie_valeur` VALUES (101, 2, 'défaut');
INSERT INTO `gen_site_categorie_valeur` VALUES (2, 1, 'avoir suivant');
INSERT INTO `gen_site_categorie_valeur` VALUES (102, 2, 'principal');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_site_relation`
-- 

CREATE TABLE `gen_site_relation` (
  `gsr_id_site_01` int(11) unsigned NOT NULL default '0',
  `gsr_id_site_02` int(11) unsigned NOT NULL default '0',
  `gsr_id_valeur` int(11) unsigned NOT NULL default '0',
  `gsr_ordre` int(11) unsigned default NULL,
  PRIMARY KEY  (`gsr_id_site_01`,`gsr_id_site_02`,`gsr_id_valeur`)
) TYPE=MyISAM;

-- 
-- Contenu de la table `gen_site_relation`
-- 

INSERT INTO `gen_site_relation` VALUES (1, 1, 101, NULL);
INSERT INTO `gen_site_relation` VALUES (1, 1, 102, 1);
