<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: sesi_config.inc.php,v 1.2 2006-03-02 10:49:49 ddelon Exp $
/**
* Configuration de l'applette Identification.
*
* Fichier de configuration de l'applette selection de site.
*
*@package Applette
*@subpackage Selecteur
//Auteur original :
*@author        David Delon <david.delon@clapas.net>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.2 $ $Date: 2006-03-02 10:49:49 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Constante stockant la valeur de la langue par défaut pour l'applette IDEN.*/
define('SESI_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);

// Chemin vers les dossiers de l'applette
/** Chemin vers l'applette Identification de Papyrus.*/
define('SESI_CHEMIN_APPLETTE', GEN_CHEMIN_APPLETTE.'selecteur_sites'.GEN_SEP);
/** Chemin vers les fichiers de traduction de l'applette Identification de Papyrus.*/
define('SESI_CHEMIN_LANGUE', SESI_CHEMIN_APPLETTE.'langues'.GEN_SEP);
/** Chemin vers les fichiers de la bibliotheque de l'applette Identification de Papyrus.*/
define('SESI_CHEMIN_BIBLIO', SESI_CHEMIN_APPLETTE.'bibliotheque'.GEN_SEP);

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: sesi_config.inc.php,v $
* Revision 1.2  2006-03-02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.1.2.1  2005/12/07 19:46:15  ddelon
* Merge + navi sites
*
* Revision 1.1  2005/03/15 14:18:49  jpm
* Ajout d'un fichier de config.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>