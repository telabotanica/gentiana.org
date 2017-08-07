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
// CVS : $Id: NomRelationDao.class.php,v 1.4 2006-03-07 11:07:08 jp_milcent Exp $
/**
* eFlore : Classe DAO NomRelation
*
* 
*
*@package eFlore
*@subpackage Nomenclature
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.4 $ $Date: 2006-03-07 11:07:08 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// NOM_RELATION
/** Récupère les relations d'un nom'.*/
define('EF_CONSULTER_NR_ID', 19);
/** Récupère les relations d'un groupe de noms'.*/
define('EF_CONSULTER_NR_GROUPE_ID', 21);


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class NomRelationDao extends AModeleDao
{
	/*** Attributes : ***/
	
		
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->nom_type_info = 'NomRelation';
		parent::__construct();
	}
	
	/*** Accesseurs : ***/
	
	
	/*** Méthodes : ***/
	
	/**
	* @return array
	* @access public
	*/
	public function consulter( $type = NULL, $param = array() ) {
		switch($type) {
			case EF_CONSULTER_NR_ID :
				$sql = 	'SELECT DISTINCT * '.
                		'FROM eflore_nom_relation '.
						'WHERE enr_id_nom_1 = ? '.
						'AND enr_id_version_projet_nom_1 = ?';
				break;
			case EF_CONSULTER_NR_GROUPE_ID :
				$sql = 	'SELECT DISTINCT * '.
                		'FROM eflore_nom_relation '.
						'WHERE enr_id_nom_1 IN (!) '.
						'AND enr_id_version_projet_nom_1 = ?';
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
				case 'enr_id_nom_1' :
					$un_objet->setId($val, 'nom_1');
					break;
				case 'enr_id_version_projet_nom_1' :
					$un_objet->setId($val, 'version_projet_nom_1');
					break;
				case 'enr_id_nom_2' :
					$un_objet->setId($val, 'nom_2');
					break;
				case 'enr_id_version_projet_nom_2' :
					$un_objet->setId($val, 'version_projet_nom_2');
					break;
				case 'enr_id_categorie_relation' :
					$un_objet->setId($val, 'categorie_relation');
					break;
				case 'enr_id_valeur_relation' :
					$un_objet->setId($val, 'valeur_relation');
					break;
				case 'enr_notes_nom_relation' :
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
* $Log: NomRelationDao.class.php,v $
* Revision 1.4  2006-03-07 11:07:08  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnbe_v1.
*
* Revision 1.3.2.1  2006/03/07 10:50:12  jp_milcent
* Correction des requêtes SQL : ajout de l'identifiant de la version du projet.
*
* Revision 1.3  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.2  2005/09/28 16:29:31  jp_milcent
* Début et fin de gestion des onglets.
* Début gestion de la fiche Synonymie.
*
* Revision 1.1  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>