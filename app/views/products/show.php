<?php require APPROOT.'/views/inc/header.php' ?>

<?php $product = $data['product']; ?>



	<div class="row mt-30">
		<div class="col-md-4">
			<img src="<?= URLROOT ?>/img/products/<?= $product->img; ?>" alt="<?= $product->name; ?>" class="img-fluid">

		</div>
		<div class="col-md-8">
			<h1><?= $product->name; ?></h1>
			<p><?= $product->description; ?></p>
			<div class="row">
				<div class="col-md-8">
					<h2 class="price">
						<?= number_format($product->price_ttc,2) ?>
					</h2>
				</div>
				<div class="col-md-4">
					<label for="">Quantité :</label>
					<div class="input-group mb-3">
  					<button class="btn btn-outline-secondary" type="button" id="button-minus">-</button>
  					<input type="text" class="form-control" value="1" readonly data-max="<?= $product->stock; ?>" placeholder="" id="qty" aria-label="Example text with button addon" aria-describedby="button-addon1">
  					 <div class="input-group-append">
  					 	<button class="btn btn-outline-secondary" type="button" id="button-plus">+</button>
  					 </div>
				   </div>
				</div>
			</div>
			<hr>
			<button class="btn btn-primary float-right btn-lg add_to_cart" data-price="<?= number_format($product->price_ttc,2) ?>" data-url="<?= URLROOT ?>/carts/add_to_cart/<?= $product->id ?>">
				Ajouter au panier
			</button>
		</div>
	</div>

<?php require APPROOT.'/views/inc/footer.php' ?>