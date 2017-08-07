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
// CVS : $Id: VernaculaireAttributionDao.class.php,v 1.4 2005-09-30 16:22:01 jp_milcent Exp $
/**
* eFlore : Classe DAO VernaculaireAttribution
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
*@version       $Revision: 1.4 $ $Date: 2005-09-30 16:22:01 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VernaculaireAttributionDao extends AModeleDao
{
	/*** Attributs : ***/
	
		
	/*** Constructeurs : ***/
	public function __construct(  )
	{
		$this->setNomTypeInfo('VernaculaireAttribution');
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
			case EF_CONSULTER_VA_VERSION_TAXON_ID :
				$sql =	'SELECT DISTINCT * 
		               FROM eflore_vernaculaire_attribution 
		               WHERE eva_id_taxon_ref = ? 
		               AND eva_id_version_projet_taxon_ref = ? ';
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
				case 'eva_id_nom_vernaculaire' :
					$un_objet->setId($val, 'nom_vernaculaire');
					break;
				case 'eva_id_version_projet_nom_verna' :
					$un_objet->setId($val, 'version_projet_nom_verna');
					break;
				case 'eva_id_taxon_ref' :
					$un_objet->setId($val, 'taxon_ref');
					break;
				case 'eva_id_version_projet_taxon_ref' :
					$un_objet->setId($val, 'version_projet_taxon_ref');
					break;
				case 'eva_ce_emploi' :
					$un_objet->setCe($val, 'emploi');
					break;
				case 'eva_ce_contributeur' :
					$un_objet->setCe($val, 'contributeur');
					break;
				case 'eva_ce_zone_geo' :
					$un_objet->setCe($val, 'zone_geo');
					break;
				case 'eva_ce_version_projet_zg' :
					$un_objet->setCe($val, 'version_projet_zg');
					break;
				case 'eva_commentaires_geographiques' :
					$un_objet->setCommentairesGeographiques($val);
					break;
				case 'eva_ce_citation_biblio' :
					$un_objet->setCe($val, 'citation_biblio');
					break;
				case 'eva_mark_info_biblio' :
					$un_objet->setMarkInfoBiblio($val);
					break;
				case 'eva_notes_emploi_nom_vernaculaire' :
					$un_objet->setNotes($val);
					break;
				case 'eva_date_derniere_modif' :
					$un_objet->setDateDerniereModif($val);
					break;
				case 'eva_date_derniere_modif' :
					$un_objet->setDateDerniereModif($val);
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
* $Log: VernaculaireAttributionDao.class.php,v $
* Revision 1.4  2005-09-30 16:22:01  jp_milcent
* Fin de la gestion de l'onglet Noms Vernaculaires.
*
* Revision 1.3  2005/09/27 16:03:46  jp_milcent
* Fin de l'amélioration de la gestion des noms vernaculaires dans l'onglet Synthèse.
*
* Revision 1.2  2005/09/26 15:48:15  jp_milcent
* Fin de l'onglet synthèse pour la fiche d'un taxon.
*
* Revision 1.1  2005/09/16 16:41:45  jp_milcent
* Gestion de l'onglet Synthèse en cours.
* Création du modèle pour l'attribution des noms vernaculaires aux taxons.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>