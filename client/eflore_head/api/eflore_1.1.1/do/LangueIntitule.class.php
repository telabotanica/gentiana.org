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
* Classe LangueIntitule
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

class LangueIntitule extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante d�finissant le nom de l'objet.*/
	const CLASSE_NOM = 'LangueIntitule';
	
	/*** Attributes : ***/
	private $intitule_langue;
	private $notes_intitule_lg;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Intitule Langue
	public function getIntituleLangue()
	{
		return $this->intitule_langue;
	}
	public function setIntituleLangue( $il )
	{
		$this->intitule_langue = $il;
		$this->setMetaAttributsUtilises('intitule_langue');
	}
	
	// Notes Intitule Lg
	public function getNotesIntituleLg()
	{
		return $this->notes_intitule_lg;
	}
	public function setNotesIntituleLg( $nil )
	{
		$this->notes_intitule_lg = $nil;
		$this->setMetaAttributsUtilises('notes_intitule_lg');
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