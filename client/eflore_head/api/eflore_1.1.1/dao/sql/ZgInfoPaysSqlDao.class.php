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
* Classe DAO SQL ZgInfoPays
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
class ZgInfoPaysSqlDao extends aDaoSqlEflore implements iDaoEzip {
	/*** Attributes : ***/
	private $table_nom = 'eflore_zg_info_pays';
	private $table_prefixe = 'ezip_';
	protected $table_cle = array('zone_geo', 'projet_zg');
	private $table_champs = array(
		'ezip_id_zone_geo'	=> array('type' => 'id', 'format' => 'int'),
		'ezip_id_projet_zg'	=> array('type' => 'id', 'format' => 'int'),
		'ezip_capitale'	=> array('type' => 'no', 'format' => 'str'),
		'ezip_annee_independance'	=> array('type' => 'no', 'format' => 'str'),
		'ezip_notes'	=> array('type' => 'no', 'format' => 'str'),
		'ezip_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ezip_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ezip_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet ZgInfoPays.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return ZgInfoPays un objet ZgInfoPays.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEzip::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg_info_pays';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEzip::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg_info_pays '.
						'WHERE ezip_id_zone_geo = ? AND ezip_id_projet_zg = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEzip::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ezip_id_zone_geo) '.
						'FROM '.$this->getBddPrincipale().'.eflore_zg_info_pays '.
						'WHERE ezip_id_projet_zg = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.' inconnue!';
				$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, ZgInfoPays::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Zg Info Pays.
	* 
	* @param ZgInfoPays l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(ZgInfoPays $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEzip::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Zg Info Pays.
	* 
	* @param ZgInfoPays l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(ZgInfoPays $obj)
	{
		return parent::supprimer($obj, iDaoEzip::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Zg Info Pays.
	* 
	* @param ZgInfoPays l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(ZgInfoPays $obj)
	{
		return parent::modifier($obj, iDaoEzip::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.3  2007-02-09 16:27:54  jp_milcent
* Mise à jour vers la version 1.2 des classes DAO SQL du module zg.
*
* Revision 1.2  2006/12/21 17:23:24  jp_milcent
* Ajout du type de résultat pour la consultation par ID.
* Complétion des requêtes mal générées.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>