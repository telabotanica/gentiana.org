<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// Copyright (C) 1999-2004 Tela Botanica (accueil@tela-botanica.org)
//
// Ce logiciel est un programme informatique servant à gérer du contenu et des
// applications web.
                                                                                                      
// Ce logiciel est régi par la licence CeCILL soumise au droit français et
// respectant les principes de diffusion des logiciels libres. Vous pouvez
// utiliser, modifier et/ou redistribuer ce programme sous les conditions
// de la licence CeCILL telle que diffusée par le CEA, le CNRS et l'INRIA 
// sur le site "http://www.cecill.info".

// En contrepartie de l'accessibilité au code source et des droits de copie,
// de modification et de redistribution accordés par cette licence, il n'est
// offert aux utilisateurs qu'une garantie limitée.  Pour les mêmes raisons,
// seule une responsabilité restreinte pèse sur l'auteur du programme,  le
// titulaire des droits patrimoniaux et les concédants successifs.

// A cet égard  l'attention de l'utilisateur est attirée sur les risques
// associés au chargement,  à l'utilisation,  à la modification et/ou au
// développement et à la reproduction du logiciel par l'utilisateur étant 
// donné sa spécificité de logiciel libre, qui peut le rendre complexe à 
// manipuler et qui le réserve donc à des développeurs et des professionnels
// avertis possédant  des  connaissances  informatiques approfondies.  Les
// utilisateurs sont donc invités à charger  et  tester  l'adéquation  du
// logiciel à leurs besoins dans des conditions permettant d'assurer la
// sécurité de leurs systèmes et ou de leurs données et, plus généralement, 
// à l'utiliser et l'exploiter dans les mêmes conditions de sécurité. 

// Le fait que vous puissiez accéder à cet en-tête signifie que vous avez 
// pris connaissance de la licence CeCILL, et que vous en avez accepté les
// termes.
// ----
// CVS : $Id: adme_langue_fr.inc.php,v 1.19 2007-10-25 14:26:56 ddelon Exp $
/**
* Gestion des langues de l'application ADME
*
* Contient les constantes pour la langue française de l'application ADME.
*
*@package Admin_menu
*@subpackage Langues
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.19 $ $Date: 2007-10-25 14:26:56 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+



// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
define ('ADME_IDENTIFIEZ_VOUS','Veuillez vous identifier pour acc&egrave;der &agrave; ce menu.');
// Le formulaire de sélection du site dont les menus doivent être administrer :
define('ADME_LG_FORM_SITE_TITRE', 'Listes des sites');
define('ADME_LG_FORM_SITE_CHOIX', 'Choix du site à administrer : ');
define('ADME_LG_FORM_SITE_VALIDER', 'OK');
 
// Les titres de l'arborescence des menus à administrer:
define('ADME_LG_MENU_TITRE', 'Configuration des menus du site : ');
define('ADME_LG_MENU_CLASSIQUE_RACINE', 'Ajouter un menu classique');
define('ADME_LG_MENU_COMMUN_RACINE', 'Ajouter un menu commun');

// Les actions des menus classiques:
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER', 'menu_classique_modifier');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_ACTION', 'menu_classique_modifier_action');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_ALT', 'Modifier');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_TITLE', 'Modifier ce menu');

define('ADME_LG_ACTION_CLASSIQUE_MONTER', 'menu_classique_monter');
define('ADME_LG_ACTION_CLASSIQUE_MONTER_ALT', 'Monter');
define('ADME_LG_ACTION_CLASSIQUE_MONTER_TITLE', 'Monter ce menu');

define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE', 'menu_classique_descendre');
define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE_ALT', 'Descendre');
define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE_TITLE', 'Descendre ce menu');

define('ADME_LG_ACTION_CLASSIQUE_DIMINUER', 'menu_classique_diminuer');
define('ADME_LG_ACTION_CLASSIQUE_DIMINUER_ALT', 'Diminuer');
define('ADME_LG_ACTION_CLASSIQUE_DIMINUER_TITLE', 'Diminuer d\'un niveau ce menu');

define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER', 'menu_classique_augmenter');
define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER_ALT', 'Augmenter');
define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER_TITLE', 'Augmenter d\'un niveau ce menu');

define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE', 'menu_classique_traduire');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_ACTION', 'menu_classique_traduire_action');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_ALT', 'Traduire');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_TITLE', 'Traduire ce menu');

define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER', 'menu_classique_supprimer');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_ALT', 'Supprimer');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TITLE', 'Supprimer ce menu');

define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION', 'menu_classique_supprimer_traduction');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION_ALT', 'Supprimer');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION_TITLE', 'Supprimer ce menu');

define('ADME_LG_ACTION_CLASSIQUE_AJOUTER', 'menu_classique_ajouter');
define('ADME_LG_ACTION_CLASSIQUE_AJOUTER_ALT', 'Ajouter');
define('ADME_LG_ACTION_CLASSIQUE_AJOUTER_TITLE', 'Ajouter ce menu');

define('ADME_LG_ACTION_CLASSIQUE_VERIFIER', 'menu_classique_verifier');
define('ADME_LG_ACTION_CLASSIQUE_VERIFIER_TRADUCTION', 'menu_classique_verifier_traduction');


define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT', 'menu_classique_traduction_defaut');
define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_ALT', 'Choisir ce menu comme traduction par défaut');
define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_TITLE', 'Choisir ce menu comme traduction par défaut');

define ('ADME_LG_ACTION_CLASSIQUE_LIMITER', 'menu_classique_limiter');
define ('ADME_LG_ACTION_CLASSIQUE_LIMITER_TITLE', 'Restreindre le menu &agrave cette langue');
define ('ADME_LG_ACTION_CLASSIQUE_OUVRIR', 'menu_classique_ouvrir');
define ('ADME_LG_ACTION_CLASSIQUE_OUVRIR_TITLE', 'Faire apparaitre ce menu dans toutes les langues');

define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT', 'menu_classique_traduction_defaut');
define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT_ALT', 'Choisir ce menu comme traduction par défaut');
define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT_TITLE', 'Choisir ce menu comme traduction par défaut');


// Les actions des menus communs:
define('ADME_LG_ACTION_COMMUN_MODIFIER', 'menu_commun_modifier');
define('ADME_LG_ACTION_COMMUN_MODIFIER_ALT', 'Modifier');
define('ADME_LG_ACTION_COMMUN_MODIFIER_ACTION', 'menu_commun_modifier_action');
define('ADME_LG_ACTION_COMMUN_MODIFIER_TITLE', 'Modifier ce menu');

define('ADME_LG_ACTION_COMMUN_MONTER', 'menu_commun_monter');
define('ADME_LG_ACTION_COMMUN_MONTER_ALT', 'Monter');
define('ADME_LG_ACTION_COMMUN_MONTER_TITLE', 'Monter ce menu');

define('ADME_LG_ACTION_COMMUN_DESCENDRE', 'menu_commun_descendre');
define('ADME_LG_ACTION_COMMUN_DESCENDRE_ALT', 'Descendre');
define('ADME_LG_ACTION_COMMUN_DESCENDRE_TITLE', 'Descendre ce menu');

define('ADME_LG_ACTION_COMMUN_DIMINUER', 'menu_commun_diminuer');
define('ADME_LG_ACTION_COMMUN_DIMINUER_ALT', 'Diminuer');
define('ADME_LG_ACTION_COMMUN_DIMINUER_TITLE', 'Diminuer d\'un niveau ce menu');

define('ADME_LG_ACTION_COMMUN_AUGMENTER', 'menu_commun_augmenter');
define('ADME_LG_ACTION_COMMUN_AUGMENTER_ALT', 'Augmenter');
define('ADME_LG_ACTION_COMMUN_AUGMENTER_TITLE', 'Augmenter d\'un niveau ce menu');

define('ADME_LG_ACTION_COMMUN_TRADUIRE', 'menu_commun_traduire');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_ACTION', 'menu_commun_traduire_action');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_ALT', 'Traduire');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_TITLE', 'Traduire ce menu');

define('ADME_LG_ACTION_COMMUN_SUPPRIMER', 'menu_commun_supprimer');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_ALT', 'Supprimer');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TITLE', 'Supprimer ce menu');

define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION', 'menu_commun_supprimer_traduction');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION_ALT', 'Supprimer');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION_TITLE', 'Supprimer ce menu');


define('ADME_LG_ACTION_COMMUN_AJOUTER', 'menu_commun_ajouter');
define('ADME_LG_ACTION_COMMUN_AJOUTER_ALT', 'Ajouter');
define('ADME_LG_ACTION_COMMUN_AJOUTER_TITLE', 'Ajouter ce menu');

define('ADME_LG_ACTION_COMMUN_VERIFIER', 'menu_commun_verifier');
define ('ADME_LG_ACTION_COMMUN_VERIFIER_TRADUCTION','menu_commun_verifier_traduction');


// Les actions générales:
define('ADME_LG_ACTION_ADMINISTRER', 'administrer');
define('ADME_LG_ACTION_ADMINISTRER_ALT', 'Administrer');
define('ADME_LG_ACTION_ADMINISTRER_TITLE', 'Administrer l\'application de ce menu');

define('ADME_LG_ACTION_PLIER', 'adme_menu_fermer');
define('ADME_LG_ACTION_PLIER_ALT', 'Plier');

define('ADME_LG_ACTION_DEPLIER', 'adme_menu_ouvrir');
define('ADME_LG_ACTION_DEPLIER_ALT', 'Déplier');

define('ADME_LG_ACTION_SUPPRIMER_CONFIRMATION', 'Êtes vous sûr de vouloir supprimer ce menu?');

// Les erreurs:
define('ADME_LG_ERREUR_INFO_MENU', 'impossible de lire les infos du menu.');
define('ADME_LG_ERREUR_INFO_SITE', 'impossible de lire les infos du site.');
define('ADME_LG_ERREUR_INFO_MENU_RELATION', 'impossible de lire les infos sur les relations du menu.');
define('ADME_LG_ERREUR_ID_MENU_PERE', 'impossible de lire identifiant du menu père.');
define('ADME_LG_ERREUR_CODE_NUM', "La valeur %s pour le champ \"Code numérique\" existe déjà.");
define('ADME_LG_ERREUR_CODE_ALPHA', "La valeur %s pour le champ \"Code alphanumérique\" existe déjà.");
define('ADME_LG_ERREUR_EXISTE_SOUS_MENU', 'Ce menu contient encore des sous menus. Veuillez commencez par supprimer ces sous menus.');

// Le formulaire de modification d'un menu :
define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_GENERAL', 'Modification menu');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_GENERAL', 'Modification menu commun');

define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_GENERAL_TRADUCTION', 'Traduction menu');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_GENERAL_TRADUCTION', 'Traduction menu commun');

define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_CONFIG', 'Configuration du menu');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_CONFIG', 'Configuration du menu commun');
define('ADME_LG_FORM_MENU_ID', 'Identifiant de ce menu : ');
define('ADME_LG_FORM_MENU_CODE_NUM', 'Code numérique du menu');
define('ADME_LG_FORM_MENU_REGLE_CODE_NUM', 'Un code numérique est requis pour le menu !');
define('ADME_LG_FORM_MENU_CODE_ALPHA', 'Code alphanumérique du menu');
define('ADME_LG_FORM_MENU_REGLE_CODE_ALPHA', 'Un code alphanumérique est requis pour le menu !');
define('ADME_LG_FORM_MENU_NOM', 'Nom du menu');
define('ADME_LG_FORM_MENU_REGLE_NOM', 'Un nom est requis pour le menu !');
define('ADME_LG_FORM_MENU_RACCOURCI', 'Raccourci clavier');
define('ADME_LG_FORM_MENU_DEFAUT', 'En faire le menu par défaut');
define('ADME_LG_FORM_MENU_FICHIER_SQUELETTE', 'Fichier squelette');
define('ADME_LG_FORM_MENU_INFO_BULLE', 'Contenu info-bulle');
define('ADME_LG_FORM_MENU_REGLE_INFO_BULLE', 'Une description courte pour l\'info-bulle est requise pour ce menu !');
define('ADME_LG_FORM_MENU_APPLI', 'Application');
define('ADME_LG_FORM_MENU_APPLI_ARGUMENT', 'Arguments de l\'application');

define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_ENTETE', 'Entête des pages du menu');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_ENTETE', 'Entête des pages du menu commun');
define('ADME_LG_FORM_MENU_ROBOT', 'Indexation par robots');
define('ADME_LG_FORM_MENU_INDEX_FOLLOW', 'Indexer cette page et les suivantes');
define('ADME_LG_FORM_MENU_INDEX', 'Indexer seulement cette page');
define('ADME_LG_FORM_MENU_NOINDEX_NOFOLLOW', 'Ne pas indexer cette page et les suivantes');
define('ADME_LG_FORM_MENU_NOINDEX', 'Ne pas indexer cette page');
define('ADME_LG_FORM_MENU_INDEX_VIDE', 'Aucune');
define('ADME_LG_FORM_MENU_TITRE', 'Titre de la page');
define('ADME_LG_FORM_MENU_TITRE_ALTERNATIF', 'Titre alternatif de la page');
define('ADME_LG_FORM_MENU_MOT_CLE', 'Mots-clés');
define('ADME_LG_FORM_MENU_DESCRIPTION', 'Description du contenu');
define('ADME_LG_FORM_MENU_TABLE_MATIERE', 'Table des matières');
define('ADME_LG_FORM_MENU_SOURCE', 'Source');
define('ADME_LG_FORM_MENU_AUTEUR', 'Auteur');
define('ADME_LG_FORM_MENU_CONTRIBUTEUR', 'Contributeur');
define('ADME_LG_FORM_MENU_EDITEUR', 'Éditeur');
define('ADME_LG_FORM_MENU_DATE_CREATION', 'Date de création');
define('ADME_LG_FORM_MENU_DATE_VALIDITE_DEBUT', 'Date de début de validité');
define('ADME_LG_FORM_MENU_DATE_VALIDITE_FIN', 'Date de fin de validité');
define('ADME_LG_FORM_MENU_DATE_COPYRIGHT', 'Année pour le copyright');
define('ADME_LG_FORM_MENU_URL_LICENCE', 'URL de la licence');
define('ADME_LG_FORM_MENU_CATEGORIE', 'Catégorie');
define('ADME_LG_FORM_MENU_PUBLIC', 'Public pour la page');
define('ADME_LG_FORM_MENU_PUBLIC_NIVEAU', 'Niveau du public pour la page');
define('ADME_LG_FORM_MENU_ZG_TYPE', 'Type de portée spatiale');
define('ADME_LG_FORM_MENU_ZG_VALEUR', 'Portée spatiale de la page');
define('ADME_LG_FORM_MENU_ZG_VIDE', 'Aucun');
define('ADME_LG_FORM_MENU_ZG_ISO', 'Code de pays sur deux lettres (iso3166)');
define('ADME_LG_FORM_MENU_ZG_DC', 'Représentation des régions géographiques du Dublin Core');
define('ADME_LG_FORM_MENU_ZG_POINT', 'Point géographique');
define('ADME_LG_FORM_MENU_ZG_GTGN', 'Noms issus du Getty Thesaurus of Geographic Names');
define('ADME_LG_FORM_MENU_TMP_TYPE', 'Type de portée temporelle');
define('ADME_LG_FORM_MENU_TMP_VALEUR', 'Portée temporelle de la page');
define('ADME_LG_FORM_MENU_TMP_VIDE', 'Aucun');
define('ADME_LG_FORM_MENU_TMP_W3C', 'Codage des dates et heures du W3C');
define('ADME_LG_FORM_MENU_TMP_DC', 'Représentation des intervalles de temps du Dublin Core');

define('ADME_LG_FORM_MENU_VALIDER', 'Enregistrer');
define('ADME_LG_FORM_MENU_ANNULER', 'Annuler');
define('ADME_LG_FORM_TXT_CHP_OBLIGATOIRE', 'Indique les champs obligatoires');
define('ADME_LG_FORM_SYMBOLE_CHP_OBLIGATOIRE', '*');
define ('ADME_VOIR_CONFIG_AVANCEE', 'Afficher/Cacher la configuration avanc&eacute;e');
define ('ADME_CONFIG_AVANCEE', 'Configuration avanc&eacute;e');


// Charactère spéciaux:
define('ADME_LG_PARENTHESE_OUVRANTE', '(');
define('ADME_LG_PARENTHESE_FERMANTE', ')');
define('ADME_LG_SLASH', '/');
// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adme_langue_fr.inc.php,v $
* Revision 1.19  2007-10-25 14:26:56  ddelon
* Multilinguisme : prÃ©sentation restriction Ã  une langue
*
* Revision 1.18  2007-10-25 10:08:55  alexandre_tb
* nouvelle constante multilinguisme
*
* Revision 1.17  2007-06-26 14:18:53  florian
* amÃ©lioration des formulaires des diffÃ©rentes applis de l'interface d'administration afin de les simplifier
*
* Revision 1.16  2006/10/06 10:40:51  florian
* harmonisation des messages d'erreur de l'authentification
*
* Revision 1.15  2006/06/29 18:58:57  ddelon
* Multilinguisme : menu par defaut pour les menu commun
*
* Revision 1.14  2006/06/28 12:53:34  ddelon
* Multilinguisme : menu par defaut
*
* Revision 1.13  2006/05/10 16:02:49  ddelon
* Finition multilinguise et schizo flo
*
* Revision 1.12  2006/05/10 15:01:57  florian
* ajout de constantes, pour Ã©viter les warnings
*
* Revision 1.11  2006/04/12 21:11:54  ddelon
* Multilinguisme menus communs
*
* Revision 1.10  2006/03/23 20:24:58  ddelon
* *** empty log message ***
*
* Revision 1.9  2006/03/13 21:00:20  ddelon
* Suppression messages d'erreur multilinguisme
*
* Revision 1.8  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.7.2.1  2006/02/28 14:02:10  ddelon
* Finition multilinguisme
*
* Revision 1.7  2005/07/18 16:14:32  ddelon
* css admin + menu communs
*
* Revision 1.6  2005/07/08 21:13:15  ddelon
* Gestion indentation menu
*
* Revision 1.5  2005/05/26 15:45:09  jpm
* Ajout d'une majuscule accentuée.
*
* Revision 1.4  2005/03/29 15:49:31  jpm
* Ajout de la constante pour la date de création dans le formulaire des menus.
*
* Revision 1.3  2004/12/01 16:47:07  jpm
* Ajout d'un texte pour la boite javascript de confirmation de suppression de menu.
*
* Revision 1.2  2004/11/10 17:26:12  jpm
* Fin gestion de la traduction.
*
* Revision 1.1  2004/11/10 11:58:31  jpm
* Début de la traduction de l'appli.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>