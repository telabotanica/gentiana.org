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
* Classe DAO SQL LangueIntitule
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
class LangueIntituleSqlDao extends aDaoSqlEflore implements iDaoEli {
	/*** Attributes : ***/
	private $table_nom = 'eflore_langue_intitule';
	private $table_prefixe = 'eli_';
	protected $table_cle = array();
	private $table_champs = array(
		'eli_id_langue'	=> array('type' => 'id', 'format' => 'int'),
		'eli_id_version_projet_langue'	=> array('type' => 'id', 'format' => 'int'),
		'eli_id_langue_intitule'	=> array('type' => 'id', 'format' => 'int'),
		'eli_id_version_projet_langue_intitule'	=> array('type' => 'id', 'format' => 'int'),
		'eli_id_categorie_format'	=> array('type' => 'id', 'format' => 'int'),
		'eli_id_valeur_format'	=> array('type' => 'id', 'format' => 'int'),
		'eli_ce_article'	=> array('type' => 'ce', 'format' => 'int'),
		'eli_intitule_langue'	=> array('type' => 'no', 'format' => 'str'),
		'eli_notes_intitule_lg'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet LangueIntitule.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return LangueIntitule un objet LangueIntitule.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEli::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_langue_intitule';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEli::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_langue_intitule '.
						'WHERE eli_id_langue = ? '.
						'AND eli_id_version_projet_langue = ? '.
						'AND eli_id_langue_intitule = ? '.
						'AND eli_id_version_projet_langue_intitule = ? '.
						'AND eli_id_categorie_format = ? '.
						'AND eli_id_valeur_format = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEli::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(eli_id_) '.
						'FROM '.$this->getBddPrincipale().'.eflore_langue_intitule '.
						'WHERE eli_id_ = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, LangueIntitule::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Langue Intitule.
	* 
	* @param LangueIntitule l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(LangueIntitule $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEli::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Langue Intitule.
	* 
	* @param LangueIntitule l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(LangueIntitule $obj)
	{
		return parent::supprimer($obj, iDaoEli::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Langue Intitule.
	* 
	* @param LangueIntitule l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(LangueIntitule $obj)
	{
		return parent::modifier($obj, iDaoEli::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2006-12-21 16:05:11  jp_milcent
* Ajout du type de résultat pour la consultation par ID.
* Complétion des requêtes mal générées.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>