// Fonction déclanchant l'ouverture d'une fenêtre externe pour les liens possédant la classe "lien_ext"
function open_ext_link()
{
	var liens = document.getElementsByTagName('a');
	// On récupère tous les liens (<a>) du document dans une variable (un array), ici liens.
	// Une boucle qui parcourt le tableau (array) liens du début Ã  la fin.
	for (var i = 0 ; i < liens.length ; ++i)  {
		// Si les liens ont un nom de class égal à  lien_ext, alors on agit.
		if (liens[i].className == 'lien_ext')  {
			liens[i].title = 'S\'ouvre dans une nouvelle fenêtre';
			// Au clique de la souris.
			liens[i].onclick = function()  {
				window.open(this.href);
				return false; // On ouvre une nouvelle page ayant pour URL le href du lien cliqué et on inhibe le lien réel.
			};
		}
	}
}

// Fonction cachant le bouton ok du sélecteur de site de Papyrus
function cacher_btn_ok_selecteur_site()
{
	if (document.getElementById('sesi_ok')) {
		document.getElementById('sesi_ok').setAttribute('style', 'display:none');
	}
}

// Fonction aggrandissant ou diminuant la taille d'un champ
// Provient du site https://addons.mozilla.org/
function basculerTaille(id, grand)
{
	var sb = document.getElementById(id);
	if (grand) {
		sb.style.width = '20em;';
	} else {
		sb.style.width = '10em;';
	}
}

// Fonction nettoyant un champ de formulaire d'une chaine donnée...
function nettoyerChamp(id, chaine)
{
	var sb = document.getElementById(id);
	var valeur = sb.value;
	if (valeur == chaine) {
		sb.value = '';
	}
	if (valeur == '') {
		sb.value = chaine;
	}
}
	
// Fonction initialisant d'autres fonctions
function initialiser()
{
	cacher_btn_ok_selecteur_site();// Doit être avant les lien_ext
	open_ext_link();
}

// Au chargement de la page, on appelle la fonction d'initialisation :
window.onload = initialiser;