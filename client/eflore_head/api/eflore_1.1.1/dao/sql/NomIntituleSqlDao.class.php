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
* Classe DAO SQL NomIntitule
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
class NomIntituleSqlDao extends aDaoSqlEflore implements iDaoEni {
	/*** Attributes : ***/
	private $table_nom = 'eflore_nom_intitule';
	protected $classe_nom = NomIntitule::CLASSE_NOM;
	private $table_prefixe = 'eni_';
	protected $table_cle = array('nom', 'version_projet_nom', 'categorie_format', 'valeur_format');
	private $table_champs = array(
		'eni_id_nom'	=> array('type' => 'id', 'format' => 'int'),
		'eni_id_version_projet_nom'	=> array('type' => 'id', 'format' => 'int'),
		'eni_id_categorie_format'	=> array('type' => 'id', 'format' => 'int'),
		'eni_id_valeur_format'	=> array('type' => 'id', 'format' => 'int'),
		'eni_intitule_nom'	=> array('type' => 'no', 'format' => 'str'),
		'eni_intitule_nom_long'	=> array('type' => 'no', 'format' => 'str'),
		'eni_soundex'	=> array('type' => 'no', 'format' => 'str'),
		'eni_notes_nom_intitule'	=> array('type' => 'no', 'format' => 'str')
		);
	protected $table_relations = array(
		'eflore_nom' => array('eni_id_nom', 'eni_id_version_projet_nom')
		);
		
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet NomIntitule.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return NomIntitule un objet NomIntitule.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEni::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_intitule';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEni::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_intitule '.
						'WHERE eni_id_nom = ? AND eni_id_version_projet_nom = ? AND eni_id_categorie_format = ? AND eni_id_valeur_format = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEni::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(eni_id_nom) '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_intitule '.
						'WHERE eni_id_version_projet_nom = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, NomIntitule::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Nom Intitule.
	* 
	* @param NomIntitule l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(NomIntitule $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEni::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Nom Intitule.
	* 
	* @param NomIntitule l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(NomIntitule $obj)
	{
		return parent::supprimer($obj, iDaoEni::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Nom Intitule.
	* 
	* @param NomIntitule l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(NomIntitule $obj)
	{
		return parent::modifier($obj, iDaoEni::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.3  2007-06-29 07:54:15  jp_milcent
* Ajout de relations.
*
* Revision 1.2  2006-07-25 16:14:57  jp_milcent
* Fin gestion du module Nomenclature pour l'intégration.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>