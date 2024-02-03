<!DOCTYPE html>
<html>
    <head>
        <title>Informations utilisateur</title>
    </head>
    <body>
        <h1>Informations sur les utilisateurs</h1>
    </body>
</html>

<script type="text/javascript" src="scripts/test.js"></script>

<?php
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

// On récupère tout le contenu de la table jeux_video
$reponse = $bdd->query('SELECT * FROM user');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>
    <hr>
    <p>
    <strong>Nom</strong> : <?php echo $donnees['Nom']; ?><br />
    <strong>Prenom</strong> : <?php echo $donnees['Prenom']; ?><br />
    <strong>Date de naissance</strong> : <?php echo $donnees['Date_Naissance']; ?><br /><br />
    <strong>Mail</strong> : <?php echo $donnees['Mail']; ?><br />
    <strong>Login</strong> : <?php echo $donnees['Login']; ?><br />
    <strong>Password</strong> : <?php echo $donnees['Password']; ?><br /><br />
    <strong>Administrateur</strong> : <?php echo $donnees['Admin']; ?><br />
   </p>
   <hr>
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête

?>
<?php
// On récupère tout le contenu de la table Projet
$reponse = $bdd->query('SELECT * FROM project');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>
    <hr>
    <p>
    <strong>Nom</strong> : <?php echo $donnees['Nom']; ?><br />
    <strong>Date de début</strong> : <?php echo $donnees['Date_Début']; ?><br />
    <strong>Nombre de tâches</strong> : <?php echo $donnees['Nombre_taches']; ?><br />
   </p>
   <hr>
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête

?>