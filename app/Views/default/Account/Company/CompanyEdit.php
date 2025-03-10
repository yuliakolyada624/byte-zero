<?= $this->extend('Account/Account') ?>
<?= $this->section('account-content') ?>
<div class="account-content__company">
  <h3 class="account-content__main-title account-content__company__title">Create Company</h3>
  
  
  <form class="form js-company-form-info" action="/companies/company-create" method="POST" data-name="compamy" data-hasdropdown="data-hasdropdown">
    <?= csrf_field() ?>
    <input type="hidden" data-from="info" name="id" id="id" value="<?=(isset($company->id) ? $company->id : "")?>" />
    <div class="form__row">
      <div class="form__col _col-6">
        <div class="form__field">
          <label class="form__field-name" for="name">Registered Legal Name*</label>
          <input class="required form__field-input js-company-form-info-input"  type="text" 
                  id="registered_legal_name" name="registered_legal_name" value="<?=(isset($company->registered_legal_name) ? $company->registered_legal_name : "")?>" data-from="info" />
        </div>
      </div>
      

      <div class="form__col _col-12">
          <div id="info_validation_responce" class=""></div>
      </div>
      <div class="form__edit-btn__wrap form__col _col-12 js-company-form__btns-wrap">
        <div class="form__edit-btn__text">*Mandatory fields</div>
        <div class="form__edit-btns-wrap js-company-btns-wrap">
          <button class="form__edit-btn btn-secondary js-company-form__btn" type="submit" aris-label="edit company info" data-action="save" data-from="info">Save</button>
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
<script>
  
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>