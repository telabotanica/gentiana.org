<?php
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.2                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2007 Tela Botanica (accueil@tela-botanica.org)                                          |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                         |
// |                                                                                                      |
// | eFlore is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eFlore is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: aDaoSql.class.php,v 1.1 2007-02-11 19:47:52 jp_milcent Exp $
/**
* Classe aDaoSql : NaturalisteValeur
*
* Description
*
*@package eFlore
*@subpackage dao_sql
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2007
*@version       $Revision: 1.1 $ $Date: 2007-02-11 19:47:52 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
abstract class aDaoSql {
	/*** Constantes : ***/
	
	const RESULTAT_UNIQUE = 1;
	const RESULTAT_OBJET_UNIQUE = 2;
	const RESULTAT_OBJET_MULTIPLE = 3;
	
	/*** Attributs: ***/

	/**
	 * Identifiant du type de données. Dans le cas de clé primaire multiple, nous avons un tableau qui contient les
	 * différentes valeurs des clés.
	 * @access private
	 * @var mixed
	 */
	private $id;

	/**
	 * Identifiant de clé étrangère. Si la table contient plusieurs clés étrangères, nous avons un tableau qui contient
	 * les différentes valeurs des clés.
	 * @access private
	 * @var mixed
	 */
	private $ce;

	
	/**
	 * Notes sur la donnée.
	 * @access private
	 * @var string
	 */
	private $notes;
	
	/**
	 * Date de dernière modification de la donnée.
	 * @access private
	 * @var string
	 */
	private $date_derniere_modif;

	/**
	 * Identifiant de la personne ayant effectué la dernière modification de la donnée.
	 * @access private
	 * @var integer
	 */
	private $ce_modifier_par;

	/**
	 * Identifiant de l'état de la donnée.
	 * @access private
	 * @var integer
	 */
	private $ce_etat;

	/**
	 * Tableau des données attributs utilisés.
	 * @access private
	 * @var array
	 */	
	private $meta_attributs_utilises = array();

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
	* Contient le nom de la classe fille courrante.
	* @access private
	*/
	private $classe_fille_nom;

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
	
	// Gestion de la création d'un fichier sql
	private static $fichier_sql;
	private static $fichier_sql_resource;
	private $fichier_sql_mark = true;
	private $fichier_sql_prefixe = '';
	private $fichier_sql_chemin = '';
	private static $fichier_sql_ecraser = true;
	private static $fichier_sql_fermer = false;
	
	/*** Constructeurs : ***/
	 
	/**
	* Constructeur du type de données issu de la base de données.
	*
	* @param int id Identifiant du type de donnée.
	* @return object
	* @access public
	*/
	public function __construct($connexion = null, $options)
	{
		// Connexion à la base de données
		$this->setConnexion($connexion);
				
		// La base principale
		$this->setStockagePrincipal($options['bdd_principale']);		
		// La base historique
		$this->setStockageHistorique($options['bdd_historique']);
		// Stockage de l'historique des modifications de la base principale
		$this->setHistorisation($options['historisation']);

		// Déclaration du type de débogage
		$this->setDebogage($options['debogage']);

		// Stockage des requêtes SQL dans un fichier
		$this->setFichierSqlMark($options['sql_fichier_mark']);
		// Gestion du fichier stockant le sql
		if ($this->getFichierSqlMark()) {
			$this->setFichierSqlPrefixe($options['fichier_sql_prefixe']);
			$this->setFichierSqlChemin($options['fichier_sql_chemin']);
			self::getFichierSql($this->getFichierSqlChemin().$this->getFichierSqlPrefixe());
			self::getFichierSqlRessource();
			self::$fichier_sql_ecraser = true; 
		}
	}

	/*** Accesseurs : ***/

	// Id 
	/**
	 * Lit la valeur de l'attribut id.
	 *
	 * @return int
	 * @access public
	 */
	public function getId( $cle = null )
	{
		if (is_null($cle)) {
			return $this->id;
		} else {
			return $this->id[$cle];
		}
	} // end of member function getId
	/**
	 * Définit la valeur de l'attribut id.
	 *
	 * @param int id Contient l'id à attribuer à ce type de données.
	 * @return 
	 * @access public
	 */
	public function setId( $id, $cle = null )
	{
		if (is_null($cle)) {
			$this->id = $id;
		} else {
			$this->id[$cle] = $id;
			$this->setMetaAttributsUtilises( $cle );
		}
	} // end of member function setId
	
	// Ce 
	/**
	 * Lit la valeur de l'attribut ce.
	 *
	 * @return int
	 * @access public
	 */
	public function getCe( $cle = null )
	{
		if (is_null($cle)) {
			return $this->ce;
		} else {
			return $this->ce[$cle];
		}
	} // end of member function getCe
	/**
	 * Définit la valeur de l'attribut ce.
	 *
	 * @param int ce Contient l'identifiant de la clé étrangère.
	 * @return 
	 * @access public
	 */
	public function setCe( $ce, $cle = null )
	{
		if (is_null($cle)) {
			$this->ce = $ce;
		} else {
			$this->ce[$cle] = $ce;
			$this->setMetaAttributsUtilises( $cle );
		}
	} // end of member function setCe
	
	// Notes
	/**
	 * Lit la valeur de l'attribut notes.
	 *
	 * @return string
	 * @access public
	 */
	public function getNotes( )
	{
		return $this->notes;
	}
	/**
	 * Définit la valeur de l'attribut notes.
	 *
	 * @param string Contient les notes à attribuer à ce type de données.
	 * @return 
	 * @access public
	 */
	public function setNotes( $notes )
	{
		$this->notes = $notes;
		$this->setMetaAttributsUtilises( 'notes' );
	}
	
	// Date Dernière Modif
	/**
	* Lit la valeur de l'attribut date_derniere_modif.
	*
	* @return string la date de dernière modif.
	* @access public
	*/
	public function getDateDerniereModif( )
	{
		return $this->date_derniere_modif;
	} // end of member function getDateDerniereModif
	/**
	* Définit la valeur de l'attribut date_derniere_modif.
	*
	* @param string Contient la date de dernière modif.
	* @return void
	* @access public
	*/
	public function setDateDerniereModif( $date )
	{
		$this->date_derniere_modif = $date;
		$this->setMetaAttributsUtilises( 'date_derniere_modif' );
	} // end of member function setDateDerniereModif
	
	// Ce Modifier Par
	/**
	* Lit la valeur de l'attribut ce_modifier_par.
	*
	* @return int l'id de la personne ayant modifié la dernière la donnée.
	* @access public
	*/
	public function getCeModifierPar( )
	{
		return $this->ce_modifier_par;
	} // end of member function getCeModifierPar
	/**
	* Définit la valeur de l'attribut ce_modifier_par.
	*
	* @param int contient l'id de la personne ayant modifié la dernière la donnée.
	* @return void
	* @access public
	*/
	public function setCeModifierPar( $id )
	{
		$this->ce_modifier_par = $id;
		$this->setMetaAttributsUtilises( 'modifier_par' );
	} // end of member function setCeModifierPar
	
	// Ce Etat
	/**
	* Lit la valeur de l'attribut ce_etat.
	*
	* @return int l'id de l'état de la donnée.
	* @access public
	*/
	public function getCeEtat( )
	{
		return $this->ce_etat;
	} // end of member function getCeEtat
	/**
	* Définit la valeur de l'attribut ce_etat.
	*
	* @param int contient l'id de l'état de la donnée.
	* @return void
	* @access public
	*/
	public function setCeEtat( $id )
	{
		$this->ce_etat = $id;
		$this->setAttributUtilise( 'etat' );
	} // end of member function setEtat
	
	// Meta Attributs Utilises
	public function getMetaAttributsUtilises()
	{
		return $this->meta_attributs_utilises;
	}
	public function setMetaAttributsUtilises( $attribut )
	{
		if (isset($this->meta_attributs_utilises[$attribut])) {
			$this->meta_attributs_utilises[$attribut] = $this->meta_attributs_utilises[$attribut]+1;
		} else {
			$this->meta_attributs_utilises[$attribut] = 1;
		}
	}

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
	
	// Classe Fille Nom
	/**
	* Lit la valeur de l'attribut "classe_fille_nom".
	* @access public
	* @return string
	*/
	public function getClasseFilleNom()
	{
		return $this->classe_fille_nom;
	}
	/**
	* Écris la valeur de l'attribut "classe_fille_nom".
	* @access public
	* @param string le nom de la classe fille.
	*/
	public function setClasseFilleNom($cfn)
	{
		$this->classe_fille_nom = $cfn;
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
	
	/*** Méthodes : ***/
	
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
		
		if ($this->getDebogage() == EF_DEBOG_SQL) {
			echo $this->getRequete()."\n";
		}
		
		if ($this->getResultatType() == aDaoSql::RESULTAT_UNIQUE) {
			$resultat = $this->getConnexion()->getOne($this->getRequete(), $parametres);
			if (PEAR::isError($resultat)) {
	    		$e = GestionnaireErreur::retournerErreurSql($fichier, $methode, $resultat->getMessage(), $this->getRequete());
	    		trigger_error($e, E_USER_ERROR);
	    		return null;
			} else {
				return $resultat;
			}
		} else if ($this->getResultatType() == aDaoSql::RESULTAT_OBJET_UNIQUE) {
			$aso_donnees = $this->getConnexion()->getRow($this->getRequete(), $parametres, DB_FETCHMODE_ASSOC);
			if (PEAR::isError($aso_donnees)) {
	    		$e = GestionnaireErreur::retournerErreurSql($fichier, $methode, $aso_donnees->getMessage(), $this->getRequete());
	    		trigger_error($e, E_USER_ERROR);
	    		return null;
			} else if (is_null($aso_donnees)) {
	    		return null;
			} else {
				return $this->instancierObjetModele($aso_donnees);
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
			while ($aso_donnees =& $donnees->fetchRow(DB_FETCHMODE_ASSOC)) {
				$tab_objets[] = $this->instancierObjetModele($aso_donnees);	 
			}
			$this->getConnexion()->freePrepared($etat);
			return $tab_objets;
		} else {
			$message = "La classe ".get_class($this)." n'indique pas le type de résultat pour la requête.";
			trigger_error($message, E_USER_WARNING);
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
	
// +------------------------------------------------------------------------------------------------------+
// DEBUT TEST ...	
	public function find()
	{
		$sql = 'SELECT * FROM '.$this->getTableNom();
		
		// Tableau conteannt les paramêtres de la clause WHERE
		$where = array();

		// Utilsiation de l'API PHP 5 de rélexion des classes
		$class = new ReflectionClass($this->getClasseFilleNom());
		
		// Récupération de toutes les propriétés de la classe
		$properties = $class->getProperties();

		// Loop through the properties
		for ($i = 0; $i < count($properties); $i++) {
			$name = $properties[$i]->getName();

			if (substr($name, 0, 5) != 'table' && $this->$name != '') {
				// Add this to the where clause
				$where[] = "`".$name."`='".$this->getConnexion()->escapeSimple($this->$name)."'";
			}
		}

		// If we have a where clause, build it
		if (count($where) > 0){
			$sql .= " WHERE ".implode(' AND ', $where);
		}
		$this->setRequete($sql);
		
		$this->rs = $this->getConnexion()->query($this->getRequete());
		if (PEAR::isError($this->rs)) {
	    	$message = $this->rs->getMessage()."\n".$this->rs->getUserInfo();
    		$e = GestionnaireErreur::retournerErreurSql(get_class($this), $methode, $message, $this->getRequete());
	    	trigger_error($e, E_USER_ERROR);
	    	return false;
		} else {
			return true;
		}	
	}
	
	function getNext()
	{
		$this->rs->fetchInto($row, DB_FETCHMODE_ORDERED);

		// Use reflection to fetch the DO's field names
		$nom_objet = $this->getClasseFilleNom();
		$dataobject = new $nom_objet;
		$class = new ReflectionObject($dataobject);
		$properties = $class->getProperties();

		// Loop through the properties to set them from the current row
		for ($i = 0; $i < count($properties); $i++) {
			$prop_name = $properties[$i]->getName();
			$dataobject->$prop_name = $row[$prop_name];
		}
		
		return $dataobject;
	}
	
	function rowCount()
	{
		return $this->rs->numRows();
	}

// FIN TEST ...
// +------------------------------------------------------------------------------------------------------+

	/**
	* Ajoute les valeurs des champs aux bons attributs.
	* 
	* @return NaturalisteIntituleAbreviation un objet de type NaturalisteIntituleAbreviation instancié avec les valeurs d'une requete.
	* @access public
	*/
	public function instancierObjetModele(&$donnees)
	{
		$classe = $this->getClasseFilleNom();
		$un_objet = new $classe;
		foreach ($donnees as $cle => $val) {
			$supprimer = true;
			if (array_key_exists($cle, $this->getTableChamps())) {
				$type = $this->getTableChamps($cle);
				$type = $type['type'];
				if ($type == 'id') {
					$un_objet->setId($val, substr_replace(substr_replace($cle, '', 0, strlen($this->getTablePrefixe())), '', 0, 3));
				} else if ($type == 'ce') {
					$un_objet->setCe($val, substr_replace(substr_replace($cle, '', 0, strlen($this->getTablePrefixe())), '', 0, 3));
				} else if ($type == 'no') {
					$methode = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', substr_replace($cle, '', 0, strlen($this->getTablePrefixe())))));
					call_user_method($methode, $un_objet, $val);
				}
			} else {
				$supprimer = false;
			}
			if ($supprimer === true) {
				unset($donnees[$cle]);
			}
		}
		foreach ($this->getEnfants() as $cle => $val) {
			$un_objet->setObjet($cle, $val->instancierObjetModele($donnees));
		}
		return $un_objet;
	}
	
	/**
	* Vérifie les valeurs présentes dans l'objet et permet de construire une requête.
	* 
	* @param Nom un objet de type nom instancié avec les valeurs d'une requete.
	* @access public
	*/
	public function verifierObjetModele( $un_objet )
	{
		$aso_champs = array();
		foreach($un_objet->getMetaAttributsUtilises() as $attribut => $nbre_utilisation) {
			foreach($this->getTableChamps() as $champ => $val) {
				$champ_cmp = substr_replace($champ, '', 0, strlen($this->getTablePrefixe()));
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
						$valeur = call_user_method($methode, $un_objet, $attribut);
					} else {
						$methode = 'get'.$methode;
						$valeur = call_user_method($methode, $un_objet);
					}
					if ($val['format'] == 'str') {
						$aso_champs[$champ] = '"'.$this->getConnexion()->escapeSimple($valeur).'"';
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
	public function ajouterEnfant( $cle, $enfant )
	{
		$this->enfants[$cle] = $enfant;
	}
	/**
	* Supprime un enfant du composant.
	*
	* @param string Définit le nom de l'objet enfant.
	* @return void
	* @access public
	*/
	public function supprimerEnfant( $cle )
	{
		unset($this->enfants[$cle]);
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
	
	public function __destruct()
	{
		self::getFichierSqlRessource(true);	
	}
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: aDaoSql.class.php,v $
* Revision 1.1  2007-02-11 19:47:52  jp_milcent
* Début gestion de l'api de la version 1.2 d'eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>