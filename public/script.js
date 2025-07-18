// script.js corrigé avec console.log pour debug des publications temps réel
function formatHeure(dateStr) {
  const d = new Date(dateStr);
  return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}
let destinataire_id_messagerie = null;
let destinataire_username = null;
const postsContainer = document.getElementById('posts-container');

console.log("✅ Connexion Socket.IO en cours...");

// Charger les posts au chargement initial
function loadPosts() {
  fetch('../public/get_post.php')
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        postsContainer.innerHTML = '';
        data.posts.forEach(post => {
          const postElement = createPostElement(post);
          postsContainer.appendChild(postElement);
        });
      } else {
        console.error("❌ Erreur dans la réponse get_post.php", data);
      }
    })
    .catch(err => console.error("❌ Erreur fetch get_post.php:", err));
}

loadPosts();

function createPostElement(post) {
  const div = document.createElement('div');
  div.classList.add('post');

  const userName = post.username;
  const media = post.media_path ? (post.media_type === 'image' ?
    `<img class="post-media" src="${post.media_path}" alt="media" />` :
    `<video class="post-media" src="${post.media_path}" controls></video>`) : '';

  div.innerHTML = `
    <p><strong>${userName}</strong></p>
    <p>${post.description}</p>
    ${media}
    <button class="like-btn" data-postid="${post.id}">❤️ Like</button>
    <span id="likes-${post.id}">${post.like_count ?? 0}</span>
    <button class="comment-icon" data-postid="${post.id}">💬 Commenter</button>
  `;

  div.querySelector('.like-btn').addEventListener('click', handleLike);
  div.querySelector('.comment-icon').addEventListener('click', openCommentPopup);

  return div;
}

function handleLike(e) {
  const btn = e.target.closest('button');
  const postId = btn.dataset.postid;

  fetch('../public/like_post.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `postId=${postId}`
  })
  .then(res => res.json())
  .then(data => {
    console.log("🔁 Like réponse:", data);
    const counter = document.getElementById(`likes-${data.postId}`);
    const button = document.querySelector(`.like-btn[data-postid="${data.postId}"]`);

    if (counter) counter.textContent = data.likes;
    if (button) button.style.color = data.action === 'liked' ? 'blue' : 'black';

    socket.emit('like', data);
  })
  .catch(console.error);
}

socket.on('likeUpdate', data => {
  console.log("📡 Like reçu via WebSocket:", data);
  const counter = document.getElementById(`likes-${data.postId}`);
  const button = document.querySelector(`.like-btn[data-postid="${data.postId}"]`);

  if (counter) counter.textContent = data.likes;
  if (button) button.style.color = data.action === 'liked' ? 'blue' : 'black';
});

let currentPostId = null;

function openCommentPopup(e) {
  const postId = e.target.dataset.postid;
  currentPostId = postId;
  console.log("💬 Ouverture popup commentaire pour le post:", postId);

  const popup = document.getElementById('comment-popup');
  if (popup) {
    popup.style.display = 'block';
    loadComments(postId);
  }
}

function closeCommentPopup() {
  const popup = document.getElementById('comment-popup');
  if (popup) popup.style.display = 'none';
}

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

function addCommentToList(username, comment) {
  const p = document.createElement('p');
  p.textContent = `${username}: ${comment}`;
  document.getElementById('comment-list').appendChild(p);
}

// Envoi du commentaire

document.getElementById('submit-comment')?.addEventListener('click', () => {
  const content = document.getElementById('comment-input').value.trim();
  if (!content || !currentPostId) return;

  fetch('../public/comment_post.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `postId=${currentPostId}&comment=${encodeURIComponent(content)}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      console.log("✏️ Commentaire envoyé:", data);
      document.getElementById('comment-input').value = '';
      socket.emit('newComment', {
        postId: currentPostId,
        username: data.username,
        comment: data.comment
      });
      addCommentToList(data.username, data.comment);
    }
  })
  .catch(console.error);
});

socket.on('newComment', data => {
  console.log("📡 Commentaire reçu:", data);
  const popupVisible = document.getElementById("comment-popup").style.display === "block";
  if (popupVisible && parseInt(data.postId) === parseInt(currentPostId)) {
    addCommentToList(data.username, data.comment);
  }
});

// Soumission du post (création)

document.getElementById('post-form')?.addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  fetch('../public/post_article.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success && data.post) {
      console.log("📤 Nouveau post publié localement:", data.post);
      const postElement = createPostElement(data.post);
      postsContainer.prepend(postElement);

      socket.emit("newPost", data.post);
    }
  })
  .catch(console.error);
});

// Réception d'un post émis par un autre utilisateur
socket.on("newPost", post => {
  console.log("📥 Post reçu via WebSocket:", post);
  if (parseInt(post.user_id) !== parseInt(USER_ID)) {
    const postElement = createPostElement(post);
    postsContainer.prepend(postElement);
  }
});

let notifCount = 0;
const notifBadge = document.getElementById('notifCount');
const notifMenu = document.getElementById('notifMenu');

function addNotification(content) {
    notifCount++;
    notifBadge.textContent = notifCount;
    notifBadge.style.display = 'inline-block';

    const p = document.createElement('p');
    p.textContent = content;
    notifMenu.appendChild(p);
}

// Exemple : quand un message est reçu
socket.on("newMessage", (msg) => {
    if (parseInt(msg.destinataire_id) === parseInt(USER_ID)) {
        addNotification(`Nouveau message de ${msg.pseudo}`);
    }
});

document.getElementById('notifIcon').addEventListener('click', () => {
    notifCount = 0;
    notifBadge.style.display = 'none';
});
