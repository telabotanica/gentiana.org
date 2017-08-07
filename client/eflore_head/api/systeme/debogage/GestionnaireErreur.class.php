<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Debogage.                                                                |
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
// CVS : $Id: GestionnaireErreur.class.php,v 1.3 2006-07-20 18:06:17 jp_milcent Exp $
/**
* Classe de gestion des erreurs.
*
* 
*
*@package eFlore
*@subpackage Debogage
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.3 $ $Date: 2006-07-20 18:06:17 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+


/**
 * Classe GestionnaireErreur
 * 
 * Gérer les erreurs PHP et SQL.
 */
class GestionnaireErreur
{
	/*** Attributes: ***/

	/**
	 * Permet de savoir si on utilise PHP en ligne de commande dans une console (PHP-CLI) ou en mode module de serveur.
	 * @access private
	 */
	private static $mode;

	/**
	 * Contient la liste des erreurs.
	 * @access private
	 */
	private $erreurs;

	/**
	 * Permet de savoir si on veut faire apparaître ou pas le contexte de l'erreur,
	 * c'est à dire le contenu des variables.
	 * @access private
	 */
	private $contexte;
	
	/**
	 * Contient le niveau d'erreur courrant. Celui que l'on donne à la fonction
	 * error_reporting().
	 * @access private
	 */
	private $niveau_erreur_courrant;
	
	/*** Constructeur: ***/
	
	/**
	 * Construit le gestionnaire d'erreur.
	 *
	 * @return void
	 * @access public
	 */
	public function __construct( $contexte = false ) {
		$this->mode = php_sapi_name();
		$this->erreurs = array();
		$this->setContexte($contexte);
		set_error_handler(array(&$this, 'gererErreur'));
	} // end of member function __construct
	
	/*** Accesseurs: ***/
	
	/**
	 * Récupère le tableau des erreurs.
	 *
	 * @return array
	 * @access public
	 */
	public function getErreur( ) {
		return $this->erreurs;
	}

	/**
	 * Ajoute une erreur à la liste.
	 *
	 * @param array une_erreur 	 
	 * @return void
	 * @access public
	 */
	public function setErreur( $une_erreur ) {
		$this->erreurs[] = $une_erreur;
	}

	/**
	 * Récupère la valeur du contexte.
	 *
	 * @return boolean
	 * @access public
	 */
	public function getContexte( ) {
		return $this->contexte;
	}

	/**
	 * Définit si oui ou non le contexte sera affiché.
	 *
	 * @param boolean un_contexte
	 * @return  void
	 * @access public
	 */
	public function setContexte( $un_contexte ) {
		$this->contexte = $un_contexte;
	}
	
	/**
	 * Récupère le niveau d'erreur courrant.
	 *
	 * @return int le niveau d'erreur courrant.
	 * @access public
	 */
	public function getNiveauErreurCourrant( ) {
		return (int)$this->niveau_erreur_courrant;
	}

	/**
	 * Définit le niveau d'erreur courrant.
	 *
	 * @param int un niveau d'erreur.
	 * @return void
	 * @access public
	 */
	public function setNiveauErreurCourrant( $niveau = 2048 ) {
		$this->niveau_erreur_courrant = $niveau;
	}
	
	/**
	 * Définit le niveau d'erreur courrant (synonyme fonction precedente)
	 *
	 * @param int un niveau d'erreur.
	 * @return void
	 * @access public
	 */
	public function setActive ($niveau) {
		$this->niveau_erreur_courrant = $niveau;
	}
	
	
	/*** Méthodes : ***/
	
	/**
	 *
	 * @param int niveau
	 * @param string message
	 * @param string fichier
	 * @param int ligne
	 * @param boolean contexte
	 * @return void
	 * @access public
	 */
	public function gererErreur( $niveau,  $message,  $fichier,  $ligne,  $contexte ) {
		$aso_erreur = array();
		// Nous vérifions si nous affichons ou pas l'erreur en fonction du niveau demandé
		if ( $niveau <= $this->getNiveauErreurCourrant() ) {
			$aso_erreur['niveau'] = $niveau;
			$aso_erreur['message'] = $message;
			$aso_erreur['fichier'] = $fichier;
			$aso_erreur['ligne'] = $ligne;
			if ($this->getContexte()) {
				$aso_erreur['contexte'] = $contexte;
			}
			$this->setErreur($aso_erreur);
		}
		// Si nous avons à faire à une erreur et non à un warning ou une notice, nous arrêtons l'exécution du script
		switch ($niveau) {
			case E_ERROR :
			case E_USER_ERROR :
				die($this->retournerErreur());
				break;
		}
	} // end of member function gererErreur

	/**
	 * Retourne l'erreur PHP formatée en XHTML.
	 *
	 * @return string
	 * @access public
	 */
	public static function retournerErreur( ) {
		$retour = '';
		$erreur_pear_nbre = 0;
		foreach($this->getErreur() as $aso_erreur) {
			if ('<!-- BEGIN sql -->' == substr($aso_erreur['message'], 0, 18)) {
				$retour .= $aso_erreur['message'];
				continue;
			}
			// Nous testons les erreurs PEAR pour ne pas en tenir compte
			if (!EF_DEBOGAGE_PEAR && stristr($aso_erreur['fichier'], EF_DEBOGAGE_PEAR_CHAINE)) {
				$erreur_pear_nbre++;
			} else {
				switch (php_sapi_name()) {
					case 'cli' :
						if ($aso_erreur['niveau'] <= 512) {
							$retour .= 'INFO : Niveau '.$aso_erreur['niveau']."\n";
						} else {
							$retour .= 'ERREUR : Niveau '.$aso_erreur['niveau']."\n";
						}
						$retour .= 'Niveau : '.$aso_erreur['niveau']."\n";
						$retour .= 'Message : '.$aso_erreur['message']."\n";
						$retour .= 'Fichier : '.$aso_erreur['fichier']."\n";
						$retour .= 'Ligne : '.$aso_erreur['ligne']."\n";
						if ($this->getContexte()) {
							$retour .= 'Contexte : '."\n".print_r($aso_erreur['contexte'], true)."\n";
						}
						break;
					default:
						if ($aso_erreur['niveau'] <= 512) {
							$retour .= '<p class="information">'."\n";
							$retour .= '<strong>INFO : Niveau '.$aso_erreur['niveau'].'</strong><br />'."\n";
						} else {
							$retour .= '<p class="attention">'."\n";
							$retour .= '<strong>ERREUR : Niveau '.$aso_erreur['niveau'].'</strong><br />'."\n";
						}
						$retour .= '<strong>Niveau : </strong>'.$aso_erreur['niveau'].'<br />'."\n";
						$retour .= '<strong>Message : </strong>'.$aso_erreur['message'].'<br />'."\n";
						$retour .= '<strong>Fichier : </strong>'.$aso_erreur['fichier'].'<br />'."\n";
						$retour .= '<strong>Ligne : </strong>'.$aso_erreur['ligne'].'<br />'."\n";
						if ($this->getContexte()) {
							$retour .= '<pre>'."\n";
							$retour .= '<stong>Contexte : </stong>'."\n".print_r($aso_erreur['contexte'], true)."\n";
							$retour .= '</pre>'."\n";
						}
						$retour .= '</p>'."\n";
				} 
			}
		}
		if ($erreur_pear_nbre != 0) {
			$retour .= '<p class="attention"><strong>Nombre d\'erreurs PEAR : </strong>'.$erreur_pear_nbre.'</p>'."\n";
		}
		return $retour;
	} // end of member function retournerErreur

	/**
	* Retourne l'erreur SQL formatée en XHTML.
	*
	* @param string fichier
	* @param int ligne
	* @param string message
	* @param string requete
	* @param string autres
	* @return string
	* @static
	* @access public
	*/
	public static function retournerErreurSql( $fichier,  $methode,  $message,  $requete = null,  $autres = null ) 
	{
		$retour = '';
		switch (php_sapi_name()) {
			case 'cli' :
				$retour .= 'ERREUR SQL '."\n";
				$retour .= 'Fichier : '.$fichier."\n";
				$retour .= 'Méthode : '.$methode."\n";
				$retour .= 'Message : '.$message."\n";
				if (!is_null($requete)) {
					$retour .= 'Requete : '."\n";
					$retour .= $requete."\n";
		    	}
		    	
				if (!is_null($autres)) {
					$retour .= 'Autres infos : '."\n";
					$retour .= $autres."\n";
				}
				break;
			default:
				$retour .= '<!-- BEGIN sql -->';
				$retour .= '<div id="zone_erreur">'."\n";
				$retour .= '<h1 > ERREUR SQL </h1><br />'."\n";
				$retour .= '<dl>'."\n";
				$retour .= '<dt> Fichier : </dt> ';
				$retour .= '<dd> '.$fichier.'</dd>'."\n";
				
				$retour .= '<dt> Méthode : </dt> ';
				$retour .= '<dd> '.$methode.'</dd>'."\n";
				
				$retour .= '<dt> Message erreur : </dt> ';
				$retour .= '<dd> '.$message.'</dd>'."\n";
				
				if (!is_null($requete)) {
					$retour .= '<dt> Requete : </dt> ';
					$retour .= '<dd> '.$requete.' </dd>'."\n";
		    	}
		    	
				if (!is_null($autres)) {
					$retour .= '<dt> Autres infos : </dt> ';
					$retour .= '<dd> '.$autres.' </dd>'."\n";
				}
				$retour .= '</dl>'."\n";
				$retour .= '</div>'."\n";
				$retour .= '<!-- END sql -->'."\n";
		}
		return $retour;
	} // end of member function retournerErreurSql

} // end of GestionnaireErreur

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: GestionnaireErreur.class.php,v $
* Revision 1.3  2006-07-20 18:06:17  jp_milcent
* Correction bogue this dans méthode static.
*
* Revision 1.2  2006/07/20 17:41:43  jp_milcent
* Formatage du message de sortie en fonction du type de PHP : cli ou autre.
*
* Revision 1.8  2006/07/20 13:33:46  jp_milcent
* Légère modif affichage.
*
* Revision 1.7  2006/07/20 13:33:03  jp_milcent
* Amélioration du gestionnaire d'erreur.
*
* Revision 1.6  2006/07/20 13:27:07  jp_milcent
* Ajout du type information.
*
* Revision 1.5  2006/05/29 13:52:41  ddelon
* Integration wiki dans eflore
*
* Revision 1.4  2005/12/09 10:47:05  jp_milcent
* Amélioration du Gestionnaire de Bogues.
*
* Revision 1.3  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.2  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
* Revision 1.1  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.3  2005/08/02 16:19:33  jp_milcent
* Amélioration des requetes de recherche de noms.
*
* Revision 1.2  2005/08/01 16:18:39  jp_milcent
* Début gestion résultat de la recherche par nom.
*
* Revision 1.1  2005/07/28 15:37:56  jp_milcent
* Début gestion des squelettes et de l'API eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>