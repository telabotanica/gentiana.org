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
* Classe DAO SQL PublicationValeur
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
class PublicationValeurSqlDao extends aDaoSqlEflore implements iDaoEpuv {
	/*** Attributes : ***/
	private $table_nom = 'eflore_publication_valeur';
	private $table_prefixe = 'epuv_';
	protected $table_cle = array('valeur', 'categorie');
	private $table_champs = array(
		'epuv_id_valeur'	=> array('type' => 'id', 'format' => 'int'),
		'epuv_id_categorie'	=> array('type' => 'id', 'format' => 'int'),
		'epuv_intitule_valeur'	=> array('type' => 'no', 'format' => 'str'),
		'epuv_abreviation_valeur'	=> array('type' => 'no', 'format' => 'str'),
		'epuv_ce_image_valeur'	=> array('type' => 'ce', 'format' => 'int'),
		'epuv_ce_version_projet_image'	=> array('type' => 'ce', 'format' => 'int'),
		'epuv_description_valeur'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet PublicationValeur.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return PublicationValeur un objet PublicationValeur.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEpuv::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication_valeur';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEpuv::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication_valeur '.
						'WHERE epuv_id_valeur = ? AND epuv_id_categorie = ? ';
				break;
			case iDaoEpuv::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(epuv_id_valeur) '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication_valeur '.
						'WHERE epuv_id_categorie = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, PublicationValeur::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Publication Valeur.
	* 
	* @param PublicationValeur l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(PublicationValeur $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEpuv::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Publication Valeur.
	* 
	* @param PublicationValeur l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(PublicationValeur $obj)
	{
		return parent::supprimer($obj, iDaoEpuv::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Publication Valeur.
	* 
	* @param PublicationValeur l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(PublicationValeur $obj)
	{
		return parent::modifier($obj, iDaoEpuv::CONSULTER_ID);
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