<?php
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.2                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2007 Tela Botanica (accueil@tela-botanica.org)                                          |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                         |
// |                                                                                                      |
// | eFlore is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eFlore is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: NaturalisteNomRelationSqlDao.class.php,v 1.1 2007-02-11 19:47:52 jp_milcent Exp $
/**
* Classe DAO SQL : NaturalisteNomRelation
*
* Description
*
*@package eFlore
*@subpackage dao_sql
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2007
*@version       $Revision: 1.1 $ $Date: 2007-02-11 19:47:52 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class NaturalisteNomRelationSqlDao extends aDaoSql implements iDaoEnanr {

	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'NaturalisteNomRelationSqlDao';
	
	/*** Attributes : ***/
	
	protected $table_nom = 'eflore_naturaliste_nom_relation';
	protected $table_prefixe = 'enanr_';
	protected $table_cle = array();
	protected $table_champs = array(
		'enanr_id_nom_1'	=> array('type' => 'id', 'format' => 'int'),
		'enanr_id_projet_nom_1'	=> array('type' => 'id', 'format' => 'int'),
		'enanr_id_nom_2'	=> array('type' => 'id', 'format' => 'int'),
		'enanr_id_projet_nom_2'	=> array('type' => 'id', 'format' => 'int'),
		'enanr_id_valeur'	=> array('type' => 'id', 'format' => 'int'),
		'enanr_notes'	=> array('type' => 'no', 'format' => 'str'),
		'enanr_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'enanr_ce_etat'	=> array('type' => 'ce', 'format' => 'int'),
		'enanr_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null, $options = array())
	{
		// Le nom de la classe pour aDaoSql
		$this->setClasseFilleNom(self::CLASSE_NOM);
		return parent::__construct($connexion, $options);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet NaturalisteNomRelation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return NaturalisteNomRelation un objet NaturalisteNomRelation.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEnanr::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_nom_relation';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEnanr::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_nom_relation '.
						'WHERE ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEnanr::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(enanr_id_) '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_nom_relation '.

						'WHERE enanr_id_ = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.' inconnue!';
				$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres);
	}
	
	/**
	* Ajoute une ligne :  Naturaliste Nom Relation.
	* 
	* @param NaturalisteNomRelation l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(NaturalisteNomRelation $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEnanr::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Naturaliste Nom Relation.
	* 
	* @param NaturalisteNomRelation l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(NaturalisteNomRelation $obj)
	{
		return parent::supprimer($obj, iDaoEnanr::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Naturaliste Nom Relation.
	* 
	* @param NaturalisteNomRelation l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(NaturalisteNomRelation $obj)
	{
		return parent::modifier($obj, iDaoEnanr::CONSULTER_ID);
	}

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: NaturalisteNomRelationSqlDao.class.php,v $
* Revision 1.1  2007-02-11 19:47:52  jp_milcent
* Début gestion de l'api de la version 1.2 d'eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>