<?php
// TODO - delete after replace
if (!function_exists('form_show_errors_field')) {
    function form_show_errors_field($key = false)
    {
        if (!$key)
            return;
        if (session('errors') !== null && is_array(session('errors')) && isset(session('errors')[$key])) {
            ?>
            <div class="form__col _col-12 form-field _invalid">
                <span class="form-field__error">
                    <?= session('errors')[$key]; ?>
                </span>
            </div>
            <?php
        }
    }
}


if (!function_exists('form_show_errors_by_field')) {
    function form_show_errors_by_field($key = false, $js_error='')
    {
        if (!$key)
            echo $js_error;
        if (session('errors') !== null && is_array(session('errors')) && isset(session('errors')[$key])) {
            ?>
            <?= session('errors')[$key]; ?>
            <?php
        } else {
            echo $js_error;
        }
    }
}

if (!function_exists('form_check_errors_field')) {
    function form_check_errors_field($key = false)
    {
        if (!$key)
            return false;
        if (session('errors') !== null && is_array(session('errors')) && isset(session('errors')[$key])) {
            return true;
        }
    }
}

if (!function_exists('form_show_error')) {
    function form_show_error()
    {
         // dd(session('error'));
        //  d(session('errors'));
        //   d(session('message'));
        if (session('error') !== null): ?>
            <div class="form__col _col-12 form-field _invalid">
                <div class="form-field__error js-field-error" role="alert">
                    <?= session('error') ?>
                </div>
            </div>
        <?php elseif (session('errors') !== null && !is_array(session('errors'))): ?>
            <div class="form__col _col-12 form-field _invalid">
                <div class="form-field__error js-field-error" role="alert">
                    <?= session('errors') ?>
                </div>
            </div>
        <?php endif ?>

        <?php /* if (session('message') !== null): ?>
                         <div class="form-field__error js-field-error" role="alert">
                           <?= session('message') ?>
                         </div>
                       <?php endif */ ?>
        <?php
    }
}