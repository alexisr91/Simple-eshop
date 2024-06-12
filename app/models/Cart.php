<?php 

// L'ID  est relié à l'ID_Cart 
Class Cart{

	private $db;

	public function __construct(){
		$this->db = new Database;
	}

	public function add($data){
		$this->db->query('
			INSERT INTO cartline (id_product, id_cart, qty, amount)
			VALUES (:id_product,:id_cart,:qty,:amount)
			');

		$this->db->bind(':id_product', $data['id_product']);
		$this->db->bind(':id_cart', $data['id_cart']);
		$this->db->bind(':qty',$data['qty']);
		$this->db->bind(':amount', $data['amount']);


		if($this->db->execute()){
			return true;
		}else{
			return false;
		}

	}


	public function update($data){
		$this->db->query('
			UPDATE cartline SET amount= :amount, qty=:qty WHERE id_product=:id_product
			');


	$this->db->bind(':id_product', $data['id_product']);
	$this->db->bind(':qty', $data['qty']);
	$this->db->bind(':amount', $data['amount']);

	if($this->db->execute()){
			return true;
		}else{
			return false;
		}
	}	

	public function createCart(){


		$uniqid = strtoupper(uniqid()); // uniqid est une fonction créant une chaine de CHAR aléatoire et à chaque nouvelle connexion, on a un panier qui se crée. // Ici on a un retour de fonction 
		$this->db->query('INSERT INTO cart (reference, created_at) VALUES (:reference, :created_at)'); // jamais de : avant le INSERT INTO, les : sont avant les param
		$date = new DateTime();
		$this->db->bind(':created_at',$date->format('Y-m-d H:i:s')); // H : format sous 24 / i : minute / s : secondes.
		$this->db->bind(':reference',$uniqid);
		if($this->db->execute()){
			$_SESSION['cart'] = $uniqid; // uniqid qui est de base L15 devient la cart qui est dans notre BDD 
			return true;
		}else{
			return false;
		}

	}

	public function getCartByIdUser($id_user){
		$this->db->query('
			SELECT * 
			FROM cart 
			WHERE id_user = :id_user AND status = 0
			');

		$this->db->bind(':id_user', $id_user);
		$row = $this->db->single();
		return $row;

	}

	public function associateUserToCart($id_user, $reference){
		$this->db->query('UPDATE cart SET id_user = :id_user WHERE reference = :reference');
		$this->db->bind(':id_user',$id_user);
		$this->db->bind(':reference',$reference);
		$this->db->execute();
		return true;
	}


	public function getCurrentCart($reference){

		$this->db->query('
			SELECT *
			FROM cart
			WHERE reference = :reference
					'); // : EST TOUJOURS POUR DES REQUETES PREPAREES

		$this->db->bind(':reference', $reference);
		$row = $this->db->resultSet()[0]; // resultSet renvoie le resultat de la requete après l'avoir executé et renvoie un tableau. Toujours mettre des parenthèses à une fonction PHP
		return $row;
	}

	public function getAllLineInCart($reference){
		$cart = $this->getCurrentCart($reference);
		$this->db->query('SELECT * FROM cartline WHERE id_cart = :id_cart');
		$this->db->bind(':id_cart',$cart->id); // LIAISON SQL DANS LA QUERY

		return $this->db->resultSet();
	}

	public function getCountProductInCart($reference){

		$cart = $this->getCurrentCart($reference);
		$this->db->query('SELECT SUM(qty) as total_product FROM cartline WHERE id_cart=:id_cart');
		$this->db->bind(':id_cart',$cart->id);
		$result = $this->db->resultSet();
		if(is_null($result[0]->total_product)){
			return 0;
		}else{
		return $result[0]->total_product;
		}
	}

	public function alreadyInCart($id,$reference){
		$cart = $this->getCurrentCart($reference); // Ce qu'il manquait
		$this->db->query('SELECT * FROM cartline WHERE id_product=:id_product AND id_cart=:id_cart'); // requete préparée de l'ID cart 
		$this->db->bind(':id_product',$id);
		$this->db->bind(':id_cart',$cart->id); // Checker l'ID du produit et du panier 
		$row = $this->db->single();

		if($row){
			return $row;
		}else{
			return false;
		}
	}

	public function validate($id){
		$this->db->query('UPDATE cart SET status = 1 WHERE id = :id');
		$this->db->bind(':id',$id);
		$this->db->execute();
		return true;
	}


}