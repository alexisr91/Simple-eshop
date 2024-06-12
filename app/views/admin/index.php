<?php require APPROOT.'/views/inc/header.php' ?>

	<div class="row mt-30">
		<div class="col-md-8">
			<h1><?= $data['title']; ?></h1>
		</div>

		<div class="col-md-4">
			<?php include APPROOT.'/views/inc/sidebar_admin.php';?>
		</div>	
	</div>	
<?php require APPROOT.'/views/inc/footer.php' ?>