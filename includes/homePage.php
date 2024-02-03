<?php
    $user = $_POST['user'];
    $user = "\"".$user."\"";
    $back = "";
    $donnees = NULL;

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
    
    // On récupère tout le contenu de la table project
    $req=  'SELECT project.Nom
            FROM project
            INNER JOIN manage ON manage.ref_project = project.id_ref
            INNER JOIN user ON user.id_user = manage.ref_user
            WHERE user.Login = '.$user;

    $reponse = $bdd->query($req);

    while ($donnees = $reponse->fetch())
    {
        echo($donnees["Nom"].",");
    }

    $reponse->closeCursor(); // Termine le traitement de la requête
    
?>