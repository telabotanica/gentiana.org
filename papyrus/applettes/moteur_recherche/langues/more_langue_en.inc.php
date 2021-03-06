<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
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
// CVS : $Id: more_langue_en.inc.php,v 1.4 2006-11-14 16:07:41 jp_milcent Exp $
/**
* Gestion des langues de l'applette Moteur_Recherche
*
* Contient les constantes pour la langue anglaise de l'applette MORE.
*
*@package Applette
*@subpackage Moteur_Recherche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.4 $ $Date: 2006-11-14 16:07:41 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+



// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// Le formulaire de s�lection du site dont les menus doivent �tre administrer :
define('MORE_LG_FORM_TITRE', 'Search engine');
define('MORE_LG_FORM_ACCESSKEY', '4');
define('MORE_LG_FORM_MOTIF', 'Search : ');
define('MORE_LG_FORM_MOTIF_REGLE', 'You must type a string !');
define('MORE_LG_FORM_MOTIF_VALUE', 'Search');
define('MORE_LG_FORM_VALIDER', 'ok');
define('MORE_LG_FORM_SYMBOLE_OBLIGATOIRE', '*');
define('MORE_LG_TITRE', 'Search result of : ');
define('MORE_LG_USURPATION', 'Search of : ');

// Les r�sultats de la recherche :
define('MORE_LG_RESULTAT_TITRE', 'Search results : %s page found');
define('MORE_LG_RESULTAT_TITRE_PLURIEL', 'Search results : %s pages found');
define('MORE_LG_RESULTAT_RACCOURCI', 'Shortcut : ');
define('MORE_LG_RESULTAT_DESCRIPTION', 'Description : ');
define('MORE_LG_RESULTAT_DATE_CREATION', 'Creation date : ');
define('MORE_LG_RESULTAT_DETAIL', 'Detail : ');
define('MORE_LG_RESULTAT_POIDS', 'Weight : ');
define('MORE_LG_RESULTAT_SCORE', 'Accuracy : ');
define('MORE_LG_RESULTAT_URL', 'URL : ');
define('MORE_LG_RESULTAT_SEPARATEUR', '-');
define('MORE_LG_RESULTAT_POURCENT', '%');
define('MORE_LG_RESULTAT_CADRE_OUVRIR', '(');
define('MORE_LG_RESULTAT_CADRE_FERMER', ')');
define('MORE_LG_RESULTAT_POINT', '.');
define('MORE_LG_RESULTAT_VIDE', 'No matches for this query!');
define('MORE_LG_RESULTAT_ETC', ' (...)');

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: more_langue_en.inc.php,v $
* Revision 1.4  2006-11-14 16:07:41  jp_milcent
* Ajout d'intitul� suite � modification de la gestion de l'applette.
*
* Revision 1.3  2006/05/19 10:04:55  jp_milcent
* Ajout d'un moteur de recherche analysant les articles des sites sous Spip.
*
* Revision 1.2  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.1.2.2  2005/12/27 15:56:00  ddelon
* Fusion Head vers multilinguisme (wikini double clic)
*
* Revision 1.1.2.1  2005/12/20 14:40:25  ddelon
* Fusion Head vers Livraison
*
* Revision 1.4  2005/10/26 08:14:51  jp_milcent
* Changement du terme "score" en "pertinence".
*
* Revision 1.3  2005/05/25 13:49:22  jpm
* Corection erreur pour la recherche dans le contenu.
*
* Revision 1.2  2005/04/14 17:39:34  jpm
* Am�lioration du moteur de rechercher :
*  - pourcentage
*  - ajout d'info
*
* Revision 1.1  2004/12/07 10:24:16  jpm
* Moteur de recherche version de d�part.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>