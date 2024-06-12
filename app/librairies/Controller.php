<?php 

/*
* Controleur de base 
* s'occupe de charger les modèles et les vues 
*/


class Controller {
	// chargement du modèle (données)

	public function model($model){
		// donne le chemin vers le fichier 

		require_once '../app/models/'. $model . '.php';
		// retournera le modèle et donc instancie la classe 

		// instancier la classe
		return new $model;
	}

	//chargement de la vue 

	public function view($view,$data = []){
		if(file_exists('../app/views/'. $view . '.php')){ // test si le dossier views existe
			require_once '../app/views/'. $view . '.php';
		}
		else{
			die("la vue n'existe pas");
		}
	}
}