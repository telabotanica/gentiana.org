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
* Classe DAO SQL ChorologieDonnee
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
class ChorologieDonneeSqlDao extends aDaoSqlEflore implements iDaoEcd {
	/*** Attributes : ***/
	private $table_nom = 'eflore_chorologie_donnee';
	protected $classe_nom = ChorologieDonnee::CLASSE_NOM;
	private $table_prefixe = 'ecd_';
	protected $table_cle = array('donnee_choro', 'version_projet_donnee_choro');
	private $table_champs = array(
		'ecd_id_donnee_choro'	=> array('type' => 'id', 'format' => 'int'),
		'ecd_id_version_projet_donnee_choro'	=> array('type' => 'id', 'format' => 'int'),
		'ecd_ce_taxon'	=> array('type' => 'ce', 'format' => 'int'),
		'ecd_ce_version_projet_taxon'	=> array('type' => 'ce', 'format' => 'int'),
		'ecd_ce_zone_geo'	=> array('type' => 'ce', 'format' => 'int'),
		'ecd_ce_version_projet_zg'	=> array('type' => 'ce', 'format' => 'int'),
		'ecd_notes_donnee_choro'	=> array('type' => 'no', 'format' => 'str'),
		'ecd_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ecd_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ecd_ce_etat'	=> array('type' => 'ce', 'format' => 'int'),
		'donnee_choro_nbre'	=> array('type' => 'sp', 'format' => 'int')
		);
	protected $table_relations = array(
		'eflore_selection_nom' => array('ecd_ce_taxon', 'ecd_ce_version_projet_taxon')
		);
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet ChorologieDonnee.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return ChorologieDonnee un objet ChorologieDonnee.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEcd::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_donnee';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEcd::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_donnee '.
						'WHERE ecd_id_donnee_choro = ? '.
						'AND ecd_id_version_projet_donnee_choro = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEcd::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ecd_id_donnee_choro) '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_donnee '.
						'WHERE ecd_id_version_projet_donnee_choro = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			//<!-- INSERTION MANUELLE : DEBUT -->//
			case iDaoEcd::CONSULTER_VERSION_CHORO_TAXON :
				$sql =	'SELECT DISTINCT * '. 
		               	'FROM '.$this->getBddPrincipale().'.eflore_chorologie_donnee '.
		               	'WHERE ecd_id_version_projet_donnee_choro = ? '.
		               	'AND ecd_ce_taxon = ? '. 
		               	'AND ecd_ce_version_projet_taxon = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEcd::CONSULTER_ZG_CHORO_VERSION :
				$sql =	'SELECT DISTINCT ecd_ce_zone_geo, ecd_ce_version_projet_zg '.  
		               	'FROM '.$this->getBddPrincipale().'.eflore_chorologie_donnee '.
		               	'WHERE ecd_id_version_projet_donnee_choro = ? '. 
						'AND ecd_ce_version_projet_taxon = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEcd::CONSULTER_PROJET_CHORO_VERSION :
				$sql =	'SELECT DISTINCT ecd_id_version_projet_donnee_choro '.  
		               	'FROM '.$this->getBddPrincipale().'.eflore_chorologie_donnee '.
		               	'WHERE ecd_ce_version_projet_taxon = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEcd::CONSULTER_TAXON_PAR_ZG_ET_PROJET_CHORO :
				$sql =	'SELECT DISTINCT * '.  
		               	'FROM '.$this->getBddPrincipale().'.eflore_chorologie_donnee '.
		               	'WHERE ecd_ce_zone_geo = ? '.
		               	'AND ecd_ce_version_projet_zg  = ? '.
		               	'AND ecd_id_version_projet_donnee_choro = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEcd::CONSULTER_NBRE_TAXON_PAR_ZG_ET_PROJET_CHORO :
				$sql =	'SELECT DISTINCT COUNT(ecd_id_donnee_choro) '.  
		               	'FROM '.$this->getBddPrincipale().'.eflore_chorologie_donnee '.
		               	'WHERE ecd_ce_zone_geo = ? '.
		               	'AND ecd_ce_version_projet_zg  = ? '.
		               	'AND ecd_id_version_projet_donnee_choro = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			case iDaoEcd::CONSULTER_PROJET_CHORO :
				$sql = 	'SELECT ecd_ce_zone_geo, ecd_ce_version_projet_zg, COUNT(ecd_id_donnee_choro) AS donnee_choro_nbre '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_donnee '.
						'WHERE ecd_id_version_projet_donnee_choro = ? '.
						'GROUP BY ecd_ce_zone_geo, ecd_ce_version_projet_zg ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			//<!-- INSERTION MANUELLE : FIN -->//
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, ChorologieDonnee::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Chorologie Donnee.
	* 
	* @param ChorologieDonnee l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(ChorologieDonnee $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEcd::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Chorologie Donnee.
	* 
	* @param ChorologieDonnee l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(ChorologieDonnee $obj)
	{
		return parent::supprimer($obj, iDaoEcd::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Chorologie Donnee.
	* 
	* @param ChorologieDonnee l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(ChorologieDonnee $obj)
	{
		return parent::modifier($obj, iDaoEcd::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.7  2007-06-29 07:54:15  jp_milcent
* Ajout de relations.
*
* Revision 1.6  2007-06-27 17:08:12  jp_milcent
* Mise en place de la gestion des relations entre table.
*
* Revision 1.5  2007-06-21 17:43:36  jp_milcent
* Ajout de requetes utilisées entre autre par le module Chorologie.
*
* Revision 1.4  2007-06-11 12:43:13  jp_milcent
* Début ajout des requêtes provenant de des DAO d'eFlore utilisé avant la création de l'API générale.
*
* Revision 1.3  2006-07-20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>