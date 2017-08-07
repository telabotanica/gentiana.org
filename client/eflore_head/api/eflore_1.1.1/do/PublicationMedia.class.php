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
* Classe PublicationMedia
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

class PublicationMedia extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'PublicationMedia';
	
	/*** Attributes : ***/
	private $ref_media_complete;
	private $annee_publi;
	private $titre_media;
	private $numero_edition;
	private $nom_collection;
	private $numero_collection;
	private $series;
	private $volume;
	private $prix;
	private $ville_publication;
	private $nom_editeur;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Ref Media Complete
	public function getRefMediaComplete()
	{
		return $this->ref_media_complete;
	}
	public function setRefMediaComplete( $rmc )
	{
		$this->ref_media_complete = $rmc;
		$this->setMetaAttributsUtilises('ref_media_complete');
	}
	
	// Annee Publi
	public function getAnneePubli()
	{
		return $this->annee_publi;
	}
	public function setAnneePubli( $ap )
	{
		$this->annee_publi = $ap;
		$this->setMetaAttributsUtilises('annee_publi');
	}
	
	// Titre Media
	public function getTitreMedia()
	{
		return $this->titre_media;
	}
	public function setTitreMedia( $tm )
	{
		$this->titre_media = $tm;
		$this->setMetaAttributsUtilises('titre_media');
	}
	
	// Numero Edition
	public function getNumeroEdition()
	{
		return $this->numero_edition;
	}
	public function setNumeroEdition( $ne )
	{
		$this->numero_edition = $ne;
		$this->setMetaAttributsUtilises('numero_edition');
	}
	
	// Nom Collection
	public function getNomCollection()
	{
		return $this->nom_collection;
	}
	public function setNomCollection( $nc )
	{
		$this->nom_collection = $nc;
		$this->setMetaAttributsUtilises('nom_collection');
	}
	
	// Numero Collection
	public function getNumeroCollection()
	{
		return $this->numero_collection;
	}
	public function setNumeroCollection( $nc )
	{
		$this->numero_collection = $nc;
		$this->setMetaAttributsUtilises('numero_collection');
	}
	
	// Series
	public function getSeries()
	{
		return $this->series;
	}
	public function setSeries( $s )
	{
		$this->series = $s;
		$this->setMetaAttributsUtilises('series');
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
	
	// Prix
	public function getPrix()
	{
		return $this->prix;
	}
	public function setPrix( $p )
	{
		$this->prix = $p;
		$this->setMetaAttributsUtilises('prix');
	}
	
	// Ville Publication
	public function getVillePublication()
	{
		return $this->ville_publication;
	}
	public function setVillePublication( $vp )
	{
		$this->ville_publication = $vp;
		$this->setMetaAttributsUtilises('ville_publication');
	}
	
	// Nom Editeur
	public function getNomEditeur()
	{
		return $this->nom_editeur;
	}
	public function setNomEditeur( $ne )
	{
		$this->nom_editeur = $ne;
		$this->setMetaAttributsUtilises('nom_editeur');
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