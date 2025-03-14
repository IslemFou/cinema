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

//Déclaration des variables
$films = allFilm();
$info = "";

require_once "../inc/header.inc.php";

?>
    <?php
echo $info;
    ?>
<div class="d-flex flex-column m-auto mt-5">
    
    <h2 class="text-center fw-bolder mb-5 text-danger">Liste des films</h2>
    <a href="filmForm.php" class="btn align-self-end"> Ajouter un film</a>
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

              <?php
              foreach ($films as $film):
              ?>
                        <tr>

                            <!-- Je récupére les valeus de mon tabelau $film dans des td -->
                            <td><?= html_entity_decode($film['id_film']) ?></td>
                            <td><?= html_entity_decode($film['title']) ?> </td>
                            <td><img src="../assets/img/films/<?= html_entity_decode($film['image']) ?> " alt="affiche du film" class="img-fluid"></td>
                            <td><?= html_entity_decode($film['director']) ?> </td>
                            <td> 
                                <ul>
                                <?php
                                $TabActors = explode ("/",$film['actors']); // création de tableau actors à partir d'une string
                                foreach ($TabActors as $actor):
                                ?>
                                    <li><?= ucfirst(html_entity_decode($actor)) ?></li>
                          
                               <?php endforeach; ?>
                                </ul>
                            </td>
                            <td><?= html_entity_decode($film['ageLimit']) ?>  </td>
                            <td> <?= html_entity_decode($film['genre']) ?> </td>
                            <td><?= html_entity_decode($film['date']) ?></td>
                            <td><?= html_entity_decode($film['price']) ?>€</td>
                            <td><?= html_entity_decode($film['stock']) ?> </td>
                            <td> <?= html_entity_decode($film['synopsis']) ?>...</td>
                            <td> <?= html_entity_decode($film['date'])?> </td>
                            <td class="text-center"><a href=""><i class="bi bi-trash3-fill"></i></a></td>
                            <td class="text-center"><a href=""><i class="bi bi-pen-fill"></i></a></td>
                           
                        </tr>
                        <?php endforeach; ?>
            </tbody>
    </table>
</div>

<?php
require_once "../inc/footer.inc.php";
?>