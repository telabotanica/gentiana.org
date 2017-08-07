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
* Classe DAO SQL InventaireObsAImg
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
class InventaireObsAImgSqlDao extends aDaoSqlEflore implements iDaoEioai {
	/*** Attributes : ***/
	private $table_nom = 'eflore_inventaire_obs_a_img';
	private $table_prefixe = 'eioai_';
	protected $table_cle = array('image', 'version_projet_img', 'observation', 'version_projet_observation');
	private $table_champs = array(
		'eioai_id_image'	=> array('type' => 'id', 'format' => 'int'),
		'eioai_id_version_projet_img'	=> array('type' => 'id', 'format' => 'int'),
		'eioai_id_observation'	=> array('type' => 'id', 'format' => 'int'),
		'eioai_id_version_projet_observation'	=> array('type' => 'id', 'format' => 'int'),
		'eioai_notes_img_obs'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet InventaireObsAImg.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return InventaireObsAImg un objet InventaireObsAImg.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEioai::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_inventaire_obs_a_img';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEioai::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_inventaire_obs_a_img '.
						'WHERE eioai_id_image = ? AND eioai_id_version_projet_img = ? AND eioai_id_observation = ? AND eioai_id_version_projet_observation = ? ';
				break;
			case iDaoEioai::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(eioai_id_image) '.
						'FROM '.$this->getBddPrincipale().'.eflore_inventaire_obs_a_img '.
						'WHERE eioai_id_version_projet_img = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, InventaireObsAImg::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Inventaire Obs A Img.
	* 
	* @param InventaireObsAImg l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(InventaireObsAImg $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEioai::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Inventaire Obs A Img.
	* 
	* @param InventaireObsAImg l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(InventaireObsAImg $obj)
	{
		return parent::supprimer($obj, iDaoEioai::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Inventaire Obs A Img.
	* 
	* @param InventaireObsAImg l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(InventaireObsAImg $obj)
	{
		return parent::modifier($obj, iDaoEioai::CONSULTER_ID);
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