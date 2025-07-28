<?php
$edit_document = null;
$edit_index = null;

if (isset($_GET['edit'])) {
    $edit_index = intval($_GET['edit']);
    $lines = file('data/documents.csv', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (isset($lines[$edit_index])) {
        $edit_document = str_getcsv($lines[$edit_index], ",");
    }
}

if (isset($_POST['update_document'])) {
    $index = intval($_POST['index']);
    $title = $_POST['title'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $file = $_POST['filename'];

    $rows = array_map('str_getcsv', file('data/documents.csv'));
    $fp = fopen('data/documents.csv', 'w');
    foreach ($rows as $i => $row) {
        if ($i == $index) {
            fputcsv($fp, [$title, $date, $category, $file]);
        } else {
            fputcsv($fp, $row);
        }
    }
    fclose($fp);
    header("Location: admin_documents.php");
    exit;
}
?>

<?php include 'includes/protect.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
$folder = '../documents/';

if (isset($_GET['delete'])) {
    $file = basename($_GET['delete']);
    $path = $folder . $file;

    if (file_exists($path)) {
        unlink($path);
        header("Location: admin_documents.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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

    input[type="text"],input[type="date"],select,input[type="file"] {
      padding: 10px 12px;
      border-radius: 8px;
      background: #fff3e6;
      border: 1px solid #f4cfa8;
      font-size: 16px;
      min-width: 180px;
    }

    input[type="file"] {
      background-color: transparent;
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
      color: #e57224;
    }
    .action-links a.delete {
      color: #cc0000;
    }
  </style>
</head>
<body>
  <h2>Documents administratifs internes</h2>
<form method="post" enctype="multipart/form-data">
  <input type="text" name="titre" placeholder="Titre du document" required>
  <input type="date" name="date" required>
  <select name="categorie">
    <option value="Notes de service">Notes de service</option>
    <option value="Règlements internes">Règlements internes</option>
    <option value="Circulaires et instructions">Circulaires et instructions</option>
    <option value="Procédures">Procédures</option>
  </select>
  <input type="file" name="fichier" required>
  <button type="submit">Ajouter</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $_POST['titre'];
    $date = $_POST['date'];
    $categorie = $_POST['categorie'];
    $file = $_FILES['fichier'];
    $filename = basename($file['name']);

    // Créer le dossier si nécessaire
    $target_dir = "../documents/$categorie";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0775, true);
    }

    // Déplacer le fichier dans le bon dossier
    $target_path = "$target_dir/$filename";
    move_uploaded_file($file['tmp_name'], $target_path);

    // Enregistrer dans le fichier CSV
    $csv_file = '../admin/data/documents.csv';
    $f = fopen($csv_file, 'a');
    fputcsv($f, [$titre, $date, $categorie, "$categorie/$filename"]);
    fclose($f);

    echo "<p>✅ Document ajouté avec succés</p>";
}
?>
<table border="1">
  <tr>
    <th>Titre</th>
    <th>Date</th>
    <th>Catégorie</th>
    <th>Fichier</th>
    <th>Supprimer</th>
  </tr>
  <?php
  $lines = array_map('str_getcsv', file('data/documents.csv'));
  foreach ($lines as $doc) {
    echo "<tr><td>{$doc[0]}</td><td>{$doc[1]}</td><td>{$doc[2]}</td><td><a href='uploads/documents/{$doc[3]}' download>Télécharger</a></td><td><a href='?delete=" . urlencode($doc[3]) . "' onclick='return confirm(\"Supprimer ce document ?\")' style='color:red;'>Supprimer</a></td></tr>";

  }
  ?>
</table>
<?php include 'includes/footer.php'; ?>
</body>
</html>

<?php if ($edit_document): ?>
<h2>Modifier le document</h2>
<form method="POST">
    <input type="hidden" name="index" value="<?= $edit_index ?>">
    <input type="hidden" name="filename" value="<?= htmlspecialchars($edit_document[3]) ?>">
    <input type="text" name="title" value="<?= htmlspecialchars($edit_document[0]) ?>" required>
    <input type="date" name="date" value="<?= htmlspecialchars($edit_document[1]) ?>" required>
    <input type="text" name="category" value="<?= htmlspecialchars($edit_document[2]) ?>" required>
    <button type="submit" name="update_document">Enregistrer</button>
</form>
<?php endif; ?>