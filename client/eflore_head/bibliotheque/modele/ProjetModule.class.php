<?php


/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: ProjetModule.class.php,v 1.2 2005-08-04 15:51:45 jp_milcent Exp $
/**
* eFlore
*
* 
*
*@package eFlore
*@subpackage projet
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.2 $ $Date: 2005-08-04 15:51:45 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

/**
 * class ProjetModule
 */
class ProjetModule extends AModele
{
	/*** Atributs : ***/
	
	private $tables;
	
	/*** Constructeur : ***/
	
	public function __construct( $donnees = array() ) {
				foreach ($donnees as $cle => $val) {
			switch ($cle) {
				case 'eprm_id_module' :
					$this->setId($val);
					unset($donnees['eprm_id_module']);
					break;
			}
		}
		
		parent::__construct($donnees); 
	}
	
	/*** Accesseur : ***/
	
	public function getTables() {
		return $this->tables;
	}
	
	public function setTables( $tables ) {
		$this->tables = $tables;
	}
	
	/*** Méthodes : ***/

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ProjetModule.class.php,v $
* Revision 1.2  2005-08-04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.1  2005/08/01 16:18:39  jp_milcent
* Début gestion résultat de la recherche par nom.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>