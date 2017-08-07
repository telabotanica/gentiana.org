<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of Papyrus.                                                                        |
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
// CVS : $Id: more_recherche.class.php,v 1.12 2007-10-29 18:29:30 jp_milcent Exp $
/**
* Classe permettant d'effectuer des recherches sur les métas informations des menus.
*
* Permet de rechercher et classer les menus en fonction d'une chaine.
*
*@package Applette
*@subpackage Moteur_Recherche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.12 $ $Date: 2007-10-29 18:29:30 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class More_Recherche {
    var $motif = '';
    var $moteurs_recherches = array();
    var $resultats = array();
    
    // Constructeur
    function More_Recherche($motif) {
        $this->setMotif($motif);
    }
    
    // Accesseurs
    function getMotif() {
        return $this->motif;
    }
    function setMotif($motif) {
        $this->motif = $motif;
    }
    function getMoteurs() {
        return $this->moteurs_recherches;
    }
    function getMoteur($id) {
        return $this->moteurs_recherches[$id];
    }
    function setMoteur($val) {
        $id_nouveau = count($this->moteurs_recherches);
        $this->moteurs_recherches[$id_nouveau] = $val;
    }
    function getResultats() {
        return $this->resultats;
    }
    function setResultats($val) {
        $this->resultats = $val;
    }
    function setResultat($aso_page) {
        $id_nouveau = count($this->resultats);
        $this->resultats[$id_nouveau] = $aso_page;
    }
    
    // Méthodes
    
    function ajouterRecherche(&$objet_recherche) {
        return $this->setMoteur($objet_recherche);
    }

    function rechercherMotif() {
        foreach ($this->getMoteurs() as $cle => $val) {
            $this->setResultats(array_merge((array)$this->getResultats(),(array)$val->rechercherMotif($this->getMotif())));
        }
        $aso_resultats = $this->getResultats();
        function comparer($a, $b) {
            if ($a['poids'] > $b['poids']) {
                return -1;
            }
            if ($a['poids'] < $b['poids']) {
                return +1;
            }
            if ($a['poids'] = $b['poids']) {
                return 0;
            }
        }
        usort($aso_resultats, 'comparer');
        $pds_max = 0;
        if (isset($aso_resultats[0]['poids'])) {
            $pds_max = $aso_resultats[0]['poids'];
        }
        for ($i = 0 ; $i < count($aso_resultats) ; $i++) {
            $aso_resultats[$i]['score'] = round((100 / $pds_max) * $aso_resultats[$i]['poids'], 1);
        }
        
        return $aso_resultats;
    }
    
    /** Renvoie le nombre d'occurences total de la présence de chaque mot.
	*
	* @param  string	le motif à rechercher.
	* @param  string	le texte dans lequel effectuer la recherche. 
	* @return integer	le nombre de fois où les mots sont trouvés.
	*/
	function retournerOccurenceMotif($motif, &$texte, $mode = MORE_MODE)
	{
		$nbre_correspondance = 0;
		$nbre_correspondance_total = 0;
		$motif = $this->traiterMotif($motif, 'simple');
		// Si demande de recherche d'expression complète
		if (preg_match('/^".+"$/', $motif)) {
			$mode = 2;
			
		}
		$motif = $this->traiterMotif($motif, 'recherche');
		switch ($mode) {
			case '1' :
				// Découpage en mot
				$tab_motif = explode(' ', $motif);
				break;
			case '2' :
				// La chaine saisie par l'utilisateur est recherchée tel quel
				$tab_motif[] = $motif;
				break;
			default:
				$e = 'Mode pour le moteur de recherche inconnu : '.$mode.
				trigger_error($e, E_USER_ERROR);
		}
		// Nous recherchons chaque mot
		$compteur_mot = 0;
		foreach ($tab_motif as $mot) {
			//$nbre_correspondance += preg_match_all('/'.$mot.'/i', $texte, $tab_morceaux);
			$nbre_correspondance = substr_count(strtolower($texte), strtolower($mot));
			if ($nbre_correspondance > 0) {
				$compteur_mot++;
			}
			$nbre_correspondance_total += $nbre_correspondance; 
		}
		// Si tous les mots recherchés sont présents nous renvoyons le poids de la page.
		if ($compteur_mot == count($tab_motif)) {
			return $nbre_correspondance_total;
		} else {
			return 0;
		}
	}
	
	function traiterMotif($motif, $type = 0)
    {
    	switch ($type) {
			case 'simple' :
				return trim(stripslashes($motif));
				break;
			case 'recherche' :
				if (preg_match('/^"(.+)"$/', $motif, $match)) {
					$motif = $match[1];
				}
				return $motif;
				break;
			case 'url' :
				$motif = trim(stripslashes($motif));
				if (preg_match('/^"(.+)"$/', $motif, $match)) {
					$motif = $match[1];
				}
				return urlencode($motif);
				break;
			default:
				return $motif;
		}
    }
    
    function traduireMois($mois_numerique)
    {
        switch ($mois_numerique) {
            case '01' :
                return 'janvier';              
            case '02' :
                return 'février';              
            case '03' :
                return 'mars';
            case '04' :
                return 'avril';
            case '05' :
                return 'mai';
            case '06' :
                return 'juin';
            case '07' :
                return 'juillet';
            case '08' :
                return 'août';
            case '09' :
                return 'septembre';
            case '10' :
                return 'octobre';
            case '11' :
                return 'novembre';
            case '12' :
                return 'décembre';
            default:
                return '';
        }
    }
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: more_recherche.class.php,v $
* Revision 1.12  2007-10-29 18:29:30  jp_milcent
* Ajout d'un prÃ©fixe devant les classes de l'applette pour Ã©viter les conflits avec d'autres classes provenant des applis clientes.
*
* Revision 1.11  2007-01-02 18:49:22  jp_milcent
* Amélioration de la gestion du motif.
* Ajout de la gestion des expressions complête via l'utilisation de guillemets.
*
* Revision 1.10  2006/12/12 13:54:41  jp_milcent
* Correction bogue : variable non initialisée.
*
* Revision 1.9  2006/10/17 09:21:40  jp_milcent
* Mise en commun des spécifications de la recherche.
*
* Revision 1.8  2006/05/23 14:18:19  jp_milcent
* Ajout de la gestion du mode de recherche au moteur de recherche de Papyrus.
* Soit on recherche chaque mot du motif, soit le motif entier.
*
* Revision 1.7  2006/05/19 10:04:55  jp_milcent
* Ajout d'un moteur de recherche analysant les articles des sites sous Spip.
*
* Revision 1.6  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.5  2005/09/20 17:01:22  ddelon
* php5 et bugs divers
*
* Revision 1.4  2005/05/25 13:49:22  jpm
* Corection erreur pour la recherche dans le contenu.
*
* Revision 1.3  2005/05/19 12:46:12  jpm
* Correction bogue accesskey.
* Ajout d'un id à la liste.
* Arrondissement des score.
*
* Revision 1.2  2005/04/14 17:39:34  jpm
* Amélioration du moteur de rechercher :
*  - pourcentage
*  - ajout d'info
*
* Revision 1.1  2004/12/07 10:24:06  jpm
* Moteur de recherche version de départ.
*
* 
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>