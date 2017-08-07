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
* Classe DAO SQL NaturalisteComposerIntituleAbreviation
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
class NaturalisteComposerIntituleAbreviationSqlDao extends aDaoSqlEflore implements iDaoEnacia {
	/*** Attributes : ***/
	private $table_nom = 'eflore_naturaliste_composer_intitule_abreviation';
	private $table_prefixe = 'enacia_';
	protected $table_cle = array('intitule_naturaliste_abrege', 'abreviation_naturaliste');
	private $table_champs = array(
		'enacia_id_intitule_naturaliste_abrege'	=> array('type' => 'id', 'format' => 'int'),
		'enacia_id_abreviation_naturaliste'	=> array('type' => 'id', 'format' => 'int'),
		'enacia_numero_ordre'	=> array('type' => 'no', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
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
						'FROM '.$this->getBddPrincipale().'.eflore_naturaliste_composer_intitule_abreviation';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEnacia::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_naturaliste_composer_intitule_abreviation '.
						'WHERE enacia_id_intitule_naturaliste_abrege = ? AND enacia_id_abreviation_naturaliste = ? ';
				break;
			case iDaoEnacia::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(enacia_id_intitule_naturaliste_abrege) '.
						'FROM '.$this->getBddPrincipale().'.eflore_naturaliste_composer_intitule_abreviation '.
						'WHERE enacia_id_abreviation_naturaliste = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, NaturalisteComposerIntituleAbreviation::CLASSE_NOM);
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
* $Log$
* Revision 1.1  2006-07-20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>