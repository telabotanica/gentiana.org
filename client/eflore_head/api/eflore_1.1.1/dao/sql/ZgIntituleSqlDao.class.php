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
* Classe DAO SQL ZgIntitule
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
class ZgIntituleSqlDao extends aDaoSqlEflore implements iDaoEzi {
	/*** Attributes : ***/
	private $table_nom = 'eflore_zg_intitule';
	private $table_prefixe = 'ezi_';
	protected $table_cle = array();
	private $table_champs = array(
		'ezi_id_intitule_zg'	=> array('type' => 'id', 'format' => 'int'),
		'ezi_id_zone_geo'	=> array('type' => 'id', 'format' => 'int'),
		'ezi_id_projet_zg'	=> array('type' => 'id', 'format' => 'int'),
		'ezi_ce_format'	=> array('type' => 'ce', 'format' => 'int'),
		'ezi_ce_langue'	=> array('type' => 'ce', 'format' => 'int'),
		'ezi_ce_projet_langue'	=> array('type' => 'ce', 'format' => 'int'),
		'ezi_ce_article'	=> array('type' => 'ce', 'format' => 'int'),
		'ezi_intitule_zone_geo'	=> array('type' => 'no', 'format' => 'str'),
		'ezi_notes'	=> array('type' => 'no', 'format' => 'str'),
		'ezi_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ezi_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ezi_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet ZgIntitule.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return ZgIntitule un objet ZgIntitule.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEzi::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg_intitule';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEzi::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg_intitule '.
						'WHERE ezi_id_intitule_zg = ? '.
						'AND ezi_id_zone_geo = ? '.
						'AND ezi_id_projet_zg = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEzi::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ezi_id_) '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg_intitule '.
						'WHERE ezi_id_ = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.' inconnue!';
				$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, ZgIntitule::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Zg Intitule.
	* 
	* @param ZgIntitule l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(ZgIntitule $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEzi::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Zg Intitule.
	* 
	* @param ZgIntitule l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(ZgIntitule $obj)
	{
		return parent::supprimer($obj, iDaoEzi::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Zg Intitule.
	* 
	* @param ZgIntitule l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(ZgIntitule $obj)
	{
		return parent::modifier($obj, iDaoEzi::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
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