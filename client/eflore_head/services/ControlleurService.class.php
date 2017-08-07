<?php

/**
* Identifie la ressource demandée et récupère les informations la concernant.
* Le service concerné est alors appelé!
*
* @author Jean-Pascal MILCENT <jpm@clapas.org>
* @version $Revision: 1.1 $
* @public
*/
class ControlleurService {

	/*** Attributs : ***/
	private $Requete;
	private $requete_uri;
	private $requete_methode = 'GET';
	private $requete_donnees = null;
	
	private $Reponse;
	
	private $Service = null;
	private $service_nom = null;// Équivaut à $resource
	private $service_nom_chamo = null;// avec les _ supprimés et des majuscules au début de chaque mot
	private $service_arguments = null;// Équivaut à $uid
	private $resource = null;
	private $uid = null;
	
	/*** Constructeurs : ***/
	
	public function __construct($Requete, $Reponse)
	{
		$this->Requete = $Requete;
		$this->requete_uri = $Requete->getEnteteParametre()->getUri();
		$this->requete_methode = $Requete->getEnteteParametre()->getMethode();
		$this->requete_donnees = $Requete->getEntite()->getContenu();
		
		$this->Reponse = $Reponse;
		
		// Analyse de l'URI, récupération d'informations
		$tab_uri = explode('/', $this->requete_uri);
		// Nous supprimons tous les éléments qui ne sont pas des arguments 
		foreach ($tab_uri as $param) {
			array_shift($tab_uri);
			if ($param == 'services') {
				break;
			}
		}
		
		// Récupération du nom du service demandé
		if (isset($tab_uri[0])) {
			$this->resource = $tab_uri[0];
			$this->setServiceNom($tab_uri[0]);
		}

		// Récupération de l'uid
		if (count($tab_uri) > 1 && $tab_uri[1] != '') {
			array_shift($tab_uri);
			foreach ($tab_uri as $uid) {
				if ($uid != '') {
					$this->uid[] = $uid;
					$this->setArguments($uid);
				}
			}
		}
	}
		
	/*** Accesseurs : ***/
	
	// Service Nom ou resource
	private function setServiceNom( $sn )
	{
		$this->service_nom = $sn;
		$this->service_nom_chamo = str_replace(' ', '', ucwords(str_replace('_', ' ', $sn)));
	}
	private function getServiceNomChamo()
	{
		return $this->service_nom_chamo;
	}
	public function getServiceNom()
	{
		return $this->service_nom;
	}
	
	public function getServiceFichier()
	{
		return EFS_CHEMIN_SERVICE.$this->getServiceNom().DS.$this->getServiceNomChamo().'.class.php';
	}
	
	// Arguments ou uid
	private function setArguments( $a )
	{
		$this->service_arguments[] = $a;
	}
	public function getArguments($a = null)
	{
		if (is_null($a)) {
			return $this->service_arguments;
		} else {
			return $this->service_arguments[$a];
		}
	}
	
	/*** Méthodes : ***/
	
	/**
	* Execute le service demandé et crée la réponse appropriée.
	*
	* @public
	* @return HttpReponse la réponse à renvoyer.
	*/
	public function executer()
	{
		// Initialisation du service
		if (file_exists($this->getServiceFichier())) {
			require EFS_CHEMIN_SERVICE.$this->getServiceNom().DS.$this->getServiceNomChamo().'.class.php';
			if (class_exists($this->getServiceNomChamo())) {
				$service_classe = $this->getServiceNomChamo();
				$this->Service = new $service_classe($this->getArguments());
			} else {
				trigger_error('Le classe du service demandée ['.$this->getServiceNomChamo().'] n\'existe pas!', E_USER_WARNING);
			}
		} else {
			trigger_error('Le fichier du service demandé ['.$this->getServiceFichier().'] n\'existe pas!', E_USER_WARNING);
		}
		
		// Recherche et lancement du type d'action à effectuer
		switch ($this->requete_methode) {
			case 'GET' :
				$this->executerConsultation();
				break;
			case 'PUT' :
				$this->executerAjout();
				break;
			case 'POST' :
				// Gestion du DELETE via le POST : si paramêtre "action" vaut "DELETE", nous sommes en mode Suppression
				// Safari ne sait pas envoyer des DELETE avec gwt ... et en plus c'est bien plus simple comme ca !
				if ($this->requete_donnees) {
					$paires = $this->parserRequeteDonnees();
					if ($paires['action'] == 'DELETE') {
 						$this->executerSuppression();
 						break;
					}
				}
				
				// Gestion du PUT via le POST : si pas d'arguments, c'est que nous sommes en mode Ajout.
				if (is_null($this->getArguments())) {
					$this->executerAjout();
					break;
				}
				// Nous sommes bien en mode POST :
				$this->executerModification();
				break;
			case 'DELETE' :
				$this->executerSuppression();
				break;
		}
		
		// Gestion du débogage
		if (EF_DEBOGAGE) {
			$this->Reponse->getEnteteParametre()->setCode(404);
			//$this->Reponse->getEntite()->getEntete()->setContentType('text/plain; charset=ISO-8859-1');
			$Registre = Registre::getInstance();
			$this->Reponse->getEntite()->setContenu($Registre->get('Erreur')->retournerErreur());
		}
		
		// Gestion de la sortie
		$this->Reponse->genererReponse();
		exit();
	}
	/**
	* Execution de la méthode consulter() ou consulterElement du service
	* @return void
	*/
	private function executerConsultation() {
		if ($this->getArguments()) { // Nous avons des arguments, donc un seul élément est démandé
			$methode = 'consulterElement';
			if (method_exists($this->Service, $methode)) {
				$this->Service->consulterElement($this->getArguments());
			} else {
				$e = 'La méthode du service demandé n\'existe pas!'."\n";
				$e .= 'Service : '.$this->getServiceFichier()."\n";
				$e .= 'Méthode : '.$methode.'()'."\n";
				trigger_error($e, E_USER_WARNING);
			}
		} else { // Aucun argument : nous renvoyons les infos sur l'ensemble des éléments
			$methode = 'consulter';
			if (method_exists($this->Service, $methode)) {
				$this->Service->consulter();
			} else {
				$e = 'La méthode du service demandé n\'existe pas!'."\n";
				$e .= 'Service : '.$this->getServiceFichier()."\n";
				$e .= 'Méthode : '.$methode.'()'."\n";
				trigger_error($e, E_USER_WARNING);
			}
		}
	}
	
	/**
	* Execution de la méthode modifier() du service
	* @return void
	*/
	private function executerModification() {
		$methode = 'modifier';
		if ($this->requete_donnees) {
			$paires = $this->parserRequeteDonnees();
			if (method_exists($this->Service, $methode)) {
				if($this->Service->modifier($this->getArguments(), $paires)) {
					$this->created();
				} else {
					// TODO : a voir le retour ...
				}
			} else {
				$e = 'La méthode du service demandé n\'existe pas!'."\n";
				$e .= 'Service : '.$this->getServiceFichier()."\n";
				$e .= 'Méthode : '.$methode.'()'."\n";
				trigger_error($e, E_USER_WARNING);
			}
		} else {
			$this->lengthRequired();
		}
	}
		
	/**
	* Execution de la méthode ajouter() du service
	* @return void
	*/
	private function executerAjout() {
		$methode = 'ajouter';
		if ($this->requete_donnees) {
			$paires = $this->parserRequeteDonnees();
			if (method_exists($this->Service, $methode)) {
				if($this->Service->ajouter($paires)) {
					$this->created();
				} else {
					// TODO : a voir le retour ...
				}
			} else {
				$e = 'La méthode du service demandé n\'existe pas!'."\n";
				$e .= 'Service : '.$this->getServiceFichier()."\n";
				$e .= 'Méthode : '.$methode.'()'."\n";
				trigger_error($e, E_USER_WARNING);
			}
		} else {
			$this->lengthRequired();
		}
	}
	
	/**
	* Execution de la méthode supprimer() du service
	* @return void
	*/
	private function executerSuppression() {
		$methode = 'supprimer';
		if ($this->getArguments()) { 
			if (method_exists($this->Service, $methode)) {
				if($this->Service->supprimer($this->getArguments())) {
					$this->nocontent();
				} else {
					// TODO : a voir le retour ...
				}
			} else {
				$e = 'La méthode du service demandé n\'existe pas!'."\n";
				$e .= 'Service : '.$this->getServiceFichier()."\n";
				$e .= 'Méthode : '.$methode.'()'."\n";
				trigger_error($e, E_USER_WARNING);
			}
		} else {
			$e = 'La méthode DELETE exige des arguments!'."\n";
			$e .= 'Service : '.$this->getServiceFichier()."\n";
			trigger_error($e, E_USER_WARNING);
		}
	}
	
	/**
	* Parse les données des requêtes HTTP.
	* @return array Talbeau avec les clés et valeurs des données.
	*/
	private function parserRequeteDonnees() {
		$valeurs = array();
		$paires = explode('&', $this->requete_donnees);
		foreach ($paires as $paire) {
			$parties = explode('=', $paire);
			if (isset($parties[0]) && isset($parties[1])) {
				$parties[1] = rtrim($parties[1]);
				$valeurs[$parties[0]] = $parties[1];
			}
		}
		return $valeurs;
	}
	
	// Send a HTTP 201 response header.
	function created($url = FALSE) {
		$this->Reponse->getEnteteParametre()->setCode(201);
		if ($url) {
			$this->Reponse->getEntite()->setContentLocation($url);   
		}
	}
	
	// Send a HTTP 204 response header.
	function noContent() {
		$this->Reponse->getEnteteParametre()->setCode(204);
	}
	
	// Send a HTTP 400 response header.
	function badRequest() {
		$this->Reponse->getEnteteParametre()->setCode(400);
	}
	
	// Send a HTTP 401 response header.
	function unauthorized($realm = 'JRest') {
		if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
			header('WWW-Authenticate: Basic realm="'.$realm.'"');
		}
		$this->Reponse->getEnteteParametre()->setCode(401);   
	}
	
	// Send a HTTP 404 response header.
	function notFound() {
		$this->Reponse->getEnteteParametre()->setCode(404);
	}
	
	// Send a HTTP 405 response header.
	function methodNotAllowed($allowed = 'GET, HEAD') {
		$this->Reponse->getEnteteParametre()->setCode(405);
		$this->Reponse->getEntite()->setAllow($allowed);
	}
	
	// Send a HTTP 406 response header.
	function notAcceptable() {
		$this->Reponse->getEnteteParametre()->setCode(406);
		echo join(', ', array_keys($this->config['renderers']));
	}
	
	// Send a HTTP 411 response header.
	function lengthRequired() {
		$this->Reponse->getEnteteParametre()->setCode(411);
	}
	
	// Send a HTTP 500 response header.
	function internalServerError() {
		$this->Reponse->getEnteteParametre()->setCode(500);
	}
}
?>