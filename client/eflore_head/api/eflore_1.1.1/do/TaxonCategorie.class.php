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
* Classe TaxonCategorie
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

class TaxonCategorie extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'TaxonCategorie';
	
	/*** Attributes : ***/
	private $intitule_categorie_taxon;
	private $abreviation_categorie_taxon;
	private $description_categorie_taxon;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Intitule Categorie Taxon
	public function getIntituleCategorieTaxon()
	{
		return $this->intitule_categorie_taxon;
	}
	public function setIntituleCategorieTaxon( $ict )
	{
		$this->intitule_categorie_taxon = $ict;
		$this->setMetaAttributsUtilises('intitule_categorie_taxon');
	}
	
	// Abreviation Categorie Taxon
	public function getAbreviationCategorieTaxon()
	{
		return $this->abreviation_categorie_taxon;
	}
	public function setAbreviationCategorieTaxon( $act )
	{
		$this->abreviation_categorie_taxon = $act;
		$this->setMetaAttributsUtilises('abreviation_categorie_taxon');
	}
	
	// Description Categorie Taxon
	public function getDescriptionCategorieTaxon()
	{
		return $this->description_categorie_taxon;
	}
	public function setDescriptionCategorieTaxon( $dct )
	{
		$this->description_categorie_taxon = $dct;
		$this->setMetaAttributsUtilises('description_categorie_taxon');
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