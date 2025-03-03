<?php
// $title = "Profil";
// $description = "Bienvenue sur votre profil";
require_once "inc/functions.inc.php";
debug($_SESSION['user']); // pour voir les infos de l'utilisateur actuellement connecté 

if (!isset($_SESSION['user'])) {
    header("location:authentication.php");
}
require_once "inc/header.inc.php"; // il faut déplacer cette ligne avant le require_once "inc/footer.inc.php" car sinon il va chercher le footer avant le header et cela va provoquer une erreur

?>

















<?php
require_once "inc/footer.inc.php";
?>
