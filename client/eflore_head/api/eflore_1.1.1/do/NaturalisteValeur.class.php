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
* Classe NaturalisteValeur
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

class NaturalisteValeur extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'NaturalisteValeur';
	
	/*** Attributes : ***/
	private $enacv_id_categorie_naturaliste;
	private $intitule_valeur_categorie_naturaliste;
	private $abreviation_valeur_categorie_naturaliste;
	private $description_valeur_categorie_naturaliste;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Enacv Id Categorie Naturaliste
	public function getEnacvIdCategorieNaturaliste()
	{
		return $this->enacv_id_categorie_naturaliste;
	}
	public function setEnacvIdCategorieNaturaliste( $eicn )
	{
		$this->enacv_id_categorie_naturaliste = $eicn;
		$this->setMetaAttributsUtilises('enacv_id_categorie_naturaliste');
	}
	
	// Intitule Valeur Categorie Naturaliste
	public function getIntituleValeurCategorieNaturaliste()
	{
		return $this->intitule_valeur_categorie_naturaliste;
	}
	public function setIntituleValeurCategorieNaturaliste( $ivcn )
	{
		$this->intitule_valeur_categorie_naturaliste = $ivcn;
		$this->setMetaAttributsUtilises('intitule_valeur_categorie_naturaliste');
	}
	
	// Abreviation Valeur Categorie Naturaliste
	public function getAbreviationValeurCategorieNaturaliste()
	{
		return $this->abreviation_valeur_categorie_naturaliste;
	}
	public function setAbreviationValeurCategorieNaturaliste( $avcn )
	{
		$this->abreviation_valeur_categorie_naturaliste = $avcn;
		$this->setMetaAttributsUtilises('abreviation_valeur_categorie_naturaliste');
	}
	
	// Description Valeur Categorie Naturaliste
	public function getDescriptionValeurCategorieNaturaliste()
	{
		return $this->description_valeur_categorie_naturaliste;
	}
	public function setDescriptionValeurCategorieNaturaliste( $dvcn )
	{
		$this->description_valeur_categorie_naturaliste = $dvcn;
		$this->setMetaAttributsUtilises('description_valeur_categorie_naturaliste');
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