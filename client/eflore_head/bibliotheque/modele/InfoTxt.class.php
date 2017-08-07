<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
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
// CVS : $Id$
/**
* eFlore : Classe InformationTxt
*
* 
*
*@package eFlore
*@subpackage Information
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

class InfoTxt extends AModele {
	/*** Constantes : ***/
	
	/*** Attributs : ***/
	private $titre;
	private $resumer;
	private $lien_vers_txt;
	private $nom_fichier;
	private $contenu_texte;
	private $autre_auteur;
	private $autre_lien_licence;
	
	/*** Constructeur : ***/
	public function __construct( )
	{

	}
		
	/*** Accesseurs : ***/
	// Titre
	public function getTitre()
	{
		return $this->titre;
	}
	public function setTitre( $t )
	{
		$this->titre = $t;
	}
	
	// Resumer
	public function getResumer()
	{
		return $this->resumer;
	}
	public function setResumer( $r )
	{
		$this->resumer = $r;
	}
	
	// Lien Vers Txt
	public function getLienVersTxt()
	{
		return $this->lien_vers_txt;
	}
	public function setLienVersTxt( $lvt )
	{
		$this->lien_vers_txt = $lvt;
	}
	
	// Nom Fichier
	public function getNomFichier()
	{
		return $this->nom_fichier;
	}
	public function setNomFichier( $nf )
	{
		$this->nom_fichier = $nf;
	}
	
	// Texte
	public function getContenuTexte()
	{
		return $this->contenu_texte;
	}
	public function setContenuTexte( $ct )
	{
		$this->contenu_texte = $ct;
	}
	
	// Autre Auteur
	public function getAutreAuteur()
	{
		return $this->autre_auteur;
	}
	public function setAutreAuteur( $aa )
	{
		$this->autre_auteur = $aa;
	}
	
	// Autre Lien Licence
	public function getAutreLienLicence()
	{
		return $this->autre_lien_licence;
	}
	public function setAutreLienLicence( $all )
	{
		$this->autre_lien_licence = $all;
	}
	
	/*** Méthodes : ***/
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.1  2006-04-25 16:22:24  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des données txt liées au nom sélectionné.
*
* 
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/ 
?>