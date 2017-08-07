<?php

//vim: set expandtab tabstop=4 shiftwidth=4: 
// +-----------------------------------------------------------------------------------------------+
// | PHP version 4.0                                                                               |
// +-----------------------------------------------------------------------------------------------+
// | Copyright (c) 1997, 1998, 1999, 2000, 2001 The PHP Group                                      |
// +-----------------------------------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,                                | 
// | that is bundled with this package in the file LICENSE, and is                                 |
// | available at through the world-wide-web at                                                    |
// | http://www.php.net/license/2_02.txt.                                                          |
// | If you did not receive a copy of the PHP license and are unable to                            |
// | obtain it through the world-wide-web, please send a note to                                   |
// | license@php.net so we can mail you a copy immediately.                                        |
// +-----------------------------------------------------------------------------------------------+
/**
* Fichier regroupant toutes les classes de la carto
*
*Toutes les classe de la carto sont disponibles dans ce fichier.
*
*@package carto
//Auteur original :
*@author        Nicolas MATHIEU
//Autres auteurs :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2003
*@version       01 juillet 2002
// +-----------------------------------------------------------------------------------------------+
//
// $Id: lib.carto.php,v 1.9 2007/04/20 14:16:45 alexandre_tb Exp $
// FICHIER : $RCSfile: lib.carto.php,v $
// AUTEUR  : $Author: alexandre_tb $
// VERSION : $Revision: 1.9 $
// DATE    : $Date: 2007/04/20 14:16:45 $
//
// +-----------------------------------------------------------------------------------------------+
// A FAIRE :
// 1.-Rendre cette classe indépendante de l'arborescence du site.
//      On trouve encore des urls ou des chemins d'accé au fichier codé en dur dans l'appli
//      Il faudrait pouvoir les paramétrés dans la classe.
// 2.- Supprimer l'attribut $this->historiques qui doit être devenu complétement obscoléte et le 
//      remplacer par $this->historique_cartes
// 3.- Renomer $this->liste_zone_carte en quelque chose de plus parlant...
*/
//Inclusion d'un autre fichier de librairie
include_once 'lib.couleur.php';

//Sert seulement en interne pour le débogage des requetes SQL
$NOM_FICHIER = 'lib.carto.php';

//==================================================================================================
// La classe Carto_HistoriqueCarte sert à pouvoir afficher les liens avec les carte précédentes
// On accède à cette fonctionnalité grâce à la méthode afficherHistoriqueCarte()
// L'objet Carto_HistoriqueCarte recoit en parametres : 
//      -la généalogie du niveau ou on en est (du type monde*europe*france )
//      -l'url du document
//      -en option :    *le caractere de separation (par defaut c'est >)
//                      *la classe css des liens
//===================================================================================================

class Carto_HistoriqueCarte 
{
    var $historique;
    var $url;
    var $caractere_separation;
    var $class_css;
    var $nom;

    function Carto_HistoriqueCarte ($objet_carte, $caractere = '&gt;', $class = '')
    {
        global $GS_GLOBAL;

        $this->historique = $objet_carte->historique;
        $this->url = $objet_carte->url;
        $this->nom = $objet_carte->nom;
        unset ($objet_carte);
        $this->caractere_separation = $caractere;
        $this->class_css = $class;
    }//Fin du constructeur Carto_HistoriqueCarte().
    
    function afficherHistoriqueCarte () 
    {
        $res='<div style="float:left;">'.INS_ECHELLE;
        $tabonglet = explode ('*', $this->historique);
        $tabnom = explode ('*', $this->nom);
        foreach ($tabonglet as $key=>$value) {
            if ($key == 0) {
                $chemin = $value;
            }
            else {
                $chemin .= '*'.$value;
            }
            
            $res.= '<a ';
            
            if (!empty($this->class_css)) {
                $res.='class="'.$this->class_css.'" ';
            }
            
            $res.='href="'.$this->url.'&amp;historique_cartes='.$chemin.'">&nbsp;'.$this->caractere_separation.'&nbsp;'.$tabnom[$key].'</a>';
        }
        $res.= '</div>'."\n";
        return $res;
        
    }//Fin de la méthode afficherHistoriqueCarte().

}//Fin de la classe Carto_HistoriqueCarte.

//================================================================================================
//La classe Action sert a definir les paramètres nécessaires pour recueillir l'action a réaliser en 
// fonction des coordonnées du point, du masque et du niveau.
//Elle remplace la fonction get_cartoAction() que l'on peut trouver dans le fichier carto_commun.php
//des différentes application utilisant la carto.
// Les champs a renseigner sont les suivants :
//   -le nom de la table ($nom_table_carto_action) où sont stokée les actions à réalisées 
//      en fonction des couleurs
//   -les 5 champs principaux de la table :
//      -l'identifiant de la zone géographique (un nom, un numéro ou une abréviation) -> $nom_champ_cle 
//      -les couleurs -> $nom_champ_rouge, $nom_champ_vert, $nom_champ_bleu
//      -l'action -> $nom_champ_action
// Elle possède une seule méthode : get_cartoAction().
//================================================================================================

class Carto_Action
{
        var $_table_zone_geo;
        var $_id_zone_geo_zone;
        var $_rouge;
        var $_vert;
        var $_bleu;
        var $_table_action;
        var $_id_carte_action;
        var $_id_zone_geo_action;
        var $_type_zone_geo_action;
        var $_action;
        var $_id_carte_destination;
    
    function Carto_Action ($table_zone_geo, $zone_chp_id_zone, $chp_rouge,
                                    $chp_vert, $chp_bleu, $table_carto_action, $action_chp_id_carte, $action_chp_id_zone,
                                    $action_chp_type_zone, $chp_action, $chp_destination) 
    {
        $this->_table_zone_geo = $table_zone_geo;
        $this->_id_zone_geo_zone = $zone_chp_id_zone;
        $this->_rouge = $chp_rouge;
        $this->_vert = $chp_vert;
        $this->_bleu = $chp_bleu;
        $this->_table_action = $table_carto_action;
        $this->_id_carte_action = $action_chp_id_carte;
        $this->_id_zone_geo_action = $action_chp_id_zone;
        $this->_type_zone_geo_action = $action_chp_type_zone;
        $this->_action = $chp_action;
        $this->_id_carte_destination = $chp_destination;
    }
    
    //**********************************************************************************************************
    // Méthode get_cartoAction($imageX, $imageY, $masque, $id_carte)
    
    // Elle renvoit l'action a réaliser.
    // Nous passons les paramètres suivant :     
    //      -les coordonnees du point ($imageX et $imageY)
    //      -le masque pour recuperer la couleur ($masque)
    //      -l'identifiant de la carte où nous nous trouvons ($id_carte)
    //**********************************************************************************************************
    
    function _consulterActionImage($imageX, $imageY, $masque, $id_carte) 
    {
        // Nous récuperons les valeurs RVB de la couleur sur laquelle l'utilisateur a cliqué.
        // Les valeurs RVB sont stockées dans le tableau associatif $valeurs_RVB.
        
        $masque_courant = imagecreatefrompng($masque);
        $index_couleur = imagecolorat($masque_courant,$imageX,$imageY);
        $valeurs_RVB = imagecolorsforindex($masque_courant, $index_couleur);
        
        // Nous effectuons une requete dans la table carto_ACTION pour récupérer la valeur
        // du champ "action", afin de savoir quoi faire.
        $requete = 
        'SELECT '.$this->_action.', '.$this->_id_carte_destination.', '.$this->_id_zone_geo_action.
        ' FROM '.$this->_table_action.', '.$this->_table_zone_geo.
        ' WHERE '.$this->_table_zone_geo.'.'.$this->_rouge.' = '.$valeurs_RVB['red'].
        ' AND '.$this->_table_zone_geo.'.'.$this->_vert.' = '.$valeurs_RVB['green'].
        ' AND '.$this->_table_zone_geo.'.'.$this->_bleu.' = '.$valeurs_RVB['blue'].
        ' AND '.$this->_table_action.'.'.$this->_id_zone_geo_action.' = '.$this->_table_zone_geo.'.'.$this->_id_zone_geo_zone.
        ' AND '.$this->_table_action.'.'.$this->_id_carte_action.' = "'.$id_carte.'"';
        
        $resultat=mysql_query($requete) or die('
            <H2 style="text-align: center; font-weight: bold; font-size: 26px;">Erreur de requête</H2>'.
            '<b>Requete : </b>'.$requete.
            '<br/><br/><b>Erreur : </b>'.mysql_error());
        
        $ligne = mysql_fetch_object ($resultat);
        
        if (mysql_num_rows ($resultat) != 0) {
            
            $chp_id_zone_geo = $this->_id_zone_geo_action;
            $chp_action = $this->_action;
            $chp_id_carte_destination = $this->_id_carte_destination;
            
            $action['id_zone_geo'] = $ligne->$chp_id_zone_geo;
            $action['type_action'] = $ligne->$chp_action;
            $action['id_carte_destination'] = $ligne->$chp_id_carte_destination;
            
            return $action;
        }
    }//Fin de la méthode _consulterActionImage().
    
    //**********************************************************************************************************
    // Méthode _consulterActionListe($id_zone_carte, $id_carte)
    
    // Elle renvoit l'action a réaliser.
    // Nous passons les paramètres suivant :     
    //      -l'identifiant de la zone que l'on veut afficher
    //      -l'identifiant de la carte où nous nous trouvons ($id_carte)
    //**********************************************************************************************************
    
    function _consulterActionListe($id_zone_carte, $id_carte) 
    {
        // Nous effectuons une requete dans la table carto_ACTION pour récupérer la valeur
        // du champ "action", afin de savoir quoi faire.
        $requete = 
        'SELECT '.$this->_action.', '.$this->_id_carte_destination.', '.$this->_id_zone_geo_action.
        ' FROM '.$this->_table_action.', '.$this->_table_zone_geo.
        ' WHERE '.$this->_table_action.'.'.$this->_id_zone_geo_action.' = '.$this->_table_zone_geo.'.'.$this->_id_zone_geo_zone.
        ' AND '.$this->_table_zone_geo.'.'.$this->_id_zone_geo_zone.' = "'.$id_zone_carte.'"'.
        ' AND '.$this->_table_action.'.'.$this->_id_carte_action.' = "'.$id_carte.'"';
        
        $resultat=mysql_query($requete) or die('
            <H2 style="text-align: center; font-weight: bold; font-size: 26px;">Erreur de requête</H2>'.
            '<b>Requete : </b>'.$requete.
            '<br/><br/><b>Erreur : </b>'.mysql_error());
        
        $ligne = mysql_fetch_object ($resultat);
        
        if (mysql_num_rows ($resultat) != 0) {
            
            $chp_id_zone_geo = $this->_id_zone_geo_action;
            $chp_action = $this->_action;
            $chp_id_carte_destination = $this->_id_carte_destination;
            
            $action['id_zone_geo'] = $ligne->$chp_id_zone_geo;
            $action['type_action'] = $ligne->$chp_action;
            $action['id_carte_destination'] = $ligne->$chp_id_carte_destination;
            
            return $action;
        }
    }//Fin de la méthode get_cartoAction().
}//Fin de la classe Carto_Action.

//================================================================================================
// L'objet carte est l'objet principal de la carto. C'est lui possede qui possède les methodes
//pour colorier les cartes.
// Il faut lui donner les parametres suivants :
//      -le nom de la premier carte ($id).
//      -le nom du masque ($masque).
//      -le nom du fond de carte a colorier ($fond).
//      -le tableau $info_table_couleur : il contient les renseignements concernant la table des couleurs ainsi
//       qu'un autre tableau dans lequel figure le nombre d'elements par zone.
// L'objet comporte deux methodes principales :
//      -'ajouterFils()' qui permet d'ajouter les cartes de niveau inferieur.
//      -'donnerFormulaireImage()' qui lance l'action a faire en fonction de l'action de l'utilisateur.
// Il faut aussi penser a donner directement le champs url.
//================================================================================================

class Carto_Carte 
{
    /*|=============================================================================================|*/
    /*|                                LES ATTRIBUTS DE LA CLASSE                                   |*/
    /*|---------------------------------------------------------------------------------------------|*/
    var $id;
    var $_id_zone_geo_carte;
    var $nom;
    var $masque;
    var $fond;
    var $chemin;
    var $image;
    var $fils;
    var $url;
    var $_info_table_zg;
    var $filiation;
    var $image_x;
    var $image_y;
    var $historique_cartes;
    var $liste_zone_carte;
    var $historique;
    // La couleur dominante ( $maxiRVB ), la couleur la plus claire ($miniRVB) et la couleur
    // intermédiaire précédant le maximum ( $mediumRVB ) au cas ou il y aurait un trop grand
    //ecart entre les deux plus grandes valeurs.
    var $_zeroR;
    var $_zeroV;
    var $_zeroB;
    var $_miniR;
    var $_miniV;
    var $_miniB;
    var $_mediumR;
    var $_mediumV;
    var $_mediumB;
    var $_maxiR;
    var $_maxiV;
    var $_maxiB;
    //Le type de formule mathématique permettant de colorier la carte
    var $_formule_coloriage;
    //L'action à réaliser
    var $_action;

    /*|=============================================================================================|*/
    /*|                                LE CONSTRUCTEUR DE LA CLASSE                                 |*/
    /*|---------------------------------------------------------------------------------------------|*/
    
    function Carto_Carte ($id, $id_zone_geo_carte, $nom, $masque, $fond, $chemin, $info_table) 
    {
        $this->id = $id;
        $this->_id_zone_geo_carte = $id_zone_geo_carte;
        $this->nom = $nom;
        $this->masque = $chemin.$masque;
        $this->fond = $chemin.$fond;
        $this->chemin = $chemin;
        $this->_info_table_zg = $info_table;
        
        $this->_action = new Carto_Action($info_table['nom_table_zone'],$info_table['nom_chp_id_zone'], $info_table['nom_chp_rouge'], $info_table['nom_chp_vert'], $info_table['nom_chp_bleu'],
                                                            'carto_ACTION', 'CA_ID_Carte', 'CA_ID_Zone_geo', 'CA_Type_zone', 'CA_Action', 'CA_ID_Carte_destination');
        $this->fils = array();
        $this->filiation = $id;
        $this->historique_cartes = '';
        $this->liste_zone_carte = '';
        $this->definirCouleurs();
        $this->definirFormuleColoriage();
    }
    
    /*|=============================================================================================|*/
    /*|                                LES METHODES PUBLIQUES                                       |*/
    /*|---------------------------------------------------------------------------------------------|*/
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
    
    function donnerImageSimple ($objet) 
    {
        $nom_fichier_image = $this->_donnerIdUnique();
        $objet->_lancerColoriage('', $nom_fichier_image);
        $res = '<img src="'.INS_CHEMIN_APPLI.'/bibliotheque/lib.carto.extractimg.php?fichier='.$nom_fichier_image.'" alt="image.png">';
        return $res;
    }
    
    //********************************************************************************************************
    // La methode ajouterFils() est essentielle. Elle permet d'ajouter toutes les sous cartes voulues.
    // Il faut lui indiquer, comme a la carte du niveau du dessus, son nom, le masque, le fond et info_table_couleur.
    // On a ainsi une inclusion d'objets les uns dans les autres.
    //*********************************************************************************************************
    
    function ajouterFils ($id, $id_zone_geo_carte, $nom, $masque, $fond, $info_table) 
    {
        $this->fils[$id] = new Carto_Carte ($id, $id_zone_geo_carte, $nom, $masque, $fond, $this->chemin, $info_table);
        //Si on ajoute à la carte du monde comme fils celle de l'europe, alors
        //on aura comme valeur pour $this->filiation de la carte d'europe : monde*europe
        $this->fils[$id]->filiation = $this->filiation.'*'.$id;
        $this->fils[$id]->url = $this->url;
        //Si on ajoute à la carte du monde dont le nom est 'Monde' comme fils celle de l'europe,
        //dont le nom est 'Europe', alors on aura comme valeur pour $this->nom de la carte d'europe : Monde*Europe
        $this->fils[$id]->nom = $this->nom.'*'.$nom;
        $this->fils[$id]->historique_cartes = $this->historique_cartes;
    }
    
    //*********************************************************************************************************	
    // La methode donnerFormulaireImage() est la methode principale de la carto. C'est elle qui gere ce qu'il y a faire en 
    // fonction de l'action de l'utilisateur.
    // Trois cas se distinguent :
    //      -soit l'utilisateur a clique sur un point de la carte.
    //      -soit il a clique sur un des liens que l'on a afficher avec la méthode afficherHistoriqueCarte de l'objet Carto_HistoriqueCarte.
    //      -soit il a sélectionné une zone géographique dans la liste déroulante.
    // Elle renvoit a la fin: 
    //      -soit une nouvelle carte coloriée
    //      -soit false.
    //**********************************************************************************************************
    
    function donnerFormulaireImage ()
    {
        global $GS_GLOBAL;
        $res = '';
        
        // Nous commençons par tester tout d'abords si nous venons d'une autre carte. Pour cela nous vérifions,
        // si les attributs $this->image_x et $this->image_y de la classe Carte existe ou ne sont pas null.
        // La carte est une image appelée par une balise <input type="image"> et non par une balise classique <img>.
        // Ansi, lorsqu'on clique sur la carte le formulaire appelle (via l'url du formulaire) l'application  
        // utilisant la classe carte et lui renvoit deux variables contenant les coordonnées x et y du clic.
        // L'application instancie à nouveau les objets cartes mais cette fois ci la carte affichée dépendra des
        // informations founit par une table de la base de données.
        // La classe carto_action instanciée dans l'application utilisant la classe carte fournit les noms
        // des champs et celui de la table contenant les valeur RVB de chaque zone des cartes, l'identifiant
        // de la zone et l'action à entreprendre pour la zone conssidérée.
        // La méthode imgform() utilise la méthode get_cartoAction() de l'objet Carto_Action pour connaître 
        // en fonction des coordonnées du clic l'action à entreprendre. 
                
        if (isset ($this->image_x) && ($this->image_x != '') && isset ($this->image_y) && ($this->image_y != '')) {
            // on regarde ici si l'on a pas un objet de plus bas niveau présent dans la variable de session carte
            //a charger a la place de l'objet de plus haut niveau 
            
            $var_session_retour = $_SESSION['carte'] ;
            
            if ($var_session_retour) {
                $image_x = $this->image_x;
                $image_y = $this->image_y;
                $liste_zone_carte = $this->liste_zone_carte;
                // Nous chargons alors l'ojet approprié en descendant grâce a la généalogie

                $historique_cartes = explode('*',$this->historique_cartes);
                foreach ($historique_cartes as $key => $value) {
                    if ($key != 0) { 
                        foreach (get_object_vars($this->fils[$value]) as $key => $value) 
                               $this->$key = $value; 
                    }
                }

                $this->image_x = $image_x;
                $this->image_y = $image_y;
                $this->liste_zone_carte = $liste_zone_carte;
                unset ($_SESSION['carte']) ;
            }
            
            // on regarde qu'est-ce qu'on doit faire grace a la methode _consulterAction() de l'objet Carto_Action
           
            $action = $this->_action->_consulterActionImage($this->image_x, $this->image_y, $this->masque, $this->id);
            
            // Nous distinguons 2 cas :
            //le cas ou il faut afficher une nouvelle carte ... :
            if ($action['type_action'] == 'Aller_a') {
                
                $id_carte_destination = $action['id_carte_destination'] ;
                $this->fils[$id_carte_destination]->liste_zone_carte = $this->liste_zone_carte;
                if (INS_AFFICHE_ZONE_ROUGE) {
                	$res .= ''.$this->fils[$id_carte_destination]->_donnerListeZoneCarte()."<br />\n";
                }
                $res .= '<input type="image" src="';
                $id_image = $this->_donnerIdUnique();
                $this->fils[$id_carte_destination]->_lancerColoriage($id_image);
                $obj = serialize($this->fils[$id_carte_destination]);
                $_SESSION['carte'] = $obj ;
                $this->historique = $this->fils[$id_carte_destination]->filiation;
                $this->id = $this->fils[$id_carte_destination]->id;
                $this->nom = $this->fils[$id_carte_destination]->nom;
            }
            //Dans le cas où l'on veut rappeler une nouvelle carte, il se peut que la nouvelle carte à rappeler
            //soit la même que précédement.
            //Cette possibilité peut se présenter quand on clique sur un zone blanche d'une carte (càd dans la mer)
            //Là, on recharge la carte précédente :
            elseif ($action['type_action'] == 'Recharger') {
                if (INS_AFFICHE_ZONE_ROUGE) {
                	$res .= ''.$this->_donnerListeZoneCarte()."<br />\n";
                }
                $res .= '<input type="image" src="';
                $id_image = $this->_donnerIdUnique();
                $this->_lancerColoriage($id_image);
                $obj = serialize($this);
                $_SESSION['carte'] = $obj ;
                $this->historique = $this->filiation;
            }
            // ... et le cas ou il faut lancer le dernier niveau
            else if ($action['type_action'] == 'Stop') {
                unset ($_SESSION['carte']) ;
                $this->historique = $this->filiation.'*'.$action['id_zone_geo'];
                $obj = serialize($this);
                $_SESSION['carte'] = $obj ;
                return false;
            }
        }
        elseif ($this->liste_zone_carte != '') {
            $liste_zone_carte = $this->liste_zone_carte;
            $historique_cartes = explode('*',$this->historique_cartes);
            foreach ($historique_cartes as $key => $value) {
                    if ($key != 0) { 
                        foreach (get_object_vars($this->fils[$value]) as $key => $value) 
                               $this->$key = $value; 
                    }
                }
            $this->liste_zone_carte = $liste_zone_carte;
            if (INS_AFFICHE_ZONE_ROUGE) {
            	$res .= ''.$this->_donnerListeZoneCarte($this->liste_zone_carte)."<br />\n";
            }
            $res .= '<input type="image" src="';
            $id_image = $this->_donnerIdUnique();
            $this->_lancerColoriage($id_image, '', $this->liste_zone_carte);
            $this->historique = $this->historique_cartes;
            $obj = serialize($this);
            $_SESSION['carte'] = $obj ;
        }
        // On teste maintenant si l'on vient d'un lien. Si c'est le cas on a recu un argument 
        // qui nous donne la "genealogie" de la carte que l'on doit afficher 
        else if ($this->historique_cartes) {
            // Nous chargons alors l'ojet approprié en descendant grâce a la généalogie
            $historique_cartes = explode('*',$this->historique_cartes);
            foreach ($historique_cartes as $key => $value) {
                if ($key != 0) { 
                    foreach (get_object_vars($this->fils[$value]) as $key => $value) 
                           $this->$key = $value; 
                }
            }
            // une foit que l'on a charge le bon objet nous le colorions 
            if (INS_AFFICHE_ZONE_ROUGE) {
            	$res .= ''.$this->_donnerListeZoneCarte()."<br />\n";
            }
            $res .= '<input type="image" src="';
            $id_image = $this->_donnerIdUnique();
            $this->_lancerColoriage($id_image);
            $this->historique = $this->historique_cartes;
            $obj = serialize($this);
            $_SESSION['carte'] = $obj ;
        }
        // Enfin si on ne vient pas d'une carte ou d'un lien c'est que l'on vient de l'onglet carto du menu
        // et on affiche alors la premiere carte
        else {
            unset ($_SESSION['carte']) ;
            if (INS_AFFICHE_ZONE_ROUGE) {
            	$res .= ''.$this->_donnerListeZoneCarte()."<br />\n";
            }
            $res .= '<input type="image" src="';
            $id_image = $this->_donnerIdUnique();
            $this->_lancerColoriage($id_image);
            $this->historique = $this->id;
            $obj = serialize($this);
            
            $_SESSION['carte'] = $obj ;
        }
        $res .= INS_CHEMIN_APPLI.'/bibliotheque/lib.carto.extractimg.php?fichier='.$this->id.$id_image.'"';
        $res .= ' name="image" onmouseover="javascript:show(\'d\');" onmouseout="javascript:show(\'d\');" />'."\n";
        $res .= '<input type="hidden" name="historique_cartes" value="'.$this->historique.'" />'."\n";
        return $res;
    }
    
    /*|=============================================================================================|*/
    /*|                                LES METHODES PRIVEES                                         |*/
    /*|---------------------------------------------------------------------------------------------|*/
    function _donnerListeZoneCarte($zone_par_defaut = '')
    {
        $retour = '';
        
        $requete =
                    'SELECT '.$this->_info_table_zg['nom_chp_id_zone'].', '.$this->_info_table_zg['nom_chp_nom_zone'].
                    ' FROM '.$this->_info_table_zg['nom_table_zone'];
        if ($this->_info_table_zg['nom_chp_zone_sup'] != ''){
            if(ereg("[a-z]+",$this->_id_zone_geo_carte)){
                $requete .=
                    ' WHERE '.$this->_info_table_zg['nom_chp_zone_sup'].' = "'.$this->_id_zone_geo_carte.'"';
            }
            else{
                $requete .=
                    ' WHERE '.$this->_info_table_zg['nom_chp_zone_sup'].' = '.$this->_id_zone_geo_carte;
            }
        }
        $requete .=
                    ' ORDER BY '.$this->_info_table_zg['nom_chp_nom_zone'].' ASC';
	$resultat = mysql_query ($requete) or die(BOG_afficherErreurSql(__FILE__, __LINE__, 
								'', $requete));
        
        $i=0;
        
        $retour = '<select name="liste_zone_carte" style="float:right;" onchange="javascript:this.form.submit();">'."\n";
        $retour .= '<option value="">'.INS_VISUALISER_ZONE.'</option>'."\n";
        
        $nom_chp_nom_zone = $this->_info_table_zg['nom_chp_nom_zone'];
        $nom_chp_id_zone = $this->_info_table_zg['nom_chp_id_zone'];
        
        while ($ligne = mysql_fetch_object ($resultat)) {
            if ($zone_par_defaut == $ligne->$nom_chp_id_zone){
                $retour .= '<option value="'.$ligne->$nom_chp_id_zone.'" selected="selected">'.$ligne->$nom_chp_nom_zone.'</option>'."\n";
            }
            else {
                $retour .= '<option value="'.$ligne->$nom_chp_id_zone.'">'.$ligne->$nom_chp_nom_zone.'</option>'."\n";
            }
            $i++;
        }
        
        $retour .= '</select>'."\n";
        
        return $retour;
    }
    //==============================================================================
    // METHODE _lancerColoriage() 
    // 
    // Elle lance le coloriage de l'image.
    // Elle est lancée toute seule par la méthode donnerFormulaireImage().
    // Les informations qui lui sont necessaires sont déjà données à l'objet carte (fond, info_table_couleur).
    //==============================================================================
    
    function _lancerColoriage ($id_image = '_00', $nom_fichier = '', $id_zone_a_reperer = '') 
    {
    	
        $this->image = imagecreatefrompng($this->fond);
        
        $this->_colorierImage ($this->image, $this->_info_table_zg['nom_table_zone'], $this->_info_table_zg['nom_chp_id_zone'], $this->_info_table_zg['nom_chp_rouge'],
                                        $this->_info_table_zg['nom_chp_vert'], $this->_info_table_zg['nom_chp_bleu'], $this->_info_table_zg['nom_chp_zone_sup'],
                                        $this->_info_table_zg['tableau_valeurs_zone'], $id_zone_a_reperer) ;
        if ($nom_fichier != '') {
            imagepng(&$this->image, INS_CHEMIN_APPLI.'bibliotheque/tmp/carto/'.$nom_fichier.'.png');
	    
            //$this->image = imagepng(&$this->image);
        }
        else {
            imagepng(&$this->image, INS_CHEMIN_APPLI.'bibliotheque/tmp/carto/'.$this->id.$id_image.'.png');
            //imagepng(&$this->image);
        }
    }
    
    //==============================================================================
    // METHODE _colorierImage() 
    // 
    // Elle réalise le coloriage de l'image.
    //==============================================================================
    
    function _colorierImage (&$image_fond, $table_zone_geo, $chp_id_zone_couleur, $chp_rouge, $chp_vert, $chp_bleu, $chp_zone_sup, $tableau_valeurs_zone, $id_zone_a_reperer) 
    {
        //----------------------------------------------------------------------------
        // Cherche les valeurs RVB de la couleur de chaque zone géographique et les rentre dans 
        //un tableau d'objets Carto_InformationCouleur (voir la description de la classe ci-dessus.
        
        $requete_01 =
                    'SELECT *'.
                    ' FROM '.$table_zone_geo;
        if ($chp_zone_sup != ''){
            if(ereg("[a-z]+",$this->_id_zone_geo_carte)){
                $requete_01 .=
                    ' WHERE '.$chp_zone_sup.' = "'.$this->_id_zone_geo_carte.'"';
            }
            else{
                $requete_01 .=
                    ' WHERE '.$chp_zone_sup.' = '.$this->_id_zone_geo_carte;
            }
        }
        $resultat_01 = mysql_query ($requete_01) or die('
            <H2 style="text-align: center; font-weight: bold; font-size: 26px;">Erreur de requête</H2>'.
            '<b>Requete : </b>'.$requete_01.
            '<br/><br/><b>Erreur : </b>'.mysql_error());
        $i=0;
        $attachments = array();
        while ($ligne_01 = mysql_fetch_object ($resultat_01)) {
            $attachments[$i] = new Carto_InformationCouleur ($ligne_01->$chp_id_zone_couleur, $ligne_01->$chp_rouge, $ligne_01->$chp_vert, $ligne_01->$chp_bleu);
            $i++;
        }
        
        //Nous libérons toute la mémoire associée à l'identifiant de résultat.
        mysql_free_result ($resultat_01);
        
        //----------------------------------------------------------------------------
        // On realide l'association entre l'index des couleurs et la zone de meme couleur
        
        $attachments = $this->_construireAssociationIndexZone ($image_fond, $attachments);
        
        //----------------------------------------------------------------------------
        //Dans l'application qui utilise la classe carte, nous avons instancié un tableau
        //associatif qui contient en clé l'identifiant d'une zone géographique et en valeur
        //un nombre (qui peut-être un nombre d'inscrit, d'institutions, de taxons...).
        // Nous récupérons ci-dessous la valeur minimum autre que 0 présente dans ce tableau
        //puis une valeur conscidérée comme maximum 
        
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
            if ($tableau_valeurs_zone[$id_zone_geo] != 0) {
                //echo 'ZONE:'.$id_zone_geo."<br/>";
                //echo $tableau_valeurs_zone[$id_zone_geo]."<br/>";
                $theColor = $this->_donnerCouleur(
                                        $this->_miniR, $this->_miniV, $this->_miniB,
                                        $this->_mediumR , $this->_mediumV , $this->_mediumB ,
                                        $this->_maxiR , $this->_maxiV , $this->_maxiB ,
                                        $mini, $medium, $maxi, $nbre_valeurs, $ecart_type, $moyenne, $tablo_valeurs,
                                        $tablo_frequences, $nbre_frequences, 
                                        $tableau_valeurs_zone[$id_zone_geo],
                                        $this->_formule_coloriage);
                //echo $theColor['R'].'<br>';
                //echo $theColor['V'].'<br>';
                //echo $theColor['B'].'<br>';
            }
            else {
                $theColor['R'] = $this->_zeroR;
                $theColor['V'] = $this->_zeroV;
                $theColor['B'] = $this->_zeroB;
            }
            //Nous réalisons le coloriage de toutes les zones de l'image avec la couleur obtenue.
            $this->_remplacerCouleur($image_fond, $attachments, $id_zone_geo,  $theColor['R'], $theColor['V'], $theColor['B'], $id_zone_a_reperer);
        }
        //Nous libérons toute la mémoire associée à l'identifiant de résultat de la requête.
        mysql_free_result ($resultat_03);
    }
    
    //==============================================================================
    // METHODE  _construireAssociationIndexZone ($image, &$att)
    //
    // Le tableau $att est passé par référence. La méthode modifie donc directement
    // le tableau et ne renvoit donc rien.
    // Attache dans un tableau $att, contenant sous forme d'objet (Carto_ColorInfo)
    // les valeurs RVB des zones d'une image, la valeur de l'index correspondant 
    // à la couleur de la zone.
    // Note : les images en question sont constituées de zones distincte possédant 
    // chacune une couleur unique et unie.
    //==============================================================================
    
    function _construireAssociationIndexZone(&$image_fond, &$att) 
    {
        // Nous récupérons le nombre de couleur différentes contenues dans l'image.
        //echo $this->fond.'<BR>';
        $image_fond = imagecreatefrompng($this->fond);
        $taille_palette = imagecolorstotal ($image_fond);
        if (!$image_fond) echo 'erreur fond : '.$this->fond;
        // Pour chaque couleur contenue dans l'image, nous cherchons l'objet correspondant
        // dans le tableau $att, qui contient des informations sur chaque zone de l'image,
        // et nous attribuons à l'objet la valeur de l'index de sa couleur dans l'image.
        
        for ($i = 0; $i < $taille_palette; $i++) {
            $valeurs_RVB = array();
            $valeurs_RVB = imagecolorsforindex ($image_fond, $i);
            
            for ($j = 0; $j < count ($att); $j++) {
                
                if (($att[$j]->rouge == $valeurs_RVB['red']) && ($att[$j]->vert == $valeurs_RVB['green']) && ($att[$j]->bleu == $valeurs_RVB['blue'])) {
                    $att[$j]->index = $i;
                    //echo 'ICI'.$att[$j]->id_zone.$att[$j]->index.'<br>';
                    break;
                }
            }
        }
        
        return $att;
    }//Fin méthode _construireAssociationIndexZone()

    //==============================================================================
    // METHODE _donnerCouleur()
    //------------------------------------------------------------------------------
    // Renvoie pour une valeur donnee la couleur a mettre
    //------------------------------------------------------------------------------
    // ENTREE
    // $miniR : valeur rouge du minimum 
    // $miniV : valeur vert du minimum 
    // $miniB : valeur blue du minimum
    // $maxiR : valeur rouge du maximum 
    // $maxiV : valeur vert du maximum 
    // $maxiB : valeur bleu du maximum
    // $mediumR : valeur rouge du deuxieme maximum 
    // $mediumV : valeur vert du deuxieme maximum 
    // $mediumB : valeur bleu du deuxieme maximum
    // $mini  : valeur mini sur l'echelle 
    // $medium  : valeur juste au dessous du maximum sur l'echelle 
    // $maxi  : valeur maxi sur l'echelle 
    // $val   : valeur dont on cherche la couleur
    //------------------------------------------------------------------------------
    // SORTIE 
    // $couleur array donne la couleur pour la valeur demande ($val)
    //------------------------------------------------------------------------------
    
    function _donnerCouleur($miniR, $miniV, $miniB, $mediumR, $mediumV, $mediumB, $maxiR, 
                            $maxiV, $maxiB, $mini, $medium, $maxi, $nbre_valeurs, $ecart_type, $moyenne, $tablo_valeurs, $tablo_frequences, $nbre_frequences, $val, $formuleColoriage) 
    {
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
        }
        
        return $couleur;
    
    }//Fin méthode _donnerCouleur()

    //==============================================================================
    // METHODE _remplacerCouleur ($img, $att, $id_zone_geo, $r, $g, $b)
    //
    // $img is the image, $att an array of carto_colorinfo objects, $id_zone_geo the name
    // of an object of $att, ($r, $g, $b) the new color.
    //
    // In the palette of $img, the color matching with $id_zone_geo is modified. 
    //==============================================================================
    
    function _remplacerCouleur(&$image, &$atta, $id_zone_geo, $rouge, $vert, $bleu, $id_zone_a_reperer) 
    {
        // Nous recherchons la valeur de l'index.
        
        $index = -1;
        for ($i = 0; $i < count ($atta); $i++) {
            if ($atta[$i]->id_zone == $id_zone_geo) {
                $index = $atta[$i]->index;
                //Dans le cas où nous voulons repérer une zone sur la carte :
                if($id_zone_geo == $id_zone_a_reperer) {
                    $rouge = 255;
                    $vert = 0;
                    $bleu = 0;
                }
                break;
            }
        }
        
        // Nous mettons à jour l'image de la carte avec la valeur de l'index.
        
        if ($index >= 0) {
            imagecolorset (&$image, $index, $rouge, $vert, $bleu);
        }
        
    }//Fin de la méthode _remplacerCouleur
    
    //==============================================================================
    // METHODE _donnerIdUnique ()
    //
    // Cette méthode privée retourne un identifiant de 32 caractères unique.
    //
    //==============================================================================
    
    function _donnerIdUnique() 
    {
        $id = '';
        $id = md5 (uniqid (rand()));
        
        return $id;
    }//Fin de la méthode _donnerIdUnique()


}//Fin de la classe Carto_Carte()

//==============================================================================
// La classe Carto_InformationCouleur n'est utilisée que par la classe carte.
// C'est une classe privée.
// Elle sert à stocker les informations (RVB et index) sur la couleur d'une 
// zone d'une image.
//==============================================================================

class Carto_InformationCouleur
{
    /*|=============================================================================================|*/
    /*|                                LES ATTRIBUTS DE LA CLASSE                                   |*/
    /*|---------------------------------------------------------------------------------------------|*/
    
    var $id_zone;
    var $rouge;
    var $vert;
    var $bleu;
    var $index;
    
    /*|=============================================================================================|*/
    /*|                                LE CONSTRUCTEUR DE LA CLASSE                                 |*/
    /*|---------------------------------------------------------------------------------------------|*/
    
    function Carto_InformationCouleur($id_zone, $rouge, $vert, $bleu) 
    {
        $this->id_zone    = $id_zone;
        $this->rouge     = $rouge;
        $this->vert = $vert;
        $this->bleu    = $bleu;
        $this->index = -1;
    }
    
}//Fin de la classe Carto_InformationCouleur


//==============================================================================
// FUNCTION carto_errorMsg ()
//
// Return an error message about carto management.
//==============================================================================

function carto_errorMsg() 
{
    global $PRIVATE_CARTO_ERROR;

    return $PRIVATE_CARTO_ERROR;
}

//==============================================================================
// FUNCTION carto_putErrorImage ()
//
// Dump a default error image.
//==============================================================================

function carto_putErrorImage() 
{
    $img = '47494638396120002000800100ff000000006621f90401000001002c000000002000'.
            '200040026d848fa99be11f009c53524373b41ae2da65dcf345e1693aa536aae77ab1'.
            'e1d7a2a22ad5f60deb6fe54bc958418f0b05bb9190bee2f1327276a2c91db16a855a'.
            'a4489c31bb24d5b8614fb32b2a9ea7d228738785dab673e7f81554b395682008dc52'.
            '4236b4210416c390a8a85000003b';
    
    header ('Content-Type: image/gif');
    
    echo gs_hex2bin($img);
}

//==============================================================================
//==============================================================================
// Les fonctions qui suivent permettent de recuperer des infos (nom de l'image,
// du masque, du niveau ou du titre) d'une carte.
//==============================================================================
//==============================================================================

function carto_consulterTitreCarte($id_carte) 
{
    global $NOM_FICHIER;
    
    $requete =
    'SELECT * '.
    ' FROM carto_DESCRIPTION_CARTE'.
    ' WHERE CDC_ID_Carte = "'.$id_carte.'"';
    
    $resultat = mysql_query ($requete) or die('
            <H2 style="text-align: center; font-weight: bold; font-size: 26px;">Erreur de requête</H2>'.
            '<b>Nom du fichier : </b> '.$NOM_FICHIER.'<br/>'.
            '<b>Nom fonction : </b> carto_consulterTitreCarte<br/>'.
            '<b>Requete : </b>'.$requete.
            '<br/><br/><b>Erreur : </b>'.mysql_error());
    
    $ligne = mysql_fetch_object ($resultat);
    
    $titre_carte = $ligne->CDC_Titre_carte;
    
    return $titre_carte;
}

function carto_consulterFichierFond($id_carte) 
{
    global $NOM_FICHIER;
    
    $requete =
        'SELECT * '.
        ' FROM carto_DESCRIPTION_CARTE'.
        ' WHERE CDC_ID_Carte = "'.$id_carte.'"';
    
    $resultat = mysql_query ($requete) or die('
            <H2 style="text-align: center; font-weight: bold; font-size: 26px;">Erreur de requête</H2>'.
            '<b>Nom du fichier : </b> '.$NOM_FICHIER.'<br/>'.
            '<b>Nom fonction : </b> carto_consulterFichierFond<br/>'.
            '<b>Requete : </b>'.$requete.
            '<br/><br/><b>Erreur : </b>'.mysql_error());
    
    $ligne = mysql_fetch_object ($resultat);
    
    $nom_fichier_carte_fond = $ligne->CDC_Carte_fond;
    
    return $nom_fichier_carte_fond;
}

function carto_consulterFichierMasque($id_carte) 
{
    global $NOM_FICHIER;
    
    $requete =
        'SELECT * '.
        ' FROM carto_DESCRIPTION_CARTE'.
        ' WHERE CDC_ID_Carte = "'.$id_carte.'"';
    
    $resultat = mysql_query ($requete) or die('
            <H2 style="text-align: center; font-weight: bold; font-size: 26px;">Erreur de requête</H2>'.
            '<b>Nom du fichier : </b> '.$NOM_FICHIER.'<br/>'.
            '<b>Nom fonction : </b> carto_consulterFichierMasque<br/>'.
            '<b>Requete : </b>'.$requete.
            '<br/><br/><b>Erreur : </b>'.mysql_error());
    
    $ligne = mysql_fetch_object ($resultat);
    
    $nom_fichier_carte_masque = $ligne->CDC_Carte_masque;
    
    return $nom_fichier_carte_masque;
}

function carto_consulterTypeZoneCarte($id_carte) 
{
    global $NOM_FICHIER;
    
    $requete =
        'SELECT * '.
        ' FROM carto_DESCRIPTION_CARTE'.
        ' WHERE CDC_ID_Carte = "'.$id_carte.'"';
    
    $resultat = mysql_query($requete) or die('
            <H2 style="text-align: center; font-weight: bold; font-size: 26px;">Erreur de requête</H2>'.
            '<b>Nom du fichier : </b> '.$NOM_FICHIER.'<br/>'.
            '<b>Nom fonction : </b> carto_consulterTypeZoneCarte<br/>'.
            '<b>Requete : </b>'.$requete.
            '<br/><br/><b>Erreur : </b>'.mysql_error());
    
    $ligne = mysql_fetch_object($resultat);
    
    $type_zone_carte = $ligne->CDC_Type_zone_carte;
    
    return $type_zone_carte;
}

function carto_consulterIdZoneGeoCarte($id_carte) 
{
    global $NOM_FICHIER;
    
    $requete =
        'SELECT * '.
        ' FROM carto_DESCRIPTION_CARTE'.
        ' WHERE CDC_ID_Carte = "'.$id_carte.'"';
    
    $resultat = mysql_query($requete) or die('
            <H2 style="text-align: center; font-weight: bold; font-size: 26px;">Erreur de requête</H2>'.
            '<b>Nom du fichier : </b> '.$NOM_FICHIER.'<br/>'.
            '<b>Nom fonction : </b> carto_consulterIdZoneGeoCarte<br/>'.
            '<b>Requete : </b>'.$requete.
            '<br/><br/><b>Erreur : </b>'.mysql_error());
    
    $ligne = mysql_fetch_object ($resultat);
    
    $id_zone_carte = $ligne->CDC_ID_Zone_geo_carte;
    return $id_zone_carte;
}

//-- Fin du code source  ------------------------------------------------------------
/*
* $Log: lib.carto.php,v $
* Revision 1.9  2007/04/20 14:16:45  alexandre_tb
* compatibilite php4 php5
*
* Revision 1.8  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.5  2006/12/01 13:23:16  florian
* integration annuaire backoffice
*
* Revision 1.4  2006/04/04 12:23:05  florian
* modifs affichage fiches, gÃ©nÃ©ricitÃ© de la carto, modification totale de l'appli annuaire
*
* Revision 1.3  2005/12/07 14:59:14  alexandre_tb
* suppression d'un echo
*
* Revision 1.2  2005/11/24 16:17:52  florian
* changement template inscription + modifs carto
*
* Revision 1.1  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.2  2005/09/22 13:30:49  florian
* modifs pour compatibilitÃ© XHTML Strict + corrections de bugs (mais ya encore du boulot!!)
*
* Revision 1.1  2004/12/15 13:30:20  alex
* version initiale
*
* Revision 1.17  2003/05/16 13:17:40  jpm
* Correction d'une erreur (des guillemets en trop).
*
* Revision 1.16  2003/03/14 14:12:14  jpm
* Correction bug : le nom de la zone ne restait pas dans la liste déroulante.
*
* Revision 1.15  2003/03/11 14:49:47  jpm
* Simplification de l'interface.
*
* Revision 1.14  2003/03/07 15:10:24  jpm
* Ajout de commentaires : "à faire"
*
* Revision 1.13  2003/03/04 16:14:06  alex
* Utilisation de la fonction cxt_clearVariable à la place de cxt_clear
*
* Revision 1.12  2003/03/04 08:09:39  jpm
* Ajout suppression des fichiers carto du dossier carto temporaire.
*
* Revision 1.11  2003/02/26 12:12:38  jpm
* Ajout de la gestion des listes déroulantes représentant la zone géographique
* à éditer.
*
* Revision 1.10  2003/02/21 13:50:57  jpm
* Mise à jour nouvel objet Carto_Carte.
*
* Revision 1.8  2003/02/14 08:01:14  jpm
* Changement des noms de méthode selon les recommandations de PEAR.
* Ajout d'attributs à la classe.
* Ajout de la possibilité de redéfinir les couleurs de coloriage d'une carte.
* Ajout de la possibilité de désigner une formule mathématique de coloriage.
*
* Revision 1.7  2003/02/12 18:15:56  jpm
* Meilleure gestion de l'obtentions des valeurs minimum, medium et maximum
* pour l'ensemble des zones géographiques d'une carte.
* Ajout de commentaires.
* Meilleure gestion des erreurs de requêtes.
*
*
*/
?>