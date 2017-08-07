<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                         |
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
// CVS : $Id$
/**
* Titre
*
* Description
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class EfCommun extends aServiceDeprecie {
	
	public function __construct($Registre = null)
	{
		// Ajout du nom du service
		$this->setNom('commun');
		// Appel de la classe parente
		parent::__construct($Registre);
	}
	
	public function executer($action) 
	{
		// +-----------------------------------------------------------------------------------------------------------+
		// Mesure du temps d'éxecution : début
		$GLOBALS['_EFLORE_']['chrono']->setTemps(array('debut_commun_'.$action => microtime()));
		
		$retour = parent::executer($action);
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Mesure du temps d'éxecution : fin
		$GLOBALS['_EFLORE_']['chrono']->setTemps(array('fin_commun_'.$action => microtime()));
		
		return $retour;
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.3  2007-07-17 07:47:50  jp_milcent
* Renommage de l'ancienne classe aService en aServiceDeprecie.
*
* Revision 1.2  2006-10-25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.1.2.1  2006/07/27 12:58:11  jp_milcent
* Ajout du fichier module qui peut être appelé.
* Exemple : url base xper...
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
