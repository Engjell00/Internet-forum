<?php
/**
 * Surnom: Tomtom
 * Date: 2018-09-29
 * Heure: 07:34
 * Nom du fichier : header.php
 * Projet : TP_final
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="description" content="1365422 7532266">
        <meta name="author" content="Engjell Bislimi et Christian Cayer">
        <title>Tp final - prog 3 - session 4</title>
        <link rel="icon" href="img/LogoTomtom.ico" />
<!--        <link rel="stylesheet" href="css/normalize.css">-->
        <link rel="icon" src="jpg/LogoTomtom.ico" />
        <link rel = "stylesheet" type = "text/css" href="css/colorTomS2.css" />
        <link rel = "stylesheet" type = "text/css" href = "css/posTomS2.css" />
        <link rel = "stylesheet" type = "text/css" href = "css/login.css" />
        <link rel = "stylesheet" type = "text/css" href = "css/table.css" />
    </head>
    <body>
    <header>
    <!--Partie gauche-->
    <div class="enTete1">
        <a href='index.php?Sujets'><img class="logo" src="img/logoS4.png" alt="logo élève"></a>

    </div>
    <!--Partie droite-->
    <div class="enTete2">
        <h1>No. Étudiant : 1365422 Engjell Bislimi et 7532266, Christian Cayer</h1>
        <h2>582-P41-MA - PROGRAMMATION WEB DYNAMIQUE 3<br>Goupe 16611 - session 4 - TP final</h2>
    </header>
        <div class="headerLogin">
                <form action="index.php" method="POST">
                    <p>Pour login (admin:admin, banni:banni, toto:toto, Guillaume:Harvey, harvey:1234)</p>
                <?php
                if(isset($_SESSION["username"])) {
                    echo "<input type='hidden' name='action' value='logout'/>";
                    echo "Bienvenue " . $_SESSION["username"] . ". ";
                    if($_SESSION["admin"]){
                        echo "<span style='color:red'>Vous êtes administrateur.</span>";
                        echo " Accès <a href='index.php?Usager&action=adminPage'>administrateur</a> ";
                    }
                    if($_SESSION["banni"]) echo "<span style='color:red'>Vous êtes banni.</span>";
                    echo "<button type='submit' name='connecter' accesskey='d'>Déconnecter</button>";
                }
                else{
                    echo "<label for='usernameLabel'>Nom d'utilisateur : <input id='usernameLabel' type='text' placeholder='nom utilisateur' name='username'></label>";
                    echo "<label for='passwordLabel'>Mot de passe : <input id='passwordLabel' type='password' placeholder='mot de passe' name='password' ></label>";
                    echo "<input type='hidden' name='action' value='login'/>";
                    echo "<button type='submit' name='connecter'  accesskey='c'>Connecter</button>";
                }
                ?>
            </form>

        </div>

    <h1>Forum avec Architecture MVC</h1>
<hr>