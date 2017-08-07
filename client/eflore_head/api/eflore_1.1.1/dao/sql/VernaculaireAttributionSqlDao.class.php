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
* Classe DAO SQL VernaculaireAttribution
*
* Description
*
*@package eFlore
*@subpackage dao_sql
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

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class VernaculaireAttributionSqlDao extends aDaoSqlEflore implements iDaoEva {
	/*** Attributes : ***/
	private $table_nom = 'eflore_vernaculaire_attribution';
	private $table_prefixe = 'eva_';
	protected $table_cle = array('nom_vernaculaire', 'version_projet_nom_verna', 'taxon_ref', 'version_projet_taxon_ref');
	private $table_champs = array(
		'eva_id_nom_vernaculaire'	=> array('type' => 'id', 'format' => 'int'),
		'eva_id_version_projet_nom_verna'	=> array('type' => 'id', 'format' => 'int'),
		'eva_id_taxon_ref'	=> array('type' => 'id', 'format' => 'int'),
		'eva_id_version_projet_taxon_ref'	=> array('type' => 'id', 'format' => 'int'),
		'eva_ce_emploi'	=> array('type' => 'ce', 'format' => 'int'),
		'eva_ce_contributeur'	=> array('type' => 'ce', 'format' => 'int'),
		'eva_ce_zone_geo'	=> array('type' => 'ce', 'format' => 'int'),
		'eva_ce_version_projet_zg'	=> array('type' => 'ce', 'format' => 'int'),
		'eva_commentaires_geographiques'	=> array('type' => 'no', 'format' => 'str'),
		'eva_ce_citation_biblio'	=> array('type' => 'ce', 'format' => 'int'),
		'eva_mark_info_biblio'	=> array('type' => 'no', 'format' => 'str'),
		'eva_notes_emploi_nom_vernaculaire'	=> array('type' => 'no', 'format' => 'str'),
		'eva_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'eva_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'eva_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet VernaculaireAttribution.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return VernaculaireAttribution un objet VernaculaireAttribution.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEva::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_vernaculaire_attribution';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEva::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_vernaculaire_attribution '.
						'WHERE eva_id_nom_vernaculaire = ? AND eva_id_version_projet_nom_verna = ? AND eva_id_taxon_ref = ? AND eva_id_version_projet_taxon_ref = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEva::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(eva_id_nom_vernaculaire) '.
						'FROM '.$this->getBddPrincipale().'.eflore_vernaculaire_attribution '.
						'WHERE eva_id_version_projet_nom_verna = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			//<!-- INSERTION MANUELLE : DEBUT -->//
			case iDaoEva::CONSULTER_EMPLOI_PROJET_TAXON_GROUPE_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_vernaculaire_attribution '.
						'WHERE eva_id_taxon_ref IN (!) '.
						'AND eva_id_version_projet_taxon_ref = ? '.
						'AND eva_ce_emploi = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			//<!-- INSERTION MANUELLE : FIN -->//
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, VernaculaireAttribution::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Vernaculaire Attribution.
	* 
	* @param VernaculaireAttribution l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(VernaculaireAttribution $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEva::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Vernaculaire Attribution.
	* 
	* @param VernaculaireAttribution l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(VernaculaireAttribution $obj)
	{
		return parent::supprimer($obj, iDaoEva::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Vernaculaire Attribution.
	* 
	* @param VernaculaireAttribution l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(VernaculaireAttribution $obj)
	{
		return parent::modifier($obj, iDaoEva::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.3  2007-06-21 17:43:36  jp_milcent
* Ajout de requetes utilisées entre autre par le module Chorologie.
*
* Revision 1.2  2006-12-21 15:59:33  jp_milcent
* Ajout du type de résultat pour la consultation par ID.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>