<?php

abstract class aComposant {

    /*** Constantes : ***/
	
	const TPL_NULL = 'NULL';
	const TPL_PHP = 'PHP';
	const FORMAT_NULL = 'NULL';
	const FORMAT_HTML = 'html';
	
	/*** Attributs : ***/
	private $registre;
	private $cache;
	private $actions_chainees = null;
	
	/*** Constructeur : ***/
	
	public function __construct($options = array())
    {
		// Création du registre
		$this->registre = Registre::getInstance();
		
		$this->getRegistre()->set('cps_squelette_moteur', aComposant::TPL_PHP);
		$this->getRegistre()->set('cps_format', aComposant::FORMAT_HTML);
		$this->getRegistre()->set('cps_charset', 'ISO-8859-1');
		
		// Nous créons automatiquement les chemins vers les différents dossier de l'application
		$cps_dossier = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', get_class($this)));
		$this->getRegistre()->set('cps_chemin', EF_CHEMIN_COMPOSANT.$cps_dossier.DIRECTORY_SEPARATOR);
		$this->getRegistre()->set('cps_chemin_relatif', EF_CHEMIN_COMPOSANT_RELATIF.$cps_dossier.DIRECTORY_SEPARATOR);
		$this->getRegistre()->set('cps_chemin_config', $this->getRegistre()->get('cps_chemin').'configuration'.DIRECTORY_SEPARATOR);
		$this->getRegistre()->set('cps_chemin_config_relatif', $this->getRegistre()->get('cps_chemin_relatif').'configuration'.DIRECTORY_SEPARATOR);
		$this->getRegistre()->set('cps_chemin_squelette', $this->getRegistre()->get('cps_chemin').'squelettes'.DIRECTORY_SEPARATOR);
		$this->getRegistre()->set('cps_chemin_squelette_relatif', $this->getRegistre()->get('cps_chemin_relatif').'squelettes'.DIRECTORY_SEPARATOR);
		
		// Nous définissons si oui ou non le cache sera utilisé
		if (defined('EF_BOOL_STOCKAGE_CACHE')) {
			$this->cache_bool = EF_BOOL_STOCKAGE_CACHE;
		} else {
			$this->cache_bool = false;
			$e = 'La constante EF_BOOL_STOCKAGE_CACHE est indéfinie. Le cache a été désactivé!';
			trigger_error($e, E_USER_WARNING);
		}
		
		// Nous chargeons le fichier de config de l'appli s'il existe
		if ($this->getConfigFichier()) {
			require_once $this->getConfigFichier();
		}
    }

    /*** Accesseurs : ***/
    public function getRegistre()
    {
    	return $this->registre;
    }
    
    public function setCacheBool($cb)
    {
    	return $this->cache_bool = $cb;
    }
    
    /*** Méthodes : ***/
    
    public function getCacheId()
    {
    	if ($this->getActionNom() != null) {
    		$methode_cache_id = 'getCacheId'.$this->getActionNom();
    		if (method_exists($this, $methode_cache_id) && !is_null($this->$methode_cache_id())) {
    			return call_user_func(array($this, $methode_cache_id));
    		}
    	}
    	return null;
    }
    
    public function getCacheFichier()
    {
    	$fichier_cache = EF_CHEMIN_STOCKAGE_CACHE.$this->getCacheId();
    	if (!is_null($this->getCacheDuree())) {
    		$fichier_cache .= '_['.$this->getCacheDuree().']';
    	}
    	$fichier_cache .= '.cache.'.$this->getRegistre()->get('cps_format');
    	
    	return $fichier_cache;
    }
    
    public function getCacheDuree()
    {
    	$dlc = null;
    	$methode_cache_dlc = 'getCacheDlc'.$this->getActionNom();
    	if (method_exists($this, $methode_cache_dlc) && !is_null($this->$methode_cache_dlc())) {
    		$dlc = call_user_func(array($this, $methode_cache_dlc)); // dlc en seconde
    	}
    	return $dlc;
    }
    
    public function getActionNom()
    {
		if ($this->getRegistre()->get('cps_action') != null) {
			return $action = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->getRegistre()->get('cps_action'))));
		}
		return null;
    }
    
    public function setDebogage($d, $e = E_USER_NOTICE)
    {
    	if (is_array($d) || is_object($d)) {
    		trigger_error(print_r($d, true), $e);
    	} else {
    		trigger_error($d, $e);
    	}
    }
    
    public function setChrono($balise)
    {
		// Mesure du temps d'éxecution
		$class = new ReflectionClass($this);
		$GLOBALS['_EFLORE_']['chrono']->setTemps(array($class->getName().'-'.$balise => microtime()));
    }
    
    public function getSqueletteFichier()
    {
		// Par défaut le nom du fichier de squelette est construit à partir du nom de l'action.
		if (is_null($this->getRegistre()->get('cps_squelette_fichier'))) {
			$this->getRegistre()->set('cps_squelette_fichier', $this->getRegistre()->get('cps_action'));
		}

		// Nous recherchons s'il existe un squelette spécifique à la distribution
		$fichier_tpl_defaut =  	$this->getRegistre()->get('cps_chemin_squelette').
								$this->getRegistre()->get('cps_squelette_fichier').'.tpl.'.$this->registre->get('cps_format');
		if (defined('EF_DISTRIBUTION') && EF_DISTRIBUTION != ''&& !is_null(EF_DISTRIBUTION)) {
			$fichier_tpl_projet =  	$this->getRegistre()->get('cps_chemin_squelette').
									strtolower(EF_DISTRIBUTION).DIRECTORY_SEPARATOR.
									$this->getRegistre()->get('cps_squelette_fichier').'.tpl.'.$this->getRegistre()->get('cps_format');
			if (file_exists($fichier_tpl_projet)) {
				return $fichier_tpl_projet;
			}
		}
		if (file_exists($fichier_tpl_defaut)) {
			return $fichier_tpl_defaut;
		}
		return false;
    }
    
    public function getConfigFichier()
    {
		$fichier_conf_defaut = $this->getRegistre()->get('cps_chemin_config').'config.inc.php';
		if (defined('EF_DISTRIBUTION') && EF_DISTRIBUTION != '') {
			
			$fichier_conf_projet = 	$this->getRegistre()->get('cps_chemin_config').
									'config.'.strtolower(EF_DISTRIBUTION).'.inc.php';
			if (file_exists($fichier_conf_projet)) {
				return $fichier_conf_projet;
			}
		}
		if (file_exists($fichier_conf_defaut)) {
			return $fichier_conf_defaut;
		}
		return false;
    }
    
    public function getActionsChainees()
    {
    	// Création du tableau si nécessaire
		if (is_null($this->actions_chainees)) {
			$this->actions_chainees = array();
			$this->actions_chainees[] = $this->getRegistre()->get('cps_action');
		}
		return $this->actions_chainees;
    }
    
    public function poursuivreVers($action)
    {
		// Ajout de l'action suivante
   		$this->actions_chainees[] = $action;
    }

	public function __call($methode, $parametres)
	{
		// Gestion de l'action passé en paramêtre
		$action = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $methode));
		$this->getRegistre()->set('cps_action', $action);
		return $this->traiterAction($parametres);
	}
	
	public function traiterAction($parametres = array())
    {
		// Gestion des actions chainées si nécessaire
		$sortie = '';
		$cps_nom = strtolower(get_class($this));
		$i = 0;
		while ($i < count($this->getActionsChainees())) {
			// Initialisation de variables
			$actions = $this->getActionsChainees();
			$action = $actions[$i++];
			
			// Remise à défaut des valeurs du Registre pour la prochaine action
			$this->getRegistre()->set('cps_action', $action);
			$this->getRegistre()->set('cps_format', aModule::SORTIE_HTML);
			$this->getRegistre()->set('cps_squelette_fichier', null);
			$this->getRegistre()->set('cps_squelette_moteur', aModule::TPL_PHP);
			
			// Gestion du multilinguisme
			if (isset($GLOBALS['_EF_']['i18n'][$cps_nom][$action]) || isset($GLOBALS['_EF_']['i18n']['_defaut_'][$action])) {
				$this->getRegistre()->set('cps_i18n', $GLOBALS['_EF_']['i18n']['_defaut_']['general']);
				if (isset($GLOBALS['_EF_']['i18n']['_defaut_'][$action])) {
					$this->getRegistre()->set('cps_i18n', $GLOBALS['_EF_']['i18n']['_defaut_'][$action]);
				}
				if (isset($GLOBALS['_EF_']['i18n'][$cps_nom][$action])) {
					$this->getRegistre()->set('cps_i18n', $GLOBALS['_EF_']['i18n'][$cps_nom][$action]);
				}
				
				$aso_donnees = $this->getRegistre()->get('cps_squelette_donnees');
				$aso_donnees['i18n'] = $this->getRegistre()->get('cps_i18n');
				$this->getRegistre()->set('cps_squelette_donnees', $aso_donnees);
				
			}
			
			// Exécution du rendu de l'action
			$sortie .= $this->traiterRendu($parametres);
		}
		
		// Gestion de la sortie finale
		return $sortie;
    }
	
	private function traiterRendu($parametres = array())
    {		
		// Gestion du cache : avant toute chose, retour du cache s'il existe
    	if ($this->cache_bool) {
			//$this->setDebogage($this->getCacheId());
			if (!is_null($this->getCacheId())) {
				if (file_exists($this->getCacheFichier())) {
					// Gestion de la DLC
					if (	(is_null($this->getCacheDuree())) ||
							(!is_null($this->getCacheDuree()) && (time() < (filemtime($this->getCacheFichier()) + $this->getCacheDuree())))) {
						$this->getRegistre()->set('cps_sortie', file_get_contents($this->getCacheFichier()));
						return $this->traiterSortie();
					}
				}
			}
		}
		
    	// Execution de l'action
		$methode_action = 'executer';
		if ($this->getActionNom() != null) {
			$methode_action .= $this->getActionNom();
		}

		// Si aucune méthode ou au minimum un template n'existe nous renvoyons une erreur et aucun résutat
    	if (method_exists($this, $methode_action)) {
    		//call_user_func(array($this, $methode_action));
    		call_user_func_array(array($this, $methode_action), $parametres);
    	} else if (!$this->getSqueletteFichier()) {
    		$e = 'Aucun squelette ou méthode "'.$methode_action.'" n\'existe pour l\'action '.$this->getRegistre()->get('cps_action');
    		trigger_error($e, E_USER_WARNING);
    		return null;
    	}

    	// Gestion du rendu en fonction du type de template
    	switch($this->registre->get('cps_squelette_moteur')) {
			case aComposant::TPL_PHP :
				$Squelette = new SquelettePhp();
				$Squelette->set($this->getRegistre()->get('cps_squelette_donnees'));
				if ($this->getSqueletteFichier()) {
					$sortie = $Squelette->analyser($this->getSqueletteFichier());
					$this->getRegistre()->set('cps_sortie', $sortie);
				} else {
					$e = 'Action : '.$this->getRegistre()->get('cps_action').' fichier de squelette introuvable !';
					trigger_error($e, E_USER_WARNING);
					return null;
				}
				break;
    		case aComposant::TPL_NULL :
    			// Nous ne faisons rien, nous passons à la gestion du type de sortie
    			break;
    		default :
    			trigger_error('Moteur de squelette inconnu', E_USER_WARNING);
    			return null;
    	}
    	
    	// Gestion du cache : écriture du fichier
		if ($this->cache_bool) {
			if (!is_null($this->getCacheId())) {
				if (!file_put_contents($this->getCacheFichier(), $this->getRegistre()->get('cps_sortie'))) {
					$e = 'Écriture du fichier de cache impossible : '.$this->getCacheFichier();
					trigger_error($e, E_USER_WARNING);
				}
			 }
		}
		
		// Gestion du format de sortie
		return $this->traiterSortie();
    }
    
    private function traiterSortie()
    {
    	switch($this->getRegistre()->get('cps_format')) {
			case aComposant::FORMAT_HTML :
				// +--------------------------------------------------------------------------------------------------+				
				// Gestion du cache : affichage de la date du cache
				if ($this->cache_bool) {
					if (!is_null($this->getCacheId())) {
						$e = 	'Cache, généré le '.date('D d M Y à H:i:s', filemtime($this->getCacheFichier())).
								' sera généré à nouveau le '.
								date('D d M Y à H:i:s', (filemtime($this->getCacheFichier()) + $this->getCacheDuree()))." \n";
						trigger_error($e, E_USER_NOTICE);
					}
				}
				return EfloreEncodage::remplacerEsperluette($this->getRegistre()->get('cps_sortie'));
				break;
			default :
    			trigger_error('Type de sortie inconnu', E_USER_ERROR);
		}
    }
}
?>