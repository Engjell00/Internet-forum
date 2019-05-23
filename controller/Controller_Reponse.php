<?php
class Controller_Reponse extends BaseControleur
{
    public function traite(array $params)
    {
        if(isset($params["action"]))
        {
            switch($params["action"])
            {
                //Afficher le sujet avec les réponses//
                case "affiche":
                    if(isset($params["id"]))
                    {
                        $modeleSujets = $this->getDAO("Sujets");
                        $donnees["sujets"] = $modeleSujets->obtenir_par_id($params["id"]);
                        if($donnees["sujets"]) {
                            $modeleReponse = $this->getDAO("Reponse");
                            $donnees["reponse"] = $modeleReponse->obtenir_reponse_par_sujet($params["id"]);
                            $vue = "AfficheSujetAvecReponse";
                            $this->afficheVue("header");
                            $this->afficheVue($vue, $donnees);
                            $this->afficheVue("footer");
                        }
                        else
                        {
                            trigger_error("Pas de sujets");
                        }
                    }
                    else
                    {
                        trigger_error("Pas de réponse; des réponses et sujets");
                    }
                    break;
                  //La forme pour écrire une réponse au aujets
                case "FormReponseSujet":
                    $this->afficheFormReponseSujet();
                break;
                //Insérer la réponse dans la BD
                case "insererLaReponse":
                    $messageForm = "";
                    $insertOK = FALSE;
                    if(isset($params["titre_reponse"], $params["texte_reponse"]))
                    {
                        $messageForm = $this->valideFormAjoutReponse($params["titre_reponse"], $params["texte_reponse"]);

                        if($messageForm == "")
                        {
                           $laReponse = new Reponse(0, $params["titre_reponse"], $params["texte_reponse"],date("Y-m-d H:i:s"), $params["id"],$_SESSION["username"]);
                           $modeleReponse = $this->getDAO("Reponse");
                            $succes =  $modeleReponse->sauvegarde($laReponse);
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

                        $modeleSujets = $this->getDAO("Sujets");
                        $donnees["sujets"] = $modeleSujets->obtenir_par_id($params["id"]);
                        $modeleReponse = $this->getDAO("Reponse");
                        $donnees["reponse"] = $modeleReponse->obtenir_reponse_par_sujet($params["id"]);
                        $vue = "AfficheSujetAvecReponse";
                        $this->afficheVue("header");
                        $this->afficheVue($vue, $donnees);
                        $this->afficheVue("footer");
                    }
                    else{
                        echo $messageForm;
                        $this->afficheFormReponseSujet($messageForm);
                    }
                    $this->afficheVue("footer");
                break;
                default:
                    trigger_error("Action invalide.");
            }
        }
        else
        {
            $this->affichageParDefault();
        }

    }
    private function afficheFormReponseSujet($erreurs = "")
    {
        $this->afficheVue("header");
        $donnees["erreurs"] = $erreurs;
        $this->afficheVue("formAjoutReponse",$donnees);
        $this->afficheVue("footer");
    }
    private function affichageParDefault(){
        $this->afficheVue("header");
        if(isset($_SESSION["username"])){
            if((isset($_SESSION["banni"])) && ($_SESSION["banni"])){
                echo "<h3>Vous êtes banni. Contactez l'admistrateur pour être réactivé.</h3>";
            }
            else{
                $this->afficheListeSujets();
            }
        }
        else{
            echo "<h3>Vous devez être connecté pour accéder à ce forum.</h3>";
        }
        $this->afficheVue("footer");
    }
    private function valideFormAjoutReponse($titre, $texte)
    {
        $erreurs = "";

        $titre = trim($titre);
        $texte = trim($texte);
        if($titre == "")
            $erreurs .= "Le titre ne peut être vide.<br>";

        if((strlen($titre) > 250) || (strlen($texte) > 250))
            $erreurs .= "Le titre ne doit pas dépasser 250 caractères.<br>";

        if($texte == "")
            $erreurs .= "Le texte ne peut être vide.<br>";

        return $erreurs;
    }
}
?>
