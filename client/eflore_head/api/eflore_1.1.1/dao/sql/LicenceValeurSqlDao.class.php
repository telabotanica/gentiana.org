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
* Classe DAO SQL LicenceValeur
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
class LicenceValeurSqlDao extends aDaoSqlEflore implements iDaoElcv {
	/*** Attributes : ***/
	private $table_nom = 'eflore_licence_valeur';
	private $table_prefixe = 'elcv_';
	protected $table_cle = array('valeur_licence');
	private $table_champs = array(
		'elcv_id_valeur_licence'	=> array('type' => 'id', 'format' => 'int'),
		'elcc_id_categorie_licence'	=> array('type' => 'no', 'format' => 'int'),
		'elcv_intitule_valeur_licence'	=> array('type' => 'no', 'format' => 'str'),
		'elcv_abreviation_valeur_licence'	=> array('type' => 'no', 'format' => 'str'),
		'elcv_description_valeur_licence'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet LicenceValeur.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return LicenceValeur un objet LicenceValeur.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoElcv::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_licence_valeur';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoElcv::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_licence_valeur '.
						'WHERE elcv_id_valeur_licence = ? ';
				break;
			case iDaoElcv::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(elcv_id_valeur_licence) '.
						'FROM '.$this->getBddPrincipale().'.eflore_licence_valeur '.
						'WHERE elcv_id_ = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, LicenceValeur::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Licence Valeur.
	* 
	* @param LicenceValeur l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(LicenceValeur $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoElcv::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Licence Valeur.
	* 
	* @param LicenceValeur l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(LicenceValeur $obj)
	{
		return parent::supprimer($obj, iDaoElcv::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Licence Valeur.
	* 
	* @param LicenceValeur l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(LicenceValeur $obj)
	{
		return parent::modifier($obj, iDaoElcv::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.1  2006-07-20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>