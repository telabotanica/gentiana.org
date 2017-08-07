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
* Classe DAO SQL Naturaliste
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
class NaturalisteSqlDao extends aDaoSqlEflore implements iDaoEna {
	/*** Attributes : ***/
	private $table_nom = 'eflore_naturaliste';
	private $table_prefixe = 'ena_';
	protected $table_cle = array('naturaliste');
	private $table_champs = array(
		'ena_id_naturaliste'	=> array('type' => 'id', 'format' => 'int'),
		'ena_lieu_naissance'	=> array('type' => 'no', 'format' => 'str'),
		'ena_date_naissance'	=> array('type' => 'no', 'format' => 'str'),
		'ena_lieu_deces'	=> array('type' => 'no', 'format' => 'str'),
		'ena_date_deces'	=> array('type' => 'no', 'format' => 'str'),
		'ena_date_publication'	=> array('type' => 'no', 'format' => 'str'),
		'ena_notes_naturaliste'	=> array('type' => 'no', 'format' => 'str'),
		'ena_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ena_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ena_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** M�thodes : ***/
	
	/**
	* Retourne un objet Naturaliste.
	* 
	* @param integer l'identifiant de la commande de consultation � ex�cuter.
	* @param array le tableau de param�tres � passer � l'ex�cutant de la commande.
	* @return Naturaliste un objet Naturaliste.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEna::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_naturaliste';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEna::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_naturaliste '.
						'WHERE ena_id_naturaliste = ? ';
				break;
			case iDaoEna::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ena_id_naturaliste) '.
						'FROM '.$this->getBddPrincipale().'.eflore_naturaliste ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, Naturaliste::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Naturaliste.
	* 
	* @param Naturaliste l'objet contenant les valeurs � ajouter.
	* @param string nom de la base de donn�e o� r�aliser l'insertion.
	* @return mixed l'identifiant de la ligne ajout�e ou false.
	*/
	public function ajouter(Naturaliste $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEna::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Naturaliste.
	* 
	* @param Naturaliste l'objet contenant les identifiants de la ligne � supprimer.
	* @return boolean true si la ligne est bien supprim�, sinon false.
	*/
	public function supprimer(Naturaliste $obj)
	{
		return parent::supprimer($obj, iDaoEna::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Naturaliste.
	* 
	* @param Naturaliste l'objet contenant les valeurs � modifier.
	* @return boolean true si la ligne est bien modifi�, sinon false.
	*/
	public function modifier(Naturaliste $obj)
	{
		return parent::modifier($obj, iDaoEna::CONSULTER_ID);
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