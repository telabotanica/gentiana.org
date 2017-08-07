<?php
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.2                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2007 Tela Botanica (accueil@tela-botanica.org)                                          |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                         |
// |                                                                                                      |
// | eFlore is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eFlore is distributed in the hope that it will be useful,                                            |
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
* Classe Fabrique DAO SQL : NaturalisteValeur
*
* Description
*
*@package eFlore
*@subpackage dao_sql
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2007
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class FabriqueDaoSql extends aFabriqueDao {
	
	/*** Attributs: ***/
	
	private $connexion;
	private $options;
	
	/*** Constructeurs : ***/
	 
	/**
	* Constructeur du type de données issu de la base de données.
	*
	* @param string le DSN d'accès à la base de données.
	* @param array les tableau des options.
	* @return object
	* @access public
	*/
	public function __construct($dsn, $options)
	{
		// Vérification du type de la variable contenant les options
		if (is_array($options)) {
			$this->options = $options;
		} else {
			$e = "Les options passés à la fabrique de DAO doivent être contenu dans un tableau.";
			trigger_error($e, E_USER_WARNING);
		}
		// Connexion à la base de données
		$connecteur_options = array();
		if (isset($this->options['conecteur_options'])) {
			$connecteur_options = $this->options['conecteur_options'];
		}
		$this->connexion =& DB::connect((string)$dsn, $connecteur_options);
		if (PEAR::isError($this->connexion)) {
			$message = $this->connexion->getMessage()."\n".$this->connexion->getDebugInfo();
			$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message);
			trigger_error($e, E_USER_ERROR);
		}
	}
	
	/*** Méthodes : ***/
	
	
	public function getNaturalisteDao()
	{
		return new NaturalisteSqlDao($this->connexion, $this->options);
	}
	
	public function getNaturalisteASpecialiteGeoDao()
	{
		return new NaturalisteASpecialiteGeoSqlDao($this->connexion, $this->options);
	}
	
	public function getNaturalisteAbreviationDao()
	{
		return new NaturalisteAbreviationSqlDao($this->connexion, $this->options);
	}
	
	public function getNaturalisteAbreviationRelationDao()
	{
		return new NaturalisteAbreviationRelationSqlDao($this->connexion, $this->options);
	}
	
	public function getNaturalisteComposerIntituleAbreviationDao()
	{
		return new NaturalisteComposerIntituleAbreviationSqlDao($this->connexion, $this->options);
	}
	
	public function getNaturalisteComposerIntituleNomDao()
	{
		return new NaturalisteComposerIntituleNomSqlDao($this->connexion, $this->options);
	}
	
	public function getNaturalisteNomDao()
	{
		return new NaturalisteNomSqlDao($this->connexion, $this->options);
	}
	
	public function getNaturalisteNomAReferenceDao()
	{
		return new NaturalisteNomAReferenceSqlDao($this->connexion, $this->options);
	}
	
	public function getNaturalisteNomRelationDao()
	{
		return new NaturalisteNomRelationSqlDao($this->connexion, $this->options);
	}
	
	public function getNaturalisteRelationDao()
	{
		return new NaturalisteRelationSqlDao($this->connexion, $this->options);
	}
	
	public function getNaturalisteValeurDao()
	{
		return new NaturalisteValeurSqlDao($this->connexion, $this->options);
	}
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2007-02-11 19:47:52  jp_milcent
* Début gestion de l'api de la version 1.2 d'eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>