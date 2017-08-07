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
* Classe InventaireStation
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

class InventaireStation extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'InventaireStation';
	
	/*** Attributes : ***/
	private $autre_contributeur;
	private $description;
	private $lieudit;
	private $zone_geo_autre;
	private $altitude;
	private $maille;
	private $coordonnee_x;
	private $coordonne_y;
	private $precision_xy;
	private $latitude_wgs84;
	private $longitude_wgs84;
	private $precision_lat_long;
	private $notes_station;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Autre Contributeur
	public function getAutreContributeur()
	{
		return $this->autre_contributeur;
	}
	public function setAutreContributeur( $ac )
	{
		$this->autre_contributeur = $ac;
		$this->setMetaAttributsUtilises('autre_contributeur');
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
	
	// Lieudit
	public function getLieudit()
	{
		return $this->lieudit;
	}
	public function setLieudit( $l )
	{
		$this->lieudit = $l;
		$this->setMetaAttributsUtilises('lieudit');
	}
	
	// Zone Geo Autre
	public function getZoneGeoAutre()
	{
		return $this->zone_geo_autre;
	}
	public function setZoneGeoAutre( $zga )
	{
		$this->zone_geo_autre = $zga;
		$this->setMetaAttributsUtilises('zone_geo_autre');
	}
	
	// Altitude
	public function getAltitude()
	{
		return $this->altitude;
	}
	public function setAltitude( $a )
	{
		$this->altitude = $a;
		$this->setMetaAttributsUtilises('altitude');
	}
	
	// Maille
	public function getMaille()
	{
		return $this->maille;
	}
	public function setMaille( $m )
	{
		$this->maille = $m;
		$this->setMetaAttributsUtilises('maille');
	}
	
	// Coordonnee X
	public function getCoordonneeX()
	{
		return $this->coordonnee_x;
	}
	public function setCoordonneeX( $cx )
	{
		$this->coordonnee_x = $cx;
		$this->setMetaAttributsUtilises('coordonnee_x');
	}
	
	// Coordonne Y
	public function getCoordonneY()
	{
		return $this->coordonne_y;
	}
	public function setCoordonneY( $cy )
	{
		$this->coordonne_y = $cy;
		$this->setMetaAttributsUtilises('coordonne_y');
	}
	
	// Precision Xy
	public function getPrecisionXy()
	{
		return $this->precision_xy;
	}
	public function setPrecisionXy( $px )
	{
		$this->precision_xy = $px;
		$this->setMetaAttributsUtilises('precision_xy');
	}
	
	// Latitude Wgs84
	public function getLatitudeWgs84()
	{
		return $this->latitude_wgs84;
	}
	public function setLatitudeWgs84( $lw )
	{
		$this->latitude_wgs84 = $lw;
		$this->setMetaAttributsUtilises('latitude_wgs84');
	}
	
	// Longitude Wgs84
	public function getLongitudeWgs84()
	{
		return $this->longitude_wgs84;
	}
	public function setLongitudeWgs84( $lw )
	{
		$this->longitude_wgs84 = $lw;
		$this->setMetaAttributsUtilises('longitude_wgs84');
	}
	
	// Precision Lat Long
	public function getPrecisionLatLong()
	{
		return $this->precision_lat_long;
	}
	public function setPrecisionLatLong( $pll )
	{
		$this->precision_lat_long = $pll;
		$this->setMetaAttributsUtilises('precision_lat_long');
	}
	
	// Notes Station
	public function getNotesStation()
	{
		return $this->notes_station;
	}
	public function setNotesStation( $ns )
	{
		$this->notes_station = $ns;
		$this->setMetaAttributsUtilises('notes_station');
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