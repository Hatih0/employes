<?php
    include('../inc/functions.php');

    $emp_no   = $_GET['emp_no'] ?? '';
    $employee = get_one_employee($emp_no);
    $current_dept = get_current_department($emp_no);   // département dont il deviendra manager

    $error   = '';
    $success = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $current_dept) {
        $start = $_POST['from_date'] ?? '';
        $manager = get_current_manager($current_dept['dept_no']);

        if ($start === '') {
            $error = "Veuillez saisir une date de début.";
        } elseif ($manager && $start < $manager['from_date']) {
            // c. Erreur si la date est antérieure à celle du manager actuel
            $error = "La date de début ($start) ne peut pas être antérieure à celle du manager actuel (" . $manager['from_date'] . ").";
        } else {
            make_manager($emp_no, $current_dept['dept_no'], $start);
            $success = true;
        }
    }

    // b. Manager en cours (rechargé après un éventuel changement pour vérifier)
    $manager = $current_dept ? get_current_manager($current_dept['dept_no']) : null;
?>
<html>
    <head>
        <title>Devenir manager</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        
        <div class="container">
            <p><a href="fiche.php?emp_no=<?= urlencode($emp_no) ?>">&larr; Retour à la fiche</a></p>

            <?php if (!$employee) { ?>
                <h1>Employé introuvable</h1>
            <?php } elseif (!$current_dept) { ?>
                <h1>Cet employé n'a pas de département actuel.</h1>
            <?php } else { ?>
                <h1><?= $employee['first_name'] ?> <?= $employee['last_name'] ?> — devenir manager de <?= $current_dept['dept_name'] ?></h1>

                <?php if ($success) { ?>
                    <p class="alert-success" style="color:green;">C'est fait : l'employé est désormais le manager du département.
                    <a href="index.php">Vérifier dans la liste des départements &rarr;</a></p>
                <?php } ?>
                <?php if ($error !== '') { ?>
                    <p class="alert-error" style="color:red;"><?= htmlspecialchars($error) ?></p>
                <?php } ?>

                <!-- b. Manager en cours affiché en haut -->
                <p><strong>Manager en cours :</strong>
                    <?= $manager ? $manager['manager_name'] . ' (depuis le ' . $manager['from_date'] . ')' : 'aucun' ?>
                </p>
                <div class="card">
                    <form method="post" action="become_manager.php?emp_no=<?= urlencode($emp_no) ?>">
                        <p class="form-group">Date de début : <input type="date" name="from_date"></p>
                        <p><input class="btn" type="submit" value="Devenir manager"></p>
                    </form>
                </div>
            <?php } ?>
        </div>
    </body>
</html>
