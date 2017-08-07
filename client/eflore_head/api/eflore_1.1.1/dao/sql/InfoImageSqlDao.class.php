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
* Classe DAO SQL InfoImage
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
class InfoImageSqlDao extends aDaoSqlEflore implements iDaoEii {
	/*** Attributes : ***/
	private $table_nom = 'eflore_info_image';
	private $table_prefixe = 'eii_';
	protected $table_cle = array('image', 'version_projet_img');
	private $table_champs = array(
		'eii_id_image'	=> array('type' => 'id', 'format' => 'int'),
		'eii_id_version_projet_img'	=> array('type' => 'id', 'format' => 'int'),
		'eii_intitule'	=> array('type' => 'no', 'format' => 'str'),
		'eii_description_courte'	=> array('type' => 'no', 'format' => 'str'),
		'eii_description_longue'	=> array('type' => 'no', 'format' => 'str'),
		'eii_hauteur'	=> array('type' => 'no', 'format' => 'int'),
		'eii_largeur'	=> array('type' => 'no', 'format' => 'int'),
		'eii_poids'	=> array('type' => 'no', 'format' => 'int'),
		'eii_lien_vers_img'	=> array('type' => 'no', 'format' => 'str'),
		'eii_nom_fichier'	=> array('type' => 'no', 'format' => 'str'),
		'eii_ce_contributeur'	=> array('type' => 'ce', 'format' => 'int'),
		'eii_ce_auteur'	=> array('type' => 'ce', 'format' => 'int'),
		'eii_autre_auteur'	=> array('type' => 'no', 'format' => 'str'),
		'eii_ce_citation_biblio'	=> array('type' => 'ce', 'format' => 'int'),
		'eii_ce_licence'	=> array('type' => 'ce', 'format' => 'int'),
		'eii_ce_version_projet_licence'	=> array('type' => 'ce', 'format' => 'int'),
		'eii_autre_lien_licence'	=> array('type' => 'no', 'format' => 'str'),
		'eii_notes_image'	=> array('type' => 'no', 'format' => 'str'),
		'eii_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'eii_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'eii_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet InfoImage.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return InfoImage un objet InfoImage.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEii::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_info_image';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEii::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_info_image '.
						'WHERE eii_id_image = ? AND eii_id_version_projet_img = ? ';
				break;
			case iDaoEii::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(eii_id_image) '.
						'FROM '.$this->getBddPrincipale().'.eflore_info_image '.
						'WHERE eii_id_version_projet_img = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, InfoImage::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Info Image.
	* 
	* @param InfoImage l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(InfoImage $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEii::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Info Image.
	* 
	* @param InfoImage l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(InfoImage $obj)
	{
		return parent::supprimer($obj, iDaoEii::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Info Image.
	* 
	* @param InfoImage l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(InfoImage $obj)
	{
		return parent::modifier($obj, iDaoEii::CONSULTER_ID);
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