<?php 


class Product{
	private $db; // Attribut de class

	public function __construct(){

		$this->db = new Database();

	}

	/*  * = veut dire ALL lors d'une lecture donnée 
	
	    SELECT DISTINCT product_name FROM table = le mot clé DISTINCT pour éviter de lire des données en doublon



	    SELECT product_name AS... AS = Mot clé pour faire un ALIAS de sa colonne/ table



	    SELECT * FROM... WHERE... = WHERE est une condition en langage SQL 


	    SELECT * FROM... WHERE... IN() =  IN mot clé pour filtrer des valeurs numériques au lieu de faire des OR 

	    SELECT * FROM.. WHERE... LIKE '' = LIKE mot clé pour filtrer les strings, mettre % après le string  pour que le nom soit pris en compte avant.

	    SELECT * FROM.. WHERE... LIMIT 3,5; = On recupere les 3 premieres requetes à partir de la 6eme row ( offset )


		



	*/


	public function add($datas){
		$this->db->query('
			INSERT INTO products
			(name,description,price_ht,price_ttc,img,created_at,stock)
			VALUES (:name,:description,:price_ht,:price_ttc,:img,:created_at,:stock)
			');

		$this->db->bind(':name',$datas['name']);
		$this->db->bind(':description',$datas['description']);
		$this->db->bind(':price_ht',$datas['price_ht']);
		$this->db->bind(':price_ttc',$datas['price_ttc']);
		$this->db->bind(':img',$datas['img']);
		$this->db->bind(':stock',$datas['stock']);
		$this->db->bind(':created_at',$datas['created_at']);

		if($this->db->execute()){
			return true; // renvoie d'une fonction ( CHAR, obj, boolean ), un statement a toujours un ;
		}else{
			return false;
		}
	}


	public function getProducts(){ 

		$this->db->query('SELECT * FROM products WHERE suppr=:suppr ORDER BY id DESC');
		$this->db->bind(':suppr',0);
		$result = $this-> db-> resultSet();
		return $result;
	}


	public function getProduct($id){
		// WHERE : Condition dans une requete SQL
		// : Notation pour indiquer un parametre dans ma requete préparée ( evite les injections SQL )
		// prepare = mot clé obligatoire pour la requete 
		$this->db->query('SELECT * FROM products WHERE id = :id');

		// Quand on fait un SELECT on attend un return contrairement au DELETE, UPDATE et à l'INSERT

		$this->db->bind(':id',$id); // bind = on dit qu'elle valeur aura mon parametre de ma requete SQL 

		$row = $this->db-> single();


		return $row; 
		// la fonction execute doit prendre un array 

	}


	public function update($datas){

		$this->db->query('
			UPDATE products SET
			name = :name,
			description = :description,
			price_ht = :price_ht,
			price_ttc = :price_ttc,
			img = :img,
			stock = :stock -- Ne pas mettre de virgule après la fin de la liste -- 
			WHERE id = :id
			');

		// Penser à bind tous les parametres qu'on a requeté
		$this->db->bind(':name', $datas['name']);
		$this->db->bind(':description', $datas['description']);
		$this->db->bind(':price_ht', $datas['price_ht']);
		$this->db->bind(':price_ttc', strval($datas['price_ttc'])); // strvval = Fonction qui peut changer un type de param ( float, int etc ) en string
		$this->db->bind(':img', $datas['img']);
		$this->db->bind(':stock', $datas['stock']);
		$this->db->bind(':id', $datas['id']);
		$this->db->execute();


		if($this->db->execute()){
			return true; // renvoie d'une fonction ( CHAR, obj, boolean ), un statement a toujours un ;
		}else{
			return false;
		}
	}




	public function update_stock($id,$qty){ // update stock de l'API 
		$this->db->query('UPDATE products SET   
			 stock=:stock
			WHERE id=:id
			');

		$this->db->bind(':id',$id);
		$this->db->bind(':stock',$qty);

		if($this->db->execute()){
			return true;
		}else{
			return false;
		}

	}



	public function delete($id){
		$this->db->query('DELETE FROM product WHERE id=:id');
		$this->db->bind(':id',$id);

		if($this->db->execute()){
			return true;
		}else{
			return false;
		}
	}


	public function suppr($id){
		$this->db->query('
			UPDATE products SET 
			suppr =:suppr
			WHERE id= :id
			');

		$this->db->bind(':suppr',true);
		$this->db->bind(':id',$id);

	}

}