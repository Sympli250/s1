<?php
header('Content-Type: text/html; charset=utf-8');
?>
<?php include 'includes/header.php'; ?>

<main class="devices-section">
  <div class="main-content" style="max-width:800px;margin:auto;padding:36px 28px 64px 28px;background:#fff;border-radius:15px;box-shadow:0 5px 24px #A1D44B33;position:relative;">
    <div class="widget-version" style="position:absolute;top:24px;right:32px;background:#A1D44B;color:#fff;font-size:1.13em;font-weight:600;padding:5px 15px;border-radius:16px;box-shadow:0 1px 8px #A1D44B33;">Assistant AI v1.2</div>
    <h1 style="color:#219769;font-weight:700;font-size:2.2em;margin-top:0;">Assistant Symplissime AI</h1>
    <div class="widget-description" style="font-size:1.11em;color:#3c3c3c;margin-bottom:32px;margin-top:-15px;">
      Posez vos questions ou demandez de l’aide grâce à notre assistant IA intégré.<br>
      La fenêtre de discussion apparaît automatiquement au centre de la page.
    </div>
    <div id="debug-box" style="background:#e5ffe6;border:2px solid #81d44b;color:#235f30;font-family:monospace;font-size:1em;padding:10px 18px;margin:20px auto 0 auto;border-radius:10px;max-width:800px;min-height:32px;box-shadow:0 2px 8px #A1D44B33;white-space:pre-line;">[DEBUG] Chargement initial de la page PHP...</div>
    <div class="widget-container"></div>
  </div>
</main>

<!-- Widget AnythingLLM -->
<script
  data-embed-id="dbf689b8-c04a-4aa8-be2e-94cfa675a4a2"
  data-base-api-url="http://storage.symplissime.fr:3001/api/embed"
  data-greeting="SYMPLISSIME AI"
  data-chat-icon="support"
  data-no-sponsor="SYMPLISSIME3"
  data-sponsor-text="Symplissime"
  data-button-color="#25be70"
  data-assistant-bg-color="#25be70"
  data-assistant-name="Symplissime AI"
  data-auto-open="true"
  data-open-on-load="on"
  src="http://storage.symplissime.fr:3001/embed/anythingllm-chat-widget.min.js">
</script>

<script>
function debugLog(msg) {
  const debugBox = document.getElementById('debug-box');
  debugBox.textContent += "\n" + msg;
  console.log('[DEBUG]', msg);
}

debugLog('Script AnythingLLM inséré dans la page.');

function forceCenterAnythingLLM() {
  var modal = document.getElementById('anything-llm-chat');
  if (modal) {
    modal.classList.remove('allm-right-0', 'allm-bottom-0', 'allm-mr-4', 'allm-md:mr-4');
    modal.style.left = '50%';
    modal.style.top = '50%';
    modal.style.right = 'auto';
    modal.style.bottom = 'auto';
    modal.style.transform = 'translate(-50%, -50%)';
    modal.style.position = 'fixed';
    modal.style.margin = '0';
    modal.style.zIndex = '1000'; // <= INFERIEUR au header (2002)
    modal.style.maxWidth = "500px";
    modal.style.maxHeight = "700px";
    modal.style.width = "500px";
    modal.style.height = "650px";
    modal.style.borderRadius = "18px";
    modal.style.border = "2px solid #A1D44B";
    modal.style.background = "#fff";
    modal.style.boxShadow = "0 8px 40px #A1D44B44";
    debugLog("Widget détecté et centré !");
    return true;
  } else {
    debugLog("Widget non détecté dans le DOM à cette itération.");
    return false;
  }
}

let tries = 0;
const maxTries = 100;
const interval = setInterval(function() {
  tries++;
  if (forceCenterAnythingLLM() || tries > maxTries) {
    if (tries > maxTries) debugLog("Arrêt surveillance : widget introuvable après 30s.");
    clearInterval(interval);
  }
}, 300);

window.onerror = function(msg, url, line, col, error) {
  debugLog("Erreur JS : " + msg + " (" + url + ":" + line + ")");
};
</script>

<?php include 'includes/footer.php'; ?>