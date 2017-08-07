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
// CVS : $Id: TaxonRelationDao.class.php,v 1.1 2005-10-13 16:25:05 jp_milcent Exp $
/**
* eFlore : Classe DAO TaxonRelation
*
* 
*
*@package eFlore
*@subpackage Taxon
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2005-10-13 16:25:05 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// ZG
/** Récupère les infos d'une relation entre taxon.*/
define('EF_CONSULTER_TR_CATEGORIE_VALEUR_VERSION_ID', 'ETR1');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class TaxonRelationDao extends AModeleDao
{
	/*** Attributes : ***/
	
		
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->setNomTypeInfo('TaxonRelation');
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
			case EF_CONSULTER_TR_CATEGORIE_VALEUR_VERSION_ID :
				$sql =	'SELECT DISTINCT * '.
		               'FROM eflore_taxon_relation '.
		               'WHERE etr_id_taxon_1 = ? '. 
		               'AND etr_id_version_projet_taxon_1 = ? '.
		               'AND etr_id_categorie_taxon = ? '.
		               'AND etr_id_valeur_taxon = ? ';
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
				case 'etr_id_taxon_1' :
					$un_objet->setId($val, 'taxon_1');
					break;
				case 'etr_id_version_projet_taxon_1' :
					$un_objet->setId($val, 'version_projet_taxon_1');
					break;
				case 'etr_id_taxon_2' :
					$un_objet->setId($val, 'taxon_2');
					break;
				case 'etr_id_version_projet_taxon_2' :
					$un_objet->setId($val, 'version_projet_taxon_2');
					break;
				case 'etr_id_valeur_taxon' :
					$un_objet->setId($val, 'valeur_taxon');
					break;
				case 'etr_id_categorie_taxon' :
					$un_objet->setId($val, 'categorie_taxon');
					break;
				case 'etr_notes_relation_taxon' :
					$un_objet->setNotes($val);
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
* $Log: TaxonRelationDao.class.php,v $
* Revision 1.1  2005-10-13 16:25:05  jp_milcent
* Ajout de la classification à la synthèse.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>