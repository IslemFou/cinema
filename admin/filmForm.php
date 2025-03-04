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

?>

<?php
require_once "../inc/footer.inc.php";
?>