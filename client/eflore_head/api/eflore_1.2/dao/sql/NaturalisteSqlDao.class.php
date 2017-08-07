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
// CVS : $Id: NaturalisteSqlDao.class.php,v 1.1 2007-02-11 19:47:52 jp_milcent Exp $
/**
* Classe DAO SQL : Naturaliste
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
class NaturalisteSqlDao extends aDaoSql implements iDaoEna {

	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'NaturalisteSqlDao';
	
	/*** Attributes : ***/
	private $lieu_naissance;
	private $date_naissance;
	private $lieu_deces;
	private $date_deces;
	private $date_publication;
	
	protected $table_nom = 'eflore_naturaliste';
	protected $table_prefixe = 'ena_';
	protected $table_cle = array('naturaliste', 'projet_naturaliste');
	protected $table_champs = array(
		'ena_id_naturaliste'	=> array('type' => 'id', 'format' => 'int'),
		'ena_id_projet_naturaliste'	=> array('type' => 'id', 'format' => 'int'),
		'ena_lieu_naissance'	=> array('type' => 'no', 'format' => 'str'),
		'ena_date_naissance'	=> array('type' => 'no', 'format' => 'str'),
		'ena_lieu_deces'	=> array('type' => 'no', 'format' => 'str'),
		'ena_date_deces'	=> array('type' => 'no', 'format' => 'str'),
		'ena_date_publication'	=> array('type' => 'no', 'format' => 'str'),
		'ena_notes'	=> array('type' => 'no', 'format' => 'str'),
		'ena_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ena_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ena_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null, $options = array())
	{
		// Le nom de la classe pour aDaoSql
		$this->setClasseFilleNom(self::CLASSE_NOM);
		return parent::__construct($connexion, $options);
	}
	
	/*** Accesseurs : ***/

	// Lieu Naissance
	public function getLieuNaissance()
	{
		return $this->lieu_naissance;
	}
	public function setLieuNaissance( $ln )
	{
		$this->lieu_naissance = $ln;
		$this->setMetaAttributsUtilises('lieu_naissance');
	}
	// Date Naissance
	public function getDateNaissance()
	{
		return $this->date_naissance;
	}
	public function setDateNaissance( $dn )
	{
		$this->date_naissance = $dn;
		$this->setMetaAttributsUtilises('date_naissance');
	}
	// Lieu Deces
	public function getLieuDeces()
	{
		return $this->lieu_deces;
	}
	public function setLieuDeces( $ld )
	{
		$this->lieu_deces = $ld;
		$this->setMetaAttributsUtilises('lieu_deces');
	}
	// Date Deces
	public function getDateDeces()
	{
		return $this->date_deces;
	}
	public function setDateDeces( $dd )
	{
		$this->date_deces = $dd;
		$this->setMetaAttributsUtilises('date_deces');
	}
	// Date Publication
	public function getDatePublication()
	{
		return $this->date_publication;
	}
	public function setDatePublication( $dp )
	{
		$this->date_publication = $dp;
		$this->setMetaAttributsUtilises('date_publication');
	}
	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet Naturaliste.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return Naturaliste un objet Naturaliste.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEna::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEna::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste '.
						'WHERE ena_id_naturaliste = ? AND ena_id_projet_naturaliste = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEna::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ena_id_naturaliste) '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste '.

						'WHERE ena_id_projet_naturaliste = ? ';
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
	* Ajoute une ligne :  Naturaliste.
	* 
	* @param Naturaliste l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(Naturaliste $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEna::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Naturaliste.
	* 
	* @param Naturaliste l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(Naturaliste $obj)
	{
		return parent::supprimer($obj, iDaoEna::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Naturaliste.
	* 
	* @param Naturaliste l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(Naturaliste $obj)
	{
		return parent::modifier($obj, iDaoEna::CONSULTER_ID);
	}

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: NaturalisteSqlDao.class.php,v $
* Revision 1.1  2007-02-11 19:47:52  jp_milcent
* Début gestion de l'api de la version 1.2 d'eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>