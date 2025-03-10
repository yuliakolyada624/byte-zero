$(document).ready(function()
{
	/*For Account Section*/
    $("#save_customer_card_form").validate(
    {
        ignore: [], // input type hidden consider
        rules: {

            card_number   : {
                required: true,
                digits: true
            },
            month         : {
                required: true,
                digits: true
            },
            year          : {
                required: true,
                digits: true
            },
            first_name    : {
                required:true,
                noSpace : true,
                maxlength: 20
            },
            last_name    : {
                required :true,
                noSpace : true,
                maxlength: 20
            },
            cvv_code      : {
                required: true,
                digits: true,
                maxlength: 4,
                minlength: 3
            },
            billing_address : {
                required : true,
                noSpace : true
            },
            card_zip : {
                required : true,
                noSpace : true
            },
            card_country : {
                required : true
            }
        },
        messages: {

           card_number    : {
                required   : languageData.card_error_card_number_required,
                digits     : languageData.card_error_card_number_numeric
            },
            month          : languageData.card_error_month_required,
            year           : languageData.card_error_year_required,
            first_name     : {
                required : languageData.card_error_first_name_required,
                maxlength: languageData.name_no_maximum_error_msg
            },
            last_name      : {
                required : languageData.card_error_last_name_required,
                maxlength: languageData.name_no_maximum_error_msg
            },
            cvv_code       : {
                required: languageData.card_error_cvv_number_required,
                digits:languageData.card_error_cvv_number_numeric,
                maxlength  : languageData.card_error_billing_address_maxlength
            },
            billing_address : {
                required : languageData.card_error_billing_address_required
            },
            card_zip : {
                required : languageData.card_error_billing_zip_required
            },
            card_country : {
                required : languageData.card_error_billing_country_required
            }
        },
        errorPlacement: function(error, element)  // error placement 
        {
            if(element.attr("type") == "hidden")  // when input type hidden than error message show parent div 
            {
                error.appendTo( element.parent("div") );            
            } 
            else 
            {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) 
        {
            var formData    = $("#save_customer_card_form").serializeArray();

            /*Adding additioanl parameters*/
            formData.push({ name: 'from_account', value: true });
            formData.push({ name: 'browser_info', value: browser_info });

            $.ajax({

                type        :       "POST",
                url         :       saveUserCardUrl,
                data        :       formData,
                beforeSend  :       function(){

                    $("#save_card").html('<i class="fa fa-refresh fa-spin"></i>'+languageData.save_card_msg+'').attr("disabled",true);
                },
                success     :       function(response)
                {
                    var obj = JSON.parse(response);
                    $("#card_error").html("");
                    var cardType = $("#card_type").val();
                    
                    /*Error handling*/
                    if(obj.success == 1 && obj.card_details.flag != 1)
                    {
                        toastr.success(obj.message);
                        $('#save_customer_card_form')[0].reset();
                        
                        var cardHtml = '';
                        var token = "'"+obj.card_details.spreedly_token+"'";
                        cardHtml += '<tr id="'+obj.card_details.spreedly_token+'">';
                        cardHtml += '<td data-title='+languageData.type+'>'+obj.card_details.card_type+'</td>';
                        cardHtml += '<td>XXXX-XXXX-XXXX-'+obj.card_details.last_four_digit+'</td>';
                        cardHtml += '<td data-title='+languageData.expiration+'>'+obj.card_details.month+'/'+obj.card_details.year+'</td>';
                        cardHtml += '<td data-title='+languageData.name+'>'+obj.card_details.first_name+' '+obj.card_details.last_name+'</td>';
                        cardHtml += '<td><a onclick="deleteCard('+token+')" data-toggle="modal" data-target="#remove_card_modal" href="javascript:void(0)">'+languageData.remove+'</a></td>';
                        cardHtml += '</tr>';
                        
                        $(".no_card").remove();
                        
                        $("#card_list").append(cardHtml);

                        /*refreshing the account section*/
                        $('#append_main_data_travelers').html('');
                    }
                    else if(obj.success==1 && obj.card_details.flag)
                    {
                        /*Check for authorization of card*/
                        if(obj.is_authorize == 1)
                        {
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

                                console.log("transaction data");
                                console.log(transactionData);

                                console.log("Start lifecycle");
                                lifecycle.start(transactionData);
                            }
                        }
                        else
                        {
                            var cardHtml = '';
                            var token = "'"+obj.card_details.spreedly_token+"'";
                            var cardImg = "";

                            switch (obj.card_details.card_type) {
                                case 'Visa':
                                    cardImg = "visa_card.svg";
                                    break;
                                case 'MasterCard':
                                    cardImg = "master_card.png";
                                    break;
                                case 'American Express':
                                    cardImg = "express.png";
                                    break;
                                default:
                                    cardImg = "card.png";
                                    break;
                            }

                            cardHtml += '<li class="new_card_credit" id="'+obj.card_details.spreedly_token+'">';
                            cardHtml += '    <label class="cstm_check">';
                            cardHtml += '        <input type="radio" value="" name="card_checkbox[]" id="check_'+ obj.card_details.card_id +'">';
                            cardHtml += '        <span class="checkmark"></span>';
                            cardHtml += '    </label>';
                            cardHtml += '    <img src="'+SITEURL+'/assets/images/'+cardImg+'" alt="Visa card">';
                            cardHtml += '    <div class="credit_card_ctn">';
                            cardHtml += '        <h6>'+ obj.card_details.card_type.replace("_", " ") +' ending in '+ obj.card_details.last_four_digit +'</h6>';
                            cardHtml += '        <p><span>Expires '+ obj.card_details.month+'/'+obj.card_details.year +'</span><span class="card_name">'+ obj.card_details.first_name+' '+obj.card_details.last_name +'</span></p>';
                            cardHtml += '        <div class="credit_card_action d-flex"><a class="pl-0 pr-1 border-1" href="javascript:void(0);" onclick="editCard('+token+')">'+languageData.edit+'</a><a onclick="deleteCard('+token+')" data-toggle="modal" data-target="#remove_card_modal" class="pl-1 border-0" href="javascript:void(0);">'+languageData.remove+'</a></div>';
                            cardHtml += '    </div>';
                            cardHtml += '</li>';

                            $(".card_detail_list").find("#no_data_found").remove();
                            $(".card_detail_list").removeClass("text-center");
                            $(".card_detail_list ul li").removeClass("new_card_credit");
                            $(".card_detail_list ul li input[type='radio']").prop("checked", "");
                            $(".card_detail_list ul").append(cardHtml);
                            $("#check_"+ obj.card_details.card_id).prop('checked', true);
                            addNewCard();
                            $('#save_customer_card_form')[0].reset();
                            
                            /*refreshing the account section*/
                            $('#append_main_data_travelers').html('');
                        }
                    }
                    else{
                        toastr.error(obj.message);
                    }
                },
                complete    :       function(){
                     $("#save_card").attr("disabled",false).text(languageData.save_credit_card_form);
                }
           });
           
        }
    });

	/*For update card in Account Section*/
	$("#update_customer_card_form").validate(
	{
	    ignore: [], // input type hidden consider
	    rules: {

	        /*card_number   : {
	            required: true,
	            digits: true
	        },*/
	        edit_month         : {
	            required: true,
	            digits: true
	        },
	        edit_year          : {
	            required: true,
	            digits: true
	        },
	        edit_first_name    : {
	            required:true,
	            noSpace : true,
	            maxlength: 20
	        },
	        edit_last_name    : {
	            required:true,
	            noSpace  : true,
	            maxlength: 20
	        },
	        /*cvv_code      : {
	            required: true,
	            digits: true,
	            maxlength: 4
	        },*/
	        edit_billing_address : {
	            required : true,
	            noSpace : true
	        },
	        edit_card_zip : {
	            required : true,
	            noSpace : true
	        },
	        edit_card_country : {
	            required : true
	        }

	    },
	    messages: {

	        /*card_number    : {
	            required       : languageData.card_error_card_number_required,
	            digits         : languageData.card_error_card_number_numeric
	        },*/
	        edit_month          : languageData.card_error_month_required,
	        edit_year           : languageData.card_error_year_required,
	        edit_first_name     : {
	            required :languageData.card_error_first_name_required,
	            maxlength: languageData.name_no_maximum_error_msg
	        },
	        edit_last_name      : {
	            required : languageData.card_error_last_name_required,
	            maxlength: languageData.name_no_maximum_error_msg
	        },
	        /*cvv_code       : {
	            required: languageData.card_error_cvv_number_required,
	            digits:languageData.card_error_cvv_number_numeric,
	            maxlength  : languageData.card_error_billing_address_maxlength
	        },*/
	        edit_billing_address : {
	            required : languageData.card_error_billing_address_required
	        },
	        edit_card_zip : {
	            required : languageData.card_error_billing_zip_required
	        },
	        edit_card_country : {
	            required : languageData.card_error_billing_country_required
	        }
	    },
	    errorPlacement: function(error, element)  // error placement 
	    {
	        if(element.attr("type") == "hidden")  // when input type hidden than error message show parent div 
	        {
	            error.appendTo( element.parent("div") );            
	        } 
	        else 
	        {
	            error.insertAfter(element);
	        }
	    },
	    submitHandler: function(form) {

	       $.ajax({

	            type        :       "POST",
	            url         :       updateCreditCardURL,
	            data        :       $("#update_customer_card_form").serialize(),
	            beforeSend  :       function(){

	                $("#update_card").html('<i class="fa fa-refresh fa-spin"></i>'+ languageData.update_card_msg).attr("disabled",true);
	            },
	            success     :       function(response){

	                var obj = JSON.parse(response);
	                var url = SITEURL + 'account/user/dashboard?p=creditcard';

	                if(obj.success==1)
	                {
	                    $("#update_card").attr("disabled",false);
	                    $("#update_card").text(languageData.update_credit_card);
	                    toastr.success(obj.message);
	                    setTimeout(function(){ window.location.href = url; }, 1000);
	                }
	                else{
	                    toastr.error(obj.message)
	                }
	            },
	            complete    :       function(){
	                
	            }
	       });
	    }
	});
});