<?php
require_once "inc/functions.inc.php";
require_once "inc/header.inc.php";
$title = '';
$buttonText = '';

if (isset($_GET['action']) && $_GET['action'] == 'viewAll') {
    $films = getAllFilms();
    $title = 'Tous les films ' . '(' . count($films) . ')';
    $buttonText = 'Voir les six derniers films';
} else {
    $films = getSixFilms();
    $title = 'Les 6 derniers films ' . '(' . count($films) . ')';
    $buttonText = 'Voir plus de films';
}

?>

<div class="films">
    <h2 class="fw-bolder fs-1 mx-5 text-center"><?= $title; ?> </h2> <!-- Affiche le message et le nombre de films -->
    <div class="row justify-content-around">
        <?php foreach ($films as $film): ?>

            <div class="col-sm-12 col-md-8 col-lg-6 col-xxl-3">
                <div class="card">
                    <img src="<?= RACINE_SITE . "assets/img/films/" . $film['image']; ?>" class="card-img-top" alt="image du film"> <!-- Affiche l'image du film -->
                    <div class="card-body">
                        <h3><?= $film['title']; ?></h3> <!-- Affiche le titre du film -->
                        <h4><?= $film['director']; ?></h4> <!-- Affiche le réalisateur du film -->
                        <p><span class="fw-bolder">Résumé:</span> <?= substr($film['synopsis'], 0, 150) . " ..."; ?></p> <!-- Affiche un résumé du film -->
                        <a href="<?= RACINE_SITE; ?>showfilm.php/?action=view&id_film<?= $film['id_film']; ?>" class="btn">Détails</a> <!-- Lien pour voir plus de détails -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-12 text-center">
        <?php
        if (isset($_GET['action']) && $_GET['action'] == 'viewAll'): ?>
            <!-- //Lien pour voir plus de films  -->
            <a href="<?= RACINE_SITE; ?>index.php" class="btn p-4 fs-3"> <?= $buttonText; ?></a>

        <?php else: ?>
            <!-- Lien pour voir tous les films  -->
            <a href="<?= RACINE_SITE; ?>index.php?action=viewAll" class="btn p-4 fs-3"> <?= $buttonText; ?></a>
        <?php endif;
        ?>

    </div>

</div>



<?php
require_once "inc/footer.inc.php";
?>