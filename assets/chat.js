document.addEventListener('DOMContentLoaded', function () {
  const chatBox = document.getElementById('chatBox');
  const form = document.getElementById('chatForm');
  const input = document.getElementById('message');

  function fetchMessages() {
    fetch('fetch_messages.php')
      .then(res => res.json())
      .then(data => {
        chatBox.innerHTML = data.map(m => `<p><strong>${m.pseudo}</strong> : ${m.contenu}</p>`).join('');
        chatBox.scrollTop = chatBox.scrollHeight;
      });
  }

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    fetch('send_message.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'message=' + encodeURIComponent(input.value)
    }).then(() => {
      input.value = '';
      fetchMessages();
    });
  });

  setInterval(fetchMessages, 3000);
  fetchMessages();
});

