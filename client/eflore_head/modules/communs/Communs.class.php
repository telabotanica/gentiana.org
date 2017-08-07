<?php
class Communs extends aModule {
	
	public static function getAppletteBalise()
	{
		return '\{\{Commun(?:\s*(?:(action="[^"]+")|))+\s*\}\}';
	}

	// La m�thode executer est appell� par d�faut
	public function executer()
	{ 
		// TODO : afficher la liste des m�thode disponible!
		// Si on veut rediriger l'action vers une autre m�thode, il faut d�finir le nom de la nouvelle action.
		// Le module commun n'a pas d'action par d�faut
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
		// Stockage des donn�es
		//$this->setDebogage($aso_donnees);		
		$this->getRegistre()->set('squelette_donnees', $aso_donnees);
	}
	
	public function executerPiedPage()
	{ 
		// Seulement un template!
		// Cette m�thode pourrait �tre supprim�e : elle reste pour m�mo!
	}
	
	public function executerGoogleMap()
	{ 
		// +-----------------------------------------------------------------------------------------------------------+
		// Initialisation des variables		
		$aso_donnees = array();
		
		// Gestion de l'url o� renvoyer les donn�es du formulaire
		$aso_donnees['url_retour'] = $GLOBALS['_EFLORE_']['url_base']->getUrl();
		$aso_donnees['query_string'] = null;
		if ($this->getRegistre()->get('gm_url_retour')) {
			$aso_donnees['query_string'] = $this->getRegistre()->get('gm_url_retour')->querystring;
			$this->getRegistre()->get('gm_url_retour')->querystring = array();
			$aso_donnees['url_retour'] = $this->getRegistre()->get('gm_url_retour')->getUrl();
		}
		
		// Gestion des donn�es serialis�es de la page d'origine
		$aso_donnees['form_serialize'] = '';
		if ($this->getRegistre()->get('gm_form_serialize')) {
			$aso_donnees['form_serialize'] = $this->getRegistre()->get('gm_form_serialize');
		}

		// Gestion de la cl� pour acc�der � l'API GoogleMap
		$aso_donnees['gg_cle'] = '';
		if ($this->getRegistre()->get('gm_cle')) {
			if (!is_array($this->getRegistre()->get('gm_cle'))) {
				// Si on passe une seule cl� GooleMap pour une seule url
				$aso_donnees['gg_cle'] = $this->getRegistre()->get('gm_cle');
			} else {
				// Si on veut passer un tableau de cl� GooleMap pour plrs url : en index l'url de base, en valeur la cl�
				$url = preg_replace('/\/[^\/]*$/', '/', 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
				$tab_cles = $this->getRegistre()->get('gm_cle');
				if (isset($tab_cles[$url])) {
					$aso_donnees['gg_cle'] = $tab_cles[$url];
				}
			}
		}
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Stockage des donn�es
		//$this->setDebogage($aso_donnees);		
		$this->getRegistre()->set('squelette_donnees', $aso_donnees);
		
	}
}
?>