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
// CVS : $Id: adme_langue_es.inc.php,v 1.3 2006-09-27 10:02:08 alexandre_tb Exp $
/**
* Gestion des langues de l'application ADME
*
* Contient les constantes pour la langue fran�aise de l'application ADME.
*
*@package Admin_men�
*@subpackage Langues
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.3 $ $Date: 2006-09-27 10:02:08 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+



// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// Le formulaire de s�lection du site dont les men�s doivent �tre administrer :
define('ADME_LG_FORM_SITE_TITRE', 'Lista de los Web site');
define('ADME_LG_FORM_SITE_CHOIX', 'Opci�na el sitio a administrar: ');
define('ADME_LG_FORM_SITE_VALIDER', 'OK');

// Les titres de l'arborescence des men�s � administrer:
define('ADME_LG_MENU_TITRE', 'Configuraci�n de los men�s del Web site:');
define('ADME_LG_MENU_CLASSIQUE_RACINE', 'agregue un men� cl�sico ');
define('ADME_LG_MENU_COMMUN_RACINE', 'agregue un men� comuno');

// Les actions des men�s classiques:
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER', 'classico_men�_modicar');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_ALT', 'Modificar');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_TITLE', 'Modificar estemen�');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_ACTION', 'menu_classique_modifier_action');


define('ADME_LG_ACTION_CLASSIQUE_MONTER', 'men�_classico_subir');
define('ADME_LG_ACTION_CLASSIQUE_MONTER_ALT', 'Subir');
define('ADME_LG_ACTION_CLASSIQUE_MONTER_TITLE', 'Subir este men�');

define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE', 'classico_men�_bajar');
define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE_ALT', 'Bajar');
define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE_TITLE', 'Najar este men�');

define('ADME_LG_ACTION_CLASSIQUE_DIMINUER', 'men�_classico_disminuir');
define('ADME_LG_ACTION_CLASSIQUE_DIMINUER_ALT', 'Disminuir');
define('ADME_LG_ACTION_CLASSIQUE_DIMINUER_TITLE', 'Disminuir de un nivel este men�');

define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER', 'men�_classico_aumentar');
define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER_ALT', 'Aumentar');
define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER_TITLE', 'Aumentar de un nivel este men�');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE', 'menu_classique_traduire');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_ACTION', 'menu_classique_traduire_action');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_ALT', 'Traduire');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_TITLE', 'Traduire ce menu');

define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER', 'classico_men�_quite');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_ALT', 'Quite');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TITLE', 'Quite este men�');

define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION', 'menu_classique_supprimer_traduction');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION_ALT', 'Supprimer');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION_TITLE', 'Supprimer ce menu');

define('ADME_LG_ACTION_CLASSIQUE_AJOUTER', 'classico_men�_agrege');
define('ADME_LG_ACTION_CLASSIQUE_AJOUTER_ALT', 'Agrege');
define('ADME_LG_ACTION_CLASSIQUE_AJOUTER_TITLE', 'Agrege este men�');

define('ADME_LG_ACTION_CLASSIQUE_VERIFIER', 'classico_men�_verificar');
define('ADME_LG_ACTION_CLASSIQUE_VERIFIER_TRADUCTION', 'menu_classique_verifier_traduction');

define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT', 'menu_classique_traduction_defaut');
define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_ALT', 'Choisir ce menu comme traduction par d�faut');
define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_TITLE', 'Choisir ce menu comme traduction par d�faut');

// Les actions des men�s communs:
define('ADME_LG_ACTION_COMMUN_MODIFIER', 'com�n_men�_modificar');
define('ADME_LG_ACTION_COMMUN_MODIFIER_ALT', 'Modificar');
define('ADME_LG_ACTION_COMMUN_MODIFIER_TITLE', 'Modificar este men�');
define('ADME_LG_ACTION_COMMUN_MODIFIER_ACTION', 'menu_commun_modifier_action');

define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT', 'menu_classique_traduction_defaut');
define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT_ALT', 'Choisir ce menu comme traduction par d�faut');
define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT_TITLE', 'Choisir ce menu comme traduction par d�faut');

define('ADME_LG_ACTION_COMMUN_MONTER', 'com�n_men�_subir');
define('ADME_LG_ACTION_COMMUN_MONTER_ALT', 'Subir');
define('ADME_LG_ACTION_COMMUN_MONTER_TITLE', 'Subir este men�');

define('ADME_LG_ACTION_COMMUN_DESCENDRE', 'com�n_men�_bajar');
define('ADME_LG_ACTION_COMMUN_DESCENDRE_ALT', 'Bajar');
define('ADME_LG_ACTION_COMMUN_DESCENDRE_TITLE', 'Bajar este men�');

define('ADME_LG_ACTION_COMMUN_DIMINUER', 'com�n_men�_disminuir');
define('ADME_LG_ACTION_COMMUN_DIMINUER_ALT', 'Disminuir');
define('ADME_LG_ACTION_COMMUN_DIMINUER_TITLE', 'Disminuir de un nivel este men�');

define('ADME_LG_ACTION_COMMUN_AUGMENTER', 'com�n_men�_aumentar');
define('ADME_LG_ACTION_COMMUN_AUGMENTER_ALT', 'Aumentar');
define('ADME_LG_ACTION_COMMUN_AUGMENTER_TITLE', 'Aumentar de un nivel este men�');

define('ADME_LG_ACTION_COMMUN_TRADUIRE', 'menu_commun_traduire');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_ACTION', 'menu_commun_traduire_action');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_ALT', 'Traduire');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_TITLE', 'Traduire ce menu');

define('ADME_LG_ACTION_COMMUN_SUPPRIMER', 'com�n_men�_suprimir');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_ALT', 'Suprimir');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TITLE', 'Suprimir este men�');

define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION', 'menu_commun_supprimer_traduction');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION_ALT', 'Supprimer');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION_TITLE', 'Supprimer ce menu');

define('ADME_LG_ACTION_COMMUN_AJOUTER', 'com�n_men�_a�adir');
define('ADME_LG_ACTION_COMMUN_AJOUTER_ALT', 'a�adir');
define('ADME_LG_ACTION_COMMUN_AJOUTER_TITLE', 'a�adir este men�');

define('ADME_LG_ACTION_COMMUN_VERIFIER', 'com�n_men�_verificar');
define ('ADME_LG_ACTION_COMMUN_VERIFIER_TRADUCTION','menu_commun_verifier_traduction');

// Les actions g�n�rales:
define('ADME_LG_ACTION_ADMINISTRER', 'Administrar');
define('ADME_LG_ACTION_ADMINISTRER_ALT', 'Administrar');
define('ADME_LG_ACTION_ADMINISTRER_TITLE', 'Administrar la aplicacion de este men�');

define('ADME_LG_ACTION_PLIER', 'adme_men�_doblar');
define('ADME_LG_ACTION_PLIER_ALT', 'doblar');

define('ADME_LG_ACTION_DEPLIER', 'adme_men�_abrir');
define('ADME_LG_ACTION_DEPLIER_ALT', '	brir');

define('ADME_LG_ACTION_SUPPRIMER_CONFIRMATION', 'es usted seguro desear quitar este men�?');

// Les erreurs:
define('ADME_LG_ERREUR_INFO_men�', 'imposible leer las informaciones del men�.');
define('ADME_LG_ERREUR_INFO_SITE', 'imposible leer las informaciones del website');
define('ADME_LG_ERREUR_INFO_men�_RELATION', 'imposible leer las informaciones sobre las relaciones del men�.');
define('ADME_LG_ERREUR_ID_men�_PERE', ' imposible leer identificar del padre del men�.');
define('ADME_LG_ERREUR_CODE_NUM', "El valor %s por el \"code nu�rique\" ja exista&");
define('ADME_LG_ERREUR_CODE_ALPHA', "El valor %s por el  \"Code alphanum�rique\" ja exista");
define('ADME_LG_ERREUR_EXISTE_SOUS_men�', 'Este men� incluye debajo de -men�es. Por favor, comience a quitarlos.');

// Le formulaire de modification d'un men� :
define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_GENERAL', 'Moficar men�');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_GENERAL', 'Modicar com�n men�');

define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_CONFIG', 'men� config');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_CONFIG', 'com�n men� configurar');
define('ADME_LG_FORM_MENU_ID', 'Identificador de este men�: ');
define('ADME_LG_FORM_MENU_CODE_NUM', 'Codico Numerico de este men�');
define('ADME_LG_FORM_MENU_REGLE_CODE_NUM', 'un c�digo digital num�rico es necesario para el men�!');
define('ADME_LG_FORM_MENU_CODE_ALPHA', 'Codico alphanum�rique del men�');
define('ADME_LG_FORM_MENU_REGLE_CODE_ALPHA', 'un c�digo alfanum�rico es necesario para el men�!');
define('ADME_LG_FORM_MENU_NOM', 'Nombre de el men�');
define('ADME_LG_FORM_MENU_REGLE_NOM', 'un nombre esta necesario por el men� !');
define('ADME_LG_FORM_MENU_RACCOURCI', 'clavier acortada ');
define('ADME_LG_FORM_MENU_DEFAUT', 'haciendo el men� por el d�faut ');
define('ADME_LG_FORM_MENU_FICHIER_SQUELETTE', ' squelette del archivo ');
define('ADME_LG_FORM_MENU_INFO_BULLE', 'informacion-bulle contenida ');
define('ADME_LG_FORM_MENU_REGLE_INFO_BULLE', ' una descripci�n corta para la informacion-burbuja es necesaria para este men�!');
define('ADME_LG_FORM_MENU_APPLI', 'Applicacion');
define('ADME_LG_FORM_MENU_APPLI_ARGUMENT', 'Application argumentes');

define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_ENTETE', ' t�tulo de las p�ginas del men� ');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_ENTETE', ' t�tulo de las p�ginas del men� comun ');
define('ADME_LG_FORM_MENU_ROBOT', ' Indesar los robotes') ;
define('ADME_LG_FORM_MENU_INDEX_FOLLOW', ' poniendo en un �ndice esta p�gina y despu�s ');
define('ADME_LG_FORM_MENU_INDEX', ' poniendo en un �ndice solo en esta p�gina ');
define('ADME_LG_FORM_MENU_NOINDEX_NOFOLLOW', ' No poner en un �ndice esta p�gina y despu�s ');
define('ADME_LG_FORM_MENU_NOINDEX', 'No poner en un �ndice esta p�gina ');
define('ADME_LG_FORM_MENU_INDEX_VIDE', 'vide');
define('ADME_LG_FORM_MENU_TITRE', ' t�tulo de la p�gina ');
define('ADME_LG_FORM_MENU_TITRE_ALTERNATIF', ' t�tulo alternativo de la p�gina ');
define('ADME_LG_FORM_MENU_MOT_CLE', 'palabras lavves');
define('ADME_LG_FORM_MENU_DESCRIPTION', ' Descripci�n del contenido ');
define('ADME_LG_FORM_MENU_TABLE_MATIERE', ' contenido');
define('ADME_LG_FORM_MENU_SOURCE', ' fuente ');
define('ADME_LG_FORM_MENU_AUTEUR', 'Autor');
define('ADME_LG_FORM_MENU_CONTRIBUTEUR', 'Contributor');
define('ADME_LG_FORM_MENU_EDITEUR', '�ditor');
define('ADME_LG_FORM_MENU_DATE_CREATION', ' fecha de creaci�n ');
define('ADME_LG_FORM_MENU_DATE_VALIDITE_DEBUT', ' vaya de nuevo al principio de la validez ');
define('ADME_LG_FORM_MENU_DATE_VALIDITE_FIN', ' fecha de la terminaci�n de la validez ');
define('ADME_LG_FORM_MENU_DATE_COPYRIGHT', 'a�o del copyright');
define('ADME_LG_FORM_MENU_URL_LICENCE', ' URL de la licencia ');
define('ADME_LG_FORM_MENU_CATEGORIE', 'Cat�goria');
define('ADME_LG_FORM_MENU_PUBLIC', 'Publico por esta pagina');
define('ADME_LG_FORM_MENU_PUBLIC_NIVEAU', ' nivel del p�blico para esta p�gina ');
define('ADME_LG_FORM_MENU_ZG_TYPE', ' tipo de gama del espacio ');
define('ADME_LG_FORM_MENU_ZG_VALEUR', ' espacie la gama de la p�gina ');
define('ADME_LG_FORM_MENU_ZG_VIDE', ' ningunos ');
define('ADME_LG_FORM_MENU_ZG_ISO', ' c�digo del pa�s en dos letras(iso3166)');
define('ADME_LG_FORM_MENU_ZG_DC', ' Representaci�n de las �reas geogr�ficas de Dublin Core');
define('ADME_LG_FORM_MENU_ZG_POINT', 'Punto g�ografico');
define('ADME_LG_FORM_MENU_ZG_GTGN', ' nombra el issus du Getty Thesaurus de los nombres geogr�ficos');
define('ADME_LG_FORM_MENU_TMP_TYPE', ' Est�ndar de la gama temporal ');
define('ADME_LG_FORM_MENU_TMP_VALEUR', ' dimensi�n temporal de la p�gina ');
define('ADME_LG_FORM_MENU_TMP_VIDE', 'Ningunos');
define('ADME_LG_FORM_MENU_TMP_W3C', ' Codificaci�n de las fechas y de las horas del W3C');
define('ADME_LG_FORM_MENU_TMP_DC', ' Representaci�n de los intervalos de la �poca de la base de Dubl�n');

define('ADME_LG_FORM_MENU_VALIDER', 'Registrar');
define('ADME_LG_FORM_MENU_ANNULER', ' cancelaci�n ');
define('ADME_LG_FORM_TXT_CHP_OBLIGATOIRE', ' indica los obligatories de los campos');
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
* $Log: adme_langue_es.inc.php,v $
* Revision 1.3  2006-09-27 10:02:08  alexandre_tb
* Ajout de constante de traduction
*
* Revision 1.2  2006/09/27 09:20:28  alexandre_tb
* Ajout de constante de traduction
*
* Revision 1.1  2006/04/12 21:11:54  ddelon
* Multilinguisme menus communs
*
* Revision 1.7  2005/07/18 16:14:32  ddelon
* css admin + men� communs
*
* Revision 1.6  2005/07/08 21:13:15  ddelon
* Gestion indentation men�
*
* Revision 1.5  2005/05/26 15:45:09  jpm
* Ajout d'une majuscule accentu�e.
*
* Revision 1.4  2005/03/29 15:49:31  jpm
* Ajout de la constante pour la date de cr�ation dans le formulaire des men�s.
*
* Revision 1.3  2004/12/01 16:47:07  jpm
* Ajout d'un texte pour la boite javascript de confirmation de suppression de men�.
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