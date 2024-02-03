<?php
    $data = json_decode( file_get_contents( 'php://input' ), true );

    $data_sel = $data["task_sel"];

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

    $req=  'DELETE FROM task WHERE task.Nom = :task_sel';

    $response = $bdd->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $response->execute(array(':task_sel' => $data_sel));

    $response->closeCursor(); // Termine le traitement de la requête

    
?>