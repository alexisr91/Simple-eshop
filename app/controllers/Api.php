<?php 
	
	// Recuperation de données USERS via une API 

	class Api extends Controller{

		public function __construct(){

			$this->userModel = $this->model('User');
			$this->productModel = $this->model('Product');
			$this->tokens = [
				'736273de',
				'7369373de'
			];
		}


		/*
		* monsite.com/api/users/?token=736273de
		*/

		public function users(){

			if(in_array($_GET['token'],$this->tokens)){
				$users = $this->userModel->getUsers();
				header('Content-Type: application/json');
				echo json_encode($users);
			}else{
				return false;
			}
			
		}

			/*
		* monsite.com/api/products/?token=736273de
		*/

		public function products(){

			if(in_array($_GET['token'],$this->tokens)){
				$products = $this->productModel->getProducts();
				header('Content-Type: application/json');
				echo json_encode($products);
			}else{
				return false;
			}
			
		}

		public function update_product(){
			if(in_array($_POST['token'],$this->tokens)){

				$qty = $_POST['qty'];
				$id_product = $_POST['id'];
				$product = $this->productModel->getProduct($id_product);
				$qty = $product->stock - $_POST['qty'];
				$this->productModel->update_stock($id_product,$qty);
				
			}else{
				return false;
			}
		}

	}