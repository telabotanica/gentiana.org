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
// CVS : $Id: NaturalisteAbreviationSqlDao.class.php,v 1.1 2007-02-11 19:47:52 jp_milcent Exp $
/**
* Classe DAO SQL : NaturalisteAbreviation
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
class NaturalisteAbreviationSqlDao extends aDaoSql implements iDaoEnaa {

	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'NaturalisteAbreviationSqlDao';
	
	/*** Attributes : ***/
	private $abeviation;
	private $code_numerique;
	private $code_alpha;
	private $mark_abreviation_recommandee;
	
	protected $table_nom = 'eflore_naturaliste_abreviation';
	protected $table_prefixe = 'enaa_';
	protected $table_cle = array('abreviation', 'projet_abreviation');
	protected $table_champs = array(
		'enaa_id_abreviation'	=> array('type' => 'id', 'format' => 'int'),
		'enaa_id_projet_abreviation'	=> array('type' => 'id', 'format' => 'int'),
		'enaa_ce_nom'	=> array('type' => 'ce', 'format' => 'int'),
		'enaa_ce_projet_nom'	=> array('type' => 'ce', 'format' => 'int'),
		'enaa_abeviation'	=> array('type' => 'no', 'format' => 'str'),
		'enaa_code_numerique'	=> array('type' => 'no', 'format' => 'int'),
		'enaa_code_alpha'	=> array('type' => 'no', 'format' => 'str'),
		'enaa_mark_abreviation_recommandee'	=> array('type' => 'no', 'format' => 'str'),
		'enaa_notes'	=> array('type' => 'no', 'format' => 'str'),
		'enaa_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'enaa_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'enaa_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null, $options = array())
	{
		// Le nom de la classe pour aDaoSql
		$this->setClasseFilleNom(self::CLASSE_NOM);
		return parent::__construct($connexion, $options);
	}
	
	/*** Accesseurs : ***/

	// Abeviation
	public function getAbeviation()
	{
		return $this->abeviation;
	}
	public function setAbeviation( $a )
	{
		$this->abeviation = $a;
		$this->setMetaAttributsUtilises('abeviation');
	}
	// Code Numerique
	public function getCodeNumerique()
	{
		return $this->code_numerique;
	}
	public function setCodeNumerique( $cn )
	{
		$this->code_numerique = $cn;
		$this->setMetaAttributsUtilises('code_numerique');
	}
	// Code Alpha
	public function getCodeAlpha()
	{
		return $this->code_alpha;
	}
	public function setCodeAlpha( $ca )
	{
		$this->code_alpha = $ca;
		$this->setMetaAttributsUtilises('code_alpha');
	}
	// Mark Abreviation Recommandee
	public function getMarkAbreviationRecommandee()
	{
		return $this->mark_abreviation_recommandee;
	}
	public function setMarkAbreviationRecommandee( $mar )
	{
		$this->mark_abreviation_recommandee = $mar;
		$this->setMetaAttributsUtilises('mark_abreviation_recommandee');
	}
	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet NaturalisteAbreviation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return NaturalisteAbreviation un objet NaturalisteAbreviation.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEnaa::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_abreviation';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEnaa::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_abreviation '.
						'WHERE enaa_id_abreviation = ? AND enaa_id_projet_abreviation = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEnaa::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(enaa_id_abreviation) '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_abreviation '.

						'WHERE enaa_id_projet_abreviation = ? ';
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
	* Ajoute une ligne :  Naturaliste Abreviation.
	* 
	* @param NaturalisteAbreviation l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(NaturalisteAbreviation $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEnaa::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Naturaliste Abreviation.
	* 
	* @param NaturalisteAbreviation l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(NaturalisteAbreviation $obj)
	{
		return parent::supprimer($obj, iDaoEnaa::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Naturaliste Abreviation.
	* 
	* @param NaturalisteAbreviation l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(NaturalisteAbreviation $obj)
	{
		return parent::modifier($obj, iDaoEnaa::CONSULTER_ID);
	}

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: NaturalisteAbreviationSqlDao.class.php,v $
* Revision 1.1  2007-02-11 19:47:52  jp_milcent
* Début gestion de l'api de la version 1.2 d'eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>