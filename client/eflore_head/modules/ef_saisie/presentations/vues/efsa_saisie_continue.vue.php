<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of project_name.                                                                |
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
// CVS : $Id: efsa_saisie_continue.vue.php,v 1.5 2007-02-07 18:04:44 jp_milcent Exp $
/**
* project_name
*
*@package project_name
*@subpackage 
//Auteur original :
*@author        David DELON <dd@clapas.net>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.5 $ $Date: 2007-02-07 18:04:44 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueSaisieContinue extends aVue {
	
	public function __construct($Registre)
	{
		$this->setNom('saisie_continue');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		
		$bool_projet_multiple = false;
		foreach ($this->getDonnees('referenciels') as $referenciel) {
			foreach ($referenciel['versions'] as $version) {
				if (count($this->getDonnees('referenciels')) > 1 || count($referenciel['versions']) > 1) {
					$bool_projet_multiple = true;
					$squelette->setCurrentBlock('REFERENCIEL') ;
					$squelette->setVariable('EFLORE_REF_MULTIPLE_ABREVIATION', $referenciel['abreviation']);
					$squelette->setVariable('EFLORE_REF_MULTIPLE_VERSION', $version['code']);
					$squelette->setVariable('EFLORE_REF_MULTIPLE_INTITULE', $referenciel['intitule']);
					$squelette->setVariable('EFLORE_REF_MULTIPLE_ID', $version['id']);
					if ($bool_projet_multiple) {
						if ($GLOBALS['eflore_referenciel'] == $version['id']) {
							$squelette->setVariable('EFLORE_REF_MULTIPLE_SELECTED', 'id="eflore_referenciel" selected="selected"');
							// Ajout du nom du référenciel courant à la la variable globale pour l'affichage du 
							// "résumé de la recherche"'
							// TODO : améliorer la gestion des cette variable. Il faudrait au moins utiliser $GLOBALS['_EFLORE_']
							$GLOBALS['eflore_referenciel_nom']['intitule'] = $referenciel['intitule'];
							$GLOBALS['eflore_referenciel_nom']['abreviation'] = $referenciel['abreviation'];
							$GLOBALS['eflore_referenciel_nom']['code'] = $version['code'];
						} else {
							$squelette->setVariable('EFLORE_REF_MULTIPLE_SELECTED', '');
						}
					}
					$squelette->parseCurrentBlock('REFERENCIEL');
				} else {
					$squelette->setCurrentBlock('REFERENCIEL_UNIQUE');
					//$squelette->setVariable('EFLORE_REF_UNIQUE_ABREVIATION', $referenciel['abreviation']);
					//$squelette->setVariable('EFLORE_REF_UNIQUE_VERSION', $version['code']);
					//$squelette->setVariable('EFLORE_REF_UNIQUE_INTITULE', $referenciel['intitule']);
					$squelette->setVariable('EFLORE_REF_UNIQUE_ID', $version['id']);
					$squelette->parseCurrentBlock('REFERENCIEL_UNIQUE');
					// Ajout du nom du référenciel courant à la la variable globale pour l'affichage du 
					// "résumé de la recherche"'
					// TODO : améliorer la gestion des cette variable. Il faudrait au moins utiliser $GLOBALS['_EFLORE_']
					$GLOBALS['eflore_referenciel_nom']['intitule'] = $referenciel['intitule'];
					$GLOBALS['eflore_referenciel_nom']['abreviation'] = $referenciel['abreviation'];
					$GLOBALS['eflore_referenciel_nom']['code'] = $version['code'];
				}

			}
		}
		if ($bool_projet_multiple) {
			$squelette->setCurrentBlock('REFERENCIEL_MULTIPLE');
			$squelette->parseCurrentBlock('REFERENCIEL_MULTIPLE');
		}
		// +------------------------------------------------------------------------------------------------------+
		// Ajout du paramêtre action à l'url courante.
		$squelette->setCurrentBlock();
		$url_completion = clone $GLOBALS['_EFLORE_']['url_base'];
		$url_completion->addQueryString(EF_LG_URL_MODULE, EF_LG_URL_MODULE_RECHERCHE);
		$url_completion->addQueryString(EF_LG_URL_ACTION, 'completion_nom_latin' );
		$url_completion->addQueryString('referentiel','');
		
		$squelette->setVariable('URL_COMPLETION_PREFIXE', str_replace ('&amp;', '&', $url_completion->getURL()));
		$squelette->setVariable('URL_COMPLETION_PARAM', '&nom=');
		
		$url_nomenclatural = clone $GLOBALS['_EFLORE_']['url_base'];
		$url_nomenclatural->addQueryString(EF_LG_URL_MODULE, 'saisie');
		$url_nomenclatural->addQueryString(EF_LG_URL_ACTION, 'information_numero_nomenclatural' );
		$url_nomenclatural->addQueryString('eflore_numero_nomenclatural','');
		$url_nomenclatural->removeQueryString('menu');
		$squelette->setVariable('URL_NOMENCLATURAL', str_replace ('&amp;', '&', $url_nomenclatural->getURL()));
		
		$squelette->setVariable('EF_URL_JS', EF_URL_JS);
		$squelette->parseCurrentBlock();
	}
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efsa_saisie_continue.vue.php,v $
* Revision 1.5  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.4.2.1  2007/02/02 14:34:46  jp_milcent
* Correction ajout du nom valide.
*
* Revision 1.4  2006/12/27 14:07:13  jp_milcent
* Ajout de la sélection du référentiel.
*
* Revision 1.3  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.2  2006/04/26 16:57:04  ddelon
* Fusion bdnbe + saisie assistee
*
* Revision 1.1.2.4  2006/04/25 12:44:52  ddelon
* saisie en masse
*
* Revision 1.1.2.3  2006/04/21 22:52:37  ddelon
* cetace
*
* Revision 1.1.2.2  2006/04/21 22:48:58  ddelon
* bug url base
*
* Revision 1.1.2.1  2006/04/21 20:50:28  ddelon
* Saisie continue
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>