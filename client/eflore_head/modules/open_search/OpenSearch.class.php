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
// CVS : $Id: OpenSearch.class.php,v 1.2 2007-02-12 14:53:44 jp_milcent Exp $
/**
* eflore_bp - OpenSearch.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.2 $ $Date: 2007-02-12 14:53:44 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class OpenSearch extends aModule {
	private $nvp = '';
	private $cprv = '';
	private $cpr = '';
	
	public function recupererInfo()
	{
		if (isset($_GET['cpr']) && isset($_GET['cprv'])) {
			$dao_pr = new ProjetDao;
			//$dao_pr->setDebogage(EF_DEBOG_SQL);
			$dao_prv = new ProjetVersionDao;
			//$dao_prv->setDebogage(EF_DEBOG_SQL);
			$this->cpr = $_GET['cpr'];
			$tab_pr = $dao_pr->consulter( EF_CONSULTER_PR_ABBR, array($_GET['cpr']) );
			$un_projet = $tab_pr[0];
			$_SESSION['npr'] = $un_projet->getId('projet');
			$tab_prv = $dao_prv->consulter( EF_CONSULTER_PRV_DERNIERE_VERSION, array((int)$_SESSION['npr']) );
			$une_version = $tab_prv[0];
			$this->cprv = $une_version->getCode();
			$this->nvp = $une_version->getId('version');
		} else {
			// Récupération des infos sur le projet
			$dao_pr = new ProjetDao;
			//$dao_pr->setDebogage(EF_DEBOG_SQL);
			$dao_prv = new ProjetVersionDao;
			//$dao_prv->setDebogage(EF_DEBOG_SQL);
			$Registre = Registre::getInstance();
			if (isset($_GET['nvp'])) {
				$this->nvp = $_GET['nvp'];
			} else if ($Registre->get('applette_parametre')) {
				$aso_param = $Registre->get('applette_parametre');
				$this->nvp = $aso_param['nvp'];
			}
			$tab_prv = $dao_prv->consulter( EF_CONSULTER_PRV_ID, array((int)$this->nvp) );
			$une_version = $tab_prv[0];
			$this->cprv = $une_version->getCode();
			$tab_pr = $dao_pr->consulter( EF_CONSULTER_PR_ID, array($une_version->getCe('projet')) );
			$un_projet = $tab_pr[0];
			$this->cpr = $un_projet->getAbreviation();
		}
	}
	public static function getAppletteBalise()
    {
    	return '\{\{OpenSearch(?:\s*(?:(action="[^"]+")|(nvp="[^"]+")|))+\s*\}\}';
    }
    
    // La méthode executer est appellé par défaut 
    public function executer()
    {
    	$this->recupererInfo();

    	$Registre = Registre::getInstance();
		$Registre->set('squelette_moteur', aModule::TPL_PHP);
		$Registre->set('squelette_fichier', 'nom_latin');
		
		// Format de sortie positionne : affichage automatique
		$Registre->set(EF_LG_URL_FORMAT, aModule::SORTIE_XML);
		
		$aso_donnees = array();
		$aso_donnees['projet'] = $this->cpr.' v'.$this->cprv;
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		$url->addQueryString('module', 'recherche');
		$url->addQueryString('action', 'recherche_nom');
		$url->addQueryString('nvp', $this->nvp);
		$url->addQueryString('eflore_nom', '{searchTerms}', true);
		$aso_donnees['url_recherche'] = $url->getUrl();
		
		$url_suggestion = clone $GLOBALS['_EFLORE_']['url_base'];
		$url_suggestion->addQueryString('module', 'recherche');
		$url_suggestion->addQueryString('action', 'completion_nom_latin');
		$url_suggestion->addQueryString('referentiel', $this->nvp);
		$url_suggestion->addQueryString('nom', '{searchTerms}', true);
		$url_suggestion->addQueryString('format', 'json', true);
		$aso_donnees['url_suggestion'] = $url_suggestion->getUrl();
		
		$Registre->set('squelette_donnees', $aso_donnees);
    }

    // "Url" est le nom de l'action passé en paramêtre
    public function executerUrl()
    {
    	$this->recupererInfo();

    	$Registre = Registre::getInstance();
    	//echo '<pre>'.print_r($GLOBALS['_EFLORE_']['info_applette'], true).'</pre>';
		$Registre->set('squelette_moteur', aModule::TPL_PHP);
		$Registre->set('squelette_fichier', 'url');
		
		// Format de sortie positionne : affichage automatique
		$Registre->set(EF_LG_URL_FORMAT, aModule::SORTIE_HTML);
		
		$aso_donnees = array();
		$url_base = $GLOBALS['_EFLORE_']['url_permalien'];
		$aso_donnees['url_base'] = $url_base->getUrl();
		$url = $GLOBALS['_EFLORE_']['url_permalien'];
		$url->setProjetCode($this->cpr);
		$url->setVersionCode($this->cprv);
		$url->setPage('opensearch');
		$aso_donnees['url'] = $url->getUrl();
		
		$aso_donnees['referentiel'] = $this->cpr.' v'.$this->cprv;
		$aso_donnees['chemin_squelette'] = $Registre->get('chemin_module_squelette_relatif');
		$Registre->set('squelette_donnees', $aso_donnees);
    }
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: OpenSearch.class.php,v $
* Revision 1.2  2007-02-12 14:53:44  jp_milcent
* Correction gestion des urls des images.
*
* Revision 1.1  2007/02/10 17:29:28  jp_milcent
* Changement de nom des modules pour gérer les tirets.
*
* Revision 1.1  2007/01/24 16:10:59  jp_milcent
* Ajout du module OpenSearch.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
