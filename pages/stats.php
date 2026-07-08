<?php
    include('../inc/functions.php');
    $stats = get_jobs_stats();
?>
<html>
    <head>
        <title>Statistiques par emploi</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
    <div class="container">
        <p class="navbar"><a href="index.php">&larr; Retour aux départements</a></p>
        <h1>Statistiques par emploi</h1>

        <table border="1" class="table">
            <tr>
                <th>Emploi</th>
                <th>Hommes</th>
                <th>Femmes</th>
                <th>Total</th>
                <th>Salaire moyen</th>
            </tr>
            <?php foreach ($stats as $row) { ?>
                <tr>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['nb_hommes'] ?></td>
                    <td><?= $row['nb_femmes'] ?></td>
                    <td><?= $row['nb_total'] ?></td>
                    <td><?= number_format($row['salaire_moyen'], 0, ',', ' ') ?> €</td>
                </tr>
            <?php } ?>
        </table>
    </div>
    </body>
</html>
