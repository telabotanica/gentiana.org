<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: EfloreUrl.class.php,v 1.8 2007-08-05 10:53:23 jp_milcent Exp $
/**
* Permet de créer et manipuler les formats d'URL d'eFlore.
*
* 
*
*@package eFlore
*@subpackage URL
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.8 $ $Date: 2007-08-05 10:53:23 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
/*Constante representant une séparation entre dossier dans une URL.*/
define('US', '/');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class EfloreUrl extends Net_URL {
	/*** Attributs : ***/
	private $url_base;
	private $type;
	private $type_id;
	private $projet_code;
	private $version_code;
	private $page;
	private $format;
	private $service;
	
	/*** Constructeurs : ***/
	
	public function __construct($url = null, $type = null, $type_id = null, $projet_code = null, $version_code = null, $page = null, $format = null)
	{
		parent::__construct($url);
		$this->url_base = $this->path;
		$this->type = $type;
		$this->type_id = $type_id;
		$this->projet_code = $projet_code;
		$this->version_code = $version_code;
		$this->page = $page;
		$this->format = $format;
	}
	
	/*** Accesseurs : ***/
	// Url Base
	public function getUrlBase()
	{
		return $this->url_base;
	}
	
	// Url Séparation
	/**
	* Retourne le caractère représentant le séparateur de dossier des urls.
	* 
	* @return string caractère de séparation des dossiers des urls.
	*/
	public function getUs()
	{
		return US;
	}
	
	// Type
	public function setType($t)
	{
		$this->type = $t;
	}
	
	// Type Id
	public function setTypeId($ti)
	{
		$this->type_id = $ti;
	}
	
	// Projet Code
	public function setProjetCode($pc)
	{
		$this->projet_code = $pc;
	}
	
	// Version Code
	public function setVersionCode($vc)
	{
		$this->version_code = $vc;
	}
	
	// Page
	public function setPage($p)
	{
		$this->page = $p;
	}

	// Format
	public function setFormat($f)
	{
		$this->format = $f;
	}
	
	// Service
	public function setService($s)
	{
		$this->service = $s;
	}
	
	/*** Méthodes : ***/
	
	public function getURL()
	{
		// Format CODE_PROJET/CODE_VERSION/TYPE/TYPE_ID/PAGE (Exemple : BDNFF/4.02/nn/181/synthese)
		if (!is_null($this->type) && !is_null($this->projet_code) && !is_null($this->version_code) && !is_null($this->type_id)) {
			$this->path = $this->url_base;
			$this->path .= $this->projet_code;
			$this->path .= US.$this->version_code;
			$this->path .= US.$this->type;
			$this->path .= US.$this->type_id;
			if (!is_null($this->page)) { 
				$this->path .= US.$this->page;
			}
			if (!is_null($this->format)) { 
				$this->path .= US.$this->format;
			}
		} else if (!is_null($this->projet_code) && !is_null($this->version_code)) {
			$this->path = $this->url_base;
			$this->path .= $this->projet_code;
			$this->path .= US.$this->version_code;
			if (!is_null($this->page)) { 
				$this->path .= US.$this->page;
			}
			if (!is_null($this->format)) { 
				$this->path .= US.$this->format;
			}
		}
		return parent::getURL();	
	}
	
	/**
	* Retourne le permalien d'un service web d'eFlore.
	* 
	* @return string l'url du service.
	*/
	public function getUrlService()
	{
		$this->path = $this->url_base.'services'.US.$this->service.US;
		return parent::getURL();	
	}
	
	public function getUrlDefaut()
	{
		if (!is_null($this->type) && !is_null($this->projet_code) && !is_null($this->type_id)) {
			$this->path = $this->url_base.$this->projet_code.US.'derniere_version'.US.$this->type.US.$this->type_id;
		}
		return parent::getURL();	
	}

	public function getUrlProjet()
	{
		if (!is_null($this->type) && !is_null($this->projet_code) && !is_null($this->type_id)) {
			$this->path = $this->url_base.$this->type.$this->type_id;
			$this->path .= '-'.$this->projet_code;
		}
		return parent::getURL();	
	}	

	public function getUrlVersion()
	{
		if (!is_null($this->type) && !is_null($this->projet_code) && !is_null($this->version_code) && !is_null($this->type_id)) {
			$this->path = $this->url_base.$this->type.$this->type_id;
			$this->path .= '-'.$this->projet_code;
			$this->path .= '-v'.$this->version_code;
		}
		return parent::getURL();	
	}
	
	public function getUrlReferentielDefaut()
	{
		if (!is_null($this->type) && !is_null($this->type_id)) {
			$this->path = US.$this->type.$this->type_id;
		}
		return parent::getURL();	
	}
	
	public static function parserQueryString($querystring, $encode_query_keys = false, $useBrackets = false)
    {
        $parts  = preg_split('/(&amp;|&)/', $querystring, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($parts as $part) {
            if (strpos($part, '=') !== false) {
                $value = substr($part, strpos($part, '=') + 1);
                $key   = substr($part, 0, strpos($part, '='));
            } else {
                $value = null;
                $key   = $part;
            }

            if (!$encode_query_keys) {
                $key = rawurldecode($key);
            }

            if (preg_match('#^(.*)\[([0-9a-z_-]*)\]#i', $key, $matches)) {
                $key = $matches[1];
                $idx = $matches[2];
                // Ensure is an array
                if (empty($return[$key]) || !is_array($return[$key])) {
                    $return[$key] = array();
                }

                // Add data
                if ($idx === '') {
                    $return[$key][] = $value;
                } else {
                    $return[$key][$idx] = $value;
                }
            } elseif (!$useBrackets AND !empty($return[$key])) {
                $return[$key]   = (array)$return[$key];
                $return[$key][] = $value;
            } else {
                $return[$key] = $value;
            }
        }
        return $return;
   	}
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreUrl.class.php,v $
* Revision 1.8  2007-08-05 10:53:23  jp_milcent
* Ajout de méthodes pour créer des permaliens de Services.
*
* Revision 1.7  2007-07-09 12:15:42  jp_milcent
* Ajout d'une fonction issuer de Net_URL permettant de parser une QueryString et de retourner un tableau.
*
* Revision 1.6  2007-01-24 16:35:25  jp_milcent
* Ajout de la possibilité de fomer des url avec seulement Projet et Version.
*
* Revision 1.5  2006/05/11 10:28:27  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.4  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.3  2005/11/24 16:23:26  jp_milcent
* Correction des permaliens suite à discussion.
*
* Revision 1.2  2005/11/24 16:01:12  jp_milcent
* Suite correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.1  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.1  2005/09/28 16:29:31  jp_milcent
* Début et fin de gestion des onglets.
* Début gestion de la fiche Synonymie.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>