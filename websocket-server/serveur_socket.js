const express = require("express");
const http = require("http");
const { Server } = require("socket.io");
const path = require("path");

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
  cors: { origin: "*", methods: ["GET", "POST"] }
});

// Sert la page HTML
app.use(express.static(path.join(__dirname, "../public")));

io.on("connection", (socket) => {
  console.log("Client connecté :", socket.id);

  socket.on("like", data => {
    io.emit("likeUpdate", data);
  });

  socket.on("comment", data => {
    io.emit("commentUpdate", data);
  });

  socket.on("disconnect", () => {
    console.log("Déconnecté :", socket.id);
  });
});

server.listen(3000, () => {
  console.log("Serveur WebSocket prêt sur http://localhost:3000");
});
// Pour tester, ouvrez plusieurs onglets et interagissez avec les likes et commentaires
// Vous devriez voir les mises à jour en temps réel dans tous les onglets ouverts.  