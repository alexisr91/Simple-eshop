
<?php require APPROOT . '/views/inc/header.php';  ?>

<div class="row">

	<div class="col-md-10 mx-auto">
		<div class="card card-body bg-light mt-5 col-lg">	
		<h1>Ajouter un article</h1>
		
		<form action="<?php echo URLROOT?>/posts/add" method="post">

			<div class="form-group">
				<label>Titre <sup>*</sup></label>
				<input type="text" name="title" class="form-control form-control-lg mb-2
				<?php echo(!empty($data['title_err'])) ? 'is-invalid' : ''; ?> " value="<?php echo $data['title'] ?>">
				<span class="invalid-feedback"><?php echo $data['title_err']; ?></span> <!-- class bootstrap en cas de champ invalide -->
			</div>

			<div class="form-group">
				<label>Contenu<sup>*</sup></label>
				<textarea name="body" class="form-control form-control-lg mb-2
				 <?php echo(!empty($data['body_err'])) ? 'is-invalid' : ''; ?> " value="<?php echo $data['body'] ?>"></textarea>
				<span class="invalid-feedback"><?php echo $data['body_err'] ;?></span>
			</div>

				<input type="submit" value="Soumettre" class="btn btn-success">
				<a href="<?php echo URLROOT; ?>/posts" class="btn btn-black btn-block"><i class="fas fa-backward"></i>Retour</a>

		
		</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php';  ?>