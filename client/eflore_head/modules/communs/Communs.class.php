<?php
class Communs extends aModule {
	
	public static function getAppletteBalise()
	{
		return '\{\{Commun(?:\s*(?:(action="[^"]+")|))+\s*\}\}';
	}

	// La méthode executer est appellé par défaut
	public function executer()
	{ 
		// TODO : afficher la liste des méthode disponible!
		// Si on veut rediriger l'action vers une autre méthode, il faut définir le nom de la nouvelle action.
		// Le module commun n'a pas d'action par défaut
		//$this->poursuivreVers('');
	}
	
	public function executerAppletteXper()
	{ 
		// +-----------------------------------------------------------------------------------------------------------+
		// Initialisation des variables		
		$aso_donnees = array();
		$aso_donnees['base'] = $_GET['base'];
		$aso_donnees['url_eflore'] = EF_URL;
		$aso_donnees['url_xper_base'] = EF_URL_XPER_BASE;
		$aso_donnees['url_xper_jar'] = EF_URL_XPER_JAR;
		
		// Gestion des fichiers jar de l'applette
		$tab_fichiers = explode(',', EF_URL_XPER_JAR_FICHIER);
		foreach ($tab_fichiers as $fichier) {
			$aso_donnees['url_xper_jar_fichier'] .= EF_URL_XPER_JAR.$fichier.', ';
		}
		$aso_donnees['url_xper_jar_fichier'] = preg_replace('/, $/', '', $aso_donnees['url_xper_jar_fichier']);
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Stockage des données
		//$this->setDebogage($aso_donnees);		
		$this->getRegistre()->set('squelette_donnees', $aso_donnees);
	}
	
	public function executerPiedPage()
	{ 
		// Seulement un template!
		// Cette méthode pourrait être supprimée : elle reste pour mémo!
	}
	
	public function executerGoogleMap()
	{ 
		// +-----------------------------------------------------------------------------------------------------------+
		// Initialisation des variables		
		$aso_donnees = array();
		
		// Gestion de l'url où renvoyer les données du formulaire
		$aso_donnees['url_retour'] = $GLOBALS['_EFLORE_']['url_base']->getUrl();
		$aso_donnees['query_string'] = null;
		if ($this->getRegistre()->get('gm_url_retour')) {
			$aso_donnees['query_string'] = $this->getRegistre()->get('gm_url_retour')->querystring;
			$this->getRegistre()->get('gm_url_retour')->querystring = array();
			$aso_donnees['url_retour'] = $this->getRegistre()->get('gm_url_retour')->getUrl();
		}
		
		// Gestion des données serialisées de la page d'origine
		$aso_donnees['form_serialize'] = '';
		if ($this->getRegistre()->get('gm_form_serialize')) {
			$aso_donnees['form_serialize'] = $this->getRegistre()->get('gm_form_serialize');
		}

		// Gestion de la clé pour accéder à l'API GoogleMap
		$aso_donnees['gg_cle'] = '';
		if ($this->getRegistre()->get('gm_cle')) {
			if (!is_array($this->getRegistre()->get('gm_cle'))) {
				// Si on passe une seule clé GooleMap pour une seule url
				$aso_donnees['gg_cle'] = $this->getRegistre()->get('gm_cle');
			} else {
				// Si on veut passer un tableau de clé GooleMap pour plrs url : en index l'url de base, en valeur la clé
				$url = preg_replace('/\/[^\/]*$/', '/', 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
				$tab_cles = $this->getRegistre()->get('gm_cle');
				if (isset($tab_cles[$url])) {
					$aso_donnees['gg_cle'] = $tab_cles[$url];
				}
			}
		}
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Stockage des données
		//$this->setDebogage($aso_donnees);		
		$this->getRegistre()->set('squelette_donnees', $aso_donnees);
		
	}
}
?>