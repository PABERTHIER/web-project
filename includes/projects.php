<?php
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
            FROM project';

    $reponse = $bdd->query($req);

    while ($donnees = $reponse->fetch())
    {
        echo($donnees["Nom"].",");
    }

    $reponse->closeCursor(); // Termine le traitement de la requête
    
?>