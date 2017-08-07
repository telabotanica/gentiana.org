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
* Classe DAO SQL InfoTxt
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
class InfoTxtSqlDao extends aDaoSqlEflore implements iDaoEit {
	/*** Attributes : ***/
	private $table_nom = 'eflore_info_txt';
	private $table_prefixe = 'eit_';
	protected $table_cle = array('texte', 'version_projet_txt');
	private $table_champs = array(
		'eit_id_texte'	=> array('type' => 'id', 'format' => 'int'),
		'eit_id_version_projet_txt'	=> array('type' => 'id', 'format' => 'int'),
		'eit_titre'	=> array('type' => 'no', 'format' => 'str'),
		'eit_resumer'	=> array('type' => 'no', 'format' => 'str'),
		'eit_lien_vers_txt'	=> array('type' => 'no', 'format' => 'str'),
		'eit_nom_fichier'	=> array('type' => 'no', 'format' => 'str'),
		'eit_contenu_texte'	=> array('type' => 'no', 'format' => 'str'),
		'eit_ce_contributeur_txt'	=> array('type' => 'ce', 'format' => 'int'),
		'eit_ce_auteur'	=> array('type' => 'ce', 'format' => 'int'),
		'eit_autre_auteur'	=> array('type' => 'no', 'format' => 'str'),
		'eit_ce_citation_biblio'	=> array('type' => 'ce', 'format' => 'int'),
		'eit_ce_licence'	=> array('type' => 'ce', 'format' => 'int'),
		'eit_ce_version_projet_licence'	=> array('type' => 'ce', 'format' => 'int'),
		'eit_autre_lien_licence'	=> array('type' => 'no', 'format' => 'str'),
		'eit_notes_texte'	=> array('type' => 'no', 'format' => 'str'),
		'eit_date_derniere_modif'	=> array('type' => 'no', 'format' => 'str'),
		'eit_ce_modifier_par'	=> array('type' => 'ce', 'format' => 'int'),
		'eit_ce_etat'	=> array('type' => 'ce', 'format' => 'int')
		);
	
	/*** Constructeur : ***/
	public function __construct($connexion = null)
	{
		return parent::__construct($connexion, $this->table_nom, $this->table_prefixe, $this->table_champs);
	}
	
	/*** Accesseurs : ***/

	
	/*** Méthodes : ***/
	
	/**
	* Retourne un objet InfoTxt.
	* 
	* @param integer l'identifiant de la commande de consultation à exécuter.
	* @param array le tableau de paramêtres à passer à l'exécutant de la commande.
	* @return InfoTxt un objet InfoTxt.
	*/
	public function consulter($cmd, $parametres = array() )
	{
		switch($cmd) {
			case iDaoEit::CONSULTER :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_info_txt';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_MULTIPLE);
				break;
			case iDaoEit::CONSULTER_ID :
				$sql = 	'SELECT * '.
						'FROM '.$this->getBddPrincipale().'.eflore_info_txt '.
						'WHERE eit_id_texte = ? AND eit_id_version_projet_txt = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_OBJET_UNIQUE);
				break;
			case iDaoEit::CONSULTER_ID_MAX :
				$sql = 	'SELECT MAX(eit_id_texte) '.
						'FROM '.$this->getBddPrincipale().'.eflore_info_txt '.
						'WHERE eit_id_version_projet_txt = ? ';
				$this->setResultatType(aDaoSql::RESULTAT_UNIQUE);
				break;
			default :
				$message = 'Commande '.$cmd.'inconnue!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
		}
		$this->setRequete($sql);
		return parent::consulter($parametres, InfoTxt::CLASSE_NOM);
	}
	
	/**
	* Ajoute une ligne :  Info Txt.
	* 
	* @param InfoTxt l'objet contenant les valeurs à ajouter.
	* @param string nom de la base de donnée où réaliser l'insertion.
	* @return mixed l'identifiant de la ligne ajoutée ou false.
	*/
	public function ajouter(InfoTxt $obj, $bdd = null)
	{
		return parent::ajouter($obj, $bdd, iDaoEit::CONSULTER_ID_MAX);
	}

	
	/**
	* Supprime une ligne :  Info Txt.
	* 
	* @param InfoTxt l'objet contenant les identifiants de la ligne à supprimer.
	* @return boolean true si la ligne est bien supprimé, sinon false.
	*/
	public function supprimer(InfoTxt $obj)
	{
		return parent::supprimer($obj, iDaoEit::CONSULTER_ID);
	}
	
	/**
	* Modifie une ligne :  Info Txt.
	* 
	* @param InfoTxt l'objet contenant les valeurs à modifier.
	* @return boolean true si la ligne est bien modifié, sinon false.
	*/
	public function modifier(InfoTxt $obj)
	{
		return parent::modifier($obj, iDaoEit::CONSULTER_ID);
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.4  2007-01-24 16:35:48  jp_milcent
* AJout du type de résultat.
*
* Revision 1.3  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>