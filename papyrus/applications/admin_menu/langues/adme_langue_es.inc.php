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
// CVS : $Id: adme_langue_es.inc.php,v 1.3 2006-09-27 10:02:08 alexandre_tb Exp $
/**
* Gestion des langues de l'application ADME
*
* Contient les constantes pour la langue française de l'application ADME.
*
*@package Admin_menú
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
// Le formulaire de sélection du site dont les menús doivent être administrer :
define('ADME_LG_FORM_SITE_TITRE', 'Lista de los Web site');
define('ADME_LG_FORM_SITE_CHOIX', 'Opcióna el sitio a administrar: ');
define('ADME_LG_FORM_SITE_VALIDER', 'OK');

// Les titres de l'arborescence des menús à administrer:
define('ADME_LG_MENU_TITRE', 'Configuración de los menús del Web site:');
define('ADME_LG_MENU_CLASSIQUE_RACINE', 'agregue un menú clásico ');
define('ADME_LG_MENU_COMMUN_RACINE', 'agregue un menú comuno');

// Les actions des menús classiques:
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER', 'classico_menú_modicar');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_ALT', 'Modificar');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_TITLE', 'Modificar estemenú');
define('ADME_LG_ACTION_CLASSIQUE_MODIFIER_ACTION', 'menu_classique_modifier_action');


define('ADME_LG_ACTION_CLASSIQUE_MONTER', 'menú_classico_subir');
define('ADME_LG_ACTION_CLASSIQUE_MONTER_ALT', 'Subir');
define('ADME_LG_ACTION_CLASSIQUE_MONTER_TITLE', 'Subir este menú');

define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE', 'classico_menú_bajar');
define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE_ALT', 'Bajar');
define('ADME_LG_ACTION_CLASSIQUE_DESCENDRE_TITLE', 'Najar este menú');

define('ADME_LG_ACTION_CLASSIQUE_DIMINUER', 'menú_classico_disminuir');
define('ADME_LG_ACTION_CLASSIQUE_DIMINUER_ALT', 'Disminuir');
define('ADME_LG_ACTION_CLASSIQUE_DIMINUER_TITLE', 'Disminuir de un nivel este menú');

define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER', 'menú_classico_aumentar');
define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER_ALT', 'Aumentar');
define('ADME_LG_ACTION_CLASSIQUE_AUGMENTER_TITLE', 'Aumentar de un nivel este menú');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE', 'menu_classique_traduire');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_ACTION', 'menu_classique_traduire_action');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_ALT', 'Traduire');
define('ADME_LG_ACTION_CLASSIQUE_TRADUIRE_TITLE', 'Traduire ce menu');

define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER', 'classico_menú_quite');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_ALT', 'Quite');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TITLE', 'Quite este menú');

define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION', 'menu_classique_supprimer_traduction');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION_ALT', 'Supprimer');
define('ADME_LG_ACTION_CLASSIQUE_SUPPRIMER_TRADUCTION_TITLE', 'Supprimer ce menu');

define('ADME_LG_ACTION_CLASSIQUE_AJOUTER', 'classico_menú_agrege');
define('ADME_LG_ACTION_CLASSIQUE_AJOUTER_ALT', 'Agrege');
define('ADME_LG_ACTION_CLASSIQUE_AJOUTER_TITLE', 'Agrege este menú');

define('ADME_LG_ACTION_CLASSIQUE_VERIFIER', 'classico_menú_verificar');
define('ADME_LG_ACTION_CLASSIQUE_VERIFIER_TRADUCTION', 'menu_classique_verifier_traduction');

define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT', 'menu_classique_traduction_defaut');
define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_ALT', 'Choisir ce menu comme traduction par défaut');
define('ADME_LG_ACTION_CLASSIQUE_TRADUCTION_DEFAUT_TITLE', 'Choisir ce menu comme traduction par défaut');

// Les actions des menús communs:
define('ADME_LG_ACTION_COMMUN_MODIFIER', 'común_menú_modificar');
define('ADME_LG_ACTION_COMMUN_MODIFIER_ALT', 'Modificar');
define('ADME_LG_ACTION_COMMUN_MODIFIER_TITLE', 'Modificar este menú');
define('ADME_LG_ACTION_COMMUN_MODIFIER_ACTION', 'menu_commun_modifier_action');

define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT', 'menu_classique_traduction_defaut');
define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT_ALT', 'Choisir ce menu comme traduction par défaut');
define('ADME_LG_ACTION_COMMUN_TRADUCTION_DEFAUT_TITLE', 'Choisir ce menu comme traduction par défaut');

define('ADME_LG_ACTION_COMMUN_MONTER', 'común_menú_subir');
define('ADME_LG_ACTION_COMMUN_MONTER_ALT', 'Subir');
define('ADME_LG_ACTION_COMMUN_MONTER_TITLE', 'Subir este menú');

define('ADME_LG_ACTION_COMMUN_DESCENDRE', 'común_menú_bajar');
define('ADME_LG_ACTION_COMMUN_DESCENDRE_ALT', 'Bajar');
define('ADME_LG_ACTION_COMMUN_DESCENDRE_TITLE', 'Bajar este menú');

define('ADME_LG_ACTION_COMMUN_DIMINUER', 'común_menú_disminuir');
define('ADME_LG_ACTION_COMMUN_DIMINUER_ALT', 'Disminuir');
define('ADME_LG_ACTION_COMMUN_DIMINUER_TITLE', 'Disminuir de un nivel este menú');

define('ADME_LG_ACTION_COMMUN_AUGMENTER', 'común_menú_aumentar');
define('ADME_LG_ACTION_COMMUN_AUGMENTER_ALT', 'Aumentar');
define('ADME_LG_ACTION_COMMUN_AUGMENTER_TITLE', 'Aumentar de un nivel este menú');

define('ADME_LG_ACTION_COMMUN_TRADUIRE', 'menu_commun_traduire');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_ACTION', 'menu_commun_traduire_action');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_ALT', 'Traduire');
define('ADME_LG_ACTION_COMMUN_TRADUIRE_TITLE', 'Traduire ce menu');

define('ADME_LG_ACTION_COMMUN_SUPPRIMER', 'común_menú_suprimir');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_ALT', 'Suprimir');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TITLE', 'Suprimir este menú');

define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION', 'menu_commun_supprimer_traduction');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION_ALT', 'Supprimer');
define('ADME_LG_ACTION_COMMUN_SUPPRIMER_TRADUCTION_TITLE', 'Supprimer ce menu');

define('ADME_LG_ACTION_COMMUN_AJOUTER', 'común_menú_añadir');
define('ADME_LG_ACTION_COMMUN_AJOUTER_ALT', 'añadir');
define('ADME_LG_ACTION_COMMUN_AJOUTER_TITLE', 'añadir este menú');

define('ADME_LG_ACTION_COMMUN_VERIFIER', 'común_menú_verificar');
define ('ADME_LG_ACTION_COMMUN_VERIFIER_TRADUCTION','menu_commun_verifier_traduction');

// Les actions générales:
define('ADME_LG_ACTION_ADMINISTRER', 'Administrar');
define('ADME_LG_ACTION_ADMINISTRER_ALT', 'Administrar');
define('ADME_LG_ACTION_ADMINISTRER_TITLE', 'Administrar la aplicacion de este menú');

define('ADME_LG_ACTION_PLIER', 'adme_menú_doblar');
define('ADME_LG_ACTION_PLIER_ALT', 'doblar');

define('ADME_LG_ACTION_DEPLIER', 'adme_menú_abrir');
define('ADME_LG_ACTION_DEPLIER_ALT', '	brir');

define('ADME_LG_ACTION_SUPPRIMER_CONFIRMATION', 'es usted seguro desear quitar este menú?');

// Les erreurs:
define('ADME_LG_ERREUR_INFO_menú', 'imposible leer las informaciones del menú.');
define('ADME_LG_ERREUR_INFO_SITE', 'imposible leer las informaciones del website');
define('ADME_LG_ERREUR_INFO_menú_RELATION', 'imposible leer las informaciones sobre las relaciones del menú.');
define('ADME_LG_ERREUR_ID_menú_PERE', ' imposible leer identificar del padre del menú.');
define('ADME_LG_ERREUR_CODE_NUM', "El valor %s por el \"code nuérique\" ja exista&");
define('ADME_LG_ERREUR_CODE_ALPHA', "El valor %s por el  \"Code alphanumérique\" ja exista");
define('ADME_LG_ERREUR_EXISTE_SOUS_menú', 'Este menú incluye debajo de -menúes. Por favor, comience a quitarlos.');

// Le formulaire de modification d'un menú :
define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_GENERAL', 'Moficar menú');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_GENERAL', 'Modicar común menú');

define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_CONFIG', 'menú config');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_CONFIG', 'común menú configurar');
define('ADME_LG_FORM_MENU_ID', 'Identificador de este menú: ');
define('ADME_LG_FORM_MENU_CODE_NUM', 'Codico Numerico de este menú');
define('ADME_LG_FORM_MENU_REGLE_CODE_NUM', 'un código digital numérico es necesario para el menú!');
define('ADME_LG_FORM_MENU_CODE_ALPHA', 'Codico alphanumérique del menú');
define('ADME_LG_FORM_MENU_REGLE_CODE_ALPHA', 'un código alfanumérico es necesario para el menú!');
define('ADME_LG_FORM_MENU_NOM', 'Nombre de el menú');
define('ADME_LG_FORM_MENU_REGLE_NOM', 'un nombre esta necesario por el menú !');
define('ADME_LG_FORM_MENU_RACCOURCI', 'clavier acortada ');
define('ADME_LG_FORM_MENU_DEFAUT', 'haciendo el menú por el défaut ');
define('ADME_LG_FORM_MENU_FICHIER_SQUELETTE', ' squelette del archivo ');
define('ADME_LG_FORM_MENU_INFO_BULLE', 'informacion-bulle contenida ');
define('ADME_LG_FORM_MENU_REGLE_INFO_BULLE', ' una descripción corta para la informacion-burbuja es necesaria para este menú!');
define('ADME_LG_FORM_MENU_APPLI', 'Applicacion');
define('ADME_LG_FORM_MENU_APPLI_ARGUMENT', 'Application argumentes');

define('ADME_LG_FORM_MENU_CLASSIQUE_TITRE_ENTETE', ' título de las páginas del menú ');
define('ADME_LG_FORM_MENU_COMMUN_TITRE_ENTETE', ' título de las páginas del menú comun ');
define('ADME_LG_FORM_MENU_ROBOT', ' Indesar los robotes') ;
define('ADME_LG_FORM_MENU_INDEX_FOLLOW', ' poniendo en un índice esta página y después ');
define('ADME_LG_FORM_MENU_INDEX', ' poniendo en un índice solo en esta página ');
define('ADME_LG_FORM_MENU_NOINDEX_NOFOLLOW', ' No poner en un índice esta página y después ');
define('ADME_LG_FORM_MENU_NOINDEX', 'No poner en un índice esta página ');
define('ADME_LG_FORM_MENU_INDEX_VIDE', 'vide');
define('ADME_LG_FORM_MENU_TITRE', ' título de la página ');
define('ADME_LG_FORM_MENU_TITRE_ALTERNATIF', ' título alternativo de la página ');
define('ADME_LG_FORM_MENU_MOT_CLE', 'palabras lavves');
define('ADME_LG_FORM_MENU_DESCRIPTION', ' Descripción del contenido ');
define('ADME_LG_FORM_MENU_TABLE_MATIERE', ' contenido');
define('ADME_LG_FORM_MENU_SOURCE', ' fuente ');
define('ADME_LG_FORM_MENU_AUTEUR', 'Autor');
define('ADME_LG_FORM_MENU_CONTRIBUTEUR', 'Contributor');
define('ADME_LG_FORM_MENU_EDITEUR', 'Éditor');
define('ADME_LG_FORM_MENU_DATE_CREATION', ' fecha de creación ');
define('ADME_LG_FORM_MENU_DATE_VALIDITE_DEBUT', ' vaya de nuevo al principio de la validez ');
define('ADME_LG_FORM_MENU_DATE_VALIDITE_FIN', ' fecha de la terminación de la validez ');
define('ADME_LG_FORM_MENU_DATE_COPYRIGHT', 'año del copyright');
define('ADME_LG_FORM_MENU_URL_LICENCE', ' URL de la licencia ');
define('ADME_LG_FORM_MENU_CATEGORIE', 'Catégoria');
define('ADME_LG_FORM_MENU_PUBLIC', 'Publico por esta pagina');
define('ADME_LG_FORM_MENU_PUBLIC_NIVEAU', ' nivel del público para esta página ');
define('ADME_LG_FORM_MENU_ZG_TYPE', ' tipo de gama del espacio ');
define('ADME_LG_FORM_MENU_ZG_VALEUR', ' espacie la gama de la página ');
define('ADME_LG_FORM_MENU_ZG_VIDE', ' ningunos ');
define('ADME_LG_FORM_MENU_ZG_ISO', ' código del país en dos letras(iso3166)');
define('ADME_LG_FORM_MENU_ZG_DC', ' Representación de las áreas geográficas de Dublin Core');
define('ADME_LG_FORM_MENU_ZG_POINT', 'Punto géografico');
define('ADME_LG_FORM_MENU_ZG_GTGN', ' nombra el issus du Getty Thesaurus de los nombres geográficos');
define('ADME_LG_FORM_MENU_TMP_TYPE', ' Estándar de la gama temporal ');
define('ADME_LG_FORM_MENU_TMP_VALEUR', ' dimensión temporal de la página ');
define('ADME_LG_FORM_MENU_TMP_VIDE', 'Ningunos');
define('ADME_LG_FORM_MENU_TMP_W3C', ' Codificación de las fechas y de las horas del W3C');
define('ADME_LG_FORM_MENU_TMP_DC', ' Representación de los intervalos de la época de la base de Dublín');

define('ADME_LG_FORM_MENU_VALIDER', 'Registrar');
define('ADME_LG_FORM_MENU_ANNULER', ' cancelación ');
define('ADME_LG_FORM_TXT_CHP_OBLIGATOIRE', ' indica los obligatories de los campos');
define('ADME_LG_FORM_SYMBOLE_CHP_OBLIGATOIRE', '*');

// Charactère spéciaux:
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
* css admin + menú communs
*
* Revision 1.6  2005/07/08 21:13:15  ddelon
* Gestion indentation menú
*
* Revision 1.5  2005/05/26 15:45:09  jpm
* Ajout d'une majuscule accentuée.
*
* Revision 1.4  2005/03/29 15:49:31  jpm
* Ajout de la constante pour la date de création dans le formulaire des menús.
*
* Revision 1.3  2004/12/01 16:47:07  jpm
* Ajout d'un texte pour la boite javascript de confirmation de suppression de menú.
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