<?php

class NomFormatageVue {
	private $format;
	
	function __construct($format)
	{
		$this->format = $format;
	}
	
	public function executer($donnees = array())
	{
		$nom =& $donnees;
		$squelette = new SquelettePhp(EF_CHEMIN_COMMUN_SQUELETTE.'nom_latin.tpl.'.$this->format);
		$nom_structure = array();
		$nom_complement = array();
		if (isset($nom['nom_supra_generique']) && $nom['nom_supra_generique'] != '') {
			$nom_structure[] = array('class' => 'nl_supra_generique', 'contenu' => $nom['nom_supra_generique']);
		} elseif (isset($nom['epithete_infra_generique']) && $nom['epithete_infra_generique'] != '') {
			$nom_structure[] = array('class' => 'nl_infra_generique', 'contenu' => $nom['epithete_infra_generique']);
		} else {
			if (isset($nom['nom_genre']) && $nom['nom_genre'] != '') {
				$nom_structure[] = array('class' => 'nl_g', 'contenu' => $nom['nom_genre']);
			}
			if (isset($nom['epithete_espece']) && $nom['epithete_espece'] != '') {
				$nom_structure[] = array('class' => 'nl_sp', 'contenu' => ' '.$nom['epithete_espece']);
			}
			if (isset($nom['epithete_infra_specifique']) && $nom['epithete_infra_specifique'] != '') {
				if (!empty($nom['abbreviation_rang']) ) {
					$nom_structure[] = array('class' => 'nl_abbr_rg', 'contenu' => ' '.$nom['abbreviation_rang']);
				}
				$nom_structure[] = array('class' => 'nl_infra_sp', 'contenu' => ' '.$nom['epithete_infra_specifique']);
			}
		}
		if ($nom['auteurs'] != '') {
			$nom_structure[] = array('class' => 'nl_auteur', 'contenu' => ' '.$nom['auteurs']);
		}
		
		switch ($nom['type']) {
			case NomDeprecie::FORMAT_SIMPLE :
				if ($nom['auteurs'] != '') {
					if ($nom['annee'] != '') {
						$nom_complement[] = array('class' => 'nl_annee', 'contenu' => ', '.$nom['annee']);
					}
				} else {
					if ($nom['annee'] != '') {
						$nom_complement[] = array('class' => 'nl_annee', 'contenu' => ' '.$nom['annee']);
					}
				}
				break;
			case NomDeprecie::FORMAT_COMPLET :
				if ($nom['auteur_in'] != '') {
					$nom_complement[] = array('class' => 'nl_auteur_in', 'contenu' => ' in '.$nom['auteur_in']);
				}
				if ($nom['biblio_annee'] != '') {
					$nom_complement[] = array('class' => 'nl_biblio_annee', 'contenu' => ' ['.$nom['biblio_annee'].']');
				}
				if ($nom['commentaire_nomenclatural'] != '') {
					$nom_complement[] = array(	'class' => 'nl_commentaire_nomenclatural', 
												'contenu' => ' '.$nom['commentaire_nomenclatural']);
				}
				break;
			case NomDeprecie::FORMAT_COMPLET_CODE :
				// TODO : je répète ici ce qu'il y a dans "case NomDeprecie::FORMAT_COMPLET" c'est pas top!
				if ($nom['auteur_in'] != '') {
					$nom_complement[] = array('class' => 'nl_auteur_in', 'contenu' => ' in '.$nom['auteur_in']);
				}
				if ($nom['biblio_annee'] != '') {
					$nom_complement[] = array('class' => 'nl_biblio_annee', 'contenu' => ' ['.$nom['biblio_annee'].']');
				}
				if ($nom['commentaire_nomenclatural'] != '') {
					$nom_complement[] = array(	'class' => 'nl_commentaire_nomenclatural', 
												'contenu' => ' '.$nom['commentaire_nomenclatural']);
				}
//				if ($nom['nn'] != '') {
//					$nom_complement[] = array('class' => 'ef_nn', 'contenu' => ' [nn'.$nom['nn'].'] ');
//				}
				// Nous chargeons le squelette du noms latin spécifique pour le js
				$squelette = new SquelettePhp(EF_CHEMIN_COMMUN_SQUELETTE.'nom_latin_pliage.tpl.'.$this->format);
				$squelette->set('code', $nom['code']);
				break;
			
		}
		
		// Dans le cas, où les infos sur les noms sont vides
		if (empty($nom_structure)) {
			$nom_structure[] = array('class' => 'nl_inconnu', 'contenu' => ' ? ');
		}
		
		// Nous enregistrons les infos du noms pour l'affichage
		$squelette->set('nom_structure', $nom_structure);
		$squelette->set('nom_complement', $nom_complement);
		
		return $squelette->analyser();
	}
}
?>