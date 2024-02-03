<?php
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $birth_date = $_POST['birth_date'];
    $mail = $_POST['mail'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $admin = $_POST['admin'];

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

    try{
        $req = "INSERT INTO user(Nom, Prenom, Date_Naissance, Mail, Login, Password, Admin) VALUES ('$last_name','$first_name','$birth_date','$mail','$login','$password', '$admin')";
        //echo $req;
        $bdd->exec($req);
        echo("Redirection to the Home page");
    }
    catch(Exception $e)
    {
        // En cas d'erreur, on affiche un message et on arrête tout
         echo('Erreur : '.$e->getMessage());
    }

?>