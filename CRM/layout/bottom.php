<?php // Closes the shell opened by layout/top.php and loads the shared scripts. ?>
      <div class="copyright">
        <p>Copyright © <?= date('Y') ?> NM INFOCOM. All rights reserved.</p>
      </div>
    <?php // Same closing structure the per-section bottom.php files used; pages rely on it. ?>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script src="<?= $crm ?>vendor/jquery-3.2.1.min.js"></script>
  <script src="<?= $crm ?>vendor/bootstrap-4.1/popper.min.js"></script>
  <script src="<?= $crm ?>vendor/bootstrap-4.1/bootstrap.min.js"></script>
  <script src="<?= $crm ?>vendor/slick/slick.min.js"></script>
  <script src="<?= $crm ?>vendor/wow/wow.min.js"></script>
  <script src="<?= $crm ?>vendor/animsition/animsition.min.js"></script>
  <script src="<?= $crm ?>vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <script src="<?= $crm ?>vendor/counter-up/jquery.waypoints.min.js"></script>
  <script src="<?= $crm ?>vendor/counter-up/jquery.counterup.min.js"></script>
  <script src="<?= $crm ?>vendor/circle-progress/circle-progress.min.js"></script>
  <script src="<?= $crm ?>vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="<?= $crm ?>vendor/select2/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
  <script src="<?= $crm ?>js/main.js"></script>
  <script src="<?= $crm ?>layout/crm-ui.js?v=1"></script>
  <script>
    // Off-canvas sidebar on small screens.
    (function () {
      var open = function (on) { document.body.classList.toggle('crm-nav-open', on); };
      document.querySelectorAll('[data-crm-open]').forEach(function (b) { b.addEventListener('click', function () { open(true); }); });
      document.querySelectorAll('[data-crm-close]').forEach(function (b) { b.addEventListener('click', function () { open(false); }); });
      document.addEventListener('keydown', function (e) { if (e.key === 'Escape') open(false); });
      document.querySelectorAll('.crm-nav-link').forEach(function (a) { a.addEventListener('click', function () { open(false); }); });
    })();
    // Dark / light toggle (saved per browser; charts re-colour through crm-charts.js).
    (function () {
      var root = document.documentElement;
      var sync = function () {
        var dark = root.getAttribute('data-theme') === 'dark';
        document.querySelectorAll('[data-crm-theme]').forEach(function (b) {
          b.setAttribute('aria-label', dark ? 'Switch to light mode' : 'Switch to dark mode');
          b.setAttribute('aria-pressed', dark ? 'true' : 'false');
        });
      };
      document.querySelectorAll('[data-crm-theme]').forEach(function (b) {
        b.addEventListener('click', function () {
          var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
          root.setAttribute('data-theme', next);
          try { localStorage.setItem('crm-theme', next); } catch (e) {}
          sync();
          if (window.crmCharts) window.crmCharts.refresh();
        });
      });
      sync();
    })();
  </script>
</body>

</html>
