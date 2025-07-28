<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TPEJ Portail</title>
  <link rel="stylesheet" href="planning.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400..900&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Lora:ital,wght@0,400..700;1,400..700&family=Noto+Serif+Georgian:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Georgia&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
      <h1>Planning hebdomadaire du personnel</h1>
      <p>Consulter la répartition des présences, absences et réunions pour la semaine en cours </p>
      
  </section>
  
  <section class="alert-box">
      <div class="alert-icon">
        <i class="fa-solid fa-triangle-exclamation"></i>
      </div>
      <span class="alert-text">Réunion générale vendredi à 10h - Salle 2</span>
  </section>
   <div class="planning-wrapper">
  <!-- TABLE -->
  <div class="planning-table">
    <table>
      <thead>
        <tr>
          <th>Jour</th>
          <th>Matin</th>
          <th>Après-midi</th>
          <th>Remarques</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Lundi</td>
          <td><i class="fa-solid fa-circle-check present"></i> M. AIT – Présent</td>
          <td><i class="fa-solid fa-circle-xmark conge"></i> Mme BEN – Congé</td>
          <td></td>
        </tr>
        <tr>
          <td>Mardi</td>
          <td><i class="fa-solid fa-circle-check present"></i> Mme SAID – Présente</td>
          <td><i class="fa-solid fa-circle-check present"></i> Tous – Présents</td>
          <td><i class="fa-regular fa-calendar-days reunion"></i> Réunion de coordination à 11h</td>
        </tr>
        <tr>
          <td>Mercredi</td>
          <td><i class="fa-solid fa-circle-check teletravail"></i> M. AIT – Télétravail</td>
          <td><i class="fa-solid fa-circle-check present"></i> Mme BEN – Présente</td>
          <td></td>
        </tr>
        <tr>
          <td>Jeudi</td>
          <td><i class="fa-solid fa-circle-check present"></i> Tous – Présents</td>
          <td><i class="fa-solid fa-circle-check present"></i> Tous – Présents</td>
          <td><i class="fa-regular fa-calendar-days reunion"></i> Formation TVA à 14h</td>
        </tr>
        <tr>
          <td>Vendredi</td>
          <td><i class="fa-solid fa-circle-check present"></i> Tous – Présents</td>
          <td><i class="fa-regular fa-calendar-days reunion"></i> Réunion de coordination</td>
          <td><i class="fa-regular fa-calendar-days reunion"></i> Réunion 10h (Salle 2)</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="planning-tools">
    <ul>
      <li><a href="documents/planning.pdf" download><i class="fa-solid fa-download"></i> Télécharger le planning en PDF</a></li>
    </ul>
  </div>

</div>
  <section class="legend">
    <div class="legend-title"><strong>Légende</strong></div>
    <div class="legend-item"><i class="fa-solid fa-circle-xmark conge"></i> Congé</div>
    <div class="legend-item"><i class="fa-solid fa-circle-check present"></i> Présent</div>
    <div class="legend-item"><i class="fa-solid fa-circle-check teletravail"></i> Télétravail</div>
    <div class="legend-item"><i class="fa-regular fa-calendar-days reunion"></i> Réunion/Formation</div>
  </section>



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
</body>
</html>
