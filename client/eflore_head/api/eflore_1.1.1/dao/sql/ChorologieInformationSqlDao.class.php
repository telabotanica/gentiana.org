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
* Classe DAO SQL ChorologieInformation
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
class ChorologieInformationSqlDao extends aDaoSqlEflore implements iDaoEci {
	/*** Attributes : ***/
	private $table_nom = 'eflore_chorologie_information';
	private $table_prefixe = 'eci_';
	protected $table_cle = array('info_choro', 'version_projet_info_choro');
	private $table_champs = array(
		'eci_id_info_choro'	=> array('type' => 'id', 'format' => 'int'),
		'eci_id_version_projet_info_choro'	=> array('type' => 'id', 'format' => 'int'),
		'eci_ce_donnee_choro'	=> array('type' => 'ce', 'format' => 'int'),
		'eci_ce_version_projet_donnee_choro'	=> array('type' => 'ce', 'format' => 'int'),
		'eci_ce_notion_choro'	=> array('type' => 'ce', 'format' => 'int'),
		'eci_ce_version_projet_notion_choro'	=> array('type' => 'ce', 'format' => 'int'),
		'eci_ordre_notion'	=> array('type' => 'no', 'format' => 'int'),
		'eci_notes_info_choro'	=> array('type' => 'no', 'format' => 'str'),
		'eci_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'eci_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'eci_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet ChorologieInformation.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return ChorologieInformation un objet ChorologieInformation.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEci::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_information';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEci::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_information '.
						'WHERE eci_id_info_choro = ? AND eci_id_version_projet_info_choro = ? ';
				break;
			case iDaoEci::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(eci_id_info_choro) '.
						'FROM '.$this->getBddPrincipale().'.eflore_chorologie_information '.
						'WHERE eci_id_version_projet_info_choro = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, ChorologieInformation::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Chorologie Information.
	* 
	* @param ChorologieInformation l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(ChorologieInformation $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEci::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Chorologie Information.
	* 
	* @param ChorologieInformation l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(ChorologieInformation $obj)
	{
		return parent::supprimer($obj, iDaoEci::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Chorologie Information.
	* 
	* @param ChorologieInformation l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(ChorologieInformation $obj)
	{
		return parent::modifier($obj, iDaoEci::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.4  2006-07-20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>