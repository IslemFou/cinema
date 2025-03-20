<?php
require_once "../inc/functions.inc.php";

$pageTitle = "Ajouter un film";

$regexDuration = "/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/";// regex pour la durée du film
$regexDate = "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/"; // regex pour la date de sortie du film

//check if user is connected and not admin
if (!isset($_SESSION['user'])) {
    // Si une session n'existe pas avec un identifiant utilisateur, je me redirige vers la page authentification.php
    header("location:" . RACINE_SITE . "authentication.php");
    
} else {
    if ($_SESSION['user']['role'] == "ROLE_USER"){
        header("location:" . RACINE_SITE . "profil.php");
    }
}

$info = "";

// Initialiser les variables qui contiennent les données du formulaire (avec les valeurs par défaut)
// $title = isset($_POST['title']) ? trim($_POST['title']) : "";
// $director = isset($_POST['director']) ? trim($_POST['director']) : "";
// $actors = isset($_POST['actors']) ? trim($_POST['actors']) : "";
// $ageLimit = isset($_POST['ageLimit']) ? trim($_POST['ageLimit']) : "";
// $duration = isset($_POST['duration']) ? trim($_POST['duration']) : "";
// $synopsis = isset($_POST['synopsys']) ? trim($_POST['synopsys']) : "";
// $date = isset($_POST['date']) ? trim($_POST['date']) : "";
// $price = isset($_POST['price']) ? trim($_POST['price']) : "";
// $stock = isset($_POST['stock']) ? trim($_POST['stock']) : "";
// $category_id = isset($_POST['categories']) ? trim($_POST['categories']) : "";



if (!empty($_POST)) 
{
    $verification = true;

    foreach ($_POST as $key => $value) 
    {    
        if (empty(trim($value))) {
            $verification = false;
        }
    }
    
    // alerte sur les champs vides
    if ($verification === false) 
    {
        $info .= alert("Veuillez renseigner tous les champs", "danger");
    } else {
        // on récupère les données du formulaire
        //titre
        if (!isset($_POST['title']) || strlen(trim($_POST['title'])) > 50 || strlen(trim($_POST['title'])) < 2)
        {
            $info .= alert("Le titre n'est pas valide", "danger");
        }
        // image
        if($_FILES['image']['error'] == UPLOAD_ERR_NO_FILE){
            $imageUpdate = htmlspecialchars(trim($_POST['oldImage']));
        } elseif(!isset($_FILES['image']) || $_FILES['image']['error'] != 0){
            $info .= alert("veuillez insérer une image", "danger");
        } else {
            $extensionAutorise = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            if (!in_array($ext, $extensionAutorise))
            {
                $info .= alert("L'extension de l'image n'est pas valide", "danger");
            } else {
                //upload de l'image
                $path = "../assets/img/films/". $title . "." . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $path); // l'envoie de l'image dans le dossier
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

        // si il n'y a pas d'erreur dans le formulaire, on ajoute le film
        if (empty($info)) 
        {
            $title = htmlspecialchars(trim($_POST['title']));
            $director = htmlspecialchars(trim($_POST['director']));
            $actors = htmlspecialchars(trim($_POST['actors']));
            $ageLimit = htmlspecialchars(trim($_POST['ageLimit']));
            $duration = htmlspecialchars(trim($_POST['duration']));
            $date = htmlspecialchars(trim($_POST['date']));
            $image = $_FILES['image']['name'];
            $price = htmlspecialchars(trim($_POST['price']));
            $stock = htmlspecialchars(trim($_POST['stock']));
            //category_id juste ici je l'ai nommé categories
            $categories = htmlspecialchars(trim($_POST['categories']));
            $synopsis = htmlspecialchars ( trim($_POST['synopsis']));

            //  Traitement nom de l'image
            $image = strtolower($image);
            $image = str_replace(" ", "_", $image);

            $filmExiste = checkFilm($title, $director);

            if (isset($_GET['action']) && $_GET['action'] == 'update')
            {
                $idFilm = htmlspecialchars($_GET['id_film']);

                if($idFilm) 
                {
                    updateFilm($idFilm, $category_id, $title, $director, $actors, $ageLimit, $duration, $synopsis, $date, $image, $price, $stock);
                    $info = alert('Le film ' . $title . ' a bien été mis à jour', "success");
                }
            } else{
                addFilm($categories,$title, $director,$actors, $ageLimit, $duration, $synopsis, $date, $image, $price, $stock);
                $_SESSION['info'] = alert("Le film a bien été ajouté, vous pouvez y accéder à la liste des films <a href='films.php' class='text-danger fw-bold'>ici</a>", "success");
                header("location:films.php");
                exit;  
            }
        }
    }    
}

  // Première partie de l'update: la vérification
if (isset($_GET['action'])  && isset($_GET['id_film']) && $_GET['action'] == "update")
{
    //récupération de l'id qui est dans l'URL au niveau d'une variable
    $idFilm = $_GET['id_film'];
    $film = showFilm($idFilm);
    
   
        $titleUpdate = $film['title'];
        $directorUpdate = $film['director'];
        $actorsUpdate = $film['actors'];
        $ageLimitUpdate = $film['ageLimit'];
        $categoriesUpdate = $film['category_id'];
        $durationUpdate = $film['duration'];
        $dateUpdate = $film['date'];
        $priceUpdate = $film['price'];
        $stockUpdate = $film['stock'];
        $synopsisUpdate = $film['synopsis'];
        $imageUpdate = $film['image'];
        $submitUpdate = "Modifier un film";
}

require_once("../inc/header.inc.php");

?>

<main>
    <?php echo $info; ?>
    <h2 class="text-center fw-bolder mb-5 text-danger">Formulaire d'ajout du film</h2>

        <form action="" method="post" class="back" enctype="multipart/form-data">
        <!-- il faut isérer une image pour chaque film, pour le traitement des images et des fichiers en PHP on utilise la surperglobal $_FILES -->
         <input type="hidden" name="id_film" value="<?= $idFilm; ?>">
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="title" class="text-light">Titre de film</label>
                <input type="text" name="title" id="title" class="form-control" value="<?=  $titleUpdate ?? ""  ?>">

            </div>
            <div class="col-md-6 mb-5">
                <label for="image" class="text-light">Image du film</label>
                <br>
                <input type="file" name="image" id="image">
                <input class="hidden" name="oldImage" value="<?= $imageUpdate ?? "" ?>"></input>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="director" class="text-light">Réalisateur</label>
                <input type="text" class="form-control" id="director" name="director" value="<?= $directorUpdate ?? "" ?>">
            </div>
            <div class="col-md-6">
                <label for="actors" class="text-light">Acteur(s)</label>
                <input type="text" class="form-control" id="actors" name="actors" value="<?= $actorsUpdate ?? "" ?>" placeholder="séparez les noms d'acteurs avec un /">
            </div>
        </div>
        <div class="row">
            <!-- raccouci bs5 select multiple -->
            <div class="mb-3">
                <label for="ageLimit" class="form-label text-light">Àge légale</label>
                <select class="form-select form-select-lg" name="ageLimit" id="ageLimit">
                            <?php switch ($ageLimit) {

                                    case 10:
                                        echo '<option value="10" selected>10</option>';
                                        break;
                                    case 13:
                                        echo '<option value="13" selected>13</option>';
                                        break;
                                    case 16:
                                        echo '<option value="16" selected>16</option>';
                                        break;
                                    default:
                                        echo '<option value="10">10</option>';
                                        echo '<option value="13">13</option>';
                                        echo '<option value="16">16</option>';
                                                } 
                                  ?>
                </select>
            </div>
        </div>
        <div class="row">
            <label for="categories" class="text-light" >Genre du film</label>

            <?php 
                            // On récupère toutes les catégories dans le menu déroulant
                            $categories = showAllCategories('nom_categorie');
                            foreach ($categories as $category):?>
                <div class="form-check col-sm-12 col-md-4">
                <?php if ($category['id_categorie']) : ?>
                    <input class="form-check-input" type="radio" name="categories" id="<?= $category['id_categorie'] ?>" value="<?= $category['id_categorie']?>"  checked>
                    <label class="form-check-label" for="<?= $category['id_categorie'] ?>"><?= html_entity_decode($category['nom_categorie']); ?></label>
                    <?php else : ?>
                      <input class="form-check-input" type="radio" name="categories" id="<?= $category['id_categories'] ?>" value="<?= $category['id_categorie'] ?>">
                      <label class="form-check-label" for="<?= $category['id_categorie'] ?>"><?= html_entity_decode($category['nom_categorie']); ?></label>
                    <?php endif; ?>

                </div>
                <?php endforeach; ?>
           

        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="duration" class="text-light">Durée du film</label>
                <input type="time" class="form-control" id="duration" name="duration"  min="01:00" value="<?= $durationUpdate ?? "" ?>">
            </div>

            <div class="col-md-6 mb-5">

                <label for="date" class="text-light">Date de sortie</label>
                <input type="date" name="date" id="date" class="form-control" value="<?=  $dateUpdate ?? "" ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="price" class="text-light">Prix</label>
                <div class=" input-group">
                    <input type="text" class="form-control" id="price" name="price" aria-label="Euros amount (with dot and two decimal places)" value=" <?= $priceUpdate ?? "" ?>">
                    <span class="input-group-text">€</span>
                </div>
            </div>

            <div class="col-md-6">
                <label for="stock" class="text-light">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" min="0" value="<?= $stockUpdate ?? "" ?>"> <!--pas de stock négativ donc je rajoute min="0"-->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="synopsis" class="text-light">Synopsis</label>
                <textarea type="text" class="form-control" id="synopsis" name="synopsis" rows="10" placeholder="Malgré sa paralysie,Jake Sully..."><?= $synopsisUpdate ?? "" ?></textarea>
            </div>
        </div>

        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger p-3 w-25">  
            <?= $submit ?? "Ajouter un film" ?>
        </button>
        </div>

    </form>

</main>

<?php
require_once "../inc/footer.inc.php";
?>