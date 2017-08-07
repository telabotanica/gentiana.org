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
* Classe DAO SQL ChorologieIntituleNotion
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
class ChorologieIntituleNotionSqlDao extends aDaoSqlEflore implements iDaoEcin {
	/*** Attributes : ***/
	private $table_nom = 'eflore_chorologie_intitule_notion';
	private $table_prefixe = 'ecin_';
	protected $table_cle = array('notion_choro', 'version_projet_notion_choro', 'langue', 'version_projet_langue');
	private $table_champs = array(
		'ecin_id_notion_choro'	=> array('type' => 'id', 'format' => 'int'),
		'ecin_id_version_projet_notion_choro'	=> array('type' => 'id', 'format' => 'int'),
		'ecin_id_langue'	=> array('type' => 'id', 'format' => 'int'),
		'ecin_id_version_projet_langue'	=> array('type' => 'id', 'format' => 'int'),
		'ecin_intitule_notion_choro'	=> array('type' => 'no', 'format' => 'str'),
		'ecin_abreviation_notion_choro'	=> array('type' => 'no', 'format' => 'str'),
		'ecin_description_notion_choro'	=> array('type' => 'no', 'format' => 'str'),
		'ecin_mark_intitule_notion_choro_origine'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** M�thodes : ***/
	
	/**
	* Retourne un objet ChorologieIntituleNotion.
	* 
	* @param integer l'identifiant de la commande de consultation � ex�cuter.
	* @param array le tableau de param�tres � passer � l'ex�cutant de la commande.
	* @return ChorologieIntituleNotion un objet ChorologieIntituleNotion.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEcin::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_intitule_notion';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEcin::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_intitule_notion '.
						'WHERE ecin_id_notion_choro = ? AND ecin_id_version_projet_notion_choro = ? AND ecin_id_langue = ? AND ecin_id_version_projet_langue = ? ';
				break;
			case iDaoEcin::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ecin_id_notion_choro) '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_intitule_notion '.
						'WHERE ecin_id_version_projet_notion_choro = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, ChorologieIntituleNotion::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Chorologie Intitule Notion.
	* 
	* @param ChorologieIntituleNotion l'objet contenant les valeurs � ajouter.
	* @param string nom de la base de donn�e o� r�aliser l'insertion.
	* @return mixed l'identifiant de la ligne ajout�e ou false.
	*/
	public function ajouter(ChorologieIntituleNotion $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEcin::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Chorologie Intitule Notion.
	* 
	* @param ChorologieIntituleNotion l'objet contenant les identifiants de la ligne � supprimer.
	* @return boolean true si la ligne est bien supprim�, sinon false.
	*/
	public function supprimer(ChorologieIntituleNotion $obj)
	{
		return parent::supprimer($obj, iDaoEcin::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Chorologie Intitule Notion.
	* 
	* @param ChorologieIntituleNotion l'objet contenant les valeurs � modifier.
	* @return boolean true si la ligne est bien modifi�, sinon false.
	*/
	public function modifier(ChorologieIntituleNotion $obj)
	{
		return parent::modifier($obj, iDaoEcin::CONSULTER_ID);
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