<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.3                                                                                      |
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
// CVS : $Id: BOG_Gestionnaire_Erreur.class.php,v 1.7 2007-08-28 14:03:33 jp_milcent Exp $
/**
* Classe permettant de créer un gestionnaire d'erreur PHP
*
* La classe permet de créer un gestionnaire d'erreur PHP et de le configurer.
*
*@package Debogage
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.7 $ $Date: 2007-08-28 14:03:33 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class BOG_Gestionnaire_Erreur {
    // Attributs
    var $tab_erreurs = array();
    var $erreur_txt_tete = '';
    var $erreur_txt_pied = '';
    var $bln_contexte = false;
    var $langue = 'fr';
    var $aso_trad = array(  'niveau'=> 'Niveau d\'erreur : ', 'fichier' => 'Nom du fichier : ',
                            'ligne' => 'N° de ligne : ', 'contexte' => 'Contexte d\'erreur : ');
    var $class = 'erreur';
    var $active = 1;
    
    // Constructeur
    function BOG_Gestionnaire_Erreur($bln_contexte, $class = '', $langue = 'fr', $txt_tete = '', $txt_pied = '', $aso_trad = array())
    {
        $this->ecrireContexte($bln_contexte);
        $this->ecrireLangue($langue);
        $this->ecrireTxtTete($txt_tete);
        $this->ecrireTxtPied($txt_pied);
        if (count($aso_trad) != 0) {
            $this->ecrireTraduction($aso_trad);
        }
        if (! empty($class)) {
            $this->ecrireClass($class);
        }
        
        set_error_handler(array(&$this, 'gererErreur'));
    }
    
    // Accesseurs
    
    function setActive($active)
    {
        $this->active=$active;
    }
    
    
    function ecrireErreur($aso_erreur)
    {
        array_push($this->tab_erreurs, $aso_erreur);
    }
    
    function lireTableauErreurs()
    {
        return $this->tab_erreurs;
    }
    function lireTxtTete()
    {
        return $this->erreur_txt_tete;
    }
    function ecrireTxtTete($txt_tete)
    {
        $this->erreur_txt_tete = $txt_tete;
    }
    function lireTxtPied()
    {
        return $this->erreur_txt_pied;
    }
    function ecrireTxtPied($txt_pied)
    {
        $this->erreur_txt_pied = $txt_pied;
    }
    function lireContexte()
    {
        return $this->bln_contexte;
    }
    function ecrireContexte($bln)
    {
        $this->bln_contexte = $bln;
    }
    function lireTraduction($cle)
    {
        return $this->aso_trad[$cle];
    }
    function ecrireTraduction($tab_trad)
    {
        $aso_trad['niveau'] = $tab_trad[0];
        $aso_trad['fichier'] = $tab_trad[1];
        $aso_trad['ligne'] = $tab_trad[2];
        $aso_trad['contexte'] = $tab_trad[3];
        $this->aso_trad = $aso_trad;
    }
    function lireClass()
    {
        return $this->class;
    }
    function ecrireClass($class)
    {
        $this->class = $class;
    }
    function lireLangue()
    {
        return $this->langue;
    }
    function ecrireLangue($langue)
    {
        $this->langue = $langue;
    }
    
    // Méthode
    function gererErreur($niveau, $message, $fichier, $ligne, $contexte)
    {
    	if ($this->active) {
	    	// Ouais bof le test, mais php5 renvoie vraiment trop de message d'erreur sur Deprecated ... et 
	    	// ca concerne essentiellement les classes pear !
	    	
	    	if (!defined('E_STRICT')) {
	    		define("E_STRICT", 2048);
	    	}
	    	
			if ($niveau < E_STRICT) {
	    	
		        $aso_erreur = array();
		        $aso_erreur['niveau'] = $niveau;
		        $aso_erreur['message'] = $message;
		        $aso_erreur['fichier'] = $fichier;
		        $aso_erreur['ligne'] = $ligne;
		        if ($this->lireContexte()) {
		            $aso_erreur['contexte'] = $contexte;
		        }
		        $this->ecrireErreur($aso_erreur);
		        
			}
    	}
    }
    
    function retournerErreurs()
    {
        $contenu = '';
        foreach($this->lireTableauErreurs() as $aso_erreur) {
            switch (PAP_DEBOGAGE_TYPE) {
            	case 'FIREBUG':
            		$contenu .= 	"console.info(\"[Buggy] - ".
						"Niveau : ".$aso_erreur['niveau']." - ".
						"Fichier : ".$aso_erreur['fichier']." - ".
						"Ligne :".$aso_erreur['ligne']." - ".
						"Message : ".$aso_erreur['message']." - ".
						"\");\n";
					break;
            	case 'HTML':
            	default:
	            	$contenu .= '<p class="'.$this->lireClass().'">'."\n";
		            $contenu .= '<strong>'.$this->lireTxtTete().$aso_erreur['message'].$this->lireTxtPied().'</strong><br />'."\n";
		            $contenu .= '<strong>'.$this->lireTraduction('niveau').'</strong>'.$aso_erreur['niveau'].'<br />'."\n";
		            $contenu .= '<strong>'.$this->lireTraduction('fichier').'</strong>'.$aso_erreur['fichier'].'<br />'."\n";
		            $contenu .= '<strong>'.$this->lireTraduction('ligne').'</strong>'.$aso_erreur['ligne'].'<br />'."\n";
		            if ($this->lireContexte()) {
		                $contenu .= '<pre>'."\n";
		                $contenu .= '<stong>'.$this->lireTraduction('contexte').'</stong>'.print_r($aso_erreur['contexte'], true)."\n";
		                $contenu .= '</pre>'."\n";
		            }
	            	$contenu .= '</p>'."\n";
            }
            
        }
        switch (PAP_DEBOGAGE_TYPE) {
        	case 'FIREBUG':
        		$retour = '<script type="text/javascript">'."\n".$contenu.'</script>'."\n";
				break;
        	case 'HTML':
        	default:
            	$retour = $contenu;
		}
        return $retour;
    }
}


// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: BOG_Gestionnaire_Erreur.class.php,v $
* Revision 1.7  2007-08-28 14:03:33  jp_milcent
* Ajout du type de script utilisé côté client.
*
* Revision 1.6  2007-03-01 11:07:43  jp_milcent
* Gestion de deux types de débogage : html ou firebug.
*
* Revision 1.5  2005/09/20 20:25:39  ddelon
* php5 et bugs divers
*
* Revision 1.4  2005/09/20 17:01:22  ddelon
* php5 et bugs divers
*
* Revision 1.3  2004/11/29 15:56:23  jpm
* Correction bogue.
*
* Revision 1.2  2004/11/29 15:54:16  jpm
* Changement de nom de variable et légère correction.
*
* Revision 1.1  2004/11/15 17:12:46  jpm
* Classe de gestion d'erreur pour PHP 4.3
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>