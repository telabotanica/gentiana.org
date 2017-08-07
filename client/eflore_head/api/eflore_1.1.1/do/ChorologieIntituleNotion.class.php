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
* Classe ChorologieIntituleNotion
*
* Description
*
*@package eFlore
*@subpackage modele
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

class ChorologieIntituleNotion extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'ChorologieIntituleNotion';
	
	/*** Attributes : ***/
	private $intitule_notion_choro;
	private $abreviation_notion_choro;
	private $description_notion_choro;
	private $mark_intitule_notion_choro_origine;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Intitule Notion Choro
	public function getIntituleNotionChoro()
	{
		return $this->intitule_notion_choro;
	}
	public function setIntituleNotionChoro( $inc )
	{
		$this->intitule_notion_choro = $inc;
		$this->setMetaAttributsUtilises('intitule_notion_choro');
	}
	
	// Abreviation Notion Choro
	public function getAbreviationNotionChoro()
	{
		return $this->abreviation_notion_choro;
	}
	public function setAbreviationNotionChoro( $anc )
	{
		$this->abreviation_notion_choro = $anc;
		$this->setMetaAttributsUtilises('abreviation_notion_choro');
	}
	
	// Description Notion Choro
	public function getDescriptionNotionChoro()
	{
		return $this->description_notion_choro;
	}
	public function setDescriptionNotionChoro( $dnc )
	{
		$this->description_notion_choro = $dnc;
		$this->setMetaAttributsUtilises('description_notion_choro');
	}
	
	// Mark Intitule Notion Choro Origine
	public function getMarkIntituleNotionChoroOrigine()
	{
		return $this->mark_intitule_notion_choro_origine;
	}
	public function setMarkIntituleNotionChoroOrigine( $minco )
	{
		$this->mark_intitule_notion_choro_origine = $minco;
		$this->setMetaAttributsUtilises('mark_intitule_notion_choro_origine');
	}
	
	/*** Méthodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour éviter le téléscopage avec la classe déjà présente dans eFlore.
*
* Revision 1.1  2006/07/20 17:51:29  jp_milcent
* Le dossier modele est renomé en "do" puis les classes qu'il contient sont das "Data Object".
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>