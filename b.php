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
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Symplissime - Statut des Sauvegardes</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap" rel="stylesheet">
  <style>
    .pointer { cursor:pointer; }
    .back-btn { background: #E9F7E6; color:#219769; border:none; padding:7px 16px; border-radius:5px; margin-bottom:18px; font-size:.95em; cursor:pointer; font-weight:600;}
    .back-btn:hover { background: #60C36A; color: #fff; }
    .id-pill {
      background: #A1D44B;
      color: #fff;
      border-radius: 12px;
      padding: 2px 10px;
      font-size: .96em;
      font-weight: 700;
      margin-right: 2px;
      letter-spacing: 1px;
      display: inline-block;
      min-width: 28px;
      text-align: center;
    }
  </style>
</head>
<body>
<header>
  <nav class="navbar">
    <div class="logo"><img src="logo.png" alt="Symplissime" style="height:40px; width:auto;"></div>
    <ul>
      <li><a href="#"><img src="icon1.svg" alt=""> Accueil</a></li>
      <li><a href="#"><img src="icon2.svg" alt=""> Mes ordinateurs</a></li>
      <li><a href="#"><img src="icon3.svg" alt=""> Mes sauvegardes</a></li>
      <li><a href="#"><img src="icon4.svg" alt=""> Boutique</a></li>
      <li><a href="#"><img src="icon5.svg" alt=""> Symplissime AI</a></li>
      <li><a href="#"><img src="icon6.svg" alt=""> Mon compte</a></li>
    </ul>
  </nav>
</header>
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
                $file_status = backup_status_pill($client['lastbackup'] ?? 0, "OK", "Pas de sauvegarde récente");
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
    <!-- Container for backups list, filled dynamically -->
    <div class="device-table-container" id="backups-table-container" style="display:none"></div>
  </section>
</main>
<footer>
  <div class="footer-background">
    <img src="footer-leaves.svg" alt="Fond feuilles">
  </div>
  <div class="footer-text">
    Copyright 2025 Starware. Tous droits réservés. Les différentes marques mentionnées appartiennent à leur propriétaire respectif. Starware.com SAS.
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
function ago(ts) {
    if (!ts || ts == 0) return "Jamais";
    const d = new Date(ts * 1000);
    return d.toLocaleDateString('fr-FR') + " " + d.toLocaleTimeString('fr-FR').slice(0,5);
}
function pill(text, type) {
    let cls = (type === "ok" || type === "active") ? "active" : "patched";
    return `<span class="status-pill ${cls}">${text}</span>`;
}
function backupStatusPill(last, okText = "OK", badText = "Pas de sauvegarde récente", hoursLimit = 48) {
    if(!last || last == 0) return pill(badText, "patched");
    let hoursAgo = (Date.now()/1000 - last) / 3600;
    return hoursAgo < hoursLimit ? pill(okText, "active") : pill(badText, "patched");
}

function showBackups(client_id, client_name) {
    $("#clients-table-container").hide();
    $("#main-title").text("Sauvegardes de " + client_name + " (ID " + client_id + ")");
    $("#backups-table-container")
        .html('<button class="back-btn" onclick="showClients()">&larr; Retour à la liste des clients</button><div style="padding:8px 0;">Chargement des sauvegardes...</div>')
        .show();

    // Appel API pour les sauvegardes de ce client
    $.getJSON("/backups/" + client_id, function(backups) {
        let html = `<button class="back-btn" onclick="showClients()">&larr; Retour à la liste des clients</button>`;
        html += `<div class="table-responsive"><table class="devices-table"><thead><tr>
            <th>Type</th>
            <th>Date</th>
            <th>Taille</th>
            <th>Validité</th>
            <th>Actions</th>
        </tr></thead><tbody>`;
        if (backups.length === 0) {
            html += `<tr><td colspan="5">Aucune sauvegarde trouvée.</td></tr>`;
        } else {
            backups.forEach(function(bkp) {
                let type = bkp.backup_type === 'image' ? 'Image disque' : 'Fichiers';
                let date = ago(bkp.backup_time);
                let size = bkp.total_bytes ? (bkp.total_bytes/1e9).toFixed(2) + " Go" : "";
                let valid = bkp.valid ? pill('Valide', 'active') : pill('Non valide', 'patched');
                html += `<tr>
                    <td>${type}</td>
                    <td>${date}</td>
                    <td>${size}</td>
                    <td>${valid}</td>
                    <td><!-- Actions, ex: restaurer / supprimer --></td>
                </tr>`;
            });
        }
        html += `</tbody></table></div>`;
        $("#backups-table-container").html(html);
    }).fail(function(xhr) {
        let msg = "Erreur lors du chargement des sauvegardes.";
        if (xhr.responseJSON && xhr.responseJSON.detail) {
            msg += "<br>" + xhr.responseJSON.detail;
        }
        $("#backups-table-container").html('<button class="back-btn" onclick="showClients()">&larr; Retour à la liste des clients</button><div style="padding:8px 0;color:red;">'+msg+'</div>');
    });
}
function showClients() {
    $("#backups-table-container").hide().empty();
    $("#main-title").text("Statut des sauvegardes");
    $("#clients-table-container").show();
}
$(document).ready(function() {
    // Clic sur une ligne client pour afficher ses sauvegardes
    $(".client-row").on("click", function(e) {
        if (!$(e.target).hasClass("client-select")) {
            showBackups($(this).data("client-id"), $(this).data("client-name"));
        }
    });
});
</script>
</body>
</html>