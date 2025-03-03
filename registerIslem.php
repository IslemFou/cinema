<?php
require_once "inc/functions.inc.php";


$info = "";

// var_dump($_POST); // une variable globale car elle est accessible partout dans le script , prédéfinie par PHP
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
    // echo 'n\'est pas vide';
    // on vérifie si les champs sont vides
    //trim en php enlève les espaces ou bien / ou un caractère spécifique
    $verif = true; // permet de ressortir de la condition de la boucle
    foreach ($_POST as $key=> $value)
    {
        if (empty(trim($value)))
        {
            $verif = false;
        }
    } 

    // on sort de notre if
    if ($verif === false)
    {
        $info = alert("Veuillez remplir tous les champs","danger");
    } else 
    {
        if (!isset($_POST['lastName']) || strlen(trim($_POST['lastName'])) < 3 || strlen(trim($_POST['lastName'])) > 50)
        {
            $info = alert("Ce champ n'est pas valide","danger");
        }

        //
        if (!isset($_POST['firstName']) || strlen(trim($_POST['firstName'])) > 50)
        {
            $info .= alert("Ce champ n'est pas valide","danger");
        }
        //
        if (!isset($_POST['pseudo']) || strlen(trim($_POST['pseudo'])) < 3 || strlen(trim($_POST['pseudo'])) > 50)
        {
            $info .= alert("Ce champ n'est pas valide","danger");
        }
        //
        if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 5 || strlen(trim($_POST['email'])) > 100 || !filter_var(trim($_POST['email']),FILTER_VALIDATE_EMAIL))
        {
            $info .= alert("Le email n'est pas valide","danger");
        }
        // La fonction filter_var() applique un filtre spécifique à une variable. Lorsqu'elle est utilisée avec la constante FILTER_VALIDATE_EMAIL, elle vérifie si la chaîne passée en paramètre est une adresse e-mail valide. Si l'adresse est valide, la fonction retourne la chaîne elle-même ; sinon, elle retourne false.
        // La constante FILTER_VALIDATE_EMAIL est utilisée dans la fonction filter_var() en PHP pour valider une adresse e-mail. C'est une option de filtrage qui permet de vérifier si une chaîne de caractères est une adresse e-mail valide selon le format standard des e-mails.
         
        //phone
         //on déclare une variable phone regex
            
         $phoneRegex = "/^[0-9]{10}$/";

         if (!isset($_POST['phone']) || !preg_match($phoneRegex,trim($_POST['phone']))) // vérifie si le téléphone est valide
         {
             $info .= alert("Le numéro de téléphone n'est pas valide","danger");
         }
          
         //mdp
         $regexMdp = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        /*
            ^ : Début de la chaîne.
            (?=.*[A-Z]) : Doit contenir au moins une lettre majuscule.
            (?=.*[a-z]) : Doit contenir au moins une lettre minuscule.
            (?=.*\d) : Doit contenir au moins un chiffre.
            (?=.*[@$!%*?&]) : Doit contenir au moins un caractère spécial parmi @$!%*?&.
            [A-Za-z\d@$!%*?&]{8,} : Doit être constitué uniquement de lettres majuscules, lettres minuscules, chiffres et caractères spéciaux spécifiés, et doit avoir une longueur minimale de 8 caractères.
            $ : Fin de la chaîne.
       */ 
      //mot de passe
       if (!isset($_POST['mdp']) || !preg_match($regexMdp, $_POST['mdp']))
      {
            $info .= alert("Le mot de passe n'est pas valide","danger");
      }
      //confirmMdp
      if (!isset($_POST['confirmMdp']) || $_POST['mdp'] !== $_POST['confirmMdp'])
      {
            $info .= alert("Les mots de passe ne correspondent pas","danger");
      }
      // civility
    //   if (!isset($_POST['civility']) || ($_POST['civility'] !== 'h' && $_POST['civility'] !== 'f')) (une manière)
    if (!isset($_POST['civility']) || !in_array($_POST['civility'], ['h','f'])) // une autre manière

      {
            $info .= alert("La civilité n'est pas valide","danger");
      }
        //birthday // il faut définir la date inférieure et la date extérieure
      $year1 = ((int) date('Y') -13) ; // 2012
      $year2 = ((int) date('Y')- 90) ; // 1935
      $birthdayYear = explode ('-', $_POST['birthday']); // 1990
      var_dump((int)$birthdayYear[0]);
    // var_dump(date('Y')); // de type string
    if (!isset($_POST['birthday']) || ((int) $birthdayYear[0] > $year1  || (int) $birthdayYear[0] < $year2))
    //                                           1990 > 2012 ou 1990 < 1935
    {
        $info .= alert("L'année de naissance doit etre entre 1935 et 2012","danger");

    }
    // address
    if (!isset($_POST['address']) || strlen(trim($_POST['address'])) < 5 || strlen(trim($_POST['address'])) > 50)
    {
        $info .= alert("L'adresse n'est pas valide","danger");
    }
    // zip
    $zipRegex = "/^[0-9]{5}$/";
    // if (!isset($_POST['zip']) || !preg_match($zipRegex,trim($_POST['zip']))) // vérifie si le code postal est valide
    //ou
     if (!isset($_POST['zip']) || !preg_match($zipRegex = "/^[0-9]{5}$/", $_POST['zip']))
     {
            $info .= alert("Le code postal n'est pas valide","danger");
     }
    // city
    if (!isset($_POST['city']) || strlen(trim($_POST['city'])) < 5 || strlen(trim($_POST['city'])) > 50 || preg_match('/[0-9]/', $_POST['city']))
    {
        $info .= alert("La ville n'est pas valide","danger");
    }
    // country
    if (!isset($_POST['country']) || strlen(trim($_POST['country'])) < 5 || strlen(trim($_POST['country'])) > 50 || preg_match('/[0-9]/', $_POST['country']))
    {
        $info .= alert("Le pays n'est pas valide","danger");
    }

     if (empty($info))
        {
            $info = alert("Votre formulaire a été bien envoyé","success");

        //on récupère les données du formulaire et on les stocke dans des variables
        $lastName = trim($_POST['lastName']); // [la valeur de la name] trim pour enlever les espaces
        $firstName = trim($_POST['firstName']); 
        $pseudo = trim($_POST['pseudo']); 
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $mdp = trim($_POST['mdp']); // il faut hacher ce mot de passe
        // on supprime cette ligne car il ne faut pas stocker le mot de passe
        // $confirmMdp = trim($_POST['confirmMdp']);
        $civility = trim($_POST['civility']);
        $birthday = trim($_POST['birthday']);
        $address = trim($_POST['address']);
        $zip = trim($_POST['zip']);
        $city = trim($_POST['city']);
        $country = trim($_POST['country']);

        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
        // Cette fonction PHP crée un hachage sécurisé d'un mot de passe en utilisant un algorithme de hachage fort : génère une chaîne de caractères unique à partir d'une entrée. C'est un mécanisme unidirectionnel dont l'utilité est d'empêcher le déchiffrement d'un hash. Lors de la connexion, il faudra comparer le hash stocké dans la base de données avec celui du mot de passe fourni par l'internaute.
                // PASSWORD_DEFAULT : constante indique à password_hash() d'utiliser l'algorithme de hachage par défaut actuel c'est le plus recommandé car elle garantit que le code utilisera toujours le meilleur algorithme disponible sans avoir besoin de modifications.
        
            // debug($mdpHash);        
        

    }
    
    }

}
require_once "inc/header.inc.php";

?>
<!------------------------------- formulaire d'inscription ---------------------------->
<main style="background:url(assets/img/5818.png) no-repeat; background-size: cover; background-attachment: fixed;">

    <div class="w-75 m-auto p-5" style="background: rgba(20, 20, 20, 0.9);">
        <h2 class="text-center mb-5 p-3">Créer un compte</h2>
         <?php
        echo $info;
        //voir fonction alert dans functions.inc.php
        // echo alert("test pour voir si ça marche"); // sans préciser la classe
       // echo alert("test pour voir si ça marche","danger");

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