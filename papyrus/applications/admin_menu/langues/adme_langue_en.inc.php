<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// Copyright (C) 1999-2004 Tela Botanica (accueil@tela-botanica.org)
//
// Ce logiciel est un programme informatique servant � g�rer du contenu et des
// applications web.
                                                                                                      
// Ce logiciel est r�gi par la licence CeCILL soumise au droit fran�ais et
// respectant les principes de diffusion des logiciels libres. Vous pouvez
// utiliser, modifier et/ou redistribuer ce programme sous les conditions
// de la licence CeCILL telle que diffus�e par le CEA, le CNRS et l'INRIA 
// sur le site "http://www.cecill.info".

// En contrepartie de l'accessibilit� au code source et des droits de copie,
// de modification et de redistribution accord�s par cette licence, il n'est
// offert aux utilisateurs qu'une garantie limit�e.  Pour les m�mes raisons,
// seule une responsabilit� restreinte p�se sur l'auteur du programme,  le
// titulaire des droits patrimoniaux et les conc�dants successifs.

// A cet �gard  l'attention de l'utilisateur est attir�e sur les risques
// associ�s au chargement,  � l'utilisation,  � la modification et/ou au
// d�veloppement et � la reproduction du logiciel par l'utilisateur �tant 
// donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � 
// manipuler et qui le r�serve donc � des d�veloppeurs et des professionnels
// avertis poss�dant  des  connaissances  informatiques approfondies.  Les
// utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation  du
// logiciel � leurs besoins dans des conditions permettant d'assurer la
// s�curit� de leurs syst�mes et ou de leurs donn�es et, plus g�n�ralement, 
// � l'utiliser et l'exploiter dans les m�mes conditions de s�curit�. 

// Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez 
// pris connaissance de la licence CeCILL, et que vous en avez accept� les
// termes.
// ----
// CVS : $Id: adme_langue_en.inc.php,v 1.3 2007-10-25 14:26:56 ddelon Exp $
/**
* Gestion des langues de l'application ADME
*
* Contient les constantes pour la langue fran�aise de l'application ADME.
*
*@package Admin_menu
*@subpackage Langues
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.3 $ $Date: 2007-10-25 14:26:56 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+



// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// Le formulaire de s�lection du site dont les menus doivent �tre administrer :
define('ADME_LG_FORM_SITE_TITRE', 'List of the websites');
define('ADME_LG_FORM_SITE_CHOIX', 'Choice the site to administrate : ');
define('ADME_LG_FORM_SITE_VALIDER', 'OK');

// Les titres de l'arborescence des menus � administrer:
define('ADME_LG_MENU_TITRE', 'Configuration of the menus of the website:');
define('ADME_LG_MENU_CLASSIQUE_RACINE', 'Add a classical menu');
define('ADME_LG_MENU_COMMUN_RACINE', 'Add a common menu');

// Les actions des menus classiques:
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER', 'classical_menu_modify');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_ALT', 'Modify');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_TITLE', 'Modify this menu');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_ACTION', 'classical_menu_modify_action');

define('ADME_LG_ACTION_CLASSIQUE_MONTER', 'menu_classique_go_up');
define('ADME_LG_ACTION_CLASSIQUE_MONTER_ALT', 'UP');
define('ADME_LG_ACTION_CLASSIQUE_MONTER_TITLE', 'Go up this menu');

define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE', 'classical_menu_down');
define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE_ALT', 'Down');
define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE_TITLE', 'Down this menu');

define('ADME_LG_ACTION_CLASSIQUE_DIMINUER', 'menu_classical_decrease');
define('ADME_LG_ACTION_CLASSIQUE_DIMINUER_ALT', 'Decrease');
define('ADME_LG_ACTION_CLASSIQUE_DIMINUER_TITLE', 'Decrease of one level this menu');

define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER', 'menu_classical_increase');
define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER_ALT', 'Increase');
define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER_TITLE', 'Increase of one level this menu');

define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE', 'menu_classical_translate');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_ACTION', 'menu_classical_translate_action');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_ALT', 'Translate');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_TITLE', 'Translate this menu');

define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER', 'classical_menu_remove');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_ALT', 'Remove');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TITLE', 'Remove this menu');

define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION', 'classical_menu_remove_translation');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION_ALT', 'Remove');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION_TITLE', 'Remove this menu');

define('ADME_LG_ACTION_CLASSIQUE_AJOUTER', 'classical_menu_add');
define('ADME_LG_ACTION_CLASSIQUE_AJOUTER_ALT', 'Add');
define('ADME_LG_ACTION_CLASSIQUE_AJOUTER_TITLE', 'Add this menu');

define('ADME_LG_ACTION_CLASSIQUE_VERIFIER', 'classical_menu_check');
define('ADME_LG_ACTION_CLASSIQUE_VERIFIER_TRADUCTION', 'classical_menu_check_translation');

define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT', 'classical_menu_translation_default');
define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_ALT', 'Chose this menu as default translation');
define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_TITLE', 'Chose this menu as default translation');

define ('ADME_LG_ACTION_CLASSIQUE_LIMITER', 'classical_menu_limit');
define ('ADME_LG_ACTION_CLASSIQUE_OUVRIR', 'menu_classique_open');
define ('ADME_LG_ACTION_CLASSIQUE_LIMITER_TITLE', 'Restrict menu to this lang');
define ('ADME_LG_ACTION_CLASSIQUE_OUVRIR_TITLE', 'Always show this menu');



// Les actions des menus communs:
define('ADME_LG_ACTION_COMMUN_MODIFIER', 'common_menu_modify');
define('ADME_LG_ACTION_COMMUN_MODIFIER_ALT', 'Modify');
define('ADME_LG_ACTION_COMMUN_MODIFIER_TITLE', 'Modify this menu');
define('ADME_LG_ACTION_COMMUN_MODIFIER_ACTION', 'common_menu_modify_action');

define('ADME_LG_ACTION_COMMUN_MONTER', 'common_menu_up');
define('ADME_LG_ACTION_COMMUN_MONTER_ALT', 'UP');
define('ADME_LG_ACTION_COMMUN_MONTER_TITLE', 'Up this menu');

define('ADME_LG_ACTION_COMMUN_DESCENDRE', 'common_menu_down');
define('ADME_LG_ACTION_COMMUN_DESCENDRE_ALT', 'Down');
define('ADME_LG_ACTION_COMMUN_DESCENDRE_TITLE', 'Down this menu');

define('ADME_LG_ACTION_COMMUN_DIMINUER', 'common_menu_decrease');
define('ADME_LG_ACTION_COMMUN_DIMINUER_ALT', 'Decrease');
define('ADME_LG_ACTION_COMMUN_DIMINUER_TITLE', 'Decrease of one level this menu');

define('ADME_LG_ACTION_COMMUN_AUGMENTER', 'common_menu_increase');
define('ADME_LG_ACTION_COMMUN_AUGMENTER_ALT', 'Increase');
define('ADME_LG_ACTION_COMMUN_AUGMENTER_TITLE', 'Increase of one level this');

define('ADME_LG_ACTION_COMMUN_TRADUIRE', 'commun_menu_translate');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_ACTION', 'commun_menu_translate_action');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_ALT', 'Translate');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_TITLE', 'Translate thid menu');

define('ADME_LG_ACTION_COMMUN_SUPPRIMER', 'common_menu_remove');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_ALT', 'Remove');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TITLE', 'Remove this menu');

define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION', 'common_menu_remove_translation');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION_ALT', 'Remove');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION_TITLE', 'Remove this menu');

define('ADME_LG_ACTION_COMMUN_AJOUTER', 'common_menu_add');
define('ADME_LG_ACTION_COMMUN_AJOUTER_ALT', 'Add');
define('ADME_LG_ACTION_COMMUN_AJOUTER_TITLE', 'Add this menu');

define('ADME_LG_ACTION_COMMUN_VERIFIER', 'common_menu_check');
define('ADME_LG_ACTION_COMMUN_VERIFIER_TRADUCTION', 'common_menu_check_translation');

define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT', 'common_menu_translation_default');
define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT_ALT', 'Chose this menu as default translation');
define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT_TITLE', 'Chose this menu as default translation');


// Les actions g�n�rales:
define('ADME_LG_ACTION_ADMINISTRER', 'Manage');
define('ADME_LG_ACTION_ADMINISTRER_ALT', 'Manage');
define('ADME_LG_ACTION_ADMINISTRER_TITLE', 'Manage the application of this menu');

define('ADME_LG_ACTION_PLIER', 'adme_menu_close');
define('ADME_LG_ACTION_PLIER_ALT', 'Fold');

define('ADME_LG_ACTION_DEPLIER', 'adme_menu_open');
define('ADME_LG_ACTION_DEPLIER_ALT', 'Unfold');

define('ADME_LG_ACTION_SUPPRIMER_CONFIRMATION', 'Are you sure to want to remove this menu?');

// Les erreurs:
define('ADME_LG_ERREUR_INFO_MENU', 'impossible to read the informations of the menu.');
define('ADME_LG_ERREUR_INFO_SITE', 'impossible to read the informations of the website.');
define('ADME_LG_ERREUR_INFO_MENU_RELATION', 'impossible to read the informations about the relations of the  menu.');
define('ADME_LG_ERREUR_ID_MENU_PERE', 'impossible to read identifying of the menu father.');
define('ADME_LG_ERREUR_CODE_NUM', "The value %s for the \"code nu�rique\" yet exists");
define('ADME_LG_ERREUR_CODE_ALPHA', "The value %s for the  \"Code alphanum�rique\" yet exist");
define('ADME_LG_ERREUR_EXISTE_SOUS_MENU', 'This menu includes under-menues. Please, begin to remove them.');

// Le formulaire de modification d'un menu :
define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_GENERAL', 'Mofify menu');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_GENERAL', 'Modify common menu');

define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_CONFIG', 'Menu config');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_CONFIG', 'Common menu confgig');
define('ADME_LG_FORM_MENU_ID', 'Identifier of this menu : ');
define('ADME_LG_FORM_MENU_CODE_NUM', 'Numeric code of this menu');
define('ADME_LG_FORM_MENU_REGLE_CODE_NUM', ' a numeric digital code is necessary for the menu !');
define('ADME_LG_FORM_MENU_CODE_ALPHA', 'Code alphanum�rique of the menu');
define('ADME_LG_FORM_MENU_REGLE_CODE_ALPHA', 'An alphanumeric code is necessary for the menu!');
define('ADME_LG_FORM_MENU_NOM', 'Name of the menu');
define('ADME_LG_FORM_MENU_REGLE_NOM', 'a name is necessary for the menu !');
define('ADME_LG_FORM_MENU_RACCOURCI', ' Shortened clavier');
define('ADME_LG_FORM_MENU_DEFAUT', 'Making the menu by d�faut');
define('ADME_LG_FORM_MENU_FICHIER_SQUELETTE', ' File squelette');
define('ADME_LG_FORM_MENU_INFO_BULLE', ' Contained information-bulle');
define('ADME_LG_FORM_MENU_REGLE_INFO_BULLE', ' a short description for the information-bubble is necessary for this menu!');
define('ADME_LG_FORM_MENU_APPLI', 'Application');
define('ADME_LG_FORM_MENU_APPLI_ARGUMENT', 'Application arguments');

define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_ENTETE', ' Heading of the pages of the menu');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_ENTETE', ' Heading of the pages of the  common menu');
define('ADME_LG_FORM_MENU_ROBOT', ' Indexing by robots');
define('ADME_LG_FORM_MENU_INDEX_FOLLOW', 'Indexeing this page and next');
define('ADME_LG_FORM_MENU_INDEX', 'Indexing only this page');
define('ADME_LG_FORM_MENU_NOINDEX_NOFOLLOW', 'Do notindexing this page and next pages');
define('ADME_LG_FORM_MENU_NOINDEX', 'Do not indexing this page');
define('ADME_LG_FORM_MENU_INDEX_VIDE', 'None');
define('ADME_LG_FORM_MENU_TITRE', 'Title of the page');
define('ADME_LG_FORM_MENU_TITRE_ALTERNATIF', 'Alternative tittle for the page');
define('ADME_LG_FORM_MENU_MOT_CLE', 'key-words');
define('ADME_LG_FORM_MENU_DESCRIPTION', ' Description of the content');
define('ADME_LG_FORM_MENU_TABLE_MATIERE', 'Contents');
define('ADME_LG_FORM_MENU_SOURCE', 'Source');
define('ADME_LG_FORM_MENU_AUTEUR', 'Author');
define('ADME_LG_FORM_MENU_CONTRIBUTEUR', 'Contributor');
define('ADME_LG_FORM_MENU_EDITEUR', '�ditor');
define('ADME_LG_FORM_MENU_DATE_CREATION', 'Creation date');
define('ADME_LG_FORM_MENU_DATE_VALIDITE_DEBUT', 'Go back to beginning of validity');
define('ADME_LG_FORM_MENU_DATE_VALIDITE_FIN', 'Completion date of validity');
define('ADME_LG_FORM_MENU_DATE_COPYRIGHT', 'Year for the copyright');
define('ADME_LG_FORM_MENU_URL_LICENCE', 'URL of the licence');
define('ADME_LG_FORM_MENU_CATEGORIE', 'Cat�gory');
define('ADME_LG_FORM_MENU_PUBLIC', 'Public for the page');
define('ADME_LG_FORM_MENU_PUBLIC_NIVEAU', 'level of public for this  page');
define('ADME_LG_FORM_MENU_ZG_TYPE', 'Type of space range');
define('ADME_LG_FORM_MENU_ZG_VALEUR', 'Space range of the page');
define('ADME_LG_FORM_MENU_ZG_VIDE', 'None');
define('ADME_LG_FORM_MENU_ZG_ISO', 'Code of the country on two letters(iso3166)');
define('ADME_LG_FORM_MENU_ZG_DC', ' Representation of the geographical areas of Dublin Core');
define('ADME_LG_FORM_MENU_ZG_POINT', 'G�ographique point');
define('ADME_LG_FORM_MENU_ZG_GTGN', 'Noms issus du Getty Thesaurus of Geographic Names');
define('ADME_LG_FORM_MENU_TMP_TYPE', ' Standard of range temporal');
define('ADME_LG_FORM_MENU_TMP_VALEUR', ' Temporal dimension of the page');
define('ADME_LG_FORM_MENU_TMP_VIDE', 'None');
define('ADME_LG_FORM_MENU_TMP_W3C', ' Coding of the dates and hours of the W3C');
define('ADME_LG_FORM_MENU_TMP_DC', ' Representation of the intervals of time of Dublin Core');

define('ADME_LG_FORM_MENU_VALIDER', 'Record');
define('ADME_LG_FORM_MENU_ANNULER', 'Cancel');
define('ADME_LG_FORM_TXT_CHP_OBLIGATOIRE', ' Indicates the fields obligatoires');
define('ADME_LG_FORM_SYMBOLE_CHP_OBLIGATOIRE', '*');

// Charact�re sp�ciaux:
define('ADME_LG_PARENTHESE_OUVRANTE', '(');
define('ADME_LG_PARENTHESE_FERMANTE', ')');
define('ADME_LG_SLASH', '/');
// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adme_langue_en.inc.php,v $
* Revision 1.3  2007-10-25 14:26:56  ddelon
* Multilinguisme : présentation restriction à une langue
*
* Revision 1.2  2007-10-23 14:10:00  ddelon
* Ajout traductions manquantes pour l'anglais
*
* Revision 1.1  2006-04-12 21:11:54  ddelon
* Multilinguisme menus communs
*
* Revision 1.7  2005/07/18 16:14:32  ddelon
* css admin + menu communs
*
* Revision 1.6  2005/07/08 21:13:15  ddelon
* Gestion indentation menu
*
* Revision 1.5  2005/05/26 15:45:09  jpm
* Ajout d'une majuscule accentu�e.
*
* Revision 1.4  2005/03/29 15:49:31  jpm
* Ajout de la constante pour la date de cr�ation dans le formulaire des menus.
*
* Revision 1.3  2004/12/01 16:47:07  jpm
* Ajout d'un texte pour la boite javascript de confirmation de suppression de menu.
*
* Revision 1.2  2004/11/10 17:26:12  jpm
* Fin gestion de la traduction.
*
* Revision 1.1  2004/11/10 11:58:31  jpm
* D�but de la traduction de l'appli.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>