<?php
$api_url = "http://127.0.0.1:8000/status";
$json = @file_get_contents($api_url);
$clients = [];
if ($json !== false) {
    $data = json_decode($json, true);
    if (isset($data['clients'])) {
        $clients = $data['clients'];
    } elseif (isset($data[0]['name'])) {
        $clients = $data;
    }
}
date_default_timezone_set('Europe/Paris');
function pill($text, $class) {
    return '<span class="status-pill '.$class.'">'.$text.'</span>';
}
function ago($ts) {
    if (!$ts || $ts == 0) return "Jamais";
    return date('d/m/y H:i', $ts);
}
function backup_status_pill($last, $okText = "OK", $badText = "Pas de sauvegarde récente", $hoursLimit = 48) {
    if(empty($last) || $last == 0) return pill($badText, "patched");
    $hoursAgo = (time() - $last) / 3600;
    return $hoursAgo < $hoursLimit ? pill($okText, "active") : pill($badText, "patched");
}
?>

<?php include 'includes/header.php'; ?>

<main>
  <section class="devices-section" id="main-section">
    <h2 id="main-title">Statut des sauvegardes</h2>
    <div class="super-tabs">
      <input type="radio" id="tab-total" name="super-tab" checked>
      <label for="tab-total" class="super-tab">
        <span class="tab-label">TOTAL</span>
        <span class="tab-count"><?= count($clients) ?></span>
      </label>
      <input type="radio" id="tab-server" name="super-tab">
      <label for="tab-server" class="super-tab">
        <span class="tab-label">SERVEUR</span>
        <span class="tab-count">0</span>
      </label>
      <input type="radio" id="tab-workstation" name="super-tab">
      <label for="tab-workstation" class="super-tab">
        <span class="tab-label">POSTE DE TRAVAIL</span>
        <span class="tab-count"><?= count($clients) ?></span>
      </label>
      <span class="super-tab-indicator"></span>
    </div>

    <div class="device-table-container" id="clients-table-container">
      <div class="table-title-row">
        <span>Tous les clients de sauvegarde</span>
        <span class="devices-count"><?= count($clients) ?></span>
        <button class="quick-job-btn">Sauvegarde rapide</button>
        <button class="create-job-btn">Créer une tâche</button>
      </div>

      <div class="table-filtered-row">Filtré par : <b>Non filtré</b></div>

      <div class="table-responsive">
        <table class="devices-table" id="clients-table">
          <thead>
            <tr>
              <th></th>
              <th>ID Client</th>
              <th>Nom de l'ordinateur</th>
              <th>En ligne</th>
              <th>Dernière connexion</th>
              <th>Dernière sauvegarde fichiers</th>
              <th>Dernière sauvegarde image</th>
              <th>Statut sauvegarde fichiers</th>
              <th>Statut sauvegarde image</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($clients)): ?>
            <tr><td colspan="9"><b>Erreur de connexion à l'API</b></td></tr>
          <?php else: ?>
            <?php foreach ($clients as $client): ?>
              <?php
                $id = htmlspecialchars($client['id']);
                $name = htmlspecialchars($client['name']);
                $online = !empty($client['online']) ? pill("Oui", "active") : pill("Non", "patched");
                $lastseen = ago($client['lastseen'] ?? 0);
                $last_file = ago($client['lastbackup'] ?? 0);
                $last_image = ago($client['lastbackup_image'] ?? 0);
                $file_status = backup_status_pill($client['lastbackup'] ?? 0);
                $img_status = backup_status_pill($client['lastbackup_image'] ?? 0, "OK", "Pas de sauvegarde récente", 24*7);
              ?>
              <tr class="pointer client-row" data-client-id="<?= $id ?>" data-client-name="<?= $name ?>">
                <td><input type="checkbox" class="client-select" data-id="<?= $id ?>"></td>
                <td><span class="id-pill"><?= $id ?></span></td>
                <td><span class="hostname"><?= $name ?></span></td>
                <td><?= $online ?></td>
                <td><?= $lastseen ?></td>
                <td><?= $last_file ?></td>
                <td><?= $last_image ?></td>
                <td><?= $file_status ?></td>
                <td><?= $img_status ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
      <div class="table-pagination">
        <button class="pagination-btn active">1</button>
        <select>
          <option>50 / page</option>
          <option>100 / page</option>
        </select>
      </div>
    </div>

    <div id="backups-table-container" class="device-table-container" style="display:none;"></div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="assets/js/main.js"></script>