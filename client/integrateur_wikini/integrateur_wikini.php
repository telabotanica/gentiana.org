<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of Integrateur Wikini.                                                             |
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
// CVS : $Id: integrateur_wikini.php,v 1.13 2006-04-28 12:41:26 florian Exp $
/**
* Integrateur de page Wikini
*
* Application permettant d'intégrer des pages wikini dans Papyrus.
*
*@package IntegrateurWikini
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.13 $ $Date: 2006-04-28 12:41:26 $
*
// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+



/**
 * Renvoie le menu général de l'integrateur Wikini : derniers  changement etc.
 *
 * @return string
 * @access public
 */
   
require_once 'bibliotheque/iw_integrateur.fonct.php';


function afficherContenuMenu()
{
	return afficherPageMenuWikini();	
} 
			
	
// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction afficherContenuCorps() - Fonction appelé par le gestionnaire Papyrus.
*
* Elle retourne le contenu de l'application.
*
* @return  string  du code XHTML correspondant au contenu renvoyé par l'application.
*/
function afficherContenuCorps()
{
	return afficherPageWikini();
	
}
// TODO : qu'affiche-t-on en pied ?
/** Fonction afficherContenuPied() - Fonction appelé par le gestionnaire Papyrus.
*
* Elle retourne le pied de l'application.
*
* @return  string  du code XHTML correspondant au pied renvoyé par l'application.
*/
function afficherContenuPied()
{
    return '';
}
?>