<header class="auth-header">
  <div class="container auth-container">
    <div class="d-flex justify-content-between align-items-center auth-header-wrap">
      <a href="<?= base_url() ?>">

        <picture class="auth-header__image">
          <source srcset="<?= base_url() ?>assets/themes/default/img/content/auth-logo.webp" type="image/webp"
            class="auth-header__img " />
          <img src="<?= base_url() ?>assets/themes/default/img/content/auth-logo.png" alt="img"
            class="auth-header__img " width="198" height="35" />
        </picture>

      </a>
      <?= $this->renderSection('auth-header-btn') ?>
    </div>
  </div>
</header>