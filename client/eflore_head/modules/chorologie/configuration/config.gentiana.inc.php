<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
// |                                                                                                      |
// | eflore_bp is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_bp is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: config.gentiana.inc.php,v 1.9 2007-09-25 08:59:06 jp_milcent Exp $
/**
* eflore_bp - config_gentiana.inc.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.9 $ $Date: 2007-09-25 08:59:06 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// +------------------------------------------------------------------------------------------------------+
// Parametrage de l'application
/** Constante stockant si oui ou non, on veut limiter la chorologie aux plantes protégées.*/
if (isset($GLOBALS['_GEN_commun']['info_application']->protection)) {
	define('CHORO_PROTECTION', $GLOBALS['_GEN_commun']['info_application']->protection);
} else {
	define('CHORO_PROTECTION', false);
}
/** Constante stockant l'identifiant du projet chorologique à utiliser.*/
if (isset($GLOBALS['_GEN_commun']['info_application']->projet_choro_id)) {
	define('CHORO_PROJET_ID', (bool)$GLOBALS['_GEN_commun']['info_application']->projet_choro_id);
} else {
	define('CHORO_PROJET_ID', 50);
}
/** Constante stockant la liste des textes de protection à prendre en compte. Pour tous, utiliser : null*/
define('CHORO_PROTECTION_TXT', '4, 15, 37'); 
/** Constante stockant la liste des statuts à prendre en compte. Pour tous,	 utiliser : null*/
define('CHORO_PROTECTION_STATUT', '3, 4, 5, 6, 47');
/** Constante stockant la lettre par défaut pour le Fragmenteur.*/
define('CHORO_FRAG_LETTRE_DEFAUT', '*');

// +------------------------------------------------------------------------------------------------------+
// Définition d'information pour réaliser les cartes.
/** Constante stockant la couleur la plus foncé utilisée pour les cartes "proportionnelle".*/
define('CHORO_COULEUR_FONCE', '0,6,120');//Défaut : 85,2,119 ; Gentiana: 6,49,154
/** Constante stockant la couleur la plus claire utilisée pour les cartes "proportionnelle".*/
define('CHORO_COULEUR_CLAIRE', '178,193,224');// Défaut : 244,237,249 ; Gentiana : 178,193,224
/** Constante stockant le pas pour créer les légendes automatiques des cartes "proportionnelles".*/
if (isset($GLOBALS['_GEN_commun']['info_application']->legende_pas)) {
	define('CHORO_LEGENDE_PAS', $GLOBALS['_GEN_commun']['info_application']->legende_pas);
} else {
	define('CHORO_LEGENDE_PAS', '100');
}


// +------------------------------------------------------------------------------------------------------+
/** URL du recueil de données sur le site de gentiana.*/
define('CHORO_URL_RCD', '/page:observatoire');
/** URL de la carte des efforts de prospection sur le site de gentiana.*/
define('CHORO_URL_EFFORT', '/page:infloris_stat');

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: config.gentiana.inc.php,v $
* Revision 1.9  2007-09-25 08:59:06  jp_milcent
* Gestion de la lettre par défaut du Fragmenteur.
*
* Revision 1.8  2007-09-25 08:23:15  jp_milcent
* Changement du pas de la légende.
*
* Revision 1.7  2007-09-24 14:27:50  jp_milcent
* Ajout d'une constante gérant l'id du projet de choro.
*
* Revision 1.6  2007-09-20 13:05:17  jp_milcent
* Changement de pas et de la couleur foncée.
*
* Revision 1.5  2007-09-20 12:56:29  jp_milcent
* Ajout du pas en constante pour les légendes.
*
* Revision 1.4  2007-08-17 13:10:29  jp_milcent
* Début gestion des statuts de protection.
*
* Revision 1.3  2007-08-02 16:09:08  jp_milcent
* Mise en forme pour gentiana.
*
* Revision 1.2  2007-07-06 18:51:20  jp_milcent
* Test couleur.
*
* Revision 1.1  2007-07-06 16:33:31  jp_milcent
* Fichier renommé : utilisation du point devant le nom de la distrib.
*
* Revision 1.1  2007-07-06 16:32:26  jp_milcent
* Ajout du fichier de config spécifique à la distribution Gentiana.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
