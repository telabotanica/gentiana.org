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
// CVS : $Id: RecueilDeDonnees.class.php,v 1.11 2007-10-05 10:23:15 jp_milcent Exp $
/**
* eflore_bp - ReccueilDeDonnee.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.11 $ $Date: 2007-10-05 10:23:15 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class RecueilDeDonnees extends aModule {
	
	public static function getAppletteBalise()
	{
		return '\{\{RecueilDeDonnees(?:\s*(?:(action="[^"]+")|))+\s*\}\}';
	}
	
	// La méthode executer est appellé par défaut
	public function executer()
	{ 
		$this->poursuivreVers('formulaire');
	}
	
	public function executerFormulaire()
	{
		// Initialisation des variables
		$this->setChrono('debut');
		$aso_donnees = $this->getRegistre()->get('squelette_donnees');
		$a = $GLOBALS['_EFLORE_']['identification'];
		
		// Gestion de l'url de l'envoie de mail
		$url = clone $GLOBALS['_EFLORE_']['url_base'];
		$url->addQueryString('module', 'recueil_de_donnees');

		if ($a->getIdentite()) {
			$url->addQueryString('action', 'aiguilleur');
			$aso_donnees['url'] = $url->getUrl();
			$aso_donnees['rcd_prenom_nom'] = $a->getPrenomNom();
			$aso_donnees['rcd_courriel'] = $a->getCourriel();

			// Récupération des noms de communes de l'Isère pour l'instant
			$ZoneGeographique = new EfloreZoneGeographique();
			$zones = $ZoneGeographique->consulterZgParCode(EfloreZoneGeographique::INSEE_C, '38%');
			foreach ($zones as $zone) {
				$aso_donnees['communes'][$zone['ezg']['code']] = $zone['ezg']['intitule_principal'];
			}
			
			// Gestion de la sérialisation du formulaire suite à l'envoie dans le formulaire Google Map
			if (isset($_GET['form_serialize'])) {
				$_POST = unserialize(urldecode($_GET['form_serialize']));
				if (isset($_GET['form_coordonnee_valider'])) {
					$_POST['rcd_fuseau'] = $_GET['utm_zone'];
					$_POST['rcd_coord_x'] = sprintf('%07d', $_GET['utm_est']);
					$_POST['rcd_coord_y'] = $_GET['utm_nord'];
				}
			}
			
			// Gestion du message d'information ou d'erreur suite à l'envoie du courriel
			$aso_donnees['messages'] = false;
			$aso_donnees['attentions'] = false;
			if ($this->getRegistre()->get('sortie_mail_smtp_info') === true) {
				$aso_donnees['messages'][] = 'Votre observation a bien été envoyée!';
			} else if ($this->getRegistre()->get('sortie_mail_smtp_info') != null) {
				$aso_donnees['attentions'] = $this->getRegistre()->get('sortie_mail_smtp_info')->getMessage();
			}

			// Gestion des messages de vérification du formulaire
			if (!isset($aso_donnees['verifications'])) {
				$aso_donnees['verifications'] = false;
			}
			
		} else {
			$this->getRegistre()->set('squelette_fichier', 'identification');
			$url->addQueryString('action', 'formulaire');
			$aso_donnees['url'] = $url->getUrl();
		}		
		// Attribution des données pour remplir le squelette
		$this->getRegistre()->set('squelette_donnees', $aso_donnees);
		$this->setChrono('fin');
	}
	
	public function executerAiguilleur()
	{
		// Aiguillage en fonction de l'id du bouton submit
		//$this->setDebogage($_GET);
		if (isset($_POST['rcd_submit_verifier'])) {
			$this->poursuivreVers('verifier_donnees');
		} else if (isset($_POST['rcd_submit_googlemap'])) {
			$url = clone $GLOBALS['_EFLORE_']['url_base'];
			$url->addQueryString('module', 'recueil_de_donnees');
			$this->getRegistre()->set('gm_url_retour', $url);
			$this->getRegistre()->set('gm_form_serialize', urlencode(serialize($this->manipulerSpecialChars($_POST, false))));
			$this->getRegistre()->set('gm_cle', $GLOBALS['_RDD_']['gg_cles']);
			$this->poursuivreVers('google_map', 'Communs');
		}
	}
	
	public function executerVerifierDonnees()
	{
		// Initialisation des variables
		$this->getRegistre()->set('squelette_moteur', aModule::TPL_NULL);
		$this->getRegistre()->set('format', aModule::SORTIE_NULL);
		$messages = array();
		
		// Vérification des champs vides
		if ($_POST['rcd_nom_latin'] == '') {
			$messages[] = "Vous n'avez pas mentionné de nom latin.";
		}
		if ($_POST['rcd_date'] == '') {
			$messages[] = "Vous n'avez pas indiqué la date de l'observation.";
		} else {
			if (!preg_match('/^\d{2}\/\d{2}\/\d{2}$/', $_POST['rcd_date'])) {
				$messages[] = 'La date doit être de la forme : jj/mm/aa';
			}
		}
		if ($_POST['rcd_commune'] == '') {
			$messages[] = "Vous n'avez pas sélectionné une commune.";
		}
		if ($_POST['rcd_commentaire'] == '') {
			$messages[] = "Vous n'avez pas indiqué la localisation précise.";
		}
		
		// Autres vérifications
		if ($_POST['rcd_coord_x'] != '' && !preg_match('/^\d{7}$/', $_POST['rcd_coord_x'])) {
			$messages[] = 'La longitude doit être un nombre à 7 chiffres';
		}
		if ($_POST['rcd_coord_x'] == '') {
			$messages[] = "Vous n'avez pas indiqué la longitude.";
		}
		if ($_POST['rcd_coord_y'] != '' && !preg_match('/^\d{7}$/', $_POST['rcd_coord_y'])) {
			$messages[] = 'La latitude doit être un nombre à 7 chiffres';
		}
		if ($_POST['rcd_coord_y'] == '') {
			$messages[] = "Vous n'avez pas indiqué la latitude.";
		}
		
		// Suivant les résultats de la vérification, nous envoyons le mail ou nous revenons au formulaire
		if (count($messages) > 0) {
			$this->getRegistre()->set('squelette_donnees', array('verifications' => $messages));
			$this->poursuivreVers('formulaire');		
		} else {
			$this->poursuivreVers('envoi_mail');
		}

	}
	
	public function executerEnvoiMail()
	{
		// Initialisation des variables
		$this->setChrono('debut');
		$asso_donnees = array();
		$this->getRegistre()->set('squelette_moteur', aModule::TPL_PHP_MAIL);
		$this->getRegistre()->set('format', aModule::SORTIE_MAIL_SMTP);
		
		// Récupération des infos pour conpléter le squelette du courriel
		$_POST = $this->manipulerSpecialChars($_POST);
		$asso_donnees['prenom_nom'] = $_POST['rcd_prenom_nom'];
		unset($_POST['rcd_prenom_nom']);
		unset($_POST['rcd_submit_verifier']);// suppression des infos du bouton de validation du formulaire...
		$asso_donnees['post'] = $_POST;
		$_POST = $this->manipulerSpecialChars($_POST, false);
		
		// Ajout des informations nécessaire à la sortie pour l'envoi du courriel
		$entetes['From']    = RDD_MAIL_DE;
		$entetes['To']      = RDD_MAIL_A;
		$entetes['Subject'] = RDD_MAIL_SUJET;
		$this->getRegistre()->set('sortie_mail_smtp_params', array('host' => RDD_SMTP_HOTE));
		$this->getRegistre()->set('sortie_mail_smtp_destinataire', RDD_MAIL_A);
		$this->getRegistre()->set('sortie_mail_smtp_entete', $entetes);
		
		// Attribution des données pour remplir le squelette
		$this->getRegistre()->set('squelette_donnees', $asso_donnees);
		$this->setChrono('fin');

		// Nous ajoutons une action à éxecuter avant de rendre la main
		$this->poursuivreVers('formulaire');
	}
	
	private function manipulerSpecialChars($vals, $supprimer = true)
	{
	    if (is_array($vals)) {
	        foreach ($vals as $key=>$val) {
	            $vals[$key] = $this->manipulerSpecialChars($val, $supprimer);
	        }
	    } else {
	        if ($supprimer) {
	        	$vals = htmlspecialchars_decode(stripslashes($vals), ENT_QUOTES);
	        } else {
	        	$vals = htmlspecialchars(stripslashes($vals), ENT_QUOTES);
	        }
	    }
	    return $vals;
	} 
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: RecueilDeDonnees.class.php,v $
* Revision 1.11  2007-10-05 10:23:15  jp_milcent
* Amélioration de la gestion de l'annulation du formulaire Google Map.
*
* Revision 1.10  2007-10-05 10:19:12  jp_milcent
* Gestion de l'annulation du formulaire Google Map.
*
* Revision 1.9  2007-10-05 09:44:43  jp_milcent
* Utilisation d'un tableau pour gérer les clés GoogleMap.
*
* Revision 1.8  2007-10-04 17:50:02  jp_milcent
* Corrections bogues.
*
* Revision 1.7  2007-10-04 16:58:56  jp_milcent
* Ajout d'une constante permettant de gérer le formulaire GoogleMap.
*
* Revision 1.6  2007-10-04 16:44:55  jp_milcent
* Gestion de la recherche de coordonnées via l'action des Communs : GoogleMap.
*
* Revision 1.5  2007-07-25 17:45:19  jp_milcent
* Corrections des champs obligatoires.
*
* Revision 1.4  2007-07-24 14:31:57  jp_milcent
* Ajout dans les fichiers de configuration de l'hôte smtp.
*
* Revision 1.3  2007-07-11 13:11:06  jp_milcent
* Ajout de la vérification des donnés du formulaire côté serveur.
*
* Revision 1.2  2007-07-10 16:47:30  jp_milcent
* Ajout de l'identification et améliorations diverses.
*
* Revision 1.1  2007-07-09 19:29:26  jp_milcent
* Ajout du module Recueil de données
*
* Revision 1.1  2007-07-09 15:45:59  jp_milcent
* Début ajout du module de Reccueil de Données.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
