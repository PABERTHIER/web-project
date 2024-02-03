<?php
    $project = json_decode( file_get_contents( 'php://input' ), true );

    $project_sel = $project["project_sel"];
    $admin = $project["admin"];
    $tab = null;

    $today = date("Y-m-d"); 

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
    if($admin == "true"){
        try{
            $req = "INSERT INTO Project(Nom, Date_Début) VALUES (:project_sel,:date_sel)";
            $inject = $bdd->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $inject->execute(array( ':project_sel' => $project_sel,
                                    ':date_sel' => $today
                                    ));
        }
        catch(Exception $e)
        {
            // En cas d'erreur, on affiche un message et on arrête tout
            echo('Erreur : '.$e->getMessage());
        }
        $response = array('result' => "Project Created");
        echo(json_encode($response));
    }else{
        $response = array('result' => "Not login as administrator");
        echo(json_encode($response));
    }

?>