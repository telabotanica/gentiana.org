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
* Classe InventaireDetermination
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

class InventaireDetermination extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'InventaireDetermination';
	
	/*** Attributes : ***/
	private $autre_ouvrage_determination;
	private $certitude_determination;
	private $commentaire_determination;
	private $mark_determination_origine;
	private $notes_determination;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Autre Ouvrage Determination
	public function getAutreOuvrageDetermination()
	{
		return $this->autre_ouvrage_determination;
	}
	public function setAutreOuvrageDetermination( $aod )
	{
		$this->autre_ouvrage_determination = $aod;
		$this->setMetaAttributsUtilises('autre_ouvrage_determination');
	}
	
	// Certitude Determination
	public function getCertitudeDetermination()
	{
		return $this->certitude_determination;
	}
	public function setCertitudeDetermination( $cd )
	{
		$this->certitude_determination = $cd;
		$this->setMetaAttributsUtilises('certitude_determination');
	}
	
	// Commentaire Determination
	public function getCommentaireDetermination()
	{
		return $this->commentaire_determination;
	}
	public function setCommentaireDetermination( $cd )
	{
		$this->commentaire_determination = $cd;
		$this->setMetaAttributsUtilises('commentaire_determination');
	}
	
	// Mark Determination Origine
	public function getMarkDeterminationOrigine()
	{
		return $this->mark_determination_origine;
	}
	public function setMarkDeterminationOrigine( $mdo )
	{
		$this->mark_determination_origine = $mdo;
		$this->setMetaAttributsUtilises('mark_determination_origine');
	}
	
	// Notes Determination
	public function getNotesDetermination()
	{
		return $this->notes_determination;
	}
	public function setNotesDetermination( $nd )
	{
		$this->notes_determination = $nd;
		$this->setMetaAttributsUtilises('notes_determination');
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