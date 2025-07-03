<?php include 'includes/header.php'; ?>

<main class="devices-section">
  <h2>Tableau de bord</h2>

  <!-- Super Tabs -->
  <div class="super-tabs">
    <input type="radio" id="tab-total" name="device-tabs" checked>
    <label for="tab-total" class="super-tab"><span class="tab-label">Total</span><span class="tab-count">12</span></label>

    <input type="radio" id="tab-server" name="device-tabs">
    <label for="tab-server" class="super-tab"><span class="tab-label">Serveurs</span><span class="tab-count">5</span></label>

    <input type="radio" id="tab-workstation" name="device-tabs">
    <label for="tab-workstation" class="super-tab"><span class="tab-label">Postes</span><span class="tab-count">7</span></label>

    <div class="super-tab-indicator"></div>
  </div>

  <!-- Tableau des appareils -->
  <div class="device-table-container">
    <div class="table-title-row">
      Tous les appareils
      <span class="devices-count">12</span>
      <button class="quick-job-btn">Quick job</button>
      <button class="create-job-btn">Créer un job</button>
    </div>
    <div class="table-filtered-row">
      Affichage de tous les appareils
    </div>

    <div class="table-responsive">
      <table class="devices-table">
        <thead>
          <tr>
            <th>Nom d'hôte</th>
            <th>Adresse IP</th>
            <th>Type</th>
            <th>Status</th>
            <th>Dernière sauvegarde</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><a href="#" class="hostname active">srv-web-01</a></td>
            <td>192.168.1.10</td>
            <td>Serveur</td>
            <td><span class="status-pill active">Actif</span></td>
            <td>2025-06-29</td>
          </tr>
          <tr>
            <td><a href="#" class="hostname">pc-admin-02</a></td>
            <td>192.168.1.25</td>
            <td>Poste</td>
            <td><span class="status-pill up-to-date">À jour</span></td>
            <td>2025-06-28</td>
          </tr>
          <tr>
            <td><a href="#" class="hostname">srv-db-03</a></td>
            <td>192.168.1.15</td>
            <td>Serveur</td>
            <td><span class="status-pill patched">Patché</span></td>
            <td>2025-06-27</td>
          </tr>
          <!-- Ajouter plus de lignes selon besoin -->
        </tbody>
      </table>
    </div>

    <div class="table-pagination">
      <button class="pagination-btn active">1</button>
      <button class="pagination-btn">2</button>
      <button class="pagination-btn">3</button>
      <select>
        <option>10 par page</option>
        <option>20 par page</option>
        <option>50 par page</option>
      </select>
    </div>

  </div>
</main>

<?php include 'includes/footer.php'; ?>