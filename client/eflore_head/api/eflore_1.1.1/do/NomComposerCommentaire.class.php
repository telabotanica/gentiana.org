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
* Classe NomComposerCommentaire
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

class NomComposerCommentaire extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante d�finissant le nom de l'objet.*/
	const CLASSE_NOM = 'NomComposerCommentaire';
	
	/*** Attributes : ***/
	private $mark_in_auteur_citation;
	private $date_homonyme;
	private $complement;
	private $notes_avoir_cn;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Mark In Auteur Citation
	public function getMarkInAuteurCitation()
	{
		return $this->mark_in_auteur_citation;
	}
	public function setMarkInAuteurCitation( $miac )
	{
		$this->mark_in_auteur_citation = $miac;
		$this->setMetaAttributsUtilises('mark_in_auteur_citation');
	}
	
	// Date Homonyme
	public function getDateHomonyme()
	{
		return $this->date_homonyme;
	}
	public function setDateHomonyme( $dh )
	{
		$this->date_homonyme = $dh;
		$this->setMetaAttributsUtilises('date_homonyme');
	}
	
	// Complement
	public function getComplement()
	{
		return $this->complement;
	}
	public function setComplement( $c )
	{
		$this->complement = $c;
		$this->setMetaAttributsUtilises('complement');
	}
	
	// Notes Avoir Cn
	public function getNotesAvoirCn()
	{
		return $this->notes_avoir_cn;
	}
	public function setNotesAvoirCn( $nac )
	{
		$this->notes_avoir_cn = $nac;
		$this->setMetaAttributsUtilises('notes_avoir_cn');
	}
	
	/*** M�thodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour �viter le t�l�scopage avec la classe d�j� pr�sente dans eFlore.
*
* Revision 1.1  2006/07/20 17:51:29  jp_milcent
* Le dossier modele est renom� en "do" puis les classes qu'il contient sont das "Data Object".
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes g�n�r�es automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>