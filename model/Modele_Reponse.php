<?php
class Modele_Reponse extends BaseDAO
{
    public function getTableName()
    {
        return "reponse";
    }

    public function getPrimaryKey()
    {
        return "id_reponse";
    }

    public function obtenir_par_id($id)
    {
        $resultat = $this->lire($id);
        $resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Reponse");
        $usager = $resultat->fetch();
        return $usager;
    }

    public function obtenir_tous()
    {
        $resultats = $this->lireTous("date_creation_reponse");
        $lesReponses = $resultats->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Reponse");
        return $lesReponses;
    }

    //Retourne les réponses relatives à un sujets (EXTRA)
    public function obtenir_reponse_par_sujet($id)
    {
        $query = "SELECT * FROM " . $this->getTableName()." WHERE id_sujets = ".$id. " ORDER BY date_creation_reponse ";
        $resultats = $this->requete($query);
        $lesReponses = $resultats->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Reponse");
        return $lesReponses;
    }

    //Ajout d'une méthode pour aller chercher la dernière réponse par sujets (EXTRA)
    public function derniere_reponse_par_sujet($id)
    {
        $query = "SELECT * FROM " . $this->getTableName()." WHERE id_sujets = ".$id. " ORDER BY date_creation_reponse DESC LIMIT 1";
        $resultats = $this->requete($query);
        $resultats->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Reponse");
        $laDerniereReponse = $resultats->fetch();
        return $laDerniereReponse;
    }

    //Champ autoIncrement donc pas besoin de vérifier si l'ID existe
    public function sauvegarde(Reponse $reponse)
    {
            $query = "INSERT INTO " . $this->getTableName() . " (titre_reponse, texte_reponse,date_creation_reponse,id_sujets,username) VALUES (?, ?, ?, ?, ?)";
            $donnees = array($reponse->getTitreReponse(), $reponse->getTexteReponse(), $reponse->getDateCreationReponse(),$reponse->getIdSujets(),$reponse->getUsername());
            return $this->requete($query, $donnees);
    }
    //**********************
    //EXTRA : Sert à compter le nombre de réponse par sujets
    public function compteNbReponse(){
        $query = "SELECT id_sujets, COUNT(reponse.id_reponse) AS nbReponse FROM sujets LEFT JOIN reponse USING(id_sujets) GROUP BY sujets.id_sujets;";
        $resultats = $this->requete($query);
        $lesReponses = $resultats->fetchAll();
        return $lesReponses;
    }
    //EXTRA : Sert à retourner toutes les réponses en ordre descendant que l'on va traiter en PHP dans la vue
    //on ne peut faire une requête qui fonctionne en objet (Fecth dans un objet) et qui nous retourne 2 objets soit le sujet et la réponse associé
    //Il faut donc faire une requète standard qui va retourner les sujets avec la réponse récente correspondante et trier par plus récent des deux et on a pas réussi à la trouver. Déjà que pour les sujets seuls on a réussi. Donc si vous le l'avez on aimerait bien l'avoir.
    public function reponseRecenteDuSujet(){
        $query = "SELECT * FROM " . $this->getTableName()." ORDER BY date_creation_reponse DESC;";
        $resultats = $this->requete($query);
        $lesReponses = $resultats->fetchAll();
        return $lesReponses;
    }


    //Suppression d'une réponse (non utilisé car non demandé au devis)
    public function supprimerReponse($clePrimaire)
    {
        $query = "DELETE FROM " . $this->getTableName() . " WHERE id_sujets =?";
        $donnees = array($clePrimaire);
        return $this->requete($query, $donnees);
    }
}
?>