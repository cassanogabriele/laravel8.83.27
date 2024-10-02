$(document).ready(function() {   
    // Modification de la quantité du panier 
    $(document).on('input', '#quantity', function() {
        const id = $(this).data('id');
        const productId = $(this).closest('tr').find('input[name="product_id"]').val(); 
        const quantity = $(this).val();        
      
        let idRequest = id ? id : productId;
    
        $.ajax({
            url: '/modify_qty/' + idRequest,
            type: 'POST',
            data: { quantity: quantity },
            success: function(response) {           
                // Mise à jour des infos du panier local
                Object.values(response.cart).forEach(function(item) {     
                    $('.shipping_cost[data-id="' + item.product_id + '"]').text(item.shipping_cost.toFixed(2) + ' €');
                    $('.total[data-id="' + item.product_id + '"]').text(item.total_with_shipping.toFixed(2) + ' €');    
                });

                $('#total-without-shipping').text(response.totalCartWithoutShipping.toFixed(2) + ' €');
                $('#total-shipping').text(response.totalShipping.toFixed(2) + ' €');
                $('#total-with-shipping').text(response.totalCartWithShipping.toFixed(2) + ' €');
            },
            error: function(error) {
                console.log(error);
            }
        });
    });    

    // Supprimer un produit du panier
    function attachEventListeners() {
        $('.remove-product').off('click').on('click', function(e) {
            e.preventDefault();
    
            const id = $(this).data('id');
            const productId = $(this).closest('tr').find('input[name="product_id"]').val();

            let idRequest = id ? id : productId;

            if (id == '') {
                // Panier local
    
                // Recherche de la ligne du tableau contenant le productId
                let row = $('.cart-list').find('input[name="product_id"][value="' + productId + '"]').closest('tr');
                
                // Supprimer la ligne du tableau
                if (row.length > 0) {
                    row.remove();
    
                    // Mettre à jour le tableau cart sans l'élément supprimé
                    delete cart[productId];
    
                    // Mettre à jour le nombre d'articles dans le panier
                    var cartItemsCount = Object.keys(cart).length;
                }
            }

            $.ajax({
                url: '/remove_product/' + idRequest,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Si le panier est vide
                        if (response.nbItemsCart == 0) {
                            $('.cart').hide();
                            $('.ftco-cart').prepend('<div class="alert alert-danger text-center" id="error" role="alert">Votre panier est vide !</div>');
                        }

                        if (id != '') { 
                            // Mettre à jour le panier
                            $('.product-list').html(response.html);                           
                        }                        
                        
                        $('.cart-items-count').text(response.nbItemsCart);     

                        $('#total-without-shipping').text(response.totalCartWithoutShipping.toFixed(2) + ' €');
                        $('#total-shipping').text(response.totalShipping.toFixed(2) + ' €');
                        $('#total-with-shipping').text(response.totalCartWithShipping.toFixed(2) + ' €');
                    
                        attachEventListeners();
                    }                   
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });        
        });
    }    
    
    attachEventListeners();    

    // Création d'une liste de souhait 
    $('#wishlist-form').on('submit', function(event) {
        event.preventDefault(); 

        // Récupérer les données du formulaire
        let formData = $(this).serialize();

        // Envoyer les données au serveur via AJAX
        $.ajax({
            url: $(this).attr('action'), 
            method: $(this).attr('method'), 
            data: formData,
            dataType: 'json', 
            success: function(response) {
                if (response.success) {
                    // Fermer la modal
                    $('#wishlist').modal('hide');
                    
                    // Rediriger vers la page spécifiée
                    window.location.href = response.redirect;
                }
            },
            error: function(xhr, status, error) {
            }
        });
    });    
});
