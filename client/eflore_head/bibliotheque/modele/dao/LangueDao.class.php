<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                |
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
// CVS : $Id: LangueDao.class.php,v 1.1 2005-11-23 11:13:48 jp_milcent Exp $
/**
* eFlore : Classe LangueDao
*
* 
*
*@package eFlore
*@subpackage Langue
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2005-11-23 11:13:48 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// LANGUE
/** Récupère les infos d'une langue pour un id et une version de projet.*/
define('EF_CONSULTER_L_VERSION_ID', 'EFL1');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class LangueDao extends AModeleDao
{
	/*** Attributes : ***/
	
		
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->setNomTypeInfo('Langue');
		parent::__construct();
	}
	
	/*** Accesseurs : ***/
	
	
	/*** Méthodes : ***/
	
	/**
	* @return array
	* @access public
	*/
	public function consulter( $type = NULL, $param = array() )
	{
		switch($type) {
			case EF_CONSULTER_L_VERSION_ID :
				$sql =	'SELECT DISTINCT * 
		               FROM eflore_langue
		               WHERE el_id_langue = ? 
		               AND el_id_version_projet_langue = ?';
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
				case 'el_id_langue' :
					$un_objet->setId($val, 'langue');
					break;
				case 'el_id_version_projet_langue' :
					$un_objet->setId($val, 'version_projet_langue');
					break;
				case 'el_nom_langue_principal' :
					$un_objet->setNomPrincipal($val);
					break;
				case 'el_code_langue' :
					$un_objet->setCode($val);
					break;
				case 'el_note_langue' :
					$un_objet->setNotes($val);
					break;
				case 'el_date_derniere_modif' :
					$un_objet->setDateDerniereModif($val);
					break;
				case 'el_ce_modifier_par' :
					$un_objet->setCe($val, 'modifier_par');
					break;
				case 'el_ce_etat' :
					$un_objet->setCe($val, 'etat');
					break;
				default:
					$un_objet->$cle = $val;
			}
			unset($donnees[$cle]);
		}
		return $un_objet;
	}
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: LangueDao.class.php,v $
* Revision 1.1  2005-11-23 11:13:48  jp_milcent
* Ajout du DAO et du Modele de la table Langue.
*
*
*+-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>