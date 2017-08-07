<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: more_configuration.inc.php,v 1.5 2006-11-14 16:08:12 jp_milcent Exp $
/**
* Fichier de configuration général de l'applette Moteur_Recherche.
*
* Permet de définir certains paramètres valables pour toutes l'applette MORE.
*
*@package Applette
*@subpackage Moteur_Recherche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.5 $ $Date: 2006-11-14 16:08:12 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Constante stockant la valeur de la langue par défaut pour l'applette MORE.*/
define('MORE_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);
/** Constante stockant la valeur de la langue par défaut pour l'applette MORE.*/
define('MORE_MODE', 1);// 1 : recherche de chaque mot du motif; 2: recherche du motif complet

// Chemin des fichiers à inclure.
/** Chemin vers la bibliothèque PEAR.*/
define('MORE_CHEMIN_BIBLIOTHEQUE_PEAR', PAP_CHEMIN_API_PEAR);

// Chemin vers les dossiers de l'applette
/** Chemin vers l'applette Moteur de Recherche de Papyrus.*/
define('MORE_CHEMIN_APPLETTE', GEN_CHEMIN_APPLETTE.'moteur_recherche'.GEN_SEP);
/** Chemin vers les fichiers de traduction de l'applette Moteur de Recherche de Papyrus.*/
define('MORE_CHEMIN_LANGUE', MORE_CHEMIN_APPLETTE.'langues'.GEN_SEP);
/** Chemin vers les fichiers de la bibliotheque de l'applette Moteur de Recherche de Papyrus.*/
define('MORE_CHEMIN_BIBLIO', MORE_CHEMIN_APPLETTE.'bibliotheque'.GEN_SEP);
/** Chemin vers les fichiers squelettes de l'applette Moteur de Recherche de Papyrus.*/
define('MORE_CHEMIN_SQUELETTE', MORE_CHEMIN_APPLETTE.'squelettes'.GEN_SEP);

// Configuration du formulaire de recherche
/** Nom du fichier de squelette à utiliser pour le formulaire du moteur de recherche.*/
define('MORE_FORM_SQUELETTE', 'formulaire.tpl.html');
/** Valeur de départ des tabulations pour le formulaire de recherche.*/
define('MORE_FORM_MOTIF_TAB', 100);
/** Taille de la zone de saisie de texte du formulaire de recherche.*/
define('MORE_FORM_MOTIF_SIZE', 20);
/** Nombre de caractères maximum pouvant être saisis dans la zone de texte du formulaire de recherche.*/
define('MORE_FORM_MOTIF_MAXLENGTH', 100);

// Configuration des résultats d'une recherche
/** Nom du fichier de squelette à utiliser pour les résultats du moteur de recherche.*/
define('MORE_RESULTAT_SQUELETTE', 'resultat_gg.tpl.html');
/** Taille du champ description en nombre de caractères.*/
define('MORE_RESULTAT_TAILLE_DESCRIPTION', 200);


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: more_configuration.inc.php,v $
* Revision 1.5  2006-11-14 16:08:12  jp_milcent
* Ajout de paramêtre permettant de gérer les squelettes et le découpage de la description dans Spip.
*
* Revision 1.4  2006/10/17 09:22:02  jp_milcent
* Utilisation par défaut du mode de recherche 1.
*
* Revision 1.3  2006/10/10 12:02:30  jp_milcent
* Suppression d'une bibliothèque Pear qu'il est inutile d'inclure.
* Ajout du chemin vers la bibliotheque Pear de Papyrus.
*
* Revision 1.2  2006/05/23 14:18:19  jp_milcent
* Ajout de la gestion du mode de recherche au moteur de recherche de Papyrus.
* Soit on recherche chaque mot du motif, soit le motif entier.
*
* Revision 1.1  2004/12/07 10:24:12  jpm
* Moteur de recherche version de départ.
*
* 
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
