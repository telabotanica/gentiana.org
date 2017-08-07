<?php
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.2                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of Cartographie.                                                                   |
// |                                                                                                      |
// | Cartographie is free software; you can redistribute it and/or modify                                 |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | Cartographie is distributed in the hope that it will be useful,                                      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: Carto_Carte.class.php,v 1.4 2007-02-12 18:34:50 jp_milcent Exp $
/**
* Classe Carto_Carte.
*
* Calsse permettant de réaliser des cartes.
*
*@package Cartographie
//Auteur original :
*@author        Nicolas MATHIEU
//Autres auteurs :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.4 $ $Date: 2007-02-12 18:34:50 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/**
* Classe Carto_Carte() - Classe principale de la cartographie.
*
* La classe Carto_Carte permet de travailler les fichiers images des cartes.
*/
class Carto_Carte {
	/*** Attributs : ***/
	
	public $id;
	public $nom;
	public $masque;
	public $fond;
	public $chemin;
	public $image;
	public $fils;
	public $url;

	public $filiation;
	public $image_x;
	public $image_y;
	public $historique_cartes;
	public $liste_zone_carte;
	public $historique;

	private $_id_zone_geo_carte;
	private $_info_table_zg;
	// La couleur dominante ( $maxiRVB ), la couleur la plus claire ($miniRVB) et la couleur
	// intermédiaire précédant le maximum ( $mediumRVB ) au cas ou il y aurait un trop grand
	//ecart entre les deux plus grandes valeurs.
	private $_zeroR = '255';
	private $_zeroV = '255';
	private $_zeroB = '255';
	private $_miniR = '210';
	private $_miniV = '230';
	private $_miniB = '210';
	private $_mediumR = '92';
	private $_mediumV = '181';
	private $_mediumB = '92';
	private $_maxiR = '0';
	private $_maxiV = '127';
	private $_maxiB = '0';
	//Le type de formule mathématique permettant de colorier la carte
	private $_formule_coloriage;
	//L'action à réaliser
	private $_action;
    
	/*** Constructeur : ***/
	
	function __construct($id, $id_zone_geo_carte, $nom, $masque, $fond, $chemin, $info_table_zg, $info_table_action) 
	{
		$this->id = $id;
		$this->_id_zone_geo_carte = $id_zone_geo_carte;
		$this->nom = $nom;
		//$this->masque = $chemin.$masque;
		$this->fond = $chemin.$fond;
		//echo $this->fond;
		$this->chemin = $chemin;
		$this->_info_table_zg = $info_table_zg;
		$this->definirCouleurs();
		$this->definirFormuleColoriage();
	}
    
	/*** Méthodes publiques : ***/
	
	function definirCouleurs (
        $couleur_zero_R = '255', $couleur_zero_V = '255', $couleur_zero_B = '255',
        $couleur_mini_R = '210', $couleur_mini_V = '230', $couleur_mini_B = '210',
        $couleur_medium_R  = '92', $couleur_medium_V = '181', $couleur_medium_B = '92',
        $couleur_maxi_R = '0', $couleur_maxi_V = '127', $couleur_maxi_B = '0') 
	{
		$this->_zeroR = $couleur_zero_R;
		$this->_zeroV = $couleur_zero_V;
		$this->_zeroB = $couleur_zero_B;
		$this->_miniR = $couleur_mini_R;
		$this->_miniV = $couleur_mini_V;
		$this->_miniB = $couleur_mini_B;
		$this->_mediumR = $couleur_medium_R;
		$this->_mediumV = $couleur_medium_V;
		$this->_mediumB = $couleur_medium_B;
		$this->_maxiR = $couleur_maxi_R;
		$this->_maxiV = $couleur_maxi_V;
		$this->_maxiB = $couleur_maxi_B;
	}
    
	function definirFormuleColoriage ($nomFormuleColoriage = 'defaut') 
	{
		$this->_formule_coloriage = $nomFormuleColoriage;
	}
    
    //********************************************************************************************************
    // La méthode donnerImageSimple ($objet) permet de récupérer une image non cliquable.
    //*********************************************************************************************************
	public function creerCarte($nom_fichier_img) 
	{
		$this->_lancerColoriage(null, $nom_fichier_img);
	}
    
	/*** Méthodes privées : ***/
      
    private function _lancerColoriage($id_image = '_00', $nom_fichier = '', $id_zone_a_reperer = '') 
    {
        ini_set('memory_limit', 1073741824);//128Mo = 134217728 ; 256Mo = 268435456 ; 512Mo = 536870912 ; 1Go = 1073741824
        $this->image = imagecreatefrompng($this->fond);
		if (!$this->image) { /* Vérification */
			$this->image = imagecreatetruecolor(520, 60); /* Création d'une image blanche */
			$bgc = imagecolorallocate($this->image, 255, 255, 255);
			$tc  = imagecolorallocate($this->image, 0, 0, 0);
			imagefilledrectangle($this->image, 0, 0, 520, 60, $bgc);
			/* Affichage d'un message d'erreur */
			imagestring($this->image, 1, 5, 5, "Erreur de chargement de l'image :", $tc);
			imagestring($this->image, 1, 5, 15, $this->fond, $tc);
		} else {
	        $this->_colorierImage(	$this->image, $this->_info_table_zg['nom_table_zone'], 
	        						$this->_info_table_zg['nom_chp_id_zone'], $this->_info_table_zg['nom_chp_rouge'],
	        						$this->_info_table_zg['nom_chp_vert'], $this->_info_table_zg['nom_chp_bleu'], 
	        						$this->_info_table_zg['nom_chp_zone_sup'], 
	        						$this->_info_table_zg['tableau_valeurs_zone'], $id_zone_a_reperer) ;
        }
        if ($nom_fichier != '') {
    		if (file_exists(CAR_CHEMIN_TMP.$nom_fichier)) {
    			$img_ancienne_md5 = file_get_contents(CAR_CHEMIN_TMP.$nom_fichier);
    			ob_start();
				imagepng($this->image);
				$img_neuve_md5 = ob_get_contents();
				ob_end_clean();
    			if (md5($img_neuve_md5) == md5($img_ancienne_md5)) {
    				return true;
    			}
    		}
    		imagepng($this->image, CAR_CHEMIN_TMP.$nom_fichier);
    		return true;
        } else {
            imagepng(&$this->image, CAR_CHEMIN_TMP.$this->id.$id_image.'.png');
            return true;
        }
    }
        
    private function _colorierImage(&$image_fond, $table_zone_geo, $chp_id_zone_couleur, $chp_rouge, $chp_vert, $chp_bleu, $chp_zone_sup, $tableau_valeurs_zone, $id_zone_a_reperer) 
    {
        //----------------------------------------------------------------------------
        // Cherche les valeurs RVB de la couleur de chaque zone géographique et les rentre dans 
        //un tableau d'objets Carto_InformationCouleur (voir la description de la classe ci-dessus.
        
        $requete_01 =	'SELECT * '.
						'FROM '.$table_zone_geo;
        if ($chp_zone_sup != ''){
            if(ereg("[A-Za-z]+",$this->_id_zone_geo_carte)){
                $requete_01 .=
                    ' WHERE '.$chp_zone_sup.' = "'.$this->_id_zone_geo_carte.'"';
            } else {
                $requete_01 .=
                    ' WHERE '.$chp_zone_sup.' = '.$this->_id_zone_geo_carte;
            }
        }
        $resultat_01 = mysql_query ($requete_01) or die('
            <H2 style="text-align: center; font-weight: bold; font-size: 26px;">Erreur de requête</H2>'.
            '<b>Requete : </b>'.$requete_01.
            '<br/><br/><b>Erreur : </b>'.mysql_error());

        $attachments = array();
        while ($ligne_01 = mysql_fetch_object ($resultat_01)) {
        	// Nous tenons pas compte de la couleur blanche (255-255-255).
           	$attachments[$ligne_01->$chp_id_zone_couleur] = new Carto_Couleur ($ligne_01->$chp_id_zone_couleur, $ligne_01->$chp_rouge, $ligne_01->$chp_vert, $ligne_01->$chp_bleu);
        }
        //Nous libérons toute la mémoire associée à l'identifiant de résultat.
        mysql_free_result ($resultat_01);
        
        //----------------------------------------------------------------------------
        // On realide l'association entre l'index des couleurs et la zone de meme couleur
		if (!imageistruecolor($image_fond)) {
        	$attachments = $this->_construireAssociationIndexZone($image_fond, $attachments);
		}
		//echo '<pre>'.print_r($attachments, true).'</pre>';
        //----------------------------------------------------------------------------
        // Nous réalisons le coloriage de toutes les zones :
        
        $requete_03 =
            "SELECT $chp_id_zone_couleur ".
            "FROM $table_zone_geo";
        
        $resultat_03 = mysql_query ($requete_03) or die('
            <H2 style="text-align: center; font-weight: bold; font-size: 26px;">Erreur de requête</H2>'.
            '<b>Requete : </b>'.$requete_03.
            '<br/><br/><b>Erreur : </b>'.mysql_error());
        
        while ($ligne_03 = mysql_fetch_object ($resultat_03)) {
            $id_zone_geo = $ligne_03->$chp_id_zone_couleur;
            if (!isset ($tableau_valeurs_zone[$id_zone_geo])) {
                $tableau_valeurs_zone[$id_zone_geo] = 0;
            }
            //Nous cherchons la couleur a afficher pour chaque zone.
            if($id_zone_geo == $id_zone_a_reperer) {
	                    $rouge = 255;
	                    $vert = 0;
	                    $bleu = 0;
				$theColor['R'] = 255;
				$theColor['V'] = 0;
				$theColor['B'] = 0;
			} else if ($tableau_valeurs_zone[$id_zone_geo] != 0) {
                //echo 'ZONE:'.$id_zone_geo."<br/>";
                //echo $tableau_valeurs_zone[$id_zone_geo]."<br/>";
                $theColor = $this->_donnerCouleur (
                                        $this->_miniR, $this->_miniV, $this->_miniB,
                                        $this->_mediumR , $this->_mediumV , $this->_mediumB ,
                                        $this->_maxiR , $this->_maxiV , $this->_maxiB ,
                                        $tableau_valeurs_zone[$id_zone_geo],
                                        $this->_formule_coloriage);
				
            } else {
                $theColor['R'] = $this->_zeroR;
                $theColor['V'] = $this->_zeroV;
                $theColor['B'] = $this->_zeroB;
            }
            // Implémentation du tableau de remplacement pour les vrais couleurs
            if (isset($attachments[$id_zone_geo])) {
	            $r = $attachments[$id_zone_geo]->rouge;
	            $v = $attachments[$id_zone_geo]->vert;
	            $b = $attachments[$id_zone_geo]->bleu;
				$aso_couleurs[$r.'-'.$v.'-'.$b]['r'] = $theColor['R'];
				$aso_couleurs[$r.'-'.$v.'-'.$b]['v'] = $theColor['V'];
				$aso_couleurs[$r.'-'.$v.'-'.$b]['b'] = $theColor['B'];
			}
        }
        //Nous libérons toute la mémoire associée à l'identifiant de résultat de la requête.
        mysql_free_result ($resultat_03);

        //echo '<pre>'.print_r($aso_couleurs, true).'</pre>';
        //+------------------------------------------------------------------------------------------------------------+
        // Remplacement des couleurs sur la carte:        
        if (imageistruecolor($image_fond)) {
	        $hauteur = imagesy($image_fond);
	    	$largeur = imagesx($image_fond);
	    	echo '<pre>';
	    	for ($x = 0; $x < $largeur; $x++) {
	    		for ($y = 0; $y < $hauteur; $y++) {
	    			$rvb = ImageColorAt($image_fond, $x, $y);
	    			$r = ($rvb >> 16) & 0xFF;
	       			$v =($rvb >> 8) & 0xFF;
	       			$b = $rvb & 0xFF;
	       			$cle = $r.'-'.$v.'-'.$b;
	       			//echo $cle."\n";
	       			if (isset($aso_couleurs[$cle]) && $cle != '255-255-255') {
	       				echo $cle."\n";
	       				$rouge = $aso_couleurs[$cle]['r'];
	       				$vert = $aso_couleurs[$cle]['v'];
	       				$bleu = $aso_couleurs[$cle]['b'];
	       				imagefill($image_fond, $x, $y, $rouge<<16 | $vert<<8 | $bleu);
	       			}
	    		}
	    	}
	    	echo '</pre>';
        } else {
        	foreach ($attachments as $cle => $zg) {
                $index = $zg->index;
                //Dans le cas où nous voulons repérer une zone sur la carte :
                if ($cle == $id_zone_a_reperer) {
                    $rouge = 255;
                    $vert = 0;
                    $bleu = 0;
                } else {
                	$r = $zg->rouge;
                    $v = $zg->vert;
                    $b = $zg->bleu;
                    $rouge = $aso_couleurs[$r.'-'.$v.'-'.$b]['r'];
                    $vert = $aso_couleurs[$r.'-'.$v.'-'.$b]['v'];
                    $bleu = $aso_couleurs[$r.'-'.$v.'-'.$b]['b'];
                }
                imagecolorset($image_fond, $index, $rouge, $vert, $bleu);
	        }
        }
    }

    private function _construireAssociationIndexZone (&$image_fond, &$att) 
    {
        // Nous récupérons le nombre de couleur différentes contenues dans l'image.
    	$taille_palette = imagecolorstotal($image_fond);

        // Pour chaque couleur contenue dans l'image, nous cherchons l'objet correspondant
        // dans le tableau $att, qui contient des informations sur chaque zone de l'image,
        // et nous attribuons à l'objet la valeur de l'index de sa couleur dans l'image.
        for ($i = 0; $i < $taille_palette; $i++) {
            $RVB = array();
            $RVB = imagecolorsforindex($image_fond, $i);
            foreach($att as $cle => $zg) {
                if (($zg->rouge == $RVB['red']) && ($zg->vert == $RVB['green']) && ($zg->bleu == $RVB['blue'])) {
                    $att[$cle]->index = $i;
                    break;
                }
            }
        }
        //echo '<pre>'.print_r($att, true).'</pre>';
        return $att;
    }

    private function _donnerCouleur($miniR, $miniV, $miniB, $mediumR, $mediumV, $mediumB, $maxiR, $maxiV, $maxiB, $val, $formuleColoriage) 
    {
    	  //----------------------------------------------------------------------------
        //Dans l'application qui utilise la classe carte, nous avons instancié un tableau
        //associatif qui contient en clé l'identifiant d'une zone géographique et en valeur
        //un nombre (qui peut-être un nombre d'inscrit, d'institutions, de taxons...).
        // Nous récupérons ci-dessous la valeur minimum autre que 0 présente dans ce tableau
        //puis une valeur conscidérée comme maximum 
        if ($formuleColoriage == 'defaut' || $formuleColoriage == 'ecart_type') {
	        if (!is_array($tableau_valeurs_zone)) {
	            $mini = 0;
	            $medium = 0;
	            $maxi = 0;
	            $nbre_valeurs = 0;
	        }
	        else {
	            if (count($tableau_valeurs_zone) == 0) {
	                $mini=0;
	                $medium = 0;
	                $maxi=0;
	            }
	            else {
	                $i=0;
	                foreach ($tableau_valeurs_zone as $cle => $valeur) {
	                    //Nous recherchons le minimum, le maximum et le la valeur médium juste au dessous du maximum.
	                    if ($valeur != 0) {
	                        $tablo_valeurs[$i] = $valeur;
	                        $i++;
	                    }
	                }
	                //Nombre d'entrées dans le tableau de valeurs non nulles :
	                $nbre_valeurs = count($tablo_valeurs);
	                $somme_valeurs = array_sum($tablo_valeurs);
	                $tablo_frequences = array_count_values($tablo_valeurs);
	                $nbre_frequences = count($tablo_frequences);
	                if ($nbre_valeurs > 0){
	                    //Nous trions le tableau dans l'ordre croissant :
	                    sort($tablo_valeurs);
	                    //Nous récupérons la valeur la plus petite :
	                    $mini = $tablo_valeurs[0];
	                    $maxi = $tablo_valeurs[$nbre_valeurs-1];
	                    isset($tablo_valeurs[$nbre_valeurs-2]) ? $medium = $tablo_valeurs[$nbre_valeurs-2] : $medium = 0;
	                    $moyenne = $somme_valeurs/$nbre_valeurs;
	                    $ecart_au_carre_moyen = 0;
	                    for ($i = 0; $i < $nbre_valeurs; $i++) {
	                        $ecart_au_carre_moyen += pow(($tablo_valeurs[$i] - $moyenne), 2);
	                    }
	                    $variance = $ecart_au_carre_moyen/$nbre_valeurs;
	                    $ecart_type = sqrt($variance);
	                    
	                    $moyenne = round($moyenne, 0);
	                    $variance = round($variance, 0);
	                    $ecart_type = round($ecart_type, 0);
	                    
	                    /*echo 'Nombre de valeurs : '.$nbre_valeurs.'<br>';
	                    echo 'Nombre de frequences : '.$nbre_frequences.'<br>';
	                    echo 'Moyenne : '.$moyenne.'<br>';
	                    echo 'Variance : '.$variance.'<br>';
	                    echo 'Ecart-type : '.$ecart_type.'<br>';
	                    echo 'Formule de coloriage : '.$this->_formule_coloriage.'<br>';
	                    echo "mini : $mini medium : $medium maxi : $maxi<br/>";
	            */
	                }
	            }
	        }
        }
        if ($formuleColoriage == 'defaut'){
            if ($val == $maxi) {
                $couleur['R'] = $maxiR;
                $couleur['V'] = $maxiV;
                $couleur['B'] = $maxiB;
            }
            if ($val == $mini && $val != $maxi) {
                $couleur['R'] = $miniR;
                $couleur['V'] = $miniV;
                $couleur['B'] = $miniB;
            }
            if ($maxi/10 > $medium && $maxi/40 < $medium) {
                $diff = $medium - $mini;
                if ($diff > 0 && $val != $medium && $val != $maxi) {
                    $diffR   = $mediumR - $miniR;
                    $diffV   = $mediumV - $miniV;
                    $diffB   = $mediumB - $miniB;
                    $variationR =  round ( ($diffR/$diff ), 0 );
                    $variationV =  round ( ($diffV/$diff ), 0 );
                    $variationB =  round ( ($diffB/$diff ), 0 );
                    $couleur['R'] = couleur_bornerNbre(($miniR + ($val * $variationR)), 0, 255);
                    $couleur['V'] = couleur_bornerNbre(($miniV + ($val * $variationV)), 0, 255);
                    $couleur['B'] = couleur_bornerNbre(($miniB + ($val * $variationB)), 0, 255);
                }
                else if ($val == $medium) {
                    $couleur['R'] = $mediumR;
                    $couleur['V'] = $mediumV;
                    $couleur['B'] = $mediumB;
                }
            }
            else {
                $diff = $maxi - $mini;
                if ($diff > 0 && $val != $maxi && $val != $mini) {
                    $diffR = $maxiR - $miniR;
                    $diffV = $maxiV - $miniV;
                    $diffB = $maxiB - $miniB;
                    $variationR =  round ( ($diffR/$diff ), 0 );
                    $variationV =  round ( ($diffV/$diff ), 0 );
                    $variationB =  round ( ($diffB/$diff ), 0 );
                    $couleur['R'] = couleur_bornerNbre(($miniR + ($val * $variationR)), 0, 255);
                    $couleur['V'] = couleur_bornerNbre(($miniV + ($val * $variationV)), 0, 255);
                    $couleur['B'] = couleur_bornerNbre(($miniB + ($val * $variationB)), 0, 255);
                }
                else if ($diff == 0){
                    $couleur['R'] = $mediumR;
                    $couleur['V'] = $mediumV;
                    $couleur['B'] = $mediumB;
                }
            }
        }
        elseif ($formuleColoriage == 'ecart_type') {
            if ($ecart_type == 0) {
                    $couleur['R'] = $maxiR;
                    $couleur['V'] = $maxiV;
                    $couleur['B'] = $maxiB;
            }
            elseif ($ecart_type >= 1 && $ecart_type <= 15) {
                if ($val == $mini) {
                    $couleur['R'] = $miniR;
                    $couleur['V'] = $miniV;
                    $couleur['B'] = $miniB;
                }
                elseif ($val == $medium) {
                    $couleur['R'] = $mediumR;
                    $couleur['V'] = $mediumV;
                    $couleur['B'] = $mediumB;
                }
                elseif ($val == $maxi) {
                    $couleur['R'] = $maxiR;
                    $couleur['V'] = $maxiV;
                    $couleur['B'] = $maxiB;
                }
                else {
                    $dif_valeur_maxi_mini = $maxi - $mini;
                    $diffR = $maxiR - $miniR;
                    $diffV = $maxiV - $miniV;
                    $diffB = $maxiB - $miniB;
                    $variationR =  round ( ($diffR/$dif_valeur_maxi_mini ), 0 );
                    $variationV =  round ( ($diffV/$dif_valeur_maxi_mini ), 0 );
                    $variationB =  round ( ($diffB/$dif_valeur_maxi_mini ), 0 );
                    $couleur['R']=$miniR + ($val * $variationR);
                    $couleur['V']=$miniV + ($val * $variationV);
                    $couleur['B']=$miniB + ($val * $variationB);
                }
            }
            elseif ($ecart_type > 15) {
                //Le tableau est trié de la plus petite à la plus grande clé.
                ksort($tablo_frequences);
                $i = 0;
                foreach ($tablo_frequences as $cle => $valeur){
                    //Nous cherchons la correspondance entre la valeur et la clé.
                    if ($cle == $val) {
                        //Pour faire le Rouge, Vert, Bleu
                        $couleur['R'] = $miniR + ($i/$nbre_frequences) * ($maxiR - $miniR);
                        $couleur['V'] = $miniV + ($i/$nbre_frequences) * ($maxiV - $miniV);
                        $couleur['B'] = $miniB + ($i/$nbre_frequences) * ($maxiB - $miniB);
                    }
                    $i++;
                }
            }
        } elseif ($formuleColoriage == 'legende') {
				$couleur = $val;
        }
        
        return $couleur;
    
    }
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: Carto_Carte.class.php,v $
* Revision 1.4  2007-02-12 18:34:50  jp_milcent
* Modification entête du fichier.
*
* Revision 1.3  2007/01/17 17:04:36  jp_milcent
* Correction de la gestion de la chorologie.
* Début simplification.
*
* Revision 1.2  2005/12/09 14:43:14  jp_milcent
* Mise en conformité avec charte et ajout de la porté aux attributs des classes.
*
* Revision 1.1  2005/12/09 11:37:51  jp_milcent
* Simplification du code, renommage des fichiers.
* Début mise en conformité.
*
* Revision 1.3  2005/11/29 10:14:38  jp_milcent
* Modification de la gestion des cartes pour créer des cartes dans un dossier et ne plus utiliser de sessions.
*
* Revision 1.2  2005/10/11 17:30:32  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
* Revision 1.1  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
* Revision 1.4  2005/02/23 17:29:38  jpm
* Ajout d'un id au formulaire  de la carto.
*
* Revision 1.3  2005/02/22 19:35:08  jpm
* Fin de gestion des variables via les sessions.
*
* Revision 1.2  2005/02/22 16:35:16  jpm
* Mise en forme.
* Utilisation de  constantes pour les chemins d'accès aux fichiers.
* Ajout de commentaires.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>