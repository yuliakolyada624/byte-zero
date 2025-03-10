<?php
helper('forms');
?>
<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>create-new-password-page<?= $this->endSection() ?>

<?= $this->section('auth-header-btn') ?>
<a href="<?= base_url() ?>accounts/login" class="btn btn-primary auth-header-btn">Sing in</a>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container auth-content">
    <div class="auth-page__section-header">
        <?= $this->setData(['step' => 2])->include('auth/auth-invite-steps') ?>
    </div>
    <div class="auth-page__section-content">
        <h2 class="auth-page-title">Verify your phone number with a code</h2>
        <p class="auth-page-subtitle">It helps us keep your account secure.</p>
        <div class="d-flex mx-auto auth-page__form-wrap">
            <form class="form col-4 js-form auth-page__form" action="<?= url_to('set-phone') ?>" method="POST"
                data-validation="phone_number" data-type="phone_number">
                <?= csrf_field() ?>

                <div class="form-field auth-page__form-field  is-required js-field  <?= (form_check_errors_field('phone_number') ? '_invalid' : '') ?>"
                    data-type="phone">
                    <div class="component__itidropdown auth-page__form-field is-required" data-type="phone">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input class="form-control component__itidropdown-input js__itidropdown-input" id="phone_number" type="phone"
                            name="phone_number" value="" autocomplete="off" placeholder="000-000-0000" aria-describedby="phoneFeedback"
                            data-placeholder="000-000-0000" data-country="">
                        <div id="phoneFeedback" class="invalid-feedback component__itidropdown-error js-field-error">
                            Valid company phone required
                        </div>
                    </div>
                    <span class="form-field__error js-field-error"><span
                            class="form-field__error js-field-error"><?= form_show_errors_by_field('phone_number'); ?></span></span>
                </div> <button class="btn btn-primary auth-page-btn auth-page__form-btn" type="submit"
                    aria-label="Continue">Continue</button>
            </form>
        </div>
    </div>
</div>



<?= $this->endSection() ?>