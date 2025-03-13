<?php
require_once "../inc/functions.inc.php";
$info = ""; //on déclare une variable vide
$categories = showAllCategories();


//session message
if (isset($_SESSION['message']) && !empty($_SESSION['message']))
{
    $info = $_SESSION['message'];
    unset($_SESSION['message']); 
}



// Supprimer catégorie
if (isset($_GET['action']) && isset($_GET['id'])) {

    $idCategory = htmlspecialchars($_GET['id']);
    if (!empty($_GET['action']) && $_GET['action'] == "delete" && !empty($_GET['id'])) {
        deleteCategory($idCategory);
        $_SESSION['message'] = alert("Catégorie supprimée avec succès", "success");
        // $info .= alert("Catégorie supprimée avec succès", "success");

        header('location:categories.php'); // la redirection
        exit; // quand il ya redirection, il faut mettre exit 
    }
}



// Suppression et mofification d'une catégorie

if (isset($_GET) && isset($_GET['action']) &&  isset($_GET['id_category']) && !empty($_GET['action']) && !empty($_GET['id_category'])) {


    $idCategory = htmlentities($_GET['id_category']);
  
  
    if (is_numeric($idCategory)) {
  
      $categorie = showCategoryViaId($idCategory);
  
      if ($categorie) {
  // if $categorie is true

  // la suppression
        // if ($_GET['action'] == 'delete') {
  
        //     deleteCategory($idCategory);
  
        // }
        if ($_GET['action'] != 'update') {
  
          header('location:categories.php');
        }
      } else {
  
        header('location:categories.php');
      }
    } else {
  
      header('location:categories.php');
    }
  }
  

if (!isset($_SESSION['user'])) {
    // Si une session n'existe pas avec un identifiant utilisateur, je me redirige vers la page authentification.php
    header("location:" . RACINE_SITE . "authentication.php");

} else {
    if ($_SESSION['user']['role'] == "ROLE_USER"){
        header("location:" . RACINE_SITE . "profil.php");
    }
}



// pour vérifier si notre formulaire n'est pas vide
if (!empty($_POST)) {
    $verification = true;

    foreach ($_POST as $key => $value) {
        if (empty(trim($value))) {
            $verification = false;
        }
    }
    
    if ($verification === false) {
        $info = alert("Veuillez renseigner tous les champs", "danger");
    } else {
        if (!isset($_POST['name']) || strlen($_POST['name']) < 3 || preg_match('/[0-9]/', $_POST['name'])) {
            $info .= alert("Le nom de la catégorie n'est pas valide", "danger");
        }
        if (!isset($_POST['description']) || strlen($_POST['description']) < 20 || preg_match('/[0-9]/', $_POST['name'])) {
            $info .= alert("Le champ description n'est pas valide", "danger");
        }
        else if($info === ""){
            //stocker les variables
            $name = trim(htmlspecialchars($_POST['name']));
            $description = trim(htmlspecialchars($_POST['description']));
            // creation d'une variable $catégoryBdd qui prend une fonction
            $categoryBdd = showCategories($name);

            if ($categoryBdd) {
                $info .= alert("Cette catégorie existe deja", "danger");
            } else {
                //l'insertion de la categorie dans la base de données
                addCategory($name, $description);
                $info .= alert("Catégorie ajoutée avec succès", "success");
            }
            if (isset($_GET['action']) && isset($_GET['id']) && !empty($_GET['action']) && $_GET['action'] == "update" && !empty($_GET['id'])) {
                $id = htmlspecialchars($_GET['id']); 
                updateCategory($id,$name,$description);
                $info .= alert("Catégorie modifiée avec succès", "success");
        }
    }
}
}


require_once "../inc/header.inc.php";

?>
    <?= $info; ?>
<div class="row mt-5">
    <div class="col-sm-12 col-md-6 mt-5">
        <h2 class="text-center fw-bolder mb-5 text-danger">Gestion des catégories</h2>
        <form action="" method="post" class="back">
            
            <div class="row">
                <div class="col-md-8 mb-5">
                    <label for="name" class="text-light">Nom de la catégorie</label>
             
                    <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($categorie['nom_categorie'] ?? '') ?>"> 
                    <!-- ?? est une condition ternaire qui signifie elseif  -->
                 
                </div>
                <div class="col-md-12 mb-5">
                    <label for="description" class="text-light">Description</label>
                    <textarea id="description"  name="description" class="form-control" rows="10"><?= isset($categorie) ? $categorie['description'] : '' ?></textarea>
                    <!-- Ici on a vérifié si $catégory n'est pas vide après une condition ternaire  -->
                </div>
            </div>
            <div class="row justify-content-center">
                    <button type="submit" class="btn btn-danger p-3"><?= isset($categorie) ? 'Modifier une catégorie' : ' Ajouter une catégorie' ?></button>
            </div>
        </form>
    </div>

    <div class="col-sm-12 col-md-6 d-flex flex-column mt-5 pe-3">  
       
        <h2 class="text-center fw-bolder mb-5 text-danger">Liste des catégories</h2>
        
       
    
        <table class="table table-dark table-bordered mt-5 " >
            <thead>
                    <tr>
                    <!-- th*7 -->
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Supprimer</th>
                        <th>Modifier</th>
                    </tr>
            </thead>
            <tbody> 
            <?php
    //    Ici on va afficher les catégories dans un tableau avec une boucle foreach
        foreach ($categories as $category): ?>
                        <tr>
                            <td><?= html_entity_decode($category['id_categorie']); ?></td>
                            <td><?= ucfirst(html_entity_decode($category['nom_categorie'])); ?></td> 
                            <td><?= substr(html_entity_decode($category['description']), 0,150 )." ..."; ?></td>
                            
                            <td class="text-center"><a href="categories.php?action=delete&id=<?=$category['id_categorie'];?>" onclick="return(confirm('Êtes-vous sûr de vouloir supprimer cette categorie ?'))" ><i class="bi bi-trash3-fill"></i></a></td>
                            <td class="text-center"><a href="?action=update&id_category=<?= $category['id_categorie'] ?>"><i class="bi bi-pen-fill"></i></a></td>
                            
                        </tr>
               <?php endforeach; ?>

            </tbody>

        </table>

</div>

<?php
require_once "../inc/footer.inc.php";
?>