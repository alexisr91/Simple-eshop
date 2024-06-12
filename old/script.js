$('#delete_product').on('show.bs.modal', function (event){
	var button = $(event.relatedTarget) 
	var link = button.data('link')
	var modal= $(this)
	modal.find('.btn-danger').attr('href',link)
})

// Code pour recuperer l'URL de suppression qui est une variable au bouton 





// Fonction pour augmenter et diminuer la quantité du stock dans la partie view 
$('#button-minus').on('click',function(){
	var qty = parseInt($('#qty').val());
	if(qty > 1){
		$('#qty').val(qty - 1);
	}
})


$('#button-plus').on('click',function(){
	var qty = parseInt($('#qty').val());
	var max = $('#qty').data('max');
	if( qty < max){
		$('#qty').val(qty + 1);
	}
})



function widget_cart(){
	var url = $('.cart-link').data('url');
	$.ajax({
		url: url,
		success: function(data,statut){
			$('.cart-link').html(data);
		},
		error: function(resultat,statut,erreur){
			console.log(erreur)
		}
	})
}


$(document).ready(function(){
	widget_cart()
})



$('.add_to_cart').on('click',function(){

	var qty = parseInt($('#qty').val());
	var price = $(this).data('price');
	var url = $(this).data('url');

	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {'qty':qty, 'price':price},
		success: function (data,statut){
			widget_cart()
			var html = '<div class="alert alert-success">Produit ajouté au panier avec succès</div>'
			$('.notifications').html(html);
			setTimeout(function(){
				$('.alert-success').fadeIn(600)
			},4000)
		},
		error: function (resultat, statut, erreur){
			console.log(erreur)
		}
	})
})