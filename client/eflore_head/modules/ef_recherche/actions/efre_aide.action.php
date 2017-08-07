<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of project_name.                                                                |
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
// CVS : $Id: efre_aide.action.php,v 1.2 2006-05-16 16:21:23 jp_milcent Exp $
/**
* Fichier contenant l'aide sur eFlore
*
* 
*
*@package eflore
*@subpackage ef_recherche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.2 $ $Date: 2006-05-16 16:21:23 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionAide {
	
	public function executer()
	{
		// Envoie d'un tableau de données vide car l'aide se suffit à elle même
		return array();	
	}// Fin méthode executer()
	
}// Fin classe ActionAide()


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_aide.action.php,v $
* Revision 1.2  2006-05-16 16:21:23  jp_milcent
* Ajout de l'onglet "Informations" au module ef_recherche permettant d'avoir des informations sur les référentiels tirées de la base de données.
*
* Revision 1.1  2005/10/11 09:40:59  jp_milcent
* Ajout des onglets Accueil et Aide pour permettre l'affichage d'info sous les moteurs de recherche et l'ajout futur de l'onglet Options...
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>