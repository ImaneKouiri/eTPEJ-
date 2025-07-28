<?php include 'includes/protect.php'; ?>
<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TPEJ Portail</title>
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
  <style>
    h1 {
      max-width: 100%;
      text-align: center;
      padding: 0 20px;
      font-size: 6.8em;
      margin: 0;
      font-family: "Noto Serif Georgian", serif;
      font-optical-sizing: auto;
      font-weight: weight;
      font-style: normal;
      color: #f17f38;
    }
    
.admin-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 30px;
  margin-top: 50px;
}

.card {
  background-color: #d9d9d9;
  padding: 30px;
  border-radius: 10px;
  width: 450px;
  height: 350px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  transition: all 0.2s ease;
  text-decoration: none;
}
.card i {
  margin-top: 20px;
  margin-bottom: 70px;
  display: block;
  color: #333;
}
.card h3 {
  font-family: "Inter", sans-serif;
  font-optical-sizing: auto;
  font-weight: weight;
  font-style: normal;
  font-size: 18px;
  color: #f17f38;
  margin-bottom: 35px;
}

.card p {
  font-family: "Inter", sans-serif;
  font-optical-sizing: auto;
  font-weight: weight;
  font-style: normal;
  font-size: 18px;
  color: #000000;
  margin-bottom: 5px;
}

.card:hover {
  box-shadow: 0 6px 12px rgba(0,0,0,0.1);
  transform: translateY(-5px);
  color: inherit;
  text-decoration: none;
}
  </style>
</head>
<body>
  <h1>Tableau de bord</h1>
  <div class="admin-cards">
      <a href="admin_planning.php" class="card">
        <i class="fa-solid fa-calendar-check fa-2x"></i>
        <h3>Planning du personnel</h3>
        <p>Organiser les présences, absences, réunions et événements de la semaine.</p>
      </a>
      <a href="admin_documents.php" class="card">
        <i class="fa-solid fa-file-lines fa-2x"></i>
        <h3>Documents administratifs</h3>
        <p>Ajouter, modifier ou supprimer les notes de service, règlements, formulaires, etc.</p>
      </a>
      <a href="admin_annonces.php" class="card">
        <i class="fa-solid fa-bullhorn fa-2x"></i>       
        <h3>Annonces internes</h3>
        <p>Gérer les messages internes, les annonces urgentes et les réunions programmées.</p>
      </a>
  </div>
</body>
</html>
<?php include 'includes/footer.php'; ?>