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
// CVS : $Id: NaturalisteNomAReferenceSqlDao.class.php,v 1.1 2007-02-11 19:47:52 jp_milcent Exp $
/**
* Classe DAO SQL : NaturalisteNomAReference
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
class NaturalisteNomAReferenceSqlDao extends aDaoSql implements iDaoEnanar {

	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'NaturalisteNomAReferenceSqlDao';
	
	/*** Attributes : ***/
	
	protected $table_nom = 'eflore_naturaliste_nom_a_reference';
	protected $table_prefixe = 'enanar_';
	protected $table_cle = array();
	protected $table_champs = array(
		'enanar_id_nom'	=> array('type' => 'id', 'format' => 'int'),
		'enanar_id_projet_nom'	=> array('type' => 'id', 'format' => 'int'),
		'enanar_id_citation'	=> array('type' => 'id', 'format' => 'int'),
		'enanar_notes'	=> array('type' => 'no', 'format' => 'str'),
		'enanar_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'enanar_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'enanar_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
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
	* Retourne un objet NaturalisteNomAReference.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return NaturalisteNomAReference un objet NaturalisteNomAReference.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEnanar::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_nom_a_reference';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEnanar::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_nom_a_reference '.
						'WHERE ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEnanar::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(enanar_id_) '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_nom_a_reference '.

						'WHERE enanar_id_ = ? ';
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
	* Ajoute une ligne :  Naturaliste Nom A Reference.
	* 
	* @param NaturalisteNomAReference l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(NaturalisteNomAReference $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEnanar::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Naturaliste Nom A Reference.
	* 
	* @param NaturalisteNomAReference l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(NaturalisteNomAReference $obj)
	{
		return parent::supprimer($obj, iDaoEnanar::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Naturaliste Nom A Reference.
	* 
	* @param NaturalisteNomAReference l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(NaturalisteNomAReference $obj)
	{
		return parent::modifier($obj, iDaoEnanar::CONSULTER_ID);
	}

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: NaturalisteNomAReferenceSqlDao.class.php,v $
* Revision 1.1  2007-02-11 19:47:52  jp_milcent
* Début gestion de l'api de la version 1.2 d'eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>