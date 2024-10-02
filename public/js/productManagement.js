$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });        
    
    // Enregistrer l'article vu dans la table
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        // Enregistrer l'article vu dans la table avec redirection
        $(document).on('click', '.products', function(e) {
            e.preventDefault();
    
            // Récupérer l'id de l'article pour récupérer ses informations
            let productId = $(this).data("product-id");
            let productLink = $(this).data('href');
    
            $.ajax({
                url: '/record_viewed_product', 
                method: 'POST',
                data: {
                    productId: productId
                },
                success: function(response) {
                    window.location.href = productLink;
                },
                error: function(xhr, status, error) {
                    alert('Une erreur est survenue.');
                }
            });
        });
    });

    // Afficher le produit récemment vu 
    $.ajax({
        url: '/recently_viewed_product',
        method: 'GET',
        success: function(response) {            
            let html = '';    
            
            if (response && response.length > 0) {
                response.forEach(function(product) {                  
                    html += '<div class="card boxes mb-3" style="max-width: 540px;">';
                    html += '<div class="row no-gutters">';
                    html += '<div class="col-md-4 mt-5"><img class="card-img-top img-thumbnail product-img" src="storage/' + product.product_image + '" alt="' + product.product_name + '"></div>';
                    html += '<div class="col-md-8">';
                    html += '<div class="card-body">';
                    html += '<h5 class="card-title"><b>Article récemment vu</b></h5>';
                    html += '<h6 class="card-title">' + product.product_name + '</h6>';
                    html += '<a href="/all_recently_viewed_products" class="btn btn-primary">Voir les produits</a>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                });
    
            } else{
                html += '<div class="card boxes mb-3" style="max-width: 540px;">';
                html += '<div class="row no-gutters">';
                html += '<div class="col-md-12">';
                html += '<div class="alert alert-danger" role="alert">Il n\'y a aucun article récemment vu</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            } 
           
            // Ajouter le contenu HTML construit à l'élément avec l'id "recently-viewed-product"
            $('#recently-viewed-product').append(html);
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
    }); 
    
    // Afficher la dernière commande
    $.ajax({
        url: '/last_order',
        method: 'GET',
        success: function(response) {  
            let html = '';    

            // Convertir le champ "panier" en un tableau d'objets JSON
            const panierArray = JSON.parse(response.panier);

            // Récupérer les informations du premier article
            if (panierArray.length > 0) {
                const firstArticle = panierArray[0];

                html += '<div class="card boxes mb-3" style="max-width: 540px;">';
                html += '<div class="row no-gutters">';
                html += '<div class="col-md-4 mt-5"><img class="card-img-top img-thumbnail product-img" src="storage/' + firstArticle.product_image + '" alt="' + firstArticle.product_name + '"></div>';
                html += '<div class="col-md-8">';
                html += '<div class="card-body">';
                html += '<h5 class="card-title"><b>Dernière commande</b></h5>';
                html += '<p>Numéro :' + response.id + '</p>';
                html += '<h3 class="card-title"></h3>';
                html += '<a href="/all_orders" class="btn btn-primary">Voir les commandes</a>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            } else {
                html += '<div class="card boxes mb-3" style="max-width: 540px;">';
                html += '<div class="row no-gutters">';
                html += '<div class="col-md-12">';
                html += '<div class="alert alert-danger" role="alert">Il n\'y a aucune commande récente</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            }            

            // Ajouter le contenu HTML construit à l'élément avec l'id "last-order"
            $('#last-order').append(html);
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
});
