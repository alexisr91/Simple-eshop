<?php require APPROOT.'/views/inc/header.php' ?>

<div class="row mt-30">
	<div class="col-md-8">
		<h1><?= $data['title']?></h1>
		<?php $product = $data['product']; ?>
		<form action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?= $product->id ?>">

			<div class="form-group">
				<label for="name">Nom du produit</label>
				<input type="text" name="name" id="name" class="form-control" value="<?= $product->name?>">
			</div>

			<div class="form-group">
				<label for="price_ht">Prix HT</label>
				<input type="text" name="price_ht" id="price_ht" class="form-control" value="<?= $product->price_ht?>">
			</div>


			<div class="form-group">
				<label for="stock">Quantité</label>
				<input type="text" name="stock" id="stock" class="form-control" value="<?= $product->stock?>">
			</div>


			<div class="form-group">
				<label for="img">Image du produit</label>
				<input type="file" name="name" id="img" class="form-control">
			</div>
			<div class="form-group">
				<label for="description">Description du produit</label>
				<textarea name="description" id="description" rows="5" class="form-control"><?= $product->description ?></textarea>
			</div>
			<button class="btn btn-warning" type="submit">Modifier produit</button>
		</form> 
	</div>
	<div class="col-md-4">
		<?php include APPROOT.'/views/inc/sidebar_admin.php'; ?>
	</div>
</div>	


<?php require APPROOT.'/views/inc/footer.php' ?>