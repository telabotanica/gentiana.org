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
* Classe DAO SQL NomRang
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
class NomRangSqlDao extends aDaoSqlEflore implements iDaoEnrg {
	/*** Attributes : ***/
	private $table_nom = 'eflore_nom_rang';
	private $table_prefixe = 'enrg_';
	protected $table_cle = array('rang');
	private $table_champs = array(
		'enrg_id_rang'	=> array('type' => 'id', 'format' => 'int'),
		'enrg_ce_rang_superieur'	=> array('type' => 'ce', 'format' => 'int'),
		'enrg_abreviation_rang'	=> array('type' => 'no', 'format' => 'str'),
		'enrg_intitule_rang'	=> array('type' => 'no', 'format' => 'str'),
		'enrg_description_rang'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet NomRang.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return NomRang un objet NomRang.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEnrg::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_rang';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEnrg::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_rang '.
						'WHERE enrg_id_rang = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEnrg::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(enrg_id_rang) '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_rang ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			case iDaoEnrg::CONSULTER_ABREVIATION :
				$sql = 	'SELECT enrg_abreviation_rang '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_rang '.
						'WHERE enrg_id_rang = ?';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			//<!-- INSERTION MANUELLE : DEBUT -->//
			case iDaoEnrg::CONSULTER_GROUPE_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_rang '.
						'WHERE enrg_id_rang IN (!) ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			//<!-- INSERTION MANUELLE : FIN -->//
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, NomRang::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Nom Rang.
	* 
	* @param NomRang l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(NomRang $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEnrg::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Nom Rang.
	* 
	* @param NomRang l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(NomRang $obj)
	{
		return parent::supprimer($obj, iDaoEnrg::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Nom Rang.
	* 
	* @param NomRang l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(NomRang $obj)
	{
		return parent::modifier($obj, iDaoEnrg::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.4  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.3  2006-07-25 16:14:57  jp_milcent
* Fin gestion du module Nomenclature pour l'intégration.
*
* Revision 1.2  2006/07/20 16:53:24  jp_milcent
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