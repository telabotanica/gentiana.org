<?php

class TrackBack extends aModule {
	
	public static function getAppletteBalise()
    {
    	return '\{\{TrackBack(?:\s*(?:(action="[^"]+")|))+\s*\}\}';
    }
    // La méthode executer est appellé par défaut 
    public function executer()
    {
    	$Registre = Registre::getInstance();
    	// 
		$Registre->set('squelette_moteur', aModule::TPL_NULL);
		$Registre->set(EF_LG_URL_FORMAT, aModule::SORTIE_XML);
		
		$STB = Services_Trackback::create(array('id'=>1));
		$STB->receive();
		$post = array(	'blog_name'	=>    'Le nom du blog n\'est pas défini',
		                'url'		=>    'L\'adresse n\'est pas définie',
		                'title'		=>    'Le titre n\'est pas défini',
		                'excerpt'	=>    'L\'extrait n\'est pas défini');
		$erreurs = array();
		foreach($post as $nom => $valeur) {
		    if ($STB->get($nom) == '') {
		    	$erreurs[] = $valeur;
		    }
		}
		
		if(count($erreurs) > 0) {
			$Registre->set('sortie', $STB->getResponseError(implode("\n\t\t", $erreurs), '1'));
		} else {
			$aso_txt['titre'] = $STB->get('title');
			$aso_txt['resumer'] = $STB->get('excerpt');
			$aso_txt['url'] = $STB->get('url');
			$aso_txt['autre_auteur'] = $STB->get('blog_name');
			EfloreInfoTxt::ajouterInfoTxt($aso_txt, 39);
			$Registre->set('sortie', $STB->getResponseSuccess());
			echo '<pre>'.print_r($aso_txt, true).'</pre>';
		}
    }
    
    public function executerLire()
    {
    	
    }
    
    // "Url" est le nom de l'action passé en paramêtre
    public function executerUrl()
    {
    	$Registre = Registre::getInstance();
		$Registre->set('squelette_moteur', aModule::TPL_PHP);
		$Registre->set('squelette_fichier', 'url');
		
		// Format de sortie positionne : affichage automatique
		$Registre->set(EF_LG_URL_FORMAT, aModule::SORTIE_HTML);
		
		$aso_donnees = array();
		$url =& $GLOBALS['_EFLORE_']['url_permalien'];
		$url->setType('nn');
		$url->setTypeId($_GET['nn']);
		$url->setProjetCode($_GET['cpr']);
		$url->setVersionCode($_GET['cprv']);
		$url->setPage('trackback');
		$aso_donnees['url'] = $url->getUrl();
		
		$Registre->set('squelette_donnees', $aso_donnees);
    }    
}
?>