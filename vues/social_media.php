<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion.php');
    exit;
}
$pseudo = htmlspecialchars($_SESSION['user_pseudo']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>GossipChat - Accueil</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow p-4 flex items-center justify-between sticky top-0 z-50">
    <div class="flex items-center space-x-4">
      <img src="../assets/images/logochat.png" alt="Logo" class="w-10 h-10" />
      <input type="search" placeholder="Rechercher sur GossipChat" class="hidden md:block border rounded px-3 py-1 focus:outline-none focus:ring focus:ring-purple-500" />
    </div>

    <div class="flex items-center space-x-6">
      <a href="#" class="hover:text-purple-700 font-semibold">Accueil</a>
      <a href="#" class="hover:text-purple-700">Profil</a>
      <a href="#" class="hover:text-purple-700">Messages</a>
      <a href="#" class="hover:text-purple-700">Notifications</a>

      <div class="relative group">
        <button class="flex items-center space-x-2 focus:outline-none">
          <span><?php echo $pseudo; ?></span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <!-- Dropdown -->
        <div class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none group-hover:pointer-events-auto">
          <a href="../deconnexion.php" class="block px-4 py-2 hover:bg-gray-100">Se déconnecter</a>
        </div>
      </div>
    </div>
  </nav>

  <div class="container mx-auto px-4 py-6 flex flex-col lg:flex-row gap-6">

    <!-- Sidebar gauche -->
    <aside class="lg:w-1/4 bg-white rounded shadow p-4 sticky top-16 h-fit">
      <ul class="space-y-3 text-gray-700">
        <li><a href="#" class="hover:text-purple-700 font-semibold">Fil d'actualité</a></li>
        <li><a href="#" class="hover:text-purple-700">Amis</a></li>
        <li><a href="#" class="hover:text-purple-700">Groupes</a></li>
        <li><a href="#" class="hover:text-purple-700">Événements</a></li>
        <li><a href="#" class="hover:text-purple-700">Paramètres</a></li>
      </ul>
    </aside>

    <!-- Contenu principal -->
    <main class="lg:w-2/4 space-y-6">

      <!-- Création de post -->
      <section class="bg-white rounded shadow p-4">
        <textarea placeholder="À quoi pensez-vous ?" class="w-full border rounded p-3 resize-none" rows="3"></textarea>
        <div class="flex justify-end mt-2">
          <button class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Publier</button>
        </div>
      </section>

      <!-- Posts -->
      <section class="space-y-4">
        <?php
        // Exemple simple de posts statiques
        $posts = [
          ['author' => 'Alice', 'content' => 'Salut tout le monde, bienvenue sur GossipChat!', 'date' => '2025-07-01 10:15'],
          ['author' => 'Bob', 'content' => 'Quel temps magnifique aujourd’hui.', 'date' => '2025-07-01 09:45'],
        ];
        foreach ($posts as $post):
        ?>
          <article class="bg-white rounded shadow p-4">
            <div class="flex items-center space-x-3 mb-2">
              <div class="w-10 h-10 rounded-full bg-purple-400 flex items-center justify-center text-white font-bold uppercase">
                <?php echo strtoupper($post['author'][0]); ?>
              </div>
              <div>
                <h3 class="font-semibold"><?php echo htmlspecialchars($post['author']); ?></h3>
                <time class="text-gray-500 text-xs"><?php echo date('d/m/Y H:i', strtotime($post['date'])); ?></time>
              </div>
            </div>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
          </article>
        <?php endforeach; ?>
      </section>

    </main>

    <!-- Sidebar droite -->
    <aside class="lg:w-1/4 bg-white rounded shadow p-4 sticky top-16 h-fit">
      <h3 class="font-semibold mb-4">Amis en ligne</h3>
      <ul class="space-y-3">
        <li><a href="#" class="block hover:text-purple-700">Clara</a></li>
        <li><a href="#" class="block hover:text-purple-700">David</a></li>
        <li><a href="#" class="block hover:text-purple-700">Emma</a></li>
      </ul>
      <h3 class="font-semibold mt-8 mb-4">Suggestions</h3>
      <ul class="space-y-3">
        <li><a href="#" class="block hover:text-purple-700">Jean</a></li>
        <li><a href="#" class="block hover:text-purple-700">Sophie</a></li>
      </ul>
    </aside>

  </div>

</body>
</html>
