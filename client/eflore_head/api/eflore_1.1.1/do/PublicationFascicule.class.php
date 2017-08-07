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
* Classe PublicationFascicule
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

class PublicationFascicule extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'PublicationFascicule';
	
	/*** Attributes : ***/
	private $titre;
	private $date_parution;
	private $nbre_page;
	private $lien_img_fascicule;
	private $mark_cacher_info;
	private $commentaire_public;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Titre
	public function getTitre()
	{
		return $this->titre;
	}
	public function setTitre( $t )
	{
		$this->titre = $t;
		$this->setMetaAttributsUtilises('titre');
	}
	
	// Date Parution
	public function getDateParution()
	{
		return $this->date_parution;
	}
	public function setDateParution( $dp )
	{
		$this->date_parution = $dp;
		$this->setMetaAttributsUtilises('date_parution');
	}
	
	// Nbre Page
	public function getNbrePage()
	{
		return $this->nbre_page;
	}
	public function setNbrePage( $np )
	{
		$this->nbre_page = $np;
		$this->setMetaAttributsUtilises('nbre_page');
	}
	
	// Lien Img Fascicule
	public function getLienImgFascicule()
	{
		return $this->lien_img_fascicule;
	}
	public function setLienImgFascicule( $lif )
	{
		$this->lien_img_fascicule = $lif;
		$this->setMetaAttributsUtilises('lien_img_fascicule');
	}
	
	// Mark Cacher Info
	public function getMarkCacherInfo()
	{
		return $this->mark_cacher_info;
	}
	public function setMarkCacherInfo( $mci )
	{
		$this->mark_cacher_info = $mci;
		$this->setMetaAttributsUtilises('mark_cacher_info');
	}
	
	// Commentaire Public
	public function getCommentairePublic()
	{
		return $this->commentaire_public;
	}
	public function setCommentairePublic( $cp )
	{
		$this->commentaire_public = $cp;
		$this->setMetaAttributsUtilises('commentaire_public');
	}
	
	/*** Méthodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour éviter le téléscopage avec la classe déjà présente dans eFlore.
*
* Revision 1.1  2006/07/20 17:51:30  jp_milcent
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