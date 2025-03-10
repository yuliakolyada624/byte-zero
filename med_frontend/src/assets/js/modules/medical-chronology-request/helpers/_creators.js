export function createDropdownData(wrap) {
  return {
    wrap,
    input: wrap.querySelector(".js-medical-chronology-request-dropdown-input") || null,
    trigger: wrap.querySelector(".js-medical-chronology-request-dropdown-trigger"),
    triggerValueContainer: wrap.querySelector(
      ".js-medical-chronology-request-dropdown-trigger .value",
    ),
    listWrap: wrap.querySelector(".js-medical-chronology-request-dropdown-list-wrap"),
    list: wrap.querySelector(".js-medical-chronology-request-dropdown-list"),
    activeItem: null,
    isValid: false,
    hiddenDropdown: wrap.closest(".js-medical-chronology-request-hidden-dropdown") || null,
  }
}

export function createInputData(input) {
  return {
    input,
    isValidation: input.dataset.isRequired === "true",
    type: input.type,
    value: input.value,
    isValid: false,
  }
}
