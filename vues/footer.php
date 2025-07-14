<script>
  const socket = io("http://localhost:3000");
  const USER_ID = <?= json_encode($userId) ?>;

  document.getElementById('msgIcon').addEventListener('click', () => {
    document.getElementById('messageriePanel').style.right = '0';
  });
  document.getElementById('closeMsg').addEventListener('click', () => {
    document.getElementById('messageriePanel').style.right = '-300px';
  });

  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');

  let timeout = null;

  searchInput.addEventListener('input', () => {
    clearTimeout(timeout);
    const query = searchInput.value.trim();

    if (query.length < 2) {
      searchResults.innerHTML = '';
      searchResults.style.display = 'none';
      return;
    }

    timeout = setTimeout(() => {
      fetch(`../api/search_users.php?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
          if (data.error) {
            searchResults.innerHTML = `<div class="no-results">${data.error}</div>`;
          } else if (data.results.length === 0) {
            searchResults.innerHTML = `<div class="no-results">Aucun utilisateur trouvé</div>`;
          } else {
            searchResults.innerHTML = data.results.map(user => `
              <div class="search-result-item" onclick="goToProfile(${user.id})">
                <strong>${user.prenom} ${user.nom}</strong><br>
                <small>${user.email}</small>
              </div>
            `).join('');
          }
          searchResults.style.display = 'block';
        })
        .catch(() => {
          searchResults.innerHTML = `<div class="no-results">Erreur de recherche</div>`;
          searchResults.style.display = 'block';
        });
    }, 300);
  });

  function goToProfile(userId) {
    window.location.href = `../vues/profil.php?id=${userId}`;
  }

  document.addEventListener('click', (e) => {
    if (!searchResults.contains(e.target) && e.target !== searchInput) {
      searchResults.style.display = 'none';
    }
  });
</script>
<script src="../public/script.js"></script>
<script src="../public/messagerie.js"></script>
