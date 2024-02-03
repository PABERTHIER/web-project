<?php
    $name = $_POST['user'];
    $password = $_POST['password'];

    try
    {
        // On se connecte à MySQL
        $bdd = new PDO('mysql:host=localhost;dbname=swidea;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
        // En cas d'erreur, on affiche un message et on arrête tout
         die('Erreur : '.$e->getMessage());
    }
    
    // Si tout va bien, on peut continuer
    
    // On récupère tout le contenu de la table jeux_video
    $reponse = $bdd->query('SELECT * FROM user');
    
    // On affiche chaque entrée une à une
    $result=false;
    $database_user=null;
    $database_password=null;
    $database_admin=null;

    while ($donnees = $reponse->fetch())
    {
        if($name == $donnees['Login'] && $password == $donnees['Password']) {
            $result=true;
            $database_admin=$donnees['Admin'];
        }
    }
    
    $reponse->closeCursor(); // Termine le traitement de la requête
    
    if($result == true) {
        echo($database_admin);
    } else {
        echo "Error : impossible to authenticate";
    }
    
?>