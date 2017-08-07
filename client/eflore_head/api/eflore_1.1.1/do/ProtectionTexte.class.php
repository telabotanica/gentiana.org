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
// CVS : $Id: ProtectionTexte.class.php,v 1.2 2007-01-03 17:05:30 jp_milcent Exp $
/**
* Classe ProtectionTexte
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
*@version       $Revision: 1.2 $ $Date: 2007-01-03 17:05:30 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ProtectionTexte extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'ProtectionTexte';
	
	/*** Attributes : ***/
	private $intitule;
	private $nor;
	private $abreviation;
	private $description;
	private $url_texte_loi;
	
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
	
	// Nor
	public function getNor()
	{
		return $this->nor;
	}
	public function setNor( $n )
	{
		$this->nor = $n;
		$this->setMetaAttributsUtilises('nor');
	}
	
	// Abreviation
	public function getAbreviation()
	{
		return $this->abreviation;
	}
	public function setAbreviation( $a )
	{
		$this->abreviation = $a;
		$this->setMetaAttributsUtilises('abreviation');
	}
	
	// Description
	public function getDescription()
	{
		return $this->description;
	}
	public function setDescription( $d )
	{
		$this->description = $d;
		$this->setMetaAttributsUtilises('description');
	}
	
	// Url Texte Loi
	public function getUrlTexteLoi()
	{
		return $this->url_texte_loi;
	}
	public function setUrlTexteLoi( $utl )
	{
		$this->url_texte_loi = $utl;
		$this->setMetaAttributsUtilises('url_texte_loi');
	}
	
	/*** Méthodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ProtectionTexte.class.php,v $
* Revision 1.2  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour éviter le téléscopage avec la classe déjà présente dans eFlore.
*
* Revision 1.1  2006/12/28 20:57:16  jp_milcent
* Ajout du module Protection.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>