<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>
<?= lang('Auth.register') ?>
<?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>check-email-page
<?= $this->endSection() ?>

<?= $this->section('auth-header-btn') ?>
  <a href="<?= base_url() ?>accounts/register" class="btn btn-primary auth-header-btn">Register</a>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container auth-content">
      <div class="auth-page__section-content d-flex h-100 pt-0 justify-content-center align-content-center">
        <div class="d-flex flex-column justify-content-center">
          <div class="auth-page__mark-success">
            <svg class="icon icon-mark-success ">
              <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#mark-success" />
            </svg>
          </div>
          <h2 class="auth-page-title">Password changed successfully</h2>
          <div class="d-flex flex-column justify-content-center align-items-center mx-auto auth-page__form-wrap">
            <a href="<?= url_to('login') ?>" class="auth-page-btn auth-page__back-login-btn"
              aria-label="Return to login page">Return to login page</a>
          </div>
        </div>
      </div>
    </div>
<?= $this->endSection() ?>