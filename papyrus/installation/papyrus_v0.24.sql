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
);

-- 
-- Contenu de la table `gen_annuaire`
-- 

INSERT INTO `gen_annuaire` VALUES (0, 'fr', 'Non renseigné', '', '', '');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_application`
-- 

CREATE TABLE `gen_application` (
  `gap_id_application` int(11) unsigned NOT NULL,
  `gap_nom` varchar(100) NOT NULL default '',
  `gap_description` mediumtext NOT NULL,
  `gap_chemin` varchar(255) NOT NULL default '',
  `gap_bool_applette` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`gap_id_application`)
);

-- 
-- Contenu de la table `gen_application`
-- 

INSERT INTO `gen_application` VALUES ('0', 'Inconnue', 'Pour les menu ne contenant auncune application.', 'inconnu', 0);
INSERT INTO `gen_application` VALUES ('1', 'Administrateur des sites', 'Application permettant de rajouter des sites sur les serveurs.', 'papyrus/applications/admin_site/admin_site.php', 0);
INSERT INTO `gen_application` VALUES ('2', 'Administrateur des menus', 'Application permettant de modifier la hiérarchie et les informations concernant les menus d''un site.\r\n', 'papyrus/applications/admin_menu/admin_menu.php', 0);
INSERT INTO `gen_application` VALUES ('3', 'Rédaction', 'Application standard permettant d''afficher du contenu dans les pages.', 'papyrus/applications/afficheur/afficheur.php', 0);
INSERT INTO `gen_application` VALUES ('4', 'Plan du site', 'Application affichant le plan d''un site Papyrus.', 'papyrus/applications/plan/plan.php', 0);
INSERT INTO `gen_application` VALUES ('5', 'Administreur des identifications', 'Permet de spécifier le DSN et la table d\'annuaire pour l\'identification de papyrus et d\'ajouter les identifications communes pour SPIP  et wikini.', 'papyrus/applications/admin_auth/admin_auth.php', 0);
INSERT INTO `gen_application` VALUES ('6', 'Administreur des applications', 'Permet d\'administrer les applications de Papyrus.', 'papyrus/applications/admin_application/admin_application.php', 0);
INSERT INTO `gen_application` VALUES ('7', 'Menus', 'Applette génèrant une liste de listes correspondant à la hiérarchie des menus.', 'papyrus/applettes/menu/menu.php', 1);
INSERT INTO `gen_application` VALUES ('8', 'Sélecteur de sites', 'Applette génèrant un formulaire permettant de passer de site en site pour une langue donnée.', 'papyrus/applettes/selecteur_sites/selecteur_sites.php', 1);
INSERT INTO `gen_application` VALUES ('9', 'Identification', 'Applette génèrant un formulaire permettant de s''identifier ou fournissant les informations sur la personne identifiée.', 'papyrus/applettes/identification/identification.php', 1);
INSERT INTO `gen_application` VALUES ('10', 'Vous-êtes-ici', 'Applette affichant la suite des menus visité, sous forme de lien, pour arriver au menu courant visioné par l''utilisateur.', 'papyrus/applettes/vous_etes_ici/vous_etes_ici.php', 1);
INSERT INTO `gen_application` VALUES ('11', 'Moteur de recherche', 'Permet d\'afficher un formulaire de recherche. La balise à  utiliser est <!-- PAPYRUS_MOTEUR_RECHERCHE -->.\r\nCe moteur recherche dans les diff&eacute;rents sites gérés par Papyrus.', 'papyrus/applettes/moteur_recherche/moteur_recherche.php', 1);


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
);

-- 
-- Contenu de la table `gen_i18n`
-- 

INSERT INTO `gen_i18n` VALUES ('fr', 'fr', 'FR', 'iso-8859-15', 'Français');
INSERT INTO `gen_i18n` VALUES ('en', 'en', 'UK', 'iso-8859-15', 'English');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_i18n_langue`
-- 

CREATE TABLE `gen_i18n_langue` (
  `gil_id_langue` char(2) NOT NULL default '',
  `gil_nom` varchar(255) default NULL,
  `gil_direction` varchar(20) default NULL,
  PRIMARY KEY  (`gil_id_langue`)
);

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
  `gip_id_i18n` varchar(8) NOT NULL default '',
  `gip_nom_pays_traduit` varchar(255) default NULL,
  PRIMARY KEY  (`gip_id_pays`,`gip_id_i18n`)
);

--
-- Contenu de la table `gen_i18n_pays`
--
INSERT INTO `gen_i18n_pays` VALUES ('bd', 'fr-FR', 'Bangladesh');
INSERT INTO `gen_i18n_pays` VALUES ('bh', 'fr-FR', 'Bahreïn');
INSERT INTO `gen_i18n_pays` VALUES ('bs', 'fr-FR', 'Bahamas');
INSERT INTO `gen_i18n_pays` VALUES ('az', 'fr-FR', 'Azerbaïdjan');
INSERT INTO `gen_i18n_pays` VALUES ('at', 'fr-FR', 'Autriche');
INSERT INTO `gen_i18n_pays` VALUES ('au', 'fr-FR', 'Australie');
INSERT INTO `gen_i18n_pays` VALUES ('am', 'fr-FR', 'Arménie');
INSERT INTO `gen_i18n_pays` VALUES ('ar', 'fr-FR', 'Argentine');
INSERT INTO `gen_i18n_pays` VALUES ('sa', 'fr-FR', 'Arabie Saoudite');
INSERT INTO `gen_i18n_pays` VALUES ('ag', 'fr-FR', 'Antigua et Barbuda');
INSERT INTO `gen_i18n_pays` VALUES ('ao', 'fr-FR', 'Angola');
INSERT INTO `gen_i18n_pays` VALUES ('an', 'fr-FR', 'Andorre');
INSERT INTO `gen_i18n_pays` VALUES ('de', 'fr-FR', 'Allemagne');
INSERT INTO `gen_i18n_pays` VALUES ('dz', 'fr-FR', 'Algérie');
INSERT INTO `gen_i18n_pays` VALUES ('al', 'fr-FR', 'Albanie');
INSERT INTO `gen_i18n_pays` VALUES ('za', 'fr-FR', 'Afrique du Sud');
INSERT INTO `gen_i18n_pays` VALUES ('af', 'fr-FR', 'Afghanistan');
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
INSERT INTO `gen_i18n_pays` VALUES ('LT', 'ro-RO', 'LITUANIA');
INSERT INTO `gen_i18n_pays` VALUES ('LV', 'ro-RO', 'LETONIA');
INSERT INTO `gen_i18n_pays` VALUES ('IT', 'ro-RO', 'ITALIA');
INSERT INTO `gen_i18n_pays` VALUES ('IE', 'ro-RO', 'IRLANDA');
INSERT INTO `gen_i18n_pays` VALUES ('HU', 'ro-RO', 'UNGARIA');
INSERT INTO `gen_i18n_pays` VALUES ('GR', 'ro-RO', 'GRECIA');
INSERT INTO `gen_i18n_pays` VALUES ('DE', 'ro-RO', 'GERMANIA');
INSERT INTO `gen_i18n_pays` VALUES ('FR', 'ro-RO', 'FRANTA');
INSERT INTO `gen_i18n_pays` VALUES ('FI', 'ro-RO', 'FINLAND');
INSERT INTO `gen_i18n_pays` VALUES ('EE', 'ro-RO', 'ESTONIA');
INSERT INTO `gen_i18n_pays` VALUES ('DK', 'ro-RO', 'DANEMARCA');
INSERT INTO `gen_i18n_pays` VALUES ('CZ', 'ro-RO', 'REPUBLICA CEHA');
INSERT INTO `gen_i18n_pays` VALUES ('CY', 'ro-RO', 'CIPRU');
INSERT INTO `gen_i18n_pays` VALUES ('BG', 'ro-RO', 'BULGARIA');
INSERT INTO `gen_i18n_pays` VALUES ('LU', 'ro-RO', 'LUXEMBURG');
INSERT INTO `gen_i18n_pays` VALUES ('NL', 'ro-RO', 'OLANDA');
INSERT INTO `gen_i18n_pays` VALUES ('PL', 'ro-RO', 'POLONIA');
INSERT INTO `gen_i18n_pays` VALUES ('PT', 'ro-RO', 'PORTUGALIA');
INSERT INTO `gen_i18n_pays` VALUES ('RO', 'ro-RO', 'ROMANIA');
INSERT INTO `gen_i18n_pays` VALUES ('SK', 'ro-RO', 'SLOVACIA');
INSERT INTO `gen_i18n_pays` VALUES ('SI', 'ro-RO', 'SLOVENIA');
INSERT INTO `gen_i18n_pays` VALUES ('ES', 'ro-RO', 'SPANIA');
INSERT INTO `gen_i18n_pays` VALUES ('SE', 'ro-RO', 'SUEDIA');
INSERT INTO `gen_i18n_pays` VALUES ('bb', 'fr-FR', 'Barbade');
INSERT INTO `gen_i18n_pays` VALUES ('be', 'fr-FR', 'Belgique');
INSERT INTO `gen_i18n_pays` VALUES ('bz', 'fr-FR', 'Bélize');
INSERT INTO `gen_i18n_pays` VALUES ('bj', 'fr-FR', 'Bénin');
INSERT INTO `gen_i18n_pays` VALUES ('bt', 'fr-FR', 'Bhoutan');
INSERT INTO `gen_i18n_pays` VALUES ('by', 'fr-FR', 'Biélorussie');
INSERT INTO `gen_i18n_pays` VALUES ('bo', 'fr-FR', 'Bolivie');
INSERT INTO `gen_i18n_pays` VALUES ('ba', 'fr-FR', 'Bosnie-Herzégovine');
INSERT INTO `gen_i18n_pays` VALUES ('bw', 'fr-FR', 'Botswana');
INSERT INTO `gen_i18n_pays` VALUES ('br', 'fr-FR', 'Brésil');
INSERT INTO `gen_i18n_pays` VALUES ('bn', 'fr-FR', 'Brunei Darusalam');
INSERT INTO `gen_i18n_pays` VALUES ('bg', 'fr-FR', 'Bulgarie');
INSERT INTO `gen_i18n_pays` VALUES ('bf', 'fr-FR', 'Burkina Faso');
INSERT INTO `gen_i18n_pays` VALUES ('bi', 'fr-FR', 'Burundi');
INSERT INTO `gen_i18n_pays` VALUES ('kh', 'fr-FR', 'Cambodge');
INSERT INTO `gen_i18n_pays` VALUES ('cm', 'fr-FR', 'Cameroun');
INSERT INTO `gen_i18n_pays` VALUES ('ca', 'fr-FR', 'Canada');
INSERT INTO `gen_i18n_pays` VALUES ('cv', 'fr-FR', 'Cap Vert');
INSERT INTO `gen_i18n_pays` VALUES ('cl', 'fr-FR', 'Chili');
INSERT INTO `gen_i18n_pays` VALUES ('cn', 'fr-FR', 'Chine');
INSERT INTO `gen_i18n_pays` VALUES ('cy', 'fr-FR', 'Chypre');
INSERT INTO `gen_i18n_pays` VALUES ('co', 'fr-FR', 'Colombie');
INSERT INTO `gen_i18n_pays` VALUES ('km', 'fr-FR', 'Comores');
INSERT INTO `gen_i18n_pays` VALUES ('cr', 'fr-FR', 'Costa Rica');
INSERT INTO `gen_i18n_pays` VALUES ('ci', 'fr-FR', 'Côte d\'Ivoire');
INSERT INTO `gen_i18n_pays` VALUES ('hr', 'fr-FR', 'Croatie');
INSERT INTO `gen_i18n_pays` VALUES ('cu', 'fr-FR', 'Cuba');
INSERT INTO `gen_i18n_pays` VALUES ('dk', 'fr-FR', 'Danemark');
INSERT INTO `gen_i18n_pays` VALUES ('dj', 'fr-FR', 'Djibouti');
INSERT INTO `gen_i18n_pays` VALUES ('dm', 'fr-FR', 'Dominique');
INSERT INTO `gen_i18n_pays` VALUES ('eg', 'fr-FR', 'Egypte');
INSERT INTO `gen_i18n_pays` VALUES ('sv', 'fr-FR', 'Salvador');
INSERT INTO `gen_i18n_pays` VALUES ('ae', 'fr-FR', 'Emirats Arabes Unis');
INSERT INTO `gen_i18n_pays` VALUES ('ec', 'fr-FR', 'Equateur');
INSERT INTO `gen_i18n_pays` VALUES ('er', 'fr-FR', 'Erythrée');
INSERT INTO `gen_i18n_pays` VALUES ('es', 'fr-FR', 'Espagne');
INSERT INTO `gen_i18n_pays` VALUES ('ee', 'fr-FR', 'Estonie');
INSERT INTO `gen_i18n_pays` VALUES ('us', 'fr-FR', 'Etats-Unis');
INSERT INTO `gen_i18n_pays` VALUES ('et', 'fr-FR', 'Ethiopie');
INSERT INTO `gen_i18n_pays` VALUES ('fj', 'fr-FR', 'Fidji');
INSERT INTO `gen_i18n_pays` VALUES ('fi', 'fr-FR', 'Finlande');
INSERT INTO `gen_i18n_pays` VALUES ('fr', 'fr-FR', 'France');
INSERT INTO `gen_i18n_pays` VALUES ('ga', 'fr-FR', 'Gabon');
INSERT INTO `gen_i18n_pays` VALUES ('gm', 'fr-FR', 'Gambie');
INSERT INTO `gen_i18n_pays` VALUES ('ge', 'fr-FR', 'Géorgie');
INSERT INTO `gen_i18n_pays` VALUES ('gh', 'fr-FR', 'Ghana');
INSERT INTO `gen_i18n_pays` VALUES ('gr', 'fr-FR', 'Grèce');
INSERT INTO `gen_i18n_pays` VALUES ('gd', 'fr-FR', 'Grenade');
INSERT INTO `gen_i18n_pays` VALUES ('gl', 'fr-FR', 'Groenland');
INSERT INTO `gen_i18n_pays` VALUES ('gt', 'fr-FR', 'Guatémala');
INSERT INTO `gen_i18n_pays` VALUES ('gw', 'fr-FR', 'Guinée Bissau');
INSERT INTO `gen_i18n_pays` VALUES ('gq', 'fr-FR', 'Guinée équatoriale');
INSERT INTO `gen_i18n_pays` VALUES ('gy', 'fr-FR', 'Guyana');
INSERT INTO `gen_i18n_pays` VALUES ('ht', 'fr-FR', 'Haïti');
INSERT INTO `gen_i18n_pays` VALUES ('hn', 'fr-FR', 'Honduras');
INSERT INTO `gen_i18n_pays` VALUES ('hu', 'fr-FR', 'Hongrie');
INSERT INTO `gen_i18n_pays` VALUES ('in', 'fr-FR', 'Inde');
INSERT INTO `gen_i18n_pays` VALUES ('id', 'fr-FR', 'Indonésie');
INSERT INTO `gen_i18n_pays` VALUES ('iq', 'fr-FR', 'Irak');
INSERT INTO `gen_i18n_pays` VALUES ('ir', 'fr-FR', 'Iran');
INSERT INTO `gen_i18n_pays` VALUES ('ie', 'fr-FR', 'Irlande');
INSERT INTO `gen_i18n_pays` VALUES ('is', 'fr-FR', 'Islande');
INSERT INTO `gen_i18n_pays` VALUES ('il', 'fr-FR', 'Israël');
INSERT INTO `gen_i18n_pays` VALUES ('it', 'fr-FR', 'Italie');
INSERT INTO `gen_i18n_pays` VALUES ('jm', 'fr-FR', 'Jamaïque');
INSERT INTO `gen_i18n_pays` VALUES ('jp', 'fr-FR', 'Japon');
INSERT INTO `gen_i18n_pays` VALUES ('jo', 'fr-FR', 'Jordanie');
INSERT INTO `gen_i18n_pays` VALUES ('kz', 'fr-FR', 'Kazakhstan');
INSERT INTO `gen_i18n_pays` VALUES ('ke', 'fr-FR', 'Kenya');
INSERT INTO `gen_i18n_pays` VALUES ('kg', 'fr-FR', 'Kirghizstan');
INSERT INTO `gen_i18n_pays` VALUES ('ki', 'fr-FR', 'Kiribati');
INSERT INTO `gen_i18n_pays` VALUES ('kw', 'fr-FR', 'Koweït');
INSERT INTO `gen_i18n_pays` VALUES ('ls', 'fr-FR', 'Lesotho');
INSERT INTO `gen_i18n_pays` VALUES ('lv', 'fr-FR', 'Lettonie');
INSERT INTO `gen_i18n_pays` VALUES ('lb', 'fr-FR', 'Liban');
INSERT INTO `gen_i18n_pays` VALUES ('lr', 'fr-FR', 'Libéria');
INSERT INTO `gen_i18n_pays` VALUES ('ly', 'fr-FR', 'Libye');
INSERT INTO `gen_i18n_pays` VALUES ('li', 'fr-FR', 'Liechtenstein');
INSERT INTO `gen_i18n_pays` VALUES ('lt', 'fr-FR', 'Lituanie');
INSERT INTO `gen_i18n_pays` VALUES ('lu', 'fr-FR', 'Luxembourg');
INSERT INTO `gen_i18n_pays` VALUES ('mk', 'fr-FR', 'Macédoine');
INSERT INTO `gen_i18n_pays` VALUES ('mg', 'fr-FR', 'Madagascar');
INSERT INTO `gen_i18n_pays` VALUES ('my', 'fr-FR', 'Malaisie');
INSERT INTO `gen_i18n_pays` VALUES ('mw', 'fr-FR', 'Malawi');
INSERT INTO `gen_i18n_pays` VALUES ('mv', 'fr-FR', 'Maldives');
INSERT INTO `gen_i18n_pays` VALUES ('ml', 'fr-FR', 'Mali');
INSERT INTO `gen_i18n_pays` VALUES ('mt', 'fr-FR', 'Malte');
INSERT INTO `gen_i18n_pays` VALUES ('ma', 'fr-FR', 'Maroc');
INSERT INTO `gen_i18n_pays` VALUES ('mh', 'fr-FR', 'Marshall');
INSERT INTO `gen_i18n_pays` VALUES ('mu', 'fr-FR', 'Maurice');
INSERT INTO `gen_i18n_pays` VALUES ('mr', 'fr-FR', 'Mauritanie');
INSERT INTO `gen_i18n_pays` VALUES ('mx', 'fr-FR', 'Mexique');
INSERT INTO `gen_i18n_pays` VALUES ('fm', 'fr-FR', 'Micronésie');
INSERT INTO `gen_i18n_pays` VALUES ('md', 'fr-FR', 'Moldavie');
INSERT INTO `gen_i18n_pays` VALUES ('mc', 'fr-FR', 'Monaco');
INSERT INTO `gen_i18n_pays` VALUES ('mn', 'fr-FR', 'Mongolie');
INSERT INTO `gen_i18n_pays` VALUES ('mz', 'fr-FR', 'Mozambique');
INSERT INTO `gen_i18n_pays` VALUES ('na', 'fr-FR', 'Namibie');
INSERT INTO `gen_i18n_pays` VALUES ('nr', 'fr-FR', 'Nauru');
INSERT INTO `gen_i18n_pays` VALUES ('np', 'fr-FR', 'Népal');
INSERT INTO `gen_i18n_pays` VALUES ('ni', 'fr-FR', 'Nicaragua');
INSERT INTO `gen_i18n_pays` VALUES ('ne', 'fr-FR', 'Niger');
INSERT INTO `gen_i18n_pays` VALUES ('ng', 'fr-FR', 'Nigéria');
INSERT INTO `gen_i18n_pays` VALUES ('no', 'fr-FR', 'Norvège');
INSERT INTO `gen_i18n_pays` VALUES ('nz', 'fr-FR', 'Nouvelle-Zélande');
INSERT INTO `gen_i18n_pays` VALUES ('om', 'fr-FR', 'Oman');
INSERT INTO `gen_i18n_pays` VALUES ('ug', 'fr-FR', 'Ouganda');
INSERT INTO `gen_i18n_pays` VALUES ('uz', 'fr-FR', 'Ouzbekistan');
INSERT INTO `gen_i18n_pays` VALUES ('pk', 'fr-FR', 'Pakistan');
INSERT INTO `gen_i18n_pays` VALUES ('pw', 'fr-FR', 'Palau');
INSERT INTO `gen_i18n_pays` VALUES ('ps', 'fr-FR', 'Palestine');
INSERT INTO `gen_i18n_pays` VALUES ('pa', 'fr-FR', 'Panama');
INSERT INTO `gen_i18n_pays` VALUES ('pg', 'fr-FR', 'Papouasie - Nouvelle Guinée');
INSERT INTO `gen_i18n_pays` VALUES ('py', 'fr-FR', 'Paraguay');
INSERT INTO `gen_i18n_pays` VALUES ('nl', 'fr-FR', 'Pays-Bas');
INSERT INTO `gen_i18n_pays` VALUES ('pe', 'fr-FR', 'Pérou');
INSERT INTO `gen_i18n_pays` VALUES ('ph', 'fr-FR', 'Philippines');
INSERT INTO `gen_i18n_pays` VALUES ('pl', 'fr-FR', 'Pologne');
INSERT INTO `gen_i18n_pays` VALUES ('pt', 'fr-FR', 'Portugal');
INSERT INTO `gen_i18n_pays` VALUES ('qa', 'fr-FR', 'Qatar');
INSERT INTO `gen_i18n_pays` VALUES ('cf', 'fr-FR', 'République Centrafricaine');
INSERT INTO `gen_i18n_pays` VALUES ('kr', 'fr-FR', 'République de Corée');
INSERT INTO `gen_i18n_pays` VALUES ('cd', 'fr-FR', 'République Démocratique du Congo');
INSERT INTO `gen_i18n_pays` VALUES ('kp', 'fr-FR', 'République Populaire Démocratique de Corée');
INSERT INTO `gen_i18n_pays` VALUES ('cz', 'fr-FR', 'République Tchèque');
INSERT INTO `gen_i18n_pays` VALUES ('ro', 'fr-FR', 'Roumanie');
INSERT INTO `gen_i18n_pays` VALUES ('uk', 'fr-FR', 'Royaume-Uni');
INSERT INTO `gen_i18n_pays` VALUES ('ru', 'fr-FR', 'Russie (Europe)');
INSERT INTO `gen_i18n_pays` VALUES ('rw', 'fr-FR', 'Rwanda');
INSERT INTO `gen_i18n_pays` VALUES ('sm', 'fr-FR', 'San Marin');
INSERT INTO `gen_i18n_pays` VALUES ('vc', 'fr-FR', 'Saint Vincent et les Grenadines');
INSERT INTO `gen_i18n_pays` VALUES ('lc', 'fr-FR', 'Sainte Lucie');
INSERT INTO `gen_i18n_pays` VALUES ('sb', 'fr-FR', 'Salomon');
INSERT INTO `gen_i18n_pays` VALUES ('ws', 'fr-FR', 'Samoa');
INSERT INTO `gen_i18n_pays` VALUES ('st', 'fr-FR', 'Sao Tomé et Principe');
INSERT INTO `gen_i18n_pays` VALUES ('sn', 'fr-FR', 'Sénégal');
INSERT INTO `gen_i18n_pays` VALUES ('sc', 'fr-FR', 'Seychelles');
INSERT INTO `gen_i18n_pays` VALUES ('sl', 'fr-FR', 'Sierra Leone');
INSERT INTO `gen_i18n_pays` VALUES ('sg', 'fr-FR', 'Singapour');
INSERT INTO `gen_i18n_pays` VALUES ('sk', 'fr-FR', 'Slovaquie');
INSERT INTO `gen_i18n_pays` VALUES ('si', 'fr-FR', 'Slovénie');
INSERT INTO `gen_i18n_pays` VALUES ('so', 'fr-FR', 'Somalie');
INSERT INTO `gen_i18n_pays` VALUES ('sd', 'fr-FR', 'Soudan');
INSERT INTO `gen_i18n_pays` VALUES ('lk', 'fr-FR', 'Sri Lanka');
INSERT INTO `gen_i18n_pays` VALUES ('se', 'fr-FR', 'Suède');
INSERT INTO `gen_i18n_pays` VALUES ('ch', 'fr-FR', 'Suisse');
INSERT INTO `gen_i18n_pays` VALUES ('sr', 'fr-FR', 'Surinam');
INSERT INTO `gen_i18n_pays` VALUES ('sz', 'fr-FR', 'Swaziland');
INSERT INTO `gen_i18n_pays` VALUES ('sy', 'fr-FR', 'Syrie');
INSERT INTO `gen_i18n_pays` VALUES ('tj', 'fr-FR', 'Tadjikistan');
INSERT INTO `gen_i18n_pays` VALUES ('tz', 'fr-FR', 'Tanzanie');
INSERT INTO `gen_i18n_pays` VALUES ('td', 'fr-FR', 'Tchad');
INSERT INTO `gen_i18n_pays` VALUES ('th', 'fr-FR', 'Thaïlande');
INSERT INTO `gen_i18n_pays` VALUES ('tg', 'fr-FR', 'Togo');
INSERT INTO `gen_i18n_pays` VALUES ('to', 'fr-FR', 'Tonga');
INSERT INTO `gen_i18n_pays` VALUES ('tt', 'fr-FR', 'Trinité et Tobago');
INSERT INTO `gen_i18n_pays` VALUES ('tn', 'fr-FR', 'Tunisie');
INSERT INTO `gen_i18n_pays` VALUES ('tm', 'fr-FR', 'Turkmenistan');
INSERT INTO `gen_i18n_pays` VALUES ('tr', 'fr-FR', 'Turquie');
INSERT INTO `gen_i18n_pays` VALUES ('tv', 'fr-FR', 'Tuvalu');
INSERT INTO `gen_i18n_pays` VALUES ('ua', 'fr-FR', 'Ukraine');
INSERT INTO `gen_i18n_pays` VALUES ('uy', 'fr-FR', 'Uruguay');
INSERT INTO `gen_i18n_pays` VALUES ('vu', 'fr-FR', 'Vanuatu');
INSERT INTO `gen_i18n_pays` VALUES ('ve', 'fr-FR', 'Vénézuéla');
INSERT INTO `gen_i18n_pays` VALUES ('vn', 'fr-FR', 'Vietnam');
INSERT INTO `gen_i18n_pays` VALUES ('ye', 'fr-FR', 'Yémen');
INSERT INTO `gen_i18n_pays` VALUES ('yu', 'fr-FR', 'Yougoslavie');
INSERT INTO `gen_i18n_pays` VALUES ('zm', 'fr-FR', 'Zambie');
INSERT INTO `gen_i18n_pays` VALUES ('zw', 'fr-FR', 'Zimbabwe');
INSERT INTO `gen_i18n_pays` VALUES ('00', 'fr-FR', 'Pays non référencé');
INSERT INTO `gen_i18n_pays` VALUES ('cg', 'fr-FR', 'Congo');
INSERT INTO `gen_i18n_pays` VALUES ('gn', 'fr-FR', 'Guinée');
INSERT INTO `gen_i18n_pays` VALUES ('tw', 'fr-FR', 'Taïwan');
INSERT INTO `gen_i18n_pays` VALUES ('la', 'fr-FR', 'Laos');
INSERT INTO `gen_i18n_pays` VALUES ('mm', 'fr-FR', 'Birmanie');



CREATE TABLE `gen_menu` (
  `gm_id_menu` int(11) unsigned NOT NULL default '0',
  `gm_ce_i18n` varchar(8) NOT NULL default '',
  `gm_ce_site` int(11) unsigned NOT NULL default '0',
  `gm_ce_application` int(11) unsigned NOT NULL default '0',
  `gm_application_arguments` text,
  `gm_fichier_squelette` varchar(255) default NULL,
  `gm_code_num` int(11) NOT NULL default '0',
  `gm_code_alpha` varchar(255) NOT NULL default '',
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
);

-- 
-- Contenu de la table `gen_menu`
-- 

INSERT INTO `gen_menu` (`gm_id_menu`, `gm_ce_i18n`, `gm_ce_site`, `gm_ce_application`, `gm_application_arguments`, `gm_fichier_squelette`, `gm_code_num`, `gm_code_alpha`, `gm_nom`, `gm_raccourci_clavier`, `gm_robot`, `gm_titre`, `gm_titre_alternatif`, `gm_mots_cles`, `gm_description_libre`, `gm_description_resume`, `gm_description_table_matieres`, `gm_source`, `gm_auteur`, `gm_contributeur`, `gm_editeur`, `gm_date_creation`, `gm_date_soumission`, `gm_date_acceptation`, `gm_date_publication`, `gm_date_debut_validite`, `gm_date_fin_validite`, `gm_date_copyright`, `gm_licence`, `gm_categorie`, `gm_public`, `gm_public_niveau`, `gm_ce_type_portee_spatiale`, `gm_portee_spatiale`, `gm_ce_type_portee_temporelle`, `gm_portee_temporelle`, `gm_ce_admin`) VALUES 
(2, 'fr', 1, 1, '', '', 2, 'sites', 'Sites', 'S', 'index,follow', 'Administration des sites.', '', 'Administration, sites.', 'Interface d''administration des sites de Papyrus.', 'Administration des sites de Papyrus.', '', '', 'Tela Botanica', '', 'Tela Botanica', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '2004-04-22 21:38:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', 0, '', 0, '', 0),
(3, 'fr', 1, 2, '', '', 3, 'menus', 'Menus', 'M', 'index,follow', '', '', '', '', 'Gestion des menus des différents sites', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '2004-05-06 14:52:48', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', 0, '', 0, '', 0),
(4, 'fr', 1, 3, '', '', 4, 'aide', 'Aide', 'A', 'index,follow', 'Aide des interfaces de Papyrus.', '', 'Aide, Papyrus.', 'Contient une aide sur les interfaces de Papyrus.', 'Une aide sur les interfaces de Papyrus.', '', '', 'Jean-Pascal MILCENT', '', 'Tela Botanica', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '2004-05-04 13:31:26', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', NULL, '', NULL, '', 0),
(5, 'fr', 0, 3, '', '', 5, 'accessibilite', 'Chartre d''accessibilité', 'C', 'index,follow', 'Chartre d''accessibilité.', '', 'accessibilité, chartre, handicap.', 'Fournit des informations sur l''accessibilité de ce site.', 'La chartre d''accessibilité de Tela Botanica.', '', '', 'Installateur Papyrus', '', 'Tela Botanica', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '2004-05-03 19:21:29', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu commun', '', '', NULL, '', NULL, '', 0),
(6, 'fr', 0, 4, '', '', 6, 'plan', 'Plan du site', 'P', 'index,follow', 'Plan du site d''administration.', 'Plan du site d''administration', 'plan, administration.', '', 'Plan du site d''administration de Papyrus.', '', '', 'Installateur Papyrus', '', 'Tela Botanica', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '2004-05-03 19:24:29', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu commun', '', '', NULL, '', NULL, '', 0),
(7, 'fr', 1, 5, '', '', 7, 'admin_auth', 'Identifications', '', 'index,follow', 'Administration des identifications', '', '', '', 'Administration des identifications', '', '', '', '', '', '2004-12-15 14:59:30', '2004-12-15 14:59:30', '2004-12-15 14:59:30', '2004-12-15 14:59:30', '2004-12-15 14:59:30', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', 0, '', 0, '', 1),
(8, 'fr', 1, 6, '', '', 8, 'admin_appli', 'Applications', '', 'index,follow', 'Administration des applications', '', '', '', 'Administration des applications', '', '', '', '', '', '2004-12-15 15:00:52', '2004-12-15 15:00:52', '2004-12-15 15:00:52', '2004-12-15 15:00:52', '2004-12-15 15:00:52', '0000-00-00 00:00:00', '2004-00-00 00:00:00', '', 'menu', '', '', 0, '', 0, '', 1),
(9, 'fr', 0, 3, '', '', 9, 'a_propos', 'A propos', '', 'index,follow', 'A propos de Papyrus', 'A propos de Papyrus', 'A propos de Papyrus', 'A propos de Papyrus', 'A propos de Papyrus', '', '', 'Installateur Papyrus', '', '', '2006-11-30 17:25:56', '2006-11-30 17:25:56', '2006-11-30 17:25:56', '2006-11-30 17:25:56', '2006-11-30 17:25:56', '0000-00-00 00:00:00', '2006-00-00 00:00:00', '', 'menu', '', '', 0, '', 0, '', 1),
(10, 'fr', 1, 17, 'Administration des wikinis', '', 10, 'admin_wikini', 'Wikinis', '', 'index,follow', 'Administration des wikinis', 'Administration des wikinis', 'Administration des wikinis', 'Administration des wikinis', 'Administration des wikinis', 'Administration des wikinis', '', 'Florian Schmitt', '', 'Tela Botanica', '2006-11-30 17:43:22', '2006-11-30 17:43:22', '2006-11-30 17:43:22', '2006-11-30 17:43:22', '2006-11-30 17:43:22', '0000-00-00 00:00:00', '2006-00-00 00:00:00', '', 'menu', '', '', 0, '', 0, '', 1),
(11, 'fr', 1, 23, '', '', 11, 'admin_annuaire', 'Administration de l\'annuaire', '', 'noindex', 'Administration de l\'annuaire', '', '', '', 'Administration de l\'annuaire', '', '', 'Administration de l\'annuaire', '', '', '2007-04-20 15:34:54', '2007-04-20 15:34:54', '2007-04-20 15:34:54', '2007-04-20 15:34:54', '2007-04-20 15:34:54', '0000-00-00 00:00:00', '2007-00-00 00:00:00', '', 'menu', '', '', 0, '', 0, '', 1);


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
);

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
);

-- 
-- Contenu de la table `gen_menu_categorie`
-- 

INSERT INTO `gen_menu_categorie` (`gmca_id_categorie`, `gmca_intitule_categorie`) VALUES 
(1, 'Relation entre menus'),
(2, 'Type de menu');

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
);

-- 
-- Contenu de la table `gen_menu_categorie_valeur`
-- 

INSERT INTO `gen_menu_categorie_valeur` (`gmcv_id_valeur`, `gmcv_id_categorie`, `gmcv_intitule_valeur`) VALUES 
(1, 1, 'avoir père'),
(2, 1, 'avoir traduction'),
(101, 2, 'défaut'),
(102, 2, 'commun'),
(103, 2, 'traduction'),
(104, 2, 'copyright'),
(3, 1, 'avoir suivant logique'),
(4, 1, 'avoir précédent logique'),
(100, 2, 'menu classique');

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
);

-- 
-- Contenu de la table `gen_menu_contenu`
-- 

INSERT INTO `gen_menu_contenu` (`gmc_id_contenu`, `gmc_ce_admin`, `gmc_ce_menu`, `gmc_ce_type_contenu`, `gmc_contenu`, `gmc_ce_type_modification`, `gmc_resume_modification`, `gmc_date_modification`, `gmc_bool_dernier`) VALUES 
(1, 1, 4, 1, '<h1>Aide</h1>\r\n<p>Ici figurera l''aide de Papyrus!</p>', 2, 'Origine', '2004-10-14 17:57:29', 1),
(2, 1, 5, 1, '<h1>Accessibilité</h1>\r\n<p>Ici figurera la charte d''accessibilité de Papyrus!</p>', 2, 'Origine', '2004-10-14 17:58:09', 1),
(3, 1, 9, 1, '<h1>A propos de Papyrus</h1>\r\nPapyrus est un intégrateur d&#8217;application et un système de gestion de contenu pour l&#8217;Internet, issu de l''expérience des réseaux collaboratifs.<br />\r\n<br />\r\n<h3>Auteurs , Contributeurs:</span></h3>\r\n<strong>Développement:</strong><br />\r\nJean Pascal MILCENT (Tela Botanica)<br />\r\nAlexandre GRANIER (Tela Botanica)<br />\r\nDavid DELON<br />\r\nFlorian SCHMITT (Réseau Ecole et Nature)<br /><br />\r\n<strong>Graphisme:</strong><br />\r\nJessica DESCHAMPS (Réseau Ecole et Nature)<br />\r\n<br style="font-weight: bold;" />\r\n<span style="font-weight: bold;">Logiciels libre utilisés:</span><br />\r\nwikini<br />\r\nphorum<br />\r\nfckeditor<br />\r\nPEAR<br />\r\nApache, PHP, MYSQL', 1, '', '2006-11-30 17:33:10', 1);

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
);

-- 
-- Contenu de la table `gen_menu_relation`
-- 

INSERT INTO `gen_menu_relation` (`gmr_id_menu_01`, `gmr_id_menu_02`, `gmr_id_valeur`, `gmr_ordre`) VALUES 
(2, 0, 1, 2),
(3, 0, 1, 1),
(5, 5, 102, 1),
(6, 0, 1, 2),
(4, 4, 100, 4),
(4, 0, 1, 5),
(2, 2, 100, 2),
(3, 3, 100, 3),
(5, 0, 1, 1),
(6, 6, 102, 2),
(7, 0, 1, 3),
(8, 0, 1, 4),
(7, 7, 100, 4),
(8, 8, 100, 5),
(9, 0, 1, 3),
(9, 9, 102, 3),
(10, 1, 1, 5),
(10, 10, 100, 6),
(11, 0, 1, 5),
(11, 11, 100, 5);

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
);

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
  `gs_url` varchar(255),
  `gs_fichier_squelette` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`gs_id_site`)
);

-- 
-- Contenu de la table `gen_site`
-- 

INSERT INTO `gen_site` VALUES (1, 1, 'fr', 1, 100, 'admin', 'Administration', '', 'Administration de Papyrus.', 'Administration, Papyrus.', 'Site de test de l''administration de Papyrus.', 'Tela Botanica', '2004-07-06 19:06:16', '', 'admin.html');

-- --------------------------------------------------------

-- 
-- Structure de la table `gen_site_auth`
-- 

CREATE TABLE `gen_site_auth` (
  `gsa_id_auth` int(10) unsigned NOT NULL default '0',
  `gsa_nom` varchar(100) NOT NULL default '',
  `gsa_abreviation` VARCHAR(255) NOT NULL default '',
  `gsa_ce_auth_bdd` int(11) unsigned NOT NULL default '0',
  `gsa_ce_auth_ldap` int(10) unsigned NOT NULL default '0',
  `gsa_ce_type_auth` int(11) unsigned default NULL,
  PRIMARY KEY  (`gsa_id_auth`),
  KEY `idx_fk_gsa_ce_auth_ldap` (`gsa_ce_auth_ldap`),
  KEY `idx_fk_gsa_ce_auth_bdd` (`gsa_ce_auth_bdd`)
);

-- 
-- Contenu de la table `gen_site_auth`
-- 
INSERT INTO `gen_site_auth` VALUES (0, 'Aucune identification', 'aucune', 0, 0, 0);
INSERT INTO `gen_site_auth` VALUES (1, 'Administrateur de Papyrus', 'admin_papyrus_', 1, 0, 1);
INSERT INTO `gen_site_auth` VALUES (2, 'Annuaire des utilisateurs', 'utilisateur_papyrus_', 2, 0, 1);

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
  `gsab_parametres` varchar(255),
  PRIMARY KEY  (`gsab_id_auth_bdd`)
);

-- 
-- Contenu de la table `gen_site_auth_bdd`
-- 

INSERT INTO `gen_site_auth_bdd` VALUES (0, NULL, NULL, NULL, NULL, NULL, NULL);

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
);

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
);

-- 
-- Contenu de la table `gen_site_categorie`
-- 

INSERT INTO `gen_site_categorie` VALUES (1, 'Relation entre sites');
INSERT INTO `gen_site_categorie` VALUES (2, 'Type de site');
INSERT INTO `gen_site_categorie` VALUES (3, 'Type de site externe');
-- --------------------------------------------------------

-- 
-- Structure de la table `gen_site_categorie_valeur`
-- 

CREATE TABLE `gen_site_categorie_valeur` (
  `gscv_id_valeur` int(11) unsigned NOT NULL auto_increment,
  `gscv_id_categorie` int(10) unsigned NOT NULL default '0',
  `gscv_intitule_valeur` varchar(255) default NULL,
  PRIMARY KEY  (`gscv_id_valeur`)
);

-- 
-- Contenu de la table `gen_site_categorie_valeur`
-- 

INSERT INTO `gen_site_categorie_valeur` VALUES (1, 1, 'avoir traduction');
INSERT INTO `gen_site_categorie_valeur` VALUES (2, 1, 'avoir suivant');
INSERT INTO `gen_site_categorie_valeur` VALUES (101, 2, 'défaut');
INSERT INTO `gen_site_categorie_valeur` VALUES (102, 2, 'principal');
INSERT INTO `gen_site_categorie_valeur` VALUES (103, 2, 'externe');
INSERT INTO `gen_site_categorie_valeur` VALUES (200, 3, 'Spip');
INSERT INTO `gen_site_categorie_valeur` VALUES (201, 3, 'Wikini');
INSERT INTO `gen_site_categorie_valeur` VALUES (202, 3, 'Papyrus');

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
);

-- 
-- Contenu de la table `gen_site_relation`
-- 

INSERT INTO `gen_site_relation` VALUES (1, 1, 101, NULL);
INSERT INTO `gen_site_relation` VALUES (1, 1, 102, 1);
