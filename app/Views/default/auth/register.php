<?php
helper('forms');
?>
<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>registration-page<?= $this->endSection() ?>

<?= $this->section('auth-header-btn') ?>
  <a href="<?= base_url() ?>accounts/login" class="btn btn-primary auth-header-btn">Sing in</a>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container auth-content">
      <div class="auth-page__section-content">
        <h2 class="auth-page-title">Account Registration</h2>
        <p class="auth-page-subtitle">Let’s take a moment to set up your account.</p>
        <div class="d-flex flex-column justify-content-center align-items-center mx-auto auth-page__form-wrap">
          <form class="form js-form auth-page__form" id="register" action="<?= url_to('registration') ?>" method="POST">
          <?= csrf_field() ?>

            <div class="form-field auth-page__form-field  is-required js-field js__textinput <?=(form_check_errors_field('company_name') ? '_invalid' : '')?>" data-type="text">
              <label for="company_name" class="form-label form-field__title">Firm or Company Name</label>
              <div class="form-field__input-wrap">
                  <input class="form-field__input js-field-input form-control" id="company_name" type="company_name" name="company_name" validateOnBlur="true" value="<?= old('company_name') ?>" placeholder="" />
              </div>
              <span class="form-field__error js-field-error"><?=form_show_errors_by_field('company_name');?></span>
            </div>

            <div class="form-field auth-page__form-field  is-required js-field js__textinput <?=(form_check_errors_field('email') ? '_invalid' : '')?>" data-type="email">
              <label for="company_email" class="form-label form-field__title">Firm or Company Email</label>
              <div class="form-field__input-wrap">
                <input class="form-field__input js-field-input form-control" id="company_email" validateOnBlur="true" 
                  id="email" type="email" name="email" validateOnBlur="true" value="<?= old('email') ?>"  placeholder="e.g. name@yourcompany.com"  />                  
              </div>
              <span class="form-field__error js-field-error"><?=form_show_errors_by_field('email');?></span>
            </div>

            <?=form_show_error()?>

            <button class="btn btn-primary auth-page-btn auth-page__form-btn" type="submit"
              aria-label="Continue">Continue</button>
            <div class="form-check form-terms-checkbox form-terms-checkbox-wrap <?=(form_check_errors_field('register_agree') ? 'is-required' : '')?>">
              <input class="form-check-input auth-form-terms-checkbox js__terms-checkbox <?=(form_check_errors_field('register_agree') ? 'is-invalid' : '')?>" 
                  type="checkbox" value="1" id="flexCheckDefault" name="register_agree">
              <label class="form-check-label" for="flexCheckDefault">
                By creating an account, I agree to Med-Test.ai’s
                <a href="#" class="auth-page-link">Terms and Conditions</a> and
                <a href="#" class="auth-page-link">Privacy Policy.</a>
              </label>
            </div>
          </form>

          <div class="hr auth-page__separate-line"></div>

          <p class="auth-page__form-footer">
            Already have an account? <a href="<?= url_to('login') ?>" class="auth-page-link">Sign in</a>
          </p>
        </div>
      </div>
    </div>

<?= $this->endSection() ?>
