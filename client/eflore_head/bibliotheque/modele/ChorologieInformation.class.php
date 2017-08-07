<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: ChorologieInformation.class.php,v 1.1 2005-10-11 17:30:32 jp_milcent Exp $
/**
* eFlore : Classe ChorologieInformation
*
* 
*
*@package eFlore
*@subpackage Information
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2005-10-11 17:30:32 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ChorologieInformation extends AModele
{
	/*** Attributes : ***/
	private $ordre;
	
	/*** Constructeur : ***/
	
	public function __construct( )
	{

	}
	
	/*** Accesseurs : ***/

	// Ordre
	public function getOrdre( )
	{
		return $this->ordre;
	}
	public function setOrdre( $o )
	{
		$this->ordre = $o;
	}
	
	/*** Méthodes : ***/
	

} // end of ChorologieInformation

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ChorologieInformation.class.php,v $
* Revision 1.1  2005-10-11 17:30:32  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>