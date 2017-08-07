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
// CVS : $Id: LangueValeurDao.class.php,v 1.2 2005-11-23 11:14:34 jp_milcent Exp $
/**
* eFlore : Classe LangueValeurDao
*
* 
*
*@package project_name
*@subpackage 
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.2 $ $Date: 2005-11-23 11:14:34 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// LANGUE
/** Récupère les infos d'une valeur de langue pour un id de catégorie et de valeur.*/
define('EF_CONSULTER_LV_CATEGORIE_VALEUR_ID', 'EFLV1');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class LangueValeurDao extends AModeleDao
{
	/*** Attributes : ***/
	
		
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->setNomTypeInfo('LangueValeur');
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
			case EF_CONSULTER_LV_CATEGORIE_VALEUR_ID :
				$sql =	'SELECT DISTINCT * 
		               FROM eflore_langue_valeur
		               WHERE elv_id_categorie_lg = ? 
		               AND elv_id_valeur_lg = ?';
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
				case 'elv_id_valeur_lg' :
					$un_objet->setId($val, 'valeur');
					break;
				case 'elv_id_categorie_lg' :
					$un_objet->setId($val, 'categorie');
					break;
				case 'elv_intitule_valeur_lg' :
					$un_objet->setIntitule($val);
					break;
				case 'elv_abreviation_valeur_lg' :
					$un_objet->setAbreviation($val);
					break;
				case 'elv_description_valeur_lg' :
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
* $Log: LangueValeurDao.class.php,v $
* Revision 1.2  2005-11-23 11:14:34  jp_milcent
* Ajout de la constante pour un type de consultation dans le fichier de la classe DAO.
*
* Revision 1.1  2005/09/26 15:48:15  jp_milcent
* Fin de l'onglet synthèse pour la fiche d'un taxon.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>