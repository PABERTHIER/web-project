<?php
    $data = json_decode( file_get_contents( 'php://input' ), true );
    $project_sel = $data["project_sel"];
    $true_tab = $data["state_true"];
    $false_tab = $data["state_false"];
    
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
    $req=  'SELECT DISTINCT user.Nom FROM user INNER JOIN manage ON manage.ref_user = user.id_user INNER JOIN project ON project.id_ref = manage.ref_project WHERE project.Nom = :project_name';

    $var = $bdd->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $var->execute(array(':project_name' => $project_sel));



    $sql_return = array();
    while($response = $var->fetch()){
        array_push( $sql_return, $response["Nom"]);
    }

    foreach($true_tab as &$data){
        $test_true = false;
        foreach($sql_return as &$data_name){
            if($data == $data_name){
               $test_true = true; 
            }
        }
        if(!$test_true){
            $req = 'INSERT INTO manage(ref_user, ref_project) SELECT user.id_user, project.id_ref FROM user, project WHERE project.Nom = :project_sel AND user.Nom = :user_check';
                $inject = $bdd->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $inject->execute(array( ':project_sel' => $project_sel,
                                        ':user_check' => $data
                                        ));
        }
    }

    foreach($false_tab as &$data){
        $test_false = false;
        foreach($sql_return as $data_name){
            if($data == $data_name){
               $test_false = true; 
            }
        }
        if($test_false){
            $req = 'DELETE manage.* FROM manage INNER JOIN user ON manage.ref_user = user.id_user INNER JOIN project ON manage.ref_project = project.id_ref WHERE project.Nom = :project_sel AND user.Nom = :user_check';
            $inject = $bdd->prepare($req, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $inject->execute(array( ':project_sel' => $project_sel,
                                    ':user_check' => $data
                                    ));
        }
    }
    

    $response = array('result' => "Manage Actualize");
    echo(json_encode($response));

?>