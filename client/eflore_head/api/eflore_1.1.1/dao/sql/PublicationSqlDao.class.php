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
* Classe DAO SQL Publication
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
class PublicationSqlDao extends aDaoSqlEflore implements iDaoEpu {
	/*** Attributes : ***/
	private $table_nom = 'eflore_publication';
	private $table_prefixe = 'epu_';
	protected $table_cle = array('publication');
	private $table_champs = array(
		'epu_id_publication'	=> array('type' => 'id', 'format' => 'int'),
		'epu_titre'	=> array('type' => 'no', 'format' => 'str'),
		'epu_ce_intitule_auteur'	=> array('type' => 'ce', 'format' => 'int'),
		'epu_ce_zone_geo'	=> array('type' => 'ce', 'format' => 'int'),
		'epu_ce_version_projet_zg'	=> array('type' => 'ce', 'format' => 'int'),
		'epu_ce_langue'	=> array('type' => 'ce', 'format' => 'int'),
		'epu_ce_version_projet_langue'	=> array('type' => 'ce', 'format' => 'int'),
		'epu_resumer'	=> array('type' => 'no', 'format' => 'str'),
		'epu_ce_image'	=> array('type' => 'ce', 'format' => 'int'),
		'epu_ce_version_projet_img'	=> array('type' => 'ce', 'format' => 'int'),
		'epu_ce_contributeur'	=> array('type' => 'ce', 'format' => 'int'),
		'epu_fournisseur_autre'	=> array('type' => 'no', 'format' => 'str'),
		'epu_mark_cacher_info'	=> array('type' => 'no', 'format' => 'int'),
		'epu_commentaire_public'	=> array('type' => 'no', 'format' => 'str'),
		'epu_notes'	=> array('type' => 'no', 'format' => 'str'),
		'epu_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'epu_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'epu_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet Publication.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return Publication un objet Publication.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEpu::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEpu::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication '.
						'WHERE epu_id_publication = ? ';
				break;
			case iDaoEpu::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(epu_id_publication) '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, Publication::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Publication.
	* 
	* @param Publication l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(Publication $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEpu::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Publication.
	* 
	* @param Publication l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(Publication $obj)
	{
		return parent::supprimer($obj, iDaoEpu::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Publication.
	* 
	* @param Publication l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(Publication $obj)
	{
		return parent::modifier($obj, iDaoEpu::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2006-07-20 16:53:24  jp_milcent
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