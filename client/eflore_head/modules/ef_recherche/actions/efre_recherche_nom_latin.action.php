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
// CVS : $Id: efre_recherche_nom_latin.action.php,v 1.32 2007-06-19 10:32:57 jp_milcent Exp $
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
*@version       $Revision: 1.32 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionRechercheNomLatin extends aAction {

	public function executer()
	{
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();
		$tab_retour['noms'] = array();
		$tab_retour['nvp'] = 0;
		$tab_retour['nom_approche'] = '';
		$tab_param = array();
		$referentiel = 0;
		$type_referentiel = '';
		$dao_nr = new NomRelationDao();
		$dao_nom = new NomDeprecieDao();
		
		// +------------------------------------------------------------------------------------------------------+
		// Ajout du paramêtre action à l'url courante.
		$tab_retour['url_fiche'] = clone $GLOBALS['_EFLORE_']['url_base'];
		$tab_retour['url_fiche']->addQueryString(EF_LG_URL_MODULE, EF_LG_URL_MODULE_FICHE);
		
		// +------------------------------------------------------------------------------------------------------+
		// Ajout du code du référentiel
		$tab_retour['titre_general_referentiel'] = $_SESSION['cpr'].' v'.$_SESSION['cprv'];
		$tab_retour['nvp'] = $_SESSION['nvp'];
		
		// +------------------------------------------------------------------------------------------------------+
		// Constitution du tableau de radicaux du nom permettant de constituer le tableau de paramêtres pour la requête
		$tab_radical = array();
		$eflore_nom = trim($GLOBALS['eflore_nom']);
		if (strlen($eflore_nom) > 2) {
			if (EF_LANGUE_UTF8) {
				EfloreEncodage::transformerIso_8859_15VersEntitees($eflore_nom);
				$eflore_nom = mb_convert_encoding($eflore_nom, 'UTF-8', $GLOBALS['_EFLORE_']['encodage']);
				EfloreEncodage::transformerEntiteesIso_8859_15VersUtf8($eflore_nom);
			}
			
			$tab_radical = explode(' ', $eflore_nom);
			// Ajout du caractère % en fin de chaque mot du radical
			for ($i = 0; $i < count($tab_radical); $i++) {
				if (strtoupper(trim($tab_radical[$i])) == 'X') {
					// Si nous avons le symbole d'un hybride nous le concaténons au nom qui suit
					$tab_radical[$i] = $tab_radical[$i].' '.trim($tab_radical[$i+1]).'%';
					unset($tab_radical[$i+1]);
				} else {
					// Nous ajoutons le % ...
					$tab_radical[$i] = trim($tab_radical[$i]).'%';
				}
			}

			// Reconstitution du radical utilisé pour la recherche
			$tab_retour['radical'] = implode('', $tab_radical);
			
			// Nous regardons si nous avons à faire à un référentiel précis
			if (!empty($GLOBALS['eflore_referenciel'])) {
				$referentiel = $GLOBALS['eflore_referenciel'];
				$type_referentiel = '_VERSION';
			} else {
				$type_referentiel = '_UNION';
			}
	
			// Nous récupérons le radical
			switch (count($tab_radical)) {
				// Ne pas lancer la recherche si aucune saisie
				case 0 :
					$message = "Ici le nombre de radicaux ne devrait pas valoir 0 !".'-'.__FILE__.'-'.__LINE__;
					trigger_error($message, E_USER_ERROR);
					break;
				case 1 :
					// Gestion du nombre de paramêtre
					for ($i = 1; $i <= 5; $i++) {
						$tab_param[] = $tab_radical[0];
					}
					// Gestion du type de requete
					$type = constant('EF_CONSULTER_NOM'.$type_referentiel);
					break;
				case 2 :
					$tab_param = array($tab_radical[0], $tab_radical[1]);
					$type = constant('EF_CONSULTER_NOM'.$type_referentiel.'_SP');
					break;
				case 3 :
					$tab_param = array($tab_radical[0], $tab_radical[1], $tab_radical[2]);
					$type = constant('EF_CONSULTER_NOM'.$type_referentiel.'_INFRASP');
					break;
				default:
					$tab_param = array($tab_retour['radical']);
					$type = constant('EF_CONSULTER_NOM_RADICAL'.$type_referentiel.'_INTITULE');
			}
			
			// +------------------------------------------------------------------------------------------------------+
			// Nous modifions le tableau des paramêtres en fonction du type de requête
			if (!empty($referentiel)) {
				array_unshift($tab_param, $referentiel);
			} else {
				array_unshift($tab_param, $GLOBALS['_EFLORE_']['projets_affichables']);
				$tab_param = array_merge($tab_param, $tab_param);
			}
			//echo '<pre>'.print_r($tab_param).'</pre>';
			//echo $type.'<br>';
					
			// +------------------------------------------------------------------------------------------------------+
			// Récupération des données
			$tab_noms = $dao_nom->consulter($type, $tab_param);

			// Getion des différences entre les versions archivées et la dernière
			if (empty($referentiel)) {
				$tab_noms_trie = array();
				$tab_noms_diff = array();
				foreach($tab_noms as $un_nom) {
					$id = $un_nom->getId('nom');
					$date = $un_nom->getDateDerniereModif();
					if (!isset($tab_noms_diff[$id.'-'.$date])) {
						$tab_noms_diff[$id.'-'.$date] = 1;
						$tab_noms_trie[] = $un_nom;
					}
				}
				$tab_noms = $tab_noms_trie;
			}

			// Gestion des noms latins différents trouvés
			foreach($tab_noms as $un_nom) {
				$tab_nom = array();
				//echo '<pre>'.print_r($tab_noms[$i], true).'</pre>';
				$FomatageNom = new NomFormatage($un_nom);
				
				$tab_nom['intitule'] = $un_nom->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE);
				$tab_nom['intitule_affichage'] = $FomatageNom->formaterNom(NomDeprecie::FORMAT_COMPLET_CODE);
				if (!empty($referentiel)) {
					$tab_nom['statut'] = $un_nom->esn_ce_statut;
					$tab_retour['url_fiche']->addQueryString(EF_LG_URL_NVP, $referentiel);
				} else {
					$tab_nom['statut'] = EF_SNS_NULL;
					$tab_retour['url_fiche']->addQueryString(EF_LG_URL_NVP, $un_nom->getId('version_projet_nom'));
				}
				$tab_retour['url_fiche']->addQueryString(EF_LG_URL_NN, $un_nom->getId('nom'));
				$tab_nom['url_fiche'] = $tab_retour['url_fiche']->getURL();
				$tab_nom['code'] = 'nn'.$un_nom->getId('nom').'prv'.$un_nom->getId('version_projet_nom');
				$tab_retour['noms'][] = $tab_nom;
			}
			
			// +------------------------------------------------------------------------------------------------------+
			// Recherche approchée : TODO Paremetre declenchement ? 
			if (count($tab_noms) <= 15) {
				$tab_param = array();
				$elements = explode(' ', $eflore_nom);
				
				for ($i = 1; $i <= 10; $i++) {
					$tab_param[] = $elements[0];
				}			
				
				$tab_recherche_approchee = $this->lancer_recherche_approchee($tab_param);
				
				$i = 0;
				$resultat = array();
				foreach ($tab_recherche_approchee as $tab_element) {
					//Prime pour la ressemblance globale :
					$score = 500 - levenshtein($tab_element['intitule'], $eflore_nom);
					// On affine
					$score = $score + (similar_text($eflore_nom, ($tab_element['intitule'])) * 3);
					$resultat[$i]['score'] = $score;
					$resultat[$i]['intitule'] = $tab_element['intitule'];
					$i++;
				}
			
				if ($i > 0) {
					$trie = $this->mu_sort($resultat, 'score');
					$elements = explode(' ', trim($trie[0]['intitule']));
					if (count($elements) > 1) {
						$intitule = $elements[0].' '.$elements[1];
						// Hybride ...
						if (strtoupper($elements[1]) == 'X') {
							$intitule = $elements[0].' '.$elements[1].' '.$elements[2];
						}
					} else {
						$intitule = $elements[0];
					}
					// Si intitulé = recherche, pas de suggestion :
					if (strtoupper(trim($GLOBALS['eflore_nom'])) != strtoupper($intitule)) {
						$tab_retour['nom_approche'] = $intitule;
						$url_approchee = $GLOBALS['_EFLORE_']['url'];
						$url_approchee->addQueryString(EF_LG_URL_MODULE, EF_LG_URL_MODULE_RECHERCHE);
						$url_approchee->addQueryString(EF_LG_URL_ACTION, EF_LG_URL_ACTION_RECH_NOM);
						$url_approchee->addQueryString(EF_LG_URL_NVP, $referentiel);
						$url_approchee->addQueryString('eflore_nom', $tab_retour['nom_approche']);
						$tab_retour['url_approchee'] = $url_approchee->getURL();
					}
				}
			}
		} else {
			$tab_retour['radical'] = 'problème';
			$tab_retour['info'] = 'Veuillez saisir un radical contenant au moins 3 caractères alphabétiques !';
		}

		// Reaffichage Formulaire recherche nomenclaturale
		$une_recherche = new EfRecherche();
		$une_recherche->setFormat($this->getRegistre()->get(EF_LG_URL_FORMAT));
		$tab_retour['un_form_nom'] = $une_recherche->executer('form_nom');

		// +------------------------------------------------------------------------------------------------------+
		// Retour des données
		return $tab_retour;

 	}// Fin méthode executer()

	private function lancer_recherche_approchee($tab_param)
	{		
		if (!empty($GLOBALS['eflore_referenciel'])) {
			$type = EF_CONSULTER_NOM_APPROCHE_VERSION;
			// Ajout de l'id de la version du projet courrant
			array_unshift($tab_param, $GLOBALS['eflore_referenciel']);
		} else {
			$type = EF_CONSULTER_NOM_APPROCHE;
			// Ajout des id des projets pouvant être consultés
			array_unshift($tab_param, $GLOBALS['_EFLORE_']['projets_affichables']);
		}
		
		$dao_nom = new NomDeprecieDao();
		$tab_noms = $dao_nom->consulter($type, $tab_param);
		$tab_resultat['noms_approches'] = array();
		
		foreach($tab_noms as $un_nom) {
			$tab_resultat['noms_approches'][]['intitule'] = $un_nom->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE);
		}
		
		return $tab_resultat['noms_approches'];
	}
	
	function mu_sort($array, $key_sort) 
	{ 
		$key_sorta = explode(',', $key_sort);
		$keys = array_keys($array[0]);
		$n = 0;
		// sets the $key_sort vars to the first
		for ($m = 0; $m < count($key_sorta); $m++) {
			$nkeys[$m] = trim($key_sorta[$m]);
		}
		$n += count($key_sorta);// counter used inside loop
		// this loop is used for gathering the rest of the
		// key's up and putting them into the $nkeys array
		for ($i = 0; $i < count($keys); $i++) { // start loop
			// quick check to see if key is already used.
			if(!in_array($keys[$i], $key_sorta)) {
				// set the key into $nkeys array
				$nkeys[$n] = $keys[$i];
				// add 1 to the internal counter
				$n += '1';
			}
		}

		// this loop is used to group the first array [$array]
		// into it's usual clumps
		for($u = 0; $u < count($array); $u++) { // start loop #1
			// set array into var, for easier access.
			$arr = $array[$u];	
			// this loop is used for setting all the new keys
			// and values into the new order
			for($s = 0; $s < count($nkeys); $s++) {
				// set key from $nkeys into $k to be passed into multidimensional array
				$k = $nkeys[$s];
				// sets up new multidimensional array with new key ordering
				$output[$u][$k] = $array[$u][$k];
			}
		}
		// sort
		rsort($output, SORT_REGULAR);
		
		// return sorted array
		return $output;
	}
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_recherche_nom_latin.action.php,v $
* Revision 1.32  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.31  2007-06-11 12:46:51  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.26.6.7  2007-06-11 10:22:06  jp_milcent
* Correction suppression de la recherche approchée.
*
* Revision 1.26.6.6  2007-06-11 10:11:25  jp_milcent
* Résolution de l'ensemble des problèmes d'encodage.
*
* Revision 1.26.6.5  2007-06-08 12:35:07  jp_milcent
* Simplification traitement du nom.
*
* Revision 1.26.6.4  2007-06-07 13:59:13  jp_milcent
* Prise en comtpe de l'utf8 via une constante.
*
* Revision 1.30  2007-06-04 12:17:08  jp_milcent
* Fusion avec la livraison Moquin-Tandon : 04 juin 2007
*
* Revision 1.26.6.3  2007-06-04 11:30:58  jp_milcent
* Correction problème utf8 : la convertion iso vers utf8 et inversément est réalisée par Mysql.
*
* Revision 1.29  2007-06-01 13:23:05  jp_milcent
* Fusion avec livraison Moquin-Tandon : 01 juin 2007
*
* Revision 1.28  2007-05-11 15:11:41  jp_milcent
* Correction bogue : isoëtes
*
* Revision 1.27  2007/02/07 10:49:39  jp_milcent
* Utilisation de la classe mère aAction.
*
* Revision 1.26.6.2  2007-05-30 16:35:49  jp_milcent
* Transformation en utf8 des chaines provenant de formulaires.
*
* Revision 1.26.6.1  2007-05-11 15:09:02  jp_milcent
* Correction bogue : isoëtes
*
* Revision 1.26  2006/07/20 09:45:27  jp_milcent
* Correction du bogue ayant fait sauter l'algo de trie des noms latins.
* Modification du trie pour afficher les taxons en premier.
* Ajout d'une constante permettant de tenir compte ou pas du "x" des hybrides dans le trie des noms.
*
* Revision 1.25  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.24  2006/07/05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.23  2006/05/16 09:27:34  jp_milcent
* Gestion des correspondances.
* Ajout du plier/deplier.
*
* Revision 1.22  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.21  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.20.2.1  2006/03/09 17:42:06  jp_milcent
* Simplification et amélioration de la recherche.
*
* Revision 1.20  2005/12/21 17:15:33  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnff_v3_v4.
*
* Revision 1.19  2005/12/21 16:10:30  jp_milcent
* Gestion des fichiers de localisation et simplification du code.
*
* Revision 1.18  2005/12/15 16:01:21  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.17  2005/12/06 16:37:50  jp_milcent
* Modification pour utiliser le nouveau formatage html des noms latins.
*
* Revision 1.16  2005/12/06 09:47:26  ddelon
* Recherche vernaculaire (extension) + recherche approche
*
* Revision 1.15  2005/12/05 17:24:51  ddelon
* reglage recherche approchee
*
* Revision 1.14  2005/12/05 10:52:30  jp_milcent
* Correction du bogue provoqué par la recherche sur plus de 3 noms séparés par des espaces.
* Mise en conformité avec la charte de codage.
*
* Revision 1.13  2005/12/05 08:26:51  ddelon
* Test recherche approchee
*
* Revision 1.12  2005/12/04 23:57:28  ddelon
* Recherche approchee
*
* Revision 1.11  2005/12/02 21:29:41  ddelon
* Limitation recherche nom verna
*
* Revision 1.10  2005/12/02 16:50:25  ddelon
* Retablissement recherche tout referentiel
*
* Revision 1.8  2005/11/28 22:28:15  ddelon
* traitement hybrides
*
* Revision 1.7  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.6  2005/10/11 17:30:32  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
* Revision 1.5  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.4  2005/09/13 16:25:23  jp_milcent
* Fin de gestion des interfaces de recherche.
*
* Revision 1.3  2005/09/12 16:22:44  jp_milcent
* Fin de gestion de la recherche des noms latins pour tous les référentiels.
*
* Revision 1.2  2005/08/19 13:54:11  jp_milcent
* Début de gestion de la navigation au sein de la classification.
*
* Revision 1.1  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>