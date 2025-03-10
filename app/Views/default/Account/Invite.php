<?= $this->extend('Account/Account') ?>
<?= $this->section('account-content') ?>
<div class="account-content__profile">
  <h3 class="account-content__main-title account-content__profile__title">Invite</h3>
  <?php // d($user); ?>
  
  <form class="form" action="/account/invite-users" method="POST" data-name="info" data-hasdropdown="data-hasdropdown">
    <?= csrf_field() ?>
    <div class="form__row">
      <div class="form__col _col-6">
        <div class="form__field">
          <label class="form__field-name" for="name">Office</label>
          <select name="office_id">
              <?php 
              foreach ($offices as $office) {
                //dd($office);
                ?>
                <option value="<?=$office->id?>"><?=$office->office_title?></option>
                <?php
              }
           ?>  
          </select>  
        </div>
      </div>
      <div class="form__col _col-6">
        <div class="form__field">
          <label class="form__field-name" for="name">Department <a href="#" id="add_new_departament">+ Add new</a></label>
          <div class="d-none" id="add-new-departament-div">
            <input class="js-profile-form-info-input" type="text" 
              id="new_department" name="new_department" value="" />
            <input type="hidden" data-from="info" name="company_id" id="company_id" value="<?=(isset($company_id) ? $company_id : "")?>" />
            <input type="submit" id="department_save" value="save" />
          </div>
          <select name="department_id">
              <?php 
              foreach ($company_departments as $department) {
                ?>
                <option value="<?=$department->id?>"><?=$department->name?></option>
                <?php
              }
           ?>  
           </select>  
        </div>
      </div>
    </div>
    <div class="form__row">
      <div class="form__col _col-6">
        <div class="form__field">
          <label class="form__field-name" for="name">First Name*</label>
          <input class="required form__field-input js-profile-form-info-input" type="text" 
              id="first_name" name="first_name" value="" data-type="name" data-from="info" />
        </div>
      </div>
      <div class="form__col _col-6">
        <div class="form__field">
          <label class="form__field-name" for="lastname">Last Name*</label>
          <input class="required form__field-input js-profile-form-info-input" type="text" 
            id="last_name" name="last_name" value="" data-type="name" data-from="info" />
        </div>
      </div>
      <div class="form__col _col-6">
        <div class="form__field">
          <label class="form__field-name" for="email">Email*</label>
          <input class="required form__field-input js-profile-form-info-input" type="email" 
                id="email" name="email" value="" data-type="email" data-from="info" />
        </div>
      </div>
      <div class="form__col _col-6">
        <div class="form__field">
          <label class="form__field-name" for="tel">Role*</label>
          <?php 
          $groups = config('AuthGroups')->invite_groups;
          ?>
          <select name="role">
              <?php 
              foreach ($groups as $key=>$group) {
                ?>
                <option value="<?=$key?>"><?=$group['title']?></option>
                <?php
              }
              ?>
          </select>
        </div>
      </div>
    
      
      <div class="form__col _col-12">
          <div id="info_validation_responce" class=""></div>
      </div>
      <div class="form__edit-btn__wrap form__col _col-12 js-profile-form__btns-wrap">
        <div class="form__edit-btn__text">*Mandatory fields</div>
        <div class="form__edit-btns-wrap js-profile-btns-wrap">
          <input type="submit" value="Save" />
        </div>
      </div>
    </div>
  </form>
</div>
<style>
  .errors { color: #DE5465; font-size: 14px; }
  .errors p {margin-bottom: 0px; }
  .savesuccsess { color: #2e7200; font-size: 14px; }
  
  select {
    border: 1px solid #cccccc;
    border-radius: 5px;
    padding: 5px;
    min-height: 48px;
    margin-bottom: 15px;
  }
  
</style>


<?= $this->section('extra-js') ?>
<script>


  $("#add_new_departament").click(function(e) {
    e.preventDefault();

    $("#add-new-departament-div").toggleClass('d-none');
  });



  $("#department_save").click(function(e) {
    console.log('save');

    let new_department = $("#new_department").val();
    let department_description = $("#department_description").val();
    let company_id = $("#company_id").val();

    console.log('new_department = '+new_department);
    console.log(new_department.length);
    if(new_department.length>0){
      $.ajax({
          type: "post",
          url: '<?php echo base_url() ?>' + 'account/save-department',
          data: {
            name: new_department,
            description: department_description,
            company_id: company_id
          },
          dataType: 'json',
          success: function (r) {
            console.log(r.sucsess);
            if(r.sucsess) {
              toastr.success('Saved');
              $("#new_department").val('');
              $("#add-new-departament-div").toggleClass('d-none');
            } else {
              toastr.error('saving error');
            }
          },
          error: function(e){
            //console.log(e);
            //console.log(e.responseJSON.messages);
            if (e.responseJSON) {
                  Object.values(e.responseJSON.messages).forEach(element => {
                      toastr.error(element);
                  });
            } else {
              toastr.error('Saving error');
            }
            
          }
        });
      }


    });
 
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>