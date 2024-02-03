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
    $req=  'SELECT user.Nom FROM user INNER JOIN manage ON manage.ref_user = user.id_user INNER JOIN project ON project.id_ref = manage.ref_project WHERE project.Nom = :project_name';

    $var = $bdd->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $var->execute(array(':project_name' => $project["project_sel"]));


    $tab_return = array();
    while($response = $var->fetch()){
        array_push( $tab_return, array(
            'Nom' => $response["Nom"]
        ));
    }

    $data_return = json_encode($tab_return);
    echo($data_return);

?>