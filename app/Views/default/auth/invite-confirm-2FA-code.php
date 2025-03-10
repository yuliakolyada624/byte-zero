<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('bobyClass') ?>create-new-password-page<?= $this->endSection() ?>

<?= $this->section('auth-header-btn') ?>
    <a href="<?= base_url() ?>accounts/login" class="btn btn-primary auth-header-btn">Sing in</a>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container auth-content">
    <div class="auth-page__section-header">
        <div class="component__backbtn">
            <div class="component__backbtn-wrap">
                <a href="<?=url_to('invite-add-phone')?>" class="component__backbtn-btn">
                <svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.5 4L4.5 9L9.5 14" stroke="#148BDF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back
                </a>
            </div>
        </div>
        <?= $this->setData(['step'=>2])->include('auth/auth-invite-steps') ?>
    </div>
    <div class="auth-page__section-content">
        <h2 class="auth-page-title">Two-Factor Authentication (2FA)</h2>
        <p class="auth-page-subtitle">An SMS with your verification code has been sent to your personal phone. </br> <a
                href="<?= url_to('invite-add-phone') ?>" class="auth-page-link">Change your phone number</a></p>
        <div class="d-flex flex-column justify-content-center align-items-center mx-auto auth-page__form-wrap">
            <form class="form col-4 js-form auth-page__form" action="<?= url_to('check-2fa') ?>" method="POST"
                data-validation="phone_number" data-type="phone_number">
                <?= csrf_field() ?>

                <div class="component__scode auth-page__security-code <?=(session('error') !== null ? 'is-invalid' : '') ?>" 
                    data-total-time="60" data-timeout="300" data-resend-url="<?= url_to('resend-2fa-code') ?>">
                    <input id="phoneSC" class="js__scode-main-input" type="hidden" name="security-code" aria-describedby="">
                    <p id="jsComponentSCode_label_phoneSC" class="w-100 text-center component__scode-label js__scode-label"
                        data-default-text="Enter Security Code" data-timeout-text="Security Code Timed Out">
                        Enter Security Code
                    </p>
                    <div class="d-flex justify-content-between component__scode-line">
                        <div class="justify-content-center align-items-center component__scode-wrap">
                        <input type="text" class="form-control component__scode-input js__scode-input js-input__sc1">
                        </div>
                        <div class="justify-content-center align-items-center component__scode-wrap">
                        <input type="text" class="form-control component__scode-input js__scode-input js-input__sc2">
                        </div>
                        <div class="justify-content-center align-items-center component__scode-wrap">
                        <input type="text" class="form-control component__scode-input js__scode-input js-input__sc3">
                        </div>
                        <div class="justify-content-center align-items-center component__scode-wrap">
                        <input type="text" class="form-control component__scode-input js__scode-input js-input__sc4">
                        </div>
                        <div class="justify-content-center align-items-center component__scode-wrap">
                        <input type="text" class="form-control component__scode-input js__scode-input js-input__sc5">
                        </div>
                        <div class="justify-content-center align-items-center component__scode-wrap">
                        <input type="text" maxlength="1" class="form-control component__scode-input js__scode-input js-input__sc6" required>
                        </div>
                    </div>

                    <button class="btn btn-secondary w-100 component__scode-btn js__scode-btn-submit" type="submit"
                        aria-label="Continue" disabled>Continue</button>
                    <button class="btn btn-link mt-2 component__scode-resend-btn d-none js__scode-btn-resend js__resend-2fa-btn">Resend
                        code</button>
                    <p class="mt-2 component__scode-resend-status js__scode-timer-wrap">Resend code in <span
                        class="js__scode-timer">60</span> s</p>
                   
                        <div class="form-field _invalid mt-2 mb-2 <?=((session('error') == null) ? 'd-none' : '')?>">
                            <span class="form-field__error js-field-error" style="display: flex; justify-content: center;">
                                <?= session('error'); ?> &nbsp; <a class="btn btn-link js__resend-2fa-btn">Send another code</a>
                            </span>
                        </div>
                      
                    <p id="jsComponentSCode_errorFeedback_phoneSC" class="mt-2 invalid-feedback">Security code is incorrect <a
                        href="#">Resend Code</a></p>
                </div>                
            </form>

            <div class="invalid-feedback mt-2">
                Security code is incorrect. <a href="#" class="auth-page-link">Send another code</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>