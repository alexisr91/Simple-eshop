
<?php require APPROOT.'/views/inc/header.php' ?>

<h1 class="text-center"><?= $data['title']?></h1>

<div class="d-flex justify-content-around">
	<div class="">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Désignation</th>
					<th>Prix unitaire</th>
					<th>Quantité</th>
					<th>Total</th>

				</tr>
			<tbody>
				<?php $total = 0; ?>
				<?php foreach($data['cartlines'] as $cartline): ?>
					<?php $total += $cartline->amount; ?>
					<tr>
						<td>
							<img src="<?= URLROOT.'/img/products/'.getProductInCart($cartline->id_product)->img ?>" width="40">
							<?= getProductInCart($cartline->id_product)->name; ?>
						</td>
						<td>
							<?= number_format(getProductInCart($cartline->id_product)->price_ttc,2);?> €
						</td>
						<td>
							<?= $cartline->qty ?>
						</td>
						<td>
							<?= number_format($cartline->amount,2);?> €
						</td>
					</tr>	
				<?php endforeach; ?>	
			</tbody>
			<tfoot>
				<tr class="text-bold">
					<td class="text-right text-bold" colspan="3">Total</td>
					<td class="text-bold"><?= number_format($total, 2) ?></td>
				</tr>
			</tfoot>		
			</thead>
		</table>

	</div>

	<div class="col-md-4">
		<form action="<?= URLROOT.'carts/payment' ?>" method="post" id="payment-form">
			<input type="hidden" value="<?= $total ?>" name="total">
			<label for="card-element">
				Paiement avec Stripe
			</label>
			<div id="card-element"></div> <!-- Correspond à l'ID de la CV -->
			<div id="card-errors" role="alert"></div>
			<button class="btn btn-success">
				Confirmer le paiement
			</button>
		</form>
	</div>	
</div>		


<script src="https://js.stripe.com/v3/"></script>
<script>
	var stripe = Stripe('pk_test_51LEtjyKGeU3X6nsn6HQsXu1IjxOOelqavwBb2ur7WtufzB2CDFw9HPOHKYFrEzXk1ChY8rNtsAxQdgwlwsOhANh200QJrzesvl')
	var elements = stripe.elements()
	var card = elements.create('card') 
	card.mount('#card-element') /* la CB est repris ici en JS pour inserer les champs */

	card.addEventListener('change', function(e){
		var displayError = document.getElementById('card-errors')
		if(e.error){
			displayError.textContent = e.error.message
		}else{
			displayError.textContent = ''
		}
	})

	var form = document.getElementById('payment-form').
			 addEventListener('submit',function(e){
			 e.preventDefault()// empeche la soumission du formulaire pour gérer la gestion des données et traiter le formulaire, on l'empeche de le soumettre pour qu'il soit soumis plus tard
		stripe.createToken(card).then(function(result){
			if(result.error){
	
				var displayError = document.getElementById('card-errors')
				displayError.textContent = result.error.message
			}else{
			
				stripeTokenHandler(result.token) /* generer un champ momentané, il va charger un token et va etre mis dans le formulaire dans un champ caché et une fois qu'il a été crée, on envoie le formulaire via form.submit() */
			}
		})
	})

	function stripeTokenHandler(token){
		var form = document.getElementById('payment-form')
		var hiddenInput = document.createElement('input')
		hiddenInput.setAttribute('type','hidden')
		hiddenInput.setAttribute('name', 'stripeToken')
		hiddenInput.setAttribute('value',token.id)
		form.appendChild(hiddenInput)
		form.submit() // Ici on submit le form
	}	
</script>



<?php require APPROOT.'/views/inc/footer.php' ?>