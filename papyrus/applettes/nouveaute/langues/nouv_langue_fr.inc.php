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
// CVS : $Id: nouv_langue_fr.inc.php,v 1.3 2006-12-13 09:27:42 jp_milcent Exp $
/**
* papyrus_bp - nouv_langue_fr.inc.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.3 $ $Date: 2006-12-13 09:27:42 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Texte affich� quand le param�tre "nombre" est abscent.*/
define('NOUV_LG_ERREUR_NOMBRE', "Applette NOUVEAUT� : le param�tre 'nombre' est obligatoire dans %s !");
/** Texte affich� quand le type ne convient.*/
define('NOUV_LG_ERREUR_TYPE', "Applette NOUVEAUT� : le param�tre 'type' peut prendre les valeurs 'majeure' ou 'mineure' dans : %s !");
/** Texte affich� quand on n'a pas de page � afficher.*/
define('NOUV_LG_INFO_ZERO_PAGE', "Applette NOUVEAUT� : aucune page n'a �t� trouv�e pour : %s !");

/** Texte affich� quand un champ est vide.*/
define('NOUV_LG_INCONNU_GENERAL', '&nbsp;');
/** Texte affich� quand l'auteur est inconnu.*/
define('NOUV_LG_INCONNU_AUTEUR', 'Anonyme');
/** Texte affich� quand le titre est vide.*/
define('NOUV_LG_INCONNU_TITRE', 'Titre inconnu');
/** Texte affich� quand le titre est vide.*/
define('NOUV_LG_INCONNU_URL', '#');

/** Mois de janvier.*/
define('NOUV_LG_MOIS_01', 'janvier');
/** Mois de f�vrier.*/
define('NOUV_LG_MOIS_02', 'f�vrier');
/** Mois de mars.*/
define('NOUV_LG_MOIS_03', 'mars');
/** Mois d'avril.*/
define('NOUV_LG_MOIS_04', 'avril');
/** Mois de mai.*/
define('NOUV_LG_MOIS_05', 'mai');
/** Mois de juin.*/
define('NOUV_LG_MOIS_06', 'juin');
/** Mois de juillet.*/
define('NOUV_LG_MOIS_07', 'juillet');
/** Mois d'ao�t'.*/
define('NOUV_LG_MOIS_08', 'ao�t');
/** Mois de septembre.*/
define('NOUV_LG_MOIS_09', 'septembre');
/** Mois d'octobre.*/
define('NOUV_LG_MOIS_10', 'octobre');
/** Mois de novembre.*/
define('NOUV_LG_MOIS_11', 'novembre');
/** Mois de d�cembre.*/
define('NOUV_LG_MOIS_12', 'd�cembre');


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: nouv_langue_fr.inc.php,v $
* Revision 1.3  2006-12-13 09:27:42  jp_milcent
* Ajout d'une valeur pour l'url vide.
*
* Revision 1.2  2006/12/13 09:26:44  jp_milcent
* Ajout d'une valeur pour les champs vides.
*
* Revision 1.1  2006/12/12 17:16:22  jp_milcent
* Ajout de l'applette Nouveaute.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
