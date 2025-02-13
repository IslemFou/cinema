<?php
require_once "inc/functions.inc.php";
require_once "inc/header.inc.php";


$info = "";

var_dump($_POST); // une variable globale car elle est accessible partout dans le script , prédéfinie par PHP
// isset permet de vérifier si une variable est définie --> $_POST is True


// if (isset($_POST))
// {
//     echo ' <p>cette variable est définie</p>';
// } else
// {
//     echo ' <p>cette variable n\'est pas définie</p>';
// }
// // empty permet de vérifier si une variable est vide 0 false NULL--> $_POST is False
// if (empty($_POST))
// {
//     echo ' <p>cette variable est vide</p>';
// } else
// {
//     echo ' <p>cette variable n\'est pas vide</p>';
// }
// ---------------------------------Validation de formulaire--------------------------------
if (!empty($_POST))
{
    echo 'n\'est pas vide';
    // on vérifie si les champs sont vides
    //trim en php enlève les espaces ou bien / ou un caractère spécifique
    $verif = true; // permet de ressortir de la condition de la boucle
    foreach ($_POST as $key=> $value)
    {
        if (empty(trim($value)))
        {
            $verif = false;
            break;
        }
    } 

    // on sort de notre if
    if ($verif === false)
    {
        $info = alert("Veuillez remplir tous les champs","danger");
    }

}

?>
<!------------------------------- formulaire d'inscription ---------------------------->
<main style="background:url(assets/img/5818.png) no-repeat; background-size: cover; background-attachment: fixed;">

    <div class="w-75 m-auto p-5" style="background: rgba(20, 20, 20, 0.9);">
        <h2 class="text-center mb-5 p-3">Créer un compte</h2>
         <?php
        
        //voir fonction alert dans functions.inc.php
        // echo alert("test pour voir si ça marche"); // sans préciser la classe
        echo alert("test pour voir si ça marche","danger");

        ?> 
        <form action="" method="post" class="p-5">
            <div class="row mb-3">
                <div class="col-md-6 mb-5">
                    <label for="lastName" class="form-label mb-3">Nom</label>
                    <input type="text" class="form-control fs-5" id="lastName" name="lastName">
                </div>
                <div class="col-md-6 mb-5">
                    <label for="firstName" class="form-label mb-3">Prenom</label>
                    <input type="text" class="form-control fs-5" id="firstName" name="firstName">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 mb-5">
                    <label for="pseudo" class="form-label mb-3">Pseudo</label>
                    <input type="text" class="form-control fs-5" id="pseudo" name="pseudo">
                </div>
                <div class="col-md-4 mb-5">
                    <label for="email" class="form-label mb-3">Email</label>
                    <input type="text" class="form-control fs-5" id="email" name="email" placeholder="exemple.email@exemple.com">
                </div>
                <div class="col-md-4 mb-5">
                    <label for="phone" class="form-label mb-3">Téléphone</label>
                    <input type="text" class="form-control fs-5" id="phone" name="phone">
                </div>

            </div>
            <div class="row mb-3">
                <div class="col-md-6 mb-5">
                    <label for="mdp" class="form-label mb-3">Mot de passe</label>
                    <input type="password" class="form-control fs-5" id="mdp" name="mdp" placeholder="Entrer votre mot de passe">
                </div>
                <div class="col-md-6 mb-5">
                    <label for="confirmMdp" class="form-label mb-3">Confirmation mot de passe</label>
                    <input type="password" class="form-control fs-5 mb-3" id="confirmMdp" name="confirmMdp" placeholder="Confirmer votre mot de passe ">
                    <input type="checkbox" onclick="myFunction()"> <span class="text-danger">Afficher/masquer le mot de passe</span>
                </div>


            </div>
            <div class="row mb-3">
                <div class="col-md-6 mb-5">
                    <label class="form-label mb-3">Civilité</label>
                    <select class="form-select fs-5" name="civility">
                        <option value="h">Homme</option>
                        <option value="f">Femme</option>
                    </select>
                </div>
                <div class="col-md-6 mb-5">
                    <label for="birthday" class="form-label mb-3">Date de naissance</label>
                    <input type="date" class="form-control fs-5" id="birthday" name="birthday">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 mb-5">
                    <label for="address" class="form-label mb-3">Adresse</label>
                    <input type="text" class="form-control fs-5" id="address" name="address">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="zip" class="form-label mb-3">Code postale</label>
                    <input type="text" class="form-control fs-5" id="zip" name="zip">
                </div>
                <div class="col-md-5">
                    <label for="city" class="form-label mb-3">Cité</label>
                    <input type="text" class="form-control fs-5" id="city" name="city">
                </div>
                <div class="col-md-4">
                    <label for="country" class="form-label mb-3">Pays</label>
                    <input type="text" class="form-control fs-5" id="country" name="country">
                </div>
            </div>
            <div class="row mt-5">
                <button class="w-25 m-auto btn btn-danger btn-lg fs-5" type="submit">S'inscrire</button>
                <p class="mt-5 text-center">Vous avez dèjà un compte ! <a href="authentication.php" class=" text-danger">connectez-vous ici</a></p>
            </div>
        </form>
    </div>



</main>















<?php
require_once "inc/footer.inc.php";
?>