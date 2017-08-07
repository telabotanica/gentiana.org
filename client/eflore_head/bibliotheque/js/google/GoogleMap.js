//<![CDATA[
// Contient la carte GoogleMap
var map;
// Contient l'utilitaire permettant de trouver une adresse.
var EfGeocoder;
// Point de l'adresse saisie et à passer au GeoCoder
var addrpnt;
// L'icône à afficher sur la carte
var icon;

function load() {
	// Vérification de la compatibilité du navigateur
	if (GBrowserIsCompatible()) {
		// Création de la carte
		map = new GMap2(document.getElementById("map"));
		// Positionnement de la carte
		map.setCenter(new GLatLng(init_lat, init_long), init_zoom);
		// Types de carte disponibles :
		map.addMapType(G_NORMAL_MAP);
		map.addMapType(G_SATELLITE_MAP);
		map.addMapType(G_PHYSICAL_MAP);
		// Bouton pour changer de type de carte (mixte, satellite, plan)
		map.addControl(new GMapTypeControl(1));
		// Définition du type de la carte par défaut
		map.setMapType(G_HYBRID_MAP);
		// Bouton large de déplancement et zoom apparaissant dans le coin haut gauche
	  	map.addControl(new GLargeMapControl());
		// Pour hierarchiser les types de carte --> pas encore dans la version stable...
		//var mapControl = new GHierarchicalMapTypeControl();
		// Définition des relations des types de menus
		//mapControl.clearRelationships();
		//mapControl.addRelationship(G_SATELLITE_MAP, G_HYBRID_MAP, 'Labels', false);
		// Ajout du controle après avoir spécifié les relations
		//map.addControl(mapControl);
		// Vue d'ensemble apparaissant dans le coin bas droit
		var EfOverViewMap = new GOverviewMapControl();
		map.addControl(EfOverViewMap);
		var mini = EfOverViewMap.getOverviewMap();
		// ?
		map.enableContinuousZoom();
		// Zoom avec la molette de la souris
		map.enableScrollWheelZoom();
		// Zoom avec le double clic de la souris
		map.enableDoubleClickZoom();
		
		// Création du GéoCoder
		EfGeocoder = new GClientGeocoder() ;
		
		// Création de l'icône
		icon = new GIcon();
		icon.image = "http://www.google.com/mapfiles/ms/micons/red-dot.png";
		icon.shadow = "http://www.google.com/mapfiles/shadow50.png";
		//icon.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";
		//icon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
        icon.iconSize = new GSize(34, 34);
        icon.shadowSize = new GSize(37, 34);
        icon.iconAnchor = new GPoint(16, 34);
		
		// Gestion de l'évènement click sur la carte
		GEvent.addListener(map, 'click', 
			function(overlay, position) {	// Add a click listener
				if (overlay) {
					// ? : on ne fait rien...
				} else if (position) {
					placerMarkeur(position) ;
					map.setCenter(position) ;
				}
			});
	}
}

function showAddress(form) {
	if (form.lieu.value != '') {
		var lieu = form.lieu.value;
		EfGeocoder.getLatLng(lieu, function(position) {
			if (!position) {
				alert('Le lieu "'+lieu+'" est introuvable! Veuillez essayer un autre nom.')
			} else {
				placerMarkeur(position);
				map.setCenter(position, 14) ;
			}
			// Vidage du champ du formulaire
			form.lieu.value = '';
		});
	} else {
		var position = new GLatLng(form.lati.value, form.longi.value);
		placerMarkeur(position);
		map.setCenter(position, 14);
		// Vidage des champs du formulaire
		form.lati.value = '';
		form.longi.value = '';
	}
	return false;
}

function placerMarkeur(position) {
	if (addrpnt) {
		map.removeOverlay(addrpnt);
	}
	addrpnt = new GMarker(position, {icon: icon, draggable: true,  title: 'Click sur la carte!'}) ;
	addrpnt.enableDragging() ;
	map.addOverlay(addrpnt) ;
	GEvent.addListener(addrpnt,'dragend',function() {
			map.setCenter(addrpnt.getPoint());
			afficherInfo(addrpnt.getPoint());
		}) ;
	afficherInfo(position);
}

function afficherInfo(position) {
	var form = document.getElementById('form_coordonnee');
	afficherCoordonnees(position.lat().toString(), position.lng().toString());
}

function afficherCoordonnees(lati, longi) {
	var ellipsoid = 21;// 21 = WGS-84 (voir geo_constants)
	var xtm = 0;// 0 = UTM et 1= MTM
	var Coordonnee = calculer_coordonnee(lati, longi, ellipsoid, xtm);
	
	// Nous récupérons les infos qui nous intéressent dans le forumulaire
	var form = document.getElementById('form_coordonnee');
	form.utm_nord.value = Coordonnee.nord;
	form.utm_est.value = Coordonnee.est;
	form.utm_zone.value = Coordonnee.zone_numero;
	form.utm_lettre.value = Coordonnee.zone_lettre;

	// Nous affichons des informations.
	document.getElementById('ll_latitude').firstChild.nodeValue = Coordonnee.latitude.toFixed(4);
	document.getElementById('ll_longitude').firstChild.nodeValue = Coordonnee.longitude.toFixed(4);
	document.getElementById('ll_latitude_dms').firstChild.nodeValue = Coordonnee.latitude_dms;
	document.getElementById('ll_longitude_dms').firstChild.nodeValue = Coordonnee.longitude_dms;
	document.getElementById('utm_chaine').firstChild.nodeValue = Coordonnee.xtm_chaine;
}

window.onload = load
window.onunload = GUnload
//]]>