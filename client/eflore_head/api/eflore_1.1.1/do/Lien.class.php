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
* Classe Lien
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

class Lien extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'Lien';
	
	/*** Attributes : ***/
	private $titre;
	private $url;
	private $resumer;
	private $mark_partenaire;
	private $mark_reference;
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
	
	// Url
	public function getUrl()
	{
		return $this->url;
	}
	public function setUrl( $u )
	{
		$this->url = $u;
		$this->setMetaAttributsUtilises('url');
	}
	
	// Resumer
	public function getResumer()
	{
		return $this->resumer;
	}
	public function setResumer( $r )
	{
		$this->resumer = $r;
		$this->setMetaAttributsUtilises('resumer');
	}
	
	// Mark Partenaire
	public function getMarkPartenaire()
	{
		return $this->mark_partenaire;
	}
	public function setMarkPartenaire( $mp )
	{
		$this->mark_partenaire = $mp;
		$this->setMetaAttributsUtilises('mark_partenaire');
	}
	
	// Mark Reference
	public function getMarkReference()
	{
		return $this->mark_reference;
	}
	public function setMarkReference( $mr )
	{
		$this->mark_reference = $mr;
		$this->setMetaAttributsUtilises('mark_reference');
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