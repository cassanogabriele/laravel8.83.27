$(document).ready(function() {
    // Inclure le jeton CSRF dans toutes les futures requêtes Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Afficher les informations du client
    $(document).on('click', '#infos-client', function() {
        loadUserInfo();
        
        // Fonction pour recharger les informations du client
        function loadUserInfo() {
            // Réaliser une requête AJAX pour charger les nouvelles informations du client
            $.ajax({
                url: '/infos_client',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Masquer la div qui demande de cliquer sur un lien
                        $('#alert-msg').hide();    
                        $('#client-infos').show();
                        $('#orders-infos').hide();

                        // Formatage de la date de création du compte 
                        let createdDateTime = luxon.DateTime.fromISO(response.data.created_at);
                        let formattedDate = createdDateTime.setLocale('fr-BE').toFormat('dd/LL/yyyy');
    
                        let userInfos = 
                            '<div id="infos-details">' + 
                            '<div class="d-flex justify-content-end"><i class="icon-pencil text-success" id="edit-button"></i></div>' + 
                            '<div>' + 
                            '<p><span class="font-weight-bold">Nom : </span>' + response.data.name + '</p>'+
                            '<p><span class="font-weight-bold">Email : </span>' + response.data.email + '</p>' +
                            '<p><span class="font-weight-bold">Métier : </span>' + response.data.job + '</p>' + 
                            '<p><span class="font-weight-bold">Date de création du compte : </span> Le ' + formattedDate + '<p>' + 
                            '</div></div>';
    
                        // Ajoutez les informations du client à la div avec l'ID "user-infos"
                        $('#client-infos').html(userInfos);   
                    }

                    // Afficher un formulaire pour l'édition des infos du client
                    $('#edit-button').on('click', function(event) {       
                        // Remplacer l'affichage des informations par le formulaire éditable
                        $('#infos-details').hide();                        
                        
                        let editForm =
                        '<form id="user-form">' +
                        '<div class="form-group row">' +
                        '<label for="name" class="col-sm-2 col-form-label">Nom</label>' +
                        '<div class="col-sm-10">' +
                        '<input type="text" class="form-control" id="name" name="name" value="' + response.data.name + '" required>' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group row">' +
                        '<label for="staticEmail" class="col-sm-2 col-form-label">Email</label>' +
                        '<div class="col-sm-10">' +
                        '<input type="email" class="form-control" id="email" name="email" value="' + response.data.email + '" required>' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group row">' +
                        '<label for="job" class="col-sm-2 col-form-label">Métier</label>' +
                        '<div class="col-sm-10">' +
                        '<input type="text" class="form-control" id="job" name="job" value="' + response.data.job + '">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="form-group row">' +
                        '<div class="col-sm-10 offset-sm-2">' +
                        '<button type="submit" class="btn btn-success" id="update-client-infos">Modifier</button>' +
                        '</div>' +
                        '</div>' +
                        '</form>';                    

                        $('#client-infos').append(editForm);
                    });

                    // Mise à jour des infos                    
                    $(document).on('submit', '#user-form', function(event) {
                        event.preventDefault();
                        let formData = $(this).serialize();

                        $.ajax({
                            url: '/update_infos_client',
							method: 'POST', 
							data: formData,
                            success: function(response) {
                                if (response.success) {   
                                    // Afficher les informations à jour du client
                                    loadUserInfo();
                                   
                                    // Affichage du message de succès, après le chargement des informations à jour du client
                                    setTimeout(function() {
                                        $('#client-infos').prepend('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                            'Vos informations ont été mises à jour avec succès !' +
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                            '<span aria-hidden="true">&times;</span>' +
                                            '</button>' +
                                            '</div>');
                                    }, 800);          
                                } else {
                                    console.log('Erreur lors de la mise à jour des informations client.');
                                }
                            },
                            error: function(xhr, status, error) {							
                                console.log(error);
                            }
                        });
                    });
                },
                error: function(xhr, status, error) {				
                    console.log(error);
                }
            });
        }
    });
   
    // Récupérer et afficher les informations de commande
    function fetchAndDisplayOrders() {
        $.ajax({
            url: '/orders',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    // Masquer la div qui demande de cliquer sur un lien
                    $('#alert-msg').hide();

                    // Masquer la div des infos utilisateur si elle est affichée
                    $('#user-infos').hide();

                    // Vérifier que la réponse contient bien les données des commandes
                    if (response.data && Array.isArray(response.data)) {
                        let ordersInfosDiv = $('#orders-infos');
                        ordersInfosDiv.empty();

                        response.data.forEach(function(orderInfo) {
                            displayOrderInfo(orderInfo);
                        });

                        ordersInfosDiv.css('height', 'auto');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    // Afficher les informations d'une commande spécifique
    function displayOrderInfo(orderInfo) {
        $('#client-infos').hide();
        $('#orders-infos').show();

        let status = '';
        let iconStatus = '';
        let classIcon = "";

        if (orderInfo.canceled == 0) {
            status = 'active';
            classIcon = 'text-danger';
            iconStatus = 'ion-ios-close-circle';
        } else {
            status = 'annulée';
            classIcon = 'text-success';
            iconStatus = 'ion-ios-checkmark';
        }

        // Formatage de la date de création du compte
        let createdDateTime = luxon.DateTime.fromISO(orderInfo.created_at);
        let formattedDate = createdDateTime.setLocale('fr-BE').toFormat('dd/LL/yyyy');

        let orderInfos =
            '<div class="d-flex justify-content-end"><i class="' + iconStatus + ' ' + classIcon + '" id="cancel-button" style="font-size: 35px;" data-id="' + orderInfo.id + '"></i></div>' +
            '<div>' +
            '<div>' +
            '<div>' +
            '<p><span class="font-weight-bold">Numéro : </span>' + orderInfo.id + '</p>' +
            '<p><span class="font-weight-bold">Adresse de livraison : </span>' + orderInfo.adresse + '</p>' +
            '<p><span class="font-weight-bold">Status : </span>' + status + '</p>' +
            '<p><span class="font-weight-bold">Date de la commande : </span>' + formattedDate + '</p>' +
            '<button class="btn btn-primary view-order" data-order-id="' + orderInfo.id + '">Voir la commande</button>' +
            '</div>';

        $('#orders-infos').append(orderInfos);
    }

    // Appel initial pour afficher les informations de commande
    $(document).on('click', '#orders', function() {
        fetchAndDisplayOrders();
    });

    // Événement click pour annuler une commande
    $(document).on('click', '#cancel-button', function(event) {
        // Récupérer l'id de la commande
        let orderId = $(this).data("id");

        $.ajax({
            url: '/cancel_order',
            method: 'POST',
            data: { orderId: orderId },
            success: function(response) {
                if (response.success) {
                    // Mettre à jour les informations des commandes après annulation ou réactivation
                    fetchAndDisplayOrders();                    

                    // Afficher le message de succès
                    setTimeout(function() {
                        $('#orders-infos').prepend('<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span>' +
                            '</button>' +
                            '</div>');
                    }, 800); 
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    // Afficher les détails de la commande sélectionnée
    $(document).on('click', '#display-order', function() {
        var orderId = $(this).data('order-id');       

        $.ajax({
            url: '/order_details',
            method: 'POST',  
            data: {
                orderId: orderId
            },
            success: function(response) {
                if (response.success) {
                    window.location.replace('/confirm_order');
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
});
