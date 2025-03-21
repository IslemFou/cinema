<?php
require_once "inc/functions.inc.php";

$id = $_GET['id'];
$film = getFilmById($id);
$category = getCategoryById($id);


require_once "inc/header.inc.php";

?>
<div class="film bg-dark">

<div class="back">
    <a href="<?= RACINE_SITE; ?>index.php"><i class="bi bi-arrow-left-circle-fill"></i></a>
</div>
<div class="cardDetails row mt-5">
    <h2 class="text-center mb-5"></h2>
    <div class="col-12 col-xl-5 row p-5">
        <img src="<?= RACINE_SITE . $film['image']; ?>" alt="Affiche du film">
        <div class="col-12 mt-5">
            <form action="boutique/panier.php" method="post" enctype="multipart/form-data" class="w-75 m-auto row justify-content-center p-5">
                <!-- Dans le formulaire d'ajout au panier, ajoutez des champs cachés pour chaque information que vous souhaitez conserver du film -->
                <input type="hidden" name="id_film" value="">
                <select name="quantity" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                                    <option value=""></option>

                    

                </select>
                <button class="m-auto btn btn-danger btn-lg fs-5" type="submit">Ajouter au panier</button>
                <!-- au moment du click j'initalise une session de panier qui sera récupérer dans le fichier panier.php -->
            </form>
        </div>
    </div>
    <div class="detailsContent  col-md-7 p-5">
        <div class="container mt-5">
            <div class="row">
                <h3 class="col-4"><span>Realisateur :</span></h3>
                <ul class="col-8">
                    <li></li>
                </ul>
                <hr>
            </div>
            <div class="row">
                <h3 class="col-4"><span>Acteur :</span></h3>
                <ul class="col-8">
                                                    <li></li>

                   
                </ul>
                <hr>
            </div>

            <!-- // si j'ai un age limite renseigné je l'affiche si non pas de div avec Àge limite : -->

            <!-- <div class="row">
                                <h3 class="col-4"><span>Àge limite :</span></h3>
                                <ul class="col-8">
                                     <li>+  ans</li>    
                                </ul> 
                                <hr>
                           </div> -->


        </div>
    </div>
    <div class="row">
        <h3 class="col-4"><span>Genre : </span></h3>
        <ul class="col-8">
            
            <li></li>
        </ul>
        <hr>
    </div>
    <div class="row">
        <h3 class="col-4"><span>Durée : </span></h3>
        <ul class="col-8">
            <li></li>
        </ul>
        <hr>
    </div>
    <div class="row">
        <h3 class="col-4"><span>Date de sortie:</span></h3>
        <ul class="col-8">
                               <li></li>
        </ul>
        <hr>
    </div>
    <div class="row">
        <h3 class="col-4"><span>Prix : </span></h3>
        <ul class="col-8">
            <li>€</li>
        </ul>
        <hr>
    </div>
    <div class="row">
        <h3 class="col-4"><span>Stock :</span> </h3>
        <ul class="col-8">
            <li></li>
        </ul>
        <hr>
    </div>
    <div class="row">

        <h5 class="col-4"><span>Synopsis :</span></h5>
        <ul class="col-8">
            <li></li>
        </ul>
    </div>
</div>
</div>











<?php
require_once "inc/footer.inc.php";
?>