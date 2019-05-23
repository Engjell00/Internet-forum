<?php

    class Routeur
    {
        public static function route()
        {
            //Après l'index c'est la première ligne dans le code
            //toutes les pages qui utilisent les variables sessions doivent avoir ceci comme première instruction, en haut, avant TOUTE FORME DE HTML OU D'OUTPUT
            session_start();

            //obtenir la chaine de la requête (ex : Films&action=liste)
            $queryString = $_SERVER["QUERY_STRING"];
            $posEperluette = strpos($queryString, "&");
            
            //définir un controleur par défaut (à faire plus tard)
            $controleur = "";   
            
            if($posEperluette === false)
            {
                $controleur = $queryString;
            }
            else
            {
                $controleur = substr($queryString, 0, $posEperluette);
            }
            
            //si aucun contrôleur n'a été spécifié dans la querystring, mettre un contrôleur par défaut
            if($controleur == "")
                $controleur = "Sujets";
            
            //on a déterminé le controleur
            $classe = "Controller_" . $controleur;
            //on en crée une instance si la classe existe
            if(class_exists($classe))
            {
                $objetControleur = new $classe;
                if($objetControleur instanceof BaseControleur)
                {
                    $objetControleur->traite($_REQUEST);
                }
                else
                    trigger_error("Controleur invalide.");
            }
            else
            {
                trigger_error("Le controleur $classe n'existe pas.");
            }
        }
    }





