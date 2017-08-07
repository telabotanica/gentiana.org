<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of papyrus_bp.                                                                         |
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
// CVS : $Id: gall_config.inc.php,v 1.1 2006-12-07 17:29:20 jp_milcent Exp $
/**
* papyrus_bp - gall_config.inc.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.1 $ $Date: 2006-12-07 17:29:20 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GALLERIE_'] = array();

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Constante stockant la valeur de la langue par défaut pour l'applette GALL.*/
define('GALL_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);

// Chemin des fichiers à inclure.
/** Chemin vers la bibliothèque PEAR.*/
define('GALL_CHEMIN_BIBLIOTHEQUE_PEAR', PAP_CHEMIN_API_PEAR);

// Chemin vers les dossiers de l'applette
/** Chemin vers l'applette Gallerie de Papyrus.*/
define('GALL_CHEMIN_APPLETTE', GEN_CHEMIN_CLIENT.'gallerie'.GEN_SEP);
/** Chemin vers les fichiers de traduction de l'applette Gallerie de Papyrus.*/
define('GALL_CHEMIN_LANGUE', GALL_CHEMIN_APPLETTE.'langues'.GEN_SEP);
/** Chemin vers les fichiers de la bibliotheque de l'applette Gallerie de Papyrus.*/
define('GALL_CHEMIN_BIBLIO', GALL_CHEMIN_APPLETTE.'bibliotheque'.GEN_SEP);
/** Chemin vers le dossier de Présenation.*/
define('GALL_CHEMIN_PRESENTATION', GALL_CHEMIN_APPLETTE.'presentation'.GEN_SEP);
/** Chemin vers les fichiers squelettes de l'applette Gallerie de Papyrus.*/
define('GALL_CHEMIN_SCRIPTS', GALL_CHEMIN_PRESENTATION.'scripts'.GEN_SEP);
/** Chemin vers les fichiers squelettes de l'applette Gallerie de Papyrus.*/
define('GALL_CHEMIN_STYLES', GALL_CHEMIN_PRESENTATION.'styles'.GEN_SEP);
/** Chemin vers les fichiers squelettes de l'applette Gallerie de Papyrus.*/
define('GALL_CHEMIN_IMAGES', GALL_CHEMIN_PRESENTATION.'images'.GEN_SEP);
/** Chemin vers les fichiers squelettes de l'applette Gallerie de Papyrus.*/
define('GALL_CHEMIN_SQUELETTE', GALL_CHEMIN_PRESENTATION.'squelettes'.GEN_SEP);

// Configuration du rendu
/** Nom du fichier de squelette à utiliser pour la liste des pages.*/
define('GALL_SQUELETTE_LISTE', 'gall_liste.tpl.html');


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: gall_config.inc.php,v $
* Revision 1.1  2006-12-07 17:29:20  jp_milcent
* Ajout de l'applette Gallerie dans Client car elle n'a pas un rapport direct avec Papyrus.
*
* Revision 1.2  2006/12/07 16:25:23  jp_milcent
* Ajout de la gestion de messages d'erreur.
* Ajout de la gestion des squelettes.
*
* Revision 1.1  2006/12/07 15:39:47  jp_milcent
* Ajout de l'applette Gallerie.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
