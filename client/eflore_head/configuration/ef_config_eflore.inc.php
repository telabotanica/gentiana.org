<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                         |
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
// CVS : $Id: ef_config_eflore.inc.php,v 1.6 2007-02-07 18:04:44 jp_milcent Exp $
/**
* Eflore : constantes de configuration des valeurs issues de la base de données
*
* Contient les constantes de configurations des paramêtres issus de la base de données.
*
*@package eFlore
*@subpackage configuration
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.6 $ $Date: 2007-02-07 18:04:44 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// Constante spécifique à  eFlore

// EFLORE_PROJET_VERSION
/** Constante stockant l'id du projet BDNFF.*/
define('EF_PR_BDNFF_ID', 1000);
/** Constante stockant l'id du projet BDNFF.*/
define('EF_PR_BDNBE_ID', 1006);
/** Constante stockant l'id de la dernière version du projet BDNFF.*/
define('EF_PRV_DERNIERE_VERSION_BDNFF_ID', 25);
/** Constante stockant l'id de la version de projet par défaut pour les notions chorologiques.*/
define('EF_PRV_NOTION_CHORO_DEFAUT_ID', 13);
/** Constante stockant l'id de la version de projet par défaut pour les données chorologiques.*/
define('EF_PRV_DONNEE_CHORO_DEFAUT_ID', 12);
/** Constante stockant l'id de la version du projet pour les données d'Xper stockées dans le module Info Txt.*/
define('EF_PRV_INFO_TXT_XPER_ID', 27);

// EFLORE_NOM_RANG
/** Constante stockant l'id du rang Famille.*/
define('EF_RANG_FAMILLE_ID', 120);
/** Constante stockant l'id du rang Genre.*/
define('EF_RANG_GENRE_ID', 160);
/** Constante stockant l'id du rang Espèce.*/
define('EF_RANG_SP_ID', 240);
/** Constante stockant l'id du rang par défaut.*/
define('EF_RANG_DEFAUT_ID', EF_RANG_FAMILLE_ID);

// EFLORE_SELECTION_NOM_STATUT
/** Constante stockant l'id du statut "Non renseigné".*/
define('EF_SNS_NULL', 0);
/** Constante stockant l'id du statut "Inconnu".*/
define('EF_SNS_INCONNU', 1);
/** Constante stockant l'id du statut "Problème".*/
define('EF_SNS_PROBLEME', 2);
/** Constante stockant l'id du statut "Nom retenu".*/
define('EF_SNS_RETENU', 3);
/** Constante stockant l'id du statut "Synonyme taxonomique".*/
define('EF_SNS_SYNONYME_TAXONOMIQUE', 4);
/** Constante stockant l'id du statut "Synonyme nomenclatural".*/
define('EF_SNS_SYNONYME_NOMENCLATURAL', 5);
/** Constante stockant l'id du statut "Synonyme indéterminé".*/
define('EF_SNS_SYNONYME_INDETERMINE', 6);
/** Constante stockant l'id du statut "Inclu dans".*/
define('EF_SNS_INCLU_DANS', 7);
/** Constante stockant l'id du statut "Au sens de".*/
define('EF_SNS_AU_SENS_DE', 8);
/** Constante stockant l'id du statut "Synonyme provisoire".*/
define('EF_SNS_SYNONYME_PROVISOIRE', 9);

// EFLORE_VERNACULAIRE_CONSEIL_EMPLOI
/** Constante stockant l'id du conseil d'emploi des noms vernaculaires "Recommandé ou typique".*/
define('EF_VERNA_EMPLOI_RECOMMANDE_ID', 3);

// EFLORE_TAXON_CATEGORIE
/** Constante stockant l'id de la catégorie "Relation".*/
define('EF_TC_RELATION_ID', 3);

// EFLORE_TAXON_VALEUR
/** Constante stockant l'id de la valeur "avoir père".*/
define('EF_TV_AVOIR_PERE_ID', 3);


// EFLORE_LANGUE
/** Constante stockant l'id de la version du projet de langue ISO-639-1.*/
define('EF_LG_ISO_639_1_VERSION_ID', 14);
/** Constante stockant l'id de la version du projet de langue ISO-639-2B.*/
define('EF_LG_ISO_639_2B_VERSION_ID', 15);
/** Constante stockant l'id de la version du projet de langue ISO-639-2T.*/
define('EF_LG_ISO_639_2T_VERSION_ID', 16);
/** Constante stockant l'id de la version du projet de langue par défaut.*/
define('EF_LG_DEFAUT_VERSION_ID', EF_LG_ISO_639_2T_VERSION_ID);
/** Constante stockant l'id de la langue "Français" dans la version du projet de langue par défaut.*/
define('EF_LG_ISO_639_1_FR_ID', 49);
/** Constante stockant l'id de la langue "Français" dans la version du projet de langue par défaut.*/
define('EF_LG_ISO_639_2B_FR_ID', 136);
/** Constante stockant l'id de la langue "Français" dans la version du projet de langue par défaut.*/
define('EF_LG_ISO_639_2T_FR_ID', 136);
/** Constante stockant l'id de la langue "Français" dans la version du projet de langue par défaut.*/
define('EF_LG_DEFAUT_FR_ID', EF_LG_ISO_639_2T_FR_ID);

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ef_config_eflore.inc.php,v $
* Revision 1.6  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.5.2.1  2007/02/07 10:46:48  jp_milcent
* Ajout de l'id du projet de la BDNBE.
*
* Revision 1.5  2006/12/22 16:51:44  jp_milcent
* Ajout de constantes stockant des id de projet.
*
* Revision 1.4  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.3.4.1  2006/09/06 11:15:19  jp_milcent
* Ajout d'une constante pour l'id de la version du projet Xper.
*
* Revision 1.3  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.2  2006/03/07 11:07:08  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnbe_v1.
*
* Revision 1.1.2.1  2006/03/07 10:35:47  jp_milcent
* Ajour d'une constante pour les synonymes provisoires.
*
* Revision 1.1  2005/12/21 15:11:13  jp_milcent
* Nouvelle gestion de la configuration.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>