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
* Fichier de vue du module eFlore-Fiche : Information
*
* Contient la génération de la vue pour l'onglet "Information".
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

class VueInformation extends aVue {
	
	public function __construct($Registre)
	{
		$this->setNom('information');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	public function traiterLegende($aso_i18n, $champ)
	{
		$legende['champ'] = str_replace('_', ' ', ucfirst($champ));
		$legende['legende'] = '';
		$legende['type'] = '';
		
		if (isset($aso_i18n[$this->getNom()][$_SESSION['cpr']]['legende'][$champ])) {
			$legende['champ'] = $aso_i18n[$this->getNom()][$_SESSION['cpr']][$champ];
			$legende['legende'] = $aso_i18n[$this->getNom()][$_SESSION['cpr']]['legende'][$champ];
		}
		
		if (preg_match('/^LISTE\s*;\s*/', $legende['champ'])) {
			
		}
		
		if (preg_match('/^LISTE\s*;\s*/', $legende['legende'])) {
			$legende['legende'] = preg_replace('/^LISTE\s*;\s*/', '', $legende['legende']);
			$legende['type'] = 'liste';
		}
		
		switch ($legende['type']) {
			case 'liste' :
				$tab_libelles = explode(';', $legende['legende']);
				$legende['definition'] = '';
				foreach ($tab_libelles as $libelle) {
					$tab_libelles2 = explode(' = ', $libelle);
					if ($tab_libelles2[0] == 'DEFINITION') {
						$legende['definition'] = $tab_libelles2[1];
					} else {
						$legende['liste'][trim($tab_libelles2[0])] = trim($tab_libelles2[1]);
					}
				}
				break;
			default:
				$legende['definition'] = $legende['legende'];
		}
		return $legende;
	}
	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		$NomSelectionFormatage = new NomFormatage($this->getDonnees('nom_selection'));
		$NomRetenuFormatage = new NomFormatage($this->getDonnees('nom_retenu'));
		
		// Initialisation des variables pour la légende
		$aso_legendes = array();
		
		// Gestion du nom du référentiel
		$ref_intitule_court = $this->getDonnees('pr_abreviation').'  v'.$this->getDonnees('prv_code');
		
		// Gestion du block information du taxon
		$aso_i18n = $this->getRegistre()->get('module_i18n');
		//echo '<pre>'.print_r($aso_i18n, true).'</pre>'
		//echo '<pre>'.print_r($this->getDonnees('txt'), true).'</pre>';;
		foreach ($this->getDonnees('txt_taxon') as $tab_txt) {
			foreach ($tab_txt as $cle => $val) {
				switch ($cle) {
					case 'titre' :
						$squelette->setVariable( 'EFIT_TITRE', $val );
						break;
					default:
						// Gestion des légendes
						$aso_legendes[$cle] = $this->traiterLegende($aso_i18n, $cle);

						// Nous explosons les valeurs multiples séparées par des virgules
						$tab_val = array_map('trim', explode(',', $val));
						$squelette->setCurrentBlock('EFIT_DONNEES_VAL');
						$nbre_valeur = count($tab_val);
						//echo '<pre>'.print_r($tab_val, true).'</pre>';
						for ($i = 0; $i < $nbre_valeur; $i++) {
							$val = $tab_val[$i];
							$squelette->setVariable( 'EFIT_VAL', $val);
							
							if (isset($aso_legendes[$cle]['liste'][$val])) {
								
								$squelette->setVariable( 'EFIT_VAL_TITLE', $aso_legendes[$cle]['liste'][$val]);
								$squelette->setVariable( 'EFIT_VAL_CLASS', 'tooltip');
							} else {
								$squelette->setVariable( 'EFIT_VAL_TITLE', '');
								$squelette->setVariable( 'EFIT_VAL_CLASS', '');
							}
							if ($nbre_valeur > 1 && $nbre_valeur != ($i+1)) {
								$squelette->setVariable('EFIT_VAL_SEPARATEUR', ',');
							} else {
								$squelette->setVariable('EFIT_VAL_SEPARATEUR', '');
							}
							$squelette->parseCurrentBlock('EFIT_DONNEES_VAL');
						}
						$squelette->setCurrentBlock('EFIT_DONNEES');
						// Gestion des données 
						$squelette->setVariable( 'EFIT_CHP', $aso_legendes[$cle]['champ']);
						if ($aso_legendes[$cle]['definition'] != '') {
							$squelette->setVariable( 'EFIT_CHP_TITLE', $aso_legendes[$cle]['definition']);
							$squelette->setVariable( 'EFIT_CHP_CLASS', 'tooltip');
						} else {
							$squelette->setVariable( 'EFIT_CHP_TITLE', '');
							$squelette->setVariable( 'EFIT_CHP_CLASS', '');
						}
						$squelette->parseCurrentBlock('EFIT_DONNEES');
				}
			}
			$squelette->setCurrentBlock('INFO_TXT_TAXON');
			$squelette->parseCurrentBlock('INFO_TXT_TAXON');
		}

		// Gestion du block information du nom sélectionné
		$aso_i18n = $this->getRegistre()->get('module_i18n');
		//echo '<pre>'.print_r($aso_i18n, true).'</pre>'
		//echo '<pre>'.print_r($this->getDonnees('txt'), true).'</pre>';;
		foreach ($this->getDonnees('txt_nom') as $tab_txt) {
			foreach ($tab_txt as $cle => $val) {
				switch ($cle) {
					case 'titre' :
						$squelette->setVariable( 'EFIN_TITRE', $val );
						break;
					default:
						$squelette->setCurrentBlock('EFIN_DONNEES');
						// Gestion des légendes
						$aso_legendes[$cle] = $this->traiterLegende($aso_i18n, $cle);
						// Gestion des données 
						$squelette->setVariable( 'EFIN_CHP', $aso_legendes[$cle]['champ']);
						
						if ($aso_legendes[$cle]['definition'] != '') {
							$squelette->setVariable( 'EFIN_CHP_TITLE', $aso_legendes[$cle]['definition']);
							$squelette->setVariable( 'EFIN_CHP_CLASS', 'tooltip');
						} else {
							$squelette->setVariable( 'EFIN_CHP_TITLE', '');
							$squelette->setVariable( 'EFIN_CHP_CLASS', '');
						}
						$squelette->setVariable( 'EFIN_VAL', $val );
						//echo '<pre>'.print_r($aso_legendes, true).'</pre>';
						if (isset($aso_legendes[$cle]['liste'][$val])) {
							$squelette->setVariable( 'EFIN_VAL_TITLE', $aso_legendes[$cle]['liste'][$val]);
							$squelette->setVariable( 'EFIN_VAL_CLASS', 'tooltip');
						} else {
							$squelette->setVariable( 'EFIN_VAL_TITLE', '');
							$squelette->setVariable( 'EFIN_VAL_CLASS', '');
						}
						$squelette->parseCurrentBlock('EFIN_DONNEES');
				}
			}
			$squelette->setCurrentBlock('INFO_TXT_NOM');
			$squelette->parseCurrentBlock('INFO_TXT_NOM');
		}
		
		// Gestion du block légende
		foreach ($aso_legendes as $legende) {
			//echo '<pre>'.print_r($legende, true).'</pre>';
			if ($legende['legende'] != '') {
				switch ($legende['type']) {
					case 'liste' :
						//echo '<pre>'.print_r($tab_libelles, true).'</pre>';
						$squelette->setCurrentBlock('EFIL_DONNEES_VAL2');
						foreach ($legende['liste'] as $champ => $definition) {
							$squelette->setVariable( 'EFIL_VAL_CHP', $champ);
							$squelette->setVariable( 'EFIL_VAL', $definition);
							$squelette->parseCurrentBlock('EFIL_DONNEES_VAL2');
						}
						$squelette->setCurrentBlock('EFIL_DONNEES_VAL_LISTE');
						$squelette->setVariable( 'EFIL_VAL_DEF', $legende['definition']);
						$squelette->parseCurrentBlock('EFIL_DONNEES_VAL_LISTE');
						break;
					default:
						$squelette->setCurrentBlock('EFIL_DONNEES_VAL');
						$squelette->setVariable( 'EFIL_VAL', $legende['legende']);
						$squelette->parseCurrentBlock('EFIL_DONNEES_VAL');
				}
				$squelette->setCurrentBlock('EFIL_DONNEES');
				$squelette->setVariable( 'EFIL_CHP', $legende['champ']);
				$squelette->parseCurrentBlock('EFIL_DONNEES');
			}			
		}
		$squelette->setCurrentBlock('INFO_LEGENDE');
		$squelette->parseCurrentBlock('INFO_LEGENDE');
			
		// Gestion du block principal
		$squelette->setCurrentBlock();
		$squelette->setVariable('EF_URL_JS', EF_URL_JS);
		$squelette->setVariable('TITRE_GENERAL_REFERENTIEL', $ref_intitule_court);
		$squelette->setVariable('FORMULAIRE_RECHERCHE_NOM', $this->getDonnees('un_form_nom'));		
		$squelette->setVariable('TITRE', $NomRetenuFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE));
		$squelette->setVariable('NT', $this->getDonnees('nt'));
		$squelette->setVariable('NVP', $this->getDonnees('nvp'));
		if ($this->getDonnees('nom_retenu_famille') != null) {
			$NomFamilleFormatage = new NomFormatage($this->getDonnees('nom_retenu_famille'));
			$squelette->setVariable('NOM_RETENU_FAMILLE', $NomFamilleFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE) );
		}		
		$squelette->parseCurrentBlock();
				
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.15  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.14  2007-06-11 15:45:12  jp_milcent
* Utilisation de l'applette ProtectionInfo.
*
* Revision 1.13  2007-01-15 15:37:41  jp_milcent
* Suppression d'un message de débogage.
*
* Revision 1.12  2007/01/12 16:21:13  jp_milcent
* Amélioration de la gestion des légendes.
*
* Revision 1.11  2007/01/11 19:02:13  jp_milcent
* Amélioration de la gestion des légendes.
*
* Revision 1.10  2007/01/11 13:28:34  jp_milcent
* Amélioration de la gestion du template pour les Protections.
*
* Revision 1.9  2007/01/08 18:45:40  jp_milcent
* Correction problème zg, template et amélioration du rendu.
*
* Revision 1.8  2007/01/03 19:52:19  jp_milcent
* Utilisation d'une constante pour le chemin de la bibliothèque javascript.
*
* Revision 1.7  2007/01/03 19:45:02  jp_milcent
* Ajout des informations sur les statuts de protection.
*
* Revision 1.6  2006/11/15 15:52:16  jp_milcent
* Fin gestion des légendes.
*
* Revision 1.5  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.4.2.2  2006/09/06 11:47:00  jp_milcent
* Gestion du formulaire de recherche et du titre général.
*
* Revision 1.4.2.1  2006/09/04 14:21:36  jp_milcent
* Gestion des informations sur le taxon et le nom sélectionné dans l'onglet "Informations".
*
* Revision 1.4  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
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
