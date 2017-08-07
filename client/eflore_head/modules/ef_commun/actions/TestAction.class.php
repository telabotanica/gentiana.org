<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
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
// CVS : $Id: TestAction.class.php,v 1.1 2007-01-05 18:36:55 jp_milcent Exp $
/**
* eflore_bp - effi_test.action.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.1 $ $Date: 2007-01-05 18:36:55 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class TestAction extends aAction {

	public function executer()
	{
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Initialisation des variables		
		$tab_retour = array();
		$tab_retour['exemple'] = 'une donn�e exemple';
				
		// +------------------------------------------------------------------------------------------------------+
		// Envoie des donn�es
		//echo '<pre>'.print_r($tab_retour, true).'</pre>';
		return $tab_retour;
	}
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: TestAction.class.php,v $
* Revision 1.1  2007-01-05 18:36:55  jp_milcent
* Ajout d'une action de test.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>