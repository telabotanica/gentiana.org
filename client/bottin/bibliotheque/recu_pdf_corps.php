<?php
// +----------------------------------------------------------------------------+
// |pdf_recu_et_mail.php												        |
// +----------------------------------------------------------------------------+
// | Copyright (c) 2003 Tela Botanica								            |
// +----------------------------------------------------------------------------+
// | Ce fichier g�n�re un fichier PDF                                           |
// | contenant le recu pour une cotisation � Tela Botanica                      |
// | Il utilise la librairie FPDF                                               |
// | http://www.fpdf.org/                                                       |
// | Il envoie �galement un email � l'adh�rent concern�                         |
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
// On regarde si le re�u a d�j� �t� envoy�
$requete = "select IC_RECU from annuaire_COTISATION where IC_ID=$cotisation_id" ;
$resultat = mysql_query ($requete) or die ($requete."<br>".mysql_error()) ;
$ligne = mysql_fetch_object($resultat) ;
mysql_free_result($resultat) ;
*/

if ($ligne->IC_RECU != 0) {
    $num_recu = $ligne->IC_RECU ;
    // $deja_envoye permettra au programme admin_annu.php de ne pas increment�
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

// Constante n�cessaire � fpdf.php
define('FPDF_FONTPATH','font/');

// Cr�ation de l'objet pdf

$pdf = new FPDF();

$pdf->Open();
$pdf->AddPage("P");
// La ligne du haut

$pdf->Line(10, 10, 200, 10) ;

// Contenu du document

$pdf->SetFont('Arial', '', 8) ;

$pdf->Cell(150, 10, "", 0, 0) ;

$pdf->MultiCell(40, 10, "Num�ro d'ordre : $num_recu", 1,1, "C") ;

$pdf->SetY($pdf->GetY() - 10) ;

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Re�u dons aux �uvres', 0, 1, "C");
$pdf->SetFont('Arial', '', 10) ;
$pdf->Cell(0, 0, '(Article 200-5 et 238 bis du Code G�n�ral des imp�ts)', 0, 1, "C") ;

$pdf->Cell(0, 10, 'RE�U A CONSERVER ET A JOINDRE A VOTRE DECLARATION DE REVENUS 2004', 0, 1, "L") ;

// On met le logo de Tela
$pdf->Image($chemin."logotb.png", 12, 35, "29", "", "PNG", "http://www.tela-botanica.org/") ;



// On �crie Les titres du cadre

$pdf->SetFontSize(12) ;
$pdf->Cell(100, 10, 'B�n�ficiaire du don', 0, 0, "C") ;
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
$pdf->MultiCell(100, 4, 'Contribuer au rapprochement de tous les botanistes de langue fran�aise. Favoriser l\'�change d\'information'.
                        ' et animer des projets botaniques gr�ce aux nouvelles technologies de la communication.', 0, 1, "") ;

$pdf->SetFontSize(10) ;

$pdf->Text(111, 58 + 8, "$ligne->U_ZIP_CODE $ligne->U_CITY") ;
$pdf->SetFontSize(8) ;
$pdf->MultiCell(100,4, 'Organisme d\'int�r�t g�n�ral � caract�re scientifique concourant � la diffusion de la langue et des connaissances scientifiques fran�aises.', 0,1, "R") ;



// On remonte le curseur de 52
$pdf->SetY($pdf->GetY() - 58) ;

// Le cadre central
$pdf->Cell(100, 60, '', 1) ;
$pdf->Cell(90, 60, '', 1) ;
$pdf->Ln() ;

$pdf->SetFontSize(10) ;
$pdf->Cell(0,10, 'L\'Association reconna�t avoir re�u, � titre de don, la somme de :', 0, 1, "L") ;

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
$pdf->Cell (100, 10, 'Daniel MATHIEU, Pr�sident', 0, 1, "L") ;
$pdf->Ln(5) ;

$pdf->SetFontSize(10) ;
$pdf->Cell(0, 7, '60 % de votre don � Tela Botanica est d�ductible de vos imp�ts dans la limite de 20 % de votre revenu imposable.', 1, 1, "C") ;


?>
