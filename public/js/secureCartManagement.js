





// Vérifier si l'utilisateur a cliqué sur le bouton d'ajout au panier
var addToCartClicked = localStorage.getItem('addToCartClicked');

if (addToCartClicked) {
    // L'utilisateur a cliqué sur le bouton, supprimer le flag de localStorage
    localStorage.removeItem('addToCartClicked');
} else {
    // Détecter si on raffraîchit la page
    $(window).on('beforeunload', function() {
        sessionStorage.setItem('pageRefreshed', true);
    });

    var pageRefreshed = sessionStorage.getItem('pageRefreshed');

    if (!pageRefreshed) {
        // L'utilisateur n'a pas cliqué sur le bouton, rediriger vers la page d'accueil
        window.location.href = "/";
    } 
}