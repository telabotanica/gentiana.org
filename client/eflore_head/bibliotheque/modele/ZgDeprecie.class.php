<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.			                                                                |
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
// CVS : $Id: ZgDeprecie.class.php,v 1.1 2007-06-11 15:32:50 jp_milcent Exp $
/**
* eFlore : Classe Zg
*
* 
*
*@package eFlore
*@subpackage Zone_geographique
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2007-06-11 15:32:50 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ZgDeprecie extends AModele
{
	/*** Attributes : ***/

	private $intitule_principal;
	private $code;
	private $superficie;
	private $nombre_habitant;
	private $date_recensement;
	private $altitude_moyenne;
	private $altitude_max;
	private $altitude_min;
	private $longitude;
	private $latitude;
	private $couleur_rvb;  
	
	/*** Constructeur : ***/
	
	public function __construct( )
	{

	}
	
	/*** Accesseurs : ***/

	// IntitulePrincipal
	public function getIntitulePrincipal()
	{
		return $this->intitule_principal; 
	}
	public function setIntitulePrincipal( $ip )
	{
		$this->intitule_principal = $ip; 
	}

	// Code
	public function getCode()
	{
		return $this->code; 
	}
	public function setCode( $c )
	{
		$this->code = $c; 
	}
	
	// Superficie
	public function getSuperficie()
	{
		return $this->superficie; 
	}
	public function setSuperficie( $s )
	{
		$this->superficie = $s; 
	}
	
	// Nombre Habitant
	public function getNombreHabitant()
	{
		return $this->nombre_habitant; 
	}
	public function setNombreHabitant( $nh )
	{
		$this->nombre_habitant = $nh; 
	}
	
	// Date Recensement
	public function getDateRecensement()
	{
		return $this->date_recensement; 
	}
	public function setDateRecensement( $dr )
	{
		$this->date_recensement = $dr; 
	}
	
	// Altitude Moyenne
	public function getAltitudeMoyenne()
	{
		return $this->altitude_moyenne; 
	}
	public function setAltitudeMoyenne( $amo )
	{
		$this->altitude_moyenne = $amo; 
	}
	
	// Altitude Max
	public function getAltitudeMax()
	{
		return $this->altitude_max; 
	}
	public function setAltitudeMax( $ama )
	{
		$this->altitude_max = $ama; 
	}
	
	// Altitude Min
	public function getAltitudeMin()
	{
		return $this->altitude_min; 
	}
	public function setAltitudeMin( $ami )
	{
		$this->altitude_min = $ami;
	}

	// Longitude
	public function getLongitude()
	{
		return $this->longitude; 
	}
	public function setLongitude( $lo )
	{
		$this->longitude = $lo;
	}
	
	// Latitude
	public function getLatitude()
	{
		return $this->latitude; 
	}
	public function setLatitude( $la )
	{
		$this->latitude = $la;
	}
	
	// Couleur Rvb
	public function getCouleurRvb()
	{
		return $this->couleur_rvb; 
	}
	public function setCouleurRvb( $cr )
	{
		$this->couleur_rvb = $cr;
	}
	
	/*** Méthodes : ***/
	

} // end of Zg

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ZgDeprecie.class.php,v $
* Revision 1.1  2007-06-11 15:32:50  jp_milcent
* Correction problème entre ancienne api et nouvelle version 1.1.1
*
* Revision 1.3  2006-10-25 09:06:03  jp_milcent
* Ajout des nouveaux champs pour la table des zg.
*
* Revision 1.2  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
* Revision 1.1  2005/09/27 16:03:46  jp_milcent
* Fin de l'amélioration de la gestion des noms vernaculaires dans l'onglet Synthèse.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>