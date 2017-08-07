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
* Classe PublicationIdentifiant
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

class PublicationIdentifiant extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'PublicationIdentifiant';
	
	/*** Attributes : ***/
	private $epua_id_abreviation;
	private $code_numerique;
	private $code_alphanumerique;
	private $epi_notes_code_publi;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Epua Id Abreviation
	public function getEpuaIdAbreviation()
	{
		return $this->epua_id_abreviation;
	}
	public function setEpuaIdAbreviation( $eia )
	{
		$this->epua_id_abreviation = $eia;
		$this->setMetaAttributsUtilises('epua_id_abreviation');
	}
	
	// Code Numerique
	public function getCodeNumerique()
	{
		return $this->code_numerique;
	}
	public function setCodeNumerique( $cn )
	{
		$this->code_numerique = $cn;
		$this->setMetaAttributsUtilises('code_numerique');
	}
	
	// Code Alphanumerique
	public function getCodeAlphanumerique()
	{
		return $this->code_alphanumerique;
	}
	public function setCodeAlphanumerique( $ca )
	{
		$this->code_alphanumerique = $ca;
		$this->setMetaAttributsUtilises('code_alphanumerique');
	}
	
	// Epi Notes Code Publi
	public function getEpiNotesCodePubli()
	{
		return $this->epi_notes_code_publi;
	}
	public function setEpiNotesCodePubli( $encp )
	{
		$this->epi_notes_code_publi = $encp;
		$this->setMetaAttributsUtilises('epi_notes_code_publi');
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