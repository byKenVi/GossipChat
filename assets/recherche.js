document.getElementById('search').addEventListener('input', function () {
  const q = this.value;
  if (q.length < 2) return;
  fetch('api/search_users.php?q=' + encodeURIComponent(q))
    .then(res => res.json())
    .then(data => {
      document.getElementById('results').innerHTML = data.map(u =>
        `<p><strong>${u.pseudo}</strong> (${u.nom} ${u.prenom}) - ${u.email}</p>`
      ).join('');
    });
});