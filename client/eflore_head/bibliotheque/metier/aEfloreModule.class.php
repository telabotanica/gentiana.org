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
// CVS : $Id: aEfloreModule.class.php,v 1.7 2007-08-30 19:13:26 jp_milcent Exp $
/**
* eflore_bp - EfloreModule.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.7 $ $Date: 2007-08-30 19:13:26 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

abstract class aEfloreModule {
	
	protected $dao;
	protected $WrapperSql;
	protected $limit_debut;
	protected $limit_nbre;
	
	public function __construct()
	{
		// Gestion de l'API (à remplacer par le wrapper!)
		$GLOBALS['_EFLORE_']['api']['ok'] = true;
		$GLOBALS['_EFLORE_']['api']['version'] = '1.1.1';
		$this->dao = aFabriqueDao::getDAOFabrique(aFabriqueDao::SQL, EF_DSN_PRINCIPAL);
		$this->dao->setHistorisation(false);
		$this->dao->setFichierSqlMark(false);
		$this->dao->setStockagePrincipal(EF_BDD_NOM_PRINCIPALE);
		$this->dao->setStockageHistorique(EF_BDD_NOM_HISTORIQUE);
		//$this->dao->setDebogage(EF_DEBOG_SQL);

		// Gestion du wrapper
		$this->WrapperSql = new EfloreAdaptateurSql(EF_DSN_PRINCIPAL);
		$this->WrapperSql->setHistorisation(false);
		$this->WrapperSql->setFichierSqlMark(false);
		$this->WrapperSql->setStockagePrincipal(EF_BDD_NOM_PRINCIPALE);
		$this->WrapperSql->setStockageHistorique(EF_BDD_NOM_HISTORIQUE);
		//$WrapperSql->setDebogage(true);
	}
	
	public function getWrapperSql()
	{
		return $this->WrapperSql;
	}
	
	public function executerSql($sql)
	{
		return $this->WrapperSql->executer($sql);
	}
	
	public function setDebogage($bool)
	{
		// Gestion de l'API (à remplacer par le wrapper!)
		if ($bool) {
			$this->dao->setDebogage(EF_DEBOG_SQL);
		}
		
		// Gestion du wrapper
		$this->WrapperSql->setDebogage($bool);
	}
	
	public function setLimit($nbre, $debut = 0)
	{
		$this->limit_debut = $debut;
		$this->limit_nbre = $nbre;
		
		// Gestion de l'API (à remplacer par le wrapper!)
		$this->dao->setLimitBool(true);
		$this->dao->setLimitDebut($this->limit_debut);
		$this->dao->setLimitNbre($this->limit_nbre);
		
		// Gestion du wrapper
		$this->WrapperSql->setLimitBool(true);
		$this->WrapperSql->setLimitDebut($this->limit_debut);
		$this->WrapperSql->setLimitNbre($this->limit_nbre);
	}

	/**
	* Échappe une chaine en accord avec le standard courrant des SGBD
	*
	* @param string $str la chaine à échapper.
	*
	* @return string la chaine échappée.
	*
	*/
	protected function echapperQuote($str)
	{
		if (is_null($str)) {
			return null;
		} else {
			return str_replace("'", "''", $str);
		}
	}
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: aEfloreModule.class.php,v $
* Revision 1.7  2007-08-30 19:13:26  jp_milcent
* L'échappement des quotes renvoie une valeur null si une valeur nulle lui est fourni.
*
* Revision 1.6  2007-08-23 07:59:07  jp_milcent
* Ajout d'une valeur par défaut pour le parametre debut de setLimit.
*
* Revision 1.5  2007-08-05 22:37:00  jp_milcent
* Ajout d'une méthode pour échaper les quotes des chaines de caractères à passer dans le SGBD.
*
* Revision 1.4  2007-07-05 19:08:39  jp_milcent
* Ajout d'une méthode permettant de récupérer le wrapper sql.
*
* Revision 1.3  2007-06-29 16:58:42  jp_milcent
* Test du débogage.
*
* Revision 1.2  2007-06-29 16:24:41  jp_milcent
* La classe devient abstraite.
*
* Revision 1.1  2007-06-29 16:23:31  jp_milcent
* Ajout de la gestion du wrapper SQL. Mise en classe abstraite de EfloreModule.
*
* Revision 1.5  2007-06-27 17:07:01  jp_milcent
* Ajout du controle des limites des requetes.
*
* Revision 1.4  2007-06-25 16:37:06  jp_milcent
* Suppression du saut de ligne en fin de fichier.
*
* Revision 1.3  2007-06-21 17:42:49  jp_milcent
* Ajout de méthodes mais nécessite de les uniformiser...
*
* Revision 1.2  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.1  2007-06-11 12:47:50  jp_milcent
* Début gestion de l'application Chorologie et ajout de modification suite à travail pour Gentiana.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>