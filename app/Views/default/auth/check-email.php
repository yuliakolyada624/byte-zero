<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>
<?= lang('Auth.register') ?>
<?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>check-email-page<?= $this->endSection() ?>

<?= $this->section('auth-header-btn') ?>
  <a href="<?= base_url() ?>accounts/register" class="btn btn-primary auth-header-btn">Register</a>
<?= $this->endSection() ?>

<?= $this->section('main') ?>


<div class="container auth-content">
      <div class="auth-page__section-content">
        <h2 class="auth-page-title">Check Your Email</h2>
        <p class="auth-page-subtitle">Password reset instructions have been emailed to you.</p>
        <div class="d-flex flex-column justify-content-center align-items-center mx-auto auth-page__form-wrap">
          <a href="<?= url_to('login') ?>" class="auth-page-btn auth-page__close-btn" aria-label="Return to login page">Return to
            login page</a>
        </div>
      </div>
    </div>
<?= $this->endSection() ?>