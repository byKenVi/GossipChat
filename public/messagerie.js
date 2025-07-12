// messagerie.js — nouvelle version intégrée dans la sidebar

let currentChatUserId = null;
let currentChatUsername = null;

function formatHeure(dateStr) {
  const d = new Date(dateStr);
  return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

function openChatWith(userId, username) {
  currentChatUserId = userId;
  currentChatUsername = username;

  // Si .messagerie-body existe (dans social_media.php), utilise-la
  const panel = document.querySelector('.messagerie-body');
  if (panel) {
    // version slide (dans social_media.php)
    const userItem = document.querySelector(`.message-user[onclick*="${userId}"]`);
    if (userItem) {
      userItem.classList.remove('new-message');
    }

    panel.innerHTML = `
      <div class="chat-header">
        <button onclick="loadUserList()">← Retour</button>
        <span>Discussion avec <strong>${username}</strong></span>
      </div>
      <div class="chat-messages" id="chat-messages"></div>
      <div class="chat-input">
        <input type="text" id="chat-input" placeholder="Votre message...">
        <button onclick="sendMessage()">Envoyer</button>
      </div>
    `;
  } else {
    // version chatBox (amis.php ou autre)
    document.getElementById("chatBox").style.display = 'block';
    document.getElementById("chat-username").textContent = username;
    document.getElementById("chat-messages").innerHTML = '';
  }

  // Charger les messages
  fetch(`../public/get_messages.php?destinataire_id=${userId}`)
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById('chat-messages');
      if (!container) return;
      container.innerHTML = '';
      if (data.success) {
        data.messages.forEach(msg => {
          addMessageToChat(msg.expediteur_pseudo, msg.contenu, msg.date_envoi);
        });
      }
    })
    .catch(console.error);
}


function loadUserList() {
  fetch('../public/get_users.php')
    .then(res => res.json())
    .then(data => {
      const panel = document.querySelector('.messagerie-body');
      if (!panel) return;

      panel.innerHTML = '<h3>Utilisateurs disponibles</h3>';

      data.users.forEach(user => {
        // Ne pas se lister soi-même
        if (user.id != USER_ID) {
          const div = document.createElement('div');
          div.className = 'message-user';
          div.textContent = user.pseudo;
          div.onclick = () => openChatWith(user.id, user.pseudo);
          panel.appendChild(div);
        }
      });
    })
    .catch(console.error);
}


function addMessageToChat(pseudo, contenu, date) {
  const container = document.getElementById('chat-messages');
  if (!container) return;

  const msg = document.createElement('div');
  msg.className = 'chat-message';
  msg.innerHTML = `
    <strong>${pseudo}</strong><br>
    <span class="msg-contenu">${contenu}</span>
    <span class="msg-date">${formatHeure(date)}</span>
  `;
  container.appendChild(msg);
  container.scrollTop = container.scrollHeight;
}


function sendMessage() {
  const input = document.getElementById('chat-input');
  const message = input.value.trim();
  if (!message || !currentChatUserId) return;

  fetch('../public/send_message.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `destinataire_id=${currentChatUserId}&contenu=${encodeURIComponent(message)}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      addMessageToChat(data.pseudo, data.contenu, data.date);
      socket.emit("newMessage", {
        expediteur_id: data.expediteur_id,
        destinataire_id: data.destinataire_id,
        contenu: data.contenu,
        pseudo: data.pseudo,
        date: data.date
      });
      input.value = '';
    }
  })
  .catch(console.error);
}

socket.on("newMessage", (msg) => {
  console.log("📩 Nouveau message reçu via socket:", msg);

  const isIncoming = parseInt(msg.destinataire_id) === parseInt(USER_ID);
  const isCurrentChat = parseInt(msg.expediteur_id) === parseInt(currentChatUserId);

  if (isIncoming && isCurrentChat) {
    addMessageToChat(msg.pseudo, msg.contenu, msg.date);
  } else if (isIncoming) {
    const userItem = document.querySelector(`.message-user[onclick*="${msg.expediteur_id}"]`);
    if (userItem) userItem.classList.add("new-message");
  }
 
});



