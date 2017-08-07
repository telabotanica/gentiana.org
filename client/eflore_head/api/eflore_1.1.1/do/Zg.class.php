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
* Classe Zg
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

class Zg extends aDonneesObjet
{
	/*** Constantes : ***/
	/** Donne l'id du projet ISO-3166-1 (Pays actuels).*/
	const ISO_3166_1 = 17;
	
	/** Donne l'id du projet ISO-3166-2 (Subdivision des Pays actuels).*/
	const ISO_3166_2 = 18;
	
	/** Donne l'id du projet ISO-3166-3 (Zones géographiques historiques).*/
	const ISO_3166_3 = 19;
	
	/** Donne l'id du projet INSEE-P (Pays).*/
	const INSEE_P = 20;
	
	/** Donne l'id du projet INSEE-R (Régions).*/
	const INSEE_R = 21;
	
	/** Donne l'id du projet INSEE-D (Départements).*/
	const INSEE_D = 22;
	
	/** Donne l'id du projet INSEE-C (Communes).*/
	const INSEE_C = 23;
	
	/** Donne l'id du projet TDWG-ZG-N1.*/
	const TDWG_ZG_N1 = 35;
	
	/** Donne l'id du projet TDWG-ZG-N2.*/
	const TDWG_ZG_N2 = 34;

	/** Donne l'id du projet TDWG-ZG-N3.*/
	const TDWG_ZG_N3 = 33;
	
	/** Donne l'id du projet TDWG-ZG-N4.*/
	const TDWG_ZG_N4 = 30;	
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'Zg';
	
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
	
	/*** Accesseurs : ***/
	// Intitule Principal
	public function getIntitulePrincipal()
	{
		return $this->intitule_principal;
	}
	public function setIntitulePrincipal( $ip )
	{
		$this->intitule_principal = $ip;
		$this->setMetaAttributsUtilises('intitule_principal');
	}
	
	// Code
	public function getCode()
	{
		return $this->code;
	}
	public function setCode( $c )
	{
		$this->code = $c;
		$this->setMetaAttributsUtilises('code');
	}
	
	// Superficie
	public function getSuperficie()
	{
		return $this->superficie;
	}
	public function setSuperficie( $s )
	{
		$this->superficie = $s;
		$this->setMetaAttributsUtilises('superficie');
	}
	
	// Nombre Habitant
	public function getNombreHabitant()
	{
		return $this->nombre_habitant;
	}
	public function setNombreHabitant( $nh )
	{
		$this->nombre_habitant = $nh;
		$this->setMetaAttributsUtilises('nombre_habitant');
	}
	
	// Date Recensement
	public function getDateRecensement()
	{
		return $this->date_recensement;
	}
	public function setDateRecensement( $dr )
	{
		$this->date_recensement = $dr;
		$this->setMetaAttributsUtilises('date_recensement');
	}
	
	// Altitude Moyenne
	public function getAltitudeMoyenne()
	{
		return $this->altitude_moyenne;
	}
	public function setAltitudeMoyenne( $am )
	{
		$this->altitude_moyenne = $am;
		$this->setMetaAttributsUtilises('altitude_moyenne');
	}
	
	// Altitude Max
	public function getAltitudeMax()
	{
		return $this->altitude_max;
	}
	public function setAltitudeMax( $am )
	{
		$this->altitude_max = $am;
		$this->setMetaAttributsUtilises('altitude_max');
	}
	
	// Altitude Min
	public function getAltitudeMin()
	{
		return $this->altitude_min;
	}
	public function setAltitudeMin( $am )
	{
		$this->altitude_min = $am;
		$this->setMetaAttributsUtilises('altitude_min');
	}
	
	// Longitude
	public function getLongitude()
	{
		return $this->longitude;
	}
	public function setLongitude( $l )
	{
		$this->longitude = $l;
		$this->setMetaAttributsUtilises('longitude');
	}
	
	// Latitude
	public function getLatitude()
	{
		return $this->latitude;
	}
	public function setLatitude( $l )
	{
		$this->latitude = $l;
		$this->setMetaAttributsUtilises('latitude');
	}
	
	// Couleur Rvb
	public function getCouleurRvb()
	{
		return $this->couleur_rvb;
	}
	public function setCouleurRvb( $cr )
	{
		$this->couleur_rvb = $cr;
		$this->setMetaAttributsUtilises('couleur_rvb');
	}
	
	/*** Méthodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.6  2007-02-09 16:35:56  jp_milcent
* Mise à jour vers la version 1.2 des classes DO du module Zone Géo.
*
* Revision 1.5  2007/02/09 16:17:44  jp_milcent
* Ajout de id de projet de zg.
*
* Revision 1.4  2007/01/03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour éviter le téléscopage avec la classe déjà présente dans eFlore.
*
* Revision 1.3  2006/12/28 20:57:16  jp_milcent
* Ajout du module Protection.
*
* Revision 1.2  2006/12/18 17:07:37  jp_milcent
* Les constantes ont été basculées dans l'API.
*
* Revision 1.1  2006/07/20 17:51:29  jp_milcent
* Le dossier modele est renomé en "do" puis les classes qu'il contient sont das "Data Object".
*
* Revision 1.2  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>