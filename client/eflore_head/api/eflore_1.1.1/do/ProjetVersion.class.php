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
* Classe ProjetVersion
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

class ProjetVersion extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'ProjetVersion';
	
	/*** Attributes : ***/
	private $nom;
	private $code_version;
	private $date_debut_version;
	private $date_fin_version;
	private $notes_version;
	private $date_deniere_modif;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Nom
	public function getNom()
	{
		return $this->nom;
	}
	public function setNom( $n )
	{
		$this->nom = $n;
		$this->setMetaAttributsUtilises('nom');
	}
	
	// Code Version
	public function getCodeVersion()
	{
		return $this->code_version;
	}
	public function setCodeVersion( $cv )
	{
		$this->code_version = $cv;
		$this->setMetaAttributsUtilises('code_version');
	}
	
	// Date Debut Version
	public function getDateDebutVersion()
	{
		return $this->date_debut_version;
	}
	public function setDateDebutVersion( $ddv )
	{
		$this->date_debut_version = $ddv;
		$this->setMetaAttributsUtilises('date_debut_version');
	}
	
	// Date Fin Version
	public function getDateFinVersion()
	{
		return $this->date_fin_version;
	}
	public function setDateFinVersion( $dfv )
	{
		$this->date_fin_version = $dfv;
		$this->setMetaAttributsUtilises('date_fin_version');
	}
	
	// Notes Version
	public function getNotesVersion()
	{
		return $this->notes_version;
	}
	public function setNotesVersion( $nv )
	{
		$this->notes_version = $nv;
		$this->setMetaAttributsUtilises('notes_version');
	}
	
	// Date Deniere Modif
	public function getDateDeniereModif()
	{
		return $this->date_deniere_modif;
	}
	public function setDateDeniereModif( $ddm )
	{
		$this->date_deniere_modif = $ddm;
		$this->setMetaAttributsUtilises('date_deniere_modif');
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