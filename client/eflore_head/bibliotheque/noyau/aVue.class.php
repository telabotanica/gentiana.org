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
// CVS : $Id$
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
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

abstract class aVue {

	/*** Constantes : ***/
	const TPL_IT = 'IT';
	const TPL_PHP = 'PHP';
	const TPL_FPDI = 'FPDI';
	const FORMAT_HTML = 'html';
	const FORMAT_EXIT_HTML = 'exit.html';
	const FORMAT_JSON = 'json';
	const FORMAT_EXIT_JSON = 'exit.json';
	const FORMAT_PDF = 'pdf';
	
	/*** Attributs : ***/
	
	/**
	* Contient le nom de la vue.
   * @access private
	*/
	private $nom = '';
	
	/**
	* Contient le Registre du module.
	* @access private
	*/
	private $registre = null;

	/**
	* Contient le type de rendu.
	* @access private
	*/
	private $format = aVue::FORMAT_HTML;

	/**
	* Permet de savoir si oui ou non, la vue utilise un template..
	* @access private
	*/
	private $utilise_tpl = true;
	
	/**
	* Indique le type de moteur de template utilisé.
	* @access private
	*/
	private $moteur_tpl = aVue::TPL_IT;
	
	/**
	* Contient l'objet Template ou le contenu à rendre.
   * @access private
	*/
	private $squelette;
	
	/**
	* contient les données pour le Template.
	* @access private
	*/
	private $donnees = array();
	
	/**
	* contient le chemin vers les squelettes.
	* @access private
	*/
	private $chemin = '';

	/**
	* contient le nom du fichier contenant le squelette.
	* @access private
	*/
	private $fichier = '';

	/**
	* contient le chemin et le nom du fichier contenant le squelette.
	* @access private
	*/
	private $chemin_fichier = '';
	
	/*** Constructeurs : ***/
	
	/**
	* @param string filename of template
	*/
	public function __construct($Registre)
	{	
		// Ajout du registre à l'objet Vue
		$this->setRegistre($Registre);
		
		// Attribution des attributs à la vue
		$this->setDonnees($Registre->get('vue_donnees'));
		if (!is_null($Registre->get('vue_format'))) {
			$this->setFormat($Registre->get('vue_format'));
		}
		if (!is_null($Registre->get('vue_chemin_squelette'))) {
			$this->setChemin($Registre->get('vue_chemin_squelette'));
		}
		
		if (!is_null($Registre->get('vue_chemin_squelette_projet'))) {
			if (file_exists($Registre->get('vue_chemin_squelette_projet').$this->getNom().'.tpl.'.$this->getFormat())) {
				$this->setChemin($Registre->get('vue_chemin_squelette_projet'));
			}
		}
	
		$this->setFichier($this->getNom().'.tpl.'.$this->getFormat());
		$this->setCheminFichier($this->getChemin().$this->getFichier());
	}
	
	/*** Accesseurs : ***/	
	
	// Nom
	/**
	* @return string le nom de la vue.
	*/
	public function getNom() {
		return $this->nom;
	}
	/**
	* @param string le nom de la vue.
	*/
	public function setNom($nom) {
		$this->nom = $nom;
	}
	
	// Registre 
	/**
	* @return object le registre du module.
	*/
	public function getRegistre() {
		return $this->registre;
	}
	/**
	* @param Registre le registre du module.
	*/
	public function setRegistre($r) {
		$this->registre = $r;
	}
	
	// Format
	/**
	* @return string le format des squelettes.
	*/
	public function getFormat() {
		return $this->format; 
	}
	/**
	* @param string le format des squelettes.
	*/
	public function setFormat($format) {
		if (!is_null($format)) {
			$this->format = $format;
		} else {
			$this->format = Vue::FORMAT_HTML;
		} 
	}

	// Utilise Tpl
	/**
	* @return boolean si oui (true) ou non (false), un système template et utilisé.
	*/
	public function getUtiliseTpl() {
		return $this->utilise_tpl;
	}
	/**
	* @param boolean si oui (true) ou non (false), un système template et utilisé.
	*/
	public function setUtiliseTpl($ut) {
		$this->utilise_tpl = $ut;
	}

	// Moteur Tpl
	/**
	* @return string retourne le type de moteur de template utilisé.
	*/
	public function getMoteurTpl() {
		return $this->moteur_tpl;
	}
	/**
	* @param string définit le type de moteur de template utilisé..
	*/
	public function setMoteurTpl($mt) {
		switch ($mt) {
			case aVue::TPL_IT:
			case aVue::TPL_FPDI:
			case aVue::TPL_PHP:
				$this->setUtiliseTpl(true);
				$this->moteur_tpl = $mt;
				break;
			default:
				trigger_error("Ce moteur de template n'est pas disponible", E_USER_ERROR);
		}
	}
	
	// Chemin
	/**
	* @return string le chemin vers les squlettes.
	*/
	public function getChemin() {
		return $this->chemin;
	}
	/**
	* @param string le chemin vers les squelettes.
	*/
	public function setChemin($chemin) {
		$this->chemin = $chemin;
	}

	// Fichier
	/**
	* @return string le nom du fichier de squelette.
	*/
	public function getFichier() {
		return $this->fichier;
	}
	/**
	* @param string le nom du fichier de squelette.
	*/
	public function setFichier($nom) {
		$this->fichier = $nom;
	}

	// CheminFichier
	/**
	* @return string le chemin et le nom du fichier de squelette.
	*/
	public function getCheminFichier() {
		return $this->chemin_fichier;
	}
	/**
	* @param string le chemin et le nom du fichier de squelette.
	*/
	public function setCheminFichier($cf) {
		$this->chemin_fichier = $cf;
	}

	
	// Squelette
	/**
	* @return object un template concret.
	*/
	public function getSquelette() {
		return $this->squelette;
	}
	/**
	* @param object un template concret.
	*/
	public function setSquelette($squelette) {
		$this->squelette = $squelette;
	}
	
	// Données
	/**
	* @return mixed la valeur du tableau pour une clé données, un table vide si elle n'est pas trouvé ou le tableau si
	* aucun paramêtre n'est fournit.
	*/
	public function getDonnees($cle = NULL) {
		if (!is_null($cle)) {
			if (array_key_exists($cle, $this->donnees)) {
				return $this->donnees[$cle];
			} else {
				return array();
			}
		} else {
			return $this->donnees;
		}
	}
	/**
	* @param array le tableau des données à insérer dans la vue.
	*/
	public function setDonnees( $donnees, $cle = null ) {
		if (!is_null($cle)) {
			$this->donnees[$cle] = $donnees;
		} else {
			$this->donnees = $donnees;
		}
	}
	
	/*** Méthodes : ***/
	
	public function chargerSquelette()
	{
		if ($this->getUtiliseTpl()) {
			switch ($this->getMoteurTpl()) {
				case aVue::TPL_IT :
					// Nous n'éffaçons pas les variables pour permettre l'i18n
					$squelette = file_get_contents($this->getCheminFichier());
					// Nous recherchons la présence de variable en minuscule qui correspondent aux textes I18N
					if (preg_match('/{[a-z_]+}/sm', $squelette)) {
						// Nous ne supprimons pas les variables pour les remplacer ensuite
						$this->getSquelette()->setTemplate($squelette, false, true );
					} else {
						$this->getSquelette()->setTemplate($squelette, true, true );
					}
					break;
				case aVue::TPL_FPDI :
					$pdf= new fpdi();
					$pdf->setSourceFile($this->getCheminFichier());
					$this->setSquelette( $pdf );
					break;
				case aVue::TPL_PHP :
					$this->setSquelette(new SquelettePhp($this->getCheminFichier()));
					break;
			}
		}
	}

	abstract public function preparer();
	
	/**
	* Retourne le rendu du squelette.
	* @return void
	* @access public
	*/
	public function retournerRendu()
	{
		if ($this->getUtiliseTpl()) {
			switch ($this->getMoteurTpl()) {
				case aVue::TPL_IT :
					// Les variables restantes sont traduites en analisant de nouveau le template 
					// Nous incluons le tableau contenant les chaines de caractères traduites.
					if ($this->getSquelette()->removeUnknownVariables == 0) {
						$aso_i18n = null;
						if ($this->getRegistre()->get('module_i18n')) {
							$aso_i18n = $this->getRegistre()->get('module_i18n');
						}
						//echo '<pre>'.print_r($aso_i18n, true).'</pre>';
						$tpl = $this->getSquelette()->get();
						$this->getSquelette()->setTemplate($tpl);
						$this->getSquelette()->setCurrentBlock();
						$this->getSquelette()->setVariable($GLOBALS['_EF_']['i18n']['_defaut_']['general']);
						if (!is_null($aso_i18n) && isset($aso_i18n[$this->getNom()])) {
							$this->getSquelette()->setVariable($aso_i18n[$this->getNom()]);
						}
						$this->getSquelette()->parseCurrentBlock();
					}
					return $this->getSquelette()->get();
					break;
				case aVue::TPL_FPDI :
					return $this->getSquelette()->Output(null, 'S');
					break;
				case aVue::TPL_PHP :
					return $this->getSquelette()->analyser();
					break;
			}
		} else {
			return $this->getSquelette();
		}
	}
	
	/** 
	* Trier un tableau multidimensionnel sur le second index.
	* 
	* @link http://fr.php.net/manual/fr/function.asort.php
	* @copyright rcwang@cmu.edu
	* @version 03-Mar-2002 02:42
	*/
	function trierParSecondIndex($multiArray, $secondIndex)
	{
	   while (list($firstIndex, ) = each($multiArray))
	       $indexMap[$firstIndex] = $multiArray[$firstIndex][$secondIndex];
	   asort($indexMap);
	   while (list($firstIndex, ) = each($indexMap))
	       if (is_numeric($firstIndex))
	           $sortedArray[] = $multiArray[$firstIndex];
	       else $sortedArray[$firstIndex] = $multiArray[$firstIndex];
	   return $sortedArray;
	} 
} 


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.6  2007-02-07 18:04:45  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.5  2007/01/30 16:04:16  ddelon
* Gestion squelette par projet et ajout nouveau squelette pour flore afrique du nord (backport de la livraison moquin_tandon vers HEAD)
*
* Revision 1.4  2007/01/24 16:34:17  jp_milcent
* Ajout format JSON.
*
* Revision 1.3.6.1  2007/01/30 13:01:49  ddelon
* Gestion squelette par projet et ajout nouveau squelette pour flore afrique du nord
*
* Revision 1.3  2006/07/11 16:33:09  jp_milcent
* Intégration de l'appllette Xper.
*
* Revision 1.2  2006/07/07 09:53:21  jp_milcent
* Correction de bogues dûs au changement de nom des classes du noyau.
*
* Revision 1.1  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.10  2006/07/06 12:35:19  jp_milcent
* Seul les templates possédant des chaines I18N sont analysées une deuxième fois.
*
* Revision 1.9  2006/05/16 16:21:23  jp_milcent
* Ajout de l'onglet "Informations" au module ef_recherche permettant d'avoir des informations sur les référentiels tirées de la base de données.
*
* Revision 1.8  2006/05/11 10:28:27  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.7  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.6  2005/12/21 16:02:42  jp_milcent
* Gestion de la localisation.
*
* Revision 1.5  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.4  2005/10/11 17:30:31  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
* Revision 1.3  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.2  2005/08/17 15:37:50  jp_milcent
* Gestion de la rechercher par taxon en cours...
*
* Revision 1.1  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>