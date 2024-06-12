<?php 

class User{

	private $db;

	public function __construct(){

		$this -> db = new Database;
	}


// insertion  des utilisateurs dans la bdd 

	public function register($data){
		// préparer la requête 

		$this -> db -> query("INSERT INTO users(name,prenom,email,password) VALUES(:name,:prenom,:email,:password)"); // Les values doivent etre dans le mm ordre que j'ai défini dans les parametres du INSERT INTO.

		// bind 

		$this -> db -> bind(':name', $data['name']);
		$this -> db -> bind(':prenom', $data['prenom']);
		$this -> db -> bind(':email', $data['email']);
		$this -> db -> bind(':password', $data['password']);
		// execution

		if($this -> db -> execute()){

			return true;
		}else{
			return false;
		}
	}

// vérification pseudo / password 

	public function login($name,$password){
		
		// requete préparée

		$this ->db -> query('SELECT * FROM users where name=:name');
		// bind 

		$this ->db ->bind(':name',$name);

		// execution 

		$row = $this -> db -> single();

		// Mdp crypté

		$hashed_password = $row -> password;

		if(password_verify($password,$hashed_password)){

			return $row;
		}else{

			return false;
		}
	}




// 
/** 
 *   Trouver l'utilisateur par le billet de son email 
 */

	public function findUserByEmail($email){
		
		// on prépare la requete

		$this -> db -> query("SELECT * FROM users WHERE  email = :email");

		// On relie les parametres de la requete avec les valeurs passées 

		$this -> db -> bind(':email', $email);

		// On va executer la requete
		// On stocke la ligne retournée
		$row = $this -> db ->single();

		// On compte le nombre de lignes pour cette email

		if($this-> db -> rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}


/*Trouver l'utilisateur par le billet de son email */

	public function findUserByUsername($name){
		
		// on prépare la requete

		$this -> db -> query("SELECT * FROM users WHERE name = :name");

		// On relie les parametres de la requete avec les valeurs passées 

		$this -> db -> bind(':name', $name);

		// On va executer la requete
		// On stocke la ligne retournée
		$row = $this -> db ->single();

		// On compte le nombre de lignes pour cette email


		if($this-> db -> rowCount() > 0){ 

		// Donc si le nombre de ligne est supérieure à 0, ça met vrai sinon ça met faux
			return true;
		}else{
			return false;
		}
	}


	public function getUserById($id){
		$this ->db -> query('SELECT * FROM users WHERE id=:id');

		$this ->db -> bind(':id',$id);

		$row = $this -> db -> single();

		return $row;
	}


	public function getUsers(){
		
		$this->db->query('SELECT * FROM users ORDER BY id DESC');
		$result = $this->db->resultSet();

		return $result;
	}

}

















