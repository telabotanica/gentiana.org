<?php

class Fragmenteur {
	private $pager;
	private $url;
	private $lettre;
	private $donnees_total;
	private $pager_page_saut;
	
	public function __construct($url, $lettre = 'A') {
		$this->url = $url;
		// Gestion de la lettre
		$this->setLettre($lettre);
		if (isset($_GET['lettre'])) {
			$this->setLettre(urldecode($_GET['lettre']));
		}
	}
	
	public function getPageSaut() {
		return $this->pager_page_saut;
	}
	
	public function getDeplacementParPageId() {
		return $this->pager->getOffsetByPageId();
	}
	
	public function getLettre() {
		return $this->lettre;
	}
	
	public function setLettre($l) {
		$this->lettre = $l;
	}
	
	public function getDonneesTotal() {
		return $this->donnees_total;
	}
	
	public function setDonneesTotal($dt) {
		$this->donnees_total = $dt;
	}
	
    public function executer() {
    	// Gestion de la lettre
		$lettre = $this->getLettre();
		$aso_donnees['lettre_selected'] = $lettre;
						
		// Gestion du nombre de données à afficher par page.
		$page_saut = EF_FRAGMENTEUR_PAR_PAGE_DEFAUT;
		if (isset($_GET['frag_nbre'])) {
			if ($_GET['frag_nbre'] == '*') {
				$_GET['page'] = 1;
			}
			$_SESSION['fragmenteur']['par_page'] = $_GET['frag_nbre'];
			$page_saut = $_GET['frag_nbre'];
		} else if (isset($_SESSION['fragmenteur']['par_page']) && $_SESSION['fragmenteur']['par_page'] != '') {
			$page_saut = $_SESSION['fragmenteur']['par_page'];
		} else {
			$_SESSION['fragmenteur']['par_page'] = $page_saut;
		}
		$this->pager_page_saut = $page_saut;
		if ($page_saut == '*') {
			$this->pager_page_saut = $this->donnees_total;
		}
		
		// Gestion du Fragmenteur (basé sur le Pager de Pear)
		$pager_options = array(	'mode' => 'Sliding',
								'perPage' => $this->pager_page_saut,
								'delta' => 2,
								'totalItems' => $this->donnees_total,
								'urlVar' => 'page',
								'separator' => '-');
		$this->pager = Pager::factory($pager_options);
		
		// Gestion des urls
		$this->url->addQueryString('lettre', $lettre);
		$this->url->addQueryString('page', $this->pager->getCurrentPageID());
		$aso_donnees['url'] = $this->url->getURL();
		
		// Gestion du fragmenteur
		$aso_donnees['frag_donnee_total'] = $this->donnees_total;
		$page_id_x_saut = ($this->pager->getCurrentPageID() * $this->pager_page_saut);
		$aso_donnees['frag_donnee_debut'] = ($page_id_x_saut - $this->pager_page_saut) > 0 ? ($page_id_x_saut - $this->pager_page_saut) : 0;
		$aso_donnees['frag_donnee_fin'] = $page_id_x_saut >= $this->donnees_total ? $this->donnees_total : $page_id_x_saut;
		$aso_donnees['par_page'] = explode(',', EF_FRAGMENTEUR_PAR_PAGE);
		$aso_donnees['par_page_selected'] = $_SESSION['fragmenteur']['par_page'];
		$aso_donnees['pager_links'] = $this->pager->getLinks();
		
		// Gestion des paramêtres pour le formulaire du Fragmenteur
		$tab_parties = EfloreUrl::parserQueryString($this->url->getQueryString());
		foreach ($tab_parties as $cle => $valeur) {
			$aso_donnees['form_get_url_chp_hidden'][$cle] = $valeur;
		}
		
		// Gestion de la liste alphabétique
		$this->url->addQueryString('lettre', '*');
		$aso_donnees['alphabet']['*'] = array(	'url' => $this->url->getURL(),
												'lettre' => 'tous');
		for ($i = 65; $i <= 90; $i++){
			$this->url->addQueryString('lettre', chr($i));
			$aso_donnees['alphabet'][] = array(	'url' => $this->url->getURL(),
												'lettre' => chr($i));
			$this->url->removeQueryString('lettre');
		}
		
    	return $aso_donnees;
    }
    
}
?>