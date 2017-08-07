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
// CVS : $Id: NaturalisteComposerIntituleNomSqlDao.class.php,v 1.1 2007-02-11 19:47:52 jp_milcent Exp $
/**
* Classe DAO SQL : NaturalisteComposerIntituleNom
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
class NaturalisteComposerIntituleNomSqlDao extends aDaoSql implements iDaoEnacin {

	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'NaturalisteComposerIntituleNomSqlDao';
	
	/*** Attributes : ***/
	private $numero_ordre;
	private $truk_intitule_nom;
	
	protected $table_nom = 'eflore_naturaliste_composer_intitule_nom';
	protected $table_prefixe = 'enacin_';
	protected $table_cle = array('intitule_nom_naturaliste', 'projet_intitule_nom_naturaliste', 'nom', 'projet_nom');
	protected $table_champs = array(
		'enacin_id_intitule_nom_naturaliste'	=> array('type' => 'id', 'format' => 'int'),
		'enacin_id_projet_intitule_nom_naturaliste'	=> array('type' => 'id', 'format' => 'int'),
		'enacin_id_nom'	=> array('type' => 'id', 'format' => 'int'),
		'enacin_id_projet_nom'	=> array('type' => 'id', 'format' => 'int'),
		'enacin_numero_ordre'	=> array('type' => 'no', 'format' => 'int'),
		'enacin_truk_intitule_nom'	=> array('type' => 'no', 'format' => 'str'),
		'enacin_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'enacin_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'enacin_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
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
	// Truk Intitule Nom
	public function getTrukIntituleNom()
	{
		return $this->truk_intitule_nom;
	}
	public function setTrukIntituleNom( $tin )
	{
		$this->truk_intitule_nom = $tin;
		$this->setMetaAttributsUtilises('truk_intitule_nom');
	}
	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet NaturalisteComposerIntituleNom.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return NaturalisteComposerIntituleNom un objet NaturalisteComposerIntituleNom.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEnacin::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_composer_intitule_nom';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEnacin::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_composer_intitule_nom '.
						'WHERE enacin_id_intitule_nom_naturaliste = ? AND enacin_id_projet_intitule_nom_naturaliste = ? AND enacin_id_nom = ? AND enacin_id_projet_nom = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEnacin::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(enacin_id_intitule_nom_naturaliste) '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_composer_intitule_nom '.

						'WHERE enacin_id_projet_intitule_nom_naturaliste = ? ';
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
	* Ajoute une ligne :  Naturaliste Composer Intitule Nom.
	* 
	* @param NaturalisteComposerIntituleNom l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(NaturalisteComposerIntituleNom $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEnacin::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Naturaliste Composer Intitule Nom.
	* 
	* @param NaturalisteComposerIntituleNom l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(NaturalisteComposerIntituleNom $obj)
	{
		return parent::supprimer($obj, iDaoEnacin::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Naturaliste Composer Intitule Nom.
	* 
	* @param NaturalisteComposerIntituleNom l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(NaturalisteComposerIntituleNom $obj)
	{
		return parent::modifier($obj, iDaoEnacin::CONSULTER_ID);
	}

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: NaturalisteComposerIntituleNomSqlDao.class.php,v $
* Revision 1.1  2007-02-11 19:47:52  jp_milcent
* Début gestion de l'api de la version 1.2 d'eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>