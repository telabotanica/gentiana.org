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
* Classe InfoImage
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

class InfoImage extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'InfoImage';
	
	/*** Attributes : ***/
	private $intitule;
	private $description_courte;
	private $description_longue;
	private $hauteur;
	private $largeur;
	private $poids;
	private $lien_vers_img;
	private $nom_fichier;
	private $autre_auteur;
	private $autre_lien_licence;
	private $notes_image;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Intitule
	public function getIntitule()
	{
		return $this->intitule;
	}
	public function setIntitule( $i )
	{
		$this->intitule = $i;
		$this->setMetaAttributsUtilises('intitule');
	}
	
	// Description Courte
	public function getDescriptionCourte()
	{
		return $this->description_courte;
	}
	public function setDescriptionCourte( $dc )
	{
		$this->description_courte = $dc;
		$this->setMetaAttributsUtilises('description_courte');
	}
	
	// Description Longue
	public function getDescriptionLongue()
	{
		return $this->description_longue;
	}
	public function setDescriptionLongue( $dl )
	{
		$this->description_longue = $dl;
		$this->setMetaAttributsUtilises('description_longue');
	}
	
	// Hauteur
	public function getHauteur()
	{
		return $this->hauteur;
	}
	public function setHauteur( $h )
	{
		$this->hauteur = $h;
		$this->setMetaAttributsUtilises('hauteur');
	}
	
	// Largeur
	public function getLargeur()
	{
		return $this->largeur;
	}
	public function setLargeur( $l )
	{
		$this->largeur = $l;
		$this->setMetaAttributsUtilises('largeur');
	}
	
	// Poids
	public function getPoids()
	{
		return $this->poids;
	}
	public function setPoids( $p )
	{
		$this->poids = $p;
		$this->setMetaAttributsUtilises('poids');
	}
	
	// Lien Vers Img
	public function getLienVersImg()
	{
		return $this->lien_vers_img;
	}
	public function setLienVersImg( $lvi )
	{
		$this->lien_vers_img = $lvi;
		$this->setMetaAttributsUtilises('lien_vers_img');
	}
	
	// Nom Fichier
	public function getNomFichier()
	{
		return $this->nom_fichier;
	}
	public function setNomFichier( $nf )
	{
		$this->nom_fichier = $nf;
		$this->setMetaAttributsUtilises('nom_fichier');
	}
	
	// Autre Auteur
	public function getAutreAuteur()
	{
		return $this->autre_auteur;
	}
	public function setAutreAuteur( $aa )
	{
		$this->autre_auteur = $aa;
		$this->setMetaAttributsUtilises('autre_auteur');
	}
	
	// Autre Lien Licence
	public function getAutreLienLicence()
	{
		return $this->autre_lien_licence;
	}
	public function setAutreLienLicence( $all )
	{
		$this->autre_lien_licence = $all;
		$this->setMetaAttributsUtilises('autre_lien_licence');
	}
	
	// Notes Image
	public function getNotesImage()
	{
		return $this->notes_image;
	}
	public function setNotesImage( $ni )
	{
		$this->notes_image = $ni;
		$this->setMetaAttributsUtilises('notes_image');
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