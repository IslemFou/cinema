<?php
require_once "../inc/functions.inc.php";
if (!isset($_SESSION['user'])) {
    // Si une session n'existe pas avec un identifiant utilisateur, je me redirige vers la page authentification.php
    header("location:" . RACINE_SITE . "authentication.php");

} else {
    if ($_SESSION['user']['role'] == "ROLE_USER"){
        header("location:" . RACINE_SITE . "profil.php");
    }
}
require_once "../inc/header.inc.php";

$info = "";


// debug ($_POST['duration']);


if (!empty($_POST)) {
    $verification = true;

    foreach ($_POST as $key => $value) {    
        if (empty(trim($value))) {
            $verification = false;
        }
    }
    
    if ($verification === false) {
        $info .= alert("Veuillez renseigner tous les champs", "danger");
    } else {

    //titre
     if (!isset($_POST['title']) || strlen(trim($_POST['title'])) > 50 || strlen(trim($_POST['title'])) < 2)
     {
        $info .= alert("Le titre n'est pas valide", "danger");
     }
// image
     if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0)
     {
        $info .= alert("veuillez insérer une image", "danger");
     } else
     {
        $extensionAutorise = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (!in_array($ext, $extensionAutorise))
        {
            $info .= alert("L'extension de l'image n'est pas valide", "danger");
        }
     }

//director
     if (!isset($_POST['director']) || strlen(trim($_POST['director'])) > 50 || strlen(trim($_POST['director'])) < 2)
     {
        $info .= alert("Le nom du realisateur n'est pas valide", "danger");
     }
     //actors
    if (!isset($_POST['actors']) || strlen(trim($_POST['actors'])) > 500 || strlen(trim($_POST['actors'])) < 2)
     {
        $info .= alert("Le nom des acteurs n'est pas valide", "danger");
     }
     //age limit
    if (!isset($_POST['ageLimit']) || !in_array($_POST['ageLimit'], ['10', '13', '16']))
    {
        $info .= alert("Veuillez sélectionner une age limite", "danger");
    }
    //Genre du film
    if (!isset($_POST['categories']))
    {
        $info .= alert("Veuillez cocher la catégorie du film", "danger");
    }
//duration
    if (!isset($_POST['duration']))
    {
        $info .= alert("Veuillez renseigner la durée du film", "danger");
    }
    // date de sortie
    if (!isset($_POST['date']))
    {
        $info .= alert("Veuillez renseigner la date de sortie du film", "danger");
    }
    // prix
    if (!isset($_POST['price']) || $_POST['price'] < 0) 
    {
        $info .= alert("Veuillez renseigner le prix du film", "danger");
    }
    // stock
    if (!isset($_POST['stock']) || $_POST['stock'] < 0)
    {
        $info .= alert("Veuillez renseigner le stock du film", "danger");
    }
    //synopsis
    if (!isset($_POST['synopsis']) || strlen(trim($_POST['synopsis'])) > 1000 || strlen(trim($_POST['synopsis'])) < 2)
     {
        $info .= alert("Le synopsis n'est pas valide", "danger");
     }
    
    // else{
    //     $info .= alert("Le film a bien été ajouté", "success");
    // }
}
if (empty($info)) {
    $title = htmlspecialchars(trim($_POST['title']));
    $director = trim($_POST['director']);
    $actors = trim($_POST['actors']);
    $ageLimit = trim($_POST['ageLimit']);
    $duration = trim($_POST['duration']);
    $date = trim($_POST['date']);
    $image = $_FILES['image']['name'];
    $price = trim($_POST['price']);
    $stock = trim($_POST['stock']);
    $categories = $_POST['categories'];
    $synopsis = trim($_POST['synopsis']);



// debug ($title);
$filmExisit = checkFilm($title, $director);

// debug($filmExisit); 

if ($filmExisit) {
    $info = alert("Le film existe deja", "danger");
}   

else {
    
    $path = "../assets/img/films/". $title . "." . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], $path); // l'envoie de l'image dans le dossier

    $addFilm = addFilm($categories,$title, $director,$actors, $ageLimit, $duration, $synopsis, $date, $image, $price, $stock);
    
    $info = alert("Le film a bien été ajouté, vous pouvez y accéder à la liste des films <a href='films.php' class='text-danger fw-bold'>ici</a>", "success");
    
}
}
}

?>

<main>
    <?php
echo $info;
    ?>
    <h2 class="text-center fw-bolder mb-5 text-danger">Formulaire d'ajout du film</h2>

        <form action="" method="post" class="back" enctype="multipart/form-data">
        <!-- il faut isérer une image pour chaque film, pour le traitement des images et des fichiers en PHP on utilise la surperglobal $_FILES -->
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="title" class="text-light">Titre de film</label>
                <input type="text" name="title" id="title" class="form-control" value="">

            </div>
            <div class="col-md-6 mb-5">
                <label for="image" class="text-light">Photo</label>
                <br>
                <input type="file" name="image" id="image">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="director" class="text-light">Réalisateur</label>
                <input type="text" class="form-control" id="director" name="director" value="">
            </div>
            <div class="col-md-6">
                <label for="actors" class="text-light">Acteur(s)</label>
                <input type="text" class="form-control" id="actors" name="actors" value="" placeholder="séparez les noms d'acteurs avec un /">
            </div>
        </div>
        <div class="row">
            <!-- raccouci bs5 select multiple -->
            <div class="mb-3">
                <label for="ageLimit" class="form-label text-light">Àge légale</label>
                <select class="form-select form-select-lg" name="ageLimit" id="ageLimit">
                    <option value="10">10</option>                  
                    <option value="13">13</option>
                    <option value="16">16</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label for="categories" class="text-light" >Genre du film</label>

            <?php 
                            // On récupère toutes les catégories dans le menu déroulant
                            $categories = showAllCategories();
                            foreach ($categories as $category):?>
                <div class="form-check col-sm-12 col-md-4">
                

                    <input class="form-check-input" type="radio" name="categories" id="" value="<?= $category['id_categorie']; ?>"  checked>

                    <label class="form-check-label" for=""><?= ucfirst(html_entity_decode($category['nom_categorie'])); ?></label>
                   

                </div>
                <?php endforeach; ?>
           

        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="duration" class="text-light">Durée du film</label>
                <input type="time" class="form-control" id="duration" name="duration"  min="01:00" value="">
            </div>

            <div class="col-md-6 mb-5">

                <label for="date" class="text-light">Date de sortie</label>
                <input type="date" name="date" id="date" class="form-control" value="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="price" class="text-light">Prix</label>
                <div class=" input-group">
                    <input type="text" class="form-control" id="price" name="price" aria-label="Euros amount (with dot and two decimal places)" value="1.00">
                    <span class="input-group-text">€</span>
                </div>
            </div>

            <div class="col-md-6">
                <label for="stock" class="text-light">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" min="0" value="0"> <!--pas de stock négativ donc je rajoute min="0"-->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="synopsis" class="text-light">Synopsis</label>
                <textarea type="text" class="form-control" id="synopsis" name="synopsis" rows="10" placeholder="Malgré sa paralysie,Jake Sully..."></textarea>
            </div>
        </div>

        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger p-3 w-25">Ajouter un film</button>
        </div>

    </form>

</main>

<?php
require_once "../inc/footer.inc.php";
?>