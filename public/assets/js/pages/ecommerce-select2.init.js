/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Version: 3.0
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: ecommerce select2 Js File
*/

// Select2
$(".select2").select2();

var $eventSelect = $(".selectcompany");

$eventSelect.select2();


$eventSelect.on("select2:select", function (e) {
    var data = e.params.data;
    //console.log(data);
    console.log(data.id);
    console.log(data.text);

    if(data.id>0){
        $("#company_unit_data").removeClass('d-none');
        getCompanyUnits(data.id);
    } else {
        $("#company_unit_data").addClass('d-none');
    }
    
});
