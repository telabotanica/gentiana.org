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
* Classe DAO SQL PublicationIdentifiant
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
class PublicationIdentifiantSqlDao extends aDaoSqlEflore implements iDaoEpui {
	/*** Attributes : ***/
	private $table_nom = 'eflore_publication_identifiant';
	private $table_prefixe = 'epui_';
	protected $table_cle = array('version_projet_abreviation');
	private $table_champs = array(
		'epui_id_version_projet_abreviation'	=> array('type' => 'id', 'format' => 'int'),
		'epua_id_abreviation'	=> array('type' => 'no', 'format' => 'int'),
		'epui_code_numerique'	=> array('type' => 'no', 'format' => 'int'),
		'epui_code_alphanumerique'	=> array('type' => 'no', 'format' => 'str'),
		'epi_notes_code_publi'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet PublicationIdentifiant.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return PublicationIdentifiant un objet PublicationIdentifiant.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEpui::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication_identifiant';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEpui::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication_identifiant '.
						'WHERE epui_id_version_projet_abreviation = ? ';
				break;
			case iDaoEpui::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(epui_id_version_projet_abreviation) '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication_identifiant '.
						'WHERE epui_id_ = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, PublicationIdentifiant::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Publication Identifiant.
	* 
	* @param PublicationIdentifiant l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(PublicationIdentifiant $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEpui::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Publication Identifiant.
	* 
	* @param PublicationIdentifiant l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(PublicationIdentifiant $obj)
	{
		return parent::supprimer($obj, iDaoEpui::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Publication Identifiant.
	* 
	* @param PublicationIdentifiant l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(PublicationIdentifiant $obj)
	{
		return parent::modifier($obj, iDaoEpui::CONSULTER_ID);
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