const socket = io("http://localhost:3000");

// Like handler
document.querySelectorAll(".like-btn").forEach(btn => {
  btn.addEventListener("click", () => {
    const postId = btn.dataset.postid;
    const userId = btn.dataset.userid;

    fetch('../public/like_post.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `postId=${postId}&userId=${userId}`
    })
    .then(res => res.json())
    .then(data => {
      const likeCounter = document.querySelector(`#likes-${postId}`);
      if (likeCounter && data.likes !== undefined) {
        likeCounter.textContent = data.likes;
      }
      socket.emit("like", data); // Envoie à tous
    })
    .catch(console.error);
  });
});

// Mise à jour en temps réel des likes
socket.on("likeUpdate", (data) => {
  const likeCounter = document.querySelector(`#likes-${data.postId}`);
  if (likeCounter && data.likes !== undefined) {
    likeCounter.textContent = data.likes;
  }
});

// Variables de suivi
let currentPostId = null;
let currentUserId = null;

// Ouverture du popup de commentaire
document.querySelectorAll('.comment-icon').forEach(icon => {
  icon.addEventListener('click', () => {
    currentPostId = icon.dataset.postid;
    currentUserId = icon.dataset.userid;

    document.getElementById('comment-popup').style.display = 'block';
    loadComments(currentPostId);
  });
});

function closeCommentPopup() {
  document.getElementById('comment-popup').style.display = 'none';
}

// Chargement des commentaires
function loadComments(postId) {
  fetch(`../public/get_comments.php?postId=${postId}`)
    .then(res => res.json())
    .then(comments => {
      const commentList = document.getElementById("comment-list");
      commentList.innerHTML = "";
      comments.forEach(comment => {
        addCommentToList(comment.pseudo, comment.contenu);
      });
    })
    .catch(console.error);
}

// Envoi d'un commentaire
document.getElementById('submit-comment').addEventListener('click', () => {
  const content = document.getElementById('comment-input').value.trim();
  if (!content || !currentPostId || !currentUserId) return;

  fetch('../public/comment_post.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `postId=${currentPostId}&userId=${currentUserId}&comment=${encodeURIComponent(content)}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      document.getElementById('comment-input').value = '';
      socket.emit('newComment', {
        postId: currentPostId,
        username: data.username,
        comment: data.comment
      });
      addCommentToList(data.username, data.comment); // Ajoute le commentaire à la liste
    }
  })
  .catch(console.error);
});

// Ajout d'un commentaire dans la liste
function addCommentToList(username, comment) {
  const p = document.createElement('p');
  p.textContent = `${username}: ${comment}`;
  document.getElementById('comment-list').appendChild(p);
}

// Réception en temps réel des commentaires
socket.on('newComment', data => {
  const popupVisible = document.getElementById("comment-popup").style.display === "block";
  if (popupVisible && parseInt(data.postId) === parseInt(currentPostId)) {
    addCommentToList(data.username, data.comment);
  }
});