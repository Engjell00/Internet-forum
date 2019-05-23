<?php
    class Modele_Sujets extends BaseDAO
    {
       public function getTableName()
       {
           return "sujets";
       }
        
        public function getPrimaryKey()
        {
            return "id_sujets";
        }
        
        public function obtenir_par_id($id)
        {
            $resultat = $this->lire($id);
            $resultat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Sujets");
            $leFilm = $resultat->fetch();
            return $leFilm;
        }
        
        public function obtenir_tous()
        {
            $resultats = $this->lireTous();
            $lesSujets = $resultats->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Sujets");
            return $lesSujets;
        }

        //**************************************
        //On veut afficher les sujets via une requête complexe
        public function obtenir_tous_les_sujets($nbPages = NULL, $pageDebut = NULL)
        {
            //$query = "SELECT * from " . $this->getTableName() . " ORDER BY date_creation_sujets DESC";
            //La demande au devis est qu'il faut trier par ordre de réponse donc la query change
            //**********************EXTRA: Un IF pour le pager et le nombre page
            $queryAjout = "";
            if((isset($nbPages))  && (isset($pageDebut))){
                //On insère LIMIT à la requête
                $queryAjout = " LIMIT " . ($nbPages * ($pageDebut - 1)) . "," . $nbPages;
            }
            else if(isset($nbPages)){
                $queryAjout = " LIMIT " . $nbPages;
            }
                //Tellement ciblé que l'on utlisera pas  $this->getTableName()
                $query = "SELECT DISTINCT s2.date_creation_sujets ,s2.id_sujets, s2.titre_sujets, s2.texte_sujets,  s2.username FROM (SELECT s1.id_sujets, s1.date_creation_sujets FROM sujets s1 UNION ALL SELECT r.id_sujets, r.date_creation_reponse FROM reponse r ORDER BY date_creation_sujets DESC) AS tri LEFT JOIN sujets AS s2 USING(id_sujets)" . $queryAjout;

            $resultats =  $this->requete($query);
            $lesSujets = $resultats->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Sujets");
            return $lesSujets;
        }

        //*************AJOUT d'un sujet*************************
        public function sauvegarde(Sujets $leSujet)
		{			
				//insérer le sujet (on aurait pu aussi utiliser CURRENT_TIMESTAMP et la variable session mais ils ont été de toute façon passé via l'objet)
				$query = "INSERT INTO " . $this->getTableName() . " (titre_sujets, texte_sujets,date_creation_sujets, username) VALUES (?, ?, ?,?)";
				$donnees = array($leSujet->getTitreSujets(), $leSujet->getTexteSujets(), $leSujet->getDateCreationSujets(),$leSujet->getUsername());
				return $this->requete($query, $donnees);
		}
    }
?>