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
* Classe DAO SQL DroitCreerProjet
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
class DroitCreerProjetSqlDao extends aDaoSqlEflore implements iDaoEdrcp {
	/*** Attributes : ***/
	private $table_nom = 'eflore_droit_creer_projet';
	private $table_prefixe = 'edrcp_';
	protected $table_cle = array('utilisateur', 'type_projet');
	private $table_champs = array(
		'edrcp_id_utilisateur'	=> array('type' => 'id', 'format' => 'int'),
		'edrcp_id_type_projet'	=> array('type' => 'id', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** M�thodes : ***/
	
	/**
	* Retourne un objet DroitCreerProjet.
	* 
	* @param integer l'identifiant de la commande de consultation � ex�cuter.
	* @param array le tableau de param�tres � passer � l'ex�cutant de la commande.
	* @return DroitCreerProjet un objet DroitCreerProjet.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEdrcp::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_droit_creer_projet';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEdrcp::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_droit_creer_projet '.
						'WHERE edrcp_id_utilisateur = ? AND edrcp_id_type_projet = ? ';
				break;
			case iDaoEdrcp::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(edrcp_id_utilisateur) '.
						'FROM '.$this->getBddPrincipale().'.eflore_droit_creer_projet '.
						'WHERE edrcp_id_type_projet = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, DroitCreerProjet::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Droit Creer Projet.
	* 
	* @param DroitCreerProjet l'objet contenant les valeurs � ajouter.
	* @param string nom de la base de donn�e o� r�aliser l'insertion.
	* @return mixed l'identifiant de la ligne ajout�e ou false.
	*/
	public function ajouter(DroitCreerProjet $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEdrcp::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Droit Creer Projet.
	* 
	* @param DroitCreerProjet l'objet contenant les identifiants de la ligne � supprimer.
	* @return boolean true si la ligne est bien supprim�, sinon false.
	*/
	public function supprimer(DroitCreerProjet $obj)
	{
		return parent::supprimer($obj, iDaoEdrcp::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Droit Creer Projet.
	* 
	* @param DroitCreerProjet l'objet contenant les valeurs � modifier.
	* @return boolean true si la ligne est bien modifi�, sinon false.
	*/
	public function modifier(DroitCreerProjet $obj)
	{
		return parent::modifier($obj, iDaoEdrcp::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.1  2006-07-20 16:11:05  jp_milcent
* Ajout des classes g�n�r�es automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>