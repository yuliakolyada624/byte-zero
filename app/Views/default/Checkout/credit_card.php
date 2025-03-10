<?php
    $userData       = $this->session->userdata('userdata');
    $userId         = $userData->accounts_id; 
    $instanceType   = array('','vip','pro','elite','guest', 'plus');
    $jsVersion      = $this->config->item('js_version');

	$CurrentCurrencyCode	= get_currency();
	$CurrentCurrencyRow		= get_currency_row($CurrentCurrencyCode, ['symbol', 'rate']);

    $loaderInstanceType = array(
        null    => 'mwr_loader_default.gif',
        '1'     => 'mwr_loader_vip.gif',
        '2'     => 'mwr_loader_pro.gif',
        '3'     => 'mwr_loader_elite.gif',
        '4'     => 'mwr_loader_guest.gif',
        '5'     => 'mwr_loader_plus.gif'
    );

    if($userData->status == 2)
    {
        $plan       = membershipPlanName($userData->instance_flag);
        $membership = getMembershipPricing($plan,"account");
    }

    if($this->userData->mall_add_on == true && $this->userData->mall_add_on_status == "Suspended")
    {
        $mallMembership = getMembershipPricing("mall_add_on","account");
    }
?>

<style type="text/css">
    .hidden {
        display: none;
    }

    iframe {
        width: 100%;
        height: 100%;
    }

    #gateway_iframe iframe {
        width: 100%;
        min-height: 480px;
    }

    #gateway_iframe iframe html body > div > .col-sm-10 {
        width: 100% !important;
    }

</style>



<div class="account_pages">
    <div class="account_credit_card">

        <?php
            if($this->session->userdata('success_msg')){ ?>
                <div class="alert alert-success" role="alert">
                  <?= $this->session->userdata('success_msg') ?>
                </div>
            <?php } 
            elseif($this->session->userdata('error_msg')){ ?>
                <div class="alert alert-danger" role="alert">
                  <?= $this->session->userdata('error_msg') ?>
                </div>
            <?php }
        ?>

        <?php
            /*Message for card addition from 3ds2*/
            if($this->session->tempdata('card_authorized_success'))
            { ?>
                <div class="alert alert-success" role="alert">
                  <?= $this->session->tempdata('card_authorized_success') ?>
                </div>
            <?php 
                /*Unset the session data*/
                $this->session->unset_tempdata('card_authorized_success');
            } 
            elseif($this->session->tempdata('card_authorized_error'))
            { ?>
                <div class="alert alert-danger" role="alert">
                  <?= $this->session->tempdata('card_authorized_error') ?>
                </div>
            <?php
                /*Unset the session data*/
                $this->session->unset_tempdata('card_authorized_error');
            }
        ?>
        <div class="credit_card_top <?= $instanceType[$this->userData->instance_type] ?>">
            <div class="page_title">
                <img src="<?= base_url() ?>assets/images/account/ic_credit_card_white.svg" alt="Reservations Images"><?= $this->lang->language['credit_cards']; ?>
            </div>
        </div>
        <div class="credit_card_tbl">
            <div class="card_list_new mt-4">
                <div class="card_listing_title d-flex justify-content-between">
                    <?php
                    if($this->userData->is_secondary == 0)
                    {?>
                        <h4><?= $this->lang->language['selected_payment_method_text']; ?></h4>
                    <?php
                    }
                    ?>
                    <a href="javascript:void(0);" onclick="addNewCard()">+ <?= $this->lang->language['Add_new_card']; ?></a>
                </div>

                <?php
                  /*  if($userData->status == 2){
                        ?>
                <div class="active_membership_card mb-2 d-none"></div>
                <div class="active_membership_card upgrade_membership_error mb-2 d-none"></div>
                <div class="pay_now_card <?= $plan ?> upgrade_sucess justify-content-between d-flex flex-wrap">
                    <p><?= $this->lang->language['membership_expire_msg'].' '.$this->lang->language['upgrade_credit_card_msg']; ?><span><?= $this->lang->language['payment_due_text'].$this->lang->language['blank_space'] ?>: <?= priceFormateChange($CurrentCurrencyRow->symbol,number_format((float)($membership['plan']*$CurrentCurrencyRow->rate), 2, '.', ''));  ?></span></p>
                    <a class="ml-auto pay_now_btn" href="javascript:void(0);" id="pay_now" onclick="payMembership('<?= $plan ?>')"><?= $this->lang->language['pay_now'] ?></a>
                </div>
                <div class="pay_now_card <?= $plan ?> upgrade_error justify-content-between flex-wrap d-none">
                    <p><span class="d-inline-block"><?= $this->lang->language['payment_declined_text'].'</span> '.$this->lang->language['upgrade_credit_card_msg']; ?><span><?= $this->lang->language['payment_due_text'].$this->lang->language['blank_space'] ?>: <?= priceFormateChange($CurrentCurrencyRow->symbol,number_format((float)($membership['plan']*$CurrentCurrencyRow->rate), 2, '.', ''));  ?></span></p>
                    <a class="ml-auto pay_now_btn" href="javascript:void(0);" id="pay_now" onclick="payMembership('<?= $plan ?>')"><?= $this->lang->language['pay_now'] ?></a>
                </div>
                <?php
                    } */
                ?>

                <!-- Removed mall_add_on reactivation condition -->
                <!-- <?php
                if($this->userData->mall_add_on == true && $this->userData->mall_add_on_status == "Suspended")
                {?>
                    <div class="pay_now_card mall_add_on justify-content-between d-flex flex-wrap mt-2">
                        <p><?= $this->lang->language['reactivate_mall_message2'].' '.$this->lang->language['upgrade_credit_card_msg']; ?><span><?= $this->lang->language['payment_due_text'].$this->lang->language['blank_space'] ?>: <?= priceFormateChange($CurrentCurrencyRow->symbol,number_format((float)($mallMembership['plan']*$CurrentCurrencyRow->rate), 2, '.', ''));  ?></span></p>
                        <a class="ml-auto pay_now_btn" href="javascript:void(0);" id="pay_now" onclick="payMembership('mall_add_on')"><?= $this->lang->language['pay_now'] ?></a>
                    </div>
                <?php
                } ?> -->

                <div class="card_detail_list">
                    <ul>
                <?php
                if($response && $response['success'] == 1)
                {                 
                    foreach ($response['card_data'] as $key => $value) 
                    { 
                                    switch ($value['card_type']) {
                                        case 'Visa':
                                            $card_img = "visa_card.svg";
                                            break;
                                        case 'MasterCard':
                                            $card_img = "master_card.png";
                                            break;
                                        case 'American Express':
                                            $card_img = "express.png";
                                            break;
                                        default:
                                            $card_img = "card.png";
                                            break;
                                    }?>
                        <li id="<?= $value['spreedly_token'] ?>">
                            <label class="cstm_check">
                                <input type="radio" value="<?= $value['card_id'] ?>" name="card_checkbox[]" id="check_<?= $value['card_id'] ?>" <?= $value['is_default'] == '1' ? 'checked' : ($default_check == 1 && $key == 0 ? 'checked' : '') ?>>
                                <span class="checkmark"></span>
                            </label>
                            <img src="<?= base_url() ?>assets/images/<?= $card_img; ?>" alt="Visa card">
                            <div class="credit_card_ctn">
                                <h6><?= str_replace("_", " ", $value['card_type']).' '. $this->lang->language['ending_in'] .' '. $value['last_four_digit'] ?></h6>
                                <p><span><?= $this->lang->language['expires']; ?> <?= $value['month'].'/'.$value['year'] ?></span><span class="card_name"><?= ucfirst($value['first_name']).' '.ucfirst($value['last_name']) ?></span></p>
                                <div class="credit_card_action d-flex"><a class="pl-0 pr-1 border-1" href="javascript:void(0);" onclick="editCard('<?= $value['spreedly_token'] ?>')"><?= $this->lang->language['edit']; ?></a>
                                    <a class="pl-1 border-0" href="javascript:void(0);" data-toggle="modal" data-target="#remove_card_modal" onclick="deleteCard('<?= $value['spreedly_token'] ?>')"><?= $this->lang->language['remove']; ?></a></div>
                            </div>
                        </li>
                    <?php    
                    }?>
                    
                <?php
                }?>
                    </ul>
                </div>
                <!-- Loader -->
                <div class="col-md-12 col-lg-12 loaderDiv" style="display:none;">
                    <div class="account_loader d-flex align-items-center justify-content-center bg-white h-100">
                        <img src="<?= base_url() ?>assets/images/account/<?= ($loaderInstanceType   [$this->userData->instance_type]) ?>" alt="Loader">
                    </div>
                </div>
            </div>
            <div class="add_new_card_new d-none">
                <h3 class="credit_card_title">
                    <span class="btn btn-sm mb-1" onclick="addNewCard()" style="color: #909D9D;"><i aria-hidden="true" class="fa fa-arrow-left"></i></span>
                    <?= $this->lang->language['add_new_card']; ?>
                </h3>
                <div class="add_card_form_new">
                    <div class="card-information">
                        <form method="POST" action="" id="save_customer_card_form" name="save_customer_card_form" onsubmit="return false;">
                            <p id="card_error" class="text-danger"></p>
                            <input type="hidden" value="1" name="account_card" id="account_card">
                            <div class="form-row">
                                <div class="form-group col-md-6 pr-md-3">
                                    <label for="guestUser"><?= $this->lang->language['credit_card_num']; ?><?= $this->lang->language['blank_space']?>:</label>
                                    <input type="number" class="form-control" name="card_number" id="card_number" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6 pl-md-3">
                                    <label for="guestUser"><?= $this->lang->language['first_name']; ?></label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" autocomplete="off" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 pr-md-3">
                                    <div class="form-row">
                                        <div class="form-group col-md-4 mb-0">
                                            <label class="text-nowrap" for="firstName"><?= $this->lang->language['expiration_date']; ?><?= $this->lang->language['blank_space']?>:</label>
                                            <select id="month" name="month" class="form-control">
                                                <?php
                                    for ($i = 1; $i <= 12; $i++) 

                                    { ?>
                                                <option value="<?= $i; ?>"><?= ($i < 10)? "0".$i:$i; ?></option>
                                                <?php }
                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 mb-0">
                                            <label for="firstName">&nbsp;</label>
                                            <select id="year" name="year" class="form-control">
                                                <?php
                                    for ($i = date('Y'); $i <= date('Y')+15; $i++)
                                    { ?>
                                                <option value="<?= $i; ?>"><?= $i; ?></option>
                                                <?php }
                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 mb-0">
                                            <label for="quantity"><?= $this->lang->language['cvv_code']; ?><?= $this->lang->language['blank_space']?>:</label>
                                            <input type="password" class="form-control" placeholder="3-digit code on back of card" name="cvv_code" id="cvv_code" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 pl-md-3">
                                    <label for="guestUser"><?= $this->lang->language['last_name']; ?></label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" autocomplete="off" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="billingAddress"><?= $this->lang->language['billing_address']; ?><?= $this->lang->language['blank_space']?>:</label>
                                    <input type="text" class="form-control" name="billing_address" id="billing_address" placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 mb-0 pr-md-3">
                                    <div class="form-row">
                                        <div class="form-group col-md-6 mb-0">
                                            <label for="billingCountry"><?= $this->lang->language['billing_country']; ?><?= $this->lang->language['blank_space']?>:</label>
                                            <select name="card_country" id="card_country" class="form-control">
                                                <option value=""><?= $this->lang->language['please_select']; ?></option>
                                                <?php foreach ($countries as $country) { ?>
                                                    <option value="<?= $country->countryCode ?>"><?= $country->countryName ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 mb-0">
                                            <label for="billingZip"><?= $this->lang->language['billing_zip']; ?><?= $this->lang->language['blank_space']?>:</label>
                                            <input type="text" class="form-control" name="card_zip" id="card_zip" placeholder="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="fform-group col-md-6 mb-0 text-right align-self-end mt-4">
                                    <button type="submit" class="btn btn-green px-4 mr-2 mb-2" id="save_card"><?= $this->lang->language['save_credit_card_form']; ?></button>
                                    <button type="reset" class="btn btn-gray px-4 mb-2"><?= $this->lang->language['clear']; ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="edit_card d-none">
                <h3 class="credit_card_title">
                    <span class="btn btn-sm mb-1" onclick="updateCard()" style="color: #909D9D;"><i aria-hidden="true" class="fa fa-arrow-left"></i></span>
                    <span id="edit_card"><?= $this->lang->language['edit_credit_card']; ?></span>
                </h3>
                <div class="add_card_form_new">
                    <div class="card-information">
                        <form method="POST" action="" id="update_customer_card_form" name="update_customer_card_form" onsubmit="return false;">
                            <p id="card_error" class="text-danger"></p>
                            <input type="hidden" value="" name="token" id="token">
                            <div class="form-row">
                                <div class="form-group col-md-6 pr-md-3">
                                    <label for="guestUser"><?= $this->lang->language['credit_card_num']; ?><?= $this->lang->language['blank_space']?>:</label>
                                    <input type="text" class="form-control" name="edit_card_number" id="edit_card_number" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6 pl-md-3">
                                    <label for="guestUser"><?= $this->lang->language['first_name']; ?></label>
                                    <input type="text" class="form-control" name="edit_first_name" id="edit_first_name" autocomplete="off" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 pr-md-3">
                                    <div class="form-row">
                                        <div class="form-group col-md-4 mb-0">
                                            <label class="text-nowrap" for="firstName"><?= $this->lang->language['expiration_date']; ?><?= $this->lang->language['blank_space']?>:</label>
                                            <select id="edit_month" name="edit_month" class="form-control">
                                                <?php
                                    for ($i = 1; $i <= 12; $i++) 

                                    { ?>
                                                <option value="<?= $i; ?>"><?= ($i < 10)? "0".$i:$i; ?></option>
                                                <?php }
                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 mb-0">
                                            <label for="firstName">&nbsp;</label>
                                            <select id="edit_year" name="edit_year" class="form-control">
                                                <?php
                                    for ($i = date('Y'); $i <= date('Y')+15; $i++)
                                    { ?>
                                                <option value="<?= $i; ?>"><?= $i; ?></option>
                                                <?php }
                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 mb-0">
                                            <label for="quantity"><?= $this->lang->language['cvv_code']; ?><?= $this->lang->language['blank_space']?>:</label>
                                            <input type="text" class="form-control" placeholder="3-digit code on back of card" name="edit_cvv_code" id="edit_cvv_code" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 pl-md-3">
                                    <label for="guestUser"><?= $this->lang->language['last_name']; ?></label>
                                    <input type="text" class="form-control" name="edit_last_name" id="edit_last_name" autocomplete="off" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="billingAddress"><?= $this->lang->language['billing_address']; ?><?= $this->lang->language['blank_space']?>:</label>
                                    <input type="text" class="form-control" name="edit_billing_address" id="edit_billing_address" placeholder="" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 mb-0 pr-md-3">
                                    <div class="form-row">
                                        <div class="form-group col-md-6 mb-0">
                                            <label for="billingCountry"><?= $this->lang->language['billing_country']; ?><?= $this->lang->language['blank_space']?>:</label>
                                            <select name="edit_card_country" id="edit_card_country" class="form-control">
                                                <option value=""><?= $this->lang->language['please_select']; ?></option>
                                                <?php
                                            foreach ($countries as $country) { ?>
                                                <option value="<?= $country->countryCode ?>"><?= $country->countryName ?></option>
                                                <?php }
                                        ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 mb-0">
                                            <label for="billingZip"><?= $this->lang->language['billing_zip']; ?><?= $this->lang->language['blank_space']?>:</label>
                                            <input type="text" class="form-control" name="edit_card_zip" id="edit_card_zip" placeholder="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 mb-0 text-right align-self-end mt-4">
                                    <button type="submit" class="btn btn-green px-4 mr-2 mb-2" id="update_card"><?= $this->lang->language['update_credit_card']; ?></button>
                                    <span class="btn btn-gray px-4 mb-2" onclick="updateCard()"><?= $this->lang->language['cancel']; ?></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/modules/spreedly-account.js?v=<?= $jsVersion ?>"></script>

<script type="text/javascript">

    var editCardDetailURL   = '<?= site_url()?>account/user/getCreditCardDetail';
    var updateCreditCardURL = '<?= site_url()?>account/user/updateCreditCard';
    var environmentKey = "";

    $(document).ready(function(){
        checkCreditCard();
    });


    $('input[type="radio"]').on('change', function() {
        $('input[name="' + this.name + '"]').not(this).prop('checked', false);
    });

    //setTimeout(getCustomerCardMyAccount, 1000);
    // saveCustomerCard(saveCard, 1000);
    $("#btn_cancel").click(function() {
        $('#save_customer_card_form')[0].reset();
    })

    function addNewCard() {
        $(".card_list_new").toggleClass('d-none');
        $(".add_new_card_new").toggleClass('d-none');
    }

    function updateCard() {
        $(".card_list_new").toggleClass('d-none');
        $(".edit_card").toggleClass('d-none');
    }

    function checkCreditCard() {
        var cardLength = $(".card_detail_list ul li").length;
        var noDataFound = "<?= str_replace("!", "", $this->lang->language['no_data_found']); ?>";
        var cardHtml = "";
        $("#no_data_found").remove();
        if (cardLength == 0) {
            cardHtml += '<span class="text-center" id="no_data_found" style="color:#227093;">' + noDataFound + '</span>';

            $(".card_detail_list").addClass("text-center");
            $(".card_detail_list").append(cardHtml);
        }

    }

    // var browser_size = '05';
    // // The accept header from your server side rendered page. You'll need to inject it into the page. Below is an example.
    // var acceptHeader = 'application/json,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
    // // The request should include the browser data collected by using `Spreedly.ThreeDS.serialize().
    // let browser_info = Spreedly.ThreeDS.serialize(
    //     browser_size,
    //     acceptHeader
    // );

    function payMembership(plan) {
        var token = $('input[name="card_checkbox[]"]:checked').parent().parent().attr('id');
        var paymentURL = "<?= site_url('account/user/membershipPaymentAuth'); ?>";

        if (token) {
            $.ajax({
                type: "POST",
                url: paymentURL,
                data: {
                    token: token,
                    plan: plan,
                    browser_info: browser_info
                },
                beforeSend: function() {
                    $("."+plan+" .pay_now_btn").html('<i class="fa fa-spinner fa-spin"></i>');
                    $("."+plan+" .pay_now_btn").css('pointer-events', 'none');
                },
                success: function(results) {
                    var obj = JSON.parse(results);

                    if (obj.status == "succeeded") 
                    {
                        redirectUrl = obj.redirect_url;
                        window.location.href = redirectUrl;
                    }
                    else if (obj.status == "pending") 
                    {
                        redirectUrl = obj.redirect_url;

                        var lifecycle = new Spreedly.ThreeDS.Lifecycle({
                            environmentKey: environmentKey,
                            hiddenIframeLocation: 'device-fingerprint',
                            // The DOM node that you'd like to inject hidden iframes (required)
                            challengeIframeLocation: 'challenge',
                            // The DOM node that you'd like to inject the challenge flow (required)
                            transactionToken: obj.authorize.transaction.token,
                            // The token for the transaction - used to poll for state (required)
                            //challengeIframeClasses: '...',
                            // The css classes that you'd like to apply to the challenge iframe (optional)
                        })

                        let status3ds = Spreedly.on('3ds:status', statusUpdates);

                        var transactionData = {
                            state: obj.authorize.transaction.state,
                            // The current state of the transaction. 'pending', 'succeeded', etc
                            required_action: obj.authorize.transaction.required_action,
                            // The next action to be performed in the 3D Secure workflow
                            device_fingerprint_form: obj.authorize.transaction.device_fingerprint_form,
                            // Available when the required_action is on the device fingerprint step
                            checkout_form: obj.authorize.transaction.checkout_form,
                            // Available when the required_action is on the 3D Secure 1.0 fallback step
                            checkout_url: obj.authorize.transaction.checkout_url,
                            // Available when the required_action is on the 3D Secure 1.0 fallback step
                            challenge_form: obj.authorize.transaction.challenge_form,
                            // The challenge form that is injected when the user is challenged
                            challenge_url: obj.authorize.transaction.challenge_url,
                            redirect_url: redirectUrl,
                            // The challenge url that is loaded when there is no challenge form
                        };

                        lifecycle.start(transactionData);

                    } 
                    else 
                    {
                        $("."+plan+" .pay_now_btn").html(languageData.pay_now);
                        $("."+plan+" .pay_now_btn").css('pointer-events', 'unset');
                        toastr.error(obj.message);
                    }
                }

            });
        } else {
            toastr.error('<?= $this->lang->language['please_add_a_card_to_make_payment']; ?>');
        }
    }

    var statusUpdates = function(event) {
        
        if (typeof(event.context.redirect_url) != "undefined" && event.context.redirect_url !== null) {
            redirectUrl = event.context.redirect_url;
        }

        if (event.action === 'succeeded') {
            window.location.href = redirectUrl;
        } else if (event.action === 'error') {
            window.location.href = redirectUrl;
        } else if (event.action === 'challenge') {
            $("#pageload_popup").modal('hide');
            $("#gateway_iframe").modal('show');
            $("body").removeClass("pageLoadpopup");
            $("body").removeAttr("style");

            $(".progress-bar").css("width", "0%").attr("aria-valuenow", "0");
            clearInterval(interval);

            document.getElementById('challenge-modal').classList.remove('hidden');

        } else if (event.action === 'trigger-completion') {

            $.ajax({
                async: true,
                url: SITEURL + 'payment/SpreedlyCompleteCall', // not used in this project
                type: 'POST',
                data: ({
                    purchase_token: event.token
                })
            }).done(function(completeResponse) {
                completeResult = JSON.parse(completeResponse);
                redirectUrl = completeResult.transaction.callback_url;

                if (completeResult.transaction.state === 'succeeded') {
                    window.location.href = redirectUrl;
                }

                if (completeResult.transaction.state === 'pending') {
                    event.finalize(completeResult.transaction);
                }

                if (completeResult.transaction.state === 'gateway_processing_failed') {
                    window.location.href = redirectUrl;
                }
            });
        }
    }

</script>