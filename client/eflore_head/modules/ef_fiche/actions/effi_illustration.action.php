<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: effi_illustration.action.php,v 1.22 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Fichier d'action du module eFlore-Fiche : Illustration
*
* Contient les infos pour l'onglet Illustration.
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.22 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// Inclusion des classes métiers nécessaires
include_once EF_CHEMIN_PEAR.'Services/Yahoo/Search.php';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionIllustration extends aAction {
	
	public function executer()
	{
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();
		$dao_n = new NomDeprecieDao();
		//$dao_n->setDebogage(EF_DEBOG_SQL);
		$dao_sn = new SelectionNomDao();
		//$dao_sn->setDebogage(EF_DEBOG_SQL);
		$dao_prv = new ProjetVersionDao;
		//$dao_prv->setDebogage(EF_DEBOG_SQL);

		// +-----------------------------------------------------------------------------------------------------------+
		// Ajout du code du référentiel
		$tab_retour['titre_general_referentiel'] = $_SESSION['cpr'].' v'.$_SESSION['cprv'];
		// Intégration du moteur de recherche par nom latin		
		$une_recherche = new EfRecherche();
		$une_recherche->setFormat($this->getRegistre()->get(EF_LG_URL_FORMAT));
		// Création Formulaire recherche nomenclaturale
		$tab_retour['un_form_nom'] = $une_recherche->executer('form_nom');

		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur le taxon courrant et le nom sélectionné
		$tab_retour['nom_retenu'] = $_SESSION['NomRetenu'];
		$tab_retour['nom_retenu_simple'] = $_SESSION['NomRetenu']->formaterNom(EF_NOM_FORMAT_SIMPLE);
		$tab_retour['nom_retenu_ultra_simple'] = $_SESSION['NomRetenu']->formaterNom(EF_NOM_FORMAT_ULTRA_SIMPLE);
		$tab_retour['nom_selection'] = $_SESSION['NomSelection'];
		if (isset($_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']])) {
			$tab_retour['nom_retenu_famille'] = $_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']];
		}

		// +------------------------------------------------------------------------------------------------------+		
		// Photoflora
		$tab_retour['photoflora_bool'] = false;
		$tab_retour['photoflora_info'] = 'Photographies indisponibles';
		$tab_prv = $dao_prv->consulter( EF_CONSULTER_PRV_ID, (int)$_SESSION['nvp'] );
		if (EF_PR_BDNFF_ID == $tab_prv[0]->getCe('projet')) {
			$tab_retour['photoflora_url_accueil'] = EF_URL_PHOTOFLORA;
			$tab_retour['photoflora_url_taxon'] = sprintf(EF_URL_PHOTOFLORA_TAXON, $_SESSION['nt']);
			$Illustrations = new EfloreIllustration('photoflora', $_SESSION['cpr'], $_SESSION['cprv'], 'nt', $_SESSION['nt']);
			$tab_retour['photoflora'] = $Illustrations->chercherIllustrationsServiceXml(sprintf(EF_URL_PHOTOFLORA_SERVICE, $_SESSION['nt']));
			foreach ($tab_retour['photoflora'] as $cle => $illustration) {
				if (preg_match(EF_URL_PHOTOFLORA_REGEXP, $illustration['about'], $match)) {
					$abreviation = $match[1];
					$fichier = $match[2];
					$tab_retour['photoflora'][$cle]['url_normale'] = sprintf(EF_URL_PHOTOFLORA_IMG_MAX, $abreviation, $fichier);
			      	$tab_retour['photoflora'][$cle]['url_miniature'] = sprintf(EF_URL_PHOTOFLORA_IMG_MIN, $abreviation, $fichier);;
					list($largeur, $hauteur, $type, $attr) = getimagesize($tab_retour['photoflora'][$cle]['url_normale']);
					$tab_retour['photoflora'][$cle]['hauteur'] = $hauteur+20;
					$tab_retour['photoflora'][$cle]['largeur'] = $largeur+20;
			      	if ($largeur > $hauteur) {
						$tab_retour['photoflora'][$cle]['class'] = 'paysage';
					} else {
						$tab_retour['photoflora'][$cle]['class'] = 'portrait';
					}
					$tab_retour['photoflora_bool'] = true;
				} else {
					$e = "L'url de photoflora a changée, modifié la configuration!";
					trigger_error($e, E_USER_WARNING);
				}
			}
		}
		
		// +------------------------------------------------------------------------------------------------------+		
		// Tela Botanica Images
		$Illustrations = new EfloreIllustration('eflore', $_SESSION['cpr'], $_SESSION['cprv'], 'nt', $_SESSION['nt']);
		$aso_illustrations = $Illustrations->chercherIllustrations();
		$tab_retour['telabotanica_bool'] = false;
		$tab_retour['telabotanica_info'] = 'Photographies indisponibles';
		if (count($aso_illustrations)) {
			$tab_retour['telabotanica_bool'] = true;
			$tab_retour['telabotanica'] = $aso_illustrations; 
		}
		
		// +------------------------------------------------------------------------------------------------------+		
		// Yahoo Images
		try {
			// Recherche des images sur Yahoo
			$recherche = Services_Yahoo_Search::factory("image");
			$recherche->setAppID('eFlore_consultation');
			$recherche->setQuery($tab_retour['nom_retenu_ultra_simple']);
			$resultats = $recherche->submit();

			// Récupération des résultats
			$tab_retour['yahoo_resultat_nbre'] = $resultats->getTotalResultsReturned();
			if ($tab_retour['yahoo_resultat_nbre'] != 0) {
				$tab_retour['yahoo_miniature_hauteur_max'] = 0;
				$tab_retour['yahoo_miniature_largeur_max'] = 0;
				foreach ($resultats as $resultat) {
					//echo '<pre>'.print_r($resultat, true).'</pre>';
					// Ajout de la hauteur et de la largeur pour la fenêtre js
					if ($resultat['Height'] > 600) {
						$resultat['Height_js'] = 600; 
					} else {
						$resultat['Height_js'] = $resultat['Height']+20;
					}
					if ($resultat['Width'] > 800) {
						$resultat['Width_js'] = 800; 
					} else {
						$resultat['Width_js'] = $resultat['Width']+20;
					}
					if ($resultat['Width'] > $resultat['Height']) {
						$resultat['class'] = 'paysage';
					} else {
						$resultat['class'] = 'portrait';
					}

					// Gestion des & dans les urls
					$resultat['RefererUrl'] = htmlspecialchars($resultat['RefererUrl']);
					$resultat['ClickUrl'] = htmlspecialchars($resultat['ClickUrl']);
					
					// Calcul de la hauteur et largeur maximum des miniatures
					if ($resultat['Thumbnail']->Height > $tab_retour['yahoo_miniature_hauteur_max']) {
						$tab_retour['yahoo_miniature_hauteur_max'] = $resultat['Thumbnail']->Height; 
					}
					if ($resultat['Thumbnail']->Width > $tab_retour['yahoo_miniature_largeur_max']) {
						$tab_retour['yahoo_miniature_largeur_max'] = $resultat['Thumbnail']->Width; 
					}

					// Transfert des résultats au tableau de retour
					$tab_retour['yahoo_resultats'][] = $resultat;
				}
			} else {
				$tab_retour['yahoo_info'] = 'Illustrations indisponibles';
			}
		} catch (Services_Yahoo_Exception $e) {
			// Gestion des erreurs de la recherche Yahoo
			$message = 'Erreur: '.$e->getMessage().'<br/>';
			foreach ($e->getErrors() as $erreur) {
				$message .= ' - '.$erreur.'<br/>';
			}
			trigger_error($message, E_USER_ERROR);
		}
		
		// +------------------------------------------------------------------------------------------------------+
		// Retour des données
		return $tab_retour;
		
	}// Fin méthode executer()
	
}// Fin classe ActionIllustration()



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_illustration.action.php,v $
* Revision 1.22  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.21  2007-01-24 17:34:13  jp_milcent
* Ajout du format de rendu pour le moteur de recherche.
*
* Revision 1.20  2006/11/15 10:53:50  jp_milcent
* Fin des réglages de l'utilisation du service XML venant de Photoflora.
*
* Revision 1.19  2006/11/14 20:41:38  jp_milcent
* Début des modifications du fonctionnement de l'affichage des illustrations en provenance de Photoflora.
*
* Revision 1.18  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.17.2.1  2006/09/06 11:46:36  jp_milcent
* Gestion du code du référentiel pour le titre avant de créer le formulaire de recherche.
* Si on le place après, le référentiel est faux!
*
* Revision 1.17  2006/07/12 14:43:23  jp_milcent
* Ajout de la gestion des illustrations provennant du réseau TB.
*
* Revision 1.16  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.15  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.14  2006/05/19 12:04:18  jp_milcent
* Exclusion des noms supérieur à l'espèce de la BDNFF v3.02 pour les correspondances de noms retenus.
*
* Revision 1.13  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.12  2006/04/25 16:22:24  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des données txt liées au nom sélectionné.
*
* Revision 1.10.2.1  2006/03/08 17:19:07  jp_milcent
* Amélioration de la gestion de la configuration du moteur de recherche.
* Gestion du projet par défaut et de la version par défaut dans le fichier de config et les arguments de Papyrus.
*
* Revision 1.10  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.9  2006/01/23 20:46:32  ddelon
* affichage langues disponibles
*
* Revision 1.8.2.1  2006/01/23 16:25:51  ddelon
* Affichage taille max photoflora
*
* Revision 1.8  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.7.2.1  2005/12/15 14:59:40  jp_milcent
* Prêt pour mise en ligne bdnffv3 et v4.
*
* Revision 1.7  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.6  2005/10/26 16:36:25  jp_milcent
* Amélioration des pages Synthèses, Synonymie et Illustrations.
*
* Revision 1.5  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.4  2005/10/19 16:46:48  jp_milcent
* Correction de bogue liés à la modification des urls.
*
* Revision 1.3  2005/10/11 17:30:31  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
* Revision 1.2  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.1  2005/10/05 16:36:35  jp_milcent
* Débu et fin gestion de l'onglet Illustration.
* Amélioration de l'onglet Synthèse avec ajout d'une image.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>