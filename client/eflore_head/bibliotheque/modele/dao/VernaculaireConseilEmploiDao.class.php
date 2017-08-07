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
// CVS : $Id: VernaculaireConseilEmploiDao.class.php,v 1.1 2005-09-30 16:22:01 jp_milcent Exp $
/**
* eFlore : Classe DAO Vernaculaire
*
* 
*
*@package eFlore
*@subpackage Vernaculaire
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2005-09-30 16:22:01 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VernaculaireConseilEmploiDao extends AModeleDao
{
	/*** Attributs : ***/
	
		
	/*** Constructeurs : ***/
	public function __construct(  )
	{
		$this->setNomTypeInfo('VernaculaireConseilEmploi');
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
			case EF_CONSULTER_VCE_ID :
				$sql =	'SELECT DISTINCT * 
		               FROM eflore_vernaculaire_conseil_emploi 
		               WHERE  evce_id_emploi = ? ';
				break;
		}
		$this->setRequete($sql);
		return parent::consulter($param);
	}
	
	/**
	* Ajoute les champs aux bons attributs. 
	* @return object l'objet dont on manipule les infos.
	* @access public
	*/
	public function attribuerChamps( $donnees )
	{
		$obj_nom = $this->getNomTypeInfo();
		$un_objet = new $obj_nom;
		foreach ($donnees as $cle => $val) {
			switch ($cle) {
				case 'evce_id_emploi' :
					$un_objet->setId($val, 'emploi');
					break;
				case 'evce_intitule_conseil_emlploi' :
					$un_objet->setIntitule($val);
					break;
				case 'evce_abreviation_conseil_emploi' :
					$un_objet->setAbreviation($val);
					break;
				case 'evce_description_conseil_emploi' :
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
* $Log: VernaculaireConseilEmploiDao.class.php,v $
* Revision 1.1  2005-09-30 16:22:01  jp_milcent
* Fin de la gestion de l'onglet Noms Vernaculaires.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>