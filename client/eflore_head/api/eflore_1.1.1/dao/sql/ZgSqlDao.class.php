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
* Classe DAO SQL Zg
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
class ZgSqlDao extends aDaoSqlEflore implements iDaoEzg {
	/*** Attributes : ***/
	private $table_nom = 'eflore_zg';
	private $table_prefixe = 'ezg_';
	protected $table_cle = array('zone_geo', 'projet_zg');
	private $table_champs = array(
		'ezg_id_zone_geo'	=> array('type' => 'id', 'format' => 'int'),
		'ezg_id_projet_zg'	=> array('type' => 'id', 'format' => 'int'),
		'ezg_intitule_principal'	=> array('type' => 'no', 'format' => 'str'),
		'ezg_code'	=> array('type' => 'no', 'format' => 'str'),
		'ezg_superficie'	=> array('type' => 'no', 'format' => 'str'),
		'ezg_nombre_habitant'	=> array('type' => 'no', 'format' => 'int'),
		'ezg_date_recensement'	=> array('type' => 'no', 'format' => 'str'),
		'ezg_altitude_moyenne'	=> array('type' => 'no', 'format' => 'int'),
		'ezg_altitude_max'	=> array('type' => 'no', 'format' => 'int'),
		'ezg_altitude_min'	=> array('type' => 'no', 'format' => 'int'),
		'ezg_longitude'	=> array('type' => 'no', 'format' => 'str'),
		'ezg_latitude'	=> array('type' => 'no', 'format' => 'str'),
		'ezg_couleur_rvb'	=> array('type' => 'no', 'format' => 'str'),
		'ezg_notes'	=> array('type' => 'no', 'format' => 'str'),
		'ezg_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ezg_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ezg_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet Zg.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return Zg un objet Zg.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEzg::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEzg::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg '.
						'WHERE ezg_id_zone_geo = ? AND ezg_id_projet_zg = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEzg::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ezg_id_zone_geo) '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg '.
						'WHERE ezg_id_projet_zg = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			//<!-- INSERTION MANUELLE : DEBUT -->//
			case iDaoEzg::CONSULTER_ID_PROJET :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg '.
						'WHERE ezg_id_projet_zg = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEzg::CONSULTER_ID_PROJET_GROUPE_ID :
				$sql = 	'SELECT DISTINCT * '.		
						'FROM '.$this->getBddPrincipale().'.eflore_zg '.
						'WHERE ezg_id_projet_zg = ? '.
						'AND ezg_id_zone_geo IN ( ! ) '.
						'ORDER BY ezg_intitule_principal ASC';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEzg::CONSULTER_PROJET_ID_CODE :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg '.
						'WHERE ezg_id_projet_zg = ? '.
						'AND ezg_code = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEzg::CONSULTER_PROJET_ID_CODE_LIKE :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg '.
						'WHERE ezg_id_projet_zg = ? '.
						'AND ezg_code LIKE ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEzg::CONSULTER_GROUPE_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg '.
						'WHERE ezg_id_projet_zg = ? '.
						'AND ezg_id_zone_geo IN (!) ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			//<!-- INSERTION MANUELLE : FIN -->//
			default :
				$message = 'Commande '.$cmd.' inconnue!';
				$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, Zg::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Zg.
	* 
	* @param Zg l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(Zg $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEzg::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Zg.
	* 
	* @param Zg l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(Zg $obj)
	{
		return parent::supprimer($obj, iDaoEzg::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Zg.
	* 
	* @param Zg l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(Zg $obj)
	{
		return parent::modifier($obj, iDaoEzg::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.11  2007-06-21 17:43:36  jp_milcent
* Ajout de requetes utilisées entre autre par le module Chorologie.
*
* Revision 1.10  2007-06-11 12:43:13  jp_milcent
* Début ajout des requêtes provenant de des DAO d'eFlore utilisé avant la création de l'API générale.
*
* Revision 1.9  2007-05-11 15:36:19  jp_milcent
* Modification d'un nom de champ.
*
* Revision 1.8  2007-02-09 16:27:54  jp_milcent
* Mise à jour vers la version 1.2 des classes DAO SQL du module zg.
*
* Revision 1.7  2007/01/15 19:33:43  jp_milcent
* Ajout d'un espace manquant dans une requête SQL.
*
* Revision 1.6  2007/01/03 17:06:09  jp_milcent
* Ajout de requêtes de consultation utilisées par l'interface web eFlore.
*
* Revision 1.5  2006/12/21 17:23:24  jp_milcent
* Ajout du type de résultat pour la consultation par ID.
* Complétion des requêtes mal générées.
*
* Revision 1.4  2006/09/05 14:20:59  jp_milcent
* Correction gestion des messages d'erreur.
*
* Revision 1.3  2006/07/20 16:11:05  jp_milcent
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>