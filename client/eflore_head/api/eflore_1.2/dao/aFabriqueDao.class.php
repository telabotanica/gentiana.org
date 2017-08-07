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
* Classe aFabriqueDao
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
abstract class aFabriqueDao {

	/*** Attributs : ***/
	// Liste des type de DAO supportés par la fabrique
	const SQL = 'sql';
	const XML = 'xml';
	const TXT = 'txt';

	public static function getDAOFabrique ( $type_fabrique, $connecteur = null)
	{
		switch ($type_fabrique) {
			case self::SQL : 
          		return new FabriqueDaoSql($connecteur);
			case self::XML : 
				return new FabriqueDaoXml($connecteur);
			case self::TXT : 
				return new FabriqueDaoTxt($connecteur);
			default : 
				return null;
		}
	}

	// Il doit y avoir une méthode pour chaque DAO qui doit être créé. 
	// Toutes les Fabriques concrètes (SQL, XML...) doivent implémenter ces méthodes.
	
	abstract public function getNaturalisteDao();
	
	abstract public function getNaturalisteASpecialiteGeoDao();
	
	abstract public function getNaturalisteAbreviationDao();
	
	abstract public function getNaturalisteAbreviationRelationDao();
	
	abstract public function getNaturalisteComposerIntituleAbreviationDao();
	
	abstract public function getNaturalisteComposerIntituleNomDao();
	
	abstract public function getNaturalisteNomDao();
	
	abstract public function getNaturalisteNomAReferenceDao();
	
	abstract public function getNaturalisteNomRelationDao();
	
	abstract public function getNaturalisteRelationDao();
	
	abstract public function getNaturalisteValeurDao();

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