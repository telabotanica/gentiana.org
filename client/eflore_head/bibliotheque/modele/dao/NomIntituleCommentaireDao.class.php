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
// CVS : $Id$
/**
* eFlore : Classe DAO NomIntituleCommentaire
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
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class NomIntituleCommentaireDao extends AModeleDao
{
	/*** Attributes : ***/
	
		
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->nom_type_info = 'NomIntituleCommentaire';
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
			case EF_CONSULTER_NIC_ID :
				$sql = 	'SELECT DISTINCT * '.
                		'FROM eflore_nom_intitule_commentaire '.
						'WHERE enic_id_intitule_cn = ?';
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
				case 'enic_id_intitule_cn' :
					$un_objet->setId($val, 'intitule_cn');
					break;
				case 'enic_intitule_cn_origine' :
					$un_objet->setIntituleCnOrigine($val);
					break;
				case 'enic_intitule_cn_complet' :
					$un_objet->setIntituleCnComplet($val);
					break;
				case 'enic_intitule_cn_mauvais' :
					$un_objet->setIntituleCnMauvais($val);
					break;
				case 'enic_notes_intitule_cn' :
					$un_objet->setNotes($val);
					break;
				case 'enic_date_derniere_modif' :
					$un_nom->setDateDerniereModif($val); 
					break;
				case 'enic_ce_modifier_par' :
					$un_nom->setCe($val, 'modifier_par'); 
					break;
				case 'enic_ce_etat' :
					$un_nom->setCe($val, 'etat'); 
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
* $Log$
* Revision 1.1  2005-10-06 20:23:30  jp_milcent
* Ajout de classes métier pour le module Nomenclature.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>