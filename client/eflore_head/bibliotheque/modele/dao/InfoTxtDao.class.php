<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
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
// CVS : $Id$
/**
* eFlore : Classe InformationTxt
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
/** Récupère un texte pour un id et une version donnés.*/
define('EF_CONSULTER_INFO_TXT_VERSION_ID', 'EFIT1');


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class InfoTxtDao extends AModeleDao {

	/*** Attributes : ***/


	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->nom_type_info = 'InfoTxt';
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
			case EF_CONSULTER_INFO_TXT_VERSION_ID :
				$sql = 	'SELECT * '.
                		'FROM eflore_info_txt '.
						'WHERE eit_id_texte = ? '.
						'AND eit_id_version_projet_txt = ? ';
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
				case 'eit_id_texte' :
					$un_nom->setId($val, 'texte');
					break;
				case 'eit_id_version_projet_txt' :
					$un_nom->setId($val, 'version_projet_txt');
					break;
				case 'eit_titre' :
					$un_nom->setTitre($val);
					break;
				case 'eit_resumer' :
					$un_nom->setResumer($val);
					break;
				case 'eit_lien_vers_txt' :
					$un_nom->setLienVersTxt($val);
					break;
				case 'eit_nom_fichier' :
					$un_nom->setNomFichier($val);
					break;
				case 'eit_contenu_texte' :
					$un_nom->setContenuTexte($val);
					break;
				case 'eit_ce_contributeur_txt' :
					$un_nom->setCe($val, 'contributeur_txt');
					break;
				case 'eit_ce_auteur' :
					$un_nom->setCe($val, 'auteur');
					break;
				case 'eit_autre_auteur' :
					$un_nom->setAutreAuteur($val);
					break;
				case 'en_nom_genre' :
					$un_nom->setNomGenre($val);
					break;
				case 'eit_ce_licence' :
					$un_nom->setCe($val, 'licence');
					break;
				case 'eit_ce_version_projet_licence' :
					$un_nom->setCe($val, 'version_projet_licence');
					break;
				case 'eit_autre_lien_licence' :
					$un_nom->setAutreLienLicence($val);
					break;
				case 'eit_notes_texte' :
					$un_nom->setNotes($val);
					break;
				case 'eit_date_derniere_modif' :
					$un_nom->setDateDerniereModif($val);
					break;
				case 'eit_ce_modifier_par' :
					$un_nom->setCe($val, 'modifier_par');
					break;
				case 'eit_ce_etat' :
					$un_nom->setCe($val, 'etat');
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