<?php
/**
* La fonction __autoload() charge dynamiquement les classes trouvées dans le code.
*
* Cette fonction est appelée par php5 quand il trouve une instanciation de classe dans le code.
*
*@param string le nom de la classe appelée.
*@return void le fichier contenant la classe doit être inclu par la fonction.
*/
function __autoload($classe)
{
	// TODO : l'inclusion ci-dessous devrait se trouver dans le fichier eflore.php...
	require_once EF_CHEMIN_CONFIG.'ef_config_chemin.inc.php';
	$fichier = $classe.'.php';
	//echo $classe.'-'.$fichier.'<br/>';
	if (file_exists($fichier)) {
		require_once $fichier;
	} else if (file_exists(EF_CHEMIN_BIBLIO_PEAR.$fichier)) {
		require_once EF_CHEMIN_BIBLIO_PEAR.$fichier;
	} else if (file_exists(EF_CHEMIN_PEAR.$fichier)) {
		require_once EF_CHEMIN_PEAR.$fichier;
	} else if (substr_count($classe, '_') > 0 && !preg_match('/^(?:Carto_Carte|Carto_Couleur)$/', $classe)) {
		// Gestion des classes PEAR
		$tab_chemin = explode('_', $classe);
		$fichier = '';
		$nbre_niveau = count($tab_chemin);
		for ($i = 0; $i < $nbre_niveau; $i++) {
			if (($nbre_niveau-1) == $i) {
				$fichier .= $tab_chemin[$i].'.php';
			} else {
				$fichier .= $tab_chemin[$i].DIRECTORY_SEPARATOR;
			}
		}
		if (file_exists(EF_CHEMIN_BIBLIO_PEAR.$fichier)) {
			require EF_CHEMIN_BIBLIO_PEAR.$fichier;
			return null;
		} else if (file_exists(EF_CHEMIN_PEAR.$fichier)) {
			require EF_CHEMIN_PEAR.$fichier;
			return null;
		}
	} else if (preg_match('/^Ef[A-Z][a-z]+(?:[A-Z][a-z])*/', $classe)) {
		// Ajout du fichier principal d'un module si la classe commence par "Ef"
		$nom = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $classe));
		$fichier = EF_CHEMIN_MODULE.$nom.DIRECTORY_SEPARATOR.$nom.'.php';
		if (file_exists($fichier)) {
			require_once $fichier;
		}
	} else if (preg_match('/^Action((?:[A-Z][a-z]+)+)/', $classe, $match)) {
		// Ajout du fichier d'une classe d'action d'un module si la classe commence par "Action"
		$tab_modules = scandir(EF_CHEMIN_MODULE);
		$action = strtolower($match[1]);
		//echo '<pre>'.print_r($tab_modules, true).'</pre>';
		foreach ($tab_modules as $modules) {
			if (preg_match('/^ef_([a-z_]+)$/', $modules, $match)) {
				$module_initiales = substr($match[1], 0, 2);
				$nom = 'ef'.$module_initiales.'_'.$action.'.action.php';
				$fichier = EF_CHEMIN_MODULE.$modules.DIRECTORY_SEPARATOR.'actions'.DIRECTORY_SEPARATOR.$nom;
				if (file_exists($fichier)) {
					require_once $fichier;
					break;
				}
			}
		}
	    // Désolé jp : un hack pour charger ActionAvecCache, car le code ci-dessus ne le charge pas. dd
		if ($classe='ActionAvecCache') {
    		$fichier = EF_CHEMIN_BIBLIO_NOYAU.DIRECTORY_SEPARATOR.'ActionAvecCache.class.php';
    		if (file_exists($fichier)) {
    			require_once $fichier;
    		}
		}

	} else if (preg_match('/^Vue(?:[A-Z][a-z])+/', $classe, $match)) {
		// Ajout du fichier d'une classe de vue d'un module si la classe commence par "Vue"
		$tab_modules = scandir(EF_CHEMIN_MODULE);
		$action = strtolower($match[1]);
		//echo '<pre>'.print_r($tab_modules, true).'</pre>';
		foreach ($tab_modules as $modules) {
			if (preg_match('/^ef_([a-z_]+)$/', $modules, $match)) {
				$module_initiales = substr($match[1], 0, 2);
				$nom = 'ef'.$module_initiales.'_'.$action.'.vue.php';
				$fichier = 	EF_CHEMIN_MODULE.$modules.DIRECTORY_SEPARATOR.'presentations'.
							DIRECTORY_SEPARATOR.'vues'.DIRECTORY_SEPARATOR.$nom;
				if (file_exists($fichier)) {
					require_once $fichier;
					break;
				}
			}
		}
	} else {
		$bool_poursuivre = true;
		
		if (isset($GLOBALS['_EFLORE_']['api']['ok']) && $GLOBALS['_EFLORE_']['api']['ok']) {
			$version = $GLOBALS['_EFLORE_']['api']['version'];
			$chemin_base = EF_CHEMIN_EFLORE_API.'eflore_'.$version.DIRECTORY_SEPARATOR;
			foreach ($GLOBALS['_EFLORE_']['api']['chemins'] as $chemin) {
				$fichier = $chemin_base.$chemin.$classe.'.class.php';
				if (file_exists($fichier)) {
					//echo $fichier."<br>";
					require_once $fichier;
					$bool_poursuivre = false;
					break;
				}
			}
		}
		if ($bool_poursuivre) {
			// Gestion des classes de la bibliothèque et du module "ef_commun"
			foreach ($GLOBALS['_EFLORE_']['chemins_classes'] as $chemin) {
				$fichier = $chemin.$classe.'.class.php';
				if (file_exists($fichier)) {
					//echo $fichier."<br>";
					require_once $fichier;
					break;
				}
			}
		}
	}
	// Insertion des modules nouveaux!
	$chemin_module_nouveau = EF_CHEMIN_MODULE.strtolower($classe).'/'.$classe.'.class.php';
	if (file_exists($chemin_module_nouveau)) {
		require_once $chemin_module_nouveau;
	}
}
?>
