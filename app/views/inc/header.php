<?php 
  
  if(isset($_SESSION['user_id'])) :
        if(!getCartByIdUser($_SESSION['user_id'])){ // Dans le cas où pas de panier utilisateur
          if(!isset($_SESSION['cart'])){ // Pas de session
          createCart(); // On crée donc une session
        }
      }else{
        unset($_SESSION['cart']);
        $_SESSION['cart'] = getCartByIdUser($_SESSION['user_id'])->reference;
      }
  else:
       if(!isset($_SESSION['cart'])){ // Pas de session
          createCart(); // On crée donc une session
        }
  endif;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Eshop</title>

	<link rel="icon" href="<?=URLROOT;?>.img/icons/favicon.ico">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= URLROOT ?>css/cover.css">
	<link rel="stylesheet" href="<?= URLROOT ?>css/styles.css">
  
</head>
<body>


<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><?= SITENAME ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?= URLROOT ?>">Accueil<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URLROOT ?>products">Boutique</a>
        </li>

       
      </ul>


      <ul class="navbar-nav ml-auto">

         <?php if(isset($_SESSION['user_id'])) :  ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= URLROOT ?>users/logout">Log out</a>
          </li> 

            <?php if(isset($_SESSION['user_role']) AND $_SESSION['user_role'] == 1) :?>
            <li class="nav-item">
              <a class="nav-link" href="<?= URLROOT ?>admin">Administration</a>
            </li>  
            <?php endif; ?>
            <?php else : ?>
            <li class="nav-item">  
              <a class="nav-link" href="<?= URLROOT ?>users/register">Inscription</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="<?= URLROOT ?>users/login">Connexion</a>
            </li>

          <?php endif;?>
          <li class="nav-item cart-link dropdown" data-url="<?= URLROOT ?>/carts/widgetCart"></li>
      </ul>
  </div>
</nav>


      <div class="notifications">
      <main role="main" class="container" style="position: relative;
top: 90px;">	