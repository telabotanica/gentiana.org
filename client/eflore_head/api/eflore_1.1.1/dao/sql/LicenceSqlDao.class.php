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
* Classe DAO SQL Licence
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
class LicenceSqlDao extends aDaoSqlEflore implements iDaoElc {
	/*** Attributes : ***/
	private $table_nom = 'eflore_licence';
	private $table_prefixe = 'elc_';
	protected $table_cle = array('licence', 'version_projet_licence');
	private $table_champs = array(
		'elc_id_licence'	=> array('type' => 'id', 'format' => 'int'),
		'elc_id_version_projet_licence'	=> array('type' => 'id', 'format' => 'int'),
		'elc_intitule_principal'	=> array('type' => 'no', 'format' => 'str'),
		'elc_abreviation'	=> array('type' => 'no', 'format' => 'str'),
		'elc_description'	=> array('type' => 'no', 'format' => 'str'),
		'elc_texte_original'	=> array('type' => 'no', 'format' => 'str'),
		'elc_lien'	=> array('type' => 'no', 'format' => 'str'),
		'elc_ce_image'	=> array('type' => 'ce', 'format' => 'int'),
		'elc_ce_version_projet_img'	=> array('type' => 'ce', 'format' => 'int'),
		'elc_notes_licence'	=> array('type' => 'no', 'format' => 'str'),
		'elc_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'elc_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'elc_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet Licence.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return Licence un objet Licence.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoElc::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_licence';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoElc::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_licence '.
						'WHERE elc_id_licence = ? AND elc_id_version_projet_licence = ? ';
				break;
			case iDaoElc::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(elc_id_licence) '.
						'FROM '.$this->getBddPrincipale().'.eflore_licence '.
						'WHERE elc_id_version_projet_licence = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, Licence::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Licence.
	* 
	* @param Licence l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(Licence $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoElc::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Licence.
	* 
	* @param Licence l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(Licence $obj)
	{
		return parent::supprimer($obj, iDaoElc::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Licence.
	* 
	* @param Licence l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(Licence $obj)
	{
		return parent::modifier($obj, iDaoElc::CONSULTER_ID);
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