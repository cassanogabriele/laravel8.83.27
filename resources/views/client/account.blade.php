@include('include.header')

<section class="ftco-section ftco-partner">
    <div class="container">
        <h1 class="mb-5 text-center">Compte client</h1>
    </div>   
 
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 justify-content-center ml-auto">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top img-thumbnail" width=100 src="/storage/account_user.jpg" alt="wishlist">
                    <div class="card-body">
                        <h5 class="card-title text-center">Vos informations</h5>

                        <ul id="list-wishlist">
                            <form method="POST">
                                @csrf        
                                
                                <li class="d-flex justify-content-between align-items-center mb-2">
                                    <a href="#" id="infos-client">Vos informations</a>                                   
                                </li>

                                <li class="d-flex justify-content-between align-items-center mb-2">
                                    <a href="#" id="orders">Vos Commandes</a>                                   
                                </li>                                
                            </form>
                        </ul>                      
                    </div>
                </div>           
            </div>
    
            <div class="col-lg-8 col-md-8 col-sm-8 border infos">  
                <div class="infos-user text-center">
                    <div class="infos-msg text-center">                       
                        <div class="container" id="alert-msg">
                            <div class="d-flex align-items-center justify-content-center" style="height: 40vh;">
                                <div class="alert alert-warning text-center" role="alert">
                                    Veuillez cliquer pour afficher les informations.
                                </div>
                           </div>
                        </div>                       

                        <div class="container mt-5" id="client-infos"></div>     
                        
                        <div class="container mt-5 mb-4" id="orders-infos"></div> 
                    </div>    
                </div>    
            </div>              
        </div>  
    </div>
</section>

@include('include.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/luxon/2.0.1/luxon.min.js"></script>
<script src="{{ asset('js/infosUserManagement.js') }}"></script>
