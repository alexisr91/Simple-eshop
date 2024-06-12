<?php 

// gère ce que l'utilisateur va rentrer 
// le nombre d'occurence est le nombre de fois qu'un element apparait dans le même script

// Pour l'heritage, le user qui hérite de controller, le controller est donc la classe parent

	class Users extends Controller{

			public function __construct(){

				// on charge par l'intermediaire du controleur le model 
				$this -> userModel =  $this->model('User');
				$this -> cartModel =  $this->model('Cart');
			}
			public function register(){
				
				// vérifier si on a recours à la méthode POST  / Une requete au serveur 

				if($_SERVER['REQUEST_METHOD'] == 'POST'){ 

					// Validez le formulaire 


					// nettoyer les données récupérées via la requete post 


					$_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);


					// initialiser les données
					
				
				

					// Initialiser les données pour les requetes 
					$data=[
						'name' => trim($_POST['name']), // La fonction TRIM supprime les espaces de la methode post 
						'email' => trim($_POST['email']),
						'prenom' => trim($_POST['prenom']),
						'password' => trim($_POST['password']),
						'confirm_password' => trim($_POST['confirm_password']),
						'name_err' => '',
						'email_err' => '',
						'prenom_err' => '',
						'password_err' => '',
						'confirm_password_err' => ''];

					

				// on chargera la vue à partir du controller 
				
				// validation du nom
				if(empty($data['name'])){
					$data['user_err'] = 'Merci de mettre votre nom';
				}

				//validation de l'email

				if(empty($data['email'])){
					$data['email_err'] = 'Merci de mettre un email';
				}else{
					if($this -> userModel -> findUserByEmail($data['email'])){
						$data['email_err'] = 'Email déjà enregistré dans notre base';
					}
				}

				// validation du mdp

				if(empty($data['password'])){

					$data['password_err'] = 'Merci de mettre un mot de passe';
				}elseif(strlen($data['password']) < 8 ){
					$data['password_err'] = 'Le mot de passe doit etre supérieur à 8 caractères';
				}

				// validation du confirm_password

				if(empty($data['confirm_password'])){

					$data['confirm_password_err'] = 'Merci de confirmer votre mot de passe';
				}else{
					if($data['password'] != $data['confirm_password']){

						$data['confirm_password_err'] = ' Les mots de passe ne sont pas identiques';
					}
				}
				if(empty($data['user_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){

					
					// Crypter le mot de passe 
					$data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
					
					// Validation du formulaire 
					if($this -> userModel -> register($data)){
						redirect('users/login');

					}else{

						die('erreur');
					}
				}
				else{
					// Afficher la vue avec les erreurs

					$this ->view('users/register',$data);
				}
				}

				else{
					
					$data=[
						'name' => '', 
						'email' => '',
						'prenom' => '',
						'password' => '',
						'confirm_password' => '',
						'name_err' => '',
						'email_err' => '',
						'prenom_err' => '',
						'password_err' => '',
						'confirm_password_err' => ''];


						// charger la vue
						$this -> view('users/register',$data);
				}
		 } // fin de la function register 

		 public function login(){

		 		if($this-> isLoggedIn()){
		 			redirect('pages');
		 		}
		 		// vérifier si on a recours à la méthode POST  / Une requete au serveur 

				if($_SERVER['REQUEST_METHOD'] == 'POST'){ 

					// Validez le formulaire 


					// nettoyer les données récupérées via la requete post 


					$_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);


					// initialiser les données
					

					// Initialiser les données pour les requetes 
					$data=[
						
						'name' => trim($_POST['name']),
						'password' => trim($_POST['password']),
						'user_err' => '',
						'password_err' => ''];

				// on chargera la vue à partir du controller 
				
				// validation du nom
				if(empty($data['name'])){
					$data['user_err'] = 'Merci de mettre votre pseudo';
				}else{
					if(!$this -> userModel ->findUserByUsername($data['name'])){

					// email non trouvé 

						$data['name_err'] = ' Pseudo non enregistré ';
					}
				}

				//validation de l'email

				// if(empty($data['email'])){
				// 	$data['email_err'] = 'Merci de mettre un email';
				// }

				// validation du mdp

				if(empty($data['password'])){

					$data['password_err'] = 'Merci de mettre un mot de passe';
				}
				
				// vérification username 

				

				if(empty($data['name_err']) && empty($data['password_err'])){

					// Validation du formulaire 
					 $loggedInUser = $this -> userModel -> login($data['name'],$data['password']);

					 if($loggedInUser){
					 	// création d'une session
					 	
					 	$this -> createUserSession($loggedInUser);	
					 	// redirection de ma connexion pour voir si je suis connecté

					 	redirect('posts');

					 }else{
					 	$data['password_err'] = 'Mdp incorrecte';
					 	$this->view('users/login',$data);
					 }
				}
				
				else{
					// Afficher la vue avec les erreurs

					$this ->view('users/login',$data);
				
				}
				}
				else{
					 // réinitialiser les données
					$data=[
						'name' => '',
						'password' => '',
						'name_err' => '',
						'password_err' => ''
					];
						$this -> view('users/login',$data);
		 	// chargera la vue 

		 	$this->view('users/login',$data); 
		 	}
		}


		// méthode pour les sessions 

		public function createUserSession($user){
			$_SESSION['user_id'] = $user -> id;
			$_SESSION['user_email'] = $user -> email;
			$_SESSION['user_name'] = $user-> name;
			$_SESSION['user_role'] = $user-> id_role;
			$cart = $this->cartModel->associateUserToCart($user->id, $_SESSION['cart']);
			redirect('pages');
		}
		

		public function logout(){

			unset($_SESSION['user_id']);
			unset($_SESSION['user_email']);
			unset($_SESSION['user_name']);
			unset($_SESSION['user_role']);


			session_destroy();

			redirect('users/login');
		}

		public function isLoggedIn(){
			if(isset($_SESSION['user_id'])){
				return true;
			}else{
				return false;
			}
		}

		public function isAdmin(){
			if(isset($_SESSION['user_role']) AND $_SESSION['user_role'] == 1){
				return true;
			}else{
				return false;
			}
		}
	}	