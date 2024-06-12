
<!-- Montre la suite de l'article -->
<?php require APPROOT . '/views/inc/header.php';  ?>

<a href="<?php echo URLROOT;?>posts" class="btn btn-black text-white"><i class="fas fa-backward pr-2"></i> Retour</a>

<div class="bg-secondary text-white p-3 mb-3">

<h1><?php echo $data['post'] -> title; ?></h1>
<h5 class="mb-3">Auteur : <?php echo $data['user'] -> username; ?>, écrit le <?php echo $data['post']-> created_at; ?></h5>



<p><?php echo $data['post'] -> body; ?></p>
</div>


<div class="d-flex justify-content-end gap-1">
<?php 
	if($data['post'] -> user_id == $_SESSION['user_id']) : ?>
	<hr>

	<a href="<?php echo URLROOT;?>posts/edit/<?php echo $data['post'] -> Id;?>" class="btn btn-success">Editer</a>



	<form action="<?php echo URLROOT;?>posts/delete/<?php echo $data['post'] -> Id;?>" method="post" class="">
	<input type="submit" value="supprimer" class="btn btn-danger"> 
	</form>

	<?php endif; ?>	

</div>
<?php require APPROOT . '/views/inc/footer.php';  ?>