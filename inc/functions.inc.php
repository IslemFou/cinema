<?php
/* ------------ Constante pour défninir le chemin du site ------------ */
define("RACINE_SITE", "http://localhost/cinema/");

/* ------------ Fonction alert ------------ */
function alert(string $contenu, string $class="warning") : string// type prend une classe bootstrap
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
define("DBUSER","root");

// // constante pour le mot de passe de serveur en local => pas de mot de passe
define("DBPASS",""); 

// // Constante pour le nom de la BDD
define("DBNAME", "cinema");





/* --------------------------------
-----------------------------------------------------------------------
Création d'une fonction pour se connecter à la base de donnée
-------------------------------------------------------------------------------------------------
--------------------------------
*/

function connexionBdd() : object 
{
//DSN (Data Source Name):
//$dsn = mysql:host=localhost;dbname=entreprise;charset=utf8;
 $dsn = "mysql:host=".DBHOST.";dbname=".DBNAME.";charset=utf8";

//Grâce à PDP on peut lever une exception (une erreur) si la connexion à la BDD ne se réalise pas(exp: suite à une faute au niveau du nom de la BDD) et par la suite si elle cette erreur est capté on lui demande d'afficher une erreur

     try{ // dans le try on vas instancier PDO, c'est créer un objet de la classe PDO (un élment de PDO)
          // Sans la variable dsn les constatntes d'environnement
          // $pdo = new PDO('mysql:host=localhost;dbname=entreprise;charset=utf8','root','');
           $pdo = new PDO($dsn, DBUSER, DBPASS); 
          //On définit le mode d'erreur de PDO sur Exception
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          // POUR SAHAR:  cet atribut est à rajouter après le premier fetch en bas 
               //On définit le mode de "fetch" par défaut
               $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
          // je vérifie la connexion avec ma BDD avec un simple echo
           echo "Je suis connecté à la BDD";
     }
     catch(PDOException $e){  // PDOException est une classe qui représente une erreur émise par PDO et $e c'est l'objetde la clase en question qui vas stocker cette erreur

          die("Erreur : " .$e->getMessage()); // die d'arrêter le PHP et d'afficher une erreur en utilisant la méthode getmessage de l'objet $e
     }
     return $pdo ; // on retourne la connexion à la BDD , un objet 
    }

     //le catch sera exécuter dès lors on aura un problème da le try

// À partir d'ici on est connecté à la BDD et la variable $pdo est l'objet qui représente la connexion à la BDD, cette variable va nous servir à effectuer les requêtes SQL et à interroger la base de données 
// debug($pdo);
//debug(get_class_methods($pdo)); // permet d'afficher la liste des méthodes présentes dans l'objet $pdo.



// ---------------------- table categories ----------------------
function createTableCategories():void 
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
function createTableFilm():void 
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
function createTableUsers():void 
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
function foreignkey(string $tableFK, string $keyFK, string $tablePK, string $keyPK):void
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
foreignkey('film', 'category_id', 'categories', 'id_categorie');






?>