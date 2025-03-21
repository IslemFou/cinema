<?php
/* ------------ Constante pour défninir le chemin du site ------------ */
define("RACINE_SITE", "http://localhost/cinema/");

session_start();

#### Condition pour se déconnecter
if (isset($_GET['action']) && $_GET['action'] === "deconnexion") {
    // Soit on supprime la clé "user" de la session
    // unset($_SESSION['user']);
    // Soit on détruit la session $_SESSION
    // session_destroy();
    // La fonction session_destroy détruit toutes les données de la session déjà établie. Cette focntion détruit la sessio  sur le serveur.

    //ca dépend de l'objectif du site. Dnas notre cas, c'est un site e-commerce qui va gérer des paniers utilisateur, donc on supprime la clé "user" de la session
    unset($_SESSION['user']); // On supprime l'indice 'user' de la session pour s edéconnecter, cette fonction détruit les élément du tableau $_SESSION['user']
    header("location:" . RACINE_SITE . "index.php");
}
/* ------------ Fonction alert ------------ */
function alert(string $contenu, string $class = "warning"): string // type prend une classe bootstrap
{
    return "<div class=\"alert alert-$class alert-dismissible fade show text-center w-50 m-auto mb-5\" role=\"alert\">
                $contenu
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
        </div>";
}

/* ------------- Création d'une fonction pour se connecter à la base de donnée -------------*/
// On vas utiliser l'extension PHP Data Objects (PDO), elle définit une excellente interface pour accéder à une base de données depuis PHP et d'exécuter des requêtes SQL .
// Pour se connecter à la BDD avec PDO il faut créer une instance de cet Objet (PDO) qui représente une connexion à la base,  pour cela il faut se servir du constructeur de la classe
// Ce constructeur demande certains paramètres:
// On déclare des constantes d'environnement qui vont contenir les information à la connexion à la BDD

// création d'un script réutilisable
//constante du server
define("DBHOST", "localhost");

// // constante de l'utilisateur de la BDD du serveur en local => root
define("DBUSER", "root");

// // constante pour le mot de passe de serveur en local => pas de mot de passe
define("DBPASS", "");

// // Constante pour le nom de la BDD
define("DBNAME", "cinema");

/* ------------------- Fonction pour débugger ------------------------------*/

function debug($var)
{
    echo '<pre class="border border-dark bg-light text-danger fw-bold w-50 p-5 bottom-50 start-50 position-absolute z-10
     bg-body-secondary translate-middle">';
    var_dump($var);
    echo '</pre>';
}



/* --------------------------------
-----------------------------------------------------------------------
Création d'une fonction pour se connecter à la base de donnée
-------------------------------------------------------------------------------------------------
--------------------------------
*/

function connexionBdd(): object
{
    //DSN (Data Source Name):
    //$dsn = mysql:host=localhost;dbname=entreprise;charset=utf8;
    $dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8";

    //Grâce à PDP on peut lever une exception (une erreur) si la connexion à la BDD ne se réalise pas(exp: suite à une faute au niveau du nom de la BDD) et par la suite si elle cette erreur est capté on lui demande d'afficher une erreur

    try { // dans le try on vas instancier PDO, c'est créer un objet de la classe PDO (un élment de PDO)
        // Sans la variable dsn les constatntes d'environnement
        // $pdo = new PDO('mysql:host=localhost;dbname=entreprise;charset=utf8','root','');
        $pdo = new PDO($dsn, DBUSER, DBPASS);
        //On définit le mode d'erreur de PDO sur Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // POUR SAHAR:  cet atribut est à rajouter après le premier fetch en bas 
        //On définit le mode de "fetch" par défaut
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // je vérifie la connexion avec ma BDD avec un simple echo
        //    echo "Je suis connecté à la BDD";
    } catch (PDOException $e) {  // PDOException est une classe qui représente une erreur émise par PDO et $e c'est l'objetde la clase en question qui vas stocker cette erreur

        die("Erreur : " . $e->getMessage()); // die d'arrêter le PHP et d'afficher une erreur en utilisant la méthode getmessage de l'objet $e
    }
    return $pdo; // on retourne la connexion à la BDD , un objet 
}

//le catch sera exécuter dès lors on aura un problème da le try

// À partir d'ici on est connecté à la BDD et la variable $pdo est l'objet qui représente la connexion à la BDD, cette variable va nous servir à effectuer les requêtes SQL et à interroger la base de données 
// debug($pdo);
//debug(get_class_methods($pdo)); // permet d'afficher la liste des méthodes présentes dans l'objet $pdo.



// ---------------------- table categories ----------------------
function createTableCategories(): void
{
    // creation d'une variable $conx pour stocker la connexion à la BDD
    $conx = connexionBdd();
    //définition de la requête SQL
    $sql = "CREATE TABLE IF NOT EXISTS categories(id_categorie INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                              nom_categorie VARCHAR(50) NOT NULL,
                                              description TEXT NOT NULL
                                              )";

    $_REQUEST = $conx->exec($sql); // la méthode exec() de l'objet $conx permet d'exécuter une requête SQL
};

createTableCategories();

//---------------- table films ----------------
function createTableFilm(): void
{
    // creation d'une variable $conx pour stocker la connexion à la BDD
    $conx = connexionBdd();

    $tableFilm = "CREATE TABLE IF NOT EXISTS film(id_film INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                              category_id INT(11) NOT NULL,
                                              title VARCHAR (100) NOT NULL,
                                              director VARCHAR (100) NOT NULL,
                                              actors VARCHAR (100) NOT NULL,
                                              ageLimit VARCHAR (5) NULL,
                                              duration TIME NOT NULL,
                                              synopsis TEXT NOT NULL,
                                              date DATE NOT NULL,
                                              image VARCHAR (250) NOT NULL,
                                              price FLOAT NOT NULL,
                                              stock BIGINT NOT NULL)";
    $conx->exec($tableFilm); // la méthode exec() de l'objet $conx permet d'exécuter une requête SQL
}
//createTableFilm();



// ---------------------- table users ----------------------
function createTableUsers(): void
{
    // creation d'une variable $conx pour stocker la connexion à la BDD
    $conx = connexionBdd();
    //définition de la requête SQL
    $tableUsers = "CREATE TABLE IF NOT EXISTS users(id_user INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                              firstname VARCHAR(50),
                                              lastname VARCHAR(50) NOT NULL,
                                              pseudo VARCHAR(50) NOT NULL,
                                              mdp VARCHAR(255) NOT NULL,
                                              email VARCHAR(100) NOT NULL,
                                             phone VARCHAR(30) NOT NULL,
                                             civility ENUM('f','h') NOT NULL,
                                             birthday DATE NOT NULL,
                                             address VARCHAR (50) NOT NULL,
                                             zip VARCHAR (50) NOT NULL,
                                             city VARCHAR (50) NOT NULL,
                                             country VARCHAR (50),
                                              role ENUM('ROLE_USER','ROLE_ADMIN') NOT NULL DEFAULT 'ROLE_USER')";
    $conx->exec($tableUsers);
}
//createTableUsers();

//---------------- création des clés étrangères ----------------
function foreignkey(string $tableFK, string $keyFK, string $tablePK, string $keyPK): void
{
    $conx = connexionBdd();
    // création de clé étrangère pour la table film sous-forme de fonction avec des arguments
    // $tableF = nom de la table
    // $keyFk = nom de la clé étrangère
    // $keyPK = nom de la clé primaire
    $sql = "ALTER TABLE $tableFK ADD FOREIGN KEY ($keyFK) REFERENCES $tablePK($keyPK)";
    $conx->exec($sql);
}
//appel de la fonction de création de clé étrangère
// foreignkey('film', 'category_id', 'categories', 'id_categorie');
/*
                          ╔═════════════════════════════════════════════╗
                          ║                                             ║
                          ║                UTILISATEURS                 ║
                          ║                                             ║
                          ╚═════════════════════════════════════════════╝ 
                          
*/

// fonction pour ajouter un utilisateur
function addUser(string $lastName, string $firstName, string $pseudo, string $email, string $phone, string $mdp, string $civility, string $birthday, string $address, string $zip, string $city, string $country): void
{
    //création d'un tableau associatif
    $data = [
        //key => value
        'lastName' => $lastName,
        'firstName' => $firstName,
        'pseudo' => $pseudo,
        'email' => $email,
        'phone' => $phone,
        'mdp' => $mdp,
        'civility' => $civility,
        'birthday' => $birthday,
        'address' => $address,
        'zip' => $zip,
        'city' => $city,
        'country' => $country
    ];

    //Echapper les données et les traiter contre les failles JS
    foreach ($data as $key => $value) {
        //htmlspecialchars() convertit les caractères spéciaux en entités HTML
        // Exemple : < devient &lt; et > devient &gt;
        // $data['lastName'] = htmlspecialchars($lastName);
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); //ENT_QUOTES est une constante en PHP qui convertie les guillemets doubles et les guillemets simples en entités HTML. Exemple : la guillement simple se convertit en &#039; et la guillemet double se convertit en &quot;

        /* 
            htmlspecialchars est une fonction qui convertit les caractères spéciaux en entités HTML, cela est utilisé afin d'empêcher l'exécution de code HTML ou JavaScript : les attaques XSS (Cross-Site Scripting) injecté par un utilisateur malveillant en échappant les caractères HTML /////////////potentiellement dangereux . Par défaut, htmlspecialchars échappe les caractères suivants :

            & (ampersand) devient &amp;
            < (inférieur) devient &lt;
            > (supérieur) devient &gt;
            " (guillemet double) devient &quot;

        */
    }
    //connextion à la base de données
    $pdo = connexionBdd();
    //définition de la requête SQL
    $sql = "INSERT INTO users( lastName, firstName, pseudo, email, phone, mdp, civility, birthday, address, zip, city, country) VALUES (:lastName, :firstName, :pseudo, :email, :phone, :mdp, :civility, :birthday, :address, :zip, :city, :country)";
    /* Les requêtes préparer sont préconisées si vous exécutez plusieurs fois la même requête. Ainsi vous évitez au SGBD de répéter toutes les phases analyse/ interpretation / exécution de la requête (gain de performance). Les requêtes préparées sont aussi utilisées pour nettoyer les données et se prémunir des injections de type SQL.

        1- On prépare la requête
        2- On lie le marqueur à la requête
        3- On exécute la requête 

    */
    $request = $pdo->prepare($sql); //prepare() est une méthode qui permet de préparer la requête sans l'exécuter. Elle contient un marqueur :firstName qui est vide et attend une valeur.
    $request->execute(array(
        ':lastName' => $data['lastName'],
        ':firstName' => $data['firstName'],
        ':pseudo' => $data['pseudo'],
        ':email' => $data['email'],
        ':phone' => $data['phone'],
        ':mdp' => $data['mdp'],
        ':civility' => $data['civility'],
        ':birthday' => $data['birthday'],
        ':address' => $data['address'],
        ':zip' => $data['zip'],
        ':city' => $data['city'],
        ':country' => $data['country']
    ));
    //execute() est une méthode qui permet d'exécuter la requête préparée. Elle prend en paramètre un tableau associatif qui contient les valeurs à injecter dans la requête.

    // $request->execute($data); // cela ne fonctionne pas car les clés du tableau $data doivent être identiques aux marqueurs de la requête préparée
}
#### Fonction pour vérifier si l'email existe déjà
function checkEmailUser(string $email): mixed
{
    $pdo = connexionBdd();
    $sql = "SELECT email FROM users WHERE email = :email";
    $request = $pdo->prepare($sql); // La flèche représente l'opérateur de résolution de portée qui permet d'accéder à une méthode ou une propriété d'un objet. Dans notre cas, on accède à la méthode prepare() de l'objet $pdo.
    $request->bindValue(':email', $email, PDO::PARAM_STR);
    $request->execute();
    $result = $request->fetch();
    return $result;

    // $request = $pdo->query($sql); // query() est une méthode qui permet d'exécuter une requête SQL. Elle prend en paramètre la requête SQL à exécuter.
    // $result = $request->fetch(); // fetch() est une méthode qui permet de récupérer le résultat de la requête sous forme de tableau associatif (clé => valeur)
    // return $result;
}


#### Fonction pour vérifier si le pseudo existe déjà
function checkPseudoUser(string $pseudo): mixed
{
    $pdo = connexionBdd();
    $sql = "SELECT pseudo FROM users WHERE pseudo = :pseudo";
    $request = $pdo->prepare($sql);
    $request->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $request->execute();
    $result = $request->fetch();
    return $result;
}

#### Fonction pour vérifier si l'email et le pseudo existent déjà
function checkEmailPseudoUser($email, $pseudo): mixed
{
    $pdo = connexionBdd();
    $sql = "SELECT * FROM users WHERE email = :email AND pseudo = :pseudo";
    $request = $pdo->prepare($sql);
    $request->bindValue(':email', $email, PDO::PARAM_STR); // bindValue permet de lier une valeur à un marqueur de requête préparée (marqueur :email) et de spécifier le type de données à lier (PDO::PARAM_STR) et de sécuriser les données.
    $request->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $request->execute();
    $result = $request->fetch();
    return $result;
}

#### Afficher tous les utilisateurs dans le dashboard
function allUsers(): mixed
{
    $pdo = connexionBdd();
    $sql = "SELECT * FROM users";
    $request = $pdo->query($sql); // La méthode query permet d'exécuter une requête SQL. Elle prend en paramètre la requête SQL à exécuter.
    $result = $request->fetchAll(); // La méthode fetchAll récupère toutes les lignes à la fois et les retourne sous forme de tableau associatif.
    return $result;
}

#### Fonction pour mettre à jour le rôle de l'utilisateur

function updateUserRole(int $id, string $role): void
{
    $pdo = connexionBdd();
    $sql = "UPDATE users SET role = :role WHERE id_user = :id";
    $request = $pdo->prepare($sql);
    $request->bindValue(':role', $role, PDO::PARAM_STR);
    $request->bindValue(':id', $id, PDO::PARAM_INT);
    $request->execute();
}


function showUser(int $id): mixed
{
    $pdo = connexionBdd();
    $sql = "SELECT * FROM users WHERE id_user = :id";
    $request = $pdo->prepare($sql);
    // $request->bindValue(':id', $id, PDO::PARAM_INT);
    // $request->execute();
    $request->execute(array(':id' => $id));
    $result = $request->fetch();
    return $result;
}

function deleteUser(int $id): void
{
    $cnx = connexionBdd();
    $sql = "DELETE FROM users WHERE id_user = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(':id' => $id));
}


/*
                          ╔═════════════════════════════════════════════╗
                          ║                                             ║
                          ║                CATEGORIES                   ║
                          ║                                             ║
                          ╚═════════════════════════════════════════════╝ 
                          
*/
/*This is a PHP function named showCategories that retrieves a category from a database based on its name. It takes a string parameter $name, prepares and executes a SQL query to select all columns (*) from the categories table where the name column matches the input $name, and returns the result as a mixed type (e.g., an array or an object).
*/
function showCategories(string $name): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE nom_categorie = :name";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ":name" => $name
    ));
    $result = $request->fetch();
    return $result;
}

function getCategoryById(int $id): ?array
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE id_categorie = :id_categorie";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ":id_categorie" => $id
    ));
    $result = $request->fetch();

    return $result;
}





function showAllCategories(): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories";
    $request = $cnx->query($sql);
    // query envoie la requête SQL vers la base de données
    $result = $request->fetchAll();
    return $result;
}



function addCategory(string $name, string $description): void
{
    //sécuriser les deux variables
    $data = [
        "name" => $name,
        "description" => $description
    ];
    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    $cnx = connexionBdd();
    $sql = "INSERT INTO categories (nom_categorie, description) VALUES (:name, :description)";
    $request = $cnx->prepare($sql);
    $request->execute($data);
}


function deleteCategory(int $id): void
{
    $cnx = connexionBdd();
    $sql = "DELETE FROM categories WHERE id_categorie = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(':id' => $id));
}


##### Update category
//on a crée au début une fonction showCategoryViaId qui permet de recuperer la category via son id et on a crée une autre fonction updateCategory qui permet de modifier la category

function showCategoryViaId(int $id): mixed
{

    $cnx = connexionBdd();
    $sql = "SELECT * FROM categories WHERE id_categorie = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ":id" => $id
    ));
    $result = $request->fetch();
    return $result;
}

//on a crée une autre fonction updateCategory qui permet de modifier la category via son id 
function updateCategory(int $id, string $name, string $description): void
{
    $cnx = connexionBdd();
    $sql = "UPDATE categories SET nom_categorie = :name, description = :description WHERE id_categorie = :id";
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ":name" => $name,
        ":description" => $description,
        ":id" => $id
    ));
}

function categoryExist(string $name): array
{
    $cnx = connexionBdd();
    $sql = 'SELECT * FROM categories WHERE name = :name';
    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':name' => $name
    ));
    $result = $request->fetchAll();

    return $result;
}






/*
                          ╔═════════════════════════════════════════════╗
                          ║                                             ║
                          ║                FILM                         ║
                          ║                                             ║
                          ╚═════════════════════════════════════════════╝ 
                          
*/
// fonction pour l'insertion d un film auprès de l'utilisateur
function addFilm(int $category_id, string $title, string $director, string $actors, string $ageLimit, string $duration, string $synopsis, string $date, string $image, float $price, int $stock): void
{
    //création d'un tableau associatif
    $data = [
        //key => value
        'category_id' => $category_id,
        'title' => $title,
        'image' => $image,
        'director' => $director,
        'actors' => $actors,
        'ageLimit' => $ageLimit,
        'duration' => $duration,
        'date' => $date,
        'price' => $price,
        'stock' => $stock,
        'synopsis' => $synopsis
    ];

    //Echapper les données et les traiter contre les failles JS
    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); //ENT_QUOTES est une constante en PHP qui convertie les guillemets doubles et les guillemets simples en entités HTML. Exemple : la guillement simple se convertit en &#039; et la guillemet double se convertit en &quot;
    }
    //connextion à la base de données
    $pdo = connexionBdd();
    $sql = "INSERT INTO film ( category_id, title, director, actors, ageLimit, duration, synopsis, date, image,  price, stock) VALUES (:category_id, :title, :director, :actors, :ageLimit, :duration, :synopsis, :date, :image, :price, :stock)";
    $request = $pdo->prepare($sql); //prepare() est une méthode qui permet de préparer la requête sans l'exécuter. Elle contient un marqueur :firstName qui est vide et attend une valeur.
    $request->execute(array(
        ':category_id' => $data['category_id'],
        ':title' => $data['title'],
        ':director' => $data['director'],
        ':actors' => $data['actors'],
        ':ageLimit' => $data['ageLimit'],
        ':duration' => $data['duration'],
        ':synopsis' => $data['synopsis'],
        ':date' => $data['date'],
        ':image' => $data['image'],
        ':price' => $data['price'],
        ':stock' => $data['stock'],
    ));
}

function checkFilm($title, $director): mixed
{
    $pdo = connexionBdd();
    $sql = "SELECT * FROM film WHERE title = :title AND director = :director";
    $request = $pdo->prepare($sql);
    $request->bindValue(':title', $title, PDO::PARAM_STR); // bindValue permet de lier une valeur à un marqueur de requête préparée (marqueur :email) et de spécifier le type de données à lier (PDO::PARAM_STR) et de sécuriser les données.
    $request->bindValue(':director', $director, PDO::PARAM_STR);
    $request->execute();
    $result = $request->fetch();
    return $result;
}

//
function allFilm(): mixed
{
    $pdo = connexionBdd();
    $sql = "SELECT 
    id_film, 
    categories.nom_categorie AS genre,
    title,
    director,
    actors,
    ageLimit,
    duration,
    synopsis,
    date,
    image,
    price,
    stock
    FROM film
    INNER JOIN categories ON film.category_id = categories.id_categorie";
    $request = $pdo->prepare($sql);
    $request->execute();
    $result = $request->fetchAll();
    return $result;
}


//update film
function updateFilm(int $id_film, int $category_id, string $title, string $director, string $actors, string $ageLimit, string $duration, string $synopsis, string $date, string $image, float $price, int $stock): void
{
    $cnx = connexionBdd();
    $sql = "UPDATE film SET 
    category_id = :category_id,
    title = :title, 
    director =:director,
    actors = :actors,
    ageLimit = :ageLimit,
    duration = :duration,
    synopsis = :synopsis,
    date = :date,
    image = :image,
    price = :price,
    stock = :stock
    WHERE id_film = :id_film";

    $request = $cnx->prepare($sql);
    $request->execute(array(
        ':category_id' => $category_id,
        ':title' => $title,
        ':director' => $director,
        ':actors' => $actors,
        ':ageLimit' => $ageLimit,
        ':duration' => $duration,
        ':synopsis' => $synopsis,
        ':date' => $date,
        ':image' => $image,
        ':price' => $price,
        ':stock' => $stock,
        ':id_film' => $id_film
    ));
}

//show film
function getFilmById(int $id_film): mixed
{
    $cnx = connexionBdd();
    $sql = "SELECT * FROM film
    WHERE id_film = :id_film
    ";
    $request = $cnx->prepare($sql);
    // query envoie la requête SQL vers la base de données
    $request->execute(array(
        ":id_film" => $id_film
    ));
    $result = $request->fetch();
    return $result;
}


// Delete film
function deleteFilm($id_film): void
{
    $cnx = connexionBdd();
    $sql = "DELETE FROM film WHERE id_film = :id_film";
    $request = $cnx->prepare($sql);
    $request->execute([':id_film' => $id_film]);
}

function getAllFilms(): array
{
    $cnx = connexionBdd();
    $sql = 'SELECT * FROM film';
    $request = $cnx->query($sql);
    $result = $request->fetchAll();
    return $result;
}

function getSixFilms(): array
{
    $cnx = connexionBdd();
    $sql = 'SELECT * FROM film LIMIT 6';
    $request = $cnx->query($sql);
    $result = $request->fetchAll();
    return $result;
}
