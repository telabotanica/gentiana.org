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
* Classe DAO SQL Nom
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
class NomSqlDao extends aDaoSqlEflore implements iDaoEn {
	/*** Attributes : ***/
	private $table_nom = 'eflore_nom';
	protected $classe_nom = Nom::CLASSE_NOM;
	private $table_prefixe = 'en_';
	protected $table_cle = array('nom', 'version_projet_nom');
	private $table_champs = array(
		'en_id_nom'	=> array('type' => 'id', 'format' => 'int'),
		'en_id_version_projet_nom'	=> array('type' => 'id', 'format' => 'int'),
		'en_ce_auteur_basio_ex'	=> array('type' => 'ce', 'format' => 'int'),
		'en_ce_auteur_basio'	=> array('type' => 'ce', 'format' => 'int'),
		'en_ce_auteur_modif_ex'	=> array('type' => 'ce', 'format' => 'int'),
		'en_ce_auteur_modif'	=> array('type' => 'ce', 'format' => 'int'),
		'en_ce_citation_initiale'	=> array('type' => 'ce', 'format' => 'int'),
		'en_ce_intitule_cn'	=> array('type' => 'ce', 'format' => 'int'),
		'en_ce_rang'	=> array('type' => 'ce', 'format' => 'int'),
		'en_nom_supra_generique'	=> array('type' => 'no', 'format' => 'str'),
		'en_nom_genre'	=> array('type' => 'no', 'format' => 'str'),
		'en_epithete_infra_generique'	=> array('type' => 'no', 'format' => 'str'),
		'en_epithete_espece'	=> array('type' => 'no', 'format' => 'str'),
		'en_epithete_infra_specifique'	=> array('type' => 'no', 'format' => 'str'),
		'en_epithete_cultivar'	=> array('type' => 'no', 'format' => 'str'),
		'en_intitule_groupe_cultivar'	=> array('type' => 'no', 'format' => 'str'),
		'en_formule_hybridite'	=> array('type' => 'no', 'format' => 'str'),
		'en_phrase_nom_non_nomme'	=> array('type' => 'no', 'format' => 'str'),
		'en_notes'	=> array('type' => 'no', 'format' => 'str'),
		'en_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'en_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'en_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	protected $table_relations = array(
		'eflore_selection_nom' => array('en_id_nom', 'en_id_version_projet_nom'),
		'eflore_nom_intitule' => array('en_id_nom', 'en_id_version_projet_nom')
		);
		
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet Nom.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return Nom un objet Nom.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEn::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEn::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom '.
						'WHERE en_id_nom = ? AND en_id_version_projet_nom = ? ';
				break;
			case iDaoEn::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(en_id_nom) '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom '.
						'WHERE en_id_version_projet_nom = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			//<!-- INSERTION MANUELLE : DEBUT -->//
			case iDaoEn::CONSULTER_ID_PROJET :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom '.
						'WHERE en_id_version_projet_nom = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEn::CONSULTER_NOM_GROUPE_ID :
				$sql = 	'SELECT * '.
                    	'FROM '.$this->getBddPrincipale().'.eflore_nom '.
						'WHERE en_id_nom IN (!) '.
						'AND en_id_version_projet_nom = ? '.
						'ORDER BY en_nom_supra_generique, en_nom_genre, en_epithete_infra_generique, en_epithete_espece, en_epithete_infra_specifique ASC ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			//<!-- INSERTION MANUELLE : FIN -->//
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, Nom::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Nom.
	* 
	* @param Nom l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(Nom $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEn::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Nom.
	* 
	* @param Nom l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(Nom $obj)
	{
		return parent::supprimer($obj, iDaoEn::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Nom.
	* 
	* @param Nom l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(Nom $obj)
	{
		return parent::modifier($obj, iDaoEn::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.4  2007-06-29 07:54:15  jp_milcent
* Ajout de relations.
*
* Revision 1.3  2007-06-27 17:08:12  jp_milcent
* Mise en place de la gestion des relations entre table.
*
* Revision 1.2  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.1  2006-07-20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>