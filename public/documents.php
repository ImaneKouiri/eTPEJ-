<?php
$csv_file = '../admin/data/documents.csv';
$documents = [];

if (file_exists($csv_file)) {
    $f = fopen($csv_file, 'r'); 
    
    while (($data = fgetcsv($f)) !== false) {
        list($titre, $date, $categorie, $fichier) = $data;
        $documents[$categorie][] = [
            'titre' => $titre,
            'date' => $date,
            'fichier' => $fichier,
            'categorie' => $categorie
        ];
    }
    fclose($f);

    foreach ($documents as &$docs) {
        usort($docs, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
    }
    unset($docs);
}    
function render_documents($category_slug, $expected_label, $documents) {
    if (!isset($documents[$expected_label])) return;

    foreach ($documents[$expected_label] as $doc) {
        echo '<tr>';
        echo '<td><span class="icon">📄</span> ' . htmlspecialchars($doc["titre"]) . '</td>';
        echo '<td>' . htmlspecialchars(date("d/m/Y", strtotime($doc["date"]))) . '</td>';

        // Chemin absolu vers le fichier pour vérification d'existence
        $cheminFichier = '../documents/' . $doc['fichier'];

        // Lien pour le href dans l'interface publique
        $href = '/documents/' . rawurlencode($doc['fichier']);

        if (file_exists($cheminFichier)) {
            echo '<td><a class="button" href="' . $href . '" download>Télécharger</a></td>';
        } else {
            echo '<td><span style="color:red;">Fichier introuvable</span></td>';
        }

        echo '</tr>';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TPEJ Portail</title>
  <link rel="stylesheet" href="documents.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <header>
    <div class="nav-content">
      <div class="logo">
        <img src="logo.png" alt="Logo TGR">
      </div>
      <nav class="nav">
        <ul class="nav-links">
          <li><a href="index.html">Accueil</a></li>
          <li><a href="planning.php">Planning</a></li>
          <li><a href="documents.php">Documents</a></li>
          <li><a href="annonce.php">Annonces</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="hero">
    <h1>Documents administratifs <br>internes</h1>
    <p>Accédez aux notes, réglements et circulaires du service</p>
  </section>

  <div class="container">
    <div class="search-box">
      <input type="text" id="searchInput" placeholder="Rechercher....">
      <span class="search-icon">🔍</span>
    </div>

    <div class="tabs">
      <span class="tab active" data-tab="notes">Notes de service</span>
      <span class="tab" data-tab="circulaires">Circulaires et instructions</span>
      <span class="tab" data-tab="reglements">Règlements internes</span>
      <span class="tab" data-tab="procedures">Procédures</span>
    </div>

    <!-- Tab Content Sections -->
    <div id="notes" class="tab-content active">
      <table>
        <thead>
          <tr>
            <th>Titre</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php render_documents('notes', 'Notes de service', $documents); ?>
        </tbody>
      </table>
    </div>

    <div id="circulaires" class="tab-content">
        <table>
      <thead>
        <tr>
          <th>Titre</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php render_documents('circulaires', 'Circulaires et instructions', $documents); ?>
      </tbody>
    </table>
    </div>
    <div id="reglements" class="tab-content">
      <table>
      <thead>
        <tr>
          <th>Titre</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php render_documents('reglements', 'Règlements internes', $documents); ?>
      </tbody>
    </table>
    </div>

  <div id="procedures" class="tab-content">
    <table>
      <thead>
        <tr>
          <th>Titre</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php render_documents('procedures', 'Procédures', $documents); ?>
      </tbody>
    </table>
  </div>
    
</div>

  <footer class="footer">
    <div class="footer-column">
      <img src="logo.png" alt="Logo TGR" class="footer-logo">
      <p><strong>Trésorerie Provinciale d’El Jadida</strong> – Service public chargé de la gestion locale des finances de l’État.</p>
      <p><em>Site interne dédié à la diffusion des informations administratives et à la coordination des services.</em></p>
      <div class="footer-icons">
        <a href="https://www.tgr.gov.ma" target="_blank" class="footer-icon" title="Site web">
          <i class="fa-solid fa-globe"></i>
        </a>
        <a href="tel:+212523379000" class="footer-icon" title="Appeler">
          <i class="fa-solid fa-phone"></i>
        </a>
        <a href="mailto:tgr@tgr.gov.ma" class="footer-icon" title="Envoyer un e-mail">
          <i class="fa-solid fa-envelope"></i>
        </a>
      </div>
    </div>

    <div class="footer-column">
      <br>
      <h3>Nos services</h3>
      <br>
      <ul>
        <li><a href="planning.php">Planning hebdomadaire</a></li>
        <li><a href="documents.php">Documents administratifs</a></li>
        <li><a href="documents.php">Règlements et procédures</a></li>
        <li><a href="annonce.php">Annonces internes</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <br>
      <h3>Navigation</h3>
      <br>
      <ul>
        <li><a href="index.html">Accueil</a></li>
        <li><a href="planning.php">Planning</a></li>
        <li><a href="documents.php">Documents</a></li>
        <li><a href="annonce.php">Annonce</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <div class="footer-map">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3336.857459736694!2d-8.5078906!3d33.24403749999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda91dc1b421fe47%3A0xeaf48bad11e681d3!2s6FVR%2BJR9%2C%20El%20Jadida%2C%20Morocco!5e0!3m2!1sen!2sus!4v1753272889743!5m2!1sen!2sus"
          width="350"
          height="200"
          style="border:0; border-radius: 6px;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        <p>
          <a href="https://www.google.com/maps/place/6FVR%2BJR9,+El+Jadida,+Morocco" target="_blank">
            6FVR+JR9, El Jadida, Morocco<br>
            Trésorerie Générale du Royaume d’El Jadida
          </a>
        </p>
      </div>
    </div>
  </footer>

  <!-- JavaScript to toggle tab content -->
  <script>
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');
    const searchInput = document.getElementById('searchInput');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.remove('active'));
        tab.classList.add('active');
        const target = tab.getAttribute('data-tab');
        document.getElementById(target).classList.add('active');
        filterTable(); // reset search after tab switch
      });
    });

   // Fonction de filtre sur la table active
    function filterTable() {
      const query = searchInput.value.toLowerCase();
      const activeTable = document.querySelector('.tab-content.active table');
      const rows = activeTable.querySelectorAll('tbody tr');

      rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
      });
    }

    searchInput.addEventListener('input', filterTable);
  </script>

</body>
</html>
