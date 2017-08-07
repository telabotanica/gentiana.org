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
* Classe DAO SQL InventaireDetermination
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
class InventaireDeterminationSqlDao extends aDaoSqlEflore implements iDaoEid {
	/*** Attributes : ***/
	private $table_nom = 'eflore_inventaire_determination';
	private $table_prefixe = 'eid_';
	protected $table_cle = array('determination');
	private $table_champs = array(
		'eid_id_determination'	=> array('type' => 'id', 'format' => 'int'),
		'eid_ce_version_projet_observation'	=> array('type' => 'ce', 'format' => 'int'),
		'eid_ce_observation'	=> array('type' => 'ce', 'format' => 'int'),
		'eid_ce_taxon'	=> array('type' => 'ce', 'format' => 'int'),
		'eid_ce_version_projet_taxon'	=> array('type' => 'ce', 'format' => 'int'),
		'eid_ce_autre_nom_latin'	=> array('type' => 'ce', 'format' => 'int'),
		'eid_autre_ouvrage_determination'	=> array('type' => 'no', 'format' => 'str'),
		'eid_ce_determinateur'	=> array('type' => 'ce', 'format' => 'int'),
		'eid_certitude_determination'	=> array('type' => 'no', 'format' => 'int'),
		'eid_commentaire_determination'	=> array('type' => 'no', 'format' => 'str'),
		'eid_mark_determination_origine'	=> array('type' => 'no', 'format' => 'int'),
		'eid_notes_determination'	=> array('type' => 'no', 'format' => 'str'),
		'eid_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'eid_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'eid_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet InventaireDetermination.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return InventaireDetermination un objet InventaireDetermination.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEid::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_inventaire_determination';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEid::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_inventaire_determination '.
						'WHERE eid_id_determination = ? ';
				break;
			case iDaoEid::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(eid_id_determination) '.
						'FROM '.$this->getBddPrincipale().'.eflore_inventaire_determination ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, InventaireDetermination::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Inventaire Determination.
	* 
	* @param InventaireDetermination l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(InventaireDetermination $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEid::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Inventaire Determination.
	* 
	* @param InventaireDetermination l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(InventaireDetermination $obj)
	{
		return parent::supprimer($obj, iDaoEid::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Inventaire Determination.
	* 
	* @param InventaireDetermination l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(InventaireDetermination $obj)
	{
		return parent::modifier($obj, iDaoEid::CONSULTER_ID);
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