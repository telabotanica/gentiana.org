<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of Integrateur Wikini.                                                             |
// |                                                                                                      |
// | Foobar is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | Foobar is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: iw_config.inc.php,v 1.10 2007-04-11 08:30:12 neiluj Exp $
/**
* Configuration de l'intégrateur de page Wikini
*
* Fichier de configuration de l'intégrateur de page Wikini
*
*@package IntegrateurWikini
*@subpackage Configuration
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.10 $ $Date: 2007-04-11 08:30:12 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// Définition de la langue
/** Constante stockant la valeur i18n fournie par Papyrus et pouvant être passée dans l'url.*/
define('IW_I18N', $GLOBALS['_GEN_commun']['i18n']);

// +------------------------------------------------------------------------------------------------------+
// Définition des chemins de fichiers.
/** Constante stockant le chemin du dossier racine.*/
define('IW_CHEMIN_RACINE', GEN_CHEMIN_CLIENT.'integrateur_wikini'.GEN_SEP);
/** Constante stockant le chemin du dossier contenant les traductions.*/
define('IW_CHEMIN_LANGUES', IW_CHEMIN_RACINE.'langues'.GEN_SEP);
/** Constante stockant le chemin du dossier contenant la bibliothèque de code.*/
define('IW_CHEMIN_BIBLIO', IW_CHEMIN_RACINE.'bibliotheque'.GEN_SEP);
/** Constante stockant le chemin du dossier contenant la bibliothèque Wikini.*/
define('IW_CHEMIN_BIBLIO_WIKINI', IW_CHEMIN_BIBLIO.'wikini'.GEN_SEP);
/** Constante stockant le chemin du dossier contenant la bibliothèque Wikini.*/
define('IW_CHEMIN_BIBLIO_ACEDITOR', IW_CHEMIN_BIBLIO.'ACeditor'.GEN_SEP);
/** Constante stockant le chemin du dossier contenant les sites Wikini.*/
define('IW_CHEMIN_WIKINI', GEN_CHEMIN_WIKINI);
/** Chemin vers la bibliothèque API.*/
define('IW_CHEMIN_BIBLIOTHEQUE_API', GEN_CHEMIN_API);
/** Chemin vers la bibliothèque API : fckeditor.*/

// TODO : un wiki par défaut pour chaque papyrus à l'installation de Papyrus
if (!isset($GLOBALS['_GEN_commun']['info_application']->wikini)) {
   $GLOBALS['_GEN_commun']['info_application']->wikini = 'defaut';
}

$config_wikini = adwi_valeurs_par_code_alpha($GLOBALS['_GEN_commun']['info_application']->wikini,&$GLOBALS['_GEN_commun']['pear_db'] );

// Parametres de base de donnée de Papyrus par défaut  


if ((!isset($config_wikini['bdd_hote'])) || (empty($config_wikini['bdd_hote']))) {
   $config_wikini['bdd_hote'] = PAP_BDD_SERVEUR;
}

if ((!isset($config_wikini['bdd_nom'])) || (empty($config_wikini['bdd_nom'])))  {
   $config_wikini['bdd_nom'] = PAP_BDD_NOM;
}

if ((!isset($config_wikini['bdd_utilisateur'])) || (empty($config_wikini['bdd_utilisateur'])))  {
   $config_wikini['bdd_utilisateur'] = PAP_BDD_UTILISATEUR;
}

if ((!isset($config_wikini['bdd_mdp'])) || (empty($config_wikini['bdd_mdp'])))  {
   $config_wikini['bdd_mdp'] = PAP_BDD_MOT_DE_PASSE;
}

if ((!isset($config_wikini['table_prefix'])) || (empty($config_wikini['table_prefix'])))  {
	$config_wikini['table_prefix'] = $GLOBALS['_GEN_commun']['info_application']->wikini.'_';
}
	

// Ordre de selection de la page de demarrage :
// Page Specifiee dans le menu 
// Page par defaut du Wiki enregistré
// PagePrincipale

if ((!isset($GLOBALS['_GEN_commun']['info_application']->page))  ||  (empty($GLOBALS['_GEN_commun']['info_application']->page))) {
	if ((!isset($config_wikini['page']))  || (empty($config_wikini['page']))) {
   		$config_wikini['page'] = 'PagePrincipale';
	}
}
else {
	$config_wikini['page'] = $GLOBALS['_GEN_commun']['info_application']->page;
}

if ((!isset($config_wikini['code_alpha_wikini'])) || (empty($config_wikini['code_alpha_wikini'])))  {
   $config_wikini['code_alpha_wikini'] = $GLOBALS['_GEN_commun']['info_application']->wikini;
}

/** Constante stockant le chemin du dossier contenant le site Wikini en cours */

/** Utilité ? **/ 
if ((!isset($config_wikini['chemin'])) || (empty($config_wikini['chemin'])))  {
	define('IW_CHEMIN_WIKINI_COURANT', GEN_CHEMIN_WIKINI.$config_wikini['code_alpha_wikini'].GEN_SEP);
}
else {
	define('IW_CHEMIN_WIKINI_COURANT',$config_wikini['chemin'].GEN_SEP);
}

/** Constante stockant le chemin du dossier contenant le site Wikini en cours */
define('IW_CHEMIN_WIKINI_COURANT_FORMATTER', IW_CHEMIN_WIKINI_COURANT.'formatters'.GEN_SEP);
  
global $wikini_config_defaut;
// Ajout dans l'URL générale du Query String wiki spécifique à l'intégrateur
$GLOBALS['_GEN_commun']['url']->addQueryString('wiki', '');
$wikini_config_defaut = array(
    "wakka_version" => "0.1.1",
	"wikini_version" => "0.4.3",
    'mysql_host'            => $config_wikini['bdd_hote'],
    'mysql_database'        => $config_wikini['bdd_nom'],
    'mysql_user'            => $config_wikini['bdd_utilisateur'],
    'mysql_password'        => $config_wikini['bdd_mdp'],
    'table_prefix'          => $config_wikini['table_prefix'],
    'root_page'             => $config_wikini['page'],
    'wakka_name'            => $config_wikini['code_alpha_wikini'],
    'base_url'              => str_replace('&amp;', '&', $GLOBALS['_GEN_commun']['url']->getUrl()),
    'rewrite_mode'          => '0',
    'meta_keywords'         => '',
    'meta_description'      => '',
    'action_path'           => IW_CHEMIN_WIKINI_COURANT.'actions',
    'handler_path'          => IW_CHEMIN_WIKINI_COURANT.'handlers',
    'header_action'         => 'header',
    'footer_action'         => 'footer',
    'navigation_links'      => 'DerniersChangements :: DerniersCommentaires :: ParametresUtilisateur',
    'referrers_purge_time'  => 24,
    'pages_purge_time'      => 90,
    'default_write_acl'     => '*',
    'default_read_acl'      => '*',
    'default_comment_acl'   => '*',
    'preview_before_save'   => '0');
// Suppression de l'URL générale du Query String wiki spécifique à l'intégrateur
$GLOBALS['_GEN_commun']['url']->removeQueryString('wiki', '');
// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: iw_config.inc.php,v $
* Revision 1.10  2007-04-11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.8  2006/11/09 17:50:41  jp_milcent
* Compatibilité avec les nouveaux permaliens de Papyrus.
*
* Revision 1.7  2005/09/14 09:12:15  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.6  2005/09/09 09:37:17  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.5  2005/09/06 08:35:36  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.4  2005/09/02 11:29:25  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.3  2005/08/31 17:34:52  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.2  2005/08/25 08:59:12  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.1  2005/03/02 17:47:05  jpm
* Ajout des fichiers necessaires à l'intégrateur de wikini.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>