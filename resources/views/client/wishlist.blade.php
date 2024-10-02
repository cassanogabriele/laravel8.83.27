@include('include.header')

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @foreach ($productAdded as $product)
                        <div class="row">
                            <div class="col-md-3">
                                <a href="/article_by_reference/{{ $product->id }}" class="img-prod">
                                    <img class="img-fluid img-thumbnail square-image" src="/storage/{{ $product->product_image }}" alt="{{ $product->product_name }}">
                                </a>
                            </div>
                            <div class="col-md-9">
                                <div class="ml-3">
                                    <h6 class="mb-1 text-success">
                                        <i class="ion-md-checkmark"></i>
                                        Ce produit sera ajouté à votre liste de souhait
                                    </h6>
                                    <p class="mb-0">{{ $product->product_name }}</p>
                                    <p class="mb-0">{{ $product->product_price }} €</p>
                                    <p>
                                        <a href="{{ route('list_wishlist') }}" class="btn btn-primary mt-2">
                                        Voir mes listes de souhaits 
                                        &nbsp; <i class = "icon icon ion-ios-eye"></i>
                                        </a>
                                    </p>
                                    <p class="mt-3 text-primary"><a class="" href="/shop">Continuer mes achats</a></p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>       

        <div id="wishlist-message-container"></div>

        @if(count($wishlists) == 0)
            <div class="col-md-12 text-center">
                <div class="alert alert-danger" role="alert">
                    Vous n'avez pas de liste de souhaits
                </div>      
            </div>          
        @else
            <div class="col-md-12 text-center">
                <h4>Sélectionnez une liste de souhaits</h4>

                <form action="{{ route('add_to_selected_wishlist') }}" id="wishlist-form" class="login100-form validate-form" method="POST">
                    <div class="form-group">
                        <select class="form-const form-control-sm form-select mt-3" name="wishlist-select" id="wishlist-select">
                            <option>--Choisissez une liste de souhaits --</option>
                            @foreach ($wishlists as $wishlist)
                                <option value="{{ $wishlist->id }}" data-wishlist-id="{{ $wishlist->id }}">{{ $wishlist->name }}</option>
                            @endforeach
                        </select>
                        
                        @foreach ($productAdded as $product)
                            <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                        @endforeach
                    </div>
                </form>
            </div>        
        @endif
        
        <div class="text-right mt-5">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#wishlist">                
                Créer une liste  &nbsp; <i class="icon ion-md-add"></i>
            </a>
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
                        
                        @foreach ($productAdded as $product)
                            <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                        @endforeach
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
<script src="{{ asset('js/secureCartManagement.js') }}"></script>
