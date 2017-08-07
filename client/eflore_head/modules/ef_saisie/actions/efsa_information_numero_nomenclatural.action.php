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
// CVS : $Id: efsa_information_numero_nomenclatural.action.php,v 1.6 2007-06-19 10:32:57 jp_milcent Exp $
/**
* project_name
*
*
*
*@package project_name
*@subpackage
//Auteur original :
*@author        David Delon <dd@clapas.net>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.6 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionInformationNumeroNomenclatural implements iActionAvecCache {

	public function get_identifiant()
	{
			return $_GET['eflore_numero_nomenclatural'];
	}

	public function executer()
	{
		
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();
		
		$dao_sn = new SelectionNomDao();
		$dao_n = new NomDeprecieDao();
		$dao_tr = new TaxonRelationDao;
		
		
		$nns=$_GET['eflore_numero_nomenclatural'];
		$nvp =$GLOBALS['_EFLORE_']['projet_version_defaut'];


		$tab_retour['eflore_numero_taxonomique']='';
		$tab_retour['eflore_numero_nomenclatural_selection']='';
		$tab_retour['eflore_numero_nomenclatural_retenu']='';
		$tab_retour['eflore_nom_retenu']='';
		$tab_retour['eflore_nom']='';
		
		if ($nns!='') {		
			
			$tab_sn = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_NOM_ID, array($nns,$nvp));
			
			$un_sn = $tab_sn[0];		
			
			if (is_object($un_sn)) {
				
				$nt = $un_sn->getId('taxon');
				
				$tab_retour['eflore_numero_taxonomique'] = $nt; 
				$tab_retour['eflore_numero_nomenclatural_selection'] = $nns;
				
		
				// Récupération taxon retenu
				$tab_sn_nt = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_TAXON_ID, array($nt, $nvp));
				foreach($tab_sn_nt as $une_sn) {
					if ($une_sn->getId('version_projet_taxon') == $nvp) {
						if ($une_sn->getCe('statut') == EF_SNS_RETENU) {
							$ma_sn_retenu = clone $une_sn;
						}
					}
				}
				
				$nnr = $ma_sn_retenu->getId('nom');
				
				$tab_retour['eflore_numero_nomenclatural_retenu'] = $nnr;
				
				$tab_nom_retenu = $dao_n->consulter(EF_CONSULTER_NOM_ID, array($nnr,$nvp));
				$le_nom_retenu = $tab_nom_retenu[0];
				$tab_retour['eflore_nom_retenu'] = $le_nom_retenu->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE);
				$rang_nom_selection = $le_nom_retenu->getCe('rang');
				
		
				$tab_nom = $dao_n->consulter(EF_CONSULTER_NOM_ID, array($nns,$nvp));
				$le_nom = $tab_nom[0];
				$tab_retour['eflore_nom'] = $le_nom->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE);
				
						
				// Récupération des infos sur la famille
				$taxon_id = $nt;	
				$tab_classification = array($taxon_id);
		
				do {
					$param = array($taxon_id, $nvp, (int)EF_TC_RELATION_ID, (int)EF_TV_AVOIR_PERE_ID);
					$tab_tr = $dao_tr->consulter(EF_CONSULTER_TR_CATEGORIE_VALEUR_VERSION_ID, $param);
					if (is_object($tab_tr[0])) {
						$taxon_id = $tab_tr[0]->getId('taxon_2');
						if ($taxon_id != 0) {
							$tab_classification[] = $taxon_id;
						}
					} else {
						// Aucune relation "enfant vers père" existante, du coup on arrête.
						$taxon_id = 0;
					}
				} while ($taxon_id != 0);
				
						
				$type = EF_CONSULTER_SN_STATUT_VERSION_TAXON_GROUPE_ID;
				
				$param = array(implode(', ', $tab_classification), $nvp, EF_SNS_RETENU);
				
				$tab_sn_classif = $dao_sn->consulter($type, $param);
				$tab_classif_nom_id = array();
				$tab_classif_taxon_nom = array();
				foreach($tab_sn_classif as $une_sn) {
					$id_vpn = $une_sn->getId('version_projet_nom');
					$tab_classif_taxon_nom[$une_sn->getId('nom')] = $une_sn->getId('taxon');
					$tab_classif_nom_id[] = $une_sn->getId('nom');
				}
				
				$tab_n = $dao_n->consulter(EF_CONSULTER_NOM_GROUPE_ID, array(implode(', ', $tab_classif_nom_id), $id_vpn ));
				$tab_classif_nom = array();
				if ($rang_nom_selection <= EF_RANG_FAMILLE_ID) {
					// Le nom à un rang supérieur ou égal à la famille, nous n'affichons donc pas la famille'
					$tab_retour['eflore_nom_retenu_famille'] = null;
				} else {
					// Le nom à un rang inférieur à la famille, nous affichons le doute
					$tab_retour['eflore_nom_retenu_famille'] = 'Famille ?';
				}
				foreach($tab_n as $un_n) {
					if ($un_n->enrg_id_rang == EF_RANG_FAMILLE_ID) {
						$tab_retour['eflore_nom_retenu_famille'] = $un_n->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE);;
					}
				}
			}			
		}
			
		
		// +------------------------------------------------------------------------------------------------------+
		// Retour des données
		return $tab_retour;

 	}// Fin méthode executer()
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efsa_information_numero_nomenclatural.action.php,v $
* Revision 1.6  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.5  2006-07-07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.4  2006/05/15 19:51:07  ddelon
* parametrage cache
*
* Revision 1.3  2006/05/11 09:43:37  ddelon
* Action cache
*
* Revision 1.2  2006/04/26 16:57:04  ddelon
* Fusion bdnbe + saisie assistee
*
* Revision 1.1.2.3  2006/04/25 14:58:41  ddelon
* controle si pb
*
* Revision 1.1.2.2  2006/04/25 12:49:31  ddelon
* famille
*
* Revision 1.1.2.3  2006/04/21 20:50:27  ddelon
* Saisie continue
*
* Revision 1.1.2.2  2006/04/19 08:03:00  ddelon
* Optimisations completion et petits bugs
*
* Revision 1.1.2.1  2006/04/07 10:50:29  ddelon
* Completion a la google suggest
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>