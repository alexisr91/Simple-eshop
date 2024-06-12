<?php require APPROOT.'/views/inc/header.php' ?>


<h1><?= $data['title'] ?></h1>


	<div class="row">
		<?php foreach ($data['products'] as $product): ?>
			<div class="col-md-4">
				<div class="card">
				<a href="<?= URLROOT; ?>/products/show/<?= $product->id; ?>">
  				<img src="<?= URLROOT; ?>/img/products/<?= $product->img ?>" class="card-img-top" alt="<?= $product->name; ?>">
  				</a>
 				<div class="card-body">
   				<h5 class="card-title"><?= $product->name; ?></h5>
    			<p class="price"><?= number_format($product->price_ttc,2) ?> E</p>
    			<a href="<?= URLROOT; ?>/products/show/<?= $product->id; ?>" class="btn btn-primary">Voir le produit</a>
  			</div>
		</div>
	</div>	

		<?php endforeach; ?>	
	</div>

<?php require APPROOT.'/views/inc/footer.php' ?>