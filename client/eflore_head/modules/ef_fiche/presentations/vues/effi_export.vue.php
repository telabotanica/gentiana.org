<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                         |
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
// CVS : $Id$
/**
* Titre
*
* Description
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
require_once EF_CHEMIN_BIBLIO_FPDF.'fpdf.php';
require_once EF_CHEMIN_BIBLIO_FPDI.'fpdi.php';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class VueExport extends aVue {

	public function __construct($Registre)
	{
		$this->setNom('export');
		switch ($Registre->get('vue_format')) {
			case 'pdf' :
				$this->setMoteurTpl(aVue::TPL_FPDI);
				break;
		}		
		parent::__construct($Registre);
	}
	
	public function preparer()
	{
		// Récupération d'une référence au squelette
		$pdf = $this->getSquelette();
		$tplidx = $pdf->ImportPage(1);
		$pdf->addPage();
		$s = $pdf->useTemplate($tplidx);
		$pdf->SetFont('Arial');
		$pdf->SetFillColor(230, 231, 230);
		
		// Encodage de sortie
		$encodage = 'ISO-8859-15';
		if (EF_LANGUE_UTF8 && $GLOBALS['_EFLORE_']['encodage'] == 'HTML-ENTITIES') {
			$encodage = 'ISO-8859-15';
		}
		
		// Récupération de données
		$tab_noms_verna = $this->getDonnees('noms_verna');
		$ref_intitule_court = 	$this->getDonnees('pr_abreviation').'  v'.$this->getDonnees('prv_code');

		// Titre
		if (isset($tab_noms_verna[0])) {
			$titre = $tab_noms_verna[0];
		} else {
			if ($_SESSION['NomSelection']->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE) != $_SESSION['NomRetenu']->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE)) {
				$titre = $_SESSION['NomSelection']->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE).' = '.$_SESSION['NomRetenu']->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE);
			} else {
				$titre = $_SESSION['NomRetenu']->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE);
			}
		}
		$pdf->setXY(10, 42);
		$pdf->SetFillColor(223, 203, 238);
		$pdf->Cell(190, 6, $titre, 1, 1, 'C', 1);

		// Création de la TaxoBox
		$pdf->SetFillColor(230, 231, 230);
		$pdf->Rect(10, 50, 44, 220, 'DF');

		// Gestion du block photo
		if (count($this->getDonnees('photoflora')) != 0) {
			foreach ($this->getDonnees('photoflora') as $photo_id => $photo_info) {
				//$pdf->Cell(0, 6, $photo_info['url_miniature'], 0, 1);
				if (strstr($photo_info['url_miniature'], '.png')) {
					if (file_exists($photo_info['fichier_local'])) {
						$image = $photo_info['fichier_local'];
					} else {
						$img = imagecreatefrompng($photo_info['url_miniature']);
						$this->imagegreyscale($img);
						if (imagepng($img, $photo_info['fichier_local'])) {
							$image = $photo_info['fichier_local'];
						}
					}
				} else {
					$image = $photo_info['url_miniature'];
				}
			}
			//$pdf->Error(print_r($this->getDonnees('photoflora'),true));
			$pdf->SetFillColor(0, 0, 0);
			$pdf->Rect(11, 51, 42, 52, 'DF');
			$pdf->Image($image, 12, 52, 40, 50);
		} else {
			$pdf->SetFillColor(0, 0, 0);
			$pdf->Rect(11, 51, 42, 52, 'DF');
			$pdf->setXY(12, 72);
			$pdf->SetFont('Arial', '', 10);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->Cell(40, 8, 'Illustration indisponible', 1, 1, 'C', 1);
			$pdf->SetTextColor(0, 0, 0);
		}

		// Gestion de la classification
		$pdf->setXY(11, 104);
		$pdf->SetFillColor(223, 203, 238);
		$pdf->Cell(42, 8, 'Classification', 1, 1, 'C', 1);
		$pdf->SetFillColor(230, 231, 230);
		foreach ($this->getDonnees('classification') as $tab_classif) {
			if (is_object($tab_classif['nom'])) {
				$pdf->SetFont('Arial', 'B', 6);
				$pdf->setX(11);
				$pdf->Cell(42, 4, ucfirst($tab_classif['rang']).' :', 'LR', 1, 'L', 1);
				$pdf->SetFont('Arial', '', 6);
				$pdf->setX(11);				
				$pdf->Cell(42, 4, $tab_classif['nom']->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE), 'LRB', 1, 'C', 1, $tab_classif['url']);
			}
		}
		$y = $pdf->getY();
		
		// Gestion du block choro
		if ($this->getDonnees('carto_bool') == true) {
			//$pdf->Cell(0, 6, $this->getDonnees('carte_france'), 0, 1);
			$pdf->Image($this->getDonnees('carte_france'), 12, $y+2, 40, 35, null, $this->getDonnees('url_carte'));
			$pdf->setXY(12, $y+2+35);
			$y_cadre_debut = $y;
			foreach ($this->getDonnees('legende') as $legende) {
				$y = $pdf->getY();
				$pdf->SetDrawColor(0, 0, 0);
				$pdf->SetFillColor($legende['couleur']['R'], $legende['couleur']['V'], $legende['couleur']['B']);
				$pdf->Rect(12, $y+2, 5, 5, 'DF');
				$pdf->setXY(18, $y+2);
				$pdf->Cell(28, 5, mb_convert_encoding($legende['intitule'], $encodage, 'ISO-8859-15'), 0, 1, 'L', 0);
			}
			$y_cadre_fin = $pdf->getY();
			$h = $y_cadre_fin - $y_cadre_debut;
			$pdf->Rect(11, $y_cadre_debut+1, 42, $h, 'D');
		}

		// Gestion du "nom sélectionné"
		$pdf->setXY(60, 50);
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(50, 8, mb_convert_encoding('Nom sélectionné : ', $encodage, 'ISO-8859-15'), 0, 1, 'L', 0);
		$pdf->SetFont('Arial', '', 12);
		$pdf->setX(65);
		$pdf->Cell(100, 8, $this->getDonnees('nom_selection_nf'), 0, 1, 'L', 0);

		// Gestion du "nom retenu"
		$pdf->setX(60);
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(50, 8, 'Nom retenu ('.$ref_intitule_court.') :', 0, 1, 'L', 0);
		$pdf->SetFont('Arial', '', 12);
		$pdf->setX(65);
		$pdf->Cell(100, 8, $this->getDonnees('nom_retenu_nf'), 0, 1, 'L', 0);

		// Gestion des correspondances
		$pdf->setX(60);
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(50, 8, 'Correspondances :', 0, 1, 'L', 0);
		$pdf->SetFont('Arial', '', 8);		
		foreach ($this->getDonnees('referentiels') as $referentiel) {
			$ref_corres_intitule_court = $referentiel['pr_abreviation'].'  v'.$referentiel['prv_code'];
			$correspondance = $ref_corres_intitule_court.' : '.$referentiel['nom_nf'];
			$pdf->setX(65);
			$pdf->Cell(100, 8, $correspondance, 0, 1, 'L', 0);
		}
		
		// Gestion des liens permanents
		$pdf->setX(60);
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(50, 8, 'Liens permanents :', 0, 1, 'L', 0);
		$pdf->SetFont('Arial', '', 8);
		$pdf->setX(65);
		$pdf->Cell(100, 8, $this->getDonnees('url_permalien_nn'), 0, 1, 'L', 0, $this->getDonnees('url_permalien_nn'));
		$pdf->setX(65);
		$pdf->Cell(100, 8, $this->getDonnees('url_permalien_nt'), 0, 1, 'L', 0, $this->getDonnees('url_permalien_nt'));

		// Gestion de la synonymie
		$aso_type_syno = array(	'ST_NR' => 'Statut non renseigné', 
								'ST_I' => 'Statut inconnu', 
								'ST_P' => 'Statut posant problème', 
								'ST' => 'Synonymes taxonomiques', 
								'SN' => 'Synonymes nomenclaturaux', 
								'SI' => 'Synonymes indéterminés', 
								'SID' => 'Synonymes "inclu dans"', 
								'SASD' => 'Synonymes "au sens de (sensu)"', 
								'SP' => 'Synonymes provisoire');
		$pdf->setX(60);
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(50, 8, 'Synonymie du nom retenu :', 0, 1, 'L', 0);
		$bool_syno = true;
		foreach ($aso_type_syno as $abbr => $titre_syno) {
			if (count($this->getDonnees(strtolower($abbr)))) {
				$bool_syno = false;
				$pdf->setX(65);
				$pdf->SetFont('Arial', 'B', 12);
				$pdf->Cell(50, 6, mb_convert_encoding($titre_syno, $encodage, 'ISO-8859-15'), 0, 1, 'L', 0);
			}
			foreach ($this->getDonnees(strtolower($abbr)) as $nom) {
				$pdf->SetFont('Arial', '', 8);
				$pdf->setX(70);
				$pdf->Cell(100, 4, $nom['nom']->formaterNom(NomDeprecie::FORMAT_COMPLET), 0, 1, 'L', 0, $nom['url']);
			}
		}
		if ($bool_syno) {
			$pdf->SetFont('Arial', '', 8);
			$pdf->setX(70);
			$pdf->Cell(100, 4, 'Aucune synonymie...', 0, 1, 'L', 0);
		}
	}
	
	private function imagegreyscale(&$img, $dither = 1) {   
		if (!($t = imagecolorstotal($img))) {
			$t = 256;
			imagetruecolortopalette($img, $dither, $t);   
		}
		for ($c = 0; $c < $t; $c++) {   
			$col = imagecolorsforindex($img, $c);
			$min = min($col['red'],$col['green'],$col['blue']);
			$max = max($col['red'],$col['green'],$col['blue']);
			$i = ($max+$min)/2;
			imagecolorset($img, $c, $i, $i, $i);
		}
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.8  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.7  2007-06-11 12:46:27  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.6.2.2  2007-06-08 09:45:33  jp_milcent
* Amélioration encodage.
*
* Revision 1.6.2.1  2007-06-08 09:41:03  jp_milcent
* Début gestion encodage pour le pdf.
*
* Revision 1.6  2007-01-17 17:54:27  jp_milcent
* Fusion avec la livraison Passy avant nouvelle livraison.
*
* Revision 1.5.2.1  2006/11/20 13:42:57  jp_milcent
* Correction erreur génération image png pour le pdf.
*
* Revision 1.5  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.4.2.3  2006/08/29 13:00:18  jp_milcent
* Changement de la taille des noms pour la correspondance.
*
* Revision 1.4.2.2  2006/08/29 12:25:09  jp_milcent
* Correction bogue illustration manquante.
* Correction décalage du cadre classification.
*
* Revision 1.4.2.1  2006/07/27 10:13:29  jp_milcent
* Correction bogue sur la récupération du nom retenu et du nom sélectionné.
*
* Revision 1.4  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.3  2006/06/20 16:28:21  jp_milcent
* Amélioration export.
* Meilleure gestion des images png à modifier.
*
* Revision 1.2  2006/05/16 09:27:33  jp_milcent
* Gestion des correspondances.
* Ajout du plier/deplier.
*
* Revision 1.1  2006/05/11 10:28:26  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
