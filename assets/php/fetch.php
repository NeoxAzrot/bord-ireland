<?php

	if($_POST['request'])
	{
        include 'connect_PDO.php';
        include 'dateChangeFormat.php';

        // Crée un tableau pour les articles pour l'affichage
        $arrayArticle = array();

        // Récupère les mots clés ressemblant
		$reqMotCle = $bdd->prepare('SELECT * FROM motcle WHERE LibMoCle Like :id');
		$reqMotCle->execute(array(
		    'id' => "%" . $_POST['request'] . "%"
        ));

        // Récupère les articles ressemblant
        while($donneesMotCle = $reqMotCle->fetch())
        {
            
            $reqMotCleArticle = $bdd->prepare('SELECT * FROM motclearticle WHERE NumMoCle = :id');
            $reqMotCleArticle->execute(array(
                'id' => $donneesMotCle['NumMoCle']
            ));
            $donneesMotCleArticle = $reqMotCleArticle->fetch();
            if(!empty($donneesMotCleArticle)) {
                array_push($arrayArticle, $donneesMotCleArticle['NumArt']);
            }
        }

	?>

            <?php

            // Car des articles pouvaient être similaire avec des mots clés ressemblant
            $arrayArticleTrue = array();

            for($i = 0; $i < count($arrayArticle); $i++)
            {
                if(!in_array($arrayArticle[$i], $arrayArticleTrue)) {
                    array_push($arrayArticleTrue, $arrayArticle[$i]);
                }
            }

            for($i = 0; $i < count($arrayArticleTrue); $i++)
            {
                $req = $bdd->prepare('SELECT * FROM article WHERE NumArt = :id');
                $req->execute(array(
                    'id' => $arrayArticleTrue[$i]
                ));
                $donnees = $req->fetch();
                ?>

                <div class="header">
                    <img src="assets/uploads/<?php echo $donnees['UrlPhotA'];  ?>" alt="Image de l'article">
                    <p><?php echo dateChangeFormat($donnees['DtCreA'], "Y-m-d", "d/m/Y"); ?></p>
                </div>

                <p class="previewSearch"><?php echo $donnees['LibTitrA']; ?></p>
                <a href="articles.php?numArt=<?php echo $donnees['NumArt']; ?>" class="linkSearch">Voir l'article</a>

                <hr>

                <?php

            }

            // Affiche un message d'erreur s'il n'y a pas d'article
            if(count($arrayArticleTrue) == 0) {
                echo "<p class='errorSearch'>Aucun article trouvé !</p>";
            }

            ?>

<?php
	}

?>