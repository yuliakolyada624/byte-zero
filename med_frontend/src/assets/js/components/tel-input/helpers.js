function formInputData(input) {
  const parent = input.closest('.tel-wrap')
  return {
    input, 
    dropdownTrigger: parent.querySelector('.code-section'),
    dropdown: parent.querySelector('.tel-input-dropdown'),
    countriesList: parent.querySelector('.tel-input-dropdown__list'),
    dialCode: parent.querySelector('.dial-code'),
    flag: parent.querySelector('.flag-container'),
    value: '',
    codeValue: '',
    fullPhone: '',
  }
}

export {formInputData}