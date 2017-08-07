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
// CVS : $Id: mocl_langue_fr.inc.php,v 1.1 2006-12-12 13:32:27 jp_milcent Exp $
/**
* papyrus_bp - mocl_langue_fr.inc.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.1 $ $Date: 2006-12-12 13:32:27 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Texte affich� quand le param�tre "mots" est abscent.*/
define('MOCL_LG_ERREUR_MOTS', "Applette MOT CLES : le param�tre 'mots' est obligatoire!");
/** Texte affich� quand le param�tre "categorie_condition" est pr�sent avec "categorie" abscent.*/
define('MOCL_LG_ERREUR_MOTS_CATEG', "Applette MOT CLES : le param�tre 'categorie' est obligatoire si vous renseignez 'categorie_condition' dans %s !");
/** Texte affich� quand on n'a pas de page � afficher.*/
define('MOCL_LG_INFO_ZERO_PAGE', "Applette MOT CLES : aucune page n'a �t� trouv� pour : %s !");
/** Texte affich� quand l'auteur est inconnu.*/
define('MOCL_LG_INCONNU_AUTEUR', 'Anonyme');
/** Texte affich� quand le titre est vide.*/
define('MOCL_LG_INCONNU_TITRE', 'Titre inconnu');

/** Mois de janvier.*/
define('MOCL_LG_MOIS_01', 'janvier');
/** Mois de f�vrier.*/
define('MOCL_LG_MOIS_02', 'f�vrier');
/** Mois de mars.*/
define('MOCL_LG_MOIS_03', 'mars');
/** Mois d'avril.*/
define('MOCL_LG_MOIS_04', 'avril');
/** Mois de mai.*/
define('MOCL_LG_MOIS_05', 'mai');
/** Mois de juin.*/
define('MOCL_LG_MOIS_06', 'juin');
/** Mois de juillet.*/
define('MOCL_LG_MOIS_07', 'juillet');
/** Mois d'ao�t'.*/
define('MOCL_LG_MOIS_08', 'ao�t');
/** Mois de septembre.*/
define('MOCL_LG_MOIS_09', 'septembre');
/** Mois d'octobre.*/
define('MOCL_LG_MOIS_10', 'octobre');
/** Mois de novembre.*/
define('MOCL_LG_MOIS_11', 'novembre');
/** Mois de d�cembre.*/
define('MOCL_LG_MOIS_12', 'd�cembre');

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: mocl_langue_fr.inc.php,v $
* Revision 1.1  2006-12-12 13:32:27  jp_milcent
* Ajout de l'applette MotCles.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
