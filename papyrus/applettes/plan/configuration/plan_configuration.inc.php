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
// CVS : $Id: plan_configuration.inc.php,v 1.1 2006-12-13 09:42:39 jp_milcent Exp $
/**
* papyrus_bp - plan_configuration.inc.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.1 $ $Date: 2006-12-13 09:42:39 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_PLAN_'] = array();

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Constante stockant la valeur de la langue par défaut pour l'applette PLAN.*/
define('PLAN_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);

// Chemin vers les dossiers de l'applette
/** Chemin vers l'applette Plan de Papyrus.*/
define('PLAN_CHEMIN_APPLETTE', GEN_CHEMIN_APPLETTE.'plan'.GEN_SEP);
/** Chemin vers les fichiers de traduction de l'applette Plan de Papyrus.*/
define('PLAN_CHEMIN_LANGUE', PLAN_CHEMIN_APPLETTE.'langues'.GEN_SEP);
/** Chemin vers les fichiers de la bibliotheque de l'applette Plan de Papyrus.*/
define('PLAN_CHEMIN_BIBLIO', PLAN_CHEMIN_APPLETTE.'bibliotheque'.GEN_SEP);
/** Chemin vers les fichiers squelettes de l'applette Plan de Papyrus.*/
define('PLAN_CHEMIN_SQUELETTE', PLAN_CHEMIN_APPLETTE.'squelettes'.GEN_SEP);

// Configuration du rendu
/** Nom du fichier de squelette à utiliser pour la liste des pages.*/
define('PLAN_SQUELETTE_LISTE', 'plan_liste.tpl.html');

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: plan_configuration.inc.php,v $
* Revision 1.1  2006-12-13 09:42:39  jp_milcent
* Ajout de l'applette Plan.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
