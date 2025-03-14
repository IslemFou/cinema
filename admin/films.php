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

// Insertion des films
if (isset($_GET['action']) && isset($_GET['id'])) {
    $idFilm = htmlspecialchars($_GET['id']);




















}


require_once "../inc/header.inc.php";

?>
    <?php
echo $info;
    ?>
<div class="d-flex flex-column m-auto mt-5">
    
    <h2 class="text-center fw-bolder mb-5 text-danger">Liste des films</h2>
    <a href="gestion_film.php" class="btn align-self-end"> Ajouter un film</a>
    <table class="table table-dark table-bordered mt-5 " >
            <thead>
                    <tr >
                    <!-- th*7 -->
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Affiche</th>
                        <th>Réalisateur</th>
                        <th>Acteurs</th>
                        <th>Àge limite</th>
                        <th>Genre</th>
                        <th>Durée</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Synopsis</th>
                        <th>Date de sortie</th>
                        <th>Supprimer</th>
                        <th> Modifier</th>
                    </tr>
            </thead>
            <tbody>

              
                        <tr>

                            <!-- Je récupére les valeus de mon tabelau $film dans des td -->
                            <td></td>
                            <td> </td>
                            <td> <img src="" alt="affiche du film" class="img-fluid"></td>
                            <td> </td>
                            <td> 
                                <ul>
                                
                                    <li></li>
                          
                               
                                </ul>
                            </td>
                            <td> </td>
                            <td> </td>
                            <td></td>
                            <td> €</td>
                            <td> </td>
                            <td> ...</td>
                            <td> </td>
                            <td class="text-center"><a href=""><i class="bi bi-trash3-fill"></i></a></td>
                            <td class="text-center"><a href=""><i class="bi bi-pen-fill"></i></a></td>
                           
                        </tr>
            </tbody>
    </table>
</div>

<?php
require_once "../inc/footer.inc.php";
?>