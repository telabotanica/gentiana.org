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
// CVS : $Id: plan_langue_fr.inc.php,v 1.2 2006-12-13 10:53:36 jp_milcent Exp $
/**
* papyrus_bp - plan_langue_fr.inc.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.2 $ $Date: 2006-12-13 10:53:36 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Texte affiché quand le paramètre "permalien" est abscent.*/
define('PLAN_LG_ERREUR_PERMALIEN', "Applette PLAN : le paramètre 'permalien' peut prendre les valeurs 'oui' ou 'non' dans : %s !");
/** Texte affiché quand le type ne convient.*/
define('PLAN_LG_ERREUR_TYPE', "Applette PLAN : le paramètre 'type' peut prendre les valeurs 'majeure' ou 'mineure' dans : %s !");
/** Texte affiché quand on n'a pas de page à afficher.*/
define('PLAN_LG_INFO_ZERO_PAGE', "Applette PLAN : aucune page n'a été trouvée pour : %s !");

/** Texte affiché quand l'auteur est inconnu.*/
define('PLAN_LG_INCONNU_NOM', 'Anonyme');
/** Texte affiché quand le titre est vide.*/
define('PLAN_LG_INCONNU_TITRE', 'Titre inconnu');
/** Texte affiché quand l'url est inconnu.*/
define('PLAN_LG_INCONNU_URL', '#');
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: plan_langue_fr.inc.php,v $
* Revision 1.2  2006-12-13 10:53:36  jp_milcent
* Correction dans la gestion des erreurs.
*
* Revision 1.1  2006/12/13 09:42:39  jp_milcent
* Ajout de l'applette Plan.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
