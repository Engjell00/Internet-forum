<?php
    //define("RACINE", $_SERVER["DOCUMENT_ROOT"] . "/Prog4_TP_final/");
    //define("RACINE", "/Prog4_TP_final/");
    define("RACINE", "");
    //définition des constantes de connexion à la base de données
    define("DBTYPE", "mysql");

    //Règle le fuseau horaire pour l'insertion de la date et heure courante
    define('TIMEZONE', 'America/New_York');
    date_default_timezone_set(TIMEZONE);

//REMIX DE LA VERSION MYSQLI EN PDO
// Le problème de lower_case_table_names... Dépendamment du setting de MY.INI il y a un risque de problème de "CASE" donc tout en minuscule avec underscore.

//Pour webDev on va chercher les infos de connection
//va chercher l'info dans le fichier de webdev .my.cnf
$fichierWebDev = "../.my.cnf";

if (file_exists($fichierWebDev)) {
    //Si OUI on est sur WebDev
    //OBLIGER D'APPELER LA BASE DE DONNÉES avec le no etudiant à cause de WebDev
    $infoIni = parse_ini_file($fichierWebDev);
    define("DBNAME", $infoIni["user"]);
    define("HOST", $infoIni["host"]);
    define("USER", $infoIni["user"]);
    define("PWD", $infoIni["password"]);
    define("WEBDEV", TRUE);
} else {
    //Si NON on est en local
    define("DBNAME", "prog4tpfinal");
    define("HOST", "localhost");
    define("USER", "root");
    define("PWD", "");
    define("WEBDEV", FALSE);
}

    //définition de la fonction d'autoload
    function mon_autoloader($classe)
    {
        $repertoires = array(RACINE . "controller/",
                            RACINE . "model/",
                            RACINE . "view/");
        
        foreach($repertoires as $rep)
        {
            if(file_exists($rep . $classe . ".php"))
            {
                require_once($rep . $classe . ".php");
                return;
            }
        }
    }

    spl_autoload_register("mon_autoloader");
?>