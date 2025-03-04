<?php
// $title = "Profil";
// $description = "Bienvenue sur votre profil";
require_once "inc/functions.inc.php";
//debug($_SESSION['user']); // pour voir les infos de l'utilisateur actuellement connecté 

if (!isset($_SESSION['user'])) {
    header("location:authentication.php");
} else {
    $user = $_SESSION['user'];
}
require_once "inc/header.inc.php"; // il faut déplacer cette ligne avant le require_once "inc/footer.inc.php" car sinon il va chercher le footer avant le header et cela va provoquer une erreur

?>

<div class="mx-auto p-2 row flex-column align-items-center">
    <h2 class="text-center mb-5">Bonjour <?php echo $_SESSION['user']['pseudo']; ?> </h2>
    <div class="cardFilm">
        <div class="image">
        <img src="
<?php 
if (isset($user) && $_SESSION['user']['civility'] == 'f') {
echo RACINE_SITE."assets/img/avatar_f.png";
}else{
echo RACINE_SITE."assets/img/avatar_h.png";  
}
//avec la condition ternaire
/*<img src="assets/img/

<?= $_SESSION['client']['civility'] == 'f' ? 'avatar_f.png' : 'avatar_h.png' ;?>

" alt="Image avatar de l'utilisateur">*/
?>
" alt="Image avatar de l'utilisateur">


            <div class="details">
                <div class="center ">

                    <table class="table">
                        <tr>
                            <th scope="row" class="fw-bold">Nom</th>
                            <td>
                                <?= $user['lastName']?>
                            </td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Prenom</th>
                            <td>
                            <?= $user['firstName']?>
                            </td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Pseudo</th>
                            <td colspan="2"><?= $user['pseudo']?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">email</th>
                            <td colspan="2"><?= $user['email']?></td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Tel</th>
                            <td colspan="2">
                            <?= $user['phone']?>
                            </td>

                        </tr>
                        <tr>
                            <th scope="row" class="fw-bold">Adresse</th>
                            <td colspan="2">
                            <?= $user['address']?>
                            <?= $user['zip']?>
                            <?= $user['city']?>

                            </td>

                        </tr>

                    </table>
                    <a href="" class="btn mt-5">Modifier vos informations</a>
                </div>
            </div>
        </div>
    </div>
</div>













<?php
require_once "inc/footer.inc.php";
?>
