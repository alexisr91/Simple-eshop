<?php 


/* Classe => noyau de l'application
*Création des URL et charge le controleurde base
* Format des urls => controllers/method/params
*/

class Core{

	protected $currentController = 'Pages';
	protected $currentMethod = 'index';
	protected $params = [];

	public function __construct(){

		// print_r($this->getUrl()); verifier contenu du tableau 

		$url = $this -> getUrl();

		// on recherche si le controller correspondant au premier parametre existe 


		if(!is_null($url)){
    		if(file_exists('../app/controllers/'. ucwords($url[0]) . '.php')){
       		 $this -> currentController = ucwords($url[0]);
       		 unset($url[0]);
       }
    }

		require_once '../app/controllers/' .$this -> currentController. '.php';

		// on instancie 

		$this -> currentController = new $this -> currentController;

		// On vérifie si il y a 2eme parametre 

		if(isset($url[1])){
			// On verifie si la méthode existe 
			if(method_exists($this -> currentController, $url[1])){
				// on met à jour l'attribut currentMethod 

				$this -> currentMethod = $url[1];

				unset($url[1]);
			}
		}

		/*echo $this -> currentMethod;*/

		// autre paramètre présent dans l'URl => index.php?pages=contact&id=1

		$this -> params = $url ? array_values($url) : [];

		// retourne le tableau de paramètres

		call_user_func_array([$this-> currentController, $this-> currentMethod], $this -> params);


	}


	public  function getUrl(){
		if(isset($_GET['url'])){
			$url = rtrim($_GET['url'], '/'); // rtrim enleve les espaces à la fin d'une chaine et dans le 2eme parametre, on précise le / 
			$url = filter_var($url, FILTER_SANITIZE_URL); // sanitize supprime les caractères spéciaux
			$url = explode('/', $url);
			return $url;
		}
	}

}