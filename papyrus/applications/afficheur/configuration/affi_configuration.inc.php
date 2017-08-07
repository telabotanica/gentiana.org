<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.3                                                                                      |
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
// CVS : $Id: affi_configuration.inc.php,v 1.14 2007-06-26 13:30:48 jp_milcent Exp $
/**
* Application réalisant l'affichage du contenu stocké dans Papyrus.
*
* Les constantes et variables de configuration de l'application Afficheur.
*
*@package Afficheur
*@subpackage Configuration
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.14 $ $Date: 2007-06-26 13:30:48 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// Chemin des fichiers à inclure.
/** Chemin vers la bibliothèque PEAR.*/
define('AFFI_CHEMIN_BIBLIOTHEQUE_PEAR', '');
/** Chemin vers la bibliothèque API.*/
define('AFFI_CHEMIN_BIBLIOTHEQUE_API', 'api'.GEN_SEP);
/** Chemin vers la bibliothèque API : fckeditor.*/
define('AFFI_CHEMIN_FCKEDITOR', AFFI_CHEMIN_BIBLIOTHEQUE_API.'fckeditor'.GEN_SEP);
/** Chemin vers l'application Admin de l'afficheur de Papyrus.*/
define('AFFI_CHEMIN_APPLICATION', GEN_CHEMIN_APPLICATION.'afficheur'.GEN_SEP);
/** Chemin vers le dossier des squelettes de l'application.*/
define('AFFI_CHEMIN_SQUELETTE', AFFI_CHEMIN_APPLICATION.'squelettes'.GEN_SEP);
/** Chemin vers le dossier des styles de l'application.*/
define('AFFI_CHEMIN_STYLE', AFFI_CHEMIN_SQUELETTE);
/** Chaine à utiliser pour l'URL de la règle Freelink.*/
define('AFFI_URL_PAPYRUS', PAP_URL.'?menu=%s');

/** Utilisation de fckeditor (true).*/
$GLOBALS['_AFFI_']['fckeditor']['utilisation'] = true;
/** Hauteur de fckeditor.*/
$GLOBALS['_AFFI_']['fckeditor']['hauteur'] = '400';
/** Type de barre d'outil de fckeditor.*/
$GLOBALS['_AFFI_']['fckeditor']['barre'] = 'Papyrus';
/** Langue de fckeditor.*/
$GLOBALS['_AFFI_']['fckeditor']['langue'] = $GLOBALS['_GEN_commun']['i18n'];
/** Fichier de config personnalisé de fckeditor.*/
$base_url = parse_url(PAP_URL);
$dirname_base_url = dirname($base_url['path']);
// Suppression double slash pour site interdisant ce type d'url (a confirmer ...)
// Probleme également avec des sous-domaines (~ree05/papyrus etc.) ....  
$GLOBALS['_AFFI_']['fckeditor']['CustomConfigurationsPath'] = str_replace('//', '/', $dirname_base_url.GEN_SEP.AFFI_CHEMIN_APPLICATION.'configuration'.GEN_SEP.'affi_fckconfig.js');

// L'objet PEAR::DB à utiliser pour l'afficheur :
$GLOBALS['_AFFICHEUR']['objet_pear_db'] =& $GLOBALS['_GEN_commun']['pear_db'];

// L'identifiant du menu courant :
if (isset($GLOBALS['_GEN_commun']['traduction_info_menu'])) {
    $GLOBALS['_AFFICHEUR']['menu_courant_id'] = $GLOBALS['_GEN_commun']['traduction_info_menu']->gm_id_menu;
} else if (isset($GLOBALS['_GEN_commun']['info_menu'])) {
    $GLOBALS['_AFFICHEUR']['menu_courant_id'] = $GLOBALS['_GEN_commun']['info_menu']->gm_id_menu;
} else {
    $GLOBALS['_AFFICHEUR']['menu_courant_id'] = $GLOBALS['_GEN_commun']['url_menu'];
}

// Le jeu de caractère à utiliser pour la page courante :
$GLOBALS['_AFFICHEUR']['jeu_de_caracteres'] = $GLOBALS['_PAPYRUS_']['page']['jeu_de_caracteres'];

// Les sites correspodant aux liens interwiki:
$GLOBALS['_AFFICHEUR']['interwiki_sites'] =& $GLOBALS['_PAPYRUS_']['interwiki_sites'];

// Les sites correspodant à l'action inclure:
$GLOBALS['_AFFICHEUR']['inclure_sites'] =& $GLOBALS['_PAPYRUS_']['inclure_sites'];

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: affi_configuration.inc.php,v $
* Revision 1.14  2007-06-26 13:30:48  jp_milcent
* Suppression de l'utilisation de Quickform.
* Utilisation de squellette PHP.
*
* Revision 1.13  2006-04-28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.12  2005/08/25 08:59:12  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.11  2005/08/18 10:20:04  ddelon
* Integrateur Wikini et Acces PEAR
*
* Revision 1.10  2005/07/21 18:11:43  ddelon
* configuration barre outil fcke
*
* Revision 1.9  2005/07/18 08:53:14  ddelon
* Configuration Fcsk et menage
*
* Revision 1.8  2005/07/15 17:10:08  ddelon
* Configuration Fcsk et menage
*
* Revision 1.7  2005/06/03 18:39:30  jpm
* Ajout de la barre d'outil Papyrus FCKeditor.
*
* Revision 1.6  2005/04/25 13:56:19  jpm
* Ajout de chemin vers les styles.
*
* Revision 1.5  2005/04/21 16:46:21  jpm
* Gestion via Papyrus du XHTML.
*
* Revision 1.4  2005/02/23 18:16:49  jpm
* Changement de l'url de Papyrus pour qu'elle corresponde à l'url courante de Papyrus.
*
* Revision 1.3  2005/02/23 17:41:21  jpm
* Modification de l'initialisation d'une variable.
*
* Revision 1.2  2005/02/22 17:55:38  jpm
* Changement de variable pour la récupération de l'identifiant du menu courant.
*
* Revision 1.1  2004/11/26 13:10:20  jpm
* Utilisation des actions Papyrus et implémentation de la syntaxe Wikini.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>