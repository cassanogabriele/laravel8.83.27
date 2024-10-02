@include('include.header')

<section class="ftco-section ftco-partner">
    <div class="container">
        <h1 class="mb-5 text-center">Liste de souhaits</h1>
    </div>
 
    <div class="container">
        <div id="wishlist-message-delete-container"></div>
    </div>

    <div class="container">
        <div id="message"></div>
    </div>   
    
    <div class="container">
        <div class="text-right mb-3">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#wishlist">                
                Créer une liste  &nbsp; <i class="icon ion-md-add"></i>
            </a>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 justify-content-center ml-auto">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top img-thumbnail" width=100 src="/storage/wishlist.jpg" alt="wishlist">
                    <div class="card-body">
                        <h5 class="card-title text-center">Vos listes de souhaits</h5>
                        
                        @if(count($wishlists) > 0)
                            <ul id="list-wishlist">
                                <form method="POST">
                                    @csrf
        
                                    @foreach ($wishlists as $wishlist)
                                    <li class="d-flex justify-content-between align-items-center mb-2" data-wishlist-id="{{ $wishlist->id }}" data-wishlist-name="{{ $wishlist->name }}">
                                        <a href="#">{{ $wishlist->name }}</a>
                                        
                                        <button type="button" class="btn btn-danger btn-sm btn-icon delete-wishlist">
                                            <i class="ion-ios-trash"></i>
                                        </button>
                                    </li>
                                    @endforeach
                                </form>
                            </ul>
                        @else
                            <div class="empty-list d-flex justify-content-center">
                                <div class="container">
                                    <div class="alert alert-danger text-center" role="alert">
                                        Vous n'avez pas de liste de souhaits.
                                    </div>
                                </div>
                            </div>                                                 
                        @endif                        
                    </div>
                </div>           
            </div>
    
            <div class="col-lg-8 col-md-8 col-sm-8 border infos">  
                <div class="wishlist-info text-center">
                    <div class="wishlist-msg text-center">
                        @if(count($wishlists) > 0)
                            <div class="container">
                                <div class="d-flex align-items-center justify-content-center" style="height: 40vh;">
                                    <div class="alert alert-warning text-center" role="alert">
                                        Veuillez choisir une liste de souhait en cliquant sur son nom.
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="container">
                                <div class="d-flex align-items-center justify-content-center" style="height: 40vh;">
                                    <div class="alert alert-danger text-center" role="alert">
                                        Veuillez créer une liste de souhait. 
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>    
                </div>    
            </div>              
        </div>  
    </div>
</section>

<!-- Modale de création d'une liste de souhaits  -->
<div class="modal fade mt-5" id="wishlist" tabindex="-1" role="dialog" aria-labelledby="wishlist" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create-list">Créer une liste de souhaits</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('record_wishlist') }}" id="wishlist-form" class="login100-form validate-form" method="POST">
                <div class="modal-body">                    
                    @csrf

                    <div class="form-group">
                        <label for="wishlist-name" class="col-form-label">Nom de la liste :</label>
                        <input type="text" class="form-control border" id="name" name="name">
                    </div>                        
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-close" data-dismiss="modal"><span>Fermer</span></button>
                    <button type="submit" class="btn btn-create"><span>Créer</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('include.footer')

<script src="{{ asset('js/wishlistManagement.js') }}"></script>
