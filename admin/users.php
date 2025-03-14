<?php
require_once "../inc/functions.inc.php";

// 
$users = allUsers();
// debug($users);

if (!isset($_SESSION['user'])) {
    // Si une session n'existe pas avec un identifiant utilisateur, je me redirige vers la page authentification.php
    header("location:" . RACINE_SITE . "authentication.php");

} else {
    if ($_SESSION['user']['role'] == "ROLE_USER"){
        header("location:" . RACINE_SITE . "profil.php");
    }
}

// Insertion des utilisateurs



if (isset($_GET['action']) && isset($_GET['id'])) {
    $idUser = htmlspecialchars($_GET['id']);
    if (!empty($_GET['action']) && $_GET['action'] == "update" && !empty($_GET['id'])) {
        
        $user = showUser($idUser);
        // debug($user);

        if ($user['role'] == "ROLE_ADMIN") {
            // je change le rôle en user
            updateUserRole($idUser, 'ROLE_USER');
        } else {
            // je change le rôle en admin
            updateUserRole($idUser, 'ROLE_ADMIN');
        }
    }

    if(!empty($_GET['action']) && $_GET['action'] == "delete" && !empty($_GET['id'])) {
        deleteUser($idUser);

    }
    header("location:users.php");

}
//
require_once "../inc/header.inc.php";

?>
<div class="d-flex flex-column m-auto mt-5 table-responsive">
    <!-- tableau pour afficher toutles films avec des boutons de suppression et de modification -->
    <h2 class="text-center fw-bolder mb-5 text-danger">Liste des utilisateurs</h2>
    <table class="table  table-dark table-bordered mt-5">
        <thead>
            <tr>
                <!-- th*7 -->
                <th>ID</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Civility</th>
                <th>Address</th>
                <th>Zip</th>
                <th>City</th>
                <th>Country</th>
                <th>Rôle</th>
                <th>Supprimer</th>
                <th>Modifier Le rôle</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // foreach ($users as $key => $value) {
            //     debug($key);
            //     echo "<tr>";
            //     echo "<td>" . html_entity_decode($value['id']) . "</td>";
            //     echo "<td>" . $value['firstName'] . "</td>";
            //     echo "<td>" . $value['lastName'] . "</td>";
            //     echo "<td>" . $value['pseudo'] . "</td>";
            //     echo "<td>" . $value['email'] . "</td>";
            //     echo "<td>" . $value['phone'] . "</td>";
            //     echo "<td>" . $value['civility'] . "</td>";
            //     echo "<td>" . $value['addressComplete'] . "</td>";
            //     echo "<td>" . $value['zip'] . "</td>";
            //     echo "<td>" . $value['city'] . "</td>";
            //     echo "<td>" . $value['country'] . "</td>";
            //     echo "<td>" . $value['role'] . "</td>";
            //     echo "<td class='text-center'><a href=''><i class='bi bi-trash3'></i></a></td>";
            //     echo "<td class='text-center'><a href='' class=' btn btn-danger'></a></td>";
            //     echo "</tr>";
            // }
            ?>
            <!-- il faut utiliser la fonction html_entity_decode() sur les valeur récupérer -->
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= html_entity_decode($user['id_user']); ?></td>
                    <td><?= ucfirst(html_entity_decode($user['firstName'])); ?></td>
                    <td><?= html_entity_decode($user['lastName'], ENT_QUOTES); ?></td>
                    <td><?= html_entity_decode($user['pseudo']); ?></td>
                    <td><?= html_entity_decode($user['email']); ?></td>
                    <td><?= html_entity_decode($user['phone']); ?></td>
                    <td><?= html_entity_decode($user['civility']); ?></td>
                    <td><?= html_entity_decode($user['address']); ?></td>
                    <td><?= html_entity_decode($user['zip']); ?></td>
                    <td><?= html_entity_decode($user['city']); ?></td>
                    <td><?= html_entity_decode($user['country']); ?></td>
                    <td><?= html_entity_decode($user['role']); ?></td>
                    <td class="text-center">
                        <a href="users.php?action=delete&id=<?= $user['id_user'] ?>"><i class="bi bi-trash3"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="users.php?action=update&id=<?= $user['id_user'] ?>" class="btn btn-danger">
                            <?= ($user['role'] === "ROLE_ADMIN") ? 'Rôle Utilisateur' : 'Rôle Admin'; ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
<?php
require_once "../inc/footer.inc.php";
?>