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
* Classe DAO SQL NomCitation
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
class NomCitationSqlDao extends aDaoSqlEflore implements iDaoEnci {
	/*** Attributes : ***/
	private $table_nom = 'eflore_nom_citation';
	private $table_prefixe = 'enci_';
	protected $table_cle = array('citation');
	private $table_champs = array(
		'enci_id_citation'	=> array('type' => 'id', 'format' => 'int'),
		'enci_ce_auteur_in'	=> array('type' => 'ce', 'format' => 'int'),
		'enci_ce_abreviation_publi'	=> array('type' => 'ce', 'format' => 'int'),
		'enci_intitule_citation_origine'	=> array('type' => 'no', 'format' => 'str'),
		'enci_intitule_complet_citation'	=> array('type' => 'no', 'format' => 'str'),
		'enci_annee_citation'	=> array('type' => 'no', 'format' => 'str'),
		'enci_serie'	=> array('type' => 'no', 'format' => 'str'),
		'enci_edition'	=> array('type' => 'no', 'format' => 'str'),
		'enci_volume'	=> array('type' => 'no', 'format' => 'str'),
		'enci_pages'	=> array('type' => 'no', 'format' => 'str'),
		'enci_notes_citation'	=> array('type' => 'no', 'format' => 'str'),
		'enci_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'enci_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'enci_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet NomCitation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return NomCitation un objet NomCitation.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEnci::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_citation';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEnci::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_citation '.
						'WHERE enci_id_citation = ? ';
				break;
			case iDaoEnci::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(enci_id_citation) '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_citation ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			case iDaoEnci::CONSULTER_INTITULE_ORIGINE :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_citation '.
						'WHERE enci_intitule_citation_origine = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			//<!-- INSERTION MANUELLE : DEBUT -->//
			case iDaoEnci::CONSULTER_GROUPE_ID :
				$sql = 	'SELECT * '.
                    	'FROM '.$this->getBddPrincipale().'.eflore_nom_citation '.
						'WHERE enci_id_citation IN (!) ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			//<!-- INSERTION MANUELLE : FIN -->//
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, NomCitation::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Nom Citation.
	* 
	* @param NomCitation l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(NomCitation $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEnci::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Nom Citation.
	* 
	* @param NomCitation l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(NomCitation $obj)
	{
		return parent::supprimer($obj, iDaoEnci::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Nom Citation.
	* 
	* @param NomCitation l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(NomCitation $obj)
	{
		return parent::modifier($obj, iDaoEnci::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2007-06-21 17:43:36  jp_milcent
* Ajout de requetes utilisées entre autre par le module Chorologie.
*
* Revision 1.1  2006-07-20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>