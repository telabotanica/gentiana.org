<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
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
// CVS : $Id: EfloreInfoTxt.class.php,v 1.2 2007-06-25 16:37:06 jp_milcent Exp $
/**
* eflore_bp - EfloreInfoTxt.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.2 $ $Date: 2007-06-25 16:37:06 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreInfoTxt {
	
	static public function ajouterInfoTxt($aso_txt, $projet_id)
	{
		$tab_retour = array();
		$GLOBALS['_EFLORE_']['api']['ok'] = true;
		$GLOBALS['_EFLORE_']['api']['version'] = '1.1.1';
		$Dao = aFabriqueDao::getDAOFabrique(aFabriqueDao::SQL, EF_DSN_PRINCIPAL);
		$Dao->setHistorisation(false);
		$Dao->setStockageHistorique(EF_BDD_NOM_HISTORIQUE);
		$Dao->setStockagePrincipal(EF_BDD_NOM_PRINCIPALE);
		//$Dao->setDebogage(EF_DEBOG_SQL);
		
		$DaoInfoTxt = $Dao->getInfoTxtDao();
		
		$InfoTxt = new InfoTxt();
		$InfoTxt->setId($projet_id, 'version_projet_txt');
		if (isset($aso_txt['titre'])) {
			$InfoTxt->setTitre($aso_txt['titre']);
		}
		if (isset($aso_txt['texte'])) {
			$InfoTxt->setContenuTexte($aso_txt['texte']);
		}
		if (isset($aso_txt['resumer'])) {
			$InfoTxt->setResumer($aso_txt['resumer']);
		}
		if (isset($aso_txt['auteur_autre'])) {
			$InfoTxt->setAutreAuteur($aso_txt['auteur_autre']);
		}
		if (isset($aso_txt['url'])) {
			$InfoTxt->setLienVersTxt($aso_txt['url']);
		}
		$InfoTxt->setDateDerniereModif(date('Y-m-j H:i:s', time()));
		if (isset($aso_txt['modifier_par'])) {
			$InfoTxt->setCe($aso_txt['modifier_par'], 'modifier_par');
		} else {
			$InfoTxt->setCe(3, 'modifier_par');
		}
		$InfoTxt->setCe(3, 'etat');
		
		$DaoInfoTxt->ajouter($InfoTxt);
	}
	
	static public function consulterInfoTxt($id, $projet_id)
	{
		$tab_retour = array();
		$GLOBALS['_EFLORE_']['api']['ok'] = true;
		$GLOBALS['_EFLORE_']['api']['version'] = '1.1.1';
		$Dao = aFabriqueDao::getDAOFabrique(aFabriqueDao::SQL, EF_DSN_PRINCIPAL);
		$Dao->setHistorisation(false);
		$Dao->setStockageHistorique(EF_BDD_NOM_HISTORIQUE);
		$Dao->setStockagePrincipal(EF_BDD_NOM_PRINCIPALE);
		//$Dao->setDebogage(EF_DEBOG_SQL);
		
		$DaoInfoTxt = $Dao->getInfoTxtDao();
		$InfoTxt = $DaoInfoTxt->consulter(iDaoEit::CONSULTER_ID, array((int)$id, (int)$projet_id));
		return $InfoTxt;
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreInfoTxt.class.php,v $
* Revision 1.2  2007-06-25 16:37:06  jp_milcent
* Suppression du saut de ligne en fin de fichier.
*
* Revision 1.1  2007-02-07 11:03:57  jp_milcent
* Début utilisation de l'API pour l'ajout d'info Txt.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>