<?php
// Détection de la page courante pour l'onglet actif
$current = basename($_SERVER['PHP_SELF']);
?>
<header>
  <nav class="navbar">
    <a href="index.php" class="logo" style="display:flex;align-items:center;text-decoration:none;">
      <img src="assets/img/logo.png" alt="Logo Symplissime" style="height:40px;width:auto;transition:transform .18s;">
    </a>
    <button class="nav-toggle" id="navToggle" aria-label="Ouvrir le menu">
      <span></span><span></span><span></span>
    </button>
    <ul id="mainNav">
      <li>
        <a href="index.php" class="<?= $current==='index.php' ? 'active' : '' ?>">
          <img src="assets/icones/accueil.svg" alt="Accueil" />
          Accueil
        </a>
      </li>
      <li>
        <a href="devices.php" class="<?= $current==='devices.php' ? 'active' : '' ?>">
          <img src="assets/icones/mes_ordinateurs.svg" alt="Mes ordinateurs" />
          Mes ordinateurs
        </a>
      </li>
      <li>
        <a href="sauvegardes.php" class="<?= $current==='sauvegardes.php' ? 'active' : '' ?>">
          <img src="assets/icones/mes_sauvegardes.svg" alt="Mes sauvegardes" />
          Mes sauvegardes
        </a>
      </li>
      <li>
        <a href="shop.php" class="<?= $current==='shop.php' ? 'active' : '' ?>">
          <img src="assets/icones/shop.svg" alt="Shop" />
          Shop
        </a>
      </li>
      <li>
        <a href="ai.php" class="<?= $current==='ai.php' ? 'active' : '' ?>">
          <img src="assets/icones/symplissime_ai.svg" alt="Symplissime AI" />
          Symplissime AI
        </a>
      </li>
      <li>
        <a href="compte.php" class="<?= $current==='compte.php' ? 'active' : '' ?>">
          <img src="assets/icones/mon_compte.svg" alt="Mon compte" />
          Mon compte
        </a>
      </li>
    </ul>
  </nav>
  <style>
    header, .navbar {
      position: relative;
      z-index: 2002;
      background: rgba(255,255,255,0.97);
      box-shadow: 0 4px 30px #A1D44B22, 0 1.5px 6px #60C36A18;
      backdrop-filter: blur(3px);
      border-bottom: 1.5px solid #e3e8ee;
      transition: box-shadow .22s;
      width: 100%;
    }
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      max-width: 1400px;
      margin: 0 auto;
      padding: 10px 18px;
      flex-wrap: wrap;
    }
    .navbar .logo img {
      filter: drop-shadow(0 1px 5px #A1D44B22);
      transition: transform .18s, box-shadow .18s, filter .18s;
    }
    .navbar .logo:hover img {
      transform: scale(1.09) rotate(-3deg);
      filter: drop-shadow(0 4px 16px #A1D44B88);
    }
    .navbar ul {
      display: flex;
      gap: 20px;
      list-style: none;
      margin: 0;
      padding: 0;
      align-items: center;
      transition: max-height .3s;
    }
    .navbar ul li {
      display: flex;
    }
    .navbar ul li a {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #219769;
      font-weight: 600;
      text-decoration: none;
      padding: 10px 18px;
      border-radius: 12px;
      font-size: 1.11em;
      transition: background .22s, color .18s, box-shadow .18s, border .16s;
      box-shadow: 0 0px 0px transparent;
      position: relative;
      overflow: hidden;
      border: 2px solid transparent;
      background: none;
    }
    .navbar ul li a:hover, .navbar ul li a.active {
      background: #eafce3;
      color: #219769;
      box-shadow: 0 2px 8px #A1D44B33;
      border: 2px solid #A1D44B;
    }
    .navbar ul li a:active {
      background: #A1D44B55;
      color: #fff;
    }
    .navbar ul li a img {
      height: 24px;
      width: 24px;
      object-fit: contain;
      filter: drop-shadow(0 0 2px #A1D44B44);
      transition: filter .18s;
      margin-right: 6px;
      background: none;
    }
    .navbar ul li a:hover img,
    .navbar ul li a.active img {
      filter: drop-shadow(0 3px 8px #A1D44B77);
    }
    /* Burger menu */
    .nav-toggle {
      display: none;
      background: none;
      border: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      margin-left: 16px;
      z-index: 2100;
    }
    .nav-toggle span {
      width: 28px;
      height: 3px;
      background: #219769;
      border-radius: 2px;
      transition: all .3s;
      display: block;
    }
    /* Responsive */
    @media (max-width: 900px) {
      .navbar ul {
        gap: 8px;
      }
      .navbar {
        padding: 10px 2vw;
      }
    }
    @media (max-width: 700px) {
      .nav-toggle {
        display: flex;
      }
      .navbar ul {
        flex-direction: column;
        position: absolute;
        right: 10px;
        top: 62px;
        background: #fff;
        box-shadow: 0 4px 30px #A1D44B22, 0 1.5px 6px #60C36A18;
        border-radius: 18px;
        min-width: 180px;
        align-items: flex-start;
        max-height: 0;
        overflow: hidden;
        padding: 0 0;
        z-index: 2050;
      }
      .navbar ul.open {
        max-height: 420px;
        padding: 14px 0;
        transition: max-height .35s;
      }
      .navbar ul li {
        width: 100%;
      }
      .navbar ul li a {
        width: 100%;
        font-size: 1em;
        justify-content: flex-start;
        padding: 14px 20px;
      }
    }
  </style>
  <script>
    // Burger menu JS
    document.addEventListener('DOMContentLoaded', function() {
      const navToggle = document.getElementById('navToggle');
      const mainNav = document.getElementById('mainNav');
      if(navToggle && mainNav){
        navToggle.addEventListener('click', function() {
          mainNav.classList.toggle('open');
        });
        // Optional: close menu if click outside on mobile
        document.addEventListener('click', function(e) {
          if (!mainNav.contains(e.target) && !navToggle.contains(e.target)) {
            mainNav.classList.remove('open');
          }
        });
      }
    });
  </script>
</header>