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
// CVS : $Id: TaxonAProtectionSqlDao.class.php,v 1.2 2007-01-03 17:06:09 jp_milcent Exp $
/**
* Classe DAO SQL TaxonAProtection
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
*@version       $Revision: 1.2 $ $Date: 2007-01-03 17:06:09 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class TaxonAProtectionSqlDao extends aDaoSqlEflore implements iDaoEtap {
	/*** Attributes : ***/
	private $table_nom = 'eflore_taxon_a_protection';
	private $table_prefixe = 'etap_';
	protected $table_cle = array('taxon', 'version_projet_taxon', 'protection', 'version_projet_protection');
	private $table_champs = array(
		'etap_id_taxon'	=> array('type' => 'id', 'format' => 'int'),
		'etap_id_version_projet_taxon'	=> array('type' => 'id', 'format' => 'int'),
		'etap_id_protection'	=> array('type' => 'id', 'format' => 'int'),
		'etap_id_version_projet_protection'	=> array('type' => 'id', 'format' => 'int'),
		'etap_notes'	=> array('type' => 'no', 'format' => 'str'),
		'etap_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'etap_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'etap_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet TaxonAProtection.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return TaxonAProtection un objet TaxonAProtection.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEtap::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_taxon_a_protection';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEtap::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_taxon_a_protection '.
						'WHERE etap_id_taxon = ? AND etap_id_version_projet_taxon = ? AND etap_id_protection = ? AND etap_id_version_projet_protection = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEtap::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(etap_id_taxon) '.
						'FROM '.$this->getBddPrincipale().'.eflore_taxon_a_protection '.
						'WHERE etap_id_version_projet_taxon = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			case iDaoEtap::CONSULTER_ID_PROJET_TAXON_ID_TAXON :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_taxon_a_protection '.
						'WHERE etap_id_taxon = ? '.
						'AND etap_id_version_projet_taxon = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			default :
				$message = 'Commande '.$cmd.' inconnue!';
				$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, TaxonAProtection::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Taxon A Protection.
	* 
	* @param TaxonAProtection l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(TaxonAProtection $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEtap::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Taxon A Protection.
	* 
	* @param TaxonAProtection l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(TaxonAProtection $obj)
	{
		return parent::supprimer($obj, iDaoEtap::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Taxon A Protection.
	* 
	* @param TaxonAProtection l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(TaxonAProtection $obj)
	{
		return parent::modifier($obj, iDaoEtap::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: TaxonAProtectionSqlDao.class.php,v $
* Revision 1.2  2007-01-03 17:06:09  jp_milcent
* Ajout de requêtes de consultation utilisées par l'interface web eFlore.
*
* Revision 1.1  2006/12/28 20:57:16  jp_milcent
* Ajout du module Protection.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>