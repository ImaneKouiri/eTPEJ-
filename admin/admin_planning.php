<?php include 'includes/protect.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
$csvFile = 'data/planning.csv';

// Créer le fichier s'il n'existe pas
if (!file_exists($csvFile)) {
    file_put_contents($csvFile, '');
}

// Supprimer une ligne
if (isset($_GET['delete'])) {
    $indexToDelete = intval($_GET['delete']);
    $rows = array_map('str_getcsv', file($csvFile));
    unset($rows[$indexToDelete]);
    $fp = fopen($csvFile, 'w');
    foreach ($rows as $row) {
        fputcsv($fp, $row);
    }
    fclose($fp);
    header('Location: admin_planning.php');
    exit;
}

// Ajouter une ligne
if (isset($_POST['add'])) {
    $jour = $_POST['jour'];
    $nom_matin = $_POST['nom_matin'];
    $etat_matin = $_POST['etat_matin'];
    $nom_am = $_POST['nom_am'];
    $etat_am = $_POST['etat_am'];
    $remarque = $_POST['remarque'];
    $type = $_POST['type'];

    $rows = array_map('str_getcsv', file($csvFile));

    // Empêcher les doublons de jour
    foreach ($rows as $row) {
        if ($row[0] == $jour) {
            $error = "Le jour '$jour' existe déjà.";
            break;
        }
    }

    if (!isset($error)) {
        $fp = fopen($csvFile, 'a');
        fputcsv($fp, [$jour, "$nom_matin ($etat_matin)", $nom_am, $etat_am, "$remarque ($type)"]);
        fclose($fp);
        header('Location: admin_planning.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Planning hebdomadaire du personnel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      padding: 30px;
    }
    h2 {
      color: #e57222;
      text-align: center;
      font-size: 38px;
      font-weight: bold;
      line-height: 1.4;
      margin: 40px;
    }
    form {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 20px;
    }
    select, input[type="text"] {
      padding: 10px 12px;
      border-radius: 8px;
      background: #fff3e6;
      border: 1px solid #f4cfa8;
      font-size: 16px;
      min-width: 180px;
    }
    button {
      background: #e57224;
      color: white;
      font-weight: bold;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .success {
      text-align: center;
      color: green;
      margin-top: 10px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      background: #fff8f0;
    }
    th, td {
      border: 1px solid #f4cfa8;
      padding: 10px;
      text-align: center;
    }
    th {
      background: #ffe1ba;
    }
    .action-links a {
      margin: 0 5px;
      text-decoration: none;
      font-weight: bold;
    }
    .action-links a.delete {
      color: #cc0000;
    }
    .present { color: green; }
    .conge { color: red; }
    .teletravail { color: blue; }
    .reunion { color: orange; }
  </style>
</head>
<body>

<h2>Planning hebdomadaire du personnel</h2>

<form method="post">
  <select name="jour" required>
    <option value="">Jour</option>
    <?php foreach(["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"] as $j): ?>
      <option value="<?= $j ?>"><?= $j ?></option>
    <?php endforeach; ?>
  </select>
  <input type="text" name="nom_matin" placeholder="Nom matin" required>
  <select name="etat_matin" required>
    <option value="">État matin</option>
    <option value="present">Présent</option>
    <option value="teletravail">Télétravail</option>
    <option value="conge">Congé</option>
  </select>
  <input type="text" name="nom_am" placeholder="Nom après-midi" required>
  <select name="etat_am" required>
    <option value="">État après-midi</option>
    <option value="present">Présent</option>
    <option value="teletravail">Télétravail</option>
    <option value="conge">Congé</option>
  </select>
  <input type="text" name="remarque" placeholder="Remarque">
  <select name="type">
    <option value="">Type</option>
    <option value="reunion">Réunion</option>
    <option value="formation">Formation</option>
  </select>
  <button type="submit" name="add">Ajouter</button>
</form>
<?php if (isset($error)) : ?>
    <div style="color: red; text-align: center; margin: 10px 10px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>
<?php if (isset($success)): ?>
  <div class="success">✅ Planning mis à jour</div>
<?php endif; ?>

<table>
  <tr>
    <th>Jour</th>
    <th>Matin</th>
    <th>État Matin</th>
    <th>Après-midi</th>
    <th>État après-midi</th>
    <th>Remarques</th>
    <th>Action</th>
  </tr>
  <tbody>
        <?php
        $rows = array_map('str_getcsv', file($csvFile));
        foreach ($rows as $index => $row) {
            echo "<tr>";
            echo "<td>{$row[0]}</td>";
            echo "<td>" . explode('(', $row[1])[0] . "</td>";
            echo "<td>" . trim(explode('(', $row[1])[1], ')') . "</td>";
            echo "<td>{$row[2]}</td>";
            echo "<td>{$row[3]}</td>";
            echo "<td>{$row[4]}</td>";
            echo "<td><a href='?delete=$index' style='color:red;'>Supprimer</a></td>";
            echo "</tr>";
        }
        ?>
  </tbody>
</table>

</body>
</html>
