<h1>Affichage de tous les sujets</h1>
<section class="section1Sujets">
    <div>
        Ajouter un <a href='index.php?Sujets&action=formInsereSujet'>nouveau sujet</a>
    </div>
<?php
    //*****************************EXTRA****************************
    //Pratique d'un pager (work in progress mais fonctionnel. Il faudrait ajouter une limite de quantité de sujet par défault.)
    //*******************************************
    if((isset($_SESSION["nbPages"])) && (!($_SESSION["nbPages"] == "Tous"))){
    //Nous allons maintenant compter le nombre de pages.
    $totalSujets = $data["nombreDeSujet"];
    $nombreDePages=ceil($totalSujets/$_SESSION["nbPages"]);
        //S'il y a plus qu'une page
        if($nombreDePages > 1){
        echo "<div class='pager'>";
            //echo "<p align='center'> nombre de pages: " . $nombreDePages . "</p><p align='center'>";
                for($i = 1;$i <= $nombreDePages; $i++){
                echo "<a href='index.php?Sujets&action=changePage&page=$i'>$i</a> ";
                }
                echo "</p></div>";
        }
    }
?>
    <!--EXTRA pour pratique de Pager-->
        <form method="post">
            <select name="nbPages">
                <option value="3"<?php if((isset($_SESSION["nbPages"])) &&($_SESSION["nbPages"] == "3")) echo " selected"; ?>>3</option>
                <option value="5"<?php if((isset($_SESSION["nbPages"])) &&($_SESSION["nbPages"] == "5")) echo " selected"; ?>>5</option>
                <option value="10"<?php if((isset($_SESSION["nbPages"])) &&($_SESSION["nbPages"] == "10")) echo " selected"; ?>>10</option>
                <option value="20"<?php if((isset($_SESSION["nbPages"])) &&($_SESSION["nbPages"] == "20")) echo " selected"; ?>>20</option>
                <option value="Tous"<?php if((isset($_SESSION["nbPages"])) &&($_SESSION["nbPages"] == "Tous")) echo " selected"; ?>>Tous</option>
            </select>
            <input type="hidden" name="action" value="choixNbPages"/>
            <input type="submit" name="submit" value="nombre pages" />
        </form>
</section>
<section>
<?php
//************** Affichage des sujets****************
echo "<table class='tableSujet'>";
    foreach($data["sujets"] as $sujet)
    {
        echo "<tr>";
        //*************************
        //Information sur l'auteur
        //*************************
        echo "<td><p>" . $sujet->getUsername();
        $modeleUsagers = $this->getDAO("Usager");
        $banni = $modeleUsagers->obtenir_par_id($sujet->getUsername());
        //*************************
        //Information sur le statut BANNI
        //*************************
        if($banni->getBanni()){
            echo " <span style='color: red'>(BANNI)</span>";
        }
        echo "</p><p style='white-space: nowrap'><small>" . date("j F, Y, g:i a", strtotime($sujet->getDateCreationSujets())) . "</small></p>";
        echo "<p>";
        //Publication par usager
        foreach($data["compteSujetsParUsagers"] as $compte){
            if($sujet->getUsername() == $compte["username"]){
                echo "<p><small>Nb sujets publiés:" . $compte["compte"] . "</small></p>";
            }
        }
        //Nombre de réponse par sujet
        foreach($data["compteReponseParSujet"] as $reponse){
            if($sujet->getIdSujets() == $reponse["id_sujets"]){
                echo "<p><small>Nb de rép.:" . $reponse["nbReponse"] . "</small></p>";
            }
        }
        echo "<p><a href='index.php?Reponse&action=affiche&id=" . $sujet->getIdSujets() . "'>Afficher le post</a></p>";
        if($_SESSION["admin"]){
            echo "<p><a href='index.php?Sujets&action=supprimeSujet&id=" . $sujet->getIdSujets() . "'>Supprimer le post</a></p>";
        }
        //*************************
        //Affichage du sujet
        //*************************
        echo "</p></td>";
        echo "<td><p><strong>" . htmlspecialchars(substr($sujet->getTitreSujets(), 0, 100)) . "... </strong></p><p>"
            . htmlspecialchars(substr($sujet->getTexteSujets(), 0, 400)) . "... </p>";
        //*************************
        //EXTRA: petit texte indiquant la denière réponse (aide le professeur à corriger)
        //Pour la cause on accède directement au modèle pour aller chercher les données
        //*************************
        $modeleReponse = $this->getDAO("Reponse");
        $derniereReponse = $modeleReponse->derniere_reponse_par_sujet($sujet->getIdSujets());
        if($derniereReponse){
            echo "<p>Sans MVC- <small>Dernière réponse :" . date("j F, Y, g:i a", strtotime($derniereReponse->getDateCreationReponse())) . " par " . $derniereReponse->getUsername() . ": " .htmlspecialchars(substr($derniereReponse->getTitreReponse(), 0, 20)). "...</small></p>";
        }
        //Version 2 sans tricher le MVC mais pas très élégant et inefficace
        foreach($data["reponseRecenteDuSujet"] as $reponseRecenteDuSujet){
            if($sujet->getIdSujets() == $reponseRecenteDuSujet["id_sujets"]){
                echo "<p>Avec MVC - <small>Dernière réponse :" . date("j F, Y, g:i a", strtotime($reponseRecenteDuSujet["date_creation_reponse"])) . " par " . $reponseRecenteDuSujet["username"] . ": " .htmlspecialchars(substr($reponseRecenteDuSujet["titre_reponse"], 0, 20)). "...</small></p>";
                //Ici un grand manque d'élégance. Mais on sort du foreach après la première réponse trouvé et récente.
                break;
            }
        }

        echo "</td></tr>";
    }
    echo "</table></section>";

?>