<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>reset-password-page<?= $this->endSection() ?>

<?= $this->section('auth-header-btn') ?>
  <a href="<?= base_url() ?>accounts/register" class="btn btn-primary auth-header-btn">Register</a>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<?php
helper('forms');
?>

<div class="container auth-content">
      <div class="auth-page__section-content">
        <h2 class="auth-page-title">Reset password</h2>
        <p class="auth-page-subtitle">Enter your email for password reset instructions</p>
        <div class="d-flex flex-column justify-content-center align-items-center mx-auto auth-page__form-wrap">
          <form class="form js-form auth-page__form" action="<?=url_to('post-reset-password') ?>" method="POST">
          <?= csrf_field() ?>


            <div class="form-field auth-page__form-field  is-required js-field js__textinput " data-type="email">
              <label for="email" class="form-label form-field__title">Company email</label>
              <div class="form-field__input-wrap">
                <input class="form-field__input js-field-input form-control" id="email" validateOnBlur="" type="email"
                  name="email" value="" placeholder="" />
              </div>
              <span class="form-field__error js-field-error">Valid company email required</span>
              <?=form_show_errors_field('email');?>
            </div>

            <?=form_show_error()?>

            <button class="btn btn-primary auth-page-btn auth-page__form-btn" type="submit"
              aria-label="Reset Password">Reset Password</button>
          </form>
        </div>
      </div>
</div>
<?= $this->endSection() ?>