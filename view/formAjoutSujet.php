<h1>Insertion d'un nouveau sujet</h1>
<div class="divAjoutSujet">
    <form method="POST">
        <p>Titre : <input type="text" name="titre"/><br></p>
        <label for="texte_sujet">Votre Texte :</label>
        <textarea id ="texte_sujet" name="texte_sujet" rows="20" cols="50">Entrez votre sujet ici.</textarea>
        <input type="hidden" name="action" value="insereSujet"/>
        <p><input type="submit" value="Enregistrer"/></p>
    </form>
</div>
