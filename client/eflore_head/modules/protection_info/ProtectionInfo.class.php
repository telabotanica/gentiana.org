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
// CVS : $Id: ProtectionInfo.class.php,v 1.2 2007-06-11 16:37:17 jp_milcent Exp $
/**
* eflore_bp - Protection.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.2 $ $Date: 2007-06-11 16:37:17 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class ProtectionInfo extends aModule {
	private $nt = '';
	private $nvp = '';
	private $squelette = '';
		
	public static function getAppletteBalise()
    {
    	return '\{\{ProtectionInfo(?:\s*(?:(action="[^"]+")|(squelette="[^"]+")|(nvp="[^"]+")|(nt="[^"]+")|))+\s*\}\}';
    }
    
    // La méthode executer est appellé par défaut 
    public function executer()
    {
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des paramêtres de l'applette
		$this->getRegistre()->set('squelette_fichier', 'tableau_protection');

		if ($this->getRegistre()->get('applette_parametre')) {
			$aso_param = $this->getRegistre()->get('applette_parametre');
			$this->nvp = $aso_param['nvp'];
			$this->nt = $aso_param['nt'];
			$this->squelette = $aso_param['squelette'];
			if ($this->squelette != '') {
				$this->getRegistre()->set('squelette_fichier', $this->squelette);
			}
		}
				
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$aso_donnees = array();
		$aso_donnees['info'] = false;
		$protections = array();
		
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des mesures de protections
		$Protection = new EfloreProtection();
		$protections = $Protection->recupererProtections((int)$this->nt, (int)$this->nvp);
		
		// Gestion du block protections
		if ($protections) {
			$aso_donnees['url_js'] = EF_URL_JS;
			foreach ($protections as $aso_protection) {
				if (strlen($aso_protection['txt_appli_intitule']) > 50) {
					$aso_protection['loi_intitule'] = substr($aso_protection['txt_appli_intitule'], 0, 50).' ...';
				} else {
					$aso_protection['loi_intitule'] = $aso_protection['txt_appli_intitule'];
				}
				$aso_protection['loi_description'] = 'Nom : '.$aso_protection['txt_appli_description']."\n";
				$aso_protection['loi_intitule_long'] = 'Nom : '.$aso_protection['txt_appli_intitule']."\n";
				$aso_protection['loi_intitule_long_ss_ajout'] = $aso_protection['txt_appli_intitule'];
				$aso_protection['loi_abreviation'] = 'Code Tela Botanica : '.$aso_protection['txt_appli_abreviation']."\n";
				$aso_protection['loi_url'] = $aso_protection['txt_appli_url'];
				$aso_protection['loi_nor'] = '';
				if ($aso_protection['txt_appli_nor'] != '' ) {
					$aso_protection['loi_nor'] = 'NOR : '.$aso_protection['txt_appli_nor']."\n";
				}
				$aso_protection['statut_abreviation'] = 'Code Tela Botanica : '.$aso_protection['statut_abreviation']."\n";
				
				$aso_donnees['protections'][] = $aso_protection;
			}
		} else {
			$aso_donnees['info'] = true;
			$aso_donnees['info_txt'] = 'Aucune information disponible concernant le statut de protection.';
		}
		
		$this->getRegistre()->set('squelette_donnees', $aso_donnees);
    }
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ProtectionInfo.class.php,v $
* Revision 1.2  2007-06-11 16:37:17  jp_milcent
* Ajout d'un squelette spécial pour la page de synthèse.
*
* Revision 1.1  2007-06-11 15:41:10  jp_milcent
* Ajout du module affichant les informations sur les statuts de protection d'une plante.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
