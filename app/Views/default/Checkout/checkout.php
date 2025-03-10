<?php
 use CodeIgniter\I18n\Time;
?>
<?= $this->extend('template/layout') ?>
<?= $this->section('content') ?>
<?= $this->section('extra-css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" integrity="sha512-gxWow8Mo6q6pLa1XH/CcH8JyiSDEtiwJV78E+D+QP0EVasFs8wKXq16G8CLD4CJ2SnonHr4Lm/yY2fSI2+cbmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js" integrity="sha512-+gShyB8GWoOiXNwOlBaYXdLTiZt10Iy6xjACGadpqMs20aJOoh+PJt3bwUVA6Cefe7yF7vblX6QwyXZiVwTWGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/libs/toastr/toastr.min.css">
<!-- extra css
    <link href="<?= base_url() ?>/assets/libs/dragula/dragula.min.css" rel="stylesheet" type="text/css" />
    -->

<style type="text/css">
    .button,
    button {
        color: #84c9b1;
        height: 100%;
        background-color: #84c9b11a;
        border: none;
        border-radius: 8px;
        flex-direction: row;
        flex-basis: 17%;
        justify-content: center;
        align-items: center;
        font-family: Montserrat, Arial;

        line-height: 24px;
        display: flex;
        padding: 6px;
    }
    .book-timer {
        font-family: 'Sora';
        font-style: normal;
        font-weight: 400;
        font-size: 42px;
        line-height: 120%;
        /* or 63px */
        text-align: center;
        color: #84C9B1;
        margin-bottom: 15px;
    }
    .book-timer div{
        background: #F8F8F8;
        border-radius: 16px;
        padding: 8px;
    }

    select{
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        appearance: none;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;

    }

    .list_customer_card input {
        appearance: auto;
    }
</style>


<style type="text/css">
    #gateway_iframe iframe {
        width: 100%;
        min-height: 480px;
    }

    #gateway_iframe iframe html body>div>.col-sm-10 {
        width: 100% !important;
    }

    .iti--separate-dial-code .iti__selected-flag {
        max-height: initial;
    }

    .iti {
        display: flex;
    }

    .list_customer_card {
        list-style: none;
    }

    .list_customer_card input {
        margin-right: 5px;
    }

    .error {
        color: #f00;
        border-color: #f00;
    }
	.success{
		color: #31842f;
		border-color: #31842f;
	}
</style>

<?= $this->endSection() ?>

<!-- 3ds challange iframe -->
<div id="gateway_iframe" class="modal" data-backdrop="static" role="dialog" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div id="device-fingerprint" class="hidden"></div>
                <div id="challenge-modal" class="hidden">
                    <div id="challenge" style="min-height: 480px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 3ds challange iframe -->


<!-- Pop up message -->
<div id="pageload_popup" class="modal" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="popup-heading border-0 loaderTitle">
                    <?= lang('Checkout.please_wait') ?>
                </div>
                <div class="progress my-2">
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="details text-center loaderBody">
                    <p><?= lang('Checkout.initiating_booking_process') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Pop up message -->


<section>
    <div class="container" style="padding-top: 120px;">
    <form id="booking-form">
    
    <div class="row">
        <div class="col-md-9">

        <h1>Booking Request</h1>
            <?php
                if(getenv('app.localtest')){
                    echo "<p class='success'>Local payment test mode ON</p>";
                }
              //  d($currentUserData);

				if(!$tgx_testmode)
					echo "<p class='error'>Warning!!! You are in production mode for Booking</p>";
				else
					echo "<p class='success'>You are in test mode for Booking</p>";
            ?>
			
			<pre>
			<?php 
				//print_r($currentUserData);
				//echo $currentUserData->first_name;
			
			?>
			</pre>
<?php /*             <div class="row mb-3">
                <div class="col-lg-12">
                    <h3>Your Details</h3>
					<?php if($tgx_testmode) { ?>
						<input type="button" class="btn btn-info inner" value="Insert Test Data" onClick="insertTestCustomerData();">
						<?php } ?>
                </div>

                <div class="col">
                    <label for="first_name" class="form-label">First name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?=($currentUserData!==null ? $currentUserData->first_name : '')?>" >
                </div>
                <div class="col">
                    <label for="last_name" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?=($currentUserData!==null ? $currentUserData->last_name : '')?>">
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Email</label>
                    <input type="email" class="form-control" id="user_email" name="user_email" value="<?=($currentUserData!==null ? $currentUserData->email : '')?>">
                </div>
                <div class="col-md-6">
                    <label for="inputPhone4" class="form-label">Phone number</label>
                    <input type="tel" class="form-control" id="inputPhone4" name="inputPhone4" value="<?=($currentUserData!==null ? $currentUserData->phone_number : '')?>">
                </div>
            </div>
            <?php if (config('App')->allowSelfRegistered && $currentUserData===null) : ?>
                <div class="row g-3 pt-2">
                    <div class="mx-1">
                        <input type="checkbox" id="register" name="register" autocomplete="off" value="yes">
                        <label for="register" class="form-label">Register?</label>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-3 mt-4 outer-repeater">
                <div class="col-lg-12">
                    <h3>Guest Details</h3>
                </div>
                <div data-repeater-list="outer-group" class="outer">
                    <div data-repeater-item class="outer">
                        <div data-repeater-list="inner-users" class="inner form-group mb-0 row">
                            <div data-repeater-item class="inner col-lg-12 ms-md-auto mb-3">
                                <p>Guest <span class="guest_num">1</span> Details</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="guest_first_name" class="form-label">First name</label>
                                        <input type="text" class="form-control" name="guest_first_name[]">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="guest_last_name" class="form-label">Last name</label>
                                        <input type="text" class="form-control" name="guest_last_name[]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="guest_email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="guest_email[]">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="guest_phone" class="form-label">Phone number</label>
                                        <input type="tel" class="form-control" name="guest_phone[]">
                                    </div>
                                </div>
                                <input data-repeater-delete type="button" value="Delete"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <div class="col-lg-2 d-flex justify-content-end">
                        <input data-repeater-create type="button" class="btn btn-success inner" value="Add Guest" />
                    </div>
                </div>
            </div> */ ?>

<input type="hidden" name="browser_info" id="browser_info" value="">

<pre>
Company cards:
<?php //print_r($CompanyCards); ?>
<?php $default_card_id = 30;  ?>
<?php foreach ($CompanyCards as $CompanyCard) { ?>
<div style="border: 1px solid #ccc; border-radius: 5px; padding: 5px 10px;">
<input type="radio" name="payment_card_token" value="<?php echo $CompanyCard['spreedly_token']; ?>" <?php if($CompanyCard['card_id'] == $default_card_id) echo 'checked'; ?> /> <?php echo $CompanyCard['nickname']; ?> Ending in: <b><?php echo $CompanyCard['last_four_digit']; ?></b> | Expiry: <b><?php echo $CompanyCard['month']; ?>/<?php echo $CompanyCard['year']; ?></b>
</div>
<?php } ?>
Personal Cards: 
<?php //print_r($PersonalCards); ?>
<?php foreach ($CompanyCards as $CompanyCard) { ?>
<div style="border: 1px solid #ccc; border-radius: 5px; padding: 5px 10px;">
<input type="radio" name="payment_card_token" value="<?php echo $CompanyCard['spreedly_token']; ?>" /> <?php echo $CompanyCard['nickname']; ?> Ending in: <b><?php echo $CompanyCard['last_four_digit']; ?></b> | Expiry: <b><?php echo $CompanyCard['month']; ?>/<?php echo $CompanyCard['year']; ?></b>
</div>
<?php } ?>
</pre>

<?php /*            <div class="row">
                 <input type="hidden" name="card_token" id="order_card_token" value=""> 
                

                // Credit cards list and Adding new Credit Card Form

                //d($currentUserData);
                 if($currentUserData===null): ?>
                <div class="form_container pt-0 resp_bottom_none mt-4">
                    <div class="credit_card">
                        <h3 class="Card Information">Card Information</h3>
						<?php if($payment_mode == 'Test') { ?>
						<input type="button" class="btn btn-info inner" value="Insert Test Data" onClick="insertTestCreditCardData();">
						<?php } ?>
                    </div>
                    <form class="form_field_main_wrapper" id="card_form">
                            <div class="row form_wrapper">
                                <div class="form_columns large_columns">
                                    <label for="card_number"><?php echo lang('Checkout.credit_card_num') ?></label>
                                    <input type="number" class="form-control" id="card_number" name="card_number" maxlength="16">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="card_first_name"><?php echo lang('Checkout.name_on_credit_card') ?></label>
                                    <input type="text" class="form-control" id="card_first_name" name="card_first_name" placeholder="<?php echo lang('Checkout.name_on_credit_card') ?>" maxlength="50">
                                </div>
                                <div class="col">
                                    <label for="card_last_name" class="no_display"><?php echo lang('Checkout.last_name') ?></label>
                                    <input type="text" class="form-control" id="card_last_name" name="card_last_name" placeholder="<?php echo lang('Checkout.last_name') ?>" maxlength="50">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="month"><?php echo lang('Checkout.expiration_date') ?></label>
                                    <div>
                                        <select name="month" id="month">
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <option value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <select name="year" id="year">
                                        <?php for ($i = 0; $i <= 10; $i++) :
                                            $year  = mktime(0, 0, 0, date("m"),   date("d"),   date("Y") + $i);
                                        ?>
                                            <option value="<?= date('Y', $year) ?>"><?= date('Y', $year) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <label for="cvv_code"><?php echo lang('Checkout.cvv_code') ?></label>
                                    <input type="password" class="form-control" placeholder="" id="cvv_code" name="cvv_code" maxlength="4" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="billing_address"><?php echo lang('Checkout.billing_address') ?></label>
                                    <input type="text" class="form-control" placeholder="" id="billing_address" name="billing_address" maxlength="300">
                                </div>
                                <div class="col billing_drop_country">
                                    <label for="firstName"><?php echo lang('Checkout.billing_country') ?></label>
                                    <div>
                                        <select name="card_country" id="card_country">
                                            <?php foreach ($credit_card_countries as $country) : ?>
                                                <option value="<?= $country->alpha2 ?>"><?= $country->name_english ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="card_zip"><?php echo lang('Checkout.billing_zip') ?></label>
                                    <input type="text" class="form-control" id="card_zip" name="card_zip" placeholder="" maxlength="12">
                                </div>
                            </div>
                        </form>
                </div>

                
                <?php
                // end not user
                else:
                ?>
                <div class="form_container pt-0 resp_bottom_none mt-4">
                    <div class="credit_card_list">
                        <h3 class="section_title inner_section_title">Payment Methods</h3>
                        <div class="card_section">
                            <div class="card_list list_customer_card">
                                <?php // in this DIV, will be loaded credit cards list
                                ?>
                            </div>
                            <div class="action_btn_wrapper">
                                <button class="bordered_blck_btn" id="form_add_btn">
                                    Add new card
                                </button>
                            </div>
                        </div>
                        <p class="sub_text error_text block_flex d-none" id="credit_card_list_error_message">
                            <?php echo lang('Checkout.checkout_please_select_credit_card') ?>
                        </p>
                        <div class="bordered_devider"></div>
                    </div>
                    <div id="new_card_add_form" style="display:none;" class="mt-3">
                        <?php // Adding new Credit Card Form
                        ?>
                        <div class="form_field_main_wrapper" id="save_card_form">
                        
                        <input type="hidden" name="customer_id" id="customer_id" value="<?=$currentUserData->id?>">
                            <div class="row form_wrapper">
                                <div class="form_columns large_columns">
                                    <label for="card_number"><?php echo lang('Checkout.credit_card_num') ?></label>
                                    <input type="number" class="form-control" id="card_number" name="card_number" maxlength="16">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="card_first_name"><?php echo lang('Checkout.name_on_credit_card') ?></label>
                                    <input type="text" class="form-control" id="card_first_name" name="card_first_name" placeholder="<?php echo lang('Checkout.name_on_credit_card') ?>" maxlength="50">
                                </div>
                                <div class="col">
                                    <label for="card_last_name" class="no_display"><?php echo lang('Checkout.last_name') ?></label>
                                    <input type="text" class="form-control" id="card_last_name" name="card_last_name" placeholder="<?php echo lang('Checkout.last_name') ?>" maxlength="50">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="month"><?php echo lang('Checkout.expiration_date') ?></label>
                                    <div>
                                        <select name="month" id="month">
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <option value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <select name="year" id="year">
                                        <?php for ($i = 0; $i <= 10; $i++) :
                                            $year  = mktime(0, 0, 0, date("m"),   date("d"),   date("Y") + $i);
                                        ?>
                                            <option value="<?= date('Y', $year) ?>"><?= date('Y', $year) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <label for="cvv_code"><?php echo lang('Checkout.cvv_code') ?></label>
                                    <input type="password" class="form-control" placeholder="" id="cvv_code" name="cvv_code" maxlength="4" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="billing_address"><?php echo lang('Checkout.billing_address') ?></label>
                                    <input type="text" class="form-control" placeholder="" id="billing_address" name="billing_address" maxlength="300">
                                </div>
                                <div class="col billing_drop_country">
                                    <label for="firstName"><?php echo lang('Checkout.billing_country') ?></label>
                                    <div>
                                        <select name="card_country" id="card_country">
                                            <?php foreach ($credit_card_countries as $country) : ?>
                                                <option value="<?= $country->alpha2 ?>"><?= $country->name_english ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="card_zip"><?php echo lang('Checkout.billing_zip') ?></label>
                                    <input type="text" class="form-control" id="card_zip" name="card_zip" placeholder="" maxlength="12">
                                </div>
                            </div>
                            <div class="row cta_row">
                                <button class="blacktext_btnborderd" id="clear_card"><?php echo lang('Checkout.clear') ?></button>
                                <button class="purple_btn with_border button2" type="submit" id="add_credit_card"><?php echo lang('Checkout.save_credit_card_form') ?></button>
                            </div>
                        </div>
                        <?php // (End of) Adding new Credit Card Form
                        ?>
                    </div>
                    <p class="sub_text purple_txt weight_500" id="mall_checkout_pending_order_balance_is">
                        <?php echo lang('Checkout.checkout_pending_order_balance_is') ?> <span class="purple_txt">
                            <?php //echo $this->user_currency_symbol 
                            ?>
                            $<span id="mall_checkout_pending_order_balance"><?php echo price_format($cart_total, 2) ?></span>
                            <?php //echo ' '.$this->user_currency_symbol 
                            ?></span>
                    </p>
                </div>
                <?php // (End of) Credit cards list and Adding new Credit Card Form
                ?>
                <?php
                endif;
                ?>

            </div> */ ?>

            <?php /* <h3 class="mt-3">Special requests</h3>
            <div class="row mb-3">
                <div class="col-12">
                    <textarea name="special_requests" id="special_requests" style="" class="form-control" cols="40" rows="5" placeholder="Please write your requests in English"></textarea>
                </div>
            </div> */ ?>
			
			<div>

				

				

			</div>

            <h3>Cancellation Policy (per room)</h3>
            <div class="row mb-3">
                <div class="col-12">
                    <ul>
                        <li>Hotel cancellations or changes made starting with ** ** 2024 will be subject to $<?=$cart_total?> fee.</li>
                        <li>No-show is subjected to a full fare fee.</li>
                    </ul>
                </div>
                <hr />

                <div class="col-12 d-flex">
                    <div class="mx-1">
                        <input type="checkbox" id="privacy_policy_agreement_checkbox" autocomplete="off" checked="checked">
                    </div>
                    <div>
                        <p class="sub_text error block_flex d-none" id="privacy_policy_error_message">
                            <?php echo lang('Checkout.checkout_please_privacy_policy') ?>
                        </p>
                        By ticking this box, I agree to Stayforless.com's Terms & Conditions and have read and understand the Cancellation Policy
                        ...
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary" id="order_save_button"><?php echo "Complete reservation"; ?></button>
				

				

		   </div>
        </div>

    </div>
	
	<input type="hidden" name="ignore_existing_similar_booking_warning" id="ignore_existing_similar_booking_warning" value="0">
    <input type="hidden" name="checkout_session_id" id="checkout_session_id" value="<?=$checkout_session_id?>">
	<input type="hidden" name="service_api_session_id " id="service_api_session_id" value="<?=$service_api_session_id ?>">
    </form>
    </div>
</section>


<?php /* 
<!-- Modal -->
<div class="modal fade" id="DeleteCardModal" role="dialog" aria-labelledby="DeleteCardModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="DeleteCardModalLabel">Delete card?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-danger" onclick="DeleteCardByToken()">Delete</button>
        <input type="hidden" value="" name="delete_token" id="delete_token" />
        For some reason modal buttons are not working...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div> */ ?>

<?= $this->section('extra-js') ?>

<!--validation -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/js/pages/spreedly.js?v=07.02.23"></script>

<script src="https://core.spreedly.com/iframe/iframe-v1.min.js"></script>
<script>
 
</script>
<!-- form repeater js -->
<script src="<?= base_url() ?>assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

<script>
	<?php if($tgx_testmode) { ?>
	/* function insertTestCustomerData()
	{
		$("#first_name").val('Test');
		$("#last_name").val('Test');
		$("#user_email").val('samba3333@gmail.com');
		$("#inputPhone4").val('1111111111');
	} */
	<?php } ?>
	<?php if($payment_mode == 'Test') { ?>
	/* function insertTestCreditCardData()
	{
		$("#card_number").val('4556761029983886');
		$("#card_first_name").val('Test');
		$("#card_last_name").val('Test');
		$("#month").val('10');
		$("#year").val('2029');
		$("#cvv_code").val('123');
		$("#billing_address").val('Some test Address');
		$("#card_country").val('BE');
		$("#card_zip").val('1111');
	} */
	<?php } ?>
	

    var environmentKey = "<?php $payment_config = config('Payment'); echo $payment_config->enviorment_key; ?>";

    $(document).ready(function() {
        'use strict';

        window.outerRepeater = $('.outer-repeater').repeater({
            defaultValues: {
                'text-input': 'outer-default'
            },
            show: function(Index) {
                console.log('outer show');
                var selfRepeaterItem = this;
                var repeaterItems = $("div[data-repeater-item] > div.inner");
                $(selfRepeaterItem).attr('data-index', repeaterItems.length - 1);
                $(selfRepeaterItem).find('span.guest_num').text(repeaterItems.length);
                
                $(this).slideDown();
            },
            hide: function(deleteElement) {
                console.log('outer delete');
                $(this).slideUp(deleteElement);
            },
            ready: function (Index) {
               // #84c9b1
            },
            repeaters: [{
                selector: '.inner-repeater',
                defaultValues: {
                    'inner-text-input': 'inner-default'
                },
                show: function() {
                    console.log('inner show');
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    console.log('inner delete');
                    $(this).slideUp(deleteElement);
                }
            }]
        });
    });

    $(document).ready(function() {

        /* var input_phone = document.querySelector("#inputPhone4");
        var iti = intlTelInput(input_phone, {
            separateDialCode: true,
            initialCountry: 'us',
            autoPlaceholder: "off",
            formatOnDisplay: false,
            preferredCountries: ["us", "fr", "it"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.min.js"
        }); */

        
        <?php 
            /* if($currentUserData!==null && $currentUserData->phone_number!=''){
                ?>
                iti.setNumber("<?=$currentUserData->phone_number?>");
                <?php
            } */
        ?>

        // loads customers cards to show in Cards List
        <?php /* if($currentUserData!==null): ?>
        getCustomerCard();
        <?php endif; */ ?>

       /*  $('#form_add_btn').click(function(e) {
            e.preventDefault();
            //var lable = $("#form_add_btn").text().trim();
            if ($('#new_card_add_form').is(":visible")) {
                $("#form_add_btn").text("<?php //echo lang('Checkout.Add_new_card'); ?>");
                $("#form_add_btn").removeClass("complete_later");
                $("#new_card_add_form").hide();
            } else {
                $("#form_add_btn").text("<?php //echo lang('Checkout.complete_later'); ?>");
                $("#form_add_btn").addClass("complete_later");
                $("#new_card_add_form").show();
            }
        }); */

        $("#order_save_button").click(function() {
            mall_order_submit();
        });


        /* $(document).on('change', "input[type='radio'][name='card']:checked", function(e) {
            e.preventDefault();
            $("#order_card_token").val($(this).val());
            // if credit card is American Express and user's currency is not USD
            //console.log('curr_selection: ', $('.curr_selection').val());
            // TODO 
            /*if (($(this).attr('data-cardtype') == "American Express") && ('<?php // echo $this->user_currency_code; 
                                                                                ?>' != 'USD')) {
                $('#mall-confirm-currency-change').modal('show');
                $("input[type='radio'][name='card']").prop("checked", false);
            }*/
      /*  }); */


    /*
    This function runs on Order Submit button
    It checks all required fields are filled/checked
    1) Recaptca checked ?
    2) Therms and Mall Policies checkbox checked
    3) Credit card selected in credits cards list, if it needs for Payment
    
    */

        function mall_order_submit_condition_check() {
            var result = true;

            // Privacy Policy checkbox checked
            if (!$("#privacy_policy_agreement_checkbox").is(':checked')) {
                console.log('Privacy Policy checkbox check FAILED');
                $("#privacy_policy_agreement_checkbox").addClass('error').addClass('error_validation'); //error_validation for v >= 2
                $("#privacy_policy_error_message").removeClass('d-none');
                result = false;
            } else {
                $("#privacy_policy_agreement_checkbox").removeClass('error').removeClass('error_validation');
                $("#privacy_policy_error_message").addClass('d-none');
            }
            // ( End of ) Privacy Policy checkbox checked


            // Credit card selected in credits cards list, if it needs for Payment
            /* if ($(".credit_card_list").is(":visible") && $("input[name='card']").is(':checked') == false) {
                console.log('Credit card selection FAILED');
                $(".credit_card_list").addClass('error').addClass('error_validation');
                $("#credit_card_list_error_message").removeClass('d-none');
                result = false;
            } else {
                $(".credit_card_list").removeClass('error').removeClass('error_validation');
                $("#credit_card_list_error_message").addClass('d-none');
            } */
            // ( End of ) Credit card selected


            console.log('mall_order_submit_condition_check: ' + result);

            return result;
        }



        function progressLoader() {
            var current_progress = 0;

            $("#pageload_popup .modal-body .progress .progress-bar").css("width", current_progress + "%").attr("aria-valuenow", current_progress);
            return interval = setInterval(function() {
                current_progress += 20;
                $("#pageload_popup .modal-body .progress .progress-bar")
                    .css("width", current_progress + "%")
                    .attr("aria-valuenow", current_progress);
                if (current_progress >= 100) {
                    clearInterval(interval);
                }
            }, 1500);
        }

        // Order sbmit function
        function mall_order_submit() {

            $("input").parent().removeClass('error'); // clear validation error hightlights for input fields

            // Checks all required fields are filled/checked 
            if (mall_order_submit_condition_check() == false)
                return false;

            var browser_size = '05';
            // The accept header from your server side rendered page. You'll need to inject it into the page. Below is an example.
            var acceptHeader = 'application/json,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
            // The request should include the browser data collected by using `Spreedly.ThreeDS.serialize().
            let browser_info = Spreedly.ThreeDS.serialize(
                browser_size,
                acceptHeader
            );

            var form = $("#booking-form");
            let vals = form.serialize();
            console.log(vals);

            //var phone = iti.getNumber(); 
            //console.log(iti);
            //var card_token = $("input[name='card']:checked").val();
           // if(card_token=="undefined") { card_token = ''; }
            //var special_requests = $("#special_requests").val();
			
			var ignore_existing_similar_booking_warning = $("#ignore_existing_similar_booking_warning").val();
            var checkout_session_id = $("#checkout_session_id").val();
			var service_api_session_id = $("#service_api_session_id").val();
			var payment_card_token = $("[name='payment_card_token']").val();

            //console.log('phone = '+phone);
            
           // vals = vals+'&phone='+phone+'&card_token='+card_token+'&special_requests='+special_requests+'&ignore_existing_similar_booking_warning='+ignore_existing_similar_booking_warning+'&checkout_session_id='+checkout_session_id+'&service_api_session_id='+service_api_session_id;
		vals = vals+'&payment_card_token='+payment_card_token+'&ignore_existing_similar_booking_warning='+ignore_existing_similar_booking_warning+'&checkout_session_id='+checkout_session_id+'&service_api_session_id='+service_api_session_id;

            $.ajax({
                url: '<?= base_url() ?>checkout/process',
                data: (vals),
                method: "POST",
                dataType: "json",
                beforeSend: function() {
                    //$('#loading_message').text(languageData.initiating_booking_process); // loading_message not used for now
                    $("#pageload_popup").modal('show');
                    $("body").addClass("pageLoadpopup");
                    $("body").css("overflow", "hidden !important");
                    interval = progressLoader();
                    $(".error").removeClass('error');
                    $("#order_save_button").addClass('disabled');
                    $("#order_save_button").attr("disabled", true);
                },
                success: function(obj) {
					
					if (obj.status == "approval_required") {
						alert(obj.message); 
						window.location.href = obj.redirect_url;
					}

                    $("#order_save_button").removeClass("disabled");
                    $("#order_save_button").attr("disabled", false);
                    $("#pageload_popup").modal('hide');
                    $("#gateway_iframe").modal('show');
                    $("body").removeClass("pageLoadpopup");
                    $("body").removeAttr("style");
                    clearInterval(interval);

                    var iconUrl = '<?php echo base_url("assets/frontend/images/icon/"); ?>';

                    if (obj.status == "succeeded") {
                        redirectUrl = obj.redirect_url;
                        window.location.href = redirectUrl;
                    } else if (obj.status == "pending") {

                        redirectUrl = obj.redirect_url;

                        var lifecycle = new Spreedly.ThreeDS.Lifecycle({
                            environmentKey: environmentKey,
                            hiddenIframeLocation: 'device-fingerprint',
                            challengeIframeLocation: 'challenge',
                            transactionToken: obj.authorize.transaction.token,
                        })

                        let status3ds = Spreedly.on('3ds:status', statusUpdates);

                        var transactionData = {
                            state: obj.authorize.transaction.state,
                            required_action: obj.authorize.transaction.required_action,
                            device_fingerprint_form: obj.authorize.transaction.device_fingerprint_form,
                            checkout_form: obj.authorize.transaction.checkout_form,
                            checkout_url: obj.authorize.transaction.checkout_url,
                            challenge_form: obj.authorize.transaction.challenge_form,
                            challenge_url: obj.authorize.transaction.challenge_url,
                            redirect_url: redirectUrl,
                        };
                        console.log("transaction data");
                        console.log(transactionData);

                        console.log("Start lifecycle");
                        lifecycle.start(transactionData);

                    } else {

                        if (obj.status == "error") {
							if (obj.error_type == "pending_or_succeed_booking_exists") {
								//alert(obj.message);
								confirmation_result = confirm(obj.message);
								console.log('confirmation_result');
								if(confirmation_result)
								{
									$("input[name='ignore_existing_similar_booking_warning']").val(1);
									//setTimeout('mall_order_submit',100);
									mall_order_submit();
								}								
							}
                            else if (obj.error_type == "validation") {

                                var validation_errors = '';

                                $.each(obj.issues_fields, function(i, value) {
                                    console.log(i + ": " + value);

                                    $("input[name='" + i + "']").parent().addClass('error_input');
                                    $("select[name='" + i + "']").parent().addClass('error_input');
                                    validation_errors = validation_errors + '<p class="validation_error">' + value + '</p>';

                                });
                                $("#validation_errors").html(validation_errors);

                                if (validation_errors)
                                    $("#validation_error_heading").removeClass('d-none');
                                else
                                    $("#validation_error_heading").addClass('d-none');

                                $([document.documentElement, document.body]).animate({
                                    scrollTop: $("#mall_information_section").offset().top
                                }, 2000);
                            } else {
                                toastr.error(obj.message);
                            }
                        } else {
                            toastr.error(obj.message);
                        }

                        $("#gateway_iframe").modal('hide');
                        $("body").removeClass("pageLoadpopup");

                    }
                },
                complete: function() {

                }
            })
        }; // end of mall_order_submit() function

        var statusUpdates = function(event) {
            console.log("event data");
            console.log(event);

            if (typeof(event.context.redirect_url) != "undefined" && event.context.redirect_url !== null) {
                redirectUrl = event.context.redirect_url;
            }

            if (event.action === 'succeeded') {
                // finish your checkout and redirect to success page
                console.log("Payment success after lifecycle");
                window.location.href = redirectUrl;
            } else if (event.action === 'error') {
                // present an error to the user to retry
                console.log("Payment got failed after lifecycle");
                window.location.href = redirectUrl;
            } else if (event.action === 'challenge') {
                $('.loader_inner').hide();
                document.getElementById('challenge-modal').classList.remove('hidden');

            } else if (event.action === 'trigger-completion') {

                console.log("authenticated call to Spreedly to complete the request");

                $.ajax({
                    async: true,
                    url: SITEURL + 'payment/spreedlyCompleteCall',
                    type: 'POST',
                    data: ({
                        purchase_token: event.token
                    })
                }).done(function(completeResponse) {
                    completeResult = JSON.parse(completeResponse);
                    redirectUrl = completeResult.transaction.callback_url;

                    console.log(completeResult);
                    if (completeResult.transaction.state === 'succeeded') {
                        // finish your checkout and redirect to success page
                        console.log("transaction Success: Send it to success page");
                        window.location.href = redirectUrl;
                    }

                    if (completeResult.transaction.state === 'pending') {
                        console.log("In pending");
                        event.finalize(completeResult.transaction);
                    }

                    if (completeResult.transaction.state === 'gateway_processing_failed') {
                        console.log("The transaction failed because the gateway declined the charge for some reason.");
                        window.location.href = redirectUrl;
                    }
                });
            }
        }


        // Close Checkout on page navigation:
        /*window.addEventListener('popstate', function() {
            handler.close();
        });*/
    });




	
	function rejectService()
	{
		let confirmation = confirm("Do you confirm rejection?");
		var reject_message = $("#reject_message").val();
		var service_api_session_id = $("#service_api_session_id").val();
		
		if(confirmation)
		{
			$.ajax({
				url: SITEURL + 'checkout/rejectApproval',
				type: 'POST',
				data: ({
					reject_message: reject_message,
					service_api_session_id: service_api_session_id,
				})
			}).done(function(data) {
				if(data.status == 'rejected')
				{
					alert("This booking was rejected");
					window.location.href = SITEURL;
				}
			});
		}
	}
</script>
<!-- toastr plugin -->
<script src="<?= base_url() ?>assets/libs/toastr/toastr.min.js"></script>
<!-- toastr init -->
<script src="<?= base_url() ?>assets/js/pages/toastr.init.js"></script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>