// ws-client.js

// Connexion au serveur WebSocket
const socket = io("http://localhost:3000"); // Change en domaine réel en prod

// Envoyer un nouveau post
function envoyerPost(postData) {
  socket.emit('nouveau_post', postData);
}

// Envoyer un like
function envoyerLike(likeData) {
  socket.emit('like', likeData);
}

// Envoyer un commentaire
function envoyerCommentaire(commentaireData) {
  socket.emit('commentaire', commentaireData);
}

// Réception d’un nouveau post
socket.on('post_recu', postData => {
  afficherNouveauPost(postData);
});

// Réception d’un like
socket.on('like_recu', likeData => {
  mettreAJourLike(likeData);
});

// Réception d’un commentaire
socket.on('commentaire_recu', commentaireData => {
  ajouterCommentaire(commentaireData);
});
