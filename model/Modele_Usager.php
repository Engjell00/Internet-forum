<?php
class Modele_Usager extends BaseDAO
{
    public function getTableName()
    {
        return "usager";
    }

    public function getPrimaryKey()
    {
        return "username";
    }

    public function verifieLogin($username){

    }

    public function obtenir_par_id($id)
    {
        $resultat = $this->lire($id);
        $resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Usager");
        $usager = $resultat->fetch();
        return $usager;
    }

    public function obtenir_tous()
    {
        //***************************discutable au point de vue de la vitesse d'exécution et de la clarté du code
        //V1
        //$query = "SELECT * FROM " . $this->getTableName();
        //$resultats =  $this->requete($query);
        //*******************************
        //V2
        $resultats =  $this->lireTous();
        //*******************************
        $lesUsagers = $resultats->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Usager");
        return $lesUsagers;
    }

    //*************** Ne sert pas. Garder si on désire créer des user.******************
    public function sauvegarde(Usager $usager)
    {
        //si l'usager existe déjà
        if($usager->getUsername() && $resultat = $this->lire($usager->getUsername())->fetch())
        {
            //mettre à jour - on aurait pu mettre seulement le champ banni mais la fonction ne servirait plus qu'à ça
            $query = "UPDATE " . $this->getTableName() . " SET password=?,banni=?, admin=? WHERE username='" . $usager->getUsername() ."'";
            $donnees = array($usager->getPassword(), $usager->getBanni(),$usager->getAdmin());
            return $this->requete($query, $donnees);

        }
        //ne sert pas du tout car on passe un objet déjà existant
        else
        {
            //insérer
            $query = "INSERT INTO " . $this->getTableName() . " (username, password,banni, admin) VALUES (?, ?, ?,?)";
            $donnees = array($usager->getUsername(), $usager->getPassword(), $usager->getBanni(),$usager->getAdmin());
            return $this->requete($query, $donnees);
        }
    }
    //**********************
    //EXTRA : Sert à compter le nombre de sujets par usagers
    public function compteSujetsUsagers(){
        $query = "SELECT username, COUNT(sujets.titre_sujets) AS compte FROM usager LEFT JOIN sujets USING(username) GROUP BY usager.username;";
        $resultats = $this->requete($query);
        $lesUsagers = $resultats->fetchAll();
        return $lesUsagers;
    }
}
?>