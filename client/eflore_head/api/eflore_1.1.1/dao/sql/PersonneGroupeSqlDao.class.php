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
* Classe DAO SQL PersonneGroupe
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
class PersonneGroupeSqlDao extends aDaoSqlEflore implements iDaoEpg {
	/*** Attributes : ***/
	private $table_nom = 'eflore_personne_groupe';
	private $table_prefixe = 'epg_';
	protected $table_cle = array('groupe');
	private $table_champs = array(
		'epg_id_groupe'	=> array('type' => 'id', 'format' => 'int'),
		'epg_intitule_groupe'	=> array('type' => 'no', 'format' => 'str'),
		'epg_courriel_groupe'	=> array('type' => 'no', 'format' => 'str'),
		'epg_notes_groupe'	=> array('type' => 'no', 'format' => 'str'),
		'epg_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'epg_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'epg_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** M�thodes : ***/
	
	/**
	* Retourne un objet PersonneGroupe.
	* 
	* @param integer l'identifiant de la commande de consultation � ex�cuter.
	* @param array le tableau de param�tres � passer � l'ex�cutant de la commande.
	* @return PersonneGroupe un objet PersonneGroupe.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEpg::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_personne_groupe';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEpg::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_personne_groupe '.
						'WHERE epg_id_groupe = ? ';
				break;
			case iDaoEpg::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(epg_id_groupe) '.
						'FROM '.$this->getBddPrincipale().'.eflore_personne_groupe ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, PersonneGroupe::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Personne Groupe.
	* 
	* @param PersonneGroupe l'objet contenant les valeurs � ajouter.
	* @param string nom de la base de donn�e o� r�aliser l'insertion.
	* @return mixed l'identifiant de la ligne ajout�e ou false.
	*/
	public function ajouter(PersonneGroupe $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEpg::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Personne Groupe.
	* 
	* @param PersonneGroupe l'objet contenant les identifiants de la ligne � supprimer.
	* @return boolean true si la ligne est bien supprim�, sinon false.
	*/
	public function supprimer(PersonneGroupe $obj)
	{
		return parent::supprimer($obj, iDaoEpg::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Personne Groupe.
	* 
	* @param PersonneGroupe l'objet contenant les valeurs � modifier.
	* @return boolean true si la ligne est bien modifi�, sinon false.
	*/
	public function modifier(PersonneGroupe $obj)
	{
		return parent::modifier($obj, iDaoEpg::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2006-07-20 16:53:24  jp_milcent
* Correction requete sql MAX.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes g�n�r�es automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>