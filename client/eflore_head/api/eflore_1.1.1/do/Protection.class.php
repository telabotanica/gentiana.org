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
// CVS : $Id: Protection.class.php,v 1.2 2007-01-03 17:05:30 jp_milcent Exp $
/**
* Classe Protection
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

class Protection extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante d�finissant le nom de l'objet.*/
	const CLASSE_NOM = 'Protection';
	
	/*** Attributes : ***/
	private $nom_scientifique;
	private $nom_vernaculaire;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Nom Scientifique
	public function getNomScientifique()
	{
		return $this->nom_scientifique;
	}
	public function setNomScientifique( $ns )
	{
		$this->nom_scientifique = $ns;
		$this->setMetaAttributsUtilises('nom_scientifique');
	}
	
	// Nom Vernaculaire
	public function getNomVernaculaire()
	{
		return $this->nom_vernaculaire;
	}
	public function setNomVernaculaire( $nv )
	{
		$this->nom_vernaculaire = $nv;
		$this->setMetaAttributsUtilises('nom_vernaculaire');
	}
	
	/*** M�thodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: Protection.class.php,v $
* Revision 1.2  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour �viter le t�l�scopage avec la classe d�j� pr�sente dans eFlore.
*
* Revision 1.1  2006/12/28 20:57:16  jp_milcent
* Ajout du module Protection.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes g�n�r�es automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>