<?php
// +----------------------------------------------------------------------------+
// |pdf_recu_et_mail.php												        |
// +----------------------------------------------------------------------------+
// | Copyright (c) 2003 Tela Botanica								            |
// +----------------------------------------------------------------------------+
// | Ce fichier génère un fichier PDF                                           |
// | contenant le recu pour une cotisation à Tela Botanica                      |
// | Il utilise la librairie FPDF                                               |
// | http://www.fpdf.org/                                                       |
// | Il envoie également un email à l'adhérent concerné                         |
// +----------------------------------------------------------------------------+
// | Auteur : Alexandre Granier <alexandre@tela-botanica.org> 	            	|
// +----------------------------------------------------------------------------+
//
// $Id: recu_pdf_corps.php,v 1.1 2005/09/22 14:02:49 ddelon Exp $


// Recherche des informations sur un utilisateur

$requete = "select * from annuaire_COTISATION, annuaire_tela, MODE_COTISATION
            where IC_ID=$cotisation_id
            and IC_ANNU_ID=U_ID
            and IC_MC_ID=MC_ID" ;
$resultat = $db->query($requete) ;
if (DB::isError ($resultat)) {
    die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
}
$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ;
$resultat->free() ;

/*
// On regarde si le reçu a déjà été envoyé
$requete = "select IC_RECU from annuaire_COTISATION where IC_ID=$cotisation_id" ;
$resultat = mysql_query ($requete) or die ($requete."<br>".mysql_error()) ;
$ligne = mysql_fetch_object($resultat) ;
mysql_free_result($resultat) ;
*/

if ($ligne->IC_RECU != 0) {
    $num_recu = $ligne->IC_RECU ;
    // $deja_envoye permettra au programme admin_annu.php de ne pas incrementé
    // le compteur de recu
    $deja_envoye = true ;
} else {
    $res_compteur = $db->query("select COMPTEUR from COMPTEUR_COTISATION") ;
    $ligne_compteur = $res_compteur->fetchRow(DB_FETCHMODE_OBJECT) ;
    $num_recu = $ligne_compteur->COMPTEUR ;
    $deja_envoye = false ;
}

@include_once "api/fpdf/fpdf.php";

if (!isset($envoie)) $chemin = "client/annuaire/" ;

// Constante nécessaire à fpdf.php
define('FPDF_FONTPATH','font/');

// Création de l'objet pdf

$pdf = new FPDF();

$pdf->Open();
$pdf->AddPage("P");
// La ligne du haut

$pdf->Line(10, 10, 200, 10) ;

// Contenu du document

$pdf->SetFont('Arial', '', 8) ;

$pdf->Cell(150, 10, "", 0, 0) ;

$pdf->MultiCell(40, 10, "Numéro d'ordre : $num_recu", 1,1, "C") ;

$pdf->SetY($pdf->GetY() - 10) ;

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Reçu dons aux œuvres', 0, 1, "C");
$pdf->SetFont('Arial', '', 10) ;
$pdf->Cell(0, 0, '(Article 200-5 et 238 bis du Code Général des impôts)', 0, 1, "C") ;

$pdf->Cell(0, 10, 'REÇU A CONSERVER ET A JOINDRE A VOTRE DECLARATION DE REVENUS 2004', 0, 1, "L") ;

// On met le logo de Tela
$pdf->Image($chemin."logotb.png", 12, 35, "29", "", "PNG", "http://www.tela-botanica.org/") ;



// On écrie Les titres du cadre

$pdf->SetFontSize(12) ;
$pdf->Cell(100, 10, 'Bénéficiaire du don', 0, 0, "C") ;
$pdf->Cell(100, 10, 'Donateur', 0, 1, "C") ;

$pdf->SetFont('Arial', 'B', 10) ;

$pdf->Cell(38, 5, '', 0, 0) ;
$pdf->Cell(62, 5, 'Association Tela Botanica', 0, 0, "L") ;

$pdf->SetFont('Arial', 'B', 10) ;

$pdf->Cell(100, 5, "$ligne->U_NAME $ligne->U_SURNAME", 0, 1, "L") ;

$pdf->SetFont('Arial', '', 10) ;

$pdf->Cell(38, 5, '', 0, 0) ;
$pdf->Cell(62, 5, 'Institut de Botanique', 0, 1, "L") ;
$pdf->Cell(38, 5, '', 0, 0) ;
$pdf->Cell(62, 5, '163, rue A. Broussonnet', 0, 0, "L") ;
$pdf->Cell(100, 5, "$ligne->U_ADDR1", 0, 1, "L") ;

$pdf->Cell(38, 5, '', 0, 0) ;
$pdf->Cell(62, 5, '34090 Montpellier', 0, 0, "L") ;
$pdf->Cell(100, 8, "$ligne->U_ADDR2", 0, 1, "L") ;


$pdf->Cell(100, 5, 'Objet :', 0,1, "L") ;
$pdf->SetFontSize(8) ;
$pdf->MultiCell(100, 4, 'Contribuer au rapprochement de tous les botanistes de langue française. Favoriser l\'échange d\'information'.
                        ' et animer des projets botaniques grâce aux nouvelles technologies de la communication.', 0, 1, "") ;

$pdf->SetFontSize(10) ;

$pdf->Text(111, 58 + 8, "$ligne->U_ZIP_CODE $ligne->U_CITY") ;
$pdf->SetFontSize(8) ;
$pdf->MultiCell(100,4, 'Organisme d\'intérêt général à caractère scientifique concourant à la diffusion de la langue et des connaissances scientifiques françaises.', 0,1, "R") ;



// On remonte le curseur de 52
$pdf->SetY($pdf->GetY() - 58) ;

// Le cadre central
$pdf->Cell(100, 60, '', 1) ;
$pdf->Cell(90, 60, '', 1) ;
$pdf->Ln() ;

$pdf->SetFontSize(10) ;
$pdf->Cell(0,10, 'L\'Association reconnaît avoir reçu, à titre de don, la somme de :', 0, 1, "L") ;

$pdf->SetFont('Arial', 'B', 11) ;
$pdf->Cell(0,10,  "*** $ligne->IC_MONTANT euros ***", 0, 1, "C") ;

$pdf->SetFont('Arial', '', 10) ;

$pdf->Ln() ;
$pdf->Cell(100,10, "Date du paiement : ".date ("d/m/Y", $ligne->IC_DATE), 0, 0, "L") ;
$pdf->Cell(100, 10, 'Montpellier, le '.date("d/m/Y"), 0, 1, "L") ;

// La signature de Daniel
$pdf->Image($chemin."signature_Daniel.png", 110, $pdf->GetY(),28.22, "") ;

$pdf->Ln() ;
$pdf->Cell(0, 10, "Mode de versement : $ligne->MC_LABEL", 0, 1, "L") ;

$pdf->Cell(100, 10, '', 0, 0) ;
$pdf->Cell (100, 10, 'Daniel MATHIEU, Président', 0, 1, "L") ;
$pdf->Ln(5) ;

$pdf->SetFontSize(10) ;
$pdf->Cell(0, 7, '60 % de votre don à Tela Botanica est déductible de vos impôts dans la limite de 20 % de votre revenu imposable.', 1, 1, "C") ;


?>
