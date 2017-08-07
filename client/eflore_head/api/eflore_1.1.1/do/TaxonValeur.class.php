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
* Classe TaxonValeur
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

class TaxonValeur extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante d�finissant le nom de l'objet.*/
	const CLASSE_NOM = 'TaxonValeur';
	
	/*** Attributes : ***/
	private $intitule_valeur_taxon;
	private $abreviation_valeur_taxon;
	private $description_valeur_taxon;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Intitule Valeur Taxon
	public function getIntituleValeurTaxon()
	{
		return $this->intitule_valeur_taxon;
	}
	public function setIntituleValeurTaxon( $ivt )
	{
		$this->intitule_valeur_taxon = $ivt;
		$this->setMetaAttributsUtilises('intitule_valeur_taxon');
	}
	
	// Abreviation Valeur Taxon
	public function getAbreviationValeurTaxon()
	{
		return $this->abreviation_valeur_taxon;
	}
	public function setAbreviationValeurTaxon( $avt )
	{
		$this->abreviation_valeur_taxon = $avt;
		$this->setMetaAttributsUtilises('abreviation_valeur_taxon');
	}
	
	// Description Valeur Taxon
	public function getDescriptionValeurTaxon()
	{
		return $this->description_valeur_taxon;
	}
	public function setDescriptionValeurTaxon( $dvt )
	{
		$this->description_valeur_taxon = $dvt;
		$this->setMetaAttributsUtilises('description_valeur_taxon');
	}
	
	/*** M�thodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour �viter le t�l�scopage avec la classe d�j� pr�sente dans eFlore.
*
* Revision 1.1  2006/07/20 17:51:30  jp_milcent
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