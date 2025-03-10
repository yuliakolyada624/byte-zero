<?= $this->extend('Account/Account') ?>
<?= $this->section('account-content') ?>
<div class="account-content__office">
  <h3 class="account-content__main-title account-content__office__title">Create Office</h3>
  
  
  <form class="form js-office-form-info" action="/offices/update" method="POST" data-name="compamy" data-hasdropdown="data-hasdropdown">
    <?= csrf_field() ?>
    <input type="hidden" data-from="info" name="id" id="id" value="<?=(isset($office->id) ? $office->id : "")?>" />
    <input type="hidden" data-from="info" name="company_id" id="company_id" value="<?=(isset($company_id) ? $company_id : "")?>" />
    <div class="form__row">
      <div class="form__col _col-6">
        <div class="form__field">
          <label class="form__field-name" for="name">Office title*</label>
          <input class="required form__field-input js-office-form-info-input"  type="text" 
                  id="office_title" name="office_title" value="<?=(isset($office->office_title) ? $office->office_title : "")?>" data-from="info" />
        </div>
      </div>

          
    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="is_default">Is Default*</label>
            <select class="required form__field-input" id="is_default" name="is_default">
                <option value="1" <?= (isset($office->is_default) && $office->is_default == 1 ? 'selected' : '') ?>>Yes</option>
                <option value="0" <?= (isset($office->is_default) && $office->is_default == 0 ? 'selected' : '') ?>>No</option>
            </select>
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="address_line_1">Address Line 1*</label>
            <input class="required form__field-input" type="text" id="address_line_1" name="address_line_1" value="<?= (isset($office->address_line_1) ? $office->address_line_1 : "") ?>" />
        </div>
    </div>

        
    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="address_line_2">Address Line 2</label>
            <input class="form__field-input" type="text" id="address_line_2" name="address_line_2" value="<?= (isset($office->address_line_2) ? $office->address_line_2 : "") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="city">City*</label>
            <input class="required form__field-input" type="text" id="city" name="city" value="<?= (isset($office->city) ? $office->city : "") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="state_province_region">State / Province / Region*</label>
            <input class="required form__field-input" type="text" id="state_province_region" name="state_province_region" value="<?= (isset($office->state_province_region) ? $office->state_province_region : "") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="zip_postal_code">ZIP / Postal Code*</label>
            <input class="required form__field-input" type="text" id="zip_postal_code" name="zip_postal_code" value="<?= (isset($office->zip_postal_code) ? $office->zip_postal_code : "") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="country">Country*</label>
            <input class="required form__field-input" type="text" id="country" name="country" value="<?= (isset($office->country) ? $office->country : "") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="contact_first_name">Contact First Name*</label>
            <input class="required form__field-input" type="text" id="contact_first_name" name="contact_first_name" value="<?= (isset($office->contact_first_name) ? $office->contact_first_name : "") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="contact_last_name">Contact Last Name*</label>
            <input class="required form__field-input" type="text" id="contact_last_name" name="contact_last_name" value="<?= (isset($office->contact_last_name) ? $office->contact_last_name : "") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="phone_number">Phone Number*</label>
            <input class="required form__field-input" type="text" id="phone_number" name="phone_number" value="<?= (isset($office->phone_number) ? $office->phone_number : "") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="email">Email*</label>
            <input class="required form__field-input" type="text" id="email" name="email" value="<?= (isset($office->email) ? $office->email : "") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="currency">Currency*</label>
            <input class="required form__field-input" type="text" id="currency" name="currency" value="<?= (isset($office->currency) ? $office->currency : "USD") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="pos_location">POS Location</label>
            <input class="form__field-input" type="text" id="pos_location" name="pos_location" value="<?= (isset($office->pos_location) ? $office->pos_location : "") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="time_zone">Time Zone*</label>
            <input class="required form__field-input" type="text" id="time_zone" name="time_zone" value="<?= (isset($office->time_zone) ? $office->time_zone : "") ?>" />
        </div>
    </div>

    <div class="form__col _col-6">
        <div class="form__field">
            <label class="form__field-name" for="time_format">Time Format*</label>
            <input class="required form__field-input" type="text" id="time_format" name="time_format" value="<?= (isset($office->time_format) ? $office->time_format : "") ?>" />
        </div>
    </div>



      
    

      <div class="form__col _col-12">
          <div id="info_validation_responce" class=""></div>
      </div>
      <?php if(isset($office->id)){ ?>
      <div class="form__col _col-12">
          <div class="form__field">
              <a href="#" onclick="deleteOffice(<?=$office->id?>);">Delete branch or office</a>
          </div>
      </div>
      <?php } ?>

      <div class="form__edit-btn__wrap form__col _col-12 js-office-form__btns-wrap">
        <div class="form__edit-btn__text">*Mandatory fields</div>
        <div class="form__edit-btns-wrap js-office-btns-wrap">
          <button class="form__edit-btn btn-secondary js-office-form__btn" type="submit" aris-label="edit office info" data-action="save" data-from="info">Save</button>
        </div>
      </div>
    </div>
  </form>
</div>
<style>
  .errors { color: #DE5465; font-size: 14px; }
  .errors p {margin-bottom: 0px; }
  .savesuccsess { color: #2e7200; font-size: 14px; }
  
</style>

<?= $this->section('extra-js') ?>
 <!-- Sweet Alerts js -->
 <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<!-- Sweet Alert-->
<link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<script>
  function deleteOffice(){

  }

  function deleteOffice(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success mt-2',
                    cancelButtonClass: 'btn btn-danger ms-2 mt-2',
                    buttonsStyling: false,
                }).then(function (result) {
                        $.ajax({
                                type: "post",
                                url: '<?php echo base_url() ?>' + 'offices/delete',
                                data: {
                                    id: id
                                },
                                success: function(r) {
                                    //console.log(r);
                                    if(r.success){
                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: r.msg,
                                            icon: 'success',
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Deleted Error!',
                                            text: r.msg,
                                            icon: 'error',
                                        });
                                    }

                                    setTimeout(function() {
                                        window.location.href='<?php echo base_url() ?>' + 'offices/list/<?=(isset($company_id) ? $company_id : "")?>';
                                    }, 2000);
                                }
                            });
                });
            }
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>