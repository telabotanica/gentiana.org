# phpMyAdmin MySQL-Dump
# version 2.5.0
# http://www.phpmyadmin.net/ (download page)
#
# Serveur: localhost
# Généré le : Lundi 10 Mai 2004 à 14:35
# Version du serveur: 4.0.15
# Version de PHP: 4.3.3
# Base de données: `tela_prod_genesia`

#
# Contenu de la table `gen_annuaire`
#

INSERT INTO `gen_annuaire` VALUES (1, 'fr-FR', 'GRANIER', 'Alexandre', '670b14728ad9902aecba32e22fa4f6bd', 'alexandre@tela-botanica.org');
INSERT INTO `gen_annuaire` VALUES (2, 'fr-FR', 'MILCENT', 'Jean-Pascal', 'bb3a0c91229a891187492444c5760e2b', 'jpm@tela-botanica.org');
INSERT INTO `gen_annuaire` VALUES (3, 'fr-FR', 'LE BOURG', 'Tamara', 'e10adc3949ba59abbe56e057f20f883e', 'tamara@tela-botanica.org');
INSERT INTO `gen_annuaire` VALUES (4, 'fr-FR', 'MATHIEU', 'Daniel', '4aad7a31ef189458ce3f8d87ec973bfb', 'dmath@tela-botanica.org');

#
# Contenu de la table `gen_application`
#

INSERT INTO `gen_application` VALUES (0, 'Inconnue', 'Pour les menu ne contenant auncune application.', 'inconnu', 0);
INSERT INTO `gen_application` VALUES (1, 'Administrateur des sites', 'Permet de rajouter des sites sur les serveurs.\r\nProchainement permetra de gérer le cache, les squelettes et leurs fichiers CSS et JS.\r\nPermetra aussi de visualiser les statistiques de chaque site.', 'applications/admin_site/admin_site.php', 0);
INSERT INTO `gen_application` VALUES (2, 'Administrateur des menus', 'Permet de modifier la hiérarchie et les informations concernant les menus d\'un site.\r\n', 'applications/admin_menu/admin_menu.php', 0);
INSERT INTO `gen_application` VALUES (3, 'Afficheur', 'L\'application standart qui permet d\'afficher du contenu XHTML dans les pages.', 'applications/afficheur/afficheur.php', 0);
INSERT INTO `gen_application` VALUES (4, 'Plan du site', 'Application affichant le plan d\'un site Génésia.', 'applications/plan/plan.php', 0);
INSERT INTO `gen_application` VALUES (5, 'Inscription à Tela Botanica', 'Application gérant l\'inscription dans l\'annuaire Tela Botanica.', '../client/applications_client/inscription/inscription.php', 0);
INSERT INTO `gen_application` VALUES (6, 'Annuaire de Tela Botanica (front office)', 'Application affichant l\'annuaire de Tela Botanica.', '../client/applications_client/annuaire/annuaire.php', 0);
INSERT INTO `gen_application` VALUES (8, 'Cartographie des adhérents de  Tela Botanica', 'La cartographie des inscrits à Tela Botanica.', '../client/applications_client/carto_adherents/carto_ad.php', 0);
INSERT INTO `gen_application` VALUES (9, 'Menu classique mono ou multi niveaux', 'Génère une liste de listes correspondant à la hiérarchie des menus.\r\nLa liste dépend des paramètres passés dans la balise.\r\nBalise de type MENU_n_m : affiche tous les menus de niveaux n à m.\r\nExemple :\r\nMENU_1_1 : affiche tous les menus de niveaux 1.\r\nMENU_1_3 : affiche tous les menus de niveaux 1 à 3.', 'applettes/menu/menu.php', 1);
INSERT INTO `gen_application` VALUES (10, 'Menu commun', 'Génère une liste de menus communs à l\'ensemble du site.', 'applettes/menu_commun/menu_commun.php', 1);
INSERT INTO `gen_application` VALUES (11, 'Sélecteur de sites', 'Génère un formulaire permettant de passer de site en site pour une langue donnée.', 'applettes/selecteur_sites/selecteur_sites.php', 1);
INSERT INTO `gen_application` VALUES (12, 'Identification', 'Génère un formulaire permettant de s\'identifier ou fournissant les informations sur la personne identifiée.', 'applettes/identification/identification.php', 1);
INSERT INTO `gen_application` VALUES (13, 'Vous-êtes-ici', 'Affiche  la suite des menus visité, sous forme de lien, pour arriver au menu courant visioné par l\'utilisateur.', 'applettes/vous_etes_ici/vous_etes_ici.php', 1);

#
# Contenu de la table `gen_i18n`
#

INSERT INTO `gen_i18n` VALUES ('fr', 'fr', '', 'iso-8859-15', 'Français');
INSERT INTO `gen_i18n` VALUES ('en', 'en', '', 'iso-8859-15', 'English');

#
# Contenu de la table `gen_i18n_langue`
#

INSERT INTO `gen_i18n_langue` VALUES ('fr', 'français', 'ltr');
INSERT INTO `gen_i18n_langue` VALUES ('en', 'anglais', 'ltr');

#
# Contenu de la table `gen_i18n_pays`
#

INSERT INTO `gen_i18n_pays` VALUES ('FR', 'France', 'FR.png');
INSERT INTO `gen_i18n_pays` VALUES ('UK', 'Royaume-Uni', 'UK.png');

#
# Contenu de la table `gen_menu`
#

INSERT INTO `gen_menu` VALUES (1, 'fr', 1, 0, '', '', 1, 'config', 'Configuration', 'C', 'index,follow', '', '', '', '', 'Configuration des sites de Génésia.', '', '', '', '', '', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '', '', '', '', NULL, '', NULL, '', 2);
INSERT INTO `gen_menu` VALUES (2, 'fr', 1, 1, '', '', 2, 'sites', 'Sites', 'S', 'index,follow', 'Administration des sites de Génésia.', '', 'Administration, sites.', 'Interface d\'administration des sites de Génésia.', 'Administration des sites de Génésia.', '', '', 'Tela Botanica', '', 'Tela Botanica', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', NULL, '', NULL, '', 2);
INSERT INTO `gen_menu` VALUES (4, 'en', 2, 0, NULL, NULL, 1, 'config', 'Configuration en en', 'C', 'index,follow', 'Génésia\'s sites configuration.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', '2004-04-22 21:35:44', NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);
INSERT INTO `gen_menu` VALUES (5, 'en', 2, 1, NULL, NULL, 2, 'sites', 'Sites in en', 'S', 'index,follow', 'Administration of Génésia\'s sites.', NULL, 'Administration, sites.', 'Web interface of Génésia\'s sites administration.', NULL, NULL, NULL, 'Tela Botanica', NULL, 'Tela Botanica', '2004-04-23 14:23:45', '2004-04-23 14:23:45', '2004-04-23 14:23:45', '2004-04-23 14:23:45', '2004-04-23 14:23:45', NULL, '2004-04-23 14:23:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);
INSERT INTO `gen_menu` VALUES (6, 'fr', 1, 0, NULL, NULL, 6, 'menu_6', 'menu_6', NULL, 'index,follow', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Jean-Pascal MILCENT', NULL, 'Tela Botanica', '2004-05-03 17:51:15', '2004-05-03 17:51:15', '2004-05-03 17:51:15', '2004-05-03 17:51:15', '2004-05-03 17:51:15', NULL, '2004-00-00 00:00:00', NULL, 'menu', NULL, NULL, NULL, NULL, NULL, NULL, 2);
INSERT INTO `gen_menu` VALUES (18, 'fr', 1, 2, 'site=essai1', '', 18, 'menu_essai1', 'Site essai n°1', '', 'index,follow', '', '', 'test', '', 'Administration des menus du site essai 1.', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-06 14:59:37', '2004-05-06 14:59:37', '2004-05-06 14:59:37', '2004-05-06 14:59:37', '2004-05-06 14:59:37', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', 0, '', 0, '', 2);
INSERT INTO `gen_menu` VALUES (15, 'en', 2, 3, '', '', 4, 'aide', 'Help', '', 'index,follow', 'Help of Génésia interfaces.', '', 'Help, Génésia.', 'It\'s the help of Génésia.', 'Help of Génésia interfaces.', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', NULL, '', NULL, '', 2);
INSERT INTO `gen_menu` VALUES (11, 'fr', 1, 3, '', '', 4, 'aide', 'Aide', '', 'index,follow', 'Aide des interfaces de Génésia.', '', 'Aide, Génésia.', 'Contient une aide sur les interfaces de Génésia.', 'Une aide sur les interfaces de Génésia.', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', NULL, '', NULL, '', 2);
INSERT INTO `gen_menu` VALUES (9, 'fr', 1, 4, '', '', 9, 'plan_genesia', 'Plan du site', '', 'index,follow', 'Plan du site d\'administration.', 'Plan du site d\'administration', 'plan, administration.', '', 'Plan du site d\'administration de Génésia.', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu commun', '', '', NULL, '', NULL, '', 2);
INSERT INTO `gen_menu` VALUES (8, 'fr', 1, 3, '', '', 5, 'accessibilite', 'Chartre d\'accessibilité', '', 'index,follow', 'Chartre d\'accessibilité de Tela Botanica.', '', 'accessibilité, chartre, handicap.', 'Fournit des informations sur l\'accessibilité de ce site.', 'La chartre d\'accessibilité de Tela Botanica.', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu commun', '', '', NULL, '', NULL, '', 2);
INSERT INTO `gen_menu` VALUES (16, 'fr', 1, 0, '', '', 16, 'gestion', 'Gestion des menus', 'G', 'index,follow', '', '', '', '', 'Gestion des menus des différents sites', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', NULL, '', NULL, '', 2);
INSERT INTO `gen_menu` VALUES (17, 'fr', 1, 2, 'site=admin', '', 17, 'menu_admin', 'Administration', '', 'index,follow', '', '', '', '', 'Administration des menus du site d\'administration.', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-06 14:57:23', '2004-05-06 14:57:23', '2004-05-06 14:57:23', '2004-05-06 14:57:23', '2004-05-06 14:57:23', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', NULL, '', NULL, '', 2);
INSERT INTO `gen_menu` VALUES (19, 'fr', 3, 3, '', '', 19, 'menu_19', 'menu_19', '', 'index,follow', '', '', '', '', 'essai', '', '', 'Jean-Pascal MILCENT', '', 'JPM', '2004-05-06 15:01:40', '2004-05-06 15:01:40', '2004-05-06 15:01:40', '2004-05-06 15:01:40', '2004-05-06 15:01:40', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', 0, '', 0, '', 2);
INSERT INTO `gen_menu` VALUES (20, 'fr', 3, 4, '', '', 20, 'menu_20', 'menu_20', '', 'index,follow', '', '', '', '', '/genesia.', '', '', 'Jean-Pascal MILCENT', '', 'Jean-Pascal MILCENT', '2004-05-10 10:14:58', '2004-05-10 10:14:58', '2004-05-10 10:14:58', '2004-05-10 10:14:58', '2004-05-10 10:14:58', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', 0, '', 0, '', 2);
INSERT INTO `gen_menu` VALUES (21, 'fr', 3, 0, NULL, NULL, 21, 'menu_21', 'menu_21', NULL, 'index,follow', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Jean-Pascal MILCENT', NULL, 'Jean-Pascal MILCENT', '2004-05-10 10:15:06', '2004-05-10 10:15:06', '2004-05-10 10:15:06', '2004-05-10 10:15:06', '2004-05-10 10:15:06', NULL, '2004-00-00 00:00:00', NULL, 'menu', NULL, NULL, NULL, NULL, NULL, NULL, 2);

#
# Contenu de la table `gen_menu_cache`
#


#
# Contenu de la table `gen_menu_categorie`
#

INSERT INTO `gen_menu_categorie` VALUES (1, 'Relation entre menus');
INSERT INTO `gen_menu_categorie` VALUES (2, 'Type de menu');

#
# Contenu de la table `gen_menu_categorie_valeur`
#

INSERT INTO `gen_menu_categorie_valeur` VALUES (1, 1, 'avoir père');
INSERT INTO `gen_menu_categorie_valeur` VALUES (2, 1, 'avoir traduction');
INSERT INTO `gen_menu_categorie_valeur` VALUES (101, 2, 'défaut');
INSERT INTO `gen_menu_categorie_valeur` VALUES (102, 2, 'commun');
INSERT INTO `gen_menu_categorie_valeur` VALUES (103, 2, 'traduction');
INSERT INTO `gen_menu_categorie_valeur` VALUES (104, 2, 'copyright');
INSERT INTO `gen_menu_categorie_valeur` VALUES (3, 1, 'avoir suivant logique');
INSERT INTO `gen_menu_categorie_valeur` VALUES (4, 1, 'avoir précédent logique');
INSERT INTO `gen_menu_categorie_valeur` VALUES (100, 2, 'menu classique');

#
# Contenu de la table `gen_menu_contenu`
#

INSERT INTO `gen_menu_contenu` VALUES (1, 2, 6, 1, 'Essai de contenu.', 1, '', '2004-04-30 16:54:33', 0);
INSERT INTO `gen_menu_contenu` VALUES (2, 2, 6, 1, 'Essai de contenu.\r\nJe tente une modification de ce contenu.', 1, '', '2004-04-30 16:57:07', 0);
INSERT INTO `gen_menu_contenu` VALUES (3, 2, 6, 1, 'Essai de contenu.\r\nJe tente une modification de ce contenu.\r\nEt à nouveau avec des accents et des virugles.\r\n"un essai"\r\n\'un essai\'\r\nL\'autre jour.\r\néàèôûî\r\n', 1, '', '2004-04-30 16:57:52', 0);
INSERT INTO `gen_menu_contenu` VALUES (4, 2, 7, 1, '<h1>Un nouveau titre pour cette page.</h1>\r\n<p>Je commence à voir la fin de cette tache</p>', 1, '', '2004-04-30 17:14:41', 0);
INSERT INTO `gen_menu_contenu` VALUES (5, 2, 6, 1, '<p>\r\nEssai de contenu.\r\nJe tente une modification de ce contenu.\r\nEt à nouveau avec des accents et des virugles.\r\n"un essai"\r\n\'un essai\'\r\nL\'autre jour.\r\néàèôûî\r\n</p>', 1, '', '2004-04-30 17:21:08', 1);
INSERT INTO `gen_menu_contenu` VALUES (6, 2, 7, 1, '<h1>Un nouveau titre pour cette page.</h1>\r\n<p>Je commence à voir la fin de cette tache. Un nouvel essai</p>', 1, '', '2004-05-03 16:23:50', 0);
INSERT INTO `gen_menu_contenu` VALUES (7, 2, 7, 1, '<h1>Un nouveau titre pour cette page.</h1>\r\n<p>Je commence à voir la fin de cette tache.</p>', 1, '', '2004-05-03 16:35:14', 0);
INSERT INTO `gen_menu_contenu` VALUES (8, 2, 7, 1, '<h1>Un nouveau titre pour cette page.</h1>\r\n<p>Je commence à voir la fin de cette tache. Une modif.</p>', 1, '', '2004-05-03 16:43:58', 1);
INSERT INTO `gen_menu_contenu` VALUES (9, 2, 11, 1, '<h1>Aide de Génésia</h1>\r\n<p>Pour l\'instant la gestion des langues ne fonctionne pas.</p>\r\n', 1, '', '2004-05-04 13:34:38', 0);
INSERT INTO `gen_menu_contenu` VALUES (10, 2, 8, 1, '<h1>Chartre d\'accessibilité de Tela Botanica</h1>', 1, '', '2004-05-04 13:44:29', 0);
INSERT INTO `gen_menu_contenu` VALUES (11, 2, 8, 1, '<h1>Chartre d\'accessibilité de Tela Botanica</h1>', 1, '', '2004-05-04 13:44:39', 0);
INSERT INTO `gen_menu_contenu` VALUES (12, 2, 8, 1, '<h1>Chartre d\'accessibilité de Tela Botanica</h1>', 1, '', '2004-05-04 13:48:54', 1);
INSERT INTO `gen_menu_contenu` VALUES (13, 2, 12, 1, 'Un test', 1, '', '2004-05-04 17:23:02', 1);
INSERT INTO `gen_menu_contenu` VALUES (14, 2, 11, 1, '<h1>Aide de Génésia</h1>\r\n<p>Pour l\'instant la gestion des langues ne fonctionne pas.</p>\r\n<p>Un nouveau paragraphe.</p>\r\n', 1, '', '2004-05-05 12:14:11', 0);
INSERT INTO `gen_menu_contenu` VALUES (15, 2, 11, 1, '<h1>Aide de Génésia</h1>\r\n<p>Pour l\'instant la gestion des langues ne fonctionne pas.</p>\r\n<p>Un nouveau paragraphe.</p>\r\n', 1, '', '2004-05-05 12:16:07', 0);
INSERT INTO `gen_menu_contenu` VALUES (17, 2, 15, 1, '<h1>Help of Génésia</h1>\r\n<p> In english.</p>\r\n', 1, '', '2004-05-05 13:33:00', 1);
INSERT INTO `gen_menu_contenu` VALUES (18, 2, 19, 1, '<h1> UN test de Site</h1>\r\n<p>Un nouveau site et sa page.</p>', 1, '', '2004-05-06 15:02:25', 1);
INSERT INTO `gen_menu_contenu` VALUES (19, 2, 22, 1, 'un test', 1, '', '2004-05-10 10:32:20', 1);

#
# Contenu de la table `gen_menu_relation`
#

INSERT INTO `gen_menu_relation` VALUES (1, 0, 1, 1);
INSERT INTO `gen_menu_relation` VALUES (2, 1, 1, 1);
INSERT INTO `gen_menu_relation` VALUES (16, 1, 1, 4);
INSERT INTO `gen_menu_relation` VALUES (5, 5, 103, 2);
INSERT INTO `gen_menu_relation` VALUES (11, 15, 2, 1);
INSERT INTO `gen_menu_relation` VALUES (2, 5, 2, 1);
INSERT INTO `gen_menu_relation` VALUES (1, 1, 101, NULL);
INSERT INTO `gen_menu_relation` VALUES (8, 8, 102, 1);
INSERT INTO `gen_menu_relation` VALUES (9, 0, 1, 2);
INSERT INTO `gen_menu_relation` VALUES (11, 11, 100, 4);
INSERT INTO `gen_menu_relation` VALUES (11, 0, 1, 5);
INSERT INTO `gen_menu_relation` VALUES (1, 1, 100, 2);
INSERT INTO `gen_menu_relation` VALUES (2, 2, 100, 2);
INSERT INTO `gen_menu_relation` VALUES (19, 19, 101, NULL);
INSERT INTO `gen_menu_relation` VALUES (4, 4, 103, 1);
INSERT INTO `gen_menu_relation` VALUES (16, 16, 100, 8);
INSERT INTO `gen_menu_relation` VALUES (8, 0, 1, 1);
INSERT INTO `gen_menu_relation` VALUES (18, 16, 1, 10);
INSERT INTO `gen_menu_relation` VALUES (17, 16, 1, 1);
INSERT INTO `gen_menu_relation` VALUES (15, 15, 103, 3);
INSERT INTO `gen_menu_relation` VALUES (19, 0, 1, 3);
INSERT INTO `gen_menu_relation` VALUES (18, 18, 100, 10);
INSERT INTO `gen_menu_relation` VALUES (17, 17, 100, 9);
INSERT INTO `gen_menu_relation` VALUES (1, 4, 2, 1);
INSERT INTO `gen_menu_relation` VALUES (19, 19, 100, 1);
INSERT INTO `gen_menu_relation` VALUES (9, 9, 102, 2);
INSERT INTO `gen_menu_relation` VALUES (20, 0, 1, 2);
INSERT INTO `gen_menu_relation` VALUES (20, 20, 100, 2);
INSERT INTO `gen_menu_relation` VALUES (21, 20, 1, 1);
INSERT INTO `gen_menu_relation` VALUES (21, 21, 100, 3);

#
# Contenu de la table `gen_menu_url_alternative`
#


#
# Contenu de la table `gen_site`
#

INSERT INTO `gen_site` VALUES (1, 2, 'fr', 1, 1, 'admin', 'Administration', '', 'Administration de Génésia.', 'Administration, Génésia.', 'Site d\'administration de Génésia.', 'Tela Botanica', '2004-05-06 18:38:13', 'admin.html');
INSERT INTO `gen_site` VALUES (2, 1, 'en', 1, 1, 'admin', 'Administration', '', 'Administration of Génésia.', 'Administration, Génésia.', 'Web administration interface of Génésia.', 'Tela Botanica', '2004-04-23 14:18:21', '../sites/admin/en/squelettes/admin.html');
INSERT INTO `gen_site` VALUES (3, 2, 'fr', 1, 2, 'essai1', 'Essai1', 'E', 'Essai n°1', 'Essai, test', 'essai', 'Jean-Pascal MILCENT', '2004-05-09 09:55:06', 'defaut.html');

#
# Contenu de la table `gen_site_auth`
#

INSERT INTO `gen_site_auth` VALUES (0, 'Aucune identification', 0, 0, 0);
INSERT INTO `gen_site_auth` VALUES (1, 'Administrateur de Génésia', 1, 0, 1);

#
# Contenu de la table `gen_site_auth_bdd`
#

INSERT INTO `gen_site_auth_bdd` VALUES (0, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `gen_site_auth_bdd` VALUES (1, 'mysql://root:0000@127.0.0.1/tela_prod_genesia', 'gen_annuaire', 'ga_mail', 'ga_mot_de_passe', 'md5');

#
# Contenu de la table `gen_site_auth_ldap`
#

INSERT INTO `gen_site_auth_ldap` VALUES (0, NULL, NULL, NULL, NULL);

#
# Contenu de la table `gen_site_categorie`
#

INSERT INTO `gen_site_categorie` VALUES (1, 'Relation entre sites');
INSERT INTO `gen_site_categorie` VALUES (2, 'Type de site');

#
# Contenu de la table `gen_site_categorie_valeur`
#

INSERT INTO `gen_site_categorie_valeur` VALUES (1, 1, 'avoir traduction');
INSERT INTO `gen_site_categorie_valeur` VALUES (101, 2, 'défaut');
INSERT INTO `gen_site_categorie_valeur` VALUES (2, 1, 'avoir suivant');
INSERT INTO `gen_site_categorie_valeur` VALUES (102, 2, 'principal');

#
# Contenu de la table `gen_site_relation`
#

INSERT INTO `gen_site_relation` VALUES (1, 2, 1, 1);
INSERT INTO `gen_site_relation` VALUES (1, 1, 101, NULL);
INSERT INTO `gen_site_relation` VALUES (1, 1, 102, 1);
INSERT INTO `gen_site_relation` VALUES (3, 3, 102, 2);

