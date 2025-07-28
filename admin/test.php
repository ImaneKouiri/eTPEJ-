<?php include 'includes/protect.php'; ?>
<?php include 'includes/header.php'; ?>

<?php
if (!function_exists('getIcon')) {
  function getIcon($etat, $type) {
    $class = "";
    if ($etat === 'present') $class = 'fa-solid fa-circle-check present';
    if ($etat === 'teletravail') $class = 'fa-circle-check teletravail';
    if ($etat === 'conge') $class = 'fa-solid fa-circle-xmark conge';
    if ($type === 'remarque') {
      if ($etat === 'reunion') $class = 'fa-calendar-days reunion';
      if ($etat === 'formation') $class = 'fa-chalkboard-user reunion';
    }
    $prefix = ($type === 'remarque') ? 'fa-regular' : 'fa-solid';
    return "<i class='$prefix $class'></i>";
  }
}
?>
<?php
if (isset($_GET['delete'])) {
  $index = intval($_GET['delete']);
  $filename = "data/planning.csv";

  if (file_exists($filename)) {
    $lines = array_map("str_getcsv", file($filename));

    if (isset($lines[$index])) {
      unset($lines[$index]);
      $fp = fopen($filename, "w");
      foreach ($lines as $row) {
        fputcsv($fp, $row);
      }
      fclose($fp);
    }
  }

  header("Location: admin_planning.php");
  exit();
}

?>
<?php
if (isset($_POST['submit'])) {
    $matin = $_POST['matin'];
    $apresmidi = $_POST['apresmidi'];
    $remarque = $_POST['remarque'];

    $data = [$matin, $apresmidi, $remarque];
    $file = fopen('/admin/data/planning.csv', 'a');
if ($file) {
    fputcsv($file, $data);
    fclose($file);
    header("Location: admin_planning.php");
    exit();
} else {
    echo "<p style='color:red;'>Erreur : impossible d’ouvrir le fichier CSV.</p>";
}
    fclose($file);

    header("Location: admin_planning.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Planning hebdomadaire - Admin</title>
  <link rel="stylesheet" href="planning.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
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
      gap: 15px;
      margin-top: 20px;
    }
    select, input[type="text"] {
      padding: 10px;
      background: #fff3e6;
      border: 1px solid #f4cfa8;
      border-radius: 5px;
      width: 200px;
    }
    button {
      background: #e57224;
      color: white;
      font-weight: bold;
      padding: 12px 25px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    table {
      width: 90%;
      margin: 40px auto;
      border-collapse: collapse;
      background: #fff8f0;
    }
    th, td {
      border: 1px solid #f4cfa8;
      padding: 12px;
      text-align: left;
    }
    th {
      background: #ffe1ba;
    }
    .action-links a {
      margin-right: 10px;
      text-decoration: none;
      font-weight: bold;
    }
    .action-links a.edit {
      color: #0066cc;
    }
    .action-links a.delete {
      color: #cc0000;
    }
  </style>
</head>
<body>

<h2>Planning hebdomadaire du personnel</h2>

<form method="post">
  <select name="jour" required>
    <option value="">Jour</option>
    <?php foreach(["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"] as $jour): ?>
      <option value="<?= $jour ?>"><?= $jour ?></option>
    <?php endforeach; ?>
  </select>
  <input type="text" name="matin_nom" placeholder="Nom matin" required>
  <select name="matin_etat" required>
    <option value="">État matin</option>
    <option value="present">Présent</option>
    <option value="teletravail">Télétravail</option>
    <option value="conge">Congé</option>
  </select>
  <input type="text" name="aprem_nom" placeholder="Nom après-midi" required>
  <select name="aprem_etat" required>
    <option value="">État après-midi</option>
    <option value="present">Présent</option>
    <option value="teletravail">Télétravail</option>
    <option value="conge">Congé</option>
  </select>
  <input type="text" name="remarque" placeholder="Remarque">
  <select name="remarque_etat">
    <option value="">Type</option>
    <option value="reunion">Réunion</option>
    <option value="formation">Formation</option>
  </select>
  <button type="submit">Ajouter</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_row = [
    $_POST['jour'],
    $_POST['matin_nom'],
    $_POST['matin_etat'],
    $_POST['aprem_nom'],
    $_POST['aprem_etat'],
    $_POST['remarque'],
    $_POST['remarque_etat']
  ];

  $filename = "data/planning.csv";
  $rows = file_exists($filename) ? array_map("str_getcsv", file($filename)) : [];
  $updated = false;

  foreach ($rows as &$row) {
    if ($row[0] === $new_row[0]) {
      $row = $new_row;
      $updated = true;
      break;
    }
  }

  if (!$updated) {
    $rows[] = $new_row;
  }

  $fp = fopen($filename, "w");
  foreach ($rows as $row) {
    fputcsv($fp, $row);
  }
  fclose($fp);

  echo "<p style='text-align:center;color:green;'>✅ Planning mis à jour</p>";
}
?>

<table>
  <tr>
    <th>Jour</th>
    <th>Matin</th>
    <th>Après-midi</th>
    <th>Remarques</th>
    <th>Action</th>
  </tr>
  <?php
  if (file_exists("/admin/data/planning.csv")):
    $lines = array_map("str_getcsv", file("/admin/data/planning.csv"));
    foreach ($lines as $i => $line):
  ?>
    <tr>
      <td><?= htmlspecialchars($line[0]) ?></td>
      <td><?= getIcon($line[2], 'etat') . " " . htmlspecialchars($line[1]) ?></td>
      <td><?= getIcon($line[4], 'etat') . " " . htmlspecialchars($line[3]) ?></td>
      <td><?= getIcon($line[6], 'remarque') . " " . htmlspecialchars($line[5]) ?></td>
      <td class="action-links">
        <a href="?edit=<?= $i ?>" class="edit">✏️ Modifier</a>
        <a href="?delete=<?= $i ?>" class="delete" onclick="return confirm('Supprimer cette ligne ?')">🗑️ Supprimer</a>
      </td>
    </tr>
  <?php endforeach; endif; ?>
</table>

</body>
</html>

.....................
<?php include 'includes/protect.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
$modifierIndex = null;
$valeurs = ["", "", "", "", "", "", ""];

// === CHARGER POUR MODIFIER ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $modifierIndex = $_POST['modifier'];
    $fichier = 'data/planning.csv';
    $lines = file($fichier, FILE_IGNORE_NEW_LINES);
    if (isset($lines[$modifierIndex])) {
        $valeurs = str_getcsv($lines[$modifierIndex]);
    }
}

// === SUPPRIMER ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
    $index = (int)$_POST['supprimer'];
    $fichier = 'data/planning.csv';
    $lines = file($fichier, FILE_IGNORE_NEW_LINES);
    if (isset($lines[$index])) {
        unset($lines[$index]);
        file_put_contents($fichier, implode("\n", $lines) . "\n");
        echo "<p style='color:green;'>✅ Ligne supprimée.</p>";
    }
}

// === AJOUT OU MODIFICATION ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $jour = $_POST['jour'] ?? '';
    $matin_nom = $_POST['matin_nom'] ?? '';
    $matin_etat = $_POST['matin_etat'] ?? '';
    $apresmidi_nom = $_POST['apresmidi_nom'] ?? '';
    $apresmidi_etat = $_POST['apresmidi_etat'] ?? '';
    $remarque = $_POST['remarque'] ?? '';
    $type = $_POST['type'] ?? '';
    $fichier = 'data/planning.csv';

    if (!is_dir('data')) mkdir('data');

    $data = [];
    $existe = false;
    if (file_exists($fichier)) {
        $data = file($fichier, FILE_IGNORE_NEW_LINES);
        foreach ($data as $i => $line) {
            $row = str_getcsv($line);
            if ($row[0] === $jour && (!isset($_POST['modifier_index']) || $_POST['modifier_index'] != $i)) {
                $existe = true;
                break;
            }
        }
    }

    if ($existe) {
        echo "<p style='color:red;'>Erreur : Le jour \"$jour\" existe déjà.</p>";
    } else {
        $nouvelleLigne = implode(",", [$jour, $matin_nom, $matin_etat, $apresmidi_nom, $apresmidi_etat, $remarque, $type]);
        if (isset($_POST['modifier_index']) && $_POST['modifier_index'] !== "") {
            $data[$_POST['modifier_index']] = $nouvelleLigne;
        } else {
            $data[] = $nouvelleLigne;
        }
        file_put_contents($fichier, implode("\n", $data) . "\n");
        echo "<p style='color:green;'>✅ Planning mis à jour</p>";
        $valeurs = ["", "", "", "", "", "", ""];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Planning hebdomadaire - Admin</title>
  <link rel="stylesheet" href="planning.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
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
      gap: 15px;
      margin-top: 20px;
    }
    select, input[type="text"] {
      padding: 10px;
      background: #fff3e6;
      border: 1px solid #f4cfa8;
      border-radius: 5px;
      width: 200px;
    }
    button {
      background: #e57224;
      color: white;
      font-weight: bold;
      padding: 12px 25px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    table {
      width: 90%;
      margin: 40px auto;
      border-collapse: collapse;
      background: #fff8f0;
    }
    th, td {
      border: 1px solid #f4cfa8;
      padding: 12px;
      text-align: left;
    }
    th {
      background: #ffe1ba;
    }
    .action-links a {
      margin-right: 10px;
      text-decoration: none;
      font-weight: bold;
    }
    .action-links a.edit {
      color: #0066cc;
    }
    .action-links a.delete {
      color: #cc0000;
    }
  </style>
</head>
<body>

<h2>Planning hebdomadaire du personnel</h2>

<form method="post">
  <select name="jour" required>
    <option value="">Jour</option>
    <?php foreach(["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"] as $jour): ?>
      <option value="<?= $jour ?>"><?= $jour ?></option>
    <?php endforeach; ?>
  </select>
  <input type="text" name="matin_nom" placeholder="Nom matin" required>
  <select name="matin_etat" required>
    <option value="">État matin</option>
    <option value="present">Présent</option>
    <option value="teletravail">Télétravail</option>
    <option value="conge">Congé</option>
  </select>
  <input type="text" name="aprem_nom" placeholder="Nom après-midi" required>
  <select name="aprem_etat" required>
    <option value="">État après-midi</option>
    <option value="present">Présent</option>
    <option value="teletravail">Télétravail</option>
    <option value="conge">Congé</option>
  </select>
  <input type="text" name="remarque" placeholder="Remarque">
  <select name="remarque_etat">
    <option value="">Type</option>
    <option value="reunion">Réunion</option>
    <option value="formation">Formation</option>
  </select>
  <button type="submit">Ajouter</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_row = [
    $jour = $_POST['jour'],
    $matin_nom = $_POST['matin_nom'],
    $matin_etat = $_POST['matin_etat'],
    $apresmidi_nom = $_POST['aprem_nom'],
    $apresmidi_etat = $_POST['aprem_etat'],
    $remarque = $_POST['remarque'],
     $type = $_POST['remarque_etat']
  ];

  $filename = "data/planning.csv";
  $rows = file_exists($filename) ? array_map("str_getcsv", file($filename)) : [];
  $updated = false;

  foreach ($rows as &$row) {
    if ($row[0] === $new_row[0]) {
      $row = $new_row;
      $updated = true;
      break;
    }
  }

  if (!$updated) {
    $rows[] = $new_row;
  }

  $fp = fopen($filename, "w");
  foreach ($rows as $row) {
    fputcsv($fp, $row);
  }
  fclose($fp);

  echo "<p style='text-align:center;color:green;'>✅ Planning mis à jour</p>";
}
?>

<table>
    <thead>
        <tr>
            <th>Jour</th>
            <th>Nom matin</th>
            <th>État matin</th>
            <th>Nom après-midi</th>
            <th>État après-midi</th>
            <th>Remarque</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $fichier = 'data/planning.csv';
        if (file_exists($fichier)) {
            $rows = file($fichier);
            foreach ($rows as $index => $line) {
                $row = str_getcsv($line);
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "<td>
                        <form method='POST' style='display:inline'>
                            <input type='hidden' name='modifier' value='$index'>
                            <button type='submit'><i class='fa fa-pen'></i> Modifier</button>
                        </form>
                        <form method='POST' style='display:inline'>
                            <input type='hidden' name='supprimer' value='$index'>
                            <button type='submit' onclick='return confirm(\"Supprimer cette ligne ?\")'><i class='fa fa-trash'></i> Supprimer</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>

</table>

</body>
</html>
