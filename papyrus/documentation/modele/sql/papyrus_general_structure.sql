# phpMyAdmin MySQL-Dump
# version 2.5.0
# http://www.phpmyadmin.net/ (download page)
#
# Serveur: localhost
# G�n�r� le : Lundi 10 Mai 2004 � 14:33
# Version du serveur: 4.0.15
# Version de PHP: 4.3.3
# Base de donn�es: `tela_prod_genesia`
# --------------------------------------------------------

#
# Structure de la table `gen_annuaire`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

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
# --------------------------------------------------------

#
# Structure de la table `gen_application`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_application` (
  `gap_id_application` int(11) unsigned NOT NULL default '0',
  `gap_nom` varchar(100) NOT NULL default '',
  `gap_description` mediumtext NOT NULL,
  `gap_chemin` varchar(255) NOT NULL default '',
  `gap_bool_applette` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`gap_id_application`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Structure de la table `gen_i18n`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

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
# --------------------------------------------------------

#
# Structure de la table `gen_i18n_langue`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_i18n_langue` (
  `gil_id_langue` char(2) NOT NULL default '',
  `gil_nom` varchar(255) default NULL,
  `gil_direction` varchar(20) default NULL,
  PRIMARY KEY  (`gil_id_langue`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Structure de la table `gen_i18n_pays`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_i18n_pays` (
  `gip_id_pays` char(2) NOT NULL default '',
  `gip_nom` varchar(255) default NULL,
  `gip_fichier_drapeau` varchar(255) default NULL,
  PRIMARY KEY  (`gip_id_pays`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Structure de la table `gen_menu`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Lundi 10 Mai 2004 � 12:09
#

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
# --------------------------------------------------------

#
# Structure de la table `gen_menu_cache`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_menu_cache` (
  `gmcac_id_md5_url` varchar(32) NOT NULL default '',
  `gmcac_ce_site` int(11) unsigned NOT NULL default '0',
  `gmcac_corps` longblob NOT NULL,
  `gmcac_date_heure` datetime NOT NULL default '0000-00-00 00:00:00',
  `gmcac_taille` int(11) NOT NULL default '0',
  `gmcac_gz_taille` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gmcac_id_md5_url`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Structure de la table `gen_menu_categorie`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_menu_categorie` (
  `gmca_id_categorie` int(10) unsigned NOT NULL auto_increment,
  `gmca_intitule_categorie` varchar(255) default NULL,
  PRIMARY KEY  (`gmca_id_categorie`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;
# --------------------------------------------------------

#
# Structure de la table `gen_menu_categorie_valeur`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_menu_categorie_valeur` (
  `gmcv_id_valeur` int(11) unsigned NOT NULL auto_increment,
  `gmcv_id_categorie` int(10) unsigned NOT NULL default '0',
  `gmcv_intitule_valeur` varchar(255) default NULL,
  PRIMARY KEY  (`gmcv_id_valeur`),
  KEY `gen_menu_categorie_valeur_FKIndex1` (`gmcv_id_categorie`)
) TYPE=MyISAM AUTO_INCREMENT=105 ;
# --------------------------------------------------------

#
# Structure de la table `gen_menu_contenu`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Lundi 10 Mai 2004 � 10:32
#

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
# --------------------------------------------------------

#
# Structure de la table `gen_menu_relation`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Lundi 10 Mai 2004 � 12:09
#

CREATE TABLE `gen_menu_relation` (
  `gmr_id_menu_01` int(11) unsigned NOT NULL default '0',
  `gmr_id_menu_02` int(11) unsigned NOT NULL default '0',
  `gmr_id_valeur` int(11) unsigned NOT NULL default '0',
  `gmr_ordre` int(11) unsigned default NULL,
  PRIMARY KEY  (`gmr_id_menu_01`,`gmr_id_menu_02`,`gmr_id_valeur`),
  KEY `gen_menu_relation_FKIndex2` (`gmr_id_menu_01`),
  KEY `gen_menu_relation_FKIndex3` (`gmr_id_valeur`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Structure de la table `gen_menu_url_alternative`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_menu_url_alternative` (
  `gmua_id_url` int(11) unsigned NOT NULL default '0',
  `gmua_ce_menu` int(11) unsigned NOT NULL default '0',
  `gmua_url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`gmua_id_url`),
  KEY `gen_menu_url_alternative_FKIndex1` (`gmua_ce_menu`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Structure de la table `gen_site`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Dimanche 09 Mai 2004 � 09:55
#

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
# --------------------------------------------------------

#
# Structure de la table `gen_site_auth`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

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
# --------------------------------------------------------

#
# Structure de la table `gen_site_auth_bdd`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_site_auth_bdd` (
  `gsab_id_auth_bdd` int(11) unsigned NOT NULL default '0',
  `gsab_dsn` varchar(255) default NULL,
  `gsab_nom_table` varchar(100) default NULL,
  `gsab_nom_champ_login` varchar(100) default NULL,
  `gsab_nom_champ_mdp` varchar(100) default NULL,
  `gsab_cryptage_mdp` varchar(100) default NULL,
  PRIMARY KEY  (`gsab_id_auth_bdd`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Structure de la table `gen_site_auth_ldap`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_site_auth_ldap` (
  `gsal_id_auth_ldap` int(10) unsigned NOT NULL default '0',
  `gsal_serveur` varchar(100) default NULL,
  `gsal_port` int(11) unsigned default NULL,
  `gsal_base_dn` varchar(255) default NULL,
  `gsal_uid` varchar(100) default NULL,
  PRIMARY KEY  (`gsal_id_auth_ldap`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Structure de la table `gen_site_categorie`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_site_categorie` (
  `gsc_id_categorie` int(10) unsigned NOT NULL auto_increment,
  `gsc_intitule_categorie` varchar(255) default NULL,
  PRIMARY KEY  (`gsc_id_categorie`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;
# --------------------------------------------------------

#
# Structure de la table `gen_site_categorie_valeur`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_site_categorie_valeur` (
  `gscv_id_valeur` int(11) unsigned NOT NULL auto_increment,
  `gsc_id_categorie` int(10) unsigned NOT NULL default '0',
  `gscv_intitule_valeur` varchar(255) default NULL,
  PRIMARY KEY  (`gscv_id_valeur`)
) TYPE=MyISAM AUTO_INCREMENT=103 ;
# --------------------------------------------------------

#
# Structure de la table `gen_site_relation`
#
# Cr�ation: Vendredi 07 Mai 2004 � 18:57
# Derni�re modification: Vendredi 07 Mai 2004 � 18:57
#

CREATE TABLE `gen_site_relation` (
  `gsr_id_site_01` int(11) unsigned NOT NULL default '0',
  `gsr_id_site_02` int(11) unsigned NOT NULL default '0',
  `gsr_id_valeur` int(11) unsigned NOT NULL default '0',
  `gsr_ordre` int(11) unsigned default NULL,
  PRIMARY KEY  (`gsr_id_site_01`,`gsr_id_site_02`,`gsr_id_valeur`)
) TYPE=MyISAM;

