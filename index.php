<!-- Popup HTML -->
<div id="updatePopup" class="update-popup">
  <p>È disponibile una nuova versione del sito. Aggiornare?</p>
  <button id="refreshBtn">Aggiorna</button>
  <button id="closeBtn">Chiudi</button>
</div>

<!-- Popup CSS (usa colori e font del tuo stile) -->
<style>
.update-popup {
  font-family: "Segoe UI", sans-serif;
  position: fixed;
  top: 20px;
  right: 20px;
  background: #ffffff;
  color: #111827;
  border-radius: 12px;
  padding: 20px 25px;
  width: 300px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  display: none;
  z-index: 9999;
  animation: fadeIn 0.5s ease-out;
}

.update-popup p {
  margin-bottom: 15px;
  font-weight: 600;
}

.update-popup button {
  background: linear-gradient(135deg, #6366f1, #3b82f6);
  border: none;
  padding: 10px 15px;
  color: white;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  margin-right: 10px;
  transition: 0.2s ease;
}

.update-popup button:hover {
  background: linear-gradient(135deg, #4f46e5, #2563eb);
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>

<!-- JS per mostrare il popup -->
<script>
function showUpdatePopup() {
  const popup = document.getElementById('updatePopup');
  popup.style.display = 'block';

  document.getElementById('refreshBtn').onclick = () => {
    location.reload(true);
  };

  document.getElementById('closeBtn').onclick = () => {
    popup.style.display = 'none';
  };
}

// Esempio: mostra popup dopo 2 secondi (qui puoi collegarlo al check_version.php)
setTimeout(showUpdatePopup, 2000);
</script>