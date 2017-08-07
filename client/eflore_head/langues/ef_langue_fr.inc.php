<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.3                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-consultation.                                                            |
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
// CVS : $Id: ef_langue_fr.inc.php,v 1.37 2007-08-02 22:13:41 jp_milcent Exp $
/**
* Fichier contenant les traductions de l'application.
*
* Contient des constantes permettant de traduire l'application eflore-consulation.
* Ici en : fr
*
*@package eFlore
*@subpackage Traductions
//Auteur original :
*@author        Linda ANGAMA <linda_angama@yahoo.fr>
//Autres auteurs :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.37 $ $Date: 2007-08-02 22:13:41 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// TRANS MODULE
// +------------------------------------------------------------------------------------------------------+
// Traduction de textes générique
$GLOBALS['_EF_']['i18n']['_defaut_']['general']['titre_general'] = $GLOBALS['_EFLORE_']['titre'];
$GLOBALS['_EF_']['i18n']['_defaut_']['general']['symbole_obligatoire'] = '*';
$GLOBALS['_EF_']['i18n']['_defaut_']['general']['etc'] = '...';
$GLOBALS['_EF_']['i18n']['_defaut_']['general']['point'] = '.';
// +------------------------------------------------------------------------------------------------------+
// Le pied de page.
$GLOBALS['_EF_']['i18n']['_defaut_']['pied_page']['info'] = 'Si vous constatez des problèmes en utilisant cette application, veuillez contacter : ';
$GLOBALS['_EF_']['i18n']['_defaut_']['pied_page']['mail'] = 'eflore_remarques@tela-botanica.org';

// +------------------------------------------------------------------------------------------------------+
// MODULE RECHERCHE
// +------------------------------------------------------------------------------------------------------+
// Page d'Accueil
$GLOBALS['_EF_']['i18n']['recherche']['accueil']['titre_nom'] = "Rechercher une plante par son nom";
$GLOBALS['_EF_']['i18n']['recherche']['accueil']['titre_taxon'] = "Consulter les plantes par genre/famille";

// +------------------------------------------------------------------------------------------------------+
// Formulaire de recherche Nomenclaturale
$GLOBALS['_EF_']['i18n']['recherche']['form_nom']['form_legende'] = 'Consultation nomenclaturale';
$GLOBALS['_EF_']['i18n']['recherche']['form_nom']['form_nom'] = 'Nom : ';
$GLOBALS['_EF_']['i18n']['recherche']['form_nom']['form_referentiel'] = 'Référentiels';

// +------------------------------------------------------------------------------------------------------+
// Formulaire de recherche Taxonomique.
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_titre'] = 'Consulter les plantes par genre/famille';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_titre_alphabet'] = 'Consultation par ordre alphabétique';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_legende'] = 'Consultation taxonomique';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_referentiel'] = 'Référentiel : ';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_rang'] = 'Rang :';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_projet'] = 'Référentiels';
$GLOBALS['_EF_']['i18n']['recherche']['form_taxon']['form_valider'] = 'Rechercher';

// +------------------------------------------------------------------------------------------------------+
// Moteur de recherche Taxonomie.
$GLOBALS['_EF_']['i18n']['recherche']['recherche_taxon']['titre_info'] = 'Informations';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_taxon']['titre_taxon_trouve'] = 'Taxons trouvés : ';

// +------------------------------------------------------------------------------------------------------+
// Moteur de recherche Nom Latin.
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_latin']['titre_nom_trouve'] = 'Noms trouvés : ';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_latin']['titre_info'] = 'Informations';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_latin']['orthographe'] = 'Essayez avec cette orthographe : ';

// +------------------------------------------------------------------------------------------------------+
// Moteur de recherche Nom Venaculaire.
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['titre_nom_trouve'] = 'Noms communs trouvés : ';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['titre_info'] = 'Informations';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['orthographe'] = 'Essayez avec cette orthographe : ';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['table_resumer'] = 'Information sur les noms communs possédant une correspondance avec le radical';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['table_titre'] = 'Liste des noms communs correspondant au radical recherché';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['numero'] = 'N°';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['langue'] = 'Langue';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['pays'] = 'Pays';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['nom_commun'] = 'Nom commun';
$GLOBALS['_EF_']['i18n']['recherche']['recherche_nom_verna']['nom_latin'] = 'Nom latin correspondant';

// +------------------------------------------------------------------------------------------------------+
// Onglets
$GLOBALS['_EF_']['i18n']['recherche']['onglet']['accueil'] = 'Recherche';
$GLOBALS['_EF_']['i18n']['recherche']['onglets']['accueil'] = $GLOBALS['_EF_']['i18n']['recherche']['onglet']['accueil'];
$GLOBALS['_EF_']['i18n']['recherche']['onglet']['info_projet'] = 'Source des données';
$GLOBALS['_EF_']['i18n']['recherche']['onglets']['info_projet'] = $GLOBALS['_EF_']['i18n']['recherche']['onglet']['info_projet'];
$GLOBALS['_EF_']['i18n']['recherche']['onglet']['aide'] = 'Aide';
$GLOBALS['_EF_']['i18n']['recherche']['onglets']['aide'] = $GLOBALS['_EF_']['i18n']['recherche']['onglet']['aide'];

// +----------------------------------------------------------------------------------------------------+
// MODULE FICHE 
// +------------------------------------------------------------------------------------------------------+
// Fiche : général
$GLOBALS['_EF_']['i18n']['fiche']['titre'] = '%taxon% - Taxon n°%nt% - %projet% v%version%';
$GLOBALS['_EF_']['i18n']['fiche']['titre_fichier'] = '%taxon%';

// Fiche : synthese
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_code'] = 'Codes nom sélectionné';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_illustration'] = 'Illustration';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_classification'] = 'Classification';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_chorologie'] = 'Répartition';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_nomenclature'] = 'Nomenclature';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_nom_verna'] = 'Noms Communs';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_xper'] = 'Outil de détermination';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_xper_lien'] = 'XPER²';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['xper_base_intitule'] = 'Base de connaissance XPER² : ';
$GLOBALS['_EF_']['i18n']['fiche']['synthese']['titre_correspondance'] = 'Correspondances';

// Fiche : synonymie
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['nom_selec'] = 'Nom sélectionné';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['nom_retenu'] = 'Nom retenu';

$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['basio'] = 'Ce nom est un basionyme';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['auteur'] = 'Auteur(s)';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['annee'] = 'Année';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['auteur_in_title'] = "Auteur, rédacteur ou éditeur de l'ouvrage, souvent collectif, dans lequel le nom a été publié.";
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['auteur_in'] = 'Auteur "in"';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['ref_biblio'] = 'Référence bibliographique';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['comm_nom'] = 'Commentaires nomenclaturaux';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['basio_nom_selec'] = 'Basionyme du nom sélectionné';

$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['nn_acro_title'] = 'Numéro nomenclatural : ';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['nt_acro_title'] = 'Numéro taxonomique : ';

$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['st_nr'] = 'Statut non renseigné';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['st_i'] = 'Statut inconnu';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['st_p'] = 'Statut posant problème';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['st'] = 'Synonymes taxonomiques';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['sn'] = 'Synonymes nomenclaturaux';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['si'] = 'Synonymes indéterminés';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['sid'] = 'Synonymes "inclu dans"';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['sasd'] = 'Synonymes "au sens de (sensu)"';
$GLOBALS['_EF_']['i18n']['fiche']['synonymie']['sp'] = 'Synonymes provisoire';

// Fiche : informations
$GLOBALS['_EF_']['i18n']['fiche']['information']['titre_nom'] = 'Nom sélectionné : ';
$GLOBALS['_EF_']['i18n']['fiche']['information']['titre_taxon'] = 'Taxon : ';
$GLOBALS['_EF_']['i18n']['fiche']['information']['titre_legende'] = 'Légende : ';

$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNBE']['sv'] = 'Stratégie de vie';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNBE']['catminat'] = 'Code Catminat';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNBE']['syntaxon'] = 'Syntaxon';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNBE']['idiotaxon'] = 'Idiotaxon';

$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['typus'] = 'Typus';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_parent_01'] = "Numéro nomenclatural du parent n°1 de l'hybride";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['nom_parent_01'] = "Nom du parent n°1 de l'hybride";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['doute_parent_01'] = "Remarque sur le parent n°1 de l'hybride";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_parent_02'] = "Numéro nomenclatural du parent n°2 de l'hybride";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['nom_parent_02'] = "Nom du parent n°2 de l'hybride";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['doute_parent_02'] = 'Remarque sur le parent n°2 de l\'hybride';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['classif'] = 'Classification';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['legende']['classif'] = "LISTE;
1 = Pteridophytes; 2 = Gymnospermes; 3 = Monocotylédones; 4 = Dicotylédones";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['corrections'] = 'Corrections';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['2n'] = 'Nombre de chromosomes (2n)';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['flores'] = 'Flores';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['legende']['flores'] = "LISTE;
1 = BONNIER & LAYENS, 1894. Tables synoptiques des plantes vasculaires de la flore de France.; 
2 = COSTE, 1899-1906. Flore illustrée France, (3 vol.).; 
3 = FOURNIER, 1934-1940. Quatre Flores de France.; 
3* = FOURNIER, additions dans l'édition de 1961.; 
4 = TUTIN & al., 1964-1980. Flora Europaea, (5 vol.).;
4* = Flora Europaea, édition 2 (Vol. 1), voir TUTIN & al. (1993), abrégée en FE2. L'indication est surtout 
donnée quand la citation n'a pas été faite dans 4 (supplémentaire ou modifiée).; 
5 = GUINOCHET & VILMORIN, 1973-1984. Flore de France, éd. C.N.R.S., (5 vol.).;
6 = KERGUÉLEN, 1993. Liste synonymique de la flore de France.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['indic_geo'] = 'Indication géographique';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['legende']['indic_geo'] = "LISTE;
Co = taxon présent en Corse (Corsica); 
Ga = taxon présent en France (Gallia).; 
GaA = taxons adventices; 
GaC ou C = taxons cultivés; 
GaD = taxons éteints ou disparus; 
GaE = taxons à exclure, absents de France; 
GaI = présence incertaine ou douteuse; 
GaN = taxons naturalisés; 
J = taxons présents uniquement dans les jardins";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['combinaison_importe'] = 'Combinaison de Kerguelen';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['nom_officiel_importe'] = 'Nom retenu par Kerguelen';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['maj_bb'] = 'Date de mise à jour (BB)';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['maj_modif'] = 'Date de mise à jour';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['maj_creation'] = 'Date de création';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_flora_helvetica'] = 'Flora Helvetica - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_flora_helvetica'] = 'Flora Helvetica - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_fournier'] = 'Flore de Fournier - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_fournier'] = 'Flore de Fournier - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_cnrs'] = 'Flore du CNRS - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_cnrs'] = 'Flore du CNRS - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_flora_europaea'] = 'Flora Europaea - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_flora_europaea'] = 'Flore Europaea - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_bonnier'] = 'Flore de Bonnier - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_bonnier'] = 'Flore de Bonnier - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_coste'] = 'Flore de Coste - code';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['rem_coste'] = 'Flore de Coste - remarques';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['nom_complet'] = 'Nom complet BDNFF';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['formule_hybridation'] = 'Formule d\'hybridation';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['num_meme_type'] = 'Numéro du même type';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['presence_france'] = 'Présence en France';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['legende']['presence_france'] = "LISTE;
0 = absent;
1 = présence (indigène ou naturalisé); 
2 = adventice ou probable; 
3 = taxon (seulement) cultivé en France (ex. : Maïs); 
4 = Manque d'information";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['taxon_reel'] = 'Taxon réel';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['legende']['taxon_reel'] = "LISTE;
0 = genre (exemple : Carex sp.); 
1 = taxon retenu sans rang inférieur; 
2 = taxon retenus dont il existe plusieurs rangs inférieurs existants; 
3 = taxon dont il existe un seul taxon de rang inférieur  
(exemple: Agrostemma githago vaut 3, Agrostemma githago subsp. githago vaut 1)";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFF']['page_flore_belge_ed5'] = 'Page Flore Belge ed. 5';

$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['statut_nom'] = 'Statut du nom du taxon';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['statut_nom'] = "LISTE ; 
DEFINITION = Symbole précisant le statut de validité du nom du taxon dans la base. Ce champ est réservé aux seuls noms valides ou considérés provisoirement comme tels, à l'exclusion donc de tous les synonymes.En conformité avec le standard international TDWG mais sur une base élargie, sept cas sont possibles :;
A = le taxon présent à la Réunion est rapporté avec certitude à un taxon reconnu. Le nom valide retenu est le 
'nom accepté' pour le taxon sur une base taxonomique et nomenclaturale fiable.;
T = le taxon présent à la Réunion est rapporté avec certitude à un taxon reconnu, mais dont le statut taxonomique 
et nomenclatural est en cours d'évolution ou a été remis en cause récemment. Le nom valide retenu est le 
'nom provisoirement accepté' pour le taxon. Ce cas implique donc une situation transitoire en attente d'informations 
taxonomiques et nomenclaturales concluantes.;
C = le taxon présent à la Réunion est rapporté avec incertitude [rapport en cf. (confer)] à un taxon reconnu.;
F = le taxon présent à la Réunion est rapproché d'un taxon reconnu, sans toutefois pouvoir être assimilé à ce taxon 
sur la base des connaissances actuelles [cas des affinités taxonomiques : « aff. » (affinis)]. ;
N = le taxon n'a pu être rapporté ou rapproché d'un taxon connu et représente probablement une entité taxonomique 
nouvelle restant à décrire. ;
D = le taxon est douteux et par conséquence le nom valide retenu pour le taxon est luimême
douteux. Ce cas implique une mention provisoire en attente d'informations taxonomiques et nomenclaturales nouvelles. ;
0 = le statut du nom n'a pas été analysé.;
Remarque = Ce champ permet également d'identifier de manière positive les noms valides 
(ou, à défaut, considérés ou utilisés provisoirement comme tels) des taxons de l'Index.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['ordre_revision'] = 'Ordre de révision';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['ordre_revision'] = 
"Numéro d'ordre chronologique de révision de la ligne nomenclaturale.
La numérotation des révisions a pris effet avec l'édition de la première version de l'Index
(30/06/2003). Les noms non révisés de cette première version ne possèdent pas de cote de révision.
Les nouveaux noms introduits depuis la première version sont cotés '0'.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['date_revision'] = 'Date de révision';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['date_revision'] =
"Date de la dernière révision de la ligne nomenclaturale, correspondant au numéro d'ordre
donné par le champ « Ordre révision ».
Il n'y a pas d'archivage des données (date, auteur) concernant les révisions précédentes.
La date est donnée sous format à huit chiffres sans séparateur de type « année/mois/jour ».
Exemple : 20031214 pour le 14 décembre 2003.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['auteur_revision'] = 'Auteur de la révision';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['auteur_revision'] =
"LISTE;
DEFINITION = Auteur de la dernière révision de la ligne nomenclaturale, correspondant au numéro d'ordre
donné par le champ « Ordre révision ».
Il n'y a pas d'archivage des données (date, auteur) concernant les révisions précédentes.
Les auteurs sont entrés par code à deux lettres. Les codes actuellement disponibles sont les
suivants :;
VB = Vincent BOULLET";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['ordre_general'] = 'Ordre général';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['ordre_general'] = "LISTE;
DEFINITION = Numéro d' ordre des noms de taxon suivant le classement alphabétique des noms valides,
avec présentation hiérarchique des synonymes sous les noms valides. Cette clé de tri permet de
présenter les synonymes sous les noms valides auxquels ils se réfèrent.
La hiérarchisation de présentation des synonymes est en principe la suivante : basionyme du
nom valide (s'il y a lieu), synonymes nomenclaturaux du nom valide par ordre chronologique,
synonymes taxonomiques par ordre chronologique (avec par ordre secondaire, le basionyme, puis les
synonymes nomenclaturaux).;
Remarque  = Ce numéro d'ordination est variable. Il est remis à jour à chaque introduction nouvelle de
ligne nomenclaturale ou à chaque révision nomenclaturale.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['type_synonymie'] = 'Type de synonymie';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['type_synonymie'] = "LISTE;
DEFINITION = Clé de synonymie permettant à la fois de marquer les synonymes et de préciser, selon le code
utilisé, le type de synonyme (clé utilisée uniquement pour les noms non valides).
Codification utilisée :;
a = antonyme (synonyme exclu).;
b = basionyme (synonyme porteur du nom ou de l' épithète).;
i = isonyme (synonyme de même nom basé sur le même type) [sauf exception, les isonymes ne sont pas pris en compte].;
n = synonyme nomenclatural (ou homotypique) sensu lato (nom basé sur le même type).;
o = variant orthographique (variant orthographique incorrect d'un nom).;
p = pseudonyme (synonyme par mésusage du nom).;
s = synonyme nomenclatural ou taxonomique non différencié (basionymes exclus).;
t = synonyme taxonomique (ou hétérotypique) (nom basé sur un type différent).;
? = synonyme de type indéterminé.;
nn = synonyme nomenclatural de même rang (synonyme nomenclatural sensu stricto). ;
nr = synonyme nomenclatural de rang différent.;
tb = basionyme du synonyme taxonomique. ;
tn = synonyme nomenclatural du synonyme taxonomique. ;
to = variant orthographique du synonyme taxonomique.;
Remarque = Les noms inédits en cours de publication n'apparaissent pas dans les versions diffusées.
Le code de synonymie « u » leur est attribué dans la version mère de l'index.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['famille_optionnelle'] = 'Famille optionnelle';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['famille_optionnelle'] = 
"Autre famille à laquelle le taxon pourrait être rapporté. Il s'agit d'un second choix de traitement
systématique, la priorité étant donnée par le choix princeps figurant dans le champ « Famille ». Cette
information est également donnée aussi bien pour les noms valides que pour les synonymes.
Pour certains groupes, le traitement systématique est loin d' être stabilisé notamment à la
lumière d' études phylogénétiques d' interprétation variable ou parfois contradictoires. Il en résulte des
opinions souvent variables quant aux concepts de famille sans qu' il soit toujours possible d' étayer plus
fortement un choix qu' un autre. Dans ce cas, comme il est nécessaire dans une base de données de
donner une priorité, le champ « Autre famille » permet de noter un autre traitement systématique
convenable pour la famille.
Remarque - Le nom de la famille est donné sans autorité.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['choro_distribution_generale'] = 'Distribution mondiale du taxon';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['choro_distribution_generale'] = "LISTE;
DEFINITION = Distribution mondiale du taxon.
Lorsque une aire d'origine s'est ensuite étendue, celleci est citée préalablement. La
codification de la présentation et des contrées géographiques est en cours d'établissement et la
présente version n'a pas été homogénéisée de ces points de vue.
Certains codes ou abréviations ont été systématiquement utilisés : Af. (Afrique), Am.
(Amérique), As. (Asie), Eur. (Europe), C (centre), E(est), N (nord), S (sud), W (ouest). Un « ? » indique
une hypothèse ou un doute.
Les premières sources d' information ont été principalement la « Flore des Mascareignes [BOSSER & al. 1976(2005)] » 
et ses manuscrits préparatoires pour les volumes non parus, « The PlantBook (MABBERLEY 1997) ». 
Celles-ci ont cependant été entièrement révisées en fonction de l'évolution des traitements taxonomiques et 
systématiques de l'Index. De nombreuses sources sont alors utilisées en fonction des cas, sans qu' il soit 
possible de les citer ici.
Les abréviations suivantes sont utilisées :;
adv. = adventice;
Af. = Afrique;
alim. = alimentaire;
Am. = Amérique;
antarct. = antarctique;
appart. = appartement;
arct. = arctique;
arom. = aromatique;
artif. = artificielle;
As. = Asie;
Austr. = Australie;
C = Centre;
céréal. = céréalier;
Circumméd. = région circumméditerranéenne;
condim. = condimentaire;
contin. = continental;
cosmop. = cosmopolite;
couv. = couverture;
cult. = culture;
cv. = cultivar;
E = Est;
essent. = essentiellement;
E.U. = ÉtatsUnis;
Eur. = Europe;
forest. = forestier;
fourr. = fourrage;
fruit. = fruitier;
hémisph. = hémisphère;
Himal. = Himalaya;
hort. = horticole;
hum. = humide;
Ind. = Indien;
Indon. = Indonésie;
indust. = industriel;
introd. = introduit;
larg. = largement;
légum. = légumier;
litt. = littoral;
Macaron. = Macaronésie;
Madag. = Madagascar;
Mascar. = Mascareignes;
médic. = médicinal;
Médit = Méditerranée;
mérid. = méridional;
mont. = montagne;
Mozamb. = Mozambique;
N = Nord;
nat. = naturalisé;
nbx = nombreux;
NE = NordEst;
néotrop. = néotropical;
Nouv.-Cal. = Nouvelle-Calédonie;
Nouv.-Galles = Nouvelle-Galles;
Nouv.-Guinée = Nouvelle-Guinée;
Nouv.-Héb. = Nouvelles-Hébrides;
Nouv.-Zél. = NouvelleZélande;
NW = NordOuest;
Oc. (ou oc.) = océan;
orig. = origine ou;
orig. cult. = origine;
orn. = ornemental;
Pacif. = Pacifique;
paléosubtrop. = paléosubtropical;
paléotrop. = paléotropical;
pantrop. = pantropical;
Philipp. = Philippines;
Polyn. = Polynésie;
princip. = principalement;
prob. = probable;
rég. = région";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['choro_diversite'] = 'Diversité';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['choro_diversite'] = 
"Indication du nombre de taxons de rang principal inférieur reconnu pour le taxon considéré.
Pour un genre, cas le plus fréquent, il s'agit du nombre d'espèces du genre.
Compte tenu des incertitudes et des données variables disponibles pour ces informations, une
notation, tenant compte de cette variabilité et du poids plus ou moins important des données selon
leur source, a été adoptée.
D'une manière générale, pour beaucoup de genres tropicaux, la diversité spécifique est
rarement connue avec précision et le symbole « ± » (= « plus ou moins ») a souvent été utilisé pour
exprimer ces approximations. Les valeurs extrêmes, lorsqu'elles sont pertinentes, figurent entre
parenthèses et encadrent la (ou les) valeur(s) retenue(s) comme étant la (ou les) plus probable(s) ;
exemple : (50)6580(100).
L'absence de variabilité infrataxonomique connue est notée  « 0 ».";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['statut_general_reu'] = "Statut global d'indigénat ou d'introduction";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['statut_general_reu'] = "LISTE;
DEFINITION = Statut global d'indigénat ou d'introduction du taxon à la Réunion, intégrant à la fois les
populations spontanées et les populations cultivées.
Le statut général Réunion est applicable à tous les taxons de l'Index. Il est aussi appliquable
La typologie de statut d' indigénat ou d'introduction des taxons, adoptée ici, s'appuie 
principalement à l'origine sur le système de statuts et de traitement des plantes étrangères
(xénophytes) de E.J. CLEMENT et M.C. FOSTER (Aliens Plants of the British Isles, 1994) et le
système de statuts des index de références de la flore vasculaire du Nord/PasdeCalais,
de Picardie et de HauteNormandie (BOULLET 1998 et 1999) inspiré initialement de LAMBINON et al. (1993). Il a
également été tenu compte, notamment pour les notions d'indigène et d'étranger, des mises au point
terminologiques récentes développées dans le contexte des plantes exotiques invasives
(RICHARDSON et al. 2000, PYS EK et al. 2004).;
I = indigène.;
K = cryptogène.;
Z = amphinaturalisé (ou assimilé indigène) [correspond grosso modo à la notion de « largement naturalisé »].;
N = sténonaturalisé [correspond grosso modo à la notion de « localement naturalisé »].;
S = établi [correspond approximativement et en partie à la notion classique de subspontané].;
R = persistant (ou rémanent).;
A = accidentel (ou casuel) (correspond approximativement à la notion classique d' adventice).;
Q = cultivé (voir contenu, champ suivant).;
E = taxon cité par erreur dans le territoire.;
? = indication complémentaire de statut douteux ou incertain se plaçant soit seul (cas
des plantes à statut inconnu ou mal connu), soit après le code de statut (I?, K?, Z?, N?, S?, A?, E?).;
?? = taxon dont la présence est hypothétique dans le territoire (indication vague pour le
territoire, détermination rapportée en confert, ou encore présence probable à confirmer en
absence de citation).";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['statut_spontane_reu'] = 'Statut des populations spontané à la Réunion';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['statut_spontane_reu'] = 
"Statut des populations spontanées (statut spontané) à la Réunion, à l' exclusion du statut des
populations culturales (statut cultural).
Le statut spontané Réunion est applicable à tous les taxons de l'Index.
Par plante (ou population) spontanée, on entend toute plante croissant en un lieu donné
sans avoir été plantée.
Pour les taxons possédant ou ayant possédé des populations spontanées, les statuts et la
codification sont identiques au champ « Statut général Réunion », le statut cultural en moins.
Pour les taxons uniquement connus à l'état cultural et les taxons cités par erreur, un code « 0 »
(= « nul ») est appliqué.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['statut_cultural_reu'] = 'Statut des populations culturales à la Réunion';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['statut_cultural_reu'] = "LISTE;
DEFINITION = Statut des populations culturales (statut cultural) à la Réunion, à l'exclusion du statut des
populations spontanées (statut spontané).
Le statut cultural Réunion est applicable à tous les taxons de l'Index.
Le statut cultural s'appuie largement sur le système de statuts des index de références de la
flore vasculaire du Nord/PasdeCalais, de Picardie et de HauteNormandie (BOULLET 1998 et 2000).
Il comprend une subdivision du statut de cultivé « Q » en quatre catégories dont les limites restent
parfois difficiles à apprécier :;
G = cultivé en grand (au moins localement) à des fins économiques de production agricole
[ex. : Saccharum officinale, Ananas comosum], sylvicole [ex. : Cryptomeria japonica] ou plus
rarement horticole (ex. : ?). Les situations actuelles et passées sont prises en compte dans la
catégorisation.;
H = cultivé en grand (au moins localement) pour l'ornement [ex.: Agave veracruz,
Euphorbia pulcherrima], l'organisation des paysages [ex. : Grevillea robusta], la
cicatrisation paysagère (écran visuel...) ou encore la protection et la fixation des sols [ex.
: Khaya senegalensis], dans les espaces publics (notamment bords de routes) ou ruraux ; ces
plantes sont souvent aussi cultivées dans les jardins et les parcs.;
P = introduit (planté, semé) ponctuellement dans les espaces naturels et seminaturels.
Cette catégorie, pas toujours bien distincte des catégories H et C, est parfois délicate à
apprécier. Elle concerne des plantes ne faisant pas l'objet d'une plantation de masse mais
introduites de manière ponctuelle (sans développement spatial ou linéaire conséquent) à des
fins diverses (biodiversification, ornement, curiosité, bornage, cynégétique...). Elle concerne
aussi bien des taxons indigènes [ex. : Ruizia cordata] que des xénophytes. Dans le cas des
taxons indigènes, de telles introductions sont souvent difficiles à détecter sur le terrain et
amènent de nombreuses confusions. Un certain nombre de ces introductions de persistance
variable peuvent éventuellement conduire à des naturalisations.;
C = cultivé (culture courante à petite échelle) dans les jardins, les parcs et les espaces
urbains, pour l'ornement [ex. : Pyrostegia venusta] ou le potager [ex. : Lablab purpureus].";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['statut_endemicite'] = "Type d'endémicité du taxon";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['statut_endemicite'] = "LISTE;
DEFINITION = Type d'endémicité du taxon dans l'ouest de l'océan Indien.
Cette information n'est prise en compte que si le taxon présente à l'état indigène (ou
cryptogène), un caractère endémique reconnu dans la zone de l'océan Indien occidental.
L'échelle d'endémicité proposée concerne prioritairement l' endémicité stricte (Réunion) et
l'endémicité régionale (Mascareignes).
Une troisième échelle d'endémicité macrorégionale a été ajoutée en complément des deux
précédentes. Elle concerne les taxons possédant une aire insulaire « Ouest Océan Indien » et est codée
« W ».;
0 = pas de caractère endémique reconnu dans la zone de l'océan Indien occidental (= « nul »). 
Doivent être également considérés comme relevant de ce dernier cas, les taxons introduits dans l'ouest de 
l'océan Indien mais endémiques à l'état indigène d'une autre région du monde.;
B = endémicité stricte pour la Réunion.;
M = endémicité régionale (présence au moins sur deux îles).; 
M3 = présence sur les trois îles;
M2 = présence sur deux îles; 
M2a = présence Réunion, Maurice;
M2b = présence Réunion, Rodrigues;
F = endémicités strictes et régionales pour Maurice;
R = endémicités strictes et régionales pour Rodrigues;
M2c = endémicités strictes et régionales pour Maurice et Rodrigues. Celles-ci
concernent certains taxons introduits à la Réunion, ou bien de présence
douteuse ou encore signalés par erreur.
W2b = Madagascar et Mascareignes ;
W2d = Comores et Mascareignes ;
W2f = Seychelles et Mascareignes ;
W3a = Madagascar, Comores et Mascareignes ;
W3c = Madagascar, Seychelles et Mascareignes ;
W3d = Comores, Seychelles et Mascareignes ;
W4 = Madagascar, Comores, Seychelles et Mascareignes ;
C = Comores ;
G = Madagascar ;
S = Seychelles ";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['combinaison_hybride'] = 'Combinaison hybride';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['combinaison_hybride'] = 
"Indication des parents de l'hybride sous forme de combinaison hybride.
La présentation se fait par ordre alphabétique des parents, sauf en cas d'hybrides
unidirectionnels. Dans ce dernier cas, le parent mâle est donné en premier. Les noms des parents
sont cités en entier avec leur autorité. Ce champ concerne uniquement les hybrides.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['notes_generales'] = 'Notes générale';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['notes_generales'] = 
"Champ d'expression libre pour toute note générale additionnelle utile, en complément ou en
relation avec les thématiques de la table (sauf les informations chromosomiques).
Elles peuvent concerner les taxons (notes taxonomiques) ou leurs noms (notes
nomenclaturales).
Les notes particulières à la Réunion ne portant pas de caractère général pour le taxon ou le
nom concerné sont portées dans une rubrique particulière intitulée « Notes Réunion ».";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['notes_reu'] = 'Notes Réunion';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['notes_reu'] =
"Champ d' expression libre pour toute note additionnelle utile, concernant plus particulièrement
la Réunion, en complément ou en relation avec les thématiques de la table (sauf les informations
chromosomiques).
Les notes à caractère général sont à porter dans la rubrique intitulée « Notes générales ».";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['date_creation_nom'] = 'Date de création du nom';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['date_creation_nom'] =
"Date de création de la ligne nomenclaturale.
La date est donnée sous format à huit chiffres sans séparateur de type « année/mois/jour ».
Exemple : 20031214 pour le 14 décembre 2003.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['auteur_creation_nom'] = 'Auteur de la création du nom';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['auteur_creation_nom'] =
"Créateur de la ligne nomenclaturale.
Les auteurs sont entrés par code à deux lettres. La codification est identique à celle du champ
« Auteur révision ».";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['ancien_code_taxon'] = 'Ancien code du taxon';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['ancien_code_taxon'] =
"Code taxon de la ligne taxonomique déclassée.
Concerne uniquement des « taxons » préalablement identifiés dans l'Index, mais traités
actuellement comme synonymes.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['date_suppression_nom'] = 'Date de suppression du nom';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['date_suppression_nom'] =
"Date de suppression de la ligne nomenclaturale.
La date est donnée sous format à huit chiffres sans séparateur de type « année/mois/jour ».
Exemple : 20031214 pour le 14 décembre 2003.";
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['auteur_suppression_nom'] = 'Auteur de la suppression du nom';
$GLOBALS['_EF_']['i18n']['fiche']['information']['BDNFM']['legende']['auteur_suppression_nom'] =
"Auteur de la suppression de la ligne nomenclaturale.
Les auteurs sont entrés par code à deux lettres. La codification est identique à celle du champ
« Auteur révision ».";

// +------------------------------------------------------------------------------------------------------+
// Onglets
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['synthese'] = 'Identité';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['synonymie'] = 'Synonymie';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['vernaculaire'] = 'Noms communs';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['chorologie'] = 'Répartition';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['information'] = 'Informations';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['illustration'] = 'Illustrations';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['permalien'] = 'Permaliens';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['wiki'] = 'Vos données';
$GLOBALS['_EF_']['i18n']['fiche']['onglets']['cel'] = 'Vos observations';

// +----------------------------------------------------------------------------------------------------+
// MODULE SAISIE
// +------------------------------------------------------------------------------------------------------+
// +------------------------------------------------------------------------------------------------------+
// Formulaire de saisie assitée des noms
$GLOBALS['_EF_']['i18n']['saisie']['saisie_continue']['form_legende'] = 'Saisie de noms';
$GLOBALS['_EF_']['i18n']['saisie']['saisie_continue']['form_nom'] = 'Tapez votre nom : ';
$GLOBALS['_EF_']['i18n']['saisie']['saisie_continue']['form_referentiel'] = 'Choisissez un référentiel : ';

// +----------------------------------------------------------------------------------------------------+
// MODULE TRACKBACK
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_EF_']['i18n']['trackback']['url']['titre'] = 'Adresse pour le trackback';

// +----------------------------------------------------------------------------------------------------+
// MODULE OPENSEARCH
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_EF_']['i18n']['opensearch']['url']['titre'] = 'Moteur de recherche pour Firefox 2 et Internet Explorer 7';

// +----------------------------------------------------------------------------------------------------+
// MODULE RECUEIL DE DONNEES
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_nom_latin'] = 'Nom latin';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_date'] = 'Date';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_commune'] = 'Commune';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_lieudit'] = 'Lieu-dit';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_commentaire'] = 'Localisation précise, commentaires';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_fuseau'] = 'Fuseau';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_coord_x'] = 'Coordonnée X';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_coord_y'] = 'Coordonnée Y';
$GLOBALS['_EF_']['i18n']['recueildedonnees']['envoi_mail']['rcd_courriel'] = 'Courriel';


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ef_langue_fr.inc.php,v $
* Revision 1.37  2007-08-02 22:13:41  jp_milcent
* Compatibilité nouveau module.
*
* Revision 1.36  2007-07-10 16:46:34  jp_milcent
* Ajout de traduction pour le RDD.
*
* Revision 1.35  2007-07-09 18:55:22  jp_milcent
* Ajout de valeur pour le module Recueil de données.
*
* Revision 1.34  2007-06-01 13:23:05  jp_milcent
* Fusion avec livraison Moquin-Tandon : 01 juin 2007
*
* Revision 1.33  2007-04-10 09:13:38  ddelon
* Mise a jour libelle recherche
*
* Revision 1.32  2007/02/07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.31  2007/01/24 16:33:55  jp_milcent
* Ajout titre opensearch.
*
* Revision 1.30.2.3  2007-05-23 10:39:16  ddelon
* libelle
*
* Revision 1.30.2.2  2007-05-13 14:20:30  ddelon
* Action carnet en ligne : maquette
*
* Revision 1.30.2.1  2007/04/10 09:05:32  ddelon
* Mise a jour libelle recherche
*
* Revision 1.30  2007/01/17 17:54:27  jp_milcent
* Fusion avec la livraison Passy avant nouvelle livraison.
*
* Revision 1.29  2007/01/12 14:40:19  jp_milcent
* Fin d'ajout des légendes pour la BDNFM.
*
* Revision 1.28  2007/01/11 19:01:44  jp_milcent
* Début d'ajout des légendes pour la BDNFM.
*
* Revision 1.27  2007/01/05 18:21:01  jp_milcent
* Ajout de données pour le module TrackBack.
*
* Revision 1.26  2006/12/27 14:09:21  jp_milcent
* Ajout de langue pour le module de saisie.
*
* Revision 1.25.2.1  2006/11/21 09:48:28  jp_milcent
* Correction faute de frappe.
*
* Revision 1.25  2006/11/17 14:46:37  jp_milcent
* Fusion n°2 avec la livraison Decaisne.
*
* Revision 1.21.2.4  2006/11/10 22:38:15  ddelon
* wiki eflore
*
* Revision 1.24  2006/11/15 18:32:32  jp_milcent
* Ajout des légendes de la BDNFF.
*
* Revision 1.23  2006/11/15 11:17:24  jp_milcent
* Ajout d'un titre pour les noms communs.
*
* Revision 1.22  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.21.2.3  2006/09/04 14:22:07  jp_milcent
* Modification de quelques intitulés pour les informations complémentaires de la BDNFF.
*
* Revision 1.21.2.2  2006/07/28 13:32:12  jp_milcent
* Correction problème du tableau langue pour st_nr.
*
* Revision 1.21.2.1  2006/07/27 14:11:31  jp_milcent
* Récupération du titre depuis la variable globale.
*
* Revision 1.21  2006/07/24 13:42:44  jp_milcent
* Modification intitulé du nom de la base de connaissance.
*
* Revision 1.20  2006/07/24 13:27:48  jp_milcent
* Modification du titre sur les bases  de connaissances.
*
* Revision 1.19  2006/07/11 16:19:19  jp_milcent
* Intégration de l'appllette Xper.
*
* Revision 1.18  2006/07/07 15:19:21  jp_milcent
* Correction de mise en page.
*
* Revision 1.17  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.16  2006/07/05 15:12:00  jp_milcent
* Ajout de nouveaux labels.
*
* Revision 1.15  2006/05/11 10:28:26  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.14  2006/04/25 16:22:24  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des données txt liées au nom sélectionné.
*
* Revision 1.13  2005/12/21 16:04:34  jp_milcent
* Utilisation d'un tableau pour les traductions à la place de constante.
* C'est plus souple et cela n'oblige pas à traduire un fichier complet.
*
* Revision 1.12  2005/12/01 15:45:58  ddelon
* orthographe
*
* Revision 1.11  2005/11/28 16:50:16  jp_milcent
* Ajout de constantes pour les urls de l'arbre des taxons.
*
* Revision 1.10  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.9  2005/10/26 16:36:25  jp_milcent
* Amélioration des pages Synthèses, Synonymie et Illustrations.
*
* Revision 1.8  2005/09/28 16:29:31  jp_milcent
* Début et fin de gestion des onglets.
* Début gestion de la fiche Synonymie.
*
* Revision 1.7  2005/09/13 16:25:23  jp_milcent
* Fin de gestion des interfaces de recherche.
*
* Revision 1.6  2005/08/19 13:54:11  jp_milcent
* Début de gestion de la navigation au sein de la classification.
*
* Revision 1.5  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.4  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
* Revision 1.3  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.2  2005/08/01 16:18:40  jp_milcent
* Début gestion résultat de la recherche par nom.
*
* Revision 1.1  2005/07/26 16:27:29  jp_milcent
* Début mise en place framework eFlore.
*
* Revision 1.1  2005/07/25 14:24:36  jp_milcent
* Début appli de consultation simplifiée.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>