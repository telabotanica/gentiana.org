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
* Classe DAO SQL InfoTxtRelation
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
class InfoTxtRelationSqlDao extends aDaoSqlEflore implements iDaoEitr {
	/*** Attributes : ***/
	private $table_nom = 'eflore_info_txt_relation';
	private $table_prefixe = 'eitr_';
	protected $table_cle = array();
	private $table_champs = array(
		'eitr_id_texte_01'	=> array('type' => 'id', 'format' => 'int'),
		'eitr_id_version_projet_txt_01'	=> array('type' => 'id', 'format' => 'int'),
		'eit_id_texte_02'	=> array('type' => 'no', 'format' => 'int'),
		'eit_id_version_projet_txt_02'	=> array('type' => 'no', 'format' => 'int'),
		'eitr_id_categorie_txt'	=> array('type' => 'id', 'format' => 'int'),
		'eitr_id_valeur_categorie_txt'	=> array('type' => 'id', 'format' => 'int'),
		'eitr_notes_relation_txt'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet InfoTxtRelation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return InfoTxtRelation un objet InfoTxtRelation.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEitr::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_info_txt_relation';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEitr::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_info_txt_relation '.
						'WHERE ';
				break;
			case iDaoEitr::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(eitr_id_) '.
						'FROM '.$this->getBddPrincipale().'.eflore_info_txt_relation '.
						'WHERE eitr_id_ = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, InfoTxtRelation::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Info Txt Relation.
	* 
	* @param InfoTxtRelation l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(InfoTxtRelation $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEitr::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Info Txt Relation.
	* 
	* @param InfoTxtRelation l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(InfoTxtRelation $obj)
	{
		return parent::supprimer($obj, iDaoEitr::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Info Txt Relation.
	* 
	* @param InfoTxtRelation l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(InfoTxtRelation $obj)
	{
		return parent::modifier($obj, iDaoEitr::CONSULTER_ID);
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