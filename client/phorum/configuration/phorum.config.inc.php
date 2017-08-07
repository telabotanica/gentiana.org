<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or                                        |
// | modify it under the terms of the GNU Lesser General Public                                           |
// | License as published by the Free Software Foundation; either                                         |
// | version 2.1 of the License, or (at your option) any later version.                                   |
// |                                                                                                      |
// | This library is distributed in the hope that it will be useful,                                      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU                                    |
// | Lesser General Public License for more details.                                                      |
// |                                                                                                      |
// | You should have received a copy of the GNU Lesser General Public                                     |
// | License along with this library; if not, write to the Free Software                                  |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id$
/**
* Fichier de configuration du phorum
*
* A �diter de fa�on sp�cifique � chaque d�ploiement
*
*@package bazar
//Auteur original :
*@author        Florian SCHMITT <florian@ecole-et-nature.org>
//Autres auteurs :
*@copyright     Outils-Reseaux 2006-2010
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

//===================================== CHEMINS ====================================
/** Chemin des sources de l'application phorum (mettre un / � la fin) */
define ('PHO_CHEMIN_SOURCES_APPLI', PAP_CHEMIN_RACINE.'client/phorum/bibliotheque/phorum/');
// set the Phorum install dir
$PHORUM_DIR=PHO_CHEMIN_SOURCES_APPLI;


// needed to really load the alternate db-config in common.php
define("PHORUM_WRAPPER",1);

//teste si l'on est dans l'application Papyrus
if (!defined('PAP_VERSION')) { //pas dans Papyrus
	//================================ BASE DE DONNEES =================================
	$PHORUM['DBCONFIG']=array(	
	    // Database connection.
	    'type'          =>  'mysql',
	    'name'          =>  'papyrus',
	    'server'        =>  'localhost',
	    'user'          =>  'root',
	    'password'      =>  'fs1980',
	    'table_prefix'  =>  'phorum',
	    'mysql_use_ft'  =>  '1'
	);
} else { //dans Papyrus
	//================================ BASE DE DONNEES =================================	
	/** Variable globale contenant l'objet d'acc�s � la base de donn�es de l'application, un objet DB*/
	$GLOBALS['_PHORUM_']['db'] =& $GLOBALS['_GEN_commun']['pear_db'];		
	// set the databse settings for this Phorum Install
	$PHORUM['DBCONFIG']=array(	
	    // Database connection.
	    'type'          =>  $GLOBALS['_PHORUM_']['db']->dsn['dbsyntax'],
	    'name'          =>  $GLOBALS['_PHORUM_']['db']->dsn['database'],
	    'server'        =>  $GLOBALS['_PHORUM_']['db']->dsn['hostspec'],
	    'user'          =>  $GLOBALS['_PHORUM_']['db']->dsn['username'],
	    'password'      =>  $GLOBALS['_PHORUM_']['db']->dsn['password'],
	    'table_prefix'  =>  'phorum',
	    'mysql_use_ft'  =>  '1'
	);
	
	//=========================AUTHENTIFICATION=================================
	/** Variable globale contenant l'objet d'authentification de l'application, un objet AUTH*/
	$GLOBALS['_PHORUM_']['AUTH'] =& $GLOBALS['_GEN_commun']['pear_auth'];
	
	//==================================== LES URLS ====================================
	/** Variable globale contenant l'objet d'acc�s � l'URL de base de l'application, un objet Net_URL*/
	$GLOBALS['_PHORUM_']['url'] =& $GLOBALS['_GEN_commun']['url'];

	//===================================== LANGUES ====================================
	/** Choix de la langue par d�faut de l'application */
	define ('PHO_LANGUE_DEFAUT', $GLOBALS['_GEN_commun']['i18n']) ;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.1  2006-04-28 12:40:44  florian
* Intégration de phorum, pas encore finalisée
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
