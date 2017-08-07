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
* Classe DAO SQL LangueArticle
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
class LangueArticleSqlDao extends aDaoSqlEflore implements iDaoEla {
	/*** Attributes : ***/
	private $table_nom = 'eflore_langue_article';
	private $table_prefixe = 'ela_';
	protected $table_cle = array('article');
	private $table_champs = array(
		'ela_id_article'	=> array('type' => 'id', 'format' => 'int'),
		'ela_ce_categorie_genre_nbre'	=> array('type' => 'ce', 'format' => 'int'),
		'ela_ce_valeur_genre_nbre'	=> array('type' => 'ce', 'format' => 'int'),
		'ela_intitule_article'	=> array('type' => 'no', 'format' => 'str'),
		'ela_intitule_charniere'	=> array('type' => 'no', 'format' => 'str'),
		'ela_ce_langue'	=> array('type' => 'ce', 'format' => 'int'),
		'ela_ce_version_projet_langue'	=> array('type' => 'ce', 'format' => 'int'),
		'ela_notes_article'	=> array('type' => 'no', 'format' => 'str'),
		'ela_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'ela_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'ela_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet LangueArticle.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return LangueArticle un objet LangueArticle.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEla::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_langue_article';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEla::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_langue_article '.
						'WHERE ela_id_article = ? ';
				break;
			case iDaoEla::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(ela_id_article) '.
						'FROM '.$this->getBddPrincipale().'.eflore_langue_article ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, LangueArticle::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Langue Article.
	* 
	* @param LangueArticle l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(LangueArticle $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEla::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Langue Article.
	* 
	* @param LangueArticle l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(LangueArticle $obj)
	{
		return parent::supprimer($obj, iDaoEla::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Langue Article.
	* 
	* @param LangueArticle l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(LangueArticle $obj)
	{
		return parent::modifier($obj, iDaoEla::CONSULTER_ID);
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