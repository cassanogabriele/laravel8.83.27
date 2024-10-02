$(document).ready(function() {
    // Inclure le jeton CSRF dans toutes les futures requêtes Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   // Ajout d'un produit à une liste de souhait sélectionné
   $('#wishlist-select').on('change', function() {
        let wishlistId = $('#wishlist-select option:selected').data('wishlist-id');
        let productId = $('#product_id').val();
            
        $.ajax({
            url: '/add_to_selected_wishlist',
            type: $(this).attr('method'),
            data: {
                wishlist_id: wishlistId,
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    // Le produit a été ajouté avec succès
                    var alertClass = 'alert-success';
                } else {
                    // Une erreur s'est produite lors de l'ajout du produit
                    var alertClass = 'alert-danger';
                }
                
                let message = `<div class="alert ${alertClass} mt-5 mb-5 text-center" style="position: relative;">${response.message}<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 50%; transform: translateY(-50%); right: 10px;">&times;</button></div>`;
                $('#wishlist-message-container').html(message);                                                   
            },
            error: function(xhr, status, error) {
                // Gestion des erreurs
                console.log(xhr.responseText);
            }
        });
    });    

    // Récupérer les produits
    $(document).on('click', 'li[data-wishlist-id]', function(event) {
        event.preventDefault();

        var wishlistId = $(this).data('wishlist-id');

        $.ajax({
            url: '/wishlist_infos',
            method: 'POST',
            data: {
                wishlistId: wishlistId
            },
            success: function(response) {
                if (response.length > 0) {
                    $('.wishlist-info').empty();

                    response.forEach(function(wishlistInfo) {
                        let wishlistItem = $('<div class="mt-3">').addClass('wishlist-item').addClass('border');

                        // Stocker l'id de produit à envoyer lors de la suppression du produit de la liste de souhaits
                        let productIdInput = $('<input>').attr('type', 'hidden').addClass('product-id-input').val(wishlistInfo.productId);

                        // Stocker l'id de la liste de souhaits
                        let wishlistIdInput = $('<input>').attr('type', 'hidden').addClass('wishlist-id-input').val(wishlistId);

                        // Stocker le nom du produit pour le message de succès quand on supprime un produit de la liste de souhaits
                        let productNameInput = $('<input>').attr('type', 'hidden').addClass('product-name-input').val(wishlistInfo.productName);

                        // Bouton de suppression
                        let deleteButton = $('<button>').attr('type', 'button')
                            .addClass('btn btn-danger btn-sm btn-icon delete-product')
                            .html('<span class="ion-ios-close"></span>')
                            .css('border-radius', '0')
                            .css('position', 'absolute')
                            .css('margin-top', '10px')
                            .css('right', '25px');

                        // Ajouter le champ input et le bouton de suppression à wishlistItem
                        wishlistItem.append(productIdInput).append(wishlistIdInput).append(productNameInput).append(deleteButton);

                        $('<h3>').text(wishlistInfo.productName).appendTo(wishlistItem);

                        let wishlistImage = $('<img>').attr('src', 'storage/' + wishlistInfo.productImage)
                            .attr('alt', wishlistInfo.productName)
                            .addClass('img-fluid img-thumbnail small-square-image');
                        wishlistItem.append(wishlistImage);
                        $('<p>').html('<span class="font-weight-bold">Prix :</span> ' + wishlistInfo.productPrice).appendTo(wishlistItem);
                        $('<p>').html('<span class="font-weight-bold">Catégorie :</span> ' + wishlistInfo.categoryName).appendTo(wishlistItem);
                        $('<p>').html('<span class="font-weight-bold">Description :</span> ' + wishlistInfo.productDescription).appendTo(wishlistItem);
                        $('<p>').html('<span class="font-weight-bold">Date de création :</span> ' + wishlistInfo.creationDate).appendTo(wishlistItem);
                        $('.wishlist-info').append(wishlistItem);
                    });

                } else {
                    $('.wishlist-info').empty();

                    let message = '<div class="container">' +
                        '<div class="d-flex align-items-center justify-content-center" style="height: 40vh;">' +
                        '<div class="alert alert-danger text-center" role="alert">' +
                        'Vous n\'avez d\'article dans votre liste de souhaits.' +
                        '</div>' +
                        '</div>';

                    $('.wishlist-info').append(message);
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

   // Supprimer un produit de la liste de souhaits
    $(document).on('click', '.delete-product', function() {
        let productId = parseInt($(this).siblings('.product-id-input').val());
        let wishlistId = parseInt($(this).siblings('.wishlist-id-input').val());
        let productName = $(this).siblings('.product-name-input').val();

        $.ajax({
            url: '/delete_product',
            method: 'POST',
            data: {
                productId: productId,
                wishlistId: wishlistId,
                productName: productName,
            },
            success: function(response) {
                if (response.success) {
                    $('.wishlist-info').empty();
                    
                    // Afficher le message de succès dans votre balise HTML souhaitée
                    $('#message').addClass('alert alert-success alert-dismissible text-center').html(
                        response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                    );

                    // Récuper les informations à jour des listes de souhaits
                    $.ajax({
                        url: '/wishlist_infos',
                        method: 'POST',
                        data: {
                            wishlistId: wishlistId
                        },
                        success: function(response) {
                            if (response.length == 0) {
                                $('.wishlist-info').empty();
            
                                let message = '<div class="container">' +
                                    '<div class="d-flex align-items-center justify-content-center" style="height: 40vh;">' +
                                    '<div class="alert alert-danger text-center" role="alert">' +
                                    'Vous n\'avez d\'article dans votre liste de souhaits.' +
                                    '</div>' +
                                    '</div>';
            
                                $('.wishlist-info').append(message);               
                            } 
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                } else {
                    $('.wishlist-info').empty();
                    // Afficher le message d'erreur dans votre balise HTML souhaitée
                    $('#message').addClass('alert alert-danger alert-dismissible text-center').html(
                        response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                    );
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    // Mettre à jour la liste de souhaits
    function updateWishlistList() {
        $.ajax({
            url: '/refresh_wishlist',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var wishlistSelect = $('#wishlist-select');
                var selectedWishlistId = wishlistSelect.val();
    
                wishlistSelect.empty();
    
                if (response.length > 0) {
                    var wishlistContainer = $('#list-wishlist');
                    var selectedWishlistId = wishlistContainer.find('.active').data('wishlist-id');
    
                    wishlistContainer.empty();
    
                    response.forEach(function(wishlist) {
                        var listItem = $('<li>')
                            .addClass('d-flex justify-content-between align-items-center mb-2')
                            .attr('data-wishlist-id', wishlist.id)
                            .attr('data-wishlist-name', wishlist.name);
    
                        $('<a>')
                            .attr('href', '#')
                            .text(wishlist.name)
                            .appendTo(listItem);
    
                        $('<button>')
                            .addClass('btn btn-danger btn-sm btn-icon delete-wishlist')
                            .html('<i class="ion-ios-trash"></i>')
                            .appendTo(listItem);
    
                        listItem.appendTo(wishlistContainer);
                    });
                    
                    // Continuer à afficher le message si il y a au moins une liste de souhaits
                    let msg = '<div class="container">' + 
                    '<div class="d-flex align-items-center justify-content-center" style="height: 40vh;">' +
                    '<div class="alert alert-warning text-center" role="alert">' + 
                    'Veuillez choisir une liste de souhait en cliquant sur son nom.' + 
                    '</div></div></div>';

                    $('.infos').html(msg);   
                } else {
                    // Afficher le message si la liste de souhaits est vide
                    let emptyList = '<div class="empty-list">' +
                        '<div class="container">' +
                        '<div class="alert alert-danger text-center" role="alert">' +
                        'Vous n\'avez pas de liste de souhaits' +
                        '</div>' +
                        '</div>' +
                        '</div>';
    
                    $('#list-wishlist').html(emptyList);

                    // Continuer d'afficher le message d'erreur si il n'y a plus de liste de souhaits 
                    let emptyInfos = '<div class="container">' +
                    '<div class="d-flex align-items-center justify-content-center" style="height: 40vh;">' +
                    '<div class="alert alert-danger text-center" role="alert">' +
                    'Veuillez créer une liste de souhait. ' +
                    '</div>' +
                    '</div>' +
                    '</div>';
    
                    $('.infos').html(emptyInfos);
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    
        // Mettre à jour les infos de liste de souhaits
        $('.wishlist-item').remove();
    }
    
    // Supprimer une liste de souhaits
    $(document).on('click', '.delete-wishlist', function() {
        var wishlistId = $(this).closest('li').data('wishlist-id');
        var wishlistName = $(this).closest('li').data('wishlist-name');

        $.ajax({
            url: '/delete_wishlist',
            type: 'POST',
            data: {
                wishlist_id: wishlistId,
                wishlist_name: wishlistName,
            },
            success: function(response) {
                if (response.success) {                 
                    updateWishlistList();  
                   
                    // Mettre à jour le nombre d'articles dans la liste de souhaits affichée dans le header
                    $('#wishlist-count').text(`[${response.nbItemsWishlist}]`);


                    // Afficher le message de succès dans votre balise HTML souhaitée
                    $('#wishlist-message-delete-container').addClass('alert alert-success alert-dismissible text-center').html(
                        response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                    ); 
                } else {
                    $('#wishlist-message-delete-container').addClass('alert alert-danger alert-dismissible text-center').html(
                        response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                    ); 
                }
            },
            error: function(xhr) {
                var errorMessage = `<div class="alert alert-danger mt-5 mb-5 text-center" role="alert">Erreur lors de la suppression de la liste de souhaits.</div>`;
                $('#wishlist-message-delete-container').html(errorMessage);
            }
        });
    });
});
