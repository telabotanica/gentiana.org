<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5                                                                                        |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eRibo.                                                            |
// |                                                                                                      |
// | Foobar is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | Foobar is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: AModeleDao.class.php,v 1.32 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Classe abstraite ModeleManipulationInformation
*
* Permet de g�rer les op�rations sur la base de donn�es.
*
*@package eRibo
*@subpackage abstractions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.32 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
//Constante d�finissant le type de requ�te de consultation. Dernier num�ro : 45
/** Constante d�finissant une requ�te de consultation simple.
 * Une ligne de la table est r�cup�r�e en se basant sur l'id pass� en param.*/
define('EF_CONSULTER_SIMPLE', 0);

// PROJET_MODULE
/** R�cup�re les modules d'une version donn�es.*/
define('EF_CONSULTER_MODULE_VERSION', 3);

// NOM_RANG
/** R�cup�re le rang correspondant � un id.*/
define('EF_CONSULTER_RANG_ID', 8);
/** R�cup�re le rang correspondant � un nom de rang.*/
define('EF_CONSULTER_RANG_NOM', 9);
/** R�cup�re le rang correspondant � un nom de rang.*/
define('EF_CONSULTER_RANG_FAMILLE', 10);
/** R�cup�re le rang correspondant � un nom de rang.*/
define('EF_CONSULTER_RANG_GENRE', 11);

// VERNACULAIRE
/** R�cup�re les noms vernaculaires pour un radical et une version de projet donn�s.*/
define('EF_CONSULTER_VERNACULAIRE_RADICAL_VERSION', 16);
/** R�cup�re les noms vernaculaires pour un radical donn�s.*/
define('EF_CONSULTER_VERNACULAIRE_RADICAL', 30);
/** R�cup�re les noms vernaculaires pour un ensemble d'ID donn�s.*/
define('EF_CONSULTER_V_GROUPE_ID', 37);
/** R�cup�re les noms vernaculaires de facon pour un radical donne� et une version donnee*/
define('EF_CONSULTER_VERNACULAIRE_APPROCHE_VERSION', 50);
/** R�cup�re les noms vernaculaires de facon pour un radical donne� et une version donnee*/
define('EF_CONSULTER_VERNACULAIRE_APPROCHE', 51);
// VERNACULAIRE_ATTRIBUTION
/** R�cup�re les r�f�rences aux noms vernaculaires pour un id de taxon et une version de projet de taxon donn�s.*/
define('EF_CONSULTER_VA_VERSION_TAXON_ID', 36);
// VERNACULAIRE_CONSEIL_EMPLOI
/** R�cup�re les infos sur un conseil d'emploi en fonction de son Id.*/
define('EF_CONSULTER_VCE_ID', 40);

/** Constante d�finissant une requ�te de consultation globale.
 * Toutes les lignes de la table sont r�cup�r�es sans aucun param�tre.*/
define('EF_CONSULTER_GLOBAL', 1000);
/** Pour tester une requete.*/
define('TEST', 10000);

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/**
 * class AModeleManipInfo
 * 
 * Classe abstraite repr�sentant type de donn�es manipulable d'eFlore.
 */
abstract class AModeleDao {
	/*** Attributs: ***/

	/**
	* Connexion � la base de donn�es.
	* @access private
	*/
	private $connexion;

	/**
	* Nom de la base de donn�es courante o� effectuer les requ�tes.
	* @access private
	*/
	private $bdd_courante = EF_BDD_NOM_PRINCIPALE;

	
	/**
	* Requete demand�e.
	* @access private
	*/
	private $requete;
	
	/**
	* Permet de savoir quel est le type de d�bogage d�sir�.
	*@access private
	*/
	private $debogage;

	/**
	* Nom de l'objet dont on manipule les informations.
	* @access protected
	*/
	protected $nom_type_info;

	/*** Constructeurs : ***/
	 
	/**
	* Constructeur du type de donn�es issu de la base de donn�es.
	*
	* @return object
	* @access public
	*/
	public function __construct()
	{
		// Connexion � la base de donn�es
		$this->setConnexion(DB::connect($GLOBALS['_EFLORE_']['dsn']));
		if (PEAR::isError($this->getConnexion())) {
			$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $this->getConnexion()->getMessage());
			die('<pre>'.print_r($e, true).'</pre>');
			// A FAIRE : r�parer le trigger_error qui ne semble pas marcher ...
    		//trigger_error($e, E_USER_ERROR);
		}

		if (EF_LANGUE_UTF8) {
			// R�cup�ration des infos au format UTF-8
			$requete = 	'SET NAMES "utf8"';
			$info = $this->getConnexion()->query($requete);
			if (PEAR::isError($info)) {
				$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $info->getMessage());
				die('<pre>'.print_r($e, true).'</pre>');
				// A FAIRE : r�parer le trigger_error qui ne semble pas marcher ...
	    		//trigger_error($e, E_USER_ERROR);
			}
		}
		
		// D�claration du type de d�bogage par d�faut : aucun.
		$this->setDebogage(EF_DEBOG_AUCUN);
	} // end of member function __construct
	
	/**
	* Destructeur du type de donn�es issu de la base de donn�es.
	* 
	* Le destructeur r�tabli l'encodage par d�faut qui est latin 1 dans Papyrus.
	*
	* @access public
	*/
	public function __destruct()
	{
		if (EF_LANGUE_UTF8) {
			// Nous remettons l'encodage par d�faut pour Papyrus.
			$requete = 	'SET NAMES DEFAULT';
			$info = $this->getConnexion()->query($requete);
			if (PEAR::isError($info)) {
				$e = GestionnaireErreur::retournerErreurSql(__FILE__, __LINE__, $info->getMessage());
				die('<pre>'.print_r($e, true).'</pre>');
			}
		}
	}
	
	/*** Accesseurs : ***/
	 
	// Connexion
	/**
	 * Lit la valeur de l'attribut connexion.
	 * 
	 * @access public
	 * @return PEAR.DB connexion � la base de donn�es.
	 */
	public function getConnexion( )
	{
		return $this->connexion;
	} // end of member function getConnexion
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
	} // end of member function setConnexion

	// Bdd Courante
	/**
	 * Lit la valeur de l'attribut bdd_courante.
	 * 
	 * @access public
	 * @return string le nom de la base de donn�es courante.
	 */
	public function getBddCourante( )
	{
		return $this->bdd_courante;
	}
	/**
	 * D�finit la valeur de l'attribut bdd_courante.
	 *
	 * @access public
	 * @param string le nom de la base de donn�es courante.
	 * @return null
	 */
	public function setBddCourante( $bc )
	{
		$this->bdd_courante = $bc;
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
	 * D�finit la valeur de l'attribut requete.
	 *
	 * @param string Contient une requete CRUD.
	 * @return void
	 * @access public
	 */
	public function setRequete( $requete )
	{
		$this->requete = $requete;
	}

	// Nom de l'objet manipul�
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
	* D�finit la valeur de l'attribut nom_type_info.
	*
	* @param string D�finit le nom de l'objet dont on manipule les infos.
	* @return void
	* @access public
	*/
	public function setNomTypeInfo( $nti )
	{
		$this->nom_type_info = $nti;
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
	} // end of member function getDebogage
	/**
	 * D�finit la valeur de l'attribut debogage.
	 *
	 * @param bool D�finit le type de d�bogage.
	 * @return void
	 * @access public
	 */
	public function setDebogage( $debogage )
	{
		$this->debogage = $debogage;
	} // end of member function setDebogage
	
	/*** M�thodes : ***/
	
	/**
	 * Permet de consulter un type de donn�es.
	 *
	 * @return array
	 * @access public
	 */
	public function consulter( $param = array() )
	{
		$tab_objets = array();
  		$fichier = $this->getNomTypeInfo().'Dao.class.php';
		$methode = 'consulter()';
			
		$etat = $this->getConnexion()->prepare($this->getRequete());
		if (PEAR::isError($etat)) {
			$e = GestionnaireErreur::retournerErreurSql($fichier, $methode, $donnees->getMessage(), $this->getRequete());
			die('<pre>'.print_r($e, true).'</pre>');
			// A FAIRE : r�parer le trigger_error qui ne semble pas marcher ...
    		//trigger_error($e, E_USER_ERROR);
    		//return false;
		}
		 
		$donnees = $this->getConnexion()->execute($etat, $param);
		if (PEAR::isError($donnees)) {
    		$e = GestionnaireErreur::retournerErreurSql($fichier, $methode, $donnees->getMessage(), $this->getRequete());
    		die('<pre>'.print_r($e, true).'</pre>');
			// A FAIRE : r�parer le trigger_error qui ne semble pas marcher ...
			//trigger_error($e, E_USER_ERROR);
			//return false;
		}
		
		if ($this->getDebogage() == EF_DEBOG_SQL) {
			echo '<pre>'.$donnees->query.'</pre>';
		}
		
		
		
		while ($tab_donnee =& $donnees->fetchRow(DB_FETCHMODE_ASSOC)) {
			if (EF_LANGUE_UTF8) {
				// Nous passons tout en iso-8859-15 en attendant que Papyrus et PHP supporte l'utf-8
				$this->decoderUtf8($tab_donnee);
			}
			
			if (method_exists($this, 'attribuerChamps')) {
				$tab_objets[] = $this->attribuerChamps($tab_donnee);
			} else {
				$nom_objet = $this->getNomTypeInfo();
				$tab_objets[] = new $nom_objet($tab_donnee);
			}	 
		}
		
		return $tab_objets;
	}
	
	/**
	 * M�thode permettant de d�tcoder de l'utf8 vers l'iso-8859-15 un tableau de variables.
	 *
	 * @param mixed la chaine ou le tableau � d�coder de l'utf8 vers l'iso-8859-15.
	 * @return mixed la chaine ou le tableau d�cod� en iso-8859-15.
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
	 * Permet d'ajouter un type de donn�es.
	 *
	 * @param object l'objet contenant les infos � ajouter � la base de donn�e.
	 * @return void
	 * @access public
	 */
	public function ajouter( $un_objet )
	{
		
	} // end of member function ajouter

	/**
	 * Permet de supprimer un type de donn�es.
	 * @param mixed identifiant du type de donn�es � d�truire.
	 * @return void
	 * @access public
	 */
	public function supprimer( $id )
	{
		
	} // end of member function supprimer

	/**
	 * Permet de modifier un type de donn�es.
	 *
	 * @param mixed identifiant du type de donn�es � modifier.
	 * @param object l'objet contenant les infos � remplacer dans la base de donn�e.
	 * @return void 
	 * @access public
	 */
	public function modifier( $id, $un_objet )
	{
		
	} // end of member function modifier

} // end of ModeleManipulationInformation

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: AModeleDao.class.php,v $
* Revision 1.32  2007-06-19 10:32:57  jp_milcent
* D�but utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.31  2007-06-11 12:45:32  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.27.6.9  2007-06-08 09:01:06  jp_milcent
* Ajout d'une variable globale pour manipuler l'encodage de sortie.
*
* Revision 1.30  2007-06-04 12:17:08  jp_milcent
* Fusion avec la livraison Moquin-Tandon : 04 juin 2007
*
* Revision 1.27.6.7  2007-06-04 11:30:58  jp_milcent
* Correction probl�me utf8 : la convertion iso vers utf8 et invers�ment est r�alis�e par Mysql.
*
* Revision 1.29  2007-06-01 13:23:05  jp_milcent
* Fusion avec livraison Moquin-Tandon : 01 juin 2007
*
* Revision 1.27.6.6  2007-05-30 17:01:40  jp_milcent
* Remise � default de la collation utilis� pour la conexion � la bdd.
*
* Revision 1.27.6.5  2007-05-30 16:35:12  jp_milcent
* Gestion correcte de l'utf8.
*
* Revision 1.28  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.27.6.4  2007/02/05 10:57:56  jp_milcent
* Correction bogue dans expression r�guli�re xml...
*
* Revision 1.27.6.3  2007/02/05 10:39:41  jp_milcent
* Ajout du xml en utf8 dans les valeurs � ne pas d�coder.
*
* Revision 1.27.6.2  2007/02/05 10:22:17  jp_milcent
* D�codage de l'utf-8 en iso-8859-15.
*
* Revision 1.27.6.1  2007/02/02 18:10:17  jp_milcent
* Tentativede modif pour g�rer l'utf8.
* Finalement, pas n�cessaire Mysql passe en iso automatiquement.
*
* Revision 1.27  2006/05/19 15:10:07  jp_milcent
* Am�lioration de la gestion des informations sur les projets.
* D�but gestion d'un graphique du nombre de noms publi�s par ann�e.
*
* Revision 1.26  2006/05/16 09:27:34  jp_milcent
* Gestion des correspondances.
* Ajout du plier/deplier.
*
* Revision 1.25  2006/03/07 11:07:08  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnbe_v1.
*
* Revision 1.24.2.1  2006/03/07 10:50:38  jp_milcent
* Suppression de constantes inutiles et redistribution dans les fichiers DAO sp�cifiques.
*
* Revision 1.24  2005/12/21 15:47:39  jp_milcent
* Suppression de l'impl�mentation d'OperationSql.
* Code inutilis�!
*
* Revision 1.23  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.22  2005/12/06 09:47:26  ddelon
* Recherche vernaculaire (extension) + recherche approche
*
* Revision 1.21  2005/12/01 09:54:33  jp_milcent
* Trigger_error ne semble pas marcher en local hors Papyrus.
* J'ai remplacer temporairement par die.
*
* Revision 1.20  2005/11/28 16:51:41  jp_milcent
* Probl�me sur les trigger_error � r�gler.
* En attendant, utilisation de la fonction die.
*
* Revision 1.19  2005/11/23 11:14:56  jp_milcent
* Extraction d'une constante, d�palcement dans son fichier DAO.
*
* Revision 1.18  2005/10/18 17:17:20  jp_milcent
* D�but de la gestion des url d'eFlore.
*
* Revision 1.17  2005/10/14 17:27:59  jp_milcent
* Ajout des param�tres aux m�thodes supprimer, ajouter, modifier.
* Utilisation du design pattern DAO.
*
* Revision 1.16  2005/10/13 16:25:04  jp_milcent
* Ajout de la classification � la synth�se.
*
* Revision 1.15  2005/10/13 08:27:09  jp_milcent
* Ajout d'une mini chorologie sur la page de synth�se.
* D�placement des constantes de requete sql dans les fichiers de chaque classe DAO.
*
* Revision 1.14  2005/10/11 17:30:31  jp_milcent
* Am�lioration gestion de la chorologie en cours.
*
* Revision 1.13  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.12  2005/10/04 16:34:03  jp_milcent
* D�but gestion de la chorologie.
* Ajout de la biblioth�que de cartographie (� am�liorer!).
*
* Revision 1.11  2005/09/30 16:22:01  jp_milcent
* Fin de la gestion de l'onglet Noms Vernaculaires.
*
* Revision 1.10  2005/09/28 16:29:31  jp_milcent
* D�but et fin de gestion des onglets.
* D�but gestion de la fiche Synonymie.
*
* Revision 1.9  2005/09/27 16:03:46  jp_milcent
* Fin de l'am�lioration de la gestion des noms vernaculaires dans l'onglet Synth�se.
*
* Revision 1.8  2005/09/26 15:48:15  jp_milcent
* Fin de l'onglet synth�se pour la fiche d'un taxon.
*
* Revision 1.7  2005/09/16 16:41:45  jp_milcent
* Gestion de l'onglet Synth�se en cours.
* Cr�ation du mod�le pour l'attribution des noms vernaculaires aux taxons.
*
* Revision 1.6  2005/09/14 16:57:58  jp_milcent
* D�but gestion des fiches, onglet synth�se.
* Am�lioration du mod�le et des objets DAO.
*
* Revision 1.5  2005/09/13 16:25:23  jp_milcent
* Fin de gestion des interfaces de recherche.
*
* Revision 1.4  2005/09/12 16:22:44  jp_milcent
* Fin de gestion de la recherche des noms latins pour tous les r�f�rentiels.
*
* Revision 1.3  2005/09/05 15:53:30  jp_milcent
* Ajout de la gestion du bouton plus et moins.
* Optimisation en cours.
*
* Revision 1.2  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.1  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requ�te rapide.
* D�but gestion choix aplhab�tique des taxons.
*
* Revision 1.2  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des r�sultats des recherches taxonomiques (en cours).
*
* Revision 1.1  2005/08/04 15:51:45  jp_milcent
* Impl�mentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.6  2005/08/03 15:52:31  jp_milcent
* Fin gestion des r�sultats recherche nomenclaturale.
* D�but gestion formulaire taxonomique.
*
* Revision 1.5  2005/08/02 16:19:33  jp_milcent
* Am�lioration des requetes de recherche de noms.
*
* Revision 1.4  2005/08/01 16:18:39  jp_milcent
* D�but gestion r�sultat de la recherche par nom.
*
* Revision 1.3  2005/07/28 15:37:56  jp_milcent
* D�but gestion des squelettes et de l'API eFlore.
*
* Revision 1.2  2005/07/27 15:43:21  jp_milcent
* D�but d�bogage avec gestion de l'appli hors Papyrus.
*
* Revision 1.1  2005/07/26 16:27:29  jp_milcent
* D�but mise en place framework eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>