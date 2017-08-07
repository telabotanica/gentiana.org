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
* Classe DAO SQL ZgRelation
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
class ZgRelationSqlDao extends aDaoSqlEflore implements iDaoEzr {
	/*** Attributes : ***/
	private $table_nom = 'eflore_zg_relation';
	private $table_prefixe = 'ezr_';
	protected $table_cle = array();
	private $table_champs = array(
		'ezr_id_zone_geo_1'	=> array('type' => 'id', 'format' => 'int'),
		'ezr_id_projet_zg_1'	=> array('type' => 'id', 'format' => 'int'),
		'ezr_id_zone_geo_2'	=> array('type' => 'id', 'format' => 'int'),
		'ezr_id_projet_zg_2'	=> array('type' => 'id', 'format' => 'int'),
		'ezr_id_valeur'	=> array('type' => 'id', 'format' => 'int'),
		'ezr_information_relation'	=> array('type' => 'no', 'format' => 'str'),
		'ezr_notes'	=> array('type' => 'no', 'format' => 'str'),
		'ezr_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ezr_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ezr_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet ZgRelation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return ZgRelation un objet ZgRelation.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEzr::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg_relation';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEzr::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg_relation '.
						'WHERE ezr_id_zone_geo_1 = ? '.
						'AND ezr_id_projet_zg_1 = ? '.
						'AND ezr_id_zone_geo_2 = ? '.
						'AND ezr_id_projet_zg_2 = ? '.
						'AND ezr_id_valeur_relation_zg = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEzr::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ezr_id_) '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg_relation '.
						'WHERE ezr_id_ = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			//<!-- INSERTION MANUELLE : DEBUT -->//
			case iDaoEzr::CONSULTER_GROUPE_ID_CODE_SUPR :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg_relation '.
						'WHERE ezr_id_projet_zg_1 = ? '.
						'AND ezr_id_zone_geo_1 IN (!) '.
						'AND ezr_id_valeur = 55';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			//<!-- INSERTION MANUELLE : FIN -->//
			default :
				$message = 'Commande '.$cmd.' inconnue!';
				$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, ZgRelation::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Zg Relation.
	* 
	* @param ZgRelation l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(ZgRelation $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEzr::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Zg Relation.
	* 
	* @param ZgRelation l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(ZgRelation $obj)
	{
		return parent::supprimer($obj, iDaoEzr::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Zg Relation.
	* 
	* @param ZgRelation l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(ZgRelation $obj)
	{
		return parent::modifier($obj, iDaoEzr::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.4  2007-06-22 16:25:48  jp_milcent
* Modification de requêtes de consultation.
*
* Revision 1.3  2007-02-09 16:27:54  jp_milcent
* Mise à jour vers la version 1.2 des classes DAO SQL du module zg.
*
* Revision 1.2  2006/12/21 17:23:24  jp_milcent
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