// index.js – Serveur WebSocket + HTTP Express

const express = require('express');
const http = require('http');
const path = require('path');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = new Server(server);

//  Rendre les fichiers statiques accessibles (HTML, JS client)
app.use(express.static(path.join(__dirname, 'public')));

//  Route de test
app.get('/', (req, res) => {
  res.send('✅ Serveur WebSocket GossipChat en ligne !');
});

//  Gestion des connexions WebSocket
io.on('connection', (socket) => {
  console.log('🟢 Un utilisateur connecté via WebSocket');

  //  Nouveau post
  socket.on('newPost', (post) => {
    console.log('📥 Nouveau post reçu:', post);
    socket.broadcast.emit('newPost', post);
  });

  //  Nouveau commentaire
  socket.on('newComment', (data) => {
    console.log('💬 Nouveau commentaire:', data);
    socket.broadcast.emit('newComment', data);
  });

  //  Nouveau like
  socket.on('like', (data) => {
    console.log('👍 Like reçu:', data);
    socket.broadcast.emit('likeUpdate', data);
  });

  // 📩 Nouveau message (notifications)
  socket.on('newMessage', (msg) => {
    console.log('📨 Nouveau message:', msg);
    socket.broadcast.emit('newMessage', msg);
  });

  //  Déconnexion
  socket.on('disconnect', () => {
    console.log(' Utilisateur déconnecté');
  });
});

// 🚀 Lancement du serveur
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
  console.log(`🚀 GossipChat WebSocket Server démarré sur le port ${PORT}`);
});
