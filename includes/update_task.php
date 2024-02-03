<?php
    $data = json_decode( file_get_contents( 'php://input' ), true );

    $data_send = $data["task_sel"];
    $data_type = $data["type"];
    $data_value = $data["value"];

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

    if($data_type == "Importance"){
        $req=  'UPDATE task SET Importance = :value_send WHERE Nom = :task_sel';

        $response = $bdd->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $response->execute(array(   ':value_send' => $data_value,
                                    ':task_sel' => $data_send));

        $response->closeCursor(); // Termine le traitement de la requête
    }
    else if ($data_type == "Vote"){
        $req=  'UPDATE task SET Vote = :value_send WHERE Nom = :task_sel';

        $response = $bdd->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $response->execute(array(   ':value_send' => $data_value,
                                    ':task_sel' => $data_send));

        $response->closeCursor(); // Termine le traitement de la requête
    }
    else{
        echo("Error !");
    }
    
?>