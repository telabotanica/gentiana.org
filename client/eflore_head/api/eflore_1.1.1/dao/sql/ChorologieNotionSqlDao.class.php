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
* Classe DAO SQL ChorologieNotion
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
class ChorologieNotionSqlDao extends aDaoSqlEflore implements iDaoEcn {
	/*** Attributes : ***/
	private $table_nom = 'eflore_chorologie_notion';
	private $table_prefixe = 'ecn_';
	protected $table_cle = array('notion_choro', 'version_projet_notion_choro');
	private $table_champs = array(
		'ecn_id_notion_choro'	=> array('type' => 'id', 'format' => 'int'),
		'ecn_id_version_projet_notion_choro'	=> array('type' => 'id', 'format' => 'int'),
		'ecn_ce_type_notion_choro'	=> array('type' => 'ce', 'format' => 'int'),
		'ecn_intitule_principal'	=> array('type' => 'no', 'format' => 'str'),
		'ecn_code_notion'	=> array('type' => 'no', 'format' => 'str'),
		'ecn_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ecn_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ecn_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet ChorologieNotion.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return ChorologieNotion un objet ChorologieNotion.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEcn::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_notion';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEcn::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_notion '.
						'WHERE ecn_id_notion_choro = ? AND ecn_id_version_projet_notion_choro = ? ';
				break;
			case iDaoEcn::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ecn_id_notion_choro) '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_notion '.
						'WHERE ecn_id_version_projet_notion_choro = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			case iDaoEcn::CONSULTER_ID_PROJET :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_notion '.
						'WHERE ecn_id_version_projet_notion_choro = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			default :
				$message = 'Commande '.$cmd.' inconnue!';
				$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, ChorologieNotion::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Chorologie Notion.
	* 
	* @param ChorologieNotion l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(ChorologieNotion $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEcn::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Chorologie Notion.
	* 
	* @param ChorologieNotion l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(ChorologieNotion $obj)
	{
		return parent::supprimer($obj, iDaoEcn::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Chorologie Notion.
	* 
	* @param ChorologieNotion l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(ChorologieNotion $obj)
	{
		return parent::modifier($obj, iDaoEcn::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.4  2006-09-05 14:20:59  jp_milcent
* Correction gestion des messages d'erreur.
*
* Revision 1.3  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>