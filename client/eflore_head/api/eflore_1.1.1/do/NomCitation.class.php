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
* Classe NomCitation
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

class NomCitation extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'NomCitation';
	
	/*** Attributes : ***/
	private $intitule_citation_origine;
	private $intitule_complet_citation;
	private $annee_citation;
	private $serie;
	private $edition;
	private $volume;
	private $pages;
	private $notes_citation;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Intitule Citation Origine
	public function getIntituleCitationOrigine()
	{
		return $this->intitule_citation_origine;
	}
	public function setIntituleCitationOrigine( $ico )
	{
		$this->intitule_citation_origine = $ico;
		$this->setMetaAttributsUtilises('intitule_citation_origine');
	}
	
	// Intitule Complet Citation
	public function getIntituleCompletCitation()
	{
		return $this->intitule_complet_citation;
	}
	public function setIntituleCompletCitation( $icc )
	{
		$this->intitule_complet_citation = $icc;
		$this->setMetaAttributsUtilises('intitule_complet_citation');
	}
	
	// Annee Citation
	public function getAnneeCitation()
	{
		return $this->annee_citation;
	}
	public function setAnneeCitation( $ac )
	{
		$this->annee_citation = $ac;
		$this->setMetaAttributsUtilises('annee_citation');
	}
	
	// Serie
	public function getSerie()
	{
		return $this->serie;
	}
	public function setSerie( $s )
	{
		$this->serie = $s;
		$this->setMetaAttributsUtilises('serie');
	}
	
	// Edition
	public function getEdition()
	{
		return $this->edition;
	}
	public function setEdition( $e )
	{
		$this->edition = $e;
		$this->setMetaAttributsUtilises('edition');
	}
	
	// Volume
	public function getVolume()
	{
		return $this->volume;
	}
	public function setVolume( $v )
	{
		$this->volume = $v;
		$this->setMetaAttributsUtilises('volume');
	}
	
	// Pages
	public function getPages()
	{
		return $this->pages;
	}
	public function setPages( $p )
	{
		$this->pages = $p;
		$this->setMetaAttributsUtilises('pages');
	}
	
	// Notes Citation
	public function getNotesCitation()
	{
		return $this->notes_citation;
	}
	public function setNotesCitation( $nc )
	{
		$this->notes_citation = $nc;
		$this->setMetaAttributsUtilises('notes_citation');
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