<?php include 'includes/header.php'; ?>

<main class="devices-section">
  <h2 class="text-2xl mb-6">Tableau de bord</h2>

  <!-- Super Tabs -->
  <div class="super-tabs" id="super-tabs-index">
    <input type="radio" id="tab-total" name="device-tabs" checked>
    <label for="tab-total" class="super-tab"><span class="tab-label">Total</span><span class="tab-count">12</span></label>

    <input type="radio" id="tab-server" name="device-tabs">
    <label for="tab-server" class="super-tab"><span class="tab-label">Serveurs</span><span class="tab-count">5</span></label>

    <input type="radio" id="tab-workstation" name="device-tabs">
    <label for="tab-workstation" class="super-tab"><span class="tab-label">Postes</span><span class="tab-count">7</span></label>

    <div class="super-tab-indicator"></div>
  </div>

  <!-- UrBackup Interface Container -->
  <div class="device-table-container">
    <div class="table-title-row">
      Interface UrBackup
      <span class="devices-count">12</span>
      <button class="quick-job-btn">Quick job</button>
      <button class="create-job-btn">Créer un job</button>
    </div>
    <div class="table-filtered-row">
      Affichage de l'interface UrBackup
    </div>

    <!-- UrBackup Iframe -->
    <div class="urbackup-iframe-container">
      <div class="iframe-header">
        <span class="iframe-status">État de connexion UrBackup</span>
        <input type="text" id="urbackup-url" value="http://localhost:55414" placeholder="URL du serveur UrBackup" style="margin-left: 20px; padding: 5px 10px; border: 1px solid #ccc; border-radius: 4px; width: 300px;">
        <button onclick="loadUrBackup()" style="margin-left: 10px; padding: 5px 15px; background: #219769; color: white; border: none; border-radius: 4px; cursor: pointer;">Charger</button>
      </div>
      <iframe 
        id="urbackup-iframe"
        src="http://localhost:55414" 
        width="100%" 
        height="600" 
        frameborder="0" 
        title="Interface UrBackup"
        style="border-radius: 8px; background: white;">
        <p>Votre navigateur ne supporte pas les iframes. Veuillez accéder directement à <a href="http://localhost:55414">l'interface UrBackup</a>.</p>
      </iframe>
    </div>

  </div>
</main>

<style>
.urbackup-iframe-container {
  padding: 20px;
  background: white;
  border-radius: 8px;
  margin: 0;
}

.iframe-header {
  display: flex;
  align-items: center;
  padding: 10px 0;
  border-bottom: 1px solid #e3e8ee;
  margin-bottom: 15px;
}

.iframe-status {
  font-weight: 600;
  color: #219769;
}

.urbackup-iframe-container iframe {
  width: 100%;
  min-height: 600px;
  border: 1px solid #e3e8ee;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(161, 212, 75, 0.15);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const tabsContainer = document.getElementById('super-tabs-index');
  const tabInputs = tabsContainer.querySelectorAll('input[name="device-tabs"]');
  const indicator = tabsContainer.querySelector('.super-tab-indicator');

  function updateIndicatorPosition() {
    const checkedTabLabel = tabsContainer.querySelector('input[name="device-tabs"]:checked + .super-tab');
    if (checkedTabLabel && indicator) {
      indicator.style.left = checkedTabLabel.offsetLeft + 'px';
      indicator.style.width = checkedTabLabel.offsetWidth + 'px';
    }
  }

  tabInputs.forEach(input => {
    input.addEventListener('change', updateIndicatorPosition);
  });

  // Initial calls on load
  updateIndicatorPosition();

  // Update indicator on window resize
  window.addEventListener('resize', updateIndicatorPosition);
});

function loadUrBackup() {
  const urlInput = document.getElementById('urbackup-url');
  const iframe = document.getElementById('urbackup-iframe');
  const url = urlInput.value.trim();
  
  if (url) {
    iframe.src = url;
  } else {
    alert('Veuillez entrer une URL valide pour le serveur UrBackup');
  }
}
</script>

<?php include 'includes/footer.php'; ?>