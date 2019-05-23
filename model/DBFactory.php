<?php

class DBFactory
{
    public static function getDB($typeBD, $dbName, $host, $user, $pwd)
    {
        if($typeBD == "mysql")
        {
            //$laDB = new PDO("mysql:host=$host;dbname=$dbName", $user, $pwd);
            //On test d'abord la présence de MySQL et de la validité du user et password
            try{
                $laDB = new PDO( "mysql:host=$host", $user, $pwd );
            }
            catch(PDOException $e) {
                //Il faut passer par une variable temporaire pour sortir le message en UTF-8
                //$message = $e->getMessage();
                die("MySQL n'est pas en fonction ou vous n'êtes pas autoriser à vous connecter à la base de donnée avec ce nom de connection.<br>");
            }
        }
        else if($typeBD == "oracle")
        {
            $laDB = new PDO("'oci:host=" . HOST . ";dbname=" . DBNAME . "'", USER, PWD);
        }
        else
            trigger_error("Le type de BD spécifié n'est pas supporté.");
        //else if...

        $laDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $laDB->exec("SET NAMES 'utf8'");
        //*************Extra: non requis au devis*****************
        //En suite on teste la présence de la base de donnée
        //Pas de try catch. Juste des die avec echo(TO DO list si on a du temps)
        $sqlDB = "USE " . DBNAME;
        try{
            $laDB->exec($sqlDB);
        }
        catch (Exception $e) {
            //Sous WEBDEV on ne peut pas créer de base de données donc arret obligatoire
            if (WEBDEV) {
                echo "<h2>Votre base de donnée " . DBNAME . " n'existe pas sous WEBDEV.</h2><p>Elle devrait avoir votre numéro d'étudiant.</p>";
                die;
            }
            //Création du schéma en local
            else {
                //$message = $e->getMessage();
                $sqlDB2 = "CREATE SCHEMA " . DBNAME;
                //$laDB->exec($sqlDB2);
                //Pour le cadre du TP on arrête tout si erreur
                try {
                    $laDB->exec($sqlDB2);
                }
                catch(PDOException $e){
                    echo "<h2>Votre base de donnée " . DBNAME . " na pu être créée.</h2><p>Vérifier vos droits pour la création.</p>";
                    die;
                }
                //ici pas de détection. Om prend pour acquis que tout est correct en local
                $laDB->exec($sqlDB);
            }
        }
         //************************À cet endroit dans le code on doit absolument avoir réussi la connection à la base de donnée sinon le code s'est arrêté

        //***************************************************************
        //Test de présence des tables
        //***************************************************************
        try {
            $resultatTablePresent = $laDB->query("SELECT 1 FROM sujets LIMIT 1");
        } catch (Exception $e) {
                //****************Insérer le nom du ficher contenant la requête voulu***********
                $fichier = 'model/create_table.sql';
                if($fichierSQL = fopen($fichier,"r")){
                    $sqlCreateTable = "";
                    //***** Les deux fonctionnent****
                    //V1
                    $sqlCreateTable = file_get_contents($fichier);
                    //V2
                    //while (!feof($fichierSQL)){
                    //$sqlCreateTable .= fgets($fichierSQL,9999);
                    //}
                    //fclose($fichierSQL);
                    try{
                        $laDB->exec($sqlCreateTable);
                        echo("La base de donnée a été créée pour une première utilisation.<br>");
                    }
                    catch(PDOException $e) {
                        echo $e->getMessage();
                    }
                }
                else{
                    echo("Le fichier $fichier n'a pas été trouvé.<br>");
                }
            }
        return $laDB;
    }
}
?>