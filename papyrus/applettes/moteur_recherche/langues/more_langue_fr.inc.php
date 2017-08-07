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
// CVS : $Id: more_langue_fr.inc.php,v 1.7 2006-11-14 16:07:41 jp_milcent Exp $
/**
* Gestion des langues de l'applette Moteur_Recherche
*
* Contient les constantes pour la langue française de l'applette MORE.
*
*@package Applette
*@subpackage Moteur_Recherche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.7 $ $Date: 2006-11-14 16:07:41 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+



// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// Le formulaire de sélection du site dont les menus doivent être administrer :
define('MORE_LG_FORM_TITRE', 'Moteur de recherche');
define('MORE_LG_FORM_ACCESSKEY', '4');
define('MORE_LG_FORM_MOTIF', 'Rechercher : ');
define('MORE_LG_FORM_MOTIF_REGLE', 'Une chaine doit être saisie pour pouvoir lancer la recherche !');
define('MORE_LG_FORM_MOTIF_VALUE', 'Rechercher');
define('MORE_LG_FORM_VALIDER', 'ok');
define('MORE_LG_FORM_SYMBOLE_OBLIGATOIRE', '*');
define('MORE_LG_TITRE', 'Résultat de la recherche de : ');
define('MORE_LG_USURPATION', 'Recherche de : ');

// Les résultats de la recherche :
define('MORE_LG_RESULTAT_TITRE', 'Résultats de la recherche : %s page trouvée');
define('MORE_LG_RESULTAT_TITRE_PLURIEL', 'Résultats de la recherche : %s pages trouvées');
define('MORE_LG_RESULTAT_RACCOURCI', 'Raccourci : ');
define('MORE_LG_RESULTAT_DESCRIPTION', 'Description : ');
define('MORE_LG_RESULTAT_DATE_CREATION', 'Date de création : ');
define('MORE_LG_RESULTAT_DETAIL', 'Détail : ');
define('MORE_LG_RESULTAT_POIDS', 'Poids : ');
define('MORE_LG_RESULTAT_SCORE', 'Pertinence : ');
define('MORE_LG_RESULTAT_URL', 'URL : ');
define('MORE_LG_RESULTAT_SEPARATEUR', '-');
define('MORE_LG_RESULTAT_POURCENT', '%');
define('MORE_LG_RESULTAT_CADRE_OUVRIR', '(');
define('MORE_LG_RESULTAT_CADRE_FERMER', ')');
define('MORE_LG_RESULTAT_POINT', '.');
define('MORE_LG_RESULTAT_VIDE', 'Aucun résultat pour cette recherche!');
define('MORE_LG_RESULTAT_ETC', ' (...)');

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: more_langue_fr.inc.php,v $
* Revision 1.7  2006-11-14 16:07:41  jp_milcent
* Ajout d'intitulé suite à modification de la gestion de l'applette.
*
* Revision 1.6  2006/05/19 10:04:55  jp_milcent
* Ajout d'un moteur de recherche analysant les articles des sites sous Spip.
*
* Revision 1.5  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.4.2.1  2005/12/27 15:56:00  ddelon
* Fusion Head vers multilinguisme (wikini double clic)
*
* Revision 1.4  2005/10/26 08:14:51  jp_milcent
* Changement du terme "score" en "pertinence".
*
* Revision 1.3  2005/05/25 13:49:22  jpm
* Corection erreur pour la recherche dans le contenu.
*
* Revision 1.2  2005/04/14 17:39:34  jpm
* Amélioration du moteur de rechercher :
*  - pourcentage
*  - ajout d'info
*
* Revision 1.1  2004/12/07 10:24:16  jpm
* Moteur de recherche version de départ.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>