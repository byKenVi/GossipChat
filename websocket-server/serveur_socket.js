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
  console.log("Connecté :", socket.id);

  // Logique quand un utilisateur like une publication
  socket.on("like", (data) => {
    console.log("Like reçu :", data);
    io.emit("likeUpdate", data); // Diffuse à tous les clients
  });

  socket.on('newComment', (data) => {
     socket.broadcast.emit('newComment', data); // broadcast à tous
  });

  socket.on("newPost", (data) => {
  io.emit("newPost", data); // envoie à tous
});


  socket.on("disconnect", () => {
    console.log("Déconnecté :", socket.id);
  });
});

server.listen(3000, () => {
  console.log("WebSocket server running on http://localhost:3000");
});
