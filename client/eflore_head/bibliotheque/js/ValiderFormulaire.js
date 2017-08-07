/* 
Origine du script : http://actuel.fr.selfhtml.org/articles/javascript/controle_formulaire/index.htm
Auteur : Dieter RABER <d.raber@gmx.net>
*/
function validate(sender, myarray, err_hd) {
	
	var message_erreur = !err_hd?new Array('Les erreurs suivantes sont survenues:\n'):new Array(err_hd+'\n');
	var error = false;

	if (!sender.name) {
		alert('Le formulaire doit comporter un attribut name');
		return false;
	}

	for (i = 0; i < myarray.length; i++) {
		field = document.forms[sender.name].elements[myarray[i][0]];
	
		/* Bloc 1 vérifie les champs qui doivent être renseignés */
		if (myarray[i][1].indexOf('e') > -1) {
			if (!field.value) {
				error = true;
				message_erreur.push(myarray[i][2]);
			}
		}
	
	/* Bloc 2 vérifie si l'adresse électronique est correcte dans la forme */
		else if (myarray[i][1].indexOf('m')>-1) {
			if (field.value) {
				var usr = "([a-zA-Z0-9][a-zA-Z0-9_.-]*|\"([^\\\\\x80-\xff\015\012\"]|\\\\[^\x80-\xff])+\")";
	  		var domain = "([a-zA-Z0-9][a-zA-Z0-9._-]*\\.)*[a-zA-Z0-9][a-zA-Z0-9._-]*\\.[a-zA-Z]{2,5}";
				var regex = "^"+usr+"\@"+domain+"$";
				var myrxp = new RegExp(regex);
				var check = (myrxp.test(field.value));
					if (check!=true) {
						error = true;
						message_erreur.push(field.value+" "+myarray[i][2]);
					}
				}
			}
	
	/* Bloc 3 vérifie les champs dont la valeur doit être numérique */
		else if (myarray[i][1].indexOf('n')>-1) {
			var num_error = false;
			if(field.value) {
				var myvalue = field.value;
				var num = myvalue.match(/[^0-9,\.]/gi)
				var dot = myvalue.match(/\./g);
				var com = myvalue.match(/,/g);
				if (num!=null) {
					num_error = true;
				}
				else if ((dot!=null)&&(dot.length>1)) {
					num_error = true;
				}
				else if ((com!=null)&&(com.length>1)) {
					num_error = true;
				}
				else if ((com!=null)&&(dot!=null)) {
					num_error = true;
				}
			}
			if (num_error==true) {
					error = true;
					message_erreur.push(myvalue+" "+myarray[i][2]);
			}
		}
	
	/* Bloc 4 vérifie la valeur à l'aide d'une expression régulière sur un modèle déterminé */
		else if (myarray[i][1].indexOf('r')>-1) {
			var regexp = myarray[i][3];
			if (field.value) {
				if (!regexp.test(field.value)) {
					error = true;
					message_erreur.push(field.value+" "+myarray[i][2]);
				}
			}
		}
	
	/* Bloc 5 vérifie les champs qui doivent être formatés comme des prix et modifie éventuellement le formatage */
		else if (myarray[i][1].indexOf('p')>-1) {
			var myvalue = field.value;
			var reg = /,-{1,}|\.-{1,}/;
			var nantest_value = myvalue.replace(reg,"");
			var num = nantest_value.match(/[^0-9,\.]/gi)
			sep = myarray[i][1].substr(1,1)?myarray[i][1].substr(1,1):',';
			if (field.value) {
				var myvalue = field.value.replace(/\./,',');
				if (myvalue.indexOf(',')==-1) {
					field.value = myvalue+sep+'00';
				}
				else if (myvalue.indexOf(",--")>-1) {
					field.value = myvalue.replace(/,--/,sep+'00');
				}
				else if (myvalue.indexOf(",-")>-1) {
					field.value = myvalue.replace(/,-/,sep+'00');
				}
				else if (!myvalue.substring(myvalue.indexOf(',') + 2)) {
					error=true;
					message_erreur.push(field.value+" "+myarray[i][2]);
				}
				else if (myvalue.substring(myvalue.indexOf(',') + 3)!='') {
					error=true;
					message_erreur.push(field.value+" "+myarray[i][2]);
				} else if (num!=null) {
					error = true;
					message_erreur.push(field.value+" "+myarray[i][2]);
				}
			}
		}
		
		/* Bloc 6 vérifie les champs de nom et rectifie éventuellement la casse */
		else if (myarray[i][1].indexOf('c')>-1) {
			var noble = new Array(" d\'", "de","von","van","der","d","la","da","of");
			var newvalue='';
			var myvalue = field.value.split(/\b/);
			for (k=0;k<myvalue.length;k++) {
				newvalue+= myvalue[k].substr(0,1).toUpperCase()+myvalue[k].substring(1);
			}
			for(k = 0; k < noble.length; k++){
				var reg = new RegExp ("\\b"+noble[k]+"\\b","gi");
				newvalue = newvalue.replace(reg,noble[k]);
			}
			field.value = newvalue;
		}
	}
	
	/* 	En cas d'erreur, les messages d'erreur récoltés sont exploités ici puis affichés.
		Si le formulaire est correctement rempli, il est transmis */
	if (error) {
		message_erreur = message_erreur.join('\n\xB7 ');
		alert(message_erreur);
		return false;
	} else {
		return true;
	}
}