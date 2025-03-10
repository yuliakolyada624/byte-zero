<!-- Payment Modal -->
<div class="modal fade payment-method" id="paymentMethodModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="staticBackdropLabel">Payment method missing!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Enter payment information below to proceed.</p>
                <form method="POST">
                    <div class="card p-3 bg-main-light border-0 mb-4 rounded-3">
                        <div class="d-flex align-items-center justify-content-between">

                            <div class="form-field js-field add-payment-method-modal__radio-group is-required"
                                data-type="radio-group">
                                <fieldset class="radio-group">
                                    <legend class="radio-group__title">

                                    </legend>
                                    <div class="radio-group__list js-radio-group">
                                        <label class="radio-group__item">
                                            <span class="radio">
                                                <input class="radio__input js-radio-input" type="radio"
                                                    name="type_of_credit_card" value="company-card" />
                                                <span class="radio__custom"></span>
                                            </span>
                                            <span class='radio-group__item-name'>Corporate credit card</span>
                                        </label>
                                        <label class="radio-group__item">
                                            <span class="radio">
                                                <input class="radio__input js-radio-input" type="radio"
                                                    name="type_of_credit_card" value="personal-card" />
                                                <span class="radio__custom"></span>
                                            </span>
                                            <span class='radio-group__item-name'>Personal credit card</span>
                                        </label>
                                    </div>
                                </fieldset>
                                <span class="form-field__error js-field-error"></span>
                            </div>
                            <p>We accept
                                <picture class="input-card-type__image">
                                    <source srcset="/assets/themes/default/img/content/payment-systems/visa.webp" type="image/webp"
                                        class="input-card-type__img " />
                                    <img src="/assets/themes/default/img/content/payment-systems/visa.png" alt="img"
                                        class="input-card-type__img " width="28" height="16" />
                                </picture>


                                <picture class="input-card-type__image">
                                    <source srcset="/assets/themes/default/img/content/payment-systems/mastercard.webp" type="image/webp"
                                        class="input-card-type__img " />
                                    <img src="/assets/themes/default/img/content/payment-systems/mastercard.png" alt="img"
                                        class="input-card-type__img " width="28" height="16" />
                                </picture>


                                <picture class="input-card-type__image">
                                    <source srcset="/assets/themes/default/img/content/payment-systems/american-express.webp"
                                        type="image/webp" class="input-card-type__img " />
                                    <img src="/assets/themes/default/img/content/payment-systems/american-express.png" alt="img"
                                        class="input-card-type__img " width="28" height="16" />
                                </picture>

                            </p>
                        </div>
                        <hr>
                        <div class="form-group__fields row">




                        <form>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="cardNumber" class="form-label">Credit Card Number</label>
                                    <input type="text" class="form-control" id="cardNumber" placeholder="4518 1223 6812 3241">
                                </div>
                                <div class="col-6">
                                    <label for="cardType" class="form-label">Credit Card Type</label>
                                    <select class="form-select" id="cardType">
                                        <option selected>Visa</option>
                                        <option value="1">MasterCard</option>
                                        <option value="2">American Express</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="firstName" class="form-label">Name On Credit Card</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="Adrian">
                                </div>
                                <div class="col-6">
                                    <label for="lastName" class="form-label">Surname</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Medina">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nickname" class="form-label">Nickname (Optional)</label>
                                <input type="text" class="form-control" id="nickname" placeholder="Example: Personal Visa">
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="expirationDate" class="form-label">Expiration Date</label>
                                    <div class="d-flex">
                                        <select class="form-select me-2" id="expirationMonth">
                                            <option selected>09</option>
                                            <option value="1">01</option>
                                            <option value="2">02</option>
                                            <!-- Additional months here -->
                                        </select>
                                        <select class="form-select" id="expirationYear">
                                            <option selected>2026</option>
                                            <option value="1">2024</option>
                                            <option value="2">2025</option>
                                            <!-- Additional years here -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="securityCode" class="form-label">Security Code</label>
                                    <input type="text" class="form-control" id="securityCode" placeholder="CVV/CVC">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="billingAddress" class="form-label">Billing Address</label>
                                    <input type="text" class="form-control" id="billingAddress">
                                </div>
                                <div class="col-3">
                                    <label for="billingCountry" class="form-label">Billing Country</label>
                                    <select class="form-select" id="billingCountry">
                                        <option selected>Select</option>
                                        <option value="1">USA</option>
                                        <option value="2">Canada</option>
                                        <!-- Additional countries here -->
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="billingZip" class="form-label">Billing ZIP/Postal Code</label>
                                    <input type="text" class="form-control" id="billingZip">
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="authorize">
                                <label class="form-check-label" for="authorize">As the primary card owner, I authorize
                                    Med-Test.AI to charge this card for future orders.</label>
                            </div>
                        </form>



                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-link">Reset Fields</button>
                <button type="submit" class="btn btn-primary">Save and Continue</button>
            </div>
        </div>
    </div>
</div>
