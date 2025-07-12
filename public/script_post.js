// const socket = io("http://localhost:3000");

// Chargement initial des posts
window.addEventListener("DOMContentLoaded", () => {
  fetch('../public/get_post.php')
    .then(res => res.json())
    .then(posts => {
      posts.forEach(post => {
        afficherPost(post, false); // false = chargement initial
      });
    })
    .catch(console.error);
});

// Réception d’un nouveau post en temps réel
socket.on("newPost", post => {
  afficherPost(post, true); // true = nouveau post en temps réel
});

// Fonction pour afficher un post dans le fil
function afficherPost(post, nouveau = false) {
  const mediaHTML = post.media_path
    ? (post.media_type === 'image'
        ? `<img src="${post.media_path}" class="post-img" />`
        : `<video src="${post.media_path}" class="post-img" controls></video>`)
    : "";

  const html = `
    <div class="post">
      <div class="post-header"><strong>${post.pseudo}</strong><br />${post.date_publication}</div>
      <p>${post.description}</p>
      ${mediaHTML}
      <div class="post-actions">
        <button class="like-btn" data-postid="${post.id}" data-userid="${post.utilisateur_id}">
          <img src="../img/like.png" alt="Like">
        </button>
        <span id="likes-${post.id}">${post.nombre_likes ?? 0}</span>
        <img src="../img/comment.png" alt="Comment" class="comment-icon" data-postid="${post.id}" data-userid="${post.utilisateur_id}" style="cursor:pointer; width:24px;" />
        <img src="../img/share.png" alt="Share" style="cursor:pointer; width:24px;" />
      </div>
    </div>
  `;

  const postElement = document.createElement('div');
postElement.innerHTML = html;

// Ajout dynamique dans le feed
const container = document.querySelector('.posts-container');
nouveau ? container.prepend(postElement) : container.appendChild(postElement);

// 👉 Attache les événements pour ce post
attacherEvenements(postElement);

}

// Gestion de la publication
document.getElementById('post-form').addEventListener('submit', function (e) {
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
      socket.emit("newPost", data.post); // Notifie les autres
      form.reset(); // Nettoie le formulaire
    }
  })
  .catch(console.error);
});
function attacherEvenements(postElement) {
  const likeBtn = postElement.querySelector(".like-btn");
  const commentIcon = postElement.querySelector(".comment-icon");

  if (likeBtn) {
    likeBtn.addEventListener("click", () => {
      const postId = likeBtn.dataset.postid;
      const userId = likeBtn.dataset.userid;

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
        socket.emit("like", data); // Pour tous les autres clients
      })
      .catch(console.error);
    });
  }

  if (commentIcon) {
    commentIcon.addEventListener("click", () => {
      currentPostId = commentIcon.dataset.postid;
      currentUserId = commentIcon.dataset.userid;

      document.getElementById('comment-popup').style.display = 'block';
      loadComments(currentPostId);
    });
  }
}
