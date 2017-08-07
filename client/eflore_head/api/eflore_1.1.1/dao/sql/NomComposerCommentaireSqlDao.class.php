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
* Classe DAO SQL NomComposerCommentaire
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
class NomComposerCommentaireSqlDao extends aDaoSqlEflore implements iDaoEncc {
	/*** Attributes : ***/
	private $table_nom = 'eflore_nom_composer_commentaire';
	private $table_prefixe = 'encc_';
	protected $table_cle = array('intitule_cn', 'categorie_cn', 'valeur_cn', 'numero_ordre_cn');
	private $table_champs = array(
		'encc_id_intitule_cn'	=> array('type' => 'id', 'format' => 'int'),
		'encc_id_categorie_cn'	=> array('type' => 'id', 'format' => 'int'),
		'encc_id_valeur_cn'	=> array('type' => 'id', 'format' => 'int'),
		'encc_id_numero_ordre_cn'	=> array('type' => 'id', 'format' => 'int'),
		'encc_ce_auteur'	=> array('type' => 'ce', 'format' => 'int'),
		'encc_ce_citation_biblio'	=> array('type' => 'ce', 'format' => 'int'),
		'encc_mark_in_auteur_citation'	=> array('type' => 'no', 'format' => 'str'),
		'encc_date_homonyme'	=> array('type' => 'no', 'format' => 'str'),
		'encc_complement'	=> array('type' => 'no', 'format' => 'str'),
		'encc_notes_avoir_cn'	=> array('type' => 'no', 'format' => 'str')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** M�thodes : ***/
	
	/**
	* Retourne un objet NomComposerCommentaire.
	* 
	* @param integer l'identifiant de la commande de consultation � ex�cuter.
	* @param array le tableau de param�tres � passer � l'ex�cutant de la commande.
	* @return NomComposerCommentaire un objet NomComposerCommentaire.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEncc::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_composer_commentaire';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEncc::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_composer_commentaire '.
						'WHERE encc_id_intitule_cn = ? AND encc_id_categorie_cn = ? AND encc_id_valeur_cn = ? AND encc_id_numero_ordre_cn = ? ';
				break;
			case iDaoEncc::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(encc_id_intitule_cn) '.
						'FROM '.$this->getBddPrincipale().'.eflore_nom_composer_commentaire '.
						'WHERE encc_id_categorie_cn = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, NomComposerCommentaire::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Nom Composer Commentaire.
	* 
	* @param NomComposerCommentaire l'objet contenant les valeurs � ajouter.
	* @param string nom de la base de donn�e o� r�aliser l'insertion.
	* @return mixed l'identifiant de la ligne ajout�e ou false.
	*/
	public function ajouter(NomComposerCommentaire $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEncc::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Nom Composer Commentaire.
	* 
	* @param NomComposerCommentaire l'objet contenant les identifiants de la ligne � supprimer.
	* @return boolean true si la ligne est bien supprim�, sinon false.
	*/
	public function supprimer(NomComposerCommentaire $obj)
	{
		return parent::supprimer($obj, iDaoEncc::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Nom Composer Commentaire.
	* 
	* @param NomComposerCommentaire l'objet contenant les valeurs � modifier.
	* @return boolean true si la ligne est bien modifi�, sinon false.
	*/
	public function modifier(NomComposerCommentaire $obj)
	{
		return parent::modifier($obj, iDaoEncc::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.1  2006-07-20 16:11:05  jp_milcent
* Ajout des classes g�n�r�es automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>