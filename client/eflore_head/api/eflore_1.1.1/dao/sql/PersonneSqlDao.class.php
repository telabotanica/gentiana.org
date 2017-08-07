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
* Classe DAO SQL Personne
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
class PersonneSqlDao extends aDaoSqlEflore implements iDaoEp {
	/*** Attributes : ***/
	private $table_nom = 'eflore_personne';
	private $table_prefixe = 'ep_';
	protected $table_cle = array('personne');
	private $table_champs = array(
		'ep_id_personne'	=> array('type' => 'id', 'format' => 'int'),
		'ep_nom'	=> array('type' => 'no', 'format' => 'str'),
		'ep_prenom'	=> array('type' => 'no', 'format' => 'str'),
		'ep_login'	=> array('type' => 'no', 'format' => 'str'),
		'ep_mot_de_passe'	=> array('type' => 'no', 'format' => 'str'),
		'ep_courriel_01'	=> array('type' => 'no', 'format' => 'str'),
		'ep_courriel_02'	=> array('type' => 'no', 'format' => 'str'),
		'ep_web'	=> array('type' => 'no', 'format' => 'str'),
		'ep_adresse_01'	=> array('type' => 'no', 'format' => 'str'),
		'ep_adresse_02'	=> array('type' => 'no', 'format' => 'str'),
		'ep_code_postal'	=> array('type' => 'no', 'format' => 'str'),
		'ep_ville'	=> array('type' => 'no', 'format' => 'str'),
		'ep_ce_pays'	=> array('type' => 'ce', 'format' => 'int'),
		'ep_ce_version_projet_pays'	=> array('type' => 'ce', 'format' => 'int'),
		'ep_date_inscription'	=> array('type' => 'no', 'format' => 'str'),
		'ep_ce_type_utilisateur_efaune'	=> array('type' => 'ce', 'format' => 'int'),
		'ep_ce_etat_inscription'	=> array('type' => 'ce', 'format' => 'int'),
		'ep_ce_annuaire_tela'	=> array('type' => 'ce', 'format' => 'int'),
		'ep_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ep_ce_modifer_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ep_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** M�thodes : ***/
	
	/**
	* Retourne un objet Personne.
	* 
	* @param integer l'identifiant de la commande de consultation � ex�cuter.
	* @param array le tableau de param�tres � passer � l'ex�cutant de la commande.
	* @return Personne un objet Personne.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEp::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_personne';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEp::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_personne '.
						'WHERE ep_id_personne = ? ';
				break;
			case iDaoEp::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ep_id_personne) '.
						'FROM '.$this->getBddPrincipale().'.eflore_personne ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, Personne::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Personne.
	* 
	* @param Personne l'objet contenant les valeurs � ajouter.
	* @param string nom de la base de donn�e o� r�aliser l'insertion.
	* @return mixed l'identifiant de la ligne ajout�e ou false.
	*/
	public function ajouter(Personne $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEp::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Personne.
	* 
	* @param Personne l'objet contenant les identifiants de la ligne � supprimer.
	* @return boolean true si la ligne est bien supprim�, sinon false.
	*/
	public function supprimer(Personne $obj)
	{
		return parent::supprimer($obj, iDaoEp::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Personne.
	* 
	* @param Personne l'objet contenant les valeurs � modifier.
	* @return boolean true si la ligne est bien modifi�, sinon false.
	*/
	public function modifier(Personne $obj)
	{
		return parent::modifier($obj, iDaoEp::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2006-07-20 16:53:24  jp_milcent
* Correction requete sql MAX.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes g�n�r�es automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>