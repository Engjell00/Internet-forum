<h2>Page d'administration</h2>
<div class="divAdmin">
    <form method="post">
        <table class="tableAdmin">
            <tr><th>Utilisateur</th><th>Actif</th><th>Banni</th></tr>
        <?php
        echo "";

        foreach($data["usagers"] as $usager) {
            echo "<tr><td>";
            echo $usager->getUsername();
            //les valeurs de checkbox ne sont transmis que s'ils sont checked. Il faut prendre des radios button
            echo "</td><td><input type='radio' name='USER[" . $usager->getUsername() . "]' value='actif'";
            if(!($usager->getBanni())){
                echo  " checked";
            }
            echo "/></td>";
            echo "<td><input type='radio' name='USER[" . $usager->getUsername() . "]' value='banni'";
            if($usager->getBanni()){
                echo  " checked";
            }
            echo "/>";
//            echo " Banni<br>";
            echo "</td></tr>";
        }
        ?>
        </table>
        <input type="hidden" name="action" value="enregistreStatutUsagers"/>
        <input type="submit" value="Enregistrer">
    </form>
    <p>Comme d'habitude cliquez sur le logo de l'en-tête pour revenir à l'<a href='index.php?Sujets'>acceuil</a>.</p>
</div>