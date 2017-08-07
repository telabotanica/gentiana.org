<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
// |                                                                                                      |
// | eflore_bp is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_bp is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: EfloreNaturaliste.class.php,v 1.3 2007-06-29 16:23:31 jp_milcent Exp $
/**
* eflore_bp - EfloreNaturaliste.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.3 $ $Date: 2007-06-29 16:23:31 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreNaturaliste extends aEfloreModule {

	public function consulterIntitulesAbreviations($liste_intitules_abreges_id)
	{
		$type = iDaoEnaia::CONSULTER_INTITULE_GROUPE_ID;
		$DaoNaInAb = $this->dao->getNaturalisteIntituleAbreviationDao();
		$tab_intitules_sortie = array();
		$param = array(implode(',', $liste_intitules_abreges_id));
		$tab_naia = $DaoNaInAb->consulter($type, $param);
		foreach($tab_naia as $NaturalisteIntituleAbreviation) {
			$tab_intitules_sortie[$NaturalisteIntituleAbreviation->getId('intitule_naturaliste_abrege')] = $NaturalisteIntituleAbreviation->getTableauAttributs();
		}
		return $tab_intitules_sortie;
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreNaturaliste.class.php,v $
* Revision 1.3  2007-06-29 16:23:31  jp_milcent
* Ajout de la gestion du wrapper SQL. Mise en classe abstraite de EfloreModule.
*
* Revision 1.2  2007-06-25 16:37:06  jp_milcent
* Suppression du saut de ligne en fin de fichier.
*
* Revision 1.1  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>