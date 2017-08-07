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
// CVS : $Id: iden_config.inc.php,v 1.3 2007-09-18 08:41:14 alexandre_tb Exp $
/**
* Configuration de l'applette Identification.
*
* Fichier de configuration de l'applette Identification.
*
*@package Applette
*@subpackage Identification
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.3 $ $Date: 2007-09-18 08:41:14 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Constante stockant la valeur de la langue par défaut pour l'applette IDEN.*/
define('IDEN_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);

/** Constante stockant la valeur de durée de la session.*/
define('IDEN_AUTH_SESSION_DUREE', PAP_AUTH_SESSION_DUREE);

// Chemin vers les dossiers de l'applette
/** Chemin vers l'applette Identification de Papyrus.*/
define('IDEN_CHEMIN_APPLETTE', GEN_CHEMIN_APPLETTE.'identification'.GEN_SEP);
/** Chemin vers les fichiers de traduction de l'applette Identification de Papyrus.*/
define('IDEN_CHEMIN_LANGUE', IDEN_CHEMIN_APPLETTE.'langues'.GEN_SEP);
/** Chemin vers les fichiers de la bibliotheque de l'applette Identification de Papyrus.*/
define('IDEN_CHEMIN_BIBLIO', IDEN_CHEMIN_APPLETTE.'bibliotheque'.GEN_SEP);

/** Chemin vers le fichier squelette par defaut */
define ('IDEN_SQUELETTE_DEFAUT', 'identification.tpl.html');

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: iden_config.inc.php,v $
* Revision 1.3  2007-09-18 08:41:14  alexandre_tb
* modification de la balise identification pour permettre de preciser un template. Ajout d une constante
*
* Revision 1.2  2006/11/20 17:30:40  jp_milcent
* Amélioration de la gestion de l'identification.
* Utilisation des durées de session correcte.
* Suppression du code pour Spip non fonctionnel.
*
* Revision 1.1  2005/03/15 14:18:49  jpm
* Ajout d'un fichier de config.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>