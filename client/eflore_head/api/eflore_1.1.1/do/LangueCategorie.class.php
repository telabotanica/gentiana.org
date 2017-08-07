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
* Classe LangueCategorie
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

class LangueCategorie extends aDonneesObjet
{
	/*** Constantes : ***/
	/** Donne l'id de la categorie Genre et Nombre.*/
	const GENRE_NOMBRE = 3;
	/** Donne l'id de la categorie Genre et Nombre.*/
	const STATUT = 4;
	/** Donne l'id de la categorie Genre et Nombre.*/
	const NIVEAU = 5;
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'LangueCategorie';
	
	/*** Attributes : ***/
	private $intitule_categorie_lg;
	private $abreviation_categorie_lg;
	private $description_categorie_lg;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Intitule Categorie Lg
	public function getIntituleCategorieLg()
	{
		return $this->intitule_categorie_lg;
	}
	public function setIntituleCategorieLg( $icl )
	{
		$this->intitule_categorie_lg = $icl;
		$this->setMetaAttributsUtilises('intitule_categorie_lg');
	}
	
	// Abreviation Categorie Lg
	public function getAbreviationCategorieLg()
	{
		return $this->abreviation_categorie_lg;
	}
	public function setAbreviationCategorieLg( $acl )
	{
		$this->abreviation_categorie_lg = $acl;
		$this->setMetaAttributsUtilises('abreviation_categorie_lg');
	}
	
	// Description Categorie Lg
	public function getDescriptionCategorieLg()
	{
		return $this->description_categorie_lg;
	}
	public function setDescriptionCategorieLg( $dcl )
	{
		$this->description_categorie_lg = $dcl;
		$this->setMetaAttributsUtilises('description_categorie_lg');
	}
	
	/*** Méthodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.3  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour éviter le téléscopage avec la classe déjà présente dans eFlore.
*
* Revision 1.2  2006/12/21 17:25:07  jp_milcent
* Ajout de constante pour récupérer les id des projets.
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