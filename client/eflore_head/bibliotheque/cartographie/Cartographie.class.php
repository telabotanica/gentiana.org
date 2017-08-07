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
// CVS : $Id: Cartographie.class.php,v 1.7 2007-07-06 18:50:41 jp_milcent Exp $
/**
* eflore_bp - Cartographie.php
*
* Classe de Cartographie g�rant les images repr�sentant le fond de carte en vraies couleurs 
* (16 millions de zones maxi sur la carte) ou en couleurs index�es (255 zones maxi sur la carte).
* Les couleurs r�serv�es et a ne pas utiliser pour cr�er l'image png de fond sont : 
* - le blanc (rvb : 255-255-255)
* - le noir (rvb : 0-0-0)
* - le gris (rvb : 128-128-128)
* - le rouge (rvb : 255-0-0)
* Pour activer le cache indiquer la date de derni�re mise � jour des donn�es servant � cr�er la carte de cette fa�on :
* $Carte->setCarteInfo(array('donnees_date_maj' => $date_maj_donnees));
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.7 $ $Date: 2007-07-06 18:50:41 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class Cartographie {
	/*** Attributs : ***/
	/**
	* L'image de la carte.
	* @var string l'image de la carte.
	*/
	private $carte;
	/**
	* Le nom du fichier contenant la carte.
	* @var string le nom du fichier de la carte.
	*/
	private $carte_nom;
	/**
	* Tableaux associatif contenant les informations sur la carte.
	* donnees_date_maj = date de derni�re mise � jour des donn�es servant � cr�er la carte, si plus r�cente que la carte 
	* d�j� cr��e getCarteCache renvoie false.
	* 
	* @var array le tableau des infos sur la carte.
	*/
	private $carte_info = array();

	
	/**
	* Indique si la carte existe d�j� et � besoin ou pas d'�tre cr��e.
	* @var bool true si la carte existe..
	*/
	private $carte_cache = false;
	/**
	* Le nom du fichier de la carte de fond.
	* @var string nom du fichier de la carte de fond.
	*/
	private $carte_fond_fichier;
	/**
	* Le nom du dossier contenant les cartes de fond.
	* @var string nom du dossier contenant les cartes de fond.
	*/
	private $carte_fond_dossier;
	/**
	* Le nom du dossier o� stocker les cartes cr�er via la classe Cartographie.
	* @var string nom du dossier contenant les cartes cr��es.
	*/
	private $carte_stockage_dossier;

	/**
	* Format du tableau :
	* carte_zone_info est un tableau de tableaux associatifs.
	* Chaque zone de la carte doit avoir son entr�e dans ce tableau. Chaque zone est repr�sent�e par :
	* - nom : (string)
	* 	le nom de la zone.
	* - index : (int) 
	* 	l'index de la couleur dans la palette si on a � faire � une image index�e (moins de 255 zones sur la carte)
	* - rvb_fond : (string) Exemple : 255-255-255. 
	* 	les valeurs entre 0 et 255 s�par�es par des tirets (-) de la couleur de la zone sur la carte de fond
	* 	Ne pas utiliser le blanc (255-255-255) et utiliser le noir pour les contours(0-0-0).
	* - rvb_carte : (string) Exemple : 255-255-255.
	* 	les valeurs entre 0 et 255 s�par�es par des tirets (-) de la couleur de remplacement
	* - nombre : (int) Exemple : nombre de personnes pr�sentent dans un d�partement.
	* 	nombre d'occurence dans cette zone.
	* @var array les informations sur les zones de la carte.
	*/
	private $carte_zone_info = array();
	/**
	* Tableau contenant la valeur RVB de la zone du fond de carte en cl� et la valeur RVB venant la remplacer en valeur.
	* @var array valeur RVB de la zone du fond de carte en cl� et valeur RVB venant la remplacer en valeur.
	*/
	private $carte_correspondance_couleurs = array();
	/**
	* La valeur RVB, sous forme de chaine de nombres s�par�es par des tirets (-), de la zone g�ographique � mettre en
	* surbrillance.
	* @var string la valeur RVB de la zone � rep�rer.
	*/
	private $zone_marker;
	/**
	* La formule de coloriage de la carte. Les formules disponibles sont : l�gende, proportionnel.
	* @var string la formule de coloriage.
	*/
	private $formule_coloriage;
	/**
	* Les valeurs RVB s�par�s par des virgules pour la couleur la plus fonc�e utilis�e, entre autre, par la formule de 
	* coloriage "proportionnel".
	* @var string les valeurs RVB s�par�es par des virgules.
	*/
	private $coloriage_couleur_max;
	
	/**
	* Les valeurs RVB s�par�s par des virgules pour la couleur la plus claire utilis�e, entre autre, par la formule de 
	* coloriage "proportionnel".
	* @var string les valeurs RVB s�par�es par des virgules.
	*/
	private $coloriage_couleur_min;

	/**
	* Contient le nombre de couleurs diff�rentes utilis�es par le coloriage pour cr�er l'image finale.
	* @var int le nombre de couleurs.
	*/
	private $coloriage_couleurs;
	
	/**
	* Contient le tableau des fr�quences et des couleurs correspondantes.
	* @var array les frequences et leurs couleurs.
	*/
	private $coloriage_tableau_frequence = array();
	
	/*** Constructeur : ***/
	public function __construct() 
	{
		// Initialisation de l'objet Cartographie
		$this->setFormuleColoriage('');
		$this->setCarteFondFichier('');
		$this->setCarteFondDossier('');
		$this->setCarteStockageDossier('');
		$this->setCarteZoneInfo(array());
		$this->setZoneMarker('');
	}
	
	/*** Accesseur : ***/
	public function getTableauFrequence()
	{
		ksort($this->coloriage_tableau_frequence);
		return $this->coloriage_tableau_frequence;
	}
	
	public function getCarteCache()
	{
		// Gestion du cache
		if ($this->carte_nom != '') {
    		$fichier_carte = $this->carte_stockage_dossier.$this->carte_nom;
    		if (file_exists($fichier_carte)) {
				//echo filemtime($fichier_carte).'-'.strtotime($this->carte_info['donnees_date_maj']);
				if (filemtime($fichier_carte) < strtotime($this->carte_info['donnees_date_maj'])) {
					$this->carte_cache = false;
				} else {
					$this->carte_cache = true;
				}
    		}
		}
		return $this->carte_cache;
	}
	
	public function setCarteInfo($ci)
	{
		$this->carte_info = $ci;
	}
	
	public function setColoriageCouleurClaire($ccmi)
	{
		$this->coloriage_couleur_min = $ccmi;
	}
	
	public function setColoriageCouleurFoncee($ccma)
	{
		$this->coloriage_couleur_max = $ccma;
	}
	
	public function setFormuleColoriage($fc)
	{
		$this->formule_coloriage = $fc;
	}
	
	public function setCarteNom($cn)
	{
		$this->carte_nom = $cn;
	}
	
	public function setCarteFondFichier($cff)
	{
		$this->carte_fond_fichier = $cff;
	}
	
	public function setCarteFondDossier($cfd)
	{
		$this->carte_fond_dossier = $cfd;
	}
	
	public function setCarteStockageDossier($csd)
	{
		$this->carte_stockage_dossier = $csd;
	}
	
	public function setCarteZoneInfo($czi)
	{
		$this->carte_zone_info = $czi;
	}
	
	public function setZoneMarker($zm)
	{
		$this->zone_marker = $zm;
	}
	
	/*** M�thodes PUBLIQUES : ***/
	
	public function creerCarte($fichier_carte_nom = '') 
	{
		// Gestion du nom de la carte
		if ($fichier_carte_nom == '') {
			if ($this->carte_nom != '') {
				$fichier_carte_nom = $this->carte_nom;
			}
		} else {
			$this->carte_nom = $fichier_carte_nom;
		}

		// Cr�ation de la carte car aucun cache ou cache � vider
		$carte_fond_fichier = $this->carte_fond_dossier.$this->carte_fond_fichier;
		$this->carte = imagecreatefrompng($carte_fond_fichier);
		// V�rification que la cr�ation � fonctionn�e
		if (!$this->carte) { 
			// Une erreur est survenue : cr�ation d'une image blanche
			$this->carte = imagecreatetruecolor(520, 60);
			$bgc = imagecolorallocate($this->carte, 255, 255, 255);
			$tc  = imagecolorallocate($this->carte, 0, 0, 0);
			imagefilledrectangle($this->carte, 0, 0, 520, 60, $bgc);
			// Affichage d'un message d'erreur
			imagestring($this->carte, 1, 5, 5, "Erreur de chargement de l'image :", $tc);
			imagestring($this->carte, 1, 5, 15, $carte_fond_fichier, $tc);
		} else {
			// Nous construison le tableau de correspondance entre les couleurs pr�sente sur l'image de fond
			// et les couleurs qui doivent les remplacer.
			$this->construireCorrespondanceCouleur();
			
			// Nous lan�ons la cr�ation de la carte
			$this->colorierCarte();
		}

		// Nous chercons � cr�er une image ind�x�es en sortie
		if (imageistruecolor(&$this->carte) && $this->formule_coloriage != 'legende') {
			if ($this->coloriage_couleurs <= 253) {
				//imagetruecolortopalette(&$this->carte, false, ($this->coloriage_couleurs + 2));// + 2 car noir et blanc r�serv�s.
			} else {
				// On force la cr�ation d'une palette... si cela pose probl�me ajouter un attribut permettant de d�sactiver 
				// ce fonctionnement.
				imagetruecolortopalette(&$this->carte, false, 255);
			}
		}
		
		// Nous �crivons le fichier de la carte.
		if ($fichier_carte_nom != '') {
    		$fichier_carte = $this->carte_stockage_dossier.$fichier_carte_nom;
    		imagepng(&$this->carte, $fichier_carte);
    		return true;
		} else {
			$fichier_carte = $this->carte_stockage_dossier.md5($this->carte).'_'.$this->carte_fond_fichier;
			imagepng(&$this->carte, $fichier_carte);
			return true;
		}
	}
	
	/*** M�thodes PRIV�ES : ***/
	private function construireCorrespondanceCouleur()
	{
		switch ($this->formule_coloriage) {
			case 'legende' :
				$this->construireCorrespondanceCouleurLegende();
				break;
			case 'proportionnel' :
				$this->construireCorrespondanceCouleurProportionnel();
				break;
			default :
				$e = "Aucune formule de coloriage n'a �t� d�finie parmis : legende. Veuillez la d�finir avec la m�thode ".
					 "setFormuleColoriage().";
				trigger_error($e, E_USER_ERROR);
		}
	}
	
	private function construireCorrespondanceCouleurProportionnel()
	{
		// Cr�ation d'un tableau contenant seulement les nombres d'information pour chaque zone.
		$tab_valeurs = array();
		foreach ($this->carte_zone_info as $cle => $valeur) {
			//Nous recherchons le minimum, le maximum et le la valeur m�dium juste au dessous du maximum.
			if (isset($valeur['info_nombre'])) {
				$tab_valeurs[] = $valeur['info_nombre'];
				if ($valeur['info_nombre'] == 0){
					//trigger_error($valeur['nom'], E_USER_NOTICE);
				}
			}
		}
		
		//Nombre d'entr�es dans le tableau de valeurs non nulles :
		$valeurs_nbre = count($tab_valeurs);
		$valeurs_somme = array_sum($tab_valeurs);
		// Tabeau des fr�quences tri� de la plus petite � la plus grande cl�.
		$tab_frequences = array_count_values($tab_valeurs);
		krsort($tab_frequences);
		//trigger_error(print_r($tab_frequences, true), E_USER_NOTICE);
		$frequences_nbre = count($tab_frequences);
		if ($valeurs_nbre > 0){
			// Nous trions le tableau dans l'ordre croissant :
			sort($tab_valeurs);
			// Nous r�cup�rons la valeur la plus petite :
			$mini = $tab_valeurs[0];
			$maxi = $tab_valeurs[$valeurs_nbre - 1];
			$medium = isset($tab_valeurs[$valeurs_nbre - 2]) ? $tab_valeurs[$valeurs_nbre - 2] : 0;
			$moyenne = $valeurs_somme / $valeurs_nbre;
			$ecart_au_carre_moyen = 0;
			for ($i = 0; $i < $valeurs_nbre; $i++) {
				$ecart_au_carre_moyen += pow(($tab_valeurs[$i] - $moyenne), 2);
			}
			$variance = $ecart_au_carre_moyen / $valeurs_nbre;
			$ecart_type = round(sqrt($variance), 0);
			$moyenne = round($moyenne, 0);
			$variance = round($variance, 0);
		}
		
		// Calcul de l'�cart moyen pour chaque �l�ment R, V et B.		
		list($r_min, $v_min, $b_min) = explode(',', $this->coloriage_couleur_max);
		list($r_max, $v_max, $b_max) = explode(',', $this->coloriage_couleur_min);
		$r_diff = $r_min - $r_max;
		$r_ecart_moyen = abs($r_diff / $frequences_nbre);
		
		$v_diff = $v_min - $v_max;
		$v_ecart_moyen = abs($v_diff / $frequences_nbre);
		
		$b_diff = $b_min - $b_max;
		$b_ecart_moyen = abs($b_diff / $frequences_nbre);
		
		// Pour chaque fr�quence nous attribuons une couleur.
		$i = 1;
		foreach ($tab_frequences as $cle => $valeur){
			if ($cle == 0) {
				$this->coloriage_tableau_frequence[$cle] = '255-255-255';
			} else {
				$r = $r_min + round(($i * $r_ecart_moyen), 0);
				
				$v = $v_min + round(($i * $v_ecart_moyen), 0);
				$b = $b_min + round(($i * $b_ecart_moyen), 0);
				$this->coloriage_tableau_frequence[$cle] = $r.'-'.$v.'-'.$b;
			}
			$i++;
		}
		
		// Attribution du nombre de couleurs utilis� pour r�aliser la carte
		$this->coloriage_couleurs = count(array_count_values($this->coloriage_tableau_frequence));
		//trigger_error('<pre>'.print_r($this->coloriage_couleurs, true).'</pre>', E_USER_ERROR);
		
		// Nous attribuons les couleurs � chaque zone g�ographique
		foreach ($this->carte_zone_info as $cle => $zg) {
			if (isset($this->coloriage_tableau_frequence[$zg['info_nombre']])) {
				$this->carte_correspondance_couleurs[$zg['rvb_fond']] = $this->coloriage_tableau_frequence[$zg['info_nombre']];
			} else {
				$e = "La zone ".$zg['nom']." (".$zg['rvb_fond'].") ne poss�de pas de couleur RVB pour la remplir. ".
					 "La valeur 128-128-128 lui a �t� attribu�.";
				trigger_error($e, E_USER_WARNING);
				$this->carte_correspondance_couleurs[$zg['rvb_fond']] = '128-128-128';
			}
		}
	}
	
	private function construireCorrespondanceCouleurLegende()
	{
		$tab_couleurs = array();
		foreach ($this->carte_zone_info as $cle => $zg) {
			if ($zg['rvb_carte'] != '') {
				$this->carte_correspondance_couleurs[$zg['rvb_fond']] = $zg['rvb_carte'];
			} else {
				$e = "La zone ".$zg['nom']." (".$zg['rvb_fond'].") ne poss�de pas d'information pour la l�gende dans le champ".
					 " rvb_carte. La valeur 128-128-128 lui a �t� attribu�.";
				trigger_error($e, E_USER_WARNING);
				$this->carte_correspondance_couleurs[$zg['rvb_fond']] = '128-128-128';
			}
			if (!isset($tab_couleurs[$this->carte_correspondance_couleurs[$zg['rvb_fond']]])) {
				$tab_couleurs[$this->carte_correspondance_couleurs[$zg['rvb_fond']]] = 1;
			}
		}
		// Attribution du nombre de couleurs utilis� pour r�aliser la carte
		$this->coloriage_couleurs = count($tab_couleurs);
	}
    
	private function colorierCarte()
	{
        if (imageistruecolor(&$this->carte)) {
			//+--------------------------------------------------------------------------------------------------------+
	        // Remplacement des couleurs sur la carte en mode vraies couleurs (RGB)
			
			// Nous commen�ons le rempalcement des couleurs sur la carte de fond.  
	        $hauteur = imagesy(&$this->carte);
	    	$largeur = imagesx(&$this->carte);
			
			// Tableau contenant les couleurs trait�es, pour �viter de traiter plusieurs fois la m�me couleur	    	
	    	$tab_rvb_ok = array();
	    	for ($x = 0; $x < $largeur; $x++) {
	    		for ($y = 0; $y < $hauteur; $y++) {
	    			$rvb = ImageColorAt(&$this->carte, $x, $y);
	    			if (!isset($tab_rvb_ok[$rvb])) {
		       			// R�cup�ration de la couleur rvb au format xxx-xxx-xxx
		       			$cle = (($rvb >> 16) & 0xFF).'-'.(($rvb >> 8) & 0xFF).'-'.($rvb & 0xFF);
		       			// Si nous n'avons pas � faire � la couleur noire (utilis� pour d�limit� les zones), nous continuons
		       			if ($cle != '255-255-255') {
			       			$rvb_final = null;
			       			if (isset($this->carte_correspondance_couleurs[$cle])) {
			       				if ($this->zone_marker!= '' && $cle == $this->zone_marker) {
		                    		$rvb_final = '255'<<16 | '0'<<8 | '0';
		                		} else {
			       					list($rouge, $vert, $bleu) = explode('-', $this->carte_correspondance_couleurs[$cle]);
			       					$rvb_final = $rouge<<16 | $vert<<8 | $bleu;
			       				}
			       				// Si le nombre de couleurs sur la carte finale est inf�rieur � 255 nous cr�ons une image index�e
			       				imagefill(&$this->carte, $x, $y, $rvb_final);
			       			} else {		       				
			       				$rvb_final = '128'<<16 | '128'<<8 | '128';
			       				imagefill(&$this->carte, $x, $y, $rvb_final);
			       			}
		       				// Nous ajoutons la couleur ajout�e � la carte dans le tableau des couleurs trait�es
		       				$tab_rvb_ok[$rvb_final] = true;
		       			}
		       			// Nous ajoutons la couleur trouv�es sur la carte de fond dans le tableau des couleurs trait�es
		       			$tab_rvb_ok[$rvb] = true;
	    			}
	    		}
	    	}
        } else {
			//+--------------------------------------------------------------------------------------------------------+
	        // Remplacement des couleurs sur la carte en mode couleurs index�es (palette de couleurs)

	        // Nous attribuons � chaque zone pr�sente dans le tableau $this->carte_zone_info la valeur de l'index 
	        // de la couleur RVB repr�sentant cette zone sur la carte de fond.
	        $this->construireAssociationIndexZone();
	          
        	foreach ($this->carte_zone_info as $cle => $zg) {
                //Dans le cas o� nous voulons rep�rer une zone sur la carte :
                if ($this->zone_marker!= '' && $zg['rvb_fond'] == $this->zone_marker) {
                    $rouge = 255;
                    $vert = 0;
                    $bleu = 0;
                } else {
                	$couleur_remplacement = explode('-', $zg['rvb_carte']);
                	$rouge = $couleur_remplacement[0];
	       			$vert = $couleur_remplacement[1];
	       			$bleu = $couleur_remplacement[2];
                }
                imagecolorset(&$this->carte, $zg['index'], $rouge, $vert, $bleu);
	        }
        }
	}
	
	private function construireAssociationIndexZone()
	{
		// Nous r�cup�rons le nombre de couleur diff�rentes contenues dans l'image.
		$taille_palette = imagecolorstotal($this->carte);

		// Pour chaque couleur contenue dans l'image, nous cherchons l'objet correspondant
		// dans le tableau $this->carte_zone_info, qui contient des informations sur chaque zone de l'image,
		// et nous attribuons la valeur de l'index de sa couleur sur la carte de fond.
		for ($i = 0; $i < $taille_palette; $i++) {
			$rvb = array();
			$rvb = imagecolorsforindex($this->carte, $i);
			$rvb_cle = $rvb['red'].'-'.$rvb['green'].'-'.$rvb['blue'];
			$index_ok = false;
			foreach($this->carte_zone_info as $cle => $zg) {
				if (isset($zg['rvb_fond']) && $zg['rvb_fond'] == $rvb_cle) {
					$this->carte_zone_info[$cle]['index'] = $i;
					$index_ok = true;
					//print_r($this->carte_zone_info[$cle]);
					break;
				}
			}
			if (!$index_ok && $rvb_cle != '0-0-0') {
				$e = "Aucune zone trouv� pour l'index $i : $rvb_cle";
				trigger_error($e, E_USER_WARNING);
				$this->carte_zone_info[] = array('rvb_fond' => $rvb_cle, 'rvb_carte' => '128-128-128', 'index' => $i);
			}
		}
	}
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: Cartographie.class.php,v $
* Revision 1.7  2007-07-06 18:50:41  jp_milcent
* Correction probl�me de cache et ajout de commentaires.
*
* Revision 1.6  2007-07-06 18:06:46  jp_milcent
* Optimisation du code pour le coloriage des images en vrai couleur.
*
* Revision 1.5  2007-07-05 19:08:58  jp_milcent
* Am�lioration de la cartographie.
*
* Revision 1.4  2007-06-25 16:37:13  jp_milcent
* Suppression du saut de ligne en fin de fichier.
*
* Revision 1.3  2007-06-22 16:27:40  jp_milcent
* D�but gestion du cache.
* Correction probl�me de la gestion du coloriage "proportionnel".
*
* Revision 1.2  2007-06-21 17:42:24  jp_milcent
* D�but gestion de la formule de coloriage "proportionnel".
*
* Revision 1.1  2007-02-12 18:35:06  jp_milcent
* Ajout de la nouvelle classe de Cartographie.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>