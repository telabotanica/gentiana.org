<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Fiche.                                                                   |
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
// CVS : $Id$
/**
* Fichier d'action du module eFlore-Fiche : Information
*
* Contient des informations au format texte provenant à la fois de la base de données d'eFlore (module Information[txt])
* et de sources extèrieures (API Google, par exemple).
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionInformation extends aAction {
	
	public function executer()
	{
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();
		$dao_tat = new TaxonATxtDao();
		//$dao_tat->setDebogage(EF_DEBOG_SQL);
		$dao_nat = new NomATxtDao();
		//$dao_nat->setDebogage(EF_DEBOG_SQL);
		$dao_it = new InfoTxtDao();
		//$dao_it->setDebogage(EF_DEBOG_SQL);

		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur la version et le projet courant
		$tab_retour['pr_abreviation'] = $_SESSION['cpr'];
		$tab_retour['pr_intitule'] = $_SESSION['ipr'];
		$tab_retour['prv_code'] = $_SESSION['cprv'];
		$tab_retour['nt'] = $_SESSION['nt'];
		$tab_retour['nvp'] = $_SESSION['nvp'];
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Intégration du moteur de recherche par nom latin		
		$une_recherche = new EfRecherche();
		$une_recherche->setFormat($this->getRegistre()->get(EF_LG_URL_FORMAT));
		// Création Formulaire recherche nomenclaturale
		$tab_retour['un_form_nom'] = $une_recherche->executer('form_nom');		

		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur le taxon courrant et le nom sélectionné
		$tab_retour['nom_retenu'] = $_SESSION['NomRetenu'];
		$tab_retour['nom_selection'] = $_SESSION['NomSelection'];
		if (isset($_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']])) {
			$tab_retour['nom_retenu_famille'] = $_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']];
		}
		
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos txt disponibles dans la base de données pour ce taxon
		$type = EF_CONSULTER_TAXON_A_TXT_VERSION_ID;
		$param = array((int)$_SESSION['nt'], (int)$_SESSION['nvp']);
		$tab_tat = $dao_tat->consulter( $type, $param );
		$j = 0;
		//echo '<pre>'.print_r($tab_tat, true).'</pre>';
		foreach ($tab_tat as $TaxonATxt) {
			$type = EF_CONSULTER_INFO_TXT_VERSION_ID;
			$param = array((int)$TaxonATxt->getId('texte'), (int)$TaxonATxt->getId('version_projet_txt'));
			$tab_it = $dao_it->consulter( $type, $param );
			//echo '<pre>'.print_r($tab_it, true).'</pre>';
			foreach ($tab_it as $InfoTxt) {
				$tab_retour['txt_taxon'][$j]['titre'] = $InfoTxt->getTitre();
				// TODO : gérer ici les différents types d'information texte présent dans la base. Pour l'instant "xml".
				$dom = new DOMDocument();
				$dom->loadXML(stripslashes($InfoTxt->getContenuTexte()));
				$dom_liste_info = $dom->getElementsByTagName('info');
				for ($i = 0; $i < $dom_liste_info->length; $i++) {
					$chp = mb_convert_encoding($dom_liste_info->item($i)->getAttribute('type'), 'ISO-8859-15', 'UTF-8');
					$val = mb_convert_encoding($dom_liste_info->item($i)->nodeValue, 'ISO-8859-15', 'UTF-8');
   					$tab_retour['txt_taxon'][$j][$chp] = $val;   
				}
				$j++;
			}
		}
		
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos txt disponibles dans la base de données pour le nom sélectionné
		$type = EF_CONSULTER_NOM_A_TXT_VERSION_ID;
		$param = array((int)$_SESSION['nn'], (int)$_SESSION['nvpn']);
		//echo '<pre>'.print_r($param, true).'</pre>';
		$tab_nat = $dao_nat->consulter( $type, $param );
		$j = 0;
		//echo '<pre>'.print_r($tab_nat, true).'</pre>';
		foreach ($tab_nat as $NomATxt) {
			$type = EF_CONSULTER_INFO_TXT_VERSION_ID;
			$param = array((int)$NomATxt->getId('texte'), (int)$NomATxt->getId('version_projet_txt'));
			$tab_it = $dao_it->consulter( $type, $param );
			//echo '<pre>'.print_r($tab_it, true).'</pre>';
			foreach ($tab_it as $InfoTxt) {
				$tab_retour['txt_nom'][$j]['titre'] = $InfoTxt->getTitre();
				// TODO : gérer ici les différents types d'information texte présent dans la base. Pour l'instant "xml".
				$dom = new DOMDocument();
				//echo '<pre>'.print_r($InfoTxt->getContenuTexte(), true).'</pre>';
				$dom->loadXML(stripslashes($InfoTxt->getContenuTexte()));
				$dom_liste_info = $dom->getElementsByTagName('info');
				for ($i = 0; $i < $dom_liste_info->length; $i++) {
					$chp = mb_convert_encoding($dom_liste_info->item($i)->getAttribute('type'), 'ISO-8859-15', 'UTF-8');
					$val = mb_convert_encoding($dom_liste_info->item($i)->nodeValue, 'ISO-8859-15', 'UTF-8');
   					$tab_retour['txt_nom'][$j][$chp] = $val;   
				}
				$j++;
			}
		}

		// +------------------------------------------------------------------------------------------------------+
		// Retour des données
		return $tab_retour;
	}	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.9  2007-06-11 15:43:27  jp_milcent
* Ajout des variables à passer à l'applette ProtectionInfo.
*
* Revision 1.8  2007-01-24 17:34:13  jp_milcent
* Ajout du format de rendu pour le moteur de recherche.
*
* Revision 1.7  2007/01/17 17:54:27  jp_milcent
* Fusion avec la livraison Passy avant nouvelle livraison.
*
* Revision 1.6  2007/01/16 11:51:27  ddelon
* Stripslashes pour eviter erreur parsing xml (backport passy)
*
* Revision 1.5  2007/01/03 19:45:02  jp_milcent
* Ajout des informations sur les statuts de protection.
*
* Revision 1.4.2.1  2007/01/16 11:45:05  ddelon
* Stripslashes pour eviter erreur parsing xml
*
* Revision 1.4  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.3.2.2  2006/09/06 11:46:36  jp_milcent
* Gestion du code du référentiel pour le titre avant de créer le formulaire de recherche.
* Si on le place après, le référentiel est faux!
*
* Revision 1.3.2.1  2006/09/04 14:21:36  jp_milcent
* Gestion des informations sur le taxon et le nom sélectionné dans l'onglet "Informations".
*
* Revision 1.3  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.2  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.1  2006/04/25 16:22:24  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des données txt liées au nom sélectionné.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>