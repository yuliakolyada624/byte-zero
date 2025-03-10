/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Form wizard Js File
*/


$(function () {
    

    $("#basic-example").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slide",
        onStepChanging: function (event, currentIndex, newIndex){
            console.log('currentIndex = '+currentIndex);
            var form = $("#vizard-form-"+currentIndex).show();
          
            // Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex)
            {
                return true;
            }
            
            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex)
            {
                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            if(form.valid()){
                // save!
                let vals = form.serialize();
                console.log(vals);
                if(currentIndex==1){
                    vals = $("#unit-departments").find('input').serialize();
                    console.log(vals);
                }

                if(currentIndex==2){
                    vals = $("#unit-roles").find('input').serialize();
                    console.log(vals);
                }

                console.log(vals);
                let bu_id = $("#bu_id").val();
                let company_id = $("#company_id").val();
                vals = vals+'&id='+bu_id+'&company_id='+company_id+'&step='+currentIndex;
                console.log(vals);

                $.ajax({
                    type: "POST",
                    url: update_url,
                    data: (vals),
                    success: function(r) {
                        console.log(r);
                        // console.log(r.success);
                        if(r.success) {
                            console.log(r.bu_id);
                            $("#bu_id").val(r.bu_id);

                            // Load roles for step 4
                            if(newIndex==3){
                                console.log('tpt Load Roles');
                                load_roles_for_tpt(r.bu_id);
                            }

                            // Load Departments and Roles for step 5
                            if(newIndex==4){
                                console.log('Users - Load Departments and Roles');
                                load_departments_roles_for_users(r.bu_id);
                            }

                        } else {
                            console.log(r.errors);
                            alert('error while saving data');
                        }
                    },
                    error: function() {
                        alert('error while saving data');
                    }
                });
            }
            return form.valid();
        },
        
        onFinishing: function (event, currentIndex){
            
            var form = $("#vizard-form-"+currentIndex).show();
            console.log(currentIndex);
            // Needed in some cases if the user went back (clean up)
            if (currentIndex==4)
            {
                // To remove error styles
                form.find(".body:eq(" + currentIndex + ") label.error").remove();
                form.find(".body:eq(" + currentIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            if(form.valid()){
                // save!
                let vals = form.serialize();
                console.log(vals);
                let bu_id = $("#bu_id").val();
                let company_id = $("#company_id").val();
                vals = vals+'&id='+bu_id+'&company_id='+company_id+'&step='+currentIndex;
                console.log(vals);

                $.ajax({
                    type: "POST",
                    url: update_url,
                    data: (vals),
                    success: function(r) {
                        console.log(r);
                        if(r.success) {
                            console.log(r.bu_id);
                            $("#bu_id").val(r.bu_id);

                            Swal.fire(
                                {
                                    title: 'Congratulations!',
                                    text: 'The business unit has been successfully created.',
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#556ee6',
                                    cancelButtonColor: "#f46a6a"
                                }
                            ).then(function() {
                                window.location = "/businessunits/index";
                            });

                        } else {
                            console.log(r.errors);
                            alert('error while saving data');
                        }
                    },
                    error: function() {
                        alert('error while saving data');
                    }
                });
            }
            
            return form.valid();
        },

        });


        function load_roles_for_tpt(bu_id){
            $.ajax({
                type: "GET",
                url: get_unit_roles_url+'/'+bu_id,
                success: function(r) {
                    //console.log(r);
                    if(r.success && r.success==true) {
                        let new_opt = '';
                        let options = JSON.parse(r.roles_options);
                        //console.log(options);
                        $.each(options, function(i, item){
                            //console.log(item);
                            new_opt =new_opt+ '<option value="'+item.id+'" class="dyn">'+item.name+'</option>';
                       });
                       $('.policy_role').find('option.dyn').remove().end().append(new_opt);
                       $('.policy_role').each(function(){
                            
                            let default_policy_role = $(this).data('role_id');
                            //console.log('default_policy_role =' + default_policy_role);
                            
                            if(default_policy_role){ // first load!
                                $(this).val(default_policy_role).change();
                                $(this).attr('disabled', false)
                                // $('policy_role').data('role_id', false);
                            }
                       });

                       
                       

                       // refresh repeater
                       window.outerRepeater = $('.outer-repeater-tpt').repeater({
                            defaultValues: { 'text-input': 'outer-default' },
                            show: function () {
                                console.log('outer show');
                                $(this).slideDown();
                            },
                            hide: function (deleteElement) {
                                console.log('outer delete');
                                console.log(deleteElement);
                                $(this).slideUp(deleteElement);
                            },
                            repeaters: [{
                                selector: '.inner-repeater',
                                defaultValues: { 'inner-text-input': 'inner-default' },
                                show: function () {
                                    console.log('inner show');
                                    $(this).slideDown();
                                },
                                hide: function (deleteElement) {
                                    console.log('inner delete');
                                    console.log(deleteElement);
                                    $(this).slideUp(deleteElement);
                                }
                            }]
                        });

                        
                    } else {
                        console.log(r.errors);
                        alert('error getting roles data');
                    }
                },
                error: function() {
                    alert('error getting roles data');
                }
            });
        }


        function load_departments_roles_for_users(bu_id){
            $.ajax({
                type: "GET",
                url: get_unit_departments_roles_url+'/'+bu_id,
                success: function(r) {
                   // console.log(r);
                    if(r.success && r.success==true) {
                        let new_departments_opt = '';
                        let departments_options = JSON.parse(r.departments_options);
                        //console.log(departments_options);
                        $.each(departments_options, function(i, item){
                            //console.log(item);
                            new_departments_opt =new_departments_opt+ '<option value="'+item.id+'" class="dyn">'+item.name+'</option>';
                       });
                       $('.user_departments').find('option.dyn').remove().end().append(new_departments_opt);

                        let new_role_opt = '';
                        let roles_options = JSON.parse(r.roles_options);
                        //console.log(roles_options);
                        $.each(roles_options, function(i, item){
                            //console.log(item);
                            new_role_opt =new_role_opt+ '<option value="'+item.id+'" class="dyn">'+item.name+'</option>';
                       });
                       $('.user_role').find('option.dyn').remove().end().append(new_role_opt);

                       // user_custom
                       let new_user_custom_opt = '';
                       let user_custom = JSON.parse(r.user_custom);
                       //console.log(user_custom);
                       $.each(user_custom, function(i, item){
                           //console.log(item);
                           new_user_custom_opt =new_user_custom_opt+ '<option value="'+item.value+'" class="dyn">'+item.name+' ('+item.value+')</option>';
                      });
                      $('.user_custom').find('option.dyn').remove().end().append(new_user_custom_opt);

                       // refresh repeater
                       window.outerRepeater = $('.outer-repeater-users').repeater({
                            defaultValues: { 'text-input': 'outer-default' },
                            show: function () {
                                console.log('outer show');
                                $(this).slideDown();
                            },
                            hide: function (deleteElement) {
                                console.log('outer delete');
                                $(this).slideUp(deleteElement);
                            },
                            repeaters: [{
                                selector: '.inner-repeater',
                                defaultValues: { 'inner-text-input': 'inner-default' },
                                show: function () {
                                    console.log('inner show');
                                    $(this).slideDown();
                                },
                                hide: function (deleteElement) {
                                    console.log('inner delete');
                                    $(this).slideUp(deleteElement);
                                }
                            }]
                        });

                        
                    } else {
                        console.log(r.errors);
                        alert('error getting roles data');
                    }
                },
                error: function() {
                    alert('error getting roles data');
                }
            });

        }
});
