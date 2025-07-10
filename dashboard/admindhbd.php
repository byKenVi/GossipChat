<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="src/style.css">
</head>
<body>
    <div class="sidebar">
    <h2>ADMIN</h2><br><br> 
    <ul>
      <a href="#"><li>Tableau de bord</li></a><br>
      <a href="#"><li>Utilisateur</li></a><br>
      <a href="#"><li>Signalement</li></a><br>
      <a href="<#"><li>Publication</li></a><br>
      <a href="#"><li>Gestion de rôle</li></a><br>
      <a href="<#"><li>Déconnexion</li></a><br>
    </ul>
  </div>

  <div class="main">
    <!-- Stats -->
    <div class="cards">
      <div class="card">
        <h4>Nombre de utilisateurs</h4>
        <p><strong>1200</strong></p>
      </div>
      <div class="card">
        <h4>Nombre de publications</h4>
        <p><strong>3500</strong></p>
      </div>
      
      <div class="card">
        <h4>Nombre de commentaires</h4>
        <p><strong>9800</strong></p>
      </div>
      <div class="card">
        <h4>Nombre de signalements</h4>
        <p><strong>75</strong></p>
      </div>
    </div>
     <div class="sections">
    <!-- Gestion des utilisateurs -->
    <div class="section">
      <h3>Gestion des utilisateurs</h3>
      <div class="user-list">
        <div class="user-item">
          <span>Utilisateur1</span>
          <button class="btn btn-danger">Supprimer</button>
        </div>
        <div class="user-item">
          <span>Utilisateur2</span>
          <button class="btn btn-danger">Supprimer</button>
        </div>
        <div class="user-item">
          <span>Utilisateur3</span>
          <button class="btn btn-danger">Supprimer</button>
        </div>
        <div class="user-item">
          <span>Utilisateur4</span>
          <button class="btn btn-danger">Supprimer</button>
        </div>
      </div>
    </div>

    <!-- Signalements -->
    <div class="section">
      <h3>Signalements de publications</h3>
      <div class="report-list">
        <div class="report-item">
          <div class="board">
            <strong>Publication1</strong><br />
             contenu inapproprié
            <button class="btn btn-danger">Supprimer</button>
            <button class="btn btn-secondary">Ignorer</button>
          </div>
        </div>
        <div class="report-item">
          <div  class="board-i">
            <strong> Publication2</strong><br />
               contenu inapproprié
          </div>
          <div>
            <button class="btn btn-danger">Supprimer</button>
            <button class="btn btn-secondary">Ignorer</button>
          </div>
        </div>
        <div class="report-item">
          <div class="board-i">
            <strong> Publication3</strong><br />
            contenu inapproprié
          </div>
          <div>
            <button class="btn btn-danger">Supprimer</button>
            <button class="btn btn-secondary">Ignorer</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
 
</body>
</html>