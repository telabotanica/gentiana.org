<?php

abstract class aDaoSql {
	/*** Constantes : ***/
	
	const RESULTAT_UNIQUE = 1;
	const RESULTAT_OBJET_UNIQUE = 2;
	const RESULTAT_OBJET_MULTIPLE = 3;
	
	/*** Attributs: ***/

	/**
	* Connexion à la base de données.
	* @access private
	*/
	private $connexion;
	
	/**
	* Noms des bases de données
	* @access private
	*/
	private $bdd_principale = '';
	private $bdd_historique = '';
	
	/**
	* Requete demandée.
	* @access private
	*/
	private $requete;
	
	/**
	* Permet de savoir le type de résultat retouné par une requête.
	* @access private
	*/
	private $resultat_type;

	/**
	* Permet de savoir quel est le type de débogage désiré.
	* @access private
	*/
	private $debogage;

	/**
	* Permet de savoir si oui ou non la gestion de l'archivage est activée.
	* @access private
	*/
	private $historisation = true;

	/**
	* Nom de l'objet dont on manipule les informations.
	* @access protected
	*/
	protected $nom_type_info;

	/**
	* Tableau d'objets enfants.
	* @access private
	*/
	private $enfants = array();

	private $table_nom = '';
	private $table_prefixe = '';
	private $table_champs = array();
	//private $table_relations = array();
	
	// Gestion de la création d'un fichier sql
	private static $fichier_sql;
	private static $fichier_sql_resource;
	private $fichier_sql_mark = false;
	private $fichier_sql_prefixe = '';
	private $fichier_sql_chemin = '';
	private static $fichier_sql_ecraser = true;
	private static $fichier_sql_fermer = false;
	
	// Gestion d'un pager
	private $limit_bool = false;
	private $limit_nbre = 10;
	private $limit_debut = 0;
	
	/*** Constructeurs : ***/
	 
	/**
	* Constructeur du type de données issu de la base de données.
	*
	* @param int id Identifiant du type de donnée.
	* @return object
	* @access public
	*/
	public function __construct($connexion = null, $table_nom, $table_prefixe, $table_champs)
	{
		// Connexion à la base de données
		$this->setConnexion($connexion);
		// Le nom de la table
		$this->setTableNom($table_nom);
		// Le prefixe de la table
		$this->setTablePrefixe($table_prefixe);
		// Les champs de la table
		$this->setTableChamps($table_champs);		
		// Déclaration du type de débogage par défaut : aucun.
		$this->setDebogage(EF_DEBOG_AUCUN);
		// Gestion du fichier stockant le sql
		if ($this->getFichierSqlMark()) {
			$this->setFichierSqlPrefixe('api_eflore_v1.1.1');
			$this->setFichierSqlChemin('/tmp/');
			self::getFichierSql($this->getFichierSqlChemin().$this->getFichierSqlPrefixe());
			self::getFichierSqlRessource();
			self::$fichier_sql_ecraser = true; 
		}

		// Gestion du pager de résultat
		if (isset($_SESSION['_API_']['limit']['bool']) && $_SESSION['_API_']['limit']['bool']) {
			if (isset($_SESSION['_API_']['limit']['nbre']) && isset($_SESSION['_API_']['limit']['debut'])) {
				$this->setLimitBool(true);
				$this->setLimitNbre($_SESSION['_API_']['limit']['nbre']);
				$this->setLimitDebut($_SESSION['_API_']['limit']['debut']);
			} else {
				$e = 	'Vous devez définir les variables de sessions : $_SESSION["_API_"]["limit"]["nbre"] et '.
						' $_SESSION["_API_"]["limit"]["debut"]';
				trigger_error($e, E_USER_WARNING);
			}
		}

		// Gestion de l'encodage
		if (EF_LANGUE_UTF8) {
			// Récupération des infos au format UTF-8
			$requete = 	'SET NAMES "utf8"';
			$info = $this->getConnexion()->query($requete);
			if (PEAR::isError($info)) {
				$fichier = get_class($this);
				$methode = '__construct()';
				$e = GestionnaireErreur::retournerErreurSql($fichier, $methode, $info->getMessage(), $requete);
		    	trigger_error($e, E_USER_ERROR);
		    }
		}
	}
	
	/**
	* Destructeur du type de données issu de la base de données.
	* 
	* Le destructeur rétabli l'encodage par défaut qui est latin 1 dans Papyrus.
	*
	* @access public
	*/
	public function __destruct()
	{
		if ($this->getFichierSqlMark()) {
			self::getFichierSqlRessource(true);
		}
		if (EF_LANGUE_UTF8) {
			// Rétablissement de l'encodage par défaut pour la connection avec la base de données
			$requete = 	'SET NAMES DEFAULT';
			$info = $this->getConnexion()->query($requete);
			if (PEAR::isError($info)) {
				$fichier = get_class($this);
				$methode = '__destruct()';
				$e = GestionnaireErreur::retournerErreurSql($fichier, $methode, $info->getMessage(), $requete);
		    	trigger_error($e, E_USER_ERROR);
			}
		}
	}
	
	/*** Accesseurs : ***/
	 
	// Connexion
	/**
	* Lit la valeur de l'attribut connexion.
	* 
	* @access public
	* @return PEAR.DB connexion à la base de données.
	*/
	public function getConnexion( )
	{
		return $this->connexion;
	}
	/**
	* Définit la valeur de l'attribut connexion.
	*
	* @param PEAR.DB connexion à la base de données.
	* @return
	* @access public
	*/
	public function setConnexion( $connexion )
	{
		$this->connexion = $connexion;
	}
	
	// eFlore : stokage données Principal
	public function getStockagePrincipal()
	{
		return $this->bdd_principale;
	}
	public function setStockagePrincipal($stock)
	{
		$this->bdd_principale = $stock;
	}

	// eFlore : stokage données Historique
	public function getStockageHistorique()
	{
		return $this->bdd_historique;
	}
	public function setStockageHistorique($stock)
	{
		$this->bdd_historique = $stock;
	}
		
	// Table Nom
	/**
	* Lit la valeur de l'attribut "table nom".
	* @access public
	* @return string
	*/
	public function getTableNom()
	{
		return $this->table_nom;
	}
	/**
	* Écris la valeur de l'attribut "table nom".
	* @access public
	* @param string le nom de la table.
	*/
	public function setTableNom($tn)
	{
		$this->table_nom = $tn;
	}
	
	// Table Champs
	/**
	* Lit la valeur de l'attribut "table champs".
	* @access public
	* @return string
	*/
	public function getTableChamps($cle = null)
	{
		if (is_null($cle)) {
			return $this->table_champs;
		} else {
			return $this->table_champs[$cle];
		}
	}
	
	// Table Relations
	/**
	* Lit la valeur de l'attribut "table relations".
	* @access public
	* @return string
	*/
	public function getTableRelations($cle = null)
	{
		if (is_null($cle)) {
			return $this->table_relations;
		} else {
			return $this->table_relations[$cle];
		}
	}
	
	/**
	* Écris la valeur de l'attribut "table champs".
	* @access public
	* @param array le talbeau associatif des champs.
	*/
	public function setTableChamps($tc)
	{
		$this->table_champs = $tc;
	}
	
	// Table Prefixe
	/**
	* Lit la valeur de l'attribut "table prefixe".
	* @access public
	* @return string
	*/
	public function getTablePrefixe()
	{
		return $this->table_prefixe;
	}
	/**
	* Ecris la valeur de l'attribut "table prefixe".
	* @access public
	* @param string le préfixe des noms des champs de la table.
	*/
	public function setTablePrefixe($tp)
	{
		$this->table_prefixe = $tp;
	}

	// Requete
	/**
	* Lit la valeur de l'attribut requete.
	*
	* @return string la requete.
	* @access public
	*/
	public function getRequete( )
	{
		return $this->requete;
	}
	/**
	* Définit la valeur de l'attribut requete.
	*
	* @param string Contient une requete CRUD.
	* @return void
	* @access public
	*/
	public function setRequete( $requete )
	{
		$this->requete = $requete;
		if ($this->getFichierSqlMark()) {
			// Nous enregistrons uniquement les requetes modifiant la base
			if (preg_match('/^(?:INSERT|UPDATE|DELETE)/', $requete)) {
				$requete_format_fichier = preg_replace('/\n/', '\\n', $requete);
				$requete_format_fichier = preg_replace('/ VALUES /', "\n VALUES ", $requete_format_fichier);
				$requete_format_fichier .= ';'."\n";
				if (!fwrite(self::getFichierSqlRessource(), $requete_format_fichier)) {
					echo 'Resource : '.self::getFichierSqlRessource()."\n";
					echo 'Erreur écriture dans le fichier SQL.'."\n";
				}
			}
		}
	}
	
	// Resultat Type
	/**
	* Lit la valeur de l'attribut resultat_type.
	*
	* @return mixed une valeur contenue dans les constantes aDaoSql::RESULTAT...
	* @access public
	*/
	public function getResultatType( )
	{
		return $this->resultat_type;
	}
	/**
	* Définit la valeur de l'attribut resultat type.
	*
	* @param mixed une valeur contenue dans les constantes aDaoSql::RESULTAT...
	* @return void
	* @access public
	*/
	public function setResultatType( $rt )
	{
		$this->resultat_type = $rt;
	}

	// Historisation
	/**
	* Lit la valeur de l'attribut historisation.
	* 
	* @access public
	* @return bool true si l'archivage est activé.
	*/
	public function getHistorisation( )
	{
		return $this->historisation;
	}
	/**
	* Définit la valeur de l'attribut historisation.
	*
	* @param bool true si on veut activer l'archivage.
	* @return
	* @access public
	*/
	public function setHistorisation( $h )
	{
		$this->historisation = $h;
	}

	// Nom de l'objet manipulé
	/**
	* Lit la valeur de l'attribut nom_type_info.
	* @access public
	* @return string
	*/
	public function getNomTypeInfo()
	{
		return $this->nom_type_info;
	}
	/**
	* Définit la valeur de l'attribut nom_type_info.
	*
	* @param string Définit le nom de l'objet dont on manipule les infos.
	* @return void
	* @access public
	*/
	public function setNomTypeInfo( $nti )
	{
		$this->nom_type_info = $nti;
	}
	
	// Enfants
	/**
	* Lit la valeur de l'attribut enfants.
	* @access public
	* @return string
	*/
	public function getEnfants($cle = null)
	{
		if (is_null($cle)) {
			return $this->enfants;
		} else {
			return $this->enfants[$cle];
		}
	}
	
	// Débogage
	/**
	 * Lit la valeur de l'attribut debogage.
	 * 
	 * @access public
	 * @return bool
	 */
	public function getDebogage()
	{
		return $this->debogage;
	}
	/**
	 * Définit la valeur de l'attribut debogage.
	 *
	 * @param bool Définit le type de débogage.
	 * @return void
	 * @access public
	 */
	public function setDebogage( $debogage )
	{
		$this->debogage = $debogage;
	}
	
	// Fichier SQL Mark 
	/**
	 * Lit la valeur de l'attribut fichier_sql_mark.
	 * 
	 * @access public
	 * @return bool
	 */
	public function getFichierSqlMark()
	{
		return $this->fichier_sql_mark;
	}
	
	/**
	 * Définit la valeur de l'attribut fichier_sql_mark.
	 *
	 * @param bool Définit si oui ou non on créé un fichier SQL.
	 * @return void
	 * @access public
	 */
	public function setFichierSqlMark( $fsm )
	{
		$this->fichier_sql_mark = $fsm;
	}
	
	// Fichier SQL Chemin 
	/**
	 * Lit la valeur de l'attribut fichier_sql_chemin.
	 * 
	 * @access public
	 * @return string
	 */
	public function getFichierSqlChemin()
	{
		return $this->fichier_sql_chemin;
	}
	/**
	 * Définit la valeur de l'attribut fichier_sql_chemin.
	 *
	 * @param string Définit le chemin du fichier SQL.
	 * @return void
	 * @access public
	 */
	public function setFichierSqlChemin( $fsc )
	{
		if (!is_null($fsc)) {
			$this->fichier_sql_chemin = $fsc;
		}
	}
	
	/** Lit la valeur de l'attribut fichier_sql_prefixe.
	 * 
	 * @access public
	 * @return string
	 */
	public function getFichierSqlPrefixe()
	{
		return $this->fichier_sql_prefixe;
	}
	/**
	 * Définit la valeur de l'attribut fichier_sql_prefixe.
	 *
	 * @param string Définit le préfixe du nom du fichier SQL.
	 * @return void
	 * @access public
	 */
	public function setFichierSqlPrefixe( $fsp )
	{
		$this->fichier_sql_prefixe = $fsp;
	}
	
	/** Lit la valeur de l'attribut limit_bool.
	 * 
	 * @access public
	 * @return string
	 */
	public function getLimitBool()
	{
		return $this->limit_bool;
	}
	/**
	 * Définit la valeur de l'attribut limit_bool.
	 *
	 * @param int le nombre de lignes à renvoyer.
	 * @return void
	 * @access public
	 */
	public function setLimitBool( $lb )
	{
		$this->limit_bool = $lb;
	}
	
	/** Lit la valeur de l'attribut limit_nbre.
	 * 
	 * @access public
	 * @return string
	 */
	public function getLimitNbre()
	{
		return $this->limit_nbre;
	}
	/**
	 * Définit la valeur de l'attribut limit_nbre.
	 *
	 * @param int le nombre de lignes à renvoyer.
	 * @return void
	 * @access public
	 */
	public function setLimitNbre( $ln )
	{
		$this->limit_nbre = $ln;
	}
	
	/** Lit la valeur de l'attribut limit_debut.
	 * 
	 * @access public
	 * @return string
	 */
	public function getLimitDebut()
	{
		return $this->limit_debut;
	}
	/**
	 * Définit la valeur de l'attribut limit_debut.
	 *
	 * @param int la ligne de début.
	 * @return void
	 * @access public
	 */
	public function setLimitDebut( $ld )
	{
		$this->limit_debut = $ld;
	}
	
	public function getClasseNom()
	{
		return $this->classe_nom;
	}
	
	
	/*** Méthodes : ***/
	
	/**
	 * Permet de consulter un type de données.
	 *
	 * @param array tableau de paramêtres à passer à la requête.
	 * @param string nom de l'objet à instancier.
	 * @return array
	 * @access public
	 */
	public function consulterPlusieursTables()
	{
		// Initialisation des variables
		$requete_select = 'SELECT ';
		$requete_from = 'FROM ';
		$requete_where = 'WHERE ';
		$requete_order = 'ORDER BY ';
		$tab_objets = array();
		//echo '<pre>'.print_r($this->enfants, true).'</pre>';
		$tables = $this->enfants;

		// Construction des parties de la requete SQL
		$order = array();
		for ($i = 0; $i < count($tables); $i++) {
			if (is_object($tables[$i]['do'])) {
				$champs = $this->verifierObjetModele($tables[$i]['do'], $tables[$i]['dao']);
				//echo '<pre>'.print_r($champs, true).'</pre>';
				foreach ($champs as $champ => $valeur) {
					//$requete_select .= $champ.', ';
					$separateur = '=';
					//echo $valeur;
					if (preg_match('/^"(?:\s*'.
										'(?:'.
											'sql_separateur:#([^#]*)#|'.
											'sql_order:#([^#]*)#|'.
											'val:#([^#]*)#'.
										')\s*' .
									')+\s*"$/', $valeur, $match)) {
						if (isset($match[1]) && $match[1] != '') {
							$separateur = $match[1];
						}
						if (isset($match[2])) {
							if ($match[2] != 0) {
								$order[$match[2]] = $champ;
							} else {
								$order[] = $champ;
							}
						}
						if (isset($match[3]) && $match[3] != '') {
							$valeur = is_string($match[3]) ? '"'.$match[3].'"' : $match[3];
						} else {
							$valeur = '';
						}
					}
					if ($valeur != '') {
						$requete_where .= "\t".$champ.' '.$separateur.' '.$valeur."\n".' AND ';
					}
				}
				$tab_do[$tables[$i]['dao']->getClasseNom()] = $tables[$i]['dao'];
			}
			$requete_from .= $tables[$i]['dao']->getTableNom().', ';
			$requete_select .= $tables[$i]['dao']->getTableNom().'.*, ';
			
			// Gestion des relations entre tables
			if (isset($tables[$i+1]['dao']) && is_object($tables[$i+1]['dao'])) {
				$table_presente_rel = $tables[$i]['dao']->getTableRelations();
				$table_presente_nom = $tables[$i]['dao']->getTableNom();
				$table_suivante_rel = $tables[$i+1]['dao']->getTableRelations();
				$table_suivante_nom = $tables[$i+1]['dao']->getTableNom();
				//echo '<pre>'.print_r($table_presente_rel, true).'</pre>';
				//echo '<pre>'.print_r($table_suivante_rel, true).'</pre>';
				if (isset($table_suivante_rel[$table_presente_nom]) && isset($table_presente_rel[$table_suivante_nom])) {
					if (count($table_suivante_rel[$table_presente_nom]) == count($table_presente_rel[$table_suivante_nom])) {
						for ($j = 0; $j < count($table_presente_rel[$table_suivante_nom]); $j++) {
							$requete_where .= "\t".$table_presente_rel[$table_suivante_nom][$j].' = '.$table_suivante_rel[$table_presente_nom][$j]."\n".' AND ';
						}
					}
				}
			}
		}
		// Concaténation de la requete SQL
		$this->setRequete(trim($requete_select, ', ')." \n".trim($requete_from, ', ')." \n".trim($requete_where, "\n".' AND '))." \n";

		// Concaténation des champs de trie
		if (count($order) > 0) {
			foreach ($order as $champ) {
				$requete_order .= $champ.', ';
			}
			$this->setRequete($this->getRequete()."\n".trim($requete_order, ', '));
		}
		
		// Gestion des limites de résultat de la requete SQL
		if ($this->getLimitBool()) {
			$this->setRequete($this->getRequete()."\n".'LIMIT '.$this->getLimitDebut().', '.$this->getLimitNbre());
		}
		//echo '<pre>'.print_r($this->getRequete(), true).'</pre>';
		
		// Débogage
		if ($this->getDebogage() == EF_DEBOG_SQL) {
			echo print_r($this->getRequete(), true)."\n";
		}
		
		// Execution de la requete SQL
		$donnees = $this->getConnexion()->query($this->getRequete());

		// Gestion des erreurs
		if (PEAR::isError($donnees)) {
    		$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $donnees->getMessage(), $this->getRequete());
    		trigger_error($e, E_USER_ERROR);
    		return null;
		}

		// Récupération des résultats
		while ($aso_donnees =& $donnees->fetchRow(DB_FETCHMODE_ASSOC)) {
			// Gestion de l'encodage
			$this->decoderUtf8($aso_donnees);
			$tab_objets = array();
			foreach ($tab_do as $nom_objet => $dao) {
				$tab_objets[$nom_objet] = $this->instancierObjetModele($aso_donnees, $nom_objet, $dao);
				//echo('<pre>'.$nom_objet.print_r($aso_donnees, true).'</pre>');
			}
			$tab_donnees[] = $tab_objets;
			//die('<pre>'.print_r($tab_donnees, true).'</pre>'); 
		}
		
		return $tab_donnees;
	}
	
	/**
	 * Permet de consulter un type de données.
	 *
	 * @param array tableau de paramêtres à passer à la requête.
	 * @param string nom de l'objet à instancier.
	 * @return array
	 * @access public
	 */
	public function consulter( $parametres, $nom_objet )
	{
		$tab_objets = array();
  		$fichier = get_class($this);
		$methode = 'consulter()';
		
		// Gestion des limites de résultat
		if ($this->getLimitBool()) {
			$this->setRequete($this->getRequete().' LIMIT '.$this->getLimitDebut().', '.$this->getLimitNbre());
		}
		
		if ($this->getResultatType() == aDaoSql::RESULTAT_UNIQUE) {
			$resultat = $this->getConnexion()->getOne($this->getRequete(), $parametres);

			// Débogage
			if ($this->getDebogage() == EF_DEBOG_SQL && is_object($resultat)) {
				echo $resultat->query."\n";
			} else if ($resultat == null) {
				$e = 'Aucun résultat en mode RESULTAT_UNIQUE pour la requete : '."\n".$this->getRequete();
	    		trigger_error($e, E_USER_WARNING);
			}
			
			if (PEAR::isError($resultat)) {
	    		$e = GestionnaireErreur::retournerErreurSql($fichier, $methode, $resultat->getMessage(), $this->getRequete());
	    		trigger_error($e, E_USER_ERROR);
	    		return null;
			} else {
				// Gestion de l'encodage
				$this->decoderUtf8($resultat);
				return $resultat;
			}
		} else if ($this->getResultatType() == aDaoSql::RESULTAT_OBJET_UNIQUE) {
			$aso_donnees = $this->getConnexion()->getRow($this->getRequete(), $parametres, DB_FETCHMODE_ASSOC);

			// Débogage
			if ($this->getDebogage() == EF_DEBOG_SQL) {
				echo $aso_donnees->query."\n";
			}

			if (PEAR::isError($aso_donnees)) {
	    		$e = GestionnaireErreur::retournerErreurSql($fichier, $methode, $aso_donnees->getMessage(), $this->getRequete());
	    		trigger_error($e, E_USER_ERROR);
	    		return null;
			} else if (is_null($aso_donnees)) {
	    		return null;
			} else {
				// Gestion de l'encodage
				$this->decoderUtf8($aso_donnees);
				return $this->instancierObjetModele($aso_donnees, $nom_objet);
			}
		} else if ($this->getResultatType() == aDaoSql::RESULTAT_OBJET_MULTIPLE) {
			$etat = $this->getConnexion()->prepare($this->getRequete());
			if (PEAR::isError($etat)) {
	    		$e = GestionnaireErreur::retournerErreurSql($fichier, $methode, $etat->getMessage(), $this->getRequete());
	    		trigger_error($e, E_USER_ERROR);
	    		return null;
			}
			$donnees = $this->getConnexion()->execute($etat, $parametres);
			if (PEAR::isError($donnees)) {
	    		$e = GestionnaireErreur::retournerErreurSql($fichier, $methode, $donnees->getMessage(), $this->getRequete());
	    		trigger_error($e, E_USER_ERROR);    		
	    		return null;
			}
			
			// Débogage
			if ($this->getDebogage() == EF_DEBOG_SQL) {
				echo $donnees->query."\n";
			}
			
			while ($aso_donnees =& $donnees->fetchRow(DB_FETCHMODE_ASSOC)) {
				// Gestion de l'encodage
				$this->decoderUtf8($aso_donnees);
				$tab_objets[] = $this->instancierObjetModele($aso_donnees, $nom_objet);	 
			}
			$this->getConnexion()->freePrepared($etat);
			return $tab_objets;
		} else {
			$message = "La classe ".get_class($this)." n'indique pas le type de résultat pour la requête.";
			trigger_error($message, E_USER_WARNING);
		}
	}

	/**
	 * Méthode permettant de détcoder de l'utf8 vers l'iso-8859-15 un tableau de variables.
	 *
	 * @param mixed la chaine ou le tableau à décoder de l'utf8 vers l'iso-8859-15.
	 * @return mixed la chaine ou le tableau décodé en iso-8859-15.
	 * @access public
	 */
	private function decoderUtf8( &$val )
	{
		//echo '<pre>'.print_r($val, true).'</pre>';
		if (is_array($val)) {
			foreach ($val as $c => $v) {
				$val[$c] = $this->decoderUtf8($v);
			}
		} else {
			// Nous vérifions si nous avons un bon encodage utf8
			if (is_numeric($val) || empty($val) || preg_match('/<\?xml version="1.0" encoding="UTF-8" \?>/', $val)) { 
				// Les nombres, les valeurs vides et le xml en utf8 ne sont pas décodés.
				return $val;
			} else if ($this->detecterUtf8($val)) { 
				//$val = mb_convert_encoding($val, 'HTML-ENTITIES', 'UTF-8');
				$val = mb_convert_encoding($val, $GLOBALS['_EFLORE_']['encodage'], 'UTF-8');
				return $val;
			} else {
				return $val;
			}
		}
	}
	
	/**
	 * Méthode permettant de détecter réellement l'encodage utf8.
	 * mb_detect_encoding plante si la chaine de caractère se termine par un caractère accentué.
	 * Provient de  PHPDIG.
	 * 
	 * @param string la chaine à vérifier.
	 * @return bool true si c'est de l'utf8, sinon false.
	 * @access public
	 */
	private function detecterUtf8($str) {
		if ($str === mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32')) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Permet d'ajouter un type de données.
	 *
	 * @return mixed l'identifiant si les infos sont bien ajoutées, sinon false.
	 * @access public
	 */
	public function ajouter( $obj, $bdd = null, $cmd_max = null)
	{
  		if (is_null($bdd)) {
			$bdd = $this->getBddPrincipale();
		}
		
		if ($obj->getId($this->getClesPrimaires(1)) == null) {
			switch($this->getClesPrimairesNbre()) {
				case 4 :
					$id_max = $this->consulter($cmd_max, array($obj->getId($this->getClesPrimaires(1))));
					$obj->setId(($id_max + 1), $this->getClesPrimaires(1));
					$id_max = $this->consulter($cmd_max, array($obj->getId($this->getClesPrimaires(3))));
					$obj->setId(($id_max + 1), $this->getClesPrimaires(3));
					break;
				case 2 :
					$id_max = $this->consulter($cmd_max, array($obj->getId($this->getClesPrimaires(2))));
					$obj->setId(($id_max + 1), $this->getClesPrimaires(1));
					break;
				case 1 :
					$id_max = $this->consulter($cmd_max);
					$obj->setId(($id_max + 1), $this->getClesPrimaires(1));
					break;
			}
		}
		
		foreach ($this->verifierObjetModele($obj) as $champs => $valeur) {
				$sql_attributs .= $champs.', ';
				$sql_valeurs .= $valeur.', ';
		}
		$sql_attributs = trim($sql_attributs, ', ');
		$sql_valeurs = trim($sql_valeurs, ', ');
		$sql = 	'INSERT INTO '.$bdd.'.'.$this->getTableNom().' '.
					'( '.$sql_attributs.' ) '.
				'VALUES '.
					'( '.$sql_valeurs.' )';
		$this->setRequete($sql);
  		$fichier = get_class($this);
		$methode = 'ajouter()';
		
		if ($this->getDebogage() == EF_DEBOG_SQL) {
			echo $this->getRequete()."\n";
		}
		
		$Resultat = $this->getConnexion()->query($this->getRequete());
		if (PEAR::isError($Resultat)) {
    		$message = $Resultat->getMessage()."\n".$Resultat->getUserInfo();
    		$e = GestionnaireErreur::retournerErreurSql($fichier, $methode, $message, $this->getRequete());
    		trigger_error($e, E_USER_ERROR);
    		return false;
		}
		return $obj->getId($this->getClesPrimaires(1));
	}

	/**
	 * Permet de supprimer un type de données.
	 * 
	 * @param mixed identifiant du type de données à détruire.
	 * @return boolean true si les infos sont bien supprimées, sinon false.
	 * @access public
	 */
	public function supprimer($obj, $cmd_id)
	{
		// Gestion de l'historique
		if ($this->getHistorisation()) {
			if ($this->getClesPrimairesNbre() == 2) {
				$obj_a_historiser = $this->consulter($cmd_id, array($obj->getId($this->getClesPrimaires(2)), $obj->getId($this->getClesPrimaires(1))));
			} else if ($this->getClesPrimairesNbre() == 1) {
				$obj_a_historiser = $this->consulter($cmd_id, array($obj->getId($this->getClesPrimaires(1))));
			}
			$obj_suprimer_a_historiser = clone $obj_a_historiser;
			$obj_suprimer_a_historiser->setCe(5, 'etat');// Indication de l'état supprimé
			$obj_suprimer_a_historiser->setDateDerniereModif(date('Y-m-j H:i:s', time()));// Date et heure de la suppression
			if (!$this->ajouter($obj_a_historiser, $this->getBddHistorique()) && !$this->ajouter($obj_suprimer_a_historiser, $this->getBddHistorique())) {
				$message = 'Ajout de la ligne supprimée dans la base d\'historique impossible!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
		    	trigger_error($e, E_USER_ERROR);
			}
		}
		// Gestion de la suppression dans la base principale
		foreach ($this->verifierObjetModele($obj) as $champs => $valeur) {
			if ($this->table_champs[$champs]['type'] == 'id') {
				$sql_where .= $champs.' = '.$valeur.' AND ';
			}
		}
		$sql_where = trim($sql_where, ' AND ').' ';
		$sql = 'DELETE FROM '.$this->getBddPrincipale().'.'.$this->getTableNom().' WHERE '.$sql_where ;
		$this->setRequete($sql);
		
		$methode = 'supprimer()';
		
		if ($this->getDebogage() == EF_DEBOG_SQL) {
			echo $this->getRequete()."\n";
		}
		
		$Resultat = $this->getConnexion()->query($this->getRequete());
		if (PEAR::isError($Resultat)) {
    		$message = $Resultat->getMessage()."\n".$Resultat->getUserInfo();
    		$e = GestionnaireErreur::retournerErreurSql(get_class($this), $methode, $message, $this->getRequete());
    		trigger_error($e, E_USER_ERROR);
    		return false;
		} else {
			return true;
		}
	}

	/**
	 * Permet de modifier un type de données.
	 *
	 * @return boolean true si les infos sont bien modifiées, sinon false.
	 * @access public
	 */
	public function modifier($obj, $cmd_id)
	{
		// Gestion de l'historique
		if ($this->getHistorisation()) {
			if ($this->getClesPrimairesNbre() == 2) {
				$obj_a_historiser = $this->consulter($cmd_id, array($obj->getId($this->getClesPrimaires(2)), $obj->getId($this->getClesPrimaires(1))));
			} else if ($this->getClesPrimairesNbre() == 1) {
				$obj_a_historiser = $this->consulter($cmd_id, array($obj->getId($this->getClesPrimaires(1))));
			}
			
			if (!$this->ajouter($obj_a_historiser, $this->getBddHistorique())) {
				$message = 'Ajout de la ligne modifiée dans la base d\'historique impossible!';
				$e = GestionnaireErreur::formaterMessageErreur(__FILE__, __LINE__, $message);
    			trigger_error($e, E_USER_ERROR);
			}
		}
		// Gestion de la mise à jour dans la base principale
		foreach ($this->verifierObjetModele($obj) as $champs => $valeur) {
			if ($this->table_champs[$champs]['type'] == 'id') {
				$sql_where .= $champs.' = '.$valeur.' AND ';
			} else {
				$sql_set .= $champs.' = '.$valeur.', ';
			}
		}
		$sql_set = trim($sql_set, ', ').' ';
		$sql_where = trim($sql_where, ' AND ').' ';
		$sql = 	'UPDATE '.$this->getBddPrincipale().'.'.$this->getTableNom().' SET '.$sql_set.'WHERE '.$sql_where;
		$this->setRequete($sql);
		
		$methode = 'modifier()';
		
		if ($this->getDebogage() == EF_DEBOG_SQL) {
			echo $this->getRequete()."\n";
		}
		
		$Resultat = $this->getConnexion()->query($this->getRequete());
		if (PEAR::isError($Resultat)) {
	    	$message = $Resultat->getMessage()."\n".$Resultat->getUserInfo();
    		$e = GestionnaireErreur::retournerErreurSql(get_class($this), $methode, $message, $this->getRequete());
	    	trigger_error($e, E_USER_ERROR);
	    	return false;
		} else {
			return true;
		}	
	}

		/**
	* Ajoute les valeurs des champs aux bons attributs.
	* 
	* @return NaturalisteIntituleAbreviation un objet de type NaturalisteIntituleAbreviation instancié avec les valeurs d'une requete.
	* @access public
	*/
	public function instancierObjetModele( &$donnees, $nom_objet, $dao = '')
	{
		if ($dao == '') {
			$dao = $this;
		}
		$un_objet = new $nom_objet();
		foreach ($donnees as $cle => $val) {
			$supprimer = true;
			if (array_key_exists($cle, $dao->getTableChamps())) {
				$type = $dao->getTableChamps($cle);
				$type = $type['type'];
				if ($type == 'id') {
					$un_objet->setId($val, substr_replace(substr_replace($cle, '', 0, strlen($dao->getTablePrefixe())), '', 0, 3));
				} else if ($type == 'ce') {
					$un_objet->setCe($val, substr_replace(substr_replace($cle, '', 0, strlen($dao->getTablePrefixe())), '', 0, 3));
				} else if ($type == 'no') {
					$methode = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', substr_replace($cle, '', 0, strlen($dao->getTablePrefixe())))));
					call_user_func(array($un_objet, $methode), $val);
				} else if ($type == 'sp') {
					// Les champs ajoutés par les requetes sql.
					$un_objet->$cle = $val;
					$un_objet->setMetaAttributsUtilises($cle);
				}
			} else {
				$supprimer = false;
			}
			if ($supprimer === true) {
				unset($donnees[$cle]);
			}
		}
		
		return $un_objet;
	}
	
	/**
	* Vérifie les valeurs présentes dans l'objet et permet de construire une requête.
	* 
	* @param Nom un objet de type nom instancié avec les valeurs d'une requete.
	* @access public
	*/
	public function verifierObjetModele( $un_objet, $dao = '' )
	{
		if ($dao == '') {
			$dao = $this;
		}
		$aso_champs = array();
		foreach($un_objet->getMetaAttributsUtilises() as $attribut => $nbre_utilisation) {
			foreach($dao->getTableChamps() as $champ => $val) {
				$champ_cmp = substr_replace($champ, '', 0, strlen($dao->getTablePrefixe()));
				$type = null;
				if ($val['type'] == 'id') {
					$champ_cmp = substr_replace($champ_cmp, '', 0, 3);
					$type = 'Id';
				} else if ($val['type'] == 'ce') {
					$champ_cmp = substr_replace($champ_cmp, '', 0, 3);
					$type = 'Ce';
				}
				if ($champ_cmp == $attribut) {
					$methode = str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));
					if (!is_null($type)) {
						$methode = 'get'.$type;
						//$valeur = call_user_method($methode, $un_objet, $attribut);
						$valeur = call_user_func(array($un_objet, $methode), $attribut);
					} else {
						$methode = 'get'.$methode;
						//$valeur = call_user_method($methode, $un_objet);
						$valeur = call_user_func(array($un_objet, $methode));
					}
					if ($val['format'] == 'str') {
						$aso_champs[$champ] = '"'.$dao->getConnexion()->escapeSimple($valeur).'"';
					} else if ($val['format'] == 'int') {
						$aso_champs[$champ] = $valeur;
					}
					break;
				}
			}
		}
		return $aso_champs;
	}
	
	/**
	* Ajoute un enfant au composant.
	* 
	* @access public
	* @return string
	*/
	public function ajouterEnfant($dao, $do)
	{
		$this->enfants[] = array('dao' => $dao, 'do' => $do);
	}
	/**
	* Supprime un enfant du composant.
	*
	* @param string Définit le nom de l'objet enfant.
	* @return void
	* @access public
	*/
	public function supprimerEnfant()
	{
		unset($this->enfants);
	}

	// Fichier SQL Resource
	/**
	* Lit la valeur de l'attribut Fichier SQL Resource.
	* Utilise le motif de conception (= design pattern) Singleton.
	* 
	* @access public
	* @param string le préfixe du nom de fichier à créer.
	* @return string retourne la Resource du fichier SQL.
	*/
	public static function getFichierSqlRessource($fermer = false)
	{
		if (!isset(self::$fichier_sql_resource) && !self::$fichier_sql_fermer) {
			if (file_exists(self::getFichierSql()) && !self::$fichier_sql_ecraser) {
				self::$fichier_sql_resource = fopen(self::getFichierSql(), 'a');
			} else {
				self::$fichier_sql_resource = fopen(self::getFichierSql(), 'w');
			}
		}

		if ($fermer) {
			if (self::$fichier_sql_fermer) {
				self::$fichier_sql_fermer = fclose(self::$fichier_sql_resource);
				self::$fichier_sql_resource = null;
			}
			return self::$fichier_sql_fermer;
		}

		return self::$fichier_sql_resource;
	}

	// Fichier Sql
	/**
	* Lit la valeur de l'attribut fichier_sql.
	* Utilise le motif de conception (= design pattern) Singleton.
	* 
	* @access public
	* @param string le préfixe du nom de fichier à créer.
	* @return string retourne la Resource du fichier SQL.
	*/
	public static function getFichierSql($fichier = null)
	{
		if (!isset(self::$fichier_sql)) {
			if (!self::$fichier_sql_ecraser) {
				$fichier .= '_'.date('Y-m-j_H:i:s', time());
			}
			$fichier .= '.sql';
			self::$fichier_sql = $fichier;
		}
		return self::$fichier_sql;
	}
}
?>