<?php

class Controller_Usager extends BaseControleur
{
    public function traite(array $params)
    {
        if (isset($params["action"])) {
            switch ($params["action"]) {
                //***************************************************************
                //accès admin
                //***************************************************************
                case"adminPage":
                    if ((isset($_SESSION["username"])) && $_SESSION["admin"]) {
                        $this->affichePageAdmin();
                    } else {
                        //Retour à la page d'acceuil si pas admin
                        $this->affichageParDefault();
                    }
                    break;
                // Changement de statut des usagers par l'administrateur
                case "enregistreStatutUsagers":
                    if ((isset($_SESSION["username"])) && $_SESSION["admin"]) {
                        $modeleUsagers = $this->getDAO("Usager");
                        if (isset($_POST["USER"])) {
                            $message = "<ul>";
                            foreach ($_POST['USER'] as $usernameBanni => $bouttonRadio) {
                                $donnees = $modeleUsagers->obtenir_par_id($usernameBanni);
                                //modifier l'objet seulement si changement de statut
                                $utilisateurBanni = $donnees->getBanni(); //Pour clarté du code
                                if (($bouttonRadio === "actif") && $utilisateurBanni) {
                                    $donnees->setBanni(false);
                                    $resultat = $modeleUsagers->sauvegarde($donnees);
                                    if($resultat){
                                        $message .= "<li>Utilisateur " . $donnees->getUsername() . " maintenant actif</li>";
                                    }
                                } elseif (($bouttonRadio === "banni") && !$utilisateurBanni) {
                                    $donnees->setBanni(true);
                                    $resultat = $modeleUsagers->sauvegarde($donnees);
                                    if($resultat) {
                                        $message .= "<li>Utilisateur " . $donnees->getUsername() . " maintenant banni</li>";
                                    }
                                }
                                $message .= "</ul>";
                            }
                        }
                        $this->affichePageAdmin($message);
                    }
                    break;
                default:
                    trigger_error("Action invalide.");
            }
        }
        else
        {
            //action du controleur à effectuer par défaut
            trigger_error("Ausune action demandé.");
        }
    }

    private function affichePageAdmin($message = "")
    {
        $this->afficheVue("header");
        //On va chercher les données nécessaires
        $modeleUsagers = $this->getDAO("Usager");
        $donnees["usagers"] = $modeleUsagers->obtenir_tous();
        $this->afficheVue("AdminPage", $donnees);
        echo $message;
        $this->afficheVue("footer");
    }
}
?>
