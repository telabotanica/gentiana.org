<?php

// Action changesstyle.php version 0.2 du 16/03/2004
// pour WikiNi 0.4.1rc (=> � la version du 200403xx) et sup�rieurs
// Par Charles N�pote (c) 2004
// Licence GPL


// Fonctionnement
//
// Cette action regroupe la fonction de changement de style ainsi que l'interface
// de modification du style.
// Une fois le style s�lectionn� via l'interface, la requ�te est envoy�e sous la forme :
// http://example.org/PageTest&set="NomDeFeuilleDeStyle"
// . si ce nom n'est pas constitu� uniquement de caract�res alphanum�riques,
//   une erreur est retourn�e
// . si ce nom est valide et que la feuille de style existe :
//   . on change le cookie utilisateur
//   . on redirrige l'utilisateur vers http://example.org/PageTest o�
//     l'utilisateur peut alors constater le changement de style


// Usage :
//
// -- {{changestyle link="xxx.css"}}
//    donne le lien suivant :
//    Feuille de style xxx.css
//
// -- {{changestyle link="xxx.css" title="Ouragan"}}
//    donne le lien suivant :
//    Ouragan


// A compl�ter (peut-�tre un jour) :
//
// -- {{changestyle}}
//    donne un formulaire :
//    Entrer l'adresse de la feuille de style d�sir�e : [     ]
//
// -- {{changestyle choice="zzz.css;ttt.css"}}
//	[] Feuille de style zzz
//	[] Feuille de style ttt


$set = $_GET["set"];


if ($this->GetParameter(link))
{
	echo	"<a href=\"".$this->href()."&set=".$this->GetParameter(link)."\">";
	echo	(!$this->GetParameter(title))?"Feuille de style ".$this->GetParameter(link):$this->GetParameter(title);
	echo	"</a>";
}


// Do it.
if (preg_match("/^[A-Za-z0-9][A-Za-z0-9]+$/", $set))
{
	$this->SetPersistentCookie('sitestyle',$set,1);
	header("Location: ".$this->href());
}
else if ($set)
{
	$this->SetMessage("La feuille de style ".$set." est non valide !");
	header("Location: ".$this->href());
}
?>