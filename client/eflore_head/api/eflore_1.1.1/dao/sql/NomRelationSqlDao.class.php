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
* Classe DAO SQL NomRelation
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
class NomRelationSqlDao extends aDaoSqlEflore implements iDaoEnr {
	/*** Attributes : ***/
	private $table_nom = 'eflore_nom_relation';
	private $table_prefixe = 'enr_';
	protected $table_cle = array();
	private $table_champs = array(
		'enr_id_nom_1'	=> array('type' => 'id', 'format' => 'int'),
		'enr_id_version_projet_nom_1'	=> array('type' => 'id', 'format' => 'int'),
		'enr_id_nom_2'	=> array('type' => 'id', 'format' => 'int'),
		'enr_id_version_projet_nom_2'	=> array('type' => 'id', 'format' => 'int'),
		'enr_id_categorie_relation'	=> array('type' => 'id', 'format' => 'int'),
		'enr_id_valeur_relation'	=> array('type' => 'id', 'format' => 'int'),
		'enr_notes_nom_relation'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet NomRelation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return NomRelation un objet NomRelation.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEnr::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_relation';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEnr::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_relation '.
						'WHERE enr_id_nom_1 = ? '.
						'AND enr_id_version_projet_nom_1 = ? '.
						'AND enr_id_nom_2 = ? '.
						'AND enr_id_version_projet_nom_2 = ? '.
						'AND enr_id_categorie_relation = ? '.
						'AND enr_id_valeur_relation = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, NomRelation::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Nom Relation.
	* 
	* @param NomRelation l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(NomRelation $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEnr::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Nom Relation.
	* 
	* @param NomRelation l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(NomRelation $obj)
	{
		return parent::supprimer($obj, iDaoEnr::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Nom Relation.
	* 
	* @param NomRelation l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(NomRelation $obj)
	{
		return parent::modifier($obj, iDaoEnr::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2006-07-25 16:14:57  jp_milcent
* Fin gestion du module Nomenclature pour l'intégration.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>