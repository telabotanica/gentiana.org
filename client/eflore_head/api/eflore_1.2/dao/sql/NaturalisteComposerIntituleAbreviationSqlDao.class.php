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
// CVS : $Id: NaturalisteComposerIntituleAbreviationSqlDao.class.php,v 1.1 2007-02-11 19:47:52 jp_milcent Exp $
/**
* Classe DAO SQL : NaturalisteComposerIntituleAbreviation
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
class NaturalisteComposerIntituleAbreviationSqlDao extends aDaoSql implements iDaoEnacia {

	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'NaturalisteComposerIntituleAbreviationSqlDao';
	
	/*** Attributes : ***/
	private $numero_ordre;
	private $truk_intitule_abrege;
	
	protected $table_nom = 'eflore_naturaliste_composer_intitule_abreviation';
	protected $table_prefixe = 'enacia_';
	protected $table_cle = array('intitule_naturaliste_abrege', 'projet_intitule_naturaliste_abrege', 'abreviation_naturaliste', 'projet_abreviation');
	protected $table_champs = array(
		'enacia_id_intitule_naturaliste_abrege'	=> array('type' => 'id', 'format' => 'int'),
		'enacia_id_projet_intitule_naturaliste_abrege'	=> array('type' => 'id', 'format' => 'int'),
		'enacia_id_abreviation_naturaliste'	=> array('type' => 'id', 'format' => 'int'),
		'enacia_id_projet_abreviation'	=> array('type' => 'id', 'format' => 'int'),
		'enacia_numero_ordre'	=> array('type' => 'no', 'format' => 'int'),
		'enacia_truk_intitule_abrege'	=> array('type' => 'no', 'format' => 'str'),
		'enacia_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'enacia_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'enacia_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null, $options = array())
	{
		// Le nom de la classe pour aDaoSql
		$this->setClasseFilleNom(self::CLASSE_NOM);
		return parent::__construct($connexion, $options);
	}
	
	/*** Accesseurs : ***/

	// Numero Ordre
	public function getNumeroOrdre()
	{
		return $this->numero_ordre;
	}
	public function setNumeroOrdre( $no )
	{
		$this->numero_ordre = $no;
		$this->setMetaAttributsUtilises('numero_ordre');
	}
	// Truk Intitule Abrege
	public function getTrukIntituleAbrege()
	{
		return $this->truk_intitule_abrege;
	}
	public function setTrukIntituleAbrege( $tia )
	{
		$this->truk_intitule_abrege = $tia;
		$this->setMetaAttributsUtilises('truk_intitule_abrege');
	}
	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet NaturalisteComposerIntituleAbreviation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return NaturalisteComposerIntituleAbreviation un objet NaturalisteComposerIntituleAbreviation.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEnacia::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_composer_intitule_abreviation';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEnacia::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_composer_intitule_abreviation '.
						'WHERE enacia_id_intitule_naturaliste_abrege = ? AND enacia_id_projet_intitule_naturaliste_abrege = ? AND enacia_id_abreviation_naturaliste = ? AND enacia_id_projet_abreviation = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEnacia::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(enacia_id_intitule_naturaliste_abrege) '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_composer_intitule_abreviation '.

						'WHERE enacia_id_projet_intitule_naturaliste_abrege = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			case iDaoEnacia::CONSULTER_INTITULE :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_composer_intitule_abreviation '.
						'WHERE enacia_truk_intitule_abrege LIKE "!%" '.
						'AND enacia_numero_ordre = 0';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
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
	* Ajoute une ligne :  Naturaliste Composer Intitule Abreviation.
	* 
	* @param NaturalisteComposerIntituleAbreviation l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(NaturalisteComposerIntituleAbreviation $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEnacia::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Naturaliste Composer Intitule Abreviation.
	* 
	* @param NaturalisteComposerIntituleAbreviation l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(NaturalisteComposerIntituleAbreviation $obj)
	{
		return parent::supprimer($obj, iDaoEnacia::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Naturaliste Composer Intitule Abreviation.
	* 
	* @param NaturalisteComposerIntituleAbreviation l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(NaturalisteComposerIntituleAbreviation $obj)
	{
		return parent::modifier($obj, iDaoEnacia::CONSULTER_ID);
	}

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: NaturalisteComposerIntituleAbreviationSqlDao.class.php,v $
* Revision 1.1  2007-02-11 19:47:52  jp_milcent
* Début gestion de l'api de la version 1.2 d'eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>