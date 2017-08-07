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
* Classe DAO SQL LangueRelation
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
class LangueRelationSqlDao extends aDaoSqlEflore implements iDaoElr {
	/*** Attributes : ***/
	private $table_nom = 'eflore_langue_relation';
	private $table_prefixe = 'elr_';
	protected $table_cle = array();
	private $table_champs = array(
		'elr_id_langue_1'	=> array('type' => 'id', 'format' => 'int'),
		'elr_id_version_projet_langue_1'	=> array('type' => 'id', 'format' => 'int'),
		'elr_id_langue_2'	=> array('type' => 'id', 'format' => 'int'),
		'elr_id_version_projet_langue_2'	=> array('type' => 'id', 'format' => 'int'),
		'elr_id_categorie_relation'	=> array('type' => 'id', 'format' => 'int'),
		'elr_id_valeur_relation'	=> array('type' => 'id', 'format' => 'int'),
		'elr_information_relation_lg'	=> array('type' => 'no', 'format' => 'str'),
		'elr_notes_relation_lg'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet LangueRelation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return LangueRelation un objet LangueRelation.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoElr::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_langue_relation';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoElr::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_langue_relation '.
						'WHERE elr_id_langue_1 = ? '.
						'AND elr_id_version_projet_langue_1 = ? '.
						'AND elr_id_langue_2 = ? '.
						'AND elr_id_version_projet_langue_2 = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoElr::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(elr_id_) '.
						'FROM '.$this->getBddPrincipale().'.eflore_langue_relation '.
						'WHERE elr_id_ = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, LangueRelation::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Langue Relation.
	* 
	* @param LangueRelation l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(LangueRelation $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoElr::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Langue Relation.
	* 
	* @param LangueRelation l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(LangueRelation $obj)
	{
		return parent::supprimer($obj, iDaoElr::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Langue Relation.
	* 
	* @param LangueRelation l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(LangueRelation $obj)
	{
		return parent::modifier($obj, iDaoElr::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2006-12-21 16:05:11  jp_milcent
* Ajout du type de résultat pour la consultation par ID.
* Complétion des requêtes mal générées.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>