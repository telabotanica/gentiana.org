<?php

abstract class aModule {
	
	/*** Constantes : ***/
	
	const TPL_NULL = 'NULL';
	const TPL_PHP = 'PHP';
	const TPL_PHP_MAIL = 'PHP_MAIL';
	const TPL_IT = 'IT';
	const TPL_FPDI = 'FPDI';
	const SORTIE_NULL = 'NULL';
	const SORTIE_EXIT = 'EXIT';
	const SORTIE_XLS = 'xls';
	const SORTIE_MAIL_SMTP = 'email';
	const SORTIE_HTML = 'html';
	const SORTIE_EXIT_HTML = 'exit.html';
	const SORTIE_XML = 'xml';
	const SORTIE_PDF = 'pdf';
	
	/*** Attributs : ***/
	private $registre;
	private $cache;
	private $actions_chainees = null;
	
	/*** Constructeur : ***/
	
	public function __construct()
    {
    	$this->registre = Registre::getInstance();
		$this->registre->set('squelette_moteur', aModule::TPL_PHP);
		$this->registre->set(EF_LG_URL_FORMAT, aModule::SORTIE_HTML);
		$module_dossier = $this->getModuleNomDossier(get_class($this));
		
		// Nous créons automatiquement les chemins vers les différents dossier de l'application
		$this->registre->set('chemin_module', EF_CHEMIN_MODULE.$module_dossier.DIRECTORY_SEPARATOR);
		$this->registre->set('chemin_module_relatif', EF_CHEMIN_MODULE_RELATIF.$module_dossier.DIRECTORY_SEPARATOR);
		$this->registre->set('chemin_module_config', $this->registre->get('chemin_module').'configuration'.DIRECTORY_SEPARATOR);
		$this->registre->set('chemin_module_config_relatif', $this->registre->get('chemin_module_relatif').'configuration'.DIRECTORY_SEPARATOR);
		$this->registre->set('chemin_module_squelette', $this->registre->get('chemin_module').'squelettes'.DIRECTORY_SEPARATOR);
		$this->registre->set('chemin_module_squelette_relatif', $this->registre->get('chemin_module_relatif').'squelettes'.DIRECTORY_SEPARATOR);
		
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
    
    public function getModuleNomDossier($nom)
    {
    	return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $nom));
    }
    
    public function getCacheId()
    {
    	if ($this->getActionNom() != null) {
    		$methode_cache_id = 'getCacheId'.$this->getActionNom();
    		$methode_cache = 'getCache';
    		if (method_exists($this, $methode_cache_id)) {
    			// Appel de la méthode spécifique à une action
    			return $this->$methode_cache_id();
    		} else if (method_exists($this, $methode_cache)) {
    			// Appel de la méthode générale pour une classe d'action...
    			return $this->$methode_cache($this->getActionNom());
    		}
    	}
    	return null;
    }
    
    public function getCacheFichier($cache_id = null)
    {
    	if (is_null($cache_id)) {
    		$cache_id = $this->getCacheId();
    	}
    	$fichier_cache = EF_CHEMIN_STOCKAGE_CACHE.$cache_id;
    	if (!is_null($this->getCacheDuree())) {
    		$fichier_cache .= '_[dlc#'.$this->getCacheDuree().']';
    	}
    	$fichier_cache .= '.cache.'.$this->getRegistre()->get('format');
    	
    	return $fichier_cache;
    }
    
    public function getCacheDuree()
    {
    	if ($this->getActionNom() != null) {
	    	$methode_cache_dlc = 'getCacheDlc'.$this->getActionNom();
	    	$methode_cache_dlc_generale = 'getCacheDlc';
	    	if (method_exists($this, $methode_cache_dlc)) {
	    		return $this->$methode_cache_dlc(); // dlc en seconde
	    	} else if (method_exists($this, $methode_cache_dlc_generale)) {
	    		return $this->$methode_cache_dlc_generale($this->getActionNom()); // dlc en seconde
	    	}
    	}
    	return null;
    }
    
    public function getActionNom()
    {
		if ($this->getRegistre()->get('action') != null) {
			return $action = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->getRegistre()->get('action'))));
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
		$fichier_tpl_null = false;
		if (is_null($this->getRegistre()->get('squelette_fichier'))) {
			$this->getRegistre()->set('squelette_fichier', $this->getRegistre()->get('action'));
			$fichier_tpl_null = true;
		}

		// Nous recherchons s'il existe un squelette spécifique à la distribution
		$fichier_tpl_defaut =  	$this->getRegistre()->get('chemin_module_squelette').
								$this->getRegistre()->get('squelette_fichier').'.tpl.'.$this->registre->get('format');
		if (defined('EF_DISTRIBUTION') && EF_DISTRIBUTION != ''&& !is_null(EF_DISTRIBUTION)) {
			$fichier_tpl_distrib =  	$this->getRegistre()->get('chemin_module_squelette').
									strtolower(EF_DISTRIBUTION).DIRECTORY_SEPARATOR.
									$this->getRegistre()->get('squelette_fichier').'.tpl.'.$this->getRegistre()->get('format');
			if (file_exists($fichier_tpl_distrib)) {
				return $fichier_tpl_distrib;
			}
		}
		if (file_exists($fichier_tpl_defaut)) {
			return $fichier_tpl_defaut;
		} else if (!$fichier_tpl_null) {
			// Affichage d'un message d'erreur car un squelette a été indiqué mais il est introuvable!
			$e = 'Action : '.$this->getRegistre()->get('action').' fichier de squelette introuvable !';
			trigger_error($e, E_USER_WARNING);
		}
		return false;
    }
    
    public function getConfigFichier()
    {
		$fichier_conf_defaut = $this->getRegistre()->get('chemin_module_config').'config.inc.php';
		if (defined('EF_DISTRIBUTION') && EF_DISTRIBUTION != '') {
			
			$fichier_conf_projet = 	$this->getRegistre()->get('chemin_module_config').
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
			$this->actions_chainees[] = array('action' => $this->getRegistre()->get('action'), 'module' => null);
		}
		return $this->actions_chainees;
    }
    
    public function poursuivreVers($action, $module = null)
    {
		// Ajout de l'action suivante
   		$this->actions_chainees[] = array('action' => $action, 'module' => $module);
    }
    
	public function traiterAction()
    {	
		// Gestion des actions chainées si nécessaire
		$sortie = '';
		$i = 0;
		while ($i < count($this->getActionsChainees())) {
			// Initialisation de variables
			$actions = $this->getActionsChainees();
			$action = $actions[$i]['action'];
			$module_nom_i18n = strtolower(get_class($this));
			$Module = $this;
			if (!is_null($actions[$i]['module'])) {
				$module_nom_i18n = strtolower($actions[$i]['module']);
				$Module = new $actions[$i]['module'];
			}
			
			// Remise à défaut des valeurs du Registre pour la prochaine action
			$this->getRegistre()->set('action', $action);
			$this->getRegistre()->set('format', aModule::SORTIE_HTML);
			$this->getRegistre()->set('squelette_fichier', null);
			$this->getRegistre()->set('squelette_moteur', aModule::TPL_PHP);
			
			// Gestion du multilinguisme
			if (isset($GLOBALS['_EF_']['i18n'][$module_nom_i18n][$action]) || isset($GLOBALS['_EF_']['i18n']['_defaut_'][$action])) {
				$this->getRegistre()->set('module_i18n', $GLOBALS['_EF_']['i18n']['_defaut_']['general']);
				if (isset($GLOBALS['_EF_']['i18n']['_defaut_'][$action])) {
					$this->getRegistre()->set('module_i18n', $GLOBALS['_EF_']['i18n']['_defaut_'][$action]);
				}
				if (isset($GLOBALS['_EF_']['i18n'][$module_nom_i18n][$action])) {
					$this->getRegistre()->set('module_i18n', $GLOBALS['_EF_']['i18n'][$module_nom_i18n][$action]);
				}
				
				$aso_donnees = $this->getRegistre()->get('squelette_donnees');
				$aso_donnees['i18n'] = $this->getRegistre()->get('module_i18n');
				$this->getRegistre()->set('squelette_donnees', $aso_donnees);
				
			}
			
			// Exécution du rendu de l'action
			$sortie .= $Module->traiterRendu($action);
			
			// Passage à l'action suivante 
			$i++;
		}
		
		// Gestion de la sortie finale
		return $sortie;
    }
	
	private function traiterRendu()
    {		
		// Gestion du cache : avant toute chose, retour du cache s'il existe
    	if ($this->cache_bool) {
			// Nous récupérons ici l'identifiant du cache dans $cache_id car la variable $_GET peut être modifié par les actions...
			// On se retrouve alors avec deux valeurs d'identifiant de cache différentes
			//$this->setDebogage($this->getCacheId());
			if (!is_null($cache_id = $this->getCacheId())) {
				if (file_exists($this->getCacheFichier($cache_id))) {
					// Gestion de la DLC
					if (	(is_null($this->getCacheDuree())) ||
							(!is_null($this->getCacheDuree()) && (time() < (filemtime($this->getCacheFichier($cache_id)) + $this->getCacheDuree())))) {
						// Gestion du cache : affichage de la date du cache
						$e = 	'Cache, généré le '.date('D d M Y à H:i:s', filemtime($this->getCacheFichier($cache_id))).
								' sera généré à nouveau le '.
								date('D d M Y à H:i:s', (filemtime($this->getCacheFichier($cache_id)) + $this->getCacheDuree()))." \n";
						trigger_error($e, E_USER_NOTICE);
							
						$this->registre->set('sortie', file_get_contents($this->getCacheFichier($cache_id)));
						return $this->traiterSortie();
					}
				}
			}
		}
		
		// Attribution si nécessaire de l'encodage de sortie
		if (!$this->registre->get('charset')) {
			$this->registre->set('charset', 'ISO-8859-1');
		}
		
    	// Execution de l'action
		$methode_action = 'executer';
		if ($this->getActionNom() != null) {
			$methode_action .= $this->getActionNom();
		}

		// Si aucune méthode ou au minimum un template n'existe nous renvoyons une erreur et aucun résutat
    	if (method_exists($this, $methode_action)) {
    		call_user_func(array($this, $methode_action));
    	} else if (!$this->getSqueletteFichier()) {
    		// Tentative de recherche de l'action dans le module des Communs
    		$fichier_communs = EF_CHEMIN_MODULE.'communs'.DIRECTORY_SEPARATOR.'Communs.class.php';
    		if (file_exists($fichier_communs)) {
    			include_once $fichier_communs;
				$Commun = new Communs();
				$sortie_commun = $Commun->traiterAction();
    		}
			if (isset($sortie_commun)) {
				return $sortie_commun;
			} else {
    			$e = 'Aucun squelette ou méthode "'.$methode_action.'" n\'existe pour l\'action '.$this->registre->get('action');
    			trigger_error($e, E_USER_WARNING);
    			return null;
			}
    	}

    	// Gestion du rendu en fonction du type de template
    	switch($this->registre->get('squelette_moteur')) {
			case aModule::TPL_PHP_MAIL :
			case aModule::TPL_PHP :
				$Squelette = new SquelettePhp();
				$Squelette->set($this->getRegistre()->get('squelette_donnees'));
				if ($this->getSqueletteFichier()) {
					$sortie = $Squelette->analyser($this->getSqueletteFichier());
					if ($this->registre->get('squelette_moteur') == aModule::TPL_PHP_MAIL) {
						// Traitement spécial pour les mails
						if (preg_match_all('/<(html|txt|file)(?:>(.*?)<\/\\1>|\s+src="(.*)"\s+type="(.*)"\s*\/>\s*$)/ism', $sortie, $decoupage, PREG_SET_ORDER)) {
							$this->registre->set('sortie_mail_mime', $decoupage);
						}
					} else {
						$this->registre->set('sortie', $sortie);
					}
				} else {
					return null;
				}
				break;
    		case aModule::TPL_NULL :
    			// Nous ne faisons rien, nous passons à la gestion du type de sortie
    			break;
    		default :
    			trigger_error('Moteur de squelette inconnu', E_USER_WARNING);
    			return null;
    	}
    	
    	// Gestion du cache : écriture du fichier
		if ($this->cache_bool) {
			if (!is_null($cache_id)) {
				if (!file_put_contents($this->getCacheFichier($cache_id), $this->getRegistre()->get('sortie'))) {
					$e = 'Écriture du fichier de cache impossible : '.$this->getCacheFichier($cache_id);
					trigger_error($e, E_USER_WARNING);
				}
			 }
		}
		
		// Gestion du format de sortie
		return $this->traiterSortie();
    }
    
    private function traiterSortie()
    {
    	switch($this->getRegistre()->get('format')) {
			case aModule::SORTIE_HTML :
				// +--------------------------------------------------------------------------------------------------+
				// Remplacement du titre fournit par Papyrus par celui créé dans l'appli
				if (defined('PAP_VERSION') && !empty($GLOBALS['_EFLORE_']['titre'])) {
					$GLOBALS['_PAPYRUS_']['rendu']['TITRE_PAGE'] = $GLOBALS['_EFLORE_']['titre'];
				}
				// +--------------------------------------------------------------------------------------------------+
				// A FAIRE : Gestion des statistiques

				return EfloreEncodage::remplacerEsperluette($this->getRegistre()->get('sortie'));
				break;
			case aModule::SORTIE_EXIT_HTML :
				echo Encodage::remplacerEsperluette($this->registre->get('sortie'));
				exit();
				break;
			case aModule::SORTIE_XML :
				header('Content-Type: application/xhtml+xml; charset='.$this->registre->get('charset'));
				echo $this->registre->get('sortie');
				exit();
				break;
			case aModule::SORTIE_PDF :
				header('Content-type: application/pdf');
				header('Content-Length: '.strlen($this->getRegistre()->get('sortie')));
				header('Content-Disposition: inline; filename='.str_replace(' ', '_', $GLOBALS['_EFLORE_']['titre_fichier']).'.pdf');//
				echo $this->registre->get('sortie');
				break;
			case aModule::SORTIE_MAIL_SMTP :
				//trigger_error(print_r($this->getRegistre()->get('sortie_mail_mime'), true), E_USER_NOTICE);
				// TODO : réseoudre le problème de l'autoload pour les fichiers PEAR ci-dessous
				include_once 'Mail.php';
				include_once 'Mail/smtp.php';
				$sortie_mail = '';
				// Nous vérifions si nous avons à faire à un mail mime ou pas
				if (is_null($this->getRegistre()->get('sortie_mail_mime'))) {
					$sortie_mail = $this->getRegistre()->get('sortie');
				} else {
					// Pour l'instant supporte du html et son alternative en txt plus des fichiers attachés
					// TODO : Les mails multiparts contenant des imbrications de html et de txt ne sont pas encore pris en compte...
					include_once 'Mail/mime.php';
					$MailMime = new Mail_mime("\n");
					foreach ($this->getRegistre()->get('sortie_mail_mime') as $valeur) {
						switch (strtolower($valeur[1])) {
							case 'txt' :
								// Syntaxe multiligne: <txt>mettre ici du texte brute</txt>
								$MailMime->setTXTBody($valeur[2]);
								break;
							case 'html' :
								// Syntaxe multiligne: <html>mettre ici votre html</html>
								$MailMime->setHTMLBody($valeur[2]);
								break;
							case 'file' :
								// Syntaxe sur une ligne: <file src="/tmp/un_test.txt" type="text/plain" />
								$e = $MailMime->addAttachment($valeur[3], $valeur[4]);
								if ($e instanceof PEAR_Error) {
									trigger_error($e->getMessage(), E_USER_NOTICE);
								}
								break;
							default :
								trigger_error('Type de balise inconnue :'.$valeur[1], E_USER_WARNING);
						}
					}
					//do not ever try to call these lines in reverse order
					$sortie_mail = $MailMime->get();
					$this->getRegistre()->set('sortie_mail_smtp_entete', $MailMime->headers($this->getRegistre()->get('sortie_mail_smtp_entete')));
				}
				$mail_object = new Mail_smtp($this->getRegistre()->get('sortie_mail_smtp_params'));
				$message = $mail_object->send(	$this->getRegistre()->get('sortie_mail_smtp_destinataire'), 
												$this->getRegistre()->get('sortie_mail_smtp_entete'), 
												$sortie_mail);
				$this->getRegistre()->set('sortie_mail_smtp_info', $message);
				return null;
				break;
			case aModule::SORTIE_XLS :
			case aModule::SORTIE_EXIT :
    			// Nous ne faisons rien, nous terminons seulement le programme ici
    			exit();
    			break;
			case aModule::SORTIE_NULL :
    			// Nous ne faisons rien, nous retournons null
    			return null;
    			break;
			default :
    			trigger_error('Type de sortie inconnu', E_USER_ERROR);
		}
    }
}
?>