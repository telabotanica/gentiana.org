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
* Classe DAO SQL Structure
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
class StructureSqlDao extends aDaoSqlEflore implements iDaoEs {
	/*** Attributes : ***/
	private $table_nom = 'eflore_structure';
	private $table_prefixe = 'es_';
	protected $table_cle = array('stucture');
	private $table_champs = array(
		'es_id_stucture'	=> array('type' => 'id', 'format' => 'int'),
		'es_ce_type_structure'	=> array('type' => 'ce', 'format' => 'int'),
		'es_nom'	=> array('type' => 'no', 'format' => 'str'),
		'es_sigle'	=> array('type' => 'no', 'format' => 'str'),
		'es_service'	=> array('type' => 'no', 'format' => 'str'),
		'es_date_creation'	=> array('type' => 'no', 'format' => 'str'),
		'es_nbre_personne'	=> array('type' => 'no', 'format' => 'int'),
		'es_vocation'	=> array('type' => 'no', 'format' => 'str'),
		'es_adresse_01'	=> array('type' => 'no', 'format' => 'str'),
		'es_adresse_02'	=> array('type' => 'no', 'format' => 'str'),
		'es_code_postal'	=> array('type' => 'no', 'format' => 'str'),
		'es_ville'	=> array('type' => 'no', 'format' => 'str'),
		'es_ce_pays'	=> array('type' => 'ce', 'format' => 'int'),
		'es_ce_version_projet_pays'	=> array('type' => 'ce', 'format' => 'int'),
		'es_telephone'	=> array('type' => 'no', 'format' => 'str'),
		'es_fax'	=> array('type' => 'no', 'format' => 'str'),
		'es_mail'	=> array('type' => 'no', 'format' => 'str'),
		'es_ce_image'	=> array('type' => 'ce', 'format' => 'str'),
		'es_ce_version_projet_img'	=> array('type' => 'ce', 'format' => 'int'),
		'es_mark_cacher'	=> array('type' => 'no', 'format' => 'int'),
		'es_commentaire_public'	=> array('type' => 'no', 'format' => 'str'),
		'es_notes'	=> array('type' => 'no', 'format' => 'str'),
		'es_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'es_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'es_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet Structure.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return Structure un objet Structure.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEs::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_structure';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEs::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_structure '.
						'WHERE es_id_stucture = ? ';
				break;
			case iDaoEs::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(es_id_stucture) '.
						'FROM '.$this->getBddPrincipale().'.eflore_structure ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, Structure::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Structure.
	* 
	* @param Structure l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(Structure $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEs::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Structure.
	* 
	* @param Structure l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(Structure $obj)
	{
		return parent::supprimer($obj, iDaoEs::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Structure.
	* 
	* @param Structure l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(Structure $obj)
	{
		return parent::modifier($obj, iDaoEs::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2006-07-20 16:54:23  jp_milcent
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