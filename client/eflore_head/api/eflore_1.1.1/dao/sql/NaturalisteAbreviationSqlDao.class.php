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
* Classe DAO SQL NaturalisteAbreviation
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
class NaturalisteAbreviationSqlDao extends aDaoSqlEflore implements iDaoEnaa {
	/*** Attributes : ***/
	private $table_nom = 'eflore_naturaliste_abreviation';
	private $table_prefixe = 'enaa_';
	protected $table_cle = array('abreviation');
	private $table_champs = array(
		'enaa_id_abreviation'	=> array('type' => 'id', 'format' => 'int'),
		'enaa_ce_nom_naturaliste'	=> array('type' => 'ce', 'format' => 'int'),
		'enaa_abeviation'	=> array('type' => 'no', 'format' => 'str'),
		'enaa_ce_abreviation_recommandee'	=> array('type' => 'ce', 'format' => 'int'),
		'enaa_notes_abreviation'	=> array('type' => 'no', 'format' => 'str'),
		'enaa_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'enaa_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'enaa_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
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
						'FROM '.$this->getBddPrincipale().'.eflore_naturaliste_abreviation';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEnaa::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_naturaliste_abreviation '.
						'WHERE enaa_id_abreviation = ? ';
				break;
			case iDaoEnaa::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(enaa_id_abreviation) '.
						'FROM '.$this->getBddPrincipale().'.eflore_naturaliste_abreviation ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, NaturalisteAbreviation::CLASSE_NOM);
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
* $Log$
* Revision 1.2  2006-07-20 16:53:24  jp_milcent
* Correction requete sql MAX.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>