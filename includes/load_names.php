<?php
    $project = json_decode( file_get_contents( 'php://input' ), true );
    
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
    $req=  'SELECT user.Nom, user.Prenom FROM user';

    $var = $bdd->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $var->execute();


    $tab_return = array();
    while($response = $var->fetch()){
        array_push( $tab_return, array(
            'Nom' => $response["Nom"],
            'Prenom' => $response["Prenom"]
        ));
    }

    $data_return = json_encode($tab_return);
    echo($data_return);

?>