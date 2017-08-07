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
// CVS : $Id: synd_configuration.inc.php,v 1.1 2006-12-13 17:06:36 jp_milcent Exp $
/**
* papyrus_bp - synd_configuration.inc.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.1 $ $Date: 2006-12-13 17:06:36 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_SYNDICATION_'] = array();

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Constante stockant la valeur de la langue par défaut pour l'applette SYND.*/
define('SYND_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);

// Paramétrage de la bibliothèque de manipulation des flux RSS
/** Constante stockant le chemin vers la bibliothèque MAGPIERSS.*/
define('MAGPIE_DIR', GEN_CHEMIN_API.'syndication_rss/magpierss/');
/** Constante stockant le chemin vers le dossier de cache pour MAGPIERSS.*/
define('MAGPIE_CACHE_DIR', MAGPIE_DIR.'/tmp/magpie_cache');
/** Constante stockant le nombre de page syndiqués à afficher par site.*/
define('SYND_NOMBRE', 10);
/** Constante stockant si oui ou non on ouvre une nouvelle fenêtre pour consulter la page d'un site syndiqué.*/
define('SYND_OUVRIR_LIEN_RSS_NOUVELLE_FENETRE', 1);
/** Constante stockant le format des dates.*/
define('SYND_FORMAT_DATE', 'jma');

// Chemin vers les dossiers de l'applette
/** Chemin vers l'applette Syndication de Papyrus.*/
define('SYND_CHEMIN_APPLETTE', GEN_CHEMIN_APPLETTE.'syndication'.GEN_SEP);
/** Chemin vers les fichiers de traduction de l'applette Syndication de Papyrus.*/
define('SYND_CHEMIN_LANGUE', SYND_CHEMIN_APPLETTE.'langues'.GEN_SEP);
/** Chemin vers les fichiers squelettes de l'applette Syndication de Papyrus.*/
define('SYND_CHEMIN_SQUELETTE', SYND_CHEMIN_APPLETTE.'squelettes'.GEN_SEP);

// Configuration du rendu
/** Nom du fichier de squelette, par défaut, à utiliser pour la liste des pages.*/
define('SYND_SQUELETTE_LISTE', 'synd_liste.tpl.html');



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: synd_configuration.inc.php,v $
* Revision 1.1  2006-12-13 17:06:36  jp_milcent
* Ajout de l'applette Syndication.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
