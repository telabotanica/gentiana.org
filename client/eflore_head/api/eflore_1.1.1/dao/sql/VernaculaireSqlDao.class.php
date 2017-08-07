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
* Classe DAO SQL Vernaculaire
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
class VernaculaireSqlDao extends aDaoSqlEflore implements iDaoEv {
	/*** Attributes : ***/
	private $table_nom = 'eflore_vernaculaire';
	private $table_prefixe = 'ev_';
	protected $table_cle = array('nom_vernaculaire', 'version_projet_nom_verna');
	private $table_champs = array(
		'ev_id_nom_vernaculaire'	=> array('type' => 'id', 'format' => 'int'),
		'ev_id_version_projet_nom_verna'	=> array('type' => 'id', 'format' => 'int'),
		'ev_ce_langue'	=> array('type' => 'ce', 'format' => 'int'),
		'ev_ce_version_projet_langue'	=> array('type' => 'ce', 'format' => 'int'),
		'ev_ce_categorie_genre_nombre'	=> array('type' => 'ce', 'format' => 'int'),
		'ev_ce_valeur_genre_nombre'	=> array('type' => 'ce', 'format' => 'int'),
		'ev_intitule_nom_vernaculaire'	=> array('type' => 'no', 'format' => 'str'),
		'ev_soundex_nom_vernaculaire'	=> array('type' => 'no', 'format' => 'str'),
		'ev_notes_nom_vernaculaire'	=> array('type' => 'no', 'format' => 'str'),
		'ev_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ev_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ev_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet Vernaculaire.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return Vernaculaire un objet Vernaculaire.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEv::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_vernaculaire';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEv::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_vernaculaire '.
						'WHERE ev_id_nom_vernaculaire = ? AND ev_id_version_projet_nom_verna = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEv::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ev_id_nom_vernaculaire) '.
						'FROM '.$this->getBddPrincipale().'.eflore_vernaculaire '.
						'WHERE ev_id_version_projet_nom_verna = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			//<!-- INSERTION MANUELLE : DEBUT -->//
			case iDaoEv::CONSULTER_GROUPE_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_vernaculaire '.
						'WHERE ev_id_nom_vernaculaire IN (!) '.
						'AND ev_id_version_projet_nom_verna = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			//<!-- INSERTION MANUELLE : FIN -->//
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, Vernaculaire::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Vernaculaire.
	* 
	* @param Vernaculaire l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(Vernaculaire $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEv::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Vernaculaire.
	* 
	* @param Vernaculaire l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(Vernaculaire $obj)
	{
		return parent::supprimer($obj, iDaoEv::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Vernaculaire.
	* 
	* @param Vernaculaire l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(Vernaculaire $obj)
	{
		return parent::modifier($obj, iDaoEv::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.3  2007-06-21 17:43:36  jp_milcent
* Ajout de requetes utilisées entre autre par le module Chorologie.
*
* Revision 1.2  2006-12-21 15:59:34  jp_milcent
* Ajout du type de résultat pour la consultation par ID.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>