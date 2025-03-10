<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.emailActivateTitle') ?> <?= $this->endSection() ?>

<?= $this->section('auth-header-btn') ?>
<a href="<?= base_url() ?>accounts/login" class="btn btn-primary auth-header-btn">Sing in</a>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container auth-content">
  <div class="auth-page__section-header">
    <?= $this->setData(['step' => 1])->include('auth/auth-steps') ?>
  </div>
  <div class="auth-page__section-content">
    <div class="auth-page__content-wrap">
      <h2 class="auth-page-title">Email verification</h2>
      <p class="auth-page-subtitle">Review and verify the email for this account.</p>
      <p class="auth-page-infolink">
        A verification link has been sent to:
        <a href="mailto:<?= $user->email ?>" class="auth-page-link"><?= $user->email ?></a>
        - 
        <a href="<?= base_url() ?>accounts/logout" class="auth-page-link">Change</a>
      </p>
      <button type="button" onclick="reloadPage()" class="auth-page-btn auth-page__close-btn auth-page-time-trigger"
        aria-label="Resend verification email">Resend verification email</button>
      <div class="auth-page-time-message" style="<?= isset($_GET['resend']) ? 'display: block;' : 'display: none;' ?>">
        <p>Please check your email.<br>A new verification email has been set to you.</p>
      </div>
    </div>
  </div>
</div>

<script>
  function reloadPage() {
    //location.reload();
    window.location.href = window.location.pathname + '?resend=1';
  }
</script>

<?= $this->endSection() ?>