<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                      |
// |                                                                                                      |
// | eflore_bp is free software; you can redistribute it and/or modify                                    |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_bp is distributed in the hope that it will be useful,                                         |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: Chorologie.class.php,v 1.34 2007-09-25 08:59:06 jp_milcent Exp $
/**
* eflore_bp - Chorologie.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.34 $ $Date: 2007-09-25 08:59:06 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class Chorologie extends aModule {
	private $projet_choro = null;
	
	public function __construct()
	{
		parent::__construct();
		if (defined('CHORO_PROJET_ID')) {
			$this->projet_choro = CHORO_PROJET_ID;
		}
		if (is_null($this->projet_choro)){
			$e = 'Veuillez définir la constante CHORO_PROJET_ID pour utiliser cette application.';
			trigger_error($e, E_USER_ERROR);
		}
	}
	
	public static function getAppletteBalise()
	{
		return '\{\{Chorologie(?:\s*(?:(action="[^"]+")|(nvp="[^"]+")|))+\s*\}\}';
	}
	
	public function getCache($action)
	{
		ksort($_GET);
		switch ($action) {
			case 'AccesParZone' :
			case 'AccesParTaxon' :
			case 'AccesParCarte' :
			case 'Liste' :
			case 'CartePresence' :
			case 'ExportListeTaxons' :
				$cache_id = '';
				if (isset($_GET['module'])) {
					$cache_id .= '[module#'.$_GET['module'].']_';
				}
				if (isset($_GET['action'])) {
					$cache_id .= '[action#'.$_GET['action'].']_';
				}
				foreach ($_GET as $cle => $val) {
					if (!preg_match('/^(?:module|action|format|frag_nbre)$/', $cle)) {
						$cache_id .= '['.$cle.'#'.urldecode($val).']_';
					}
				}
				if (isset($_GET['frag_nbre'])) {
					$cache_id .= '[frag#'.$_GET['frag_nbre'].']';
				} else if (isset($_SESSION['fragmenteur']['par_page'])) {
					$cache_id .= '[frag#'.$_SESSION['fragmenteur']['par_page'].']';
				}
				$cache_id .= '_[eprc#'.$this->projet_choro.']';
				break;
			default:
				$cache_id = null;// Pas de cache;
		}
		
		return $cache_id;
	}
	
	public function getCacheDlc($action)
	{
		switch ($action) {
			case 'AccesParZone' :
			case 'AccesParTaxon' :
			case 'AccesParCarte' :
			case 'Liste' :
			case 'CartePresence' :
			case 'ExportListeTaxons' :
				$dlc = 30*24*3600;// 1 mois;
				break;
			default:
				$dlc = 0;// Pas de cache;
		}
		return $dlc;
	}
	
	// La méthode executer est appellé par défaut
	public function executer()
	{ 
		// Si on veut rediriger l'action vers une autre méthode, il faut définir le nom de la nouvelle action.
		$this->getRegistre()->set('action', 'acces_par_carte');
		$this->executerAccesParCarte();
	}
	
	public function executerAccesParTaxon()
	{
		// Initialisation des variables
		$this->setChrono('debut');
		$aso_donnees = array();
		$this->getRegistre()->set('squelette_moteur', aModule::TPL_PHP);

		// Instanciation des classes métiers nécessaires
		$Chorologie = new EfloreChorologie();
		$Vernaculaire = new EfloreVernaculaire();
		$Nom = new EfloreNom();
		
		// Gestion des urls
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		$url->addQueryString('module', 'chorologie');
		$url->addQueryString('action', 'acces_par_taxon');

		// Création du Fragmenteur
		$Fragmenteur = new Fragmenteur($url, CHORO_FRAG_LETTRE_DEFAUT);
		
		// Gestion de la limitation aux taxons protégés.
		$limitation = false;
		if (CHORO_PROTECTION) {
			$limitation['statut'] = CHORO_PROTECTION_STATUT;
			$limitation['texte_application'] = CHORO_PROTECTION_TXT;
		}
		
		// Calcul du nombre de données max à afficher
		$page_donnees_nbre_total = $Chorologie->consulterTaxonsNbre($this->projet_choro, null, null, '*', $limitation);
		if ($Fragmenteur->getLettre() != '*') {
			$Fragmenteur->setDonneesTotal($Chorologie->consulterTaxonsNbre($this->projet_choro, null, null, $Fragmenteur->getLettre(), $limitation));
		} else {
			$Fragmenteur->setDonneesTotal($page_donnees_nbre_total); 
		}

		// Execution du Fragmenteur
		$aso_donnees = array_merge($aso_donnees, $Fragmenteur->executer());
		list($de, $a) = $Fragmenteur->getDeplacementParPageId();
						
		// Récupération des données
		$Chorologie->setLimit($Fragmenteur->getPageSaut(), $de - 1);
		$Chorologie->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$tab_donnees = $Chorologie->consulterTaxons($this->projet_choro, null, null, $Fragmenteur->getLettre(), $limitation);
		// TODO : simplifer l'écriture de l'accès au mode de rendu des données du Wrapper SQL
		$Chorologie->getWrapperSql()->setMode();// On remet en mode par défaut
		
		// Gestion de l'url de la carte de présence des taxons
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		$url->addQueryString('module', 'chorologie');
		$url->addQueryString('action', 'carte_presence');
		$url->addQueryString('format', 'html');
		
		// Ajout aux tableaux des données les noms latins formatés
		if (!empty($tab_donnees)) {
			$FormatageNom = Composant::fabrique('formatage_nom');
			$FormatageNom->setType(EfloreNom::FORMAT_SIMPLE);
			
			foreach ($tab_donnees as $taxon) {
				$id = $taxon['esn']['id']['version_projet_taxon'].'-'.$taxon['esn']['id']['taxon'];
				$url->addQueryString('pr', $taxon['esn']['id']['version_projet_taxon']);
				$url->addQueryString('nt', $taxon['esn']['id']['taxon']);
			
				$tab_info  = array(
					'nom_id' => $taxon['en']['id']['nom'],
					'taxon_id' => $taxon['esn']['id']['taxon'],
					'taxon_projet_id' => $taxon['esn']['id']['version_projet_taxon'],
					'nom_latin' => $FormatageNom->formater($taxon),
					'url_carte_presence' => $url->getURL()
					);
				
				$tab_taxons[$taxon['esn']['id']['version_projet_taxon']][$taxon['esn']['id']['taxon']] = $tab_info;
				$aso_donnees['taxons'][$id] = $tab_info;
			}

			$tab_vernas = $Vernaculaire->consulterTaxonsNomTypique($tab_taxons);
			// Ajout aux tableaux des données les noms vernaculaires formatés
			foreach ($tab_vernas as $verna) {
				$id = $verna['eva']['id']['version_projet_taxon_ref'].'-'.$verna['eva']['id']['taxon_ref'];
				$aso_donnees['taxons'][$id]['nom_verna'] = $verna['ev']['intitule_nom_vernaculaire'];
			}
		}
		
		// Informations diverses
		$aso_donnees['index'] = $aso_donnees['frag_donnee_debut'] + 1;
		$aso_donnees['taxons_nbre_lettre'] = $Fragmenteur->getDonneesTotal();
		$aso_donnees['taxons_nbre_total'] = $page_donnees_nbre_total;
		
		// Gestion du trie
		$tt = 'nl';
		if (isset($_GET['tt'])) {
			$tt = 'nl';
		}
		$to = 'asc';
		if (isset($_GET['to'])) {
			$to = $_GET['to'];
		}
		$this->trierDonnees(&$aso_donnees['taxons'], $tt, $to);
		
		// Attribution des données pour remplir le squelette
		$this->getRegistre()->set('squelette_donnees', $aso_donnees);
		$this->setChrono('fin');
	}
	
	public function executerAccesParZone()
	{
		// Initialisation des variables
		$this->setChrono('debut');
		$aso_donnees = array();
		$this->getRegistre()->set('squelette_moteur', aModule::TPL_PHP);

		// Instanciation des classes métiers nécessaires
		$Chorologie = new EfloreChorologie();
		//$Chorologie->setDebogage(true);
		
		// Gestion des urls
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		$url->addQueryString('module', 'chorologie');
		$url->addQueryString('action', 'acces_par_zone');
		
		// Création du Fragmenteur
		$Fragmenteur = new Fragmenteur($url, CHORO_FRAG_LETTRE_DEFAUT);
		
		// Calcul du nombre de données max à afficher
		$page_donnees_nbre_total = $Chorologie->consulterZoneGeoNombre($this->projet_choro);
		if ($Fragmenteur->getLettre() != '*') {
			$Fragmenteur->setDonneesTotal($Chorologie->consulterZoneGeoNombre($this->projet_choro, $Fragmenteur->getLettre()));
		} else {
			$Fragmenteur->setDonneesTotal($page_donnees_nbre_total); 
		}
		
		$aso_donnees = array_merge($aso_donnees, $Fragmenteur->executer());
		list($de, $a) = $Fragmenteur->getDeplacementParPageId();
						
		// Récupération des données
		$Chorologie->setLimit($Fragmenteur->getPageSaut(), $de - 1);
		$Chorologie->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		if ($Fragmenteur->getLettre() != '*') {
			$tab_donnees = $Chorologie->consulterZoneGeo($this->projet_choro, $Fragmenteur->getLettre());
		} else {
			// TODO : simplifer l'écriture de l'accès au mode de rendu des données du Wrapper SQL
			$tab_donnees = $Chorologie->consulterZoneGeo($this->projet_choro);
		}
		$Chorologie->getWrapperSql()->setMode();// On remet en mode par défaut
		
		// Gestion de l'url de la carte de présence des taxons
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		$url->addQueryString('module', 'chorologie');
		$url->addQueryString('action', 'liste');
		
		// Ajout aux tableaux des données les noms latins formatés
		if (count($tab_donnees) > 0) {
			foreach ($tab_donnees as $zone) {
				$url->addQueryString('zg_projet', EfloreZoneGeographique::getCodeProjet($zone['ezg']['id']['projet_zg']));
				$url->addQueryString('zg_code', $zone['ezg']['code']);
				$aso_donnees['zones'][]  = array(
					'nom' => $zone['ezg']['intitule_principal'],
					'code' => $zone['ezg']['code'],
					'url_liste' => $url->getURL()
					);
			}
		}
		
		// Informations diverses
		$aso_donnees['index'] = $aso_donnees['frag_donnee_debut'] + 1;
		$aso_donnees['taxons_nbre_lettre'] = $Fragmenteur->getDonneesTotal();
		$aso_donnees['taxons_nbre_total'] = $page_donnees_nbre_total;
		
		// Gestion du trie
		$tt = 'nc';
		if (isset($_GET['tt'])) {
			$tt = $_GET['tt'];
		}
		$to = 'asc';
		if (isset($_GET['to'])) {
			$to = $_GET['to'];
		}
		$this->trierDonnees(&$aso_donnees['zones'], $tt, $to);
					
		// Attribution des données pour remplir le squelette
		$this->getRegistre()->set('squelette_donnees', $aso_donnees);
		$this->setChrono('fin');
	}
			
	public function executerAccesParCarte()
	{
		// Initialisation de variables
		$this->setChrono('debut');
		$aso_donnees = array();
		// Ajout d'info au Registre
		// TODO : instancier "cpr" depuis le fichier principal eflore.php
		$this->getRegistre()->set('cpr', 'infloris');// Code du projet
		// TODO : instancier "cprv" depuis le fichier principal eflore.php
		$this->getRegistre()->set('cprv', '1.00');// Code du projet

		// Définition du nom de la carte
		$fichier_carte_fond = 'isere.png';
		$type_carte = str_replace('.png', '', $fichier_carte_fond);
		$nom_carte_commun = $type_carte.'_'.$this->getRegistre()->get('cpr').'_'.$this->getRegistre()->get('cprv').'_generale';
		$nom_carte_commun .= (CHORO_PROTECTION) ? '_protec': '';
		$nom_carte_png = $nom_carte_commun.'.png';
		$nom_carte_map = $nom_carte_commun.'.map';
		$nom_carte_leg = $nom_carte_commun.'.leg';
		
		// Récupération des infos sur le projet
		$aso_donnees = array_merge($aso_donnees, $this->getInfoProjet());
		
		// Gestion de la limitation aux taxons protégés.
		$limitation = false;
		if (CHORO_PROTECTION) {
			$limitation['statut'] = CHORO_PROTECTION_STATUT;
			$limitation['texte_application'] = CHORO_PROTECTION_TXT;
		}
		
		// Création de la carte
		$Carte = new Cartographie();
		$Carte->setCarteNom($nom_carte_png);// Nous donnons le nom de la carte
		$Carte->setCarteInfo(array('donnees_date_maj' => $aso_donnees['version_date_maj']));
		// TODO : mettre le chemin de stockage des cartes dans le tableau des infos de la carte, utiliser setCarteInfo()
		$Carte->setCarteStockageDossier(EF_CHEMIN_CARTE_STOCKAGE);// Nous définissons le chemin contenant les cartes créées
		//$aso_donnees['choro_debog_info'] = print_r($Carte->getCarteCache(), true);
		if (!$Carte->getCarteCache() || !EF_BOOL_STOCKAGE_CACHE) {
			// Récolte d'info pour les zones renseignées
			$Chorologie = new EfloreChorologie();
			$tab_zones = $Chorologie->consulterDonnees($this->projet_choro, $limitation);
			$tab_carte_zones = array();
			foreach ($tab_zones as $zone) {
				$tab_zone = array();
				$tab_zone['nom'] = $zone['ezg']['intitule_principal'];
				$tab_zone['rvb_fond'] = $zone['ezg']['couleur_rvb'];
				$tab_zone['info_nombre'] = $zone['ecd']['donnee_choro_nbre'];
				$tab_carte_zones[$zone['ezg']['code']] = $tab_zone;
				
			}

			// Nous rechercons maintenant les zones non renseignée.
			$ZoneGeo = new EfloreZoneGeographique();
			$tab_zg_isere = $ZoneGeo->consulterZgParCode(23, '38%');// Toutes les communes de l'Isère
			//$this->setDebogage($tab_zg_isere);			
			foreach ($tab_zg_isere as $zone) {
				if (!isset($tab_carte_zones[$zone['ezg']['code']])) {
					$tab_zone = array();
					$tab_zone['nom'] = $zone['ezg']['intitule_principal'];
					$tab_zone['rvb_fond'] = $zone['ezg']['couleur_rvb'];
					$tab_zone['info_nombre'] = 0;
					$tab_carte_zones[$zone['ezg']['code']] = $tab_zone;
				}
			}
			//$this->setDebogage($tab_carte_zones);
			// Nous définissons la formule de coloriage de la carte et les couleurs éventuellement nécessaire
			$Carte->setFormuleColoriage('proportionnel');
			$Carte->setColoriageCouleurFoncee(CHORO_COULEUR_FONCE);
			$Carte->setColoriageCouleurClaire(CHORO_COULEUR_CLAIRE);
			// Nous définissons le fichier contenant le fond de carte
			$Carte->setCarteFondFichier($fichier_carte_fond);
			// Nous définissons le dossier contenant les fonds de carte
			$Carte->setCarteFondDossier(EF_CHEMIN_CARTE_SRC);
			// Nous indiquons les informations sur les zones géographiques
			$Carte->setCarteZoneInfo($tab_carte_zones);
			// Lancement de la création de la carte
			$Carte->creerCarte();
			// Traitement du tableau des fréquences pour créer une légende
			$pas = CHORO_LEGENDE_PAS; $compteur = 0; $i = 0;$j = 1;
			$nbre_freq = count($Carte->getTableauFrequence());
			foreach ($Carte->getTableauFrequence() as $freq => $rvb) {
				if ((($compteur / $pas) == 1) || $i == 0 || $j == $nbre_freq) {
					$compteur = 0;
					$freq_min = 0;
					if (isset($aso_donnees['legendes'][($i-1)]['freq_max'])) {
						$freq_min = $aso_donnees['legendes'][($i-1)]['freq_max']+1;
					}
					$rvb = str_replace('-', ',', $rvb);
					$aso_donnees['legendes'][$i++] = array('rvb' => $rvb, 'freq_max' => $freq+1, 'freq_min' => $freq_min);
				}
				$compteur++; $j++;
			}
			if (!file_put_contents(EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_leg, serialize($aso_donnees['legendes']))) {
				$e = 'Écriture du fichier .leg impossible : '.EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_leg;
				trigger_error($e, E_USER_WARNING);
			}
		}
		
		// Récupération de la légende depuis le cache
		if (file_exists(EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_leg)) {
			$aso_donnees['legendes'] = unserialize(file_get_contents(EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_leg));
		}
		
		// Gestion des urls
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		$url->addQueryString('module', 'chorologie');
		$url->addQueryString('action', 'liste');
		$aso_donnees['url'] = $url->getUrl();
		$aso_donnees['url_carte'] = sprintf(EF_URL_CARTO, $nom_carte_png);
		
		// Gestion de l'image map
		if (file_exists(EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_map)) {
			$aso_donnees['carte_map'] = file_get_contents(EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_map);
		} else {
			$aso_donnees['carte_map'] = file_get_contents(EF_CHEMIN_CARTE_SRC.'isere.map');
			$url_liste = clone $GLOBALS['_EFLORE_']['url_base'];
			$url_liste->addQueryString('module', 'chorologie');
			$url_liste->addQueryString('action', 'liste');
			$url_liste->addQueryString('zg_projet', '%s', true);
			$url_liste->addQueryString('zg_code', '%s', true);
			$url_liste->addQueryString('format', 'html');
			$url_liste = 'href="'.$url_liste->getUrl().'"';
			if (preg_match_all('/href="([A-Z_]+)-(\d+)"/', $aso_donnees['carte_map'], $matches)) {
				//echo '<pre>'.print_r($matches, true).'</pre>';
				$nbre_href = count($matches[0]);
				for ($i = 0; $i < $nbre_href ;$i++) {
					$remplacement = sprintf($url_liste, $matches[1][$i], $matches[2][$i]);
					$aso_donnees['carte_map'] = preg_replace('/'.$matches[0][$i].'/', $remplacement, $aso_donnees['carte_map']);
				}
			}
			if (!file_put_contents(EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_map, $aso_donnees['carte_map'])) {
				$e = 'Écriture du fichier .map impossible : '.EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_map;
				trigger_error($e, E_USER_WARNING);
			}
		}
		
		
		// Attribution des données pour remplir le squelette
		$this->getRegistre()->set('squelette_donnees', $aso_donnees);
		$this->setChrono('fin');
	}
	
	public function executerListe()
	{
		// Initialisation des variables
		$this->getRegistre()->set('squelette_moteur', aModule::TPL_PHP);
		$aso_donnees = array();
		
		// Instanciation des classes métiers nécessaires
		$ZoneGeo = new EfloreZoneGeographique();
		$Chorologie = new EfloreChorologie();
		$Vernaculaire = new EfloreVernaculaire();
		$Nom = new EfloreNom();
		
		// Récupération des données nécessaire à la chorologie
		$zg_projet_id = EfloreZoneGeographique::consulterZgProjetId($_GET['zg_projet']);
		$zg_info = $ZoneGeo->consulterZgParCode($zg_projet_id, $_GET['zg_code']);
		
		// Récupération des infos sur le projet
		$aso_donnees = array_merge($aso_donnees, $this->getInfoProjet());
		
		// Gestion de l'url pour le Fragmenteur
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		$url->addQueryString('module', 'chorologie');
		$url->addQueryString('action', 'liste');
		$url->addQueryString('zg_projet', $_GET['zg_projet']);
		$url->addQueryString('zg_code', $_GET['zg_code']);
		
		// Création du Fragmenteur
		$Fragmenteur = new Fragmenteur($url, CHORO_FRAG_LETTRE_DEFAUT);

		// Gestion de la limitation aux taxons protégés.
		$limitation = false;
		if (CHORO_PROTECTION) {
			$limitation['statut'] = CHORO_PROTECTION_STATUT;
			$limitation['texte_application'] = CHORO_PROTECTION_TXT;
		}
		
		// Récupération du nombre de données total pour le Fragmenteur
		$page_donnees_nbre_total = $Chorologie->consulterTaxonsNbre($this->projet_choro, $zg_info['ezg']['id']['zone_geo'], $zg_projet_id, '*', $limitation);
		if ($Fragmenteur->getLettre() != '*') {
			$Fragmenteur->setDonneesTotal($Chorologie->consulterTaxonsNbre($this->projet_choro, $zg_info['ezg']['id']['zone_geo'], $zg_projet_id, $Fragmenteur->getLettre(), $limitation));
		} else {
			$Fragmenteur->setDonneesTotal($page_donnees_nbre_total); 
		}
				
		// Execution du Fragmenteur
		$aso_donnees = array_merge($aso_donnees, $Fragmenteur->executer());
		list($de, $a) = $Fragmenteur->getDeplacementParPageId();
		
		// Récupération des données
		$Chorologie->setLimit($Fragmenteur->getPageSaut(), $de - 1);
		$Chorologie->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$tab_donnees = array();
		$tab_donnees = $Chorologie->consulterTaxons($this->projet_choro, $zg_info['ezg']['id']['zone_geo'], $zg_projet_id, $Fragmenteur->getLettre(), $limitation);
		// TODO : simplifer l'écriture de l'accès au mode de rendu des données du Wrapper SQL
		$Chorologie->getWrapperSql()->setMode();// On remet en mode par défaut
		
		// Gestion de l'url de la carte de présence des taxons
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		$url->addQueryString('module', 'chorologie');
		$url->addQueryString('action', 'carte_presence');
		$url->addQueryString('format', 'html');
		
		// Ajout aux tableaux des données les noms latins formatés
		$aso_donnees['taxons'] = array();
		$aso_donnees['legende_statut'] = array();
		$aso_donnees['legende_txt'] = array();
		if (is_array($tab_donnees) && count($tab_donnees) > 0) {
			$Protection = new EfloreProtection();
			$FormatageNom = Composant::fabrique('formatage_nom');
			$FormatageNom->setType(EfloreNom::FORMAT_SIMPLE);
			foreach ($tab_donnees as $taxon) {
				$id = $taxon['esn']['id']['version_projet_taxon'].'-'.$taxon['esn']['id']['taxon'];
				
				$url->addQueryString('pr', $taxon['esn']['id']['version_projet_taxon']);
				$url->addQueryString('nt', $taxon['esn']['id']['taxon']);

				$protections = $Protection->recupererProtections($taxon['esn']['id']['taxon'], $taxon['esn']['id']['version_projet_taxon'], $limitation);
				$protec = '';
				if (!empty($protections)) {
					foreach ($protections as $protection) {
						$protec .= $protection['txt_appli_abreviation'].' : '.$protection['statut_abreviation'].' ; '; 
					}
					// Gestion des légendes pour les statuts et les textes de protection
					foreach ($protections as $protection) {
						if (!isset($aso_donnees['legende_statut'][$protection['statut']])) {
							$aso_donnees['legende_statut'][$protection['statut']] = array(
								'statut_intitule' => $protection['statut_intitule'],
								'statut_abreviation' => $protection['statut_abreviation'],
								'statut_description' => $protection['statut_description']);
						}
						if (!isset($aso_donnees['legende_txt'][$protection['txt_appli']])) {
							$aso_donnees['legende_txt'][$protection['txt_appli']] = array(	
								'txt_appli_intitule' => $protection['txt_appli_intitule'],
								'txt_appli_abreviation' => $protection['txt_appli_abreviation'],
								'txt_appli_description' => $protection['txt_appli_description'],
								'txt_appli_url' => str_replace('&', '&amp;', $protection['txt_appli_url']),
								'txt_appli_nor' => $protection['txt_appli_nor']);
						}
					}
				}
								
				$tab_info  = array(
					'nom_id' => $taxon['en']['id']['nom'],
					'taxon_id' => $taxon['esn']['id']['taxon'],
					'taxon_projet_id' => $taxon['esn']['id']['version_projet_taxon'],
					'url_carte_presence' => $url->getURL(),
					'nom_latin' => $FormatageNom->formater($taxon),
					'protection' => trim($protec, ' ; '));
				
				$tab_taxons[$taxon['esn']['id']['version_projet_taxon']][$taxon['esn']['id']['taxon']] = $tab_info;
				$aso_donnees['taxons'][$id] = $tab_info;
			}
			EfloreTriage::trieMultiple($aso_donnees['legende_statut'], array('statut_abreviation', 'asc'));
			EfloreTriage::trieMultiple($aso_donnees['legende_txt'], array('txt_appli_abreviation', 'asc'));

			$tab_vernas = $Vernaculaire->consulterTaxonsNomTypique($tab_taxons);
			// Ajout aux tableaux des données les noms vernaculaires formatés
			foreach ($tab_vernas as $verna) {
				$id = $verna['eva']['id']['version_projet_taxon_ref'].'-'.$verna['eva']['id']['taxon_ref'];
				$aso_donnees['taxons'][$id]['nom_verna'] = $verna['ev']['intitule_nom_vernaculaire'];
			}
		}
		
		// Gestion de l'url pour l'export des données
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		$url->addQueryString('module', 'chorologie');
		$url->addQueryString('action', 'export_liste_taxons');
		$url->addQueryString('zg_projet', $_GET['zg_projet']);
		$url->addQueryString('zg_code', $_GET['zg_code']);
		$url->addQueryString('lettre', $Fragmenteur->getLettre());
		$url->addQueryString('format', 'xls');
		$aso_donnees['url_export_xls'] = $url->getUrl();
		$url->removeQueryString('lettre');
		$url->addQueryString('lettre', '*');
		$aso_donnees['url_export_xls_tous'] = $url->getUrl();
		
		// Informations diverses
		$aso_donnees['index'] = $aso_donnees['frag_donnee_debut'] + 1;
		$aso_donnees['taxons_nbre_lettre'] = $Fragmenteur->getDonneesTotal();
		$aso_donnees['taxons_nbre_total'] = $page_donnees_nbre_total;
		$aso_donnees['zg_nom'] = $zg_info['ezg']['intitule_principal'];
		
		// Permalien de la carte
		$url_carte = clone $GLOBALS['_EFLORE_']['url_base'];
		$url_carte->addQueryString('module', 'chorologie');
		$url_carte->addQueryString('action', 'acces_par_carte');
		$aso_donnees['url_carte'] = $url_carte->getUrl();
		
		// Gestion du trie
		$tt = 'nl';
		if (isset($_GET['tt'])) {
			$tt = $_GET['tt'];
		}
		$to = 'asc';
		if (isset($_GET['to'])) {
			$to = $_GET['to'];
		}
		$this->trierDonnees(&$aso_donnees['taxons'], $tt, $to);
		
		// Attribution des données pour remplir le squelette
		$this->getRegistre()->set('squelette_donnees', $aso_donnees);
	}
	
	public function executerCartePresence()
	{
		// Initialisation de variables
		$this->setChrono('debut');
		$aso_donnees = array();
		
		// Instanciation des classes métiers nécessaires
		$Chorologie = new EfloreChorologie();
		//$Chorologie->setDebogage(true);
		$Taxon = new EfloreTaxon();
		$Nom = new EfloreNom();
		$Vernaculaire = new EfloreVernaculaire();
		
		// Définition du nom de la carte
		// TODO : mettre touts les infos ci-dessous dans une table de la bdd eflore_zg_carte (par exemple)
		$fichier_carte_fond = 'isere.png';
		$aso_donnees['zone_type'] = 'commune';
		$aso_donnees['zone_parente_nom'] = 'Isère';
		$type_carte = str_replace('.png', '', $fichier_carte_fond);
		$nom_carte_commun = $type_carte.'_'.$_GET['pr'].'_'.$_GET['nt']; 
		$nom_carte_png = $nom_carte_commun.'.png';
		$nom_carte_map = $nom_carte_commun.'.map';
		
		// Récupération des infos sur le taxon
		$info_nom = $Taxon->consulterNomRetenu($_GET['pr'], $_GET['nt']);
		$FormatageNom = Composant::fabrique('formatage_nom');
		$aso_donnees['taxon_nom_id'] = $info_nom['en']['id']['nom'];
		$aso_donnees['taxon_nom_latin'] = $FormatageNom->formater($info_nom);
		$aso_donnees['taxon_nom_verna'] = $Vernaculaire->consulterTaxonNomTypique($_GET['pr'], $_GET['nt']);
		
		// Récupération des infos sur le projet
		$aso_donnees = array_merge($aso_donnees, $this->getInfoProjet());
		
		// +-------------------------------------------------------------------------------------------------------+
		// Gestion de la légende
		switch (25) {
			case 25: // BDNFF v4.02
			case 26: // BDNBE v0
			case 32: // BDAFN v0
			case 38: // BDNBE v1
				$aso_legende[0] = array('intitule' => ucfirst($aso_donnees['zone_type']).' non renseignée', 
										'rvb' => '128-128-128' );
				$aso_legende[3] = array('intitule' => 'Présence de l\'espèce', 
										'rvb' => '160-255-125' );
				$aso_legende[4] = array('intitule' => 'Présence à confirmer', 
										'rvb' => '255-255-50' );
				$aso_legende[5] = array('intitule' => 'Disparu ou douteux', 
										'rvb' => '248-128-23' );
				$aso_legende[6] = array('intitule' => 'Cité par erreur comme présent', 
										'rvb' => '255-40-80' );
				$aso_legende[10] = array('intitule' => 'Présence non signalée', 
										'rvb' => '255-255-255' );
				break;
		case 29 :// BDNFM v2006.01
				$aso_legende[0] = array('intitule' => ucfirst($aso_donnees['zone_type']).' non renseignée', 
										'rvb' => '128-128-128' );
				$aso_legende[3] = array('intitule' => 'Présent', 
										'rvb' => '160-255-125');
				$aso_legende[4] = array('intitule' => 'Présence probable à confirmer', 
										'rvb' => '255-255-50');
				$aso_legende[5] = array('intitule' => 'Présence douteuse ou incertaine', 
										'rvb' => '248-128-23');
				$aso_legende[6] = array('intitule' => 'Présence uniquement à l\'état cultivé', 
										'rvb' => '162-91-28');
				$aso_legende[7] = array('intitule' => 'Cité par erreur', 
										'rvb' => '255-40-80');
				$aso_legende[10] = array('intitule' => 'Présence non signalée', 
										'rvb' => '255-255-255');
				break;
			default:
				$aso_legende = array();
		}
		$aso_donnees['legendes'] = $aso_legende;
		// Nous récupérons le nombre de zone géo 
		$this->setChrono('nbre_donne_debut');
		$aso_donnees['zones_nbre'] = $Chorologie->consulterZoneGeoNombre($this->projet_choro);
		$this->setChrono('nbre_donne_fin');

		// Nous affectons les légendes aux zones contenant le taxon
		$Chorologie->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$tab_zones = $Chorologie->consulterDonneesTaxon($this->projet_choro, $_GET['pr'], $_GET['nt']);
		foreach ($tab_zones as $zone) {
			// Création du tableau contenant le nombre de zones par notion
			if (!isset($aso_donnees['zones_notions_nbre'][$zone['eci']['ce']['notion_choro']])) {
				$aso_donnees['zones_notions_nbre'][$zone['eci']['ce']['notion_choro']] = 1;
			} else {
				$aso_donnees['zones_notions_nbre'][$zone['eci']['ce']['notion_choro']]++;
			}
		}
		
		// Création de la carte de présence
		$Carte = new Cartographie();
		$Carte->setCarteNom($nom_carte_png);// Nous donnons le nom de la carte
		$Carte->setCarteInfo(array('donnees_date_maj' => $aso_donnees['version_date_maj']));
		$Carte->setCarteStockageDossier(EF_CHEMIN_CARTE_STOCKAGE);// Nous définissons le chemin contenant les cartes créées
		// Récolte d'info pour la carte si elle n'est pas en cache
		if (!$Carte->getCarteCache()) {
			// Nous affectons la couleur de la "zone géo non renseigné" à toutes les zones de la carte.
			$this->setChrono('recup_donne_debut');
			$tab_zones_carte = $Chorologie->consulterDonnees($this->projet_choro);
			$this->setChrono('recup_donne_fin');
			$tab_info = array();
			foreach ($tab_zones_carte as $zone) {
				$tab_info[$zone['ezg']['code']] = array('nom' => $zone['ezg']['intitule_principal'],
														'rvb_fond'	=> $zone['ezg']['couleur_rvb'],
														'rvb_carte'	=> $aso_legende[10]['rvb']);
			}
			
			// Nous affectons les légendes aux zones contenant le taxon
			foreach ($tab_zones as $zone) {
				$tab_info[$zone['ezg']['code']]['rvb_carte'] = $aso_legende[$zone['eci']['ce']['notion_choro']]['rvb'];
			}
			
			// Nous définissons la formule de coloriage de la carte et les couleurs éventuellement nécessaire
			$Carte->setFormuleColoriage('legende');
			// Nous définissons le fichier contenant le fond de carte
			$Carte->setCarteFondFichier($fichier_carte_fond);
			// Nous définissons le dossier contenant les fonds de carte
			$Carte->setCarteFondDossier(EF_CHEMIN_CARTE_SRC);
			// Nous indiquons les informations sur les zones géographiques
			$Carte->setCarteZoneInfo($tab_info);
			// Lancement de la création de la carte
			$Carte->creerCarte();
		}

		// Gestion de l'url de la carte
		$aso_donnees['url_carte'] = sprintf(EF_URL_CARTO, $nom_carte_png);

		// Gestion de l'url pour obtenir la liste des espèces
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		$url->addQueryString('module', 'chorologie');
		$url->addQueryString('action', 'liste');
		$aso_donnees['url'] = $url->getUrl();
		
		// Gestion de l'image map
		if (file_exists(EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_map)) {
			$aso_donnees['carte_map'] = file_get_contents(EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_map);
		} else {
			$aso_donnees['carte_map'] = file_get_contents(EF_CHEMIN_CARTE_SRC.'isere.map');
			$url_liste = clone $GLOBALS['_EFLORE_']['url_base'];
			$url_liste->addQueryString('module', 'chorologie');
			$url_liste->addQueryString('action', 'liste');
			$url_liste->addQueryString('zg_projet', '%s', true);
			$url_liste->addQueryString('zg_code', '%s', true);
			$url_liste->addQueryString('format', 'html');
			$url_liste = 'href="'.$url_liste->getUrl().'"';
			if (preg_match_all('/href="([A-Z_]+)-(\d+)"/', $aso_donnees['carte_map'], $matches)) {
				//echo '<pre>'.print_r($matches, true).'</pre>';
				$nbre_href = count($matches[0]);
				for ($i = 0; $i < $nbre_href ;$i++) {
					$remplacement = sprintf($url_liste, $matches[1][$i], $matches[2][$i]);
					$aso_donnees['carte_map'] = preg_replace('/'.$matches[0][$i].'/', $remplacement, $aso_donnees['carte_map']);
				}
			}
			if (!file_put_contents(EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_map, $aso_donnees['carte_map'])) {
				$e = 'Écriture du fichier .map impossible : '.EF_CHEMIN_CARTE_STOCKAGE.$nom_carte_map;
				trigger_error($e, E_USER_WARNING);
			}
		}
		
		$this->setChrono('fin');
		// Attribution des données pour remplir le squelette
		$this->getRegistre()->set('squelette_donnees', $aso_donnees);
	}
	
	public function executerExportListeTaxons()
	{
		// Initialisation de variables
		$this->getRegistre()->set('squelette_moteur', aModule::TPL_NULL);
		$this->getRegistre()->set('format', aModule::SORTIE_XLS);
		
		// Instanciation des classes métiers nécessaires
		$GLOBALS['_EFLORE_']['encodage'] = 'ISO-8859-1';
		$ZoneGeo = new EfloreZoneGeographique();
		$Chorologie = new EfloreChorologie();
		$Vernaculaire = new EfloreVernaculaire();
		$Nom = new EfloreNom();
		
		// Récupération des données nécessaire à la chorologie
		$zg_projet_id = EfloreZoneGeographique::consulterZgProjetId($_GET['zg_projet']);
		$zg_info = $ZoneGeo->consulterZgParCode($zg_projet_id, $_GET['zg_code']);
		$aso_donnees['zone_nom'] = $zg_info['ezg']['intitule_principal'];
		$aso_donnees['zone_code'] = $zg_info['ezg']['code'];
		
		// Gestion de la limitation aux taxons protégés.
		$limitation = false;
		if (CHORO_PROTECTION) {
			$limitation['statut'] = CHORO_PROTECTION_STATUT;
			$limitation['texte_application'] = CHORO_PROTECTION_TXT;
		}
		
		// Récupération des données
		$Chorologie->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$tab_donnees = array();
		$tab_donnees = $Chorologie->consulterNotionsTaxons($this->projet_choro, $zg_info['ezg']['id']['zone_geo'], $zg_projet_id, $_GET['lettre'], $limitation);
		// TODO : simplifer l'écriture de l'accès au mode de rendu des données du Wrapper SQL
		$Chorologie->getWrapperSql()->setMode();// On remet en mode par défaut
		
		// Ajout aux tableaux des données les noms latins formatés
		$aso_donnees['legende_statut'] = array();
		$aso_donnees['legende_txt'] = array();
		if (count($tab_donnees) > 0) {
			$Protection = new EfloreProtection();
			foreach ($tab_donnees as $taxon) {
				$id = $taxon['esn']['id']['version_projet_taxon'].'-'.$taxon['esn']['id']['taxon'];
				
				// Gestion des protection
				$protections = $Protection->recupererProtections($taxon['esn']['id']['taxon'], $taxon['esn']['id']['version_projet_taxon'], $limitation);
				$protec = '';
				foreach ($protections as $protection) {
					$protec .= $protection['txt_appli_abreviation'].' : '.$protection['statut_abreviation'].' ; '; 
				}
				
				$tab_info  = array(
					'nom_code' => $taxon['en']['id']['nom'],
					'nom_latin' => $Nom->formaterNom($taxon),		
					'taxon_code' => $taxon['esn']['id']['taxon'],
					'taxon_projet_id' => $taxon['esn']['id']['version_projet_taxon'],
					'notion_intitule' => $taxon['ecn']['intitule_principal'],
					'notion_code' => $taxon['ecn']['code_notion'],
					'protection' => trim($protec, ' ; '));
				
				$tab_taxons[$taxon['esn']['id']['version_projet_taxon']][$taxon['esn']['id']['taxon']] = $tab_info;
				$aso_donnees['taxons'][$id] = $tab_info;
			}
			
			$tab_vernas = $Vernaculaire->consulterTaxonsNomTypique($tab_taxons);
			// Ajout aux tableaux des données les noms vernaculaires formatés
			foreach ($tab_vernas as $verna) {
				$id = $verna['eva']['id']['version_projet_taxon_ref'].'-'.$verna['eva']['id']['taxon_ref'];
				$aso_donnees['taxons'][$id]['nom_verna'] = $verna['ev']['intitule_nom_vernaculaire'];
			}
		}
		
		// Création du fichier XLS
		/** Inclusion de la classe PEAR de création de fichiers excell. */
		require_once 'Spreadsheet/Excel/Writer.php';		

		// Création de la feuille
		$workbook = new Spreadsheet_Excel_Writer();
		$nom_feuille = $aso_donnees['zone_nom'];
		$nom_fichier = 'Chorologie_'.str_replace(' ', '_', $nom_feuille);
		if ($_GET['lettre'] != '*') {
			$nom_fichier .= '_lettre_'.$_GET['lettre'];
		}
		$nom_fichier .= '.xls';
		$worksheet = $workbook->addWorksheet($nom_feuille);
		if (PEAR::isError($worksheet)) {
    		trigger_error($worksheet->getMessage(), E_USER_ERROR);
		}
		
		// Traitement distinct en fonction de la distribution...
		switch (EF_DISTRIBUTION) {
			case 'gentiana' :
				$this->formaterExportGentiana(&$workbook, &$worksheet, &$aso_donnees);
				break;
			case 'tela_botanica' :
			default:
				$this->formaterExportTelaBotanica(&$workbook, &$worksheet, &$aso_donnees);
		}

		// Envoi du fichier
		$workbook->send($nom_fichier);
		$workbook->close();
	}
	
	private function formaterExportTelaBotanica(&$workbook, &$worksheet, &$aso_donnees)
	{
		// Définitions de formats
		$format_titre = $workbook->addFormat();
		$format_titre->setBold(1);
		$format_titre->setSize(16);
		$format_intro = $workbook->addFormat();
		$format_intro->setBold(1);
		$format_intro->setSize(12);
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Feuille des données
		
		// Compteur des lignes		
		$i = 0;

		// Titre général
		$worksheet->mergeCells($i++, 0, $i, 8);
		if ($_GET['lettre'] != '*') {
			$titre = 'Export des taxons commençant par la lettre '.$_GET['lettre'].'. Zone géographique : '.$aso_donnees['zone_nom'].' ['.$aso_donnees['zone_code'].']';
		} else {
			$titre = 'Export des taxons de la zone géographique '.$aso_donnees['zone_nom'].' ['.$aso_donnees['zone_code'].']';
		}
		$worksheet->writeString(0, 0, $titre, $format_titre);

		// Date d'extraction
		$worksheet->mergeCells(++$i, 0, $i, 8);
		$worksheet->writeString($i++, 0, 'Date de l\'extraction :', $format_intro);
		$worksheet->mergeCells($i, 0, $i, 8);
		$worksheet->writeString($i++, 0, date('d/m/Y', time()));
				
		// Titre du projet
		$worksheet->mergeCells($i, 0, $i, 8);
		$titre_projet = 'Projet :';
		$worksheet->writeString($i++, 0, $titre_projet, $format_intro);
		$worksheet->mergeCells($i, 0, $i, 8);
		$txt_projet = 'Phytochorologie départementale - Coordinateur : Philippe JULVE';
		$worksheet->writeString($i++, 0, $txt_projet);
		
		// Licence
		$worksheet->mergeCells($i, 0, $i, 8);
		$titre_licence = 'Licence :';
		$worksheet->writeString($i++, 0, $titre_licence, $format_intro);
		$worksheet->mergeCells($i, 0, $i, 8);
		$txt_licence = 'http://creativecommons.org/licenses/by-sa/2.0/fr/';
		$worksheet->writeUrl($i++, 0, $txt_licence);
		
		/*$worksheet->mergeCells($i, 0, $i, 8);
		$titre_contributeur = 'Contributeurs :';
		$worksheet->writeString($i++, 0, $titre_contributeur, $format_intro);
		for ($j = 0; $j < count($tableau_infoDep['CORRESPONDANTS']); $j++){
            if(ereg("[@]", $tableau_infoDep['CORRESPONDANTS'][$j]['COURRIEL'])){
                $worksheet->writeString($i, 0, $tableau_infoDep['CORRESPONDANTS'][$j]['PRENOM']);
                $worksheet->writeString($i, 1, $tableau_infoDep['CORRESPONDANTS'][$j]['NOM']);
                $worksheet->writeString($i++, 2, $tableau_infoDep['CORRESPONDANTS'][$j]['COURRIEL']);
            } else {
                $worksheet->writeString($i, 0, $tableau_infoDep['CORRESPONDANTS'][$j]['PRENOM']);
                $worksheet->writeString($i++, 1, $tableau_infoDep['CORRESPONDANTS'][$j]['NOM']);
            }
        }
        
        $worksheet->mergeCells($i, 0, $i, 8);
		$titre_source = 'Sources :';
		$worksheet->writeString($i++, 0, $titre_source, $format_intro);
		for ($j = 0; $j < count($tableau_infoDep['SOURCES']); $j++){
			$worksheet->mergeCells($i, 0, $i, 8);
			$worksheet->writeString($i++, 0, $tableau_infoDep['SOURCES'][$j]);
        }*/
        
        // Liste des données
        $i++;// Saut de ligne
        $worksheet->setColumn(0, 1, 20);
        $worksheet->setColumn(2, 2, 60);
        $worksheet->setColumn(3, 3, 60);
        $worksheet->setColumn(4, 4, 20);
        $worksheet->setColumn(5, 5, 20);
		$worksheet->writeString($i, 0, 		'N° taxonomique', $format_intro);
		$worksheet->writeString($i, 1, 		'N° nomenclatural', $format_intro);
		$worksheet->writeString($i, 2, 		'Nom complet', $format_intro);
		$worksheet->writeString($i, 3, 		'Nom commun', $format_intro);
		$worksheet->writeString($i, 4,	'Notion intitulé', $format_intro);
		$worksheet->writeString($i++, 5,	'Notion code', $format_intro);
		foreach ($aso_donnees['taxons'] as $ligne) {
			$worksheet->writeNumber($i, 0, $ligne['taxon_code']);
			$worksheet->writeNumber($i, 1, $ligne['nom_code']);
			$worksheet->writeString($i, 2, $ligne['nom_latin']);
			$worksheet->writeString($i, 3, $ligne['nom_verna']);
			$worksheet->writeString($i, 4, $ligne['notion_intitule']);
			$worksheet->writeString($i++, 5, $ligne['notion_code']);
		}
	}
	
	private function formaterExportGentiana(&$workbook, &$worksheet, &$aso_donnees)
	{
		// Définitions de formats
		$format_titre = $workbook->addFormat();
		$format_titre->setBold(1);
		$format_titre->setSize(16);
		$format_intro = $workbook->addFormat();
		$format_intro->setBold(1);
		$format_intro->setSize(12);
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Feuille des données
		
		// Récupération des infos sur le projet
		$info_projet = array_merge($aso_donnees, $this->getInfoProjet());
		
		// Compteur des lignes		
		$i = 0;
		
		// Titre général
		$worksheet->mergeCells($i++, 0, $i++, 8);
		if ($_GET['lettre'] != '*') {
			$titre = 'Export des taxons commençant par la lettre '.$_GET['lettre'].' présents dans la commune '.$aso_donnees['zone_nom'].' ['.$aso_donnees['zone_code'].']';
		} else {
			$titre = 'Export des taxons présents dans la commune '.$aso_donnees['zone_nom'].' ['.$aso_donnees['zone_code'].']';
		}
		$worksheet->writeString(0, 0, $titre, $format_titre);

		// Date d'extraction
		$worksheet->writeString($i, 0, 'Date de l\'extraction :', $format_intro);
		$worksheet->writeString($i++, 1, date('d/m/Y', time()));
				
		// Source
		$worksheet->writeString($i, 0, 'Source :', $format_intro);
		$worksheet->writeString($i++, 1, 'INFLORIS du '.$info_projet['version_date']);

		// Auteur
		$worksheet->writeString($i, 0, 'Auteur :', $format_intro);
		$worksheet->mergeCells($i, 1, $i, 8);
		$worksheet->writeString($i++, 1, 'GENTIANA Société botanique dauphinoise D.Villars, MNEI, 5, place Bir Hakeim 38000 Grenoble - 04.76.03.37.37 - www.gentiana.org');

		// Licence
		$worksheet->writeString($i, 0, 'Licence :', $format_intro);
		$url_licence = 'http://creativecommons.org/licenses/by-nc-nd/2.0/fr/';
		$txt_licence = 'Paternité - Pas d\'Utilisation Commerciale - Pas de Modification';
		$worksheet->writeUrl($i++, 1, $url_licence, $txt_licence);
		$i++;// Saut de ligne supplémentaire...
		
        // Liste des données
        $worksheet->setColumn(0, 0, 20);
        $worksheet->setColumn(1, 1, 60);
        $worksheet->setColumn(2, 2, 60);
        $worksheet->setColumn(3, 3, 20);
        $worksheet->setColumn(4, 4, 20);
		$worksheet->writeString($i, 0, 	'N° nomenclatural', $format_intro);
		$worksheet->writeString($i, 1, 	'Nom latin retenu', $format_intro);
		$worksheet->writeString($i, 2, 	'Nom commun', $format_intro);
		$worksheet->writeString($i, 3,	'Statut de protection', $format_intro);
		$i++;// Passage à la ligne suivante...
		foreach ($aso_donnees['taxons'] as $ligne) {
			if ($ligne['notion_code'] == '1') {// Taxon présent
				$worksheet->writeNumber($i, 0, $ligne['nom_code']);
				$worksheet->writeString($i, 1, $ligne['nom_latin']);
				$worksheet->writeString($i, 2, $ligne['nom_verna']);
				$worksheet->writeString($i++, 3, $ligne['protection']);
			}
		}

		// +-----------------------------------------------------------------------------------------------------------+
		// Création de la feuille contenant la légende
		$ws_legende = $workbook->addWorksheet('Légende');
		if (PEAR::isError($ws_legende)) {
    		trigger_error($ws_legende->getMessage(), E_USER_ERROR);
		}
		// Compteur des lignes		
		$i = 0;

		// Statut de protection
		$ws_legende->mergeCells(0, 0, 0, 8);
		$ws_legende->writeString(0, 0, 'Statuts de protection pour la France :', $format_intro);
		$ws_legende->setColumn(0, 0, 20);
		$ws_legende->setColumn(1, 1, 200);
		$ws_legende->writeString(1, 0, 'FR1995 : Fr1 (PN1) :');
		$ws_legende->writeString(1, 1, 'Protection Nationale au titre de l\'annexe 1 de l\'arrêté ministériel du 20 janvier 1982 modifié par l\'arrêté du 31 août 1995, interdisant la destruction, la cueillette, le colportage, la mise en vente ou l\'achat sur tout le territoire national.');
		$ws_legende->writeString(2, 0, 'FR1995 : Fr2 (PN2) :');
		$ws_legende->writeString(2, 1, 'Protection Nationale au titre de l\'annexe 2 de l\'arrêté ministériel du 20 janvier 1982 modifié par l\'arrêté du 31 août 1995, interdisant la destruction sur tout le territoire national. Le ramassage, l\'utilisation et le transport sont soumis à autorisation ministérielle. ');
		$ws_legende->writeString(3, 0, 'FR-Reg-82 : Reg (PRRA) :');
		$ws_legende->writeString(3, 1, 'Protection Régionale en Rhône-Alpes au titre de l\'arrêté ministériel du 4 décembre 1990. ');
		$ws_legende->writeString(4, 0, 'FR-Dep-38 : Dep (P38) :');
		$ws_legende->writeString(4, 1, 'Espèces végétales protégées dans le département de l\'Isère au titre de l\'articles 1 de l\'arrêté préfectoral du 21 janvier 1993 sur l\'ensemble du département.');
		$ws_legende->writeString(5, 0, 'FR-Dep-38 : Dep-cueil (C38) :');
		$ws_legende->writeString(5, 1, 'Espèces végétales dont la cueillette est réglementée dans le département de l\'Isère au titre des articles 2 et 5  de l\'arrêté préfectoral du 21 janvier 1993 sur l\'ensemble du département.');
		
		$ws_legende->writeString(7, 0, 'N° nomenclatural : ', $format_intro);
		$ws_legende->writeString(7, 1, 'identifiant unique d\'un nom latin au sein d\'un référentiel de nom latin (BDNFF).');
		
		$ws_legende->writeString(9, 0, 'Nom latin retenu : ', $format_intro);
		$ws_legende->writeString(9, 1, 'nom latin retenu dans le référentiel de nom latin (BDNFF).');
		
		$ws_legende->mergeCells(11, 0, 11, 8);
		$ws_legende->writeString(11, 0, 'Licence Creative Communs', $format_intro);
		$ws_legende->writeString(12, 1, 'Vous êtes libres :');
		$ws_legende->writeString(13, 1, ' * de reproduire, distribuer et communiquer cette création au public');

		$ws_legende->writeString(15, 1, 'Selon les conditions suivantes :');
		$ws_legende->writeString(16, 1, ' * Paternité. Vous devez citer le nom de l\'auteur original de la manière indiquée par l\'auteur de l\'oeuvre ou le titulaire des droits qui vous confère cette autorisation');
		$ws_legende->writeString(17, 1, ' (mais pas d\'une manière qui suggérerait qu\'ils vous soutiennent ou approuvent votre utilisation de l\'oeuvre).');
		$ws_legende->writeString(18, 1, ' * Pas d\'Utilisation Commerciale. Vous n\'avez pas le droit d\'utiliser cette création à des fins commerciales.');
		$ws_legende->writeString(19, 1, ' * Pas de Modification. Vous n\'avez pas le droit de modifier, de transformer ou d\'adapter cette création.');
		
		$ws_legende->writeString(21, 1, ' * A chaque réutilisation ou distribution de cette création, vous devez faire apparaître clairement au public les conditions contractuelles de sa mise à disposition. ');
		$ws_legende->writeString(22, 1, 'La meilleure manière de les indiquer est un lien vers cette page web : http://creativecommons.org/licenses/by-nc-nd/2.0/fr/');
		$ws_legende->writeString(23, 1, ' * Chacune de ces conditions peut être levée si vous obtenez l\'autorisation du titulaire des droits sur cette oeuvre.');
		$ws_legende->writeString(24, 1, ' * Rien dans ce contrat ne diminue ou ne restreint le droit moral de l\'auteur ou des auteurs');
		
	}
	
	private function trierDonnees(&$tableau, $defaut_tt = null, $defaut_to = null)
	{
		// Création des urls
		$tab_to = array('asc', 'desc');
		$tab_tt = array('nl', 'nv', 'nc', 'cc', 'pr');
		$tab_urls = array();
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		foreach ($_GET as $param_cle => $param_val) {
			if ($param_cle != 'tt' && $param_cle != 'to') {
				$url->addQueryString($param_cle, $param_val);
			}
		}
		foreach ($tab_to as $to) {
			$url->addQueryString('to', $to);
			foreach ($tab_tt as $tt) {
				$url->addQueryString('tt', $tt);
				$tab_urls['url_'.$to.'_'.$tt] = $url->getUrl();
				$url->removeQueryString('tt');
			}
			$url->removeQueryString('to');
		}
		$this->getRegistre()->set('squelette_donnees', $tab_urls);
		
		// Réalisation du triage
		if (isset($defaut_to) && isset($defaut_tt)) {
			$colonne = null;
			switch ($defaut_tt) {
				case 'nl' : // Les noms latins
					$colonne = 'nom_latin';
					break;
				case 'nv' : // Les noms communs
					$colonne = 'nom_verna';
					break;
				case 'nc' : // Les noms de communes
					$colonne = 'nom';
					break;
				case 'cc' : // Les codes de communes
					$colonne = 'code';
					break;
				case 'pr' : // Les statuts de protection
					$colonne = 'protection';
					break;
				default:
					$colonne = 'nom_latin';
					trigger_error('Type de trie inconnu!', E_USER_WARNING);
			}
			switch ($defaut_to) {
				case 'asc' :
					EfloreTriage::triNaturel($tableau, array($colonne, 'asc'));
					break;
				case 'desc' :
					EfloreTriage::triNaturel($tableau, array($colonne, 'desc'));
					break;
				default:
					EfloreTriage::triNaturel($tableau, array($colonne, 'asc'));
					trigger_error('Type d\'ordre de trie inconnu!', E_USER_WARNING);
			}
		}
	}
	
	private function getInfoProjet()
	{
		$Projet = new EfloreProjet();
		$version = $Projet->consulterVersion($this->projet_choro);
		$retour['version_nom'] = $version['eprv']['nom'];
		$retour['version_code'] = $version['eprv']['code_version'];
		$retour['version_date'] = date('d-m-Y', strtotime($version['eprv']['date_debut_version']));
		$retour['version_date_maj'] = $version['eprv']['date_deniere_modif'];		
		return $retour;
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: Chorologie.class.php,v $
* Revision 1.34  2007-09-25 08:59:06  jp_milcent
* Gestion de la lettre par défaut du Fragmenteur.
*
* Revision 1.33  2007-09-24 14:27:37  jp_milcent
* Ajout d'une constante gérant l'id du projet de choro.
*
* Revision 1.32  2007-09-24 14:12:11  jp_milcent
* Amélioration de la gestion du cache.
*
* Revision 1.31  2007-09-21 15:02:26  jp_milcent
* Remplacement des & par des &amp; et suppression du débogage.
*
* Revision 1.30  2007-09-20 15:31:33  jp_milcent
* Correction bogue : une seule commune pour la plante
*
* Revision 1.29  2007-09-20 13:06:21  jp_milcent
* Optimisation de l'affichage des noms.
*
* Revision 1.28  2007-08-20 16:06:08  jp_milcent
* Ajout du formatage des noms latins avec plier-deplier.
*
* Revision 1.27  2007-08-17 13:10:29  jp_milcent
* Début gestion des statuts de protection.
*
* Revision 1.26  2007-08-08 17:27:34  jp_milcent
* Corrections de bogues et améliorations...
*
* Revision 1.25  2007-08-05 22:53:13  jp_milcent
* Correction bogue dans la gestion du cache.
*
* Revision 1.24  2007-08-02 16:08:49  jp_milcent
* Mise en forme pour gentiana.
*
* Revision 1.23  2007-07-25 18:05:03  jp_milcent
* Suppression de l'appel au moteur de tplt par défaut inutile.
*
* Revision 1.22  2007-07-13 11:34:25  jp_milcent
* Ajout de la gestion des urls pour le tri des données.
*
* Revision 1.21  2007-07-12 16:15:54  jp_milcent
* Début ajout du trie sur les colonnes des tableaux.
*
* Revision 1.20  2007-07-11 17:11:16  jp_milcent
* Ajout des urls pour le recueil de données.
*
* Revision 1.19  2007-07-09 12:53:21  jp_milcent
* Utilisation de la classe Fragmenteur.
*
* Revision 1.18  2007-07-09 08:11:44  jp_milcent
* Début utilisation de la classe Fragmenteur (pas encore déboguée)
*
* Revision 1.17  2007-07-06 18:51:35  jp_milcent
* Optimisation du code.
*
* Revision 1.16  2007-07-06 16:34:10  jp_milcent
* Suppression de l'utilisation de la clé du Registre module_projet.
*
* Revision 1.15  2007-07-06 14:20:41  jp_milcent
* Ajout de constante issue du fichier de config.
*
* Revision 1.14  2007-07-06 14:17:38  jp_milcent
* Ajout de l'action acces_pas_zone.
*
* Revision 1.13  2007-07-05 19:07:00  jp_milcent
* Début de la gestion de l'accès par taxons.
*
* Revision 1.12  2007-07-05 17:28:15  jp_milcent
* Amélioration de la carte de présence et mutualisation de données.
*
* Revision 1.11  2007-07-03 16:54:38  jp_milcent
* Début gestion carte de "présence".
*
* Revision 1.10  2007-07-03 10:05:39  jp_milcent
* Getion du cache.
*
* Revision 1.9  2007-07-02 15:51:30  jp_milcent
* Utilisation du chrono.
*
* Revision 1.8  2007-07-02 15:35:12  jp_milcent
* Utilisation intégrale du wrapper SQL pour ce module.
*
* Revision 1.7  2007-06-29 16:59:30  jp_milcent
* Utilisation du wrapper.
* Fin de la gestion du fragmenteur et de la recherche par l'alphabet.
*
* Revision 1.6  2007-06-27 17:06:45  jp_milcent
* Simplification.
*
* Revision 1.5  2007-06-25 16:38:50  jp_milcent
* Mise en commentaire des infos de débogage.
*
* Revision 1.4  2007-06-22 16:28:23  jp_milcent
* Amélioration de la réactivité de l'application : gestion d'un cache.
*
* Revision 1.3  2007-06-21 17:41:31  jp_milcent
* Début gestion de la création de la carte.
*
* Revision 1.2  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.1  2007-06-11 12:47:51  jp_milcent
* Début gestion de l'application Chorologie et ajout de modification suite à travail pour Gentiana.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>