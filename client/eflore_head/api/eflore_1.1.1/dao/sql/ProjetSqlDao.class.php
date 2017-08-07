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
* Classe DAO SQL Projet
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
class ProjetSqlDao extends aDaoSqlEflore implements iDaoEpr {
	/*** Attributes : ***/
	private $table_nom = 'eflore_projet';
	private $table_prefixe = 'epr_';
	protected $table_cle = array('projet');
	private $table_champs = array(
		'epr_id_projet'	=> array('type' => 'id', 'format' => 'int'),
		'epr_ce_type_projet'	=> array('type' => 'ce', 'format' => 'int'),
		'epr_ce_naturaliste'	=> array('type' => 'ce', 'format' => 'int'),
		'epr_ce_contributeur_projet'	=> array('type' => 'ce', 'format' => 'int'),
		'epr_intitule_projet'	=> array('type' => 'no', 'format' => 'str'),
		'epr_abreviation_projet'	=> array('type' => 'no', 'format' => 'str'),
		'epr_description_projet'	=> array('type' => 'no', 'format' => 'str'),
		'epr_lien_web'	=> array('type' => 'no', 'format' => 'str'),
		'epr_mark_projet_consultable'	=> array('type' => 'no', 'format' => 'str'),
		'epr_notes_projet'	=> array('type' => 'no', 'format' => 'str'),
		'epr_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'epr_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'epr_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet Projet.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return Projet un objet Projet.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEpr::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_projet';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEpr::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_projet '.
						'WHERE epr_id_projet = ? ';
				break;
			case iDaoEpr::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(epr_id_projet) '.
						'FROM '.$this->getBddPrincipale().'.eflore_projet ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, Projet::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Projet.
	* 
	* @param Projet l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(Projet $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEpr::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Projet.
	* 
	* @param Projet l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(Projet $obj)
	{
		return parent::supprimer($obj, iDaoEpr::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Projet.
	* 
	* @param Projet l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(Projet $obj)
	{
		return parent::modifier($obj, iDaoEpr::CONSULTER_ID);
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