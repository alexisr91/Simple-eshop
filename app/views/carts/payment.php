<?php require APPROOT.'/views/inc/header.php' ?>



<h1>
	<?php if($data['status'] == 'succeeded'): ?>
	<div class="alert alert-success">
		Felicirtations votre paiement a été accepté 
	</div>	
	<?php endif; ?>


</h1>	


<?php require APPROOT.'/views/inc/footer.php' ?>