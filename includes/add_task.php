<?php
    $project = json_decode( file_get_contents( 'php://input' ), true );

    $project_sel = $project["project_sel"];
    $task_name = $project["task_name"];
    $task_content = $project["task_content"];
    $task_vote = 0;
    $task_importance = 0;

    $id_project=null;

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

    $req=  'SELECT project.id_ref FROM project WHERE project.Nom = :project_sel';

    $response = $bdd->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $response->execute(array(':project_sel' => $project["project_sel"]));

    while ($donnees = $response->fetch())
    {
        $id_project=$donnees["id_ref"];
    }

    $response->closeCursor(); // Termine le traitement de la requête

    try{
        $req = "INSERT INTO task(Nom, Contenue, Importance, Vote, ref_projet) VALUES (:task_name,:task_content,:importance,:vote,:project_sel)";
        $inject = $bdd->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $inject->execute(array( ':task_name' => $task_name,
                                ':task_content' => $task_content,
                                ':importance' => $task_importance,
                                ':vote' => $task_vote,
                                ':project_sel' => $id_project
                                ));
    }
    catch(Exception $e)
    {
        // En cas d'erreur, on affiche un message et on arrête tout
         echo('Erreur : '.$e->getMessage());
    }

?>