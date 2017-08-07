// Fonction d�clanchant l'ouverture d'une fen�tre externe pour les liens poss�dant la classe "lien_ext"
function open_ext_link()
{
	var liens = document.getElementsByTagName('a');
	// On r�cup�re tous les liens (<a>) du document dans une variable (un array), ici liens.
	// Une boucle qui parcourt le tableau (array) liens du d�but à la fin.
	for (var i = 0 ; i < liens.length ; ++i)  {
		// Si les liens ont un nom de class �gal � lien_ext, alors on agit.
		if (liens[i].className == 'lien_ext')  {
			liens[i].title = 'S\'ouvre dans une nouvelle fen�tre';
			// Au clique de la souris.
			liens[i].onclick = function()  {
				window.open(this.href);
				return false; // On ouvre une nouvelle page ayant pour URL le href du lien cliqu� et on inhibe le lien r�el.
			};
		}
	}
}

// Fonction cachant le bouton ok du s�lecteur de site de Papyrus
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

// Fonction nettoyant un champ de formulaire d'une chaine donn�e...
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
	cacher_btn_ok_selecteur_site();// Doit �tre avant les lien_ext
	open_ext_link();
}

// Au chargement de la page, on appelle la fonction d'initialisation :
window.onload = initialiser;