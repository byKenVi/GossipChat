const socket = io("http://localhost:3000");

socket.on("connect", () => {
  console.log("Connecté à Socket.io !");
});

// Like
document.querySelectorAll(".like-btn").forEach(btn => {
  btn.addEventListener("click", () => {
    const postId = btn.dataset.postid;
    const userId = btn.dataset.userid;
    console.log('postId:', postId, 'userId:', userId);
    fetch('../public/like_post.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `postId=${postId}&userId=${userId}`
    })
    .then(response => response.json())
    .then(data => {
      const likeCounter = document.querySelector(`#likes-${postId}`);
      if (likeCounter) {
        likeCounter.textContent = data.likes;
      }
      // Tu peux aussi émettre un événement Socket.io ici pour les autres clients
      socket.emit("like", { postId, userId });
    })
    .catch(console.error);
  });
});

// Réagir aux likes venant des autres
socket.on("likeUpdate", (data) => {
  const likeCounter = document.querySelector(`#likes-${data.postId}`);
  if (likeCounter && data.likes !== undefined) {
    likeCounter.textContent = data.likes; // Utilise la valeur exacte
  }
});

// Commentaire
document.querySelectorAll(".comment-form").forEach(form => {
  form.addEventListener("submit", e => {
    e.preventDefault();
    const postId = form.dataset.postid;
    const userId = form.dataset.userid;
    const input = form.querySelector("input");
    const commentText = input.value.trim();
    if (commentText) {
      socket.emit("comment", { postId, userId, commentText });
      input.value = "";
    }
  });
});

// Réagir aux commentaires venant des autres
socket.on("commentUpdate", (data) => {
  const commentBox = document.querySelector(`#comments-${data.postId}`);
  if (commentBox) {
    const p = document.createElement("p");
    p.textContent = data.commentText;
    commentBox.appendChild(p);
  }
});

