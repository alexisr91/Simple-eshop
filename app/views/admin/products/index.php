<?php require APPROOT.'/views/inc/header.php' ?>

	<div class="row mt-30">
		<div class="col-md-8">
			<h1><?= $data['title']; ?></h1><button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#add_product">
 Ajouter produit
</button>

			<table class="table table-striped">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Prix HT</th>
						<th> Prix TTC</th>
						<th>Quantité</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $products = $data['products']; ?>
					<?php foreach ($products as $product): ?>
						<tr>
							<td><img width="60" src="<?= URLROOT ?>/img/products/<?= $product->img; ?>"> <?= $product->name; ?>
							</td>
							<td><?= $product->price_ht; ?> €</td>
							<td><?= $product->price_ttc; ?> €</td>
								<td><?= $product->stock; ?></td>
							<td>
								<a href="<?php echo URLROOT;?>admin/edit_product/<?= $product->id ?>" class="btn btn-warning">Editer</a>

								   <button data-bs-toggle="modal" data-link="<?php echo URLROOT ?>admin/deleteProduct/<?php echo $product->id ?>" type="button"  data-bs-target="#delete_product" class="btn btn-danger delete-product">Supprimer</button> <!-- Nouvelle version avec data-bs-toggle sur Bootstrap 5 et faire attention au script pour le modal --> 
            </td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="col-md-4">
			<?php include APPROOT.'/views/inc/sidebar_admin.php';?>
		</div>	
	</div>


<div class="modal fade" id="add_product" tabindex="-1" aria-labelledby="exampleaddProduct" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau produit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

    	<!-- Enctype : encodage des données lors de la soumission au serveur -->
        <form action="" method="post" enctype="multipart/form-data">

        	<div class="form-group">
        		<label for="name">Nom du produit</label>
        		<input type="text" class="form-control" name="name" id="name" required>
        	</div>

        	<div class="form-group">
        		<label for="price_ht">Prix HT</label>
        		<input type="text" class="form-control" name="price_ht" id="price_ht" required>
        	</div>

        	<div class="form-group">
        		<label for="price_ht">Quantité</label>
        		<input type="text" class="form-control" name="stock" id="stock" required>
        	</div>

        	<div class="form-group">
        		<label for="img">Image du produit</label>
        		<input type="file" class="form-control" name="img" id="img" required>
        	</div>

        	<div class="form-group">
        		<label for="description">Description du produit</label>
        		<textarea name="description" class="form-control" id="description"></textarea>
        	</div>
        	
        	<button type="submit" class="btn btn-success mt-4">Ajouter produit</button>

        </form>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="delete_product" role="dialog" tabindex="-1" aria-labelledby="delete_productLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> New message</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
        <button data-bs-dismiss="modal" class="btn btn-secondary">Non</button>
        <a href="" class="btn btn-danger">Oui</a>
      </div>
    </div>
  </div>
</div>





<?php require APPROOT.'/views/inc/footer.php' ?>