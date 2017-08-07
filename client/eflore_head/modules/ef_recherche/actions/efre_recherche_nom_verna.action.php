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
// CVS : $Id: efre_recherche_nom_verna.action.php,v 1.16 2007-06-19 10:32:57 jp_milcent Exp $
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
*@version       $Revision: 1.16 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionRechercheNomVerna extends aAction {

	public function executer()
	{
		// +------------------------------------------------------------------------------------------------------+
		// Ajout du paramêtre action à l'url courante.
		$tab_retour['url_fiche'] = clone $GLOBALS['_EFLORE_']['url_base'];
		$tab_retour['url_fiche']->addQueryString(EF_LG_URL_MODULE, EF_LG_URL_MODULE_FICHE);
		
		$tab_retour['nom_vernaculaire_approche'] = '';
		
		// +------------------------------------------------------------------------------------------------------+
		// Ajout du titre provenant du fichier de config
		$tab_retour['titre_general'] = $GLOBALS['_EFLORE_']['titre'];
		// Ajout du code du référentiel
		$tab_retour['titre_general_referentiel'] = $_SESSION['cpr'].' v'.$_SESSION['cprv'];
		
		// +------------------------------------------------------------------------------------------------------+
		// Constitution du tableau de paramêtres à paser à la requete
		$tab_radical = array();
		$eflore_nom = trim(strtolower($GLOBALS['eflore_nom']));
		if (strlen($eflore_nom) > 0) {
			if (EF_LANGUE_UTF8) {
				$eflore_nom = mb_convert_encoding($eflore_nom, 'UTF-8', $GLOBALS['_EFLORE_']['encodage']);
			}
			$tab_radical = explode(' ', $eflore_nom);
			
			// Ajout du caractère n'importe quel autre caractère en fin de chaque mot du radical
			foreach ($tab_radical as $cle => $val) {
				$tab_radical[$cle] = $val.'%';
			}
			$tab_radical[0] = '%'.$tab_radical[0];
		} else {
			$tab_radical[0] = '%';
		}
		
		$lancer_recherche = true;
		
		// Reconstitution du radical utilisé pour la recherche
		$tab_retour['radical'] = implode('', $tab_radical);
		
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des données
		$tab_retour['noms_vernaculaires'] = array();
		$dao_taxon = new TaxonDao();
		$dao_nom_relation = new NomRelationDao();
		$dao_nom = new NomDeprecieDao();
		$dao_vernaculaire = new VernaculaireDao();

		// Nous regardons si nous avons à faire à un référentiel précis
		if (!empty($GLOBALS['eflore_referenciel'])) {
			$tab_param_radical = array($GLOBALS['eflore_referenciel'], $tab_retour['radical']);
			$type_radical = EF_CONSULTER_VERNACULAIRE_RADICAL_VERSION;
		} else {
			$tab_param_radical = array($tab_retour['radical']);
			$type_radical = EF_CONSULTER_VERNACULAIRE_RADICAL;
		}

		if (strlen(trim($GLOBALS['eflore_nom'])) < 3) {
			$lancer_recherche = false;
		}
		
		if ($lancer_recherche) {
			//$dao_vernaculaire->setDebogage(EF_DEBOG_SQL);
			$tab_noms_vernaculaires = $dao_vernaculaire->consulter($type_radical, $tab_param_radical);
			if (count($tab_noms_vernaculaires) != 0) {
				$i = 0;
				foreach ($tab_noms_vernaculaires as $nom_verna) {
					//echo '<pre>'.print_r($nom_verna, true).'</pre>';
					$tab_retour['noms_vernaculaires'][$i]['intitule'] = $nom_verna->getIntitule();
					$tab_retour['noms_vernaculaires'][$i]['lg_intitule'] = $nom_verna->getLgIntitule();
					$tab_retour['noms_vernaculaires'][$i]['lg_abreviation'] = $nom_verna->getLgAbreviation();
					$tab_retour['noms_vernaculaires'][$i]['zg_intitule'] = $nom_verna->getZgIntitule();
					$tab_retour['noms_vernaculaires'][$i]['zg_abreviation'] = $nom_verna->getZgAbreviation();
					$tab_retour['noms_vernaculaires'][$i]['id_taxon'] = $nom_verna->getIdTaxon();
					$tab_retour['noms_vernaculaires'][$i]['id_version_taxon'] = $nom_verna->getIdTaxonVersionProjet();
					$tab_taxons_id[$nom_verna->getIdTaxonVersionProjet()][] = $nom_verna->getIdTaxon();
					$i++;
				}
	
				// Récupération des taxons de tous les référentiels
				foreach ($tab_taxons_id as $c => $v) {
					$chaine_id_taxons = implode(', ', $v);
					$type_taxon_grp = EF_CONSULTER_TAXON_VERSION_GROUPE_ID;
					$tab_param_taxon_grp = array( (int)$c, $chaine_id_taxons );
		
					//$dao_taxon->setDebogage(EF_DEBOG_SQL);
					$tab_taxons = $dao_taxon->consulter($type_taxon_grp, $tab_param_taxon_grp);
					//echo '<pre>'.print_r($tab_taxons, true).'</pre>';
					foreach ($tab_taxons as $taxon) {
						//echo '<pre>'.print_r($taxon, true).'</pre>';
						foreach ($tab_retour['noms_vernaculaires'] as $cle => $nom_verna) {
							if (	$nom_verna['id_taxon'] == $taxon->getId('taxon') && 
									$nom_verna['id_version_taxon'] == $taxon->getId('version_projet_taxon')) {
								$tab_retour['noms_vernaculaires'][$cle]['id_nom_latin'] = $taxon->getIdNomRetenu();
								$referentiel = $tab_retour['noms_vernaculaires'][$cle]['id_version_taxon'];
								$tab_retour['url_fiche']->addQueryString(EF_LG_URL_NVP, $referentiel);
								$tab_retour['url_fiche']->addQueryString(EF_LG_URL_NN, $taxon->getIdNomRetenu());
								$url_fiche = $tab_retour['url_fiche']->getURL();
								$tab_retour['noms_vernaculaires'][$cle]['url_fiche'] = $url_fiche;
								$tab_noms_id[$taxon->getId('version_projet_nom')][] = $taxon->getIdNomRetenu();
							}
						}
					}
				}
				
				// Récupération des noms des taxons
				foreach ($tab_noms_id as $int_projet_nom_id => $tab_projet_noms_id) {
					$chaine_id_noms = implode(', ', $tab_projet_noms_id);
					$type = EF_CONSULTER_NR_GROUPE_ID;
					$tab_param = array($chaine_id_noms, (int)$int_projet_nom_id);
					//$dao_nom_relation->setDebogage(EF_DEBOG_SQL);
					$tab_nom_relations = $dao_nom_relation->consulter($type, $tab_param);
					foreach ($tab_retour['noms_vernaculaires'] as $cle => $nom_verna) {
						$tab_retour['noms_vernaculaires'][$cle]['autonyme'] = FALSE;
						foreach ($tab_nom_relations as $nom_relation) {
							if (	$nom_relation->getId('nom_1') == $nom_verna['id_nom_latin'] && 
									$nom_relation->getId('categorie_relation') == 10 && $nom_relation->getId('valeur_relation') == 3) {
								$tab_retour['noms_vernaculaires'][$cle]['autonyme'] = TRUE;
								break;
							}
						}
						if ($tab_retour['noms_vernaculaires'][$cle]['autonyme'] == FALSE) {
							$type = EF_CONSULTER_NOM_ID;
							$tab_param = array($nom_verna['id_nom_latin'], (int)$int_projet_nom_id);
							//$dao_nom->setDebogage(EF_DEBOG_SQL);
							$tab_noms = $dao_nom->consulter($type, $tab_param);
							foreach ($tab_noms as $nom) {
								$FomatageNom = new NomFormatage($nom);
								$tab_retour['noms_vernaculaires'][$cle]['nom_latin'] = $FomatageNom->formaterNom(NomDeprecie::FORMAT_SIMPLE);
							}
						} else {
							unset($tab_retour['noms_vernaculaires'][$cle]);
						}
					}
				}
			}
			// +------------------------------------------------------------------------------------------------------+
			// TODO : Recherche approchée : Paramêtre déclenchement ? 
			// +------------------------------------------------------------------------------------------------------+
			if (count($tab_noms_vernaculaires) <= 15) {						
				$tab_param = array();
				$tab_radical = array();
				
				$tab_radical = explode(' ', trim($eflore_nom));
				
				// Nous regardons si nous avons à faire à un référentiel précis
				if (!empty($GLOBALS['eflore_referenciel'])) {
					$tab_param_radical = array($GLOBALS['eflore_referenciel'], trim($eflore_nom), trim($eflore_nom), '%'.trim($tab_radical[0]).'%');
				} else {
					$tab_param_radical = array(trim($eflore_nom), trim($eflore_nom) , '%'.trim($tab_radical[0]).'%');
				}
				
				$tab_approchee = $this->lancer_recherche_approchee($tab_param_radical);
				$i = 0;
				$resultat = array();
				foreach ($tab_approchee as $tab_retour_element) {
					//Prime pour la ressemblance globale :
					$score = 500 - levenshtein($tab_retour_element['intitule'], $eflore_nom);
					// On affine
					$score = $score + (similar_text($eflore_nom, ($tab_retour_element['intitule'])) * 3);
					$resultat[$i]['score'] = $score;
					$resultat[$i]['intitule'] = $tab_retour_element['intitule'];
					$i++;
				}
				
				if ($i > 0) {
					$trie = $this->mu_sort($resultat, 'score');
					$intitule = trim($trie[0]['intitule']);
					// Si intitulé = recherche, pas de suggestion :
					if (strtoupper(trim($GLOBALS['eflore_nom'])) != strtoupper($intitule)) {
						$tab_retour['nom_vernaculaire_approche'] = $intitule;
						$url_approchee = clone $GLOBALS['_EFLORE_']['url'];
						$url_approchee->addQueryString(EF_LG_URL_MODULE, EF_LG_URL_MODULE_RECHERCHE);
						$url_approchee->addQueryString(EF_LG_URL_ACTION, EF_LG_URL_ACTION_RECH_NOM);
						$url_approchee->addQueryString('eflore_referenciel', $GLOBALS['eflore_referenciel']);
						$url_approchee->addQueryString('eflore_type_nom', 'nom_vernaculaire');
						$url_approchee->addQueryString('eflore_nom', $intitule);
						$tab_retour['url_approchee'] = $url_approchee->getURL();
					}
				}
			}
		} else {
			$tab_retour['info'][] = 'Veuillez saisir un radical contenant au moins 3 caractères alphabétiques !';
		}
				
		// Création Formulaire recherche nomenclaturale
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
			$referentiel = $GLOBALS['eflore_referenciel'];
			$type_referentiel = '_VERSION';
			$type = EF_CONSULTER_VERNACULAIRE_APPROCHE_VERSION;
		} else {
			$type = EF_CONSULTER_VERNACULAIRE_APPROCHE;
		}
		
		$dao_vernaculaire = new VernaculaireDao();
		$tab_noms = $dao_vernaculaire->consulter($type, $tab_param);
		
		$tab_resultat['noms_vernaculaires_approches'] = array();
		
		foreach($tab_noms as $nom_verna) {
			$tab_nom = array();
			$tab_nom['intitule'] = $nom_verna->getIntitule();
			$tab_resultat['noms_vernaculaires_approches'][] = $tab_nom;
		}
		return $tab_resultat['noms_vernaculaires_approches'];
		
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
				$n += "1";
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
		// Réalisation du trie
		rsort($output, SORT_REGULAR);
		
		// Retourne le tableau trié
		return $output;
	}
 	
 	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_recherche_nom_verna.action.php,v $
* Revision 1.16  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.15  2007-06-11 12:46:51  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.10.6.7  2007-06-11 11:49:11  jp_milcent
* Correction problème url et changement de nom de variable de retour.
*
* Revision 1.10.6.6  2007-06-11 10:20:48  jp_milcent
* Correction oublie de modifier une variable.
*
* Revision 1.10.6.5  2007-06-11 10:11:25  jp_milcent
* Résolution de l'ensemble des problèmes d'encodage.
*
* Revision 1.10.6.4  2007-06-07 13:59:13  jp_milcent
* Prise en comtpe de l'utf8 via une constante.
*
* Revision 1.14  2007-06-04 13:20:38  jp_milcent
* Fusion avec la livraison Moquin-Tandon : 04 juin 2007 - formatage détaillé du nom latin
*
* Revision 1.10.6.3  2007-06-04 13:02:57  jp_milcent
* Utilisation du formatage détaillé du nom latin.
*
* Revision 1.13  2007-06-04 12:17:08  jp_milcent
* Fusion avec la livraison Moquin-Tandon : 04 juin 2007
*
* Revision 1.12  2007-06-01 13:23:05  jp_milcent
* Fusion avec livraison Moquin-Tandon : 01 juin 2007
*
* Revision 1.11  2007-01-24 17:35:02  jp_milcent
* Correction pour gérer correctement le format de sortie.
*
* Revision 1.10.6.2  2007-06-04 11:30:58  jp_milcent
* Correction problème utf8 : la convertion iso vers utf8 et inversément est réalisée par Mysql.
*
* Revision 1.10.6.1  2007-05-30 16:35:49  jp_milcent
* Transformation en utf8 des chaines provenant de formulaires.
*
* Revision 1.10  2006/07/05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.9  2006/03/07 11:07:08  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnbe_v1.
*
* Revision 1.8.2.1  2006/03/07 10:35:00  jp_milcent
* Correction des requêtes SQL : ajout de l'identifiant de la version du projet.
* Mise en forme du code conformément à la charte de codage.
*
* Revision 1.8  2005/12/21 16:10:30  jp_milcent
* Gestion des fichiers de localisation et simplification du code.
*
* Revision 1.7  2005/12/06 09:47:26  ddelon
* Recherche vernaculaire (extension) + recherche approche
*
* Revision 1.6  2005/12/02 21:29:41  ddelon
* Limitation recherche nom verna
*
* Revision 1.5  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.4  2005/09/30 16:22:01  jp_milcent
* Fin de la gestion de l'onglet Noms Vernaculaires.
*
* Revision 1.3  2005/09/26 15:48:15  jp_milcent
* Fin de l'onglet synthèse pour la fiche d'un taxon.
*
* Revision 1.2  2005/09/13 16:25:23  jp_milcent
* Fin de gestion des interfaces de recherche.
*
* Revision 1.1  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>