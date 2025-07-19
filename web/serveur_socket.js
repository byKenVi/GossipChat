// 📄 serveur_socket.js (Socket.io complet pour GossipChat)


const socket = io('https://gossipchat-b9kn.onrender.com', {
  transports: ['websocket']
});

const http = require("http");
const { Server } = require("socket.io");

const server = http.createServer();
const io = new Server(server, {
  cors: {
    origin: "*",
    methods: ["GET", "POST"]
  }
});

io.on("connection", (socket) => {
  console.log("✅ Utilisateur connecté:", socket.id);

  // Réception d’un nouveau like
  socket.on("like", (data) => {
    io.emit("likeUpdate", data);
  });

  // Réception d’un nouveau commentaire
  socket.on("newComment", (data) => {
    socket.broadcast.emit("newComment", data);
  });

  // Réception d’un nouveau post
  socket.on("newPost", (data) => {
    socket.broadcast.emit("newPost", data);
  });

  // 📩 Réception d’un nouveau message privé
  socket.on("newMessage", (msg) => {
    console.log("📩 Nouveau message reçu :", msg);
    io.emit("newMessage", msg); 
  });

  socket.on("disconnect", () => {
    console.log("❌ Utilisateur déconnecté:", socket.id);
  });
});

server.listen(3000, () => {
  console.log("Serveur Socket.io en cours d'exécution sur http://localhost:3000");
});
