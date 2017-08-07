<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Recherche.                                                               |
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
// CVS : $Id: efsa_config.inc.php,v 1.2 2006-04-26 16:57:04 ddelon Exp $
/**
* Fichier de configuration d'eFlore-Recherche.
*
* Fichier contenant des constantes et des variables globales permettant de
* configurer eFlore-recherche.
*
*@package ef_recherche
*@subpackage configuration
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.2 $ $Date: 2006-04-26 16:57:04 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// Définition des chemins de fichiers.
/** Constante stockant l'URL de base de l'application saisie de noms */
define('EFSA_CHEMIN_APPLI', EF_CHEMIN_MODULE.'ef_saisie/');
/** Constante stockant le chemin vers le dossier actions.*/
define('EFSA_CHEMIN_ACTION', EFSA_CHEMIN_APPLI.'actions/');
/** Constante stockant le chemin vers le dossier configuration.*/
define('EFSA_CHEMIN_CONFIG', EFSA_CHEMIN_APPLI.'configuration/');
/** Constante stockant le chemin vers le dossier présentations.*/
define('EFSA_CHEMIN_PRESENTATION', EFSA_CHEMIN_APPLI.'presentations/');
/** Constante stockant le chemin vers le dossier vues.*/
define('EFSA_CHEMIN_VUE', EFSA_CHEMIN_PRESENTATION.'vues/');
/** Constante stockant le chemin vers le dossier squelettes.*/
define('EFSA_CHEMIN_SQUELETTE', EFSA_CHEMIN_PRESENTATION.'squelettes/');


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efsa_config.inc.php,v $
* Revision 1.2  2006-04-26 16:57:04  ddelon
* Fusion bdnbe + saisie assistee
*
* Revision 1.1.2.1  2006/04/21 20:50:27  ddelon
* Saisie continue
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>