<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Panier 

// F12 + Reseau + reponse : affichage des erreurs AJAX 
class Carts extends Controller{
	public function __construct(){
		$this->cartModel = $this->model('Cart');
		$this->productModel = $this->model('Product');
		$this->userModel = $this->model('User');
	}


	// Sur une carte existante, fonction pour ajouter des produits au panier
	public function add_to_cart($id){

		if($this->cartModel->alreadyInCart($id,$_SESSION['cart'])){
			// Produit déjà dans le panier, en update uniquement le montant et la quantité 
			$cartline = $this->cartModel->alreadyInCart($id,$_SESSION['cart']);
			$data = [
				'qty' => $cartline->qty + $_POST['qty'],
				'amount' => $cartline->amount + ($_POST['qty'] * $_POST['price']),
				'id_product' => $id
			];

			$cart = $this->cartModel->update($data);	
		}else{
			// produit pas présent dans le panier, on crée la ligne dans le panier

			$cart = $this->cartModel->getCurrentCart($_SESSION['cart']);
			$data = [
				'qty' => $_POST['qty'],
				'amount' => $_POST['qty'] * $_POST['price'],
				'id_product' => $id,
				'id_cart' => $cart->id
			];

			$cart = $this->cartModel->add($data);
		}

		return true;
	}

	// Panier en question
	public function widgetCart(){
		$html = '';
		if(isset($_SESSION['cart'])){
			if(isset($_SESSION['user_id'])):
			if($this->cartModel->getCartByIdUser($_SESSION['user_id'])){
				$cart= $this->cartModel->getCartByIdUser($_SESSION['user_id']);
			}else{
				$cart = isCartExist();
			}
		else:
			$cart = isCartExist();
		endif;

			$cart = isCartExist();
			$cartlines = currentCart();
			// recuperation du panier si il existe

			$html .=  '
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				<i class="fa fa-shopping-cart"></i><span class="badge badge-light">'.$this->cartModel->getCountProductInCart($_SESSION['cart']).'</span>
			</a>

			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			';

			$total = 0;

			foreach ($cartlines as $cartline):
				$total += $cartline->amount; // Afficher le total dans le panier
				$html .='

					  <div class="dropdown-item d-flex"> 
						<div class="col-8">
							<a href="'.URLROOT.'/products/show/'.$cartline->id_product.'">
							<img src="'.URLROOT.'/img/products/'.getProductInCart($cartline->id_product)->img.'" width="40">
							'.getProductInCart($cartline->id_product)->name.' x '.$cartline->qty.'
							</a>
							</div>
							<div class="col-4 text-right" style="margin-left: 6px; margin-top: 6px; padding: 2px;">
								'.number_format($cartline->amount,2).'€
							</div>
						</div>

				';
			endforeach;
				$html .= '<div class="dropdown-divider"></div>';
				$html .= '<div class="dropdown-item text-right">Total : '.number_format($total,2).'€</div>';
				$html .= '<div class="text-center"><a class="btn btn-primary see_cart btn-lg" href="'.URLROOT.'carts">Voir le panier</a></div>'; 

		}

		echo $html;
	}

	public function index(){
		$cart = isCartExist();
		$cartlines = currentCart();
		$data = [
			'title' => 'Récap de commande',
			'cartlines' => $cartlines,
			'cart' => $cart
		];

		$this->view('carts/index',$data);
	}


	public function payment(){
		$cart = isCartExist();
		$cartlines = currentCart();

		require_once VENDORROOT.'autoload.php';
		$key = APISTRIPE;
		\Stripe\Stripe::setApiKey($key);

		if(isset($_POST['stripeToken'])){
			$customer = \Stripe\Customer::create([
				'description' => 'Nom et Prénom',
				'source' => $_POST['stripeToken'],
				'email' => 'email@test.fr'
			]);

			$charge = \Stripe\Charge::create([ // Charge:: ou Session::
					'amount' => $_POST['total']*100,
					'currency' => 'eur',
					'customer' => $customer->id
			]);


			if($charge->status == 'succeeded'){


				//Paiement validé 
				foreach($cartlines as $cartline){
					$qty = $cartline->qty;
					$id_product = $cartline->id_product;
					$product = $this->productModel->getProduct($id_product);
					$datas = [
							'id' => $product->id,
							'stock' => $product->stock - $qty,
							'price_ht' => $product->price_ht,
							'price_ttc' => $product->price_ttc,
							'img' => $product->img,
							'description' => $product->description,
							'name' => $product->name,
					]; 
					$this->productModel->update($datas);
				}
				$cart = $this->cartModel->validate($cart->id); // cela va passer le panier du statut 0 à 1 
			;

						// PHP MAIL CONTENT 
						$mail = new PHPMailer(true);

				try {
				    //Server settings
				    $mail->SMTPDebug = false;                      				// Pas de debug de l'envoi d'email
				    /*$mail->isSMTP();*/                                            //Methode à enlever/commenter en fonction de l'hebergeur 
				    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
				    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				    $mail->Username   = 'alexis.ramboarina@gmail.com';                     //SMTP username
				    $mail->Password   = '';                               //SMTP password
				    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
				    $mail->Port  	  = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

				    //Recipients / destinataire
				    $mail->setFrom($_SESSION['user_email'], $_SESSION['user_name']);     //Add a recipient / Name of the client		
				    $mail->addAddress('alexis.ramboarina@gmail.com', 'Eshop');												
				    $mail->addReplyTo('alexis.ramboarina@gmail.com', 'Information');
				    $mail->addCC('alexis.ramboarina@gmail.com'); 

				    //Attachments / Attach de fichier logo, img etc

				    //Content
				    $mail->isHTML(true);                                  //Set email format to HTML
				    $mail->Subject = 'Confirmation de votre commande';

				    $html ='<style type="text/css">
						  body,
						  html, 
						  .body{
						    background: #f3f3f3 !important;
						  }

						  </style>
						  <!-- move the above styles into your custom stylesheet -->
						  <spacer size=\"16\"></spacer>

						  <container>
						  <spacer size=\"16\"></spacer>

						  <row>
						    <columns>

						      <h1>Thanks for your order.</h1>

						      <p>Thanks for shopping with us! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad earum ducimus, non, eveniet neque dolores voluptas architecto sed, voluptatibus aut dolorem odio. Cupiditate a recusandae, illum cum voluptatum modi nostrum.</p>

						      <spacer size=\"16\"></spacer>

						      <callout class=\"secondary\">
						        <row>
						          <columns large=\"6\">
						            <p>
						              <strong>Payment Method</strong><br/>
						              Dubloons
						            </p>
						            <p>
						              <strong>Email Address</strong><br/>
						              thecapn@pirates.org
						            </p>
						            <p>
						     <strong>Order ID</strong><br/>';

						   $html .= $_SESSION['cart'];
						   $html .= '</p>
							          </columns>
							          <columns large=\"6\">
							            <p>
							              <strong>Shipping Method</strong><br/>
							              Boat (1&ndash;2 weeks)<br/>
							              <strong>Shipping Address</strong><br/>
							              Captain Price<br/>
							              123 Maple Rd<br/>
							              Campbell, CA 95112
							            </p>
							          </columns>
							        </row>
							       </callout>

							      <h4>Order Details</h4>

							      <table>
							        <tr><th>Item</th><th>#</th><th>Price</th></tr>';
						$total = 0;	        
						foreach ($cartlines as $cartline){
								$total += $cartline->amount;
								$html .="<tr><td>".$product = $this-> productModel->getProduct($cartline->id_product)->name."</td><td>".$cartline->qty."</td><td>".number_format($cartline->amount,2)."€</td></tr>";
							}

						$html .='<tr>
						         <td colspan=\"2\"><b>Total:</b></td>
						         <td>".number_format($total,2)."€</td>
						         </tr>
						      	 </table>
						      	 <hr/>
						      	 </columns>
  								 </row>
  								 </container>
  								 ';		

				    $mail->Body = $html;

				    $mail->send();
				    echo 'Message has been sent';
					unset($_SESSION['cart']);
					}catch (Exception $e) {
				    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
					}
				}
			}

		$data = [
            'status' => $charge->status,
        ];
		
		$this->view('carts/payment',$data); // On charge le tableau dans la view
	}
}