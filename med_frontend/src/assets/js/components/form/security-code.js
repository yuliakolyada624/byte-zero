import { getCSRFToken } from "../../global-functions";

const ComponentSecurityCode = (function () {
    // Elements
    const scWrapper = $('.component__scode');
    const scMainInput = scWrapper.find('.js__scode-main-input');
    const scLabel = scWrapper.find('.js__scode-label');
    const scInputs = scWrapper.find('.js__scode-input');
    const scBtnSubmit = scWrapper.find('.js__scode-btn-submit');
    const scBtnResend = scWrapper.find('.js__scode-btn-resend');
    const scBtnResend2FA = scWrapper.find('.js__resend-2fa-btn');
    const scTimerWrapper = scWrapper.find('.js__scode-timer-wrap');
    const scTimer = scTimerWrapper.find('.js__scode-timer');

    // Timers
    let resendTimer = {};
    let globalTimer = {};

    // Settings
    const timerTotalTime = parseInt(scWrapper.data('total-time'));
    const totalTimeout = parseInt(scWrapper.data('timeout'));
    const defaultText = scWrapper.data('default-text');
    const timeoutText = scWrapper.data('timeout-text');
    const resendUrl = scWrapper.data('resend-url');

    // Additional variables
    let fullCode = [];

    const enteredCallback = () => {
        scBtnSubmit.attr('disabled', false);
        scBtnSubmit.addClass('btn-primary');
        scBtnSubmit.removeClass('btn-secondary');
    }

    const backCallback = () => {
        scBtnSubmit.attr('disabled', true);
        scBtnSubmit.addClass('btn-secondary');
        scBtnSubmit.removeClass('btn-primary');
    }

    const clear = () => {
        scMainInput.val('');
        scInputs.val('');
        clearInterval(resendTimer);
        clearInterval(globalTimer);
    }

    const inputInputHandler = (input, index) => {
        input.val(input.val().replace(/[^0-9]/g, ''));
        if (input.val().length === 1 && index < scInputs.length - 1) {
            scInputs.eq(index + 1).focus();
        }

        fullCode[index] = input.val();

        scMainInput.val(fullCode.join(''));
        if (index + 1 === scInputs.length && input.val() !== '') {
            enteredCallback()
        } else {
            backCallback()
        }
    }

    const inputKeydownHandler = (input, event, index) => {
        if (event.key === 'Backspace' && input.val() === '' && index > 0) {
            scInputs.eq(index - 1).focus();
            scMainInput.val(fullCode.join(''));
        }
        fullCode[index] = input.val();
    }

    const setTimer = () => {
        scBtnResend.addClass('d-none');
        scTimerWrapper.removeClass('d-none');
        let totalTime = timerTotalTime;
        resendTimer = setInterval(function () {
            let seconds = totalTime;
            seconds = seconds < 10 ? '0' + seconds : seconds;
            scTimer.text(seconds);
            totalTime--;

            if (totalTime < 0) {
                clearInterval(resendTimer);
                scTimerWrapper.addClass('d-none');
                scBtnResend.removeClass('d-none');
            }
        }, 1000);
    }

    const setTotalTimeout = () => {
        scLabel.text(timeoutText);
        globalTimer = setInterval(function () {
            scLabel.text(defaultText);
        }, totalTimeout * 1000)
    }

    let init = () => {
        backCallback();
        setTimer();
        setTotalTimeout();
        scInputs.each(function (index) {
            $(this).on('input', function () {
                inputInputHandler($(this), index);
            });
            $(this).on('keydown', function (e) {
                inputKeydownHandler($(this), e, index);
            });
        });
        scBtnResend2FA.on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: resendUrl,
                headers: {
                    'X-CSRF-TOKEN': getCSRFToken()
                },
                method: 'POST',
                dataType: 'json',
                data: { action: "resend_code" },
                success: function (data) {
                    console.log('success: ' + data);
                    $('.js-field-error').closest('div').addClass('d-none');
                    $('.component__scode').removeClass('is-invalid');

                    clear();
                    backCallback();
                    setTimer();
                    setTotalTimeout();
                }
            });
        });
    }

    const reset = () => {
        backCallback();
        setTimer();
        setTotalTimeout();
        scInputs.each(function (index) {
            $(this).off('input');
            $(this).on('input', function () {
                inputInputHandler($(this), index);
            });
            $(this).off('keydown');
            $(this).on('keydown', function (e) {
                inputKeydownHandler($(this), e);
            });
        });
    }

    return {
        init: init,
        reset: reset,
    }
})();

export default ComponentSecurityCode