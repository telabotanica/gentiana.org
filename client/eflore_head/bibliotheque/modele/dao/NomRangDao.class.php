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
// CVS : $Id: NomRangDao.class.php,v 1.4 2005-11-24 15:53:04 ddelon Exp $
/**
* Classe d'accès aux données pour les objets appartenant à la classe NomRang
*
*
*
*@package eFlore
*@subpackage nomenclature
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.4 $ $Date: 2005-11-24 15:53:04 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class NomRangDao extends AModeleDao
{
	/*** Attributes : ***/


	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->nom_type_info = 'NomRang';
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
			case EF_CONSULTER_RANG_ID :
				$sql = 	'SELECT DISTINCT * '.
                		'FROM eflore_nom_rang '.
							'WHERE enrg_id_rang = ? ';
				break;
			case EF_CONSULTER_RANG_NOM :
				$sql = 	'SELECT DISTINCT * '.
                		'FROM eflore_nom_rang '.
							'WHERE enrg_intitule_rang LIKE ? ';
				break;
			case EF_CONSULTER_RANG_FAMILLE :
				$sql = 	'SELECT DISTINCT * '.
                		'FROM eflore_nom_rang '.
							'WHERE enrg_id_rang = 120 ';
				break;
			case EF_CONSULTER_RANG_GENRE :
				$sql = 	'SELECT DISTINCT * '.
                		'FROM eflore_nom_rang '.
							'WHERE enrg_id_rang = 160 ';
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
				case 'enrg_id_rang' :
					$un_objet->setId($val, 'rang');
					break;
				case 'enrg_intitule_rang' :
					$un_objet->setIntitule($val);
					break;
				case 'enrg_abreviation_rang' :
					$un_objet->setAbreviation($val);
					break;
				case 'enrg_description_rang' :
					$un_objet->setDescription($val);
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
* $Log: NomRangDao.class.php,v $
* Revision 1.4  2005-11-24 15:53:04  ddelon
* Bug mauvaise utilisation de this
*
* Revision 1.3  2005/10/06 20:23:30  jp_milcent
* Ajout de classes métier pour le module Nomenclature.
*
* Revision 1.2  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
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