<!DOCTYPE html>
<html lang="fr">
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
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

header {
  border-bottom: 1px solid #ccc; 
}

.nav-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 50px;
  height: 110px;
  position: relative;
}

.logo img {
  width: 200px;
  margin-top: 0; 
  max-height: 90px;
  object-fit: contain;
}

.nav {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}

.nav ul {
  display: flex;
  gap: 40px;
  list-style: none;
  margin-top: 30px;
}

.nav a {
  text-decoration: none;
  color: #222;
  font-size: 25px;
  font-family: "Poppins", sans-serif;
  font-weight: 400;
  font-style: normal;
}

  </style>
</head>
<body>
  <header>
    <div class="nav-content">
      <div class="logo">
        <img src="assets/logo.png" alt="Logo TGR">
      </div>
      <nav class="nav">
        <ul class="nav-links">
          <li><a href="/admin/dashboard.php">Accueil</a></li>
          <li><a href="/admin//admin_planning.php">Planning</a></li>
          <li><a href="/admin//admin_documents.php">Documents</a></li>
          <li><a href="/admin//admin_annonces.php">Annonces</a></li>
          <li><a href="/public/index.html">Portail</a></li>          
          <li><a href="/admin//logout.php">Déconnexion</a></li>
        </ul>
      </nav>
    </div>
  </header>
</body>
</html>
