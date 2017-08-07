<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
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
// CVS : $Id: ef_config_papyrus.inc.php,v 1.5 2007-07-17 07:48:23 jp_milcent Exp $
/**
* eflore_bp - ef_config_papyrus.inc.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.5 $ $Date: 2007-07-17 07:48:23 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// Redéfini le séparateur utilisé lorsque PHP génère des URLs pour séparer les arguments. (compatible XHTML strict)
ini_set('arg_separator.input', '&amp;');
ini_set('arg_separator.output', '&amp;');
$GLOBALS['_GEN_commun']['i18n'] = 'fr';
$GLOBALS['_DEBOGAGE_'] = '';
session_name('eflore_beta');
session_start();
$expiration = 60*60*60;
setcookie(session_name(),session_id(), time()+$expiration, '/');
$GLOBALS['_GEN_commun']['url'] = new Net_URL('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);

// Initialisation du gestionnaire d'erreur
$GLOBALS['_EFLORE_']['erreur'] = new GestionnaireErreur(EF_DEBOGAGE_CONTEXTE);
$GLOBALS['_EFLORE_']['erreur']->setNiveauErreurCourrant(EF_DEBOGAGE_NIVEAU);
$GLOBALS['_PAPYRUS_']['erreur'] =& $GLOBALS['_EFLORE_']['erreur'];

// On n'oublie pas les parametres bases de données, on en a  besoin pour les 
// Wikini par exemple
define('GEN_SEP', '/');
define('PAP_BDD_SERVEUR', EF_BDD_SERVEUR);
define('PAP_BDD_NOM', EF_BDD_NOM_PRINCIPALE);
define('PAP_BDD_UTILISATEUR', EF_BDD_UTILISATEUR);
define('PAP_BDD_MOT_DE_PASSE', EF_BDD_MOT_DE_PASSE);
$GLOBALS['_GEN_commun']['pear_db'] = DB::connect($GLOBALS['_EFLORE_']['dsn']);
if (PEAR::isError($GLOBALS['_GEN_commun']['pear_db'])) {
	$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $GLOBALS['_GEN_commun']['pear_db']->getMessage());
	die('<pre>'.print_r($e, true).'</pre>');
}

// Gestion de l'identification : nécessaire pour le fonctionnement de Wikini
$GLOBALS['_EFLORE_']['identification'] = new EfloreIdentification();
$GLOBALS['_GEN_commun']['pear_auth'] = $GLOBALS['_EFLORE_']['identification']->getIdentification(); // Retourne l'objet Auth

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ef_config_papyrus.inc.php,v $
* Revision 1.5  2007-07-17 07:48:23  jp_milcent
* Ajout et modification des fichiers nécessaires aux services web.
*
* Revision 1.4  2007-07-10 16:47:59  jp_milcent
* Amélioration de la gestion de Auth pour Wikini hors de Papyrus.
*
* Revision 1.3  2007-07-09 15:45:21  jp_milcent
* Ajout de la gestion de arg_separator.input
*
* Revision 1.2  2007-01-19 13:48:04  jp_milcent
* Ajout dans Auth d'une méthode pour le wikini.
*
* Revision 1.1.2.1  2007/01/18 17:37:46  ddelon
* bug integration wiki eflore
*
* Revision 1.1  2007/01/05 14:25:01  jp_milcent
* Ajout d'un fichier contenant tout le code permettant le fonctionnement hors de Papyrus.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
