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
// CVS : $Id: efre_config.inc.php,v 1.2 2005-08-11 10:15:49 jp_milcent Exp $
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
*@version       $Revision: 1.2 $ $Date: 2005-08-11 10:15:49 $
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
/** Constante stockant l'URL de base de l'application recherche de plante.*/
define('EFRE_CHEMIN_APPLI', EF_CHEMIN_MODULE.'ef_recherche/');
/** Constante stockant le chemin vers le dossier actions.*/
define('EFRE_CHEMIN_ACTION', EFRE_CHEMIN_APPLI.'actions/');
/** Constante stockant le chemin vers le dossier configuration.*/
define('EFRE_CHEMIN_CONFIG', EFRE_CHEMIN_APPLI.'configuration/');
/** Constante stockant le chemin vers le dossier langues.*/
define('EFRE_CHEMIN_LANGUE', EFRE_CHEMIN_APPLI.'langues/');
/** Constante stockant le chemin vers le dossier présentations.*/
define('EFRE_CHEMIN_PRESENTATION', EFRE_CHEMIN_APPLI.'presentations/');
/** Constante stockant le chemin vers le dossier vues.*/
define('EFRE_CHEMIN_VUE', EFRE_CHEMIN_PRESENTATION.'vues/');
/** Constante stockant le chemin vers le dossier squelettes.*/
define('EFRE_CHEMIN_SQUELETTE', EFRE_CHEMIN_PRESENTATION.'squelettes/');


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_config.inc.php,v $
* Revision 1.2  2005-08-11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.1  2005/08/01 16:18:40  jp_milcent
* Début gestion résultat de la recherche par nom.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>