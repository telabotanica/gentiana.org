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
// CVS : $Id: NaturalisteNomSqlDao.class.php,v 1.1 2007-02-11 19:47:52 jp_milcent Exp $
/**
* Classe DAO SQL : NaturalisteNom
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
class NaturalisteNomSqlDao extends aDaoSql implements iDaoEnan {

	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'NaturalisteNomSqlDao';
	
	/*** Attributes : ***/
	private $prenom_principal;
	private $prenom_deux;
	private $prenom_trois;
	private $nom;
	private $nom_complet;
	
	protected $table_nom = 'eflore_naturaliste_nom';
	protected $table_prefixe = 'enan_';
	protected $table_cle = array('nom', 'projet_nom');
	protected $table_champs = array(
		'enan_id_nom'	=> array('type' => 'id', 'format' => 'int'),
		'enan_id_projet_nom'	=> array('type' => 'id', 'format' => 'int'),
		'enan_ce_naturaliste'	=> array('type' => 'ce', 'format' => 'int'),
		'enan_ce_projet_naturaliste'	=> array('type' => 'ce', 'format' => 'int'),
		'enan_prenom_principal'	=> array('type' => 'no', 'format' => 'str'),
		'enan_prenom_deux'	=> array('type' => 'no', 'format' => 'str'),
		'enan_prenom_trois'	=> array('type' => 'no', 'format' => 'str'),
		'enan_nom'	=> array('type' => 'no', 'format' => 'str'),
		'enan_nom_complet'	=> array('type' => 'no', 'format' => 'str'),
		'enan_notes'	=> array('type' => 'no', 'format' => 'str'),
		'enan_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'enan_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'enan_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null, $options = array())
	{
		// Le nom de la classe pour aDaoSql
		$this->setClasseFilleNom(self::CLASSE_NOM);
		return parent::__construct($connexion, $options);
	}
	
	/*** Accesseurs : ***/

	// Prenom Principal
	public function getPrenomPrincipal()
	{
		return $this->prenom_principal;
	}
	public function setPrenomPrincipal( $pp )
	{
		$this->prenom_principal = $pp;
		$this->setMetaAttributsUtilises('prenom_principal');
	}
	// Prenom Deux
	public function getPrenomDeux()
	{
		return $this->prenom_deux;
	}
	public function setPrenomDeux( $pd )
	{
		$this->prenom_deux = $pd;
		$this->setMetaAttributsUtilises('prenom_deux');
	}
	// Prenom Trois
	public function getPrenomTrois()
	{
		return $this->prenom_trois;
	}
	public function setPrenomTrois( $pt )
	{
		$this->prenom_trois = $pt;
		$this->setMetaAttributsUtilises('prenom_trois');
	}
	// Nom
	public function getNom()
	{
		return $this->nom;
	}
	public function setNom( $n )
	{
		$this->nom = $n;
		$this->setMetaAttributsUtilises('nom');
	}
	// Nom Complet
	public function getNomComplet()
	{
		return $this->nom_complet;
	}
	public function setNomComplet( $nc )
	{
		$this->nom_complet = $nc;
		$this->setMetaAttributsUtilises('nom_complet');
	}
	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet NaturalisteNom.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return NaturalisteNom un objet NaturalisteNom.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEnan::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_nom';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEnan::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_nom '.
						'WHERE enan_id_nom = ? AND enan_id_projet_nom = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEnan::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(enan_id_nom) '.
						'FROM '.$this->getStockagePrincipal().'.eflore_naturaliste_nom '.

						'WHERE enan_id_projet_nom = ? ';
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
	* Ajoute une ligne :  Naturaliste Nom.
	* 
	* @param NaturalisteNom l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(NaturalisteNom $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEnan::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Naturaliste Nom.
	* 
	* @param NaturalisteNom l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(NaturalisteNom $obj)
	{
		return parent::supprimer($obj, iDaoEnan::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Naturaliste Nom.
	* 
	* @param NaturalisteNom l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(NaturalisteNom $obj)
	{
		return parent::modifier($obj, iDaoEnan::CONSULTER_ID);
	}

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: NaturalisteNomSqlDao.class.php,v $
* Revision 1.1  2007-02-11 19:47:52  jp_milcent
* Début gestion de l'api de la version 1.2 d'eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>