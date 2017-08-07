<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id$
/**
* eFlore : Classe NomATxtDao
*
* 
*
*@package eFlore
*@subpackage Information
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
/** Récupère les textes disponibles pour un id et une version données de nom.*/
define('EF_CONSULTER_NOM_A_TXT_VERSION_ID', 'EFNAT1');


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class NomATxtDao extends AModeleDao {

	/*** Attributes : ***/


	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->nom_type_info = 'NomATxt';
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
			case EF_CONSULTER_NOM_A_TXT_VERSION_ID :
				$sql = 	'SELECT * '.
                		'FROM eflore_nom_a_txt '.
						'WHERE enat_id_nom = ? '.
						'AND enat_id_version_projet_nom = ? ';
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
		$un_objet = $this->nom_type_info;
		$un_nom = new $un_objet();
		foreach ($donnees as $cle => $val) {
			switch ($cle) {
				case 'enat_id_taxon' :
					$un_nom->setId($val, 'nom');
					break;
				case 'enat_id_version_projet_nom' :
					$un_nom->setId($val, 'version_projet_nom');
					break;
				case 'enat_id_texte' :
					$un_nom->setId($val, 'texte');
					break;
				case 'enat_id_version_projet_txt' :
					$un_nom->setId($val, 'version_projet_txt');
					break;
				case 'enat_notes' :
					$un_nom->setNotes($val);
					break;
				default:
					$un_nom->$cle = $val;
			}
			unset($donnees[$cle]);
		}
		return $un_nom;
	}
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.1  2006-04-25 16:22:25  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des données txt liées au nom sélectionné.
*
* 
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/ 
?>