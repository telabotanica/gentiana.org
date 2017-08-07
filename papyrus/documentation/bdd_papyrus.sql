-- ------------------------------------------------------------
-- Contient les informations sur les administrateurs de Papyrus.
-- ------------------------------------------------------------

CREATE TABLE gen_annuaire (
  ga_id_administrateur INTEGER(11) UNSIGNED NOT NULL DEFAULT '0',
  ga_ce_i18n VARCHAR(8) NOT NULL,
  ga_nom VARCHAR(32) NOT NULL,
  ga_prenom VARCHAR(32) NOT NULL,
  ga_mot_de_passe VARCHAR(32) NOT NULL DEFAULT 'X X',
  ga_mail VARCHAR(128) NOT NULL,
  PRIMARY KEY(ga_id_administrateur),
);

-- ------------------------------------------------------------
-- Contient les informations sur les applications ou les applettes disponibles pour Papyrus.
-- Une application est spécifiquement appelée par un menu et ce menu lui transmet des paramètres.
-- Une applette est appellée via une balise présente dans un squelette et possède ses propres paramètres.
-- Une applette sera donc commune à toutes les pages utilisant le squelette en question.
-- ------------------------------------------------------------

CREATE TABLE gen_application (
  gap_id_application INTEGER(11) UNSIGNED NOT NULL,
  gap_nom VARCHAR(100) NOT NULL,
  gap_description MEDIUMTEXT NOT NULL,
  gap_chemin VARCHAR(255) NOT NULL,
  gap_bool_applette TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  gap_applette_balise VARCHAR(255) NULL,
  gap_applette_arguments VARCHAR(255) NULL,
  PRIMARY KEY(gap_id_application)
);

-- ------------------------------------------------------------
-- Contient les informations sur le couple langue / pays autrement appelé Internationalisation ou i18n.
-- ------------------------------------------------------------

CREATE TABLE gen_i18n (
  gi_id_i18n VARCHAR(8) NOT NULL,
  gi_ce_langue VARCHAR(2) NOT NULL,
  gi_ce_pays VARCHAR(2) NOT NULL,
  gi_jeu_de_caracteres VARCHAR(50) NULL,
  gi_nom VARCHAR(255) NOT NULL,
  PRIMARY KEY(gi_id_i18n),
);

-- ------------------------------------------------------------
-- Cette table contient les langues, leur noms par défaut, en français en général et la direction d'écriture (ltr left to right ou rtl right to left)
-- ------------------------------------------------------------

CREATE TABLE gen_i18n_langue (
  gil_id_langue VARCHAR(2) NOT NULL,
  gil_nom VARCHAR(255) NULL,
  gil_direction VARCHAR(20) NULL,
  PRIMARY KEY(gil_id_langue)
);

-- ------------------------------------------------------------
-- Cette table contient les différents pays du monde et leur nom par défaut (en français). Ainsi qu'un nom de fichier pour le drapeaux.
-- ------------------------------------------------------------

CREATE TABLE gen_i18n_pays (
  gip_id_pays VARCHAR(2) NOT NULL,
  gip_nom VARCHAR(255) NULL,
  gip_fichier_drapeau VARCHAR(255) NULL,
  PRIMARY KEY(gip_id_pays)
);

-- ------------------------------------------------------------
-- Contient les informations sur les menus constituant un site.
-- Les informations d'un menu permettent de générer les entetes Dublin Core.
-- ------------------------------------------------------------

CREATE TABLE gen_menu (
  gm_id_menu INTEGER(11) UNSIGNED NOT NULL,
  gm_ce_site INTEGER(11) UNSIGNED NOT NULL,
  gm_ce_i18n VARCHAR(8) NOT NULL,
  gm_ce_application INTEGER(11) UNSIGNED NOT NULL,
  gm_application_arguments VARCHAR(255) NULL,
  gm_fichier_squelette VARCHAR(255) NULL,
  gm_code_num INTEGER(11) UNSIGNED NOT NULL,
  gm_code_alpha VARCHAR(20) NOT NULL,
  gm_nom VARCHAR(100) NULL,
  gm_raccourci_clavier CHAR(1) NULL,
  gm_robot VARCHAR(100) NULL DEFAULT 'index,follow',
  gm_titre VARCHAR(255) NULL,
  gm_titre_alternatif VARCHAR(255) NULL,
  gm_mots_cles TEXT NULL,
  gm_description_libre TEXT NULL,
  gm_description_resume TEXT NULL,
  gm_description_table_matieres TEXT NULL,
  gm_source VARCHAR(255) NULL,
  gm_auteur VARCHAR(255) NULL,
  gm_contributeur TEXT NULL,
  gm_editeur TEXT NULL,
  gm_date_creation DATETIME NULL,
  gm_date_soumission DATETIME NULL,
  gm_date_acceptation DATETIME NULL,
  gm_date_publication DATETIME NULL,
  gm_date_debut_validite DATETIME NULL,
  gm_date_fin_validite DATETIME NULL,
  gm_date_copyright DATETIME NULL,
  gm_licence VARCHAR(255) NULL,
  gm_categorie VARCHAR(100) NULL,
  gm_public VARCHAR(255) NULL,
  gm_public_niveau VARCHAR(45) NULL,
  gm_ce_type_portee_spatiale INTEGER(11) UNSIGNED NULL,
  gm_portee_spatiale VARCHAR(100) NULL,
  gm_ce_type_portee_temporelle INTEGER(11) UNSIGNED NULL,
  gm_portee_temporelle VARCHAR(100) NULL,
  gm_ce_admin INTEGER(11) UNSIGNED NOT NULL,
  PRIMARY KEY(gm_id_menu),
);

-- ------------------------------------------------------------
-- Contient les pages en cache du site.
-- ------------------------------------------------------------

CREATE TABLE gen_menu_cache (
  gmcac_id_md5_url VARCHAR(32) NOT NULL,
  gmcac_ce_site INTEGER(11) UNSIGNED NOT NULL,
  gmcac_corps LONGBLOB NOT NULL,
  gmcac_date_heure DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  gmcac_taille INTEGER(11) NOT NULL,
  gmcac_gz_taille INTEGER(11) NOT NULL,
  PRIMARY KEY(gmcac_id_md5_url),
);

CREATE TABLE gen_menu_categorie (
  gmca_id_categorie INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  gmca_intitule_categorie VARCHAR(255) NULL,
  PRIMARY KEY(gmca_id_categorie)
);

CREATE TABLE gen_menu_categorie_valeur (
  gmcv_id_valeur INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  gmcv_id_categorie INTEGER UNSIGNED NOT NULL,
  gmcv_intitule_valeur VARCHAR(255) NULL,
  PRIMARY KEY(gmcv_id_valeur),
);

-- ------------------------------------------------------------
-- Permet de suivre l'évolution d'une page et d'obtenir ses informations  d'entete et son contenu associé.
-- ------------------------------------------------------------

CREATE TABLE gen_menu_contenu (
  gmc_id_contenu INTEGER(11) UNSIGNED NOT NULL,
  gmc_ce_admin INTEGER(11) UNSIGNED NOT NULL,
  gmc_ce_menu INTEGER(11) UNSIGNED NOT NULL,
  gmc_ce_type_contenu INTEGER(11) UNSIGNED NULL,
  gmc_contenu MEDIUMTEXT NULL,
  gmc_ce_type_modification INTEGER(11) UNSIGNED NULL,
  gmc_resume_modification VARCHAR(255) NULL,
  gmc_date_modification DATETIME NULL,
  gmc_bool_dernier TINYINT(1) UNSIGNED NULL DEFAULT '1',
  PRIMARY KEY(gmc_id_contenu),
);

-- ------------------------------------------------------------
-- Table permettant de connaitre les relations unissant les menus entre eux.
-- ------------------------------------------------------------

CREATE TABLE gen_menu_relation (
  gmr_id_menu_01 INTEGER(11) UNSIGNED NOT NULL,
  gmr_id_menu_02 INTEGER(11) UNSIGNED NOT NULL,
  gmr_id_valeur INTEGER(11) UNSIGNED NOT NULL,
  gmr_ordre INTEGER(11) UNSIGNED NULL,
  PRIMARY KEY(gmr_id_menu_01, gmr_id_menu_02, gmr_id_valeur),
);

-- ------------------------------------------------------------
-- Contient les url alternative pour un menu d'un site dans une langue donnée.
-- ------------------------------------------------------------

CREATE TABLE gen_menu_url_alternative (
  gmua_id_url INTEGER(11) UNSIGNED NOT NULL DEFAULT '0',
  gmua_ce_menu INTEGER(11) UNSIGNED NOT NULL,
  gmua_url VARCHAR(255) NOT NULL,
  PRIMARY KEY(gmua_id_url),
);

-- ------------------------------------------------------------
-- Contient les informations sur les sites gérés par Papyrus.
-- ------------------------------------------------------------

CREATE TABLE gen_site (
  gs_id_site INTEGER(11) UNSIGNED NOT NULL,
  gs_ce_i18n VARCHAR(8) NOT NULL,
  gs_ce_auth INTEGER(11) UNSIGNED NOT NULL DEFAULT '0',
  gs_fichier_squelette VARCHAR(255) NOT NULL,
  gs_code_num INTEGER(11) UNSIGNED NULL,
  gs_code_alpha VARCHAR(20) NOT NULL,
  gs_nom VARCHAR(100) NOT NULL,
  gs_raccourci_clavier CHAR(1) NULL,
  gs_titre VARCHAR(255) NULL,
  gs_mots_cles TEXT NULL,
  gs_description TEXT NULL,
  gs_auteur VARCHAR(255) NULL,
  gs_date_creation DATETIME NULL,
  gs_ce_admin INTEGER(11) UNSIGNED NOT NULL,
  PRIMARY KEY(gs_id_site),
);

-- ------------------------------------------------------------
-- Contient les informations communes aux différents systèmes d'identification.
-- Le type d'identification permet de savoir dans quel table chercher les informations d'identifications  spécifique au mode d'identification.
-- ------------------------------------------------------------

CREATE TABLE gen_site_auth (
  gsa_id_auth INTEGER(11) UNSIGNED NOT NULL,
  gsa_ce_type_auth INTEGER(11) UNSIGNED NULL,
  gsa_nom VARCHAR(100) NULL,
  gsa_ce_auth_bdd INTEGER(11) UNSIGNED NOT NULL,
  gsa_ce_auth_ldap INTEGER(11) UNSIGNED NOT NULL,
  PRIMARY KEY(gsa_id_auth),
);

-- ------------------------------------------------------------
-- Contient les informations pour identification via une base de données.
-- ------------------------------------------------------------

CREATE TABLE gen_site_auth_bdd (
  gsab_id_auth_bdd INTEGER(11) UNSIGNED NOT NULL,
  gsab_dsn VARCHAR(255) NULL,
  gsab_nom_table VARCHAR(100) NULL,
  gsab_nom_champ_login VARCHAR(100) NULL,
  gsab_nom_champ_mdp VARCHAR(100) NULL,
  gsab_cryptage_mdp VARCHAR(100) NULL,
  PRIMARY KEY(gsab_id_auth_bdd)
);

-- ------------------------------------------------------------
-- Contient les information spécifique à une identification via LDAP.
-- ------------------------------------------------------------

CREATE TABLE gen_site_auth_ldap (
  gsal_id_auth_ldap INTEGER(11) UNSIGNED NOT NULL,
  gsal_serveur VARCHAR(100) NULL,
  gsal_port INTEGER(11) UNSIGNED NULL,
  gsal_base_dn VARCHAR(255) NULL,
  gsal_uid VARCHAR(100) NULL,
  PRIMARY KEY(gsal_id_auth_ldap)
);

CREATE TABLE gen_site_categorie (
  gsc_id_categorie INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  gsc_intitule_categorie VARCHAR(255) NULL,
  PRIMARY KEY(gsc_id_categorie)
);

CREATE TABLE gen_site_categorie_valeur (
  gscv_id_valeur INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  gsc_id_categorie INTEGER UNSIGNED NOT NULL,
  gscv_intitule_valeur VARCHAR(255) NULL,
  PRIMARY KEY(gscv_id_valeur),
);

-- ------------------------------------------------------------
-- Table permettant de connaitre les relations unissant les menus entre eux.
-- ------------------------------------------------------------

CREATE TABLE gen_site_relation (
  gsr_id_site_01 INTEGER(11) UNSIGNED NOT NULL,
  gsr_id_site_02 INTEGER(11) UNSIGNED NOT NULL,
  gsr_id_valeur INTEGER(11) UNSIGNED NOT NULL,
  gsr_ordre INTEGER(11) UNSIGNED NULL,
  PRIMARY KEY(gsr_id_site_01, gsr_id_site_02, gsr_id_valeur),
);


