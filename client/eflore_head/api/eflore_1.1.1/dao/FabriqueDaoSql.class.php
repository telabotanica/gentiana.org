<?php

class FabriqueDaoSql extends aFabriqueDao {
	
	/*** Attributs: ***/
	
	private $connexion;
	private $stockage_principal = '';
	private $stockage_historique = '';
	private $historisation = true;
	private $debogage = EF_DEBOG_AUCUN;
	private $fichier_sql_mark = true;
	private $fichier_sql_prefixe = null;
	private $fichier_sql_chemin = null;
	// Gestion d'un pager
	private $limit_bool = false;
	private $limit_nbre = 10;
	private $limit_debut = 1;
		
	/*** Accesseurs : ***/
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
	* @param string le DSN d'acc�s � la base de donn�es.
	* @return object
	* @access public
	*/
	public function __construct($dsn)
	{
		// Connexion � la base de donn�es
		$options = array(
		    'debug'       => 2
		);
		$this->connexion =& DB::connect((string)$dsn, $options);
		if (PEAR::isError($this->connexion)) {
			$message = $this->connexion->getMessage()."\n".$this->connexion->getDebugInfo();
			$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $message);
			trigger_error($e, E_USER_ERROR);
		}
		// R�cup�ration des infos au format UTF-8
//		$requete = 	'SET NAMES "utf8"';
//		$info = $this->connexion->query($requete);
//		if (PEAR::isError($info)) {
//			$e = $info->getMessage();
//			die('<pre>'.print_r($e, true).'</pre>');
//			// A FAIRE : r�parer le trigger_error qui ne semble pas marcher ...
//    		//trigger_error($e, E_USER_ERROR);
//		}
	}
	
	/*** M�thodes : ***/
	
	public function getChorologieDonneeDao()
	{
		$Dao = new ChorologieDonneeSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao; 
	}
	
	public function getChorologieDonneeAContributeurDao()
	{
		$Dao = new ChorologieDonneeAContributeurSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao; 
	}

	public function getChorologieInformationDao()
	{
		$Dao = new ChorologieInformationSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getChorologieNotionDao()
	{
		$Dao = new ChorologieNotionSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}

	public function getInfoTxtDao()
	{
		$Dao = new InfoTxtSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getLangueDao()
	{
		$Dao = new LangueSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getLangueValeurDao()
	{
		$Dao = new LangueValeurSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}

	public function getNaturalisteIntituleAbreviationDao()
	{
		$Dao = new NaturalisteIntituleAbreviationSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	} 
	
	public function getNomCitationDao()
	{
		$Dao = new NomCitationSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getNomIntituleDao()
	{
		$Dao = new NomIntituleSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getNomIntituleCommentaireDao()
	{
		$Dao = new NomIntituleCommentaireSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}

	public function getNomATxtDao()
	{
		$Dao = new NomATxtSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getNomDao()
	{
		$Dao = new NomSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getNomRelationDao()
	{
		$Dao = new NomRelationSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getNomRangDao()
	{
		$Dao = new NomRangSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getProjetVersionDao()
	{
		$Dao = new ProjetVersionSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getProtectionDao()
	{
		$Dao = new ProtectionSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getProtectionStatutDao()
	{
		$Dao = new ProtectionStatutSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getProtectionTexteDao()
	{
		$Dao = new ProtectionTexteSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getSelectionNomDao()
	{
		$Dao = new SelectionNomSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getTaxonDao()
	{
		$Dao = new TaxonSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getTaxonATxtDao()
	{
		$Dao = new TaxonATxtSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getTaxonAProtectionDao()
	{
		$Dao = new TaxonAProtectionSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getTaxonRelationDao()
	{
		$Dao = new TaxonRelationSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}

	public function getVernaculaireDao()
	{
		$Dao = new VernaculaireSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getVernaculaireAttributionDao()
	{
		$Dao = new VernaculaireAttributionSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getVernaculaireConseilEmploiDao()
	{
		$Dao = new VernaculaireConseilEmploiSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}

	public function getZgDao()
	{
		$Dao = new ZgSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	public function getZgRelationDao()
	{
		$Dao = new ZgRelationSqlDao($this->connexion);
		$this->initialiserDao($Dao);
		return $Dao;
	}
	
	private function initialiserDao($Dao)
	{
		$Dao->setBddPrincipale($this->getStockagePrincipal());
		$Dao->setBddHistorique($this->getStockageHistorique());
		$Dao->setHistorisation($this->getHistorisation());
		$Dao->setDebogage($this->getDebogage());
		$Dao->setFichierSqlMark($this->getFichierSqlMark());
		$Dao->setFichierSqlPrefixe($this->getFichierSqlPrefixe());
		$Dao->setFichierSqlChemin($this->getFichierSqlChemin());
		$Dao->setLimitBool($this->getLimitBool());
		$Dao->setLimitDebut($this->getLimitDebut());
		$Dao->setLimitNbre($this->getLimitNbre());
	}
	// Ajouter les autres objets...
}
?>