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
* Classe Personne
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

class Personne extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'Personne';
	
	/*** Attributes : ***/
	private $nom;
	private $prenom;
	private $login;
	private $mot_de_passe;
	private $courriel_01;
	private $courriel_02;
	private $web;
	private $adresse_01;
	private $adresse_02;
	private $code_postal;
	private $ville;
	private $date_inscription;
	
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
	
	// Prenom
	public function getPrenom()
	{
		return $this->prenom;
	}
	public function setPrenom( $p )
	{
		$this->prenom = $p;
		$this->setMetaAttributsUtilises('prenom');
	}
	
	// Login
	public function getLogin()
	{
		return $this->login;
	}
	public function setLogin( $l )
	{
		$this->login = $l;
		$this->setMetaAttributsUtilises('login');
	}
	
	// Mot De Passe
	public function getMotDePasse()
	{
		return $this->mot_de_passe;
	}
	public function setMotDePasse( $mdp )
	{
		$this->mot_de_passe = $mdp;
		$this->setMetaAttributsUtilises('mot_de_passe');
	}
	
	// Courriel 01
	public function getCourriel01()
	{
		return $this->courriel_01;
	}
	public function setCourriel01( $c )
	{
		$this->courriel_01 = $c;
		$this->setMetaAttributsUtilises('courriel_01');
	}
	
	// Courriel 02
	public function getCourriel02()
	{
		return $this->courriel_02;
	}
	public function setCourriel02( $c )
	{
		$this->courriel_02 = $c;
		$this->setMetaAttributsUtilises('courriel_02');
	}
	
	// Web
	public function getWeb()
	{
		return $this->web;
	}
	public function setWeb( $w )
	{
		$this->web = $w;
		$this->setMetaAttributsUtilises('web');
	}
	
	// Adresse 01
	public function getAdresse01()
	{
		return $this->adresse_01;
	}
	public function setAdresse01( $a )
	{
		$this->adresse_01 = $a;
		$this->setMetaAttributsUtilises('adresse_01');
	}
	
	// Adresse 02
	public function getAdresse02()
	{
		return $this->adresse_02;
	}
	public function setAdresse02( $a )
	{
		$this->adresse_02 = $a;
		$this->setMetaAttributsUtilises('adresse_02');
	}
	
	// Code Postal
	public function getCodePostal()
	{
		return $this->code_postal;
	}
	public function setCodePostal( $cp )
	{
		$this->code_postal = $cp;
		$this->setMetaAttributsUtilises('code_postal');
	}
	
	// Ville
	public function getVille()
	{
		return $this->ville;
	}
	public function setVille( $v )
	{
		$this->ville = $v;
		$this->setMetaAttributsUtilises('ville');
	}
	
	// Date Inscription
	public function getDateInscription()
	{
		return $this->date_inscription;
	}
	public function setDateInscription( $di )
	{
		$this->date_inscription = $di;
		$this->setMetaAttributsUtilises('date_inscription');
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