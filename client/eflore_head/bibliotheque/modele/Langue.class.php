<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                |
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
// CVS : $Id: Langue.class.php,v 1.1 2005-11-23 11:13:48 jp_milcent Exp $
/**
* eFlore : Classe Langue
*
* 
*
*@package eFlore
*@subpackage Langue
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2005-11-23 11:13:48 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class Langue extends AModele
{
	/*** Attributes : ***/

	private $nom_principal;
	
	private $code;
	
	/*** Constructeur : ***/
	
	public function __construct()
	{
		
	}
	
	/*** Accesseurs : ***/
	
	// Nom principal
	public function getNomPrincipal()
	{
		return $this->nom_principal;
	}
	public function setNomPrincipal( $np )
	{
		$this->nom_principal = $np;
	}

	// Code
	public function getCode()
	{
		return $this->code;
	}
	public function setCode( $c )
	{
		$this->code = $c;
	}

	/*** Méthodes : ***/
	

} // end of LangueValeur

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: Langue.class.php,v $
* Revision 1.1  2005-11-23 11:13:48  jp_milcent
* Ajout du DAO et du Modele de la table Langue.
*
*
*+-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>