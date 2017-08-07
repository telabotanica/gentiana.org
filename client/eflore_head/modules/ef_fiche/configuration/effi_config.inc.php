<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-fiche.                                                                   |
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
// CVS : $Id: effi_config.inc.php,v 1.2 2006-05-11 10:28:27 jp_milcent Exp $
/**
* Fichier de configuration du module d'eFlore-Fiche.
*
* Fichier contenant des constantes et des variables globales permettant de
* configurer le module eFlore-Fiche.
*
*@package eflore
*@subpackage ef_fiche 
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.2 $ $Date: 2006-05-11 10:28:27 $
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
/** Constante stockant l'URL de base du module eFlore-Fiche.*/
define('EFFI_CHEMIN_APPLI', EF_CHEMIN_MODULE.'ef_fiche/');
/** Constante stockant l'URL de base du module eFlore-Fiche.*/
define('EFFI_CHEMIN_APPLI_RELATIF', EF_CHEMIN_MODULE_RELATIF.'ef_fiche/');
/** Constante stockant le chemin vers le dossier actions.*/
define('EFFI_CHEMIN_ACTION', EFFI_CHEMIN_APPLI.'actions/');
/** Constante stockant le chemin vers le dossier configuration.*/
define('EFFI_CHEMIN_CONFIG', EFFI_CHEMIN_APPLI.'configuration/');
/** Constante stockant le chemin vers le dossier langues.*/
define('EFFI_CHEMIN_LANGUE', EFFI_CHEMIN_APPLI.'langues/');
/** Constante stockant le chemin vers le dossier présentations.*/
define('EFFI_CHEMIN_PRESENTATION', EFFI_CHEMIN_APPLI.'presentations/');
/** Constante stockant le chemin relatif vers le dossier présentations.*/
define('EFFI_CHEMIN_PRESENTATION_RELATIF', EFFI_CHEMIN_APPLI_RELATIF.'presentations/');
/** Constante stockant le chemin vers le dossier vues.*/
define('EFFI_CHEMIN_VUE', EFFI_CHEMIN_PRESENTATION.'vues/');
/** Constante stockant le chemin vers le dossier squelettes.*/
define('EFFI_CHEMIN_SQUELETTE', EFFI_CHEMIN_PRESENTATION.'squelettes/');
/** Constante stockant le chemin relatif vers le dossier images.*/
define('EFFI_CHEMIN_IMAGE_RELATIF', EFFI_CHEMIN_PRESENTATION_RELATIF.'images/');


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_config.inc.php,v $
* Revision 1.2  2006-05-11 10:28:27  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.1  2005/09/14 16:57:58  jp_milcent
* Début gestion des fiches, onglet synthèse.
* Amélioration du modèle et des objets DAO.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>