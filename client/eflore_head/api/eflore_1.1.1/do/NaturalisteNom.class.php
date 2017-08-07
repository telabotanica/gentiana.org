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
* Classe NaturalisteNom
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

class NaturalisteNom extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'NaturalisteNom';
	
	/*** Attributes : ***/
	private $prenom_principal;
	private $prenom_deux;
	private $prenom_trois;
	private $nom;
	private $nom_complet;
	private $notes_nom;
	private $ena_date_derniere_modif;
	private $ena_ce_modifier_par;
	private $ena_ce_etat;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Prenom Principal
	public function getPrenomPrincipal()
	{
		return $this->prenom_principal;
	}
	public function setPrenomPrincipal( $pp )
	{
		$this->prenom_principal = $pp;
		$this->setMetaAttributsUtilises('prenom_principal');
	}
	
	// Prenom Deux
	public function getPrenomDeux()
	{
		return $this->prenom_deux;
	}
	public function setPrenomDeux( $pd )
	{
		$this->prenom_deux = $pd;
		$this->setMetaAttributsUtilises('prenom_deux');
	}
	
	// Prenom Trois
	public function getPrenomTrois()
	{
		return $this->prenom_trois;
	}
	public function setPrenomTrois( $pt )
	{
		$this->prenom_trois = $pt;
		$this->setMetaAttributsUtilises('prenom_trois');
	}
	
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
	
	// Nom Complet
	public function getNomComplet()
	{
		return $this->nom_complet;
	}
	public function setNomComplet( $nc )
	{
		$this->nom_complet = $nc;
		$this->setMetaAttributsUtilises('nom_complet');
	}
	
	// Notes Nom
	public function getNotesNom()
	{
		return $this->notes_nom;
	}
	public function setNotesNom( $nn )
	{
		$this->notes_nom = $nn;
		$this->setMetaAttributsUtilises('notes_nom');
	}
	
	// Ena Date Derniere Modif
	public function getEnaDateDerniereModif()
	{
		return $this->ena_date_derniere_modif;
	}
	public function setEnaDateDerniereModif( $eddm )
	{
		$this->ena_date_derniere_modif = $eddm;
		$this->setMetaAttributsUtilises('ena_date_derniere_modif');
	}
	
	// Ena Ce Modifier Par
	public function getEnaCeModifierPar()
	{
		return $this->ena_ce_modifier_par;
	}
	public function setEnaCeModifierPar( $ecmp )
	{
		$this->ena_ce_modifier_par = $ecmp;
		$this->setMetaAttributsUtilises('ena_ce_modifier_par');
	}
	
	// Ena Ce Etat
	public function getEnaCeEtat()
	{
		return $this->ena_ce_etat;
	}
	public function setEnaCeEtat( $ece )
	{
		$this->ena_ce_etat = $ece;
		$this->setMetaAttributsUtilises('ena_ce_etat');
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