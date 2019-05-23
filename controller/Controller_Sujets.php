<?php

class Controller_Sujets extends BaseControleur
{
    public function traite(array $params)
    {
        //déterminer une vue par défaut (à faire plus tard)
        $vue = "";
     
        if(isset($params["action"]))
        {
            switch($params["action"])
            {
                //***************************************************************
                //SECTION insertion d'un sujet
                //***************************************************************
                case "formInsereSujet":
                    $this->afficheFormAjoutSujet();
                    break;
                case "insereSujet":
                    $messageForm = "";
                    $insertOK = FALSE;
                    if(isset($params["titre"], $params["texte_sujet"]))
                    {
                        //j'ai reçu les paramètres, j'arrive probablement du formulaire
                        $messageForm = $this->valideFormAjoutSujet($params["titre"], $params["texte_sujet"]);
                        
                        if($messageForm == "")
                        {
                            //les paramètres sont valides

                            $leSujet = new Sujets(0, $params["titre"], $params["texte_sujet"], date("Y-m-d H:i:s"),$_SESSION["username"]);
                            $modeleSujets = $this->getDAO("Sujets");
                            $succes = $modeleSujets->sauvegarde($leSujet);
                            
                            if($succes)
                            {
                                $messageForm = "Insertion réussie.";
                                $insertOK = TRUE;
                            }
                            else
                            {
                                //ça n'a pas fonctionné... refaire l'entrée
                                $messageForm = "Erreur lors de l'ajout...";
                            }
                        }         
                    }
                    
                    $this->afficheVue("header");
                    if($insertOK){
                        //echo $messageForm;
                        $this->afficheListeSujets($messageForm);
                    }
                    else{
                        echo $messageForm;
                        $this->AfficheFormAjoutSujet($messageForm);
                    }
                    $this->afficheVue("footer");
                    break;
                //***************************************************************
                //SECTION suppression d'un sujet
                //***************************************************************
                case "supprimeSujet":
                    if(isset($_GET["id"])){
                        //Pour supprimer aussi les réponse correspondante. À faire avant le Sujets pour intégrité de base de donnée
                        $modeleReponse = $this->getDAO("Reponse");
                        $modeleReponse->supprimerReponse($_GET["id"]);
                        $modeleSujets = $this->getDAO("Sujets");
                        $modeleSujets->supprimer($_GET["id"]);
                    }
                    $this->affichageParDefault();
                    break;
                //***************************************************************
                //SECTION authentification
                //***************************************************************
                case "login":
                    if(isset($_POST["username"]) && isset($_POST["password"])) {
                        $this->login($_POST["username"], $_POST["password"]);
                    }
                    //Retour à la page d'acceuil
                    $this->affichageParDefault();
                    break;
                case "logout":
                    $this->logout();
                    //Retour à la page d'acceuil
                    $this->affichageParDefault();
                    break;
                //***************************************************************
                //SECTION EXTRA pager
                //***************************************************************
                case "choixNbPages":
                    if(isset($_POST["nbPages"])){
                        $_SESSION["nbPages"] = $_POST["nbPages"];
                        switch ($_POST["nbPages"]){
                            case "3":
                            case "5":
                            case "10":
                            case "20":
                                //Affichage spécial
                                $this->affichageParDefault($_SESSION["nbPages"]);
                                break;
                            default:
                                //Retour à la page d'acceuil(defaut étant tous les posts)
                                $this->affichageParDefault();

                        }
                    }
                    //Retour à la page d'acceuil si pas de POST
                    $this->affichageParDefault();
                    break;
                case "changePage":
                    //On se sert des variables session pour conserver le choix utilisateur
                    $this->affichageParDefault($_SESSION["nbPages"],$_GET["page"]);
                    break;
                default:
                    trigger_error("Action invalide.");
            }
        }
        else
        {
            //action du controleur à effectuer par défaut si aucune action d'envoyer(index.php suivi de rien)
            //On initialise la variable $session du pager. On aurait pu aussi la mettre à "Tous" ou appeler avec paramètre.
            if(isset($_SESSION["nbPages"]))
            {
                unset($_SESSION["nbPages"]);
            }
            $this->affichageParDefault();
        }
        
    }
    //***************************************************************
    //SECTION affichage centrale. On se sert de paramètres pour le pager
    //***************************************************************
    private function afficheListeSujets($message = "", $nbPages = NULL, $page = NULL)
    {
        $donnees["message"] = $message;
        $modeleSujets = $this->getDAO("Sujets");
        $donnees["sujets"] = $modeleSujets->obtenir_tous_les_sujets($nbPages, $page);
        //***********EXTRA: pour le pager donc 2 requètes à obtenir_tous_les_sujets. Ici sans paramètre.
        $donnees["nombreDeSujet"] = count($modeleSujets->obtenir_tous_les_sujets());
        //**********EXTRA: donne le compte
        //Ajoute la possibilité d'avoir le nombre de compte de sujets par usagers
        $modeleUsagers = $this->getDAO("Usager");
        $donnees["compteSujetsParUsagers"] = $modeleUsagers->compteSujetsUsagers();
        //Pour savoir le nombre de réponse par sujets
        $modeleReponse = $this->getDAO("Reponse");
        $donnees["compteReponseParSujet"] = $modeleReponse->compteNbReponse();
        //*** essai pour ne pas appeler le modèle via la vue...(requête à vérifier
        $modeleReponse = $this->getDAO("Reponse");
        $donnees["reponseRecenteDuSujet"] = $modeleReponse->reponseRecenteDuSujet();

        $this->afficheVue("AfficheListeSujets", $donnees);
    }

    //***************************************************************
    //SECTION affichage pour ajouter un sujet
    //***************************************************************
    private function afficheFormAjoutSujet($erreurs = "")
    {
        $this->afficheVue("header");
        $donnees["erreurs"] = $erreurs;
        $this->afficheVue("formAjoutSujet",$donnees);
        $this->afficheVue("footer");
    }

    //***************************************************************
    //SECTION validation
    //***************************************************************
    private function valideFormAjoutSujet($titre, $texte)
    {
        $erreurs = "";
        
        $titre = trim($titre);
        $description = trim($texte);
        if($titre == "")
            $erreurs .= "Le titre ne peut être vide.<br>";
        
        if((strlen($titre) > 250) || (strlen($texte) > 250))
            $erreurs .= "Le titre ne doit pas dépasser 250 caractères.<br>";
        
        if($texte == "")
            $erreurs .= "Le texte ne peut être vide.<br>";
        
        return $erreurs;
    }
    //Permet de protéger l'accès via l'affichage par défaut et ainsi mettre le login dans l'en-tête
    private function affichageParDefault($nbPages = NULL, $page = NULL){
        $this->afficheVue("header");
        if(isset($_SESSION["username"])){
            if((isset($_SESSION["banni"])) && ($_SESSION["banni"])){
                echo "<h3>Vous êtes banni. Contactez l'admistrateur pour être réactivé.</h3>";
            }
            else{
                if(isset($nbPages)){
                    $this->afficheListeSujets("", $nbPages, $page);
                }
                else{
                    //$_SESSION["nbPages"] = "Tous";
                    $this->afficheListeSujets();
                }
            }
        }
        else{
            echo "<h3>Vous devez être connecté pour accéder à ce forum.</h3>";
        }
        $this->afficheVue("footer");
    }
}
?>