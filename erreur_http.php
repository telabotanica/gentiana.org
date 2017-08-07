<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of Papyrus.                                                                        |
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
// CVS : $Id: erreur_http.php,v 1.3 2007-04-19 16:53:20 neiluj Exp $
/**
* Gestion des erreurs HTTP
*
* Permet d'afficher les pages d'erreur HTTP pr�sentes dans Papyrus
*
*@package Papyrus
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.3 $ $Date: 2007-04-19 16:53:20 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// D�finission de constantes
/** Chemin et nom du fichier de configuration principal de Papyrus.*/
define('PAP_FICHIER_CONFIG', 'papyrus/configuration/pap_config.inc.php');
/** Chemin et nom du fichier de configuration avanc�e de Papyrus.*/
define('PAP_FICHIER_CONFIG_AVANCEE', 'papyrus/configuration/pap_config_avancee.inc.php');
/** Chemin et nom du fichier Pear HTTP.*/
define('PAP_FICHIER_PEAR_HTTP', 'api/pear/HTTP.php');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// Nous v�rifions que ce fichier n'est pas acc�d� directement 
if (!isset($_SERVER['REDIRECT_STATUS'])) {
	header('Location: /');	
}
// +------------------------------------------------------------------------------------------------------+
// Recherche du chemin vers papyrus.
preg_match('/^(\/.*?)([^\/]+?)(?:\?(.*)|)$/', $_SERVER['REQUEST_URI'], $tab_raccourci);
$raccourci = $tab_raccourci[2];
$chemin_papyrus = $tab_raccourci[1];
$parametres = '';
if (isset($tab_raccourci[2])) {
    $parametres = $tab_raccourci[2];
}
// Inclusion des fichiers, si �chec on redirige vers la racine du site
if (file_exists(PAP_FICHIER_CONFIG) && file_exists(PAP_FICHIER_CONFIG_AVANCEE) && file_exists(PAP_FICHIER_PEAR_HTTP)) {
    /** Inclusion du fichier de configuration de Papyrus permettant de se conecter � la base de donn�es. */
    require_once PAP_FICHIER_CONFIG;
    /** Inclusion du fichier de configuration de Papyrus permettant d'avoir des infos sur la structure de l'url. */
    require_once PAP_FICHIER_CONFIG_AVANCEE;
    /** Inclusion de l'objet PEAR servant � n�gocier le language avec le navigateur client. */
    require_once PAP_FICHIER_PEAR_HTTP;
} else {
	header('Location: /');
}
// Utilisation de la fonction statique de Pear HTTP pour n�gocier l'i18n.
$aso_i18n_possible = array(GEN_I18N_ID_DEFAUT => true);
$i18n = HTTP::negotiateLanguage($aso_i18n_possible, GEN_I18N_ID_DEFAUT);
// Redirection vers le fichier erreur de Papyrus s'il existe
$fichier_erreur = sprintf(PAP_FICHIER_ERREUR_HTTP, $i18n, $_GET['erreur']);
if (file_exists($fichier_erreur)) {
    header ('Location: '.dirname(PAP_URL).sprintf(PAP_URL_ERREUR_HTTP, $i18n, $_GET['erreur'], $_SERVER['REQUEST_URI']));
} else {
    echo 	'ERREUR Papyrus : Impossible de trouver le fichier de l\'erreur '.$_GET['erreur'].'<br />'.
			'Chemin fichier erreur : '.$fichier_erreur.' <br />'.
			'Veuillez le cr�er ou supprimer l\'entr�e correspondante dans le fichier .htaccess.<br />'.
			'Ligne n� : '. __LINE__ .'<br />'.
			'Fichier : '. __FILE__ ;
}
exit(0);

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: erreur_http.php,v $
* Revision 1.3  2007-04-19 16:53:20  neiluj
* fix du chemin erreur http lorsque papyrus n'est pas installé à la racine du serveur
*
* Revision 1.2  2006/10/26 16:29:52  jp_milcent
* Correction erreur redirection en boucle.
*
* Revision 1.1  2006/10/18 10:18:05  jp_milcent
* Gestion des erreurs HTTP par Papyrus.
*
* Revision 1.5  2006/10/18 09:27:32  jp_milcent
* Gestion des erreurs 404 uniquement.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>