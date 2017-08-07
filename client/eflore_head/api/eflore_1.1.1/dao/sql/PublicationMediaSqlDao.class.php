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
* Classe DAO SQL PublicationMedia
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
class PublicationMediaSqlDao extends aDaoSqlEflore implements iDaoEpum {
	/*** Attributes : ***/
	private $table_nom = 'eflore_publication_media';
	private $table_prefixe = 'epum_';
	protected $table_cle = array('media');
	private $table_champs = array(
		'epum_id_media'	=> array('type' => 'id', 'format' => 'int'),
		'epum_ce_media_superieur'	=> array('type' => 'ce', 'format' => 'int'),
		'epum_ce_structure'	=> array('type' => 'ce', 'format' => 'int'),
		'epum_ce_intitule_auteur'	=> array('type' => 'ce', 'format' => 'int'),
		'epum_ref_media_complete'	=> array('type' => 'no', 'format' => 'str'),
		'epum_annee_publi'	=> array('type' => 'no', 'format' => 'str'),
		'epum_titre_media'	=> array('type' => 'no', 'format' => 'str'),
		'epum_numero_edition'	=> array('type' => 'no', 'format' => 'str'),
		'epum_nom_collection'	=> array('type' => 'no', 'format' => 'str'),
		'epum_numero_collection'	=> array('type' => 'no', 'format' => 'str'),
		'epum_series'	=> array('type' => 'no', 'format' => 'str'),
		'epum_volume'	=> array('type' => 'no', 'format' => 'int'),
		'epum_prix'	=> array('type' => 'no', 'format' => 'str'),
		'epum_ville_publication'	=> array('type' => 'no', 'format' => 'str'),
		'epum_nom_editeur'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet PublicationMedia.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return PublicationMedia un objet PublicationMedia.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEpum::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication_media';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEpum::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication_media '.
						'WHERE epum_id_media = ? ';
				break;
			case iDaoEpum::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(epum_id_media) '.
						'FROM '.$this->getBddPrincipale().'.eflore_publication_media ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, PublicationMedia::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Publication Media.
	* 
	* @param PublicationMedia l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(PublicationMedia $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEpum::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Publication Media.
	* 
	* @param PublicationMedia l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(PublicationMedia $obj)
	{
		return parent::supprimer($obj, iDaoEpum::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Publication Media.
	* 
	* @param PublicationMedia l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(PublicationMedia $obj)
	{
		return parent::modifier($obj, iDaoEpum::CONSULTER_ID);
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