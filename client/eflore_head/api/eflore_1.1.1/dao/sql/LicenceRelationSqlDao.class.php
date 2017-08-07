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
* Classe DAO SQL LicenceRelation
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
class LicenceRelationSqlDao extends aDaoSqlEflore implements iDaoElcr {
	/*** Attributes : ***/
	private $table_nom = 'eflore_licence_relation';
	private $table_prefixe = 'elcr_';
	protected $table_cle = array();
	private $table_champs = array(
		'elcr_id_licence_1'	=> array('type' => 'id', 'format' => 'int'),
		'elcr_id_version_projet_licence_1'	=> array('type' => 'id', 'format' => 'int'),
		'elcr_id_licence_2'	=> array('type' => 'id', 'format' => 'int'),
		'elcr_id_version_projet_licence_2'	=> array('type' => 'id', 'format' => 'int'),
		'elcr_id_categorie_relation'	=> array('type' => 'id', 'format' => 'int'),
		'elcr_id_valeur_relation'	=> array('type' => 'id', 'format' => 'int'),
		'elcr_notes_relation_licence'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet LicenceRelation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return LicenceRelation un objet LicenceRelation.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoElcr::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_licence_relation';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoElcr::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_licence_relation '.
						'WHERE ';
				break;
			case iDaoElcr::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(elcr_id_) '.
						'FROM '.$this->getBddPrincipale().'.eflore_licence_relation '.
						'WHERE elcr_id_ = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, LicenceRelation::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Licence Relation.
	* 
	* @param LicenceRelation l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(LicenceRelation $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoElcr::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Licence Relation.
	* 
	* @param LicenceRelation l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(LicenceRelation $obj)
	{
		return parent::supprimer($obj, iDaoElcr::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Licence Relation.
	* 
	* @param LicenceRelation l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(LicenceRelation $obj)
	{
		return parent::modifier($obj, iDaoElcr::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.1  2006-07-20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>