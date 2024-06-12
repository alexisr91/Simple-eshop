<!-- page pour afficher les ARTICLES/ LES POSTS -->


<?php require APPROOT . '/views/inc/header.php';  ?>


<div class="row">
	
	<div class="col-md-12">
		<h1>Articles</h1>

	</div>

	<div class="col-md-12">
		<a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-info pull-right">
			<i class="fas fa-pencil-alt"></i>
			Ajouter un article
		</a>	
	</div>
</div>

<section class="row">
	<?php foreach ($data['posts'] as $post) : {
	} ?>


	<article class="card card-body mt-3 text-dark">

		<h4 class="card-title"><?php echo $post -> title; ?></h4>
		<p class="card-text"><?php echo $post -> body; ?></p>
		<span> Ecrit par <?php echo $post -> username; ?></span>

		<br>
		<a href="<?php echo URLROOT;?>/posts/show/<?php echo $post -> postId ;?>" class="btn btn-dark">Lire la suite...</a>
	</article>

<?php endforeach; ?>
</section>

<?php require APPROOT . '/views/inc/footer.php';  ?>