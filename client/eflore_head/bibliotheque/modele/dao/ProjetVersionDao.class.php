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
// CVS : $Id: ProjetVersionDao.class.php,v 1.4 2005-10-18 17:17:20 jp_milcent Exp $
/**
* eFlore
*
* 
*
*@package eFlore
*@subpackage projet
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.4 $ $Date: 2005-10-18 17:17:20 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// PROJET_VERSION
/** Récupère les infos sur une versions pour un id donné.*/
define('EF_CONSULTER_PRV_ID', 'EPRV1');
/** Récupère les versions d'un projet donné.*/
define('EF_CONSULTER_VERSION_PROJET', 'EPRV2');
/** Récupère toutes les versions de tous les projets.*/
define('EF_CONSULTER_PRV', 'EPRV3');
/** Récupère la dernière version d'un projet donné.*/
define('EF_CONSULTER_PRV_DERNIERE_VERSION', 'EPRV4');
/** Récupère une version en fonction d'un id de projet et de son code de version.*/
define('EF_CONSULTER_PRV_CODE', 'EPRV5');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ProjetVersionDao extends AModeleDao
{
	/*** Attributes : ***/
	
	
	/*** Constructeur : ***/
	public function __construct(  )
	{
		$this->nom_type_info = 'ProjetVersion';
		parent::__construct();
	}
	
	/*** Accesseurs : ***/
	
	
	/*** Méthodes : ***/
	
	/**
	* @return array
	* @access public
	*/
	public function consulter( $type = null, $param = array() ) {
		switch($type) {
			case EF_CONSULTER_PRV_ID :
				$sql = 	'SELECT DISTINCT * '.
							'FROM eflore_projet_version '.				
							'WHERE eprv_id_version = ?';
				break;
			case EF_CONSULTER_VERSION_PROJET :
				$sql = 	'SELECT DISTINCT * '.
							'FROM eflore_projet_version '.				
							'WHERE eprv_ce_projet = ?';
				break;
			case EF_CONSULTER_PRV :
				$sql = 	'SELECT DISTINCT * '.				
							'FROM eflore_projet_version';
				break;
			case EF_CONSULTER_PRV_DERNIERE_VERSION :
				$sql = 	'SELECT DISTINCT * '.				
							'FROM eflore_projet_version '.
							'WHERE eprv_ce_projet = ? '.
							'AND eprv_date_fin_version IS NULL';
				break;
			case EF_CONSULTER_PRV_CODE :
				$sql = 	'SELECT DISTINCT * '.				
							'FROM eflore_projet_version '.
							'WHERE eprv_ce_projet = ? '.
							'AND eprv_code_version = ? ';
				break;
		}
		$this->setRequete($sql);
		return parent::consulter($param);
	}
	
	/**
	* Ajoute les champs aux bons attributs. 
	* @return array
	* @access public
	*/
	public function attribuerChamps( $donnees )
	{
		$obj_nom = $this->getNomTypeInfo();
		$un_objet = new $obj_nom;
		foreach ($donnees as $cle => $val) {
			switch ($cle) {
				case 'eprv_id_version' :
					$un_objet->setId($val, 'version');
					break;
				case 'eprv_ce_projet' :
					$un_objet->setCe($val, 'projet');
					break;
				case 'eprv_ce_ouvrage_source_version' :
					$un_objet->setCe($val, 'ouvrage_source_version');
					break;
				case 'eprv_date_fin_version' :
					$un_objet->setDateFinVersion($val);
					break;
				case 'eprv_code_version' :
					$un_objet->setCode($val);
					break;
			}
			unset($donnees[$cle]);
		}
		return $un_objet;
	}
} // end of ProjetVersionDao


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ProjetVersionDao.class.php,v $
* Revision 1.4  2005-10-18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.3  2005/09/14 16:57:58  jp_milcent
* Début gestion des fiches, onglet synthèse.
* Amélioration du modèle et des objets DAO.
*
* Revision 1.2  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
* Revision 1.1  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>