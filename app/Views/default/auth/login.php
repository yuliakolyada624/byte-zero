<?php
helper('forms');
?>
<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>
<?= lang('Auth.login') ?>
<?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>login-page<?= $this->endSection() ?>

<?= $this->section('auth-header-btn') ?>
  <a href="<?= base_url() ?>accounts/register" class="btn btn-primary auth-header-btn">Register</a>
<?= $this->endSection() ?>

<?= $this->section('main') ?>


    <div class="container auth-content">
      <div class="auth-page__section-content">
        <h2 class="auth-page-title">Welcome Back</h2>
        <p class="auth-page-subtitle">Let’s log in to your account</p>
        <div class="d-flex flex-column justify-content-center align-items-center mx-auto auth-page__form-wrap">
          <form class="form js-form auth-page__form" action="<?= url_to('login') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="form-field auth-page__form-field  is-required js-field js__textinput <?=(form_check_errors_field('email') ? '_invalid' : '')?>" data-type="email">
              <label for="email" class="form-label form-field__title">Firm or Company Email</label>
              <div class="form-field__input-wrap">
                <input class="form-field__input js-field-input form-control" id="email" type="email" name="email" validateOnBlur=""
                value="<?= old('email') ?>" placeholder="" />
              </div>
              <span class="form-field__error js-field-error"><?=form_show_errors_by_field('email', 'Valid company email required');?></span>
            </div>

            <div class="form-field auth-page__form-field  is-required js-field password js__textinput <?=(form_check_errors_field('password') ? '_invalid' : '')?>" data-type="password">
              <label for="password" class="form-label form-field__title">Password</label>
              <div class="form-field__input-wrap">
                <input class="form-field__input js-field-input form-control" id="password" type="password"
                  name="password" value="" placeholder="" required />
                <button type="button" class="show-pass closed js-additional-btn" data-action="toggle"
                  data-classes="showed">
                  <svg class="icon icon-eye ">
                    <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#eye" />
                  </svg>
                  <svg class="icon icon-eye-closed ">
                    <use href="<?= base_url() ?>assets/themes/default/icon/icons/icons.svg#eye-closed" />
                  </svg>

                </button>
              </div>
              <span class="form-field__error js-field-error"><?=form_show_errors_by_field('password');?></span>
            </div>

            <?=form_show_error()?>

            <div class="auth-page__form-row">
              <div class="form-check auth-page__form-field  js-field" data-type="checkbox">
                <input class="form-check-input" type="checkbox" name="remember" <?php if (old('remember')): ?> checked<?php endif ?> id="keep-logged">
                <label class="form-check-label">Keep me logged in</label>
              </div>
              <a class="auth-page-link" href="<?= url_to('reset-password') ?>">Forgot password</a>
            </div>

            <button class="btn btn-primary auth-page-btn auth-page__form-btn" type="submit" aria-label="Log in">Log in</button>
            
          </form>
          <div class="hr"></div>
          <p class="auth-page__bottom-content">
            Don’t have an account?
            <?php if (setting('Auth.allowRegistration') && setting('App.allowSelfRegistered')): ?>
                       <a href="<?= url_to('register') ?>" class="auth-page-link">Register here</a>
            <?php endif ?>
          </p>
        </div>
      </div>

    </div>

<?= $this->endSection() ?>