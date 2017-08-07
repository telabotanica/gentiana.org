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
* Classe DAO SQL SelectionNom
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
class SelectionNomSqlDao extends aDaoSqlEflore implements iDaoEsn {
	/*** Attributes : ***/
	private $table_nom = 'eflore_selection_nom';
	protected $classe_nom = SelectionNom::CLASSE_NOM;
	private $table_prefixe = 'esn_';
	protected $table_cle = array('nom', 'version_projet_nom', 'taxon', 'version_projet_taxon');
	private $table_champs = array(
		'esn_id_nom'	=> array('type' => 'id', 'format' => 'int'),
		'esn_id_version_projet_nom'	=> array('type' => 'id', 'format' => 'int'),
		'esn_id_taxon'	=> array('type' => 'id', 'format' => 'int'),
		'esn_id_version_projet_taxon'	=> array('type' => 'id', 'format' => 'int'),
		'esn_ce_statut'	=> array('type' => 'ce', 'format' => 'int'),
		'esn_code_numerique_1'	=> array('type' => 'no', 'format' => 'int'),
		'esn_code_numerique_2'	=> array('type' => 'no', 'format' => 'str'),
		'esn_code_alphanumerique_1'	=> array('type' => 'no', 'format' => 'str'),
		'esn_code_alphanumerique_2'	=> array('type' => 'no', 'format' => 'str'),
		'esn_commentaire_nomenclatural'	=> array('type' => 'no', 'format' => 'str'),
		'esn_notes_nom_selection'	=> array('type' => 'no', 'format' => 'str'),
		'esn_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'esn_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'esn_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	protected $table_relations = array(
		'eflore_chorologie_donnee' => array('esn_id_taxon', 'esn_id_version_projet_taxon'),
		'eflore_nom' => array('esn_id_nom', 'esn_id_version_projet_nom')
		);
		
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet SelectionNom.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return SelectionNom un objet SelectionNom.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEsn::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_selection_nom';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEsn::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_selection_nom '.
						'WHERE esn_id_nom = ? '.
						'AND esn_id_version_projet_nom = ? '.
						'AND esn_id_taxon = ? '.
						'AND esn_id_version_projet_taxon = ? ';
						$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEsn::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(esn_id_nom) '.
						'FROM '.$this->getBddPrincipale().'.eflore_selection_nom '.
						'WHERE esn_id_version_projet_nom = ? ';
						$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			//<!-- INSERTION MANUELLE : DEBUT -->//
			case iDaoEsn::CONSULTER_VERSION_TAXON_ID_RETENU :
				$sql =	'SELECT DISTINCT * '.
		               	'FROM '.$this->getBddPrincipale().'.eflore_selection_nom '.
		               	'WHERE esn_id_taxon = ? '. 
		               	'AND esn_id_version_projet_taxon = ? '.
		               	'AND esn_ce_statut = 3 ';
		               	$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEsn::CONSULTER_STATUT_VERSION_TAXON_GROUPE_ID :
				$sql =	'SELECT DISTINCT * '.
		               	'FROM '.$this->getBddPrincipale().'.eflore_selection_nom '.
		               	'WHERE esn_id_taxon IN (!) '. 
		               	'AND esn_id_version_projet_taxon = ? '.
		               	'AND esn_ce_statut = ? ';
		               	$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEsn::CONSULTER_NOM_GROUPE_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_selection_nom '.
						'WHERE en_id_nom IN (!) '.
						'AND en_id_version_projet_nom = ? ';
						$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			//<!-- INSERTION MANUELLE : FIN -->//
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, SelectionNom::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Selection Nom.
	* 
	* @param SelectionNom l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(SelectionNom $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEsn::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Selection Nom.
	* 
	* @param SelectionNom l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(SelectionNom $obj)
	{
		return parent::supprimer($obj, iDaoEsn::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Selection Nom.
	* 
	* @param SelectionNom l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(SelectionNom $obj)
	{
		return parent::modifier($obj, iDaoEsn::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.4  2007-06-27 17:08:12  jp_milcent
* Mise en place de la gestion des relations entre table.
*
* Revision 1.3  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.2  2006-12-06 17:41:25  jp_milcent
* Correction de bogues.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>