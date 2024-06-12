<?php 
// CONTROLEUR
class Posts extends Controller{


	public function __construct(){ // Si la fonction de login est fausse il retourne vers le login.php
		if(!isLoggedin()){
			redirect('users/login'); 
		}
		$this-> postModel = $this->model('Post');
		$this-> userModel = $this->model('User');
	}


	public function index(){

	$posts = $this ->  postModel -> getPosts();	

		$data = [
			'posts'=> $posts
		];

		$this -> view('posts/index',$data);
	}

	public function add(){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){

			// nettoyage du tableau 

			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data = [
				'title'=>trim($_POST['title']),
				'body'=>trim($_POST['body']),
				'user_id'=>$_SESSION['user_id'],
				'title_err'=>'',
				'body_err'=>'',
			];

			// validation des données 

			if(empty($data['title'])){
				$data['title_err'] = 'Merci de rentrer un titre';

			}

			if(empty($data['body'])){
				$data['body_err'] = 'Merci d\'ajouter du contenu';				
			}

			// Vérifier qu'il n'y a pas d'erreurs pour rediriger l'utilisateur

			if(empty($data['title_err']) && empty($data['body_err'])){

				// validé 

				if($this->postModel->addPost($data)){

				// Message Flash

				// On est redirigé vers la page article 
					
					redirect('posts');
				}else{
					die('une erreur est survenue');
				}

			}else{
				// on charge la vue avec les erreurs

				$this ->view('posts/add',$data);
			}


		}else{
			$data = [
			'title'=> '',
			'body' => ''];

			$this ->view('posts/add', $data);
		}
	}

	public function show($id){
		$post = $this -> postModel ->getPostById($id);
		$user = $this -> userModel ->getUserById($post-> user_id);
		$data = [
			'post'=>$post,
			'user'=>$user
		];

		$this -> view('posts/show',$data);
	}

	public function edit($id){


	

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			// nettoyer le tableau
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			 
			$data = [
				'id'=>$id,
				'title'=> trim($_POST['title']),
				'body'=> trim($_POST['body']),
				'user_id' => $_SESSION['user_id'],
				'title_err' =>'',
				'body_err'=>''
			];
			// valider les données


			if(empty($data['title'])){

				$data['title_err'] = 'merci de saisir un titre';
			}

			if(empty($data['body'])){

				$data['body_err'] = 'merci de saisir un texte';
			}


			// vérifier qu'il n'y ait pas d'erreurs

			if(empty($data['title_err']) && empty($data['body_err'])){
				// validation 

				if($this ->postModel ->updatePost($data)){

					redirect('posts');
				}else{
					
					die('Une erreur est survenue ');
				}
			}else{
			// charge la vue avec erreurs
			$this -> view('posts/edit',$data);

			}


		}else{

			// Aller chercher l'article actuel à partir du model 

			$post = $this ->postModel->getPostById($id);

			// vérifier si il s'agit de l'auteur

			if($post ->user_id != $_SESSION['user_id']){
				redirect('posts');
			}

			$data = [
				'id'=> $id,
				'title'=> $post -> title,
				'body'=> $post -> body
			];


			// => Fat arrows sont présentes dans les tableaux associatifs 

			$this->view('posts/edit',$data);
		}
	}

	public function delete($id){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){


			$post = $this ->postModel ->getPostById($id);

			if($post -> user_id != $_SESSION['user_id']){
				redirect('posts');
			}



			if($this->postModel->deletePost($id)){

				// Message flash pour dire que l'article a été supprimé et on redirige
				redirect('posts');

			}else{

				die('Une erreur est survenue');

			}

		}else{

			redirect('posts');
		}
	}
}

