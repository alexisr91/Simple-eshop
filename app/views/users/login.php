
<?php require APPROOT . '/views/inc/header.php';  ?>

<div class="row">

	<div class="col-md-10 mx-auto">
		<div class="card card-body bg-light mt-5 col-lg">	
		<h1>Connexion</h1>
		<h2>Connectez vous</h2>
		<form action="<?php echo URLROOT?>/users/login" method="post">

			<div class="form-group">
				<label>Votre nom <sup>*</sup></label>
				<input type="text" name="name" class="form-control form-control-lg mb-2
				<?php echo(!empty($data['name_err'])) ? 'is-invalid' : ''; ?> " value="<?php echo $data['name'] ?>">
				<span class="invalid-feedback"><?php echo $data['name_err']; ?></span> <!-- class bootstrap en cas de champ invalide -->
			</div>

			<div class="form-group">
				<label>Votre mot de passe<sup>*</sup></label>
				<input type="password" name="password" class="form-control form-control-lg mb-2
				 <?php echo(!empty($data['password_err'])) ? 'is-invalid' : ''; ?> " value="<?php echo $data['password'] ?>">
				<span class="invalid-feedback"><?php echo $data['password_err'] ;?></span>
			</div>

			<div class="row">
				<div class="col">
				<input type="submit" value="Se connecter" class="btn btn-success btn-block form-control-lg"></a>
			</div>

			<div class="col">
				<a href="<?php echo URLROOT; ?>/users/register" class="btn btn-secondary btn-block fs-5 form-control-lg">Pas encore inscrit ? Inscrivez vous</a>
			</div>
			</div>
		</form>

		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php';  ?>