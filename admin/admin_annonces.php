<?php include 'includes/protect.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
$csvFile = 'data/annonces.csv';
$annonces = [];

// Supprimer une annonce
if (isset($_GET['delete'])) {
    $indexToDelete = intval($_GET['delete']);
    $rows = array_map('str_getcsv', file($csvFile));
    unset($rows[$indexToDelete]);
    $fp = fopen($csvFile, 'w');
    foreach ($rows as $row) {
        fputcsv($fp, $row, ",");
    }
    fclose($fp);
    header("Location: admin_annonces.php");
    exit;
}

// Modifier une annonce (formulaire)
$editData = null;
if (isset($_GET['edit'])) {
    $editIndex = intval($_GET['edit']);
    $lines = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (isset($lines[$editIndex])) {
        $editData = str_getcsv($lines[$editIndex], ",");
        $editDataIndex = $editIndex;
    }
}

// Enregistrer les modifications
if (isset($_POST['update'])) {
    $i = intval($_POST['index']);
    $newTitre = $_POST['titre'];
    $newContenu = $_POST['contenu'];
    $newDate = $_POST['date'];
    $newNouveau = isset($_POST['nouveau']) ? "1" : "0";

    $rows = array_map('str_getcsv', file($csvFile));
    $fp = fopen($csvFile, 'w');
    foreach ($rows as $key => $row) {
        if ($key == $i) {
            fputcsv($fp, [$newTitre, $newContenu, $newDate, $newNouveau], ",");
        } else {
            fputcsv($fp, $row, ",");
        }
    }
    fclose($fp);
    header("Location: admin_annonces.php");
    exit;
}

// Lire les annonces
if (file_exists($csvFile)) {
    $lines = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $doc = str_getcsv($line, ",");
        if (count($doc) >= 4) {
            $annonces[] = $doc;
        }
    }

    // Trier par date décroissante
    usort($annonces, function($a, $b) {
        return strtotime($b[2]) <=> strtotime($a[2]);
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des Annonces</title>
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
      flex-wrap: wrap;
      gap: 15px;
      justify-content: center;
      align-items: center;
      margin-bottom: 30px;
    }

    input[type="text"],input[type="date"],select,textarea {
      padding: 10px 12px;
      border-radius: 8px;
      background: #fff3e6;
      border: 1px solid #f4cfa8;
      font-size: 16px;
      min-width: 180px;
    }

    textarea {
      resize: horizontal ;
      width: 50%;
    }

    button {
      background-color: #e57222;
      color: white;
      padding: 12px 25px;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #cc5a1b;
    }

    .full-width {
      width: 100%;
      max-width: 600px;
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
   

    .btn-modifier {
      padding: 6px 12px;
      margin:5px;
      border: none;
      border-radius: 4px;
      font-size: 14px;
      text-decoration: none;
      cursor: pointer;
      display: inline-block;
      transition: background-color 0.3s ease;
      background-color: #ffa500;
      color: white;
    }

    .btn-modifier:hover {
      background-color: #e69500;
    }

    .btn-supprimer {
      padding: 6px 12px;
      margin:5px;
      border: none;
      border-radius: 4px;
      font-size: 14px;
      text-decoration: none;
      cursor: pointer;
      display: inline-block;
      transition: background-color 0.3s ease;
      background-color: #e74c3c;
      color: white;
    }

    .btn-supprimer:hover {
      background-color: #c0392b;
    }

    </style>
</head>
<body>
  <h2>Annonces</h2>
<form method="post">
  <input type="text" name="titre" placeholder="Titre" required>
  <textarea name="contenu" placeholder="Contenu" required></textarea>
  <input type="date" name="date_annonce" required>
  <label><input type="checkbox" name="est_nouveau" value="1"> Marquer comme nouveau</label>
  <button type="submit">Ajouter</button>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titre = $_POST['titre'];
  $contenu = $_POST['contenu'];
  $date = isset($_POST['date_annonce']) ? $_POST['date_annonce'] : '';
  $est_nouveau = isset($_POST['est_nouveau']) ? '1' : '0';
  $row = [$titre, $contenu, $date, $est_nouveau];
  $fp = fopen("data/annonces.csv", "a");
  fputcsv($fp, $row);
  fclose($fp);
  echo "<p>✅ Annonce ajoutée</p>";
}
?>

<?php if ($editData): ?>
<div class="form-wrapper">
    <h2 class="section-title">Modifier l'annonce</h2>
    <form method="POST" class="form-horizontal">
        <input type="hidden" name="index" value="<?= $editDataIndex ?>">

        <input type="text" name="titre" class="form-control" placeholder="Titre" value="<?= htmlspecialchars($editData[0]) ?>" required>

        <textarea name="contenu" class="form-control" placeholder="Contenu" required><?= htmlspecialchars($editData[1]) ?></textarea>

        <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($editData[2]) ?>" required>

        <label class="checkbox-inline">
            <input type="checkbox" name="nouveau" value="1" <?= $editData[3] == "1" ? "checked" : "" ?>>
            Marquer comme nouveau
        </label>

        <button type="submit" name="update" class="btn btn-orange">Enregistrer</button>
    </form>
</div>
<?php endif; ?>

<!-- Tableau des annonces avec actions -->
<table class="annonces-table">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Contenu</th>
            <th>Date</th>
            <th>Nouveau</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($annonces as $index => $doc): ?>
        <tr>
            <td><?= htmlspecialchars($doc[0]) ?></td>
            <td><?= htmlspecialchars($doc[1]) ?></td>
            <td><?= htmlspecialchars($doc[2]) ?></td>
            <td><?= $doc[3] == "1" ? "🆕" : "" ?></td>
            <td>
                <a href="?edit=<?= $index ?>" class="btn btn-modifier">Modifier</a>
                <a href="?delete=<?= $index ?>" class="btn btn-supprimer" onclick="return confirm('Supprimer cette annonce ?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
