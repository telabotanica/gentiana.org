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
// CVS : $Id: GestionnaireErreur.class.php,v 1.9 2007-08-08 17:25:34 jp_milcent Exp $
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
*@version       $Revision: 1.9 $ $Date: 2007-08-08 17:25:34 $
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
	private $mode;

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
	
	/**
	 * Contient la méthode de débogage à employer : TXT, HTML, FIREBUG
	 * @access private
	 */
	private $debogage_methode = 'HTML';
	
	/**
	 * Indique si oui ou non on veut limiter l'affichage du débogage à une liste d'IP
	 * @access private
	 */
	private $debogage_ip = true;
	
	/**
	 * Contient la liste d'ip pour laquelle nous autorisons l'affichage du débogage.
	 * @access private
	 */
	private $debogage_ip_liste = array('127.0.0.1' => true);
	
	/*** Constructeur: ***/
	
	/**
	 * Construit le gestionnaire d'erreur.
	 *
	 * @return void
	 * @access public
	 */
	public function __construct( $contexte = false )
	{
		$this->mode = php_sapi_name();
		if ($this->mode == 'cli') {
			$this->setDebogageMethode('TXT');
		}
		$this->erreurs = array();
		$this->setContexte($contexte);
		set_error_handler(array(&$this, 'gererErreur'));
	}
	
	/*** Accesseurs: ***/
	 // end of member function __construct
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
	public function setActive($niveau) {
		$this->niveau_erreur_courrant = $niveau;
	}
	
	/**
	 * Définit la méthode de débogage
	 *
	 * @param string 
	 * @return void
	 * @access public
	 */
	public function setDebogageMethode($methode) {
		 
		 if (!preg_match('/^(?:FIREBUG|HTML|TXT)$/', $methode)) {
		 		trigger_error('Méthode de débogage inconnue : '.$methode, E_USER_WARNING);
		 		return false;
		 }
		 $this->debogage_methode = $methode;
	}
	
	/**
	 * Définit si oui ou non on veut limiter le débogage à une liste d'IP.
	 *
	 * @param bool true pour oui, false pour non
	 * @return void
	 * @access public
	 */
	public function setDebogageIp($bool) {
	 	$this->debogage_ip = $bool;
	}
		
	/**
	 * Définit la liste d'ip pour laquelle on peut afficher le débogage
	 *
	 * @param string liste d'ip séparée par des virgules
	 * @return void
	 * @access public
	 */
	public function setDebogageIpListe($liste) {
		 $tab_ip = explode(',', $liste);
		 foreach ($tab_ip as $ip) {
		 	$this->debogage_ip_liste[trim($ip)] = true;
		 }
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
	public function gererErreur($niveau,  $message,  $fichier,  $ligne,  $contexte)
	{
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
	}

	/**
	 * Retourne l'erreur PHP formatée en XHTML.
	 *
	 * @return string
	 * @access public
	 */
	public function retournerErreur()
	{
		$contenu = '';
		$erreur_pear_nbre = 0;
		$erreur_pear_fichier_nbre = 0;
		$erreur_pear_message_nbre = 0;
		foreach($this->getErreur() as $aso_erreur) {
			if ('<!-- BEGIN sql -->' == substr($aso_erreur['message'], 0, 18)) {
				$contenu .= $aso_erreur['message'];
				continue;
			}
			// Nous testons les erreurs PEAR pour ne pas en tenir compte
			if (!EF_DEBOGAGE_PEAR && preg_match(EF_DEBOGAGE_PEAR_REGEXP_FICHIER, $aso_erreur['fichier'])) {
				$erreur_pear_fichier_nbre++;
			} else if (!EF_DEBOGAGE_PEAR && preg_match(EF_DEBOGAGE_PEAR_REGEXP_MESSAGE, $aso_erreur['message'])) {
				$erreur_pear_message_nbre++;
			} else {
				switch ($this->debogage_methode) {
					case 'TXT' :
						if ($aso_erreur['niveau'] == E_USER_NOTICE) {
							$contenu .= $aso_erreur['message']."\n";
							$contenu .= 'Fichier : '.$aso_erreur['fichier']."\n";
							$contenu .= 'Ligne : '.$aso_erreur['ligne']."\n";						
						} else if ($aso_erreur['niveau'] <= 512) {
							$contenu .= 'INFO : Niveau '.$aso_erreur['niveau']."\n";
						} else {
							$contenu .= 'ERREUR : Niveau '.$aso_erreur['niveau']."\n";
						}
						$contenu .= 'Niveau : '.$aso_erreur['niveau']."\n";
						$contenu .= 'Message : '.$aso_erreur['message']."\n";
						$contenu .= 'Fichier : '.$aso_erreur['fichier']."\n";
						$contenu .= 'Ligne : '.$aso_erreur['ligne']."\n";
						if ($this->getContexte()) {
							$contenu .= 'Contexte : '."\n".print_r($aso_erreur['contexte'], true)."\n";
						}
						break;
					case 'FIREBUG' :
					    $contenu .= 'console.info("[Buggy] - '.
							'Niveau : '.$aso_erreur['niveau'].' - '.
							'Fichier : '.$aso_erreur['fichier'].' - '.
							'Ligne : '.$aso_erreur['ligne'].' - '.
							'Message : '.str_replace('"', '\"', $aso_erreur['message']).'");'."\n";
						break;
					case 'HTML' :
						if ($aso_erreur['niveau'] == E_USER_NOTICE) {
							$contenu .= '<pre class="debogage">'."\n";
							$contenu .= htmlentities($aso_erreur['message'])."\n";
							$contenu .= '<span class="debogage_fichier">'.'Fichier : '.$aso_erreur['fichier'].'</span>'."\n";
							$contenu .= '<span class="debogage_ligne">'.'Ligne : '.$aso_erreur['ligne'].'</span>'."\n";
							$contenu .= '</pre>'."\n";
							continue;
						} else if ($aso_erreur['niveau'] <= 512) {
							$contenu .= '<p class="information">'."\n";
							$contenu .= '<strong>INFO : Niveau '.$aso_erreur['niveau'].'</strong><br />'."\n";
						} else {
							$contenu .= '<p class="attention">'."\n";
							$contenu .= '<strong>ERREUR : Niveau '.$aso_erreur['niveau'].'</strong><br />'."\n";
						}
						$contenu .= '<strong>Niveau : </strong>'.$aso_erreur['niveau'].'<br />'."\n";
						$contenu .= '<strong>Message : </strong>'.$aso_erreur['message'].'<br />'."\n";
						$contenu .= '<strong>Fichier : </strong>'.$aso_erreur['fichier'].'<br />'."\n";
						$contenu .= '<strong>Ligne : </strong>'.$aso_erreur['ligne'].'<br />'."\n";
						if ($this->getContexte()) {
							$contenu .= '<pre>'."\n";
							$contenu .= '<stong>Contexte : </stong>'."\n".print_r($aso_erreur['contexte'], true)."\n";
							$contenu .= '</pre>'."\n";
						}
						$contenu .= '</p>'."\n";
						break;
				}
			}
		}
		$erreur_pear_nbre = $erreur_pear_fichier_nbre + $erreur_pear_message_nbre;
		if ($erreur_pear_nbre != 0) {
			switch ($this->debogage_methode) {
				case 'TXT' :
					$contenu .= 'Nombre d\'erreurs PEAR totales : '.$erreur_pear_nbre."\n".
						' - éliminées car le "fichier" correspondé à '.EF_DEBOGAGE_PEAR_REGEXP_FICHIER.' : '.$erreur_pear_fichier_nbre."\n".
						' - éliminées car le "message" correspondé à '.EF_DEBOGAGE_PEAR_REGEXP_MESSAGE.' : '.$erreur_pear_message_nbre."\n";
					break;
				case 'FIREBUG' :
				    $contenu .=	'console.info("[Buggy] - '.
						'Nombre d\'erreurs PEAR totales : '.$erreur_pear_nbre.' - '.
						'éliminées car le fichier correspondé à  '.str_replace('"', '\"', EF_DEBOGAGE_PEAR_REGEXP_FICHIER).' : '.$erreur_pear_fichier_nbre.' - '.
						'éliminées car le message correspondé à  '.str_replace('"', '\"', EF_DEBOGAGE_PEAR_REGEXP_MESSAGE).' : '.$erreur_pear_message_nbre.'.'.
						'");'."\n";
					break;
				case 'HTML' :
					$contenu .= '<p class="attention">'.
						'<strong>Nombre d\'erreurs PEAR totales : </strong>'.$erreur_pear_nbre.'<br />'."\n".
						'<strong> - éliminées car le "fichier" correspondé à '.EF_DEBOGAGE_PEAR_REGEXP_FICHIER.' : </strong>'.$erreur_pear_fichier_nbre.'<br />'."\n".
						'<strong> - éliminées car le "message" correspondé à '.EF_DEBOGAGE_PEAR_REGEXP_MESSAGE.' : </strong>'.$erreur_pear_message_nbre.'<br />'."\n".
						'</p>'."\n";
					break;
			}
		}

		// Affichage dépendant de la méthode de débogage.
		$retour = '';
		switch ($this->debogage_methode) {
        	case 'FIREBUG':
        		$retour = '<script type="text/javascript">'."\n".$contenu.'</script>'."\n";
				break;
        	case 'HTML':
        		$retour = $contenu;
        	case 'TXT':
        		$retour = $contenu;
        	default:
            	// On ne fait rien...
		}
		
		// Test du débogage en fonction des IP
		if ($this->debogage_ip == false || ($this->debogage_ip == true && isset($this->debogage_ip_liste[$_SERVER['REMOTE_ADDR']]))) {
			return $retour;
		} else {
			return false;
		}
	}

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
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: GestionnaireErreur.class.php,v $
* Revision 1.9  2007-08-08 17:25:34  jp_milcent
* Ajout de l'affiche dans Firebug et de la limitation du débogage à certaines IP.
*
* Revision 1.8  2007-08-05 09:11:37  jp_milcent
* Remplacement d'une constante oubliée pour l'expression régulière des chemins des fichiers PEAR.
*
* Revision 1.7  2007-08-05 09:10:10  jp_milcent
* Utilisation d'une expression régulière pour les chemins des fichiers PEAR.
*
* Revision 1.6  2007-07-09 18:54:43  jp_milcent
* Remplacement des balises html par des entités pour le message des E_USER_NOTICE.
*
* Revision 1.5  2007-07-02 15:31:53  jp_milcent
* Initialisation d'une variable.
*
* Revision 1.4  2007-07-02 12:43:09  jp_milcent
* Gestion de php-cli ou cgi...
*
* Revision 1.3  2007-07-02 10:50:06  jp_milcent
* Ajout de la gestion du mode d'affichage (xhtml ou txt).
*
* Revision 1.2  2007-01-15 15:30:03  jp_milcent
* Amélioration du gestionnaire d'erreur pour qu'il prenne en compte les erreurs Pear des méthodes "non static"...
*
* Revision 1.1  2007/01/12 13:16:09  jp_milcent
* Déplacement des classes de débogage et d'optimisation dans le dossier noyau.
*
* Revision 1.9  2006/10/25 08:15:23  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.8.2.1  2006/08/29 09:22:37  jp_milcent
* Correction et amélioration du gestionnaire d'erreurs.
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