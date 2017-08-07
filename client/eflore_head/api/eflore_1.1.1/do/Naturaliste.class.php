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
* Classe Naturaliste
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

class Naturaliste extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'Naturaliste';
	
	/*** Attributes : ***/
	private $lieu_naissance;
	private $date_naissance;
	private $lieu_deces;
	private $date_deces;
	private $date_publication;
	private $notes_naturaliste;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Lieu Naissance
	public function getLieuNaissance()
	{
		return $this->lieu_naissance;
	}
	public function setLieuNaissance( $ln )
	{
		$this->lieu_naissance = $ln;
		$this->setMetaAttributsUtilises('lieu_naissance');
	}
	
	// Date Naissance
	public function getDateNaissance()
	{
		return $this->date_naissance;
	}
	public function setDateNaissance( $dn )
	{
		$this->date_naissance = $dn;
		$this->setMetaAttributsUtilises('date_naissance');
	}
	
	// Lieu Deces
	public function getLieuDeces()
	{
		return $this->lieu_deces;
	}
	public function setLieuDeces( $ld )
	{
		$this->lieu_deces = $ld;
		$this->setMetaAttributsUtilises('lieu_deces');
	}
	
	// Date Deces
	public function getDateDeces()
	{
		return $this->date_deces;
	}
	public function setDateDeces( $dd )
	{
		$this->date_deces = $dd;
		$this->setMetaAttributsUtilises('date_deces');
	}
	
	// Date Publication
	public function getDatePublication()
	{
		return $this->date_publication;
	}
	public function setDatePublication( $dp )
	{
		$this->date_publication = $dp;
		$this->setMetaAttributsUtilises('date_publication');
	}
	
	// Notes Naturaliste
	public function getNotesNaturaliste()
	{
		return $this->notes_naturaliste;
	}
	public function setNotesNaturaliste( $nn )
	{
		$this->notes_naturaliste = $nn;
		$this->setMetaAttributsUtilises('notes_naturaliste');
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