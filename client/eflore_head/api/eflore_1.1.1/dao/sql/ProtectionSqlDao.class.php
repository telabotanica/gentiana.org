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
// CVS : $Id: ProtectionSqlDao.class.php,v 1.2 2007-01-03 17:06:09 jp_milcent Exp $
/**
* Classe DAO SQL Protection
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
*@version       $Revision: 1.2 $ $Date: 2007-01-03 17:06:09 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class ProtectionSqlDao extends aDaoSqlEflore implements iDaoEpt {
	/*** Attributes : ***/
	private $table_nom = 'eflore_protection';
	private $table_prefixe = 'ept_';
	protected $table_cle = array('protection', 'version_projet_protection');
	private $table_champs = array(
		'ept_id_protection'	=> array('type' => 'id', 'format' => 'int'),
		'ept_id_version_projet_protection'	=> array('type' => 'id', 'format' => 'int'),
		'ept_ce_statut'	=> array('type' => 'ce', 'format' => 'int'),
		'ept_ce_texte_application'	=> array('type' => 'ce', 'format' => 'int'),
		'ept_ce_zone_geo'	=> array('type' => 'ce', 'format' => 'int'),
		'ept_ce_version_projet_zg'	=> array('type' => 'ce', 'format' => 'int'),
		'ept_nom_scientifique'	=> array('type' => 'no', 'format' => 'str'),
		'ept_nom_vernaculaire'	=> array('type' => 'no', 'format' => 'str'),
		'ept_notes'	=> array('type' => 'no', 'format' => 'str'),
		'ept_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ept_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ept_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet Protection.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return Protection un objet Protection.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEpt::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_protection';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEpt::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_protection '.
						'WHERE ept_id_protection = ? AND ept_id_version_projet_protection = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEpt::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ept_id_protection) '.
						'FROM '.$this->getBddPrincipale().'.eflore_protection ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			case iDaoEpt::CONSULTER_ID_PROJET_GROUPE_ID :
				$sql = 	'SELECT eflore_protection.* '.
						'FROM '.$this->getBddPrincipale().'.eflore_protection '.
						'WHERE ept_id_version_projet_protection = ? '.
						'AND ept_id_protection IN (!)';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			default :
				$message = 'Commande '.$cmd.' inconnue!';
				$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, Protection::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Protection.
	* 
	* @param Protection l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(Protection $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEpt::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Protection.
	* 
	* @param Protection l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(Protection $obj)
	{
		return parent::supprimer($obj, iDaoEpt::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Protection.
	* 
	* @param Protection l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(Protection $obj)
	{
		return parent::modifier($obj, iDaoEpt::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ProtectionSqlDao.class.php,v $
* Revision 1.2  2007-01-03 17:06:09  jp_milcent
* Ajout de requêtes de consultation utilisées par l'interface web eFlore.
*
* Revision 1.1  2006/12/28 20:57:16  jp_milcent
* Ajout du module Protection.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>