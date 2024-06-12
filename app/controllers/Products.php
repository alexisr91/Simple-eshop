<?php 


class Products extends Controller{
	
	public function __construct(){
		$this->productModel = $this->model('Product'); // Récuperer les elements qui sont liés dans le modèle product 
	}



	public function index(){

		// Fonction qui va lister les produits
		$products = $this->productModel->getProducts();
		$data = [
			'title' => 'Boutique',
			'products' => $products
		];

		$this->view('products/index',$data);
	}

	public function show($id){
		$product = $this->productModel->getProduct($id);
		$data = [
			'product' => $product
		];

		$this->view('products/show',$data);
	}
}