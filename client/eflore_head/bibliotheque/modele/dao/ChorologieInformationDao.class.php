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
// CVS : $Id: ChorologieInformationDao.class.php,v 1.2 2005-10-13 08:27:09 jp_milcent Exp $
/**
* eFlore : Classe DAO ChorologieInformation
*
* 
*
*@package eFlore
*@subpackage Chorologie
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.2 $ $Date: 2005-10-13 08:27:09 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// CHOROLOGIE_INFORMATION
/**Récupère les infos choro en fonction d'un id et d'une version.*/
define('EF_CONSULTER_CI_VERSION_ID', 'ECI1');
/**Récupère les infos choro en fonction d'un id et une version de donnée.*/
define('EF_CONSULTER_CI_DONNEE_VERSION_ID', 'ECI2');
/**Récupère les infos choro en fonction d'une version et pour un groupe d'id donnée.*/
define('EF_CONSULTER_CI_GROUPE_DONNEE_VERSION_ID', 'ECI3');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ChorologieInformationDao extends AModeleDao
{
	/*** Attributes : ***/
	
		
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->setNomTypeInfo('ChorologieInformation');
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
			case EF_CONSULTER_CI_VERSION_ID :
				$sql =	'SELECT DISTINCT * 
		               FROM eflore_chorologie_information
		               WHERE eci_id_version_projet_info_choro = ? 
		               AND eci_id_info_choro = ?';
				break;
			case EF_CONSULTER_CI_DONNEE_VERSION_ID :
				$sql =	'SELECT DISTINCT * 
		               FROM eflore_chorologie_information
		               WHERE eci_ce_version_projet_donnee_choro = ? 
		               AND eci_ce_donnee_choro = ?';
				break;
			case EF_CONSULTER_CI_GROUPE_DONNEE_VERSION_ID :
				$sql =	'SELECT DISTINCT * 
		               FROM eflore_chorologie_information
		               WHERE eci_ce_version_projet_donnee_choro = ? 
		               AND eci_ce_donnee_choro IN (!)';
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
				case 'eci_id_info_choro' :
					$un_objet->setId($val, 'info_choro');
					break;
				case 'eci_id_version_projet_info_choro' :
					$un_objet->setId($val, 'version_projet_info_choro');
					break;
				case 'eci_ce_donnee_choro' :
					$un_objet->setCe($val, 'donnee_choro');
					break;
				case 'eci_ce_version_projet_donnee_choro' :
					$un_objet->setCe($val, 'version_projet_donnee_choro');
					break;
				case 'eci_ce_notion_choro' :
					$un_objet->setCe($val, 'notion_choro');
					break;
				case 'eci_ce_version_projet_notion_choro' :
					$un_objet->setCe($val, 'version_projet_notion_choro');
					break;
				case 'eci_ordre_notion' :
					$un_objet->setOrdre($val);
					break;
				case 'eci_notes_info_choro' :
					$un_objet->setNotes($val);
					break;
				case 'eci_date_derniere_modif' :
					$un_objet->setDateDerniereModif($val);
					break;
				case 'eci_ce_modifier_par' :
					$un_objet->setCe($val, 'modifier_par');
					break;
				case 'eci_ce_etat' :
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
* $Log: ChorologieInformationDao.class.php,v $
* Revision 1.2  2005-10-13 08:27:09  jp_milcent
* Ajout d'une mini chorologie sur la page de synthèse.
* Déplacement des constantes de requete sql dans les fichiers de chaque classe DAO.
*
* Revision 1.1  2005/10/11 17:30:31  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>