<?php 

class Admin extends Controller{

	public function __construct(){
		if(!isLoggedIn() and !isAdmin()){

			redirect('users/login');
		}else{
			// je suis connecté et j'ai le role admin
			$this->userModel = $this->model('User');
			$this->productModel = $this->model('Product');
		}
	}

	public function index(){
		$data = [
			'title' => 'Tableau de bord',
		];
		$this->view('admin/index',$data);
	}

	public function products(){

		if(isset($_POST['name'])){
			$date = new Datetime();
			$datas = [
				'name' => $_POST['name'],
				'description' => $_POST['description'],
				'price_ht' => $_POST['price_ht'],
				'price_ttc' => $_POST['price_ht'] * 1.2, // calcul du prix du ttc fois 1.2
				'stock' => $_POST['stock'], // A enlever pour l'erreur undefined index au cas ou 
				'created_at' => $date->format('Y-m-d'),
			];

			if(isset($_FILES['img'])){
				$uploadDir = 'img/products/';
				$uploadFile = $uploadDir . basename($_FILES['img']['name']);
				if(move_uploaded_file($_FILES['img']['tmp_name'],$uploadFile)){
					$datas['img'] = $_FILES['img']['name'];
				} 

				$this->productModel ->add($datas);

				redirect('admin/products');
			}
		}

		$products = $this->productModel->getProducts();

		$data = [ 
			'title' => 'Gestion des produits',
			'products' => $products,
		];

		$this ->view('admin/products/index', $data);
	}


	public function edit_product($id){

		$product = $this->productModel->getProduct($id);
	
		$datas['product'] = $product;
		$datas['title'] = 'Edition du produit '.$product->name;


		if(!empty($_POST)){
			$datas = [
				'name' => $_POST['name'],
				'price_ht' => $_POST['price_ht'],
				'price_ttc' => 1.2 * $_POST['price_ht'],
				'stock' => $_POST['stock'],
				'description' => $_POST['description'],
				'id' => $_POST['id'],
			];

			if(isset($_FILES['img']) && $_FILES['img']['name'] != ""){
				$uploadDir = 'img/products/';
				$uploadFile = $uploadDir . basename($_FILES['img']['name']);
				if(move_uploaded_file($_FILES['img']['tmp_name'],$uploadFile)){
					$datas['img'] = $_FILES['img']['name'];
					}
				}else{
					$datas['img'] = $product->img;
				}


				$this->productModel->update($datas);
				redirect('admin/products');
			}

		$this->view('admin/products/edit_product',$datas);
	}

	public function delete_product($id){

		$this->productModel->suppr($id);
		redirect('admin/products');
		
	}


}