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
// CVS : $Id: effi_permalien.action.php,v 1.14 2007-06-19 10:32:57 jp_milcent Exp $
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
*@version       $Revision: 1.14 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionPermalien extends aAction {
	
	/*** Méthodes : ***/
	
	public function executer()
	{
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();
		$dao_n = new NomDeprecieDao();
		//$dao_n->setDebogage(EF_DEBOG_SQL);
		$dao_sn = new SelectionNomDao();
		//$dao_sn->setDebogage(EF_DEBOG_SQL);
		
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur la version et le projet courant
		$tab_retour['pr_abreviation'] = $_SESSION['cpr'];
		$tab_retour['pr_intitule'] = $_SESSION['ipr'];
		$tab_retour['prv_code'] = $_SESSION['cprv'];
		if (isset($_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']])) {
			$tab_retour['nom_retenu_famille'] = $_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']];
		}

		// +------------------------------------------------------------------------------------------------------+
		// Intégration du moteur de recherche par nom latin		
		$tab_retour['titre_general_referentiel'] = $_SESSION['cpr'].' v'.$_SESSION['cprv'];
		$une_recherche = new EfRecherche();
		$une_recherche->setFormat($this->getRegistre()->get(EF_LG_URL_FORMAT));
		// Création Formulaire recherche nomenclaturale
		$tab_retour['un_form_nom'] = $une_recherche->executer('form_nom');

		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur le taxon courrant et le nom sélectionné
		$tab_retour['nom_retenu'] = $_SESSION['NomRetenu'];
		$tab_retour['nom_retenu_simple'] = $_SESSION['NomRetenu']->formaterNom(EF_NOM_FORMAT_SIMPLE);
		$tab_retour['nom_selection'] = $_SESSION['NomSelection'];

		$tab_retour['permalien_nn_bool'] = false;
		$tab_retour['permalien_nn_info'] = 'Ce nom est généré dynamiquement et n\'est pas géré par ce référentiel !';
		$tab_retour['permalien_nt_bool'] = false;
		$tab_retour['permalien_nt_info'] = 'Ce taxon est généré dynamiquement et n\'est pas géré par ce référentiel !';
		// Nom sélectionné
		if (!$this->getRegistre()->get('nn_virtuel_depart') || $_SESSION['nn'] < $this->getRegistre()->get('nn_virtuel_depart')) {
			$tab_retour['permalien_nn_bool'] = true;
			
			$permalien_nn = clone $GLOBALS['_EFLORE_']['url_permalien'];
			$permalien_nn->setType('nn');
			$permalien_nn->setProjetCode($tab_retour['pr_abreviation']);
			$permalien_nn->setVersionCode($tab_retour['prv_code']);
			$permalien_nn->setTypeId($_SESSION['nn']);
			if (EF_PRV_DERNIERE_VERSION_BDNFF_ID == $_SESSION['nvpn']) {
				$tab_retour['url_permalien_nn_prv'] = $permalien_nn->getUrlReferentielDefaut();
			} else {
				$tab_retour['url_permalien_nn_prv'] = $permalien_nn->getUrl();
			}
			$tab_retour['url_permalien_nn_prv_defaut'] = $permalien_nn->getUrlDefaut();
		}
		
		// Taxon
		if (!$this->getRegistre()->get('nt_virtuel_depart') || $_SESSION['nt'] < $this->getRegistre()->get('nt_virtuel_depart')) {
			$tab_retour['permalien_nt_bool'] = true;
	
			$permalien_nt = clone $GLOBALS['_EFLORE_']['url_permalien'];
			$permalien_nt->setType('nt');
			$permalien_nt->setProjetCode($tab_retour['pr_abreviation']);
			$permalien_nt->setVersionCode($tab_retour['prv_code']);
			$permalien_nt->setTypeId($_SESSION['nt']);
			if (EF_PRV_DERNIERE_VERSION_BDNFF_ID == $_SESSION['nvp']) {
				$tab_retour['url_permalien_nt_prv'] = $permalien_nt->getUrlReferentielDefaut();
			} else {
				$tab_retour['url_permalien_nt_prv'] = $permalien_nt->getUrl();
			}
			$tab_retour['url_permalien_nt_prv_defaut'] = $permalien_nt->getUrlDefaut();
		}

		return $tab_retour;
	}// Fin méthode executer()
	
}// Fin classe ActionSynonymie()

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_permalien.action.php,v $
* Revision 1.14  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.13  2007-01-24 17:34:13  jp_milcent
* Ajout du format de rendu pour le moteur de recherche.
*
* Revision 1.12  2007/01/18 17:45:42  jp_milcent
* Fusion avec la livraison Moquin-Tandon : corrections bogue des sessions.
*
* Revision 1.11.2.1  2007/01/18 10:48:30  jp_milcent
* La classe étend aAction pour utiliser le Registre.
*
* Revision 1.11  2007/01/17 17:03:51  jp_milcent
* Modification de la gestion des noms et taxons virtuels des projets.
*
* Revision 1.10  2007/01/12 16:20:17  jp_milcent
* Correction bogue : les permaliens étaient affichées sous forme courte pour les projets autres que BDNFF.
*
* Revision 1.9  2006/12/22 16:50:43  jp_milcent
* Amélioration de la gestion des permaliens : nous tenons comptes des taxons non géré par les référentiels.
*
* Revision 1.8  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.7  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.6  2006/04/25 16:22:24  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des données txt liées au nom sélectionné.
*
* Revision 1.5  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.4  2005/11/24 16:23:26  jp_milcent
* Correction des permaliens suite à discussion.
*
* Revision 1.3  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.2  2005/10/20 16:37:49  jp_milcent
* Amélioration de l'onglet Synthèse.
*
* Revision 1.1  2005/10/19 16:46:48  jp_milcent
* Correction de bogue liés à la modification des urls.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>