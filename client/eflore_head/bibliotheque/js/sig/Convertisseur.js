/* Source : Code provenant du site http://pages.globetrotter.net/roule/utmgoogle.htm 
 * Licence : ?
*/
var deg2rad = Math.PI / 180;

/*
* Fonction de transformation de coordonnées géographiques entre ellipsoide.
* Source : http://home.hiwaay.net/~taylorc/bookshelf/math-science/geodesy/datum/transform/molodensky/
* Licence : "The source code in the listing below may be copied and reused without restriction, but it is offered AS-IS with NO WARRANTY."
*
* Parameters:
*     from:     The geodetic position to be translated. (objet : GeodeticPosition)
*     from_a:   The semi-major axis of the "from" ellipsoid. (double)
*     from_f:   Flattening of the "from" ellipsoid. (double)
*     from_esq: Eccentricity-squared of the "from" ellipsoid. (double)
*     da:       Change in semi-major axis length (meters); "to" minus "from"
*     df:       Change in flattening; "to" minus "from"  (double)
*     dx:       Change in x between "from" and "to" datum.  (double)
*     dy:       Change in y between "from" and "to" datum.  (double)
*     dz:       Change in z between "from" and "to" datum.  (double)
* 
* Paramêtres :
* 	from :		l'objet GeodesiquePosition à transformer (contient latitute, longitude et hauteur)
* 	from_a : 	le demi grand axe (=a) de l'ellipsoïde utilisé pour la position géodésique contenu dans l'objet "from".
* 	from_f :	l'applatissement (=f) = 1/valeur... de l'ellipsoïde de l'objet "from"
* 	from_esq :	l'excentricité au carré de l'ellipsoïde de l'objet "from"
* 	da :		différence de demi grand axe (en metres) entre l'ellipsoïde "to" et "from".
* 	df : 		différence d'applatissement entre l'ellipsoïde "to" et "from".
* 	dx :		différence pour l'axe x entre l'ellipsoïde "to" et "from".
* 	dy :		différence pour l'axe y entre l'ellipsoïde "to" et "from".
* 	dz :		différence pour l'axe z entre l'ellipsoïde "to" et "from".
*/
function transform(from, from_a, from_f, from_esq, da, df, dx, dy, dz) {
	var slat = Math.sin (from.lat);
	var clat = Math.cos (from.lat);
	var slon = Math.sin (from.lon);
	var clon = Math.cos (from.lon);
	var ssqlat = slat * slat;
	// "a divided by b"
	var adb = 1.0 / (1.0 - from_f);
	var dlat, dlon, dh;
	
	var rn = from_a / Math.sqrt (1.0 - from_esq * ssqlat);
	var rm = from_a * (1. - from_esq) / Math.pow ((1.0 - from_esq * ssqlat), 1.5);
	
	dlat = (((((-dx * slat * clon - dy * slat * slon) + dz * clat) + (da * ((rn * from_esq * slat * clat) / from_a))) + (df * (rm * adb + rn / adb) * slat * clat))) / (rm + from.h);
	
	dlon = (-dx * slon + dy * clon) / ((rn + from.h) * clat);
	
	dh = (dx * clat * clon) + (dy * clat * slon) + (dz * slat) - (da * (from_a / rn)) + ((df * rn * ssqlat) / adb);
	
	// Retour des données sous forme d'objet
	var GeodeticPosition = 	{	lon: from.lon + dlon,
								lat: from.lat + dlat,
								h: from.h + dh
							};
	
	return GeodeticPosition;
}

function test_transform() {
	var PositionNtf = { lon: 7.7372, lat: 48.6, h: 0 };
	var PositionWGS84 = 	transform(PositionNtf, 6378249.2, 0.00340755, 0.0068034881, -112.2, 0.00005474, -168, -60, 320);
	alert('Longitude : ' + PositionWGS84.lon + 'Latitude : ' + PositionWGS84.lat + 'Hauteur : ' + PositionWGS84.h);
}

// Indiquer l'ellipsoid par son index dans le table et pour le xtm mettre 0 pour l'UTM  et 1 pour le MTM (?)
function geo_constants(ellipsoid, xtm) {
	// returns ellipsoid values
	ellipsoid_axis = new Array(); // valeur du demi grand axe (a) de l'ellipsoïde
	ellipsoid_eccen = new Array(); // valeur de l'excentricité au carré (e²) de l'ellipsoïde
	ellipsoid_axis[0] = 6377563.396; ellipsoid_eccen[0] = 0.00667054;  //airy
	ellipsoid_axis[1] = 6377340.189; ellipsoid_eccen[1] = 0.00667054;  // mod airy
	ellipsoid_axis[2] = 6378160; ellipsoid_eccen[2] = 0.006694542;  //aust national
	ellipsoid_axis[3] = 6377397.155; ellipsoid_eccen[3] = 0.006674372;  //bessel 1841
	ellipsoid_axis[4] = 6378206.4; ellipsoid_eccen[4] = 0.006768658;  //clarke 1866 == NAD 27 (TBC)
	ellipsoid_axis[5] = 6378249.145; ellipsoid_eccen[5] = 0.006803511;  //clarke 1880
	ellipsoid_axis[6] = 6377276.345; ellipsoid_eccen[6] = 0.00637847;  //everest
	ellipsoid_axis[7] = 6377304.063; ellipsoid_eccen[7] = 0.006637847;  // mod everest
	ellipsoid_axis[8] = 6378166; ellipsoid_eccen[8] = 0.006693422;  //fischer 1960
	ellipsoid_axis[9] = 6378150; ellipsoid_eccen[9] = 0.006693422;  //fischer 1968
	ellipsoid_axis[10] = 6378155; ellipsoid_eccen[10] = 0.006693422;  // mod fischer
	ellipsoid_axis[11] = 6378160; ellipsoid_eccen[11] = 0.006694605;  //grs 1967
	ellipsoid_axis[12] = 6378137; ellipsoid_eccen[12] = 0.00669438;  //  grs 1980
	ellipsoid_axis[13] = 6378200; ellipsoid_eccen[13] = 0.006693422;  // helmert 1906
	ellipsoid_axis[14] = 6378270; ellipsoid_eccen[14] = 0.006693422;  // hough
	ellipsoid_axis[15] = 6378388; ellipsoid_eccen[15] = 0.00672267;  // int24
	ellipsoid_axis[16] = 6378245; ellipsoid_eccen[16] = 0.006693422;  // krassovsky
	ellipsoid_axis[17] = 6378160; ellipsoid_eccen[17] = 0.006694542;  // s america
	ellipsoid_axis[18] = 6378165; ellipsoid_eccen[18] = 0.006693422;  // wgs-60
	ellipsoid_axis[19] = 6378145; ellipsoid_eccen[19] = 0.006694542;  // wgs-66
	ellipsoid_axis[20] = 6378135; ellipsoid_eccen[20] = 0.006694318;  // wgs-72
	ellipsoid_axis[21] = 6378137; ellipsoid_eccen[21] = 0.00669438;  //wgs-84 (et NAD83 : pourquoi mis avec WGS84 ?)
	
	if (ellipsoid == 0) {
		ellipsoid = 22;
	}
	
	--ellipsoid; // table indexed differently
	
	if (xtm == 1) {
		// WAS: if (ellipsoid > 22)
		scaleTm = 0.9999;
		eastingOrg = 304800.;
	} else {
		scaleTm = 0.9996;
		eastingOrg = 500000.;
	}

	// Retour des données sous forme d'objet
	var ellipsoid = {	axis: ellipsoid_axis[ellipsoid],
						eccentricity: ellipsoid_eccen[ellipsoid],
						eastingOrg: eastingOrg,
						scaleTm: scaleTm
					};
	return ellipsoid;
}

/**This routine determines the correct UTM letter designator for the given latitude
* returns 'Z' if latitude is outside the UTM limits of 84N to 80S
*/
function get_zoneletter(lat) {
	var zoneletter;
	if ((84 >= lat) && (lat >= 72)) zoneletter = 'X';
	else if ((72 > lat) && (lat >= 64)) zoneletter = 'W';
	else if ((64 > lat) && (lat >= 56)) zoneletter = 'V';
	else if ((56 > lat) && (lat >= 48)) zoneletter = 'U';
	else if ((48 > lat) && (lat >= 40)) zoneletter = 'T';
	else if ((40 > lat) && (lat >= 32)) zoneletter = 'S';
	else if ((32 > lat) && (lat >= 24)) zoneletter = 'R';
	else if ((24 > lat) && (lat >= 16)) zoneletter = 'Q';
	else if ((16 > lat) && (lat >= 8)) zoneletter = 'P';
	else if (( 8 > lat) && (lat >= 0)) zoneletter = 'N';
	else if (( 0 > lat) && (lat >= -8)) zoneletter = 'M';
	else if ((-8> lat) && (lat >= -16)) zoneletter = 'L';
	else if ((-16 > lat) && (lat >= -24)) zoneletter = 'K';
	else if ((-24 > lat) && (lat >= -32)) zoneletter = 'J';
	else if ((-32 > lat) && (lat >= -40)) zoneletter = 'H';
	else if ((-40 > lat) && (lat >= -48)) zoneletter = 'G';
	else if ((-48 > lat) && (lat >= -56)) zoneletter = 'F';
	else if ((-56 > lat) && (lat >= -64)) zoneletter = 'E';
	else if ((-64 > lat) && (lat >= -72)) zoneletter = 'D';
	else if ((-72 > lat) && (lat >= -80)) zoneletter = 'C';
	else zoneletter = chr(32 + 66); //This is here as an error flag to show that the Latitude is outside the UTM limits
	return zoneletter;
}

function parseCoordinate(coordinate, type, format, spaced) {
	var coordd;
	var coordm;
	var coords;
	var coordh = 0;
	
	if (coordinate.search(/(^ *-|[WOS])/i) >= 0) {
		coordh = -1;
	}
	if (coordinate.search(/(^ *\+|[NE])/i) >= 0) {
		coordh = 1;
	}
	
	// if (coordinate.search(/[EW]/i) >= 0 && !type) { type = 'lon'; }
	// if (coordinate.search(/[NS]/i) >= 0 && !type) { type = 'lat'; }
	
	coordinate = coordinate.replace(/,/g, '.');  // french commas
	// not sure really needed.
	coordinate = coordinate.replace(/[NESWO+\-]/gi,' ');  // add also: °, ', "  --  or replace everything that is not a number or a dot
	
	// alert("coordinate = " + coordinate);
	if (coordinate.search(/[0-9]/i) < 0) {
		alert("Can't parse input field");
		coordd = "";
		return;
	}

	// http://www.gpsvisualizer.com/calculators
	// http://www.javascriptkit.com/javatutors/redev2.shtml
	var parts = coordinate.match(/([0-9\.\-]+)[^0-9\.]*([0-9\.]+)?[^0-9\.]*([0-9\.]+)?/);
	//                           /                          (one or more)             /
	//                            ([0-9\.\-]+)              digits, dot or -, one set
	//                                        [^0-9\.]*            separator
	//                                                 ([0-9\.]+)?       digits, dot, zero or one set
	//                                                            [^0-9\.]*     separator
	//                                                                     ([0-9\.]+)?  digits, dot, zero or one set

	// *: 0|more   +: 1|more   ?: 0|1        http://www.javascriptkit.com/javatutors/redev2.shtml
	if (!parts[1]) {
		alert("Can't parse input field");
		coordd = '';
		return;
	} else {
		coordd = parts[1];
		if (parts[2]) {
			coordm = parts[2];
		} else {
			coordm = 0;
		}
		if (parts[3]) {
			coords = parts[3];
		} else {
			coords = 0;
		}
		// n = parseFloat(parts[1]);
		// if (parts[2]) { n = n + parseFloat(parts[2])/60; }
		// if (parts[3]) { n = n + parseFloat(parts[3])/3600; }
	}
	
	// Retour des données sous forme d'objet
	var Coordonnee = 	{	coordd: coordd,
							coordm: coordm,
							coords: coords,
							coordh: coordh
						};
	return Coordonnee;
}

function validate_dms(latd, latm, lats, latb, lonm, lond, lons, lonb) {
	var valid = 1;
	if (Math.abs(Number(latd)) >= 90)
		valid = 0;
	if (Number(latm) >= 60)
		valid = 0;
	if (Number(lats) >= 60)
		valid = 0;
	if (Math.abs(Number(lond)) >= 180)
		valid = 0;
	if (Number(lonm) >= 60)
		valid = 0;
	if (Number(lons) >= 60)
		valid = 0;

	return(valid);
}

// convert decimal degrees to dms
function convertir_en_dms(lat, lon) {
	var latbrg = 1;
	var lonbrg = 2;
	if (lat < 0)
		latbrg = 2
	if (lon < 0)
		lonbrg = 1;
	// LEW: have to round here, else could end up with 60 seconds :-)
	var tlat = Math.abs(lat) + 0.5 / 360000;  // round up 0.005 seconds (1/100th)
	var tlon = Math.abs(lon) + 0.5 / 360000;
	
	var tlatdm = Math.abs(lat) + 0.5 / 60000;  // round up 0.0005 minutes (1/1000th)
	var tlondm = Math.abs(lon) + 0.5 / 60000;
	
	var deglat = Math.floor(tlat);
	var t = (tlat - deglat) * 60;
	var minlat = Math.floor(t);
	
	var minlatdm = Math.floor((tlatdm - Math.floor(tlatdm)) * 60 * 1000) / 1000;
	
	var seclat = (t - minlat) * 60;
	seclat = Math.floor(seclat * 100) / 100;  //  works in js 1.4
	// seclat = seclat.toFixed(2);  // 2 decimal places js 1.5 and later
	
	var deglon = Math.floor(tlon);
	
	t = (tlon - deglon) * 60;
	var minlon = Math.floor(t);
	
	var minlondm = Math.floor((tlondm - Math.floor(tlondm)) * 60 * 1000) / 1000;

	var seclon = (t - minlon) * 60;
	seclon = Math.floor(seclon * 100) / 100;  // js 1.4
	// seclon = seclon.toFixed(2);  // js 1.5 and later

	var latb = '';
	if (latbrg > 0) {
		latb = 'N';// 1 = N (nord)
	} else {
		latb = 'S';// 2 = S (sud)
	}
	var latdms = deglat + "° " + minlat + "' " + seclat + "\"";

	var lonb = '';
	if (lonbrg > 0) {
		lonb = 'E'; // 2 = E (est)
	} else {
		lonb = 'W';// 1 = W (west)
	}
	var londms = deglon + "° " + minlon + "' " + seclon + "\"";
	
	var chaine_latlon_dms = latdms + '  ' + latb + '  ' + londms + '  ' + lonb;
	
	// Retour des données sous forme d'objet
	var LatLongDms = 	{	lat: lat,
							lat_degre: Math.floor(tlatdm),
							lat_min: minlatdm,
							lat_s: seclat,
							lat_direction:latb,
							lat_dms:latdms,
							lon: lon,
							lon_degre: Math.floor(tlondm),
							lon_min: minlondm,
							lon_s: seclon,
							lon_direction:lonb,
							lon_dms:londms,
							ll_dms:chaine_latlon_dms
						};
	return LatLongDms;
}

function calculer_coordonnee(lati, longi, ellips, xtm) {
	// Récupération de l'ellipsoide
	var ellipsoid = geo_constants(ellips, xtm);
	var axis = ellipsoid.axis;
	var eccent = ellipsoid.eccentricity;
	var scaleTm = ellipsoid.scaleTm;
	var eastingOrg = ellipsoid.eastingOrg;

	// Nous parsons la latitude saisie
	var CoordonneeLat = parseCoordinate(lati);
	var latb = '';// vide
	if (CoordonneeLat.coordh != 0) {
		if (CoordonneeLat.coordh > 0) {
			latb = 'N';// 1 = N (nord)
		} else {
			latb = 'S';// 2 = S (sud)
		}
	}
	var latd = CoordonneeLat.coordd;
	var latm = CoordonneeLat.coordm;
	var lats = CoordonneeLat.coords;

	// Nous parsons la longitude saisie
	var CoordonneeLon = parseCoordinate(longi);
	var lonb = '';// vide
	if (CoordonneeLon.coordh != 0) {
		if (CoordonneeLon.coordh > 0) {
			lonb = 'E'; // 2 = E (est)
		} else {
			lonb = 'W';// 1 = W (west)
		}
	}
	var lond = CoordonneeLon.coordd;
	var lonm = CoordonneeLon.coordm;
	var lons = CoordonneeLon.coords;

	// cope with blank fields
	if (latd == '' || lond == '')	{
		alert("Latitude and longitude degrees must be entered");
		return;
	}

	// Indication de la direction par défaut pour la latitude et la longitude en France
	if (latb == '') {
		latb = 'N';// 1 = N (Nord)
	}
	if (lonb == '') {
		lonb = 'E';// 2 = E (Est)
	}

	// Validation
	var valid = validate_dms(latd, latm, lats, latb, lonm, lond, lons, lonb);
	if (valid == 0) {
		alert("Invalid degrees, minutes or seconds");
		return;
	}
	
	var lat = Number(latd);
	lat = lat + Number(latm) / 60;
	lat = lat + Number(lats) / 3600;
	if (latb == 'S') {  // 2 = S
		lat = lat * -1;
	}
	var lon = Number(lond);
	lon = lon + Number(lonm) / 60;
	lon = lon + Number(lons) / 3600;
	if (lonb == 'W') { // 1 = W
		lon = lon * -1;
	}

	if (lat >= 84 || lat <= -80) {
		alert("UTM latitudes should be between 84N and 80S\nCalculation will proceed anyway as locator will be valid.");
	}

	var k0 = scaleTm;
	var latrad = lat * deg2rad;
	var longrad = lon * deg2rad;
	var zonenum = Math.floor((lon + 180) / 6) + 1;
	// @dc (180 - (-70.5))/3 - 76
	if (eastingOrg == 304800.) {
		zonenum = Math.floor((180 - lon) / 3) - 76;  // MTM, only in Quebec
		if (zonenum < 3 || zonenum > 10) {
			alert("MTM zone numbers only confirmed for 3-10, province of Quebec\nContinuing anyway");
		}
	}

	if (lat >= 56.0 && lat < 64.0 && lon >= 3.0 && lon < 12.0 ) {
		zonenum = 32;
	}
	// Zones speciales pour Svalbard
	if( lat >= 72.0 && lat < 84.0 ) {
		if (lon >= 0.0  && lon <  9.0 ) zonenum = 31;
		else if ( lon >= 9.0  && lon < 21.0 ) zonenum = 33;
		else if ( lon >= 21.0 && lon < 33.0 ) zonenum = 35;
		else if ( lon >= 33.0 && lon < 42.0 ) zonenum = 37;
	}

	var lonorig = (zonenum - 1) * 6 - 180 + 3;  //+3 puts origin in middle of zone
	// @dc 180 - (7+76) * 3 - 1.5
	if (eastingOrg == 304800.) {
		lonorig = 180 - (zonenum + 76) * 3 - 1.5;
	}
	var lonorigrad = lonorig * deg2rad;

	//Récupération de la lettre du fuseau xTM
	var letter = get_zoneletter(lat);

	// Calcul xTM
	var eccPrimeSquared = (eccent) / (1 - eccent);
	var N = axis / Math.sqrt(1 - eccent * Math.sin(latrad) * Math.sin(latrad));
	var T = Math.tan(latrad) * Math.tan(latrad);
	var C = eccPrimeSquared * Math.cos(latrad) * Math.cos(latrad);
	var A = Math.cos(latrad) * (longrad - lonorigrad);
	var M = axis * ((1 - eccent / 4 - 3 * eccent * eccent / 64 - 5 * eccent * eccent * eccent / 256) * latrad - (3 * eccent / 8 + 3 * eccent * eccent / 32 + 45 * eccent * eccent *eccent / 1024) * Math.sin(2 * latrad) + (15 * eccent * eccent / 256 + 45 * eccent * eccent * eccent / 1024) * Math.sin(4 * latrad) - (35 * eccent * eccent * eccent / 3072) * Math.sin(6 * latrad));

	var easting = (k0 * N * (A + (1 - T + C) * A * A * A / 6 + (5 - 18 * T + T * T + 72 * C - 58 * eccPrimeSquared) * A * A * A * A * A / 120) + eastingOrg);
	var northing = (k0 * (M + N * Math.tan(latrad) * (A * A / 2 + (5 - T + 9 * C + 4 * C * C) * A * A * A * A / 24 + (61 - 58 * T + T * T + 600 * C - 330 * eccPrimeSquared) * A * A * A * A * A * A / 720)));
	if (lat < 0) {
		northing += 10000000.0; //10000000 meter offset for southern hemisphere
	}
	
	// xTM
	// Arrondi au nombre supérieur
	// alert("easting = " + easting);
	preciseEasting = easting;
	easting = Math.floor(easting + .5);
	// alert("easting = " + easting);
	// alert("northing = " + northing);
	preciseNorthing = northing;
	northing = Math.floor(northing + .5);
	// alert("northing = " + northing);
	var chaine_xtm = '';
	var x_tm = '';
	if (eastingOrg == 304800.) {
		chaine_xtm = zonenum + '  ' + easting + 'm E  ' + northing + 'm N';
		x_tm = 'MTM';
	} else {
		chaine_xtm = zonenum + letter + '  ' + easting + 'm E  ' + northing + 'm N';
		x_tm = 'UTM';
	}

	// Latitude/Longitude
	var chaine_latlon = lat + ' ' + latb + ' ' + lon + ' ' + lonb;
	var LatLongDms = convertir_en_dms(lat,lon);
	
	// Retour des données sous forme d'objet
	var Coordonnee = {	xtm: x_tm,
						nord: northing,
						est: easting,
						zone_numero: zonenum,
						zone_lettre: letter,
						xtm_chaine: chaine_xtm,
						latitude:lat,
						longitude:lon,
						ll_chaine: chaine_latlon,
						latitude_dms:LatLongDms.lat_dms,
						longitude_dms:LatLongDms.lon_dms,
						ll_chaine_dms: LatLongDms.ll_dms
					};
	return Coordonnee;
}