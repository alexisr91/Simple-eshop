<?php 

// redirection de pages 


// redirection simple 


function redirect($page){
	header('Location:'.URLROOT.$page); 
	// Pour faire une redirection il faut ABSOLUMENT mettre location:
}