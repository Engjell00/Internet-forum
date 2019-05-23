<?php
echo "<table class='tableSujet'>";
    echo "<tr>";
        echo "<td><p>" .$data["sujets"]->getUsername() . "</p><p style='white-space: nowrap'><small>" . date("j F, Y, g:i a", strtotime($data["sujets"]->getDateCreationSujets())) . "</small></p></td>";
        echo "<p>";
        echo "<td><h3>".$data["sujets"]->getTitreSujets() . "</h3>";
        echo "<p>". $data["sujets"]->getTexteSujets() . "</p>";
        echo "</td>";
    echo "</tr>";
        foreach($data["reponse"] as $reponse)
        {
            echo "<tr>";
            echo "<td><p>" . $reponse->getUsername() . "</p><p style='white-space: nowrap'><small>" . date("j F, Y, g:i a", strtotime($reponse->getDateCreationReponse())) . "</small></p></td>";
            echo "<td><h3><strong>" . $reponse->getTitreReponse() . "</strong></h3><p>". $reponse->getTexteReponse() . "</p></td>";
            echo "</tr>";
        }
echo "</table>";
echo "<h1><a href='index.php?Reponse&action=FormReponseSujet&id=" . $data["sujets"]->getIdSujets() . "'>Ajouter votre réponse</a></h1>";
?>

