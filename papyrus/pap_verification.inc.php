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
// CVS : $Id: pap_verification.inc.php,v 1.9 2007-04-13 09:41:09 neiluj Exp $
/**
* Réalisation de la vérification des besoins de Papyrus.
*
* Ce fichier vérifie la présence de certaines extensions nécessaires à Papyrus.
*
*@package Papyrus
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Laurent COUDOUNEAU <lc@gsite.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.9 $ $Date: 2007-04-13 09:41:09 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// Initialisation des variables globales de gestion d'erreur et de l'installation:
$_GEN_commun['erreur_instal_afaire'] = false;

// +------------------------------------------------------------------------------------------------------+
// Gestion des fichiers de configuration et de l'installation

$chemin_fichier_config_defaut = 'papyrus/configuration/pap_config.inc.php';

/** Inclusion du fichier de configuration avancée
** Ajout du fichier de configuration avancée de de Papyrus contenant les chemins des fichiers.*/
include_once 'configuration/pap_config_avancee.inc.php';

// Gestion du fichier de config par défaut permettant de savoir si l'installation a été faite ou pas
if (file_exists($chemin_fichier_config_defaut)) {
    /** Inclusion du fichier de configuration de base contenant la connexion à la base de donnée de Papyrus.*/
    include_once $chemin_fichier_config_defaut;
     
     // Nous vérifions que nous avons pas à faire à une mise à jour de Papyrus
     if (GEN_VERSION != PAP_VERSION) {
         $_GEN_commun['erreur_instal_afaire'] = true;
     }
     
     // Initialisation de la variable stockant les infos de débogage.
     if (GEN_DEBOGAGE) {
     	    $_GEN_commun['debogage_info'] = '';
     }
     
     // Niveau d'erreur pour le code PHP de Papyrus
     // Inutile car shunté par set_error_handler du gestionnaire d'erreur
     error_reporting(GEN_DEBOGAGE_NIVEAU);
} else {
	$_GEN_commun['erreur_instal_afaire'] = true;
}

// +------------------------------------------------------------------------------------------------------+
// |                                              PIED du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_verification.inc.php,v $
* Revision 1.9  2007-04-13 09:41:09  neiluj
* rÃ©parration cvs
*
* Revision 1.8  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.7  2006/03/15 09:30:50  florian
* suppression des echos, qui entrainaient des problemes d'affichages
*
* Revision 1.6  2005/09/20 17:01:22  ddelon
* php5 et bugs divers
*
* Revision 1.5  2005/02/28 11:20:42  jpm
* Modification des auteurs.
*
* Revision 1.4  2004/10/25 16:28:47  jpm
* Ajout de nouvelles balises Papyrus, ajout vérification mise à jour de Papyrus, meilleure gestion des sessions...
*
* Revision 1.3  2004/10/22 17:23:59  jpm
* Début amélioration de la gestion des erreurs et de l'installation.
*
* Revision 1.2  2004/10/15 18:29:19  jpm
* Modif pour gérer l'appli installateur de Papyrus.
*
* Revision 1.1  2004/06/16 08:14:23  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.7  2004/05/10 12:24:24  jpm
* Configuration de la gestion des niveaux d'erreur.
*
* Revision 1.6  2004/04/28 12:04:31  jpm
* Changement du modèle de la base de données.
*
* Revision 1.5  2004/04/23 09:24:47  jpm
* Suppression recherche ip et port.
*
* Revision 1.4  2004/04/22 08:23:47  jpm
* Transformation de $GS_GLOBAL en $_GEN_commun.
*
* Revision 1.3  2004/04/09 16:21:23  jpm
* Extraction de la gestion de la connexion à la BdD transféré dans genesia.php.
*
* Revision 1.2  2004/04/08 14:13:02  jpm
* Suppression de code inutile et renomage de fonctions.
*
* Revision 1.1  2004/04/08 12:29:00  jpm
* Ajout du code réalisant les vérification nécessaires au fonctionnement de Génésia.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>