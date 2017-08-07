<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                               |
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
// CVS : $Id: NomDeprecie.class.php,v 1.1 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Classe Nom
*
* 
*
*@package eFlore
*@subpackage Nomenclature
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// +------------------------------------------------------------------------------------------------------+
//Constante définissant le type de format de nom.
/** Constante définissant le type de format contenant seulement le nom latin de l'espèce'.*/
define('EF_NOM_FORMAT_ULTRA_SIMPLE', 0);
/** Constante définissant le type de format de nom par défaut.*/
define('EF_NOM_FORMAT_SIMPLE', 1);
/** Constante définissant le type de format de nom complet (avec la référence biblio).*/
define('EF_NOM_FORMAT_COMPLET', 2);

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class NomDeprecie extends AModele
{
	/*** Constantes : ***/
	/** Constante définissant le type de format contenant seulement le nom latin de l'espèce'.*/
	const FORMAT_ULTRA_SIMPLE = EF_NOM_FORMAT_ULTRA_SIMPLE;
	/** Constante définissant le type de format de nom par défaut.*/
	const FORMAT_SIMPLE = EF_NOM_FORMAT_SIMPLE;
	/** Constante définissant le type de format de nom complet (avec la référence biblio).*/
	const FORMAT_COMPLET = EF_NOM_FORMAT_COMPLET;
	/** Constante définissant le type de format de nom complet (avec la référence biblio et les codes nn et nt).*/
	const FORMAT_COMPLET_CODE = 3;
	
	/*** Attributes : ***/
	private $nom_supra_generique;
	
	private $nom_genre;

	private $epithete_infra_generique;

	private $epithete_espece;
	
	private $epithete_infra_specifique;
	
	private $epithete_cultivar;
	
	private $intitule_groupe_cultivar;
	
	private $formule_hybridite;
	
	private $phrase_nom_non_nomme;
	
	/*** Constructeurs : ***/
	
	public function __construct()
	{
		
	}
	
	/*** Accesseurs : ***/

	// Nom supra-générique
	public function getNomSupraGenerique()
	{
		return $this->nom_supra_generique;
	}
	public function setNomSupraGenerique( $nsg )
	{
		$this->nom_supra_generique = $nsg;
	}

	// Nom genre
	public function getNomGenre()
	{
		return $this->nom_genre;
	}
	public function setNomGenre( $ng )
	{
		$this->nom_genre = $ng;
	}

	// Epithete Infra Generique
	public function getEpitheteInfraGenerique()
	{
		return $this->epithete_infra_generique;
	}
	public function setEpitheteInfraGenerique( $eig )
	{
		$this->epithete_infra_generique = $eig;
	}

	// Epithete Espece
	public function getEpitheteEspece()
	{
		return $this->epithete_espece;
	}
	public function setEpitheteEspece( $ee )
	{
		$this->epithete_espece = $ee;
	}
	
	// Epithete Infra Specifique
	public function getEpitheteInfraSpecifique()
	{
		return $this->epithete_infra_specifique;
	}
	public function setEpitheteInfraSpecifique( $eis )
	{
		$this->epithete_infra_specifique = $eis;
	}
	
	// Epithete Cultivar
	public function getEpitheteCultivar()
	{
		return $this->epithete_cultivar;
	}
	public function setEpitheteCultivar( $ec )
	{
		$this->epithete_cultivar = $ec;
	}

	// Intitule Groupe Cultivar
	public function getIntituleGroupeCultivar()
	{
		return $this->intitule_groupe_cultivar;
	}
	public function setIntituleGroupeCultivar( $igc )
	{
		$this->intitule_groupe_cultivar = $igc;
	}

	// Formule Hybridite
	public function getFormuleHybridite()
	{
		return $this->formule_hybridite;
	}
	public function setFormuleHybridite( $fh )
	{
		$this->formule_hybridite = $fh;
	}
	
	// Phrase Nom Non Nomme
	public function getPhraseNomNonNomme()
	{
		return $this->phrase_nom_non_nomme;
	}
	public function setPhraseNomNonNomme( $pnnn )
	{
		$this->phrase_nom_non_nomme = $pnnn;
	}
	
	/*** Méthodes : ***/
	
	/** Méthode formaterNom() - Retourne un nom formater suivant le type demandé
	* 
	* Retourne une chaine correspondant au nom formaté.
	* 
	* @param int le type de format.
	* @return array
	* @access public
	*/
	function formaterNom($type = EF_NOM_FORMAT_SIMPLE)
	{
		// Constitution du nom:
		$nom = '';
		
		if ($this->getNomSupraGenerique() != '') {
		    $nom .= $this->getNomSupraGenerique();
		} else if ($this->getEpitheteInfraGenerique() != '') {
		    $nom .= $this->getEpitheteInfraGenerique();
		} else {
			if ($this->getNomGenre() != '') {
			    $nom .= $this->getNomGenre();
			}
			if ($this->getEpitheteEspece() != '') {
			    $nom .= ' '.$this->getEpitheteEspece();
			}
			if ($this->getEpitheteInfraSpecifique() != '') {
				if (!empty($this->enrg_abreviation_rang)) {
					$nom .= ' '.$this->enrg_abreviation_rang.'';
				}
				if ($this->enrg_id_rang == NomRang::CULTIVAR || $this->enrg_id_rang == NomRang::CULTIVAR_HYBRIDE) {
					$nom .= ' \''.$this->getEpitheteInfraSpecifique().'\'';
				} else {
					$nom .= ' '.$this->getEpitheteInfraSpecifique();
				}
			}
		}
		
		// Gestion des noms d'ateurs
		$auteurs = $this->retournerAuteur();
		
		// Complément en fonction du type de nom
		switch ($type) {
			case EF_NOM_FORMAT_ULTRA_SIMPLE :
				break;
			case EF_NOM_FORMAT_SIMPLE :
				// Ajout de l'auteur au nom
				$nom .= $auteurs;
				// Gestion de la citation biblio
				if ($annee = $this->retournerAnnee()) {
					$nom .= ', '.$annee;
				}
				break;
			case EF_NOM_FORMAT_COMPLET :
				// Ajout de l'auteur au nom
				$nom .= $auteurs;
				
				// Gestion de l'auteur "in"
				if ($auteur_in = $this->retournerAuteurIn()) {
					$nom .= ' in '.$auteur_in;
				}

				// Gestion de la citation biblio
				if ($biblio = $this->retournerBiblioAnnee()) {
					$nom .= ' ['.$biblio.']';
				}
				
				// Gestion du commentaire "nomenclatural"
				// A FAIRE : régler le problème des enic_intitule_cn_complet différent du enic_intitule_cn_origine 
				if ($commentaire = $this->retournerCommentaireNomenclatural()) {
					$nom .= ' '.$commentaire;
				}
				break;
		}
		return $nom;
	}
	
	public function retournerTabloNomLatin()
	{
		// Constitution du nom:
		$nom = array();
		
		if ($this->getNomSupraGenerique() != '') {
		    $nom['nom_supra_generique'] = $this->getNomSupraGenerique();
		} else if ($this->getEpitheteInfraGenerique() != '') {
		    $nom['epithete_infra_generique'] = $this->getEpitheteInfraGenerique();
		} else {
			if ($this->getNomGenre() != '') {
			    $nom['nom_genre'] = $this->getNomGenre();
			}
			if ($this->getEpitheteEspece() != '') {
			    $nom['epithete_espece'] = $this->getEpitheteEspece();
			}
			if ($this->getEpitheteInfraSpecifique() != '') {
				if (!empty($this->enrg_abreviation_rang)) {
					$nom['abbreviation_rang'] = $this->enrg_abreviation_rang;
				}
				$nom['epithete_infra_specifique'] = $this->getEpitheteInfraSpecifique();
			}
		}
		return $nom;
	}
	
	public function retournerAuteur()
	{
		$auteurs = '';
		$auteur_basio = '';
		$auteur_modif = '';
		if (!empty($this->abreviation_auteur_basio_ex) && $this->getCe('auteur_basio_ex') != 0) {
		    $auteur_basio .= $this->abreviation_auteur_basio_ex;
		    if (!empty($this->abreviation_auteur_basio)) {
		        $auteur_basio .= ' ex '.$this->abreviation_auteur_basio;
		    }
		} else if (!empty($this->abreviation_auteur_basio) && $this->getCe('auteur_basio') != 0) {
		    $auteur_basio .= $this->abreviation_auteur_basio;
		}
		
		if (!empty($this->abreviation_auteur_modif_ex) && $this->getCe('auteur_modif_ex') != 0) {
		    $auteur_modif .= $this->abreviation_auteur_modif_ex;
		    if (!empty($this->abreviation_auteur_modif)) {
		        $auteur_modif .= ' ex '.$this->abreviation_auteur_modif;
		    }
		} else if (!empty($this->abreviation_auteur_modif) && $this->getCe('auteur_modif') != 0) {
		    $auteur_modif .= $this->abreviation_auteur_modif;
		}
		
		if (!empty($auteur_modif)) {
		    $auteurs = ' ('.$auteur_basio.') '.$auteur_modif;
		} elseif (!empty($auteur_basio)) {
		    $auteurs = ' '.$auteur_basio;
		}
		
		return $auteurs ;
	}	
	
	public function retournerAuteurPrincipal()
	{
		if (!empty($this->abreviation_auteur_modif) && $this->getCe('auteur_modif') != 0) {
		    return $this->abreviation_auteur_modif;
		} else {
			if (!empty($this->abreviation_auteur_basio) && $this->getCe('auteur_basio') != 0) {
				return $this->abreviation_auteur_basio;
			} else {
				return false;
			}
		}
	}
	
	public function retournerAuteurIn()
	{
		if (!empty($this->enci_ce_auteur_in)) {
			switch ($this->enci_ce_auteur_in) {
				case 0 :
				case 1 :
				case 2 :
					return false;
				default :
					return $this->abreviation_auteur_in;
			}
		} else {
			return false;
		}
	}
	
	public function retournerAnnee()
	{
		if (!empty($this->enci_annee_citation)) {
			return $this->enci_annee_citation;
		} else {
			return false;
		}
	}
	
	public function retournerBiblio()
	{
		if (!empty($this->enci_intitule_citation_origine)) {
			return $this->enci_intitule_citation_origine;
		} else {
			return false;
		}
	}
	
	public function retournerBiblioAnnee()
	{
		if (!empty($this->enci_annee_citation) || !empty($this->enci_intitule_citation_origine)) {
			$biblio = '';	
			if (!empty($this->enci_annee_citation) && !empty($this->enci_intitule_citation_origine)) {
				$biblio .= $this->enci_annee_citation.', '.$this->enci_intitule_citation_origine;
			} else {
				if (!empty($this->enci_annee_citation)) {
					$biblio .= $this->enci_annee_citation;
				}
				if (!empty($this->enci_intitule_citation_origine)) {
					$biblio .= $this->enci_intitule_citation_origine;
				}
			}
			return $biblio;
		} else {
			return false;
		}
	}	
	
	public function retournerCommentaireNomenclatural()
	{
		if (!empty($this->enic_intitule_cn_origine)) {
			return $this->enic_intitule_cn_origine;
		}
	}	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: NomDeprecie.class.php,v $
* Revision 1.1  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.18  2006-05-16 09:27:34  jp_milcent
* Gestion des correspondances.
* Ajout du plier/deplier.
*
* Revision 1.17  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.16  2005/12/08 15:01:50  jp_milcent
* Amélioration méthode retour auteur principal
*
* Revision 1.15  2005/12/08 13:43:21  jp_milcent
* Correction affichage des auteurs.
*
* Revision 1.14  2005/12/06 16:39:29  jp_milcent
* Ajout d'une méthode renvoyant un tableau décomposant le nom latin.
*
* Revision 1.13  2005/12/05 14:28:15  jp_milcent
* Correction affichage des cultivars.
*
* Revision 1.12  2005/10/26 16:36:25  jp_milcent
* Amélioration des pages Synthèses, Synonymie et Illustrations.
*
* Revision 1.11  2005/10/21 16:28:54  jp_milcent
* Amélioration des onglets Synonymies et Synthèse.
*
* Revision 1.10  2005/10/20 16:37:49  jp_milcent
* Amélioration de l'onglet Synthèse.
*
* Revision 1.9  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.8  2005/10/06 20:23:30  jp_milcent
* Ajout de classes métier pour le module Nomenclature.
*
* Revision 1.7  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
* Revision 1.6  2005/09/16 16:41:45  jp_milcent
* Gestion de l'onglet Synthèse en cours.
* Création du modèle pour l'attribution des noms vernaculaires aux taxons.
*
* Revision 1.5  2005/09/12 16:22:44  jp_milcent
* Fin de gestion de la recherche des noms latins pour tous les référentiels.
*
* Revision 1.4  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.3  2005/08/03 15:52:31  jp_milcent
* Fin gestion des résultats recherche nomenclaturale.
* Début gestion formulaire taxonomique.
*
* Revision 1.2  2005/08/02 16:19:33  jp_milcent
* Amélioration des requetes de recherche de noms.
*
* Revision 1.1  2005/08/01 16:18:39  jp_milcent
* Début gestion résultat de la recherche par nom.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>