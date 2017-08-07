<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
// |                                                                                                      |
// | eflore_bp is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_bp is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: EfloreAdaptateurSql.class.php,v 1.5 2007-08-23 07:59:38 jp_milcent Exp $
/**
* eflore_bp - EfloreAdaptateurSql.php
*
* Description : cette classe annalyse les requ�tes SQL avant de les executer. Dans le cas des requetes DELETE et UPDATE
* un ajout de l'ancienne donn�e est fait dans la base d'historique, si l'hitorisation des donn�es est activ�e.
* Cette classe �vite l'utilisation d'une API DAO-DO.
* Elle fournit en sortie un tableau de r�sultat sous la forme :
* $mes_resultats['abreviation_table']['nom_champ']
* "nom_champ" ne comporte plus l'abreviation de la table ni la mention "ce" ou "id".
* Nous trouverons aussi les cl�s �trang�res "ce" et "id" dans des sous-tableaux de la forme:
* $mes_resultats['abreviation_table']['ce'] et $mes_resultats['abreviation_table']['id']
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.5 $ $Date: 2007-08-23 07:59:38 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreAdaptateurSql {
	
	/*** Constantes : ***/
	
	const RESULTAT_DEFAUT = 0;
	const RESULTAT_UNIQUE = 1;
	const RESULTAT_TABLEAU_UNIQUE = 2;
	const RESULTAT_TABLEAU_MULTIPLE = 3;
	const RESULTAT_OBJET_UNIQUE = 4;
	const RESULTAT_OBJET_MULTIPLE = 5;
		
	/*** Attributs: ***/
	
	// Gestion de la bdd
	private $connexion;
	private $stockage_principal = '';
	private $stockage_historique = '';
	private $historisation = true;
	
	// Gestion du d�bogage
	private $debogage = '';
	
	// Gestion des fichiers de log sql
	private static $fichier_sql;
	private static $fichier_sql_resource;
	private $fichier_sql_mark = false;
	private $fichier_sql_prefixe = '';
	private $fichier_sql_chemin = '';
	private static $fichier_sql_ecraser = true;
	private static $fichier_sql_fermer = false;
	
	// Gestion des r�sultats
	private $limit_bool = false;
	private $limit_nbre = 10;
	private $limit_debut = 1;
	private $mode;
	
	/*** Accesseurs : ***/
	
	/**
	* Lit la valeur de l'attribut connexion.
	* 
	* @access public
	* @return PEAR.DB connexion � la base de donn�es.
	*/
	public function getConnexion( )
	{
		return $this->connexion;
	}
	/**
	* D�finit la valeur de l'attribut connexion.
	*
	* @param PEAR.DB connexion � la base de donn�es.
	* @return
	* @access public
	*/
	public function setConnexion( $connexion )
	{
		$this->connexion = $connexion;
	}
	
	// eFlore : stokage donn�es Principale
	public function getStockagePrincipal()
	{
		return $this->stockage_principal;
	}
	public function setStockagePrincipal($stock)
	{
		$this->stockage_principal = $stock;
	}

	// eFlore : stokage donn�es Historique
	public function getStockageHistorique()
	{
		return $this->stockage_historique;
	}
	public function setStockageHistorique($stock)
	{
		$this->stockage_historique = $stock;
	}
	
	// Historisation
	/**
	* Lit la valeur de l'attribut historisation.
	* 
	* @access public
	* @return bool true si l'archivage est activ�.
	*/
	public function getHistorisation( )
	{
		return $this->historisation;
	}
	/**
	* D�finit la valeur de l'attribut historisation.
	*
	* @param bool true si on veut activer l'archivage.
	* @return
	* @access public
	*/
	public function setHistorisation( $h )
	{
		$this->historisation = $h;
	}
	
	// D�bogage
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
	 * D�finit la valeur de l'attribut debogage.
	 *
	 * @param bool D�finit le type de d�bogage.
	 * @return void
	 * @access public
	 */
	public function setDebogage($d)
	{
		$this->debogage = $d;
	}

	// Mode de r�cup�ration des r�sultats
	/**
	 * Lit la valeur de l'attribut mode.
	 * 
	 * @access public
	 * @return bool
	 */
	public function getMode()
	{
		return $this->mode;
	}
	/**
	 * D�finit la valeur de l'attribut mode.
	 *
	 * @param integer une valeur d�finit par les constantes de la classe.
	 * @return void
	 * @access public
	 */
	public function setMode($m = self::RESULTAT_DEFAUT)
	{
		$this->mode = $m;
	}

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
	* D�finit la valeur de l'attribut requete.
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
					echo 'Erreur �criture dans le fichier SQL.'."\n";
				}
			}
		}
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
	 * D�finit la valeur de l'attribut fichier_sql_mark.
	 *
	 * @param bool D�finit si oui ou non on cr�� un fichier SQL.
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
	 * D�finit la valeur de l'attribut fichier_sql_chemin.
	 *
	 * @param string D�finit le chemin du fichier SQL.
	 * @return void
	 * @access public
	 */
	public function setFichierSqlChemin( $fsc )
	{
		$this->fichier_sql_chemin = $fsc;
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
	 * D�finit la valeur de l'attribut fichier_sql_prefixe.
	 *
	 * @param string D�finit le pr�fixe du nom du fichier SQL.
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
	 * D�finit la valeur de l'attribut limit_bool.
	 *
	 * @param int le nombre de lignes � renvoyer.
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
	 * D�finit la valeur de l'attribut limit_nbre.
	 *
	 * @param int le nombre de lignes � renvoyer.
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
	 * D�finit la valeur de l'attribut limit_debut.
	 *
	 * @param int la ligne de d�but.
	 * @return void
	 * @access public
	 */
	public function setLimitDebut( $ld )
	{
		$this->limit_debut = $ld;
	}
	
	/*** Constructeurs : ***/
	 
	/**
	* Constructeur du type de donn�es issu de la base de donn�es.
	*
	* @access public
	*/
	public function __construct($dsn)
	{
		// Connexion � la base de donn�es
		$options = array(
		    'debug'       => 2
		);
		$this->setConnexion(DB::connect((string)$dsn, $options));
		if (PEAR::isError($this->getConnexion())) {
			$message = $this->connexion->getMessage()."\n".$this->connexion->getDebugInfo();
			$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message);
			trigger_error($e, E_USER_ERROR);
		}

		// D�claration du type de d�bogage par d�faut : aucun.
		$this->setDebogage(false);
		
		// D�claration du type de rendu de r�sultat
		$this->setMode(self::RESULTAT_DEFAUT);
		
		// Gestion du fichier stockant le sql
		if ($this->getFichierSqlMark()) {
			$this->setFichierSqlPrefixe('api_eflore_v1.1.1');
			$this->setFichierSqlChemin('/tmp/');
			self::getFichierSql($this->getFichierSqlChemin().$this->getFichierSqlPrefixe());
			self::getFichierSqlRessource();
			self::$fichier_sql_ecraser = true; 
		}

		// Gestion de l'encodage
		if (EF_LANGUE_UTF8) {
			// R�cup�ration des infos au format UTF-8
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
	* Destructeur du type de donn�es issu de la base de donn�es.
	* 
	* Le destructeur r�tabli l'encodage par d�faut qui est latin 1 dans Papyrus.
	*
	* @access public
	*/
	public function __destruct()
	{
		if ($this->getFichierSqlMark()) {
			self::getFichierSqlRessource(true);
		}
		if (EF_LANGUE_UTF8) {
			// R�tablissement de l'encodage par d�faut pour la connection avec la base de donn�es
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

	/*** M�thodes : ***/	
	
	/**
	 * M�thode analysant le sql et renvoyant le tableau de r�sultats.
	 *
	 * @param string la requ�te sql.
	 * @access public
	 */
	public function executer($sql)
	{
		// Nous ajoutons la requ�te � l'objet
		$this->setRequete($sql);

		// Gestion du d�coupage de la requ�te
		$info = $this->retournerInfoRequete();
		
		// Gestion des limites de r�sultat
		if ($this->getLimitBool()) {
			$this->setRequete($this->getRequete().' LIMIT '.$this->getLimitDebut().', '.$this->getLimitNbre());
		}
		
		// Gestion du d�bogage.
		if ($this->getDebogage()) {
	    	$this->formaterRequete();
	    	trigger_error($this->getRequete(), E_USER_NOTICE);
		}
		
		// Aiguillage vers la m�thode sp�cialis�e
		switch ($info['type']) {
			case 'select':
				return $this->consulter();
				break;
			case 'insert':
				return $this->ajouter();
				break;
			case 'update':
				return $this->modifier();
				break;
			case 'delete':
				return $this->supprimer();
				break;
			default:
				trigger_error('Le type de la requ�te est introuvable : '.$this->getRequete(), E_USER_WARNING);
				return false;
		}
		
	}

	/**Fonction formaterRequete() - Ajout des sauts de ligne et des tabulations pour faciliter la lecture d'une requ�te.
	*
	* Cette fonction formate la requ�te pour un meilleur affichage.
	*
	* @author Jean-Pascal MILCENT <jpm@tela-botanica.org>
	* @return null
	*/
	private function formaterRequete()
	{
		$sql = $this->getRequete();
		$this->setRequete(preg_replace('/(FROM|WHERE|AND|OR|GROUP BY|ORDER BY|LIMIT) /i', "\n$1 ",$sql));
	}
	
	/**Fonction retournerInfoRequete() - Retourne le type de requ�te sql et le nom de la table touch�e.
	*
	* Cette fonction retourne un tableau associatif contenant en cl� 'table_nom' le nom de la table touch�e
	* et en cl� 'type' le type de requ�te (create, alter, insert, update...).
	* Licence : la m�me que celle figurant dans l'ent�te de ce fichier
	* Auteurs : Jean-Pascal MILCENT
	*
	* @author Jean-Pascal MILCENT <jpm@tela-botanica.org>
	* @return string l'url courante.
	*/
	private function retournerInfoRequete()
	{
		$requete = array('type' => '', 'table_nom' => '');
		$resultat = '';
		if (preg_match('/^SELECT/i', $this->getRequete(), $resultat)) {
			$requete['type'] = 'select';
		} else if (preg_match('/^INSERT INTO/i', $this->getRequete(), $resultat)) {
			$requete['type'] = 'insert';
		} else if (preg_match('/^UPDATE/i', $this->getRequete(), $resultat)) {
			$requete['type'] = 'update';
		} else if (preg_match('/^DELETE/i', $this->getRequete(), $resultat)) {
			$requete['type'] = 'delete';
		} else if (preg_match('/^ALTER TABLE/i', $this->getRequete(), $resultat)) {
			$requete['type'] = 'alter';
		} else if (preg_match('/^CREATE TABLE/i', $this->getRequete(), $resultat)) {
			$requete['type'] = 'create';
		} 
		return $requete;
	}
	
	
	/**
	 * Permet de consulter un type de donn�es.
	 *
	 * @param array tableau de param�tres � passer � la requ�te.
	 * @param string nom de l'objet � instancier.
	 * @return array
	 * @access public
	 */
	public function consulter()
	{
		$this->getConnexion()->setFetchMode(DB_FETCHMODE_ASSOC);
		$resultats = $this->getConnexion()->getAll($this->getRequete());
		if (PEAR::isError($resultats)) {
    		$message = $resultats->getMessage()."\n".$resultats->getUserInfo();
    		$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message, $this->getRequete());
    		trigger_error($e, E_USER_ERROR);
		}
		
		
		$nbre_lignes = count($resultats);
		
		// Nous n'avons pas de r�sultat nous renvoyons false
		if ($nbre_lignes == 0) {
			return false;
		}
		
		// Nous avons au moins une ligne de r�sultat
		$donnee_unique = null;
		$tab_donnee_unique = array();
		$tab_donnee_multiple = array();
		$aso_cle_champ = null;
		foreach ($resultats as $ligne) {
			$nbre_champs = count($ligne);
			$donnee = array();
			foreach ($ligne as $champ => $valeur) {
				// Gestion de l'encodage de sortie
				if (EF_LANGUE_UTF8 && $GLOBALS['_EFLORE_']['encodage'] != 'UTF-8') {
					$valeur = $this->decoderUtf8($valeur);
				}
				// Gestion du formatage des r�sultats
				if ($nbre_lignes == 1 && $nbre_champs == 0) {
					// 1 ligne mais pas champs : bizare ?
					return false;
				} else {
					// Au moins 1 ligne et au moins 1 champ
					$tab_decompo_champ = explode('_', $champ);
					$table_abreviation = $tab_decompo_champ[0];
					unset($tab_decompo_champ[0]);
					if (isset($tab_decompo_champ[1]) && preg_match('/^(?:ce|id)$/', $tab_decompo_champ[1])) {
						$table_cle_type = $tab_decompo_champ[1];						
						unset($tab_decompo_champ[1]);
						$donnee[$table_abreviation][$table_cle_type][implode('_', $tab_decompo_champ)] = $valeur;
					} else {
						$donnee[$table_abreviation][implode('_', $tab_decompo_champ)] = $valeur;
					}
				}
			}
			if ($nbre_champs == 1 && $nbre_lignes == 1) {
				// 1 ligne et 1 champ : r�sultat unique !
				$donnee_unique = array('valeur' => $valeur, 'tableau' => $donnee);
			} else if ($nbre_champs >= 1) {
				if ($nbre_lignes == 1) {
					$tab_donnee_unique =  $donnee;
				} else if ($nbre_lignes > 1) {
					$tab_donnee_multiple[] = $donnee;
				}
			}
		}
		
		// Retour de r�sultats en fonction du mode de r�cup�ration demand� par l'utilisateur
		switch($this->getMode()) {
			case self::RESULTAT_DEFAUT :
				if (!is_null($donnee_unique)) {
					return $donnee_unique['valeur'];
				} else if (count($tab_donnee_unique) > 0) {
					return $tab_donnee_unique;
				} else if (count($tab_donnee_multiple) > 0) {
					return $tab_donnee_multiple;
				}
				break;
			case self::RESULTAT_TABLEAU_MULTIPLE :
				if (!is_null($donnee_unique)) {
					return array(0 => $donnee_unique['tableau']);
				} else if (count($tab_donnee_unique) > 0) {
					return array(0 => $tab_donnee_unique);
				} else if (count($tab_donnee_multiple) > 0) {
					return $tab_donnee_multiple;
				}
				break;
			default:
				trigger_error('Ce mode de r�cup�ration de r�sultat n\'a pas �t� impl�ment� !', E_USER_ERROR);
		}
	}
	
	/**
	 * Permet d'ajouter un type de donn�es.
	 *
	 * @return mixed l'identifiant si les infos sont bien ajout�es, sinon false.
	 * @access public
	 */
	public function ajouter( $sql, $bdd = null)
	{

	}

	/**
	 * Permet de supprimer un type de donn�es.
	 * 
	 * @param mixed identifiant du type de donn�es � d�truire.
	 * @return boolean true si les infos sont bien supprim�es, sinon false.
	 * @access public
	 */
	public function supprimer($obj, $cmd_id)
	{

	}

	/**
	 * Permet de modifier un type de donn�es.
	 *
	 * @return boolean true si les infos sont bien modifi�es, sinon false.
	 * @access public
	 */
	public function modifier($obj, $cmd_id)
	{
		
	}
	
	/**
	 * M�thode permettant de d�tcoder de l'utf8 vers l'iso-8859-15 un tableau de variables.
	 *
	 * @param mixed la chaine ou le tableau � d�coder de l'utf8 vers l'iso-8859-15.
	 * @return mixed la chaine ou le tableau d�cod� en iso-8859-15.
	 * @access private
	 */
	private function decoderUtf8( &$val )
	{
		//echo '<pre>'.print_r($val, true).'</pre>';
		if (is_array($val)) {
			foreach ($val as $c => $v) {
				$val[$c] = $this->decoderUtf8($v);
			}
		} else {
			// Nous v�rifions si nous avons un bon encodage utf8
			if (is_numeric($val) || empty($val) || preg_match('/<\?xml version="1.0" encoding="UTF-8" \?>/', $val)) { 
				// Les nombres, les valeurs vides et le xml en utf8 ne sont pas d�cod�s.
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
	 * M�thode permettant de d�tecter r�ellement l'encodage utf8.
	 * mb_detect_encoding plante si la chaine de caract�re se termine par un caract�re accentu�.
	 * Provient de  PHPDIG.
	 * 
	 * @param string la chaine � v�rifier.
	 * @return bool true si c'est de l'utf8, sinon false.
	 * @access private
	 */
	private function detecterUtf8($str) {
		if ($str === mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32')) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	* Lit la valeur de l'attribut Fichier SQL Resource.
	* Utilise le motif de conception (= design pattern) Singleton.
	* 
	* @param string le pr�fixe du nom de fichier � cr�er.
	* @return string retourne la Resource du fichier SQL.
	* @access public
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

	/**
	* Lit la valeur de l'attribut fichier_sql.
	* Utilise le motif de conception (= design pattern) Singleton.
	* 
	* @param string le pr�fixe du nom de fichier � cr�er.
	* @return string retourne la Resource du fichier SQL.
	* @access public
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

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreAdaptateurSql.class.php,v $
* Revision 1.5  2007-08-23 07:59:38  jp_milcent
* Ajout d'une tab devant OR pour le formatage des requetes.
*
* Revision 1.4  2007-07-05 19:08:17  jp_milcent
* Am�lioration de la gestion du mode de r�cup�ration des r�sultats.
*
* Revision 1.3  2007-07-02 15:34:48  jp_milcent
* Ajout du mode de r�cup�ration des donn�es.
* Ajout du formatage des requ�tes pour l'affichage lors du d�bogage.
*
* Revision 1.2  2007-06-29 16:58:42  jp_milcent
* Test du d�bogage.
*
* Revision 1.1  2007-06-29 15:20:03  jp_milcent
* Ajout d'un adaptateur en remplacement de l'API.
* On va gagner du temps ! Merci David ;)
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
