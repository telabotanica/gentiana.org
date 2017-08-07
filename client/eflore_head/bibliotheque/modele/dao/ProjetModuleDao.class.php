<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of project_name.                                                                |
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
// CVS : $Id: ProjetModuleDao.class.php,v 1.2 2005-08-05 15:13:35 jp_milcent Exp $
/**
* project_name
*
* 
*
*@package project_name
*@subpackage 
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.2 $ $Date: 2005-08-05 15:13:35 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

/**
 * class ProjetModuleDao
 */
class ProjetModuleDao extends AModeleDao
{
	/*** Atributs : ***/
	
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->nom_type_info = 'ProjetModule';
		parent::__construct();
	}
	
	/*** Accesseur : ***/
	
	/*** Méthodes : ***/
	
	public function consulter($type = NULL, $param = array()) {
		switch($type) {
			case EF_CONSULTER_MODULE_VERSION :
				$sql = 	'SELECT DISTINCT module.* ' .
							'FROM eflore_projet_module AS module, eflore_projet_utiliser_module AS utiliser ' .
							'WHERE eprum_id_version = ? ' .
							'AND eprum_id_module = eprm_id_module';
				break;
		}
		$this->setRequete($sql);
		return parent::consulter($param);
	}
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ProjetModuleDao.class.php,v $
* Revision 1.2  2005-08-05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
* Revision 1.1  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>