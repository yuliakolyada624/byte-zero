/**
 * Description: save customer card
 * @author Suresh Suthar
 * Date : 13 May 2018
 */

// Modified by MOhit
$(document).ready(function(){
    jQuery.validator.addMethod("noSpace", function(value, element, param) { 
    return $.trim(value).length >= param;
    }, languageData.user_error_name_blankspace);

    /*For save card in Generic*/
    $("#booking-form").validate(
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
            card_first_name    : {
                required:true,
                noSpace : true,
                maxlength: 20
            },
            card_last_name    : {
                required:true,
                noSpace  : true,
                maxlength: 20
            },
            cvv_code      : {
                required: true,
                digits: true,
                maxlength: 4
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
                required       : languageData.card_error_card_number_required,
                digits         : languageData.card_error_card_number_numeric
            },
            month          : languageData.card_error_month_required,
            year           : languageData.card_error_year_required,
            card_first_name     : {
                required :languageData.card_error_first_name_required,
                maxlength: languageData.name_no_maximum_error_msg
            },
            card_last_name      : {
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
        submitHandler: function(form) {

           $.ajax({

                type        :       "POST",
                url         :       SITEURL + 'cards/saveUserCard',
                data        :       $("#booking-form").serialize(),
                /*  not used
                beforeSend  :       function(){

                    $("#save_card").html('<i class="fa fa-refresh fa-spin"></i>'+languageData.save_card_msg+'').attr("disabled",true);
                },*/
                success     :       function(response){

                    var obj = JSON.parse(response);
                    //var cardType = $("#card_type").val();
                    if(obj.success==1){
                        console.log(obj.message);
                        toastr.success(obj.message);
                        
                        var cardHtml = '';
                        cardHtml +='<li class="text-left"><label class="cstm_check checkbox_custom">';
                        cardHtml +='<input type="radio" id="card'+obj.card_details.card_id+'" name="card" value="'+obj.card_details.spreedly_token+'" data-cardtype="'+obj.card_details.card_type+'">';
                        cardHtml +='<span class="checkmark"></span>'+obj.card_details.card_type+' '+languageData.ending_in+' '+obj.card_details.last_four_digit;
                        cardHtml +='</label> </li>';
                        
                        $(".list_customer_card:last").append(cardHtml);
                        //$('#save_card_form')[0].reset();
                        $("#new_card_add_form").toggleClass("d-none");
                        $("#form_add_btn").toggleClass("d-none");
                        //$("#form_add_btn").trigger('click');

                        $(".add_new_card").toggleClass("d-none");

                        /*updating user country details*/
                        /* WTF? */
                        /*if(className == "cruises" && methodName == "checkout"){
                            
                        }
                        else if(methodName != 'leCheckout')
                        {
                            getGuestDetails();
                        }*/
                        
                    }
                    else{
                        toastr.error(obj.message)
                    }
                },
                /*complete    :       function(){
                     $("#save_card").attr("disabled",false).text(languageData.save_credit_card_form);
                }*/
           });
        }
    });
    
});

/**
 * Description: get customer card
 * @author Suresh Suthar
 * Date : 13 May 2018
 */
function getCustomerCard(){

    $.ajax({

        type        :       "POST",
        url         :       SITEURL+'cards/getCustomerCard',
        beforeSend  :       function(){

            $(".list_customer_card").html("<li>Fetching card details....</li>");
        },
        success    :       function(response){

            var obj = JSON.parse(response);
            
            if(obj.success==1){
                var cardHtml = '';
                for (var i = 0; i < obj.card_data.length; i++) {
                    
                    cardHtml +='<li class="text-left" id="Card-'+obj.card_data[i].spreedly_token+'"><label class="cstm_check checkbox_custom">';
                    cardHtml +='<input type="radio" id="card'+obj.card_data[i].card_id+'" name="card" value="'+obj.card_data[i].spreedly_token+'" data-cardtype="'+obj.card_data[i].card_type+'">';
                    cardHtml +='<span class="checkmark"></span>'+obj.card_data[i].card_type+' ended '+obj.card_data[i].last_four_digit;
                    cardHtml +='</label> <a class="card_delete" onclick="deleteCard(\''+obj.card_data[i].spreedly_token+'\')" href="#" title="Remove card from list">x</a> </li>';
                }
                $(".list_customer_card").html(cardHtml);
            }
            else{

                $(".list_customer_card").html("<li class='no_card'>No card found</li>");
            }
        },
        complete    :       function(){
            $('.card_detail_loader').addClass('d-none');
            $('.card_detail').removeClass('d-none');
        }
    });
}
//setTimeout(getCustomerCard,1000);


/**
 * Description: get customer card
 * @author Suresh Suthar
 * Date : 13 May 2018
 */
function getCustomerCardMyAccount(){


    $.ajax({

        type        :       "POST",
        url         :       getCustomerCardUrl,
        beforeSend  :       function(){

            $("#card_list").html("<tr> <td colspan='3'>"+languageData.fetching_card_details+"....</td></tr>");
        },
        success    :       function(response){

            var obj = JSON.parse(response);
            if(obj.success==1){

                var cardHtml = '';
                var token ='';
                for (var i = 0; i < obj.card_data.length; i++) {
                    
                    token = "'"+obj.card_data[i].spreedly_token+"'";
                    cardHtml += '<tr id="'+obj.card_data[i].spreedly_token+'">';
                    cardHtml += '<td data-title='+languageData.type+'>'+obj.card_data[i].card_type+'</td>';
                    cardHtml += '<td>'+obj.card_data[i].card_number+'</td>';
                    cardHtml += '<td data-title='+languageData.expiration+'>'+obj.card_data[i].month+'/'+obj.card_data[i].year+'</td>';
                    cardHtml += '<td data-title='+languageData.name+'>'+obj.card_data[i].first_name+' '+obj.card_data[i].last_name+'</td>';
                    cardHtml += '<td><a onclick="deleteCard('+token+')" data-toggle="modal" data-target="#remove_card_modal" href="javascript:void(0)">'+languageData.remove+'</a></td>';
                    cardHtml += '</tr>';
                }

                $("#card_list").html("");
                $("#card_list").html(cardHtml);
            }
            else{

                $("#card_list").html("");
            }
        },
        complete    :       function(){

        }
    });
}


function saveCustomerCard(){   

}

function deleteCard(token)
{
    $("#delete_token").val(token);
    $('#DeleteCardModal').modal('show');
}

function DeleteCardByToken() {
    let token = $("#delete_token").val();
    console.log(token);

    $.ajax({

        type: "POST",
        url: SITEURL + 'cards/deleteCard',
        data: { token: token },
        beforeSend: function () {

        },
        success: function (response) {
            $("#DeleteCardModal").modal('hide');
            var obj = JSON.parse(response);
            if (obj.success == 'true') {
                toastr.success(obj.message);
                $("#Card-" + token).remove();
                //checkCreditCard(); /* to show no card found text in account section*/
            }
            else {
                toastr.error(obj.error);
            }
        },
        complete: function () {
            //$("#delete_credit_card").attr("disabled",false).text(languageData.yes);
        },
        error: function () {
            toastr.error('Error removing card');
        }
    });
}

$('#DeleteCardModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    console.log(button);
    
  })

/*
$(document).on("click","#delete_credit_card",function(){

    var token = $("#token").val();

    $.ajax({

            type        :       "POST",
            url         :       SITEURL+'checkout/deleteCard',
            data        :       {token:token},
            beforeSend  :       function(){

                $("#delete_credit_card").html('<i class="fa fa-refresh fa-spin"></i> '+languageData.deleting_card+'...').attr("disabled",true);
            },
            success     :       function(response){
                $("#remove_card_modal").modal('hide');
                var obj = JSON.parse(response);
                if(obj.success=='true')
                {
                    toastr.success(obj.message);
                    $("#"+token).remove();
                    checkCreditCard(); /* to show no card found text in account section*/
          /*      }
                else
                {
                    toastr.error(obj.error);
                }
            },
            complete    :       function()
            {
                $("#delete_credit_card").attr("disabled",false).text(languageData.yes);
            }
        });
});


function editCard(token)
{
    $.ajax({
        type        :       "POST",
        url         :       editCardDetailURL,
        data        :       {token:token},
        beforeSend  :       function(){
            $(".card_detail_list").toggleClass('d-none');
            $(".card_list_new").find('.loaderDiv').css('display', 'block');
        },
        success     :       function(response){
            $(".card_detail_list").toggleClass('d-none');
            $(".card_list_new").find('.loaderDiv').css('display', 'none');
            var obj = JSON.parse(response);
            if(obj.success)
            {
                $("#token").val(token);
                $("#edit_card_number").val(obj.card_data.mask_number);
                $("#edit_first_name").val(obj.card_data.first_name);
                $("#edit_month").val(obj.card_data.month);
                $("#edit_year").val(obj.card_data.year);
                $("#edit_last_name").val(obj.card_data.last_name);
                $("#edit_billing_address").val(obj.card_data.billing_address);
                $("#edit_card_country").val(obj.card_data.billing_country);
                $("#edit_card_zip").val(obj.card_data.postal_code);
                $("#edit_cvv_code").val('XXX');

                $("#edit_card_number").attr("disabled", true);
                $("#edit_cvv_code").attr("disabled", true);
                //$("#edit_month").attr("disabled", true);
                //$("#edit_year").attr("disabled", true);
                
                updateCard();
            }
            else
            {
                toastr.error(obj.error);
            }
        },
        complete    :       function()
        {
            
        }
    });
}*/
