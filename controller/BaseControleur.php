<?php
    abstract class BaseControleur
    {
        public abstract function traite(array $params);
        
        public function afficheVue($nomVue, $data = null)
        {
            //le paramètre data est utilisé directement dans les vues
            $cheminVue = RACINE . "view/" . $nomVue . ".php";
            
            if(file_exists($cheminVue))
            {
                include_once($cheminVue);    
            }   
            else
            {
                trigger_error("La vue spécifiée est introuvable.");
            }
        }
        
        public function getDAO($nomModele)
        {
            $classe = "Modele_" . $nomModele;
            
            if(class_exists($classe))
            {
                //on créé la connexion à la BD
                $connexionPDO = DBFactory::getDB(DBTYPE, DBNAME, HOST, USER, PWD);
                
                //on crée une instance de la classe Modele_$nomModele
                $objetModele = new $classe($connexionPDO);
                
                if($objetModele instanceof BaseDAO)
                    return $objetModele;
                else
                    trigger_error("Modèle invalide.");
            }
        }
        public function login($username, $password){
            $loginDB = $this->getDAO("Usager");
            $usager = $loginDB->obtenir_par_id($username);
            //fonction PHP password_verify
            if($usager && password_verify($password, $usager->getPassword())){
                //nous sommes authentifiés
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["banni"] = $usager->getBanni();
                $_SESSION["admin"] = $usager->getAdmin();
                //Sélectionne  le nombre de réponse maximum par page
                $_SESSION["nbPages"] = 5;
                return true;
            }
            else
                return false;
        }
        public function logout(){
             //code Guillaume Harvey
                // Détruit toutes les variables de session
                $_SESSION = array();
                // Si vous voulez détruire complètement la session, effacez également
                // le cookie de session.
                // Note : cela détruira la session et pas seulement les données de session !
                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(session_name(), '', time() - 42000,
                        $params["path"], $params["domain"],
                        $params["secure"], $params["httponly"]
                    );
                }
                // Finalement, on détruit la session.
                session_destroy();

        }
    }
?>